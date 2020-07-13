const div = document.getElementById('etudiant');
const divChambre = document.getElementById('chambre');
const selects = document.getElementsByTagName('select');
const labels = document.getElementsByTagName('label');
const inputs = document.getElementsByTagName('input');
const type = document.getElementById('etudiant_type');
const adresseEtud = document.getElementById('etudiant_adresse');
const Num = document.getElementById('etudiant_num_chambre');
const BourseEtud = document.getElementById('etudiant_bourse');
const adresse = document.getElementById('adresse');
const numChambre = document.getElementById('numChambre');
const bourse = document.getElementById('bourse');
const forms = document.getElementsByTagName('form');
for(form of forms){
    form.setAttribute("class", "container-fluid col-7");
}
for(select of selects){
    select.setAttribute("class", "container form-control");
}
if(div){
    div.setAttribute("class", "container-fluid form-group")
    err = document.createElement("small");
    err.setAttribute("id","error-etudiant_adresse");
    err.setAttribute("class","text-danger");
    adresse.appendChild(err);
    err = document.createElement("small");
    err.setAttribute("id","error-etudiant_num_chambre");
    err.setAttribute("class","text-danger");
    numChambre.appendChild(err);
    err = document.createElement("small");
    err.setAttribute("id","error-etudiant_bourse");
    err.setAttribute("class","text-danger");
    bourse.appendChild(err);
    adresse.setAttribute("class", "d-none")
}
if (divChambre) {
    divChambre.setAttribute("class", "container-fluid form-group")
}
for(label of labels){
    label.setAttribute("class", "text-white");
}
for(input of inputs){
    input.setAttribute("class", "form-control")
    if (input.type === 'submit') {
       input.setAttribute("class", "form-control btn btn-info") 
    }
}
var error;
//Fonctions
function target(){
    adresseEtud.addEventListener("keyup",function(e){
        if(e.target.hasAttribute("name")){
            var small = e.target.getAttribute("id");
            document.getElementById('error-'+small).innerText = ""
        }
    })
    Num.addEventListener("change",function(e){
        if(e.target.hasAttribute("name")){
            var small = e.target.getAttribute("id");
            document.getElementById('error-'+small).innerText = "";
        }
    })
    BourseEtud.addEventListener("change",function(e){
        if(e.target.hasAttribute("name")){
            var small = e.target.getAttribute("id");
            document.getElementById('error-'+small).innerText = ""
        }
    })
}
function checkRequired(inputArray) {
    error = false;
    inputArray.forEach(input => {
        if(input.value.trim() === ''){
            showError(input, `Remplir le Champ`);  
            error = true;  
        }else{
            showSuccess(input);
        }
    });
}
//
function showError(input, message) {
    input.className = 'form-control border border-danger';
    const small  = document.getElementById('error-'+input.id);
    small.innerText = message;
}
//
function showSuccess(input) {
    input.className = 'form-control border border-success';
    const small  = document.getElementById('error-'+input.id);
    small.innerText = '';
}
//
function typeEtudiant(){
    if (type.value) {
        if(type.value == 'NonBoursier'){
            adresse.setAttribute("class", "")
            numChambre.setAttribute("class", "d-none")
            bourse.setAttribute("class", "d-none")
        }
        else{
            adresse.setAttribute("class", "d-none")
            numChambre.setAttribute("class", "d-none")
            bourse.setAttribute("class", "")
            if (type.value == 'BoursierLogé') {
                numChambre.setAttribute("class", "")
            }
        }
    }
}

//Events

if (typeof(form) != 'undefined') {
    form.addEventListener('submit',(e)=>{
        if (type.value) {
            if (type.value === "NonBoursier") {
                checkRequired([adresseEtud]);
            }else {
                if (type.value === "BoursierLogé") {
                    checkRequired([BourseEtud,Num]);
                }
                else{
                    checkRequired([BourseEtud]);
                }
            }
        }
        target();
        if (error) {
            e.preventDefault();
            return false;
        }
    });    
}

$(document).ready(function(){
    $('#table').DataTable();
    $('#tableChambre').DataTable({
        "scrollY":        "60vh",
        "scrollCollapse": true,
        "paging":         false
    });
    $(document).ready(function () {
        $('.delete-etudiant').click(function (e) {
            let id =  $(this).attr('id');
            $.ajax({
                url:'/etudiant/'+id+'/delete_message',
                type:'post',
                data:{id:id},
                dataType:'json',
                success:function (data) {
                    deleteEtudiant(data);
                }
            })
            function deleteEtudiant(data) {

                var text = "";
                    text = 'Attention Voulez vous vraiment supprimer '+data['prenom']+' '+data['nom']+'?';

                Swal.fire({
                    title: 'Etes vous sur?',
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimer!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'/etudiant/'+id+'/delete',
                            type:'post',
                            data:{id:id},
                            dataType:'json',
                        })
                        Swal.fire(
                            'Supprimer!',
                            'l\' étudiant est supprimer.',
                            'success'
                        ).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        })
                    }
                })
            }
        })
    })
})

$(document).ready(function () {
    $('.chambre_delete').on('click',function (e) {
        let id =  $(this).attr('id');
        $.ajax({
            url:'/chambre/'+id+'/delete',
            type:'post',
            data:{id:id},
            dataType:'json',
            success:function (data) {
                deleteChambre(data);
            }
        })
        function deleteChambre(data) {

            var text = "";
            if(data['etudiants'].length === 0) {
                text = "Voulez vous vraiment supprimer cette chambre!!!";
                Swal.fire({
                    title: 'Etes vous sur?',
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#00FF00',
                    cancelButtonText: 'Retour',
                    confirmButtonText: 'Oui, supprimer!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:'/chambre/'+id+'/delete_chambre',
                            type:'post',
                            data:{id:id},
                            dataType:'json',
                        })
                        Swal.fire(
                            'Supprimer!',
                            'la chambre est supprimer.',
                            'success'
                        ).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        })
                    }
                })
            }
            else{
                Swal.fire(
                    'Warning!!!',
                    'Vous ne pouvez pas supprimer cette chambre occupée',
                    'error'
                )
            }
            
        }
    })


})