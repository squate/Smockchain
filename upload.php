<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is actually an image file
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  }
  else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}
// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}
// Check the file size
if ($_FILES["fileToUpload"]["size"] > 3000000) {
  echo "Sorry, your file is too large.";
  echo "The max size of a file can be 3MB";
  $uploadOk = 0;
}
// Allow certain file formats only
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" && $imageFileType != "tif") {
      echo "Sorry, only jpg, png, gif, and tif files are allowed.";
      $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
}
// if everything is okay, try to upload the file
else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ".basename($_FILES["fileToUpload"]["name"]). " has been uploaded.";
  }
  else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>
