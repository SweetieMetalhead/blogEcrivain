<?php
$title = "Billet simple pour l'Alaska";

ob_start(); ?>

<section class="container row">
  <h1 class="center">Un aller simple pour l'Alaska</h1>
  <h3 class="center">Un livre de Jean Forteroche </h3>
  <h2 class="center"><i class="material-icons large">explore</i></h2>

  <div class="container">
    <h3 class="center">Les Chapitres</h3>
    <hr>
  </div>
  <?php
  for ($i=0; $i <= 1; $i++) {
    $data = ($i == 0) ? $firstChapter : $lastChapter ?>
    <div class="card col s12 m6 hoverable">
      <div class="card-content">
        <h6 class="grey-text"><?php echo ($i == 0) ? "Premier chapitre" : "Dernier chapitre paru" ?></h6>
        <span class="card-title">Chapitre <?= $data['chapter_number'] . " : " . $data['title'] ?></span>
        <p><?= $data['summary'] ?>...</p>
      </div>
      <div class="card-action row">
        <a href="index.php?action=chapter&chapterid= <?= $data['id'] ?>" class="col s12 m5">Voir le chapitre</a>
        <a href="#" class="col s12 m5">Voir tout les chapitres</a>
      </div>
    </div>
  <?php } ?>
</section>

<div class="parallax-container">
  <div class="parallax">
    <img src="public/images/Alaska.jpg" alt="image of ice and snow" class="responsive-img">
  </div>
</div>

<section id="about" class="container row">
  <div class="col s12 m6 l4">
    <img src="public/images/écrivain.jpg" alt="Cette personne est en réalité Mike Horn" class="responsive-img">
  </div>
  <div class="col s12 m6 l8">
    <h4>Jean Forteroche</h4>
    <p>Né le 16 juillet 1966 (52 ans) à Johannesbourg (Afrique du Sud), Jean Forteroche est un explorateur-aventurier de nationalités suisse et sud-africaine, de culture afrikaner, résidant en Suisse. <br/>
      De juin 1999 à octobre 2000, il entreprend de mener à bien son projet, Latitude Zéro : il est le premier au monde à réaliser le tour du monde en suivant la ligne de l’équateur, 40 000 km, qu’il parcourt sans moyen de transport motorisé.</p>
    <p>Il y a 3 ans, il décide de partir en Alaska pour mener à bien son projet de découverte des paysages hostiles et peu explorés afin d'y écrire le livre que vous vous apprettez à lire.</p>
  </div>
</section>
<section class="container row">
  <h4>Le livre</h4>
  <p>"Un aller simple pour l'Alaska" est le résultat d'un voyage effectué en 2016 par Jean Forteroche et une petite équipe d'explorateurs en quête de découvertes et d'aventures. <br/>
  C'est un récit introspectif et passionné, mêlant aventures improbables et dangers bien réels.</p>
  <p>Tout les faits relatés se sont réellement déroulés, bien qu'il soit parfois difficile d'y croire. </p>
  <p>Vous êtes prêts ? Alors chaussez vos chaussures de randonnée et lancez-vous dans cette lecture chapitre par chapitre de l'oeuvre de Jean Forteroche...</p>
</section>

<footer class="page-footer grey darken-3">
  <div class="container">
    <div class="row">
      <div class="col s12 l6">
        <h5>Droits d'auteur</h5>
        <p>La présente oeuvre est protégée par les droits d'auteur Français. Toute reproduction est interdite.</p>
      </div>
      <div class="col s12 l4 offset-l2">
        <h5>Entrez en contact</h5>
        <ul>
          <li><a href="#" class="grey-text text-lighten-3">Facebook</a></li>
          <li><a href="#" class="grey-text text-lighten-3">Twitter</a></li>
          <li><a href="#" class="grey-text text-lighten-3">LinkedIn</a></li>
          <li><a href="#" class="grey-text text-lighten-3">Instagram </a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="footer-copyright grey darken-4">
    <div class="container center-align">
      &copy; 2019 Editions Jacketard
    </div>
  </div>
</footer>

<?php $content = ob_get_clean();

require('template.php');
