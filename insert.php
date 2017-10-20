<?php
# See this URL on how to place our vlaues in a include file and then access them via variables.
# http://php.net/manual/en/function.include.php

echo "begin database";
$link = mysqli_connect("itmo544jrhdb.cpyht2c1c9a4.us-east-1.rds.amazonaws.com","controller","ilovebunnies","itmo544db") or die("Error " . mysqli_error($link));

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


   # id INT NOT NULL AUTO_INCREMENT,
   # name VARCHAR(200) NOT NULL,
   # age INT NOT NULL,

/* Prepared statement, stage 1: prepare */
if (!($stmt = $link->prepare("INSERT INTO student (id, name, age) VALUES (NULL,?,?)"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

$id = 1;
$name = "joe";
$age = 55;

$stmt->bind_param("si",$name,$age);

if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}

printf("%d Row inserted.\n", $stmt->affected_rows);


/* explicit close recommended */
$stmt->close();

$link->real_query("SELECT * FROM student");
$res = $link->use_result();

echo "Result set order...\n";
while ($row = $res->fetch_assoc()) {
    echo " id = " . $row['id'] . "\n";
}


$link->close();




?>
