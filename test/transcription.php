<?php

require '../vendor/autoload.php';

use Izisaurio\OpenAI\Transcription,
    Dotenv\Dotenv,
    \FFMpeg\FFMpeg,
    \FFMpeg\Format\Audio\Mp3;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..')->safeLoad();

//Transform whatsapp file to compatible type
$ffmpeg = FFMpeg::create();
$audio = $ffmpeg->open('whatsapp.opus');
$mp3 = new Mp3();
//Save the file to a temp file
$tmpFile = tempnam(sys_get_temp_dir(), 'ad') . '.mp3';
$audio->save($mp3, $tmpFile);

$openai = new Transcription($_ENV['OPENAI']);

$response = $openai->send([
    'model' => 'whisper-1',
    'file' => $tmpFile,
    'response_format' => 'srt',
]);

var_dump($openai->srt());