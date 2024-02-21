jQuery(function ($) {
	$('#informations input[type="checkbox"]:not(:disabled)').change(
		function () {
			let checked = $(this).prop('checked'),
				container = $(this).parent();
			// siblings = container.siblings();

			container.find('input[type="checkbox"]:not(:disabled)').prop({
				indeterminate: false,
				checked: checked,
			});

			function checkSiblings(el) {
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
					parent
						.children('input[type="checkbox"]:not(:disabled)')
						.prop({
							indeterminate: false,
							checked: checked,
						});

					checkSiblings(parent);
				} else if (all && !checked) {
					parent
						.children('input[type="checkbox"]:not(:disabled)')
						.prop('checked', checked);
					parent
						.children('input[type="checkbox"]:not(:disabled)')
						.prop(
							'indeterminate',
							parent.find(
								'input[type="checkbox"]:not(:disabled):checked'
							).length > 0
						);
					checkSiblings(parent);
				} else {
					el.parents('li')
						.children('input[type="checkbox"]:not(:disabled)')
						.prop({
							indeterminate: true,
							checked: false,
						});
				}
			}

			checkSiblings(container);
		}
	);
});
