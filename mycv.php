<!DOCTYPE html>
<html lang="fr">
	<head>
	    <meta charset="UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <title>Jeunes 6.4 - Mon CV</title>
	    <link rel="icon" href="assets/logo4.ico">
	    <link rel="stylesheet" href="style.css">
	    <script src="https://kit.fontawesome.com/9b3084e9e8.js" crossorigin="anonymous"></script>
	</head>

	<body id="mycv">
        <?php
            function IsSetFile($variable) {
                if(isset($variable)) {
                    return 1;
                } else {
                    echo "Erreur lors de la lecture d'un fichier JSON.";
                    exit();
                }
            }
        
            
            if(isset($_POST['references'])) {
                $selectedReferences = $_POST['references'];
        
                $fileContentUsers = file_get_contents('users.json');
                $users = json_decode($fileContentUsers, true);
        
                // Parcours des références sélectionnées
                foreach($selectedReferences as $selectedKey) {
                    echo '<section>
                            <div class="medium-container">
                                <h2 class="subtitle">Demande de référence</h2>
                                <p>La référence avec la clé ' . $selectedKey . ' est sélectionnée.</p>
                                <div class="row-cards">
                                    <div class="card">
                                        <span class="card__step-number card__step-number-1"><h1>JEUNE</h1></span>
                    ';
                    if(IsSetFile($users)) {
                        foreach($users as $email => $userData) {
                            $fileContentSoleUser = file_get_contents($userData);
                            $sole_user = json_decode($fileContentSoleUser, true);
                            
                            if(IsSetFile($sole_user)) {
                                foreach($sole_user['references'] as $key => $data) {
                                    $young_quality = "";
                                    $referent_quality = "";
                                    foreach($data['skills'] as $quality => $statut) {
                                        if($statut['value'] == "on") {
                                            $young_quality .= $statut['name'] . ', ';
                                        }
                                        if($statut['refValue'] == "on") {
                                            $referent_quality .= $statut['name'] . ', ';
                                        }
                                    }
                                    // Supprimer la virgule à la fin des chaînes
                                    $referent_quality = rtrim($referent_quality, ', ');
                                    $young_quality = rtrim($young_quality, ', ');
                                    if($key == $selectedKey) {
                                        echo '<p class="card__unit-description">Prénom : ' . $sole_user['firstname'] . '</p>
                                                <p class="card__unit-description">Nom : ' . $sole_user['lastname'] . '</p>
                                                <p class="card__unit-description">email : ' . $sole_user['email'] . '</p>
                                                <p class="card__unit-description">Date de naissance : ' . $sole_user['birth'] . '</p>
                                                <p class="card__unit-description">Téléphone : ' . $sole_user['tel'] . '</p>
                                                <p class="card__unit-description">Engagement : ' . $data['commitment-type'] . ' (' . $data['period'] . ' mois)</p>
                                                <p class="card__unit-description">Commentaire : ' . $data['description'] . '</p>
                                                <p class="card__unit-description">Savoir-être : ' . $young_quality . '</p>
                                            </div>
                                        ';
                                        echo '<div class="card">
                                                <span class="card__step-number card__step-number-2"><h1>RÉFÉRENT</h1></span>
                                                <p class="card__unit-description">Prénom : '  . $data['firstname'] . '</p>
                                                <p class="card__unit-description">Nom : ' . $data['lastname'] . '</p>
                                                <p class="card__unit-description">email : ' . $data['email'] . '</p>
                                                <p class="card__unit-description">Date de naissance : ' . $data['birth'] . '</p>
                                                <p class="card__unit-description">Téléphone : ' . $data['tel'] . '</p>
                                                <p class="card__unit-description">Commentaire : ' . $data['refComment'] . '</p>
                                                <p class="card__unit-description">Savoir-être : ' . $referent_quality . '</p>
                                            </div>
                                        ';
                                    }
                                }
                            }
                        }
                        echo '  </div>
                            </div>
                        </section>
                        ';
                    }
                }
            } else { // Condition laissée dans le cas où l'on accèderait à la page manuellement.
                echo 'Aucunes références sélectionées';
                exit();
            }
        ?>
	</body>
</html>