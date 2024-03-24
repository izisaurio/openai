<?php

require '../vendor/autoload.php';

use Izisaurio\OpenAI\Chat,
    Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..')->safeLoad();

$openai = new Chat($_ENV['OPENAI']);

$response = $openai->send([
    'messages' => [
        ['role' => 'system', 'content' => 'You are a helpful assistant.'],
        ['role' => 'user', 'content' => 'What is the meaning of life?'],
    ],
]);

var_dump($response['choices'][0]['message']['content']);