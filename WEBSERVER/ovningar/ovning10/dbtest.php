<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>TEST</title>
</head>

<body>
    <?php
    include('dbconnection.php');
    try {

        // sql to create table
        $sql = "CREATE TABLE IF NOT EXISTS testtabell (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(30) NOT NULL,
comment TEXT,
reg_date DATETIME
)";

        // use exec() because no results are returned
        $dbconn->exec($sql);
        echo "Table created successfully";

        $sql = "INSERT INTO testtabell (name, comment, reg_date)
VALUES (?, ?, now())";
        # prepare
        $stmt = $dbconn->prepare($sql);
        # the data we want to insert
        $data = array('KalleAnka', 'QUUUAACKK!');
        # execute width array-parameter
        $stmt->execute($data);

        $sql = "SELECT * FROM testtabell";
        $stmt = $dbconn->prepare($sql);

        // parameters in array, if empty we could skip the $data-variable
        $data = array();
        $stmt->execute($data);

        $res = $stmt->fetchAll();
        $output = htmlentities(print_r($res, 1));
        echo "<pre>$output</pre>";


    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    //Rensa kopplingen till databasen
    $dbconn = null;
    ?>
</body>

</html>