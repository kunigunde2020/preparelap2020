<!DOCTYPE html>
<html>
<head>
    <title>Patientensuche</title>
    <meta charset="UTF-8">
</head>
<nav>
    <?php
    include ('menu.html');
    ?>
</nav>
<body>
<main>
    <h2 class="text-center">Patientensuche</h2>
    <?php
    include ('config.php');
    if (isset($_POST['search']) && isset($_POST['patient'])){
        try{
            $query = 'select pat_vn,pat_nn from patient 
                        where concat(pat_vn,pat_nn) like ("%"?"%")';
            $select = $con->prepare($query);
            $select->execute([$_POST['patient']]);
            $rowcount = $select->rowCount();
            if($rowcount > 0) {
                echo '<h3>Sucherergebnis:</h3>';
                echo 'Gesuchte Patienten:'.$_POST['patient'];
                echo '<br>Gefundene Patienten:';
                echo '<ul>';
                while($row = $select->fetch(PDO::FETCH_NUM))
                {
                        echo '<li>' . $row[0] . ' ' . $row[1] . '</li>';
                }
                echo '</ul>';
                echo 'Anzahl Patienten:';
                $query = 'select  pat_vn,
                                  pat_nn,
                                  pat_svnr 
                        from patient   
                            where 
                        concat(pat_vn,pat_nn) like ("%"?"%") ;';
                $select = $con->prepare($query);
                $select->execute([$_POST['patient']]);
                echo $select->rowCount();
                echo
                '<table border ="1">
                 <tr>
                        <th>Vorname</th>
                        <th>Nachname</th>
                        <th>SVNR</th>
                 </tr>';
                while ($row = $select->fetch(PDO::FETCH_NUM)) {
                    echo '<tr><td>' . $row[0].'</td>
                          <td>' . $row[1] . '</td>
                          <td>' . $row[2] . '</td>';
                    echo '<tr>';
                }
                echo '</table>';
            }
            else
            {
                echo '<h3>Sucherergebnis:</h3>';
                echo 'Gesuchter Patient:'.$_POST['patient'];
                echo '<br>Gefundener Patient: KEINE';
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
                <label>Suche Patient: </label>
                <input type="text" name="patient" placeholder="z.B. Max Mustermann">
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