<?php
require 'db.php';

$id_patient = $_GET['id_patient'] ?? null;

// Vérification que l'ID est bien fourni
if (!$id_patient) {
    header("Location: patient.php");
    exit;
}

// Récupération des données du patient
$stmt = $pdo->prepare("SELECT * FROM patients WHERE id_patient = :id_patient");
$stmt->execute([':id_patient' => $id_patient]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    header("Location: patient.php");
    exit;
}

$error = "";

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_prenom = trim($_POST['nom_prenom']);
    $telephone = trim($_POST['telephone']);
    $email = trim($_POST['email']);

    // Validation des données
    if (empty($nom_prenom) || empty($telephone) || empty($email)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide.";
    } elseif (!preg_match("/^\d{8,15}$/", $telephone)) {
        $error = "Numéro de téléphone invalide.";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE patients SET nom_prenom = :nom_prenom, telephone = :telephone, email = :email WHERE id_patient = :id_patient");
            $success = $stmt->execute([
                ':nom_prenom' => $nom_prenom,
                ':telephone' => $telephone,
                ':email' => $email,
                ':id_patient' => $id_patient
            ]);

            if ($success) {
                header("Location: patient.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Patient</title>
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

    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
        <div class="bg-green-500 text-white text-center text-2xl font-bold p-4 rounded-md mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Modifier le patient</h2>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-red-500 text-white p-2 rounded mb-4"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block text-gray-700">Nom et prénom :</label>
                <input type="text" name="nom_prenom" value="<?= htmlspecialchars($patient['nom_prenom']) ?>" class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Téléphone :</label>
                <input type="text" name="telephone" value="<?= htmlspecialchars($patient['telephone']) ?>" class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Email :</label>
                <input type="email" name="email" value="<?= htmlspecialchars($patient['email']) ?>" class="w-full p-2 border rounded">
            </div>

            <div class="flex justify-between">
                <a href="patient.php" class="bg-gray-500 text-white px-4 py-2 rounded shadow">Annuler</a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-500">Enregistrer</button>
            </div>
        </form>
    </div>
</body>
</html>

