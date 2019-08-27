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
	
	<script>
	$(function(){           
    var step = 1;
    var current = 0;
    var maximum = $(".categories ul li").size();
    var visible = 2;
    var speed = 500;
    var liSize = 120;
    var height = 60;    
    var ulSize = liSize * maximum;
    var divSize = liSize * visible; 

    $('.categories').css("width", "auto").css("height", height+"px").css("visibility", "visible").css("overflow", "hidden").css("position", "relative");
    $(".categories ul li").css("list-style","none").css("display","inline");
    $(".categories ul").css("width", ulSize+"px").css("left", -(current * liSize)).css("position", "absolute").css("white-space","nowrap").css("margin","0px").css("padding","5px");

    $(".categories").swipeleft(function(event){
        if(current + step < 0 || current + step > maximum - visible) {return; }
        else {
            current = current + step;
            $('.categories ul').animate({left: -(liSize * current)}, speed, null);
        }
        return false;
    });

    $(".categories").swiperight(function(){
        if(current - step < 0 || current - step > maximum - visible) {return; }
        else {
            current = current - step;
            $('.categories ul').animate({left: -(liSize * current)}, speed, null);
        }
        return false;
    });         
});
</script>	
	
</head>
	
<body>
	<div data-role="page" id="list">
		<div data-role="header" data-theme="b">
		 <?php
			//Wenn ich abgemeldet bin, weiterleitung auf die 'index.php' seite um die App zu beginnen.
			if ($_COOKIE["eMail"] == 'Abgemeldet')
			    {
				   echo "Funktion Abgemeldet";
				   ?>
			      <script language="javascript" type="text/javascript">
				     window.document.location.href = "index.php";
	          </script>
		       <?php
			    }
			
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
			
			echo "<br>";
			echo "<br>";
			//echo $_SESSION['$dbName'];
			
			if ($_SESSION['$dbName'] == "__")
			    {
				   ?>
			      <script language="javascript" type="text/javascript">
				     window.document.location.href = "index.php";
	          </script>
		       <?php
			    }
			
			?>
      <a class="ui-icon-nodisc" href="#left-panel" data-iconpos="notext" data-icon="arrow-r" data-theme="d" data-iconshadow="false" data-shadow="false">Open left panel</a>
      <a class="ui-icon-nodisc" href="#right-panel" data-iconpos="notext" data-icon="arrow-l" data-theme="d" data-iconshadow="false" data-shadow="false">Open right panel</a>
			
		  <div data-role="navbar">
			 <ul>
			  <li><a href="addTanken.php" data-transition="slidedown">+ Tanken</a></li>
			  <li><a href="tankListe.php" data-transition="slidedown">Tank Liste</a></li>
			  <li><a href="addFahrt.php" data-transition="slideup">+ Fahrt</a></li>
			 </ul>
		  </div>	
    </div>
		 
		<?php include ("revealPanel.php"); ?>
    <br><br>
		<div data-role="header" data-scroll="x">
		 <div class="categories">                
      <ul>                    
       <li><span><a href="">ABC</a></span></li>
       <li><span><a href="">DEF</a></span></li>
       <li><span><a href="">GHI</a></span></li>
       <li><span><a href="">JKL</a></span></li>
			 <li><span><a href="">ABC</a></span></li>
       <li><span><a href="">DEF</a></span></li>
       <li><span><a href="">GHI</a></span></li>
       <li><span><a href="">JKL</a></span></li>
			 <li><span><a href="">ABC</a></span></li>
       <li><span><a href="">DEF</a></span></li>
       <li><span><a href="">GHI</a></span></li>
       <li><span><a href="">JKL</a></span></li>
      </ul>               
     </div>	
		</div>
		
		<div data-role="content" data-theme="b">
			<?php
       // connect to mongodb
       $m = new MongoClient();
       //$db = $m->drive;	
			 $db = $m->$_SESSION['$dbName'];
	     $collection = $db->fahrten;
       $findEreignis = array ("ereignis" => "Fahrt");
	     $query = $collection->find($findEreignis); 
	     //$query = $collection->find($findEreignis).sort(array('endeKM' => -1));
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
				 
				         //ISO Datum ausgeben
				         $current["ISOendeDatum"] = date(DATE_ISO8601, $current["ISOendeDatum"]->sec);
				         $ISO_Jahr  = substr($current["ISOendeDatum"], 0, 4);
	               $ISO_Monat = substr($current["ISOendeDatum"], 5, 2);
	               $ISO_Tag   = substr($current["ISOendeDatum"], 8, 2);
	               $ISO_Uhrzeit = substr($current["ISOendeDatum"], 11, 5);
		             $ISO_Datum = $ISO_Tag.".".$ISO_Monat.".".$ISO_Jahr."&nbsp;&nbsp;".$ISO_Uhrzeit;
				 
				         //Wochentag ausgeben
				         $timestamp = mktime(0,0,0,$ISO_Monat,$ISO_Tag,$ISO_Jahr);
				         $wochentag = date("D",$timestamp);
				 
								 echo   "<tr><td colspan=\"4\"><font size=2>".$wochentag.'&nbsp;&nbsp;'.$ISO_Datum."</td></tr>";
                 echo   "<tr><td width=190>".$current["endeOrt"]."</td><td>&nbsp</td><td id=endeKM".$durchlaufZahl.">".$current["endeKM"]."</td><td>Km</td></tr>";
					       $div = $current["endeKM"] - $current["startKM"];
					       $gesGeschKmDiv = $gesGeschKmDiv + $div;
					       echo  "<tr><td id=".$durchlaufZahl." width=190></td><td>&nbsp</td><td align=right><font color=yellow size=2>".$div."</td><td></td></tr>";
					 
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
					     
				         echo  "<tr><td width=190>".$current["startOrt"]."</td><td>&nbsp</td><td id=startKM".$durchlaufZahl.">".$current["startKM"]."</td><td>Km</td></tr>";
					       
				         //ISO Datum ausgeben
				         $current["ISOstartDatum"] = date(DATE_ISO8601, $current["ISOstartDatum"]->sec);
				         $ISO_Jahr  = substr($current["ISOstartDatum"], 0, 4);
	               $ISO_Monat = substr($current["ISOstartDatum"], 5, 2);
	               $ISO_Tag   = substr($current["ISOstartDatum"], 8, 2);
	               $ISO_Uhrzeit = substr($current["ISOstartDatum"], 11, 5);
		             $ISO_Datum = $ISO_Tag.".".$ISO_Monat.".".$ISO_Jahr."&nbsp &nbsp".$ISO_Uhrzeit;
				 
				         //Wochentag ausgeben
				         $timestamp = mktime(0,0,0,$ISO_Monat,$ISO_Tag,$ISO_Jahr);
				         $wochentag = date("D",$timestamp);
				 
				         echo  "<tr><td colspan=\"4\"><font size=2>".$wochentag.'&nbsp;&nbsp;'.$ISO_Datum."</td></tr>";
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