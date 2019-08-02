<?php
require('db.php');

    $sql = "DELETE FROM todolist WHERE id = ?";

    $id = $_POST['id'];
    $db = new DB();
    $res = $db->query($sql, [$id]);