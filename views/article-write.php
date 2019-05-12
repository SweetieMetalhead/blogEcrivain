<?php
$title = 'PNL - écriture d\'article';

ob_start();?>

<h1>Écriture d'article</h1>

<form method="post" action="index.php?action=addarticle" class="white">
  <h4><input type="text" name="title" placeholder="Titre du Chapitre"></h4>
  <textarea id="content" name="content">Hello World!</textarea>
  <div class="input-field">
    <i class="material-icons prefix">today</i>
    <input type="text" name="date" id="date" class="datepicker">
    <input type="text" name="time" class="timepicker">
    <label for="date">Quand souhaitez-vous publier le chapitre ?</label>
  </div>
  <input type="submit" name="submit" value="Poster !">
</form>

<!-- script of TinyMce -->
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=594pdhygyyrc3n8dmb6nd0x3p341kkhqbu32w2ug0dqdn721"></script>
<script>
  tinymce.init({
    selector: '#content'
  });
</script>

<?php
$content = ob_get_clean();

require('template.php');
