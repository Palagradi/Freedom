<?php
require("config.php");
$footer= substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '/'));

if($footer!="/proforma.php"){
$req=mysqli_query($con,"DROP table IF EXISTS SalleTempon");
}


$res=mysqli_query($con,'CREATE TABLE IF NOT EXISTS reservation_tempon (
jour VARCHAR( 10) NOT NULL, num_reserv VARCHAR( 25)
) ENGINE = InnoDB ');
$res2=mysqli_query($con,'CREATE TABLE IF NOT EXISTS reservation_tempon2 (
jour VARCHAR( 10) NOT NULL, num_reserv VARCHAR( 25)
) ENGINE = InnoDB ');

	//if(isset($_SESSION['module'])&&($_SESSION['module']==1)) $role="roler";
	//else if(isset($_SESSION['module'])&&($_SESSION['module']==2))  $role="roleh";
	//else $role="roleh";

	$reqsel=mysqli_query($con,"SELECT * FROM module WHERE Etat='1'");
	if(mysqli_num_rows($reqsel)>0){
		if(mysqli_num_rows($reqsel)==1) {
			$ret1=mysqli_fetch_assoc($reqsel);
			$mod=$ret1['Name']; $_SESSION['module']=$ret1['Name'];
			if($ret1['Name']=="RESTAURATION") $role="roleR"; if($ret1['Name']=="ECONOMAT") $role="roleE"; if($ret1['Name']=="HEBERGEMENT") $role="roleH";
		} //else $role="role";
		else if(isset($_GET['module']))  {
			if($_GET['module']=="RESTAURATION") $role="roleR";
			if($_GET['module']=="ECONOMAT") $role="roleE";
			if($_GET['module']=="HEBERGEMENT") $role="roleH";
			//else $role="role";
		}
		else	$role="roleh";

		//unset($_SESSION['module']);

	if($_SESSION['poste']=="Super administrateur")
		{ $role="role"; //$_SESSION['mod']= $mod;
		  $mod="SUPER  ADMINISTRATEUR";
		}$_SESSION['role']= $role;

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
		<link rel="icon" href="logo/link.png" />
		<link href="bootstrap/customiz_e.css" rel="stylesheet">
			
		<link rel="Stylesheet" type="text/css" media="screen, print" href='css/style.css' />
		<link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">


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

			<link href="bootstrap/4.1.1/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
			<script src="bootstrap/4.1.1/bootstrap.min.js"></script>
			<script src="bootstrap/4.1.1/jquery.min.js"></script>
			<link href="bootstrap/4.0.0/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
			<script src="bootstrap/4.0.0/bootstrap.min.js"></script>
			<script src="bootstrap/4.0.0/jquery.min.js"></script>

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

		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
		<style>
			.alertify-log-custom {
				background: blue;
			}
			.footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #84CECC;
            color: white;
            text-align: center;
            padding: 5px 0;
			font-size:0.8em;
        }
		</style>
	</head>

	<body style='background-color:#84CECC; '>
