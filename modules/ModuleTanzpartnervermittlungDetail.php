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


/**
 * Namespace
 */
//namespace TSC_ASTORIA;


/**
 * Class ModuleTanzpartnervermittlungList
 *
 * @copyright  Thomas Bilich 2013
 * @author     Thomas Bilich
 * @package    Devtools
 */
class ModuleTanzpartnervermittlungDetail extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	 
	protected $strTemplate = 'mod_tanzpartnervermittlung_detail';


	/**
	 * Generate the module
	 */
	protected function compile()
	{
		//hole die id die im link übergeben wird z.B. ?anzeige=95
	$id = $this->Input->get("anzeige");
	
	//id muss auf jeden fall gesetzt sein, sonst kommt es zu fehlern im Backend, wenn man das Mudol in einen Artikel einbinden möchte
	if(strlen($id)==0){
	$id = 0;	
		}

	$sql = "SELECT * FROM tl_tanzpartnervermittlung WHERE id= ".$id;

	$std = Database::getInstance()->query($sql);
		
		//hier wird Template das Feld anzeigen zugewiesen 	
		$this->Template->anzeigen = $std->fetchAllAssoc();
	}
}
