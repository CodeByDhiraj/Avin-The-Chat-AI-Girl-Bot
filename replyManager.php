<?php
$db = new SQLite3('replies.db');
$db->exec("CREATE TABLE IF NOT EXISTS replies (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    message TEXT NOT NULL,
    reply TEXT NOT NULL
)");

function getReply($user_id, $msg) {
    global $db;

    // Admin command check (optional)
    $adminId = getenv('ADMIN_ID');
    if ($user_id == $adminId && strpos($msg, '/admin') !== false) {
        return "👑 Hello Admin! Avni ready hai.";
    }

    // Reply matching
    $stmt = $db->prepare("SELECT reply FROM replies WHERE :msg LIKE '%' || message || '%' LIMIT 1");
    $stmt->bindValue(':msg', $msg, SQLITE3_TEXT);
    $res = $stmt->execute();
    $row = $res->fetchArray();

    return $row['reply'] ?? null;
}
?>
