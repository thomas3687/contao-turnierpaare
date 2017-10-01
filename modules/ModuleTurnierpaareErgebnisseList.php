<?php
 
/*
Klasse für die Listendarstellung der Turnierpaare für das Frontend
*/ 
 
class ModuleTurnierpaareErgebnisseList extends Module
{
	/**
	 * Template
	 * @var string
	 */
	 //$strTemplate = auf diese Template wird nacher zugegriffen
	protected $strTemplate = 'mod_turnierpaare_ergebnisse_list'; 
	/**
	 * Compile the current element
	 */
	 
	 
	 /*
	 mit this->ModulFeld kann auf jede Einstellung zugegriffen werden
	 
	 */
	protected function compile()
	{
		
		$ende = $ende - 28*86400;
		
		$sql	= "SELECT * FROM tl_turnierergebnisse WHERE datum >= $ende AND freigabe = 1 GROUP BY ort, datum ORDER BY datum  DES;";
		
		$orte_datum = Database::getInstance()->query($sql)->fetchAllAssoc();
		$i = 0;
		
		$ergebnisse = array();
		foreach($orte_datum as $ergebnis){ 
		
		$datum = $ergebnis['datum'];
		$ort = $ergebnis['ort'];
	
		  $sql	= "SELECT * FROM tl_turnierergebnisse WHERE datum = $datum AND ort = '$ort' AND paar_name IS NOT NULL AND freigabe = 1 ORDER BY paar_name ASC;
";
    $result = Database::getInstance()->query($sql)->fetchAllAssoc();
	
		$ergebnisse[$i] = $result;
	
	$i++;
		}

		
		//hier wird Template das Feld turnierpaare zugewiesen und mit dem query ergebnis befüllt 	
		$this->Template->ergebnisorte = $orte_datum;
		$this->Template->ergebnisse = $ergebnisse;
		
	} 
	
}

?>