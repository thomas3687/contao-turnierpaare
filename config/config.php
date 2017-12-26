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
        'tables' => array('tl_turnierpaare', 'tl_turnierpaarbilder', 'tl_turnierergebnisse'),
		//icon zum Modul
		'icon'   => 'system/modules/turnierpaare/assets/images/turnierpaare.png'
      ),
	  // Modul Turnierergebnisse
      'turnierergebnisse' => array
      (
        'tables' => array('tl_turnierergebnisse'),
		'icon'   => 'system/modules/turnierpaare/assets/images/ergebnisse.png'
      )
    ),
    'tanzpartnervermittlung' => array(
	// Modul Turnierpaare 
      'tanzpartneranzeigen' => array 
      ( 
	  //hier werden die Tabellen angegeben auf die das Modul zugreifen darf
        'tables' => array('tl_tanzpartnervermittlung'),
		//icon zum Modul
		'icon'   => 'system/modules/turnierpaare/assets/images/tanzpartneranzeigen.png' 
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
  'turnierpaare_ergebnisse_neu' => 'ModuleTurnierpaareErgebnissNeu',
  'tanzpartnervermittlung_list' => 'ModuleTanzpartnervermittlungList',
  'tanzpartnervermittlung_detail' => 'ModuleTanzpartnervermittlungDetail',
  'tanzpartnervermittlung_neu' => 'ModuleTanzpartnervermittlungNeu'
);

$GLOBALS['TL_CRON'] = array
(
   'monthly' => array(),
   'weekly'   => array(),
   'daily'    => array(array('tl_tanzpartnervermittlungCRON', 'checkAnzeigen')),
   'hourly'   => array(),
   'minutely' => array()
);

?>
