<!DOCTYPE html>
 <html>
  <body>
    
   <?php 
   if ($_POST["updateTanken"] == "1")
       {
				echo "Update Tanken<br>";	
				echo $_POST['id'];
				echo $_POST['update_tankenEndeOrt'];
				echo $_POST['update_Liter'];
			 }
   ?>
    
  </body>
</html> 