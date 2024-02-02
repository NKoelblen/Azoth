jQuery(function($){
    const pays = $('#l_pays');
    const region = $('#l_region');
    if (pays.find('option:selected').text().indexOf("France") >= 0) {
        region.parent().parent().css('display', 'inline-block');
    } else {
        region.parent().parent().css('display', 'none');
    }
    pays.on('change', function() {
        if (pays.find('option:selected').text().indexOf("France") >= 0) {
            region.parent().parent().css('display', 'inline-block');
        } else {
            region.parent().parent().css('display', 'none');
            region.find('option:selected').prop("selected", false);
            region.find('option[value=""]').prop("selected", true);
        }
    })
});