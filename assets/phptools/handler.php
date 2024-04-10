<?php
$action = $_GET['action'];

switch ($action) {
  case 'load_posts':
    $type = $_GET['type'];

    switch ($type) {
      case 'all':
        // Code to handle 'all' requests
        echo "all posts";
        break;
      case 'liked':
        // Code to handle 'liked' requests
        echo "tamer";
        break;
      case 'following':
        // Code to handle 'followers' requests
        echo "tonper";
        break;
      default:
        // Code to handle unknown requests
        break;
    }
    break;
  // Other cases for other actions
}
?>