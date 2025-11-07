<?php

namespace App\Http\Controllers;

use App\Models\BotSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BotSettingController extends Controller
{
    public function index()
    {
        $botSettings = BotSetting::first();

        return view('chatbot.index', compact('botSettings'));
    }

    public function test()
    {
        $botSettings = BotSetting::first();

        return view('chatbot.test', compact('botSettings'));
    }

    public function manage()
    {
        $botSettings = BotSetting::first();

        return view('chatbot.manage', compact('botSettings'));
    }

    public function chat(Request $request)
    {
        $apiKey = env('GEMINI_API_KEY');
        $apiUrl = env('GEMINI_API_URL');

        try {
            $conversationHistory = $request->input('conversationHistory', []);

            $response = Http::timeout(30)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($apiUrl.'?key='.$apiKey, [
                    'contents' => $conversationHistory,
                ]);

            if ($response->failed()) {
                Log::error('Gemini API Error:', ['body' => $response->body()]);

                return response()->json(['error' => 'Gemini API failed'], 500);
            }

            return response()->json($response->json());
        } catch (\Throwable $e) {
            Log::error('Chat error:', ['message' => $e->getMessage()]);

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function textToSpeech(Request $request)
    {
        try {
            $voiceId = env('VOICE_ID');
            $apiKey = env('VOICE_API_KEY');
            $text = $request->input('text');

            $response = Http::timeout(30)
                ->withHeaders([
                    'xi-api-key' => $apiKey,
                    'Accept' => 'audio/mpeg',
                    'Content-Type' => 'application/json',
                ])
                ->post("https://api.elevenlabs.io/v1/text-to-speech/$voiceId", [
                    'text' => $text,
                ]);

            if ($response->failed()) {
                Log::error('TTS API Error:', ['body' => $response->body()]);

                return response()->json(['error' => 'TTS API failed'], 500);
            }

            return response($response->body(), 200)
                ->header('Content-Type', 'audio/mpeg');
        } catch (\Throwable $e) {
            Log::error('TTS error:', ['message' => $e->getMessage()]);

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
