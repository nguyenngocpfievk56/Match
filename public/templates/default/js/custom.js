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

function addComment(url, idUser, idProduct){
  $.post(url,
    {
      content: $("#comment").val(),
      idUser: idUser,
      idProduct: idProduct
    },
    function(data, status){
      $("#comments-list").append(data);
    });
}

function like(likeButton, url, idComment, likesTag) {
  $.post(url,
  {
    'id-comment': idComment
  },
  function(data, status) {
    likesTag.text(data);
    likeButton.onclick = function(event) {
      event.preventDefault();
    }
  });
}
