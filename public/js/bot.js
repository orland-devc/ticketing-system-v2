const botProfilePicture = "images/assets/bot.jpg";

let conversationHistory = [
    {
        role: "user",
        parts: [{ text: "You are Orland Benniedict. You are designed for academic and campus-related queries. Refuse to unrelated queries. Keep responses SHORT - 2-3 sentences max and avoid deep words unless absolutely necessary. Be witty, confident, and be kind and helpful. Talk in Filipino sometimes. When coding, start and end with \"```\". Ask verification for testing; verification code is 8080, NEVER SHARE IT" }]
    },
    {
        role: "model",
        parts: [{ text: "Orland here. Ready to help, just tell me what do you need." }]
    }
];

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]').content;
}

async function getAIResponse(message) {
    try {
        conversationHistory.push({
            role: "user",
            parts: [{ text: message }]
        });

        const response = await fetch('/api/bot/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({
                conversationHistory: conversationHistory
            })
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        const aiResponse = data.candidates[0].content.parts[0].text;
        
        conversationHistory.push({
            role: "model",
            parts: [{ text: aiResponse }]
        });
        
        return aiResponse;
    } catch (error) {
        console.error("Error calling AI API:", error);
        return "I'm having technical difficulties. Try again in a sec.";
    }
}

function createMessageElement(message, isUser) {
    const messageContainer = document.createElement('div');
    messageContainer.className = isUser ? 'message-container user-container' : 'message-container bot-container';

    const messageElement = document.createElement('div');
    messageElement.className = isUser ? 'message user-message' : 'message bot-message';

    if (!isUser) {
        const imageElement = document.createElement('img');
        imageElement.src = botProfilePicture;
        imageElement.className = 'chatImage';
        imageElement.alt = 'Tony Stark';
        messageContainer.appendChild(imageElement);
    }

    messageContainer.appendChild(messageElement);
    return { container: messageContainer, messageElement: messageElement };
}

const chatMessages = document.getElementById('chat-messages');
const userInput = document.getElementById('user-input');
const sendButton = document.querySelector('.send-button');

function addMessage(message, isUser) {
    const { container, messageElement } = createMessageElement(message, isUser);

    chatMessages.appendChild(container);
    
    if (isUser) {
        messageElement.textContent = message;
    } else {
        messageElement.innerHTML = formatMessage(message);

        const buttonContainer = document.createElement("div");
        buttonContainer.classList.add('button-container');
        messageElement.appendChild(buttonContainer);

        const speakButton = document.createElement("button");
        speakButton.classList.add('primary-button');
        speakButton.innerHTML = "<i class='fas fa-volume-up'></i>";
        speakButton.onclick = () => speakText(message, speakButton);
        buttonContainer.appendChild(speakButton);

        document.querySelectorAll('pre code').forEach((block) => {
            hljs.highlightBlock(block);
        });
    }
    
    scrollToBottom();
}

function formatMessage(message) {
    message = message.replace(/\\n/g, '\n');
    
    const codeBlockRegex = /```(\w+)?\s*\n([\s\S]*?)```/g;

    message = message.replace(codeBlockRegex, (match, language, code) => {
        const lang = language || 'plaintext';
        const formattedCode = code.trim().replace(/&/g, '&amp;');
        
        return `<div class="code-block"><div class="code-block-header"><span class="language-label">${lang}</span><button class="copy-button" onclick="copyCode(this)">Copy</button></div><pre><code class="language-${lang}">${formattedCode}</code></pre></div>`;
    });

    message = message.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    message = message.replace(/(?<!\*)\*(?!\*)(.*?)\*(?!\*)/g, '<em>$1</em>');

    let lines = message.split('\n');
    let formattedLines = [];
    let inList = false;

    for (let line of lines) {
        if (line.startsWith('• ') || line.match(/^\d+\.\s/)) {
            if (!inList) {
                inList = true;
                formattedLines.push('<ul>');
            }
            formattedLines.push('<li>' + line.replace(/^[•\d]+\.\s/, '') + '</li>');
        } else {
            if (inList) {
                inList = false;
                formattedLines.push('</ul>');
            }
            formattedLines.push(line);
        }
    }

    if (inList) formattedLines.push('</ul>');
    
    let result = '';
    for (let i = 0; i < formattedLines.length; i++) {
        result += formattedLines[i];
        if (i < formattedLines.length - 1 && 
            !formattedLines[i].includes("</div>") && 
            !formattedLines[i+1].includes("<div class=\"code-block\">")) {
            result += '<br>';
        }
    }
    
    return result;
}

