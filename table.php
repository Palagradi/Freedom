<?php
include_once 'menu.php';  //if(isset($_SESSION['quantify'])) echo $_SESSION['quantify'];
// https://www.youtube.com/watch?v=xYc4AO_wQgM
//https://sweetalert.js.org/docs/#content
	$reqTable=mysqli_query($con,"SELECT * FROM RTables WHERE status=0");
	$Nbre=mysqli_num_rows($reqTable);

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
		   $reqsel=mysqli_query($con,"SELECT * FROM RTables WHERE numTable='".$table."'");
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
		while($dataT=mysqli_fetch_object($reqTable)){		
		$i=$dataT->nomTable ;
		//for($i=1;$i<=$Nbre;$i++){
			if (isset($_POST['table']) and $_POST['table']==$i)
				{ if($i<10) $table="0".$i; else $table=$i;
					$_SESSION['Ntable']=$i;
					$reqsel=mysqli_query($con,"SELECT * FROM RTables WHERE status=0 AND nomTable='".$i."'");
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
			
		<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> !-->
		<link rel="stylesheet" href="js/bootstrap2.min.css">
		<script src="js/bootstrap2.bundle.min.js"></script>

			
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script src="js/sweetalert.min.js"></script>	
		<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> !-->
		<script src="js/sweetalert2.min.js"></script>

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
				//function edition1() { options = "Width=800,Height=450" ; window.open( "tableP.php", "edition", options ) ; }
				//function edition2() { options = "Width=800,Height=400" ; window.open( "ServP.php", "edition", options ) ; }
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
		
			if(!empty($_GET['del'])){ $_SESSION['del']=$_GET['del'];$_SESSION['tab']=$_GET['tab'];$tabName=$_GET['tab'];
			echo "<script language='javascript'>";		
			
			if($_GET['del']==1){
				if($_GET['status']==0)
				echo 'swal("Vous êtes sur le point de désactiver la table { ' . htmlspecialchars($tabName) . ' }. Voulez-vous continuer ?", {
				  dangerMode: true, buttons: true,
				}).then((value) => { var Es = value;  document.location.href="table.php?menuParent='.$_SESSION['menuParenT'].'&desactive="+Es;
				}); ';
				else 
				echo 'swal("Vous êtes sur le point d\'activer à nouveau la table  { ' . htmlspecialchars($tabName) . ' }.  Voulez-vous continuer ?", {
				  dangerMode: true, buttons: true,
				}).then((value) => { var Es = value;  document.location.href="table.php?menuParent='.$_SESSION['menuParenT'].'&desactive="+Es+"&status=1";
				}); ';	
			}else {
				echo 'swal("Vous êtes sur le point de supprimer la table { ' . htmlspecialchars($tabName) . ' }. Voulez-vous continuer ?", {
				  dangerMode: true, buttons: true,
				}).then((value) => { var Es = value;  document.location.href="table.php?menuParent='.$_SESSION['menuParenT'].'&delete="+Es;
				}); ';
			}

			echo "</script>";
		}  //https://sweetalert.js.org/docs/#configuration
		if(!empty($_GET['desactive'])&& ($_GET['desactive']=='true')){
			if(isset($_SESSION['tab'])) {
				$table=(int)($_SESSION['tab']);
				$sql = "SELECT * FROM tableEnCours WHERE numTable='".$table."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'";
				$reqselRTables=mysqli_query($con,$sql);
				if(mysqli_num_rows($reqselRTables)>0){
					echo "<script language='javascript'>";
					echo 'alertify.error("La table est occupée par un client. Vous ne pouvez pas la désactiver !");';
					echo "</script>";
				}else {
						if(isset($_GET['status']))
							$Query="UPDATE rtables SET status =0 WHERE nomTable='".$table."'";
						else 
							$Query="UPDATE rtables SET status =1 WHERE nomTable='".$table."'";
						$exec=mysqli_query($con,$Query);
						echo "<script language='javascript'>";
						if(isset($_GET['status']))
							echo 'alertify.success("Table activée avec succès !");';
						else 
							echo 'alertify.success("Table désactivée avec succès !");';
						echo "</script>";
						//echo '<meta http-equiv="refresh" content="1; url=table.php?menuParent='.$_SESSION['menuParenT'].'" />';
				}
			 
			}
		} 
		if(!empty($_GET['delete'])&& ($_GET['delete']=='true')){
			$Query="UPDATE rtables SET status =1,NbreCV=0,RealNameTable='',serveur=0 WHERE nomTable='".$_SESSION['tab']."'";
			$exec=mysqli_query($con,$Query);
			echo "<script language='javascript'>";
			echo 'alertify.success("Table supprimée avec succès !");';
			echo "</script>";
		}
		
		
		echo "<span style='display:block;font-weight:bold;font-size:135%;color:maroon;font-family:cambria;'>Liste des tables du Restaurant&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		
		echo "<span style='font-size:0.8em;color:#006D80;float:right;'>";
       echo "<a class='info2' href='#' onclick='newTable();return false;' style='background-color:white;color:#444739;text-decoration:none;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'>
					<span style='font-size:0.9em;font-style:normal;color:maroon;'>Nouveau&nbsp;</span>
					<i class='fas fa-plus-square' aria-hidden='true' style='font-size:140%;color:#FEBE89;'></i>
				</a>";
		echo "</span>";	

		echo '<br/>';
		if(!empty($_GET['trie'])){
			
		}else {
		$reqTable=mysqli_query($con,"SELECT * FROM RTables WHERE NbreCV<>0"); $j=0;
		while($dataT=mysqli_fetch_object($reqTable)){	$j++;	
		$i=$dataT->nomTable ;  
		//for($i=1;$i<=$Nbre;$i++){
			$ii=$i; if($i<10) $ii="0".$i;
		    $req="SELECT * FROM RTables WHERE nomTable='".$i."' ORDER BY nomTable DESC";
			$reqsel=mysqli_query($con,$req);
			$data=mysqli_fetch_assoc($reqsel);$NbreCV=$data['NbreCV'];$status=$data['status'];//$RealNameTable=$data['RealNameTable'];
			$query=mysqli_query($con,"SELECT serveur FROM tableEnCours WHERE numTable='".$i."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'"); $data1=mysqli_fetch_assoc($query);
			$serveur=!empty($data1['serveur'])?$data1['serveur']:$data['serveur']; if(empty($serveur)) $serveur="&nbsp;";
			echo "
			<table  WIDTH='' style='border-spacing: 5px 5px;border:3px solid white;"; if($j%5!=0) echo "float:left;";  echo "' class=''>
				<tr>
					<td style='padding: 10px;padding-bottom: 10px;'>";  if(!empty($serv)) echo "<span style='color:white;display:block;float:top;margin-left:20px;'>".$serveur."</span>"; //else echo "<span style='color:blue;display:block;float:top;margin-bottom:-25px;'>&nbsp;</span>";
						echo "<input type='submit' class='bouton5' id='full' name='' value='"; if(!empty($dataT->RealNameTable)) echo $dataT->RealNameTable; else echo $ii; echo "' onclick='redirect();' style='width:90px;height:45px;font-size:1.2em;";
						if($table==$i) echo "border:2px solid red;";
							$req="SELECT DISTINCT numTable FROM tableEnCours WHERE numTable='".$i."' AND created_at='".$Jour_actuel."' AND Etat <> 'Desactive'";
							$reqsel2=mysqli_query($con,$req);
							$data1=mysqli_fetch_assoc($reqsel2);
									//if($data1['numTable']==$i) echo "background: #7E45D8;"; else 
									echo "background: #00734F;";
							if($status==1) echo "background: gray;";							
						echo "'/>";
						echo "<a href='#' onclick='newTable(1, ".$ii.", \"".addslashes($dataT->RealNameTable)."\", ".$NbreCV."); return false;' class='info2' id='test'>
						<span style='color:blue; display:block; position:relative; margin-top:-10px; background: white; z-index:1; width:18px; height:15px; border:0px solid white; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius:5px; top:0px; font-size:0.8em; color:maroon;'>";
							//echo "<img src='logo/modifier.png' alt='' width='18' height='18' border='1'>";
							echo "<i class='fas fa-edit' style='color:#FFA500;font-size:1.1em;'></i>";
							echo "<span style='color:#FC7F3C; font-size:1.2em;'>Modifier</span>
						</span>
					  </a>&nbsp;";
						echo $NbreCV." CV&nbsp;";
						$req="SELECT * FROM tableEnCours WHERE numTable='".$i."'";
						$reqsel2=mysqli_query($con,$req);							 
						if(mysqli_num_rows($reqsel2)>0){
							echo "<a href='table.php?menuParent=".$_SESSION['menuParenT']."&del=1&tab=".$ii."&status=".$status."' class='info2' id='test'><span style='float:right;color:blue;display:block;position:relative;margin-top:-10px;background: white;z-index:1;width:20px;height:15px;border:0px solid white;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;display:block;top:0px;font-size:0.8em;color:maroon;'>";
							echo "<img src='logo/b_drop.png' alt='Désactiver' width='18' height='18' border='1'";  if($status==1) echo "style='background-color:#FFD700;'";  echo "><span style='color:#B83A1B;font-size:1.2em;'>";
							if($status==0) echo "Désactiver"; else echo "Activer"; echo "</span>"; echo"</span></a>";
						}else {
							echo "<a href='table.php?menuParent=".$_SESSION['menuParenT']."&del=2&tab=".$ii."&status=".$status."' class='info2' id='test'><span style='float:right;color:blue;display:block;position:relative;margin-top:-10px;background: white;z-index:1;border:0px solid white;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;display:block;top:0px;font-size:0.8em;color:maroon;'>";
							echo "<i class='fas fa-trash' style='color:#d10000;font-size:1.2em;'></i><span style='color:#B83A1B;font-size:1.2em;'>";
							echo "Supprimer"; echo "</span>"; echo"</span></a>";
						}
						
					echo "</td>
					<td><span style='display:block;'>
					<a href='receipt.php' onclick='edition3();return false;' class='info'><span style='font-size:0.9em;color:maroon;font-weight:bold;'>Modifier</span> </a>
					</a></span></td>
				</tr>
			</table>"; 
		}
		}
		echo "</form>";
		echo "<br/>";
 		for($i=39;$i<=100;$i++){
			//echo $sql = "INSERT INTO RTables SET nomTable='".$i."',status='1';";
			//$query = mysqli_query($con,$sql) or die (mysqli_error($con));
		}	 		

		?>	
		</div>
		<div style='margin-top:0%;width:auto;float:right;'><span style='font-weight:bold;font-size:100%;color:maroon;font-family:cambria;float:left;display:inline;'>
		<?php 
