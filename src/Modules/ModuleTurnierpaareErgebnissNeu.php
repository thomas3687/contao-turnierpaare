<?php
namespace ThomasBilich\Turnierpaarverwaltung\Modules;
use Contao;

/*
Klasse für die Listendarstellung der Turnierpaare für das Frontend
*/

class ModuleTurnierpaareErgebnissNeu extends \Module
{
	/**
	 * Template
	 * @var string
	 */
	 //$strTemplate = auf diese Template wird nacher zugegriffen
	protected $strTemplate = 'mod_turnierpaare_ergebniss_neu';
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

   private function mail_att($htmlContent,$anhang)
      {

      // Recipient 
      $to = $this->tl_turnierpaare_ergebniss_email;
 
      // Sender 
      $from = $this->tl_turnierpaare_ergebniss_email_absender; 
      $fromName = $this->tl_turnierpaare_ergebniss_email_name;
 
      // Email subject 
      $subject = $this->tl_turnierpaare_ergebniss_email_subject;

      
      // Header for sender info 
      $headers = "From: $fromName"." <".$from.">"; 
 
      // Boundary  
      $semi_rand = md5(time());  
      $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
      
      // Headers for attachment  
      $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
      
      // Multipart boundary  
      $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . 
      "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";  

      //$anhang ist ein Mehrdimensionals Array
      //$anhang enthält mehrere Dateien
      
      if(is_array($anhang) AND is_array(current($anhang)))
         {
         foreach($anhang AS $dat)
            {
            $data = chunk_split(base64_encode($dat['data']));
            $message.= "--".$mime_boundary."\r\n";
            $message.= "Content-Disposition: attachment;\r\n";
            $message.= "\tfilename=\"".$dat['name']."\";\r\n";
            $message.= "Content-Length: .".$dat['size'].";\r\n";
            $message.= "Content-Type: ".$dat['type']."; name=\"".$dat['name']."\"\r\n";
            $message.= "Content-Transfer-Encoding: base64\r\n\r\n";
            $message.= $data."\r\n";
            }
         $message .= "--".$mime_boundary."--";
         }
      else if(strlen($anhang['name'])>0) //Nur 1 Datei als Anhang
         {

         $data = chunk_split(base64_encode($anhang['data']));
         $message.= "--".$mime_boundary."\r\n";
         $message.= "Content-Disposition: attachment;\r\n";
         $message.= "\tfilename=\"".$anhang['name']."\";\r\n";
         $message.= "Content-Length: .".$dat['size'].";\r\n";
         $message.= "Content-Type: ".$anhang['type']."; name=\"".$anhang['name']."\"\r\n";
         $message.= "Content-Transfer-Encoding: base64\r\n\r\n";
         $message.= $data."\r\n";
         $message .= "--".$mime_boundary."--";
         }
         
      $returnpath = "-f" . $from; 

      if(mail($to, $subject, $message, $headers, $returnpath)){
        return true;
      } else{ 
        return false;
      }
    }

  private function selectValues($offset, $value, $elemenID){
      $form = '<select name="'.$elemenID.'" id="'.$elemenID.'">';

      for ($i = $offset; $i <= 300; $i++) {
            $form = $form.'<option value="'.$i.'" ';
            if ($value == $i){
              $form = $form.'selected="selected"';
            }
            $form = $form.'>'.$i.'</option>';
        }
      $form = $form.'</select>';

      return $form;
  }

