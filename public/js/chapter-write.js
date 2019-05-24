// Start by hiding datetimepicker
$("#datetimepicker").hide();

// Then check if the user wants to publish later
$("#publishlaterbool").click(function() {
  if(this.checked == true) {
      $("#datetimepicker").show();
  } else {
     $("#datetimepicker").hide();
  }
});

//For TinyMCE
tinymce.init({
  selector: '#content',
  language: "fr_FR",
  content_css : 'https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css'
});
