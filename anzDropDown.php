<form method="post" action="tankListe.php">
 <table align="center">
  <tr>
   <td><?php echo $anz ?></td>
   <td>
    <select name="fahrtenAnzeige" id="fahrtenAnzeige">
     <?php
      if ($_POST["fahrtenAnzeige"] <> "")
          {
           echo "<option value=".$_POST["fahrtenAnzeige"]." selected>".$_POST["fahrtenAnzeige"]."</option>";
          }
     ?>
     <option value=letzten30Tage>letzten 30 Tage</option>
     <option value=Monatsanfang>Monatsanfang</option>
     <option value=Vormonat>Vormonat</option>
     <option value=Jahr>Jahr</option>
     <option value=alleFahrten>alle Fahrten</option> 
    </select>
   </td>
   <td>
    <button style="color:green" type=submit name="action" value="OK">OK</button>
   </td>
  </tr>
 </table>
</form>