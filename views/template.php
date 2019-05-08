<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title><?= $title ?></title>
    <link href="public/css/style.css" rel="stylesheet" />
  </head>

  <body>
    <header>
      <a href="index.php?action=home"><div class="title">
        <img src="http://www.liguedefensejuive.com/wp-content/uploads/2016/10/lCo9oYbl-400x400.jpg">
        <h2>Le PNL</h2>
      </div></a>
      <div class="menu">
        <ul>
          <li><a href="index.php?action=home">Accueil</a></li>
          <?php if (!isset($_SESSION['pseudo'])) {
            echo "
            <li><a href='index.php?action=signin-page'>S'inscrire</a></li>
            <li><a href='index.php?action=login-page'>Se connecter</a></li>
            ";
          } else {
            echo "
            <li><a href='index.php?action=manage'>" . $_SESSION['pseudo'] . "
            <li><a href='index.php?action=logout'>Se déconnecter</a></li>
          ";
          }?>
        </ul>
      </div>
    </header>
    <?= $content ?>
  </body>
</html>
