<html>
  <head>
    <title>DB & PHP test: INSERT</title>
  </head>
  <body>
   <?php
     $titolo = $_GET["titolo"];
     $autore = $_GET["autore"];
     $genere = $_GET["genere"];

     $connection = new mysqli("localhost", "root", "", "biblioteca");


     if ($connection->connect_error) {
       die("Errore di connessione: " . $connection->connect_error);
     }

     $stmt = $connection->prepare("SELECT * FROM libri WHERE TITOLO = ?");
     $stmt->bind_param("s", $titolo);
     $stmt->execute();
     $result = $stmt->get_result();

     if ($result->num_rows != 0) {
       echo "Il libro $titolo &egrave; gi&agrave; presente nel database!";
     } else {
       $stmt = $connection->prepare("INSERT INTO libri (TITOLO, AUTORE, GENERE) VALUES (?, ?, ?)");
       $stmt->bind_param("sss", $titolo, $autore, $genere);
       
       if ($stmt->execute()) {
         echo "Il libro $titolo &egrave; stato aggiunto al database!";
       } else {
         echo "Errore nell'aggiunta del prodotto: " . $stmt->error;
       }
     }

     $stmt->close();
     $connection->close();
   ?><br><br>
   <a href="http://localhost/biblioteca/index.php">
    Visualizza elenco libri.
   </a>
  </body>
</html>
