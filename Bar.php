<?php
	include_once'menu.php';  

	$Qte=isset($_GET['Qte'])?$_GET['Qte']:NULL;
	$param=isset($_GET['param'])?$_GET['param']:NULL;
	$numero=isset($_GET['numero'])?$_GET['numero']:NULL;
	$numero2=isset($_GET['numero2'])?$_GET['numero2']:NULL;
	if(!empty($numero)){
		echo "<script language='javascript'>";
		if($Qte==0)
			echo 'alertify.error("Ce nombre doit être superieur à 0 ");';   
		else if($Qte>$param)
		echo 'alertify.error(" Le nombre saisi ne doit pas être supérieur à la quantité disponible. ");';
		else {}
		echo "</script>";
		
		if($Qte<=$param){
				//Pour la ligne des Pack
				$result=mysqli_query($con,"SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson,casier WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND casier.id=boisson.pc AND pc<>0 AND Depot = '2' AND numero='".$numero."'");
				//Pour vérifier si la ligne unitaire existe
				$result0=mysqli_query($con,"SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND pc=0 AND Depot = '2' AND numero2='".$numero2."'");
				$data=mysqli_fetch_object($result);
				$numero2=$data->numero2;$pc=0;$Seuil=0;
				$Categorie=$data->Categorie;$Qte2=$data->Qte;
				$designation=$data->designation;				
				$Conditionne=$data->Conditionne;
				$PrixUnitaire=$data->PrixUnitaire;
				$PrixPack=$data->PrixPack;				
				$QteStockPack=$data->QteStock;$QteStockPack-=$Qte;
				$QteStock=$data->qtepc*$Qte;
				$RegimeTVA=$data->RegimeTVA;
			
				if(mysqli_num_rows($result0)==0){
					 $rek1="INSERT INTO boisson SET numero2='".$numero2."',Categorie='".$Categorie."',pc='".$pc."',designation='".$designation."',Qte='".$Qte2."',Conditionne='".$Conditionne."',PrixUnitaire='".$PrixUnitaire."',PrixPack='".$PrixPack."',Seuil='".$Seuil."',QteStock='".$QteStock."',StockReel='".$QteStock."',dateCreation='".$Jour_actuel."',dateUpdate='".$Jour_actuel."',Depot = '2',RegimeTVA='".$RegimeTVA."'";	
					 $query = mysqli_query($con,$rek1) or die (mysqli_error($con));
				}else {
					$data2=mysqli_fetch_object($result0); $QteStock+=$data2->QteStock; $numero3=$data2->numero;
					  $rek="UPDATE boisson SET QteStock='".$QteStock."' WHERE numero='".$numero3."' AND pc='0' AND Depot = '2' ";
					$query = mysqli_query($con,$rek) or die (mysqli_error($con));
				}
				$rek="UPDATE boisson SET QteStock='".$QteStockPack."' WHERE numero='".$numero."' AND pc<>'0' AND Depot = '1' "; 
				$query = mysqli_query($con,$rek) or die (mysqli_error($con)); //dimunition du stock du depot
				
				if($query){
				echo "<script language='javascript'>";
				echo 'alertify.success("Conversion effectuée avec succès !");';
				echo "</script>";
				echo '<meta http-equiv="refresh" content="1; url=Bar.php?menuParent='.$_SESSION['menuParenT'].'" />';
				}  
		}		
	}
			
	if(isset($_GET['checkpvc']))
		{$checkpvc=$_GET['checkpvc'];$pvc=$checkpvc;}
	else 	
		$checkpvc=isset($_POST['checkpvc'])?$_POST['checkpvc']:NULL;

	if(isset($checkpvc))
		{   $checkpvc=2;
		}else 
		{   $checkpvc=1;
		} 
	$rek="UPDATE configresto SET pvc='".$checkpvc."'";
	$query = mysqli_query($con,$rek) or die (mysqli_error($con));
	$pvc = $checkpvc ;
	
	if(isset($_GET['pvc'])) $pvc= $_GET['pvc'];


