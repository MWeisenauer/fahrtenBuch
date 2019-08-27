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
	
	<!-- 
   <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
   <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
   <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
  -->
</head>
<body>

<div data-role="page" id="tankListe" data-theme="b">
 <div data-role="header" data-position="fixed">
  <?php  $anz='Tankliste : '; include ("anzDropDown.php") ?>
  <a class="ui-icon-nodisc" href="#left-panel" data-iconpos="notext" data-icon="arrow-r" data-theme="d" data-iconshadow="false" data-shadow="false">Open left panel</a>
  <a class="ui-icon-nodisc" href="#right-panel" data-iconpos="notext" data-icon="arrow-l" data-theme="d" data-iconshadow="false" data-shadow="false">Open right panel</a>
 </div>
 <?php include ("revealPanel.php"); ?> 
 <div data-role="navbar">
  <ul>
   <li><a href="index2.php" data-transition="slidedown">Fahrten</a></li>
   <li><a href="addFahrt.php" data-transition="slideup">+ Fahrt</a></li>
	 <li><a href="addTanken.php" data-transition="slideup">+ Tanken</a></li>
  </ul>
 </div>	
	
 <div data-role="content" id="content">	  
	<?php

   if ( isset ( $_POST["fahrtenAnzeige"] ) )
        {
         $_SESSION["fahrtenAnzeige"] = $_POST["fahrtenAnzeige"];
        }
   
   if ($_SESSION["fahrtenAnzeige"] == "letzten30Tage")
       { 
        $startListe = date("d.m.Y",mktime(0, 0, 0, date("m"), date ("d")-30, date("Y"))); // letzten30Tage
        $listBeginn = new MongoDate (strtotime ("$startListe"));
        $find = array ('endeDatum' => array( '$gte' => $listBeginn), "ereignis" => "Tanken");
       }
   
   if ($_SESSION["fahrtenAnzeige"] == "Monatsanfang")
       { 
        $startListe = date('d.m.Y',mktime(0, 0 ,0 ,date("m") ,1 ,date("Y"))); // Monatsanfang - aktueller Monat
        $listBeginn = new MongoDate (strtotime ("$startListe"));
        $find = array ('endeDatum' => array( '$gte' => $listBeginn), "ereignis" => "Tanken");
       }
   
   if ($_SESSION["fahrtenAnzeige"] == "Vormonat")
       { 
        $startListe = date("d.m.Y",mktime(0, 0, 0, date("m")-1, 1, date("Y"))); //beginnend mit vorigem Monat
        $listBeginn = new MongoDate (strtotime ("$startListe"));
        $find = array ('endeDatum' => array( '$gte' => $listBeginn), "ereignis" => "Tanken");
       }
   
   if ($_SESSION["fahrtenAnzeige"] == "Jahr")
       { 
        $startListe = date("d.m.Y",mktime(0, 0, 0, 1, 1, date("Y"))); // komplette aktuelle Jahr
        $listBeginn = new MongoDate (strtotime ("$startListe"));
        $find = array ('endeDatum' => array( '$gte' => $listBeginn), "ereignis" => "Tanken");
       }
   
   if ($_SESSION["fahrtenAnzeige"] == "alleFahrten")
       { 
        $find = array ("ereignis" => "Tanken"); 
       }
  
   // connect to mongodb
   $m = new MongoClient();	
	 $db = $m->$_SESSION['$dbName'];
	 $collection = $db->fahrten;
			
   //Tankdaten finden
	 $query = $collection->find($find); 
	 $query->sort(array('endeKM' => -1));
	 
   echo "<ul data-role=\"listview\" data-inset=\"true\">";
	 $durchlauf = 1;
	 foreach ($query as $current)
            {
		         //Datum ausgeben
		         $current["endeDatum"] = date(DATE_ISO8601, $current["endeDatum"]->sec);
	           $Jahr  = substr($current["endeDatum"], 0, 4);
	           $Monat = substr($current["endeDatum"], 5, 2);
	           $Tag   = substr($current["endeDatum"], 8, 2);
	           $Uhrzeit = substr($current["endeDatum"], 11, 5);
		         $Datum = $Tag.".".$Monat.".".$Jahr."&nbsp &nbsp".$Uhrzeit;
		 
			       echo "<li>";
	  	       echo "<a href=editTanken.php?id=".$current["_id"]." data-transition=flip>";
             echo "<table border=\"0\">";        
             echo  "<tr> 
						         <td colspan=3 width=200>".$Datum."</td>
                    </tr>
								    <tr>
                     <td colspan=2 width=200><font color=orange>".$current["endeOrt"]."</td><td>".$current["endeKM"]." Km</td>
                    </tr>
                    <tr>
                     <td>".$current["Liter"]." L</td><td> ".$current["literPreis"]." €/L</td><td>".round($current["Liter"] * $current["literPreis"],2)." €</td>
                    </tr>";
		         echo "</table>";
		         echo "</a>";
			       echo "</li>";
						 echo "<li>";
						 $div = $kmTankenVorher -$current["endeKM"];
						 echo "<table border=\"0\">";
						 echo  "<tr>";
						 echo   "<td id=".$durchlauf.">Bitte Seite 'refreshen'</td>";
						 echo  "</tr>";
						 echo "</table>";
						 echo "</li>";
						 $durchVerbrauch = round($literVorher / $div * 100,2);
						 if ($durchlauf > 1)
						     {
									?>
			             <script type='text/javascript'>
							      var idLauf = <?php echo $durchlauf - 1?>;
							      document.getElementById(idLauf).innerHTML = '<font color="green">Div. <b><?php echo $div ?></b> Km - Verbr. <b><?php echo $durchVerbrauch ?></b> l/100 Km</font>';
			             </script>
			            <?php
								 }			 
							$kmTankenVorher = $current["endeKM"];
							$literVorher = $current["Liter"];
							$durchlauf = $durchlauf + 1;
          
              //Berechnungen für Footer
              $gesLiter = $gesLiter + $current["Liter"];
              $gesPreis = $gesPreis + round($current["Liter"] * $current["literPreis"],2);
		        }
       echo "</ul>";
	?> 
 </div>
 <div data-role="footer" data-position="fixed" data-theme="b">
			<div data-role="navbar" data-theme="b">
				<ul>
					<li>
					 <?php 
	          echo "<font color=green><center>ges. Liter";
	          echo "<br>";
	          echo $gesLiter."</center></font>"; 
	         ?>
					</li>
          <li>
					 <?php 
	          echo "<font color=orange><center>ges. Preis";
	          echo "<br>";
	          echo $gesPreis."</center></font>"; 
	         ?>
					</li>
				</ul>
			</div>
		</div>
</div>	
</body>
</html>