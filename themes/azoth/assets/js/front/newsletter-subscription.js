jQuery(function ($) {
	// function openForm() {
	// 	element.css('display', 'flex');
	// }
	// function closeForm() {
	// 	element.parent().parent().css('display', 'none');
	// }

	// closeForm($('.modal-inner .modal-close'));

	// $('a.add').on('click', function (e) {
	// 	e.preventDefault();
	// 	openForm();
	// });

	// $('.modal-inner .modal-close').on('click', function (e) {
	// 	closeForm();
	// });

	$('#subscription-form').submit(function (e) {
		e.preventDefault();

		const ajaxurl = $(this).attr('action');

		const data = {};

		$(this)
			.find('input')
			.each(function () {
				// console.log($(this));
				if (
					$(this).attr('type') === 'checkbox' &&
					$(this).is(':checked')
				) {
					data[$(this).attr('name')] = $(this).val();
				} else if ($(this).attr('type') !== 'checkbox') {
					data[$(this).attr('name')] = $(this).val();
				}
			});

		console.log(data);

		// Requête Ajax en JS natif via Fetch
		fetch(ajaxurl, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
				'Cache-Control': 'no-cache',
			},
			body: new URLSearchParams(data),
		})
			.then((response) => response.json())
			.then((body) => {
				console.log(body.data);
				// En cas d'erreur
				if (!body.success) {
					$('#subscription-form').append(body.data);
					return;
				}
				// Et en cas de réussite
				$('#subscription-form').append(body.data);
			});
	});
});
