<html>
  <head>
    <title>DB & PHP test: UPLOAD</title>
  </head>
  <body>
   <?php
	if ($_FILES["libri"]["error"] == UPLOAD_ERR_OK) {
		$connection = new mysqli("localhost", "root", "", "biblioteca");
		if ($connection->connect_error) {
			die("Errore di connessione con il DBMS: " . $connection->connect_error);
		}

		$command = $connection->prepare("INSERT INTO libri (TITOLO, AUTORE, GENERE) VALUES (?, ?, ?)");
		if (!$command) {
			die("Errore nella preparazione della query: " . $connection->error);
		}

		$personaggi = file($_FILES["libri"]["tmp_name"], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

		foreach ($personaggi as $linea) {
			$dati = explode(",", $linea);

			if (count($dati) !== 3) {
				echo "Errore nel formato del file: ogni riga deve contenere esattamente 3 valori.<br>";
				continue;
			}

			$titolo = trim($dati[0]);
			$autore = trim($dati[1]);
            $genere = trim($dati[2]);

			if (!$command->bind_param("sss", $titolo, $autore, $genere)) {
				echo "Errore nel binding dei parametri: " . $command->error . "<br>";
				continue;
			}

			if ($command->execute()) {
				echo "Il libro $titolo &egrave; stato aggiunto al database.<br>";
			} else {
				echo "Errore: il libro $titolo NON &egrave; stato aggiunto al database: " . $command->error . "<br>";
			}
		}

		unlink($_FILES["libri"]["tmp_name"]);
		$command->close();
		$connection->close();
	} else {
		echo "Errore di caricamento del file.";
	}
    ?><br>
    
    <a href="http://localhost/biblioteca/index.php">Visualizza elenco libri.</a>
  </body>
</html>