  private function selectKlasseValues($turnierpaar, $value, $elemenID){

      $form = '<select name="'.$elemenID.'" id="'.$elemenID.'">';

      $form = $form.'<option value="" ';
      if ($value == ""){
        $form = $form.'selected="selected"';
      }
      $form = $form.'>-- Bitte Startklasse auswählen--</option>';

      if($turnierpaar['classLAT'] != "" ){
          if($value == $turnierpaar['classLAT']." Lat"){
            $form = $form.'<option value="'.$turnierpaar['classLAT'].' Lat" selected="selected">'.$turnierpaar['classLAT'].' Lat</option>'; }
          else{
            $form = $form.'<option value="'.$turnierpaar['classLAT'].' Lat">'.$turnierpaar['classLAT'].' Lat</option>';
          }
      }

      if($turnierpaar['classLAT2'] != "" ){
          if($value == $turnierpaar['classLAT2']." Lat"){
            $form = $form.'<option value="'.$turnierpaar['classLAT2'].' Lat" selected="selected">'.$turnierpaar['classLAT2'].' Lat</option>'; }
          else{
            $form = $form.'<option value="'.$turnierpaar['classLAT2'].' Lat">'.$turnierpaar['classLAT2'].' Lat</option>';
          }
      }

      if($turnierpaar['classSTD'] != "" ){
          if($value == $turnierpaar['classSTD']." Std"){
            $form = $form.'<option value="'.$turnierpaar['classSTD'].' Std" selected="selected">'.$turnierpaar['classSTD'].' Std</option>'; }
          else{
            $form = $form.'<option value="'.$turnierpaar['classSTD'].' Std">'.$turnierpaar['classSTD'].' Std</option>';
          }
      }

      if($turnierpaar['classSTD2'] != "" ){
          if($value == $turnierpaar['classSTD2']." Std"){
            $form = $form.'<option value="'.$turnierpaar['classSTD2'].' Std" selected="selected">'.$turnierpaar['classSTD2'].' Std</option>'; }
          else{
            $form = $form.'<option value="'.$turnierpaar['classSTD2'].' Std">'.$turnierpaar['classSTD2'].' Std</option>';
          }
      }
      $form = $form.'<option value="">-- nächst höhere Startklasse --</option>';

      switch ($turnierpaar['classLAT']){

       case "Kin I D": $form = $form.'<option value="Kin I C Lat">Kin I C Lat</option>'; break;
       case "Kin II D": $form = $form.'<option value="Kin II C Lat">Kin II C Lat</option>'; break;
       case "Jun I D": $form = $form.'<option value="Jun I C Lat">Jun I C Lat</option>'; break;
       case "Jun I C": $form = $form.'<option value="Jun I B Lat">Jun I B Lat</option>'; break;
       case "Jun II D": $form = $form.'<option value="Jun II C Lat">Jun II C Lat</option>';break;
       case "Jun II C": $form = $form.'<option value="Jun II B Lat">Jun II B Lat</option>'; break;
       case "Jug D": $form = $form.'<option value="Jug C Lat">Jug C Lat</option>'; break;
       case "Jug C": $form = $form.'<option value="Jug B Lat">Jug B Lat</option>'; break;
       case "Jug B": $form = $form.'<option value="Jug A Lat">Jug A Lat</option>'; break;
       case "Hgr D": $form = $form.'<option value="Hgr C Lat">Hgr C Lat</option>'; break;
       case "Hgr C": $form = $form.'<option value="Hgr B Lat">Hgr B Lat</option>'; break;
       case "Hgr B": $form = $form.'<option value="Hgr A Lat">Hgr A Lat</option>'; break;
       case "Hgr A": $form = $form.'<option value="Hgr S Lat">Hgr S Lat</option>'; break;
       case "Hgr II D": $form = $form.'<option value="Hgr II C Lat">Hgr II C Lat</option>'; break;
       case "Hgr II C": $form = $form.'<option value="Hgr II B Lat">Hgr II B Lat</option>'; break;
       case "Hgr II B": $form = $form.'<option value="Hgr II A Lat">Hgr II A Lat</option>'; break;
       case "Hgr II A": $form = $form.'<option value="Hgr II S Lat">Hgr II S Lat</option>'; break;
       case "MAS I D": $form = $form.'<option value="MAS I C Lat">MAS I C Lat</option>'; break;
       case "MAS I C": $form = $form.'<option value="MAS I B Lat">MAS I B Lat</option>'; break;
       case "MAS I B": $form = $form.'<option value="MAS I A Lat">MAS I A Lat</option>'; break;
       case "MAS I A": $form = $form.'<option value="MAS I S Lat">MAS I S Lat</option>'; break;
       case "MAS II D": $form = $form.'<option value="MAS II C Lat">MAS II C Lat</option>'; break;
       case "MAS II C": $form = $form.'<option value="MAS II B Lat">MAS II B Lat</option>'; break;
       case "MAS II B": $form = $form.'<option value="MAS II A Lat">MAS II A Lat</option>'; break;
       case "MAS II A": $form = $form.'<option value="MAS II S Lat">MAS II S Lat</option>'; break;

       case "Fortgeschrittene LWD 1 Combi" : $form = $form.'<option value="Leistungsklasse LWD 1 Combi Lat">Leistungsklasse LWD 1 Combi Lat</option>';
           break;

       case "Fortgeschrittene LWD 2 Combi" : $form = $form.'<option value="Leistungsklasse LWD 2 Combi Lat">Leistungsklasse LWD 2 Combi Lat</option>';
           break;

       case "Fortgeschrittene LWD 1 Duo" : $form = $form.'<option value="Leistungsklasse LWD 1 Duo Lat">Leistungsklasse LWD 1 Duo Lat</option>';
           break;
       case "Fortgeschrittene LWD 2 Duo" : $form = $form.'<option value="Leistungsklasse LWD 2 Duo Lat">Leistungsklasse LWD 2 Duo Lat</option>';
           break;

       }
       switch ($turnierpaar['classLAT2']){

       case "Kin I D": $form = $form.'<option value="Kin I C Lat">Kin I C Lat</option>'; break;
       case "Kin II D": $form = $form.'<option value="Kin II C Lat">Kin II C Lat</option>'; break;
       case "Jun I D": $form = $form.'<option value="Jun I C Lat">Jun I C Lat</option>';break;
       case "Jun I C": $form = $form.'<option value="Jun I B Lat">Jun I B Lat</option>'; break;
       case "Jun II D": $form = $form.'<option value="Jun II C Lat">Jun II C Lat</option>'; break;
       case "Jun II C": $form = $form.'<option value="Jun II B Lat">Jun II B Lat</option>'; break;
       case "Jug D": $form = $form.'<option value="Jug C Lat">Jug C Lat</option>'; break;
       case "Jug C": $form = $form.'<option value="Jug B Lat">Jug B Lat</option>'; break;
       case "Jug B": $form = $form.'<option value="Jug A Lat">Jug A Lat</option>'; break;
       case "Hgr D": $form = $form.'<option value="Hgr C Lat">Hgr C Lat</option>'; break;
       case "Hgr C": $form = $form.'<option value="Hgr B Lat">Hgr B Lat</option>'; break;
       case "Hgr B": $form = $form.'<option value="Hgr A Lat">Hgr A Lat</option>'; break;
       case "Hgr A": $form = $form.'<option value="Hgr S Lat">Hgr S Lat</option>'; break;
       case "Hgr II D": $form = $form.'<option value="Hgr II C Lat">Hgr II C Lat</option>'; break;
       case "Hgr II C": $form = $form.'<option value="Hgr II B Lat">Hgr II B Lat</option>'; break;
       case "Hgr II B": $form = $form.'<option value="Hgr II A Lat">Hgr II A Lat</option>'; break;
       case "Hgr II A": $form = $form.'<option value="Hgr II S Lat">Hgr II S Lat</option>'; break;
       case "MAS I D": $form = $form.'<option value="MAS I C Lat">MAS I C Lat</option>'; break;
       case "MAS I C": $form = $form.'<option value="MAS I B Lat">MAS I B Lat</option>'; break;
       case "MAS I B": $form = $form.'<option value="MAS I A Lat">MAS I A Lat</option>'; break;
       case "MAS I A": $form = $form.'<option value="MAS I S Lat">MAS I S Lat</option>'; break;
       case "MAS II D": $form = $form.'<option value="MAS II C Lat">MAS II C Lat</option>'; break;
       case "MAS II C": $form = $form.'<option value="MAS II B Lat">MAS II B Lat</option>'; break;
       case "MAS II B": $form = $form.'<option value="MAS II A Lat">MAS II A Lat</option>'; break;
       case "MAS II A": $form = $form.'<option value="MAS II S Lat">MAS II S Lat</option>'; break;

       }
     switch ($turnierpaar['classSTD']){

       case "Kin I D": $form = $form.'<option value="Kin I C Std">Kin I C Std</option>'; break;
       case "Kin II D": $form = $form.'<option value="Kin II C Std">Kin II C Std</option>'; break;
       case "Jun I D": $form = $form.'<option value="Jun I C Std">Jun I C Std</option>'; break;
       case "Jun I C": $form = $form.'<option value="Jun I B Std">Jun I B Std</option>'; break;
       case "Jun II D": $form = $form.'<option value="Jun II C Std">Jun II C Std</option>'; break;
       case "Jun II C": $form = $form.'<option value="Jun II B Std">Jun II B Std</option>'; break;
       case "Jug D": $form = $form.'<option value="Jug C Std">Jug C Std</option>'; break;
       case "Jug C": $form = $form.'<option value="Jug B Std">Jug B Std</option>'; break;
       case "Jug B": $form = $form.'<option value="Jug A Std">Jug A Std</option>'; break;
       case "Hgr D": $form = $form.'<option value="Hgr C Std">Hgr C Std</option>'; break;
       case "Hgr C": $form = $form.'<option value="Hgr B Std">Hgr B Std</option>'; break;
       case "Hgr B": $form = $form.'<option value="Hgr A Std">Hgr A Std</option>'; break;
       case "Hgr A": $form = $form.'<option value="Hgr S Std">Hgr S Std</option>'; break;
       case "Hgr II D": $form = $form.'<option value="Hgr II C Std">Hgr II C Std</option>'; break;
       case "Hgr II C": $form = $form.'<option value="Hgr II B Std">Hgr II B Std</option>'; break;
       case "Hgr II B": $form = $form.'<option value="Hgr II A Std">Hgr II A Std</option>'; break;
       case "Hgr II A": $form = $form.'<option value="Hgr II S Std">Hgr II S Std</option>'; break;
       case "MAS I D": $form = $form.'<option value="MAS I C Std">MAS I C Std</option>'; break;
       case "MAS I C": $form = $form.'<option value="MAS I B Std">MAS I B Std</option>'; break;
       case "MAS I B": $form = $form.'<option value="MAS I A Std">MAS I A Std</option>'; break;
       case "MAS I A": $form = $form.'<option value="MAS I S Std">MAS I S Std</option>'; break;
       case "MAS II D": $form = $form.'<option value="MAS II C Std">MAS II C Std</option>'; break;
       case "MAS II C": $form = $form.'<option value="MAS II B Std">MAS II B Std</option>'; break;
       case "MAS II B": $form = $form.'<option value="MAS II A Std">MAS II A Std</option>'; break;
       case "MAS II A": $form = $form.'<option value="MAS II S Std">MAS II S Std</option>'; break;
       case "MAS III D": $form = $form.'<option value="MAS III C Std">MAS III C Std</option>'; break;
       case "MAS III C": $form = $form.'<option value="MAS III B Std">MAS III B Std</option>'; break;
       case "MAS III B": $form = $form.'<option value="MAS III A Std">MAS III A Std</option>'; break;
       case "MAS III A": $form = $form.'<option value="MAS III S Std">MAS III S Std</option>'; break;
       case "MAS IV D": $form = $form.'<option value="MAS IV C Std">MAS IV C Std</option>'; break;
       case "MAS IV C": $form = $form.'<option value="MAS IV B Std">MAS IV B Std</option>'; break;
       case "MAS IV B": $form = $form.'<option value="MAS IV A Std">MAS IV A Std</option>'; break;
       case "MAS IV A": $form = $form.'<option value="MAS IV S Std">MAS IV S Std</option>'; break;

       case "Beginners LWD 1 Combi" :
             $form = $form.'<option value="Fortgeschrittene LWD 1 Combi Std">Fortgeschrittene LWD 1 Combi Std</option>';
           $form = $form.'<option value="Fortgeschrittene LWD 1 Combi Lat">Fortgeschrittene LWD 1 Combi Lat</option>';
           break;

       case "Beginners LWD 2 Combi" :
             $form = $form.'<option value="Fortgeschrittene LWD 2 Combi Std">Fortgeschrittene LWD 2 Combi Std</option>';
           $form = $form.'<option value="Fortgeschrittene LWD 2 Combi Lat">Fortgeschrittene LWD 2 Combi Lat</option>';
           break;

       case "Beginners LWD 1 Duo" :
             $form = $form.'<option value="Fortgeschrittene LWD 1 Duo Std">Fortgeschrittene LWD 1 Duo Std</option>';
           $form = $form.'<option value="Fortgeschrittene LWD 1 Duo Lat">Fortgeschrittene LWD 1 Duo Lat</option>';
           break;
       case "Beginners LWD 2 Duo" :
             $form = $form.'<option value="Fortgeschrittene LWD 2 Duo Std">Fortgeschrittene LWD 2 Duo Std</option>';
           $form = $form.'<option value="Fortgeschrittene LWD 2 Duo Lat">Fortgeschrittene LWD 2 Duo Lat</option>';
           break;

       case "Fortgeschrittene LWD 1 Combi" :
             $form = $form.'<option value="Leistungsklasse LWD 1 Combi Std">Leistungsklasse LWD 1 Combi Std</option>';
           break;

       case "Fortgeschrittene LWD 2 Combi" :
             $form = $form.'<option value="Leistungsklasse LWD 2 Combi Std">Leistungsklasse LWD 2 Combi Std</option>';
           break;

       case "Fortgeschrittene LWD 1 Duo" :
             $form = $form.'<option value="Leistungsklasse LWD 1 Duo Std">Leistungsklasse LWD 1 Duo Std</option>';
           break;
       case "Fortgeschrittene LWD 2 Duo" :
             $form = $form.'<option value="Leistungsklasse LWD 2 Duo Std">Leistungsklasse LWD 2 Duo Std</option>';
           break;

       }

         switch ($turnierpaar['classSTD2']){

       case "Kin I D": $form = $form.'<option value="Kin I C Std">Kin I C Std</option>'; break;
       case "Kin II D": $form = $form.'<option value="Kin II C Std">Kin II C Std</option>'; break;
       case "Jun I D": $form = $form.'<option value="Jun I C Std">Jun I C Std</option>'; break;
       case "Jun I C": $form = $form.'<option value="Jun I B Std">Jun I B Std</option>'; break;
       case "Jun II D": $form = $form.'<option value="Jun II C Std">Jun II C Std</option>'; break;
       case "Jun II C": $form = $form.'<option value="Jun II B Std">Jun II B Std</option>'; break;
       case "Jug D": $form = $form.'<option value="Jug C Std">Jug C Std</option>'; break;
       case "Jug C": $form = $form.'<option value="Jug B Std">Jug B Std</option>'; break;
       case "Jug B": $form = $form.'<option value="Jug A Std">Jug A Std</option>'; break;
       case "Hgr D": $form = $form.'<option value="Hgr C Std">Hgr C Std</option>'; break;
       case "Hgr C": $form = $form.'<option value="Hgr B Std">Hgr B Std</option>'; break;
       case "Hgr B": $form = $form.'<option value="Hgr A Std">Hgr A Std</option>'; break;
       case "Hgr A": $form = $form.'<option value="Hgr S Std">Hgr S Std</option>'; break;
       case "Hgr II D": $form = $form.'<option value="Hgr II C Std">Hgr II C Std</option>'; break;
       case "Hgr II C": $form = $form.'<option value="Hgr II B Std">Hgr II B Std</option>'; break;
       case "Hgr II B": $form = $form.'<option value="Hgr II A Std">Hgr II A Std</option>'; break;
       case "Hgr II A": $form = $form.'<option value="Hgr II S Std">Hgr II S Std</option>'; break;
       case "MAS I D": $form = $form.'<option value="MAS I C Std">MAS I C Std</option>';  break;
       case "MAS I C": $form = $form.'<option value="MAS I B Std">MAS I B Std</option>'; break;
       case "MAS I B": $form = $form.'<option value="MAS I A Std">MAS I A Std</option>'; break;
       case "MAS I A": $form = $form.'<option value="MAS I S Std">MAS I S Std</option>'; break;
       case "MAS II D": $form = $form.'<option value="MAS II C Std">MAS II C Std</option>'; break;
       case "MAS II C": $form = $form.'<option value="MAS II B Std">MAS II B Std</option>'; break;
       case "MAS II B": $form = $form.'<option value="MAS II A Std">MAS II A Std</option>'; break;
       case "MAS II A": $form = $form.'<option value="MAS II S Std">MAS II S Std</option>'; break;
       case "MAS III D": $form = $form.'<option value="MAS III C Std">MAS III C Std</option>'; break;
       case "MAS III C": $form = $form.'<option value="MAS III B Std">MAS III B Std</option>'; break;
       case "MAS III B": $form = $form.'<option value="MAS III A Std">MAS III A Std</option>'; break;
       case "MAS III A": $form = $form.'<option value="MAS III S Std">MAS III S Std</option>'; break;
       case "MAS IV D": $form = $form.'<option value="MAS IV C Std">MAS IV C Std</option>'; break;
       case "MAS IV C": $form = $form.'<option value="MAS IV B Std">MAS IV B Std</option>'; break;
       case "MAS IV B": $form = $form.'<option value="MAS IV A Std">MAS IV A Std</option>'; break;
       case "MAS IV A": $form = $form.'<option value="MAS IV S Std">MAS IV S Std</option>'; break;
       }

      $form = $form.'</select>';

      return $form;
  }

