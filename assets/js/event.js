import '../styles/event.scss';
const $ = require('jquery');

$(".cadreEvent").on("click", function(){
    var idEvent = $(this).attr("data-idEvent");
    window.location.replace('evenement/affiche/' + idEvent);
});