<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$BOT_TOKEN = $_ENV['BOT_TOKEN'];
$ADMIN_ID = $_ENV['ADMIN_ID'];
$VIDEO_URL = $_ENV['VIDEO_URL'];

require 'replyManager.php';

$content = file_get_contents("php://input");
$update = json_decode($content, true);
if (!$update) exit;

$message = $update['message'] ?? $update['edited_message'] ?? null;
if (!$message) exit;

$chat_id = $message['chat']['id'];
$text = strtolower($message['text'] ?? '');

if (strpos($text, 'status') !== false || strpos($text, 'video') !== false) {
    sendVideo($chat_id, $VIDEO_URL);
} else {
    $reply = getReply($chat_id, $text);
    if (!$reply) {
        sendMessage($chat_id, "🤔 Hmm... kya kehna chahte ho?");
    } else {
        sendMessage($chat_id, $reply);
    }
}

function sendMessage($chat_id, $text) {
    global $BOT_TOKEN;
    $url = "https://api.telegram.org/bot$BOT_TOKEN/sendMessage";
    $post = ['chat_id' => $chat_id, 'text' => $text];
    file_get_contents($url . '?' . http_build_query($post));
}

function sendVideo($chat_id, $video_url) {
    global $BOT_TOKEN;
    $url = "https://api.telegram.org/bot$BOT_TOKEN/sendVideo";
    $post = ['chat_id' => $chat_id, 'video' => $video_url, 'caption' => '❤️ Avni ka status for you...'];
    file_get_contents($url . '?' . http_build_query($post));
}

// ✅ Very Important
http_response_code(200);
echo "OK";
?>
