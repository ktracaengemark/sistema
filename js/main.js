$(function(){
  $("#App_Profissional").autocomplete({
    source: "Profissional/get_profissional" // path to the get_birds method
  });
});