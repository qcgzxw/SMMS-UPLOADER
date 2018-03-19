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
				//$('textarea[name="comment"]').val($('textarea[name="comment"]').val() + '<img src="' + res.data.url + '" />').focus(); 
				$('textarea[name="comment"]').insertAtCaret('<img src="' + res.data.url + '" />');  
			}
		})
	}
});

(function($) {  
    $.fn.extend({  
        insertAtCaret: function(myValue) {  
            var $t = $(this)[0];  
              //IE  
            if (document.selection) {  
                this.focus();  
                sel = document.selection.createRange();  
                sel.text = myValue;  
                this.focus();  
            } else  
            //!IE  
            if ($t.selectionStart || $t.selectionStart == "0") {  
                var startPos = $t.selectionStart;  
                var endPos = $t.selectionEnd;  
                var scrollTop = $t.scrollTop;  
                $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);  
                this.focus();  
                $t.selectionStart = startPos + myValue.length;  
                $t.selectionEnd = startPos + myValue.length;  
                $t.scrollTop = scrollTop;  
            } else {  
                this.value += myValue;  
                this.focus();  
            }  
        }  
    })  
})(jQuery);  