?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" style=''>
	<head>
		<title><?php echo $title; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
		<link rel="Stylesheet" href='css/table.css' />
		<link rel="Stylesheet" type="text/css"  href='css/input.css' />
		<link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		
		<link href="js/datatables/dataTables.bootstrap4.css" rel="stylesheet">
		
		<link href="js/editableSelect/jquery-editable-select.min.css" rel="stylesheet">
		
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
		function JSalertQte(param0,param,param2,param3){
			var text = "Packs [P]";if(param2==0) text = "Casiers [C]";
		swal("Nbre de "+text+ " disponible : "+param3,{
		  content: {
			element: "input",
			attributes: {
			  placeholder: "Nbre de "+text+ " à convertir ",
			  type: "number",
			  min : "1",
			  max : param3,
			},
		  },
		})
			.then((value) => {
				//var numero = param; 
				document.location.href='Bar.php?menuParent=Restauration&Qte='+value+'&param='+param3+'&numero='+param0+'&numero2='+param+'&checkpvc=2';
			});
		}

			</script>
	</head>
	<body bgcolor='azure' style="overflow: visible;" >
	<div class="container">
		<table align='center' width='98%'>
			<tr>
			<td style='text-align:left;'>
				<h2 style='font-family:Cambria;color:maroon;font-weight:bold;float:left;'>STOCK DE BOISSONS DISPONIBLES DANS LE BAR</h2>				
				<form action="" method="POST" id="chgdept" style='float:right;'>
					<span style='float:right; margin-right:25px;'>
					<input type='checkbox' <?php if(isset($pvc)&&($pvc==2)) echo "checked='checked'"; ?> name='checkpvc' id='button_checkbox2' onchange="document.forms['chgdept'].submit();" <?php if(isset($pvc)&&($pvc==2)) echo "value='2'"; else echo "value='1'"; ?> >
					<label for='button_checkbox2' style='color:#444739;'>
					<?php echo "En Pack [P] et Casier [C]"; ?> </label></span>
				</form>			
			</td>
		</tr>
		<tr>
			<td style='text-align:left;'><hr style=''/>	</td>
		</tr>
	</table>

<br/>

<div class="table-responsive">
	<table id="dataTable"  align='center' width='100%' border='0' cellspacing='1' style='margin-top:0px;border-collapse: collapse;font-family:Cambria;'>
<thead>
<tr><td colspan='9' > <span style="float:left;font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#4C767A;" >Liste des boissons </span>
<span style="float:right;font-family:Cambria;font-size:1em;margin-bottom:5px;color:#4C767A;" ><?php if(!empty($pvc)&&($pvc==2)) echo "4P/24 => Lire : 4 Packs de 24; &nbsp;&nbsp;&nbsp; 5C/24 => Lire : 5 Casiers de 24";  ?></span></td></tr>
		<tr  style='background-color:#3EB27B;color:white;font-size:1.2em;'>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;border-left: 1px solid #ffffff;" align="center" ><label for='1' style=''>N° d'Enrég.</label><span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><label for='2' style=''>Catégorie</label><span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><label for='3' style=''>Désignation</label><span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><label for='5' style=''>Conditionnement</label><span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><label for='6' style=''>Quantité <br/>indiquée (Qi)</label> <span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><label for='7' style=''>Seuil d'alerte</label> <span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><label for='7' style=''>Quantité <br/>en Stock (Qs)</label> <span style='font-size:0.8em;'></span></td>
			<td style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><label for='8' style=''><?php if(!empty($pvc)&&($pvc==2)) echo "Prix du Pack/<br/>Casier"; else echo "Prix Unitaire";  ?></label> <span style='font-size:0.8em;'></span></td>
			<?php if(!empty($pvc)&&($pvc==2)) 
				 echo "<td style='border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;' align='center' >Actions</td>";  
			 ?>
		</tr>
