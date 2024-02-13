jQuery(function ($) {
	const items = $('#stage_categoriechecklist input');
	const voie = $('#e_voie').parent().parent().parent();

	items.attr('type', 'radio');
	items.prop('required', true);

	items.on('change', function (e) {
		if (e.target.parentNode.innerText === ' Le Mouvement Immobile') {
			voie.css('display', 'none');
		} else {
			voie.css('display', 'flex');
		}
	});
});
