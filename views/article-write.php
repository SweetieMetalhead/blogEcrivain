<?php
$title = 'PNL - écriture d\'article';

ob_start();?>

<h1>Écriture d'article</h1>
<form action="index.php?action=addarticle" method="post">
  <p><input type="text" name="title" placeholder="Titre de l'article"></p>
  <p><textarea name="content" rows="8" cols="80"></textarea></p>
  <input type="submit" value="Valider">
  <input type="reset" value="Annuler">
</form>

<?php
$content = ob_get_clean();

require('template.php');