/* 		if((empty($table))&&(empty($vt))) echo "<a href='table.php?menuParent=".$_SESSION['menuParenT']."&vt=1&tk=1'   id='lien1' style='text-decoration:none;'></a>";
		else if((empty($table))&&(!empty($vt))) echo "<span style='color:#444739;font-weight:bold;'>Formule de vente : Takeaway</span>";
		else if(!empty($table)) {echo "<span style='color:#444739;font-weight:bold;'>Formule de vente : Occupation d'une table</span>"; }  else {}

	 		echo "</span>"; */
			//if((empty($table))&&(empty($vt))) 
				echo "<span style='float:left;font-weight:bold;'>
				<a href='table.php?menuParent=".$_SESSION['menuParenT']."&vt=1&tk=1' id='lien1' class='info' style='border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;background-color:white;color:#444739;text-decoration:none;'>&nbsp;Liste des serveur(se)s&nbsp;</a> </span>
				<span style='float:right;font-weight:bold;'>";
			
				echo "<a class='info2' href='#' onclick='newServ();return false;' style='background-color:white;color:#444739;text-decoration:none;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'>
					<span style='font-size:0.9em;font-style:normal;color:black;'>Ajouter un(e) serveur(se)&nbsp;</span>
					<i class='fas fa-user-plus' aria-hidden='true' style='font-size:140%;'></i>
				</a>";
			
			echo "</span>";
		?>
		<h2 style='font-size:1.1em;color:maroon;font-family:cambria;'>&nbsp;&nbsp;  </h2>

				<?php 
	/* 			if((!empty($table))||(!empty($vt))||(!empty($tk)))
					{
						//include('serv.php'); //header('Location: table.php');
						
					}
					else if(isset($_GET['print'])){
						include('receiptH.php');
					}
					else */
						{ //echo "<br/>";
							echo "<img title='' src='logo/resto/".rand(1,2).".png' width='' height='' style='max-width:500px;border:3px solid white;padding-left:5px;padding-right:5px;'/>	";
						}
				?>
		</div>
		</div>
		<input type='hidden' value='﻿<?php if(isset($del)) echo $del;?>'>
		<script>
