<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Http;

new class extends Component {
    public $messages = [];
    public $userInput = '';
    public $isLoading = false;
    
    public function mount()
    {
        // Initialize with Tony's intro
        $this->messages = [
            [
                'role' => 'model',
                'text' => "Stark here. Make it quick, I've got three holograms running and a suit upgrade that won't finish itself. What do you need?",
                'timestamp' => now()->format('H:i')
            ]
        ];
    }
    
    public function sendMessage()
    {
        if (empty(trim($this->userInput))) {
            return;
        }
        
        // Add user message
        $this->messages[] = [
            'role' => 'user',
            'text' => $this->userInput,
            'timestamp' => now()->format('H:i')
        ];
        
        $userPrompt = $this->userInput;
        $this->userInput = '';
        $this->isLoading = true;
        
        try {
            // Build conversation history for API
            $contents = [
                [
                    'role' => 'user',
                    'parts' => [['text' => "You are Tony Stark. Keep responses SHORT and punchy - 2-3 sentences max unless absolutely necessary. Be witty, confident, and sarcastic but get to the point quickly. Don't over-explain. Talk like you're busy but helping anyway. Drop the occasional quip but stay concise."]]
                ],
                [
                    'role' => 'model',
                    'parts' => [['text' => "Stark here. Make it quick, I've got three holograms running and a suit upgrade that won't finish itself. What do you need?"]]
                ]
            ];
            
            // Add conversation history (skip the intro message)
            foreach (array_slice($this->messages, 1) as $msg) {
                $contents[] = [
                    'role' => $msg['role'],
                    'parts' => [['text' => $msg['text']]]
                ];
            }
            
            // Call Gemini API
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key=' . env('GEMINI_API_KEY'), [
                'contents' => $contents
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Error: No response';
                
                // Add AI response
                $this->messages[] = [
                    'role' => 'model',
                    'text' => $text,
                    'timestamp' => now()->format('H:i')
                ];
            } else {
                $this->messages[] = [
                    'role' => 'model',
                    'text' => 'JARVIS is having technical difficulties. Try again.',
                    'timestamp' => now()->format('H:i')
                ];
            }
            
        } catch (\Exception $e) {
            $this->messages[] = [
                'role' => 'model',
                'text' => 'System error: ' . $e->getMessage(),
                'timestamp' => now()->format('H:i')
            ];
        }
        
        $this->isLoading = false;
    }
};
?>

<div class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 p-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-black/40 backdrop-blur-sm border border-cyan-500/30 rounded-t-lg p-4 mb-0">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 bg-cyan-400 rounded-full animate-pulse"></div>
                    <h1 class="text-cyan-400 font-mono text-xl font-bold">STARK INDUSTRIES AI</h1>
                </div>
                <div class="text-cyan-500/60 font-mono text-sm">SYSTEM ONLINE</div>
            </div>
        </div>
        
        <!-- Chat Container -->
        <div class="bg-black/60 backdrop-blur-md border-x border-cyan-500/30 h-[600px] overflow-y-auto p-6 space-y-4" id="chatContainer">
            @foreach($messages as $message)
                @if($message['role'] === 'user')
                    <!-- User Message -->
                    <div class="flex justify-end">
                        <div class="max-w-[80%]">
                            <div class="bg-blue-600/30 border border-blue-400/50 rounded-lg p-4 backdrop-blur-sm">
                                <p class="text-blue-100 text-sm leading-relaxed">{{ $message['text'] }}</p>
                            </div>
                            <div class="text-blue-400/60 text-xs mt-1 text-right font-mono">{{ $message['timestamp'] }}</div>
                        </div>
                    </div>
                @else
                    <!-- Tony Stark Message -->
                    <div class="flex justify-start">
                        <div class="max-w-[80%]">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-red-600 rounded-full flex items-center justify-center flex-shrink-0 border-2 border-yellow-500/50">
                                    <span class="text-white text-xs font-bold">TS</span>
                                </div>
                                <div class="flex-1">
                                    <div class="bg-cyan-900/30 border border-cyan-400/50 rounded-lg p-4 backdrop-blur-sm">
                                        <p class="text-cyan-100 text-sm leading-relaxed">{{ $message['text'] }}</p>
                                    </div>
                                    <div class="text-cyan-400/60 text-xs mt-1 font-mono">{{ $message['timestamp'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            
            @if($isLoading)
                <div class="flex justify-start">
                    <div class="max-w-[80%]">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-red-600 rounded-full flex items-center justify-center flex-shrink-0 border-2 border-yellow-500/50">
                                <span class="text-white text-xs font-bold">TS</span>
                            </div>
                            <div class="bg-cyan-900/30 border border-cyan-400/50 rounded-lg p-4 backdrop-blur-sm">
                                <div class="flex gap-1">
                                    <div class="w-2 h-2 bg-cyan-400 rounded-full animate-bounce"></div>
                                    <div class="w-2 h-2 bg-cyan-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                    <div class="w-2 h-2 bg-cyan-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Input Area -->
        <div class="bg-black/40 backdrop-blur-sm border border-cyan-500/30 rounded-b-lg p-4">
            <form wire:submit.prevent="sendMessage" class="flex gap-3">
                <input 
                    type="text" 
                    wire:model="userInput"
                    placeholder="Type your message to Stark..."
                    class="flex-1 bg-gray-900/50 border border-cyan-500/30 rounded-lg px-4 py-3 text-cyan-100 placeholder-cyan-700 focus:outline-none focus:border-cyan-400 font-mono text-sm"
                    @if($isLoading) disabled @endif
                >
                <button 
                    type="submit"
                    class="bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 disabled:from-gray-600 disabled:to-gray-700 text-white px-6 py-3 rounded-lg font-mono font-bold transition-all duration-200 border border-cyan-400/50"
                    @if($isLoading) disabled @endif
                >
                    @if($isLoading)
                        <span class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    @else
                        SEND
                    @endif
                </button>
            </form>
        </div>
    </div>
    
    <script>
        // Auto-scroll to bottom when new messages arrive
        document.addEventListener('livewire:updated', () => {
            const container = document.getElementById('chatContainer');
            container.scrollTop = container.scrollHeight;
        });
    </script>
</div>