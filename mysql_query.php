
<html>
   <head>
      <title>Selecting MySQL Database</title>
      <style>
         table, th, td 
         {
          border: 1px solid black;
         }
</style>
   </head>

<form action="" method="post">
    Base de datos <br/>
    <input type="text" name="database" id="database" value = "<?php if(isset($_POST["database"])){echo $_POST["database"];}?>">
    <br/>
    SQL Query <br/>
    <textarea name="query" cols="60" rows="10"><?php if(isset($_POST["query"])){echo $_POST["query"];}?></textarea> <br />
    <input type="submit" value="Submit Query"> <br />
</form>


<?php
      if (isset($_POST["database"]) && isset($_POST["query"]))
      {
         //database credential
         $dbhost = '<database_ip>:3306';
         $dbuser = 'user for  db';
         $dbpass = 'password';
         $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
         $db = $_POST["database"];
         $query = $_POST["query"];
         
         if(! $conn ) 
         {
            die('Could not connect: ' . mysqli_error());
         }
         echo 'Connected successfully <br/>' ;
         mysqli_select_db($conn, $db);     
       
       $result = mysqli_query($conn,$query);
       #$row = mysqli_fetch_array($result);
       echo "<table> <thead> <tr>";
       for ($i = 0;$i < mysqli_num_fields($result);$i++)
       {
          $column = mysqli_fetch_field_direct($result,$i);
         # echo "<th>".$column."</th>";
         printf("<th> %s\n",$column->name);
         echo "</th>";
       }
       echo "</tr></thead></tbody>";
       for ($i = 0; $i < mysqli_num_rows($result);$i++)
       {
          echo "<tr>";
          $row = mysqli_fetch_row($result);
          for ($j = 0; $j < mysqli_num_fields($result);$j++)
          {
             echo "<td>".$row[$j]."</td>";
          }
          echo "</tr>";
       }
      
       mysqli_close($conn);
         
      }