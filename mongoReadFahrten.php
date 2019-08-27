<!DOCTYPE html>
<html>
<head>
	<title>Read DB</title>
</head>
<body> 
 <?php
  error_reporting (E_ALL);
  echo "Ich bin oben.."."<br>";
  
  //Connection mit der Datenbank
  $m = new MongoDB\Driver\Manager('mongodb://localhost:27017');
  //$m = new MongoDB\Driver\Manager('mongodb+srv://MWeisenauer:Adenauer@timetec-bzlfs.mongodb.net/test?retryWrites=true');
    
  //$filter = ['startOrt' => 'TimeTec']; //Suchen nach einem z.B. Vornamen
  //$filter = ['_id' => new MongoDB\BSON\ObjectId("5c8e02c11c9d44000028777b")]; //suchen nach einer bestimmten _id

  // Adding query [] Steht für $optionen welche gesetz werden können
  //$query = new MongoDB\Driver\Query($filter, []);
  $query = new MongoDB\Driver\Query([]); //Von der Datenbank wir alles ausgegeben
  //$query = new MongoDB\Driver\Query(['startOrt' => 'TimeTec'], []);
  $rows = $m->executeQuery("fahrtenbuch.Markus_Weisenauer_de_Touareg_V8_TDI_KL-MM_110", $query);
  foreach($rows as $row)
          {
           echo "$row->_id : $row->startOrt : $row->startDatum : $row->ereignis"."<br/>";
          }
 ?>
</body>
</html>