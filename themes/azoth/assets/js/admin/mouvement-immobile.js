jQuery(function ($) {
	const items = $('#stage_categoriechecklist input');
	const voie = $('#e_voie').parent().parent().parent();

	items.attr('type', 'radio');
	items.prop('required', true);

	items.on('change', function (e) {
		if (e.target.parentNode.innerText === ' Le Mouvement Immobile') {
			voie.css('display', 'none');
			voie.find('#e_voie').prop('required', false);
		} else {
			voie.css('display', 'flex');
			voie.find('#e_voie').prop('required', true);
		}
	});
});
