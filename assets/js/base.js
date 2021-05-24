const $ = require('jquery');

//NavBar
$('#sidebarCollapse').on('click', function() {
    $('#sidebar, #content').toggleClass('active');
});