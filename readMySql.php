<?php
 echo 'Hallo';
 //$link = mysql_connect('localhost', 'MWeisenauer', '!Adenauer1!');
 $conn = new mysqli('localhost', 'MWeisenauer', '!Adenauer1!', 'Fahrtenbuch');
 if (!$conn) 
     {
      die('Verbindung schlug fehl: ' . mysql_error());
     }
 echo 'Erfolgreich verbunden';

 $sql = "SELECT * FROM user";
 $result = $conn->query($sql);

 if ($result->num_rows > 0) 
     {
      // output data of each row
      while($row = $result->fetch_assoc()) 
            {
             echo "<br>id: ". $row["id"]. 
                  "<br>Name: ". $row["FirmenBez"]. 
                  "<br>Anrede: " . $row["Anrede"];
            }
     } 
     else 
     {
      echo "0 results";
     }
$conn->close();
?>