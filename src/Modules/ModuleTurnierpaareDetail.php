<?php
namespace ThomasBilich\Turnierpaarverwaltung\Modules;
use Contao;

class ModuleTurnierpaareDetail extends \Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_turnierpaare_detail';
 	//public static $strDetailKey = 'turnierpaar'; 
	/**
	 * Compile the current element
	 */
	public function generate()
	{
		return parent::generate();
	}
	protected function compile()
	{
	
	//hole die id die im link übergeben wird z.B. ?paar=95
	$id = $this->Input->get("paar");
	
	//id muss auf jeden fall gesetzt sein, sonst kommt es zu fehlern im Backend, wenn man das Mudol in einen Artikel einbinden möchte
	if(strlen($id)==0){
	$id = 0;	
		}
	
	$sql = "SELECT * FROM tl_turnierpaare WHERE id= ".$id;
	
	$ergebnisse_sql = "SELECT * FROM tl_turnierergebnisse WHERE tl_turnierergebnisse.pid=".$id." ORDER BY datum DESC";
	
	$bilder_sql = "SELECT * FROM tl_turnierpaarbilder WHERE tl_turnierpaarbilder.pid=".$id ;
 
	
		$std = \Database::getInstance()->query($sql);
		$ergebnisse = \Database::getInstance()->query($ergebnisse_sql);
		$bilder = \Database::getInstance()->query($bilder_sql);	
		$this->Template->turnierpaare = $std->fetchAllAssoc();
		$this->Template->ergebnisse = $ergebnisse->fetchAllAssoc();
		$this->Template->bilder = $bilder->fetchAllAssoc();
	} 
	
}

?>