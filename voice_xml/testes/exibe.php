<?php
header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="iso-8859-1"?>';

$nome1 = isset($_POST['nome1']) ? $_POST['nome1'] : 'nao tem nome 1';
$nome2 = isset($_POST['nome2']) ? $_POST['nome2'] : 'nao tem nome 2';
?>

<!DOCTYPE vxml PUBLIC "-//BeVocal Inc//VoiceXML 2.0//EN"
 "http://cafe.bevocal.com/libraries/dtd/vxml2-0-bevocal.dtd">
<vxml version="2.0" xmlns="http://www.w3.org/2001/vxml">

<form id="init">
<block>
	<prompt><value expr="'<?php echo $nome1; ?>'"/></prompt>
	<prompt><value expr="'<?php echo $nome2; ?>'"/></prompt>
</block>
</form>



</vxml>