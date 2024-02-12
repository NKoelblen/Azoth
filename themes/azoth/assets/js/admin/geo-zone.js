jQuery(function($){
    
    const children = $('#geo_zonechecklist .children')
    const items = $('#geo_zonechecklist input');
    const parentItems = $('#geo_zonechecklist input:not(.children input)');
    
    items.attr('type', 'radio');

    let open = [];

    children.each(function (key, val) {
        open[key] = false;
        val.style.setProperty('display', 'none');
        parentItems.on('change', function(e) {
            if (e.target.parentNode.parentNode.contains(val)){
                isOpen(val, key);
            } else if(open[key]) {
                isOpen(val, key);
            }
        });
    });

    function isOpen(element, key) {
        open[key] = !open[key];
        if(open[key]) {
            element.style.setProperty('display', 'block');
        } else {
            element.style.setProperty('display', 'none');
        }
    }
});