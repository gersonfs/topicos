<?php


$resultados = array();

if (count($_POST)){
	include("dados_banco.php");
	$con = mysql_connect($host,$user,$password);
	mysql_select_db($database,$con);
	
	$palavra = trim($_POST['palavra']);
	$palavra = ereg_replace("[ÁÀÂÃáàâãª]","a",$palavra);	
	$palavra = ereg_replace("[ÉÈÊéèê]","e",$palavra);	
	$palavra = ereg_replace("[ÍÌÏÎíìïî]","i",$palavra);
	$palavra = ereg_replace("[ÓÒÔÕóòôõº]","o",$palavra);	
	$palavra = ereg_replace("[ÚÙÛúùû]","u",$palavra);	
	$palavra = str_replace(array("Ç","ç"),"c",$palavra);
	
	$palavra = strtolower($palavra);
	
	
	$sql = "select pg.pagina, pp.peso  
			from palavras p, 
				 palavras_paginas pp, 
				 paginas pg 
			where p.id = pp.palavra_id and 
				  pp.pagina_id = pg.id and 
				  p.palavra = '$palavra' 
			order by pp.peso desc";
	
	
	$q = mysql_query($sql);
	while ($d = mysql_fetch_assoc($q)) {
		$resultados[] = $d;
	}
	
	mysql_close($con);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>T&oacute;picos Especiais em Computa&ccedil;&atilde;o - Gerson - Gustavo - Cl&aacute;udio - Marcus Rosa</title>
<style type="text/css">
<!--
*{
	font-family: verdana;
	font-size: 11px;
}
h1{
	font-size: 16px;
	text-align: center;
}
a{
	color: #0000ff;
}
-->
</style>
</head>
<body>
<h1>Relizar Busca</h1>
<form method="post">
	<table align="center">
		<tr>
			<td><input type="text" name="palavra" /></td>
		</tr>
		<tr>
			<td align="center"><input type="submit" name="enviar" value="Buscar" /></td>
		</tr>
	</table>
</form>

<?php
if (count($resultados)){
	echo '<br /><br /><table border="1" cellpadding="5" style="margin: 0px auto 0px auto;">';
	echo '<tr><td><b>Página</b></td><td><b>Peso</b></td></tr>';
	foreach ($resultados as $v) {
		echo '<tr>';
			echo '<td>'. $v['pagina'] .'</td>';
			echo '<td>'. $v['peso'] .'</td>';
		echo '</tr>';
	}
	echo '</table>';
}

if (!count($resultados) && count($_POST)){
	echo '<br /><br /><center style="color: red;">Nenhum resultado encontrado!</center>'; 
}

?>
</body>
</html>