<!------ Include the above in your HEAD tag ---------->

  <div id="wrapper" class="animate">
  <?php

	?>
    <nav class="navbar header-top fixed-top navbar-expand-lg navbar-dark bg-dark" style='font-weight:bold;font-family:calibri;'>
	  <?php
	  	$rZ=mysqli_query($con,"SELECT * FROM menu_tempon");
		$d1=mysqli_fetch_assoc($rZ);$mParent=isset($d1['menu'])?trim($d1['menu']):NULL;
		//$mod;
		$reqsel=mysqli_query($con,"SELECT * FROM module WHERE Etat='1' AND Name='RESTAURATION'");
		if(mysqli_num_rows($reqsel)>0){
			if(!isset($_GET['module'])) {
			 echo "<a class='navbar-brand' href='menu.php?module=RESTAURATION' title='RESTAURATION'><i class='fas fa-home'></i></a>";
			}
		}
		// $reqsel=mysqli_query($con,"SELECT * FROM module WHERE Etat='1' AND Name='ECONOMAT'");
		// if(mysqli_num_rows($reqsel)>0){
		// 	echo "<a class='navbar-brand' href='menu.php' title='ECONOMAT'><i class='fas fa-home'></i></a>";
		// }
		else {
/* 			echo "<a class='navbar-brand' href='menu.php' ><i class='fas fa-home'></i></a>";
			if(isset($_GET['module'])&&($_GET['module']=='RESTAURATION'))
			{  echo "<a class='navbar-brand' href='menu.php?module=HEBERGEMENT' title='PASSEZ EN MODE HEBERGEMENT'><i class='fas fa-home'></i></a>";
				$role="roleR"; $_SESSION['module']=1;
			}
			if(isset($_GET['module'])&&($_GET['module']=='HEBERGEMENT'))
			{
				echo "<a class='navbar-brand' href='menu.php?module=RESTAURATION' title='PASSEZ EN MODE RESTAURATION'><i class='fas fa-home'></i></a>";
				$role="roleH"; $_SESSION['module']=2;
			} */	
		}

		mysqli_query($con,"SET NAMES 'utf8'");
		$reqsel=mysqli_query($con,"SELECT DISTINCT menuParent,logo FROM ".$role.",affectationrole WHERE ".$role.".nomrole=affectationrole.nomrole AND ".$role.".nomrole <> 'Administration' AND Profil='".$_SESSION['poste']."' ORDER BY menuParent");
		//$nbreReq=mysqli_num_rows($reqsel);
			while($data=mysqli_fetch_array($reqsel))
				{   $menuParent=trim($data['menuParent']);
					$logo=$data['logo'];
					mysqli_query($con,"SET NAMES 'utf8'");
					$reqselB=mysqli_query($con,"SELECT chemin,target FROM ".$role.",affectationrole WHERE menuParent='".$menuParent."'");
					$dataB=mysqli_fetch_array($reqselB);	$nbreRS=mysqli_num_rows($reqselB); $chemin=$dataB['chemin']; 	$target=$dataB['target'];
					mysqli_query($con,"SET NAMES 'utf8'");
					$reqse_l1=mysqli_query($con,"SELECT * FROM ".$role.",affectationrole WHERE ".$role.".nomrole=affectationrole.nomrole AND Profil='".$_SESSION['poste']."' AND menuParent='$menuParent'");
					$data_1=mysqli_fetch_assoc($reqse_l1);
					if($data_1['menu']!=$data_1['menuParent'])
					{//if($_SESSION['poste']=="Super administrateur")
						//echo "<a class='navbar-brand' href='".$chemin."?menuParent=".$menuParent."' style='font-size:95%;";
				    // else
						 echo "<a class='navbar-brand' href='menu.php?menuParent=".$menuParent."' style='font-family:calibri;font-size:105%;";

						if(empty($cheminP))  {if($mParent==$menuParent) echo "color:yellow; ";   }
						echo "'>".$menuParent."</a>";

					}else { //if($_SESSION['poste']=="Super administrateur") //$chemin="../".$chemin;
								//echo "<a class='navbar-brand' id='navbar-brand' href='#' style='font-size:95%;";
							//else
								echo "<a class='navbar-brand' id='navbar-brand' href='".trim($chemin)."?chemin=".$chemin."&lien=".$menuParent."' style='font-family:calibri;font-size:100%";
					if(empty($menuParenT)) {if(!empty($cheminP) && ($cheminP==$chemin )) echo "color:yellow; ";  }
					echo "' >".$menuParent."</a>";
					}
				}

