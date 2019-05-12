<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <title><?= $title ?></title>
    <link href="public/css/style.css" rel="stylesheet"/>
  </head>
  <body class="blue-grey lighten-3">
    <header>
      <nav class="nav-wrapper blue darken-2">
        <div class="container">
          <a href="index.php?action=home" class="brand-logo left">Aller simple pour l'Alaska</a>
          <a href="#" class="sidenav-trigger right" data-target="mobile-menu">
            <i class="material-icons">menu</i>
          </a>
          <ul class="right hide-on-med-and-down">
            <li><a href="#photos" class="">Chapitres</a></li>
            <li><a href="index.php#about" class="">À propos</a></li>
            <?php if (!isset($_SESSION['pseudo'])) { ?>
              <li><a href='#login-signin' class='modal-trigger'>Inscription/Connexion</a></li>
            <?php } else { ?>
              <!-- Dropdown Trigger -->
              <li><a class='dropdown-trigger' href='#' data-target='usermenu'><?= $_SESSION['pseudo'] ?></a></li>

              <!-- Dropdown Structure -->
              <ul id='usermenu' class='dropdown-content'>
                <li><a href="index.php?action=manage">Profil</a></li>
                <li><a href="index.php?action=logout">Se déconnecter</a></li>
              </ul>
            <?php }?>
          </ul>
          <ul class="sidenav grey lighten-2" id="mobile-menu">
            <li><a href="index.php?action=home" class=""><i class="material-icons indigo-text text-darken-4">home</i> Accueil</a></li>
            <li><a href="#">Chapitres</a></li>
            <li><a href="#">À propos</a></li>
            <li><a href="#">Contact</a></li>
            <?php if (!isset($_SESSION['pseudo'])) { ?>
              <li><a href='#login-signin' class="modal-trigger">Inscription/Connexion</a></li>
            <?php } else { ?>
              <li><a href='index.php?action=manage'><?= $_SESSION['pseudo'] ?></li>
            <?php }?>
          </ul>
        </div>
      </nav>
    </header>

    <div class="modal" id="login-signin">
      <div class="modal-content">
        <div class="row">
          <ul class="tabs">
            <li class="tab col s6">
              <a href="#signin" class="indigo-text text-darken-4">Inscription</a>
            </li>
            <li class="tab col s6">
              <a href="#login" class="indigo-text text-darken-4">Connexion</a>
            </li>
          </ul>
          <div class="col s12" id="signin">
            <?php require('views/signin-form.php'); ?>
          </div>
          <div class="col s12" id="login">
            <?php require('views/login-form.php'); ?>
          </div>
        </div>
      </div>
    </div>



    <?= $content ?>

    <!-- Compiled and minified JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <script>
      $(document).ready(function(){
        $('.sidenav').sidenav();
        $('.materialboxed').materialbox();
        $('.parallax').parallax();
        $('.tabs').tabs();
        $('.modal').modal();
        $('.datepicker').datepicker({});
        $('.timepicker').timepicker({
          twelveHour: false
        });
        $('.dropdown-trigger').dropdown({
          coverTrigger: false,
          hover: true,
          constrainWidth: false
        });
      });
    </script>
  </body>
</html>
