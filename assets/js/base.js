import '../styles/base.scss';
import 'bootstrap/js/dist/modal';
const $ = require('jquery');

//NavBar
$('#sidebarCollapse').on('click', function() {
    $('#sidebar, #content').toggleClass('active');
});

//ChatBar
$('.bubbleContact').on("click", function(){
    var id = $(this).attr("data-id");
    var pseudo = $(this).attr("data-pseudo");
    
    //Show chat
    $(".nameContact").html(pseudo);
    $(".cadreChat").css("display", "block");

    //Close chat
    $(".closeCadreChat").on("click", function(){
        $(".cadreChat").css("display", "none");
    });
});