function newTable(edit = 0, table = 0, tableName0 = null, NbreCV = 0)  {
    const title = edit === 1 ? "Modification de la table N° " + table : "Enregistrer une nouvelle Table";
    swal({
        title: title,
        content: {
            element: "div",
            attributes: {
                innerHTML: `
                <style>
                    .swal-custom-form {
                        display: flex;
                        flex-direction: column;
                        gap: 10px;
                        font-family: Arial, sans-serif;
                    }
                    .swal-custom-form .row {
                        display: flex;
                        align-items: center;
                    }
                    .swal-custom-form label {
                        width: 170px;
                        font-weight: bold;
                        color: maroon;
                        margin-right: 10px;
                        text-align: right;
                    }
                    .swal-custom-form select,
                    .swal-custom-form input {
                        flex: 1;
                        padding: 5px;
                        height: 25px;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        margin-right: 15px;
                    }
                </style>
                <div class='swal-custom-form'>
                    <div class='row'>
                        <fieldset>
                            ${edit === 0 ? `
                            <div class='row'>
                                <label for='tableNumber'>N° de la table :</label>
                                <select id='tableNumber' class='swal-content__input' style='height:30px;'>
                                    <option value=''>Sélectionner une table...</option>
                                </select>
                            </div><br/>
                            ` : ''}
                            <div class='row'>
                                <label for='tableName'>Nom de la table :</label>
                                <input id='tableName' type='text' ${edit === 1 ? ` value='${tableName0}' ` : ''} placeholder='Le Nom de la table est optionnelle.'/>
                            </div><br/>
                            <div class='row'>
                                <label for='covers'>Nbre de Couverts :</label>
                                <input id='covers' type='number' min='1' max='100' ${edit === 1 ? ` value='${NbreCV}' ` : ''} required='required'/>
                            </div>
                        </fieldset>
                    </div>
                </div>
                `
            }
        },
        buttons: true
    }).then((willSubmit) => {
        if (willSubmit) {
            const tableNumber = document.getElementById('tableNumber') ? document.getElementById('tableNumber').value.trim() : '';
            const tableName = document.getElementById('tableName').value.trim();
            const covers = document.getElementById('covers').value.trim();

            // Validation
            if (!tableNumber && edit === 0) {
                swal("Erreur", "Le Numéro de la table est requis.", "error");
                return;
            }
            if (!covers) {
                swal("Erreur", "Précisez le nombre de couverts.", "error");
                return;
            }

            // Envoi des données en AJAX
            const formData = new FormData();
            formData.append('tableNumber', tableNumber);
            formData.append('tableName', tableName);
            formData.append('covers', covers);
			formData.append('edit', edit);
			formData.append('table', table);

            fetch('insert_table.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                     swal("Succès", data.message, "success").then(() => {
						location.reload(); // Recharge la page après le message de succès
					});
                } else {
                    swal("Erreur", data.message, "error");
                }
            })
            .catch(error => swal("Erreur", "Une erreur s'est produite lors de l'ajout de la table.", "error"));
        }
    });

    // Charger les numéros de tables
    fetch('get_table_numbers.php')
        .then(response => response.json())
        .then(data => {
            if (data && Array.isArray(data)) {
                const tableSelect = document.getElementById('tableNumber');
                data.forEach(table => {
                    const option = document.createElement('option');
                    option.value = table.id; // Changez selon votre structure de données
                    option.textContent = table.nomTable; // Changez selon votre structure de données
                    tableSelect.appendChild(option);
                });
            }
        })
        .catch(error => console.error("Erreur lors de la récupération des tables :", error));
}




