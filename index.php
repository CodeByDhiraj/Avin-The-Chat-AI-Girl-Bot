<?php
// Enable all error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Load DB and logic
require_once 'replyManager.php';

// Get Telegram data
$content = file_get_contents("php://input");
$update = json_decode($content, true);
if (!$update) exit;

$message = $update['message'] ?? $update['edited_message'] ?? null;
if (!$message) exit;

$chat_id = $message['chat']['id'];
$text = strtolower(trim($message['text'] ?? ''));

// Check message
if ($text === "status" || $text === "video") {
    sendVideo($chat_id, 'https://knullmods.site/avni/media/status1.mp4');
} else {
    $reply = getReply($chat_id, $text);
    sendMessage($chat_id, $reply ?: "🥺 Avni ko samajh nahi aaya baby...");
}

// Function to send text
function sendMessage($chat_id, $text) {
    $token = getenv("BOT_TOKEN");
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
        'chat_id' => $chat_id,
        'text' => $text
    ]));
}

// Function to send video
function sendVideo($chat_id, $video_url) {
    $token = getenv("BOT_TOKEN");
    file_get_contents("https://api.telegram.org/bot$token/sendVideo?" . http_build_query([
        'chat_id' => $chat_id,
        'video' => $video_url,
        'caption' => "❤️ Avni ka status 🥰"
    ]));
}
?>
