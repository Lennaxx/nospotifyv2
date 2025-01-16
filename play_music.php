<?php
session_start();

if (!isset($_SESSION['pseudo']) || !isset($_SESSION['email'])) {
    header('Location: connexion.php');
    exit;
}

$pseudo = $_SESSION['pseudo'];  
$email = $_SESSION['email'];   

include('includes/db.php');

$musiqueId = $_GET['id'] ?? ''; 

if ($musiqueId) {
    $musique = $db->musique->findOne(['_id' => new MongoDB\BSON\ObjectId($musiqueId)]);
}

if (!$musique) {
    echo "Musique introuvable.";
    exit;
}

$musiqueTitle = $musique['title'];

$filePath = 'musics/' . $musiqueTitle . '.mp3';

if (!file_exists($filePath)) {
    echo "Fichier audio introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecture - NoSpotify</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: #121212;
            color: white;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .navbar {
            background-color: #1db954;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
        }

        .container {
            flex-grow: 1;
            padding: 20px;
            text-align: center;
        }

        .audio-player {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="home.php">NoSpotify</a>
        <div class="profile">
            <span>Bienvenue, <?php echo htmlspecialchars($pseudo); ?> |<a href="deconnexion.php">Déconnexion</a></span>
        </div>
    </div>

    <div class="container">
        <h2>Lecture de la musique : <?php echo htmlspecialchars($musique['title']); ?></h2>
        
        <!-- Lecteur MP3 -->
        <audio controls class="audio-player">
            <source src="<?php echo htmlspecialchars($filePath); ?>" type="audio/mp3">
            Votre navigateur ne prend pas en charge l'élément audio.
        </audio>
    </div>

</body>
</html>
