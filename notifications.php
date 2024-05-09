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


<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Delete</h5>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this notification?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>
<?php
require_once dirname(__FILE__) . '/assets/phptools/template_bot.php';
