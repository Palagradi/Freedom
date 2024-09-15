<?php
session_start();
unset($_SESSION['login']);
unset($_SESSION['poste']);
unset($_SESSION['userId']);
$lock = "2025-03-15";

include_once 'connexion.php';

$exec = mysqli_query($con, "SELECT DATEDIFF('" . $lock . "','" . date('Y-m-d') . "') AS DiffDate");
$row_Recordset1 = mysqli_fetch_assoc($exec);
$lock = $row_Recordset1['DiffDate'];

$pre_sql = "CREATE table IF NOT EXISTS module(Num int PRIMARY KEY  NOT NULL AUTO_INCREMENT, Name varchar(50) UNIQUE,Etat int)";
$req1 = mysqli_query($con, $pre_sql) or die(mysqli_error($con));
$reqsel = mysqli_query($con, "SELECT * FROM module");
if (mysqli_num_rows($reqsel) <= 0) {
	$req1 = mysqli_query($con, "INSERT INTO module VALUES(NULL,'HEBERGEMENT','0')") or die(mysqli_error($con));
	$req1 = mysqli_query($con, "INSERT INTO module VALUES(NULL,'RESTAURATION','0')") or die(mysqli_error($con));
	$req1 = mysqli_query($con, "INSERT INTO module VALUES(NULL,'ECONOMAT','0')") or die(mysqli_error($con));
}

$tab = array('/Freedom/frameDrink.php', '/Freedom/searchDrink.php', '/Freedom/tableP.php', '/Freedom/searchDrink.php', '/Freedom/frameFood.php', '/Freedom/ajax-searchP.php', '/Freedom/InfoProduit.php', '/Freedom/auto_liste.php', '/Freedom/checking.php', '/Freedom/checkingOK.php', '/Freedom/receiptH.php', '/Freedom/reimpression.php', '/Freedom/Facture.php', '/Freedom/JsonData.php', '/Freedom/receipt2.php', '/Freedom/reimpressionOK.php');
for ($j = 0; $j < sizeof($tab); $j++) {
	$re = "UPDATE utilisateur SET etatconnect='0' WHERE etatconnect LIKE '" . $tab[$j] . "%'";
	$ret = mysqli_query($con, $re);
	//echo '<meta http-equiv="refresh" content="0; url=index.php" />';
}

$res = mysqli_query($con, "SELECT name FROM serveurused WHERE state =1");
$ret = mysqli_fetch_assoc($res);
if (mysqli_num_rows($res) > 0)
	$serveurused = $ret['name'];
else
	$serveurused = "emecef";
if ($serveurused == "emecef") $serveurused = "eFreedom";
else $serveurused = "Freedom";


