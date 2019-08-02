<?php
    require('db.php');

    $sql = "UPDATE todolist SET complete = 1, date = now() WHERE id = ?";

    $id = $_POST['id'];
    // $date = $_POST['date'];
    $db = new DB();
    $res = $db->query($sql, [$id]);

    $response = ['success'=>true, 'res'=>$res];

    echo json_encode($response, JSON_UNESCAPED_UNICODE);