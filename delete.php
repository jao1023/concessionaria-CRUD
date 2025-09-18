<?php
if (isset($_GET["id"])) {

    $id = $_GET["id"];
    $severname = "localhost";
    $username  = "root";
    $password = "root";
    $database = "concessionaria";

    //Criação da conexão

    $connection = new mysqli($severname, $username, $password, $database);

    $sql = "DELETE FROM veiculos WHERE id=$id";

    $connection->query($sql);

    header("location: index.php");
    exit;
}
