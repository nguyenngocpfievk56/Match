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
      $("#comment").val('');
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

function subCommentToggle(toggleBtn, subCommentDiv){
  if (toggleBtn.text() == 'hide'){
    toggleBtn.html('show');
    subCommentDiv.hide();
  } else {
    toggleBtn.html('hide');
    subCommentDiv.show();
  }
}

function replyToggle(toggleBtn, replyDiv){
  if (toggleBtn.text() == 'reply'){
    toggleBtn.html('cancel');
    replyDiv.show();
  } else {
    toggleBtn.html('reply');
    replyDiv.hide();
  }
}

function addSubComment(url, replyDiv, contentArea, idUser, idComment){
  $.post(url,
    {
      content: contentArea.val(),
      idUser: idUser,
      idComment: idComment
    },
    function(data, status){
      contentArea.val('');
      replyDiv.before(data);
    });
}

function openUpdateForm(){
  $("#update-form").toggle();
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
