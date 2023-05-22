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

    if (isset($_POST['references'])) {
        $selectedReferences = $_POST['references'];
        /*
        // Parcours des références sélectionnées
        foreach ($selectedReferences as $selectedKey) {
            echo 'La référence avec la clé ' . $selectedKey . ' est sélectionnée.<br>';
            // Faites ce que vous souhaitez avec chaque $selectedKey
        }
        */
    } else {
        header("Location: create_cv.php");
    }

?>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
</head>
<body>
    <section class="mycv">
        <div class="cv-btn hide-on-print">
            <button id="pdfButton">Télécharger en PDF</button>
            <button onclick="window.print();return false;">Imprimer</button>
        </div>
        <div class="medium-container mycv-page" id="cv">
            <h1 class="main-title"><?php echo $userData["firstname"]." ".$userData["lastname"];?></h1>
            <h2 class="subtitle">Informations personelles</h2>
            <div class="ref-info young">
                <p><i class="fa-solid fa-cake-candles color-icn"></i> <?php echo date("d M Y", strtotime($userData['birth'])); ?></p>
                <p><i class="fa-solid fa-at color-icn"></i> <?php echo $userData['email']; ?></p>
                <p><i class="fa-solid fa-phone color-icn"></i> <?php echo $userData['tel']; ?></p>
            </div>
            <h2 class="subtitle">Références validées</h2>
            <?php
                foreach ($selectedReferences as $key) {
                    $reference = $userData["references"][$key];
                    $refBirth = $reference['birth'];
                    $refBirth_formattee = date("d M Y", strtotime($refBirth));

                    echo '
                    <div class="box green" style="page-break-inside: avoid;">
                        <div class="reference-status">
                            <div class="reference-header">
                                <h3>Demande de référence à '.$reference['firstname'].' '.$reference['lastname'].'</h3>
                                <div class="reference-info">
                                    <p class="legend">Engagement : '.$reference['commitment-type'].'</p>
                                    <p class="legend">Durée : '. $reference["period"] .' mois</p>
                                </div>
                            </div>
                            <span><i class="fa-solid fa-circle-check color-icn green"></i></span>
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
                            <div class="column young">
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
                    </div>
                    ';
                }
            ?>
        </div>   
    </section>
    <script>
    // Attacher l'événement de clic au bouton
    document.getElementById('pdfButton').addEventListener('click', generatePDF);

    // Fonction pour générer le PDF à partir de la page HTML
    function generatePDF() {
      const element = document.querySelector('.mycv-page');

      html2pdf()
        .from(element)
        .save('moncv_jeunes64.pdf');
    }
  </script>
</body>
</html>