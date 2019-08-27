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
	  
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
  <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>   
	 
 </head>
 <body>

<div data-role="page" id="addFahrt" data-theme="b">
  <div data-role="header" data-position="fixed" data-add-back-btn="true">
    <a href="#" data-icon="back" class="ui-btn-left" data-rel="back">Abbruch</a>
    <a href="index2.php" data-icon="home" class="ui-btn-right">Home</a>
    <h1>Fahrt hinzufügen</h1>
  </div><!-- Ende header -->
  <div data-role="content">	 
    <?php
		 // connect to mongodb
      $m = new MongoClient();
      //$db = $m->drive;	
		  $db = $m->$_SESSION['$dbName'];
	    $collection = $db->fahrten;
		
		  // neuen Fahrt abspeichern
      if ($_POST['startOrt'] <> "")
          {
			     $ISO_startZeit = $_POST["ISOstartDatum"].$_POST["ISOstartZeit"];
		       $ISO_endeZeit = $_POST["ISOendeDatum"].$_POST["ISOendeZeit"];
           $m = new MongoClient();
           //$db = $m->drive;
				   $db = $m->$_SESSION['$dbName'];
           $collection = $db->fahrten;
           $document = array('startOrt' => ''.$_POST["startOrt"].'', 
				                'ISOstartDatum' => new MongoDate (strtotime(''.$ISO_startZeit.'')),
				                  'startKM'     => (int) $_POST["startKM"],
			                    'endeOrt'     => ''.$_POST["endeOrt"].'', 
				                 'ISOendeDatum' => new MongoDate (strtotime(''.$ISO_endeZeit.'')),
	                        'endeKM'      => (int) $_POST['endeKM'],
		                      'bemerkung'   => ''.$_POST["bemerkung"].'',
		                      'ereignis'    => 'Fahrt'
                            ); 
           $collection->insert($document);
          }
		
		  // letzte Fahrten auflisten
      $findEreignis = array ("ereignis" => "Fahrt");
	    $query = $collection->find($findEreignis); 		  
	    $query->sort(array('endeKM' => 1));
		  foreach ($query as $current)
               {
				        $letzteEndeOrt = $current['endeOrt'];
				        $letzteEndeKM  = $current['endeKM'];
			         }
		
		//Das heutige Datum berechnen und in Form z.B. 05.02.2018 an das 'value' ausliefern und anzeigen.
		$timestamp = time();
    $Datum = date("d.m.Y", $timestamp);
		$Zeit = date("H:i", $timestamp);
		
    ?>		
    <div data-role="fieldcontain">
     <form action="#" method="post">
      <table border="0">
       <tr>
        <td colspan="4"><label for="name"><b>Von:</b></label></td>
       </tr>
       <tr>
       <td>&nbsp;&nbsp;&nbsp;</td>
       <td><label for="name">Ort</label></td>  
       <td colspan="4"><input type="text" name="startOrt" id="startOrt" data-clear-btn="true" value="<?php echo $letzteEndeOrt ?>"></td>
       </tr>
			 <tr>
		    <td>&nbsp;</td>
        <td><label for=date>Datum</label></td>
        <td><input type=date name=ISOstartDatum id=ISOstartDatum data-clear-btn="true" value="<?php echo $Datum ?>"</input></td>
        <td>&nbsp;</td>
        <td><label for="name">Zeit</label></td>
        <td><input type="time" name="ISOstartZeit" id="ISOstartZeit" data-clear-btn="true" value="<?php echo $Zeit ?>"</input></td>
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Km Stand</label></td>
        <td><input type="number" name="startKM" id="startKM" pattern="[0-9]*" data-clear-btn="true" value="<?php echo $letzteEndeKM ?>"></td>
       </tr>
       <tr>
         <td colspan="3"><label for="name"><b>Nach:</b></label></td>
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Ort</label></td>  
        <td colspan="4"><input type="text" name="endeOrt" id="endeOrt" data-clear-btn="true" value="" /></td>
       </tr>				
			 <tr>
		    <td>&nbsp;</td>
        <td><label for=date>Datum</label></td>
        <td><input type=date name=ISOendeDatum id=ISOendeDatum data-clear-btn="true" value="<?php echo $Datum ?>"</input></td>
        <td>&nbsp;</td>
        <td><label for="name">Zeit</label></td>
        <td><input type="time" name="ISOendeZeit" id="ISOendeZeit" data-clear-btn="true" value="<?php echo $Zeit ?>"</input></td>
       </tr>	
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Km Stand</label></td>
        <td><input type="number" name="endeKM" id="endeKM" pattern="[0-9]*" data-clear-btn="true" value=""></td>
       </tr>
       <tr><td>&nbsp;</td></tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Bemerkung</label></td>  
        <td colspan="4"><textarea rows="3" name="bemerkung" id="bemerkung"></textarea></td>
       </tr>
       <tr>
       <tr><td>&nbsp;</td></tr>
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