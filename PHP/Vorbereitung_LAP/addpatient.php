<?php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Patient hinzufügen</title>
    <meta charset="UTF-8">
</head>
<nav>
    <?php
    include ('menu.html');
    ?>
</nav>
<body>
<main>
    <h2 class="text-center">Patient hinzufügen</h2>
    <?php
    include ('config.php');
    if (isset($_POST['insert'])){
        try{
            $vorname = $_POST['vorname'];
            $nachname = $_POST['nachname'];
            $svnr = $_POST['svnr'];
            $adresse = $_POST['adresse'];
            $praxis = $_POST['praxis'];
            $sozialversicherung = $_POST['sozialversicherung'];
            $query = 'select pat_svnr from patient 
                        where pat_svnr = ?';
            $select = $con->prepare($query);
            $select->execute([$svnr]);
            $rowcount = $select->rowCount();
            if($rowcount == 0) {
                $query = 'insert into patient(pat_vn,pat_nn,pra_id,soz_id,pat_svnr,adr_id) values (?,?,?,?,?,?)';
                $insert = $con->prepare($query);
                $insert->execute([$vorname,$nachname,$praxis,$sozialversicherung,$svnr,$adresse]);
                $query = 'select pra_name from praxis where pra_id = ?';
                $select = $con->prepare($query);
                $select->execute([$praxis]);
                $praxis_name = $select->fetch(PDO::FETCH_NUM);
                $query = 'select soz_name from sozialversicherung where soz_id = ?';
                $select = $con->prepare($query);
                $select->execute([$sozialversicherung]);
                $sozialversicherung_name = $select->fetch(PDO::FETCH_NUM);
                echo 'Folgende Daten wurden eingefügt:';
                echo '<br><u>Vorname:</u> '.$vorname;
                echo '<br><u>Nachname:</u> '.$nachname;
                echo '<br><u>SVNR:</u> '.$svnr;
                echo '<br><u>Praxis:</u> '.$praxis_name[0];
                echo '<br><u>Sozialversicherung:</u> '.$sozialversicherung_name[0];
            }
            else
            {
                echo '<h3>Fehler beim hinzufügen des Patienten:</h3>';
                echo 'Sozialversicherungsnummer existiert bereits!';
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
                <h3>Patientendaten:</h3>
                <label>Vorname: </label>
                <input type="text" name="vorname" placeholder="z.B. Max" required>
                <br><label for="cp">Nachname: </label>
                <input type="text" name="nachname" placeholder="z.B. Mustermann" required>
                <br><label for="cp">SVNR: </label>
                <input type="text" name="svnr" placeholder="z.B. 12345" required>
                <br><label>Adresse:</label>
                <select name="adresse" required>
                    <?php
                    $query='select adr_id,adr_straße,adr_hnr from adresse';
                    $selFun = $con->prepare($query);
                    $selFun->execute();
                    while($row = $selFun->fetch(PDO::FETCH_NUM)){
                        echo '<option value="'.$row[0].'">'.$row[1].' '.$row[2];
                    }
                    ?>
                </select>

                <h3>Praxis:</h3>
                <label>Praxis: </label>
                <select name="praxis" required>
                <?php
                $query='select pra_id,pra_name from praxis';
                $selFun = $con->prepare($query);
                $selFun->execute();
                while($row = $selFun->fetch(PDO::FETCH_NUM)){
                        echo '<option value="'.$row[0].'">'.$row[1];
                    }
                ?>
                </select>

                <h3>Sozialversicherung:</h3>
                <label>Sozialversicherung: </label>
                <select name="sozialversicherung" required>
                <?php
                $query='select soz_id,soz_name from sozialversicherung';
                $selFun = $con->prepare($query);
                $selFun->execute();
                while($row = $selFun->fetch(PDO::FETCH_NUM)){
                    echo '<option value="'.$row[0].'">'.$row[1];
                }
                ?>
                </select>
                </br>
                </br>
                <button type="submit" name="insert">Speichern</button>
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