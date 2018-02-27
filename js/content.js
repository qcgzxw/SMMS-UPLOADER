jQuery(document).ready(function($) {
	$('#admin-img-file').change(function() {
		for (var i = 0; i < this.files.length; i++) {
			var f = this.files[i];
			var formData = new FormData();
			formData.append('smfile', f);
			$.ajax({
				url: 'https://sm.ms/api/upload',
				type: 'POST',
				processData: false,
				contentType: false,
				data: formData,
				success: function(res) {
					$('textarea[name="content"]').val($('textarea[name="content"]').val() + '<img class="aligncenter" src="' + res.data.url + '" />').focus();
					$("html").find("iframe").contents().find("body").append('<img class="aligncenter" src="' + res.data.url + '" />');
				}
			})
		}
	});
})