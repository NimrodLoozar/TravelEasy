<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with AI</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen py-12">

<div class="w-full max-w-md bg-white shadow-lg rounded-lg p-4">
    <h1 class="text-xl font-semibold text-gray-800 text-center mb-4">Chatbot</h1>

    <!-- Chatbox -->
    <div id="chat-box" class="h-96 overflow-y-auto border rounded-lg p-3 bg-gray-50 mb-4" aria-live="polite">
        <p class="text-gray-400 text-sm text-center">Ask me anything...</p>
    </div>

    <!-- Form to send prompt to the API -->
    <form action="{{ route('huggingface.generate') }}" method="POST" id="chat-form" class="flex items-center gap-2">
        @csrf
        <input type="text" name="prompt" class="flex-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="type here" rows="4" id="prompt" required>
        
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
            Send
        </button>
    </form>

    <!-- Displaying the response -->
    @if(isset($response))
            <h2>AI Response:</h2>
            <p>{{ $response }}</p>
        @elseif(isset($error))
            <h2>Error:</h2>
            <p>{{ $error }}</p>
        @endif

    <p class="text-center text-gray-500 text-sm mt-4">
        Made with ❤️ by <a href="https://github.com/ThomasTadesse" class="text-blue-500 hover:underline">T. Tadesse</a>
    </p>
</div>

<a href="{{ url('/') }}" class="fixed bottom-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition">
    Home
</a>

<script>
    const chatBox = document.getElementById('chat-box');
    const promptInput = document.getElementById('prompt');
    const chatForm = document.getElementById('chat-form');

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

        // Show loading indicator
        const loadingMessage = document.createElement('p');
        loadingMessage.textContent = 'Thinking...';
        loadingMessage.classList.add('text-gray-400', 'text-sm', 'italic');
        chatBox.appendChild(loadingMessage);
        chatBox.scrollTop = chatBox.scrollHeight;

        fetch('/huggingface/generate', {  // Change this to the correct route
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ prompt: message })  // Change 'message' to 'prompt'
        })
        .then(response => response.json())
        .then(data => {
            chatBox.removeChild(loadingMessage);
            addMessage('bot', data.response || 'No response from AI');
        })
        .catch(error => {
            console.error('Error:', error);
            chatBox.removeChild(loadingMessage);
            addMessage('bot', 'Oops! Something went wrong.');
        });
    });
</script>

</body>
</html>
