<?php
    if (!isset($_SESSION)) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title> Spitalul "RdS"
    </title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!-- <link href="jumbotron.css" rel="stylesheet"> -->
  </head>
  <body style="background-image: linear-gradient(to bottom right,#00B4DB 0%, #0083B0 100%);">
      <div class="container" style="padding-top: 10px;">
        <nav class="navbar navbar-static-top">
          <a href="index.php" class="navbar-brand" style="color:black">🌅 Spitalul "Raza de Soare"</a>
            <ul class="nav nav-pills">
              <li class="nav-item">
                <a href="https://goo.gl/maps/jZKSMZBfw5D2" target="_blank" style="color:black"> Adresa spital: Facultatea de Informatica, Iasi</a>
              </li>
              <li class="nav-item">
                <a style="color:black" href="">Numar ambulanta: +04 43286739</a>
              </li>
              <?php
                if (isset($_SESSION['username'])) {
                    echo '<a href="logout.php" style="align-items: right;"> <button class="btn btn-danger" >Logout
                  </button></a>';
                }
              ?>
            </ul>
        </nav>
        </div>
