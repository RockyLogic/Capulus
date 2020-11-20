$(function(){
  $( "form" ).on( "submit", function(e) {

    var dataString = $(this).serialize();

    $.ajax({
      type: "POST",
      url: "../php/addForm.php",
      data: dataString,
      //success: function () {
        //}
      });
      $("form")[0].reset();
      e.preventDefault();
  });
});
