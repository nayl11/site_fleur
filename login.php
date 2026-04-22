<?php
// traitement.php
session_start();

// Récupérer les données du formulaire
$nom = htmlspecialchars($_POST['nom']);
$motDePasseSaisi = $_POST['motDePasse']; // Récupération du mot de passe saisi

// Informations de connexion à la base de données
$host = 'localhost'; // Adresse du serveur (ou 127.0.0.1)
$dbname = 'fleursm'; // Nom de ta base de données
$username = 'root'; // Nom d'utilisateur MySQL
$password = ''; // Mot de passe MySQL

try {
    // Connexion à MySQL avec PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparation et exécution de la requête SQL
    $sql = "SELECT motDePasse FROM utilisateurs WHERE nom = :nom";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':nom' => $nom]);

    // Récupérer les informations utilisateur
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Vérification du mot de passe
        $motDePasseStocke = $user['motDePasse'];
        if (password_verify($motDePasseSaisi, $motDePasseStocke)) {
            header("Location: index.html"); 
            exit;
        } else {
            $_SESSION['message'] = "Mot de passe incorrect.";
            header("Location: formulaire.html");
            exit;
        }
    } else {
        $_SESSION['message'] = "Utilisateur non trouvé.";
        header("Location: formulaire.html");
        exit;
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    header("Location: login.php");
    exit;
}
?>