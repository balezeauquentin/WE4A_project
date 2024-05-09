<?php
require_once dirname(__FILE__) . '/databaseFunctions.php';
session_start_secure();

?>


<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/img/favicon/android-icon-192x192.png">
    <title>Z - <?php echo $pageTitle; ?></title>
    <link rel="icon" type="image/png" sizes="192x192" href="assets/img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"
        defer>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"
        defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/WE4A_project/assets/css/style.css">
    <script src="/WE4A_project/assets/js/jquery-3.7.1.min.js" defer></script>
    <script src="/WE4A_project/assets/js/template.js" defer></script>
    
    <?php 
    if (isset($_GET['username'])){
        $username = $_GET['username'];
    } else {
        $username = null;
    }
    if ($pageTitle == $username): ?>
    <script src="/WE4A_project/assets/js/profile.js" defer></script>
    <script src="/WE4A_project/assets/js/follow.js" defer></script>
    <?php endif;
    if ($pageTitle === "Home" || $pageTitle == $username): ?>
    <script src="/WE4A_project/assets/js/postmanager.js" defer></script>
    <?php endif;
    if ($pageTitle === "Settings"): ?>
    <script src="/WE4A_project/assets/js/updatesettings.js" defer></script>
    <?php endif; 
    if ($pageTitle === "Notifications") :?>
    <script src="/WE4A_project/assets/js/notificationManager.js" defer></script>
    <?php endif; ?>

</head>

