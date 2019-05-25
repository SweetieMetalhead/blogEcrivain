<h4 class="flow-text indigo-text text-darken-4">Connexion</h4>

<form id="login-form" method="POST" action="index.php?action=login">
  <div class="input-field">
    <i class="material-icons prefix">email</i>
    <input type="email" name="loginemail" id="loginemail" required>
    <label for="loginemail" id="emailadvice">Votre e-mail</label>
  </div>
  <div class="input-field">
    <i class="material-icons prefix">lock</i>
    <input type="password" name="loginpassword" id="loginpassword" required>
    <label for="loginpassword" id="passwordadvice">Votre mot de passe</label>
  </div>
  <div class="input-field center">
    <input type="submit" name="submit" class="btn" value="Se connecter !">
    <input type="reset" name="reset" class="btn modal-close" value="Annuler">
  </div>
</form>
