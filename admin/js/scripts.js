$(document).ready(function() {
    $('#summernote').summernote({
      height: 200
    });
  });



$(document).ready(function(){
  $('#selectAllBoxes').click(function(event){
    if(this.checked) {
      $('.checkBoxes').each(function(){
        this.checked = true;
      });
    } else {
      $('.checkBoxes').each(function(){
        this.checked = false;   
      });
    }
  });


  var div_box = "<div id='load-screen'><div id='loading'></div></div>";
  $("body").prepend(div_box);

  $("#load-screen").delay(300).fadeOut(200, function(){
    $(this).remove();
  });
});


function loadUsersOnline(){

  $.get("function.php?onlineusers=result", function(data){

    $(".usersonline").text(data);

  });

}

/* with setInterval we set the interval to refresh the function every half second*/
setInterval(function(){

  loadUsersOnline();

}, 500);


