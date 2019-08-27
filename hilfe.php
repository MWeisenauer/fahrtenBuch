<?php
			//Wenn ich abgemeldet bin, weiterleitung auf die 'index.php' seite um die App zu beginnen.
			if ($_COOKIE["eMail"] == 'Abgemeldet')
			    {
				   ?>
			      <script language="javascript" type="text/javascript">
				     //window.document.location.href = "index.php";
	          </script>
		       <?php
			    }
			
      $_SESSION['$dbName'] = 'Markus_Weisenauer_de_Touareg_V8_TDI_KL-MM_110';
      
			//Ersetzungen in E-Mail
			$suchen = array("@", ".");
      $ersetzen = array("_", "_");
      $_SESSION['$dbName'] = str_replace($suchen, $ersetzen, $_COOKIE["eMail"]);
			
			//Ersetzungen in fahrzeugTyp
			$suchen = array(" ");
      $ersetzen = array("_");
      $_SESSION['$dbName'] = $_SESSION['$dbName']."_".str_replace($suchen, $ersetzen, $_COOKIE["fahrzeugTyp"]);
			
			//Ersetzungen in Nummernschild
			$suchen = array(" ");
      $ersetzen = array("_");
      $_SESSION['$dbName'] = $_SESSION['$dbName']."_".str_replace($suchen, $ersetzen, $_COOKIE["nrSchild"]);
			
			if ($_SESSION['$dbName'] == "__")
			    {
				   ?>
			      <script language="javascript" type="text/javascript">
				     //window.document.location.href = "index.php";
	          </script>
		       <?php
			    }
      
      // Post in Session Variable schreiben    
      if ( isset ( $_POST["fahrtenAnzeige"] ) )
           {
            $_SESSION ["fahrtenAnzeige"] = $_POST["fahrtenAnzeige"];
            }
      
      if ($_SESSION["fahrtenAnzeige"] == "letzten30Tage")
          {
           $startListe = date("d.m.Y",mktime(0, 0, 0, date("m"), date ("d")-30, date("Y"))); // letzten30Tage
           $listBeginn = new MongoDate (strtotime ("$startListe"));
           $findEreignis = array ('ISOstartDatum' => array( '$gte' => $listBeginn), "ereignis" => "Fahrt");
          }
      if ($_SESSION["fahrtenAnzeige"] == "Monatsanfang")
          {
           $startListe = date('d.m.Y',mktime(0, 0 ,0 ,date("m") ,1 ,date("Y"))); // Monatsanfang - aktueller Monat
           $listBeginn = new MongoDate (strtotime ("$startListe"));
           $findEreignis = array ('ISOstartDatum' => array( '$gte' => $listBeginn), "ereignis" => "Fahrt");
          }
      if ($_SESSION["fahrtenAnzeige"] == "Vormonat")
          {
           $startListe = date("d.m.Y",mktime(0, 0, 0, date("m")-1, 1, date("Y"))); //beginnend mit vorigem Monat
           $listBeginn = new MongoDate (strtotime ("$startListe"));
           $findEreignis = array ('ISOstartDatum' => array( '$gte' => $listBeginn), "ereignis" => "Fahrt");
          }
      if ($_SESSION["fahrtenAnzeige"] == "Jahr")
          {
           $startListe = date("d.m.Y",mktime(0, 0, 0, 1, 1, date("Y"))); // komplette aktuelle Jahr
           $listBeginn = new MongoDate (strtotime ("$startListe"));
           $findEreignis = array ('ISOstartDatum' => array( '$gte' => $listBeginn), "ereignis" => "Fahrt");
          }
      if ($_SESSION["fahrtenAnzeige"] == "Jahr_2017")
          {
           $startListe = date("d.m.Y", mktime(0, 0, 0, date(12), date(31), date(2017)));
           $endeListe = date("d.m.Y", mktime(0, 0, 0, date(1), date(1), date(2017)));
           $listBeginn = new MongoDate (strtotime ("$startListe")); 
           $listEnde = new MongoDate (strtotime ("$endeListe"));
           $findEreignis = array ('ISOstartDatum' => array('$lte' => $listBeginn, '$gte' => $listEnde), "ereignis" => "Fahrt");
          }
      if ($_SESSION["fahrtenAnzeige"] == "alleFahrten")
          {
           $findEreignis = array ("ereignis" => "Fahrt");
          }
     
			?>




