/**
 * Prevents page from redirection while sending form data to post
 */
$(function(){
  $( "form" ).on( "submit", function(e) {

    var dataString = $(this).serialize();

    $.ajax({
      type: "POST",
      url: "php/addForm.php",
      data: dataString,

      });

      //Empty out form field
      $("form")[0].reset();
      e.preventDefault();
  });
});
