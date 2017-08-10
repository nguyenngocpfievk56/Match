function login(){
  $('#loginModal').modal('show');
  $('#createAccountModal').modal('hide');
}

function createAccount(){
  $('#createAccountModal').modal('show');
  $('#loginModal').modal('hide');
}

function updateAvatar(input){
  if (input.files && input.files[0]){
    var render = new FileReader();
    render.onload = function (e) {
      $('#imgAvatar').attr('src', e.target.result)
                      .width(80).height(80);
    };

    render.readAsDataURL(input.files[0]);
  }
}
