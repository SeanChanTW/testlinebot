<?php // callback.php
define("LINE_MESSAGING_API_CHANNEL_SECRET", 'ea7439b0b67b0212b578b629f08fb657');
define("LINE_MESSAGING_API_CHANNEL_TOKEN", 'pNfdP3rvEB4sBKJgxCi6Xou6HBjTiXJQk2qwBqA76XAJ8NuVbygA3onwAO5N3bHSfllyc50DuUf9dqzkcq8EKnyfHc+ajUsprJK/jLzlVKczi5Ms4p3+H9jeTgS67qsjSM0AMokwA37m9mpZe460gdB04t89/10/w1cDnyilFU=');

require __DIR__."/../vendor/autoload.php";

$bot = new \LINE\LINEBot(
    new \LINE\LINEBot\HTTPClient\CurlHTTPClient(LINE_MESSAGING_API_CHANNEL_TOKEN),
    ['channelSecret' => LINE_MESSAGING_API_CHANNEL_SECRET]
);

$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$body = file_get_contents("php://input");

$events = $bot->parseEventRequest($body, $signature);

foreach ($events as $event) {
    if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
        $reply_token = $event->getReplyToken();
        $text = $event->getText();
        $bot->replyText($reply_token, $text);
    }
}

echo "OK";