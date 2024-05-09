<?php

require_once dirname(__FILE__) . '/databaseFunctions.php';
session_start_secure();

function getNotificationInfo($notif)
{
    global $db;
    $date = date_create_from_format('Y-m-d H:i:s', $notif['created_at']);
    if ($date === false) {
        throw new Exception("Failed to parse date: " . $notif['created_at']);
    }
    $formatted_date = $date->format('d/m/Y H:i');

    $notificationInfo = [
        'id' => $notif['id'],
        'user_id' => $notif['user_id'],
        'content' => $notif['content'],
        'created_at' => $formatted_date
    ];
    return $notificationInfo;
}
function parseNotificationContent($content)
{
    // The regular expression pattern to match @username
    $pattern = '/@(\w+)/';

    // The replacement pattern. \1 refers to the first capture group in the pattern, which is the username
    $replacement = '<a href="user.php?username=\1">\1</a>';

    // Perform the replacement and return the result
    $parsedContent = preg_replace($pattern, $replacement, $content);
    return $parsedContent;
}

function getNotifications($user_id)
{
    global $db;

    $query = $db->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
    $query->execute([$user_id]);
    $notifications = $query->fetchAll();
    if ($notifications) {
        foreach ($notifications as $notif) {
            $notif['content'] = validateSqlOutput($notif['content']);
            $notif['content']  = parseNotificationContent($notif['content']);
            $listNotif[] = getNotificationInfo($notif);
        }
        echo json_encode($listNotif);
    } else {
        echo json_encode(array('error' => true, 'message' => 'No posts found'));

    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['getNotifications']) {
        getNotifications($_GET['userId']);
    }
}