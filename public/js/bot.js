const botProfilePicture = window.botSettings.profile_picture;

let conversationHistory = [
    {
        role: "user",
        parts: [{ text: "Today is " + window.botSettings.time +
            ". You are " + window.botSettings.name +
            ". You are talking to " + window.botSettings.username + ". " +
            window.botSettings.character +
            window.botSettings.role +
            window.botSettings.personality +
            window.botSettings.behavior +
            " Limit your response based on FAQs. " +
            "If you think that the concern is outside FAQs, suggest to create a ticket. " +
            "If someone asked, you are Orland Benniedict Sayson's fast-developing LLM." }]
    },
    {
        role: "model",
        parts: [{ text: "Hi **" + window.botSettings.username + "**! " + window.botSettings.name + " here. " + window.botSettings.greeting }]
    }
];

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]').content;
}

// =============================
// 🧠 FAQ Matching System
// =============================
function findMatchingFaqs(userMessage) {
    const stopwords = [
        'the','a','an','is','are','was','were','what','who','how','where','why',
        'to','for','of','and','in','on','do','does','did','can','you','your','i','my','me','it'
    ];

    const words = userMessage
        .toLowerCase()
        .replace(/[^a-z0-9\s]/g, '')
        .split(/\s+/)
        .filter(w => w && !stopwords.includes(w));

    const matchedFaqs = [];

    if (!window.faqs || !window.faqs.length) return matchedFaqs;

    window.faqs.forEach(faq => {
        let score = 0;
        const questionWords = faq.question.toLowerCase().replace(/[^a-z0-9\s]/g, '').split(/\s+/);

        words.forEach(word => {
            if (questionWords.includes(word)) score++;
        });

        if (score >= 2) matchedFaqs.push({ question: faq.question, answer: faq.answer, score });
    });

    matchedFaqs.sort((a, b) => b.score - a.score);
    return matchedFaqs.slice(0, 3); // top 3 most relevant
}

// =============================
// 🤖 AI Response Handling
// =============================
async function getAIResponse(message, matchedFaqs = []) {
    try {
        conversationHistory.push({
            role: "user",
            parts: [{ text: message }]
        });

        // Add matched FAQs context (if any)
        if (matchedFaqs.length > 0) {
            const faqContext = matchedFaqs.map(f => `Q: ${f.question}\nA: ${f.answer}`).join('\n\n');
            conversationHistory.push({
                role: "user",
                parts: [{ text: "Here are some possible matched FAQs based on user's message:\n" + faqContext }]
            });
        }

        // Keep system prompt (first 2) + last 10 messages
        const maxMessages = 10;
        const historyToSend =
            conversationHistory.length > maxMessages + 2
                ? [conversationHistory[0], conversationHistory[1], ...conversationHistory.slice(-maxMessages)]
                : conversationHistory;

        const response = await fetch('/api/bot/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({
                conversationHistory: historyToSend,
                matchedFaqs
            })
        });

        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();
        const aiResponse = data.candidates[0].content.parts[0].text;

        conversationHistory.push({
            role: "model",
            parts: [{ text: aiResponse }]
        });

        return aiResponse;
    } catch (error) {
        console.error("Error calling AI API:", error);
        return window.botSettings.error;
    }
}

// =============================
// 💬 Chat UI and Message Handling
// =============================
function createMessageElement(message, isUser) {
    const messageContainer = document.createElement('div');
    messageContainer.className = isUser ? 'message-container user-container' : 'message-container bot-container';

    const messageElement = document.createElement('div');
    messageElement.className = isUser ? 'message user-message' : 'message bot-message';

    if (!isUser) {
        const imageElement = document.createElement('img');
        imageElement.src = botProfilePicture;
        imageElement.className = 'chatImage';
        imageElement.alt = window.botSettings.name;
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

        document.querySelectorAll('pre code').forEach(block => hljs.highlightBlock(block));
    }

    scrollToBottom();
}

// =============================
// 🧩 Message Formatting
// =============================
function formatMessage(message) {
    message = message.replace(/\\n/g, '\n');
    const codeBlockRegex = /```(\w+)?\s*\n([\s\S]*?)```/g;
    message = message.replace(codeBlockRegex, (match, language, code) => {
        const lang = language || 'plaintext';
        const formattedCode = code.trim().replace(/&/g, '&amp;');
        return `<div class="code-block"><div class="code-block-header"><span class="language-label">${lang}</span><button class="copy-button" onclick="copyCode(this)">Copy</button></div><pre><code class="language-${lang}">${formattedCode}</code></pre></div>`;
    });
    message = message.replace(/`([^`]+)`/g, '<code class="inline-code">$1</code>');
    message = message.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    message = message.replace(/(?<!\*)\*(?!\*)(.*?)\*(?!\*)/g, '<em>$1</em>');
    return message.replace(/\n/g, '<br>');
}

// =============================
// 📋 Code Copy
// =============================
function copyCode(button) {
    const codeBlock = button.closest('.code-block');
    const code = codeBlock.querySelector('pre code').textContent;
    navigator.clipboard.writeText(code);
    button.textContent = "Copied!";
    setTimeout(() => (button.textContent = "Copy"), 2000);
}

// =============================
// 🎙️ Text-to-Speech
// =============================
async function speakText(text, speakButton) {
    const plainText = text.replace(/<[^>]*>/g, '').replace(/```[\s\S]*?```/g, '');
    speakButton.innerHTML = "<i class='fas fa-spinner fa-spin'></i>";
    try {
        const response = await fetch('/api/bot/tts', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
            body: JSON.stringify({ text: plainText })
        });

        if (response.ok) {
            const audioBlob = await response.blob();
            const audio = new Audio(URL.createObjectURL(audioBlob));
            audio.play();
        }
    } catch (error) {
        console.error("TTS Error:", error);
    } finally {
        speakButton.innerHTML = "<i class='fas fa-volume-up'></i>";
    }
}

// =============================
// ⌨️ Input Handling
// =============================
let isAwaitingResponse = false;

async function handleUserInput() {
    if (isAwaitingResponse) return;
    const message = userInput.value.trim();
    if (!message) return;

    addMessage(message, true);
    userInput.value = '';
    sendButton.disabled = true;
    isAwaitingResponse = true;

    await new Promise(r => setTimeout(r, 500));
    const typingIndicatorContainer = showTypingIndicator();

    try {
        const matchedFaqs = findMatchingFaqs(message);

        // Instant reply if strong FAQ match
        if (matchedFaqs.length && matchedFaqs[0].score >= 4) {
            chatMessages.removeChild(typingIndicatorContainer);
            addMessage(matchedFaqs[0].answer, false);
        } else {
            const response = await getAIResponse(message, matchedFaqs);
            chatMessages.removeChild(typingIndicatorContainer);
            addMessage(response, false);
        }
    } catch (error) {
        chatMessages.removeChild(typingIndicatorContainer);
        addMessage("System error. System needs a reboot.", false);
        console.error("Error:", error);
    } finally {
        sendButton.disabled = false;
        isAwaitingResponse = false;
        userInput.focus();
    }
}

userInput.addEventListener('keypress', e => e.key === 'Enter' && !isAwaitingResponse && handleUserInput());
sendButton.addEventListener('click', () => !isAwaitingResponse && handleUserInput());

// =============================
// ✨ Extras
// =============================
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

document.addEventListener('DOMContentLoaded', () => {
    hljs.configure({ languages: ['javascript', 'python', 'html', 'css', 'php', 'java', 'cpp'] });
    addMessage("Hi **" + window.botSettings.username + "**! " + window.botSettings.name + " here. " + window.botSettings.greeting, false);
});
