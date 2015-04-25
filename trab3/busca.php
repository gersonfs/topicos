<?php

include("dados_banco.php");
include("funcoes.php");

$con = mysql_connect($host,$user,$password);
mysql_select_db($database,$con);

$paginas = array();

if (count($_POST)){
	$palavra = trim($_POST['palavra']);
	$palavra = ereg_replace("[ÁÀÂÃáàâãª]","a",$palavra);	
	$palavra = ereg_replace("[ÉÈÊéèê]","e",$palavra);	
	$palavra = ereg_replace("[ÍÌÏÎíìïî]","i",$palavra);
	$palavra = ereg_replace("[ÓÒÔÕóòôõº]","o",$palavra);	
	$palavra = ereg_replace("[ÚÙÛúùû]","u",$palavra);	
	$palavra = str_replace(array("Ç","ç"),"c",$palavra);
	$similaridade_l = $_POST['similaridade_l'];
	$similaridade_n = $_POST['similaridade_n'];
	$similaridade_a = $_POST['similaridade_a'];
	$algoritmo = $_POST['algoritmo'];
	
	$palavra = strtolower($palavra);
	
	$sql = "select pg.pagina 
			from palavras p, 
				 palavras_paginas pp, 
				 paginas pg 
			where p.id = pp.palavra_id and 
				  pp.pagina_id = pg.id and 
				  p.palavra = '$palavra' 
			order by pp.peso desc";
	
	$q = mysql_query($sql);
	while ($d = mysql_fetch_assoc($q)) {
		$paginas[] = $d['pagina'];
	}
	
	
	if ($algoritmo != 'nenhum'){
	
		$sql = "select pg.pagina, p.palavra 
				from palavras p, 
					 palavras_paginas pp, 
					 paginas pg 
				where p.id = pp.palavra_id and 
					  pp.pagina_id = pg.id
				order by p.id asc";
		
		$q = mysql_query($sql);
		$pagina_palavras = array();
		while ($d = mysql_fetch_assoc($q)) {
			if (!isset($pagina_palavras[$d['pagina']])) $pagina_palavras[$d['pagina']] = array();
			$pagina_palavras[$d['pagina']][] = $d['palavra'];
		}
		
		if ($algoritmo == 'levenshtein'){
			foreach ($pagina_palavras as $pagina=>$ps) {
				foreach ($ps as $v) {
					if (levdis($palavra,$v) >= $similaridade_l && !in_array($pagina,$paginas)) $paginas[] = $pagina;
				}
			}
		}
		
		if ($algoritmo == 'ngrams'){
			foreach ($pagina_palavras as $pagina=>$ps) {
				foreach ($ps as $v) {
					if (compareNGrams($palavra,$v) >= $similaridade_n && !in_array($pagina,$paginas)) $paginas[] = $pagina;
				}
			}
		}
		
		$total = strlen($palavra);
		
		if ($algoritmo == 'acronyms'){
			foreach ($pagina_palavras as $pagina=>$palavras) {
				for ($x = 0; $x < count($palavras); $x++){
					
					if (eregi("^" . substr($palavra,0,1),$palavras[$x])){
						
						$achou = true;
						$proxima_palavra = $x+1;
						for ($k = 1; $k < $total; $k++){
							if (!isset($palavras[$proxima_palavra]) || !eregi("^" . substr($palavra,$k,1),$palavras[$proxima_palavra] )){
								$achou = false;
							}
							$proxima_palavra++;
						}
						
						if ($achou && !in_array($pagina,$paginas)){
							$paginas[] = $pagina;
						}
					}
				}
			}
		}
		
		if ($algoritmo == 'acronyms2'){
			foreach ($pagina_palavras as $pagina=>$palavras) {
				for ($x = 0; $x < count($palavras); $x++){
					
					if (eregi("^" . substr($palavra,0,1),$palavras[$x])){
						$str = "";
						for ($k = $x; $k < $x + $total; $k++)
							if (isset($palavras[$k]))
								$str.= substr($palavras[$k],0,1);
						
						
						if (levdis(strtolower($str),strtolower($palavra)) >= $similaridade_a && !in_array($pagina,$paginas)){
							$paginas[] = $pagina;
						}
					}
				}
			}
		}
	
	}
	
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
.style1 {font-size: 9px}
-->
</style>
</head>
<body>
<h1>Realizar Busca</h1>
<form method="post">
	<table width="100%" align="center">
		<tr>
			<td>Termo a ser buscado: 
			  <input type="text" name="palavra" /></td>
		</tr>
		<tr>
			<td align="center"><p align="left">Selecione um algoritmo de busca:<br />
			    <label for="levenshtein_id"><input id="levenshtein_id" name="algoritmo" type="radio" value="levenshtein" />		        <strong>Levenshtein</strong></label> - Similaridade: 
		      <input name="similaridade_l" type="text" id="similaridade_l" />
		      <span class="style1">(similaridade &eacute; um valor de 0 &agrave; 1, exemplo: 0.85)</span><br />			  
			  <label for="ngrams_id"><input id="ngrams_id" name="algoritmo" type="radio" value="ngrams" />
			  <strong>N-Grams</strong></label> - Similaridade: 
			  <input name="similaridade_n" type="text" id="similaridade_n" />
			  <span class="style1">(similaridade &eacute; um valor de 0 &agrave; 1, exemplo: 0.85)</span><br />
			  <label for="acronyms_id"><input name="algoritmo" id="acronyms_id" type="radio" value="acronyms" />
			  <strong>Acronyms</strong></label><br />
			  
			  <label for="acronyms2_id"><input id="acronyms2_id" name="algoritmo" type="radio" value="acronyms2" />
			  <strong>Acronyms + Levenshtein</strong></label> - Similaridade: 
			  <input name="similaridade_a" type="text" id="similaridade_a" />
			  <span class="style1">(similaridade &eacute; um valor de 0 &agrave; 1, exemplo: 0.85)</span><br />
			  
			  <label for="nenhum_id"><input id="nenhum_id" name="algoritmo" type="radio" value="nenhum" checked="checked" />
			  N&atilde;o usar algoritmos de similaridade  </label><br />
			    
	          <input type="submit" name="enviar" value="Buscar" />
	      </p>
		  </td></tr>
  </table>
</form>

<?php
if (count($paginas)){
	echo '<br /><br /><table border="1" cellpadding="5" style="margin: 0px auto 0px auto;">';
	echo '<tr><td><b>Página</b></td></tr>';
	foreach ($paginas as $v) {
		echo '<tr>';
			echo '<td>'. $v .'</td>';
		echo '</tr>';
	}
	echo '</table>';
}

if (!count($paginas) && count($_POST)){
	echo '<br /><br /><center style="color: red;">Nenhum resultado encontrado!</center>'; 
}

?>
</body>
</html>
<?php
mysql_close($con);
?>