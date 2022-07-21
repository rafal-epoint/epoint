$(document).ready(function(){

	$("#submit").click(function(event) {
		event.preventDefault();

		var name = $('#name').val();
		var countryCode = $('#country').val();
		var jqxhr = $.ajax("/gender.php?name=" + name + "&countryCode=" + countryCode)
			.done(function(data) {
				$('#result').text(data);
			})
			.fail(function() {
				console.log("AJAX error");
			})
			.always(function() {
				console.log("AJAX complete");
			});

	});

});