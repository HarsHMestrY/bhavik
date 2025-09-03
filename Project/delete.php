<?php
include "db.php";

if (!isset($_SESSION["id"])) {
    header("Location:login.php");
}
if (isset($_GET["id"])) {
    $blog_id=$_GET["id"];
    $user_id = $_SESSION["id"];

    $conn->query("delete from blogs where id=$blog_id and user_id=$user_id");

}
header("Location:dashboard.php");


?>