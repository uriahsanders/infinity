<div id="uploadProfile">
<form id="upload_form" enctype="multipart/form-data" method="post" action="/extra/imgUpload/upload.php" onsubmit="return checkForm()">
    <input type="hidden" id="x1" name="x1" />
    <input type="hidden" id="y1" name="y1" />
    <input type="hidden" id="x2" name="x2" />
    <input type="hidden" id="y2" name="y2" />
    <input type="hidden" id="w" name="w" />
    <input type="hidden" id="h" name="h" />
    <input type="hidden" id="id" name="id" value="<?php echo $_GET['ID']; ?>"/>
    <input type="file" name="image_file" id="image_file" onchange="fileSelectHandler()" /><br />
    <div class="error"></div>
    <div class="step2">
        <img id="preview" />
        <input type="submit" value="Upload" />
    </div>
</form>
</div>