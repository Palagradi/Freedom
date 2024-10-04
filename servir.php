<?php
include_once 'menu.php';  
require ('vendor/autoload.php');

use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;

//if(isset($_SESSION['quantify'])) echo $_SESSION['quantify'];
// https://www.youtube.com/watch?v=xYc4AO_wQgM
//https://sweetalert.js.org/docs/#content
	$reqsel=mysqli_query($con,"SELECT * FROM RTables");
	$Nbre=mysqli_num_rows($reqsel);

		$fd=!empty($_GET['fd'])?$_GET['fd']:NULL; $fk=!empty($_GET['fk'])?$_GET['fk']:NULL;$Qte=!empty($_GET['Qte'])?$_GET['Qte']:0;
		 $fd; $tk=!empty($_GET['tk'])?$_GET['tk']:NULL;   $serv = !empty($_GET['serv'])?$_GET['serv']:NULL; $tab = !empty($_GET['tab'])?$_GET['tab']:NULL;

	//$req1 = mysqli_query($con, "DROP TABLE IF EXISTS qtelignet") or die (mysqli_error($con));

		//if (isset($_GET['table'])){ //if ((isset($_GET['table']))&&(isset($_GET['cv']))){
		$table = !empty($_GET['table'])?$_GET['table']:0;
		$cv = !empty($_GET['cv'])?$_GET['cv']:0;
		$reqselRTables=mysqli_query($con,"SELECT * FROM tableEnCours WHERE numTable='".$table."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'");
			if($reqselRTables){ unset($del); unset($val); unset($vt);
/* 				echo "<script language='javascript'>";
				echo 'alertify.success(" La commande a été validée !");';
				echo "</script>";	 */
				}
				//echo '<meta http-equiv="refresh" content="0; url=servir.php" />';
	//}else $reqselRTables=mysqli_query($con,"SELECT * FROM tableEnCours WHERE numTable='0' AND Etat<> 'Desactive'");

	$vt = !empty($_GET['vt'])?$_GET['vt']:NULL;  $val = !empty($_GET['val'])?$_GET['val']:NULL; if(empty($val)) { if(!isset($_GET['del'])) unset($_SESSION['Ntable']); unset($_SESSION['cv']);}
	$del = !empty($_GET['del'])?$_GET['del']:NULL;

	if (!empty($del))
		{  $mQuery=mysqli_query($con,"SELECT max(Num) AS Num FROM tableEnCours WHERE numTable='".$table."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'");
		   $data=mysqli_fetch_object($mQuery); $max=$data->Num;
		   if(empty($max))
		   {	echo "<script language='javascript'>";
				echo 'alertify.error(" Aucune Ligne à supprimer");';
				echo "</script>";
		   }else {  //$pre_sql1="DELETE FROM tableEnCours WHERE num='$max' AND Etat<> 'Desactive'";
		   //$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));
		   $reqsel=mysqli_query($con,"SELECT * FROM RTables WHERE nomTable='".$table."'");
		   $data=mysqli_fetch_assoc($reqsel);$cv=$data['NbreCV'];
		   $reqselRTables=mysqli_query($con,"SELECT * FROM tableEnCours WHERE numTable='".$table."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'");
		   		//if($req1){
				//echo "<script language='javascript'>";
				//echo 'alertify.success(" Ligne supprimée avec succès !");';
				//echo "</script>";	}
		   }
		   //echo '<meta http-equiv="refresh" content="2; url=servir.php" />';
		}


/* 			$reqsel2=mysqli_query($con,"SELECT DISTINCT numTable FROM tableEnCours");
			$Ttable=array();$i=0;
			while($data1=mysqli_fetch_array($reqsel2)){
				 echo $Ttable[$i]=$data1['numTable']; $i++;
			} */
		for($i=1;$i<=$Nbre;$i++){
			if (isset($_POST['table']) and $_POST['table']==$i)
				{ if($i<10) $table="0".$i; else $table=$i;
					$_SESSION['Ntable']=$i;
					$reqsel=mysqli_query($con,"SELECT * FROM RTables WHERE nomTable='".$i."'");
					$data=mysqli_fetch_assoc($reqsel);$cv=$data['NbreCV'];$_SESSION['cv']=$cv;
					//if(!empty($tab))
						//$req="SELECT * FROM tableEnCours WHERE numTable='".$i."' AND Etat<> 'Desactive' ORDER BY HeureOccup ";
					//else
						$req="SELECT * FROM tableEnCours WHERE numTable='".$i."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'";
					$reqselRTables=mysqli_query($con,$req);
				}
}
			if (isset($_POST['Valider']))
			{  //if(isset($_POST['MontantP'])) echo $_POST['MontantP'] ; echo 12;
			}
			$_SESSION['table'] = $table;
