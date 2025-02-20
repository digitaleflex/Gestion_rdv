<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_prenom = trim($_POST["nom_prenom"]);
    $telephone = trim($_POST["telephone"]);
    $email = trim($_POST["email"]);
    $error_message = "";

    // Validation des champs
    if (empty($nom_prenom) || empty($telephone) || empty($email)) {
        $error_message = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Adresse email invalide.";
    } elseif (!preg_match("/^\d{8,15}$/", $telephone)) { // Exemple : 8 à 15 chiffres
        $error_message = "Numéro de téléphone invalide.";
    }

    // Si aucune erreur, on insère dans la base de données
    if (empty($error_message)) {
        try {
            $requete = $pdo->prepare("INSERT INTO `patients`(`nom_prenom`, `telephone`, `email`) VALUES (?, ?, ?)");
            $success = $requete->execute([$nom_prenom, $telephone, $email]);

            if ($success) {
                header("Location: patient.php");
                exit;
            } else {
                $error_message = "Erreur lors de l'enregistrement.";
            }
        } catch (PDOException $e) {
            $error_message = "Erreur SQL : " . $e->getMessage();
        }
    }

    // Affichage du message d'erreur (à intégrer dans ton HTML)
    if (!empty($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout d'un patient</title>
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
            Formulaire d'ajout d'un patient
        </h2>
        <form action="" method="post" class="space-y-4">
            <div>
                <label for="nom_prenom" class="block text-gray-700 font-medium">Nom et prenom :</label>
                <input type="text" name="nom_prenom" id="nom_prenom" required 
                       class="w-full p-2 border rounded-md focus:ring-2 focus:ring-pink-400">
            </div>

            <div>
                <label for="telephone" class="block text-gray-700 font-medium">Téléphone :</label>
                <input type="text" name="telephone" id="telephone" required 
                       class="w-full p-2 border rounded-md focus:ring-2 focus:ring-pink-400">
            </div>

            <div>
                <label for="email" class="block text-gray-700 font-medium">Email :</label>
                <input type="email" name="email" id="email" required 
                       class="w-full p-2 border rounded-md focus:ring-2 focus:ring-pink-400">
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
