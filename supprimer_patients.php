<?php
    require "db.php";


    $id_patient = $_GET['id_patient'];

    $requete =$pdo->prepare("DELETE FROM `patients` WHERE `id_patient` = '$id_patient' ");

    $requete->execute();

        if ($requete==true ) {

        header("location:patient.php");
    }
?>