<?php
/* recupera as paginas com extensao htm ou html do determinado $folder  */
function getHTMLFiles($folder){
	$arquivos = array();
	if ( $d = opendir($folder) ){
		
		/* le o diretorio arquivo por arquivo e armazena o nome do arquivo em $f */
		while (false !== ($f = readdir($d))) {
			
			/*se o arquivo termina com htm ou html adiciona o nome do arquivo no array arquivos */
			if (eregi("(htm|html)$",$f)){
				$arquivos[] = $f;
			}
		}
		
		closedir($d);
	}else{
		echo "nao foi possivel abrir a pasta onde estao os arquivos html";
		exit();
	}
	
	return $arquivos;
}



/* retorna um array com as stop words */
function getStopWords($str){
	
	$stopWords = array();
	
	$ar = explode(",",$str);
	
	foreach ($ar as $v) {
		$stopword = trim($v);
					
		if (strlen($stopword)){
			$stopword = ereg_replace("[ÁÀÂÃáàâãª]","a",$stopword);	
			$stopword = ereg_replace("[ÉÈÊéèê]","e",$stopword);	
			$stopword = ereg_replace("[ÍÌÏÎíìïî]","i",$stopword);
			$stopword = ereg_replace("[ÓÒÔÕóòôõº]","o",$stopword);	
			$stopword = ereg_replace("[ÚÙÛúùû]","u",$stopword);	
			$stopword = str_replace(array("Ç","ç"),"c",$stopword);
			$stopWords[] = strtolower($stopword);
		}
	}
	
	return $stopWords;
}

/*remove tags html*/
function limpaTags($str){
	
	/*limpa de <script até </script>*/
	while (($p1 = strpos($str,"<script")) !== false) {
		$p2 = strpos($str,"</script>");
		$str = substr_replace($str,"",$p1,($p2 - $p1) + strlen("</script>"));
	}
	
	/*limpa de <style até </style>*/
	while (($p1 = strpos($str,"<style")) !== false) {
		$p2 = strpos($str,"</style>");
		$str = substr_replace($str,"",$p1,($p2 - $p1) + strlen("</style>"));
	}
	
	/*limpa demais tags html*/
	$str = strip_tags($str);
	
	
	return $str;
}

/*o nome da funcao ja diz tudo.... ;)*/
function removeStopWords($str, $stopWords = array(),$id_pagina,&$con){
	
	
	/*troca tabulacoes e quebras de linha por um espaco em branco*/
	$str = str_replace(array("\r\n","\n\r","\n","\r","\t","&nbsp;")," ",$str);
	
	/*quando ha mais de um espaco ele substitui por um so*/
	$str = eregi_replace("[ ]{2,}"," ",$str);
	
	/*converte a string num array onde cada palavra separada por um espaco se torna um elemento do array*/
	$p = explode(" ",$str);
	
	/*para cada stop word em $v*/
	foreach ($stopWords as $v) {
		
		/*verifica se a stop word nao esta em branco*/
		if (strlen(trim($v))){
			
			/*para cada elemento do array de palavras do site*/
			foreach ($p as $k=>$v2) {
				
				$v2 = trim($v2);
				if (strlen($v2)){
					
					/*remove espacos do inicio e do fim*/
					$palavra = $v2;
					
					/*
					substitui caracteres especiais html pela sua respectiva letra sem a acentuacao
					*/
					$palavra =  eregi_replace("(.{0,})&([a-u]+)(acute|grave|circ|tilde|rdf|uml|rdm);(.{0,})","\\1\\2\\4",$palavra);
					
					
					/*tira acentuacao*/
					$palavra = ereg_replace("[ÁÀÂÃáàâãª]","a",$palavra);	
					$palavra = ereg_replace("[ÉÈÊéèê]","e",$palavra);	
					$palavra = ereg_replace("[ÍÌÏÎíìïî]","i",$palavra);
					$palavra = ereg_replace("[ÓÒÔÕóòôõº]","o",$palavra);	
					$palavra = ereg_replace("[ÚÙÛúùû]","u",$palavra);	
					$palavra = str_replace(array("Ç","ç"),"c",$palavra);
					
					
					/*remove demais caracteres e pontuacao, exemplo: palavra. */
					$palavra = eregi_replace("[^a-z0-9;&]","",$palavra);
					
					
					$stopword = $v;
					
					$palavra = strtolower($palavra);
					$p[$k] = $palavra;
					
					
					/*bate?*/
					if ($palavra == $stopword) {
						
						/*remove do array de palavras do site a stop word*/
						unset($p[$k]);
					}else{
						
						$sql = "select id from palavras where palavra = '$palavra'";
						$query = mysql_query($sql,$con);
						if (!mysql_numrows($query)){
							mysql_query("insert into palavras (palavra) values ('$palavra')",$con);
						}
						
					}
				}else{
					unset($p[$k]);
				}
			}
			/*coloca o ponteiro do array no inicio do mesmo*/
			reset($p);
		}
			
	}
	
	return $p;
	
}


function  calculaPeso($palavras,$id_pagina,&$con){	
		$total_palavras = count($palavras);
		
		$palavras_copia = $palavras;
		foreach ($palavras as $indice1=>$palavra) {
			
			if (strlen(trim($palavra))){
				$sql = "select id from palavras where palavra = '$palavra'";
				$query = mysql_query($sql,$con);
				if (!mysql_numrows($query) && strlen(trim($palavra))){
					mysql_query("insert into palavras (palavra) values ('$palavra')",$con);
					$id_palavra = mysql_insert_id($con);
				}else{
					$d = mysql_fetch_assoc($query);
					$id_palavra = $d['id'];
				}
				
				
				$count_palavra = 0;
				
				foreach ($palavras_copia as $indice2=>$palavra_copia) {
					if ($palavra_copia == $palavra){
						$count_palavra++;
						unset($palavras_copia[$indice2]);
						unset($palavras[$indice1]);
					}
				}
				
				$sql = "select 1 from palavras_paginas where palavra_id = $id_palavra and pagina_id = $id_pagina";
				
				$query = mysql_query($sql,$con);
				if (!mysql_num_rows($query)){
					mysql_query("insert into palavras_paginas (palavra_id,pagina_id,peso) values ($id_palavra,$id_pagina,". ($count_palavra / $total_palavras) .")");
					
				}
			}
		}
}
?>