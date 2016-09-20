$(document).ready(function(){
  $('#category').change(function() {
      var value = $(this).val();
      var baseSwitch = $("#base_switch");
      var ipnetwork =$("#ipnetwork");
      var transmission =$("#transmission");
      var ticketBtn =$("#ticketBtn");
      //var message =$("#ticketBtn");
      if (value === '3') {
          transmission.hide();
          baseSwitch.hide();
          ipnetwork.show();
          ticketBtn.show();
      }else if (value === "1") {

        baseSwitch.hide();
        ipnetwork.hide();
        transmission.show();
        ticketBtn.show();
      }else if (value == "2") {
        transmission.hide();

        ipnetwork.hide();
        baseSwitch.show();
        ticketBtn.show();
      }else{
        transmission.hide();

        ipnetwork.hide();
        baseSwitch.hide();
        ticketBtn.hide();
      }


  });

});
