<?php
$mn = intval(filter_input(INPUT_GET, "mn"));

$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "universitydb";

$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

if (!$conn) {
  die('Could not connect: ' . mysqli_connect_error());
}

$tblArr = array();
$tblArr[] = "student";
$tblArr[] = "course";
$tblArr[] = "section";
$tblArr[] = "grade_report";
$tblArr[] = "prerequisite";

$table_name = $tblArr[$mn];

$sql = "SHOW COLUMNS FROM $table_name";
$result1 = mysqli_query($conn, $sql);

while ($record = mysqli_fetch_array($result1)) {
    $fields[] = $record['0'];
}

$query = "SELECT MAX($fields[0]) FROM  $table_name";

$out = "";
$result2 = mysqli_query($conn, $query);
$line = mysqli_fetch_array($result2, MYSQLI_ASSOC);

foreach ($line as $col_value) {
    
        $out = $col_value;
        break;
}

print $out;

mysqli_close($conn);
?>
