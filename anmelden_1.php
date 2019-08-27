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

	 <div data-role="content" data-theme="b">
		 
	 <?php
    
   //Globale Variablen
    $_SESSION["fahrtenAnzeige"] = 'letzten30Tage';  
     
	  if ($_POST['Anmelden'] == "Anmelden" && $_POST['Angemeldet'] == "nein")
		    {
			   // Nachsehen, ob es den User überhaupt gibt.
		     // Wenn es den User gibt, diesen dann anmelden
         $m = new MongoClient();
         $db = $m->userFahrtenbuch;	
	       $collection = $db->user;
         $find = array ("eMail" => $_POST['eMail'], "password" => $_POST['password']);
	       $query = $collection->find($find); 
	 
	       foreach ($query as $current)
                  {
                   $_SESSION['eMail'] = $_POST['eMail']; // Variable wir benötigt, um csvExport an die reichtige E-Mail Adresse zu versenden
					         $userExist = 1;
					 
					         // Cookie schreiben
					         setcookie ("eMail", $_POST['eMail'] , time() + 3600);
			             setcookie ("nrSchild", $current['nrSchild'] , time() + 3600);
			             setcookie ("Angemeldet", $_POST['Angemeldet'] , time() + 3600);
			             setcookie ("fahrzeugTyp", $current['fahrzeugTyp'] , time() + 3600);
                   setcookie ("fahrtenAnzeige", "letzten30Tage" , time() + 3600);
					 
					         ?>
			              <script language="javascript" type="text/javascript">
				             window.document.location.href = "index2.php";
	                  </script>
		               <?php
	                }
			
			    if ($userExist <> 1)
					    {
						   echo "<font color=red>Falsche E-Mail oder Passwort angegeben<font color=white>";
						   echo "<br>";
						   $userExist = 0;
					    }
		     }
		 
		 if ($_POST['Anmelden'] == "Anmelden" && $_POST['Angemeldet'] == "ja")
		     {
			    // Nachsehen, ob es den User überhaupt gibt.
		      // Wenn es den User gibt, diesen dann anmelden
          $m = new MongoClient();
          $db = $m->userFahrtenbuch;	
	        $collection = $db->user;
          $find = array ("eMail" => $_POST['eMail'], "password" => $_POST['password']);
	        $query = $collection->find($find); 
	 
	        foreach ($query as $current)
                   {
                    $_SESSION['eMail'] = $_POST['eMail']; // Variable wir benötigt, um csvExport an die reichtige E-Mail Adresse zu versenden
					          $userExist = 1;
					 
			              setcookie ("eMail", $_POST['eMail'] , time() + 2600000); // Für einen Monat angemeldet bleiben
			              setcookie ("nrSchild", $current['nrSchild'] , time() + 2600000);
			              setcookie ("Angemeldet", $_POST['Angemeldet'] , time() + 2600000);
			              setcookie ("fahrzeugTyp", $current['fahrzeugTyp'] , time() + 2600000);
                    setcookie ("fahrtenAnzeige", "letzten30Tage" , time() + 2600000);
			              ?>
			               <script language="javascript" type="text/javascript">
				              window.document.location.href = "index2.php";
	                   </script>
		                <?php
		               }
			 
			    if ($userExist <> 1)
					    {
					    echo "<font color=red>Falsche E-Mail oder Passwort angegeben<font color=white>";
					    echo "<br>";
					    $userExist = 0;
					    }
		     }
	  ?> 
		 
     <form action="#" method="post">
      <table border="0">
       <tr>
         <td colspan="3"><label for="name"><b>Anmelden:</b></label></td>
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">E-Mail</label></td>  
        <td colspan="4"><input type="text" name="eMail" id="eMail" data-clear-btn="true" value="<?php echo $_COOKIE['eMail'] ?>" /></td> 
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Password</label></td>
        <td><input type="text" name="password" id="password" data-clear-btn="true" value=""></td>
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Angemeldet<br>bleiben<br>Ja = 30 Tage</label></td>
        <td>
				 <select name="Angemeldet" id="Angemeldet" data-role="slider">
          <option value="nein">Nein</option>
          <option value="ja">Ja</option>
         </select>
				</td>
       </tr>
       <tr>
       <tr><td colspan="3">&nbsp;</td></tr>
       <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><button id="Anmelden" type="submit" name="Anmelden" value="Anmelden">Anmelden</button></td>
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