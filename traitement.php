<?php
// traitement.php

// Récupérer les données du formulaire
$nom = htmlspecialchars($_POST['nom']);
$email = htmlspecialchars($_POST['email']);
$motDePasse = password_hash($_POST['motDePasse'], PASSWORD_DEFAULT); // Toujours hacher les mots de passe


// Informations de connexion à la base de données
$host = 'localhost'; // Adresse du serveur (ou 127.0.0.1)
$dbname = 'fleursm'; // Nom de ta base de données
$username = 'root'; // Nom d'utilisateur MySQL
$password = ''; // Mot de passe MySQL

try {
    // Connexion à MySQL avec PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparation de la requête SQL
    $sql = "INSERT INTO utilisateurs (nom, email, motDePasse) VALUES (:nom, :email, :motDePasse)";
    $stmt = $conn->prepare($sql);

    // Exécution de la requête avec les valeurs des champs
    $stmt->execute([
        ':nom' => $nom,
        ':email' => $email,
        ':motDePasse' => $motDePasse
    ]);


    echo "Données enregistrées avec succès !";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>