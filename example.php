<?php
// NovaPAI PHP SDK Example
// Install: composer require openai-php/client
// Docs: https://api.novapai.ai

require_once 'vendor/autoload.php';

use OpenAI;

$client = OpenAI::factory()
    ->withApiKey('your-api-key')
    ->withBaseUri('https://api.novapai.ai/router/v1')
    ->make();

// ── Basic Chat ──────────────────────────────────────────────
function basicChat($client) {
    $response = $client->chat()->create([
        'model' => 'deepseek-v4-pro',
        'messages' => [
            ['role' => 'system', 'content' => 'You are a helpful assistant.'],
            ['role' => 'user',   'content' => 'Hello!'],
        ],
    ]);
    echo $response->choices[0]->message->content . PHP_EOL;
}

// ── Streaming ───────────────────────────────────────────────
function streamChat($client) {
    $stream = $client->chat()->createStreamed([
        'model' => 'deepseek-v4-pro',
        'messages' => [
            ['role' => 'user', 'content' => 'Tell me a joke'],
        ],
    ]);
    foreach ($stream as $response) {
        echo $response->choices[0]->delta->content ?? '';
        flush();
    }
    echo PHP_EOL;
}

// ── Multi-turn Conversation ─────────────────────────────────
function multiTurnChat($client) {
    $messages = [['role' => 'system', 'content' => 'You are a helpful assistant.']];

    $chat = function (string $userInput) use ($client, &$messages): string {
        $messages[] = ['role' => 'user', 'content' => $userInput];
        $response = $client->chat()->create([
            'model'    => 'deepseek-v4-pro',
            'messages' => $messages,
        ]);
        $reply = $response->choices[0]->message->content;
        $messages[] = ['role' => 'assistant', 'content' => $reply];
        return $reply;
    };

    echo $chat('What is 1+1?') . PHP_EOL;
    echo $chat('Multiply that by 10') . PHP_EOL;
}

basicChat($client);
streamChat($client);
multiTurnChat($client);
