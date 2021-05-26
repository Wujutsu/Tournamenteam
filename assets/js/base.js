import '../styles/base.scss';
import 'jquery';
import 'bootstrap';

//NavBar
$('#sidebarCollapse').on('click', function() {
    $('#sidebar, #content').toggleClass('active');
});