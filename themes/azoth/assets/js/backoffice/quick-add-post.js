jQuery(function($){
    function openForm(element) {
        element.parent().next().css('display', 'block');
        element.parent().next().find('input').prop( "disabled", false );
    }
    function closeForm(element) {
        element.parent().parent().css('display', 'none');
        $('.modal-outer input').prop( "disabled", true );
    }

    $('.modal-outer input').prop( "disabled", true );

    // closeForm($('button.add'));

    $('button.add').on('click', function(e) {
        e.preventDefault();
        openForm($(this));
    });

    $('.modal-inner .media-modal-close').on('click', function(e) {
        closeForm($(this));
    });

    $('.quick-add-post').on('click', function (e) {

        e.preventDefault();
        
        const ajaxurl = $(this).data('ajaxurl');

        let postType = $(this).data('post-type');

        let data = {
            action: $(this).data('action'), 
            nonce:  $(this).data('nonce'),
            post_type:   postType
    }

        let selector = '.modal-outer.' + postType + ' .modal-inner input:not(input[type=radio]:not(:checked), #geo_zonechecklist-pop input, .category-add input, #map input), .modal-outer.' + postType + ' .modal-inner textarea'

        $(selector).each(function() {
            let property = $(this).attr('name');
            let value = $(this).val();
            data[property] = value;
        });

        console.log(ajaxurl);
        console.log(data);

        // Requête Ajax en JS natif via Fetch
        fetch(ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Cache-Control': 'no-cache'
            },
            body: new URLSearchParams(data),
        })
        .then(response => response.json())
        .then(body => {
            // En cas d'erreur
            if (!body.success) {
                alert(response.data);
                return;
            }
        //     // Et en cas de réussite
        //     $('.modal-inner').appendTo('.wrap');
            $('.modal-inner').append(body.data); // afficher le HTML
        });
    });
});