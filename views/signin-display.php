<?php
$title = "PNL - Inscription";

ob_start(); ?>

<form id="inscription" action="index.php?action=signin" method="post">
  <h3 id="lalala">Inscription</h3>
  <table>
    <tr>
      <th class="left"><label for="pseudo">Pseudo : </label></th>
      <th><input type="text" id="pseudo" name="pseudo" required autofocus></th>
      <th><p id='pseudoadvice' class='warning'></p></th>
    </tr>
    <tr>
      <th class="left"><label for="email-insc">Adresse e-mail : </label></th>
      <th><input type="text" id="email" name="email" required></th>
      <th><p id='emailadvice' class='warning'></p></th>
    </tr>
    <tr>
      <th class="left"><label for="password">Mot de passe : </label></th>
      <th><input type="password" id="password" name="password" required></th>
      <th><p id='passwordadvice' class='warning'></p></th>
    </tr>
    <tr>
      <th class="left"><label for="confirm">Confirmation mot de passe : </label></th>
      <th><input type="password" id="confirm" name="confirm" required></th>
      <th><p id='confirmadvice' class='warning'></p></th>
    </tr>
  </table>
  <input type="submit" value="S'inscrire !">
</form>

<script src="public/js/verification.js"></script>
<script src="public/js/signin.js"></script>

<?php $content = ob_get_clean();

require('template.php');
