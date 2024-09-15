<?php
require("../config.php");
$footer= substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '/'));

if($footer!="/proforma.php"){
$req=mysqli_query($con,"DROP table SalleTempon");
}


$res=mysqli_query($con,'CREATE TABLE IF NOT EXISTS reservation_tempon (
jour VARCHAR( 10) NOT NULL, num_reserv VARCHAR( 25)
) ENGINE = InnoDB ');
$res2=mysqli_query($con,'CREATE TABLE IF NOT EXISTS reservation_tempon2 (
jour VARCHAR( 10) NOT NULL, num_reserv VARCHAR( 25)
) ENGINE = InnoDB ');

	$reqsel=mysqli_query($con,"SELECT * FROM module WHERE Etat='1'");
	if(mysqli_num_rows($reqsel)>0){
		if(mysqli_num_rows($reqsel)==1) {
			$ret1=mysqli_fetch_assoc($reqsel);
			$mod=$ret1['Name'];
			if($ret1['Name']=="RESTAURATION") $role="roleR"; if($ret1['Name']=="ECONOMAT") $role="roleE"; if($ret1['Name']=="HEBERGEMENT") $role="roleH";
			} else $role="role";
	if($_SESSION['poste']=='Super administrateur')  $role="role";
		{$_SESSION['role']= $role;//$_SESSION['mod']= $mod;
		$mod="SUPER  ADMINISTRATEUR";}

$menuParenT=!empty($_GET['menuParent'])? $_GET['menuParent']:NULL;
if($_SESSION['role']== "roleE") $_SESSION['menuParenT1']="Economat";  if($_SESSION['role']== "roleR") $_SESSION['menuParenT1']="Restauration"; if($_SESSION['role']== "role") $_SESSION['menuParenT1']=$menuParenT;
$_SESSION['menuParenT']=$menuParenT; $cheminP=!empty($_GET['chemin'])? $_GET['chemin']:NULL;
$lien=!empty($_GET['lien'])? $_GET['lien']:NULL;
if(!empty($menuParenT))
	{$req=mysqli_query($con,"TRUNCATE table menu_Tempon");
	 $reqsl=mysqli_query($con,"INSERT INTO menu_Tempon SET menu='".$menuParenT."'");
	}

//https://bootsnipp.com/snippets/qr9AQ

$d=!empty($_GET['d'])? $_GET['d']:NULL;
if($d==1)	include('deconnexion.php');
?>
<!--?xml version="1.0" encoding="UTF-8"?-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" style='overflow-x: hidden;'>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="Pragma" CONTENT="no-cache">
		<title> <?php echo $nomHotel; ?> </title>

		<title> <?php echo $nomHotel; ?> </title>
			<link href="../bootstrap/customiz_e.css" rel="stylesheet">
			<link rel="Stylesheet" type="text/css" media="screen, print" href='../css/style.css' />
			<link href="../fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">


<!-- 		<link 	// automatisation du numéro
	function random($car,$initial_reserv) {
		$string = $initial_reserv;
		$chaine = "0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
		}
		function nbJours($debut, $fin) {
        //60 secondes X 60 minutes X 24 heures dans une journée
        $nbSecondes= 60*60*24;

        $debut_ts = strtotime($debut);
        $fin_ts = strtotime($fin);
        $diff = $fin_ts - $debut_ts;
        return round($diff / $nbSecondes);
    }
href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
			<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
			<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
			<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
			<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
			<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
-->

			<link href="../bootstrap/4.1.1/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
			<script src="../bootstrap/4.1.1/bootstrap.min.js"></script>
			<script src="../bootstrap/4.1.1/jquery.min.js"></script>
			<link href="../bootstrap/4.0.0/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
			<script src="../bootstrap/4.0.0/bootstrap.min.js"></script>
			<script src="../bootstrap/4.0.0/jquery.min.js"></script>

		<!--	<link rel="Stylesheet" type="text/css"  href='css/input.css' />  -->
		<link rel="Stylesheet" type="text/css"  href='css/input2.css' />

			<script type="text/javascript" >
				$(document).ready(function () {
			  $('.leftmenutrigger').on('click', function (e) {
				$('.side-nav').toggleClass("open");
				$('#wrapper').toggleClass("open");
				e.preventDefault();
			  });
			});
			</script>

		<link rel="stylesheet" href="../js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="../js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
		<style>
			.alertify-log-custom {
				background: blue;
			}
		</style>
	</head>

	<body style='background-color:#84CECC; '>
<!------ Include the above in your HEAD tag ---------->

  <div id="wrapper" class="animate">
  <?php

	?>
    <nav class="navbar header-top fixed-top navbar-expand-lg navbar-dark bg-dark" style='font-weight:bold;font-family:cambria;'>
	  <?php
	  	$rZ=mysqli_query($con,"SELECT * FROM menu_tempon");
		$d1=mysqli_fetch_assoc($rZ);$mParent=$d1['menu'];

		echo "<a class='navbar-brand' href='menu.php' ><i class='fas fa-home'></i></a>";
		mysqli_query($con,"SET NAMES 'utf8'");
		$reqsel=mysqli_query($con,"SELECT DISTINCT menuParent,logo FROM ".$role.",affectationrole WHERE ".$role.".nomrole=affectationrole.nomrole AND ".$role.".nomrole <> 'Administration' AND Profil='".$_SESSION['poste']."' ORDER BY menuParent");
		//$nbreReq=mysqli_num_rows($reqsel);
			while($data=mysqli_fetch_array($reqsel))
				{   $menuParent=$data['menuParent'];
					$logo=$data['logo'];
					mysqli_query($con,"SET NAMES 'utf8'");
					$reqselB=mysqli_query($con,"SELECT chemin,target FROM ".$role.",affectationrole WHERE menuParent='".$menuParent."'");
					$dataB=mysqli_fetch_array($reqselB);	$nbreRS=mysqli_num_rows($reqselB); $chemin=$dataB['chemin']; 	$target=$dataB['target'];
					mysqli_query($con,"SET NAMES 'utf8'");
					$reqse_l1=mysqli_query($con,"SELECT * FROM ".$role.",affectationrole WHERE ".$role.".nomrole=affectationrole.nomrole AND Profil='".$_SESSION['poste']."' AND menuParent='$menuParent'");
					$data_1=mysqli_fetch_assoc($reqse_l1);
					if($data_1['menu']!=$data_1['menuParent'])
					{if($_SESSION['poste']=="Super administrateur") 
						echo "<a class='navbar-brand' href='".$chemin."?menuParent=".$menuParent."' style='font-size:95%;";
				     else 
						 echo "<a class='navbar-brand' href='menu.php?menuParent=".$menuParent."' style='font-size:95%;";
					 
						if(empty($cheminP))  {if($mParent==$menuParent) echo "color:yellow; ";   }
						echo "'>".$menuParent."</a>";

					}else { if($_SESSION['poste']=="Super administrateur") //$chemin="../".$chemin;
								echo "<a class='navbar-brand' id='navbar-brand' href='#' style='font-size:95%;";
							else 
								echo "<a class='navbar-brand' id='navbar-brand' href='".$chemin."?chemin=".$chemin."&lien=".$menuParent."' style='font-size:95%;";
					if(empty($menuParenT)) {if(!empty($cheminP) && ($cheminP==$chemin )) echo "color:yellow; ";  }
					echo "' >".$menuParent."</a>";
					}
				}


	  ?>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon" ></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText" >
	  <ul class='navbar-nav animate side-nav'>
	  <?php
		if(!empty($menuParenT)){ $mParent=htmlspecialchars($mParent);
		mysqli_query($con,"SET NAMES 'utf8'");
			$reqsel1=mysqli_query($con,"SELECT * FROM ".$role.",affectationrole WHERE ".$role.".nomrole=affectationrole.nomrole AND Profil='".$_SESSION['poste']."' AND menuParent='".$mParent."'");
				$cpteur=1;
				while($data1=mysqli_fetch_array($reqsel1))
				{
					if($cpteur == 1)
					{
						$cpteur = 0;
						$bgcouleur = "#00FF00";  //orange
					}
					else
					{
						$cpteur = 1;
						$bgcouleur = "#790000";
					}
			$menu=$data1['menu'];   $Profil=$data1['Profil'];  $chemin=$data1['chemin']; $nomrole=$data1['nomRole']; 	$target=$data1['target']; if(empty($target)) $target="fas fa-cart-plus";
			if($menu=="Liste des bons <br/>de commande") $menuParenT.="&Cde=1";   // Traitement spécial
					//echo "<a class='nav-link' href='".$chemin."' title='Cart'> <i class='fas fa-cart-plus'></i><span class='ttip'>".$menu."</span></a>";
					echo "<li class='nav-item'>
						<a class='nav-link' href='".$chemin."?menuParent=".$menuParenT."' title=''> <i class='".$target."' style='color:".$bgcouleur.";'></i><span class='ttip'>".$menu."</span></a>
					  </li>";

						//}
				}
		}else {		//$reqsel1=mysqli_query($con,"SELECT * FROM ".$role.",affectationrole WHERE ".$role.".nomrole=affectationrole.nomrole AND Profil='".$_SESSION['poste']."' AND menuParent='$lien'");
					//$data1=mysqli_fetch_assoc($reqsel1);$target=$data1['target']; if(empty($target)) $target="fas fa-cart-plus";
					//$bgcouleur = "orange";
					//echo "<li class='nav-item'>
						//<a class='nav-link' href='".$cheminP."' title='Cart'> <i class='".$target."' style='color:".$bgcouleur.";'></i><span class='ttip'>".$lien."</span></a>
					 // </li>";
		}
		if(empty($reqsel1)){$target="fab fa-hire-a";$bgcouleur = "orange";
				// echo "<li class='nav-item'>
				// 		<a class='nav-link' href='help.php' title=''> <i class='".$target."' style='color:".$bgcouleur.";'></i><span class='ttip'>Aide</span></a>
				//  </li>";$bgcouleur="green";$target="fab fa-hire-a-helper";
				//  	echo "<li class='nav-item'>
				// 		<a class='nav-link' href='#' title=''> <i class='".$target."' style='color:".$bgcouleur.";'></i><span class='ttip'>Hébergement</span></a>
				//  </li>";$bgcouleur="yellow";$target="fab fa-hire-a-helper";
				//  	echo "<li class='nav-item'>
				// 		<a class='nav-link' href='#' title=''> <i class='".$target."' style='color:".$bgcouleur.";'></i><span class='ttip'>Restauration</span></a>
				//  </li>";$bgcouleur="red";$target="fab fa-hire-a-helper";
				//  	echo "<li class='nav-item'>
				// 		<a class='nav-link' href='#' title=''> <i class='".$target."' style='color:".$bgcouleur.";'></i><span class='ttip'>Economat</span></a>
				//  </li>";
				$tab = str_split($mod,1);	//array('H','E','B','E','R','G','E','M','E','N','T');
				//$mod="LIBERTE"; $tab = str_split($mod,1);
 				for($i=0;$i<count($tab);$i++)
				{	//echo "<span align='center' style='font-size:1.2em;width:100%;font-family:algerian;color:#444739;align:center;'>";
					if((count($tab)<10)&& ($i==0)) echo "<br/>";
					//echo $tab[$i];
					echo "<H2 ALIGN='center' style='color:#444739;font-family:georgia ;'><b><span style='font-size:200%;color:white;font-family:algerian;'>".$tab[$i]."</span></h2>";
					//echo "</span><br/>"; if(count($tab)<10) echo "<br/>";
				} //echo "&Alpha;"; 

		}
/* 					else
					echo "
					  <li class='nav-item'>
						<a class='nav-link' href='".$chemin."' title='Cart'> <i class='fas fa-cart-plus'></i><span class='ttip'>".$menuParent."</span></a>
					  </li>
					  <li class='nav-item'>
						<a class='nav-link' href='#' title='Comment'> <i class='fas fa-comment'></i><span class='ttip'>Chat</span></a>
					  </li>
					"; */

		?>
		</ul>

        <ul class="navbar-nav ml-md-auto d-md-flex" >
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-user"></i> <?php echo $_SESSION['login']; ?> </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php if($_SESSION['poste']=="Super administrateur") echo "../";?>deconnexion.php?d=1"><i class="fas fa-key"></i> Déconnexion</a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="container-fluid">
		<div class="row">
    <?php
			//echo $_SESSION['poste'];
/* 			if($_SESSION['poste']=='Super administrateur'){

					{ while($data = mysqli_fetch_array($reqsel))
						echo $data['Name']; //$data->Etat;
					}		 */



			//}

	?>
		</div>
  </div>
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

	<?php
		//include ("footer.inc.php");
		  $footer= substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '/'));
		if($footer=="/menu.php"){
			$reqsel=mysqli_query($con,"SELECT logo FROM autre_configuration");
			$data=mysqli_fetch_assoc($reqsel);
			$logo=$data['logo'];
			echo "<img src='".$logo."' style='margin:  25px 13%; 0 auto;filter:alpha(opacity=25);opacity: 0.25;-moz-opacity:0.25;'/>";
		echo "<H2 ALIGN='center' style='color:#444739;font-family:georgia ;'><b><span style='font-size:200%;color:green;font-family:algerian;'>H</span>EBERGEMENT - <span style='font-size:200%;color:yellow;font-family:algerian;'>R</span>ESTAURATION - <span style='font-size:200%;color:red;font-family:algerian;'>E</span>CONOMAT </b></H2>	<div style ='font-family:cambria;'>
			<br/>
			<div style ='text-align:center;bottom:0;'><span class='Style3'>".$title." - Version 2.0 (Juillet 2016) </span></div>
			<div style ='text-align:center;bottom:0;'><span class='Style3'>Copyright: GIS Informatique</span>&nbsp;&nbsp;&nbsp;<span class='Style3'>Tous droits reservés</span></div>
		<br/>
		<p>&nbsp;</p>
		</div>";
		}
		?>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="js/alertify.js/lib/alertify.min.js"></script>
	<script>

	 var maVariable1 = '<?php echo $_SESSION["login"]; ?>';
	 var maVariable2 = '<?php echo $_SESSION["nom"]; ?>';
	 var maVariable3 = '<?php echo $_SESSION["prenom"]; ?>';
	 var change = '';

	var CheminComplet = document.location.href;
	var CheminRepertoire  = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( "/" ) );
	var NomDuFichier     = CheminComplet.substring(CheminComplet.lastIndexOf( "/" )+1 );
	//alert (NomDuFichier);
	  var timeout = setTimeout(
        function() {
            //document.getElementById('bienvenue').innerHTML = null;
			if(NomDuFichier=='menu.php')
				alertify.success("Bienvenue "+" "+maVariable2+" "+maVariable3);
			clearTimeout(timeout);
            }
        ,500); // temps en millisecondes
		if(change!="")
			{ setTimeout(function(){ alertify.log(change, "", 0); }, 3000);

			}
	</script>
<?php
}
	else{  if($_SESSION['poste']=='Super administrateur'){
		
		header('location:admin/admin.php');

} else {
		?>

	<table align='center' width='45%' height='auto' border='0' cellpadding='0' cellspacing='0' style='margin-top:90px;border:2px solid teal;font-family:Cambria;background-color:#f5f5dc;'>
		<tr>
			<td align='center' ><h3>SYGHOG Version 2.0 (Juillet 2016) <br/><br/> AUCUN MODULE N'EST INSTALLE.  <br/><br/>CONTACTEZ LE SUPER ADMINISTRATEUR</h3></td>
		</tr>

	</table>

	<?php

	}
		}
