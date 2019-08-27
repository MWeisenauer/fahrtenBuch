<!-- Start erste Seite -->
<!DOCTYPE html> 
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
 <div data-role="page" id="editFahrt">
  <div data-role="header" data-position="fixed" data-add-back-btn="true">
    <a href="#" data-icon="back" class="ui-btn-left" data-rel="back">Abbruch</a>
    <a href="index2.php" data-icon="home" class="ui-btn-right" rel="external">Home</a>
    <h1>Edit Fahrt</h1>
  </div><!-- Ende header -->
  <div data-role="content">	
    <?php
		 //echo "idFahrt => ".$_GET['idFahrt'];
     echo "<div data-role=fieldcontain>";
     echo   "<form action=index2.php?update_idFahrt=".$_GET['idFahrt']." startOrt=$update_startOrt
		                                                                     &stratDatum=$update_startDatum 
																																				 &stratKM=$update_startKM 
																																				 &endeOrt=$update_endeOrt 
																																				 &endeDatum=$update_endeDatum 
																																				 &endeKM=$update_endeKM method=get data-transition=flip>";
     echo    "<table border=0>";
     echo     "<tr><td colspan=3><b>Von:</b></td></tr>";
     echo     "<tr>";
     echo      "<td>&nbsp;</td>";
     echo      "<td>Ort</td>";
     echo      "<td><input type=text name=update_startOrt id=update_startOrt value=".$_GET['startOrt']." /></td>"; 
     echo     "</tr>";
     echo     "<tr>";
     echo      "<td>&nbsp;</td>";
     echo      "<td>Datum</td>";
     echo      "<td><input type=datetime-local name=update_startDatum id=update_startDatum value=".$_GET['startDatum']." /></td>";
     echo     "</tr>";
     echo     "<tr>";
     echo      "<td>&nbsp;</td>";
     echo      "<td>Km Stand</td>";
     echo      "<td><input type=number name=update_startKM id=update_startKM value=".$_GET['startKM']." /></td>";
     echo     "</tr>";
     echo     "<tr><td colspan=3><b>Nach:</b></td></tr>";
     echo     "<tr>";
     echo      "<td>&nbsp;</td>";
     echo      "<td>Ort</td>";
     echo      "<td><input type=text name=update_endeOrt id=update_endeOrt value=".$_GET['endeOrt']." /></td>"; 
     echo     "</tr>";
     echo     "<tr>";
     echo      "<td>&nbsp;</td>";
     echo      "<td>Datum</td>";
     echo      "<td><input type=datetime-local name=update_endeDatum id=update_endeDatum value=".$_GET['endeDatum']." /></td>";
     echo     "</tr>";
     echo     "<tr>";
     echo      "<td>&nbsp;</td>";
     echo      "<td>Km Stand</td>";
     echo      "<td><input type=number name=update_endeKM id=update_endeKM value=".$_GET['endeKM']." /></td>";
     echo     "</tr>";
		 echo      "<td>&nbsp;</td>";
     echo      "<td>Bemerkung</td>";
     echo      "<td><input type=text name=update_bemerkung id=update_bemerkung value=".$_GET['bemerkung']." /></td>";
     echo     "</tr>";
     echo     "<tr>";
     echo      "<td colspan=3>";
     echo        "<button class=ui-shadow ui-btn ui-corner-all ui-mini id=submit type=submit>Update</button>";
     echo      "</td>";
     echo     "</tr>";
     echo   "</form>";
     //echo "<tr></tr>";
    
     // Formular zum Deleten einer Fahrt
     echo   "<tr>";
     echo    "<td colspan=3>";
     echo     "<form action=index2.php?delFahrt=".$_GET["idFahrt"]." method=post data-transition=flip>"; 
     echo     "<button class=ui-shadow ui-btn ui-corner-all ui-mini id=submit type=submit>Löschen</button>";
     echo    "</td>";
     echo   "</tr>";
     echo   "</form>";
     echo    "</table>";
     // Deleten ende 
    ?>  
    </div>
    
  </div><!-- Ende content -->
  <div data-role="footer" data-position="fixed">
    <div data-role="navbar">
      <ul>
        <li><a href="#seite1" data-transition="slidedown">Seite 1</a></li>
        <li><a href="#seite2" data-transition="slideup">Seite 2</a></li>
      </ul>
    </div><!-- Ende navbar -->
  </div><!-- Ende footer -->
</div><!-- Ende page seite1-->