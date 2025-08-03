<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;
use CodeIgniter\API\ResponseTrait;

class MentalBot extends BaseController
{
    use ResponseTrait;

    /**
     * Displays the main chatbot interface.
     */
    public function index()
    {
        $data = [
            'title' => 'Mental Health Bot'
        ];
        
        return view('mentalbot/index', $data);
    }

    /**
     * API endpoint to get an answer from the chatbot.
     */
    public function ask()
    {
        // 1. Validasi Request (Sama seperti sebelumnya)
        if (!$this->request->isAJAX()) {
            return $this->fail('Invalid request type. Only AJAX requests are allowed.', 405);
        }

        $rules = ['question' => 'required|string|min_length[3]'];
        $errors = [
            'question' => [
                'required' => 'Pertanyaan tidak boleh kosong.',
                'min_length' => 'Pertanyaan minimal harus 3 karakter.'
            ]
        ];

        if (!$this->validate($rules, $errors)) {
            $error = $this->validator->getErrors()['question'] ?? 'Terjadi kesalahan validasi.';
            return $this->fail($error, 400);
        }

        // 2. Ambil API Key dari environment file
        $apiKey = getenv('GROQ_API_KEY');
        if (empty($apiKey)) {
            log_message('error', 'GROQ_API_KEY is not set in the .env file.');
            return $this->failServerError('Konfigurasi server tidak lengkap. Harap hubungi administrator.');
        }

        // 3. Persiapan Panggilan ke Groq API
        $question = $this->request->getVar('question');
        $client = Services::curlrequest();

        // System prompt untuk memberikan kepribadian dan batasan pada bot
        $systemPrompt = "Anda adalah Julie, asisten kesehatan mental dari aplikasi MentalCare. Tanggapi selalu dalam Bahasa Indonesia.\n\n**ATURAN PALING PENTING: FOKUS UTAMA ANDA**\n- Misi utama Anda adalah **hanya** membahas topik yang berkaitan langsung dengan **kesehatan mental, psikologi, dan dukungan emosional**.\n- **JANGAN PERNAH** menjawab pertanyaan tentang topik lain, bahkan jika Anda mengetahuinya. Ini termasuk tapi tidak terbatas pada: nama tempat (seperti sekolah atau kota), tokoh publik, berita, resep, matematika, sejarah, atau topik umum lainnya.\n- Jika pengguna bertanya tentang topik di luar fokus Anda, Anda **WAJIB** menolak dengan sopan. Gunakan respons ini: 'Maaf, saya adalah asisten kesehatan mental dan fokus saya hanya pada topik tersebut. Saya tidak memiliki informasi mengenainya. Apakah ada pertanyaan lain seputar kesehatan mental yang bisa saya bantu?'\n\n**Peran & Kemampuan Anda (Dalam Konteks Kesehatan Mental):**\n- Anda ramah, empatik, dan suportif.\n- Tugas Anda adalah mendengarkan, memberikan dukungan emosional, dan memberikan informasi umum yang bermanfaat.\n\n**Batasan Penting Lainnya:**\n- Anda BUKAN seorang profesional medis. Jangan pernah memberikan diagnosis atau resep.\n- Jika pengguna menunjukkan tanda-tanda krisis, sarankan dengan lembut agar mereka berbicara dengan profesional.\n\n**Aturan Pemformatan:**\n- Jaga agar jawaban tetap ringkas dan mudah dipahami.\n- Gunakan format poin-poin (bullet atau nomor) untuk penjelasan rinci.";

        try {
            // 4. Kirim Request ke Groq API
            $response = $client->post('https://api.groq.com/openai/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'model'    => 'llama3-8b-8192', // Model yang cepat dan mumpuni
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $question]
                    ],
                    'temperature' => 0.7, // Sedikit kreatif tapi tetap fokus
                    'max_tokens'  => 1024,
                ],
                'timeout' => 30, // Timeout 30 detik
            ]);

            // 5. Proses Respons dari API
            if ($response->getStatusCode() === 200) {
                $body = json_decode($response->getBody(), true);
                // Pastikan path ke jawaban ada dan tidak kosong
                if (isset($body['choices'][0]['message']['content'])) {
                    $answer = $body['choices'][0]['message']['content'];

                    // --- Logika Pemformatan Teks ke HTML ---
                    // 1. Ubah format tebal markdown (**teks**) menjadi <strong>
                    $answer = preg_replace('/\\*\\*(.*?)\\*\\*/', '<strong>$1</strong>', $answer);

                    // 2. Ubah pemisah paragraf (dua baris baru) menjadi satu tag <br> untuk baris baru.
                    $answer = str_replace("\n\n", "<br>", $answer);

                    // 3. Ubah poin-poin (diawali dengan • atau *) menjadi daftar yang terstruktur.
                    $answer = str_replace('• ', '<br>• ', $answer);
                    $answer = str_replace('* ', '<br>* ', $answer);

                    return $this->response->setJSON(['answer' => $answer]);
                } else {
                    log_message('error', 'Groq API response format is invalid: ' . $response->getBody());
                    return $this->failServerError('Gagal memproses jawaban dari AI.');
                }
            } else {
                // Log error dari API jika ada
                log_message('error', 'Groq API request failed with status ' . $response->getStatusCode() . ': ' . $response->getBody());
                return $this->fail('Gagal terhubung ke layanan AI. Status: ' . $response->getReason(), $response->getStatusCode());
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception during Groq API call: ' . $e->getMessage());
            return $this->failServerError('Terjadi kesalahan internal saat menghubungi layanan AI.');
        }
    }
}
