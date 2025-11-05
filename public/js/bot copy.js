const GEMINI_API_KEY = "";
const GEMINI_API_URL = "";
const botProfilePicture = "images/assets/bot.jpg";

let conversationHistory = [
    {
        role: "user",
        parts: [{ text: "You are Orland Benniedict. You are designed for academic and campus-related queries. Refuse to unrelated queries. Keep responses SHORT - 2-3 sentences max and avoid deep words unless absolutely necessary. Be witty, confident, and be kind and helpful. Talk in Filipino if you can. When coding, start and end with \"```\"" }]
    },
    {
        role: "model",
        parts: [{ text: "Orland here. Make it quick, I've got three holograms running and a suit upgrade that won't finish itself. What do you need?" }]
    }
];

async function getAIResponse(message) {
    try {
        conversationHistory.push({
            role: "user",
            parts: [{ text: message }]
        });

        const response = await axios.post(
            `${GEMINI_API_URL}?key=${GEMINI_API_KEY}`,
            { contents: conversationHistory },
            { headers: { "Content-Type": "application/json" } }
        );

        const aiResponse = response.data.candidates[0].content.parts[0].text;
        
        conversationHistory.push({
            role: "model",
            parts: [{ text: aiResponse }]
        });
        
        return aiResponse;
    } catch (error) {
        console.error("Error calling Gemini API:", error.response ? error.response.data : error.message);
        return "JARVIS is having technical difficulties. Try again in a sec.";
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

    if (isUser) {
        chatMessages.appendChild(container);
        messageElement.textContent = message;
        scrollToBottom();
    } else {
        showTypingIndicator().then(() => {
            chatMessages.appendChild(container);
            messageElement.innerHTML = formatMessage(message);
            scrollToBottom();

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
        });
    }
}

function formatMessage(message) {
    const codeBlockRegex = /```(\w+)?\s*\n([\s\S]*?)```/g;

    message = message.replace(codeBlockRegex, (match, language, code) => {
        const lang = language || 'plaintext';
        const formattedCode = code.trim().replace(/&/g, '&amp;');
        
        return `<div class="code-block"><div class="code-block-header"><span class="language-label">${lang}</span><button class="copy-button" onclick="copyCode(this)">Copy</button></div><pre><code class="language-${lang}">${formattedCode}</code></pre></div>`;
    });

    // Bold
    message = message.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    // Italic (ignore **bold**)
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

    return new Promise((resolve) => {
        setTimeout(() => {
            chatMessages.removeChild(container);
            resolve();
        }, 1500);
    });
}

function scrollToBottom() {
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

async function speakText(text, speakButton) {
    const plainText = text.replace(/<[^>]*>/g, '').replace(/```[\s\S]*?```/g, '');
    speakButton.innerHTML = "<i class='fas fa-spinner fa-spin'></i>";

    const apiKey = "sk_fbb20533bf5d2cf8bbec51f86e146c70f7d270ba4c30a07b";
    const voiceId = "WTUK291rZZ9CLPCiFTfh";

    try {
        const response = await fetch(
            `https://api.elevenlabs.io/v1/text-to-speech/${voiceId}`,
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "xi-api-key": apiKey
                },
                body: JSON.stringify({
                    text: plainText,
                    voice_settings: { stability: 0.5, similarity_boost: 0.75 }
                })
            }
        );

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

        try {
            const response = await getAIResponse(message);
            addMessage(response, false);
        } catch (error) {
            addMessage("System error. JARVIS needs a reboot.", false);
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
    
    addMessage("Orland here. Make it quick, I've got three holograms running and a suit upgrade that won't finish itself. What do you need?", false);
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