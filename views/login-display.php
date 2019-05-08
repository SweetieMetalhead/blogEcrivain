<?php
$title = "PNL - Connexion";

ob_start(); ?>

<form id="connexion" action="index.php?action=login" method="post">
  <h3>Connexion</h3>
  <table>
    <tr>
      <th><label for="email">Adresse e-mail : </label></th>
      <th><input type="text" id="email" name="email" autofocus required></th>
    </tr>
    <tr>
      <th><label for="mdp-conn">Mot de passe : </label></th>
      <th><input type="password" id="password" name="password" required></th>
    </tr>
  </table>
  <p><input type="submit" value="Se connecter !"></p>
  <?php if (isset($_GET['response'])) {
    if ($_GET['response'] == 'wrongpassword') {
      echo "<p>Vous avez entré le mauvais mot de passe ou la mauvaise adresse email. Veuillez réessayer.</p>";
    } elseif ($_GET['response'] == 'wrongemail') {
      echo "<p>Vous avez entré la mauvaise adresse e-mail.</p>";
    }
  } ?>
</form>

<script src="public/js/login.js"></script>

<?php $content = ob_get_clean();

require('template.php');
