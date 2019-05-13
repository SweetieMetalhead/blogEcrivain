<h4 id="lalala" class="flow-text indigo-text text-darken-4">Inscription</h4>

<form id="signin-form" method="POST" action="index.php?action=signin">
  <div class="input-field">
    <i class="material-icons prefix">person</i>
    <input type="text" name="signinpseudo" id="signinpseudo" required onkeyup="checkPseudo(this.value)">
    <label for="signinpseudo" id="pseudoadvice">Votre pseudo</label>
  </div>
  <div class="input-field">
    <i class="material-icons prefix">email</i>
    <input type="email" name="signinemail" id="signinemail" required onkeyup="checkEmail(this.value)">
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

<p id="msgPseudo"></p>
<p id="msgEmail"></p>

<script type="text/javascript">
function checkPseudo(val){
  $.ajax({
    type:"POST",                        //type of the request to make
    url:"models/validator.php",              //server the request should be sent
    data:"pseudo="+val,               //the data to send to the server
    success: function(data){            //the function to be called if the request succeeds
      $("#msgPseudo").html(data);
    }
  });
}

function checkEmail(val){
  $.ajax({
    type:"POST",                        //type of the request to make
    url:"models/validator.php",              //server the request should be sent
    data:"email="+val,               //the data to send to the server
    success: function(data){            //the function to be called if the request succeeds
      $("#msgEmail").html(data);
    }
  });
}
</script>

<script src="public/js/verification.js"></script>
<script src="public/js/signin.js"></script>
