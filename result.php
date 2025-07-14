<?php

$file =$_FILES["foo"]["name"];
$checkPictutre = getimagesize($_FILES["foo"]["tmp_name"]);

echo pathinfo($file, PATHINFO_FILENAME);
echo $checkPictutre[0];
echo $checkPictutre[1];


?>