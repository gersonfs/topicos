<?php
header("Content-type: text/xml");
include("dados_db.php");
$con = mysql_connect($host,$user,$pass);
mysql_select_db($db,$con);

echo '<?xml version="1.0"?>';
?>
<grammar
    xmlns="http://www.w3.org/2001/06/grammar" version="1.0" 
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
    xsi:schemaLocation="http://www.w3.org/2001/06/grammar 
                             http://www.w3.org/TR/speech-grammar/grammar.xsd"
    xml:lang="en-US" root="acao">


<rule id="cond_pag" scope="public">
      <item repeat="0-1"><ruleref uri="#pronome"/></item>
      <item repeat="0-1"><ruleref uri="#verbo"/></item>
      <item repeat="0-1"><ruleref uri="#prep"/></item>
      <item repeat="0-1"> pagar </item>
      <item repeat="0-1"> a </item>
    <one-of>
    <?php
    	$sql = "select * from pagamento_formas";
    	$q = mysql_query($sql);
    	while ($d = mysql_fetch_assoc($q)) {
    		echo '<item> '. $d['nome'] .' <tag>cond_pag= "'. $d['id'] .'"</tag> </item>';
    	}
    	?>
    </one-of>
</rule>


<rule id="apt" scope="public">
  <one-of>

      <item>
      <item repeat="0-1"><ruleref uri="#pronome"/></item>
      <item repeat="0-1"><ruleref uri="#verbo"/></item>
      <item repeat="0-1"><ruleref uri="#prep"/></item>
      <item repeat="0-1"><ruleref uri="#acao"/></item>       
      <item repeat="0-1"><ruleref uri="#prep"/></item>
      <item repeat="0-1"><ruleref uri="#subs"/></item>
      <item repeat="0-1"><ruleref uri="#prep"/></item>
      <item><ruleref uri="#apto"/></item>
      <item repeat="0-1">para</item>
      <item repeat="0-1"><ruleref uri="#hosp"/></item>
      <item repeat="0-1"><ruleref uri="#ph"/></item>
      </item>

      <item>
      <item repeat="0-1"><ruleref uri="#pronome"/></item>
      <item repeat="0-1"><ruleref uri="#verbo"/></item>
      <item repeat="0-1"><ruleref uri="#prep"/></item>
      <item repeat="0-1"><ruleref uri="#acao"/></item>       
      <item repeat="0-1"><ruleref uri="#prep"/></item>
      <item repeat="0-1"><ruleref uri="#subs"/></item>
      <item repeat="0-1">para</item>
      <item><ruleref uri="#hosp"/></item>
      <item repeat="0-1"><ruleref uri="#ph"/></item>
      <item repeat="0-1"><ruleref uri="#prep"/></item>
      <item repeat="0-1"><ruleref uri="#apto"/></item>
      </item>

  </one-of>
</rule>


<rule id="acao" scope="public">
    <item repeat="0-1"><ruleref uri="#pronome"/></item>
    <item repeat="0-1"><ruleref uri="#verbo"/></item>
    <item repeat="0-1"><ruleref uri="#prep"/></item>
     <one-of>
     	<?php
     	$sql = "select v.nome as verbo, a.nome as acao 
     			from verbos v, acoes a 
     			where v.acao_id = a.id";
     	$q = mysql_query($sql);
     	while ($d = mysql_fetch_assoc($q)) {
     		echo '<item> '. $d['verbo'] .' <tag>acao= "'. $d['acao'] .'" </tag> </item>';
     	}
     	?>
    </one-of>
    <item repeat="0-1"><ruleref uri="#prep"/></item>
    <item repeat="0-1"><ruleref uri="#subs"/></item>  
</rule>


<rule id="pronome" scope="public">
    <one-of>
    	<?php
    	$sql = "select * from pronomes";
    	$q = mysql_query($sql);
    	while ($d = mysql_fetch_assoc($q)) {
    		echo '<item> '. $d['nome'] .' </item>';
    	}
    	?>
    </one-of>
</rule>

<rule id="nomes" scope="public">
	<item repeat="0-1"> meu </item>
    <item repeat="0-1"> nome </item>
    <item repeat="0-1"> e </item>
    <one-of>
    	<?php
    	$sql = "select * from nomes";
    	$q = mysql_query($sql);
    	while ($d = mysql_fetch_assoc($q)) {
    		echo '<item> '. $d['nome'] .' <tag>nome= "'. $d['nome'] .'" </tag> </item>';
    	}
    	?>
    </one-of>
</rule>

<rule id="ph" scope="public">
    <one-of>
      <item>pessoas</item>
      <item>pessoa</item>
      <item>hospede</item>
      <item>hospedes</item>
    </one-of>
</rule>


<rule id="alteracao" scope="public">
	<item repeat="0-1"><ruleref uri="#pronome"/></item>
	<item repeat="0-1"><ruleref uri="#verbo"/></item>
	<item repeat="0-1"><ruleref uri="#prep"/></item>
	<item repeat="0-1">
		<one-of>
		<?php
     	$sql = "select v.nome as verbo, a.nome as acao 
     			from verbos v, acoes a 
     			where v.acao_id = a.id";
     	$q = mysql_query($sql);
     	while ($d = mysql_fetch_assoc($q)) {
     		echo '<item> '. $d['verbo'] .' <tag>acao= "'. $d['acao'] .'" </tag> </item>';
     	}
     	?>
     	</one-of>
	</item>
	<item repeat="0-1"><ruleref uri="#prep"/></item>
    <one-of>
      <item> periodo <tag>alterar= "periodo" </tag></item>
      <item> forma de pagamento <tag>alterar= "pagamento" </tag></item>
    </one-of>
</rule>


<rule id="apto" scope="public">
    <one-of>
    	<?php
    	$sql = "select * from apto_tipos";
    	$q = mysql_query($sql);
    	while ($d = mysql_fetch_assoc($q)) {
    		echo '<item> '. $d['nome'] .' <tag>apto= "'. $d['id'] .'" </tag> </item>';
    	}
    	?>
    </one-of>
</rule>


<rule id="hosp" scope="public">
    <one-of>
    
        <?php
    	$sql = "select * from numeros";
    	$q = mysql_query($sql);
    	while ($d = mysql_fetch_assoc($q)) {
    		echo '<item> '. $d['nome'] .' <tag>hosp= "'. $d['valor'] .'" </tag> </item>';
    	}
    	?>
    </one-of>
</rule>


<rule id="verbo" scope="public">
    <one-of>
    <?php
    	$sql = "select * from verbos where acao_id is null or acao_id = ''";
    	$q = mysql_query($sql);
    	while ($d = mysql_fetch_assoc($q)) {
    		echo '<item> '. $d['nome'] .' </item>';
    	}
    ?>
    </one-of>
</rule>


<rule id="prep" scope="public">
    <one-of>
    	<?php
    	$sql = "select * from preposicoes";
    	$q = mysql_query($sql);
    	while ($d = mysql_fetch_assoc($q)) {
    		echo '<item> '. $d['nome'] .' </item>';
    	}
    	?>
    </one-of>
</rule>


<rule id="subs" scope="public">
      <one-of>
      <?php
    	$sql = "select * from substantivos";
    	$q = mysql_query($sql);
    	while ($d = mysql_fetch_assoc($q)) {
    		echo '<item> '. $d['nome'] .' </item>';
    	}
    	?>
      </one-of>
</rule>
</grammar>
<?php
mysql_close($con);
?>