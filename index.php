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
</head>

<body>		    
 <div data-role="page" data-theme="b" id="list1">
    <div data-role="header" data-theme="b">
     <h1>Fahrtenbuch</h1>
     <a class="ui-icon-nodisc" href="#left-panel" data-iconpos="notext" data-icon="arrow-r" data-theme="d" data-iconshadow="false" data-shadow="false">Open left panel</a>
     <a class="ui-icon-nodisc" href="#right-panel" data-iconpos="notext" data-icon="arrow-l" data-theme="d" data-iconshadow="false" data-shadow="false">Open right panel</a>
    </div> 
    
	 <?php include ("revealPanel.php"); ?>

	 <div align="center" data-role="content" data-theme="b">
		 
     <form action="anmelden.php" method="post">
      <table border="0">
       <tr>
        <td><button id="Anmelden" type="submit" name="Anmelden" value="Anmelden">Anmelden</button></td>
       </tr>
      </table>
     </form>
		 <img src="img/fahrtenbuch.jpg">
		 <form action="registrieren.php" method="post">
      <table border="0">
       <tr>
        <td><button id="Anmelden" type="submit" name="Anmelden" value="Anmelden">Registrieren</button></td>
       </tr>
      </table>
     </form>
    <!-- </div> -->
	</div> 
  <!-- <div data-role="footer" data-position="fixed" data-theme="b">
    <div data-role="navbar" data-theme="b">
      <ul>
        <li><a href="#seite1" data-transition="slidedown">Seite 1</a></li>
        <li><a href="#seite2" data-transition="slideup">Seite 2</a></li>
      </ul>
    </div>
  </div> -->
 </div>
</body>
</html>