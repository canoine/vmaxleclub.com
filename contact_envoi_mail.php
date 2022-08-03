<?php

$error_message = "Aucune donn&eacute;e re&ccedil;ue.";

if(isset($_POST['envoi_mail'])) {

    $email_to = "contact@vmaxleclub.com";
    $email_subject = "[Vmax le Club] Formulaire de contact";

	$error_message = "";

    // validation expected data exists
    if(empty($_POST['nom'])) {
		$error_message .= 'Vous devez indiquer votre nom.<br />';
    }
    if(empty($_POST['prenom'])) {
		$error_message .= 'Vous devez indiquer votre pr&eacute;nom.<br />';
    }
    if(empty($_POST['email'])) {
		$error_message .= 'Vous devez indiquer votre adresse email.<br />';
    }
    if(empty($_POST['message'])) {
		$error_message .= 'Vous n’avez rien à dire ?<br />';
    }

	if(empty($error_message)) {

		// On a tous les champs voulus
		$nom			= $_POST['nom'];
		$prenom 		= $_POST['prenom'];
		$email_addr		= $_POST['email'];
		$emessage		= $_POST['message'];

		$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
		//$string_exp = "/^[A-Za-z .'-]+$/";
		$string_exp = "/^[\pL\pM\p{Zs}.-]+$/u";
		$number_exp = "/^[0-9]+$/";
		$tel_exp = "/^\+?[0-9]+$/";


		// Quelques tests de forme
		if(!preg_match($email_exp,$email_addr)) {
			$error_message .= 'Votre adresse email semble invalide.<br />';
		}

		if(!preg_match($string_exp,$nom)) {
			$error_message .= 'Votre nom semble invalide.<br />';
		}
		if(!preg_match($string_exp,$prenom)) {
			$error_message .= 'Votre pr&eacute;nom semble invalide.<br />';
		}

		if(empty($error_message)) {
			function clean_string($string) {
				$bad = array("content-type","bcc:","to:","cc:","href");
				return str_replace($bad,"",$string);
			}

			$email_message  = "Bonjour,\n\nCoordonnées fournies par le demandeur :\n\n";
			$email_message .= "Prénom : ".clean_string($prenom)."\n";
			$email_message .= "--\n";
			$email_message .= "Message : ".clean_string($emessage)."\n";

			// create email headers
			$headers =	'From: '.$email_addr."\r\n".
						'Content-Type: text/plain; charset=utf-8'."\r\n" .
						'X-Mailer: PHP/' . phpversion();
			if (mail($email_to, $email_subject, $email_message, $headers)) {
				header('Location: contact_mail_ok.html');
			}
			$error_message .= 'Donn&eacute;es non envoy&eacute;es.<br />';
		}
	}
}
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="Vmax Le Club, club dédié aux Yamaha 1200 et 1700 Vmax. Retrouvez ici toutes les informations sur la moto et le club : forum, activités, sorties, entretien mécanique, accessoires, etc." />
		<meta name="abstract" content="Vmax Le Club, Vmax, Yamaha, Vmax 1200, Vmax 1700, club Vmax, balades, groupes de passionnés de vmax, Vmax 2009 new Vmax, Yamaha Vmax, goodies, calendrier de activités, articles vmax, galerie photos de la vmax, meeting vmax, concentration, vmax, tutoriels vmax" />
		<meta name="reply-to" content="contact@vmaxleclub.com" />

		<link rel="shortcut icon" href="/favicon.ico" />
		<link type="text/css" rel="stylesheet" href="/fichiers/css.css" />
		<link type="text/css" rel="stylesheet" href="/fichiers/adherer.css" />

		<style type="text/css" nonce="cont7Loh7B1WF38Y">
			div.container {
				min-height: 802px;
			}
			div.bloc_donnees {
				height: 600px;
			}
			div.donnees_titre {
				top: 150px;
			}
		</style>

		<title>Vmax Le Club - Nous contacter</title>

	</head>

	<body>
		<div class="container">

			<!-- Titre -->
			<div class="bloc_titre">
				<div>
					<a href="/"><img src="/fichiers/crbst_newlogo00.png" alt="Accueil Vmax le Club"></a>
				</div>
				<div>
					<a href="/"><img src="/fichiers/wa_238fcwflhbfo4m_text.png" alt="Accueil Vmax le Club"></a>
				</div>
			</div>

			<!-- Bloc Données -->
			<div class="bloc_donnees">
				<div class="bloc_donnees_gris">
					<div class="donnees_titre">
						<span class="donnees_titre">
							Erreurs d&eacute;tect&eacute;es dans les donn&eacute;es envoy&eacute;es :
						</span>
						<span class="donnees_erreurs">
							<br /><br /><br />
							<?php
								echo nl2br($error_message);
							?>
							<br /><br />
							<a href="./" class="retour">Retour à l'accueil</a>
						</span>
					</div>
				</div>
			</div>

			<!-- Bloc bas de page -->
			<div class="bloc_bas_page">
				<div class="bloc_bas_page_gris">
					<span class="bas_page">
						Vmax le Club - Association loi 1901
						-
						<a href="/contact-club-vmax.html">Contact</a>
						-
						<a href="/mentions-legales.html">Mentions légales</a>
					</span>
				</div>
			</div>
			<!-- Bas de page forcé -->
			<div class="bas_page">
				<a>&nbsp;</a>
			</div>
		</div>
	</body>
</html>
</html>