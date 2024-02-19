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

	$('input#title').on('input', function (e) {
		console.log('test');
		if ($('#subscriber-id').length !== 0) {
			$('#subscriber-id').remove();
		}
		$('#subscription-btn').text("S'inscrire");
		if ($('#subscription-form .delete-btn').length !== 0) {
			$('#subscription-form .delete-btn').remove();
		}
		$('#subscription-form input[type="checkbox"]:not(:disabled)').prop(
			'checked',
			false
		);

		let ajaxurl = $('#subscription-form').attr('action');

		let data = {
			action: $('#update-action').val(),
			nonce: $('#update-nonce').val(),
			value: $(this).val(),
		};

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
				console.log(body);
				if (!body.success) {
					$('#subscription-form').html(body.data);
					return;
				}
				$.each(body.data['meta-values'], function () {
					if ($(this)[0].match('^{')) {
						$('#' + $.escapeSelector($(this)[0])).prop(
							'checked',
							true
						);
					}
				});
				if ($('#subscriber-id').length === 0) {
					$('#subscription-form').append(
						'<input type="hidden" id="subscriber-id" name="subscriber-id" value="' +
							body.data['ID'] +
							'">'
					);
				}
				$('#subscription-btn').text('Mettre à jour');
				if ($('#subscription-form .delete-btn').length === 0) {
					$('#subscription-form').append(body.data['delete-btn']);
				}
			});
	});

	$('#subscription-form').on('click', $('delete-btn'), function (e) {
		e.preventDefault();

		console.log($(this));

		const ajaxurl = $('#subscription-form .delete-btn').data('ajaxurl');

		let data = {
			action: $('#subscription-form .delete-btn').data('action'),
			nonce: $('#subscription-form .delete-btn').data('nonce'),
			id: $('#subscription-form .delete-btn').data('id'),
		};

		console.log(data);

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
				$('#subscription-form').html(body.data);
			});
	});

	$('#subscription-form').submit(function (e) {
		e.preventDefault();

		let ajaxurl = $(this).attr('action');

		data = {};

		$(this)
			.find('input')
			.each(function () {
				if (
					$(this).attr('type') === 'checkbox' &&
					$(this).is(':checked')
				) {
					data[$(this).attr('name')] = $(this).val();
				} else if ($(this).attr('type') !== 'checkbox') {
					data[$(this).attr('name')] = $(this).val();
				}
			});

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
				$('#subscription-form').html(body.data);
			});
	});
});
