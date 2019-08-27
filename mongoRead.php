<!DOCTYPE html>
<html>
<head>
	<title>Read DB</title>
</head>
<body> 
 <?php
  error_reporting (E_ALL);
  echo "Ich bin oben.."."<br>";
  //$m = new MongoDB\Driver\Manager('mongodb://localhost:27017');
  $m = new MongoDB\Driver\Manager('mongodb+srv://MWeisenauer:Adenauer@timetec-bzlfs.mongodb.net/test?retryWrites=true');
  
  //Von der Datenbank wir alles ausgegebe
  //$query = new MongoDB\Driver\Query([]);
  
  //Suchen nach einem z.B. Vornamen
  //$filter = ['Vorname' => 'Martina']; 
  
  //suchen nach einer bestimmten _id
  $filter = ['_id' => new MongoDB\BSON\ObjectId("5c8e02c11c9d44000028777b")];

  // Adding query [] Steht für $optionen welche gesetz werden können
  $query = new MongoDB\Driver\Query($filter, []);
  $rows = $m->executeQuery("fahrtenbuch.user", $query);
  foreach($rows as $row)
          {
           echo "$row->_id : $row->Vorname : $row->Nachname"."<br/>";
          }
 ?>
</body>
</html>
 