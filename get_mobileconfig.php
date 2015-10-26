<?php
$name_file = "device.mobileconfig";
if( file_exists($name_file) ) {
	$file = fopen($name_file, "r");
	if ($file === false) {
		echo "Unable to open file!";
		die;
	}
	header("Content-type: application/x-apple-aspen-config; chatset=utf-8");
	header("Content-Disposition: attachment; filename=\"$name_file\"");
	echo fread($file,filesize($name_file));
}else{
	echo "File Not Found.";
	die;
}