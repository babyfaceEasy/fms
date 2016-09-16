$(document).ready(function(){

  $( "#category" )
  .change(function() {
    var str = "";
    $( "select option:selected" ).each(function() {
      str += $( this ).text() + " ";
    });
  //  alert( str );
    if(str == "3"){
      $("#ipnetwork").show();
    }else{
      $("#ipnetwork").show();
    }
  })
  .trigger( "change" );
});
