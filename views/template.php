<!DOCTYPE html>
<html lang="fr">
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
            <li><a href="index.php?action=allchapters" class="">Chapitres</a></li>
            <li><a href="index.php#about" class="">À propos</a></li>
            <?php if (!isset($_SESSION['pseudo'])) { ?>
              <li><a href='#login-signin' class='modal-trigger'>Inscription/Connexion</a></li>
            <?php } else { ?>
              <!-- Dropdown Trigger -->
              <li>
                <a class='dropdown-trigger' href='#' data-target='usermenu'><?= $_SESSION['pseudo'] ?>
                  <?php if (countNotifications($_SESSION['pseudo']) > 0): ?>
                    <span class="new badge" data-badge-caption="msg"><?= countNotifications($_SESSION['pseudo']); ?></span>
                  <?php endif; ?>
                </a>
              </li>
            <?php }?>
          </ul>
          <!-- Dropdown Structure -->
          <ul id='usermenu' class='dropdown-content'>
            <li><a href="index.php?action=manage&pseudo=<?= $_SESSION['pseudo'] ?>">Profil</a></li>
            <?php if($_SESSION['pseudo'] == "Jean_Forteroche") {?>
              <li><a href="index.php?action=writechapter">Ecrire un chapitre</a></li>
            <?php } ?>
            <li><a href="index.php?action=logout">Se déconnecter</a></li>
          </ul>
          <ul class="sidenav grey lighten-2" id="mobile-menu">
            <li><a href="index.php?action=home" class=""><i class="material-icons indigo-text text-darken-4">home</i> Accueil</a></li>
            <li><a href="#">Chapitres</a></li>
            <li><a href="#">À propos</a></li>
            <li><a href="#">Contact</a></li>
            <?php if (!isset($_SESSION['pseudo'])) { ?>
              <li><a href='#login-signin' class="modal-trigger">Inscription/Connexion</a></li>
            <?php } else { ?>
              <li><a href='index.php?action=manage'><?= $_SESSION['pseudo'] ?></a></li>
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
    <!-- Parameters for Materialize -->
    <script>
      $(document).ready(function(){
        $('.sidenav').sidenav();
        $('.tooltipped').tooltip();
        $('.materialboxed').materialbox();
        $('.parallax').parallax();
        $('.tabs').tabs();
        $('.modal').modal();
        $('.datepicker').datepicker({
          firstDay: 0,
          format: 'ddd dd mmmm yyyy',
          i18n: {
            months: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
            monthsShort: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jun", "Jul", "Aou", "Sep", "Oct", "Nov", "Déc"],
            weekdays: ["Lundi","Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
            weekdaysShort: ["Lun","Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"],
            weekdaysAbbrev: ["L","M", "M", "J", "V", "S", "D"],
            cancel:'Annuler',
            clear:'Effacer',
            done:'Confirmer'
          }
        });
        $('.timepicker').timepicker({
          twelveHour: false,
          i18n: {
            cancel:'Annuler',
            clear:'Effacer',
            done:'Confirmer'
          }
        });
        $('.dropdown-trigger').dropdown({
          coverTrigger: false,
          hover: false,
          constrainWidth: false
        });
        $('.collapsible').collapsible();
      });
    </script>
  </body>
</html>
