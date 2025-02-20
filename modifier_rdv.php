<?php
require 'db.php';

$id_rdv = $_GET['id_rdv'] ?? null;

// Vérification que l'ID est bien fourni
if (!$id_rdv) {
    header("Location: liste_rdv.php");
    exit;
}

// Récupération des données du rendez-vous
$stmt = $pdo->prepare("
    SELECT rendez_vous.id_rdv, rendez_vous.date_heure, patients.id_patient, patients.nom_prenom, 
           medecin.id_medecin, CONCAT(medecin.nom, ' ', medecin.prenom, ' - ', medecin.domaine) AS nom_medecin
    FROM rendez_vous
    JOIN patients ON rendez_vous.id_patient = patients.id_patient
    JOIN medecin ON rendez_vous.id_medecin = medecin.id_medecin
    WHERE rendez_vous.id_rdv = :id_rdv
");
$stmt->execute([':id_rdv' => $id_rdv]);
$rendez_vous = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$rendez_vous) {
    header("Location: liste_rdv.php");
    exit;
}

$error = "";

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_patient = $_POST['id_patient'] ?? null;
    $id_medecin = $_POST['id_medecin'] ?? null;
    $date_heure = trim($_POST['date_heure']);

    // Validation des données
    if (!$id_patient || !$id_medecin || empty($date_heure)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE rendez_vous SET id_patient = :id_patient, id_medecin = :id_medecin, date_heure = :date_heure WHERE id_rdv = :id_rdv");
            $success = $stmt->execute([
                ':id_patient' => $id_patient,
                ':id_medecin' => $id_medecin,
                ':date_heure' => $date_heure,
                ':id_rdv' => $id_rdv
            ]);

            if ($success) {
                header("Location: liste_rdv.php");
                exit;
            } else {
                $error = "Échec de la mise à jour.";
            }
        } catch (PDOException $e) {
            $error = "Une erreur est survenue : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier rendez-vous</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 flex justify-center items-center min-h-screen">

    <!-- barre de navigation -->

    <nav class="bg-green-50 dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
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
           Modification d'un rendez-vous
        </h2>

        <?php if (!empty($error)): ?>
            <div class="bg-red-500 text-white p-2 rounded mb-4"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="" method="post" class="space-y-4">
            <div class="mb-4">
                <label for="id_patient" class="block text-gray-700 text-sm font-bold mb-2">Nom du patient :</label>
                <select name="id_patient" id="id_patient" class="block w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow focus:outline-none focus:shadow-outline">
                    <option value="" >Sélectionner un patient</option>
                    <?php 
                        try {
                            $stmt = $pdo->query("SELECT * FROM patients");
                            $patients = $stmt->fetchAll();
                            foreach ($patients as $patient): ?>
                                <option value="<?= htmlspecialchars($patient['id_patient']); ?>" <?= ($patient['id_patient'] == $rendez_vous['id_patient']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($patient['nom_prenom']); ?>
                                </option>
                            <?php endforeach; 
                        } catch (PDOException $e) {
                            echo "<p class='text-red-500'>Erreur : " . $e->getMessage() . "</p>";
                        }
                    ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="date_heure" class="block text-gray-700 font-medium">Date et Heure :</label>
                <input type="datetime-local" name="date_heure" id="date_heure" value="<?= htmlspecialchars($rendez_vous['date_heure']) ?>"
                       class="w-full p-2 border rounded-md focus:ring-2 focus:ring-pink-400">
            </div>

            <div class="mb-4">
                <label for="id_medecin" class="block text-gray-700 text-sm font-bold mb-2">Nom du médecin :</label>
                <select name="id_medecin" id="id_medecin" class="block w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow focus:outline-none focus:shadow-outline">
                    <option value="" >Sélectionner un spécialiste</option>
                    <?php 
                        try {
                            $stmt = $pdo->query("SELECT * FROM medecin");
                            $medecins = $stmt->fetchAll();
                            foreach ($medecins as $medecin): ?>
                                <option value="<?= htmlspecialchars($medecin['id_medecin']); ?>" <?= ($medecin['id_medecin'] == $rendez_vous['id_medecin']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($medecin['nom'] . " " . $medecin['prenom'] . " - " . $medecin['domaine']); ?>
                                </option>
                            <?php endforeach; 
                        } catch (PDOException $e) {
                            echo "<p class='text-red-500'>Erreur : " . $e->getMessage() . "</p>";
                        }
                    ?>
                </select>
            </div>

            <div class="flex justify-between">
                <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-pink-700 transition">Enregistrer</button>
                <a href="liste_rdv.php" class="bg-gray-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-gray-700 transition">Annuler</a>
            </div>
        </form>
    </div>
</body>
</html>
