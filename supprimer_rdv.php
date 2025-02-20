<?php
    require "db.php";


    $id_rdv = $_GET['id_rdv'];

    $requete =$pdo->prepare("DELETE FROM `rendez_vous` WHERE `id_rdv` = '$id_rdv' ");

    $requete->execute();

        if ($requete==true ) {

        header("location:liste_rdv.php");
    }
?>