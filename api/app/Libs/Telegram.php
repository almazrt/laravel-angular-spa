<?php


namespace App\Libs;


use GuzzleHttp\Client;

class Telegram
{
    public static function getClient()
    {
        $params = [
            'base_uri' => 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN', '') . '/',
        ];

        if (env('PROXY', false)) {
            $params['proxy'] = env('PROXY');
        }

        return new Client($params);
    }

    public static function sendMessage($chatId, $message, $replyMarkup = [])
    {
        $client = self::getClient();

        $json = [
            'chat_id' => $chatId,
            'text' => $message,
        ];

        if ($replyMarkup) {
            $json['reply_markup'] = $replyMarkup;
        }

        return $client->post('sendMessage', ['json' => $json]);
    }

    public static function sendContact($chatId, $phone, $name)
    {
        $client = self::getClient();

        $json = [
            'chat_id' => $chatId,
            'phone_number' => $phone,
            'first_name' => $name,
        ];

        return $client->post('sendContact', ['json' => $json]);
    }

    public static function sendBigMessage($chatId, $message, $replyMarkup = [])
    {
        $messages = str_split($message, 4000);

        $res = [];
        $numItems = count($messages);
        $i = 0;

        foreach ($messages as $message) {
            if (++$i === $numItems) {
                $res[] = self::sendMessage($chatId, $message, $replyMarkup);
            } else {
                $res[] = self::sendMessage($chatId, $message);
            }
        }
        return print_r($res, true);
    }

    public static function getUpdates()
    {
        $client = self::getClient();
        return json_decode($client->get('getUpdates?offset=-1')->getBody());
    }

}
