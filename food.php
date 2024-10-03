<?php
	include_once'menu.php';
	$reqsel=mysqli_query($con,"SELECT * FROM plat");
	$nbreplat=mysqli_num_rows($reqsel);$nbre=$nbreplat+1;
	if(($nbre>=0)&&($nbre<=9)) $nbre="00000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="0000".$nbre ;else $nbre="00".$nbre ;
	
	$update=isset($_GET['update'])?$_GET['update']:NULL;
	$delete=isset($_GET['delete'])?$_GET['delete']:NULL;
	$typeR=isset($_GET['typeR'])?$_GET['typeR']:NULL;
	$catR=isset($_GET['catR'])?$_GET['catR']:NULL;   

		if(isset($_GET['ok'])){ 
		echo "<script language='javascript'>";  
			if($_GET['ok']==1){
			echo 'alertify.success("Enrégistrement effectué avec succès !");';
			}
			if($_GET['ok']==2){
			echo 'alertify.success("Modifications effectuées avec succès !");';
			}
		}	
	
	if(isset($typeR)&&(!empty($typeR))&&($typeR!="null")) {
		$categorie=ucfirst(trim($typeR));
		$query = mysqli_query($con,"INSERT INTO menu SET TypeMenu='".$categorie."'") or die (mysqli_error($con));
	}
	$reqMenu = mysqli_query($con,"SELECT * FROM menu") or die (mysqli_error($con));
	
		if(isset($catR)&&(!empty($catR)&&($catR!="null"))) { 
		$categorie=ucfirst(trim($catR));
		$query = mysqli_query($con,"INSERT INTO categorieplat SET catPlat='".$categorie."'") or die (mysqli_error($con));
	}
	$reqCateg = mysqli_query($con,"SELECT * FROM categorieplat") or die (mysqli_error($con));
	
	if(isset($update)) {
		$reqk=mysqli_query($con,"SELECT * FROM plat,categorieplat,menu WHERE categorieplat.id=plat.categPlat AND menu.id=plat.categMenu AND numero='".$update."'");
		while($dataP = mysqli_fetch_object($reqk)){
			$nbre = $dataP->numero;$CategorieMenu=$dataP->TypeMenu;$CategoriePlat=$dataP->catPlat;
			$CategMenu=$dataP->categMenu;$CategPlat=$dataP->categPlat;$designation=$dataP->designation;
			$designation2=$dataP->designation2;$prix=$dataP->prix;$ListeProduits=$dataP->ListeProduits;
		}
	if(($nbre>=0)&&($nbre<=9)) $nbre="00000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="0000".$nbre ;else $nbre="00".$nbre ;	
	}
