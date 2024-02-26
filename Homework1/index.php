<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarih Aralığına Göre Veri Listeleme</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <center><h2>Tarih Aralığına Göre Veri Listeleme</h2></center>
    
    <form method="post">

        <div class="start_date_box">
            <label for="start_date">Başlangıç Tarihi</label><br>
            <input type="date" id="start_date" name="start_date" value="2003-12-22">
        </div>

        <div class="end_date_box">
            <label for="end_date">Bitiş Tarihi</label><br>
            <input type="date" id="end_date" name="end_date">
        </div>
        <br>
        <button type="submit" name="listele" id="read_data">Listele</button>
    </form>


    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "classicmodels";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Bağlantı hatası: " . $conn->connect_error);
        }

        if (isset($_POST['listele'])) {
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='$dbname' AND TABLE_NAME='orders'";
            $result = $conn->query($sql);

            $columns = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $columns[] = $row["COLUMN_NAME"];
                }
            }

            $sql = "SELECT * FROM orders WHERE shippedDate BETWEEN '$start_date' AND '$end_date'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table border='1'>";

                echo "<tr>";
                foreach ($columns as $column) {
                    echo "<th>$column</th>";
                }
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($columns as $column) {
                        echo "<td>" . $row[$column] . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "0 sonuç";
            }
        }

        $conn->close();
    ?>
    
</body>
</html>


