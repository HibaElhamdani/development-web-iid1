<?php
$servername = "localhost";
$username = "root";
$password = "0000";
$database = "myDB";

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Suppression d'un enregistrement si l'ID est passé dans l'URL
    if (isset($_GET['delete_id'])) {
        $deleteId = intval($_GET['delete_id']);
        $deleteQuery = "DELETE FROM users WHERE id = :id";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(':id', $deleteId, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: register.php");
        exit();
    }

    // Mise à jour d'un enregistrement si le formulaire est soumis
    if (isset($_POST['update'])) {
        $updateId   = intval($_POST['update_id']);
        $newName    = $_POST['name'];
        $newEmail   = $_POST['email'];
        $newPassword= $_POST['password'];

        $updateQuery = "UPDATE users 
                        SET name = :name, email = :email, password = :password 
                        WHERE id = :id";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bindParam(':name', $newName);
        $updateStmt->bindParam(':email', $newEmail);
        $updateStmt->bindParam(':password', $newPassword);
        $updateStmt->bindParam(':id', $updateId, PDO::PARAM_INT);
        $updateStmt->execute();

        header("Location: register.php");
        exit();
    }

    // Préparation des données pour le formulaire de modification
    $editUser = null;
    if (isset($_GET['edit_id'])) {
        $editId = intval($_GET['edit_id']);
        $editStmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $editStmt->bindParam(':id', $editId, PDO::PARAM_INT);
        $editStmt->execute();
        $editUser = $editStmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupération des données de la table 'users'
    $selectQuery = "SELECT * FROM users";
    $stmt = $conn->query($selectQuery);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 1000px;
            overflow-x: auto;
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        thead {
            background-color: #6a11cb;
            color: #fff;
        }

        th, td {
            padding: 15px;
            border: 1px solid #ddd;
        }

        tbody tr:nth-child(even) {
            background-color: #f3f3f3;
        }

        tbody tr:hover {
            background-color: #e1f0ff;
            transition: background-color 0.3s ease;
        }

        .delete-btn {
            background-color: #ff4a6e;
            color: white;
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .delete-btn:hover {
            background-color: #e6003a;
        }

        .edit-btn {
            background-color: #00b894;
            color: white;
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .edit-btn:hover {
            background-color: #008f6b;
        }

        .update-btn {
            background-color: #0984e3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .update-btn:hover {
            background-color: #065a97;
        }

        /* Séparation des boutons Modifier et Supprimer */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        @media screen and (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead tr { display: none; }
            tbody tr {
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 10px;
                background-color: #f9f9f9;
            }
            td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }
            td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 45%;
                font-weight: bold;
                text-align: left;
                color: #333;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Liste des utilisateurs</h1>
        <?php if ($editUser): ?>
            <h2>Modifier l'utilisateur #<?= htmlspecialchars($editUser['id']) ?></h2>
            <form method="post" action="register.php">
                <input type="hidden" name="update_id" value="<?= htmlspecialchars($editUser['id']) ?>">
                <p>
                    <label>Nom:<br>
                        <input type="text" name="name" value="<?= htmlspecialchars($editUser['name']) ?>" required>
                    </label>
                </>
닌
                <p>
                    <label>Email:<br>
                        <input type="email" name="email" value="<?= htmlspecialchars($editUser['email']) ?>" required>
                    </label>
                </p>
                <p>
                    <label>Mot de passe:<br>
                        <input type="text" name="password" value="<?= htmlspecialchars($editUser['password']) ?>" required>
                    </label>
                </p>
                <p>
                    <button type="submit" name="update" class="update-btn">Mettre à jour</button>
                    <a href="register.php" class="edit-btn">Annuler</a>
                </p>
            </form>
            <hr>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Mot de passe</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td data-label="ID"><?= htmlspecialchars($user['id']) ?></td>
                            <td data-label="Nom"><?= htmlspecialchars($user['name']) ?></td>
                            <td data-label="Email"><?= htmlspecialchars($user['email']) ?></td>
                            <td data-label="Mot de passe"><?= htmlspecialchars($user['password']) ?></td>
                            <td data-label="Action">
                                <div class="action-buttons">
                                    <a class="edit-btn" href="register.php?edit_id=<?= $user['id'] ?>">Modifier</a>
                                    <a class="delete-btn" href="register.php?delete_id=<?= $user['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Aucun utilisateur trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
