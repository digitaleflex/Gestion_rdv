<?php
    require "db.php";

    try {
        // Récupérer les patients
        $requete1 = $pdo->query("SELECT * FROM `patients`");
        $patients = $requete1->fetchAll(PDO::FETCH_ASSOC);

        // Récupérer les médecins
        $requete2 = $pdo->query("SELECT * FROM `medecin`");
        $medecins = $requete2->fetchAll(PDO::FETCH_ASSOC);

        // Récupérer les rendez-vous avec les infos des patients et médecins
        $requete3 = $pdo->query("
            SELECT rendez_vous.*, patients.nom_prenom, medecin.nom, medecin.prenom, medecin.domaine 
            FROM `rendez_vous`
            JOIN `patients` ON rendez_vous.id_patient = patients.id_patient
            JOIN `medecin` ON rendez_vous.id_medecin = medecin.id_medecin
        ");
        $rendez_vous = $requete3->fetchAll(PDO::FETCH_ASSOC);

        // Gestion du formulaire
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_patient = $_POST["id_patient"];
            $date_heure = $_POST["date_heure"];
            $id_medecin = $_POST["id_medecin"];

            $requete = $pdo->prepare("INSERT INTO `rendez_vous`(`id_patient`, `date_heure`, `id_medecin`) 
                                      VALUES (:id_patient, :date_heure, :id_medecin)");

            $requete->bindParam(':id_patient', $id_patient, PDO::PARAM_INT);
            $requete->bindParam(':date_heure', $date_heure, PDO::PARAM_STR);
            $requete->bindParam(':id_medecin', $id_medecin, PDO::PARAM_INT);

            if ($requete->execute()) {
                header("location: liste_rdv.php");
                exit;
            }
        }

    } catch (PDOException $e) {
        echo "<p class='text-red-500'>Erreur de connexion : " . $e->getMessage() . "</p>";
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prendre rendez-vous</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 flex justify-center items-center min-h-screen">

        <!-- barre de navigation -->

<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
  <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
      <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">MediSync</span>
  </a>
  <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
      
      <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
    </button>
  </div>
  <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
    <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
      <li>
        <a href="index.php" class="block py-2 px-3 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500" aria-current="page">Home</a>
      </li>
      <li>
        <a href="index.php" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>
      </li>
      <li>
        <a href="index.php" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Services</a>
      </li>
      <li>
        <a href="index.php" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
      </li>
    </ul>
  </div>
  </div>
</nav>

    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h2 class="bg-green-500 text-white text-center text-2xl font-bold p-4 rounded-md mb-6">
           Ajout d'un rendez-vous
        </h2>
        <form action="" method="post" class="space-y-4">
            <div class="mb-4">
                    <label for="id_patient" class="block text-gray-700 text-sm font-bold mb-2">Nom du patient :</label>
                    <select name="id_patient" id="id_patient" class="block w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow focus:outline-none focus:shadow-outline">
                        <option value="" >Sélectionner votre nom</option>
                        <?php 
                            try {
                                $requete = "SELECT * FROM patients"; 
                                $stmt = $pdo->query($requete);
                                $patients = $stmt->fetchAll();

                                foreach ($patients as $patients): ?>
                                    <option value="<?= htmlspecialchars($patients['id_patient']); ?>">
                                        <?= htmlspecialchars($patients['nom_prenom']); ?>
                                    </option>
                                <?php endforeach; 

                            } catch (PDOException $e) {
                                echo "<p class='text-red-500'>Erreur de connexion : " . $e->getMessage() . "</p>";
                            }
                        ?>
                    </select>
                </div>

            <div  class="mb-4">
                <label for="date_heure" class="block text-gray-700 font-medium">Date et Heure :</label>
                <input type="datetime-local" name="date_heure" id="date_heure" required 
                       class="w-full p-2 border rounded-md focus:ring-2 focus:ring-pink-400">
                       
            </div>

            <div class="mb-4">
                    <label for="id_medecin" class="block text-gray-700 text-sm font-bold mb-2">Nom du medecin :</label>
                    <select name="id_medecin" id="id_medecin" class="block w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow focus:outline-none focus:shadow-outline">
                        <option value="" >Sélectionner un spécialiste</option>
                        <?php 
                            try {
                                $requetes = "SELECT * FROM medecin"; 
                                $stmt = $pdo->query($requetes);
                                $medecin = $stmt->fetchAll();

                                foreach ($medecin as $medecins): ?>
                                    <option value="<?= htmlspecialchars($medecins['id_medecin']); ?>">
                                         <?= htmlspecialchars($medecins['nom'] . " " . $medecins['prenom'] . " - " . $medecins['domaine']); ?>
                                    </option>
                                <?php endforeach; 

                            } catch (PDOException $e) {
                                echo "<p class='text-red-500'>Erreur de connexion : " . $e->getMessage() . "</p>";
                            }
                        ?>
                    </select>
                </div>

            <div class="flex justify-between">
                <input type="submit" value="Envoyer" 
                       class="bg-green-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-green-700 transition">
                <input type="reset" value="Annuler" 
                       class="bg-gray-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-gray-700 transition">
            </div>
        </form>
    </div>
</body>
</html>