?>
<html>
	<head>
		<link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


			
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script src="js/sweetalert.min.js"></script>	

		<style>
		.alertify-log-custom {
				background: blue;
			}
		#lien1:hover {
			text-decoration:underline;background-color: #046380;font-size:1.1em;
		}
		#lien1:hover {
			text-decoration:underline;background-color: #046380;font-size:1.1em;
		}
		.bouton5 {
		border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;background: #00734F; 

		border:none;
		color:#fff;
		font:bold 12px Verdana;
		padding:6px ;font-family:cambria;font-size:0.9em;
		}
		.bouton5:hover{
		cursor:pointer;color: black;
		}
		.bouton2 {
			border-radius:12px 0 12px 0;
			background: #d34836;
			border:none;
			color:#fff;
			font:bold 12px Verdana;
			padding:6px ;font-family:cambria;font-size:0.9em;
		}
		.bouton2:hover{
			cursor:pointer;background-color: #000000;
		}
		#test:hover{
			color:black;
		}


		 .button {
		  background-color: blue;
		  border: none;
		  color: white;font-weight:bold;
		  padding-left: 10px; padding-right: 10px;  padding-top: 2px; padding-bottom: 0px;
		  text-align: center;
		  text-decoration: none;
		  display: inline-block;
		  font-size: 25px;
		  margin: 4px 2px;cursor: pointer;
		}

		.button5 {border-radius: 50%;}

		 .buttonT {
		  background-color: red;
		  border: none;
		  color: white;font-weight:bold;
		  padding: 0px;
		  text-align: center;
		  text-decoration: none;
		  display: inline-block;
		  font-size: 25px;
		  margin: 4px 2px;cursor: pointer;
		}

		 .button7 {
		  background-color: orange;
		  border: none;
		  color: white;font-weight:bold;
		  text-align: center;
		  text-decoration: none;display: inline-block;
		  font-size: 22px;
		  padding-left:2px;padding-right:2px;
		  margin: 0px 0px;cursor: pointer;
		}
		.button6 {border-radius: 40%;}

		#full  {-webkit-transition: all 1s ease; /* Safari and Chrome */
			-moz-transition: all 1s ease; /* Firefox */
			-ms-transition: all 1s ease; /* IE 9 */
			-o-transition: all 1s ease; /* Opera */
			transition: all 1s ease;}
		#full:hover{   -webkit-transform:scale(1.25); /* Safari and Chrome */
			-moz-transform:scale(1.25); /* Firefox */
			-ms-transform:scale(1.25); /* IE 9 */
			-o-transform:scale(1.25); /* Opera */
			 transform:scale(1.25);}
			 
	/* Styles du ticket */
        .ticket {
            width: 400px;
            padding: 25px;
            background: linear-gradient(135deg, #ffffff, #f7f7f7);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: calibri;
            color: #333;
            margin: 20px auto;
			
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            color: #2c3e50;
        }

        .header p {
            margin: 5px 0;
            color: #7f8c8d;
        }

        .content table {
            width: 100%;
        }

        .content td {
            padding: 1px 5px;
            border-bottom: 1px solid #ddd;
        }

        .total {
            text-align: right;
            font-weight: bold;
            font-size: 16px;
        }

        .footerT {
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .footerT img {
            margin-top: 15px;
            width: 80px;
        }
		
		 /* Impression */
        @media print {
            body * {
                visibility: hidden;
            }

            #printable-ticket, #printable-ticket * {
                visibility: visible;
            }

            #printable-ticket {
                position: absolute;
                left: 0;
                top: 0;
            }
		  .info {
            margin-bottom: 10px;
        }
		</style>
			<script type="text/javascript" >
				function edition1() { options = "Width=800,Height=450" ; window.open( "tableP.php", "edition", options ) ; }
				function edition2() { options = "Width=800,Height=400" ; window.open( "ServP.php", "edition", options ) ; }
				//function edition3() { options = "Width=800,Height=450" ; window.open( "receipt2.php", "edition", options ) ; }
				function edition4() { options = "Width=800,Height=450" ; window.open( "frameFood.php", "edition", options ) ; }
				function edition9() { options = "Width=800,Height=450" ; window.open( "framePFood.php", "edition", options ) ; }
				function edition5() { options = "Width=800,Height=450" ; window.open( "frameDrink.php", "edition", options ) ; }
				function edition8() { options = "Width=800,Height=450" ; window.open( "framePDrink.php", "edition", options ) ; }
				function edition6(param0=0) { options = "Width=auto,Height=auto" ; window.open( "receipt2.php?param0=" + encodeURIComponent(param0), "edition", options ) ; }
				function edition7() { options = "Width=600,Height=300" ; window.open( "tableS.php", "edition", options ) ; }
				function Alert() {
					alertify.error(" Choississez d'abord la formule de vente à appliquer!");
				}
				function Alert1() {
					alertify.error(" Valider d'abord la Commande!");
				}
				function Alert2() {
					alertify.error(" Aucune donnée à imprimer!");
				}
				function remiseR() {//alert("hjjjd");
					if(document.getElementById('remise').value!=""){
						rem.innerHTML = parseInt(document.getElementById("total").value)-parseInt(document.getElementById('remise').value);
						document.getElementById('m').value=parseInt(document.getElementById("total").value)-parseInt(document.getElementById('remise').value);
						document.getElementById('remise').style.backgroundColor='#F3F39F';
						document.getElementById('remise').style.fontWeight='bold'; }
				}
				function monnaie() {
					if(document.getElementById('remise').value=="") {document.getElementById('remise').value=0;
					rem.innerHTML =parseInt(document.getElementById("total").value)-parseInt(document.getElementById('remise').value);}

						var it= parseInt(document.getElementById("total").value)-parseInt(document.getElementById('remise').value);

					  if(document.getElementById("Mtpercu").value>= it)
						  var Rx=parseInt(document.getElementById("Mtpercu").value) - it;
					  else
						  var Rx=0;
						mon.innerHTML = Rx;
						document.getElementById('Mtpercu').style.backgroundColor='#F3F39F';
						document.getElementById('Mtpercu').style.fontWeight='bold';

					document.getElementById('m').value=parseInt(document.getElementById("total").value)-parseInt(document.getElementById('remise').value);

				}

				function JSalert(){
					swal("Entrez ici le Nom du Client :", {
					  content: "input",
					})
					.then((value) => {
					  //swal(`Nom client : ${value}`);
					  document.getElementById('Nomclt').value=value;   var table = document.getElementById('NameTable').value;  var cv = document.getElementById('cv').value;
					  document.location.href='servir.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&clt='+value+'&table='+table+'&cv='+cv;
					});
				}

				function redirect() {
					document.location.href='servir.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>';
				}


			</script>
	</head>
	<body bgcolor='azure' style="" > 
		<div class="container">
		<div style='margin-left:0%;float:left;'><form action='' method='post'>
		<?php
		$printf=0;
		echo "<span style='display:block;font-weight:bold;font-size:135%;color:maroon;font-family:cambria;'>Liste des tables du Restaurant&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		
		echo "<span style='font-size:0.8em;color:#006D80;float:right;'>";
		
		if(!empty($_GET['p'])){ $_SESSION['p']=$_GET['p'];
			echo "<script language='javascript'>";
			echo 'swal("Vous êtes sur le point de retirer votre serveur(se) de la table. Voulez-vous continuer ?", {
			  dangerMode: true, buttons: true,
			}).then((value) => { var Es = value;  document.location.href="servir.php?menuParent='.$_SESSION['menuParenT'].'&test="+Es;
			}); ';
			echo "</script>";
		}  //https://sweetalert.js.org/docs/#configuration
		if(!empty($_GET['test'])&& ($_GET['test']=='true')){
			//echo $_SESSION['p'];
/* 			$rz="SELECT * FROM produits WHERE Num='".$_SESSION['aj']."' AND Type='".$_SESSION['menuParenT1']."'"; $req=mysqli_query($con,$rz);
			$data=mysqli_fetch_object($req);  $Qte_initial= $data->Qte_Stock; $Qte_Stock=$Qte_initial+$_SESSION['qte'];$update=$data->Num2 ;
		 	$rek="UPDATE produits SET Qte_Stock='".$Qte_Stock."',StockReel='".$Qte_Stock."' WHERE Num='".$_SESSION['aj']."' AND Type='".$_SESSION['menuParenT1']."'";
			$query = mysqli_query($con,$rek) or die (mysqli_error($con)); $ref="PRIN".$update ;  $service=" "; $designationOperation ='Mise à jour Produits';
			if($query){
			$re="INSERT INTO operation VALUES(NULL,'".$ref."','".$designationOperation."','".$update."','".$Qte_initial."','".$_SESSION['qte']."','".$Qte_Stock."','".$Jour_actuel."','".$Heure_actuelle."','','".$_SESSION['qte']."')";
			$req=mysqli_query($con,$re);
			echo "<script language='javascript'>";
			echo 'alertify.success(" Opération effectuée avec succès !");';
			echo "</script>"; */
		} 
		
		
		
		//<a href='' onclick='edition1();return false;' id='lien1' style='background-color: gold;color:#444739;font-style:italic;text-decoration:none;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'>Ajouter une table </a>&nbsp;";
		
