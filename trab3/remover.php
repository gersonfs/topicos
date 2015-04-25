<?php
$arquivo = urldecode( $_GET['arq'] );
if (eregi("^(htmls|temp)",$arquivo)){
	unlink($arquivo);
}

header("location: index.php");
?>