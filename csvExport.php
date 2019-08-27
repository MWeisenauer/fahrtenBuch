<!DOCTYPE html>
<?php
 session_start();
?>
<html>
<head>
 <title>Fahrtenbuch</title>
	<meta charset="utf-8" />
</head>
<body>

<?php
       // connect to mongodb ich bin der neue
       $m = new MongoClient();
       //$_SESSION['$dbName'] = 'Markus_Weisenauer_de_Touareg_V8_TDI_KL-MM_110';
	     //$_SESSION['$dbName'] = 'Torsten_Kropp_mhp_com_Macan_SOL1338';
			 $db = $m->$_SESSION['$dbName'];
	     $collection = $db->fahrten;
       $findEreignis = array ("ereignis" => "Fahrt");
	     $query = $collection->find($findEreignis);
	     //$query = $collection->find($findEreignis).sort(array('endeKM' => -1));
	     $query->sort(array('endeKM' => -1));

	     $datei = fopen("Fahrtenbuch.csv", "w");   // Datei öffnen
	     $daten = 'startWochentag;startDatum;startKM;startOrt;endeWochentag;endeDatum;endeKM;endeOrt;ereignis;bemerkung';
	     fwrite($datei, $daten."\r\n");
       foreach ($query as $current)
                {
				         //Start Datum für csv Export berechnen
				         $current["ISOstartDatum"] = date(DATE_ISO8601, $current["ISOstartDatum"]->sec);
				         $start_Jahr  = substr($current["ISOstartDatum"], 0, 4);
	               $start_Monat = substr($current["ISOstartDatum"], 5, 2);
	               $start_Tag   = substr($current["ISOstartDatum"], 8, 2);
	               $start_Uhrzeit = substr($current["ISOstartDatum"], 11, 5);
		             $start_Datum = $start_Tag.".".$start_Monat.".".$start_Jahr.".".$start_Uhrzeit;

				         //Start Wochentag für csv Export berechnen
				         $timestamp = mktime(0,0,0,$start_Monat,$start_Tag,$start_Jahr);
				         $startWochentag = date("D",$timestamp);

				         //Ende Datum für csv Export berechnen
				         $current["ISOendeDatum"] = date(DATE_ISO8601, $current["ISOendeDatum"]->sec);
				         $ende_Jahr  = substr($current["ISOendeDatum"], 0, 4);
	               $ende_Monat = substr($current["ISOendeDatum"], 5, 2);
	               $ende_Tag   = substr($current["ISOendeDatum"], 8, 2);
	               $ende_Uhrzeit = substr($current["ISOendeDatum"], 11, 5);
		             $ende_Datum = $ende_Tag.".".$ende_Monat.".".$ende_Jahr.".".$ende_Uhrzeit;

				         //Ende Wochentag für csv Export berechnen
				         $timestamp = mktime(0,0,0,$ende_Monat,$ende_Tag,$ende_Jahr);
				         $endeWochentag = date("D",$timestamp);

			        	 //echo $current['endeKM'].$startWochentag.$start_Datum;
				         //echo "<br>";
				         $daten = $startWochentag.';'.$start_Datum.';'.$current['startKM'].';'.$current['startOrt'].';'.
									        $endeWochentag.';'.$ende_Datum.';'.$current['endeKM'].';'.$current['endeOrt'].';'
									       .$current['ereignis'].';'.$current['bemerkung'];
                 fwrite($datei, $daten."\r\n");   // Daten schreiben, Zeilenumbruch
                }
	     fclose($datei);

       //echo "E-Mail Adresse"." - ".$_SESSION['eMail']."<BR>";
       $empfaenger = $_COOKIE["eMail"];
	     //$empfaenger = 'Markus@Weisenauer.de';
	     //$empfaenger = 'Torsten.Kropp@mhp.com';
       $absender = 'Fahrtenbuch@TimeTec.de';
       $betreff = "TimeTec Fahrtenbuch Backup";
       $text = "Ihr angeforderter csvExport der Fahrtenbuchdaten.\n\n";

	     $datei = "Fahrtenbuch.csv";
	     $typ = "application/vnd.ms-excel";
       //$typ = "text/plain";

       $anhang = fread(fopen($datei, "r"), filesize($datei));
       $anhang = chunk_split(base64_encode($anhang));

	     $boundary = md5(uniqid(time()));

	     $kopf = "MIME-Version: 1.0\n";
       $kopf .= "From: ".$absender."\n";
       $kopf .= "Content-Type: multipart/mixed; boundary=".$boundary."\n\n";
       $kopf .= "This is a multi-part message in MIME format -- Dies ist eine mehrteilige Nachricht im MIME-Format.\n";
	     $kopf .= "--".$boundary."\n";
       $kopf .= "Content-Type: text/plain\n";
       $kopf .= "Content-Transfer-Encoding: 8bit\n\n";
       $kopf .= $text."\n";
	     $kopf .= "--".$boundary."\n";
       $kopf .= "Content-Type: ".$typ."; name=\"".$datei."\"\n";
       $kopf .= "Content-Transfer-Encoding: base64\n";
       $kopf .= "Content-Disposition: attachment; filename=\"".$datei."\"\n\n";
       $kopf .= $anhang."\n";
	     $kopf .= "--".$boundary."--\n";

       if($empfaenger != "") mail($empfaenger, $betreff, $text, $kopf);

  ?>
	 <script language="javascript" type="text/javascript">
    window.alert('csv Export wurde erstellt und Ihnen per E-Mail zugestellt.')
		window.document.location.href = "index2.php";
	 </script>
</body>
</html>
