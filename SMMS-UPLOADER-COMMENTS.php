<?php
function comment_upload_img() {
echo '<div class="zz-add-img"><input id="zz-img-file" type="file" accept="image/*" multiple="multiple"><div id="zz-img-add">上传图片</div><div id="zz-img-show"></div></div>';
}
function admin_upload_img() {
    echo '<a href="javascript:;" class="file">选择文件<input id="admin-img-file" type="file" accept="image/*" multiple="multiple"></a>';
}
