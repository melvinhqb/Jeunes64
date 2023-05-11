
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeunes 6.4</title>
    <link rel="icon" href="assets/logo4.ico">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/9b3084e9e8.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="large-container">
            <div class="header-status">
                
            </div>
            <div class="header-body">
                <div class="header-logo">
                    <a href="home.php"><img src="assets/logo1.png" alt="Logo Jeunes 6.4"></a>
                </div>
                <div class="header-text">
                    <div class="header-slogan">
                        <h2 class="slogan">Pour faire de l'engagement une valeur</h2>
                    </div>
                </div>
            </div>
            <nav class="header-nav">
                <ul class="nav-list">
                <li class="nav-item young"><a class="nav-link" href="profil.php">Jeune</a></li>
                    <li class="nav-item referent"><a class="nav-link" href="referants.php">Référent</a></li>
                    <li class="nav-item consultant"><a class="nav-link" href="consultant.php">Consultant</a></li>
                    <li class="nav-item partner"><a class="nav-link" href="partners.php">Partenaires</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <h1 class="main-title">entrer votre code a 12 caractéres </h1>
            <form id="hashform" action="verif_hash.php" method="post">
                    <label for="register-lastname">hash</label>
                    <input type="text" id="hash" name="hash" required>
                    <button type="submit" class="btn">enter</button>
            </form>    
    </body>
</html>