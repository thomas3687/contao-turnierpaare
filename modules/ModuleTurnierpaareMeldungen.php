<?php
 
/*
Klasse für die Listendarstellung der Turnierpaare für das Frontend
*/ 
 
class ModuleTurnierpaareMeldungen extends Module
{
	/**
	 * Template
	 * @var string
	 */
	 //$strTemplate = auf diese Template wird nacher zugegriffen
	protected $strTemplate = 'mod_turnierpaare_meldungen'; 
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
		
		
		
		
	$sql="";
	
	if ($this->tl_turniermeldungen_selection =="Alle"){
		//alle Meldungen
		 $sql	= "SELECT * FROM tl_turniermeldungen LEFT JOIN tl_turnierpaare ON tl_turnierpaare.id=tl_turniermeldungen.pid WHERE tl_turniermeldungen.date >= ".time()." AND  state!='REJ' ORDER BY date ASC, place ASC, class ASC";
		}
	if ($this->tl_turniermeldungen_selection =="Eigene"){
		//eigene Meldungen
		 $sql	= "SELECT *, tl_turniermeldungen.id AS meldung_id FROM tl_turniermeldungen LEFT JOIN tl_turnierpaare ON tl_turnierpaare.id=tl_turniermeldungen.pid WHERE date >= ".time()." AND (tl_turnierpaare.herr_id =".$userid." || tl_turnierpaare.dame_id =".$userid." ) ORDER BY date ASC";
		}
   
    	$std = Database::getInstance()->query($sql);
		
		//hier wird Template das Feld turnierpaare zugewiesen und mit dem query ergebnis befüllt 	
		$this->Template->meldungen = $std->fetchAllAssoc();
		
	} 
	
}

?>