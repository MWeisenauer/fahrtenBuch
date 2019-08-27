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
    <a href="index2.php" data-icon="home" class="ui-btn-right" rel="external">Home</a>
    <h1>.pdf Export Daten</h1>
  </div><!-- Ende header -->
  
  <?php
   //echo "vonDatum ".$_POST['vonDatum']."<br>";
   //echo "bisDatum ".$_POST['bisDatum']."<br>";
  ?>
  
  <div data-role="content">	 
   <div data-role="fieldcontain">
    <form action="pdfFahrtenbuch.php" method="post" target="_blank">
     <table border="0">
      <tr>
       <td colspan="2"><label for="name"><b>Von:</b></label></td>
      </tr>
		  <tr>
       <td>&nbsp;</td>
       <td><label for="name">Datum</label></td>
       <td><input type="date" name="bisDatum" id="bisDatum" value=""></td>
      </tr>
      <tr>
       <td colspan="2"><label for="name"><b>Bis:</b></label></td>
      </tr>
      <tr>
       <td>&nbsp;</td>
       <td><label for="name">Datum</label></td>
       <td><input type="date" name="vonDatum" id="vonDatum" value=""></td>
      </tr>
      <tr>
      <tr><td colspan="6">&nbsp;</td></tr>
      <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td><button class="ui-shadow ui-btn ui-corner-all ui-mini" id="submit" type="submit">.pdf Erzeugen</button></td>
      </tr>
     </table>
    </form>
   </div> 
  </div><!-- Ende content -->
  <!--
  <div data-role="footer" data-position="fixed">
   <div data-role="navbar">
    <ul>
     <li><a href="#seite1" data-transition="slidedown">Seite 1</a></li>
     <li><a href="#seite2" data-transition="slideup">Seite 2</a></li>
    </ul>
   </div>
  </div>
  -->
</div>
</body>
</html>