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
    <h1>Fahrt hinzufügen</h1>
  </div>   
 <script type="text/javascript">
  function showPositionVon(position) 
           { 
            var latitude  = position.coords.latitude;
            var longitude = position.coords.longitude;
            $.ajax({
                    url: `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=AIzaSyBOnxMAxs2qzFlZF87Q-5hRO3ha8zLUHoo`, dataType: 'json'
                   }).done(function(result) 
                           {
                            var fAdress = result.results[0].formatted_address;
                            var r = confirm('Soll folgende Adresse als Start Ort übernommen werden ?\n \n' + fAdress);
                            if (r == true)
                                {
                                 document.getElementById("vonNach").startOrt.value = fAdress;
                                };
                           });
           }
    
  function getLocationVon() 
           {
            if (navigator.geolocation) 
                {
                 navigator.geolocation.getCurrentPosition(showPositionVon);
                } 
             else 
                { 
                 x.innerHTML = "Geolocation is not supported by this browser.";      
                }
           }
   
  function showPositionNach(position) 
           { 
            var latitude  = position.coords.latitude;
            var longitude = position.coords.longitude;
            $.ajax({
                    url: `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=AIzaSyBOnxMAxs2qzFlZF87Q-5hRO3ha8zLUHoo`, dataType: 'json'
                   }).done(function(result) 
                           {
                            var fAdress = result.results[0].formatted_address;
                            var r = confirm('Soll folgende Adresse als Ende Ort übernommen werden ?\n \n' + fAdress);
                            if (r == true)
                                {
                                 document.getElementById("vonNach").endeOrt.value = fAdress;
                                };
                           });
           }
    
  function getLocationNach() 
           {
            if (navigator.geolocation) 
                {
                 navigator.geolocation.getCurrentPosition(showPositionNach);
                } 
             else 
                { 
                 x.innerHTML = "Geolocation is not supported by this browser.";      
                }
           } 
 </script>
   
  <div data-role="content">	 
    
    <?php
     /*
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
           ?>
           <script type="text/javascript">
            window.document.location.href = "index2.php";
           </script>
           <?php
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
		
    $datum = date("d.m.Y");
    $uhrzeit = date("H:i");
   */
    ?>		
    <div data-role="fieldcontain">
     <form id="vonNach" action="#" method="post">
      <table border="0">
       <tr>
         <td colspan="2"><button type="button" onclick="getLocationVon()">GPS Von</button></td>
       </tr>
       <tr>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td><label for="name">Ort</label></td>  
        <td colspan="4"><input type="text" name="startOrt" id="startOrt" data-clear-btn="true" value="<?php echo $letzteEndeOrt ?>"></td>
       </tr>
			 <tr>
		    <td>&nbsp;</td>
        <td><label for=date>Datum</label></td>
        <td><input type="date" name="ISOstartDatum" id="ISOstartDatum" value="<?= date("Y-m-d", time()) ?>"</input></td>
        <td>&nbsp;</td>
        <td><label for="name">Zeit</label></td>
        <td><input type="time" name="ISOstartZeit" id="ISOstartZeit" value="<?php echo $uhrzeit ?>"</input></td>
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Km Stand</label></td>
        <td><input type="number" name="startKM" id="startKM" pattern="[0-9]*" data-clear-btn="true" value="<?php echo $letzteEndeKM ?>"></td>
       </tr>
       <tr>
         <td colspan="2"><button type="button" onclick="getLocationNach()">GPS Nach</button></td>
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Ort</label></td>  
        <td colspan="4"><input type="text" name="endeOrt" id="endeOrt" data-clear-btn="true" style="color:red" value="Zielort" /></td>
       </tr>				
			 <tr>
		    <td>&nbsp;</td>
        <td><label for=date>Datum</label></td>
        <td><input type=date name=ISOendeDatum id=ISOendeDatum style="color:red" value="<?= date("Y-m-d", time()) ?>"</input></td>
        <td>&nbsp;</td>
        <td><label for="name">Zeit</label></td>
        <td><input type="time" name="ISOendeZeit" id="ISOendeZeit" style="color:red" value="<?php echo $uhrzeit ?>"</input></td>
       </tr>	
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Km Stand</label></td>
        <td><input type="number" name="endeKM" id="endeKM" pattern="[0-9]*" data-clear-btn="true" style="color:red" value="<?php echo $letzteEndeKM+1 ?>"></td>
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
  </div>
 </div>   
</body>
</html>