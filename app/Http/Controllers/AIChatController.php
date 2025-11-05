<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIChatController extends Controller
{
    public function index()
    {
        return view('chatbot.index');
    }

    public function send(Request $request)
    {
        $userInput = $request->input('message');
        $history = $request->input('history', []);

        // Add current user message to conversation
        $conversation = $history;
        $conversation[] = [
            'role' => 'user',
            'parts' => [['text' => $userInput]],
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'x-goog-api-key' => env('GEMINI_API_KEY'),
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
            'contents' => $conversation,
        ]);

        $data = $response->json();

        // Safely extract Gemini’s text output
        $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? '[No response received]';

        // Add model reply to conversation
        $conversation[] = [
            'role' => 'model',
            'parts' => [['text' => $reply]],
        ];

        return response()->json([
            'reply' => $reply,
            'history' => $conversation,
        ]);
    }

    public function chat(Request $request)
    {
        try {
            $conversationHistory = $request->input('conversationHistory', []);
            
            $apiKey = env('GEMINI_API_KEY');
            $apiUrl = env('GEMINI_API_URL');
            
            // Debug: Check if env variables exist
            if (!$apiKey || !$apiUrl) {
                Log::error('Missing Gemini API configuration');
                return response()->json([
                    'error' => 'API configuration missing'
                ], 500);
            }

            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post(
                    $apiUrl . '?key=' . $apiKey,
                    ['contents' => $conversationHistory]
                );

            if ($response->successful()) {
                return response()->json($response->json());
            }

            // Log the actual error from Gemini
            Log::error('Gemini API Error Response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return response()->json([
                'error' => 'Failed to get AI response',
                'details' => $response->body()
            ], $response->status());

        } catch (\Exception $e) {
            Log::error('Gemini API Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'JARVIS is having technical difficulties.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function textToSpeech(Request $request)
    {
        try {
            $text = $request->input('text');
            
            $voiceKey = env('VOICE_API_KEY');
            $voiceId = env('VOICE_ID');
            
            // Debug: Check if env variables exist
            if (!$voiceKey || !$voiceId) {
                Log::error('Missing Voice API configuration');
                return response()->json([
                    'error' => 'Voice API configuration missing'
                ], 500);
            }

            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'xi-api-key' => $voiceKey,
                ])
                ->post(
                    'https://api.elevenlabs.io/v1/text-to-speech/' . $voiceId,
                    [
                        'text' => $text,
                        'voice_settings' => [
                            'stability' => 0.5,
                            'similarity_boost' => 0.75
                        ]
                    ]
                );

            if ($response->successful()) {
                return response($response->body())
                    ->header('Content-Type', 'audio/mpeg');
            }

            // Log the actual error from ElevenLabs
            Log::error('ElevenLabs API Error Response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return response()->json([
                'error' => 'Failed to synthesize speech',
                'details' => $response->body()
            ], $response->status());

        } catch (\Exception $e) {
            Log::error('TTS API Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Speech synthesis failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
