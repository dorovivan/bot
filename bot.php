<?php

$config = [
    'api_key' => '5675948335:AAHvH8M6SUkRmdkQS7cUKdLKExPYsMuMVoM'
];

$telegramData = file_get_contents('php://input');
$telegramData = json_decode($telegramData, true);

if ($telegramData['message']['entities'][0]['type'] == 'bot_command') {
    if ($telegramData['message']['text'] == '/start') {
        $message = [
            'chat_id' => $telegramData['message']['from']['id'],
            'text' => 'Welcome!'
        ];

        sendMessage($message);
        exit;
    }
}

if ($telegramData['message']['text']) {

    $string = $telegramData['message']['text'];

    preg_match('/(.*), (.*)/', $string, $result1);
    preg_match('/DL:(.*)/', $string, $result2);
    preg_match('/Expires: (.*)/', $string, $result3);
    preg_match('/DOB:(.*)/', $string, $result4);
    preg_match('/Wt:(.*)\..* kg/', $string, $result5);
    preg_match('/Ht:(.*) cm/', $string, $result6);
    preg_match('/Sex:(.*)/', $string, $result7);
    preg_match('/Eyes:(.*)/', $string, $result8);
    preg_match('/Hair:(.*)/', $string, $result9);
    preg_match('/(.*) (.*) BC(.*)/', $string, $result10);


    $expires = new DateTime($result3[1]);
    $DOB = new DateTime($result4[1]);

    $string2 = '%BC^' . $result1[1] . ',$' . $result1[2] . '^' . $result10[1] . '$' . $result10[2] . ' BC ^?;636028' . $result2[1] . '=' . $expires->format('y') . $expires->format('m') . $DOB->format('Ym') . $expires->format('d') . '=?_%0A' . (str_replace(' ', '', $result10[3])) . '                     ' . $result7[1] . $result6[1] . $result5[1] . $result9[1] . $result8[1] . ' :' . generateRandomString() . '%)' . generateRandomString() . ' ' . generateRandomString() . mt_rand(0, 9) . mt_rand(0, 9) . generateRandomString() . generateRandomString() . '? )';


    $message = [
        'chat_id' => $telegramData['message']['from']['id'],
        'text' => $string2
    ];

    sendMessage($message);
    exit;
}

function sendMessage($message)
{
    global $config;

    $requestAPIURL = 'https://api.telegram.org/bot' . $config['api_key'] . '/sendMessage';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $requestAPIURL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);
}

function generateRandomString($length = 1)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}