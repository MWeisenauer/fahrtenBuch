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
	<div data-role="header" data-position="fixed" data-add-back-btn="true">
    <a href="#" data-icon="back" class="ui-btn-left" data-rel="back">Abbruch</a>
    <a href="index2.php" data-icon="home" class="ui-btn-right">Home</a>
    <h1>Edit Tanken</h1>
  </div><!-- Ende header -->
  
  <div data-role="navbar">
   <ul>
    <li><a href="index2.php" data-transition="slidedown">Fahrten</a></li>
    <li><a href="addFahrt.php" data-transition="slideup">+ Fahrt</a></li>
	  <li><a href="addTanken.php" data-transition="slideup">+ Tanken</a></li>
   </ul>
  </div> 
  
 <div data-role="content" id="content">	  
	<?php
   // connect to mongodb
   $m = new MongoClient();
   //$db = $m->drive;	
	 $db = $m->$_SESSION['$dbName'];
	 $collection = $db->fahrten;
	 
	 //Delete Tanken
	 if ($_POST['action'] == "Delete")
	     {
		    $id = $_POST['id'];
		    $id = new MongoId($id);
		    $collection->remove(array('_id' => $id));
		    ?>
	       <script language="javascript" type="text/javascript">
				  window.document.location.href = "tankListe.php";
	       </script> 
	      <?php
	     }
	 
	 //Update Tanken
	 if ($_POST['action'] == "Update")
       { 
		    $zeit = $_POST["endeDatum"].$_POST["endeZeit"];
				$id = $_POST['id'];
			  $id = new MongoId($id);
			  $collection->update(array('_id' => $id),array('$set'=>array("endeOrt"  => $_POST['update_endeOrt'], 
						                                  									  "endeDatum"  => new MongoDate (strtotime(''.$zeit.'')),
										                                    						 "endeKM"  => (int) $_POST['update_endeKM'],
																																		 "startKM" => (int) $_POST['update_endeKM'],
										                                    							"Liter"  => (double) $_POST['update_Liter'],
										                                  					 "literPreis"  => (double) $_POST['update_literPreis'],
											                                    			  "bemerkung"  => $_POST['update_bemerkung']))); 
				$_GET['id'] = $_POST['id']; //Anpassung der Variable, damit das Tankformular angezeigt wird 
				echo '<font color="green"><align="center">Update durchgeführt';
			 }
	 
	 $find = array("_id" => new MongoId($_GET[id]));
	 $query = $collection->find($find); 
	 
	 foreach ($query as $current)
	          {
						 echo "<div data-role=fieldcontain>";
						 ?>
						  <form method="post" action="editTanken.php">
						 <?php
						 echo  '<table border=0>';
             echo    '<tr><td colspan=2><b>Edit Tanken:</b></td></tr>';
             echo    '<tr>';
             echo     '<td>Tankstelle</td>';
             echo     '<td colspan=4><input type=text name=update_endeOrt id=update_endeOrt value="'.$current['endeOrt'].'"></td>'; 
             echo    '</tr>';
		         
		         //Datum ausgeben
						 $currentISOdate = date(DATE_ISO8601, $current["endeDatum"]->sec);
				     $Jahr  =   substr($currentISOdate, 0, 4);
	           $Monat =   substr($currentISOdate, 5, 2);
	           $Tag   =   substr($currentISOdate, 8, 2);
	           $Uhrzeit = substr($currentISOdate, 11, 5);
		         $Datum = $Tag.".".$Monat.".".$Jahr;
		 
		         echo  '<tr>';
             echo   '<td><label for=date>DatumISO</label></td>';
             echo   '<td><input type=datetime name=endeDatum id=endeDatum value='.$Datum.'></td>';
       
             echo   '<td>&nbsp;</td>';
             echo   '<td><label for="name">Zeit</label></td>';
             echo   '<td><input type="time" name="endeZeit" id="endeZeit" value="'.$Uhrzeit.'"></td>';
             echo  '</tr>';
		 
             echo    '<tr>';
             echo     '<td>Km Stand</td>';
             echo     '<td><input type=number name=update_endeKM id=update_endeKM value="'.$current['endeKM'].'"></td>';
             echo    '</tr>';
						 echo 	 '<tr>';
             echo      '<td>Liter</td>';
             echo      '<td><input type=text name=update_Liter id=update_Liter value="'.$current['Liter'].'"></td>'; 
						 echo    '</tr>';
             echo    '<tr>';
             echo     '<td>EUR / Liter</td>';
             echo     '<td><input type=text name=update_literPreis id=update_literPreis value="'.$current['literPreis'].'"></td>';
             echo    '</tr>';
             echo    '<tr>';
             echo     '<td>Bemerkung</td>';
             echo     '<td colspan="4"><input type=text name=update_bemerkung id=update_bemerkung value="'.$current['bemerkung'].'" /></td>';
             echo    '</tr>';
             echo    '<tr>';
						 echo    '<input type=hidden name=id value="'.$_GET['id'].'">';
             echo     '<td colspan=2>';
		         echo      '<button type="submit" name="action" value="Update">Update</button>';
		         echo     '</td>';
		         echo    '</tr>';
		         echo    '<tr>';
		         echo     '<td>';
		         echo      '<button style="color:red" type="submit" name="action" value="Delete">Delete</button>';
             echo     '</td>';
             echo    '</tr>';
						 echo   '</table>';
						 echo  '</form>';
						 echo '</div>';
						}
	?>
 </div>
</div>	
</body>
</html>