if(isset($_POST['ENREGISTRER'])){

	$categorie=$_POST['Libmenu'];$designation=trim(addslashes($_POST['designation']));	$designation2=trim(addslashes($_POST['designation2'])); $CategoriePlat=$_POST['categorie'];$Prix=$_POST['Prixvente'];  $TPS_2=isset($_POST['TPS_2'])?$_POST['TPS_2']:1; //$NbrePers=$_POST['NbrePers'];
	//if(!empty($designation)&&isset($_POST['designation'])){
	$dataT="";
    if (isset($_POST['ListeProduits']) && is_array($_POST['ListeProduits'])) {
        $selectedStates = $_POST['ListeProduits'];
        foreach ($selectedStates as $state) {
			$dataT.="|".htmlspecialchars($state);
        }
    }
	if($_POST['ENREGISTRER']=="Enrégistrer"){
	$sql="INSERT INTO `plat`(`numero`, `CategMenu`, `CategPlat`, `designation`, `designation2`, `ListeProduits`, `composition`, `prix`, `NbreJ`, `NbreC`, `Nbre`, `state`, `RegimeTVA`, `created_at`, `updated_at`) VALUES (NULL,'".$categorie."','".$CategoriePlat."','".$designation."','".$designation2."','".$dataT."',NULL,'".$Prix."',0,0,0,NULL,'".$TPS_2."','" . $Jour_actuel. "','".$Jour_actuel."')";
 	$query = mysqli_query($con,$sql);
		if($query){ $designation="";
		echo "<script language='javascript'>";
		echo 'alertify.success(" Enrégistrement effectué avec succès");';
		echo "</script>";
		//echo '<meta http-equiv="refresh" content="1; url=food.php?menuParent=Enrégistrement />'; 
		echo '<meta http-equiv="refresh" content="0; url=food.php?menuParent='.$_SESSION['menuParenT'].'" />';
	}
	}
	if($_POST['ENREGISTRER']=="Modifier"){ $update=(int)$update;
			$rek="UPDATE plat SET CategMenu='".$categorie."',CategPlat='".$CategoriePlat."',designation='".$designation."',designation2='".$designation2."',ListeProduits='".$dataT."',prix='".$Prix."',updated_at ='".$Jour_actuel."' WHERE numero='".$update."'";			
			$query = mysqli_query($con,$rek) or die (mysqli_error($con)); 
			echo "<script language='javascript'>";
			echo 'alertify.success("Modifications effectuées avec succès");';
			echo "</script>";
			//echo '<meta http-equiv="refresh" content="1; url=food.php?menuParent=Enrégistrement />'; 
			echo '<meta http-equiv="refresh" content="0; url=food.php?menuParent='.$_SESSION['menuParenT'].'" />';
	}
//}
}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title><?php echo $title; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="Stylesheet" href='css/table.css' />
		<link rel="Stylesheet" type="text/css"  href='css/input.css'/>
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
		<link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		
		<link href="js/datatables/dataTables.bootstrap4.css" rel="stylesheet">
		
		<link href="js/select2/select2.min.css" rel="stylesheet" />
		<script src="js/select2/select2.min.js"></script>
		
		<script src="js/sweetalert.min.js"></script>
		
		<meta name="viewport" content="width=device-width">
		<style>
			.alertify-log-custom {
				background: blue;
			}
					#lien1:hover {
			text-decoration:underline;background-color: gold;font-size:1.1em;
		}
		.bouton2 {
			border-radius:12px 0 12px 0;
			background: white;
			border:2px solid #B1221C;
			color:#B1221C;
			font:bold 12px Verdana;
			height:auto;font-family:cambria;font-size:0.9em;
		}
		.bouton2:hover{color:white;
			cursor:pointer;background-color: #B1221C;border:2px solid #B1221C;
		}
		.rouge {
			color:#B83A1B;
		}
		</style>
		<script type="text/javascript" >

		</script>
			<script type="text/javascript" src="js/fonctions_utiles.js"></script>
			<script type="text/javascript" >
				
			$(document).ready(function() {
				$('.js-example-basic-multiple').select2();
			});
			
			function JSalert(){
				swal("Entrez ci-dessous le nouveau type de repas ", {
					  content: "input",
					})
					.then((value) => {
					  document.location.href='food.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&typeR='+value;
					});
				}
			function JSalert2(){
				swal("Entrez ci-dessous la nouvelle catégorie de plat ", {
					  content: "input",
					})
					.then((value) => {
					  document.location.href='food.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&catR='+value;
					});
				}
			</script>
	</head>
	<body bgcolor='azure' style="">	
	<div class="container">
			<form action="" method="POST">
			<table align='center' width='98%' height="auto" border="0" cellpadding="0" cellspacing="0" id="tab">

	<?php
			if(!empty($_GET['delete'])){ $_SESSION['delete']=$_GET['delete'];
			echo "<script language='javascript'>";
			echo 'swal("Cette action est irréversible. Voulez-vous continuer ?", {
			  dangerMode: true, buttons: true,
			}).then((value) => { var Es = value;  document.location.href="food.php?menuParent='.$_SESSION['menuParenT'].'&test="+Es;
			}); ';
			echo "</script>";
		}  //https://sweetalert.js.org/docs/#configuration
		if(!empty($_GET['test'])&& ($_GET['test']=='true')){
			//echo $_SESSION['delete'];
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
		} if(!empty($_GET['test'])&& ($_GET['test']=='null')){
			echo "<script language='javascript'>";
			echo 'alertify.error(" L\'opération a été annulée !");';
			echo "</script>";
		}
			echo "	<tr>
						<td colspan='8'>
							<h2 style='text-align:center; font-family:Cambria;color:Maroon;font-weight:bold;'>"; if(isset($update)) echo "MISE A JOUR D'INFORMATIONS SUR UN PLAT"; else echo "ENREGISTREMENT DES PLATS"; echo "</h2>
						</td>
					</tr>

				<tr>
					<td rowspan='7' align='left'>
						<img title='' src='logo/food/".rand(1,36).".png' width='250' height='300'/>
					</td>
					<td colspan='2' style='padding-left:25px;' >N° d'enrég. : &nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
					<td colspan='2'><input type='text' id='code' name='code' style='width:250px;' readonly value='".$nbre."' onkeyup='myFunction()'/> </td>
					<td rowspan='7' align='right' style='padding-left:25px;'>
						<img title='' src='logo/food/".rand(1,36).".png' width='250' height='300'/>;
					</td>
				</tr>
				<tr>
					<td colspan='2' style='padding-left:25px;'>Produits alimentaires :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
					<td colspan='2'>";
						echo "<select class='js-example-basic-multiple' name='ListeProduits[]' multiple='multiple' style='font-family:sans-serif;border:1px solid gray;width:250px;' default='23'>";
					
						mysqli_query($con,"SET NAMES 'utf8'");
						if(isset($ListeProduits)&&(!empty($ListeProduits))){
						$ListeProduits = explode("|",$ListeProduits);
				/* 		for($i=0;$i<count($ListeProduits);$i++) {
							if(($ListeProduits[$i])!="")
							{
								$req=mysqli_query($con,"SELECT Num,Designation FROM produits WHERE Num='".$ListeProduits[$i]."'");	
								$data0 =  mysqli_fetch_object($req);
								echo "<option value ='".$data0->Num."' selected> ".$data0->Designation."</option>";								
							}
							} */
						}else $ListeProduits=[];
						$req=mysqli_query($con,"SELECT Num,Designation FROM produits WHERE Type='".$_SESSION['menuParenT1']."' order by Designation");							
						while($data = mysqli_fetch_array($req)){ 
								$selected = in_array($data['Num'], $ListeProduits) ? 'selected' : '';
								echo "<option value ='".$data['Num']."' $selected > ".$data['Designation']."</option>";
						}
						echo "</select>";
					
						echo "<a href='#' class='info2' style='color:#B83A1B;'><span style='font-size:0.9em;font-style:normal;color:green;'>
						Pour un suivi rigoureux du <g style='color:red;'>stock des produits <br/> alimentaires</g>, ajoutez ici les différents produits<br/>entrant dans la préparation du plat.<br/><br/>
						Vous pouvez vous limiter aux <g style='color:red;'>produits</g> dont vous<br/> voulez connaitre <g style='color:red;'>l'état réel du stock</g>.</span><i class='fa fa-info-circle' aria-hidden='true'></i></a>
					</td>
				</tr>
				<tr>
					<td colspan='2' style='padding-left:25px;'> Type de repas : &nbsp;&nbsp;&nbsp;<span class='rouge'>*</span></td>
					<td colspan='2'>";
				echo "<select name='Libmenu' style='font-family:sans-serif;font-size:90%;border:1px solid gray;width:250px;' required='required'>";
				if(isset($CategoriePlat))
					echo "<option value='".$CategPlat."'>".$CategoriePlat."</option>";
				else 
					echo "<option value=''></option>";
				while($data=mysqli_fetch_array($reqMenu))
				{
					echo" <option value ='".$data['id']."'> ".ucfirst($data['TypeMenu'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option> ";
					echo "<option value=''></option>";
				}
				echo "</select>
					<a class='info' href='#' style='color:#4C433B;' onclick='JSalert();return false;'> <span style='font-size:0.9em;font-style:normal;'>Ajouter un type de repas</span>	 <i class='fa fa-plus-square' aria-hidden='true'></i></a></td>
				</tr>
				<tr>
				<td colspan='2' style='padding-left:25px;'>Catégorie du plat :&nbsp;&nbsp;&nbsp;<span class='rouge'>*</span></td>
				<td colspan='2' style=''><select name='categorie' style='font-family:sans-serif;font-size:90%;border:1px solid gray;width:250px;' required='required'>";
				if(isset($CategorieMenu))
					echo "<option value='".$CategMenu."'>".$CategorieMenu."</option>";
				else 
					echo "<option value=''></option>";
				while($data=mysqli_fetch_array($reqCateg))
				{
					echo" <option value ='".$data['id']."'> ".ucfirst($data['catPlat'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option> ";
					echo "<option value=''></option>";
				}

			echo "</select>&nbsp;<a class='info' href='#' style='color:#4C433B;' onclick='JSalert2();return false;'><span style='font-size:0.9em;font-style:normal;'>Ajouter une nouvelle Catégorie</span><i class='fa fa-plus-square' aria-hidden='true'></i></a>

				</td>
			</tr>
			<tr>
				<td colspan='2' style='padding-left:25px;'>Nom complet du plat :&nbsp;&nbsp;<span class='rouge'>*</span>&nbsp;</td>
				<td colspan='2'><input type='text' id='' name='designation' value='".$designation."' style='width:250px;font-family:sans-serif;font-size:90%;' required='required' onblur='ucfirst(this);' onkeypress=''/>
				<a class='info2' href='#' style='color:#B83A1B;'>
				<span style='font-size:0.9em;font-style:normal;color:green;'>Veuillez donner ci-possible des noms qui vous permettront <br/>d'avoir des différentes portions d'un même plat.<br/>
				Dans le Nom complet du plat, utilisez des séparateurs comme : 
				<br/><b style='color:red;'>avec&nbsp;&nbsp;et&nbsp;&nbsp;au  &nbsp;&nbsp;aux &nbsp;&nbsp; + &nbsp;&nbsp; ; &nbsp;&nbsp;,&nbsp;&nbsp; -</b> 
				<br/>Exemples : Riz <g style='color:red;'>au</g> poulet, Tartine de pain <g style='color:red;'>avec</g> 5 g de 
				confiture,<br/> Pâte noire <g style='color:red;'>+</g> poisson,	etc, 			
				</span>
				<i class='fa fa-info-circle' aria-hidden='true'></i></a></td>
			</tr>
			<tr>
				<td colspan='2' style='padding-left:25px;'>Désignation du plat :&nbsp;&nbsp;<span class='rouge'></span>&nbsp;</td>
				<td colspan='2'><input type='text' id='' name='designation2' value='".$designation2."' style='width:250px;font-family:sans-serif;font-size:90%;'  onblur='ucfirst(this);' onkeypress=''/>
				<a class='info2' href='#' style='color:#B83A1B;'>
				<span style='font-size:0.9em;font-style:normal;color:green;'>Cette information est optionnelle. Si vous<br/> ne renseignez pas ce champ,
				le <g style='color:red;'>Nom complet<br/> du plat</g> sera considéré pas défaut.</span>
				<i class='fa fa-info-circle' style='color:gray;' aria-hidden='true'></i></a></td>
			</tr>
			<tr>
				<td colspan='2' style='padding-left:25px;'>Prix de vente :&nbsp;&nbsp;&nbsp;<span class='rouge'>*</span></td>
				<td colspan='2'><input type='text' id='' name='Prixvente' value='".$prix."' placeholder='".$devise."' style='width:250px;font-family:sans-serif;font-size:90%;' required='required' onkeypress='testChiffres(event);'/></td>
		</tr>
		<tr>
			<td colspan='6' align='center' ><br/><input type='submit'"; if(isset($update)) echo "value='Modifier'"; else echo "value='Enrégistrer'"; echo "id='' class='bouton2' name='ENREGISTRER' style=''/>
			&nbsp;&nbsp;<input type='reset' value='Annuler' id='' class='bouton2'  name='ANNULER' style=''/> <br/>&nbsp;";
			?>
			<span style='float:right; margin-right:25px;'><input checked type='checkbox' name='TPS_2' id='button_checkbox2' value='<?php if(!empty($RegimeTVA2)&&($RegimeTVA2==1)) echo "1"; else echo 2; ?>' >
			<label for='button_checkbox2' style='color:#444739;'><?php   if(!empty($RegimeTVA2)&&($RegimeTVA2==1)) echo "Exempté(e) de la TVA"; else echo "Assujetti(e) à la TVA";?> </label></span>
			</td>
		</tr>
		</form>
		</table>
<br/>

<div class="table-responsive">
	<table id="dataTable"  align='center' width='100%' border='0' cellspacing='1' style='margin-top:0px;border-collapse: collapse;font-family:Cambria;'>
<thead>
<tr><td colspan='7' > <span style="float:left;font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#4C767A;" >Liste des plats | repas  </span></td></tr>
		<tr  style='background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;border-left: 1px solid #ffffff;" align="center" >N° d'Enrég.<span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" >Type de repas<span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" >Catégorie plat<span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" >Nom complet du plat<span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" >Désignation<span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" >Prix de vente<span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" >Actions</td>
		</tr>
</thead>
<tbody id="">
<?php
	mysqli_query($con,"SET NAMES 'utf8'");
	$result=mysqli_query($con,"SELECT * FROM plat,categorieplat,menu WHERE categorieplat.id=plat.categPlat AND menu.id=plat.categMenu");
	$cpteur=1;
    // parcours et affichage des résultats
    while( $data = mysqli_fetch_object($result))
    {
		if($cpteur == 1)
			{
				$cpteur = 0;
				$bgcouleur = "#DDEEDD";
			}
			else
			{
				$cpteur = 1;
				$bgcouleur = "#dfeef3";
			}
	$nbre=$data->numero;
	if(($nbre>=0)&&($nbre<=9)) $nbre="0000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="000".$nbre ;else $nbre="00".$nbre ;
    ?>
		 	<tr class='rouge1' bgcolor=' <?php echo $bgcouleur; ?>'>
				<td align="center" style='border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;; border-top: 2px solid #ffffff'><?php echo $nbre;  ?> </td>
				<td style='border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;; border-top: 2px solid #ffffff'><?php echo $data->TypeMenu; ?> </td>
				<td style='border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;; border-top: 2px solid #ffffff'> <?php echo $data->catPlat; ?></td>
				<td align='' style='border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;; border-top: 2px solid #ffffff'>
				<?php  
				if(!empty($data->ListeProduits))
				echo "<a class='info2' href='#' style=''>
				<span style='font-size:0.9em;font-style:normal;color:green;'>Liste des produits alimentaires constituant le plat :<br/> 
				<g style='color:red;'>";
				if(!empty($data->ListeProduits)){
					$produits = explode("|",$data->ListeProduits);
					for($i=1;$i<count($produits);$i++)
						{
							mysqli_query($con,"SET NAMES 'utf8'");
							$resultP=mysqli_query($con,"SELECT Designation FROM produits WHERE Num='".$produits[$i]."'");
							$dataP = mysqli_fetch_object($resultP);
							echo $dataP->Designation;
							if($i<count($produits)-1)
								echo " ; ";							
						}
				}
				echo "</g>				
				</span>"; 
				
				 echo ucfirst($data->designation);
					if(!empty($data->ListeProduits)) echo "</a>
				<span style='float:right;color:gray;'>
				 <i class='fa fa-plus-square' aria-hidden='true'></i></span>";
				?>				
				</td>
					<td style='border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;; border-top: 2px solid #ffffff'> &nbsp;<?php echo !empty($data->designation2)?$data->designation2:$data->designation; echo "</span>";?></td>
				<td style='border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;; border-top: 2px solid #ffffff'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $data->prix; echo "&nbsp;<span style='font-size:0.6em;'>".$devise."</span>";?></td>
				<?php
				echo "<td align='center' style='border-right: 0px solid #ffffff; border-top: 2px solid #ffffff'> 
				&nbsp;<a class='info2' href='food.php?menuParent=".$_SESSION['menuParenT']."&update=".$nbre."'  style='color:#FC7F3C;'><img src='logo/b_edit.png' alt='' width='16' height='16' border='0'><span style='color:#FC7F3C;font-size:0.9em;'>Modifier</span></a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;<a class='info2' href='food.php?menuParent=".$_SESSION['menuParenT']."&delete=".$nbre."'  style='color:#B83A1B;'><img src='logo/b_drop.png' alt='Supprimer' width='16' height='16' border='0'><span style='color:#B83A1B;font-size:0.9em;'>Supprimer</span></a>
				</td>";

	}
	?>
			</tr>
			</tbody>
		<tfoot></tfoot>
	</table>
</div>
		<script src="js/datatables/jquery.dataTables.js"></script>
        <script src="js/datatables/dataTables.bootstrap4.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>
        <!-- Custom scripts for this page-->
        <script src="js/sb-admin-datatables.min.js"></script>
        <script src="js/sb-admin-charts.min.js"></script>
        <script src="js/custom.js"></script>
	</div>
	</body>
</html>
<?php
	// $Recordset1->Close();
?>
