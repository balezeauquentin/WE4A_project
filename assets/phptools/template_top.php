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
    <script src="/WE4A_project/assets/js/jquery-3.7.1.min.js" defer></script>
    <script src="/WE4A_project/assets/js/template.js" defer></script>
</head>

<body>
    <div class="container-fluid">
        <!-- Container principal -->

        <div class="row">
            <div class="col-1"></div>
            <!-- Row contenant 2 colonnes (sidebar | navbar+main) -->
            <div class="col-2 p-0 vh-100 sticky-top">
                <!-- Sidebar -->
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light h-100">
                    <a href="/WE4A_project/index.php">
                        <img class="rounded-circle mt-3 mx-auto d-block " width="40" height="40"
                            src="assets/img/logo.png">
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php if ($pageTitle === "Home") echo "active"; ?>" href="/WE4A_project/index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($pageTitle === "Notifications") echo "active"; ?>" href="/WE4A_project/notifications.php">Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($pageTitle === "Messages") echo "active"; ?>" href="/WE4A_project/message.php">Messages</a>
                        </li>
                        <?php
                        unset ($_SESSION['id']);
                        if (isset($_SESSION['id'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/WE4A_project/profile.php?username=<?php echo "test" ?>"><i
                                        class="bi bi-person-fill"></i>Profil</a>
                            </li>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalPost">
                                Poster
                            </button>
                        <?php endif; ?>
                    </ul>
                    <hr>
                    
                    <?php
                    if (isset($_SESSION['id'])): ?>
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                                id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="img_user/avatar/<?php echo $_SESSION['avatar']; ?>" alt="" width="48" height="48"
                                    class="rounded-circle me-3">
                                <strong><?php echo $_SESSION['username'];?></strong>
                            </a>
                            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                                <li><a class="dropdown-item" href="#">Paramètres</a></li>
                                <li><a class="dropdown-item" href="#">Support</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <img src="img/avatar/utilisateur.png" alt="" width="32" height="32"
                                    class="rounded-circle me-3">
                                <li><a id="logout-button" class="dropdown-item" href="#">Se déconnecter</a></li>
                                
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
                                    <label for="username" class="form-label">Username</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password-l" name="password"
                                        placeholder="" required />
                                    <label for="password" class="form-label">Password</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="" id="showpassword"
                                        onchange="TogglePassword(this.checked)">
                                    <label class="form-check-label" for="showpassword">
                                        Show password
                                    </label>
                                </div>
                                <div id="error-message" class="text-danger"></div>
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
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="Username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="sername" name="username-r">
                                    </div>
                                    <div class="col">
                                        <label for="mail" class="form-label">E-mail</label>
                                        <input type="text" class="form-control" id="mail" name="mail-r">
                                        <div class="form-text">An email will be sent.</div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="password" class="form-label">Password</label>
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
                                <hr>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="day" class="form-label">Day</label>
                                        <input type="text" class="form-control" id="birthdate" name="day-r">
                                    </div>
                                    <div class="col">
                                        <label for="day" class="form-label">Month</label>
                                        <select class="form-control" id="month" name="month-r">
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
                                        <label for="year" class="form-label">Year</label>
                                        <input type="text" class="form-control" id="year" name="year-r">
                                    </div>

                                </div>
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
                                    <div class="col-12 d-flex justify-content-center align-items-center">
                                        <div class="g-recaptcha"
                                            data-sitekey="6LeClLIpAAAAAIt1EesWjZ_TEuMne4QRk-TTuBQ2"></div>
                                    </div>
                                </div>
                                <div id="error-message-r" class="text-danger"></div>
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
            <div class="col-6 p-0">