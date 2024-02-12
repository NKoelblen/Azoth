jQuery(function($){

    $('body').on('click', '.upload_image_button', function(e){

        e.preventDefault();

        uploader = wp.media({
            title: 'Custom image',
            library : {
                uploadedTo : wp.media.view.settings.post.id,
                type : 'image'
            },
            button: {
                text: 'Insérer cette image'
            },
            multiple: false
        });
        
        uploader.on('select', function() {
            var attachment = uploader.state().get('selection').first().toJSON();
            if(attachment.id) {
                $('.upload_image_button').html('Modifier l\'image');
                $('.delete_image_button').css('display', 'inline');
                $('.preview_image').html('<img src="' + attachment.sizes.medium.url + '" class="attachment-medium size-medium" alt="" decoding="async" loading="lazy" sizes="(max-width: 239px) 100vw, 239px">');
            }
            $('.delete_image_button').parent().next().val(attachment.id);
            console.log(attachment.sizes.medium.url);
        })

        .open();

    });

    $('body').on('click', '.delete_image_button', function(e){

        e.preventDefault();

        $('.upload_image_button').html('Ajouter une image');
        $('.delete_image_button').css('display', 'none');
        $('.delete_image_button').parent().next().val('');
        $('.preview_image').html('');

    });

});