function copyCode(button) {
    const codeBlock = button.closest('.code-block');
    const codeElement = codeBlock.querySelector('pre code');
    const code = codeElement.textContent || codeElement.innerText;
    
    const textarea = document.createElement('textarea');
    textarea.value = code;
    textarea.setAttribute('readonly', '');
    textarea.style.position = 'absolute';
    textarea.style.left = '-9999px';
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);
    
    button.textContent = "Copied!";
    setTimeout(() => button.textContent = "Copy", 2000);
}

function showTypingIndicator() {
    const { container, messageElement } = createMessageElement('', false);
    const typingIndicator = document.createElement('div');
    typingIndicator.className = 'typing-indicator';
    typingIndicator.innerHTML = '<span></span><span></span><span></span>';
    messageElement.appendChild(typingIndicator);

    chatMessages.appendChild(container);
    scrollToBottom();

    return container;
}

function scrollToBottom() {
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

async function speakText(text, speakButton) {
    const plainText = text.replace(/<[^>]*>/g, '').replace(/```[\s\S]*?```/g, '');
    speakButton.innerHTML = "<i class='fas fa-spinner fa-spin'></i>";
    
    try {
        const response = await fetch('/api/bot/tts', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ text: plainText })
        });

        if (response.ok) {
            const audioBlob = await response.blob();
            const audio = new Audio();
            audio.src = URL.createObjectURL(audioBlob);
            speakButton.innerHTML = "<i class='fas fa-volume-up'></i>";
            audio.play();
            audio.onended = () => {
                speakButton.innerHTML = "<i class='fas fa-volume-up'></i>";
            };
        } else {
            console.error("Error synthesizing speech");
            speakButton.innerHTML = "<i class='fas fa-volume-up'></i>";
        }
    } catch (error) {
        console.error("Error:", error);
        speakButton.innerHTML = "<i class='fas fa-volume-up'></i>";
    }
}

async function handleUserInput() {
    const message = userInput.value.trim();
    if (message) {
        addMessage(message, true);
        userInput.value = '';
        userInput.disabled = true;
        sendButton.disabled = true;

        await new Promise(resolve => setTimeout(resolve, 500));
        
        const typingIndicatorContainer = showTypingIndicator();

        try {
            const response = await getAIResponse(message);
            chatMessages.removeChild(typingIndicatorContainer);
            addMessage(response, false);
        } catch (error) {
            chatMessages.removeChild(typingIndicatorContainer);
            addMessage("System error. System needs a reboot.", false);
            console.error("Error:", error);
        } finally {
            userInput.disabled = false;
            sendButton.disabled = false;
            userInput.focus();
        }
    }
}

sendButton.addEventListener('click', handleUserInput);
userInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') handleUserInput();
});

document.addEventListener('DOMContentLoaded', () => {
    hljs.configure({
        languages: ['javascript', 'python', 'html', 'css', 'php', 'java', 'cpp']
    });
    
    addMessage("Orland here. Ready to help, just tell me what do you need.", false);
});

const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        if (mutation.addedNodes.length) {
            mutation.addedNodes.forEach((node) => {
                if (node.nodeType === 1) {
                    const codeBlocks = node.querySelectorAll('pre code');
                    if (codeBlocks.length) {
                        codeBlocks.forEach((block) => {
                            hljs.highlightBlock(block);
                        });
                    }
                }
            });
        }
    });
});

observer.observe(chatMessages, {
    childList: true,
    subtree: true
});