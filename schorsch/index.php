<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Postleitzahlensuche!</title>

    <?php
    // Auslesen der Parameter

    //Verbindung zur Datenbank

    //Variablen "Config"
    $server = "localhost";
    $user = "root";
    $pwd = "";
    $db = "dbplz";

    $conn = new mysqli($server, $user, $pwd, $db);

    $suchplz = $_REQUEST["paraplz"];

    //Abfrage vorbereiten
    if(isset($_REQUEST["paraplz"])) {
      $sql = "select * from t1 where plz = ".$suchplz;
    } else{
      $sql = "select * from t1";
    }

    $result = $conn->query($sql);
    
    ?>

  </head>
  <body>
    <h2>Postleitzahlensuche!</h2>

    <form action="index.php" method="post">
      <input type="text" name="paraplz">
    </form>

    <h3>Ergebnisliste:</h3>

    <?php
    // output data of each row
    echo"<table class='table'>";
    echo "<tr><th>PLZ</th><th>Ort</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["plz"]."</td>";
        echo "<td>".$row["ort"]."</td>";
        echo "</tr>";
      }
    echo "</table>";
    ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>