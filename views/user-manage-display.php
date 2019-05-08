<?php
$title = "Aller simple pour l'Alaska - Votre compte";

ob_start(); ?>

<h1>Votre compte :</h1>

<h3> <?= $_SESSION['pseudo'] ?> </h3>

<p>email : <?= $_SESSION['email'] ?></p>

<?php
if ($_SESSION['auth'] == "admin") {
  echo "<a href='index.php?action=writearticle'>Ecrire un article</a>";
}
?>

<hr>

<form id="changepseudo" action="index.php?action=changepseudo" method="post">
  <p>
    <label>Changer de pseudo : <input type="text" name="newPseudo"></label>
    <input type="submit" value="Changer !">
    <span id="pseudoadvice" class="warning"></span>
  </p>
</form>

<form id="changeemail" action="index.php?action=changeemail" method="post">
  <p>
    <label>Changer d'adresse mail : <input type="text" name="newEmail"></label>
    <input type="submit" value="Changer !">
    <span id="emailadvice" class="warning"></span>
  </p>
</form>

<form id="changepassword" action="index.php?action=changepassword" method="post">
  <p>
    <p><label for="oldpassword">Changer de mot de passe : </label><br/>
    <input type="text" name="oldpassword" placeholder="Ancien mot de passe">
    <span id="oldpasswordadvice" class="warning"></span><br/>
    <input type="text" name="newpassword" placeholder="Nouveau mot de passe">
    <span id="newpasswordadvice" class="warning"></span><br/>
    <input type="text" name="passwordconfirm" placeholder="Confirmation nouveau mot de passe">
    <span id="confirmationadvice" class="warning"></span><br/>
    <input type="submit" value="Changer !"></p>
  </p>
</form>

<a id="accountdelete" href=""><p>Supprimer le compte</p></a>

<script src="public/js/verification.js"></script>
<script src="public/js/user-manage.js"></script>

<?php $content = ob_get_clean();

require('template.php');
