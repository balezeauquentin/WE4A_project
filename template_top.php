<?php
session_start();
require_once ('assets/phptools/connection.php');
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

<body>
    <div class="container-fluid text-center">
        <div class="row pt-2">
            <div class="col-2 text-start ">
                <style>
                    .col-2 {
                        background-color: #f8f9fa;
                        border-radius: 1vh;
                        height: 100vh;
                    }
                </style>
                <a href="index.php">
                    <img class="rounded-circle mt-3 mx-auto d-block " width="40" height="40" src="assets/img/logo.png">
                </a>

                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link <?php if ($activePage == 'main')
                            echo 'active' ?>" aria-current="page">
                                <svg class="bi pe-none me-2" width="16" height="16">
                                    <use xlink:href="#home" />
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link <?php if ($activePage == 'follow')
                            echo 'active' ?>">
                                <svg class="bi pe-none me-2" width="16" height="16">
                                    <use xlink:href="#speedometer2" />
                                </svg>
                                Suivis
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link <?php if ($activePage == 'notifs')
                            echo 'active' ?>">
                                <svg class="bi pe-none me-2" width="16" height="16">
                                    <use xlink:href="#table" />
                                </svg>
                                Notifications
                            </a>
                        </li>
                    </ul>
                    <hr>

                </div> <!-- End of col-2 -->

                <div class="col-8">
                    <!-- The content should be here -->