<body>
    <div class="container-fluid">
        <!-- Container principal -->

        <div class="row">
            <div class="col-1"></div>
            <!-- Row contenant 2 colonnes (sidebar | navbar+main) -->
            <div class="col-2 p-0 vh-100">
                <!-- Sidebar -->
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light h-100">
                    <a href="/WE4A_project/index.php">
                        <img class="rounded-circle mt-3 mx-auto d-block " width="40" height="40"
                            src="assets/img/logo.png">
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item mb-2">
                            <a class="nav-link <?php if ($pageTitle === "Home")
                                echo "active"; ?>"
                                href="/WE4A_project/index.php"><i class="bi bi-house"></i> Home</a>
                        </li>
                        <?php
                        if (isset($_SESSION['id'])): ?>
                        <li class="nav-item mb-2">
                            <a class="nav-link <?php if ($pageTitle === "Notifications")
                                echo "active"; ?>"
                                href="/WE4A_project/notifications.php"><i class="bi bi-bell"></i> Notifications <span class="badge bg-danger" id="notification-badge"></span></a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link <?php if ($pageTitle === "Messages")
                                echo "active"; ?>"
                                href="/WE4A_project/messages.php"><i class="bi bi-chat-left-text"></i> Messages</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link <?php if($pageTitle === $_SESSION['username']) echo "active" ?>"
                                    href="/WE4A_project/profile.php?username=<?php echo $_SESSION['username'] ?>"><i
                                        class="bi bi-person"></i> Profil</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link <?php if ($pageTitle === "Statistics")
                                echo "active"; ?>"
                                href="/WE4A_project/statistics.php"><i class="bi bi-bar-chart"></i> Statistcs</a>
                        </li>
                        <?php if($_SESSION['admin'] === 1): ?>
                        <li class="nav-item mb-4">
                            <a class="nav-link <?php if ($pageTitle === "Admin")
                                echo "active"; ?>"
                                href="/WE4A_project/statistics.php"><i class="bi bi-person-gear"></i> Admin</a>
                        </li>
                        <?php endif; ?>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalPost">
                                Send a Z
                            </button>
                        <?php endif; ?>
                    </ul>
                    <hr>

                    <?php
                    if (isset($_SESSION['id'])): ?>
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                                id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class='ms-2 me-2' style='width: 45px; height: 45px; '>
                                    <img src='<?php echo  $_SESSION['profile_picture_path']; ?>' alt='' class="rounded"
                                        style='height:100%; width:100%; object-fit: cover;'>
                                </div>
                                <strong class="fs-5"><?php echo $_SESSION['username']; ?></strong>
                            </a>
                            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                                <li><a class="dropdown-item" href="/WE4A_project/settings.php">Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a id="logout-button" class="dropdown-item" href="#">Logout</a></li>

                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="#" class="d-flex text-align-center link-dark text-decoration-none" data-bs-toggle='modal'
                            data-bs-target='#modalLogin'>
                            <strong>Se connecter</strong>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Modal - Poster -->
            <!-- Modal -->
            <div class="modal fade" id="modalPost" tabindex="-1" role="dialog" aria-labelledby="modalPostLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="formPostId" class="formPost" method="POST" action="">
                            <div class="modal-header border-bottom-0">
                                <h5 class="modal-title" id="modalPostLabel">Nouveau post</h5>
                            </div>
                            <div class="modal-body">
                                <textarea id="textAreaPostId" name="textAreaPostId" class="form-control" placeholder=""
                                    required style="resize: none; height:30vh"></textarea>
                            </div>
                            <div class="modal-footer border-top-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <input type="submit" class="btn btn-primary" name="postSubmit"
                                    value="Publier le post" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal - Se connecter -->
            <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLoginLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="formLoginId" class="formLogin" method="POST" action="">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLoginLabel">Se connecter</h5>
                            </div>
                            <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="username-l" name="user" placeholder=""
                                        required />
                                    <label for="username-l" class="form-label">Username</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password-l" name="password"
                                        placeholder="" required />
                                    <label for="password-l" class="form-label">Password</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="" id="showpassword"
                                        onchange="TogglePassword(this.checked)">
                                    <label class="form-check-label" for="showpassword">
                                        Show password
                                    </label>
                                </div>
                                <div id="error-message" class="text-danger"></div>
                                <div id="success-message" class="text-success"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                    data-bs-toggle='modal' data-bs-target='#modalRegister'>S'inscrire</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <input type="submit" class="btn btn-primary" name="formLogin" value="Valider" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal - S'inscrire -->
            <div class="modal fade" id="modalRegister" tabindex="-1" role="dialog" aria-labelledby="modalRegisterLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form enctype="multipart/form-data" id="formRegisterId" class="formRegister" method="POST"
                            action="">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalRegisterLabel">S'inscrire</h5>
                            </div>
                            <div class="modal-body">
                                    <div class="">
                                        <label for="username-r" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username-r" name="username-r">
                                    </div>
                                    <div class="">
                                        <label for="mail" class="form-label">E-mail</label>
                                        <input type="text" class="form-control" id="mail" name="mail-r">
                                        <div class="form-text"></div>
                                    </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="password-r" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password-r" name="password-r">
                                    </div>
                                    <div class="col">
                                        <label for="password-r-repeat" class="form-label">Confirm password</label>
                                        <input type="password" class="form-control" id="password-r-repeat"
                                            name="password2-r">
                                    </div>
                                </div>
                                <div class="form-check ">
                                    <input class="form-check-input" type="checkbox" value="" id="showpassword-r"
                                        onchange="TogglePasswordRegister(this.checked)">
                                    <label class="form-check-label" for="showpassword">
                                        Show password
                                    </label>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="firstname" class="form-label">First name</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname-r">
                                    </div>
                                    <div class="col">
                                        <label for="name" class="form-label">Last name</label>
                                        <input type="text" class="form-control" id="name" name="name-r">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="day-r" class="form-label">Day</label>
                                        <input type="text" class="form-control" id="day-r" name="day-r">
                                    </div>
                                    <div class="col">
                                        <label for="month-r" class="form-label">Month</label>
                                        <select class="form-control" id="month-r" name="month-r">
                                            <option value=""> </option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="year-r" class="form-label">Year</label>
                                        <input type="text" class="form-control" id="year-r" name="year-r">
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="inputAddress" name="address-r">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputCity" class="form-label">City</label>
                                        <input type="text" class="form-control" id="inputCity" name="city-r">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputZip" class="form-label">ZIP code</label>
                                        <input type="text" class="form-control" id="inputZip" name="zipcode-r">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputCountry" class="form-label">Country</label>
                                        <input type="text" class="form-control" id="inputCountry" name="country-r">
                                    </div>
                                </div>
                                <div id="error-message-r" class="text-danger"></div>
                                <div id="success-message-r" class="text-success"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                    data-bs-toggle='modal' data-bs-target='#modalLogin'>Se connecter</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <input type="submit" class="btn btn-primary" name="formRegister" value="Valider" />
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="col-6 p-0 vh-100 overflow-auto">