function newServ() {
    const title = "Enregistrement d'un(e) serveur(se)";
    swal({
        title: title,
        content: {
            element: "div",
            attributes: {
                innerHTML: `
                <style>
                    .swal-custom-form {
                        display: flex;
                        flex-direction: column;
                        gap: 10px;
                        font-family: Arial, sans-serif;
                    }
                    .swal-custom-form .row {
                        display: flex;
                        align-items: center;
                    }
                    .swal-custom-form label {
                        width: 170px;
                        font-weight: bold;
                        color: maroon;
                        margin-right: 10px;
                        text-align: right;
                    }
                    .swal-custom-form select,
                    .swal-custom-form input {
                        flex: 1;
                        padding: 5px;
                        height: 25px;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        margin-right: 15px;
                    }
                </style>
                <div class='swal-custom-form'>
                    <div class='row'>
                        <fieldset>
                            <div class='row'>
                                <label for='surname'>Nom :</label>
                                <input id='surname' type='text' placeholder=''/>
                            </div><br/>
                            <div class='row'>
                                <label for='nameServ'>Prénoms :</label>
                                <input id='nameServ' type='text' placeholder=''/>
                            </div><br/>
                            <div class='row'>
                                <label for='adresse'>Adresse :</label>
                                <input id='adresse' type='text' placeholder='Champ optionnel'/>
                            </div><br/>
                            <div class='row'>
                                <label for='phoneNumber'>Téléphone :</label>
                                <input id='phoneNumber' type='text' placeholder=''/>
                            </div><br/>
                        </fieldset>
                    </div>
                </div>
                `
            }
        },
        buttons: true
    }).then((willSubmit) => {
        if (willSubmit) {
            const surname = document.getElementById('surname').value.trim();
            const nameServ = document.getElementById('nameServ').value.trim();
            const adresse = document.getElementById('adresse').value.trim();
            const phoneNumber = document.getElementById('phoneNumber').value.trim();

            // Validation
            if (!surname) {
                swal("Erreur", "Le Nom est requis.", "error");
                return;
            }
            if (!nameServ) {
                swal("Erreur", "Le prénom(s) est requis.", "error");
                return;
            }
            if (!phoneNumber) {
                swal("Erreur", "Le téléphone est requis.", "error");
                return;
            }

            // Envoi des données en AJAX
            const formData = new FormData();
            formData.append('surname', surname);
            formData.append('nameServ', nameServ);
            formData.append('adresse', adresse);
            formData.append('phoneNumber', phoneNumber);

            fetch('insert_serveur.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    swal("Succès", data.message, "success").then(() => {
                        location.reload(); // Recharge la page après le message de succès
                    });
                } else {
                    swal("Erreur", data.message, "error");
                }
            })
            .catch(error => swal("Erreur", "Une erreur s'est produite lors de l'ajout.", "error"));
        }
    });
}



</script>			
	</body>
</html>
