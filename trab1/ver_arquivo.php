<?php
$file = urldecode( $_GET['arq'] );

if (isset($_GET['ver'])){
	echo file_get_contents($file);
}else{
	header("Content-Type: application/save") ;
	header("Content-Length:".filesize($file)); 
	header('Content-Disposition: attachment; filename="' . $file . '"'); 
	header("Content-Transfer-Encoding: binary");
	header('Expires: 0'); 
	header('Pragma: no-cache'); 
	
	
	$fp = fopen("$file", "r"); 
	fpassthru($fp); 
	fclose($fp); 
}

?>