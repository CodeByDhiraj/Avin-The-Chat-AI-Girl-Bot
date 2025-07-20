<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'replyManager.php';

$content = file_get_contents("php://input");
$update = json_decode($content, true);
if (!$update) exit;

$message = $update['message'] ?? $update['edited_message'] ?? null;
if (!$message) exit;

$chat_id = $message['chat']['id'];
$text = strtolower($message['text'] ?? '');

if (strpos($text, 'status') !== false || strpos($text, 'video') !== false) {
    sendVideo($chat_id, 'https://knullmods.site/avni/media/status1.mp4');
} else {
    $reply = getReply($chat_id, $text);
    if (!$reply) {
        sendMessage($chat_id, "🤔 Hmm... kya kehna chahte ho?");
    } else {
        sendMessage($chat_id, $reply);
    }
}

function sendMessage($chat_id, $text) {
    $url = "https://api.telegram.org/bot" . getenv('BOT_TOKEN') . "/sendMessage";
    $post = ['chat_id' => $chat_id, 'text' => $text];
    file_get_contents($url . '?' . http_build_query($post));
}

function sendVideo($chat_id, $video_url) {
    $url = "https://api.telegram.org/bot" . getenv('BOT_TOKEN') . "/sendVideo";
    $post = [
        'chat_id' => $chat_id,
        'video' => $video_url,
        'caption' => '❤️ Avni ka status for you...'
    ];
    file_get_contents($url . '?' . http_build_query($post));
}
?>
