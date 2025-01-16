<?php
session_start();

include('includes/db.php');

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $response = [];
    
    $artistes = $query 
        ? $db->artistes->find(['artist_mb' => new MongoDB\BSON\Regex($query, 'i')]) 
        : $db->artistes->find();

    foreach ($artistes as $artiste) {
        $response[] = [
            'artist_mb' => $artiste['artist_mb'],
            'listeners_lastfm' => $artiste['listeners_lastfm'],
            'spotify' => $artiste['spotify'] ?? null,
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$searchQuery = $_GET['search'] ?? '';

$artistes = [];
if ($searchQuery) {
    $artistes = $db->artistes->find(
        ['artist_mb' => new MongoDB\BSON\Regex($searchQuery, 'i')]
    );
} else {
    $artistes = $db->artistes->find(); 
}

$musiques = $db->musique->find();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoSpotify</title>
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
        }

        .section-title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .section-content {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            list-style-type: none; 
            padding: 0;
        }

        .card {
            background-color: #333;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            color: white;
        }

        .card h3 {
            margin: 10px 0;
            color: white; 
        }

        .card h3 a {
            color: white; 
            text-decoration: none; 
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1db954;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .footer {
            background-color: #1a1a1a;
            padding: 20px;
            text-align: center;
            color: #888;
        }

        .audio-player {
            margin-top: 10px;
        }

        .play-button {
            display: inline-block;
            padding: 8px 15px;
            background-color: #1db954;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .play-button:hover {
            background-color: #1a1a1a; 
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="home.php">NoSpotify</a>
        <div class="profile">
            <span>Bienvenue, <?php echo htmlspecialchars($_SESSION['pseudo']); ?> |<a href="deconnexion.php">Déconnexion</a></span>
        </div>
    </div>

    <div class="container">
        <form method="get" action="home.php" id="search-form">
            <input type="text" id="search-bar" class="search-bar" placeholder="Rechercher un artiste..." value="<?php echo htmlspecialchars($searchQuery); ?>">
        </form>

        <section>
            <h2 class="section-title">Top Artistes</h2>
            <ul id="result-list" class="section-content">
                <?php foreach ($artistes as $artiste) : ?>
                    <li class="card">
                        <h3><?php echo htmlspecialchars($artiste['artist_mb']); ?></h3>
                        <p><strong>Auditeurs:</strong> <?php echo number_format($artiste['listeners_lastfm']); ?></p>
                        <p><strong>Pays:</strong> <?php echo htmlspecialchars($artiste['country_mb']); ?></p>
                        <?php if (!empty($artiste['spotify'])) : ?>
                            <a href="<?php echo htmlspecialchars($artiste['spotify']); ?>" target="_blank" class="button">Voir sur Spotify</a>
                        <?php else : ?>
                            <p><em>Pas de lien Spotify disponible</em></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section>
            <h2 class="section-title">Musiques</h2>
            <ul id="musique-list" class="section-content">
                <?php foreach ($musiques as $musique) : ?>
                    <li class="card">
                        <h3>
                            <a href="play_music.php?id=<?php echo $musique['_id']; ?>">
                                <?php echo htmlspecialchars($musique['title']); ?>
                            </a>
                        </h3>
                        <a href="play_music.php?id=<?php echo $musique['_id']; ?>" class="button play-button">Play</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

    </div>

    <div class="footer">
        <p>&copy; 2025 NoSpotify. Tous droits réservés.</p>
    </div>

    <script src="index.js"></script>
</body>
</html>
