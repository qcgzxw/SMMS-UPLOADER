$('#zz-img-file').change(function() {
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
			beforeSend: function(xhr) {
				$('#zz-img-add').text('Uploading...')
			},
			success: function(res) {
				$("#zz-img-add").text('上传图片');
				$('#zz-img-show').append('<img src="' + res.data.url + '" />');
				$('textarea[name="comment"]').val($('textarea[name="comment"]').val() + '<img src="' + res.data.url + '" />').focus()
			}
		})
	}
});