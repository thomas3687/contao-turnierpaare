
$(document).ready(function(){

  $("#geteilt").click(function(){

    if($("#geteilt").is(":checked")){
      $("#versteckt").show("slow");
    }else{
        $("#versteckt").hide("slow");
      }
  });

});
