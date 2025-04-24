<?php
$servername = "localhost";
$username = "root";
$password = "0000";
$database = "myDB";

try {
    // Connexion au serveur MySQL
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Création du schéma (base de données) si elle n'existe pas
    $sql = "CREATE DATABASE IF NOT EXISTS $database";
    $conn->exec($sql);

    // Connexion à la base de données nouvellement créée
    $conn->exec("USE $database");

    // Création de la table 'users' si elle n'existe pas
    $tableQuery = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL
    )";
    $conn->exec($tableQuery);

    // Vérification si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe

        // Préparation de la requête d'insertion
        $insertQuery = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        // Exécution de la requête
        $stmt->execute();
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription</title>
    <style>
                body {
            font-family: Arial, sans-serif;
            background: #6a11cb; /* Couleur de secours */
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            margin: 0;
            padding: 20px; /* Ajout d'un espacement */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
            min-width: 300px; /* Largeur minimale */
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        
        form {
            display: flex;
            flex-direction: column;
        }
        
        label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
        }
        
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #6a11cb;
            outline: none;
            box-shadow: 0 0 5px rgba(106, 17, 203, 0.5);
        }
        
        button {
            padding: 12px;
            background-color: #6a11cb;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        button:hover {
            background-color: #4e0d9b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ajouter un utilisateur</h1>
        <form method="POST" action="">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>
</html>