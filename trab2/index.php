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
	
	//se existem stop words
	if ( count($stopwords)){
		
		//inclui as configuracoes do banco de dados
		include("dados_banco.php");
		
		//faz a conexao
		$con = mysql_connect($host,$user,$password);
		mysql_select_db($database,$con);
		
		//limpa a base de dados
		mysql_query("truncate palavras");
		mysql_query("truncate paginas");
		mysql_query("truncate palavras_paginas");
		
		/*para cada pagina html em $v*/
		foreach ($paginas as $v) {
			
			/*pega o conteudo e manda o resultado para a funcao limpaTags */
			$str = limpaTags( file_get_contents( $pasta_arquivos . "/" . $v) );
			
			$sql = "select id from paginas where pagina = '$v'";
			$query = mysql_query($sql,$con);
			if (!mysql_numrows($query)){
				mysql_query("insert into paginas (pagina) values ('$v')",$con);
				$id_pagina = mysql_insert_id($con);
			}else{
				$d = mysql_fetch_assoc($query);
				$id_pagina = $d['id'];
			}
			
			/*remove as stopwords*/
			$palavras = removeStopWords($str, $stopwords,$id_pagina,$con);
			
			
			//calcula o peso de cada palavra
			calculaPeso($palavras,$id_pagina,$con);
			
		}
		
		
		mysql_close($con);
		
	}else{
		echo "<center style='color: red;'>Você deve informar alguma stop word!</center>";
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
	<input type="submit" name="enviar" value="Gerar banco de dados" />
</div>
<br />
<center><b>Conte&uacute;do da pasta HTML</b></center><br />
<table cellpadding="2" style="margin: 0px auto 0px auto">
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
			<tr>
				<td colspan="2">
				Selecione um arquivo html para fazer o upload para a pasta HTML<br /><input type="file" name="novo_arquivo" /><br /><br />
			<input type="submit" name="upload" value="Realizar Upload" />
				</td>
			</tr>
			</table>
			<br />
			
			<center><a href="ver_banco.php">Ver banco de dados</a></center><br /><br />
			<center><a href="busca.php">Ir para a p&aacute;gina de busca</a></center>
</form>
</body>
</html>
