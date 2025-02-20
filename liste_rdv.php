<?php 

require "db.php";
             
            $requete = $pdo->query("SELECT rendez_vous.id_rdv, rendez_vous.date_heure, patients.nom_prenom, CONCAT(medecin.nom, ' ', medecin.prenom, ' - ', medecin.domaine) AS nom_medecin
            FROM rendez_vous JOIN patients ON rendez_vous.id_patient = patients.id_patient JOIN medecin ON rendez_vous.id_medecin = medecin.id_medecin
        ");
            $rendez_vous = $requete->fetchAll(PDO::FETCH_ASSOC);
        
?>

<!DOCTYPE html> 
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listes rendez_vous</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 text-gray-900 min-h-screen flex flex-col items-center p-6">

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
</nav> <br> <br> <br>

    <h2 class="bg-green-500 text-white text-center text-2xl font-bold p-4 rounded-lg shadow-md w-full max-w-4xl">
        Liste des rendez_vous
    </h2>
    <div class="my-6 w-full max-w-4xl flex justify-end">
        <a class="bg-green-600 text-white px-5 py-2 rounded-lg shadow-md hover:bg-pink-700 transition" href="rdv.php">
            Prendre un rendez_vous
        </a>
    </div>
    <div class="overflow-x-auto w-full max-w-4xl">
        <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
            <thead class="bg-green-300 text-gray-800">
                <tr>
                    <th class="py-3 px-4 text-left">NUM</th>
                    <th class="py-3 px-4 text-left">NOM ET PRENOM</th>
                    <th class="py-3 px-4 text-left">DATE ET HEURE</th>
                    <th class="py-3 px-4 text-left">SOIGNANT</th>
                    <th class="py-3 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300">
                <?php foreach ($rendez_vous as $rendez_vou): ?>
                    <tr class="hover:bg-green-100 transition">
                        <td class="py-3 px-4"> <?= htmlspecialchars($rendez_vou['id_rdv']) ?> </td>
                        <td class="py-3 px-4"> <?= htmlspecialchars($rendez_vou['nom_prenom']) ?> </td>
                        <td class="py-3 px-4"> <?= htmlspecialchars($rendez_vou['date_heure']) ?> </td>
                        <td class="py-3 px-4"> <?= htmlspecialchars($rendez_vou['nom_medecin']) ?> </td>
                        <td class="py-3 px-4 flex gap-2">
                            <a href="modifier_rdv.php?id_rdv=<?= $rendez_vou['id_rdv'] ?>" 
                               class="bg-green-900 text-white px-4 py-2 rounded-md shadow-md hover:bg-green-700 transition">Modifier</a>
                               <a href="supprimer_rdv.php?id_rdv=<?= $rendez_vou['id_rdv'] ?>" 
                                  class="delete-rdv bg-red-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-red-700 transition">Supprimer                                                
                                </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>:



    <!-- confirmation de suppression  utilisant SweetAlert2 une bibliothèque JavaScript moderne-->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const deleteLinks = document.querySelectorAll(".delete-rdv");

        deleteLinks.forEach(link => {
            link.addEventListener("click", function (event) {
                event.preventDefault(); // Empêche la navigation immédiate

                const url = this.getAttribute("href");

                Swal.fire({
                    title: "Êtes-vous sûr ?",
                    text: "Cette action est irréversible !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Oui, supprimer !",
                    cancelButtonText: "Annuler"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url; // Redirection vers la suppression
                    }
                });
            });
        });
    });
</script>
</body>
</html>
