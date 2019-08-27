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
	  if (isset($_POST['Registrieren'])
          and $_POST['Anrede'] <> ""
          and $_POST['Vorname'] <> ""
          and $_POST['Nachname'] <> ""
          and $_POST['Strasse'] <> ""
          and $_POST['PLZ'] <> ""
          and $_POST['Ort'] <> ""
	        and $_POST['eMail'] <> ""
	        and $_POST['nrSchild'] <> ""
	        and $_POST['AutoType'] <> ""
	        and $_POST['password'] <> "")
		    {		
         //Anmeldedaten in MySQL Datenbank schreiben
         $conn = new mysqli('localhost', 'MWeisenauer', '!Adenauer1!', 'Fahrtenbuch');
         $sql = "INSERT INTO user (FirmenBez, Anrede, Vorname, Nachname, Strasse, PLZ, Ort,
                                   eMail, nrSchild, AutoType, Password)
                           VALUES ('$_POST[FirmenBez]', '$_POST[Anrede]', '$_POST[Vorname]', '$_POST[Nachname]', '$_POST[Strasse]', '$_POST[PLZ]', '$_POST[Ort]',
                                   '$_POST[eMail]', '$_POST[nrSchild]', '$_POST[AutoType]', '$_POST[password]')";
         echo $sql;
         //$conn->query($sql);
      
         if ($conn->query($sql) === TRUE) 
             {
              echo "New record created successfully";
             } 
            else 
             {
              echo "Error: " . $sql . "<br>" . $conn->error;
             }
      
         /*
		     //Anmeldedaten in userFahrtenbuch Datenbank schreiben 
         $m = new MongoClient();
         $db = $m->userFahrtenbuch;
         $collection = $db->user;
      
         //Nachsehen ob eingegebene E-Mail Adresse schon verwendet wird.
         // Wenn ja, bitte eine 'andere' E-Mail Adresse verwenden
         $find = array ("eMail" => $_POST['eMail']);
	       $query = $collection->find($find); 
      
         foreach ($query as $current)
                   {
                    ?>
                     <script language="javascript" type="text/javascript">
                      window.alert('Die eingegebene E-Mail Adresse ist bereits registriert.')
	                   </script>
                    <?php
                     $fehler = 1;
                   }
      
         // Wird die eingegebene E-Mail Adresse das erste mal verwendet, wird der User der Datenbank hinzugefügt.
         // und zur Anmeldeseite weitergeleitet.
         if ($fehler <> 1)
             {
		          $document = array( 
				                        'eMail'        => ''.$_POST["eMail"].'',
				                        'nrSchild'     => ''.$_POST["nrSchild"].'',
				                        'fahrzeugTyp'  => ''.$_POST["fahrzeugTyp"].'',
					                      'password'     => ''.$_POST["password"].''
				                       );
              $collection->insert($document);
              ?>
		           <script language="javascript" type="text/javascript">
		            window.document.location.href = "anmelden.php";
	             </script>
	            <?php
             }
         */
		    }
	 ?> 
		 
     <form action="#" method="post">
      <table border="0">
       <tr>
         <td colspan="3"><label for="name"><b>Registrieren:</b></label></td>
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Firma</label></td>  
        <td colspan="4">
          <input type="text" name="FirmenBez" id="FirmenBez" data-clear-btn="true" value="<?php
                                                                                   if (isset($_POST["FirmenBez"]))
                                                                                       { echo $_POST["FirmenBez"]; }
                                                                                       else
                                                                                       { echo "z.B. xyz GmbH"; }
                                                                                  ?>">
       </td> 
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Anrede</label></td>  
        <td colspan="4">
          <input type="text" name="Anrede" id="Anrede" data-clear-btn="true" value="<?php
                                                                                   if (isset($_POST["Anrede"]))
                                                                                       { echo $_POST["Anrede"]; }
                                                                                       else
                                                                                       { echo "Herr, Frau, Diverse"; }
                                                                                  ?>">
       </td> 
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Vorname</label></td>  
        <td colspan="4">
          <input type="text" name="Vorname" id="Vorname" data-clear-btn="true" value="<?php
                                                                                   if (isset($_POST["Vorname"]))
                                                                                       { echo $_POST["Vorname"]; }
                                                                                       else
                                                                                       { echo "z.B. Hans"; }
                                                                                  ?>">
       </td> 
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Nachname</label></td>  
        <td colspan="4">
          <input type="text" name="Nachname" id="Nachname" data-clear-btn="true" value="<?php
                                                                                   if (isset($_POST["Nachname"]))
                                                                                       { echo $_POST["Nachname"]; }
                                                                                       else
                                                                                       { echo "z.B. Mayer"; }
                                                                                  ?>">
       </td> 
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Strasse</label></td>  
        <td colspan="4">
          <input type="text" name="Strasse" id="Strasse" data-clear-btn="true" value="<?php
                                                                                   if (isset($_POST["Strasse"]))
                                                                                       { echo $_POST["Strasse"]; }
                                                                                       else
                                                                                       { echo "Strassennamen"; }
                                                                                  ?>">
       </td> 
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">PLZ</label></td>  
        <td colspan="4">
          <input type="text" name="PLZ" id="PLZ" data-clear-btn="true" value="<?php
                                                                                   if (isset($_POST["PLZ"]))
                                                                                       { echo $_POST["PLZ"]; }
                                                                                       else
                                                                                       { echo "Postleitzahl"; }
                                                                                  ?>">
       </td> 
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">Ort</label></td>  
        <td colspan="4">
          <input type="text" name="Ort" id="Ort" data-clear-btn="true" value="<?php
                                                                                   if (isset($_POST["Ort"]))
                                                                                       { echo $_POST["Ort"]; }
                                                                                       else
                                                                                       { echo "Ort"; }
                                                                                  ?>">
       </td> 
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td><label for="name">E-Mail</label></td>  
        <td colspan="4">
          <input type="text" name="eMail" id="eMail" data-clear-btn="true" value="<?php
                                                                                   if (isset($_POST["eMail"]))
                                                                                       { echo $_POST["eMail"]; }
                                                                                       else
                                                                                       { echo "z.B. Hans@GMX.de"; }
                                                                                  ?>">
       </td> 
       </tr>
			 <tr>
        <td>&nbsp;</td>
        <td><label for="name">Fahrzeug Typ</label></td>
        <td><input type="text" name="AutoType" id="AutoType" data-clear-btn="true" value="<?php
                                                                                                 if (isset($_POST["AutoType"]))
                                                                                                     { echo $_POST["AutoType"]; }
                                                                                                     else
                                                                                                     { echo "z.B. VW Golf GTD"; }
                                                                                                ?>"></td>
       </tr>
			 <tr>
        <td>&nbsp;</td>
        <td><label for="name">Nummernschild</label></td>
        <td><input type="text" name="nrSchild" id="nrSchild" data-clear-btn="true" value="<?php
                                                                                           if (isset($_POST["nrSchild"]))
                                                                                               { echo $_POST["nrSchild"]; }
                                                                                               else
                                                                                               { echo "z.B. xx-yy 110"; }
                                                                                          ?>"></td>
       </tr>
       </tr>
			 <tr>
        <td>&nbsp;</td>
        <td><label for="name">Password</label></td>
        <td><input type="text" name="password" id="password" data-clear-btn="true"></td>
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
        <td colspan="3"><button style="color:green" id="Registrieren" type="submit" name="Registrieren" value="Registrieren">Registrieren</button></td>
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