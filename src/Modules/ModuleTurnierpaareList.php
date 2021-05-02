<?php
namespace ThomasBilich\Turnierpaarverwaltung\Modules;
use Contao;

/*
Klasse für die Listendarstellung der Turnierpaare für das Frontend
*/ 
 
class ModuleTurnierpaareList extends \Module
{
	/**
	 * Template
	 * @var string
	 */
	 //$strTemplate = auf diese Template wird nacher zugegriffen
	protected $strTemplate = 'mod_turnierpaare_list'; 
	/**
	 * Compile the current element
	 */
	public function generate()
	{
		return parent::generate();
	}
	 
	 /*
	 mit this->ModulFeld kann auf jede Einstellung zugegriffen werden
	 
	 */
	protected function compile()
	{
		$sql="";
	
	if ($this->tl_turnierpaare_selectCouples =="A"){
		//alle Paare
		 $sql	= "SELECT * FROM tl_turnierpaare WHERE aktiv = 1 ORDER BY Hnachname ASC";
		}
	if ($this->tl_turnierpaare_selectCouples =="B"){
		//alle Standard
		 $sql	= "(SELECT * FROM tl_turnierpaare WHERE aktiv = 1 AND (classLAT ='' OR classLAT IS NULL) AND (classLAT2 = '' OR classLAT2 IS NULL) AND (classSTD != '' OR classSTD IS NOT NULL) AND classSTD like '%S' ORDER BY classSTD ASC
) UNION (SELECT * FROM tl_turnierpaare WHERE aktiv = 1 AND (classLAT ='' OR classLAT IS NULL) AND (classLAT2 = '' OR classLAT2 IS NULL) AND (classSTD != '' OR classSTD IS NOT NULL) AND classSTD like '%A' ORDER BY classSTD ASC) UNION (SELECT * FROM tl_turnierpaare WHERE aktiv = 1 AND (classLAT ='' OR classLAT IS NULL) AND (classLAT2 = '' OR classLAT2 IS NULL) AND (classSTD != '' OR classSTD IS NOT NULL) AND classSTD like '%B' ORDER BY classSTD ASC) UNION (SELECT * FROM tl_turnierpaare WHERE aktiv = 1 AND (classLAT ='' OR classLAT IS NULL) AND (classLAT2 = '' OR classLAT2 IS NULL) AND (classSTD != '' OR classSTD IS NOT NULL) AND classSTD like '%C' ORDER BY classSTD ASC) UNION (SELECT * FROM tl_turnierpaare WHERE aktiv = 1 AND (classLAT ='' OR classLAT IS NULL) AND (classLAT2 = '' OR classLAT2 IS NULL) AND (classSTD != '' OR classSTD IS NOT NULL) AND classSTD like '%D' ORDER BY classSTD ASC)";
		}
	if ($this->tl_turnierpaare_selectCouples =="D"){
		//alle Kombi
		 $sql	= "SELECT * FROM tl_turnierpaare WHERE aktiv = 1 AND classSTD !='' AND classLAT != ''  AND classLAT not like '%LWD%' AND classSTD not like '%LWD%' ORDER BY Hnachname ASC;";
		}
	if ($this->tl_turnierpaare_selectCouples =="C"){
		//alle Latein
		$sql = "(SELECT * FROM tl_turnierpaare WHERE aktiv = 1 AND (classSTD ='' OR classSTD IS NULL) AND (classSTD2 = '' OR classSTD2 IS NULL) AND (classLAT != '' OR classLAT IS NOT NULL) AND classLAT like '%S' ORDER BY classLAT ASC) UNION (SELECT * FROM tl_turnierpaare WHERE aktiv = 1 AND (classSTD ='' OR classSTD IS NULL) AND (classSTD2 = '' OR classSTD2 IS NULL) AND (classLAT != '' OR classLAT IS NOT NULL) AND classLAT like '%A' ORDER BY classLAT ASC) UNION (SELECT * FROM tl_turnierpaare WHERE aktiv = 1 AND (classSTD ='' OR classSTD IS NULL) AND (classSTD2 = '' OR classSTD2 IS NULL) AND (classLAT != '' OR classLAT IS NOT NULL) AND classLAT like '%B' ORDER BY classLAT ASC) UNION (SELECT * FROM tl_turnierpaare WHERE aktiv = 1 AND (classSTD ='' OR classSTD IS NULL) AND (classSTD2 = '' OR classSTD2 IS NULL) AND (classLAT != '' OR classLAT IS NOT NULL) AND classLAT like '%C' ORDER BY classLAT ASC) UNION (SELECT * FROM tl_turnierpaare WHERE aktiv = 1 AND (classSTD ='' OR classSTD IS NULL) AND (classSTD2 = '' OR classSTD2 IS NULL) AND (classLAT != '' OR classLAT IS NOT NULL) AND classLAT like '%D' ORDER BY classLAT ASC)";
		}
	if ($this->tl_turnierpaare_selectCouples =="E"){
		//alte Paare
		$sql	= "SELECT * FROM tl_turnierpaare WHERE aktiv = 0 ORDER BY ende DESC;";
		}
	if ($this->tl_turnierpaare_selectCouples =="R"){
		//Rolli Paare
		$sql= "SELECT * FROM tl_turnierpaare WHERE aktiv = 1 AND  (classLAT like '%LWD%' OR classSTD like '%LWD%') ORDER BY Hnachname ASC;
";
		}
   
    	$std = \Database::getInstance()->query($sql);
		
		$pageModel = \PageModel::findByPK($this->tl_turnierpaare_detail); 

		if ($pageModel) { 
		   $url = \Controller::generateFrontendUrl($pageModel->row()); 
		}  
		
		//hier wird Template das Feld turnierpaare zugewiesen und mit dem query ergebnis befüllt 	
		$this->Template->turnierpaare = $std->fetchAllAssoc();
		$this->Template->detailURL = $url;
	} 
	
}

?>