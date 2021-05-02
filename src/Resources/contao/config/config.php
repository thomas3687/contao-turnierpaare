<?php
/**
 * Backend modules
 */


$GLOBALS['BE_MOD']['content']['turnierpaare'] = [
  'tables' => ['tl_turnierpaare', 'tl_turnierpaarbilder','tl_turnierergebnisse'],
];

$GLOBALS['BE_MOD']['content']['turnierergebnisse'] = [
  'tables' => ['tl_turnierergebnisse'],
];

$GLOBALS['BE_MOD']['content']['tanzpartnervermittlung'] = [
  'tables' => ['tl_tanzpartnervermittlung'],
];

/**
 * Frontend modules
 */
 //Frontendmodule für das Modul "turnierpaare"

$GLOBALS['FE_MOD']['turnierpaare'] = array
(
	//Platzhalter-Name des Templates => Klasse die sich um die implementierung des Templates kümmert
	'turnierpaare_list'     => 'ThomasBilich\\Turnierpaarverwaltung\\Modules\\ModuleTurnierpaareList',
	'turnierpaare_detail'	=> 'ThomasBilich\\Turnierpaarverwaltung\\Modules\\ModuleTurnierpaareDetail',
	'turnierpaare_ergebnisse_list' => 'ThomasBilich\\Turnierpaarverwaltung\\Modules\\ModuleTurnierpaareErgebnisseList',
  'turnierpaare_ergebnisse_neu' => 'ThomasBilich\\Turnierpaarverwaltung\\Modules\\ModuleTurnierpaareErgebnissNeu'
);

$GLOBALS['FE_MOD']['tanzpartnervermittlung'] = array
(
	//Platzhalter-Name des Templates => Klasse die sich um die implementierung des Templates kümmert
  'tanzpartnervermittlung_list' => 'ThomasBilich\\Turnierpaarverwaltung\\Modules\\ModuleTanzpartnervermittlungList',
  'tanzpartnervermittlung_detail' => 'ThomasBilich\\Turnierpaarverwaltung\\Modules\\ModuleTanzpartnervermittlungDetail',
  'tanzpartnervermittlung_neu' => 'ThomasBilich\\Turnierpaarverwaltung\\Modules\\ModuleTanzpartnervermittlungNeu'
);

$GLOBALS['TL_CRON']['daily'][] = [\ThomasBilich\Turnierpaarverwaltung\Models\TanzpartnervermittlungCRON::class, 'checkAnzeigen'];

?>
