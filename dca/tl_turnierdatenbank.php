<?php
 
 /*klasse tl_turnierpaare
 hier werden hauptsächlich callback Funktionen implementiert die wir im DCA von der tabelle tl_turnierpaare benötigen
 
 */
 class tl_turnierdatenbank extends Backend 
{ 
    /** 
     * Import the back end user object 
     */ 
    public function __construct() 
    { 
        parent::__construct(); 
        $this->import('BackendUser', 'User'); 
    } 
} 
 
/**
 * Table tl_turnierdatenbank
 */
 
 /*
 Hier wird die eigentliche MySQL Tabelle angelegt und konfiguriert, sowie festgelegt in welcher Form die einzelnen Felder im Backend ausgefüllt werden können
 
 nähere infos zu den einzelnen Felder:
 https://contao.org/de/manual/3.2/data-container-arrays.html
 
 */
$GLOBALS['TL_DCA']['tl_turnierdatenbank'] = array
(
 
	// Config
	'config'   => array
	(
		'dataContainer'    => 'Table',
		'enableVersioning' => false,
		'doNotCopyRecords' => true,
		/*ctable = Kind-Tabellen
			hierbei gilt zum Beispiel tl_turnierpaare.id = tl_turnierergebnisse.pid
			Dies ist besonders praktisch da hier contao für uns vorselektiert wenn wir später im Backend unter Turnierpaare in Paar auswählen und in einem unter Menu die Ergebnisse anschauen wollen
			Entsprechend muss in den DCA's im Bereich config der Kindertabellen der Eintrag 'ptable' = 'tl_turnierpaare' gesetzt werden
			
		*/
		'sql'				=> array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		),
	),
	
// Fields
/*
Hier werden die eigentlichen felder der tabelle tl_turnierdatenbank bekannt gemacht.

Änderungen die hier durchgeführt werden, müssen im Contao Backend unter 'Erweiterungsverwaltung'-> 'Datenbank aktualisiern' aktualisiert werden
*/
	'fields'   => array
	(
	//Pflichtfeld
		'id'     => array
		(
			'sql' => "int(10) unsigned NOT NULL auto_increment"
		),
	//Pflichtfeld	
		'tstamp' => array
		(
			'sql' => "int(10) unsigned NOT NULL default '0'"
		),
		
		
		'nummer'  => array
		(
			'sql'       => "int(10) unsigned NOT NULL default '0'"
		),
		
		'land'  => array
		(
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'datum'  => array
		(
			'sql'       => "int(10) NOT NULL default '0'"
		),
		'art'  => array
		(
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'ort'  => array
		(
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'adresse'  => array
		(
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'telefon'  => array
		(
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'verein'  => array
		(
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'beschreibung'  => array
		(
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'uhrzeit'  => array
		(
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'klasse'  => array
		(
			'sql'       => "varchar(255) NOT NULL default ''"
		),
		'bemerkungen'  => array
		(
			'sql'       => "varchar(255) NOT NULL default ''"
		),
       )
);

