<?php
$mn = intval(filter_input(INPUT_GET, "mn"));
$cn = intval(filter_input(INPUT_GET, "cn"));
$dir = intval(filter_input(INPUT_GET, "dir"));

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
      
$optArr = array();
$optArr[] = "Student";
$optArr[] = "Course";
$optArr[] = "Section";
$optArr[] = "Grade Report";
$optArr[] = "Prerequisite";

$data2dArr = array();

if ($dir == 0) {
    $query = "SELECT * FROM  $table_name ORDER BY $fields[$cn]";
} else {
    $query = "SELECT * FROM  $table_name ORDER BY $fields[$cn] DESC";
}

$result2 = mysqli_query($conn, $query);

while ($line = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
    $i = 0;
    foreach ($line as $col_value) {
        $data2dArr[$i][] = $col_value;
        $i++;
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Project 1 -cs4610</title>
        <script type="text/javascript" src="js/university.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    </head>
    <body>
        <a href="index.php">Home</a>
        <a href="dispTranscript.php">Transcript</a>
        <p></p>
        <table>
            <tr>
                <?php
                for ($i = 0; $i < count($optArr); $i++) {
                    ?>
                    <td style="width: 7em">
                        <?php
                        if ($mn == $i) {
                            ?>
                            <b><?php print $optArr[$i]; ?></b>
                            <?php
                        } else {
                            ?>
                            <a href="index.php?mn=<?php print $i; ?>">
                                <?php print $optArr[$i]; ?>
                            </a>
                            <?php
                        }
                        ?>
                    </td>
                    <?php
                }
                ?>
            </tr>
        </table>
        <hr />
        <table>
            <tr>
                <?php
                for ($i = 0; $i < count($fields); $i++) {
                    ?>
                    <th style="width: 8em"><?php print $fields[$i]; ?></th>
                        <?php
                    }
                    ?>
                       <td>&nbsp;</td>
            </tr>
            <?php
            for ($j = 0; $j < count($data2dArr[0]); $j++) {
                ?>
                <tr>
                    <?php
                    for ($k = 0; $k < count($fields); $k++) {
                        ?>
                        <td id="R<?php print $j; ?>C<?php print $k; ?>"><?php print $data2dArr[$k][$j]; ?></td>
                        <?php
                    }
                    ?>                        
                       <td style="width: 4em">
                           <div id="editbtndiv<?php print $j; ?>" style="display: block">
                                <input type="button" onclick="editThisRow('<?php print $data2dArr[0][$j]; ?>',
                                            '<?php print $data2dArr[1][$j]; ?>',<?php print $j; ?>)" value="Edit"/>
                           </div>
                           <div id="updtbtndiv<?php print $j; ?>" style="display: none">
                                <input type="button" onclick="updateThisRow('<?php print $data2dArr[0][$j]; ?>',
                                    '<?php print $data2dArr[1][$j]; ?>',<?php print $j; ?>)" value="Update"/>
                           </div> 
                        </td>
                        <td id="delbtn<?php print $j; ?>">
                            <input type="button" onclick="delThisRow('<?php print $data2dArr[0][$j]; ?>',
                                '<?php print $data2dArr[1][$j]; ?>')" value="Del"/>
                        </td>                        
                </tr>
                <?php
            }
            ?>
            <tr>
                <?php
                for ($i = 0; $i < count($fields); $i++) {
                    ?>
                    <td style="width: 8em">
                        <input type="image" src="images/up.png" onclick="sortCurrentField(<?php print $mn; ?>,<?php print $i; ?>, 0)"/>
                        <input type="image" src="images/down.png" onclick="sortCurrentField(<?php print $mn; ?>,<?php print $i; ?>, 1)"/>
                    </td>
                    <?php
                }
                ?>
            </tr>        
        </table>           
  <div id="newdatadiv" style="display: block">
            <input id="numcols" type="hidden" value="" />
            <table>
                <tr>
                    <?php
                    for ($i = 0; $i < count($fields); $i++) {
                        ?>
                        <td style="width: 8em"></td>
                        <?php
                    }
                    ?>
                    <td><input type="button" onclick="addNewRow()" value="New Row"/></td>
                </tr>
            </table>
  </div>      
  <div id="datainputdiv" style="display: none">
            <form action="enterTableRow.php" method="post">
                <input id="mn" type="hidden" name="mn" value="<?php print $mn; ?>" />
                <table>
                    <tr>
                        <?php
                        for ($i = 0; $i < count($fields); $i++) {
                            ?>
                            <td style="width: 8em"><input type="text" name="<?php print $fields[$i]; ?>" size="10" /></td>
                                <?php
                            }
                            ?>
                        <td><input type="submit" value="Add"/></td>
                    </tr>
                </table>
            </form>
 </div>
  <p></p>
        <table>
            <tr>
                <td id="mymax" style="width:4em;background-color:lightgrey">&nbsp;</td>
                <td style="width: 10em">&nbsp;</td>
                <td><input type="button" onclick="showMaxVal(<?php print $mn; ?>)" value="Show Max"/></td>
            </tr>
        </table>      
        
        
        
    </body>
</html>
<?php
mysqli_close($conn);
?>
    