$reqsel = mysqli_query($con, "SELECT * FROM module WHERE Etat='1'");
if (mysqli_num_rows($reqsel) > 0) {
	if (mysqli_num_rows($reqsel) == 1) {
		$ret1 = mysqli_fetch_assoc($reqsel);
		$role = $ret1['Name'];
		if ($ret1['Name'] == "HEBERGEMENT") $name = "COMPLEXE HOTELIER";
		else if ($ret1['Name'] == "ECONOMAT") $name = "ENTREPRISE";
		else if ($ret1['Name'] == "RESTAURATION") $name = "RESTAURANT";
		else $name = "RESIDENCE";
	} else 	$role = 1;
	$_SESSION['module0'] = isset($ret1['Name']) ? $ret1['Name'] : NULL;


	$resT = mysqli_query($con, "SELECT * FROM  hotel");
	$reXt = mysqli_fetch_assoc($resT);
	$nomHotel = $reXt['nomHotel'];
	$NbreEToile = $reXt['NbreEToile'];

	if (isset($_POST['connexion']) and $_POST['connexion'] == 'Se connecter') {
		mysqli_query($con, "SET NAMES 'utf8'");
		$date = new DateTime("now"); // 'now' n'est pas nécéssaire, c'est la valeur par défaut
		$tz = new DateTimeZone('Africa/Porto-Novo');
		$date->setTimezone($tz);
		$Jour_actuel = $date->format("Y") . "-" . $date->format("m") . "-" . $date->format("d");
		//$Jour_actuel2 = $date->format("d") . "-" . $date->format("m") . "-" . $date->format("Y");
		$Heure_actuelle = $date->format("H") . ":" . $date->format("i") . ":" . $date->format("s");

		//vérification de l'etat de connection
		$pseudo = mysqli_real_escape_string($con, $_POST['edit1']);
		$re = "SELECT * FROM utilisateur WHERE login='" . $pseudo . "'";
		$ret = mysqli_query($con, $re);
		$ret1 = mysqli_fetch_assoc($ret);
		$DateConnexion = $ret1['DateConnexion'];
		if ($Jour_actuel != $DateConnexion) {
			$re = "UPDATE utilisateur SET etatconnect='0',DateConnexion='" . $Jour_actuel . "' WHERE login='" . $pseudo . "'";
			$ret = mysqli_query($con, $re);
		}

		$re = "SELECT * FROM utilisateur WHERE login='" . $pseudo . "'";
		$ret = mysqli_query($con, $re);
		while ($ret1 = mysqli_fetch_array($ret)) {
			$_SESSION['poste'] = !empty($ret1['poste']) ? $ret1['poste'] : NULL;
			$password = isset($_POST['edit2']) ? $_POST['edit2'] : NULL;
			if ($pseudo == 'S@dmin') {
				$dhm = $date->format("d") . "" . $date->format("H") . "" . $date->format("i");
				"<br/>";
				$pre = substr($password, 0, -6); //echo "<br/>";
				$post = substr($password, strlen($pre), 6);
				if ($dhm == $post)
					$password = md5($pre);
			} else {
				$password=md5($password);
				//$password = ($password);
			}

			//$password=isset($_POST['edit2'])?md5($_POST['edit2']) :NULL;
			$_SESSION['login'] = $ret1['login'];
			$change = md5("change");
			$_SESSION['userId'] = $ret1['userId'];
			// $password=isset($_POST['edit2'])?md5($_POST['edit2'] . $CFG['salt']) :NULL;
			//$_SESSION['login']=$ret1['login'];$change=md5("change" . $CFG['salt']);
			$_SESSION['nom'] = $ret1['nom'];
			$_SESSION['prenom'] = $ret1['prenom'];
			$_SESSION['DateConnexion'] = $ret1['DateConnexion'];
			$lien = $ret1['etatconnect'];
			if ($password == $ret1['pass']) {
				$reqsel = mysqli_query($con, "SELECT * FROM configuration_facture");
				while ($data = mysqli_fetch_array($reqsel)) {
					$_SESSION['num_fact'] = $data['num_fact'];
					$_SESSION['etat_facture'] = $data['etat_facture'];
					$_SESSION['initial_grpe'] = $data['initial_grpe'];
					$_SESSION['initial_reserv'] = $data['initial_reserv'];
					$_SESSION['initial_fiche'] = $data['initial_fiche'];
					$_SESSION['Nbre_char'] = $data['Nbre_char'];
				}
				$reqsel = mysqli_query($con, "SELECT * FROM configuration_client");
				while ($data = mysqli_fetch_array($reqsel)) {
					$_SESSION['num_auto'] = $data['num_auto'];
					$_SESSION['Nbre_chare'] = $data['Nbre_chare'];
				}
				$reqsel = mysqli_query($con, "SELECT * FROM autre_configuration");
				while ($data = mysqli_fetch_array($reqsel)) {
					$_SESSION['taxe'] = $data['taxe'];
					$_SESSION['etat_taxe'] = $data['etat_taxe'];
					$_SESSION['limitation'] = $data['limitation'];
					$_SESSION['limite_jrs'] = $data['limite_jrs'];
					$_SESSION['fond'] = $data['fond'];
				}

				if ($password == $change) $_SESSION['change'] = "Pour des raisons de sécurité, Veuillez changer votre mot de passe !";
				if ($lock >= 0) { //echo $lien; 
					if (!empty($lien)) {
						$ri = 'UPDATE utilisateur SET etatconnect=0 WHERE login="' . $_SESSION['login'] . '"';
						$rit = mysqli_query($con, $ri);
						if (isset($_GET['admin']) && ($ret1['poste'] == "Super administrateur")) {
							 // Connexion du Super administrateur

						} else {
							header('location:' . $lien);
						}
					} else {
							header('location:menu.php');
					}
				} else { 
					$msg_verrou = "L'APPLICATION eFreedom EST VERROUILLEE. VEUILLEZ CONTACTER VOTRE EDITEUR";
					//echo "<center>".$msg_verrou."<center>";
				}
			} else { 
			}
		}
	}
}
?>
<html>

