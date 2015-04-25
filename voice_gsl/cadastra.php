<?php
header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="iso-8859-1"?>';

include("dados_db.php");
$con = mysql_connect($host,$user,$pass);
mysql_select_db($db,$con);


$nome = $_POST['v_nome'];

$hospedes = $_POST['v_hosp'];


$forma_pagamento = $_POST['v_pag'];

$data_inicio = eregi_replace("[^0-9]","",$_POST['v_dt']);
$data_fim = eregi_replace("[^0-9]","",$_POST['v_dt2']);

$data_inicio = eregi_replace("([0-9]{4})([0-9]{2})([0-9]{2})","\\1-\\2-\\3",$data_inicio);
$data_fim = eregi_replace("([0-9]{4})([0-9]{2})([0-9]{2})","\\1-\\2-\\3",$data_fim);


$tipo_apto = $_POST['v_apto'];


$cpf = eregi_replace("[^0-9]","",$_POST['v_cpf']);

$sql = "select id from hospedes where cpf = '". $cpf ."' limit 1";
$q = mysql_query($sql);
if (mysql_num_rows($q)){
	$d = mysql_fetch_assoc($q);
	$id_hospede = $d['id'];
}else{
	$sql = "insert into hospedes (nome,cpf) values ('$nome','$cpf')";
	mysql_query($sql);
	$id_hospede = mysql_insert_id();
}


$sql = "select id 
		from aptos 
		where apto_tipo_id  = $tipo_apto and 
			  id not in ( select distinct ar.apto_id 
			  				from aptos_reservas ar, 
			  					 reservas r 
			  				where ar.reserva_id = r.id and 
			  				r.inicio between '$data_inicio' and '$data_fim' or 
			  				r.fim between '$data_inicio' and '$data_fim' or 
			  				r.inicio < '$data_inicio' and r.fim > '$data_fim') and 
			  capacidade >= $hospedes 
	     limit 1";

$q = mysql_query($sql);


if (mysql_num_rows($q)){
	
	$x = mysql_fetch_assoc($q);
	$apto_id = $x['id'];
	
	$sql = "insert into reservas (hospede_id,pagamento_forma_id,inicio,fim) values 
								 ($id_hospede,$forma_pagamento,'$data_inicio','$data_fim')";
	
	$q = mysql_query($sql);
	
	$id = mysql_insert_id();
	
	$sql = "insert into aptos_reservas (apto_id,reserva_id,ocupacao) values ($apto_id,$id,$hospedes)";
	mysql_query($sql);
	
	$mensagem = "o codigo da sua reserva e " . $id;
	
}else{
	$mensagem = "nao a quartos disponoveis";
}

?>

<!DOCTYPE vxml PUBLIC "-//BeVocal Inc//VoiceXML 2.0//EN"
 "http://cafe.bevocal.com/libraries/dtd/vxml2-0-bevocal.dtd">
<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml">

<form id="init">
<block>
	<prompt><?php echo $mensagem; ?></prompt>
</block>
</form>



</vxml>
<?php
mysql_close($con);
?>