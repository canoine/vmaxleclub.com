<?php

$error_message = "Aucune donn&eacute;e re&ccedil;ue.";

if(isset($_POST['envoi_mail'])) {
    $email_to = "contact@vmaxleclub.com";
    $email_subject = "[Vmax le Club] Formulaire de contact";
	$error_message = "";

    // Champ non vide -> robot -> poubelle
    if(!empty($_POST['pg_email'])) {
		header('Location: /');
		die();
    }
    // Sinon, champ vide -> pas bien
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
		$error_message .= 'Vous n’avez vraiment rien &agrave; dire ?<br />';
    }

	if(empty($error_message)) {
		// On a tous les champs voulus
		$nom			= $_POST['nom'];
		$prenom 		= $_POST['prenom'];
		$email_addr		= $_POST['email'];
		$emessage		= $_POST['message'];

		// Quelques tests de forme
		$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
		$string_exp = "/^[\pL\pM\p{Zs}.-]+$/u";
		$number_exp = "/^[0-9]+$/";
		$tel_exp = "/^\+?[0-9]+$/";

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
			// URLs -> poubelle
			if(preg_match('/(http|https|ftp):\/\//', $emessage)) {
				header('Location: /');
				die();
			}
			// Chteumeuleu -> poubelle
			if(preg_match('/MIME-Version:|Content-Type:|Content-Transfer-Encoding:|href=/', $emessage)) {
				header('Location: /');
				die();
			}
			// Champs email -> poubelle
			if(preg_match('/cc:|to:/', $emessage)) {
				header('Location: /');
				die();
			}

			$email_message  = "Nom : ".$prenom." ".$nom."\n";
			$email_message .= "Email : ".$email_addr."\n";
			$email_message .= "--\n";
			$email_message .= $emessage."\n";

			// create email headers
			$headers =	'From: '.$email_to."\r\n".
						'Reply-to: '.$email_addr."\r\n".
						'Content-Type: text/plain; charset=utf-8'."\r\n" .
						'X-Mailer: PHP/' . phpversion();
			if (mail($email_to, $email_subject, $email_message, $headers)) {
				header('Location: contact_mail_ok.html');
				die();
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
		<meta name="description" content="Vmax Le Club, club d&eacute;di&eacute; aux Yamaha 1200 et 1700 Vmax. Retrouvez ici toutes les informations sur la moto et le club : forum, activit&eacute;s, sorties, entretien m&eacute;canique, accessoires, etc." />
		<meta name="abstract" content="Vmax Le Club, Vmax, Yamaha, Vmax 1200, Vmax 1700, club Vmax, balades, groupes de passionn&eacute;s de vmax, Vmax 2009 new Vmax, Yamaha Vmax, goodies, calendrier de activit&eacute;s, articles vmax, galerie photos de la vmax, meeting vmax, concentration, vmax, tutoriels vmax" />
		<meta name="reply-to" content="contact@vmaxleclub.com" />

		<link rel="shortcut icon" href="/favicon.ico" />
		<link type="text/css" rel="stylesheet" href="/fichiers/css.css" />
		<link type="text/css" rel="stylesheet" href="/fichiers/adherer.css" />

		<style nonce="contsq27yAOIvW5T4uRjMcUoHdFzTFCX">
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

			<!-- Bloc Donn&eacute;es -->
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
							<a href="./" class="retour">Retour &agrave; l’accueil</a>
						</span>
					</div>
				</div>
			</div>

			<!-- Bloc bas de page -->
			<div class="bloc_bas_page">
				<div class="bloc_bas_page_gris">
					<span class="bas_page">
						Vmax le Club
						-
						Association loi 1901
						-
						<a href="/contact-club-vmax.html">Contact</a>
						-
						<a href="/mentions-legales.html">Mentions l&eacute;gales</a>
					</span>
				</div>
			</div>
			<!-- Bas de page forc&eacute; -->
			<div class="bas_page">
				<a>&nbsp;</a>
			</div>
		</div>
	</body>
</html>
