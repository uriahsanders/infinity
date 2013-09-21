<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/member/check_auth.php");
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="/test/upload/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/test/upload/upload.css">

    <form>
        <div id="queue"></div>
        <table border=0>
            <tr>
                <td><div id="show_img"></div></td>
                <td>
                    <input id="file_upload" name="file_upload" type="file" multiple="false">
                </td>
            </tr>
        </table>
    </form>

    <script type="text/javascript">
        <?php $timestamp = time();?>
        $(function() {
            $('#file_upload').uploadify({
                'formData'     : {
                    'timestamp' : '<?php echo $timestamp;?>',
                    'token'     : '<?php echo md5($_SESSION['usr']. $timestamp);?>'
                },
                'buttonText' : 'UPLOAD IMAGE',
                'fileSizeLimit' : '500KB',
                'multi'    : false,
                'width'    : 100,
                'fileTypeExts' : '*.gif; *.jpg; *.png',
                'swf'      : '/test/upload/upload_f.swf',
                'uploader' : '/test/upload/upload_f.php',
                'onUploadSuccess' : function(file, data, response) {
                    $("#show_img").html('<img src="/images/image.php?id='+data+'" height="200" width="200" />');
                }
            });
        });
    </script>
