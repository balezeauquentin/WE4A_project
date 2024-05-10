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
        'type' => $notif['type'],
        'is_read' => $notif['is_read'],
        'created_at' => $formatted_date
    ];
    return $notificationInfo;
}
function parseNotificationContent($content)
{
    // The regular expression pattern to match @username
    $pattern = '/@(\w+)/';

    // The replacement pattern. \1 refers to the first capture group in the pattern, which is the username
    $replacement = '<a href="profile.php?username=\1">\1</a>';

    // Perform the replacement and return the result
    $parsedContent = preg_replace($pattern, $replacement, $content);

     // The regular expression pattern to match #postID
     $patternPostID = '/#(\w+)/';
     // The replacement pattern. \1 refers to the first capture group in the pattern, which is the postID
     $replacementPostID = '<a href="posts.php?id=\1">\1</a>';
     // Perform the replacement and return the result
     $parsedContent = preg_replace($patternPostID, $replacementPostID, $parsedContent);
     
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

            $query = $db->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
            $query->execute([$notif['id']]);
        }
        echo json_encode($listNotif);
    } else {
        echo json_encode(array('error' => true, 'message' => 'No posts found'));
    }
}

function getUnreadNotifications ($userId) {
    global $db;

    $query = $db->prepare("SELECT * FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC");
    $query->execute([$userId]);
    $notifications = $query->rowCount();

    echo json_encode($notifications);
}

function createNotification($content, $type, $userId)
{
    global $db;

    $query = $db->prepare("INSERT INTO notifications (content, type, user_id) VALUES (?, ?, ?)");
    $query->execute([$content, $type, $userId]);
}

function deleteNotification($id_notification)
{
    global $db;

    $query = $db->prepare("DELETE FROM notifications WHERE id = ?");
    $query->execute([$id_notification]);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['getNotifications'])) {
        getNotifications($_GET['userId']);
    } else if (isset($_GET['getUnreadNotifications'])) {
        getUnreadNotifications($_GET['userId']);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['createNotification'])) {
        $content = $_POST['content'];
        $type = $_POST['type'];
        $userId = $_POST['userId'];
        
        createNotification($content, $type, $userId);
    } else if (isset($_POST['deleteNotification'])) {
        $id_notification = $_POST['id_notification'];
        deleteNotification($id_notification);
    }
}

