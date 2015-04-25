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
	
	return explode(",",$str);
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
function removeStopWords($str, $stopWords = array()){
	
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
				
				
				/*remove espacos do inicio e do fim*/
				$palavra = trim($v2);
				
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
				
				
				/*remove espacos do inicio e do fim*/
				$stopword = trim($v);
				
				/*remove caracteres especiais*/
				$stopword = ereg_replace("[ÁÀÂÃáàâãª]","a",$stopword);	
				$stopword = ereg_replace("[ÉÈÊéèê]","e",$stopword);	
				$stopword = ereg_replace("[ÍÌÏÎíìïî]","i",$stopword);
				$stopword = ereg_replace("[ÓÒÔÕóòôõº]","o",$stopword);	
				$stopword = ereg_replace("[ÚÙÛúùû]","u",$stopword);	
				$stopword = str_replace(array("Ç","ç"),"c",$stopword);
				
				
				/*bate?*/
				if ($palavra == $stopword) {
					
					/*remove do array de palavras do site a stop word*/
					unset($p[$k]);
				}
			}
			/*coloca o ponteiro do array no inicio do mesmo*/
			reset($p);
		}
			
	}
	
	/*converte o array numa string concatenando os elementos do array por um espaco*/
	return implode(" ",$p);
}
?>