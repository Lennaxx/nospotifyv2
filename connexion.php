<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoSpotify Home</title>

    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="main">
        <div class="container d-flex align-items-center justify-content-between vh-100">
            <!-- Left Section -->
            <div class="left-section d-flex align-items-center">
                <img src="./images/spotifylogo.png" alt="Spotify Logo" style="height: 60px; margin-right: 15px;">
                <h1 class="text-success">NoSpotify</h1>
            </div>

            <!-- Right Section -->
            <div class="right-section">
                <form class="form-box-index" action="verifconnexion.php" method="post">
                    <header>Connexion</header>
                    <div class="input-box">
                        <input type="text" name="pseudo" placeholder="Pseudo" required>
                    </div>
                    <div class="input-box">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-box">
                        <input type="password" name="motDePasse" placeholder="Mot de passe" required>
                    </div>
                    <div class="deja">
                        <p>Pas encore inscrit ? <a href="index.php">Inscription</a></p>
                    </div>
                    <div class="input-box-submit" onclick="index.php">
                        <input type="submit" value="Commencez">
                    </div>
                </form>
            </div>
         </div>
    </div>
    <footer>
        <p>&copy; 2024 NoSpotify. Tous droits réservés.</p>
    </footer>
</body>
</html>
