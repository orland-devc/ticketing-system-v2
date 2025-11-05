<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent', [
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
        $apiKey = config('services.gemini.key') ?: env('GEMINI_API_KEY');
        $apiUrl = config('services.gemini.url') ?: env('GEMINI_API_URL');

        $payload = [
            'contents' => $request->input('conversation') ?? [['role' => 'user', 'parts' => [['text' => $request->input('message')]]]],
        ];

        $res = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post($apiUrl.'?key='.$apiKey, $payload);

        if ($res->successful()) {
            $candidate = $res->json('candidates.0.content.parts.0.text') ?? '';

            return response()->json(['output' => $candidate]);
        }

        return response()->json(['error' => 'AI error'], 500);
    }

    public function tts(Request $request)
    {
        $elevenKey = env('ELEVENLABS_KEY');
        $voiceId = env('ELEVEN_VOICE_ID');

        $res = Http::withHeaders([
            'Content-Type' => 'application/json',
            'xi-api-key' => $elevenKey,
        ])->post("https://api.elevenlabs.io/v1/text-to-speech/{$voiceId}", [
            'text' => $request->input('text'),
            'voice_settings' => ['stability' => 0.5, 'similarity_boost' => 0.75],
        ]);

        if ($res->successful()) {
            return response($res->body(), 200)->header('Content-Type', 'audio/mpeg');
        }

        return response()->json(['error' => 'TTS failed'], 500);
    }
}
