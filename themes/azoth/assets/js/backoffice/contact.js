jQuery(function($){

    const autreInstructeur = document.querySelector('#e_autre_instructeur').parentNode.parentNode;
    const contact = document.querySelector('#contact').parentNode.parentNode;

    if($('input[name="e_coordonnees"]:checked').val() === 'autre-instructeur') {
        open(autreInstructeur);
    } else if($('input[name="e_coordonnees"]:checked').val() === 'contact') {
        open(contact);
    }

    $('input[name="e_coordonnees"]').on('change', function(e) {
        if (e.target.value === 'autre-instructeur'){
            open(autreInstructeur);
            close(contact);
        } else if(e.target.value === 'contact') {
            close(autreInstructeur);
            open(contact);
        } else {
            close(autreInstructeur);
            close(contact);
        }
    });

    function open(element) {
        element.style.setProperty('display', 'inline-block');
    }

    function close(element) {
        element.style.setProperty('display', 'none');
    }
    
});