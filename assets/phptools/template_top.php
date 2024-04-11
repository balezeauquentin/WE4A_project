<?php
session_start();
require_once ('connection.php');
$activePage = 'main';
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
    <script src="assets/js/jquery-3.7.1.min.js" defer></script>
    <script src="assets/js/main_page.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body style="overflow: hidden;">
    <div class="container-fluid">
        <!-- Container principal -->
        <div class="row">
            <!-- Row contenant 2 colonnes (sidebar | navbar+main) -->
            <div class="col-2 p-0 vh-100">
                <!-- Sidebar -->
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light h-100">
                <a href="/index.php">
                    <img class="rounded-circle mt-3 mx-auto d-block " width="40" height="40" src="/assets/img/logo.png">
                </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        
                    </ul>
                    <hr>
                    <?php if(isset($_SESSION['id'])): ?>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                            id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="img/avatar/<?php echo $_SESSION['avatar']; ?>" alt="" width="32" height="32" class="rounded-circle me-3">
                            <strong><?php echo $_SESSION['pseudo']; ?></strong>
                        </a>
                        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                            <li><a class="dropdown-item" href="#">Paramètres</a></li>
                            <li><a class="dropdown-item" href="#">Support</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a id="logout-button" class="dropdown-item" href="#">Se déconnecter</a></li>       
                        </ul>
                    </div>
                    <?php else: ?>
                    <a href="#" class="d-flex align-items-center link-dark text-decoration-none" data-bs-toggle='modal' data-bs-target='#modalLogin'>
                        <img src="img/avatar/utilisateur.png" alt="" width="32" height="32" class="rounded-circle me-3">
                        <strong>Se connecter</strong>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
                <!-- Modal - Se connecter -->
                <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLoginLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form id="formLoginId" class="formLogin" method="POST" action="">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLoginLabel">Se connecter</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="username" name="user" placeholder="" required/>
                                        <label for="username" class="form-label">Adresse Mail</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="" required/>
                                        <label for="password" class="form-label">Mot de passe</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="" id="showpassword" onchange="TogglePassword(this.checked)">
                                        <label class="form-check-label" for="showpassword">
                                            Montrer le mot de passe
                                        </label>
                                    </div>
                                    <div id="error-message" class="text-danger"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle='modal' data-bs-target='#modalRegister'>S'inscrire</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>                                
                                    <input type="submit" class="btn btn-primary" name="formLogin" value="Valider"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal - S'inscrire -->
                <div class="modal fade" id="modalRegister" tabindex="-1" role="dialog" aria-labelledby="modalRegisterLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form enctype="multipart/form-data" id="formRegisterId" class="formRegister" method="POST" action="">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalRegisterLabel">S'inscrire</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="mail" class="form-label">Adresse email</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="mail" name="mail1-r">
                                            <span class="input-group-text">@</span>
                                            <input type="text" class="form-control" name="mail2-r">
                                        </div>
                                        <div class="form-text">Utiliser une adresse email valide uniquement. Un mail de vérification vous sera envoyé.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Mot de passe</label>
                                        <input type="password" class="form-control" id="password-r" name="password-r">
                                        <div class="form-text">
                                            Les caractéristiques minimales pour un mot de passe sont :
                                            <ul>
                                                <li>12 caractères</li>
                                                <li>1 majuscule</li>
                                                <li>1 chiffre</li>
                                                <li>1 caractère spécial</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label for="password-r-repeat" class="form-label">Répéter le mot de passe</label>
                                        <input type="password" class="form-control" id="password-r-repeat" name="password2-r">
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="" id="showpassword-r" onchange="TogglePasswordRegister(this.checked)">
                                        <label class="form-check-label" for="showpassword">
                                            Montrer le mot de passe
                                        </label>
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <label for="pseudo" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="pseudo" name="pseudo-r">
                                    </div>
                                    <hr>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="firstname" class="form-label">Prénom</label>
                                            <input type="text" class="form-control" id="firstname" name="firstname-r">
                                        </div>
                                        <div class="col">
                                            <label for="name" class="form-label">Nom</label>
                                            <input type="text" class="form-control" id="name" name="name-r">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="birthdate" class="form-label">Date de naissance</label>
                                        <input type="date" class="form-control" id="birthdate" name="birthdate-r">
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="inputAddress" class="form-label">Adresse</label>
                                            <input type="text" class="form-control" id="inputAddress" name="address-r">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputCity" class="form-label">Ville</label>
                                            <input type="text" class="form-control" id="inputCity" name="city-r">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputZip" class="form-label">Code Postal</label>
                                            <input type="text" class="form-control" id="inputZip" name="zipcode-r">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="inputCountry" class="form-label">Pays</label>
                                            <input type="text" class="form-control" id="inputCountry" name="country-r">
                                        </div>
                                        <div class="col-12 d-flex justify-content-center align-items-center">
                                            <div class="g-recaptcha" data-sitekey="6LeClLIpAAAAAIt1EesWjZ_TEuMne4QRk-TTuBQ2"></div>
                                        </div>
                                    </div>
                                    <div id="error-message-r" class="text-danger text-align-center"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle='modal' data-bs-target='#modalLogin'>Se connecter</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>                                
                                    <input type="submit" class="btn btn-primary" name="formRegister" value="Valider"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                