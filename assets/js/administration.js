import '../styles/administration.scss';
import 'datatables.net-bs4';
const $ = require('jquery');

//DataTable Games
$("#tableGames").DataTable({
    "language":{
        sProcessing: "Traitement en cours...",
        sSearch: "Rechercher&nbsp;:",
        sLengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
        //sInfo: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        sInfo: "_START_ &agrave; _END_",
        //sInfoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
        sInfoEmpty: "",
        //sInfoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        sInfoFiltered: "",
        sInfoPostFix: "",
        sLoadingRecords: "Chargement en cours...",
        sZeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
        sEmptyTable: "Aucune donn&eacute;e disponible dans le tableau",
        oPaginate: {
            sFirst: "Premier",
            sPrevious: "Pr&eacute;c&eacute;dent",
            sNext: "Suivant",
            sLast: "Dernier"
        },
        oAria: {
            sSortAscending: ": activer pour trier la colonne par ordre croissant",
            sSortDescending: ": activer pour trier la colonne par ordre d&eacute;croissant"
        }
    },
    "bPaginate": true,
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": true,
    "pageLength": 10,
    "order": [[ 0, "asc" ]],
    "aoColumnDefs" : [ { 'bSortable' : false, 'aTargets' : [3] } ]
});


//DataTable Users
$("#tableUsers").DataTable({
    "language":{
        sProcessing: "Traitement en cours...",
        sSearch: "Rechercher&nbsp;:",
        sLengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
        //sInfo: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        sInfo: "_START_ &agrave; _END_",
        //sInfoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
        sInfoEmpty: "",
        //sInfoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        sInfoFiltered: "",
        sInfoPostFix: "",
        sLoadingRecords: "Chargement en cours...",
        sZeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
        sEmptyTable: "Aucune donn&eacute;e disponible dans le tableau",
        oPaginate: {
            sFirst: "Premier",
            sPrevious: "Pr&eacute;c&eacute;dent",
            sNext: "Suivant",
            sLast: "Dernier"
        },
        oAria: {
            sSortAscending: ": activer pour trier la colonne par ordre croissant",
            sSortDescending: ": activer pour trier la colonne par ordre d&eacute;croissant"
        }
    },
    "bPaginate": true,
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": true,
    "pageLength": 10,
    "order": [[ 0, "asc" ]],
    "aoColumnDefs" : [ { 'bSortable' : false, 'aTargets' : [] } ]
});

//Delete a game
$(".btnDeleteGame").on("click", function(){
    if(confirm("Confirmer la suppression du jeu \"" + $(this).attr("data-name") + "\"")){
        $.ajax({
            type: "POST",
            url: "/ajax/deleteGame",
            data: {
                id : $(this).attr("data-id")
            },
            success: function (response) {
                response == true ? location.reload() : alert("Impossible de supprimer le jeu");
            }
        });
    }
});