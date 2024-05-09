<?php
require_once dirname(__FILE__) . '/assets/phptools/databaseFunctions.php';
session_start_secure();

$pageTitle = 'Notifications';

require_once dirname(__FILE__) . '/assets/phptools/template_top.php';


?>

<body data-user-id="<?php echo $_SESSION['id'] ?>"></body>
<div class="mt-5 mb-5 pb-5">

</div>
<table class="table">
    <thead>
      <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody id="notif-container">

    </tbody>
    </table>

<?php
require_once dirname(__FILE__) . '/assets/phptools/template_bot.php';
