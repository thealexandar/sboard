



$(document).ready(function(){
  var date_input=$('input[name="date"]'); //our date input has the name "date"
  var container=$('.add-offer form').length>0 ? $('.add-offer form').parent() : "body";
  date_input.datepicker({
    format: 'yyyy/mm/dd',
    container: container,
    todayHighlight: true,
    autoclose: true,
  })
})


let emailErr = document.getElementById("emailerr");
let usernameErr = document.getElementById("usernameerr");
if(emailErr.innerHTML || usernameErr.innerHTML){
    $('#adduser').modal('show');
}



$(document).ready(function(){
  $("select#roleSelect").change(function(){
      var selectedRole = $(this).children("option:selected").val();
      if(selectedRole == 3){
        $("#addCompany").addClass('d-block');
        $("#addFranchise").removeClass('d-block');
      } else if(selectedRole == 4){
        $("#addCompany").removeClass('d-block');
        $("#addFranchise").addClass('d-block');
      } else {
        $("#addCompany").removeClass('d-block');
        $("#addFranchise").removeClass('d-block');
      }
  });
})

