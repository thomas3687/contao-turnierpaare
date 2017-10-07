<?php

/*
Palette für das Modul turnierpaare_list
*/

$GLOBALS['TL_DCA']['tl_module']['palettes']['turnierpaare_list'] = '{title_legend},name,headline,type;{turnierpaare_select_legend},tl_turnierpaare_selectCouples;{turnierpaaredetail_legend},tl_turnierpaare_detail;
{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
/*
Palette für das Modul turnierpaare_ergebnisse_list
*/
$GLOBALS['TL_DCA']['tl_module']['palettes']['turnierpaare_ergebnisse_list'] = '{title_legend},name,headline,type;{turnierpaaredetail_legend},tl_turnierpaare_detail;
{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
/*
Palette für das Modul turnierpaare_turniermeldungen
*/
$GLOBALS['TL_DCA']['tl_module']['palettes']['turnierpaare_turniermeldungen'] = '{title_legend},name,headline,type;{turnierpaare_turniermeldungen_legend},tl_turniermeldungen_selection;
{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
/*
Palette für das Modul turnierpaare_turniermeldungen
*/
$GLOBALS['TL_DCA']['tl_module']['palettes']['turnierpaare_turniermeldungen_suche'] = '{title_legend},name,headline,type;
{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
 /**
 * Add fields to tl_module
 */
 
/*
hier wird die tabelle tl_module um folgende felder erweitert um die Einstellungen des Moduls speichern zu können

*/ 

$GLOBALS['TL_DCA']['tl_module']['fields']['tl_turnierpaare_selectCouples'] = array(
       'label' => &$GLOBALS['TL_LANG']['tl_module']['tl_turnierpaare_selectCouples'],
       'default' => 'Alle',
       'inputType' => 'select',
       'options' => array('A','B','C','D','E','R'),
	   //reference = ersetzt die options 'A' 'B' ... durch richtigen text
	   'reference' => &$GLOBALS['TL_LANG']['tl_module']['tl_turnierpaare_filteroptions'],
       'eval' => array('mandatory' => true),
       'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tl_turniermeldungen_selection'] = array(
       'label' => &$GLOBALS['TL_LANG']['tl_module']['tl_turniermeldungen_selection'],
       'default' => 'Alle',
       'inputType' => 'select',
       'options' => array('Alle','Eigene'),
	   //reference = ersetzt die options 'A' 'B' ... durch richtigen text
	   'reference' => &$GLOBALS['TL_LANG']['tl_module']['tl_turniermeldungen_selection_filteroptions'],
       'eval' => array('mandatory' => true),
       'sql' => "varchar(255) NOT NULL default ''"
);


//speichert die Weiterleitungsseite (Frontend) in er die Details des Turnierpaares angeschaut werden können
$GLOBALS['TL_DCA']['tl_module']['fields']['tl_turnierpaare_detail'] = array(
       'label' => &$GLOBALS['TL_LANG']['tl_module']['tl_turnierpaare_detail'],
	'exclude'                 => true,
	'inputType'               => 'pageTree',
	'foreignKey'              => 'tl_page.title',
	'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "int(10) unsigned NOT NULL default '0'",
	'relation'                => array('type'=>'hasOne', 'load'=>'eager')
);

?>