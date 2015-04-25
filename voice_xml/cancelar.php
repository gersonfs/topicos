<?php
header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="iso-8859-1"?>';

include("dados_db.php");
$con = mysql_connect($host,$user,$pass);
mysql_select_db($db,$con);


$cancelou = false;

$reserva = $_POST['rescancelar'];

$sql = "delete from aptos_reservas where reserva_id = " . $reserva;
$cancelou = mysql_query($sql);
$sql = "delete from reservas where id = " . $reserva;
$cancelou = $cancelou &&  mysql_query($sql);

?>

<!DOCTYPE vxml PUBLIC "-//BeVocal Inc//VoiceXML 2.0//EN"
 "http://cafe.bevocal.com/libraries/dtd/vxml2-0-bevocal.dtd">
<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml">

<form id="init">
<block>
	<prompt><?php echo ($cancelou ? "reserva cancelada com sucesso" : "deu pau"); ?></prompt>
</block>
</form>

</vxml>
<?php
mysql_close($con);
?>