<?php
session_start();
include('includes/db.php');  

$pseudo = $_POST['pseudo'] ?? '';  
$email = $_POST['email'] ?? '';    
$motDePasse = $_POST['motDePasse'] ?? '';    

if (empty($pseudo) || empty($email) || empty($motDePasse)) {
    echo '<script>alert("Tous les champs sont obligatoires."); window.location.href = "index.php";</script>';
    exit;
}

$collection = $db->users; 

$utilisateurExistant = $collection->findOne(['$or' => [['pseudo' => $pseudo], ['email' => $email]]]);

if ($utilisateurExistant) {
    echo '<script>alert("Un utilisateur avec ce pseudo ou email existe déjà."); window.location.href = "index.php";</script>';
    exit;
}

$motDePasseHashe = password_hash($motDePasse, PASSWORD_BCRYPT);

$nouvelUtilisateur = [
    'pseudo' => $pseudo,
    'email' => $email,
    'motDePasse' => $motDePasseHashe,
];

$collection->insertOne($nouvelUtilisateur);

$_SESSION['pseudo'] = $pseudo;
$_SESSION['email'] = $email;

header('Location: home.php');
exit;
?>
