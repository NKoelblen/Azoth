jQuery(function($){

    const autreInstructeur = document.querySelector('#e_autre_instructeur').parentNode.parentNode;
    const contact = document.querySelector('#e_contact').parentNode.parentNode;

    $('input[name="e_coordonnees"]').on('change', function(e) {
        if (e.target.value === document.querySelector('#e_c_autre_instructeur').value){
            autreInstructeur.style.setProperty('display', 'inline-block');
            contact.style.setProperty('display', 'none');
        } else if(e.target.value === document.querySelector('#e_c_contact').value) {
            autreInstructeur.style.setProperty('display', 'none');
            contact.style.setProperty('display', 'inline-block');
        } else {
            autreInstructeur.style.setProperty('display', 'none');
            contact.style.setProperty('display', 'none');
        }
    });
    
});