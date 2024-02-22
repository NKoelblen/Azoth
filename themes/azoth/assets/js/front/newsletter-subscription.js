jQuery(function ($) {
	function checkSiblings(el, checked) {
		let parent = el.parent().parent(),
			all = true;

		el.siblings().each(function () {
			let returnValue = (all =
				$(this)
					.children('input[type="checkbox"]:not(:disabled)')
					.prop('checked') === checked);
			return returnValue;
		});

		if (all && checked) {
			parent.children('input[type="checkbox"]:not(:disabled)').prop({
				indeterminate: false,
				checked: checked,
			});

			checkSiblings(parent, checked);
		} else if (all && !checked) {
			parent
				.children('input[type="checkbox"]:not(:disabled)')
				.prop('checked', checked);
			parent
				.children('input[type="checkbox"]:not(:disabled)')
				.prop(
					'indeterminate',
					parent.find('input[type="checkbox"]:not(:disabled):checked')
						.length > 0
				);
			checkSiblings(parent, checked);
		} else {
			el.parents('li')
				.children('input[type="checkbox"]:not(:disabled)')
				.prop({
					indeterminate: true,
					checked: false,
				});
		}
	}

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
				console.log(body.data);

				if (!body.success) {
					$('#subscription-form').html(body.data);
					return;
				}
				$.each(body.data['evenements'], function () {
					let length = $(this).size();
					let i = 0;
					while (i < length) {
						$('#' + $.escapeSelector($(this)[i])).prop(
							'checked',
							true
						);
						i++;
					}
				});
				$.each(body.data['zones'], function () {
					let length = $(this).size();
					let i = 0;
					while (i < length) {
						$('#' + $.escapeSelector($(this)[i])).prop(
							'checked',
							true
						);
						i++;
					}
				});
				let checked = $(
					'#subscription-form input[type="checkbox"]:checked'
				);
				let container = checked.parent();

				checkSiblings(container, checked);

				console.log(body.data);

				$('#subscriber-id').val(body.data['ID']);
				$('#subscription-btn').text('Mettre à jour');
				if ($('#subscription-form .delete-btn').length === 0) {
					$('#subscription-form').append(body.data['delete-btn']);
				}
			});
	});

	$('#subscription-form input[type="checkbox"]:not(:disabled)').change(
		function (e) {
			let checked = $(this).prop('checked'),
				container = $(this).parent();

			container.find('input[type="checkbox"]:not(:disabled)').prop({
				indeterminate: false,
				checked: checked,
			});

			checkSiblings(container, checked);
		}
	);

	$('#subscription-form').on('click', '.delete-btn', function (e) {
		e.preventDefault();

		const ajaxurl = $(this).data('ajaxurl');

		let data = {
			action: $(this).data('action'),
			nonce: $(this).data('nonce'),
			id: $(this).data('id'),
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
				$('#subscription-form').html(body.data);
			});
	});

	$('#subscription-form').submit(function (e) {
		e.preventDefault();

		let ajaxurl = $(this).attr('action');

		data = {
			action: $('#action').val(),
			nonce: $('#nonce').val(),
			id: $('#subscriber-id').val(),
			email: $('#subscription-form #title').val(),
			blog: [$('#subscription-form #posts').val()],
			evenements: [],
			zones: [],
		};

		$(this)
			.find('input[name="evenements[]"')
			.each(function () {
				if ($(this).is(':checked')) {
					data['evenements'].push($(this).val());
				}
			});
		$(this)
			.find('input[name="zones[]"')
			.each(function () {
				if ($(this).is(':checked')) {
					data['zones'].push($(this).val());
				}
			});

		data['evenements'] = JSON.stringify(data['evenements']);
		data['zones'] = JSON.stringify(data['zones']);

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
				$('#subscription-form').html(body.data);
			});
	});
});
