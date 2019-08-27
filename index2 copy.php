<!DOCTYPE html>
<html>

<head>
	<title>Fahrtenbuch</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta http-equiv="pragma" content="no-cache">

	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	

	<!-- 
  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
  <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
  <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
  -->

</head>

<body>

	<div data-role="page" id="list">
		<div data-role="header" data-position="fixed">
			<h1>Willkommen</h1>
		</div>
		
		<div data-role="navbar">
      <ul>
        <li><a href="addTanken.php" data-transition="slidedown">+ Tanken</a></li>
        <li><a href="tankListe.php" data-transition="slidedown">Tank Liste</a></li>
        <li><a href="addFahrt.php" data-transition="slideup">+ Fahrt</a></li>
      </ul>
    </div>
		
		<div data-role="content">
		 <!-- <a href="addTanken.php" data-role="button" data-transition="flip">Tanken hinzufügen</a>
		 <a href="addFahrt.php" data-role="button" data-transition="flip">Fahrt hinzufügen</a> -->
			<?php
       // connect to mongodb
       $m = new MongoClient();
       $db = $m->drive;	
	     $collection = $db->fahrten;
       $findEreignis = array ("ereignis" => "Fahrt");
	     $query = $collection->find($findEreignis); 
	     $query->sort(array('endeKM' => -1));
       echo "<ul data-role=\"listview\" data-inset=\"true\">";
       $durchlaufZahl = 1;
       foreach ($query as $current)
                {
			        	 if ($current['endeKM'] < $startKMvorher)
					           {
					            // Privat anzeigen
					            $kmDiv = $startKMvorher -$current['endeKM'];
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
				         $x = $x + 1;
				         echo "<li>";
								 echo "<a href=editFahrt_1.php?id=".$current["_id"]." data-transition=flip>";
					       echo  "<table border=\"0\">";
				 
				         //Datum ausgeben
				         $Jahr  = substr($current["endeDatum"], 0, 4);
	               $Monat = substr($current["endeDatum"], 5, 2);
	               $Tag   = substr($current["endeDatum"], 8, 2);
	               $Uhrzeit = substr($current["endeDatum"], 11, 5);
		             $Datum = $Tag.".".$Monat.".".$Jahr."&nbsp &nbsp".$Uhrzeit;
				 
								 echo   "<tr><td colspan=\"4\"><font size=2>".$Datum."</td></tr>";
                 echo   "<tr><td width=190>".$current["endeOrt"]."</td><td>&nbsp</td><td id=endeKM".$durchlaufZahl.">".$current["endeKM"]."</td><td>Km</td></tr>";
					       $div = $current["endeKM"] - $current["startKM"];
					       $gesGeschKmDiv = $gesGeschKmDiv + $div;
					       echo  "<tr><td id=".$durchlaufZahl." width=190></td><td>&nbsp</td><td align=right><font color=blue size=2>".$div."</td><td></td></tr>";
					 
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
                             document.getElementById('startKM'+idZahl).innerHTML = '<font color="red"><?php echo $startKMvorher ?></font>';
                             document.getElementById(idZahlCurrent).innerHTML = '<font color="orange">Ende KM</font><font color="black"> nach </font><font color="red">Start KM</font>';
                             document.getElementById('endeKM'+idZahlCurrent).innerHTML = '<font color="orange"><?php echo $current['endeKM'] ?></font>';
                            </script>    
					                 <?php
					                }
					           }          
					     
				         echo  "<tr><td width=190>".$current["startOrt"]."</td><td>&nbsp</td><td id=startKM".$durchlaufZahl.">".$current["startKM"]."</td><td>Km</td></tr>";
					       
				         //Datum ausgeben
								 $Jahr  = substr($current["startDatum"], 0, 4);
	               $Monat = substr($current["startDatum"], 5, 2);
	               $Tag   = substr($current["startDatum"], 8, 2);
	               $Uhrzeit = substr($current["startDatum"], 11, 5);
		             $Datum = $Tag.".".$Monat.".".$Jahr."&nbsp &nbsp".$Uhrzeit;
				 
				         echo  "<tr><td colspan=\"4\"><font size=2>".$Datum."</td></tr>";
				         echo "</table>";
					       echo "</a>";
				         echo "</li>";
				         $endeKMvorher = $current['endeKM'];
					       $startKMvorher = $current['startKM'];
					       $startDatumVorher = $current['startDatum'];
					       $durchlaufZahl = $durchlaufZahl + 1;
			          }
       echo "</ul>";
	   ?>
		</div>
		<div data-role="footer" data-position="fixed">
     <div data-role="navbar">
      <ul>
       <li><a href="ereignisListe.php" data-transition="slidedown">Ereignis<br>Liste</a></li>
           <?php $gesKm = $gesGeschKmDiv + $gesPrivKmDiv ?>
       <li><?php 
	           echo "<font color=green>".$gesPrivKmDiv." Km";
	           echo "<br>";
	           echo round($gesPrivKmDiv / $gesKm * 100, 2)." % </font>"; 
	         ?>
	     </li>
       <li><?php 
	           echo "<font color=blue>".$gesGeschKmDiv." Km";
	           echo "<br>";
	           echo round($gesGeschKmDiv / $gesKm * 100, 2)." % </font>";
	          ?>
			</li>
       <li><?php echo $gesKm." Km<br> Ges." ?></li>
      </ul>
     </div>
    </div>
	</div>
</body>

</html>