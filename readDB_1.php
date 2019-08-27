<!DOCTYPE html>
<html>
<head>
	<title>Read DB</title>
</head>
<body> 
 <?php
  error_reporting (E_ALL);
  echo "Ich bin oben.."."<br>";
  $collection = (new MongoDB\Client)->fahrtenbuch->user;

  $cursor = $collection->find();

  foreach ($cursor as $restaurant) 
           {
            var_dump($restaurant);
           };
 ?>
</body>
</html>