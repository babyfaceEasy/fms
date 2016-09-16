$(document).ready(function(){
  $( "#category" )
  .change(function() {
    var str = "";
    $( "select option:selected" ).each(function() {
      str += $( this ).text() + " ";
    });
    alert( str );
  })
  .trigger( "change" );
});
