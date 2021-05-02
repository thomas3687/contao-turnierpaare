<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package   TSC_ASTORIA
 * @author    Thomas Bilich
 * @license   GNU/LGPL
 * @copyright Thomas Bilich 2013
 */
 
class tl_tanzpartnervermittlung extends Backend 
{ 
    /** 
     * Import the back end user object 
     */ 
    public function __construct() 
    { 
        parent::__construct(); 
        $this->import('BackendUser', 'User'); 
    }	
 
 public function getKlassen(){
	  
	  $klassen = array('','Breitensport','Gesellschaftskreise', 'Salsa', 'Vorturnier','Tango', 'D-Std','C-Std','B-Std','A-Std','S-Std','D-Lat','C-Lat','B-Lat','A-Lat','S-Lat');
	  
	  return $klassen;
	  }
	  
	  
	  
 public function saveKlassen($var, $dc){
	 
	 $classen = "";
	 if(strlen($dc->activeRecord->class1)>0 && strlen($dc->activeRecord->class2)>0){
		 $classen = $dc->activeRecord->class1."<br>".$dc->activeRecord->class2;
		 }else{
		$classen= $dc->activeRecord->class1;
			 }
	$this->Database->prepare("UPDATE tl_tanzpartnervermittlung SET classes='".$classen."' WHERE id=?")->execute($dc->id); 		 
			 
			 
			 return $var;
	 }
 
	
} 



/**
 * Table tl_tanzpartnervermittlung
 */
$GLOBALS['TL_DCA']['tl_tanzpartnervermittlung'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 2,
			'fields'                  => array('date DESC','nachname'),
			//'filter'	=>array(array('activated=?','Y')),				
			'panelLayout' => 'search,sort;filter,limit'
		),
		'label' => array
		(
			'fields'                  => array('vorname','nachname', 'age','height','classes','place','email'),
			'showColumns'             => true,
			'format'                  => '%s %s %s %s %s %s %s'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Select
	'select' => array
	(
		'buttons_callback' => array()
	),

	// Edit
	'edit' => array
	(
		'buttons_callback' => array()
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => '{person_legend},gender,vorname,nachname,email,age,height,telefon;{suche_legend},class1,class2,place;{description_legend},description,comments'
	),

	// Subpalettes
	'subpalettes' => array
	(
		''                            => ''
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'exclude'   => false,
			'sorting'   => true,
			'flag'      => 6,
			'filter'	=> true,
            'search'    => false,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'code'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['code'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(50) NOT NULL default ''"
		),
		'vorname'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['vorname'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => true,
			'flag'      => 1,
            'search'    => true,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(50) NOT NULL default ''"
		),
		'nachname'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['nachname'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => true,
			'flag'      => 1,
            'search'    => true,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(50) NOT NULL default ''"
		),
		'class1'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['class1'],
			'inputType' => 'select',
			'options_callback' => array('tl_tanzpartnervermittlung', 'getKlassen'),
			'save_callback' => array(array('tl_tanzpartnervermittlung', 'saveKlassen')),
			'exclude'   => false,
			'sorting'   => false,
			'filter'    => true,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(50) NOT NULL default ''"
		),
		'class2'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['class2'],
			'inputType' => 'select',
			'options_callback' => array('tl_tanzpartnervermittlung', 'getKlassen'),
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
			'filter'	=> true,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(50) NOT NULL default ''"
		),
		'classes'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['classes'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
			'filter'	=> false,
            'search'    => true,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(50) NOT NULL default ''"
		),
		'age'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['age'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => true,
			'flag'      => 4,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(10) NOT NULL default ''"
		),
		'height'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['height'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(10) NOT NULL default ''"
		),
		'email'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['email'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => false,
                                'maxlength'   => 255,
								'rgxp' => 'email',
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(100) NOT NULL default ''"
		),
		'gender'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['gender'],
			'inputType' => 'select',
			'options' => array('M','F'),
			'reference' => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['genderReferenz'],
			'exclude'   => false,
			'sorting'   => false,
			'filter'	=> true,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(1) NOT NULL default ''"
		),
		'activated'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['activated'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
			'filter'	=> false,
            'search'    => true,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 255,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(5) NOT NULL default ''"
		),
		'description'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['description'],
			'inputType' => 'textarea',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => true,
                                'unique'         => false,
                                
				'tl_class'        => 'clr',
 
			),
			'sql'       => "varchar(1000) NOT NULL default ''"
		),
		'comments'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['comments'],
			'inputType' => 'textarea',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
				'tl_class'        => 'clr',
 
			),
			'sql'       => "varchar(1000) NOT NULL default ''"
		),
		'phone'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['phone'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => false,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 50,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(50) NOT NULL default ''"
		),
		'place'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_tanzpartnervermittlung']['place'],
			'inputType' => 'text',
			'exclude'   => false,
			'sorting'   => true,
			'flag'      => 1,
            'search'    => false,
			'eval'      => array(
				'mandatory'   => false,
                                'unique'         => false,
                                'maxlength'   => 50,
				'tl_class'        => 'w50',
 
			),
			'sql'       => "varchar(50) NOT NULL default ''"
		),
		'notified' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
	)
);
