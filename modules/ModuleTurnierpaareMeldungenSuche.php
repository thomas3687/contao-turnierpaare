<?php
 
/*
Klasse für die Listendarstellung der Turnierpaare für das Frontend
*/ 
 
class ModuleTurnierpaareMeldungenSuche extends Module
{
	/**
	 * Template
	 * @var string
	 */
	 //$strTemplate = auf diese Template wird nacher zugegriffen
	protected $strTemplate = 'mod_turnierpaare_meldungen_suche'; 
	/**
	 * Compile the current element
	 */
	 
	 
	 /*
	 mit this->ModulFeld kann auf jede Einstellung zugegriffen werden
	 
	 */
	protected function compile()
	{
		if (FE_USER_LOGGED_IN)
{
   $this->import('FrontendUser', 'User');
   $userid = $this->User->id;
}else{
	$userid = 0;
	}   
   
  $sql= "SELECT * FROM tl_turnierpaare WHERE aktiv = 1 AND (tl_turnierpaare.herr_id =".$userid." || tl_turnierpaare.dame_id =".$userid." )";
    	$std = Database::getInstance()->query($sql);
		
		//hier wird Template das Feld turnierpaare zugewiesen und mit dem query ergebnis befüllt 	
		$this->Template->paare = $std->fetchAllAssoc();
		
	} 
	
}

?>