<?php
include_once($_SERVER['DOCUMENT_ROOT']."/member/check_auth.php");
class SimpleImage {
 
   var $image;
   var $image_type;
 
   function load($filename) {
 
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
 
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
 
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
 
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
 
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($this->image,$filename);
      }
      if( $permissions != null) {
 
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
 
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($this->image);
      }
   }
   function getWidth() {
 
      return imagesx($this->image);
   }
   function getHeight() {
 
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
 
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
 
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
 
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }
 
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }      
 
}
$targetFolder = '/upload/'; 
$verifyToken = md5($_SESSION['usr'] . $_POST['timestamp']);
if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
    $tempFile = $_FILES['Filedata']['tmp_name'];
    if ($_FILES["Filedata"]["size"] > 512000) {
        echo 'The file is to big, MAX 500KB';
        die();
    }
    $targetPath = "/home2/infiniz7" . $targetFolder;
    $fileName = $verifyToken . substr($_FILES['Filedata']['name'],-4);
    $regex = '/^([\d\w\.-])*(\.png|\.jpge?|\.gif)$/';
    while(file_exists($targetPath . "/" . $fileName)) {
        $fileName = md5(mt_rand() . time()) .substr($_FILES['Filedata']['name'],-4);    
    }
    $targetFile = rtrim($targetPath,'/') . '/' . $fileName;
    $regex = '/^([\d\w\.-])*(\.png|\.jpge?|\.gif)$/';
    if (preg_match($regex,$_FILES['Filedata']['name'])) {
    
   $image = new SimpleImage();
   $image->load($tempFile);
   $image->resize(200,200);
   $image->save($targetFile);
        
       // move_uploaded_file($tempFile,$targetFile);
        
        
    @$con = mysql_connect(SQL_SERVER, SQL_USR, SQL_PWD) or die(mysql_error());
    @mysql_select_db(SQL_DB) or die(mysql_error());
    //$SQL = "UPDATE memberinfo SET sex = '$sex', country = '$country', location = '$location', signature = '$signature', about = '$about', age = '$age', wd = '$wd', wn = '$wn', portfolio = '$portfolio', interests = '$interests', skills = '$skills', resume = '$resume' WHERE username = '$_SESSION[usr]'";
    $SQL = "UPDATE memberinfo SET image ='$fileName' WHERE username = '$_SESSION[usr]'";
    
    $result = mysql_query($SQL)or die(mysql_error());  
    @mysql_close($con);
        
        
        $_SESSION["usrdata"]['usr_img'] = $fileName;
        echo $fileName;
    } else {
        echo 'Invalid file type.';
    }
} else {
    echo 'Your IP address has been logged due to suspicious activity.';
}
?>