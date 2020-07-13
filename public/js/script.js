$(document).ready(function() {
    $('#myTable').DataTable({
        "scrollY": "50vh",
        "scrollCollapse": true,
        "paging": false
    });


    $('#etudiant_Adresse').hide();
    $('#etudiant_Chambre').hide();
    $('#etudiant_Bourse').hide();
    $('#addInput').click(function() {

        let nbr = 0;
        $('#etudiant_Type_Etudiant').change(function() {
            $('#addInput').show();
            $('#etudiant_Adresse').hide();
            $('#etudiant_Num_Chambre').hide();
            $('#etudiant_Bourse').hide();
            nbr = 0;
        });

        nbr++;
        let choix = $('#etudiant_Type_Etudiant').val();
        if (choix === "boursiernonloge") {
            $('#addInput').hide();
            $('#etudiant_Bourse').show();
            $('#etudiant_Adresse').show();
        } else if (choix === "boursierloge") {
            $('#addInput').hide();
            $('#etudiant_Bourse').show();
            $('#etudiant_Num_Chambre').show();
        } else if (choix === "nonboursier") {
            $('#addInput').hide();
            $('#etudiant_Adresse').show();
        }
    });
});



// Function qui génère le numéro d'une chambre

$('#chambre_numbat').keyup(function() {
    nbrField = $('#nbrfield').val().toString().padStart(4, '0'); //( 4 signifie la chaine et 0 le chiffre à ajouter )
    numBatiment = $('#chambre_numbat').val();
    c = numBatiment.toString().padStart(3, '0');
    $('#chambre_numchambre').attr('value', `${c}-${nbrField}`)
});

// Function qui génère le matricule d'un etudiant

var matricule = $('#etudiant_Matricule');

$('#etudiant_Date_de_Naissance').change(function() {
    date = $('#etudiant_Date_de_Naissance').val().split('-');
    var prenom = $('#etudiant_Prenom').val();
    var nom = $('#etudiant_Nom').val();
    matricule.attr(`value`, `${date[0]}${nom.substr(0,2).toUpperCase()}${prenom.substr((prenom.length)-2).toUpperCase()}${$('#matricule').val().toString().padStart(4,'0')}`);
    console.log(date[0]);
});