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
					$('textarea[name="content"]').insertAtCaret('<img class="aligncenter" src="' + res.data.url + '" />');
					$("html").find("iframe").contents().find("body").append('<img class="aligncenter" src="'+res.data.url+'" />'); 
				}
			})
		}
	});
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
    });
})