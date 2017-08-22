function updateImage(input){
  if (input.files && input.files[0]){
    var render = new FileReader();
    render.onload = function (e) {
      $('#imgAvatar').attr('src', e.target.result)
                      .width(200).height(200);
    };

    render.readAsDataURL(input.files[0]);
  }
}

function openPasswordChangeForm(){
  $("#password-change-div").show();
  $("#save-div").show();
  $("#change-div").hide();
}

function closePasswordChangeForm(){
  $("#password-change-div").hide();
  $("#save-div").hide();
  $("#change-div").show();
}

function changePassword(url, idUser){
  var newP = $("#new").val();
  var confirmP = $("#confirm").val();
  var currentP = $("#current").val();

  if (newP != '' && confirmP != '' && currentP != ''){
    if (newP == confirmP){
      $.post(url,
      {
        id: idUser,
        newPassword: newP,
        currentPassword: currentP
      },
      function(data, status){
        if (data == "fail"){
          $("#fail-div").show();
        } else {
          closePasswordChangeForm();
          $("#new").val("");
          $("#confirm").val("");
          $("#current").val("");
          $("#fail-div").hide();
        }
      });
    }
  }
}
