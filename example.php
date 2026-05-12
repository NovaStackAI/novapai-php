<?php
// NovaPAI PHP SDK Example
// Install: composer require openai-php/client
// Docs: https://novapai.ai

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

// ── Function Calling ────────────────────────────────────────
function functionCalling($client) {
    $response = $client->chat()->create([
        'model' => 'deepseek-v4-pro',
        'messages' => [
            ['role' => 'user', 'content' => "What's the weather in Tokyo?"],
        ],
        'tools' => [[
            'type' => 'function',
            'function' => [
                'name' => 'get_weather',
                'description' => 'Get current weather for a city',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'city' => ['type' => 'string', 'description' => 'City name']
                    ],
                    'required' => ['city']
                ]
            ]
        ]]
    ]);

    $toolCall = $response->choices[0]->message->toolCalls[0];
    echo "Function: {$toolCall->function->name}" . PHP_EOL;
    echo "Args: {$toolCall->function->arguments}" . PHP_EOL;

    // Continue with tool result
    $result = json_encode(['city' => 'Tokyo', 'temperature' => 22, 'condition' => 'sunny']);
    $final = $client->chat()->create([
        'model' => 'deepseek-v4-pro',
        'messages' => [
            ['role' => 'user', 'content' => "What's the weather in Tokyo?"],
            ['role' => 'assistant', 'toolCalls' => [$toolCall->toArray()]],
            ['role' => 'tool', 'tool_call_id' => $toolCall->id, 'content' => $result],
        ]
    ]);
    echo $final->choices[0]->message->content . PHP_EOL;
}

// ── JSON Mode (Structured Output) ───────────────────────────
function jsonMode($client) {
    $response = $client->chat()->create([
        'model' => 'deepseek-v4-pro',
        'messages' => [
            ['role' => 'system', 'content' => 'Extract company info as JSON.'],
            ['role' => 'user', 'content' => 'Apple Inc. is based in Cupertino, founded in 1976.'],
        ],
        'response_format' => ['type' => 'json_object']
    ]);

    $data = json_decode($response->choices[0]->message->content, true);
    echo json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL;
}

basicChat($client);
streamChat($client);
multiTurnChat($client);
functionCalling($client);
jsonMode($client);
