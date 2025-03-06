<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex justify-center items-center min-h-screen py-12">
    <div id="slideshow1" class="slideshow-background"></div>
    <div id="slideshow2" class="slideshow-background"></div>

<div class="w-full max-w-md bg-white shadow-lg rounded-lg p-4">
    <h1 class="text-xl font-semibold text-gray-800 text-center mb-4">Chatbot</h1>

    <!-- Chatbox -->
    <div id="chat-box" class="h-96 overflow-y-auto border rounded-lg p-3 bg-gray-50 mb-4" aria-live="polite">
        <p class="text-gray-400 text-sm text-center">Typ hier je vraag...</p>
    </div>

    <!-- Form to send prompt to the API -->
    <form id="chat-form" class="flex items-center gap-2">
        @csrf
        <input type="text" name="prompt" class="flex-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type hier" id="prompt" required>
        
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
            Verstuur
        </button>
    </form>

    <p class="text-center text-gray-500 text-sm mt-4">
        Made With ❤️ By <a href="https://github.com/ThomasTadesse" class="text-blue-500 hover:underline">T. Tadesse</a>
    </p>
</div>

<a href="{{ url('/') }}" class="fixed bottom-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition">
    Home
</a>

<script>
    const images = [
    // Places (each place only once)
    'img/Bali.jpg',
    'img/Maldives.png',
    'img/New_York.jpg',
    'img/Paris.png',
    'img/Rome.jpg',
    'img/Tokyo.png',

    // Planes
    'img/jumbo-jet-flying-sky.jpg',
    'img/plane-flying-with-clouds-background.jpg',
    'img/plane-is-flying-blue-sky.jpg',
    'img/plane-passing-by-suncloudy-day.jpg',
    'img/place-flying-sunset-sky.jpg',
    'img/bottom-view-plane-sky.jpg',
    'img/flying-commercial-airplane-taking-off-sunset.jpg',
    'img/full-frame-shot-cloudscape-with-plane-flying.jpg',
    'img/illustration-flying-airplane.jpg'
];
    
    let currentImageIndex = 0;
    let activeSlideshow = 1;
    
    function updateBackground() {
        const slideshow1 = document.getElementById('slideshow1');
        const slideshow2 = document.getElementById('slideshow2');
        
        const currentSlideshow = activeSlideshow === 1 ? slideshow1 : slideshow2;
        const nextSlideshow = activeSlideshow === 1 ? slideshow2 : slideshow1;
        
        nextSlideshow.style.backgroundImage = `url('${images[currentImageIndex]}')`;
        nextSlideshow.style.opacity = '1';
        currentSlideshow.style.opacity = '0';
        
        activeSlideshow = activeSlideshow === 1 ? 2 : 1;
        currentImageIndex = (currentImageIndex + 1) % images.length;
    }
    
    // Initial background
    document.getElementById('slideshow1').style.backgroundImage = `url('${images[0]}')`;
    document.getElementById('slideshow1').style.opacity = '1';
    currentImageIndex = 1;
    
    // Change background every 7 seconds (giving more time for the transition)
    setInterval(updateBackground, 7000);

    const chatBox = document.getElementById('chat-box');
    const promptInput = document.getElementById('prompt');
    const chatForm = document.getElementById('chat-form');

    // ✅ Automatische taal detectie
    const browserLang = navigator.language || navigator.userLanguage;
    const language = browserLang.startsWith('nl') ? 'nl' : 'en';

    function addMessage(role, text) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('p-2', 'rounded-lg', 'my-1', 'max-w-xs');

        if (role === 'user') {
            messageDiv.classList.add('bg-blue-500', 'text-white', 'ml-auto', 'self-end');
        } else {
            messageDiv.classList.add('bg-gray-200', 'text-gray-800', 'self-start');
        }

        messageDiv.textContent = text;
        chatBox.appendChild(messageDiv);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    chatForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const message = promptInput.value.trim();
        if (!message) return;

        addMessage('user', message);
        promptInput.value = '';

        // ✅ Toon een "denkt na..." bericht
        const loadingMessage = document.createElement('p');
        loadingMessage.textContent = 'Even nadenken...';
        loadingMessage.classList.add('text-gray-400', 'text-sm', 'italic');
        chatBox.appendChild(loadingMessage);
        chatBox.scrollTop = chatBox.scrollHeight;

        fetch("{{ route('huggingface.generate') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ 
                prompt: message,
                language: language // ✅ Stuur automatisch de juiste taal mee
            })
        })
        .then(response => response.json())
        .then(data => {
            chatBox.removeChild(loadingMessage);
            addMessage('bot', data.response || 'Geen reactie van de AI');
        })
        .catch(error => {
            console.error('Error:', error);
            chatBox.removeChild(loadingMessage);
            addMessage('bot', 'Oeps! Er ging iets mis.');
        });
    });
</script>
</body>
<style>
    .slideshow-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        background-size: cover;
        background-position: center;
        opacity: 0;
        transition: opacity 2s ease-in-out;
    }
</style>
</html>