<?php 
require "db.php";

$search = isset($_GET['search']) ? trim($_GET['search']) : "";

$query = "SELECT * FROM patients";
$params = [];

if (!empty($search)) {
    $query .= " WHERE nom_prenom LIKE :search";
    $params[':search'] = "%$search%";
}

$requete = $pdo->prepare($query);
$requete->execute($params);
$patients = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Patients</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 text-gray-900 min-h-screen flex flex-col items-center p-6">

<!-- Navigation -->
<nav class="bg-green-500 text-white fixed w-full top-0 shadow-md">
    <div class="max-w-screen-xl mx-auto flex items-center justify-between p-4">
        <a href="#" class="text-2xl font-bold">MediSync</a>
        <ul class="hidden md:flex space-x-6">
            <li><a href="index.php" class="hover:text-gray-300">Home</a></li>
            <li><a href="#" class="hover:text-gray-300">About</a></li>
            <li><a href="#" class="hover:text-gray-300">Services</a></li>
            <li><a href="#" class="hover:text-gray-300">Contact</a></li>
        </ul>
    </div>
</nav>

<!-- Contenu principal -->
<div class="container mx-auto mt-24 p-6 w-full max-w-4xl">

    <h2 class="text-center text-3xl font-bold text-green-700 mb-6">Liste des patients</h2>

    <!-- Barre de recherche -->
    <form method="GET" class="flex items-center gap-2 mb-6">
        <input type="text" name="search" placeholder="Rechercher un patient" 
            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
            value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="bg-green-600 text-white px-5 py-3 rounded-lg hover:bg-green-700">Rechercher</button>
    </form>

    <!-- Bouton d'ajout -->
    <div class="flex justify-end mb-4">
        <a href="form_patient.php" class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow-md hover:bg-blue-700">Ajouter un patient</a>
    </div>

    <!-- Tableau des patients -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="min-w-full">
            <thead class="bg-green-300 text-gray-800">
                <tr>
                    <th class="py-3 px-4 text-left">#</th>
                    <th class="py-3 px-4 text-left">Nom & Prénom</th>
                    <th class="py-3 px-4 text-left">Téléphone</th>
                    <th class="py-3 px-4 text-left">Email</th>
                    <th class="py-3 px-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300">
                <?php foreach ($patients as $patient): ?>
                    <tr class="hover:bg-green-100 transition">
                        <td class="py-3 px-4"><?= htmlspecialchars($patient['id_patient']) ?></td>
                        <td class="py-3 px-4"><?= htmlspecialchars($patient['nom_prenom']) ?></td>
                        <td class="py-3 px-4"><?= htmlspecialchars($patient['telephone']) ?></td>
                        <td class="py-3 px-4"><?= htmlspecialchars($patient['email']) ?></td>
                        <td class="py-3 px-4 text-center flex justify-center gap-3">
                            <a href="modifier_patients.php?id_patient=<?= $patient['id_patient'] ?>" 
                               class="bg-gray-900 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Modifier</a>
                            <a href="supprimer_patients.php?id_patient=<?= $patient['id_patient'] ?>" 
                               class="delete-patient bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Script pour la confirmation de suppression -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-patient").forEach(link => {
            link.addEventListener("click", function (event) {
                event.preventDefault();
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
                        window.location.href = url;
                    }
                });
            });
        });
    });
</script>

</body>
</html>