<form method="post" action="#">
       <table align="center">
        <tr>
         <td>Anzeige: </td>
         <td>
          <select name="fahrtenAnzeige" id="fahrtenAnzeige">
           <?php
            if ($_SESSION["fahrtenAnzeige"] == "letzten30Tage")
                { echo "<option value=letzten30Tage selected >letzten 30 Tage</option>"; }
             else
                { echo "<option value=letzten30Tage>letzten 30 Tage</option>"; }
            
            if ($_SESSION["fahrtenAnzeige"] == "Monatsanfang")
                { echo "<option value=Monatsanfang selected >Monatsanfang</option>"; }
             else
                { echo "<option value=Monatsanfang>Monatsanfang</option>"; }
            
            if ($_SESSION["fahrtenAnzeige"] == "Vormonat")
                { echo "<option value=Vormonat selected >Vormonat anfang</option>"; }
             else
                { echo "<option value=Vormonat>Vormonat anfang</option>"; }
            
            if ($_SESSION["fahrtenAnzeige"] == "Jahr")
                { echo "<option value=Jahr selected >Jahr anfang</option>"; }
             else
                { echo "<option value=Jahr>Jahr anfang</option>"; }
            
            if ($_SESSION["fahrtenAnzeige"] == "Jahr_2017")
                { echo "<option value=Jahr_2017 selected >Jahr 2017</option>"; }
             else
                { echo "<option value=Jahr_2017>Jahr 2017</option>"; }
            
            if ($_SESSION["fahrtenAnzeige"] == "alle Fahrten")
                { echo "<option value=alleFahrten selected >alle Fahrten</option>"; }
             else
                { echo "<option value=alleFahrten>alle Fahrten</option>"; }
           ?>
           </select>
         </td>
         <td>
          <button style="color:green" type=submit name="action" value="OK">OK</button>
         </td>
        </tr>
       </table>
      </form>


//Anzeigen, Nachfolgefahrt beginnt vor ende dieser Fahrt
					       if ($x > 1)
					           {
					            if ($startKMvorher < $current["endeKM"])
					                { 
				                   ?>
				                    <script>
					                   var idZahl = <?php echo $durchlaufZahl - 1 ?>;
					                   var idZahlCurrent = <?php echo $durchlaufZahl ?>;
					                   document.getElementById(idZahl).innerHTML = '<font color="red">Start KM</font><font color="black"> vor </font><font color="orange">Ende KM</font>';
					                   document.getElementById('startKM' + idZahl).innerHTML = '<font color="red"><?php echo $startKMvorher ?></font>';
					                   document.getElementById(idZahlCurrent).innerHTML = '<font color="orange">Ende KM</font><font color="black"> nach </font><font color="red">Start KM</font>';
					                   document.getElementById('endeKM' + idZahlCurrent).innerHTML = '<font color="orange"><?php echo $current['endeKM '] ?></font>';
				                    </script>
				                   <?php
					                }
					           }
                                 
                 
                                 
                                 
                 //ISO Datum ausgeben
				         $current["ISOstartDatum"] = date(DATE_ISO8601, $current["ISOstartDatum"]->sec);
				         $ISO_Jahr  = substr($current["ISOstartDatum"], 0, 4);
	               $ISO_Monat = substr($current["ISOstartDatum"], 5, 2);
	               $ISO_Tag   = substr($current["ISOstartDatum"], 8, 2);
	               $ISO_Uhrzeit = substr($current["ISOstartDatum"], 11, 5);
		             $ISO_DatumEnde = $ISO_Tag.".".$ISO_Monat.".".$ISO_Jahr."&nbsp &nbsp".$ISO_Uhrzeit;
				 
				         //Wochentag ausgeben
				         $timestamp = mktime(0,0,0,$ISO_Monat,$ISO_Tag,$ISO_Jahr);
				         $wochentag = date("D",$timestamp);
				 
				         echo  "<tr><td colspan=\"4\"><font size=2>".$wochentag.'&nbsp;&nbsp;'.$ISO_DatumEnde."</td></tr>";
				         echo "</table>";
					       echo "</a>";
				         echo "</li>";
				         $endeKMvorher = $current->endeKM;
					       $startKMvorher = $current->startKM;
					       $startDatumVorher = $current->startDatum;
					       $durchlaufZahl = $durchlaufZahl + 1;
                                 
                 //ISO Datum ausgeben
				         $current["ISOendeDatum"] = date(DATE_ISO8601, $current["ISOendeDatum"]->sec);
				         $ISO_Jahr  = substr($current["ISOendeDatum"], 0, 4);
	               $ISO_Monat = substr($current["ISOendeDatum"], 5, 2);
	               $ISO_Tag   = substr($current["ISOendeDatum"], 8, 2);
	               $ISO_Uhrzeit = substr($current["ISOendeDatum"], 11, 5);
		             $ISO_Datum = $ISO_Tag.".".$ISO_Monat.".".$ISO_Jahr."&nbsp;&nbsp;".$ISO_Uhrzeit;
                 $ISO_DatumEintrag = $ISO_Tag."-".$ISO_Monat."-".$ISO_Jahr;
                 
                 $heute = strtotime("-5 days"); //Heute minus 5 Tage
                 $datumEndeFahrt = strtotime($ISO_DatumEintrag);
				 
				         //Wochentag ausgeben
				         $timestamp = mktime(0,0,0,$ISO_Monat,$ISO_Tag,$ISO_Jahr);
				         $wochentag = date("D",$timestamp);