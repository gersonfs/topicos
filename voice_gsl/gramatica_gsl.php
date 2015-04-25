<?php
header("Content-type: application/x-nuance-gsl");
include("dados_db.php");
$con = mysql_connect($host,$user,$pass);
mysql_select_db($db,$con);

?>
;GSL 2.0;


Cond_pag:public (
	?Pronome
	?Verbo
	?Prep
    ?pagar
    ?a
	[ <?php
		
    	$sql = "select * from pagamento_formas";
    	$q = mysql_query($sql);
    	while ($d = mysql_fetch_assoc($q)) {
    		echo ' ('. strtolower($d['nome']) .') ' .  '{ <cond_pag "'. $d['id'] .'"> }' . "\r\n";
    	}
    	
    	?>
    ]
)


Cpf:public (
	( Numero:a 
	  Numero:b 
	  Numero:c
	  Numero:d
	  Numero:e
	  Numero:f
	  Numero:g
	  Numero:h
	  Numero:i
	  Numero:j
	  Numero:l
	   ) { <cpf strcat($a strcat($b  strcat($c strcat($d strcat($e strcat($f strcat($g strcat($h strcat($i strcat($j $l ) ) ) ) ) ) ) ) ) )> }
)

Numero:public [
	zero { return (0) }
	um { return (1) }
	dois { return (2) }
	tres { return (3) }
	quatro { return (4) }
	cinco { return (5) }
	seis { return (6) }
	sete { return (7) }
	oito { return (8) }
	nove { return (9) }
]



Apt:public [

      (
      ?Pronome
      ?Verbo
      ?Prep
      ?Acao
      ?Prep
      ?Subs
      ?Prep
      Apto
      ?para
      ?Hosp
      ?Ph
      )

      (
      ?Pronome
      ?Verbo
      ?Prep
      ?Acao
      ?Prep
      ?Subs
      ?para
      Hosp
      ?Ph
      ?Prep
      ?Apto
      )
]


Acao:public (

 	?Pronome
    ?Verbo
    ?Prep
     [
     	<?php
     	$sql = "select v.nome as verbo, a.nome as acao 
     			from verbos v, acoes a 
     			where v.acao_id = a.id";
     	$q = mysql_query($sql);
     	while ($d = mysql_fetch_assoc($q)) {
     		echo ' ('. $d['verbo'] .') { <acao "'. $d['acao'] .'" > } ' . "\r\n";
     	}
     	?>
    ]
    ?Prep
    ?Subs
)


Pronome:public [
	
    	<?php
    	$sql = "select * from pronomes";
    	$q = mysql_query($sql);
    	while ($d = mysql_fetch_assoc($q)) {
    		echo ' ('. $d['nome'] .') ' . "\r\n";
    	}
    	?>
]



Nomes:public (
	?meu
    ?nome
    ?e
    [
    	<?php
    	$sql = "select * from nomes";
    	$q = mysql_query($sql);
    	while ($d = mysql_fetch_assoc($q)) {
    		echo ' ('. strtolower($d['nome']) .') { <nome "'. $d['nome'] .'"> }' . "\r\n";
    	}
    	?>
    ]

)



Ph:public [
	pessoas
    pessoa
    hospede
    hospedes
]


Alteracao:public (

	?Pronome
	?Verbo
	?Prep
	?[
		
		<?php
     	$sql = "select v.nome as verbo, a.nome as acao 
     			from verbos v, acoes a 
     			where v.acao_id = a.id";
     	$q = mysql_query($sql);
     	while ($d = mysql_fetch_assoc($q)) {
     		echo ' ('. strtolower($d['verbo']) .') ' . "\r\n";
     	}
     	?>
    ]
    
	?Prep
    [
       periodo { <alterar periodo> }
       (forma de pagamento) { <alterar pagamento> }
    ]

)


Apto:public [

    	<?php
    	$sql = "select * from apto_tipos";
    	$q = mysql_query($sql);
    	while ($d = mysql_fetch_assoc($q)) {
    		echo ' ( '. strtolower($d['nome']) .' ) { <apto '. $d['id'] .'> }';
    	}
    	?>
]



Hosp:public [
      
        <?php
    	$sql = "select * from numeros";
    	$q = mysql_query($sql);
    	while ($d = mysql_fetch_assoc($q)) {
    		echo ' ('. strtolower($d['nome']) .') { <hosp "'. $d['valor'] .'"> }' . "\r\n";
    	}
    	?>
 

]



Verbo:public [

    <?php
    	$sql = "select * from verbos where acao_id is null or acao_id = ''";
    	$q = mysql_query($sql);
    	while ($d = mysql_fetch_assoc($q)) {
    		echo ' ('. $d['nome'] .') ' . "\r\n";
    	}
    ?>
]


Prep:public [
	<?php
    	$sql = "select * from preposicoes";
    	$q = mysql_query($sql);
    	while ($d = mysql_fetch_assoc($q)) {
    		echo ' ('. $d['nome'] .') ' . "\r\n";
    	}
    	?>
]


Subs:public [
		<?php
    	$sql = "select * from substantivos";
    	$q = mysql_query($sql);
    	while ($d = mysql_fetch_assoc($q)) {
    		echo ' ('. $d['nome'] .') ' . "\r\n";
    	}
    	?>
    	

]


<?php
mysql_close($con);
?>