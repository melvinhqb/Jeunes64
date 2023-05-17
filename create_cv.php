<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header("Location: login.php");
        exit();
    }

    $email = $_SESSION['email'];
    $file = 'users.json';
    $data = file_get_contents($file);
    $users = json_decode($data, true);
    $userData = json_decode(file_get_contents($users[$email]), true);
?>

<!DOCTYPE html>
<html lang="fr">
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
		        <a href="logout.php" class="link" id="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</a>
		    </div>
		    <div class="header-body">
		        <div class="header-logo">
		            <a href="home.php"><img src="assets/logo1.png" alt="Logo Jeunes 6.4"></a>
		        </div>
		        <div class="header-text">
		                <h1 class="xl-title young">Jeune</h1>
		                <h2 class="slogan">Je donne de la valeur à mon engagement</h2>
		        </div>
		    </div>
		    <nav class="header-nav">
		        <ul class="nav-list">
		            <li class="nav-item young active"><a class="nav-link" href="profil.php">Jeune</a></li>
		            <li class="nav-item referent"><a class="nav-link" href="verif_hash.php">Référent</a></li>
		            <li class="nav-item consultant"><a class="nav-link" href="">Consultant</a></li>
		            <li class="nav-item partner"><a class="nav-link" href="partners.php">Partenaires</a></li>
		        </ul>
		    </nav>
		</div>
	    </header>

	    <section class="young">
		<div class="subnav">
		    <div class="medium-container">
		        <ul class="subnav-list">
		            <li class="subnav-item"><a class="subnav-link" href="profil.php">Mon profil</a></li>
		            <li class="subnav-item"><a class="subnav-link" href="references.php">Demandes de références</a></li>
                    <li class="subnav-item active"><a class="subnav-link" href="create_cv.php">Mon CV</a></li>
		        </ul>
		    </div>
		</div>
		<div class="medium-container">
            <h1 class="main-title">Curriculum vitae</h1>
            <h3 class="h3-description">Sélectionnez les références à intégrer à votre CV.</h3>
			<?php
                if(isset($userData['references']) && !empty($userData['references'])) {
                    $references = array_reverse($userData['references']);

                    $count = 0;
                    foreach ($references as $ref) {
                        if ($ref['verif'] == 1) {
                            $count += 1;
                        }
                    }

                    if ($count == 0) {
                        echo "<p class='text'>Pas de références validées</p>";
                    } else {
                        echo "<form action='mycv.php' method='post'>";
                    }

                    foreach ($references as $key => $reference) {
                        // Récupérer la valeur de 'verif'
                        $verif = $reference['verif'];
                        $refBirth = $reference['birth'];
                        $refBirth_formattee = date("d M Y", strtotime($refBirth));

                        if($verif == 1) {
                            echo '
                            <div class="box grey" id="cv-box">
                                <div class="reference-status">
                                    <div class="reference-header">
                                        <h3>Demande de référence à '.$reference['firstname'].' '.$reference['lastname'].'</h3>
                                        <div class="reference-info">
                                            <p class="legend">Engagement : '.$reference['commitment-type'].'</p>
                                            <p class="legend">Durée : '. $reference["period"] .' mois</p>
                                        </div>
                                    </div>
                                    <input class="checkmark green" type="checkbox" id="'.$key.'"name="references[]" value="'.$key.'">
                                </div>
                                <div class="two-columns">
                                    <div class="young-col column">
                                        <p>'. $reference["description"] .'</p>
                                    </div>
                                    <div class="column referent">
                                        <h4>Informations référent</h4>
                                        <div class="ref-info">
                                            <span><i class="fa-solid fa-cake-candles color-icn"></i> '. $refBirth_formattee .'</span>
                                            <span><i class="fa-solid fa-at color-icn"></i> '. $reference["email"] .'</span>
                                            <span><i class="fa-solid fa-phone color-icn"></i> '. $reference["tel"] .'</span>
                                        </div>
                                        <span></span>
                                    </div>
                                </div>
                                <div class="two-columns">
                                    <div class="column">
                                        <h4>Je suis...</h4>
                                        <div class="inline-skills">';

                                            foreach ($reference['skills'] as $skill) {
                                                if($skill["value"] == "on") {
                                                    echo '<div class="pill"><span>'.$skill["name"].'</span></div>';
                                                }
                                            }
                            echo '
                                        </div>
                                    </div>
                                    <div class="column referent">
                                        <h4>Je confirme qu\'il (elle) est...</h4>
                                        <div class="inline-skills">';
                                            foreach ($reference['skills'] as $skill) {
                                                if($skill["refValue"] == "on") {
                                                    echo '<div class="pill"><span>'.$skill["name"].'</span></div>';
                                                }
                                            }
                            echo '
                            </div>
                            </div></div>
                                <div>
                                    <h4>Commentaire du référent</h4>
                                    <p class="box-text">'.$reference['refComment'].'</p>
                                </div>
                                <div class="reference-id">
                                    <p class="legend">'.$key.'</p>
                                </div>
                            </div>';

                        } 					
                    }
                    if ($count != 0) {
                        echo '<div class="small-container">';
                        echo '<div class="center">';
                        echo '<button type="submit" class="btn">Ajouter au CV</button>';
                        echo '</div></div></form>';
                    }
                    
                } else {
                    echo "<p class='text'>Pas de références validées</p>";
                }

            ?>
		</div>
	    </section>
        <script>

            // Récupérer toutes les cases à cocher
            var checkboxes = document.getElementsByClassName('checkmark');

            // Parcourir toutes les cases à cocher
            for (var i = 0; i < checkboxes.length; i++) {

            // Ajouter un écouteur d'événements au changement de chaque case à cocher
            checkboxes[i].addEventListener('change', function() {
                // Récupérer le parent de la case à cocher
                var parentDiv = this.parentElement;

                // Vérifier si la case à cocher est cochée
                if (this.checked) {
                    // Parcourir les trois générations de parents
                    for (var j = 0; j < 3; j++) {

                        // Vérifier si le parent a l'ID "cv-box"
                        if (parentDiv.id === 'cv-box') {
                        // Ajouter la classe "green" et supprimer la classe "grey"
                        parentDiv.classList.add('green');
                        parentDiv.classList.remove('grey');
                        parentDiv.style.opacity = 1;
                        }

                        // Passer au parent suivant
                        parentDiv = parentDiv.parentElement;
                    }
                } else {
                    // Parcourir les trois générations de parents
                    for (var j = 0; j < 3; j++) {
                        // Vérifier si le parent a l'ID "cv-box"
                        if (parentDiv.id === 'cv-box') {
                        // Ajouter la classe "grey" et supprimer la classe "green"
                        parentDiv.classList.add('grey');
                        parentDiv.classList.remove('green');
                        parentDiv.style.opacity = 0.5;
                    }

                    // Passer au parent suivant
                    parentDiv = parentDiv.parentElement;
                }
                }
            });
            }
        </script>
	</body>
</html>