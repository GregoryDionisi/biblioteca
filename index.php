<html>
  <head>
    <title>DB & PHP test</title>
  </head>
  <body>
    <?php
		$connection = @ new mysqli("localhost","root","","biblioteca");
		if ($connection->connect_error)
		die ("Errore di connessione con il DBMS.");
		$query = " SELECT * FROM libri";
		$result = @ $connection->query($query);
		if ($connection->errno){
			@ $connection->close();
			die ("Errore nell�esecuzione della query");
		}
		if (@ $result->num_rows != 0) {
			echo "<table border>";
			echo "<tr>";
			echo "<th>ID_LIBRO</th>";
			echo "<th>TITOLO</th>";
            echo "<th>AUTORE</th>";
            echo "<th>GENERE</th>";
			echo "</tr>";
			while ($row = @ $result->fetch_array()) {
				echo "<tr>";
				echo "<td>$row[0]</td>";
				echo "<td>$row[1]</td>";
                echo "<td>$row[2]</td>";
                echo "<td>$row[3]</td>";
				echo "</tr>";
			}
			echo "</table>";
		}
		@ $result->free();
		@ $connection->close();
    ?><br>
     <a href="http://localhost/biblioteca/add.php">
      Aggiungi un libro.
     </a><br>
     <a href="http://localhost/biblioteca/del.php">
      Elimina un libro esistente.
     </a><br>
     <a href="http://localhost/biblioteca/upload.php">
      Carica libri da file.
     </a>
  </body>
</html>

