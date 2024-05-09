<?php 
require_once dirname(__FILE__) . '/assets/phptools/databaseFunctions.php';
session_start_secure();
$pageTitle = 'Settings';

require_once dirname(__FILE__) . '/assets/phptools/template_top.php';
if (isset($_SESSION['id'])):
?>
<body data-settings-id="<?php echo $_SESSION['id']; ?>">
<div class="container">
    <h2 class="text-center">Update Your Information</h2>
    <form  id="setting-form" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address:</label>
            <input type="text" class="form-control" id="address" name="address" value>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="city" class="form-label">City:</label>
                <input type="text" class="form-control" id="city" name="city" value>
            </div>
            <div class="col-md-4 mb-3">
                <label for="zip_code" class="form-label">Zip Code:</label>
                <input type="text" class="form-control" id="zip_code" name="zip_code" value>
            </div>
            <div class="col-md-4 mb-3">
                <label for="country" class="form-label">Country:</label>
                <input type="text" class="form-control" id="country" name="country" value>
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">New password:</label>
            <input type="password" class="form-control" id="password" name="password" value>
        </div>
        <div class="mb-3">
            <label for="password-confirm" class="form-label">Confirm new password:</label>
            <input type="password" class="form-control" id="password-confirm" name="password-confirm" value>
        </div>
        <div class="mb-3">
            <label for="old-password" class="form-label">Old password:</label>
            <input type="password" class="form-control" id="old-password" name="old-password" value>
        </div>
        <div id="error-message" class="text-danger"></div>
        <div id="success-message" class="text-success"></div>
        </div>
        <button type="submit" class="btn btn-outline-secondary start-end">Confirm</button>
    </form>
</div>

<?php
endif;
if (!isset($_SESSION['id'])):
echo "You need to be Connected to access this page";
endif;
require_once dirname(__FILE__) . '/assets/phptools/template_bot.php';


?>