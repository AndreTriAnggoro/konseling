document.addEventListener('DOMContentLoaded', function () {
    const chatMessages = document.getElementById('chat-messages');
    const messageInput = document.getElementById('message-input');
    const sendButton = document.getElementById('send-button');

    sendButton.addEventListener('click', function () {
        const messageText = messageInput.value;
        if (messageText.trim() !== '') {
            const messageElement = document.createElement('div');
            messageElement.className = 'message outgoing';
            messageElement.innerHTML = `<p>Anda: ${messageText}</p>`;
            chatMessages.appendChild(messageElement);

            // Clear the input field
            messageInput.value = '';
        }
    });
});
