<!DOCTYPE html>
<html>
<head>
	<title>Read DB</title>
</head>
<body> 
 <?php
  error_reporting (E_ALL);
  echo "Ich bin oben.."."<br>";
  $bulk = new MongoDB\Driver\BulkWrite;
  
  $document = ['Vorname' => '12345'];
  $_id1 = $bulk->insert($document);
  var_dump($_id1);
  
  //$m = new MongoDB\Driver\Manager('mongodb://localhost:27017');
  $m = new MongoDB\Driver\Manager('mongodb+srv://MWeisenauer:Adenauer@timetec-bzlfs.mongodb.net/test?retryWrites=true');
  $result = $m->executeBulkWrite("fahrtenbuch.user", $bulk);
  
  echo "Insert sollte durchgeführt sein";
 ?>
</body>
</html>