<head>
	<title> <?php echo $nomHotel; ?> </title>
	<link href="css/animate.css" rel="stylesheet">
	<link rel="icon" href="<?php $icon = "logo/link.png";
							echo $icon; ?>" />
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
	<link href="bootstrap/customize.css" rel="stylesheet">
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.lettering.js"></script>
	<script src="js/jquery.textillate.js"></script>

</head>

<body style='overflow:hidden;background-image: url("<?php
													if ($role == "HEBERGEMENT") echo "logo/background/" . rand(11, 11) . ".jpg";
													else if ($role == "ECONOMAT") echo "logo/background/" . rand(21, 21) . ".jpg";
													else if ($role == "RESTAURATION") echo "logo/background/" . rand(11, 11) . ".jpg";
													else echo "logo/background/" . rand(11, 11) . ".jpg"; ?>");'>
	<p>
	<h1 align='center' class="tlt" style='<?php if ($role == "HEBERGEMENT") echo "color:#573E39;";
											else if ($role == "ECONOMAT") echo "color:black;";
											else echo "color:pick;"; ?>'>
		<font size='200'> <!--#573E39;  !-->
			<ul class="texts">
				<li data-out-effect="fadeIn"><?php
												if ($lock >= 0) 
												{
													if ($role == "HEBERGEMENT") echo "SYSTEME DE GESTION HOTELIERE " . $serveurused;
													else if ($role == "RESTAURATION") echo "SYSTEME DE GESTION HOTELIERE - " . $serveurused;
													else if ($role == "ECONOMAT") echo "SYSTEME - DE GESTION DU STOCK - " . $serveurused;
													else echo "SYSTEME DE GESTION HOTELIERE " . $serveurused;
												} else {
													$msg_verrou = "L'APPLICATION eFreedom EST VERROUILLEE. VEUILLEZ CONTACTER VOTRE EDITEUR";
													echo $msg_verrou;
												} 
												?> </li>
			</ul>
		</font>
	</h1>
	</p>
	<div class="container" style="margin-top: 100px;margin-left:38%;">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<h4 style='color:white;'>HOTEL<br /> <br />SESY <? //=$nomHotel 
																	?></h4>
					<br>
					<!-- <h4 style='color:white;'><?php echo str_replace('HOTEL', '', $nomHotel); ?></h4> !-->
					<hr>
					<div class="panel-body">
						<form action='' method='post'>
							<div class="form-group"><i class="fa fa-user fa-lg fa-fw" aria-hidden="true"></i>
								<input type="text" name="edit1" class="form-control" placeholder="Identifiant" required='required' autocomplete="off">
							</div>
							<div class="form-group"><i class="fa fa-unlock-alt"></i>
								<input type="password" name="edit2" class="form-control" placeholder="Mot de passe" required='required'>
							</div>
							<div class="form-group">
								<input type="submit" name="connexion" class="btn btn-success btn-lg btn-block" value="Se connecter">
							</div>
						</form>
					</div>
					<div class="lock"><i class="">
							<?php for ($i = 1; $i <= $NbreEToile; $i++) echo "<img src='logo/etoile.png' alt='Modifier' title='Modifier' width='30' height='25' border='0'>"; ?>
						</i>
					</div>
					<div class="label"><b>Connexion</b></div>
					<div class="label2"></div>
				</div>
			</div>

		</div>

	</div>
	<table style='margin-left:29%;bottom:0;'>
		<tr>
			<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Copyright: GIS Informatique 2013 </td>
		</tr>
	</table>
</body>
<script>
	$(function() {
		$('.tlt').textillate({
			loop: true
		});
	})
</script>

</html>
<?php
// } else { $_SESSION['admin'] = $_GET['admin'];
// include ("admin.php");
// }
?>