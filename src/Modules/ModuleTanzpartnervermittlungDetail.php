<?php

namespace ThomasBilich\Turnierpaarverwaltung\Modules;
use Contao;

class ModuleTanzpartnervermittlungDetail extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	 
	protected $strTemplate = 'mod_tanzpartnervermittlung_detail';

	public function generate()
	{
		return parent::generate();
	}
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

		$std = \Database::getInstance()->query($sql);
		$anzeigen = $std->fetchAllAssoc();
		$this->Template->anzeigen = $anzeigen;

		$send =false;
		$response = "";
	
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			
			 $text=$_POST['text'];
			 $fromemail=$_POST['fromemail'];
			 $anzeige = $anzeigen[0];

			 $this->Template->text = $text;
			 $this->Template->fromemail = $fromemail;
			
			if(filter_var($fromemail, FILTER_VALIDATE_EMAIL)){
				
				if(strlen($text)>0){
					
					$this->sendpartnermail($fromemail, $anzeige['email'], $text);
								   
					$response = '<p class="green">Deine Nachricht von '.$fromemail.' an '.$anzeige['vorname'].' '.$anzeige['nachname'].' wurde gesendet!</p>';
					
					$send = true;
					
					}else{
						$response = '<p class="red">Bitte geben Sie einen Text ein!</p>';	
						}
				
				}else{
					$response = '<p class="red">Die E-Mail Adresse ist ungültig!</p>';
					}
			
			}
       
		$this->Template->response = $response;
		$this->Template->send = $send;

	}

	function sendpartnermail($fromemail, $email, $description) {

		$absender = $this->tl_tanzpartnervermittlung_email_absender;
		$absenderName = $this->tl_tanzpartnervermittlung_email_name;
		$subject = $this->tl_tanzpartnervermittlung_email_subject;


		$text="Hallo!\n\n $fromemail hat auf deine Tanzpartner-Anzeige geantwortet:\n\n".$description;
	    $text=$text."\n\n"."Bitte andworte nicht direkt auf diese E-Mail! Du kannst über die E-Mail Adresse $fromemail auf die Nachricht antworten.";
	    mail($email, $subject ,$text,"From: $absender");
	}
}
