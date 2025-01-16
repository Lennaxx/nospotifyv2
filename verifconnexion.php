<?php
session_start();
include('includes/db.php');  

$pseudo = $_POST['pseudo'] ?? '';  
$email = $_POST['email'] ?? '';    
$motDePasse = $_POST['motDePasse'] ?? '';    

$collection = $db->users; 

if (!empty($pseudo)) {
    $utilisateur = $collection->findOne(['pseudo' => $pseudo]);
} elseif (!empty($email)) {
    $utilisateur = $collection->findOne(['email' => $email]);
} else {
    echo '<script>alert("Veuillez entrer un pseudo ou un email."); window.location.href = "connexion.php";</script>';
    exit;
}

if ($utilisateur) {
    if (password_verify($motDePasse, $utilisateur['motDePasse'])) {
        $_SESSION['pseudo'] = $utilisateur['pseudo']; 
        $_SESSION['email'] = $utilisateur['email'];   
        // Ne pas stocker le mot de passe en session
        header('Location: home.php');
        exit;
    } else {
        echo '<script>alert("Mot de passe incorrect. Veuillez réessayer."); window.location.href = "connexion.php";</script>';
        exit;
    }
} else {
    echo '<script>alert("Aucun utilisateur trouvé avec ce pseudo ou email. Veuillez vérifier vos informations."); window.location.href = "connexion.php";</script>';
    exit;
}
?>
