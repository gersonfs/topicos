<?php
header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="iso-8859-1"?>';

include("dados_db.php");
$con = mysql_connect($host,$user,$pass);
mysql_select_db($db,$con);

$reserva = $_POST['v_res_alterar'];
$msg = '';

if (isset($_POST['v_pag'])){
	$forma_de_pagamento = $_POST['v_pag'];
	
	$sql = "update reservas set pagamento_forma_id = " . $forma_de_pagamento . " where id = " . $reserva;
	if( mysql_query($sql)){
		$msg = "forma de pagamento alterada com sucesso";
	}else{
		$msg = "nao foi possivel alterar a forma de pagamento";
	}
}

if (isset($_POST['v_dt']) && isset($_POST['v_dt2'])){
	$data_inicio = eregi_replace("[^0-9]","",$_POST['v_dt']);
	$data_fim = eregi_replace("[^0-9]","",$_POST['v_dt2']);

	$data_inicio = eregi_replace("([0-9]{4})([0-9]{2})([0-9]{2})","\\1-\\2-\\3",$data_inicio);
	$data_fim = eregi_replace("([0-9]{4})([0-9]{2})([0-9]{2})","\\1-\\2-\\3",$data_fim);
	
	$sql = "select apto_id 
			from aptos_reservas 
	 		where reserva_id = " . $reserva . " limit 1";
	
	$d = mysql_fetch_assoc(mysql_query($sql));
	$apto = $d['apto_id'];
	
	
	$sql = "select 1  
		from aptos_reservas ar, 		
			 reservas r 
		where ar.reserva_id = r.id and 
			  ar.apto_id = $apto and 
			  ( ( r.inicio >= '$data_inicio' and r.inicio <= '$data_fim'  ) or 
			  	( r.fim >= '$data_inicio' and r.fim <= '$data_fim'  ) or 
			  	( r.inicio < '$data_inicio' and r.fim > '$data_fim' ) ) and 
			  r.id != $reserva 
		limit 1";
	
	
	if ( ! mysql_num_rows(mysql_query($sql)) ){
		$sql = "update reservas set inicio = '$data_inicio', fim = '$data_fim' where id = " . $reserva;
		if (mysql_query($sql)){
			$msg = "cadastro alterado com sucesso";	
		}else{
			$msg = "nao foi possivel atualizar o periodo";	
		}
	}else{
		$msg = "ja existe um reserva para este periodo";
	}
}

?>

<!DOCTYPE vxml PUBLIC "-//BeVocal Inc//VoiceXML 2.0//EN"
 "http://cafe.bevocal.com/libraries/dtd/vxml2-0-bevocal.dtd">
<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml">

<form id="init">
<block>
	<prompt><?php echo $msg; ?></prompt>
</block>
</form>

</vxml>
<?php
mysql_close($con);
?>