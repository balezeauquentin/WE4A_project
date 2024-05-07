<?php

$pageTitle = $_GET['username'];

require_once dirname(__FILE__) . '/assets/phptools/template_top.php';
require_once dirname(__FILE__) . '/assets/phptools/profileTools.php';
require_once dirname(__FILE__) . '/assets/phptools/postmanager.php';

$profile_data = getProfileData($_GET['username']);

// if (isset($_POST['profile_change'])) {
//     updateProfile($profile_data['username'], $_FILES['profile_picture'], $_FILES['banner'], $_POST['bio'], $profile_data['profile_picture_path'], $profile_data['banner_path']);
// }


?>

<style>
    body {
        font-size: 17px;
    }
</style>
<body data-profile-id="<?php echo $profile_data['id']; ?>">
<body data-profile-username="<?php echo $profile_data['username']; ?>"></body>
<div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="">
            <div class="border">
                <div class="" id="profile-container">
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
                    <div class='' style='width: 120px; height: 120px; margin-top:130px; margin-left:30px;'>
                        <img src='<?php echo $profile_picture_path; ?>'class='rounded'
                            style='height:100%; width:100%; object-fit: cover;'>
                    </div>
                </div>
            </div>
            <?php
            if (!empty($profile_data['username'])) {
                if (isset($_SESSION['username']) && $_SESSION['username'] === $profile_data['username']) {
                    echo "<button type='button' class='mt-2 me-2 btn btn-outline-dark float-end ' data-mdb-ripple-color='dark' data-bs-toggle='modal' 
                        data-bs-target='#editProfileModal'>
                        Edit profile
                    </button>";
                } else if (!isset($_SESSION['id'])){
                    echo "<button type='button' class='mt-2 me-2 btn btn-outline-dark float-end ' data-mdb-ripple-color='dark' data-bs-toggle='modal'
                    data-bs-target='#modalLogin'>
                        Follow
                    </button>";
                } else {
                    echo "<button type='button' class='mt-2 me-2 btn btn-outline-dark float-end ' data-mdb-ripple-color='dark' id='follow'>
                        Follow
                    </button>";
                }
            }
            ?>
            <div class='ms-3'>
                <div class="mb-2" style="margin-top: 55px;">
                    <?php
                    if (!empty($profile_data) && is_array($profile_data)) {
                        if (isset($profile_data['username'])) {
                            echo "<h2 class='bold' id='username'>" . $profile_data['username'] . "</h2>"; // Display username in an H1 tag
                        }
                    } else {
                        echo "<h2 class='bold mt-3'>This user doesn't exist.</h2>";
                    }
                    ?>
                </div>
                <?php
                if (!empty($profile_data) && is_array($profile_data)) {
                    echo $profile_data['bio'];
                }
                ?>
                <?php
                if (!empty($profile_data) && is_array($profile_data)) :
                    $birthdate = isset($profile_data['birthdate']) ? $profile_data['birthdate'] : '';
                    $registration_date = isset($profile_data['registration_date']) ? $profile_data['registration_date'] : '';
                ?>
                    <div class='mt-2'>
                        <i class='bi bi-cake'></i> Born <?php echo $birthdate; ?>
                        <i class='ms-2 bi bi-balloon'></i> Joined <?php echo $registration_date; ?>
                    </div>
                <?php
                endif;
                ?>
                <?php
                if (!empty($profile_data) && is_array($profile_data)) {
                    $followers = isset($profile_data['followers']) ? $profile_data['followers'] : 0;
                    $following = isset($profile_data['following']) ? $profile_data['following'] : 0;
                }
                ?>
                <div class='mt-3 mb-4'>
                    <i></i> <?php echo $followers; ?> followers 
                    <i class="ms-2"></i> <?php echo $following; ?> following 
                </div>
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
                <form method="post" id="setting-form"
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
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control" id="bio"
                            name="bio"><?php echo $profile_data['bio']; ?></textarea>
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