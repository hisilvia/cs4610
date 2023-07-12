<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "universitydb";

$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}
?>
<html>
    <body>
    <center><h3>Transcript</h3> </center> 
    <a href="index.php">Home</a>
    <hr/>
    <center><h4>Transcript</h4> </center> 
    <?php
    $transcriptr = mysqli_query($conn, "SELECT * FROM `student`");
    $count = mysqli_num_rows($transcriptr);
    ?>
    <table border='1' align='center'>
        <tr>
            <th rowspan='2'>student_number</th>
            <th colspan='5'>grade_report</th>
        </tr>
        <tr>
            <th>Course_number</th>
            <th>Grade</th>
            <th>Semester</th>
            <th>Year</th>
            <th>Section_id</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_array($transcriptr)) {
            $student_name = $row['name'];
            $student_number = $row['student_number'];

            $queryTrans = "SELECT Course_number, grade, semester,"
                    . "year, S.section_identifier FROM Section as S, grade_report as G "
                    . "WHERE S.section_identifier=G.section_identifier AND "
                    . "G.student_number=$student_number";

            $studentt = mysqli_query($conn, $queryTrans);

            $count_rows = mysqli_num_rows($studentt);
            $row2 = mysqli_fetch_array($studentt);
            ?>
            <tr>
                <td rowspan='<?php print $count_rows; ?>'><?php print $student_name; ?></td>
                <td><?php print $row2['Course_number']; ?></td>
                <td><?php print $row2['grade']; ?></td>
                <td><?php print $row2['semester']; ?></td>
                <td><?php print $row2['year']; ?></td>
                <td><?php print $row2['section_identifier']; ?></td>
            </tr>
            <?php
            for ($i = 1; $i < $count_rows; $i++) {
                $row2 = mysqli_fetch_array($studentt);
                ?>
                <tr>
                    <td><?php print $row2['Course_number']; ?></td>
                    <td><?php print $row2['grade']; ?></td>
                    <td><?php print $row2['semester']; ?></td>
                    <td><?php print $row2['year']; ?></td>
                    <td><?php print $row2['section_identifier']; ?></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
    <?php
    mysqli_close($conn);
    ?>