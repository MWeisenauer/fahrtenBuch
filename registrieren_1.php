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
</head>

<body>		    
 <div data-role="page" data-theme="b" id="list1">
    <div data-role="header" data-theme="b">
     <h1>Fahrtenbuch</h1>
     <a class="ui-icon-nodisc" href="#left-panel" data-iconpos="notext" data-icon="arrow-r" data-theme="d" data-iconshadow="false" data-shadow="false">Open left panel</a>
     <a class="ui-icon-nodisc" href="#right-panel" data-iconpos="notext" data-icon="arrow-l" data-theme="d" data-iconshadow="false" data-shadow="false">Open right panel</a>
    </div> 
    
	 <?php include ("revealPanel.php"); ?>

	 <div data-role="content" data-theme="b">
		 
	 <?php
	  if ($_POST['Registrieren'] == "Registrieren")
		    {			
			   //Anmeldedaten in userFahrtenbuch Datenbank schreiben 
         $m = new MongoClient();
         $db = $m->userFahrtenbuch;
         $collection = $db->user;
			   $document = array( 
				                   'eMail'        => ''.$_POST["eMail"].'',
				                   'nrSchild'     => ''.$_POST["nrSchild"].'',
				                   'fahrzeugTyp'  => ''.$_POST["fahrzeugTyp"].'',
					                 'password'     => ''.$_POST["password"]
				                  );
         $collection->insert($document);
			   ?>
			    <script language="javascript" type="text/javascript">
				   window.document.location.href = "anmelden.php";
	        </script>
		     <?php
		    }
	  ?> 
		 
     <form action="#" method="post">
      <table border="0">
       <tr>
         <td colspan="3"><label for="name"><b>Registrieren:</b></label></td>
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">E-Mail</label></td>  
        <td colspan="4"><input type="text" name="eMail" id="eMail" data-clear-btn="true" value="<?php echo $_COOKIE['eMail'] ?>" /></td> 
       </tr>
			 <tr>
        <td>&nbsp;</td>
        <td><label for="name">Fahrzeug Typ</label></td>
        <td><input type="text" name="fahrzeugTyp" id="fahrzeugTyp" data-clear-btn="true" value="<?php echo $_COOKIE['fahrzeugTyp'] ?>"></td>
       </tr>
			 <tr>
        <td>&nbsp;</td>
        <td><label for="name">Nummernschild</label></td>
        <td><input type="text" name="nrSchild" id="nrSchild" data-clear-btn="true" value="<?php echo $_COOKIE['nrSchild'] ?>"></td>
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Password</label></td>
        <td><input type="text" name="password" id="password" data-clear-btn="true" value=""></td>
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Bemerkung</label></td>  
        <td colspan="4"><textarea name="bemerkung" id="bemerkung"></textarea></td>
       </tr>
       <tr>
       <tr>
        <td colspan="3">&nbsp;</td>
       </tr>
       <tr>
        <td colspan="3"><button id="Registrieren" type="submit" name="Registrieren" value="Registrieren">Registrieren</button></td>
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