<h4 id="lalala" class="flow-text indigo-text text-darken-4">Inscription</h4>

<form id="signin-form" method="POST" action="index.php?action=signin">
  <div id="signinpseudoform" class="input-field">
    <i class="material-icons prefix">person</i>
    <input type="text" name="signinpseudo" id="signinpseudo" required onkeyup="checkInfo(this.value, 'pseudo')">
    <label for="signinpseudo" id="pseudoadvice">Votre pseudo</label>
  </div>
  <div class="input-field">
    <i class="material-icons prefix">email</i>
    <input type="email" name="signinemail" id="signinemail" required onkeyup="checkInfo(this.value, 'email')">
    <label for="signinemail" id="emailadvice">Votre e-mail</label>
  </div>
  <div class="input-field">
    <i class="material-icons prefix">lock</i>
    <input type="password" name="signinpassword" id="signinpassword" required>
    <label for="signinpassword" id="passwordadvice">Votre mot de passe</label>
  </div>
  <div class="input-field">
    <i class="material-icons prefix">lock</i>
    <input type="password" name="signinconfirm" id="signinconfirm" required>
    <label for="signinconfirm" id="confirmadvice">Confirmez votre mot de passe</label>
  </div>
  <div class="input-field center">
    <input type="submit" name="submit" class="btn" value="S'inscrire !">
    <input type="reset" name="reset" class="btn modal-close" value="Annuler">
  </div>
</form>

<script>
function checkInfo(val, infoTested){
  if (infoTested == "pseudo") {
    $.ajax({
      type:"POST",
      url:"models/validator.php",
      data:"pseudo="+val,
      success: function(data){
        if (!data) {
          $("#pseudoadvice").html("Votre pseudo est déjà utilisé");
          pseudoDoublesCheck = false;
        } else {
          $("#pseudoadvice").html("");
          pseudoDoublesCheck = true;
        }
      }
    });
  } else if (infoTested == "email") {
    $.ajax({
      type:"POST",
      url:"models/validator.php",
      data:"email="+val,
      success: function(data){
        if (!data) {
          $("#emailadvice").html("Votre email est déjà utilisé");
          emailDoublesCheck = false;
        } else {
          $("#emailoadvice").html("");
          emailDoublesCheck = true;
        }
      }
    });
  }
}

</script>

<script src="public/js/verification.js"></script>
<script src="public/js/signin.js"></script>
