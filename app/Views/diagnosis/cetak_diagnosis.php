<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Diagnosis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 8px;
            border: 1px solid #000;
            text-align: center;
        }
        table th {
            background-color: #f0f0f0;
        }
        caption {
            font-size: 12px;
            color: red;
            text-align: left;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <?php date_default_timezone_set('Asia/Jakarta'); ?>
    <h1 align="center">Laporan Data Diagnosis</h1>
    <h5>Tanggal Diunduh: <?= date('d-m-Y H:i:s') ?></h5>
    
    <table>
        <thead>
            <tr>
                <th colspan="4">Biodata</th>
            </tr>
            <tr>
                <th>Nama</th>
                <th>Pekerjaan</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Diagnosis</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($laporanDiagnosis as $row): ?>
                <tr>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['pekerjaan'] ?></td>
                    <td><?= $row['jk'] ?></td>
                    <td><?= date('d-m-Y', strtotime($row['tgl_diagnosis'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <br>
    <table>
        <thead>
            <tr>
                <th colspan="2">Jawaban Anda</th>
            </tr>
            <tr>
                <th>Pertanyaan</th>
                <th>Jawaban</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($laporanDiagnosis as $row): ?>
                <tr>
                    <td>Berapa rentang usia Anda?</td>
                    <td><?= $row['p_1'] ?></td>
                </tr>
                <tr>
                    <td>Apakah Anda sedang menjalani pengobatan untuk kondisi medis lain saat ini?</td>
                    <td><?= $row['p_2'] ?></td>
                </tr>
                <tr>
                    <td>Apakah ada masalah berikut yang menggambarkan Anda sekarang?</td>
                    <td><?= $row['p_3'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <br>
    <table>
        <thead>
            <tr>
                <th colspan="7">Gejala Yang Dipilih</th>
            </tr>
            <tr>
                <th>No</th>
                <th>Kode Gejala</th>
                <th>Nama Gejala</th>
                <th>Kode Penyakit</th>
                <th>Nama Penyakit</th>
                <th>Tingkat Kepercayaan</th>
                <th>CF User</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($laporanGejala as $key => $row): ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $row['kode_gejala'] ?></td>
                    <td><?= $row['nama_gejala'] ?></td>
                    <td><?= $row['kode_penyakit'] ?></td>
                    <td><?= $row['nama_penyakit'] ?></td>
                    <td><?= $row['nama_nilai'] ?></td>
                    <td><?= $row['cf'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php foreach ($laporanDiagnosis as $row): ?>
        <caption>* Dari semua gejala yang Anda pilih, <strong><?= $row['nama_penyakit'] ?></strong> memiliki tingkat presentase tertinggi.</caption>
    <?php endforeach; ?>
    
    <br>
    <table>
        <thead>
            <tr>
                <th colspan="4">Tingkat Depresi Yang Dialami</th>
            </tr>
            <tr>
                <th>Kode</th>
                <th>Nama Penyakit</th>
                <th>CF Akhir</th>
                <th>Tingkat Presentase</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($laporanDiagnosis as $row): ?>
                <tr>
                    <td><?= $row['kode_penyakit'] ?></td>
                    <td><?= $row['nama_penyakit'] ?></td>
                    <td><?= $row['cf_akhir'] ?></td>
                    <td><?= $row['presentase'] ?>%</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <br>
    <table>
        <thead>
            <tr>
                <th colspan="2">Solusi Penanganan</th>
            </tr>
            <tr>
                <th>Deskripsi Penyakit</th>
                <th>Solusi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($laporanDiagnosis as $row): ?>
                <tr>
                    <td><?= $row['deskripsi_penyakit'] ?></td>
                    <td><?= $row['solusi_penyakit'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <br>
    <footer style="font-size: 10px; color: red; text-align: left;">
        <i>MentalCare | Sistem pakar ini membantu diagnosis depresi, tetapi tidak dapat dijadikan acuan mutlak. Konsultasi dengan psikolog sangat disarankan untuk data yang lebih akurat.</i>
    </footer>
</body>
</html>