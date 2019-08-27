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

	<div data-role="page" id="list" data-theme="b">
		<div data-role="header" data-position="fixed">
			<h1>Willkommen</h1>
		</div>
		<div data-role="content">
			<!-- <a href="addFahrt.php" data-role="button" data-transition="flip">Fahrt hinzufügen</a> -->
			<?php
       // connect to mongodb
       $m = new MongoClient();
       //$db = $m->drive;	
			 $db = $m->$_SESSION['$dbName'];
			 $collection = $db->fahrten;
			
			
     //startOrte finden
     //$findOrte = array ("startOrt" => "Queidersbach");
	   $query = $collection->find(); 
	   $query->sort(array('endeKM' => -1));
       echo "<ul data-role=\"listview\" data-inset=\"true\">";
        foreach ($query as $current)
                 {
				  if ($current['endeKM'] < $startKMvorher)
					    {
					     // Private KM anzeigen
					     $kmDiv = $startKMvorher -$current['endeKM'];
					     echo "<li>";
					     echo  "<table border=\"0\">";
					     echo   "<tr>
							          <td width=200><font color=green>Priv."."</td><td><font color=green>".$kmDiv." Km </font></td>
							         </tr>";
					     echo  "</table>";  
						   echo "</li>";
					    }
				      echo "<li>";
              echo "<table border=\"0\">";
				      if ($current["ereignis"] == "Fahrt")
                  {
                   echo  "<tr>
                           <td width=200>".$current["endeOrt"]."</td><td>".$current["endeKM"]." Km</td>
                          </tr>";
			             $fahrtVorher = "";
                  }
           
              if ($current["ereignis"] == "Tanken")
                  {
                   echo  "<tr>
                           <td width=200><font color=orange>".$current["endeOrt"]."</td><td>".$current["endeKM"]." Km</td>
                          </tr>";
                  } 
			        echo "</table>";
			        echo "</li>";
              if ($current["ereignis"] == "Fahrt")
                  {
			             $startKMvorher = $current['startKM'];
			             $startDatumVorher = $current['startDatum'];
                  }
		         }
       echo "</ul>";
	    ?>
		</div>
		<div data-role="footer" data-position="fixed">
    <div data-role="navbar">
      <ul>
        <li><a href="index2.php" data-transition="slidedown">Fahrten Liste</a></li>
        <li><a href="#" data-transition="slideup">?</a></li>
      </ul>
    </div>
  </div>
</body>

</html>