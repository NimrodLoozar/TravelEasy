<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-4">
        <h2 class="text-xl font-semibold text-gray-800 text-center mb-4">Chatbot</h2>
        
        <div id="chat-box" class="h-96 overflow-y-auto border rounded-lg p-3 bg-gray-50" aria-live="polite">
            <p class="text-gray-400 text-sm text-center">ask anything...</p>
        </div>

        <div class="flex items-center gap-2 mt-3">
            <input type="text" id="user-input" class="flex-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ask me anything...">
            <button id="send-button" onclick="sendMessage()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Send
            </button>
        </div>
        <p class="text-center text-gray-500 text-sm mt-4">
            Made with ❤️ by <a href="https://github.com/ThomasTadesse" class="text-blue-500 hover:underline">T. Tadesse</a>
        </p>
    </div>

    <script>
        const chatBox = document.getElementById('chat-box');
        const userInput = document.getElementById('user-input');
        const sendButton = document.getElementById('send-button');

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
            chatBox.scrollTop = chatBox.scrollHeight;  // Auto-scroll to latest message
        }

        function sendMessage() {
            const message = userInput.value.trim();
            if (!message) return;

            addMessage('user', message);
            userInput.value = '';
            sendButton.disabled = true;  // Disable the send button

            // Show loading indicator
            const loadingMessage = document.createElement('p');
            loadingMessage.textContent = 'Thinking...';
            loadingMessage.classList.add('text-gray-400', 'text-sm', 'italic');
            chatBox.appendChild(loadingMessage);
            chatBox.scrollTop = chatBox.scrollHeight;

            // Send message to backend
            fetch('/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => {
                chatBox.removeChild(loadingMessage);  // Remove loading text
                addMessage('bot', data.message);
            })
            .catch(error => {
                console.error('Error:', error);
                chatBox.removeChild(loadingMessage);
                addMessage('bot', 'Oops! Something went wrong.');
            })
            .finally(() => {
                sendButton.disabled = false;  // Re-enable the send button
            });
        }
    </script>

</body>
