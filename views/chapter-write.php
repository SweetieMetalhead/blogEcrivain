<?php
$title = 'PNL - écriture de chapitre';
ob_start();?>

<div class="white" id="chapterwritingarea">
  <h1>Écriture de chapitre</h1>

  <form method="post" action="index.php?action=addchapter">
    <input type="hidden" name="chapterID" value="<?php echo (isset($chapter['id'])) ? $chapter['id'] : "" ?>">
    <div class="row">
      <div class="input-field col s12 m10">
        <input type="text" name="title" id="title" value="<?php echo (isset($chapter['title'])) ? $chapter['title'] : "" ?>">
        <label for="title">Titre du chapitre</label>
      </div>
      <div class="input-field col s12 m2">
        <!-- <i class="material-icons prefix">clock</i> -->
        <input type="number" name="chapternumber" id="chapternumber" value="<?php echo (isset($chapter['chapter_number'])) ? $chapter['chapter_number'] : $chapterNumber+1 ?>">
        <label for="chapternumber">Numéro</label>
      </div>
    </div>
    <textarea id="content" name="content"><?php echo (isset($chapter['content'])) ? $chapter['content'] : "" ?></textarea>
    <p>
      <label>
        <input type="checkbox" name="publishlaterbool" id="publishlaterbool"/>
        <span>Souhaitez vous publier le chapitre plus tard ?</span>
      </label>
    </p>
    <div class="row" id="datetimepicker">
      <div class="input-field col s12 m7">
        <i class="material-icons prefix">today</i>
        <input type="text" name="date" id="date" class="datepicker">
        <label for="date">Quel jour souhaitez-vous publier le chapitre ?</label>
      </div>
      <div class="input-field col s12 m5">
        <!-- <i class="material-icons prefix">clock</i> -->
        <input type="text" name="time" id="time" class="timepicker">
        <label for="time">À quelle heure ?</label>
      </div>
    </div>
    <div class="input-field center">
      <input type="submit" name="submit" class="btn" value="Poster le chapitre !">
      <input type="submit" name="saveindraft" id="saveindraft" class="btn" value="Sauvegarder dans les Brouillons">
    </div>
  </form>
</div>

<!-- script of TinyMce -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="tinymce/js/tinymce/tinymce.min.js"></script>
<!-- <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=594pdhygyyrc3n8dmb6nd0x3p341kkhqbu32w2ug0dqdn721"></script> -->
<script src="public/js/chapter-write.js"></script>

<?php
$content = ob_get_clean();
require('template.php');
