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
  language: "fr_FR"
});
