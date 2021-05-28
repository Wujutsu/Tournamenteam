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
    alert("AIE !");
});