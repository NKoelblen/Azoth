jQuery(function ($) {
	const items = $('#stage_categoriechecklist input');
	let days = 1;
	function date_au() {
		$('#e_date_du').on('change', function () {
			let date = new Date($(this).val());
			if (!isNaN(date.getTime())) {
				date.setDate(date.getDate() + days);

				$('#e_date_au').val(date.toInputFormat());
			}
		});
	}
	date_au();
	items.on('change', function (e) {
		if (e.target.parentNode.innerText === ' Stage en extérieur') {
			days = 2;
		} else {
			days = 1;
		}
		date_au();
	});

	//From: http://stackoverflow.com/questions/3066586/get-string-in-yyyymmdd-format-from-js-date-object
	Date.prototype.toInputFormat = function () {
		var yyyy = this.getFullYear().toString();
		var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based
		var dd = this.getDate().toString();
		return (
			yyyy +
			'-' +
			(mm[1] ? mm : '0' + mm[0]) +
			'-' +
			(dd[1] ? dd : '0' + dd[0])
		); // padding
	};
});
