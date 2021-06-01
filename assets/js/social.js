import '../styles/social.scss';
const $ = require('jquery');

//Add Friend request verification if pseudo exist or doublon
$("#add_friend_form_save").on("click", function(){
    $.ajax({
        type: "post",
        url: "/ajax/verificationPseudo",
        data: {
            pseudo: $("#pseudo").val()
        },
        success: function (response) {
            if(response != true) {
                $("#errorPseudo").html(response);
                $("#errorPseudo").css("display", "block");
                return false;   
            } else {
                $("#formAddFriend").submit();
            }
        }
    });
    return false;   
});

//Accept a friend
$(".btnAcceptContact").on("click", function(){
    $.ajax({
        type: "post",
        url: "/ajax/acceptFriend",
        data: {
            id: $(this).attr("data-id")
        },
        success: function (response) {
            (response == true) ? location.reload() : alert("Erreur lors de la validation");
        }
    }); 
});

//Delete a friend
$(".btnDeleteContact").on("click", function(){
   $.ajax({
       type: "post",
       url: "/ajax/deleteFriend",
       data: {
           id: $(this).attr("data-id")
       },
       success: function (response) {
           (response == true) ? location.reload() : alert("Erreur lors de la suppression");
       }
   }); 
});