//echo $cheminP;

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
				if(strpos($chemin,"menuParent")==11) $post="";  else $post="?menuParent=".$menuParenT;
					echo "<li class='nav-item'>
							<a class='nav-link' href='".$chemin." ".$post."' title=''> <i class='".$target."' style='color:".$bgcouleur.";'></i><span class='ttip'>".$menu."</span></a>
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
				//$tab = str_split($mod,1);	//array('H','E','B','E','R','G','E','M','E','N','T');
				$mod=isset($_SESSION['serveurname'])?$_SESSION['serveurname']:"FREEDOM"; 
				$tab = str_split($mod,1);
 				for($i=0;$i<count($tab);$i++)
				{	//echo "<span align='center' style='font-size:1.2em;width:100%;font-family:calibri;color:#444739;align:center;'>";
					if((count($tab)<10)&& ($i==0)) echo "<br/>";
					//echo $tab[$i];
					echo "<H2 ALIGN='center' style='color:#444739;font-family:calibri ;'><b><span style='font-size:200%;color:white;font-family: calibri ;'>".$tab[$i]."</span></h2>";
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
            <a class="nav-link" href="<?php //if($_SESSION['poste']=="Super administrateur") echo "../";?>deconnexion.php?d=1"><i class="fas fa-key"></i> Déconnexion</a>
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
	if($footer!="/food.php"){
			$reqselz=mysqli_query($con,"DROP TABLE IF EXISTS ListeProduits");
	}
		  $footer= substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '/'));
		if($footer=="/menu.php"){
			$reqsel=mysqli_query($con,"SELECT logo FROM autre_configuration");
			$data=mysqli_fetch_assoc($reqsel);
			$logo=$data['logo'];$title="e-Freedom";
			$logo="logo/Sesy.png";
			echo "<center><img src='".$logo."' style='margin-top:0px;filter:alpha(opacity=25);opacity: 0.25;-moz-opacity:0.95;'/></center>";
		//echo " <br/>";
/* 		echo "<H2 ALIGN='center' style='color:#444739;font-family:calibri ;'><b><span style='font-size:200%;color:green;font-family:calibri;'>H</span>EBERGEMENT - <span style='font-size:200%;color:teal;font-family:calibri;'>R</span>ESTAURATION -
		<span style='font-size:200%;color:red;font-family:calibri;'>E</span>CONOMAT </b> -
		<span style='font-size:200%;color:yellow;font-family:calibri;'>I</span>MMOBLIER </b>
		</H2>	<div style ='font-family:calibri;'>"; */
/* 		echo "<br/>
			<div style ='text-align:center;bottom:0;'><span class='Style3'>".$title." - Version 2.0 (Juillet 2016) </span></div>
			<div style ='text-align:center;bottom:0;'><span class='Style3'>Copyright : GIS Informatique</span>&nbsp;&nbsp;&nbsp;<span class='Style3'>Tous droits reservés</span></div>
		<br/>
		<p>&nbsp;</p>";
		echo "</div>"; */
		}
		?>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="js/alertify.js/lib/alertify.min.js"></script>
	<script src="js/sweetalert.min.js"></script>
	<script src="js/sweetalert2/sweetalert2@10.js"></script>
	<!-- <script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/sweetalert2/sweetalert.min.js"></script> -->
	<script>

	 var maVariable1 = '<?php echo $_SESSION["login"]; ?>';
	 var maVariable2 = '<?php echo $_SESSION["nom"]; ?>';
	 var maVariable3 = '<?php echo $_SESSION["prenom"]; ?>';
	 var change = '<?php echo $_SESSION["change"]; ?>';
	  //var change = 1;
	 //var verrou = '<?php echo $_SESSION["verrou"]; ?>';
	 //var verrou = '<?php if(date('Y-m-d') == "2022-12-14")  echo 1 ; else echo 0; ?>';
	 
	 //var verrou = 0; if(date('Y-m-d') == "2022-12-14") var verrou = 1;	

	 var verrou = '<?php if(date('Y-m-d') == "2023-03-01")  echo 1 ; else echo 0; ?>';	 //alert(verrou);
	 
	 var msg_verrou = "L'APPLICATION FREEDOM EST VERROUILLEE. VEUILLEZ CONTACTER VOTRE EDITEUR";

	var CheminComplet = document.location.href;
	var CheminRepertoire  = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( "/" ) );
	var NomDuFichier     = CheminComplet.substring(CheminComplet.lastIndexOf( "/" )+1 );
	//alert (NomDuFichier);
	  // var timeout = setTimeout(
    //     function() {
    //         //document.getElementById('bienvenue').innerHTML = null;
		// 	if(NomDuFichier=='menu.php')
		// 		alertify.success("Bienvenue "+" "+maVariable2+" "+maVariable3);
		// 	clearTimeout(timeout);
    //         }
    //     ,500); // temps en millisecondes

		if(NomDuFichier=='menu.php'){
			Swal.fire({
		position: 'top-end',
		type: 'success',
		title: "Bienvenue "+"  "+maVariable2+" "+maVariable3,
		showConfirmButton: false,
		timer: 1500
	 	})
	}

		if(change!="")
			{ setTimeout(function(){ alertify.log(change, "", 0); }, 6000);

			}
		if(verrou==1)
			{ setTimeout(function(){ alertify.log(msg_verrou, "", 0); }, 6000);
		
			  location.href = 'index.php?v=1'

			}
	</script>
<?php
}
	else{  if($_SESSION['poste']=='Super administrateur'){

		header('location:admin/admin.php');

} else {
		?>


	<?php

	}
	}

	$reqsel=mysqli_query($con,"SELECT backupDate FROM backup WHERE backup='".$previousDay."'");
	if(mysqli_num_rows($reqsel)==0) include 'backup.php'; 
	
	?>
	
<div class='footer'>
	<?php
		if($footer=="/menu.php"){
		echo "<h2 ALIGN='center' style='color:#444739;font-family:calibri;margin-bottom:0px;'><b><span style='font-size:200%;color:green;font-family:calibri;'>H</span>EBERGEMENT - <span style='font-size:200%;color:yellow;font-family:calibri;'>R</span>ESTAURATION -
		<span style='font-size:200%;color:red;font-family:calibri;'>E</span>CONOMAT - <span style='font-size:200%;color:teal;font-family:calibri;'>I</span>MMOBILIER</b>"; 
		echo "</h2>";
		}
	?>	
<span style='font-weight:normal;'>Copyright © eFREEDOM Version 1.0 (Juillet 2020)</span>		
</div>