<?php
$mn = intval(filter_input(INPUT_GET, "mn"));
$fd1 = filter_input(INPUT_GET, "fd1");
$fd2 = filter_input(INPUT_GET, "fd2");

$dat = filter_input(INPUT_GET, "dat");

$datArr = explode("@--@",$dat);

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

$colsdat = "$fields[0] = '$datArr[0]'";

for ($i = 1; $i < count($datArr); $i++) {
    $colsdat = $colsdat . ", $fields[$i] = '$datArr[$i]'";
}

$query = "UPDATE $table_name SET $colsdat WHERE $fields[0] = '$fd1' AND $fields[1] = '$fd2'";
$result2 = mysqli_query($conn, $query);

print "";

mysqli_close($conn);
?>