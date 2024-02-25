jQuery(function ($) {
	// Ouvrir et fermer la modale
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

	// Cocher/Décocher tous les enfants d'une checkbox parent et lui appliquer un état indéterminé
	function checkSiblings(el, checked) {
		let parent = el.parent().parent(),
			all = true;

		el.siblings().each(function () {
			let returnValue = (all = $(this).children('input[type="checkbox"]:not(:disabled)').prop('checked') === checked);
			return returnValue;
		});

		if (all && checked) {
			parent.children('input[type="checkbox"]:not(:disabled)').prop({
				indeterminate: false,
				checked: checked,
			});
			checkSiblings(parent, checked);
		} else if (all && !checked) {
			parent.children('input[type="checkbox"]:not(:disabled)').prop('checked', checked);
			parent.children('input[type="checkbox"]:not(:disabled)').prop('indeterminate', parent.find('input[type="checkbox"]:not(:disabled):checked').length > 0);
			checkSiblings(parent, checked);
		} else {
			el.parents('li').children('input[type="checkbox"]:not(:disabled)').prop({
				indeterminate: true,
				checked: false,
			});
		}
	}
	$('#subscription-form input[type="checkbox"]:not(:disabled)').change(function (e) {
		let checked = $(this).prop('checked'),
			container = $(this).parent();

		container.find('input[type="checkbox"]:not(:disabled)').prop({
			indeterminate: false,
			checked: checked,
		});

		checkSiblings(container, checked);
	});

	// Afficher les options de localité si Conférences ou Nouveaux cycles de Formations de la Voie de la Gestuelle sont cochées
	function displayLocalite(el) {
		if ($('#' + $.escapeSelector('{"post_type":"conference"}')).prop('checked') || $('#' + $.escapeSelector('{"post_type":"formation","voie":237}')).prop('checked')) {
			el.css('display', 'block');
		} else {
			el.css('display', 'none');
		}
	}
	$('#' + $.escapeSelector('{"post_type":"conference"}') + ', #' + $.escapeSelector('{"post_type":"formation","voie":237}')).change(function (e) {
		displayLocalite($('fieldset#localite'));
	});

	// Récupérer les données d'un abonnement
	$('input#title').on('input', function (e) {
		// Réinitialiser les champs si l'adresse mail saisie n'existe pas dans la base de données
		$('#subscription-btn').text("S'inscrire");
		if ($('#subscription-form .delete-btn').length !== 0) {
			$('#subscription-form .delete-btn').remove();
		}
		$('#subscription-form input[type="checkbox"]:not(:disabled)').prop('checked', false);

		// Récupérer les données du formulaire
		const ajaxurl = $('#subscription-form').attr('action');
		let data = {
			action: $('#update-action').val(),
			nonce: $('#update-nonce').val(),
			value: $(this).val(),
		};

		// Envoyer la requête ajax
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
				// En cas d'erreur, afficher un message d'erreur
				if (!body.success) {
					$('#subscription-form').html(body.data);
					return;
				}

				// En cas de réussite...

				// ... mettre à jour les checkbox
				$.each(body.data['evenements'], function () {
					let length = $(this).size();
					let i = 0;
					while (i < length) {
						$('#' + $.escapeSelector($(this)[i])).prop('checked', true);
						i++;
					}
				});
				$.each(body.data['zones'], function () {
					let length = $(this).size();
					let i = 0;
					while (i < length) {
						$('#' + $.escapeSelector($(this)[i])).prop('checked', true);
						i++;
					}
				});
				let checked = $('#subscription-form input[type="checkbox"]:checked');
				let container = checked.parent();
				checkSiblings(container, checked);
				displayLocalite($('fieldset#localite'));

				// ... récupérer l'ID de l'abonné
				$('#subscriber-id').val(body.data['ID']);

				// ... modifier le texte du bouton d'inscription
				$('#subscription-btn').text('Mettre à jour');

				// ... ajouter un bouton de désincription
				if ($('#subscription-form .delete-btn').length === 0) {
					$('#subscription-form').append(body.data['delete-btn']);
				}
			});
	});

	// Créer ou mettre à jour l'abonnement
	$('#subscription-form').submit(function (e) {
		e.preventDefault();

		// Récupérer les données du formulaire
		const ajaxurl = $(this).attr('action');
		let data = {
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

		// Envoyer la equête ajax
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
				// Afficher un message en cas de réussite ou d'erreur
				$('#subscription-form').html(body.data);
			});
	});

	// Supprimer l'abonnement
	$('#subscription-form').on('click', '.delete-btn', function (e) {
		e.preventDefault();

		// Récupérer les données du formulaire
		const ajaxurl = $(this).data('ajaxurl');
		let data = {
			action: $(this).data('action'),
			nonce: $(this).data('nonce'),
			id: $(this).data('id'),
		};

		// Envoyer la requête ajax
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
				// Afficher un message en cas de réussite ou d'erreur
				$('#subscription-form').html(body.data);
			});
	});
});
