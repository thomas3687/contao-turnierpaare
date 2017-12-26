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
class ModuleTanzpartnervermittlungList extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_tanzpartnervermittlung_list';


	/**
	 * Generate the module
	 */
	protected function compile()
	{
		$sql="";
		$time = time();
		
		$time = $time-(60*60*24*90);
		
	if ($this->tl_tanzpartnervermittlung_selectGender =="M"){
		//nur männer
		
		 $sql	= "SELECT * FROM tl_tanzpartnervermittlung WHERE activated = 'Y' AND gender = 'M' AND date > ".$time."  ORDER BY date DESC";
		}
		
	if ($this->tl_tanzpartnervermittlung_selectGender =="F"){
		//nur Frauen
		$sql	= "SELECT * FROM tl_tanzpartnervermittlung WHERE activated = 'Y' AND gender = 'F' AND date > ".$time."  ORDER BY date DESC";
		}

	$std = Database::getInstance()->query($sql);
		
	$pageModel = \PageModel::findByPK($this->tl_tanzpartnervermittlung_detail); 

	if ($pageModel) { 
	   $url = \Controller::generateFrontendUrl($pageModel->row()); 
	}  
		//hier wird Template das Feld turnierpaare zugewiesen und mit dem query ergebnis befüllt 	
		$this->Template->anzeigen = $std->fetchAllAssoc();
		$this->Template->detailURL = $url;
	}
	
	
}
