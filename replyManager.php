<?php
function getReply($chat_id, $text) {
    $db = new SQLite3('replies.db');
    $stmt = $db->prepare("SELECT reply FROM replies WHERE message = :text COLLATE NOCASE");
    $stmt->bindValue(':text', $text, SQLITE3_TEXT);
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    return $row['reply'] ?? null;
}
?>
