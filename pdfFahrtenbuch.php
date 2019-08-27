<?php
 session_start();

 $anzZeilen = 0; //Zeilen welche im .pdf aut einer Seite dargestellt werden.
 include '../TCPDF/tcpdf.php';
 
 $pdf = new TCPDF;// create TCPDF object with default constructor args
 //$pdf->AddPage('L', 'A4'); // A4 im Querformat
 $pdf->AddPage();
 // Print text using writeHTMLCell()

 $m = new MongoClient();
 $db = $m->$_SESSION['$dbName'];
 $collection = $db->fahrten;  

 //Datum aufsplitten, damit es in der funktion Maketime verwendet werden kann
 $vonTag   = substr($_POST["vonDatum"], 8, 2);
 $vonMonat = substr($_POST["vonDatum"], 5, 2);
 $vonJahr  = substr($_POST["vonDatum"], 0, 4);

 $bisTag   = substr($_POST["bisDatum"], 8, 2);
 $bisMonat = substr($_POST["bisDatum"], 5, 2);
 $bisJahr  = substr($_POST["bisDatum"], 0, 4);
 /*
 echo "vonTag ".$vonTag."<br>";
 echo "vonMonat ".$vonMonat."<br>";
 echo "vonJahr ".$vonJahr."<br>";

 echo "bisTag ".$bisTag."<br>";
 echo "bisMonat ".$bisMonat."<br>";
 echo "bisJahr ".$bisJahr."<br>";
 */
 $vonListe = date("d.m.Y", mktime(0, 0, 0, $vonMonat, $vonTag+1, $vonJahr)); //Warum die '+1' keine Ahnung, brauche diese aber für das richtige Datum.
 //$endeListe = date("d.m.Y",mktime(0, 0, 0, date("m"), date ("d")-10, date("Y"))); // letzten30Tage
 $listVon = new MongoDate (strtotime ("$vonListe")); 

 //$startListe = date("d.m.Y",mktime(0, 0, 0, date("m"), date ("d")-20, date("Y"))); // letzten30Tage
 $bisListe = date("d.m.Y", mktime(0, 0, 0, $bisMonat, $bisTag, $bisJahr));
 $listBis = new MongoDate (strtotime ("$bisListe"));

 //$findEreignis = array ('ISOstartDatum' => array('$gte' => $listBeginn), "ereignis" => "Fahrt");
 $findEreignis = array ('ISOstartDatum' => array('$lte' => $listVon, '$gte' => $listBis), "ereignis" => "Fahrt");
 $query = $collection->find($findEreignis);  
 $query->sort(array('endeKM' => -1));
 
 $text = "<table border=\"0\" style=\"width:100%\">";
 $text = $text."<tr>";
 $text = $text."<td colspan=\"4\">&nbsp;</td>";
 $text = $text."</tr>";
 foreach ($query as $current)
          {  
           //ISO Datum startFahrt ausgeben
				   $current["ISOstartDatum"] = date(DATE_ISO8601, $current["ISOstartDatum"]->sec);
				   $ISO_JahrStart  = substr($current["ISOstartDatum"], 0, 4);
	         $ISO_MonatStart = substr($current["ISOstartDatum"], 5, 2);
	         $ISO_TagStart   = substr($current["ISOstartDatum"], 8, 2);
	         $ISO_UhrzeitStart = substr($current["ISOstartDatum"], 11, 5);
		       $ISO_DatumStart = $ISO_TagStart.".".$ISO_MonatStart.".".$ISO_JahrStart."&nbsp;".$ISO_UhrzeitStart;			 
				   //Wochentag start ausgeben
				   $timestamp = mktime(0,0,0,$ISO_MonatStart,$ISO_TagStart,$ISO_JahrStart);
				   $wochentagStart = date("D",$timestamp);
   
           //ISO Datum endeFahrt ausgeben
				   $current["ISOendeDatum"] = date(DATE_ISO8601, $current["ISOendeDatum"]->sec);
				   $ISO_JahrEnde  = substr($current["ISOendeDatum"], 0, 4);
	         $ISO_MonatEnde = substr($current["ISOendeDatum"], 5, 2);
	         $ISO_TagEnde   = substr($current["ISOendeDatum"], 8, 2);
	         $ISO_UhrzeitEnde = substr($current["ISOendeDatum"], 11, 5);
		       $ISO_DatumEnde = $ISO_TagEnde.".".$ISO_MonatEnde.".".$ISO_JahrEnde."&nbsp;".$ISO_UhrzeitEnde;		 
				   //Wochentag ende ausgeben
				   $timestampEnde = mktime(0,0,0,$ISO_MonatEnde,$ISO_TagEnde,$ISO_JahrEnde);
				   $wochentagEnde = date("D",$timestampEnde);
     
           $divKM = $current['endeKM'] - $current['startKM'];         
   
           if ($startKMvorher > $current['endeKM'])
					           {
					            // Privat anzeigen
					            $kmDiv = $startKMvorher - $current['endeKM'];
					            $gesPrivKmDiv = $gesPrivKmDiv + $kmDiv;
					            $text = $text."<tr>";
							        $text = $text."<td width=\"30%\"><font color=\"green\">Privat</font></td>";
							        $text = $text."<td colspan=\"3\" width=\"70%\"><font color=\"green\">".$kmDiv." Km </font></td>";
							        $text = $text."</tr>";
                      $text = $text."<tr><td colspan=\"4\" height=\"1\">&nbsp;</td></tr>";
                      $text = $text."<hr>";
                      $text = $text."<tr><td colspan=\"4\" height=\"1\">&nbsp;</td></tr>";
                      $anzZeilen = $anzZeilen + 3;
                     }
   
           $text = $text."<tr>";
	      	 $text = $text."<td width=\"30%\"><font size=\"10\">".$wochentagStart." ".$ISO_DatumStart."</font></td>";
           $text = $text."<td width=\"10%\">&nbsp;</td>";
           $text = $text."<td width=\"30%\"><font size=\"10\">".$wochentagEnde." ".$ISO_DatumEnde."</font></td>";
           $text = $text."<td width=\"30%\" rowspan=\"3\"><font size=\"8\">".$current['bemerkung']."</font></td>";
           $text = $text."</tr>";
           $text = $text."<tr>";
           $text = $text."<td width=\"30%\"><font size=\"13\">".$current['startOrt']."</font></td>";
           $text = $text."<td width=\"10%\">&nbsp;</td>";
           $text = $text."<td width=\"30%\"><font size=\"13\">".$current['endeOrt']."</font></td>";
           $text = $text."</tr>";
           $text = $text."<tr>";
           $text = $text."<td width=\"30%\"><font size=\"10\">Start KM - ".$current['startKM']."</font></td>";
           $text = $text."<td width=\"10%\"><font size=\"10\">Div. ".$divKM."</font></td>";
           $text = $text."<td width=\"30%\"><font size=\"10\">Start KM - ".$current['endeKM']."</font></td>";
           $text = $text."</tr>";
           $text = $text."<tr><td colspan=\"4\" height=\"1\">&nbsp;</td></tr>";
           $text = $text."<hr>";
           $text = $text."<tr><td colspan=\"4\" height=\"1\">&nbsp;</td></tr>";
           if ($anzZeilen > 37)
               {
                $text = $text."<br pagebreak=\"true\"/>";
                $anzZeilen = 0;
               }
           $anzZeilen = $anzZeilen + 5;
           $startKMvorher = $current['startKM']; 
          }
 $text = $text."</table>";

 $text = $text."Hallo Welt \n<br>\nIch bins ".$_COOKIE["eMail"]." Noch ein Text";

 $pdf->writeHTMLCell(0, 0, '', '', $text, 0, 1, 0, true, '', true);
 //$pdf->Write(1, $html);      // 1 is line height
 $pdf->Output('Fahrtenbuch.pdf', 'I');    // send the file inline to the browser (default).
?>