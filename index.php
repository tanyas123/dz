<?php
$data = json_decode(file_get_contents('php://input'), TRUE);
file_put_contents('file.txt', '$data: '.print_r($data, 1)."/n", FILE_APPEND);

http://api.telegram.org/bot5085019632:AAG0ym_9TH1LmWYXePhNkbKmLioCwRsZyXI/setwebhook?url=https://github.com/tanyas123/dz/index.php

$data = $data['callback_query'] ? $data['callback_query'] : $data['message'];
define('TOKEN', '5085019632:AAG0ym_9TH1LmWYXePhNkbKmLioCwRsZyXI');
$message = mb_strtolower(($data['text'] ? $data['text'] : $data['data']), 'utf-8');

switch ($message){
    case 'текст':
        $method = 'sendMessage';
        $send_data = [
            'text' => 'hi'
        ];
        break;



    case 'видео':
        $method = 'sendVideo';
        $send_data = [
            'video' => 'https://www.youtube.com/watch?v=mwVVE1tVHls',
        ];
        break;
    default:
        $send_data = [
            'method' => 'sendMessage',
            'text' => 'Я тебя не понимаю'
        ];
}
$send_data['chat_id'] = $data['chat']['id'];
$res = sendTelegram($method, $send_data);
function sendTelegram($method, $data, $headers =[]){
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://api.telegram.org/bot'.TOKEN.'/'.$method,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"), $headers)
    ]);
    $result = curl_exec($curl);
    curl_close($curl);
    return (json_decode($result, 1) ? json_decode($result, 1): $result);
}