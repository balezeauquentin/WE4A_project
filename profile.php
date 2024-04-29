<?php

$pageTitle = $_GET['username'];

require_once dirname(__FILE__) . '/assets/phptools/template_top.php';
require_once dirname(__FILE__) . '/assets/phptools/profileTools.php';
require_once dirname(__FILE__) . '/assets/phptools/postmanager.php';

// Assuming $bdd is your PDO instance and $_GET['id'] is the id of the user you want to fetch
$profile_data = getProfileData($db, $_GET['username']);

if (isset($_POST['profile_change'])) {
    if (verifPassword($_POST['password'], $_POST['confirmpassword']) == 0) {
        updateProfile($db, $profile_data['username'], $_POST['email'], $_FILES['profile_picture'], $_FILES['banner'], $_POST['bio'], $_POST['password'], $profile_data['profile_picture_path'], $profile_data['banner_path']);
    } else {
        echo "Passwords do not match.";
    }
}


?>

<style>
    body {
        font-size: 17px;
    }
</style>

<div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="">
            <div class="border">
                <?php
                // Check if $profile_data is not empty and is an array
                if (!empty($profile_data) && is_array($profile_data)) {
                    // Determine banner path
                    $banner_path = !empty($profile_data['banner_path']) ? $profile_data['banner_path'] : 'user_img/0/banner.jpeg';
                    // Determine profile picture path
                    $profile_picture_path = !empty($profile_data['profile_picture_path']) ? $profile_data['profile_picture_path'] : 'user_img/0/pp.png';
                } else {
                    // Default paths if $profile_data is empty or not an array
                    $banner_path = 'user_img/0/banner.jpeg';
                    $profile_picture_path = 'user_img/0/pp.png';
                }
                ?>
                <div class='text-white d-flex flex-row'
                    style='background: url(<?php echo $banner_path; ?>) no-repeat center center / cover; height:200px;'>
                    <div class='rounded' style='width: 120px; height: 120px; margin-top:125px; margin-left:30px;'>
                        <img src='<?php echo $profile_picture_path; ?>' alt='Profile Picture'
                            style='height:100%; width:100%; object-fit: cover;'>
                    </div>
            </div>
            <?php
            $_SESSION['username'] = $profile_data['username'];  
            if (!empty($profile_data['username'])) {
                if (isset($_SESSION['username']) && $_SESSION['username'] === $profile_data['username']) {
                    echo "<button type='button' class='mt-2 btn btn-outline-dark float-end me-2' data-mdb-ripple-color='dark' data-bs-toggle='modal' 
                        data-bs-target='#editProfileModal'>
                        Edit profile
                    </button>";
                }
            }
            ?>
            <div class='ms-3'>
                <div class="mb-2" style="margin-top: 55px;">
                    <?php
                    if (!empty($profile_data) && is_array($profile_data)) {
                        if (isset($profile_data['username'])) {
                            echo "<h2 class='bold'>" . $profile_data['username'] . "</h2>"; // Display username in an H1 tag
                        }
                    } else {
                        echo "<h2 class='bold'>This user doesn't exist.</h2>";
                    }
                    ?>
                </div>
                <?php
                if (!empty($profile_data) && is_array($profile_data)) {
                    echo $profile_data['bio'];
                }
                ?>
                <?php
                if (!empty($profile_data) && is_array($profile_data)) {
                    echo "
                    <div class='mt-2'>
                        <i class='bi bi-cake'></i> Born";
                    if (isset($profile_data['birthdate'])) {
                        echo $profile_data['birthdate'];
                    }
                    echo "<i class='bi bi-balloon'></i> Joined";
                    if (isset($profile_data['registration_date'])) {
                        echo $profile_data['registration_date'];
                    }
                    echo "</div>";
                }
                ?>
            </div>
            <div id="posts-container">
                <!--TODO: get posts by user-->
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="profile.php?username=<?php echo $profile_data['username'];?>"
                    enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture"
                            accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="banner" class="form-label">Banner</label>
                        <input type="file" class="form-control" id="banner" name="banner" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?php echo $profile_data['email']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control" id="bio"
                            name="bio"><?php echo $profile_data['bio']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Change password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="confirmpassword" class="form-label">Confirm password</label>
                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-ripple-color='dark'
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="profile_change" class='btn btn-outline-dark float-end me-2'
                            data-mdb-ripple-color='dark'>Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require 'assets/phptools/template_bot.php'; ?>