<?php

$pasta_arquivos = "htmls";
$pasta_temp = "temp";

include("funcoes.php");


/*se foi feito o upload*/
if (count($_POST) && count($_FILES) && isset($_FILES['novo_arquivo'])){
	
	/*se for um aqrquivo html*/
	if (eregi("(html|htm)$",$_FILES['novo_arquivo']['name'])){
		
		/*move o aarquivo para a pasta*/
		move_uploaded_file($_FILES['novo_arquivo']['tmp_name'],$pasta_arquivos . "/" . $_FILES['novo_arquivo']['name']);
	}
}


/*pega a lista de arquivos html*/
$paginas = getHTMLFiles($pasta_arquivos);


/* se foi feito um submit do formulario */
if( count($_POST) && isset($_POST['enviar']) ){
	
	/*pega a lista de stopwords*/
	$stopwords = getStopWords($_POST['stopwords']);
	
	/*para cada pagina html em $v*/
	foreach ($paginas as $v) {
		
		/*pega o conteudo e manda o resultado para a funcao limpaTags */
		$str = limpaTags( file_get_contents( $pasta_arquivos . "/" . $v) );
		
		/*remove as stopwords*/
		$str = removeStopWords($str, $stopwords);
		
		/*grava o arquivo na pasta temp*/
		file_put_contents($pasta_temp . "/" . $v,$str);
		
	}
	
}


/*pega a lista de arquivos html da pasta temp*/
$temp = getHTMLFiles($pasta_temp);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>T&oacute;picos Especiais em Computa&ccedil;&atilde;o - Gerson - Gustavo - Cl&aacute;udio</title>
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
<div align="center">Informe as STOPWORDS separadas por , ( v&iacute;rgula ) </div><br />
<form method="post" enctype="multipart/form-data">
<div style="text-align: center">
	<textarea name="stopwords" style="width: 300px; height: 100px;"></textarea><br />
	<input type="submit" name="enviar" value="Gerar Arquivos Tempor&aacute;rios" />
</div>
<table style="width: 600px; margin: 30px auto 0 auto;" cellspacing="5" cellpadding="3">
	<tr>
		<td><b>Conte&uacute;do da pasta HTML</b></td>
		<td><b>Conte&uacute;do da pasta Tempor&aacute;ria</b></td>
	</tr>
	<tr>
		<td>
			<table cellpadding="2">
			<?php 
			foreach ($paginas as $v) {
				echo '<tr>';
				echo '<td>
						<a href="ver_arquivo.php?arq='. urlencode($pasta_arquivos . "/" . $v) .'" target="_blank">' . $v . '</a>
					  </td>';
				echo '<td>
						<a href="ver_arquivo.php?arq='. urlencode($pasta_arquivos . "/" . $v) .'&ver=1" target="_blank">Ver</a>
					  </td>';
				echo '<td><a href="remover.php?arq='. urlencode($pasta_arquivos."/".$v) .'">Remover</a></td>';
				echo '</tr>';
			}
			?>
			</table>
			</td>
			
		<td>
			<table cellpadding="2">
				<?php 
				foreach ($temp as $v) {
					echo '<tr>';
					echo '<td>
							<a href="ver_arquivo.php?arq='. urlencode($pasta_temp . "/" . $v) .'" target="_blank">' . $v . '</a>
						  </td>';
					echo '<td>
						<a href="ver_arquivo.php?arq='. urlencode($pasta_temp . "/" . $v) .'&ver=1" target="_blank">Ver</a>
					  </td>';
					echo '<td><a href="remover.php?arq='. urlencode($pasta_temp."/".$v) .'">Remover</a></td>';
					echo '</tr>';
				}
				?>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			Selecione um arquivo html para fazer o upload para a pasta HTML<br /><input type="file" name="novo_arquivo" /><br /><br />
			<input type="submit" name="upload" value="Realizar Upload" />
			
		</td>
	</tr>
</table>
</form>
</body>
</html>
