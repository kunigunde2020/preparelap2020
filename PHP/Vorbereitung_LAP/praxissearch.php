<!DOCTYPE html>
<html>
<head>
    <title>Praxissuche</title>
    <meta charset="UTF-8">
</head>
<nav>
    <?php
    include ('menu.html');
    ?>
</nav>
<body>
<main>
    <h2 class="text-center">Praxissuche</h2>
    <?php
    include ('config.php');
    if (isset($_POST['search']) && isset($_POST['praxis'])){
        try{
            $query = 'select pra_name from praxis 
                        where pra_name like ("%"?"%")';
            $select = $con->prepare($query);
            $select->execute([$_POST['praxis']]);
            $rowcount = $select->rowCount();
            if($rowcount > 0) {
                echo '<h3>Suchergebnis:</h3>';
                echo 'Gesuchte Praxis:'.$_POST['praxis'];
                echo '<br>Gefundene Praxis:';
                while($row = $select->fetch(PDO::FETCH_NUM))
                {
                    echo $row[0].' ';
                }
                echo '<br>Anzahl Patienten:';
                $query = 'select p.pat_vn,
                             p.pat_nn,
                             p.pat_svnr 
                        from patient p,praxis pr 
                            where p.pra_id=pr.pra_id
                        and pr.pra_name like (?);';
                $var = '%'.$_POST['praxis'].'%';
                $select = $con->prepare($query);
                $select->execute([$var]);
                echo $select->rowCount();
                echo '<table border ="1"><tr>
                        <th>Vorname</th>
                        <th>Nachname</th>
                        <th>SVNR</th>
                 </tr>';
                while ($row = $select->fetch(PDO::FETCH_NUM)) {
                    echo '<tr><td>' . $row[0] . '</td>
                          <td>' . $row[1] . '</td>
                          <td>' . $row[2] . '</td>';
                    echo '<tr>';
                }
                echo '</table>';
            }
            else
            {
                echo '<h3>Sucherergebnis:</h3>';
                echo 'Gesuchte Praxis:'.$_POST['praxis'];
                echo '<br>Gefundene Praxis: KEINE';
                echo '<br>Gefundene Patienten: KEINE';
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        try
        {
        ?>
        <form method="POST">
                <label>Suche Praxis:</label>
                <input type="text" name="praxis" placeholder="z.B. Testpraxis">
                </br>
                </br>
                <button type="submit" name="search" value="Suchen">Suchen</button>
                <button type="button" onclick="window.location.href = 'mainpage.php';">Abbrechen</button>
        </form>
        <?php
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
            }
        }
        ?>
</main>
</body>
</html>