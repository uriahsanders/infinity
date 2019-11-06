/**
 *
 * HTML5 Image uploader with Jcrop
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Script Tutorials
 * http://www.script-tutorials.com/
 */

// check for selected crop region
function checkForm() {
    if (!parseInt($('#w').val()))
	{
		$('.error').html('Please select a crop region and then press Upload').show();
		return false;
	}
	else if (boundy < imgY && boundx < imgX) return false; 

	
		
    return true;
};
var imgX = 250, imgY = 250;
function XY()
{
	if (parseInt($("#id").val())==1)
	{
		imgX = 250;
		imgY = 250;
	}
	else
	{
		imgX = 870;
		imgY = 180;	
	}
}
// update info by cropping (onChange and onSelect events handler)
function updateInfo(e) {
    $('#x1').val(e.x);
    $('#y1').val(e.y);
    $('#x2').val(e.x2);
    $('#y2').val(e.y2);
    $('#w').val(e.w);
    $('#h').val(e.h);
};

// clear info by cropping (onRelease event handler)
function clearInfo() {
    $('#w').val('');
    $('#h').val(''); 
};
var  boundx, boundy, jcrop_api;
function fileSelectHandler() {
    if (typeof jcrop_api != 'undefined')
	{ 
    	jcrop_api.destroy();
		$("#preview").attr({"src":"", "style":""});	
	}
    var oFile = $('#image_file')[0].files[0];

    // hide all errors
    $('.error').hide();

    // check for image type (jpg and png are allowed)
    var rFilter = /^(image\/jpeg|image\/png)$/i;
    if (! rFilter.test(oFile.type)) {
        $('.error').html('Please select a valid image file (jpg and png are allowed)').show();
        return;
    }

    // check for file size
    if (oFile.size > 500 * 1024) {
        $('.error').html('You have selected too big file, please select a one smaller image file').show();
        return;
    }

    // preview element
    var oImage = document.getElementById('preview');

    // prepare HTML5 FileReader
    var oReader = new FileReader();
        oReader.onload = function(e) {

        // e.target.result contains the DataURL which we can use as a source of the image
        oImage.src = e.target.result;
        oImage.onload = function () { // onload event handler

            // display step 2
            $('.step2').fadeIn(500);

            // Create variables (in this scope) to hold the Jcrop API and image size
            
		

            // initialize Jcrop
            jcrop_api = $.Jcrop('#preview',{
                minSize: [imgX, imgY], // min crop size
                aspectRatio: ((imgX== 250)?1:(29 / 6)), // keep aspect ratio 1:1
                bgFade: true, // use fade effect
				bgColor: 'black',
				bgOpacity: .4,
				setSelect: [0,0, imgX,imgY],
                onChange: updateInfo,
                onSelect: updateInfo,
                onRelease: clearInfo
            });
			var bounds = jcrop_api.getBounds();
                boundx = bounds[0];
                boundy = bounds[1];
			
			if (boundx < imgX || boundy < imgY)
			{
				$('.error').html('Image must be atleast '+imgX+'x'+imgY).show();
				jcrop_api.destroy();
				$("#preview").attr({"src":"", "style":""});
				$("#image_file").val("");
			}
        };
    };
	
    // read selected file as DataURL
    oReader.readAsDataURL(oFile);
}