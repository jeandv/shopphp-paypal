<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peropaquepo</title>
    <link rel="icon" href="./assets/img/logo.png">
    <link rel="stylesheet" href="assets\style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body style="background-color: #000; position: relative; min-height: 100vh;">
<header class="fixed-top" style="backdrop-filter: blur(5px); background-color: #00000059;">
    <nav class="navbar navbar-expand-lg navbar-light d-flex justify-content-around">
            <a class="navbar-brand text-light" href="index.php"><img src="./assets/img/logo.png" class="logoImg" alt="Logo de peropaquepo" style="    width: 135px;
    transform: scale(1.5);
"></a>
            <!-- <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse">
                <span class="navbar-toggler-icon"></span>
            </button> -->
        <div id="my-nav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link text-light" href="index.php">HOME</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link text-light" href="mostrar-carrito.php">
                            <span class="material-symbols-outlined">shopping_cart</span> 
                            (<?php
                                echo (empty($_SESSION['carrito']))?0:count($_SESSION['carrito']);
                            ?>)
                        </a>
                    </li>
                </ul>
        </div>
    </nav>
</header>
    </br>
    </br>
    <div class="container" style="
    margin: 75px auto 0 auto;
    ">