/* 			echo "&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<a href='servir.php?menuParent=".$_SESSION['menuParenT']."&serv=1' style='text-decoration:none;font-size:1.1em;'>
			<span style='color:#ff103c;font-weight:bold;font-size:75%;'>Serveurs</span></a> &nbsp;|"; */
			echo "<a href='servir.php?menuParent=".$_SESSION['menuParenT']."&tab=1&trie=1' style='text-decoration:none;font-size:1.1em;' class='info2'>
			<img src='logo/Resto/circle.png' alt='' width='30' height='25' border='1'><span style='color:#ff103c;font-weight:bold;font-size:75%;'>Trier les tables</span></a>";
		echo "</span>";	
		//echo '<i class="fas fa-user-plus"></i>';
		echo '<br/>';
		if(!empty($_GET['trie'])){
			$req="(SELECT tableencours.numTable AS numTable,RTables.NbreCV AS NbreCV,tableencours.updated_at AS updated_at FROM tableencours,RTables WHERE RTables.nomTable=tableencours.numTable AND created_at='".$Jour_actuel."' AND Etat <> 'Desactive' ORDER BY updated_at DESC)
			UNION 
			(SELECT * FROM RTables WHERE nomTable NOT IN (SELECT numTable FROM tableencours,RTables WHERE RTables.nomTable=tableencours.numTable AND created_at='".$Jour_actuel."' AND Etat <> 'Desactive'))"; 
			$reqsel=mysqli_query($con,$req); $j=0; $array = array(); 
			while($data=mysqli_fetch_array($reqsel))
				{
					$NbreCV=$data['NbreCV']; $Heure=$data['updated_at']; 	$j++; 
				  $i=$data['numTable']; if($i<10) $ii="0".$i; else $ii=$i;$array[$j]=$i; 			
				  $checkFormaHour = explode(":",$Heure); 
				  $reqsel0=mysqli_query($con,"SELECT Serveurassoc FROM RTables WHERE nomTable='".$i."'");$data0=mysqli_fetch_object($reqsel0);
				  $query=mysqli_query($con,"SELECT Serveurassoc FROM tableEnCours WHERE numTable='".$i."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'"); $data1=mysqli_fetch_object($query);
				  $Serveurassoc=!empty($data1->Serveurassoc)?$data1->Serveurassoc:$data0->Serveurassoc; if(!empty($Serveurassoc)) $user="user0"; else $user="user";			  
					if(($j==1)||(($j!=0)&&($array[$j-1]!=$i))){				
					echo " <table  WIDTH='' style=' border-spacing: 5px 5px;border:3px solid white;"; if($j%5!=0) echo "float:left;";  echo "' class=''>
					<tr>
						<td style='padding: 10px;padding-bottom: 10px;'><a href='' class='info2' id='test'>";
							if(count($checkFormaHour)!=3) $Heure="&nbsp;"; 
							//echo "<span style='color:white;display:block;float:top;margin-left:20px;'>".$Heure."</span>"; //else echo "<span style='color:blue;display:block;float:top;margin-bottom:-25px;'>&nbsp;</span>";
							echo "<input type='submit' class='bouton5' id='full' name='table' value='".$ii."' onclick='redirect();' style='width:90px;height:45px;font-size:1.2em;";
							if(count($checkFormaHour)==3) echo "background: #7E45D8;";
							echo "'/><span style='color:blue;display:block;position:relative;margin-top:-20px;background: white;z-index:1;width:25px;height:15px;border:0px solid white;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;display:block;top:0px;font-size:0.6em;font-weight:bold;color:maroon;'> &nbsp;"; echo $NbreCV." CV&nbsp;"; echo"</span>
							</a>&nbsp;";
							echo "&nbsp;<span style='color:white;position:sticky;z-index:1;'>".$Heure."</span>";
							echo "<a href='servir.php?menuParent=".$_SESSION['menuParenT']."&serv=1&tab=".$ii;
							
							if(!empty($data0->Serveurassoc)) echo "&p=1"; if(!empty($Serveurassoc)) echo "&serv=1"; else echo "&serv=0";
							
							echo "' class='info2' id='test'><span style='float:right;color:blue;display:block;position:relative;margin-top:-10px;background: white;z-index:1;width:20px;height:20px;border:0px solid white;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;display:block;top:0px;font-size:0.8em;color:maroon;";
							if(!empty($data0->Serveurassoc)) echo "border-bottom:20px solid yellow;";
							echo "'>"; 
							echo "<img src='logo/Resto/".$user.".png' alt='' width='20' height='20' border='1'>"; if(!empty($data0->Serveurassoc)) { $Serveurassoc ="<center>".$Serveurassoc."</center>"; //echo "<g style='color:gray;'>Retirer le mode permanent</g>"; 
							echo  "<center style=''><i class='fas fa-minus'></i></center>";
							}
							if(!empty($Serveurassoc)) echo "<span style='color:#B83A1B;font-size:1.2em;'>".$Serveurassoc; 
							else echo "<span style='color:gray;font-size:1.1em;'>Affecter un(e) serveur(se) <br/>de façon permanente à la table ";
							echo "</span>"; echo"</span>
							</a>
						</td>
						<td><span style='display:block;'>
						<a href='receipt.php' onclick='edition3();return false;' class='info'><span style='font-size:0.9em;color:maroon;font-weight:bold;'>Modifier</span> </a>
						</a></span></td>
					</tr></table>";
					}	else $j--;				
			if($i==$Nbre) $printf=1;		
			}			
		}else {
		for($i=1;$i<=$Nbre;$i++)
		{ if($i<10) $ii="0".$i; else $ii=$i;
		    $req="SELECT * FROM RTables WHERE nomTable='".$i."' ORDER BY nomTable DESC";
			//$req="SELECT * FROM tableencours WHERE numTable='".$i."' AND Etat <> 'Desactive' ORDER BY updated_at ";
			$reqsel=mysqli_query($con,$req);
			$data=mysqli_fetch_assoc($reqsel);$NbreCV=$data['NbreCV'];
			$query=mysqli_query($con,"SELECT Serveurassoc FROM tableEnCours WHERE numTable='".$i."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'"); $data1=mysqli_fetch_assoc($query);
			$Serveurassoc=!empty($data1['Serveurassoc'])?$data1['Serveurassoc']:$data['Serveurassoc']; //if(empty($Serveurassoc)) $Serveurassoc="&nbsp;";
			echo "
			<table  WIDTH='' style='border-spacing: 5px 5px;border:3px solid white;"; if($i%5!=0) echo "float:left;";  echo "' class=''>
				<tr>
					<td style='padding: 10px;padding-bottom: 10px;'><a href='' class='info2' id='test'>";  if(!empty($Serveurassoc)) $user="user0"; else $user="user"; //if(!empty($serv)) echo "<span style='color:white;display:block;float:top;margin-left:20px;'>".$Serveurassoc."</span>"; //else echo "<span style='color:blue;display:block;float:top;margin-bottom:-25px;'>&nbsp;</span>";
						echo "<input type='submit' class='bouton5' id='full' name='table' value='".$ii."' onclick='redirect();' style='width:90px;height:45px;font-size:1.2em;";
						if($table==$i) echo "border:2px solid red;";
						//if(!empty($tab))
							//$req="SELECT DISTINCT numTable FROM tableEnCours WHERE numTable='".$i."' AND Etat <> 'Desactive' ORDER BY HeureOccup";
						//else			
							$req="SELECT DISTINCT numTable FROM tableEnCours WHERE numTable='".$i."' AND created_at='".$Jour_actuel."' AND Etat <> 'Desactive'";
							$reqsel2=mysqli_query($con,$req);
							$data1=mysqli_fetch_assoc($reqsel2);
									if($data1['numTable']==$i) echo "background: #7E45D8;"; else echo "background: #00734F;";
						echo "'/><span style='color:blue;display:block;position:relative;margin-top:-20px;background: white;z-index:1;width:25px;height:15px;border:0px solid white;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;display:block;top:0px;font-size:0.6em;font-weight:bold;color:maroon;'> &nbsp;"; echo $NbreCV." CV&nbsp;"; echo"</span>
						</a>&nbsp;";
						echo "<a href='servir.php?menuParent=".$_SESSION['menuParenT']."&tab=".$ii; 
						
						if(!empty($data['Serveurassoc'])) echo "&p=1"; if(!empty($Serveurassoc)) echo "&serv=1"; else echo "&serv=0";
							
						echo "' class='info2' id='test'><span style='float:right;color:blue;display:block;position:relative;margin-top:-10px;background: white;z-index:1;width:20px;height:20px;border:0px solid white;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;display:block;top:0px;font-size:0.8em;color:maroon;";
						if(!empty($data['Serveurassoc'])) echo "border-bottom:20px solid yellow;";
						echo "'>"; 
						echo "<img src='logo/Resto/".$user.".png' alt='' width='20' height='20' border='1'>"; if(!empty($data['Serveurassoc'])) { $Serveurassoc ="<center>".$Serveurassoc."</center>"; //echo "<g style='color:gray;'>Retirer le mode permanent</g>"; 
						echo  "<center style=''><i class='fas fa-minus'></i></center>";
						}
						if(!empty($Serveurassoc)) echo "<span style='color:#B83A1B;font-size:1.2em;'>".$Serveurassoc; 
						else echo "<span style='color:gray;font-size:1.1em;'>Affecter un(e) serveur(se) <br/>de façon permanente à la table ";
						echo "</span>"; echo"</span>
						</a>
					</td>
					<td><span style='display:block;'>
					<a href='receipt.php' onclick='edition3();return false;' class='info'><span style='font-size:0.9em;color:maroon;font-weight:bold;'>Modifier</span> </a>
					</a></span></td>
				</tr>
			</table>"; if($i==$Nbre) $printf=1;
		}
		}
		echo "</form>";
		
		 if($printf==1)  {
 				echo "<br/><br/>";
			/*	echo "&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<a href='servir.php?menuParent=".$_SESSION['menuParenT']."&serv=1' style='text-decoration:none;font-size:1.1em;'>
			<span style='color:#ff103c;font-weight:bold;font-size:75%;'>Serveurs -> Tables</span></a> &nbsp;|<a href='servir.php?menuParent=".$_SESSION['menuParenT']."&tab=1&trie=1' style='text-decoration:none;font-size:1.1em;'>
			<span style='color:#ff103c;font-weight:bold;font-size:75%;'>Trier les tables</span></a>"; */
			}
		?>	
		</div>
		<div style='margin-top:0%;width:auto;float:right;'><span style='font-weight:bold;font-size:135%;color:maroon;font-family:cambria;float:left;display:inline;'>
		<?php if((empty($table))&&(empty($vt))) echo "<a href='servir.php?menuParent=".$_SESSION['menuParenT']."&vt=1&tk=1'   id='lien1' style='text-decoration:none;'></a>";
		else if((empty($table))&&(!empty($vt))) echo "<span style='color:#444739;font-weight:bold;'>Formule de vente : Takeaway</span>";
		else if(!empty($table)) {echo "<span style='color:#444739;font-weight:bold;'>Formule de vente : Occupation d'une table</span>"; }  else {}

	 		echo "</span>"; if((empty($table))&&(empty($vt))) echo "<span style='float:left;font-weight:bold;'></span>
			<span style='float:right;font-weight:bold;'><a href='servir.php?menuParent=".$_SESSION['menuParenT']."&vt=1&tk=1' id='lien1' class='info2' style='color:red;text-decoration:none;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'>
			<span style='font-size:0.8em;'>Takeaway</span> <img src='logo/Resto/take-away.png' alt='' width='40' height='45' border='1' style='position:relative;margin-top:-14px;background: white;z-index:1;'></a> </span>";
		?>
		<h2 style='font-size:1.1em;color:maroon;font-family:cambria;'>&nbsp;&nbsp;  </h2>

				<?php if((!empty($table))||(!empty($vt))||(!empty($tk)))
					{include('serv.php');
					}
					else if(isset($_GET['print'])){
						include('receiptH.php');
					}
					else
						{ //echo "<br/>";
							echo "<img title='' src='logo/1/".rand(1,3).".jpg' width='500' height='340' style='max-width:500px;border:3px solid white;'/>	";
						}

		$req="SELECT DISTINCT tableEnCours.num_facture as num_facture,heure_emission,montant_ttc,NomClient,factureResto.numTable,factureResto.id AS id FROM tableEnCours,factureResto WHERE factureResto.num_facture=tableEnCours.num_facture AND created_at='".$Jour_actuel."' AND Etat LIKE 'Desactive' AND factureResto.num_facture<>'' ORDER BY factureResto.id DESC LIMIT 5";
		$reqsel2=mysqli_query($con,$req);
		if(mysqli_num_rows($reqsel2)>0) {
				?>
				<hr/>
				<h5>LISTE DES DERNIERES FACTURES EMISES</h5><span style='float:right;margin-top:-20px;'><?=$Date_actuel2 ?></span>
				<hr/>
				<table class='rouge1' style='width:500px;border:2px solid gray;background-color:#F4FEFE;font-family:Calibri;font-size:1em;'>
		 
    <thead>
      <tr style='background-color:#DCDCDC;border:1px solid gray;'>
        <th align="left">NUMERO</th>
		<th align="left">&nbsp;HEURE</th>
		<th style="text-align: left;">CLIENT</th>
		<th style="text-align: left;">Table</th>
        <th style="text-align: center;">TOTAL </th>
		<th style="text-align: right;">IMPRIMER</th>
		
      </tr>
    </thead>

    <tbody id="tablbody">
<?php   $cpteur=1;
		while($data=mysqli_fetch_array($reqsel2)){
			if($cpteur == 1)
			{
				$cpteur = 0;
				$bgcouleur = "white";$color = "#FC7F3C";
			}
			else
			{
				$cpteur = 1;
				$bgcouleur = "#dfeef3";$color = "red"; 
			}
		  $i=$data['numTable']; if($i<10) $table="0".$i; else $table=$i;
		  echo "<tr class='rouge1' bgcolor='".$bgcouleur."' style='border:1px solid gray;'>
			<td align='left' style='color:maroon;'>&nbsp;&nbsp;&nbsp;".$data['num_facture']."</td>
			<td align='left'>".$data['heure_emission']."</td>
			<td style='text-align: left;'> "; echo $client=!empty($data['NomClient'])?substr($data['NomClient'],0,75):"#Non renseigné#"; echo"</td>
			<td style='text-align: center;'>"; echo $table=($table!="00")?substr($table,0,35):"-"; echo"</td>
			<td style='text-align: right;color:maroon;'>".$data['montant_ttc']."</td>
			 <td style='text-align:right;'>";
			 //echo "<a class='info2' href='servir.php?print=1' onclick='edition6(".$data['id'].");return false;'> <span style='font-size:0.9em;font-style:normal;color:black;'>Impression</span>	 <i class='fas fa-print' style='color:".$color."' aria-hidden='true' style='font-size:100%;'></i></a>";
			//echo "<a href='#' class='info2' id='ticketLink-".$data['id']."' data-bs-toggle='modal' data-bs-target='#ticketModal' data-ticket-id='".$data['id']."'><span style='font-size:0.9em;font-style:normal;color:black;'>Impression</span>	 <i class='fas fa-print' style='color:".$color."' aria-hidden='true' style='font-size:100%;'></i></a>";
		?>  
		<a href='' class='info2'class='quickview' data-link-action='quickview'  data-bs-toggle='modal' data-bs-target='#ec_quickview_modal<?=$data['id'];?>'> <span style='font-size:0.9em;font-style:normal;color:black;'>Impression</span><i class='fas fa-print' style='color:<?=$color;?>' aria-hidden='true' style='font-size:100%;'></i></a>

		<!-- Modal -->
    <div class="modal fade" id="ec_quickview_modal<?=$data['id'];?>" tabindex="-1" role="dialog" aria-labelledby="ticketModalLabel" aria-hidden="true">			
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ticketModalLabel">Ticket de Restaurant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Contenu du ticket de restaurant -->
                <div class="ticket" id="printable-ticket">
                    <div class="header">
						<div style="float:left;">
								<img class="img-responsive" alt="" src="<?php if(!empty($_SESSION['logo'])) echo $_SESSION['logo']; ?>" style="width:90px;height:90px;">
						</div>
						<div>
            			<h5><?php 	
						if(!empty($nomHotel)) echo $nomHotel;  echo "</h5>";
						if(!empty($Apostale))
							echo  "<p>".$Apostale."</p> ";
						if(!empty($NumUFI))
							echo  "<p>N° IFU: ".$NumUFI."</p> ";
	/* 					if(!empty($NumBancaire))
							echo  "<p>Compte Bancaire: ".$NumBancaire."</p>  ";
						else {
						} */
					?>
					<p> <i class="fa fa-phone"></i>&nbsp;<?php echo $telephone1." - ".$telephone2; ?></p>
					<p><?php echo $Email; ?></p>
						
					<?php
							
					$table=(isset($_SESSION['Ntable'])&&(!empty($_SESSION['Ntable']))) ? $_SESSION['Ntable']:NULL; $num_facture=isset($_SESSION['numFact'])?$_SESSION['numFact']:NULL;
					if (isset($data['id'])) {
						$param0 = $data['id'];
						$req="SELECT * FROM factureResto,tableEnCours WHERE tableEnCours.num_facture=factureResto.num_facture AND factureResto.id='".htmlspecialchars($param0)."' ";
						$reqselRTables=mysqli_query($con,$req);
					} else if(isset($num_facture)) {
						$req="SELECT * FROM factureResto,tableEnCours WHERE tableEnCours.num_facture=factureResto.num_facture AND factureResto.num_facture='".trim($num_facture)."' ";
						$reqselRTables=mysqli_query($con,$req);
					}	
					else
					{ 
					}
					$factureResto=mysqli_query($con,$req);
					while($data1=mysqli_fetch_array($factureResto)){ $Net=$data1['montant_ttc']-$data1['Remise'];
					$SommePayee=$data1['somme_paye']; $monnaie=$SommePayee-$Net;$remise=$data1['Remise'];
					 $NomClient=!empty($data1['NomClient'])?$data1['NomClient']:"<g>Non renseigné</g>";
					 $heure=$data1['heure_emission'];$numRecu=$data1['num_facture'];
					}	
					?>
				</div>
			</div>

			  <div class="info">
					<small><?php if(!empty($Date_actuel)) echo date('d')."-". date('m')."-".date('Y');  ?> à <?php echo $heure="18:55"; ?></small>
					<center>
							<h6 style='font-weight:bold;background-color:#e5e5e5;'> Ticket N°: <?php echo $numRecu; ?> </h6>
					</center>
					<div>
						<p style='float:left;'>Client  :  <?php echo $NomClient; ?>	</p>
						
						<p style='float:right;'>Caissier : <?php echo $_SESSION["nom"]." ".$_SESSION["prenom"]; ?> </p>
					</div>	

				</div>
  <div class="content">
						
	<table style='font-size:0.9em;'>
    <tr style='background-color:#e5e5e5;font-weight:bold;'>
	   <td style=''>Désignation</td>
		<td align='right'>Prix</td>
		<td style='text-align:center;'>Qté</td>
		<td style='text-align:right;'>Montant</td>
    </tr>			
		<?php
		if(isset($reqselRTables)){$total=0;$num=0;//$mt=0;
			while($data1=mysqli_fetch_array($reqselRTables)){ $num++;
			$mt=$data1['qte']*$data1['prix'];$total+=$mt;
				echo "<tr>
					<td class='' >".ucfirst($data1['LigneCde'])." ".$data1['QteInd']."</td>
					<td align='right' class=''> ".$data1['prix']."</td>
					<td align='center' class=''> ".$data1['qte']."</td>
					<td  align='right' class=''> ".$mt."</td>
				</tr>";
			}
		   }
		   
			  echo 	"
			  <tr>
		<td colspan='1' rowspan='4' align='left'><strong> Total TVA [18%] : 123455 </strong></td>
			  </tr>
			  <tr>
				<td  colspan='2' align='right'> <strong> Montant Total : </strong>  ";
				if($remise>0)
					echo "<br/><strong> Remise accordée : </strong>";

				echo "<br/><strong> Net à payer :</strong>
				<br/><strong> Somme payée :</strong> ";
				if($monnaie>0)
					echo "<br/><strong> Monnaie : </strong> </td>";
					?>
					<td align='right' style=''><strong><i class=""></i> <?php echo $total;?>
					<br/><?php echo $Net;?><br/>	<?php echo $SommePayee;?></strong>									

				<?php
				if($remise>0)
					echo " <br/><strong><i class=''></i> ". $remise."</strong> ";

				if($monnaie>0)
					echo "<br/><strong><i class=''></i> ". $monnaie."</strong> </td>
			</tr>";

				//QRcode::png('code data text', 'filename.png'); // creates file
				//QRcode::png('some othertext 1234'); // creates code image and outputs it directly into browser
	 ?>
	
	</table>

				</div>
				
				<div class="total" style='background-color:#e5e5e5;'>
				<span style='font-weight:normal;font-size:0.9em;float:left;padding-left:5px;'>Mode de règlement : <?php echo $mode="Espèce";?></span>
				<span style='padding-right:5px;'>Total encaissé : <strong><?php echo $total;?></strong></span>
				</div>

				<div class="footerT">
					<center>
					<?php $generator = new BarcodeGeneratorHTML();
						echo $generator->getBarcode($numRecu, $generator::TYPE_CODE_128);?><br/>
						Merci de votre visite !</center>
				</div>				
					
                </div>
            </div>
        </div>
    </div>
	</div>
	<!-- Modal end -->
						
		<?php 
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		  </tr>";		
		}							
		echo "</tbody></table>";
	} 
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
     // Détecter l'ouverture de la modale et lancer l'impression
    const ticketModal = document.getElementById('ticketModal');
    ticketModal.addEventListener('shown.bs.modal', () => {
        // Imprimer le contenu du ticket
        setTimeout(() => {
            window.print();
        }, 500);  // Lancer l'impression après un court délai pour s'assurer que le contenu est affiché
    });
	
	
/*
// Sélectionner tous les liens qui ouvrent la modale avec `data-bs-target='#ticketModal'`
document.querySelectorAll("[data-bs-target='#ticketModal']").forEach(link => {
    link.addEventListener('click', function() {
        // Récupérer la valeur de `data-ticket-id` de l'élément cliqué
        const ticketId = this.getAttribute('data-ticket-id');
        
        // Afficher le contenu du ticket dans la modale
        document.getElementById('ticketContent').textContent = `Ticket ID: ${ticketId}`;

        // Si nécessaire, vous pouvez effectuer d'autres actions avec `ticketId`
        console.log("Ticket ID capturé : ", ticketId);
    });
});

function myFunction(param) {
    // Affiche le paramètre dans la modale
    document.getElementById('modalParam').textContent = param;

    // Affiche la modale
    var myModal = new bootstrap.Modal(document.getElementById('ticketModal'));
    myModal.show();
}
 */
</script>




		</div>
		</div>

		<input type='hidden' value='﻿<?php if(isset($del)) echo $del;?>'>
			
	</body>
</html>
