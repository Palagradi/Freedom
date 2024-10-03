<?php
	include_once'menu.php';  //$req = mysqli_query($con,"DELETE FROM QteBoisson WHERE qte='Hhhh'");


	$plat=isset($_POST['plat'])?$_POST['plat']:NULL;
	
	$update=isset($_GET['update'])?$_GET['update']:NULL;
	$delete=isset($_GET['delete'])?$_GET['delete']:NULL;

	//$sqlF=mysqli_query($con,"SELECT DISTINCT CategoriePlat FROM plat ");
	if(!empty($plat)){
	$sqlPi=mysqli_query($con,"SELECT numero,designation,prix,ListeProduits FROM plat WHERE numero='".$plat."'");
	$data = mysqli_fetch_object($sqlPi);
	}
	if(isset($update)){
	mysqli_query($con,"SET NAMES 'utf8'");
	$sql = "SELECT * FROM plat,portion WHERE plat.numero = portion.numPlat AND id='".$update."'";
	$result=mysqli_query($con,$sql);
	$data = mysqli_fetch_object($result);
	}

	if(isset($_POST['ENREGISTRER'])&& ($_POST['ENREGISTRER']=="Enrégistrer")){
		$portion=trim(addslashes($_POST['portion']));
		$rk="SELECT * FROM portion WHERE numPlat='".$_POST['plat']."' AND libellePortion ='".$_POST['portion']."'";
		$req1 = mysqli_query($con,$rk) or die (mysqli_error($con));
		if(mysqli_num_rows($req1)>0){
			echo "<script language='javascript'>";
			echo 'alertify.error(" Cette portion existe déja. !");';
			echo "</script>";
		}
		else {
			$dataT="";
			if (isset($_POST['ListeProduits']) && is_array($_POST['ListeProduits'])) {
				$selectedStates = $_POST['ListeProduits'];
				foreach ($selectedStates as $state) {
					$dataT.="|".htmlspecialchars($state);
				}
			}	
			$pre_sql1="INSERT INTO portion SET numPlat='".$_POST['plat']."',libellePortion='".$_POST['portion']."',prixPortion='".$_POST['Prixvente']."',ListeProduitsP='".$dataT."'";
			$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));	
			if($req1){
			echo "<script language='javascript'>";
			echo 'alertify.success(" Portion enrégistrée avec succès !");';
			echo "</script>";
			unset($plat);
			//echo '<meta http-equiv="refresh" content="1; url=DpInterne.php?menuParent='.$_SESSION['menuParenT'].'" />';
			}
		}
	}
	
		if(isset($_POST['ENREGISTRER'])&& ($_POST['ENREGISTRER']=="Modifier")){
		$portion=trim(addslashes($_POST['portion']));
			$pre_sql1="UPDATE portion SET libellePortion='".$_POST['portion']."',prixPortion='".$_POST['Prixvente']."' WHERE id='".$_POST['update']."'";
 			$req1 = mysqli_query($con,$pre_sql1) or die (mysqli_error($con));	
			if($req1){
			echo "<script language='javascript'>";
			echo 'alertify.success("Modification effectuée avec succès !");';
			echo "</script>";
			} 

	}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" style=''>
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
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript" >				
			$(document).ready(function() {
				$('.js-example-basic-multiple').select2();
			});
		</script>
	</head>
	<body bgcolor='azure' style="overflow: visible;" >
	<div class="container">
			<form action="CompoPlat.php?menuParent=<?php echo $_SESSION['menuParenT'];?>" method="POST" id='chgdept1' >			
			<table align='center' width='98%' height="" border="0" cellpadding="0" cellspacing="0" id="tab" style=''>
	<?php
	
		if(!empty($_GET['delete'])){ $_SESSION['delete']=$_GET['delete'];
			echo "<script language='javascript'>";
			echo 'swal("Cette action est irréversible. Voulez-vous continuer ?", {
			  dangerMode: true, buttons: true,
			}).then((value) => { var Es = value;  document.location.href="CompoPlat.php?menuParent='.$_SESSION['menuParenT'].'&test="+Es;
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
	$rowspan=4;if((isset($data->ListeProduits)&&(!empty($data->ListeProduits)))) $rowspan=5;	
		
	$rand1=rand(1,30); $rand2=rand(1,30);
	$arrayPortion = array('amandes','ananas','banane','cabillaud','camenbert','carotte','clementine','concombres','crevettes','epinards','fraises','framboise','haricots blancs','haricots verts','jambon','kiwi','noisettes','orange','pain','pates','petits pois','petits suisses','pois chiche','pomme','poulet','prune','riz','sardines','tomate','yaourt'); 
			echo "
				<tr>
						<td colspan='4'>
							<h2 style='text-align:right; font-family:Cambria;color:maroon;font-weight:bold;'>DEFINITION D'UNE PORTION DE PLAT</h2>
						</td>
				</tr>
				<tr> 
					<td rowspan='".$rowspan."' align='left'>
						<img title='' src='logo/food/portion/".$rand1.".png' width='200' height='175'/> 
						<p style='padding-left:75px;font-family:calibri;color:gray;font-size:0.9em;'>".ucfirst($arrayPortion[$rand1-1])."</p>
					</td>";
							
				echo "<td style='padding-left:50px;'> Désignation du plat : &nbsp;<span class='rouge'>*</span>&nbsp;&nbsp;</td>							
				<td colspan='2'>";	
				?> 
				<select name='plat' required style='margin-bottom:8px;font-family:sans-serif;font-size:100%;border:1px solid gray;width:300px;' id='trie' onchange="document.forms['chgdept1'].submit();">		
					<?php 
					  $result=mysqli_query($con,"SELECT * FROM plat order by designation");
					  if(!empty($plat)||!empty($update))
						echo "<option value ='".$data->numero."'>".ucfirst($data->designation)."</option>";
					  else
						echo "<option value =''> </option>";
							while($data0 = mysqli_fetch_object($result)){
							echo "<option value ='".$data0->numero."'> ".ucfirst($data0->designation)."</option>
								<option value =''>  </option>";
							}						
				echo "</select>
				</td>
					<td rowspan='5' align='right' style='padding-left:25px;'>
								<img title='' src='logo/food/portion/".$rand2.".png' width='200' height='175'/> 
								<p style='padding-right:75px;font-family:calibri;color:gray;font-size:0.9em;'>".ucfirst($arrayPortion[$rand2-1])."</p>
					</td>
				</tr>";
				?>
			<tr>
				<td  style='padding-left:50px;' >Prix du plat  &nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td  style=''><input type='text' id='' name='Prix' style='height:25px;font-size:1em;background-color:#D3D3D3;width:300px;' readonly 
				<?php  
				if(!empty($data->prix)&&(!empty($plat))) echo "value='".$data->prix."'";
				?>
				/></td>
			</tr>
			<tr>
				<td  style='padding-left:50px;'>Portion alimentaire :&nbsp;&nbsp;&nbsp;<span class='rouge'>*</span></td>
				<td>
				<select <?php //if(empty($data->libellePortion))  echo "id='editable-select'"; ?>  name='portion' style="width:300px;background:#fff;font-family:sans-serif;font-size:100%;border:1px solid gray;" required>
					 <?php
					 		$separators = "/[;,\-+]| aux | au | et | plus | avec /";
							if(!empty($data->libellePortion)) 
								echo "<option value ='".$data->libellePortion."'>".$data->libellePortion."</option>";
							else 
								echo "<option value =''>  </option>";
							$plat = preg_split($separators,$data->designation,-1, PREG_SPLIT_NO_EMPTY); 
							for($i=0;$i<count($plat);$i++) {
								if($plat[$i]!=$data->designation)
								{echo "<option value ='".$plat[$i]."'> ".ucfirst($plat[$i])."</option>
								<option value =''>  </option>";
								}
							}					
						?>
				</select>

				</td>
			</tr>
			<?php
			if((isset($data->ListeProduits)&&(!empty($data->ListeProduits)))) {
				echo "<tr>"; 
				echo "<td  style='padding-left:50px;'>Produits alimentaires :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
					<td >";				
						 $ListeProduits = explode("|",$data->ListeProduits);						
						echo "<select class='js-example-basic-multiple' name='ListeProduits[]' multiple='multiple' style='font-family:sans-serif;border:1px solid gray;width:300px;'>";
										
					mysqli_query($con,"SET NAMES 'utf8'");
					$result_0=mysqli_query($con,"SELECT ListeProduitsP FROM portion WHERE id='".$data->id."'");
					$data_0 = mysqli_fetch_object($result_0);
	
					if((isset($data_0->ListeProduitsP)&&(!empty($data_0->ListeProduitsP)))) {
						$ListeProduitsP = explode("|",$data_0->ListeProduitsP);
					}else $ListeProduitsP=[];
						for($i=0;$i<count($ListeProduits);$i++) {
							if(($ListeProduits[$i])!="")
							{   
								$req=mysqli_query($con,"SELECT Num,Designation FROM produits WHERE Num='".$ListeProduits[$i]."'");	
								$data0 =  mysqli_fetch_object($req);
								$selected = in_array($data0->Num, $ListeProduitsP) ? 'selected' : '';
								echo "<option value ='".$data0->Num."' $selected > ".$data0->Designation."</option>";
							}
						}
						echo "</select>
						<a href='#' class='info2' style='color:#B83A1B;'><span style='font-size:0.9em;font-style:normal;color:green;'>
						Pour un suivi rigoureux du <g style='color:red;'>stock des produits <br/> alimentaires</g>, ajoutez ici les différents produits<br/>entrant dans la préparation de la portion.<hr/>
						Vous pouvez vous limiter aux <g style='color:red;'>produits</g> dont vous<br/> voulez connaitre <g style='color:red;'>l'état réel du stock</g>.</span><i class='fa fa-info-circle' aria-hidden='true'></i></a>
					</td>
				</tr>";
			}						
			?>
			<tr>
				<td  style='padding-left:50px;' >Prix de la portion  &nbsp;:&nbsp;&nbsp;&nbsp;<span class='rouge'>*</span></td>
				<td  style=''><input type='text' id='' name='Prixvente' style='height:25px;font-size:1em;width:300px;' required='required' <?php echo "placeholder='".$devise."'"; ?> onkeypress='testChiffres(event);'
				<?php  
				if(!empty($data->prixPortion)) echo "value='".$data->prixPortion."'";
				?>/></td>
			</tr>
			<input type='hidden' id='' name='update' style='height:25px;font-size:1em;'
				<?php  
				if(!empty($update)) echo "value='".$update."'";
				?>/>
		<?php
		echo "<tr>
			<td colspan='6' align='center' ><br/><input type='submit' value='"; if(isset($update)) echo "Modifier"; else  echo "Enrégistrer";
			echo "' id='' class='bouton2'  name='"; if(isset($ap)) echo "Enregistrer"; else echo "ENREGISTRER"; echo "' style=''/>
			&nbsp;&nbsp;<input type='reset' value='Annuler' id='' class='bouton2'  name='ANNULER' style=''/> <br/>&nbsp;";
		?>
		
		</tr>
		<tr><td>&nbsp;&nbsp;</td></tr>		
		</table>
		</form>
	<br/>
<div class="table-responsive">
	<table id="dataTable"  align='center' width='100%' border='0' cellspacing='1' style='margin-top:0px;border-collapse: collapse;font-family:Cambria;'>
<thead>
<tr><td colspan='6' > <span style="float:left;font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#4C767A;" >Liste des portions disponibles  </span></td></tr>
		<tr  style='background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;border-left: 1px solid #ffffff;" align="center" >Type de repas<span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" >Catégorie du plat<span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" >Désignation du plat<span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" >Désignation de la portion<span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" >Prix de vente<span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;"  align="center" >Actions</td>
		</tr>
</thead>
<tbody id="">
<?php
	mysqli_query($con,"SET NAMES 'utf8'");
	$result=mysqli_query($con,"SELECT TypeMenu,catPlat,designation,libellePortion,prixPortion,numero,ListeProduitsP,portion.id AS id FROM plat,portion,categorieplat,menu WHERE categorieplat.id=plat.categPlat AND menu.id=plat.categMenu AND plat.numero = portion.numPlat");
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
    ?>

				<tr class='rouge1' bgcolor=' <?php echo $bgcouleur; ?>'>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>&nbsp;<?php echo $data->TypeMenu; ?> </td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>&nbsp; <?php echo $data->catPlat; ?></td>
				<td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>&nbsp;<?php echo ucfirst($data->designation); ?></td>
				<?php 	
				echo "<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' align='left'>";
				if(!empty($data->ListeProduitsP))
				echo "<a class='info2' href='#' style=''>
				<span style='font-size:0.9em;font-style:normal;color:green;'>Liste des produits alimentaires constituant la portion :<br/> 
				<g style='color:red;'>";
				if(!empty($data->ListeProduitsP)){
					$produits = explode("|",$data->ListeProduitsP);
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
				 echo ucfirst($data->libellePortion);
					if(!empty($data->ListeProduitsP)) echo "</a>
				<span style='float:right;color:gray;'>
				 <i class='fa fa-plus-square' aria-hidden='true'></i></span>";			 
				echo "</td>
				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' align='center'> ".$data->prixPortion."&nbsp;<span style='font-size:0.6em;'>".$devise."</span></td>";
				echo "<td align='center' style='border-right: 0px solid #ffffff; border-top: 2px solid #ffffff'> 
				&nbsp;<a class='info2' href='CompoPlat.php?menuParent=".$_SESSION['menuParenT']."&update=".$data->id."'  style='color:#FC7F3C;'><img src='logo/b_edit.png' alt='' width='16' height='16' border='0'><span style='color:#FC7F3C;font-size:0.9em;'>Modifier</span></a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;<a class='info2' href='CompoPlat.php?menuParent=".$_SESSION['menuParenT']."&delete=".$data->id."'  style='color:#B83A1B;'><img src='logo/b_drop.png' alt='Supprimer' width='16' height='16' border='0'><span style='color:#B83A1B;font-size:0.9em;'>Supprimer</span></a>
				</td>";						
				echo "</tr>";
	}
	?>			
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
