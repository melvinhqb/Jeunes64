<?php
    session_start();

    // Vérifier si l'email de l'utilisateur est défini dans la session
    if (!isset($_SESSION['email'])) {
        // Rediriger vers la page de connexion s'il n'est pas connecté
        header("Location: login.php");
        exit();
    }

    $email = $_SESSION['email'];
    $file = 'users.json';
    $data = file_get_contents($file);
    $users = json_decode($data, true);
    $userData = json_decode(file_get_contents($users[$email]), true);

    // Fonction pour supprimer une demande de référence du fichier JSON
    function removeReference($referenceKey, &$userData) {
        if (isset($userData['references']) && !empty($userData['references'])) {
            if (array_key_exists($referenceKey, $userData['references'])) {
                unset($userData['references'][$referenceKey]);
                return true;
            }
        }
        return false;
    }

    // Vérifier si une demande de référence doit être supprimée
    if (isset($_GET['remove']) && !empty($_GET['remove'])) {
        $referenceKey = $_GET['remove'];
        $removed = removeReference($referenceKey, $userData);
        if ($removed) {
            // Enregistrer les données utilisateur mises à jour dans le fichier JSON
            file_put_contents($users[$email], json_encode($userData));
            // Rediriger vers la même page pour refléter les modifications
            header("Location: references.php");
            exit();
        }
    }
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
				<li class="nav-item consultant"><a class="nav-link" href="search_user.php">Consultant</a></li>
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
					<li class="subnav-item active"><a class="subnav-link" href="references.php">Demande de référence</a></li>
					<li class="subnav-item"><a class="subnav-link" href="create_cv.php">Mon CV</a></li>
				</ul>
			</div>
		</div>
		<div class="medium-container">
			<div class="title-btn">
				<h1 class="main-title">Demandes de référence</h1>
				<p class="text"><a href="new_ref.php" class="link-btn"><i class="fa-solid fa-plus"></i> Nouvelle demande</a></p>
			</div>

			<?php
				echo "<h2 class='subtitle'>Demandes en attente</h2>";
				if (isset($userData['references']) && !empty($userData['references'])) {
					$references = array_reverse($userData['references']);

					$count = 0;
					foreach ($references as $ref) {
						if ($ref['verif'] == 0) {
							$count = 1;
							break;
						}
					}

					if ($count == 0) {
						echo "<div class='alert alert-info alert-white rounded'>
								<div class='icon'><i class='fa fa-info-circle'></i></div>
								Pas de références en attente
							</div>";
					}

					foreach ($references as $key => $reference) {
						// Récupérer la valeur de 'verif'
						$verif = $reference['verif'];
						$refBirth = $reference['birth'];
						$refBirth_formattee = date("d M Y", strtotime($refBirth));

						if ($verif == 0) {
							?>
							<div class="box orange">
								<div class="reference-status">
									<div class="reference-header">
										<h3>Demande de référence à <?php echo $reference['firstname'] . ' ' . $reference['lastname']; ?></h3>
										<div class="reference-info">
											<p class="legend">Milieu de l'engagement : <?php echo $reference['commitment-type']; ?></p>
											<p class="legend">Durée : <?php echo $reference["period"]; ?> mois</p>
										</div>
									</div>
									<span><i class="fa-solid fa-clock color-icn orange"></i></span>
								</div>
								<div class="two-columns">
									<div class="young-col column">
										<p><?php echo $reference["description"]; ?></p>
									</div>
									<div class="column referent">
										<h4>Informations référent</h4>
										<div class="ref-info">
											<span><i class="fa-solid fa-cake-candles color-icn"></i> <?php echo $refBirth_formattee; ?></span>
											<span><i class="fa-solid fa-at color-icn"></i> <?php echo $reference["email"]; ?></span>
											<span><i class="fa-solid fa-phone color-icn"></i> <?php echo $reference["tel"]; ?></span>
										</div>
									</div>
								</div>
								<div class="two-columns">
									<div class="column">
										<h4>Je suis...</h4>
										<div class="inline-skills">
											<?php
											foreach ($reference['skills'] as $skill) {
												if ($skill["value"] == "on") {
													echo '<div class="pill"><span>' . $skill["name"] . '</span></div>';
												}
											}
											?>
										</div>
									</div>
									<div class="column referent">
									</div>
								</div>
								<div class="del-btn">
									<a href="#" class="delete-link" onclick="confirmDeletion('<?php echo $key; ?>')"><i class="fa-solid fa-trash"></i></a>
								</div>
							</div>
							<?php
						}
					}
				} else {
					echo "<div class='alert alert-info alert-white rounded'>
							<div class='icon'><i class='fa fa-info-circle'></i></div>
							Pas de références en attente
						</div>";
				}

				echo "<h2 class='subtitle'>Demandes validées</h2>";
				if (isset($userData['references']) && !empty($userData['references'])) {
					$references = array_reverse($userData['references']);

					$count = 0;
					foreach ($references as $ref) {
						if ($ref['verif'] == 1) {
							$count = 1;
							break;
						}
					}

					if ($count == 0) {
						echo "<div class='alert alert-info alert-white rounded'>
							<div class='icon'><i class='fa fa-info-circle'></i></div>
							Pas de références validées
						</div>";
					}

					foreach ($references as $key => $reference) {
						// Récupérer la valeur de 'verif'
						$verif = $reference['verif'];
						$refBirth = $reference['birth'];
						$refBirth_formattee = date("d M Y", strtotime($refBirth));

						if ($verif == 1) {
							?>
							<div class="box green">
								<div class="reference-status">
									<div class="reference-header">
										<h3>Demande de référence à <?php echo $reference['firstname'] . ' ' . $reference['lastname']; ?></h3>
										<div class="reference-info">
											<p class="legend">Engagement : <?php echo $reference['commitment-type']; ?></p>
											<p class="legend">Durée : <?php echo $reference["period"]; ?> mois</p>
										</div>
									</div>
									<span><i class="fa-solid fa-circle-check color-icn green"></i></span>
								</div>
								<div class="two-columns">
									<div class="young-col column">
										<p><?php echo $reference["description"]; ?></p>
									</div>
									<div class="column referent">
										<h4>Informations référent</h4>
										<div class="ref-info">
											<span><i class="fa-solid fa-cake-candles color-icn"></i> <?php echo $refBirth_formattee; ?></span>
											<span><i class="fa-solid fa-at color-icn"></i> <?php echo $reference["email"]; ?></span>
											<span><i class="fa-solid fa-phone color-icn"></i> <?php echo $reference["tel"]; ?></span>
										</div>
										<span></span>
									</div>
								</div>
								<div class="two-columns">
									<div class="column">
										<h4>Je suis...</h4>
										<div class="inline-skills">
											<?php
											foreach ($reference['skills'] as $skill) {
												if ($skill["value"] == "on") {
													echo '<div class="pill"><span>' . $skill["name"] . '</span></div>';
												}
											}
											?>
										</div>
									</div>
									<div class="column referent">
										<h4>Je confirme qu'il (elle) est...</h4>
										<div class="inline-skills">
											<?php
											foreach ($reference['skills'] as $skill) {
												if ($skill["refValue"] == "on") {
													echo '<div class="pill"><span>' . $skill["name"] . '</span></div>';
												}
											}
											?>
										</div>
									</div>
								</div>
								<div>
									<h4>Commentaire du référent</h4>
									<p class="box-text"><?php echo $reference['refComment']; ?></p>
								</div>
								<div class="del-btn">
									<a href="#" class="delete-link" onclick="confirmDeletion('<?php echo $key; ?>')"><i class="fa-solid fa-trash"></i></a>
								</div>
							</div>
							<?php
						}
					}
				} else {
					echo "<div class='alert alert-info alert-white rounded'>
							<div class='icon'><i class='fa fa-info-circle'></i></div>
							Pas de références validées
						</div>";
				}
			?>
		</div>
	</section>

	<script>
		function confirmDeletion(referenceKey) {
			if (confirm("Êtes-vous sûr de vouloir supprimer cette demande de référence ?")) {
				// L'utilisateur a confirmé la suppression, effectuer l'action
				window.location.href = 'references.php?remove=' + referenceKey;
			}
		}
	</script>

</body>
</html>