</thead>
<tbody id="">
<?php
	mysqli_query($con,"SET NAMES 'utf8'");
	if(!empty($pvc)&&($pvc==2)) 
	$result=mysqli_query($con,"SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson,casier WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND casier.id=boisson.pc AND pc<>0 AND Depot = '2' order by numero2 ");
	else 
		$result=mysqli_query($con,"SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND pc=0 AND Depot = '2' order by numero2 ");
	$cpteur=1;
    // parcours et affichage des résultats
    while($data = mysqli_fetch_object($result))
    {
		if($cpteur == 1)
			{
				$cpteur = 0;
				$bgcouleur = "#DDEEDD";$color = "#FC7F3C";
			}
			else
			{
				$cpteur = 1;
				$bgcouleur = "#dfeef3";$color = "#FC7F3C";
			}
	$nbre=$data->numero2;
	if(($nbre>=0)&&($nbre<=9)) $nbre="0000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="000".$nbre ;else $nbre="00".$nbre ;  $Nbre=$data->numero2;
	
/* 	if(!empty($pvc)&&($pvc==2))
		$result2=mysqli_query($con,"SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson,casier WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND casier.id=boisson.pc AND pc<>0 AND Depot = '2' AND numero2='".$data->numero2."'");
	else 
		$result2=mysqli_query($con,"SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND Depot = '2' AND pc=0 AND numero2='".$data->numero2."'");
	$data2 = mysqli_fetch_object($result2);	 */
    ?>
		 	<tr class='rouge1' bgcolor=' <?php echo $bgcouleur; ?>'>
				<td align="center" style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'><?php echo $nbre; ?></td>
				<td style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'><?php echo $data->LibCateg; ?> </td>
				<td style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'><?php echo $data->designation ; ?></td>
				<td align='' style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'><?php echo $data->LibConditionne; ?></td>
				<td align="center" style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'> <?php echo $data->LibQte; ?></td>
				<td align="center" style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff;padding-right:3px;'><?php echo "<span style=''>".$data->Seuil."&nbsp;&nbsp;&nbsp;</span>";	?></td>	
				<td align="center" style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff;padding-right:3px;'><?php if(!empty($pvc)&&($pvc==2)) echo "<span style='color:red;'>".$data->QteStock."</span><span style='font-size:0.8em;'>".substr($data->Libellepc,0,1)."/".$data->qtepc."</span>"; else echo "<span style='color:maroon;'>".$data->QteStock."&nbsp;&nbsp;&nbsp;</span>";	?></td>								
				<td align="center" style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'><?php if(!empty($pvc)&&($pvc==2)) {if($data->PrixPack==0) echo "-"; else echo $data->PrixPack."<span style='font-size:0.6em;'> ".$devise."</span>&nbsp;"; }else echo $data->PrixUnitaire."<span style='font-size:0.6em;'> ".$devise."</span>&nbsp;"; ?></td>
				<?php if(!empty($pvc)&&($pvc==2)) {  if(substr($data->Libellepc,0,1)=="P")$pack=1;else $pack=0;
				echo "<td align='center' style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'>"; 
				if($data->QteStock>0) {?>
				<a class='info2' onclick='JSalertQte(<?php echo $data->numero.",".$data->numero2.",".$pack.",".$data->QteStock; ?>);return false;' style='color:gray;'>			
				<?php 
				echo "&nbsp;<i class='fa fa-plus-square'></i><span style='color:green;'>Convertir des "; if(substr($data->Libellepc,0,1)=="P") echo "<g style='color:red;'>Packs</g>"; else echo "<g style='color:red;'>Casiers</g>"; echo " en <g style='color:red;'>Unités</g>";
				echo "</a>";
				}
				echo "</td>";
				}
	}
	?>
			</tr>
			</tbody>
		<tfoot></tfoot>
	</table>
	</div>
		<script src="js/editableSelect/jquery-1.12.4.min.js"></script>
		<script src="js/editableSelect/jquery-editable-select.min.js"></script>
		<script src="js/editableSelect/script.js"></script>
		
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