	protected function compile()
	{

    $assetsDir = 'bundles/turnierpaarverwaltung/';

    if (TL_MODE == 'BE')
    {
      return;
    }

    $objUser = \FrontendUser::getInstance();
    $userid = $objUser->id;
    $userfn = $objUser->firstname;
    $userln = $objUser->lastname;

    $sql = "SELECT * FROM tl_turnierpaare WHERE aktiv = 1 AND (dame_id = $userid || herr_id = $userid) LIMIT 1";

    $turnierpaare = \Database::getInstance()->query($sql)->fetchAllAssoc();
    $paarid = '0';
    $this->Template->klasse = "";
    $paarName = "";
     if(sizeof($turnierpaare)>0){
       $turnierpaar = $turnierpaare[0];
       $paarid = $turnierpaar['id'];
     	 $this->Template->turnierpaarID = $turnierpaar['id'];
       $paarName = $turnierpaar['Hvorname']." ".$turnierpaar['Hnachname']." - ".$turnierpaar['Dvorname']." ".$turnierpaar['Dnachname'];
       $this->Template->turnierpaarName  = $paarName;
       $this->Template->klasse = $this->selectKlasseValues($turnierpaar,NULL,"klasse");
     }

     $this->Template->platz = $this->selectValues(1, 0, 'platz');
     $this->Template->bis_platz = $this->selectValues(2, 0, 'bis_platz');
     $this->Template->geteilt = "";
     $this->Template->paare = $this->selectValues(3, 0, 'paare');
     $this->Template->errorPlatzierung = "";
     $this->Template->ort = "";
     $this->Template->errorOrt = "";
     $this->Template->kommentar = "";
     $this->Template->infoRedaktion = "";
     $this->Template->errorKlasse = "";
     $this->Template->errorBild = "";
     $this->Template->status = "";

     $GLOBALS['TL_JAVASCRIPT'][] = $assetsDir.'js/turnierpaar_ergebnis.js';
     $GLOBALS['TL_JAVASCRIPT'][] = '//code.jquery.com/jquery-1.12.4.js';
     $GLOBALS['TL_JAVASCRIPT'][] = '//code.jquery.com/ui/1.12.1/jquery-ui.js';
     $GLOBALS['TL_CSS'][] = '//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css';

	   if(\Input::post('datepicker')==""){
        $this->Template->ergebnisDate = date('dd.mm.yy');
  	  }else{
        $this->Template->ergebnisDate = \Input::post('datepicker');
      }

     if (\Input::post('pid') == $paarid){

          $platz = \Input::post('platz');
          $bis_platz = \Input::post('bis_platz');
          $paare = \Input::post('paare');
          $ort = \Input::post('ort');
          $kommentar = \Input::post('kommentar');
          $infoRedaktion = \Input::post('infoRedaktion');
          $geteilt = \Input::post('geteilt');
          $klasse = \Input::post('klasse');

          $check = true;

          if(isset($geteilt)){
            $geteilt = 'checked="checked"';

            if ($bis_platz > $paare || $platz >= $bis_platz){
              $this->Template->errorPlatzierung = '<span style="color:#F00000;">Ungültige Platzierung</span>';
              $check = false;
            }

          }else{
            $geteilt = '';
            if ($platz > $paare){
              $this->Template->errorPlatzierung = '<span style="color:#F00000;">Ungültige Platzierung</span>';
              $check = false;
            }
          }

          if (strlen($ort) == 0){
            $this->Template->errorOrt = '<span style="color:#F00000;">Bitte gebe einen Ort an!</span>';
            $check = false;
          }
          if (strlen($klasse) == 0){
            $this->Template->errorKlasse = '<span style="color:#F00000;">Bitte gebe einen Startklasse an!</span>';
            $check = false;
          }

          if (strlen($klasse) == 0){
            $this->Template->errorKlasse = '<span style="color:#F00000;">Bitte gebe einen Startklasse an!</span>';
            $check = false;
          }

          if(sizeof($turnierpaare)>0){
            $turnierpaar = $turnierpaare[0];
            $this->Template->klasse = $this->selectKlasseValues($turnierpaar,$klasse,"klasse");
          }

          if( strlen($_FILES['datei_feld']['name'])>0){
            if(($_FILES["datei_feld"]["type"] != "image/gif")
                && ($_FILES["datei_feld"]["type"] != "image/jpeg")
                && ($_FILES["datei_feld"]["type"] != "image/png" )){
                  $this->Template->errorBild = '<span style="color:#F00000;">Bitte nur Bilder hochladen!</span>';
                  $check = false;
            }

            if($_FILES['datei_feld']['size']>3000000){
                $this->Template->errorBild = '<span style="color:#F00000;">Leider ist das Bild zu groß!</span>';
                $check = false;
            }
          }

          if ($check == false){
            $this->Template->platz = $this->selectValues(1, $platz, 'platz');
            $this->Template->bis_platz = $this->selectValues(2, $bis_platz, 'bis_platz');
            $this->Template->paare = $this->selectValues(3, $paare, 'paare');
            $this->Template->geteilt = $geteilt;
            $this->Template->ort = $ort;
            $this->Template->kommentar = $kommentar;
            $this->Template->infoRedaktion = $infoRedaktion;
          }else{

            if(strlen($geteilt) > 0){
								$platz= $platz.". - ".$bis_platz.".";
              }else{
              	$platz= $platz.".";
            }

            ### Konfiguration ###

            $strMailtext = "<p>Neues Turnierergebnis:</p>";
            $strMailtext .="<p>Ort: ".$ort."</br>";
            $strMailtext .="Datum: ".\Input::post('datepicker')."</br>";
            $strMailtext .="Paar: ".$paarName."</br>";
            $strMailtext .="Klasse: ".$klasse."</br>";
            $strMailtext .="Platz: ".$platz."</br>";
            $strMailtext .="Paare am Start: ".$paare."</p>";
            $strMailtext .="<p>Kommentar: ".$kommentar."</p>";
            $strMailtext .="<p>Info an die Redaktion:</p>".$infoRedaktion;

            $anhang = array();
            if( strlen($_FILES['datei_feld']['name'])>0){
            $anhang["name"] = $_FILES['datei_feld']['name'];
            $anhang["size"] = $_FILES['datei_feld']['size'];
            $anhang["type"] = $_FILES['datei_feld']['type'];
            $anhang["data"] = implode("",file($_FILES['datei_feld']['tmp_name']));
            }
            
            $datum = strtotime(\Input::post('datepicker'));

            $sql	= "INSERT INTO tl_turnierergebnisse (pid, platz, paare, ort, klasse, datum, kommentar) VALUES ($paarid, '$platz', '$paare', '$ort', '$klasse', $datum, '$kommentar')";
            \Database::getInstance()->query($sql);

            $this->mail_att($strMailtext,$anhang);
            $this->Template->status = '<p style="color:#008000;">Ergebnis erfolgreich abgeschickt!</p>';

          }
        }

	}

}

?>
