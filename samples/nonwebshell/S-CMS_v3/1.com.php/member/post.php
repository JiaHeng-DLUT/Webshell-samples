<?php 
require '../conn/conn2.php';
require '../conn/function.php';

$O_id = intval($_REQUEST["O_id"]);
$genkey = t($_REQUEST["genkey"]);
if ($O_id == "" && $genkey == "") {
    die();
} else {
    if ($O_id != "") {
        $sql = "select * from SL_orders where O_id=" . $O_id;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            $O_state = $row["O_state"];
        }
        echo $O_state;
    }
    if ($genkey != "") {
        $sql = "select * from SL_member where M_genkey='" . $genkey . "'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            $_SESSION["M_login"] = $row["M_login"];
            $_SESSION["M_pwd"] = $row["M_pwd"];
            $_SESSION["M_id"] = $row["M_id"];
            echo 1;
        } else {
            echo 0;
        }
    }
}
?>