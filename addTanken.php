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
	 
 </head>
 <body>

<div data-role="page" id="addFahrt" data-theme="b">
  <div data-role="header" data-position="fixed" data-add-back-btn="true">
    <a href="#" data-icon="back" class="ui-btn-left" data-rel="back">Abbruch</a>
    <a href="index2.php" data-icon="home" class="ui-btn-right">Home</a>
    <h1>Tanken hinzufügen</h1>
  </div><!-- Ende header -->
  <div data-role="content">	 
    <?php
		 //dbNamen Ausgeben
		 //echo "dbName - ";
		 $dbName = $_SESSION['$dbName'];
		 //echo "$dbName";
		
	   // Tanken speichern
     if ($_POST['endeOrt'] <> "")
      {
			 $zeit = $_POST["endeDatum"].$_POST["endeZeit"];
			 
       $m = new MongoClient();
       //$db = $m->drive;
			 $db = $m->$_SESSION['$dbName'];
       $collection = $db->fahrten;
			 $document = array( 
				                 'endeOrt'     => ''.$_POST["endeOrt"].'',
				                 'endeDatum'   => new MongoDate (strtotime(''.$zeit.'')),
				                 'endeKM'      => (int) $_POST["endeKM"],
				                 'startKM'     => (int) $_POST["endeKM"],
				                 'Liter'       => (double) $_POST["Liter"],
				                 'literPreis'  => (double) $_POST["literPreis"],
				                 'ereignis'    => 'Tanken'
				                 );
       $collection->insert($document);
      }
    ?>		
    <div data-role="fieldcontain">
     <form action="#" method="post">
      <table border="0">
       <tr>
         <td colspan="2"><label for="name"><b>Tanken:</b></label></td>
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Ort</label></td>  
        <td colspan="4"><input type="text" name="endeOrt" id="endeOrt" value="" /></td>
       </tr>
			 <tr>
        <td>&nbsp;</td>
        <td><label for="name">Datum</label></td>
        <td><input type="date" name="endeDatum" id="endeDatum" value=""></td>
        <td>&nbsp;</td>
        <td><label for="name">Zeit</label></td>
        <td><input type="time" name="endeZeit" id="endeZeit" value=""></td>
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Km Stand</label></td>
        <td><input type="number" name="endeKM" id="endeKM" pattern="[0-9]*" data-clear-btn="true" value=""></td>
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Liter</label></td>
        <td><input type="text" name="Liter" id="Liter" data-clear-btn="true" value=""></td>
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Preis / Liter</label></td>
        <td><input type="text" name="literPreis" id="literPreis" data-clear-btn="true" value=""></td>
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Bemerkung</label></td>  
        <td colspan="4"><textarea name="bemerkung" id="bemerkung"></textarea></td>
       </tr>
       <tr>
       <tr><td colspan="6">&nbsp;</td></tr>
       <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><button class="ui-shadow ui-btn ui-corner-all ui-mini" id="submit" type="submit">Speichern</button></td>
       </tr>
      </table>
     </form>
    </div>
    
  </div><!-- Ende content -->
  <!-- <div data-role="footer" data-position="fixed">
    <div data-role="navbar">
      <ul>
        <li><a href="#seite1" data-transition="slidedown">Seite 1</a></li>
        <li><a href="#seite2" data-transition="slideup">Seite 2</a></li>
      </ul>
    </div><!-- Ende navbar -->
  </div><!-- Ende footer -->
</div><!-- Ende page seite1-->
</body>
</html>