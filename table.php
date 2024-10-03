<?php
include_once 'menu.php';  //if(isset($_SESSION['quantify'])) echo $_SESSION['quantify'];
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
				//echo '<meta http-equiv="refresh" content="0; url=table.php" />';
	//}else $reqselRTables=mysqli_query($con,"SELECT * FROM tableEnCours WHERE numTable='0' AND Etat<> 'Desactive'");

	$vt = !empty($_GET['vt'])?$_GET['vt']:NULL;  $val = !empty($_GET['val'])?$_GET['val']:NULL; if(empty($val)) { if(!isset($_GET['del'])) unset($_SESSION['Ntable']); unset($_SESSION['cv']);}
	$del = !empty($_GET['del'])?$_GET['del']:NULL;

/* 	if (!empty($del))
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
		   //echo '<meta http-equiv="refresh" content="2; url=table.php" />';
		} */


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


		</style>
			<script type="text/javascript" >
				function edition1() { options = "Width=800,Height=450" ; window.open( "tableP.php", "edition", options ) ; }
				function edition2() { options = "Width=800,Height=400" ; window.open( "ServP.php", "edition", options ) ; }
				//function edition3() { options = "Width=800,Height=450" ; window.open( "receipt2.php", "edition", options ) ; }
				function edition4() { options = "Width=800,Height=450" ; window.open( "frameFood.php", "edition", options ) ; }
				function edition9() { options = "Width=800,Height=450" ; window.open( "framePFood.php", "edition", options ) ; }
				function edition5() { options = "Width=800,Height=450" ; window.open( "frameDrink.php", "edition", options ) ; }
				function edition8() { options = "Width=800,Height=450" ; window.open( "framePDrink.php", "edition", options ) ; }
				function edition6() { options = "Width=auto,Height=auto" ; window.open( "receipt2.php", "edition", options ) ; }
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
					  document.location.href='table.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&clt='+value+'&table='+table+'&cv='+cv;
					});
				}

				function redirect() {
					document.location.href='table.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>';
				}


			</script>
	</head>
	<body bgcolor='azure' style="" > 
		<div class="container">
		<div style='margin-left:0%;float:left;'><form action='' method='post'>
		<?php
		$printf=0;
		
			if(!empty($_GET['del'])){ $_SESSION['del']=$_GET['del'];
			echo "<script language='javascript'>";
			echo 'swal("Vous êtes sur le point de supprimer la table. Voulez-vous continuer ?", {
			  dangerMode: true, buttons: true,
			}).then((value) => { var Es = value;  document.location.href="table.php?menuParent='.$_SESSION['menuParenT'].'&test="+Es;
			}); ';
			echo "</script>";
		}  //https://sweetalert.js.org/docs/#configuration
		if(!empty($_GET['test'])&& ($_GET['test']=='true')){
			//echo $_SESSION['del'];
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
		
		
		echo "<span style='display:block;font-weight:bold;font-size:135%;color:maroon;font-family:cambria;'>Liste des tables du Restaurant&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		
		echo "<span style='font-size:0.8em;color:#006D80;float:right;'>";
		echo "&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<a href='' onclick='edition1();return false;' id='lien1' style='background-color:white;color:#444739;text-decoration:none;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'>Nouveau</a>";
		echo "</span>";	

		echo '<br/>';
		if(!empty($_GET['trie'])){
/* 			$req="(SELECT DISTINCT tableencours.numTable AS numTable,RTables.NbreCV AS NbreCV,tableencours.updated_at AS updated_at FROM tableencours,RTables WHERE RTables.nomTable=tableencours.numTable AND created_at='".$Jour_actuel."' AND Etat <> 'Desactive' ORDER BY updated_at DESC)
			UNION 
			(SELECT * FROM RTables WHERE nomTable NOT IN (SELECT numTable FROM tableencours,RTables WHERE RTables.nomTable=tableencours.numTable AND created_at='".$Jour_actuel."' AND Etat <> 'Desactive'))"; 
			$reqsel=mysqli_query($con,$req); $j=0; $array = array(); 
			while($data=mysqli_fetch_array($reqsel))
				{$NbreCV=$data['NbreCV']; $Heure=$data['updated_at']; 	$j++; 
				  $i=$data['numTable']; if($i<10) $ii="0".$i; else $ii=$i;$array[$j]=$i; 			
				  $checkFormaHour = explode(":",$Heure);			
				if(($j==1)||(($j!=0)&&($array[$j-1]!=$i))){				
					echo " <table  WIDTH='' style=' border-spacing: 5px 5px;border:3px solid white;"; if($j%5!=0) echo "float:left;";  echo "' class=''>
					<tr>
						<td style='padding: 10px;padding-bottom: 10px;'><a href='' class='info2' id='test'>";
							if(count($checkFormaHour)!=3) $Heure="&nbsp;"; 
							echo "<span style='color:white;display:block;float:top;margin-left:20px;'>".$Heure."</span>"; //else echo "<span style='color:blue;display:block;float:top;margin-bottom:-25px;'>&nbsp;</span>";
							echo "<input type='submit' class='bouton5' id='full' name='table' value='".$ii."' onclick='redirect();' style='width:90px;height:45px;font-size:1.2em;";
							if(count($checkFormaHour)==3) echo "background: #7E45D8;";
							echo "'/><span style='color:blue;display:block;position:relative;margin-top:-20px;background: white;z-index:1;width:25px;height:15px;border:0px solid white;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;display:block;top:0px;font-size:0.6em;font-weight:bold;color:maroon;'> "; echo $NbreCV." CV&nbsp;"; echo"</span>
							</a>
						</td>
						<td><span style='display:block;'>
						<a href='receipt.php' onclick='edition3();return false;' class='info'><span style='font-size:0.9em;color:maroon;font-weight:bold;'>Modifier</span> </a>
						</a></span></td>
					</tr></table>";
					}	else $j--;				
			if($i==$Nbre) $printf=1;		
			} */			
		}else {
		for($i=1;$i<=$Nbre;$i++)
		{ if($i<10) $ii="0".$i; else $ii=$i;
		    $req="SELECT * FROM RTables WHERE nomTable='".$i."' ORDER BY nomTable DESC";
			//$req="SELECT * FROM tableencours WHERE numTable='".$i."' AND Etat <> 'Desactive' ORDER BY updated_at ";
			$reqsel=mysqli_query($con,$req);
			$data=mysqli_fetch_assoc($reqsel);$NbreCV=$data['NbreCV'];
			$query=mysqli_query($con,"SELECT Serveurassoc FROM tableEnCours WHERE numTable='".$i."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'"); $data1=mysqli_fetch_assoc($query);
			$Serveurassoc=!empty($data1['Serveurassoc'])?$data1['Serveurassoc']:$data['Serveurassoc']; if(empty($Serveurassoc)) $Serveurassoc="&nbsp;";
			echo "
			<table  WIDTH='' style='border-spacing: 5px 5px;border:3px solid white;"; if($i%5!=0) echo "float:left;";  echo "' class=''>
				<tr>
					<td style='padding: 10px;padding-bottom: 10px;'>";  if(!empty($serv)) echo "<span style='color:white;display:block;float:top;margin-left:20px;'>".$Serveurassoc."</span>"; //else echo "<span style='color:blue;display:block;float:top;margin-bottom:-25px;'>&nbsp;</span>";
						echo "<input type='submit' class='bouton5' id='full' name='' value='".$ii."' onclick='redirect();' style='width:90px;height:45px;font-size:1.2em;";
						if($table==$i) echo "border:2px solid red;";
							$req="SELECT DISTINCT numTable FROM tableEnCours WHERE numTable='".$i."' AND created_at='".$Jour_actuel."' AND Etat <> 'Desactive'";
							$reqsel2=mysqli_query($con,$req);
							$data1=mysqli_fetch_assoc($reqsel2);
									//if($data1['numTable']==$i) echo "background: #7E45D8;"; else 
									echo "background: #00734F;";
						echo "'/>";
						echo "<a href='table.php?menuParent=".$_SESSION['menuParenT']."&edit=1&tab=".$ii."' class='info2' id='test'><span style='color:blue;display:block;position:relative;margin-top:-10px;background: white;z-index:1;width:20px;height:15px;border:0px solid white;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius:5px;display:block;top:0px;font-size:0.8em;color:maroon;'>"; 
						echo "<img src='logo/modifier.png' alt='' width='20' height='20' border='1'><span style='color:#FC7F3C;font-size:1.2em;'>Modifier</span>"; echo"</span>
						</a>&nbsp;";
						echo $NbreCV." CV&nbsp;";
						echo "<a href='table.php?menuParent=".$_SESSION['menuParenT']."&del=1&tab=".$ii."' class='info2' id='test'><span style='float:right;color:blue;display:block;position:relative;margin-top:-10px;background: white;z-index:1;width:20px;height:15px;border:0px solid white;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;display:block;top:0px;font-size:0.8em;color:maroon;'>"; 
						echo "<img src='logo/b_drop.png' alt='Supprimer' width='20' height='20' border='1'><span style='color:#B83A1B;font-size:1.2em;'>Supprimer</span>"; echo"</span>
						</a>
					</td>
					<td><span style='display:block;'>
					<a href='receipt.php' onclick='edition3();return false;' class='info'><span style='font-size:0.9em;color:maroon;font-weight:bold;'>Modifier</span> </a>
					</a></span></td>
				</tr>
			</table>"; 
		}
		}
		echo "</form>";

		?>	
		</div>
		<div style='margin-top:0%;width:auto;float:right;'><span style='font-weight:bold;font-size:135%;color:maroon;font-family:cambria;float:left;display:inline;'>
		<?php if((empty($table))&&(empty($vt))) echo "<a href='table.php?menuParent=".$_SESSION['menuParenT']."&vt=1&tk=1'   id='lien1' style='text-decoration:none;'></a>";
		else if((empty($table))&&(!empty($vt))) echo "<span style='color:#444739;font-weight:bold;'>Formule de vente : Takeaway</span>";
		else if(!empty($table)) {echo "<span style='color:#444739;font-weight:bold;'>Formule de vente : Occupation d'une table</span>"; }  else {}

	 		echo "</span>"; if((empty($table))&&(empty($vt))) echo "<span style='float:left;font-weight:bold;'><a href='table.php?menuParent=".$_SESSION['menuParenT']."&vt=1&tk=1' id='lien1' class='info' style='border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;background-color:white;color:#444739;text-decoration:none;'> Liste des serveur(se)s&nbsp;</a> </span>
			<span style='float:right;font-weight:bold;'><a href='' onclick='edition2();return false;'  id='lien1' class='info2' style='background-color:white;color:#444739;text-decoration:none;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'><span style='font-size:0.7em;'>Ajouter un(e) serveur(se)</span> <i style='font-size:25px;'  class='fas fa-user-plus'></i></a> </span>";
		?>
		<h2 style='font-size:1.1em;color:maroon;font-family:cambria;'>&nbsp;&nbsp;  </h2>

				<?php if((!empty($table))||(!empty($vt))||(!empty($tk)))
					{include('serv.php'); //header('Location: table.php');
					}
					else if(isset($_GET['print'])){
						include('receiptH.php');
					}
					else
						{ //echo "<br/>";
							echo "<img title='' src='logo/resto/".rand(1,2).".png' width='' height='' style='max-width:500px;border:3px solid white;padding-left:5px;padding-right:5px;'/>	";
						}
				?>
		</div>
		</div>

		<input type='hidden' value='﻿<?php if(isset($del)) echo $del;?>'>
			
	</body>
</html>
