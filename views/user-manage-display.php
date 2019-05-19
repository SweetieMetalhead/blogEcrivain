<?php
$title = "Aller simple pour l'Alaska - Votre compte";

ob_start(); ?>

<div class="container">
  <h2>Votre compte :</h2>

  <h3> <?= $userInfo['pseudo'] ?> </h3>

  <p>email : <?= $userInfo['email'] ?></p>
</div>

<hr>

<ul class="collapsible">
  <li>
    <?php if ($userInfo['pseudo'] == $_SESSION['pseudo']) { ?>
      <div class="collapsible-header">
        <i class="material-icons">edit</i> Changez vos informations
      </div>
      <div class="collapsible-body row white">
        <form id="changepseudo" action="index.php?action=changepseudo" method="post" class="white">
          <div class="input-field col s12 m9">
            <i class="material-icons prefix">person</i>
            <input type="text" name="newpseudo" id="newpseudo" required>
            <label for="newpseudo" id="pseudoadvice" class="warning">Changer de pseudo : </label>
          </div>
          <div class="input-field center col s12 m3">
            <input type="submit" name="submit" class="btn" value="Changer">
          </div>
        </form>

        <form id="changeemail" action="index.php?action=changeemail" method="post" class="white">
          <div class="input-field col s12 m9">
            <i class="material-icons prefix">email</i>
            <input type="email" name="newemail" id="newemail" required>
            <label for="newemail" id="emailadvice" class="warning">Changer d'adresse email : </label>
          </div>
          <div class="input-field center col s12 m3">
            <input type="submit" name="submit" class="btn" value="Changer">
          </div>
        </form>

        <form id="changepassword" action="index.php?action=changepassword" method="post" class="white">
          <div class="input-field col s12">
            <i class="material-icons prefix">lock</i>
            <input type="password" name="oldpassword" id="oldpassword" required>
            <label for="oldpassword" id="oldpasswordadvice" class="warning">Entrez votre ancien mot de passe</label>
          </div>
          <div class="input-field col s12">
            <i class="material-icons prefix">lock</i>
            <input type="password" name="newpassword" id="newpassword" required>
            <label for="newpassword" id="newpasswordadvice" class="warning">Entrez votre nouveau mot de passe</label>
          </div>
          <div class="input-field col s12">
            <i class="material-icons prefix">lock</i>
            <input type="password" name="passwordconfirm" id="passwordconfirm" required>
            <label for="passwordconfirm" id="confirmationadvice" class="warning">Confirmez votre nouveau mot de passe</label>
          </div>
          <div class="input-field col s12">
            <input type="submit" name="submit" class="btn" value="Changer votre mot de passe">
          </div>
        </form>

        <div class="col s12">
          <a class="btn center" id="accountdelete" href="">Supprimer le compte</a>
        </div>
      </div>

      <script src="public/js/verification.js"></script>
      <script src="public/js/user-manage.js"></script>

    <?php } ?>
  </li>
</ul>

<?php
$content = ob_get_clean();

require('template.php');
