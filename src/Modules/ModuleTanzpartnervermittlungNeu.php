<?php
namespace ThomasBilich\Turnierpaarverwaltung\Modules;
use Contao;

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
 * Class ModuleTanzpartnervermittlungNeu
 *
 * @copyright  Thomas Bilich 2013
 * @author     Thomas Bilich
 * @package    Devtools
 */
class ModuleTanzpartnervermittlungNeu extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_tanzpartnervermittlung_neu';

	public function generate()
	{
		return parent::generate();
	}

	/**
	 * Generate the module
	 */
	protected function compile()
	{
		if (TL_MODE == 'BE')
    	{
      		return;
    	}

		$activated = false;
		$removed = false;
		$errors = "";
		$check = true;
		$send = false;

		if(\Input::get("remove") !== null && strlen(\Input::get("remove")) >0 ){
			$sql = "DELETE FROM tl_tanzpartnervermittlung WHERE code = '".\Input::get("remove")."'";
			\Database::getInstance()->query($sql);
			$removed = true;
		}else if(\Input::get("activate") !== null && strlen(\Input::get("activate")) >0){
   			$sql = "UPDATE tl_tanzpartnervermittlung SET activated = 'Y', date = ".time().", notified = 0 WHERE code = '".\Input::get("activate")."'";
			\Database::getInstance()->query($sql); 
			$activated = true;
		}
       
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
			if(strlen($_POST['vorname'])==0){
				$check = false;
				$errors = $errors."<h3 class='red'>Bitte gebe deinen Vornamen ein!</h3>";
			}
			
			if(strlen($_POST['nachname'])==0){
				$check = false;
				$errors = $errors."<h3 class='red'>Bitte gebe deinen Nachnamen ein!</h3>";
			}
			
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$check = false;
				$errors = $errors."<h3 class='red'>Bitte gebe eine gültige E-Mail-Adresse ein!</h3>";
			}
			
			if(strlen($_POST['class1'])==0){
				$check = false;
				$errors = $errors."<h3 class='red'>Bitte wähle mindestens eine Disziplin aus!</h3>";
			}
			
			if(strlen($_POST['description'])==0){
				$check = false;
				$errors = $errors."<h3 class='red'>Bitte gebe eine Beschreibung ein!</h3>";
			}
			
			if($check){
				$code = substr(md5(uniqid(rand(), true)), 0, 16);
				$this->sendConfirmMail($code, \Environment::get('uri'));
				$send = true;
				}
			
			}

			$this->Template->errors = $errors;
			$this->Template->send = $send;
			$this->Template->activated = $activated;
			$this->Template->removed = $removed;

	}
	

	private function sendConfirmMail($code, $link) {

		$absender = $this->tl_tanzpartnervermittlung_email_absender;
		$absenderName = $this->tl_tanzpartnervermittlung_email_name;
		$subject = $this->tl_tanzpartnervermittlung_email_subject;

		$vorname=$_POST['vorname'];
		$nachname=$_POST['nachname'];
				$gender=$_POST['gender'];
				$age=$_POST['age'];
				$class1=$_POST['class1'];
				$class2=$_POST['class2'];
				$classes=$class1.'<br>'.$class2;
				$place=$_POST['place'];
				$email=$_POST['email'];
				$height=$_POST['height'];
				$phone=$_POST['phone'];
				$description=$_POST['description'];
				$date = time();
				
				
				$geschlecht="weiblich";
				if($gender == 'M'){
					$geschlecht ='männlich';
					}
				
				$activateLink = $link."?activate=".$code;
				$deleteLink = $link."?remove=".$code;
				
				
	$body="Hallo $vorname,
	
	
	Deine Anzeige für die Tanzpartnervermittlung wurde erfolgreich in die Datenbank aufgenommen.
	
	Du hast jetzt noch einmal die Möglichkeit Deine gemachten Angaben zu überprüfen, bevor Deine Anzeige mit nachstehendem Link aktivieren wird:
	Anzeige aktivieren: $activateLink
	
	Nach der Aktivierung bleibt deine Anzeige für 90 Tage aktiv.

	Deine Daten:
	-------------------------------
	Geschlecht: $geschlecht
	Name: $vorname $nachname
	Körpergrösse: $height cm
	Alter: $age Jahre
	E-Mail: $email
	Ort: $place
	Klassen: $class1 $class2
	
	Bemerkung:
		$description
	-------------------------------
	
	Wenn du deine Anzeige wieder löschen möchstest kannst du das über diesen Link tun.
	Anzeige löschen: $deleteLink				
	";
	
	mail($email,$subject,$body,"From: $absender");
	
	
	 $sql	= "INSERT INTO tl_tanzpartnervermittlung (vorname, nachname , gender, age , classes, class1, class2 , place , email , height, phone, date, description, code, activated, tstamp) VALUES
							('$vorname','$nachname', '$gender','$age','$classes','$class1','$class2','$place', '$email', '$height', '$phone', '$date', '$description', '$code', 'N', $date)";
	
	\Database::getInstance()->query($sql);
	
	}
	
}
