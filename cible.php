<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ind.php');
    exit;
}

// Fonctions utilitaires
function displayValue($fieldName) {
    return isset($_POST[$fieldName]) ? htmlspecialchars($_POST[$fieldName]) : '';
}

function isChecked($fieldName, $value) {
    return isset($_POST[$fieldName]) && is_array($_POST[$fieldName]) && in_array($value, $_POST[$fieldName]) ? 'checked' : '';
}

function isSelected($fieldName, $value) {
    return isset($_POST[$fieldName]) && $_POST[$fieldName] == $value ? 'selected' : '';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Données Enregistrées</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h1>Vos Données Enregistrées</h1>
        <form>
            <div class="form-group">
                <label for="firstname">Prénom:</label>
                <input type="text" id="firstname" name="firstname" value="<?= displayValue('firstname') ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="lastname">Nom:</label>
                <input type="text" id="lastname" name="lastname" value="<?= displayValue('lastname') ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= displayValue('email') ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="phone">Téléphone:</label>
                <input type="tel" id="phone" name="phone" value="<?= displayValue('phone') ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="gender">Genre:</label>
                <select id="gender" name="gender" disabled>
                    <option value="">Sélectionner</option>
                    <option value="male" <?= isSelected('gender', 'male') ?>>Masculin</option>
                    <option value="female" <?= isSelected('gender', 'female') ?>>Féminin</option>
                    <option value="other" <?= isSelected('gender', 'other') ?>>Autre</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Centres d'intérêt:</label>
                <div class="checkbox-group">
                    <input type="checkbox" id="sports" name="interests[]" value="sports" <?= isChecked('interests', 'sports') ?> disabled>
                    <label for="sports">Sports</label>
                    
                    <input type="checkbox" id="music" name="interests[]" value="music" <?= isChecked('interests', 'music') ?> disabled>
                    <label for="music">Musique</label>
                    
                    <input type="checkbox" id="reading" name="interests[]" value="reading" <?= isChecked('interests', 'reading') ?> disabled>
                    <label for="reading">Lecture</label>
                </div>
            </div>
            
            <div class="form-group">
                <label for="comments">Commentaires:</label>
                <textarea id="comments" name="comments" rows="4" readonly><?= displayValue('comments') ?></textarea>
            </div>
            
            <div class="form-group">
                <a href="ind.php" class="back-button">Retour au Formulaire</a>
            </div>
        </form>
    </div>
</body>
</html>