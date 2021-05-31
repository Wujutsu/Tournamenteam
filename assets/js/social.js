import '../styles/social.scss';
const $ = require('jquery');

//Modal Add Friend verification if pseudo exist or doublon
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