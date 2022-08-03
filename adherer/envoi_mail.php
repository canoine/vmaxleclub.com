<?php

$error_message = "Aucune donn&eacute;e re&ccedil;ue.
Veuillez remplir le formulaire en cliquant sur le lien ci-dessous.";

if(isset($_POST['envoi_mail'])) {
    $email_to = "bureau@vmaxleclub.com";
    $email_from = "contact@vmaxleclub.com";
    $email_subject = "[Vmax le Club] Nouvelle demande d'adhésion";
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
    if(empty($_POST['adresse'])) {
		$error_message .= 'Vous devez indiquer votre adresse postale.<br />';
    }
    if(empty($_POST['code_postal'])) {
		$error_message .= 'Vous devez indiquer votre code postal.<br />';
    }
    if(empty($_POST['ville'])) {
		$error_message .= 'Vous devez indiquer votre ville de r&eacute;sidence.<br />';
    }
    if(empty($_POST['tel_fixe']) &&
        empty($_POST['tel_portable'])) {
		$error_message .= 'Vous devez indiquer au moins un num&eacute;ro de t&eacute;l&eacute;phone.<br />';
    }
    if(!isset($_POST['accept_RI'])) {
		$error_message .= 'Vous devez accepter le r&egrave;glement int&eacute;rieur.<br />';
    }

	if(empty($error_message)) {
		// On a tous les champs voulus
		$nom			= $_POST['nom'];
		$prenom 		= $_POST['prenom'];
		$email			= $_POST['email'];
		$adresse		= $_POST['adresse'];
		$code_postal	= $_POST['code_postal'];
		$ville			= $_POST['ville'];
		$tel_fixe		= $_POST['tel_fixe'];
		$tel_portable	= $_POST['tel_portable'];
		$date_naissance	= date("d/m/Y", strtotime($_POST['date_naissance']));
		$pseudo			= $_POST['ville'];
		$vmax			= $_POST['vmax'];
		$accept_RI		= $_POST['accept_RI'];

		// Quelques tests de forme
		$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
		$string_exp = "/^[\pL\pM\p{Zs}.-]+$/u";
		$number_exp = "/^[0-9]+$/";
		$tel_exp = "/^\+?[0-9]+$/";

		if(!preg_match($email_exp,$email)) {
			$error_message .= 'Votre adresse email semble invalide.<br />';
		}
		if(!preg_match($string_exp,$nom)) {
			$error_message .= 'Votre nom semble invalide.<br />';
		}
		if(!preg_match($string_exp,$prenom)) {
			$error_message .= 'Votre pr&eacute;nom semble invalide.<br />';
		}
		if(!preg_match($number_exp,$code_postal)) {
			$error_message .= 'Votre code postal semble invalide.<br />';
		}
		if(!empty($_POST['tel_fixe']) &&
			!preg_match($tel_exp,$tel_fixe)) {
			$error_message .= 'Votre num&eacute;ro de t&eacute;l&eacute;phone fixe semble invalide.<br />';
		}
		if(!empty($_POST['tel_portable']) &&
			!preg_match($tel_exp,$tel_portable)) {
			$error_message .= 'Votre num&eacute;ro de t&eacute;l&eacute;phone portable semble invalide.<br />';
		}

		if(empty($error_message)) {
			function clean_string($string) {
				$bad = array("content-type","bcc:","to:","cc:","href");
				return str_replace($bad,"",$string);
			}

			$email_message  = "Bonjour,\n\nInformations fournies par le demandeur :\n\n";
			$email_message .= "Prénom : ".clean_string($prenom)."\n";
			$email_message .= "Nom : ".clean_string($nom)."\n";
			$email_message .= "Email : ".clean_string($email)."\n";
			$email_message .= "Adresse : ".clean_string($adresse)."\n";
			$email_message .= "Code postal : ".clean_string($code_postal)."\n";
			$email_message .= "Ville : ".clean_string($ville)."\n";
			$email_message .= "Tel fixe : ".clean_string($tel_fixe)."\n";
			$email_message .= "Tel portable : ".clean_string($tel_portable)."\n";
			$email_message .= "Date de naissance : ".clean_string($date_naissance)."\n";
			$email_message .= "Vmax : ".clean_string($vmax)."\n";
			$email_message .= "J'ai accepté le règlement intérieur : OUI\n";

			// create email headers
			$headers =	'From: '.$email_from."\r\n".
						'Reply-To: '.$email."\r\n" .
						'Content-Type: text/plain; charset=utf-8'."\r\n" .
						'X-Mailer: PHP/' . phpversion();
			if (mail($email_to, $email_subject, $email_message, $headers)) {
				header('Location: mail_ok.html');
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

		<style nonce="adheJZ4Z0FexMGWR5QapLkFCw7gUlzAW">
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

		<title>Vmax Le Club - Adh&eacute;rer</title>

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
							<a href="./" class="retour">Retour sur le formulaire d'adh&eacute;sion</a>
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
