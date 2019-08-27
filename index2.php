<!DOCTYPE html>
<?php
 session_start();
?>
<html>

<head>
	<title>Fahrtenbuch</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta http-equiv="pragma" content="no-cache">

	<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
	
<body>
	<div data-role="page" id="fahrtenList" data-theme="b">
		<div data-role="header" data-position="fixed">
      <?php  $anz='Fahrtenliste : '; include ("anzDropDown.php") ?>
      <a class="ui-icon-nodisc" href="#left-panel" data-iconpos="notext" data-icon="arrow-r" data-theme="d" data-iconshadow="false" data-shadow="false">Open left panel</a>
      <a class="ui-icon-nodisc" href="#right-panel" data-iconpos="notext" data-icon="arrow-l" data-theme="d" data-iconshadow="false" data-shadow="false">Open right panel</a>
    </div>   
    <?php include ("revealPanel.php"); ?>
    <div data-role="navbar">
     <ul>
		  <li><a href="addTanken.php" data-transition="slidedown">+ Tanken</a></li>
			<li><a href="tankListe.php" data-transition="slidedown">Tank Liste</a></li>
			<li><a href="addFahrt.php" data-transition="slideup">+ Fahrt</a></li>
		 </ul>
	  </div>	

		<div data-role="content" data-theme="b">
			<?php   
       //$startListe = date("Y-m-d",mktime(0, 0, 0, 1, 1, date("Y"))); // komplette aktuelle Jahr
       //echo $startListe;
      
       $m = new MongoDB\Driver\Manager('mongodb://localhost:27017'); 
       //$filter = new MongoDB\Driver\Query(['ereignis' => 'Fahrt']); //Von der Datenbank wir alles ausgegeben 
       //$filter = array('ereignis' => 'Fahrt', 'startDatum' => array('$gt' => '2017-05-01', '$lt' => '2017-05-30'));
       //$filter = array('ereignis' => 'Fahrt', 'startDatum' => array('$gt' => '2017-05-01', '$lt' => date("Y-m-d",mktime(0, 0, 0, date("m"), date ("d")-30, date("Y")))));
       $filter = array('ereignis' => 'Fahrt', 'startDatum' => array('$lte' => date("Y-m-d",mktime(0, 0, 0, date("m"), date ("d")-10, date("Y")-2)),
                                                                    '$gte' => date("Y-m-d",mktime(0, 0, 0, date("m"), date ("d")-40, date("Y")-2))
                                                                   ));
       $options = array('sort' => array('endeKM' => -1));
       $query = new MongoDB\Driver\Query($filter, $options);
       $rows = $m->executeQuery("fahrtenbuch.Markus_Weisenauer_de_Touareg_V8_TDI_KL-MM_110", $query);
      
       echo "<ul data-role=\"listview\" data-inset=\"true\">";
       $durchlaufZahl = 1;
       foreach ($rows as $current)
                {
                 //echo "$current->_id : $current->startOrt : $current->startDatum : $current->ereignis : $current->endeKM : $current->endeDatum"."<br/>";
			        	 if ($current->endeKM < $startKMvorher) // Privatfahrt anzeigen
					           {
					            $kmDiv = $startKMvorher - $current->endeKM;
					            $gesPrivKmDiv = $gesPrivKmDiv + $kmDiv;
					            echo "<li>";
					            echo  "<table border=\"0\">";
					            echo   "<tr>
							                 <td><font color=green>Privat</td>
							                 <td width=230 align=right><font color=green>".$kmDiv." Km </font></td>
							                </tr>";
					            echo  "</table>";
					            echo "</li>";
					           }
				         echo "<li>";
								 echo "<a href=editFahrt_1.php?id=".$current->_id." data-transition=flip>";
					       echo  "<table border=\"0\">";
				 
				         // Das Feld Bemerkung in der Länge abschneiden
                 $bemerkung = substr($current->bemerkung, 0, 25);
         
                 $startKMvorher = $current->startKM;
         
				         //endeDatum der fahrt in anzeigbares Format umwandeln        
                 $endeDatum =date("D d M Y H.i", mktime(
                                                          substr($current->endeDatum, 11, 2),  //Stunde 
                                                          substr($current->endeDatum, 14, 2),  //Minute
                                                          substr($current->endeDatum, 17, 2),  //Sekunde
                                                          substr($current->endeDatum, 5, 2),   //Tag
                                                          substr($current->endeDatum, 8, 2),   //Monat
                                                          substr($current->endeDatum, 0, 4))); //Jahr
         
                 //startDatum der fahrt in anzeigbares Format umwandeln 
                 $startDatum =date("D d M Y H.i", mktime(
                                                          substr($current->startDatum, 11, 2),  //Stunde 
                                                          substr($current->startDatum, 14, 2),  //Minute
                                                          substr($current->startDatum, 17, 2),  //Sekunde
                                                          substr($current->startDatum, 5, 2),   //Tag
                                                          substr($current->startDatum, 8, 2),   //Monat
                                                          substr($current->startDatum, 0, 4))); //Jahr
         
								 echo   "<tr><td colspan=\"4\"><font size=2>".$endeDatum."</td></tr>";
                 echo   "<tr><td width=190>".$current->endeOrt."</td><td>&nbsp</td><td id=endeKM".$durchlaufZahl.">".$current->endeKM."</td><td>Km</td></tr>";
					       $div = $current->endeKM - $current->startKM;
					       $gesGeschKmDiv = $gesGeschKmDiv + $div;
         
                 echo "<tr>
                        <td colspan=2 id=".$durchlaufZahl." width=190><font color=orange size=2>&nbsp;&nbsp;&nbsp;".$bemerkung." ...</td>
                        <td align=right><font color=yellow size=2>".$div."</td>
                        <td></td>
                       </tr>";
                   
					       echo  "<tr><td width=190>".$current->startOrt."</td><td>&nbsp</td><td id=startKM".$durchlaufZahl.">".$current->startKM."</td><td>Km</td></tr>";
                 echo   "<tr><td colspan=\"4\"><font size=2>".$startDatum."</td></tr>";
                 echo "</table>";
                 echo "</a>";
					       echo "</li>";   
			          }
       echo "</ul>";
	   ?>
		</div>
		<div data-role="footer" data-position="fixed" data-theme="b">
			<div data-role="navbar" data-theme="b">
				<ul>
					<li><a href="ereignisListe.php" data-transition="slidedown">Ereignis<br>Liste</a></li>
					<?php $gesKm = $gesGeschKmDiv + $gesPrivKmDiv ?>
					<li>
					 <?php 
	          echo "<font color=green>".$gesPrivKmDiv." Km";
	          echo "<br>";
	          echo round($gesPrivKmDiv / $gesKm * 100, 2)." % </font>"; 
	         ?>
					</li>
					<li>
					 <?php 
	          echo "<font color=orange>".$gesGeschKmDiv." Km";
	          echo "<br>";
	          echo round($gesGeschKmDiv / $gesKm * 100, 2)." % </font>";
	         ?>
					</li>
					<li>
					 <?php echo $gesKm." Km<br> Ges." ?>
					</li>
				</ul>
			</div>
		</div>
	</div>
</body>

</html>