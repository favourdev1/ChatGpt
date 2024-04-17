<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class AiGeneratorController extends Controller
{
    public int $numResults;
    public float $temperature;
    public string $QuestionSystemInformation;


    public function __construct()
    {
        $this->numResults = 1;
        $this->temperature = 0.3;
        $this->QuestionSystemInformation = 'You are an AI chatbot whose job is to chat with users and answer their questions and at the same time be very conversational....';
    }

    public function sendQuestion(Request $request): JsonResponse
    {
        try {
            $question = $request->question ?? $this->dummyQuestion();

            $response = $this->sendToAI($question, 'user', $this->QuestionSystemInformation);
            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Question generated successfully',
                    'data' => $response->json(),
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $response->body(),
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

  
    private function sendToAI($message, $role, $system = null)
    {
        $url = 'https://api.ai21.com/studio/v1/j2-ultra/chat';

        $payload = [
            'numResults' => $this->numResults,
            'temperature' => $this->temperature,
            'messages' => [
                [
                    'text' => $message,
                    'role' => $role,
                ],
            ],
            'system' => $system,
        ];

        $headers = [
            'Authorization' => 'Bearer ' . 'nSXwMQYhJNeGBqtuooSzLWaXF7aMJBbB',
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ];

        $response = Http::withHeaders($headers)->post($url, $payload);
        return $response;
    }
    public function dummyQuestion()
    {
        $questions = [
            'Did you enjoy your last meal?',
            'Was your last dinner satisfying?',
            "Did you have a good night's sleep?",
            'Was your last date enjoyable?',
            'Did you complete all your homework?',
            'Was the last book you read interesting?',
            'Did you have a productive day at work?',
            'Was your last school project challenging?',
            'Did you try any new foods recently?',
            'Was the last movie you watched entertaining?',
            'Did you have a fun time with your friends recently?',
            'Was the last exam you took difficult?',
            'Did you learn anything new today?',
            'Was the last concert you attended enjoyable?',
            'Did you have a good experience at the last restaurant you visited?',
            'Was the last party you attended fun?',
            'Did you enjoy spending time outdoors last weekend?',
            'Was the last museum you visited interesting?',
            'Did you have a good workout session yesterday?',
            'Was the last TV show you watched entertaining?',
            'Did you have a positive interaction with someone today?',
            'Was the last vacation you took relaxing?',
            'Did you have a good experience with customer service recently?',
            'Was the last song you listened to enjoyable?',
            'Did you have a good time at the last family gathering?',
            'Was the last podcast you listened to informative?',
            'Did you enjoy your last shopping experience?',
            'Was the last hike you went on challenging?',
            'Did you have a good experience with your last purchase?',
        ];

        $randomKey = array_rand($questions);
        $randomQuestion = $questions[$randomKey];
        return $randomQuestion;
    }
}
