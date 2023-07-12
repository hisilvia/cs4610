<?php
$mn = intval(filter_input(INPUT_POST, "mn"));

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

$allfields = "(";
$allvalues = "(";

for ($i = 0; $i < count($fields); $i++) {
    $val = filter_input(INPUT_POST, $fields[$i]);
    
    $allfields = $allfields . $fields[$i];
    $allvalues = $allvalues . "'" . $val . "'";
    
    if ($i < count($fields) - 1) {
        $allfields = $allfields . ",";
        $allvalues = $allvalues . ",";
    }
}

$allfields = $allfields . ")";
$allvalues = $allvalues . ")";

$query = "INSERT INTO $table_name $allfields VALUES $allvalues";

mysqli_query($conn, $query);

mysqli_close($conn);

header('Location: index.php?mn=' . $mn);
?>