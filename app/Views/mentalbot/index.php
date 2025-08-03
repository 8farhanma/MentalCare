<?= $this->extend('layout/homepage'); ?>

<?= $this->section('contentHome'); ?>

<style>
    body {
        background-color: #f8f9fa; /* Lighter background for the whole page */
        font-family: 'Poppins', sans-serif;
    }
    .chat-container {
        max-width: 800px;
        margin: auto;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border-radius: 15px;
        overflow: hidden;
        background-color: #fff;
        display: flex;
        flex-direction: column;
        height: calc(100vh - 120px); /* Adjust height to be more responsive */
    }
    .chat-header {
        background-color: #334756 ;
        color: white;
        padding: 15px;
        text-align: center;
        font-size: 1.2rem;
        font-weight: 600;
        border-bottom: 1px solid #ddd;
    }
    .chat-box {
        flex-grow: 1;
        overflow-y: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        background-color: #fdfdfd;
    }
    .message {
        display: flex;
        flex-direction: column;
        max-width: 85%;
    }
    .message-content {
        padding: 12px 18px;
        border-radius: 20px;
        line-height: 1.6;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .user-message {
        align-self: flex-end;
        align-items: flex-end;
    }
    .user-message .message-content {
        background: linear-gradient(45deg, #334756, #476072);
        color: white;
        border-bottom-right-radius: 5px;
    }
    .bot-message {
        align-self: flex-start;
        align-items: flex-start;
    }
    .bot-message .message-content {
        background-color: #f1f0f0;
        color: #333;
        text-align: justify;
        border-bottom-left-radius: 5px;
    }
    .typing-dots span {
        animation: blink 1.4s infinite both;
        font-size: 1.5rem;
        font-weight: bold;
    }
    .typing-dots span:nth-child(2) {
        animation-delay: 0.2s;
    }
    .typing-dots span:nth-child(3) {
        animation-delay: 0.4s;
    }
    @keyframes blink {
        0% { opacity: 0.2; }
        20% { opacity: 1; }
        100% { opacity: 0.2; }
    }
    .chat-input {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        border-top: 1px solid #e0e0e0;
        background-color: #fff;
    }
    .chat-input input {
        flex-grow: 1;
        border: none;
        border-radius: 25px;
        padding: 12px 20px;
        margin-right: 10px;
        background-color: #f1f1f1;
        transition: box-shadow 0.3s ease;
    }
    .chat-input input:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(213, 96, 98, 0.4);
    }
    .chat-input button {
        background-color: #334756 ;
        border: none;
        color: white;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .chat-input button:hover {
        transform: scale(1.1);
    }

    .recommendation-container {
        padding: 10px 15px;
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        border-top: 1px solid #e0e0e0;
        background-color: #f8f9fa;
        justify-content: center;
    }
    .recommendation-chip {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 20px;
        padding: 8px 15px;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        color: #555;
        font-weight: 500;
    }
    .recommendation-chip:hover {
        background-color: #334756;
        color: #fff;
        border-color: #334756;
        transform: translateY(-2px);
    }
</style>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">
        <h5 class="logo me-auto" style="font-size: 20px;">
            <img src="<?= base_url('img/logo.png') ?>" class="mb-1" style="height: 28px; width: 28px;" alt="">
            <a href="#home"><span class="mental-brand" style="color: #D56062">Mental</span><span class="care-brand" style="color: #A9A9A9">Care</span> </a>
        </h5>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link" href="<?= site_url('user/cek_diagnosis') ?>">Cek Diagnosis</a></li>
                <li><a class="nav-link active" href="#">MentalBot</a></li>
                                <li><a class="nav-link scrollto" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</header>
<!-- End Header -->

<div class="container my-4" style="margin-top: 80px !important;">
    <div class="chat-container">
        <div class="chat-header">
            <i class="fas fa-robot"></i> MentalBot - Asisten Kesehatan Mental Anda
        </div>
        <div class="chat-box" id="chat-box">
            <div class="chat-message bot-message">
                Halo! Saya MentalBot. Ada yang bisa saya bantu terkait kesehatan mental Anda? Silakan ketik pertanyaan Anda di bawah.
            </div>
        </div>
        <div class="recommendation-container">
            <button class="recommendation-chip" data-question="Apa yang dimaksud dengan penyakit mental?">Apa yang dimaksud dengan penyakit mental?</button>
            <button class="recommendation-chip" data-question="Apa itu depresi dan bagaimana cara mengenalinya?">Apa itu depresi dan bagaimana cara mengenalinya?</button>
            <button class="recommendation-chip" data-question="Apa penyebab utama seseorang mengalami depresi?">Apa penyebab utama seseorang mengalami depresi?</button>
        </div>
        <form class="chat-input" id="chat-form">
            <input type="text" id="user-input" class="form-control" placeholder="Ketik pertanyaan Anda atau pilih di atas" autocomplete="off">
            <button type="submit"><i class="fas fa-paper-plane"></i></button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const userInput = document.getElementById('user-input');
        const submitButton = chatForm.querySelector('button');
        const buttonIcon = submitButton.querySelector('i');
        const recommendationChips = document.querySelectorAll('.recommendation-chip');

        let isGenerating = false;
        let typewriterInterval;

        recommendationChips.forEach(chip => {
            chip.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent form submission
                const question = this.getAttribute('data-question');
                userInput.value = question;
                userInput.focus();
            });
        });

        function appendMessage(text, className, isUser = false) {
            const messageElement = document.createElement('div');
            messageElement.classList.add('chat-message', className);

            if (isUser) {
                const contentElement = document.createElement('div');
                contentElement.classList.add('message-content');
                contentElement.textContent = text;
                messageElement.appendChild(contentElement);
            } else {
                messageElement.innerHTML = text; // For bot messages which might contain HTML (typing indicator)
            }
            
            chatBox.appendChild(messageElement);
            chatBox.scrollTop = chatBox.scrollHeight;
            return messageElement;
        }

        function typeWriterEffect(element, text) {
            let i = 0;
            element.innerHTML = '';
            isGenerating = true;
            setButtonState('stop');

            typewriterInterval = setInterval(() => {
                if (i >= text.length) {
                    stopGeneration();
                    return;
                }

                let char = text.charAt(i);
                if (char === '<') {
                    let endIndex = text.indexOf('>', i);
                    if (endIndex !== -1) {
                        // It's an HTML tag, append it all at once
                        element.innerHTML += text.substring(i, endIndex + 1);
                        i = endIndex + 1;
                    } else {
                        // It's a stray '<', treat as normal character
                        element.innerHTML += char;
                        i++;
                    }
                } else {
                    // Normal character
                    element.innerHTML += char;
                    i++;
                }
                chatBox.scrollTop = chatBox.scrollHeight;
            }, 30);
        }

        function stopGeneration() {
            clearInterval(typewriterInterval);
            isGenerating = false;
            setButtonState('send');
        }

        function setButtonState(state) {
            if (state === 'stop') {
                buttonIcon.classList.remove('fa-paper-plane');
                buttonIcon.classList.add('fa-stop');
                submitButton.style.backgroundColor = '#D56062'; // Stop color
            } else {
                buttonIcon.classList.remove('fa-stop');
                buttonIcon.classList.add('fa-paper-plane');
                submitButton.style.backgroundColor = '#334756'; // Send color
            }
        }

        chatForm.addEventListener('submit', function (e) {
            e.preventDefault();

            if (isGenerating) {
                stopGeneration();
                return;
            }

            
            const message = userInput.value.trim();
            if (message === '') {
                userInput.placeholder = 'Silakan ketik pesan Anda...';
                userInput.focus();
                return;
            }

            const question = userInput.value.trim();
            if (question === '') return;

            appendMessage(question, 'user-message', true);
            userInput.value = '';
            
            const typingIndicator = appendMessage('<span class="typing-dots"><span>.</span><span>.</span><span>.</span></span>', 'bot-message');

            isGenerating = true;
            setButtonState('stop');

            fetch('<?= site_url('mentalbot/ask') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
                },
                body: JSON.stringify({ question: question })
            })
            .then(response => response.json())
            .then(data => {
                chatBox.removeChild(typingIndicator);
                const botMessageElement = appendMessage('', 'bot-message');
                const contentElement = document.createElement('div');
                contentElement.classList.add('message-content');
                botMessageElement.appendChild(contentElement);
                console.log('Raw response from AI:', data.answer); // Debugging line
                typeWriterEffect(contentElement, data.answer);
            })
            .catch(error => {
                console.error('Error:', error);
                chatBox.removeChild(typingIndicator);
                const errorElement = appendMessage('', 'bot-message');
                errorElement.innerHTML = '<div class="message-content">Maaf, terjadi kesalahan. Silakan coba lagi.</div>';
                stopGeneration();
            });
        });
    });
</script>

<!-- Modal Konfirmasi Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin keluar dari sesi ini?</p>
                <p class="text-muted small">Anda akan diarahkan kembali ke halaman login.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="<?= base_url('logout') ?>" class="btn btn-danger">Ya, Logout</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
