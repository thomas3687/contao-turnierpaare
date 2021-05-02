<?php

namespace ThomasBilich\Turnierpaarverwaltung\Models;
use Contao;

class TanzpartnervermittlungCRON extends \Frontend{

	public function checkAnzeigen(){
		//Lösche Einträge die äter als 90 Tage sind
		$days = time()-60*60*24*90;
		
		\Database::getInstance()->prepare("DELETE FROM tl_tanzpartnervermittlung WHERE date < ?")->execute($days);
		
		//Inserat ist länger als 75 Tage drin benachrichtigen
// 		$days = time()-60*60*24*75;
		
// 		$result = \Database::getInstance()->prepare("SELECT * FROM tl_tanzpartnervermittlung WHERE date < ? AND activated = 'Y' AND notified = 0")->execute($days);
// 		$anzeigen = $result->fetchAllAssoc();
		
// 		foreach ($anzeigen as $anzeige){
			
// 			$name = $anzeige['vorname'];
// 			$code = $anzeige['code'];
// 			$email = $anzeige['email'];
		
// 			$body="Hallo $name!

// Du hast Dich in die Tanzpartnersuche des TSC Astoria Karlsruhe e.V. eingetragen. Das ist jetzt schon zwei Monate her. Bist Du weiterhin auf der Suche?
// Mit folgendem Link kannst Du deinen Eintrag um weitere 2 Monate verlängern:

// https://www.astoria-karlsruhe.de/tanzpartnersuche.html?activate=$code


// Du hast bereits jemanden gefunden? Mit diesem Link kannst Du deinen Eintrag auch sofort entfernen:

// https://www.astoria-karlsruhe.de/tanzpartnersuche.html?activate=$code&remove=now

// Falls Du während der nächsten 2 Wochen Deinen Eintrag nicht verlängerst, wird der Eintrag automatisch aus der Liste genommen.

// Solltest Du später wieder einmal auf der Suche sein, kannst Du jederzeit hier
// einen neuen Eintrag erstellen:

// https://www.astoria-karlsruhe.de/tanzpartnersuche.html


// ";

//     		mail($email,"Astoria Tanzpartnersuche - Eintrag verlängern",$body,"From:partnervermittlung@astoria-karlsruhe.de");
			
// 			\Database::getInstance()->prepare("UPDATE tl_tanzpartnervermittlung SET notified = 1 WHERE code = ?")->execute($code);		
			
// 			}
		
		
 		}
	
}

?>