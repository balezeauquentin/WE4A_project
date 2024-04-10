<?php
session_start();
require_once ("assets/phptools/connection.php");
require_once ("assets/phptools/databaseFunctions.php");

$_GET['usename']; // For testing purposes
// Assuming $bdd is your PDO instance and $_GET['id'] is the id of the user you want to fetch
$profile_data = getProfileData($bdd, $_GET['username']);

if (isset($_POST['profile_change'])) {
    if(verifPassword($_POST['password'], $_POST['confirmpassword'])==0){
        updateProfile($bdd, $profile_data['username'], $_POST['email'], $_POST['profile_picture'], $_POST['banner'], $_POST['bio'], $_POST['password']);
    } else {
        echo "Passwords do not match.";
    }
}
?>



<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
    <link rel="icon" type="image/png" sizes="192x192" href="assets/img/favicon/android-icon-192x192.png">
    <!-- start bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- end bootstrap -->
</head>

<body>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 col-xl-7">
                <div class="border">
                    <?php
                    echo "<div class='text-white d-flex flex-row' style='background: url(\"data:image/jpeg;base64," . base64_encode($profile_data['banner']) . "\") no-repeat center center / cover; height:200px;'>";
                    ?>
                    <?php
                    echo "<div class='rounded' style='width: 120px; height: 120px; overflow: hidden; margin-top:120px; margin-left:30px'>";
                    echo "<img src='data:image/jpeg;base64," . base64_encode($profile_data['profile_picture']) . "' alt='Profile picture' style='height:100%; width:100%; object-fit: cover; z-index: 1'>";
                    echo "</div>";
                    ?>
                </div>
                <?php
                $_SESSION['username'] = $profile_data['username'];
                if (isset($_SESSION['username']) && $_SESSION['username'] == $profile_data['username']) {
                    echo "<button type='button' class='mt-2 btn btn-outline-dark float-end me-2' data-mdb-ripple-color='dark' data-bs-toggle='modal' 
                        data-bs-target='#editProfileModal' style='z-index: 1;'>
                        Edit profile
                    </button>";
                }
                ?>
                <div class="ms-3 mb-3" style="margin-top: 55px;">
                    <?php
                    if (isset($profile_data['username'])) {
                        echo "<h2>" . $profile_data['username'] . "</h2>"; // Display username in an H1 tag
                    }
                    ?>
                    <div>
                        <i class="bi bi-cake"></i> Born <?php if (isset($profile_data['birthdate'])) {
                            echo $profile_data['birthdate'] . ".   ";
                        } ?>
                        <i class="bi bi-balloon"></i> Joined <?php if (isset($profile_data['registration_date'])) {
                            echo $profile_data['registration_date'] . ".";
                        } ?>
                    </div>
                    Bio:
                    <?php echo $profile_data['bio']; ?>
                </div>
                <div class="border-top mt-2 pt-2">
                    <?php
                    $posts = getPostsByUser($bdd, $profile_data['username']);
                    if ($posts) {
                        foreach ($posts as $post) {
                            echo "<div class='d-flex border-bottom'>";
                            echo "<div>";
                            echo "<a href='https://z.balezeau.fr/profile.php?username=" . $post['username'] . "'><img src='assets/img/profile.jpg' class='rounded-1 mt-1 ms-2' style='width: 40px;'></a>";
                            echo "</div>";
                            echo "<a href='https://z.balezeau.fr/profile.php?post=" . $post['id'] . "'>";
                            echo "<div class='ms-2 mb-2'>";
                            echo "<a href='https://z.balezeau.fr/profile.php?username=" . $post['username'] . "' class='link-dark link-offset-1 link-offset-1-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover'><strong>" . $profile_data['username'] . "</strong></a><br>";
                            echo $post['content'];
                            echo "</div>";
                            echo "</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>This user hasn't posted yet.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="profile_picture" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                        </div>
                        <div class="mb-3">
                            <label for="banner" class="form-label">Banner</label>
                            <input type="file" class="form-control" id="banner" name="banner">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo $profile_data['email']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control" id="bio" name="bio"
                                value="<?php echo $profile_data['bio']; ?>"></textarea>
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
                            <button type="button" class="btn btn-secondary"  data-mdb-ripple-color='dark' data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="profile_change" class='btn btn-outline-dark float-end me-2' data-mdb-ripple-color='dark'>Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</body>

</html>