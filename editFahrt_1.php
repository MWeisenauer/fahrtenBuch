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
 <div data-role="page" id="tankListe" data-theme="b">
	<div data-role="header" data-position="fixed" data-add-back-btn="true">
    <a href="#" data-icon="back" class="ui-btn-left" data-rel="back">Abbruch</a>
    <a href="index2.php" data-icon="home" class="ui-btn-right">Home</a>
    <h1>Edit Fahrt</h1>
  </div><!-- Ende header -->
  
  <div data-role="navbar">
   <ul>
    <li><a href="index2.php" data-transition="slidedown">Fahrten</a></li>
    <li><a href="addFahrt.php" data-transition="slideup">+ Fahrt</a></li>
	  <li><a href="addTanken.php" data-transition="slideup">+ Tanken</a></li>
   </ul>
  </div> 
  
 <div data-role="content" id="content" data-theme="b">	  
	<?php
   // connect to mongodb
   $m = new MongoClient();
   //$db = $m->drive;	
	 $db = $m->$_SESSION['$dbName'];
	 $collection = $db->fahrten;
	 
	 // Fahrt Löschen
	 if ($_POST['action'] == "Delete")
       { 
		    $id = $_POST['id'];
		    $id = new MongoId($id);
		    $collection->remove(array('_id' => $id));
		    ?>
	       <script language="javascript" type="text/javascript">
				  window.document.location.href = "index2.php";
	       </script> 
	      <?php
		   }
	 
	 //Update Fahrt
	 if ($_POST['action'] == "Update")
       {	
		    $ISO_startZeit = $_POST["ISOstartDatum"].$_POST["ISOstartZeit"];
		    $ISO_endeZeit = $_POST["ISOendeDatum"].$_POST["ISOendeZeit"];
				$id = $_POST['id'];
			  $id = new MongoId($id);
			  $collection->update(array('_id' => $id),array('$set'=>array("startOrt" => $_POST['update_startOrt'], 
						                                  									  "startDatum" => $_POST['update_startDatum'],
																														   "ISOstartDatum" => new MongoDate (strtotime(''.$ISO_startZeit.'')),
										                                    						 "startKM" => (int) $_POST['update_startKM'],
                                                                     "endeOrt" => $_POST['update_endeOrt'], 
						                                  									   "endeDatum" => $_POST['update_endeDatum'],
																																"ISOendeDatum" => new MongoDate (strtotime(''.$ISO_endeZeit.'')),
										                                    					    "endeKM" => (int) $_POST['update_endeKM'],
											                                    			   "bemerkung" => $_POST['update_bemerkung']))); 
				$_GET['id'] = $_POST['id']; //Anpassung der Variable, damit das Fahrtformular angezeigt wird 
        echo '<font color="green"><align="center">Update durchgeführt';
			 }
	 
	 $find = array("_id" => new MongoId($_GET[id]));
	 $query = $collection->find($find); 
	 
	 foreach ($query as $current)
	          {
						 echo "<div data-role=fieldcontain>";
						 ?>
						  <form method="post" action="editFahrt_1.php">
						 <?php
						 echo '<table border=0>';
             echo  '<tr><td colspan=3><b>Von:</b></td></tr>';
             echo  '<tr>';
             echo   '<td>&nbsp;</td>';
             echo   '<td>Ort</td>';
             echo   '<td colspan=4><input type=text name=update_startOrt id=update_startOrt value="'.$current['startOrt'].'" /></td>'; 
             echo  '</tr>';
		 
		         $ISO_startDatum = date(DATE_ISO8601, $current["ISOstartDatum"]->sec);
		         $Datum  = substr($ISO_startDatum, 0, 10);
	           $Zeit = substr($ISO_startDatum, 11, 5);

		         echo  '<tr>';
		         echo   '<td>&nbsp;</td>';
             echo   '<td><label for=date>Datum</label></td>';
             echo   '<td><input type=date name=ISOstartDatum id=ISOstartDatum value='.$Datum.'></td>';
       
             echo   '<td>&nbsp;</td>';
             echo   '<td><label for="name">Zeit</label></td>';
             echo   '<td><input type="time" name="ISOstartZeit" id="ISOstartZeit" value="'.$Zeit.'"></td>';
             echo  '</tr>';
		 
             echo     '<tr>';
             echo      '<td>&nbsp;</td>';
             echo      '<td>Km Stand</td>';
             echo      "<td><input type=number name=update_startKM id=update_startKM value=".$current['startKM']." /></td>";
             echo     "</tr>";
             echo     "<tr><td colspan=3><b>Nach:</b></td></tr>";
             echo     '<tr>';
             echo      '<td>&nbsp;</td>';
             echo      '<td>Ort</td>';
             echo      '<td colspan=4><input type=text name=update_endeOrt id=update_endeOrt value="'.$current['endeOrt'].'"></td>'; 
             echo     "</tr>";
		 
		         $ISO_endeDatum = date(DATE_ISO8601, $current["ISOendeDatum"]->sec);
		         $Datum  = substr($ISO_endeDatum, 0, 10);
	           $Zeit = substr($ISO_endeDatum, 11, 5);
		 
		         echo  '<tr>';
		         echo   '<td>&nbsp;</td>';
             echo   '<td><label for=date>Datum</label></td>';
             echo   '<td><input type=date name=ISOendeDatum id=ISOendeDatum value='.$Datum.'></td>';
       
             echo   '<td>&nbsp;</td>';
             echo   '<td><label for="name">Zeit</label></td>';
             echo   '<td><input type="time" name="ISOendeZeit" id="ISOendeZeit" value="'.$Zeit.'"></td>';
             echo  '</tr>'; 
             echo     "<tr>";
             echo      "<td>&nbsp;</td>";
             echo      "<td>Km Stand</td>";
             echo      "<td><input type=number name=update_endeKM id=update_endeKM value=".$current['endeKM']." /></td>";
             echo     "</tr>";
             echo      '<td>&nbsp;</td>';
             echo      '<td>Bemerkung</td>';
		         echo        '<td colspan=4><textarea rows="3" cols="20" wrap="soft" name=update_bemerkung id=update_bemerkung>'.$current['bemerkung'].'</textarea></td>';
             echo     "</tr>";
             echo     "<tr>";
             echo     '<input type=hidden name=updateFahrt value="1">';
						 echo     '<input type=hidden name=id value="'.$_GET['id'].'">';
             echo      '<td colspan=6>';
		         echo       '<button type="submit" name="action" value="Update">Update</button>';
             echo      '</td>';
             echo     '</tr>';
		         echo     '<tr>';
             echo      '<td colspan=2>';
             echo       '<button style="color:red" type=submit name="action" value="Delete">Delete</button>';
             echo       '</td>';
             echo     '</tr>'; 
		         echo    '<form>';
		         echo   '<table>';
						 echo '</div>';
						}
	?>
 </div>
</div>	
</body>
</html>