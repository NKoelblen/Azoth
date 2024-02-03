jQuery(function($){
    function openForm(element) {
        element.parent().next().css('display', 'block');
    }
    function closeForm(element) {
        element.parent().parent().css('display', 'none');
    }
    $('a.add').on('click', function(e) {
        e.preventDefault();
        openForm($(this));
    });
    $('a.modify').on('click', function(e) {
        e.preventDefault();
        openForm($(this));
    });
    $('.modal-inner .media-modal-close').on('click', function(e) {
        closeForm($(this));
    });
});