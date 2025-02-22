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
        $id_patient = $_POST["id_patient"] ?? null;
        $date_heure = $_POST["date_heure"] ?? null;
        $id_medecin = $_POST["id_medecin"] ?? null;

        if ($id_patient && $date_heure && $id_medecin) {
            $requete = $pdo->prepare("INSERT INTO `rendez_vous`(`id_patient`, `date_heure`, `id_medecin`) 
                                      VALUES (:id_patient, :date_heure, :id_medecin)");

            $requete->bindParam(':id_patient', $id_patient, PDO::PARAM_INT);
            $requete->bindParam(':date_heure', $date_heure, PDO::PARAM_STR);
            $requete->bindParam(':id_medecin', $id_medecin, PDO::PARAM_INT);

            if ($requete->execute()) {
                header("location: liste_rdv.php");
                exit;
            }
        } else {
            $message = "Tous les champs sont obligatoires.";
        }
    }
} catch (PDOException $e) {
    echo "<p class='text-red-500'>Erreur de connexion : " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prendre rendez-vous</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen p-4">

    <div class="bg-white shadow-xl rounded-lg p-8 w-full max-w-lg">
        <h2 class="bg-green-500 text-white text-center text-2xl font-bold p-4 rounded-md mb-6">
            Ajouter un rendez-vous
        </h2>

        <?php if (!empty($message)): ?>
            <p class="text-red-500 text-center"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form action="" method="post" class="space-y-6">
            <!-- Sélection du patient -->
            <div>
                <label for="id_patient" class="block text-gray-700 font-medium mb-2">Nom du patient :</label>
                <select name="id_patient" id="id_patient" required
                        class="block w-full border border-gray-300 px-4 py-2 rounded-md focus:ring-2 focus:ring-green-400">
                    <option value="">Sélectionner un patient</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?= htmlspecialchars($patient['id_patient']); ?>">
                            <?= htmlspecialchars($patient['nom_prenom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Date et Heure -->
            <div>
                <label for="date_heure" class="block text-gray-700 font-medium mb-2">Date et Heure :</label>
                <input type="datetime-local" name="date_heure" id="date_heure" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-400">
            </div>

            <!-- Sélection du médecin -->
            <div>
                <label for="id_medecin" class="block text-gray-700 font-medium mb-2">Nom du médecin :</label>
                <select name="id_medecin" id="id_medecin" required
                        class="block w-full border border-gray-300 px-4 py-2 rounded-md focus:ring-2 focus:ring-green-400">
                    <option value="">Sélectionner un spécialiste</option>
                    <?php foreach ($medecins as $medecin): ?>
                        <option value="<?= htmlspecialchars($medecin['id_medecin']); ?>">
                            <?= htmlspecialchars($medecin['nom'] . " " . $medecin['prenom'] . " - " . $medecin['domaine']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Boutons -->
            <div class="flex justify-between">
                <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-green-700 transition">
                    Envoyer
                </button>
                <button type="reset"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-gray-700 transition">
                    Annuler
                </button>
            </div>
        </form>
    </div>

</body>
</html>
