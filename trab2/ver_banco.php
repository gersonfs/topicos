<?php

//inclui as configuracoes do banco de dados
include("dados_banco.php");

//faz a conexao
$con = mysql_connect($host,$user,$password);
mysql_select_db($database,$con);

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
a{
	color: #0000ff;
}
-->
</style>
</head>
<body>

<table width="100%">
	<tr>
		<td valign="top">
		<table cellpadding="2">
		<tr>
			<td colspan="2"><b>Palavras</b></td>
		</tr>
		<tr>
			<td>ID</td>
			<td>Palavra</td>
		</tr>
		<?php
		$sql = "select * from palavras";		
		$q = mysql_query($sql);
		while ($d = mysql_fetch_assoc($q)) {
			echo '<tr>';
			echo '<td>'. $d['id'] .'</td>';
			echo '<td>'. $d['palavra'] .'</td>';
			echo '</tr>';
		}
		?>
		</table>
		</td>
		
		<td valign="top">
		
		<table cellpadding="2">
		<tr>
			<td colspan="2"><b>Palavras Paginas</b></td>
		</tr>
		<tr>
			<td>palavra_id</td>
			<td>pagina_id</td>
			<td>peso</td>
		</tr>
		<?php
		$sql = "select * from palavras_paginas";		
		$q = mysql_query($sql);
		while ($d = mysql_fetch_assoc($q)) {
			echo '<tr>';
			echo '<td>'. $d['palavra_id'] .'</td>';
			echo '<td>'. $d['pagina_id'] .'</td>';
			echo '<td>'. $d['peso'] .'</td>';
			echo '</tr>';
		}
		?>
		</table>
		
		</td>
		
		<td valign="top">
		
		<table cellpadding="2">
		<tr>
			<td colspan="2"><b>Paginas</b></td>
		</tr>
		<tr>
			<td>id</td>
			<td>Pagina</td>
		</tr>
		<?php
		$sql = "select * from paginas";		
		$q = mysql_query($sql);
		while ($d = mysql_fetch_assoc($q)) {
			echo '<tr>';
			echo '<td>'. $d['id'] .'</td>';
			echo '<td>'. $d['pagina'] .'</td>';
			echo '</tr>';
		}
		?>
		</table>
		
		</td>
	</tr>
</table><br />


<table>
<tr>
	<td colspan="3"><b>Ralação entre palavra pagina e peso</b></td>
</tr>

<?php
		$sql = "select p.palavra, pp.peso, pg.pagina  
				from palavras p, 
					 palavras_paginas pp, 
					 paginas pg 
				where p.id = pp.palavra_id and 
					  pp.pagina_id = pg.id";
		
		
		$q = mysql_query($sql);
		while ($d = mysql_fetch_assoc($q)) {
			echo '<tr>';
			echo '<td>'. $d['palavra'] .'</td>';
			echo '<td>'. $d['pagina'] .'</td>';
			echo '<td>'. $d['peso'] .'</td>';
			echo '</tr>';
		}
		?>
</table>

</body>
</html>
<?php
mysql_close($con);
?>