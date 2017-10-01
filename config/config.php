<?php
/**
 * Back end modules
 */
 /*



*/
array_insert($GLOBALS['BE_MOD'], 0, array(

//neue Gruppierung im Backend mit dem platzhalter-Namen tl_turnierpaarverwaltung 
    'tl_turnierpaarverwaltung' => array(
	// Modul Turnierpaare 
      'turnierpaare' => array 
      ( 
	  //hier werden die Tabellen angegeben auf die das Modul zugreifen darf
        'tables' => array('tl_turnierpaare', 'tl_turnierpaarbilder', 'tl_turnierergebnisse', 'tl_turniermeldungen', 'tl_turnierdatenbank'),
		//icon zum Modul
		'icon'   => 'system/modules/turnierpaare/assets/images/turnierpaare.png' 
      ),
	  // Modul Turnierergebnisse 
      'turnierergebnisse' => array 
      ( 
        'tables' => array('tl_turnierergebnisse'),
		'icon'   => 'system/modules/turnierpaare/assets/images/ergebnisse.png' 
      ),
	  //Modul Turniermeldungen
	  'turniermeldungen' => array 
      ( 
        'tables' => array('tl_turniermeldungen'),
		'icon'   => 'system/modules/turnierpaare/assets/images/turniermeldungen.png' 
      )  
    ) 
  ) 
);



/**
 * Front end modules
 */
 
 //Frontendmodule für das Modul "turnierpaare"
$GLOBALS['FE_MOD']['turnierpaare'] = array
(
	//Platzhalter-Name des Templates => Klasse die sich um die implementierung des Templates kümmert
	'turnierpaare_list'     => 'ModuleTurnierpaareList',
	'turnierpaare_detail'	=> 'ModuleTurnierpaareDetail',
	'turnierpaare_ergebnisse_list' => 'ModuleTurnierpaareErgebnisseList',
	'turnierpaare_turniermeldungen'=> 'ModuleTurnierpaareMeldungen',
	'turnierpaare_turniermeldungen_suche'=> 'ModuleTurnierpaareMeldungenSuche'
);

?>