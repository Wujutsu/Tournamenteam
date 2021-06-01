import '../styles/base.scss';
import 'bootstrap/js/dist/modal';
import { each, trim } from 'jquery';
const $ = require('jquery');

// NavBar
$('#sidebarCollapse').on('click', function() {
    $('#sidebar, #content').toggleClass('active');
});

// ChatBar 
var currentPseudo = $("#currentPseudo").val();
var idChat = 0;
var pseudo = '';
var saveLengthTab = 0;

//Select a friend
$('.bubbleContact, .btnSendContact').on("click", function(){
    //Verification new selection
    if(idChat != $(this).attr("data-idChat")) {
        idChat = $(this).attr("data-idChat");
        pseudo = $(this).attr("data-pseudo");
    
        //Clear chat
        $("#showCadreChat").html('');
    }
});

//Refresh convertation 500ms
setInterval(function() {
    if(idChat > 0) {
        //Creation chat
        if(($("#showCadreChat").html()).length == 0) {
            //Show chat
            var show = '<div id="cadreChat"><div id="option"><div class="bubbleContact"><img alt="Contact picture"></div><div class="nameContact">' + pseudo + '</div><div id="closeCadreChat"><i class="fas fa-times"></i></div></div>';
            show += '<div id="showConvertation"><div class="spinner-border" role="status"><span class="sr-only"></span></div></div>';
            show += '<div id="comment"><span id="divText"><textarea class="form-control" placeholder="Aa" id="textMessage"></textarea></span><i class="fas fa-paper-plane" id="sendMessage"></i></div>';
            show += '</div></div>';
            $("#showCadreChat").html(show);

            //Update convertation
            updateConvertation(idChat);

            //Send message
            $("#sendMessage").on("click", function(){
                if(($("#textMessage").val()).trim() != '')
                    sendMessage(idChat, $("#textMessage").val());
            });
            $(document).keypress(function(event){
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13'){
                    if(($("#textMessage").val()).trim() != '')
                        sendMessage(idChat, $("#textMessage").val());
                }
            });

            //Close chat
            $("#closeCadreChat").on("click", function(){
                $("#showCadreChat").html('');
                idChat = 0;
                saveLengthTab = 0;
            });
        } else {
            //Update convertation
            updateConvertation(idChat);
        }
    }
},1000);

//Function to update convertation
function updateConvertation(idChat){
    $.ajax({
        type: "post",
        url: "/ajax/showChatMessages",
        data: {
            idChat: idChat
        },
        success: function (response) {
            if(response != false){
                if(response.length != saveLengthTab) {
                    var retour = '<div class="row">';
                    each(response, function(index, element) {
                        if(element.pseudo == currentPseudo)
                            retour += '<div class="col-12" id="bottom"><div class="comMe">' + element.message + '</div></div>';
                        else
                            retour += '<div class="col-12" id="bottom"><div class="comOther">' + element.message + '</div></div>';
                    });
                    retour += '</div>';

                    //Show message historique
                    $("#showConvertation").html(retour);

                    //Position Bottom scroll
                    $("#showConvertation").scrollTop($("#showConvertation")[0].scrollHeight);

                    //Height of tab message
                    saveLengthTab = response.length;
                }
            } else {
                $("#showConvertation").html("");
            }
        }
    });
}

//Function to send message
function sendMessage(idChat, message){
    $.ajax({
        type: "post",
        url: "/ajax/addChatMessages",
        data: {
            idChat: idChat,
            message: message
        },
        success: function (response) {
            if(response == false) {
                alert("Erreur lors de l'envoi du message");
            } else {
                $("#divText").html('<textarea class="form-control" placeholder="Aa" id="textMessage"></textarea>');
                $("#textMessage").focus();
            }
        }
    });
}