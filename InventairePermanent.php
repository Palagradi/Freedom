<?php
include_once'menu.php';
	 $idr = isset($_POST['libelle'])?$_POST['libelle']:null;
     $checkbox1 = isset($_POST['checkbox1'])?$_POST['checkbox1']:null;	
 if($checkbox1==1) { //echo $_SESSION['checkbox']=isset($_GET['checkbox'])?$_GET['checkbox']:NULL;
	 	// //$pre_sql="CREATE table IF NOT EXISTS checkbox(Qte int)"; $req1 = mysqli_query($con, $pre_sql) or die (mysqli_error($con));
	 	// //$pre_sql="CREATE table IF NOT EXISTS QteLigneT(Qte int)"; $req1 = mysqli_query($con, $pre_sql) or die (mysqli_error($con));
  echo '<meta http-equiv="refresh" content="0; url=InventairePermanent.php?menuParent='.$_SESSION['menuParenT'].'&checkbox=1" />';
 // echo $checkbox=isset($_GET['checkbox'])?$_GET['checkbox']:NULL;
  }
	if(isset($_POST['ok']) && $_POST['ok'] == "OK")
		{	//		 if(isset($_POST['cat'])) 
			//echo $_POST['debut']."<br/>";
			$debut=substr($_POST['debut'],8,2).'-'.substr($_POST['debut'],5,2).'-'.substr($_POST['debut'],0,4);
			$fin=substr($_POST['fin'],8,2).'-'.substr($_POST['fin'],5,2).'-'.substr($_POST['fin'],0,4);
			$debutN=$_POST['debut'];$finN=$_POST['fin'];	 
			if( !empty($_POST['choix'])){ 
				$choix =''; 
				//on boucle
				for ($i=0;$i<count($_POST['choix']);$i++)
				{	//on concatène
					  $choix .= $_POST['choix'][$i].'|';
					  $explore = explode('|',$choix);
					if($explore[$i]!='')
						{   //echo $req="SELECT * FROM boisson WHERE numero='".$explore[$i]."'"; 
							//echo "<br/>";
							//$req="UPDATE boisson SET StockReel='".$_POST['choix']."' WHERE numero='".$explore0[$i]."'"; 
							//$reqsel=mysqli_query($req,$con);
						
						}
				
				}
			
				
			}
			if( !empty($_POST['choix0'])){ 
				$choix0 =''; 
				//on boucle
				for ($i=0;$i<count($_POST['choix0']);$i++)
				{	//on concatène
					  $choix0 .= $_POST['choix0'][$i].'|';
					  $explore0 = explode('|',$choix0);
					if($explore0[$i]!='')
						{  // echo $req="SELECT * FROM boisson WHERE numero='".$explore0[$i]."'"; 
							//echo "<br/>";
							$req="UPDATE boissonp SET StockReel='".$explore0[$i]."' WHERE numero='".$explore[$i]."' "; 
							$reqsel=mysqli_query($con,$req);	
													
						}				
				}		
			}
			
			if($reqsel)
				{	//echo "<script language='javascript'>";
					//echo 'alertify.success("Stock réel mis à jour");';
					//echo "</script>";
					//header("Location: InventairePermanent.php?menuParent=Restauration");
					$query_Recordset1 = "SELECT DISTINCT boissonp.numero AS numero,operation.numero AS Numop1,numero2,designation,Qte_initiale,Qte_entree,qte_finale,Qte_Stock,date_modification,heure_operation,Qte,Seuil,StockReel FROM operation,boissonp WHERE boissonp.numero2=operation.reference1  AND date_modification BETWEEN '".$debutN."' AND '".$finN."' AND designation_operation <> 'Mise à jour Produit alimentaire'";
					//echo '<meta http-equiv="refresh" content="1; url=InventairePermanent.php?menuParent=Restauration" />';
				}
		}else { $debutN=date('Y-m-d');$finN=date('Y-m-d');	
						if(isset($idr))
						    $query_Recordset1 = "SELECT DISTINCT boissonp.numero AS numero,operation.numero AS Numop1,numero2,designation,Qte_initiale,Qte_entree,Qte_Stock,qte_finale,date_modification,heure_operation,Qte,Seuil,StockReel FROM operation,boissonp WHERE boissonp.numero2=operation.reference1 
						    AND Categorie = '".$idr."' AND date_modification BETWEEN '".$debutN."'	AND '".$finN."'	AND operation.numero IN (SELECT MAX(operation.numero)  FROM operation,boissonp WHERE boissonp.numero2=operation.reference1  
							AND date_modification BETWEEN '".$debutN."'	AND '".$finN."' AND designation_operation <> 'Mise à jour Produit alimentaire' GROUP BY  designation,Qte  ORDER BY operation.numero) ";
					   else
							{
							if(isset($_GET['checkbox']))
								{  
								}
							else 
								{$query_Recordset1 = "SELECT DISTINCT boissonp.numero AS numero,operation.numero AS Numop1,numero2,designation,Qte_initiale,Qte_entree,Qte_Stock,qte_finale,date_modification,heure_operation,Qte,Seuil,StockReel
								FROM operation,boissonp WHERE boissonp.numero2=operation.reference1  AND operation.numero IN (SELECT MAX(operation.numero)  FROM operation,boissonp WHERE boissonp.numero2=operation.reference1  
								AND date_modification BETWEEN '".$debutN."'	AND '".$finN."' AND designation_operation <> 'Mise à jour Produit alimentaire' GROUP BY  designation,Qte  ORDER BY operation.numero)";
								}
							}
				}
	 
?>
	<head>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript" src="js/verifyCheckBoxes1.js"></script>	
		<link rel="Stylesheet" type="text/css"  href='css/input.css' />
		<style>
		.label-file {
		cursor: pointer;
		color: #00b1ca;
		font-weight: bold;
		}
		.label-file:hover {
			color: #25a5c4;
		}
		#file {
			display: none;visibility: hidden;
		}
		</style>
	</head>
		<body bgcolor='azure' style="margin-top:-20px;padding-top:0px;">
		<form action='InventairePermanent.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>' method='post' id="chgdept" >
		<?php
			echo " <hr width='65%' noshade size=3>	<table align='center'>
				<tr>

				<td style='color:#444739;'>  <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Période du&nbsp;:&nbsp;&nbsp; </b></td>
				<td>";?>
					<input type='date' name='debut' id='' size='20'  style='width:150px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value="<?php if(isset($debutN))  echo $debutN; else {echo date('Y-m-d'); $debutN=date('d-m-Y');} ?>"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				<td  style='color:#444739;'> <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Au:&nbsp;&nbsp; </b></td>
				<td>
					<input type='date' name='fin' id='' size='20'  style='width:150px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value="<?php if(isset($finN))  echo $finN; else {echo date('Y-m-d');$finN=date('d-m-Y');} ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='Submit' name='ok' value='OK' class='bouton3' style='border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;'/></td> 
				 		
				</tr>

			</table> <hr width='65%' noshade size=3>
		<?php 	
			 $result = mysqli_query($con,$query_Recordset1);
			 $nbre = mysqli_num_rows($result);
			 $req1 = mysqli_query($con,"SELECT DISTINCT catPrd FROM categorieproduit") or die (mysqli_error($con));	

		   if($nbre>0)
		   {
			   	echo "<table align='center' width='65%' height='auto' border='0' cellpadding='0' cellspacing='0' style='border:0px solid maroon;font-family:Cambria;'>
				<tr>		
				<td  align='right'  style='color:#444739;'><b>Catégorie : </b>";?>
				<select name='libelle' style='margin-bottom:8px;font-family:sans-serif;font-size:90%;border:0px solid teal;width:250px;' id='continent' onchange="document.forms['chgdept'].submit();"  >
				<option value =''> </option> <?php
				while($data=mysqli_fetch_array($req1))
				{    
					echo" <option value ='".$data['catPrd']."'> ".ucfirst($data['catPrd'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option> ";
				}
				echo "</select> </span>	</td></tr></table>";
			
		?>

		<table align='center' width='65%' height='auto' border='1' cellpadding='0' cellspacing='0' style='border:2px solid teal;font-family:Cambria;background-color:#f5f5dc;'>
			<tr>
			<td align='center' colspan='2' style='font-weight:bold;font-size:1.2em;color:#a52a2a;'>&nbsp;</td>
		</tr>
		<tr>
			<td align='center' colspan='2' style='font-weight:bold;font-size:1.2em;color:#a52a2a;'>INVENTAIRE PERMANENT DES PRODUITS</td>
		</tr>
		<tr style='font-weight:bold;font-size:1em;color:#444739;'>
			<td align='center' ><br/>Famille de produits : <?php if(isset($idr)) echo $idr;?> </td>
			<td align='center' ><br/>Sous-Famille : </td>
		</tr>
		<tr style='font-weight:bold;font-size:1em;color:#444739;'>
			<td align='center' ><br/>Période du  &nbsp;<?php echo substr($debutN,8,2).'-'.substr($debutN,5,2).'-'.substr($debutN,0,4)."&nbsp;au&nbsp;". substr($finN,8,2).'-'.substr($finN,5,2).'-'.substr($finN,0,4); ?>   </td>
			<td align='center' ><br/>Service Stockage : <?php echo "Dépôt principal"; //echo $nomHotel; ?></td>
		</tr>
		<tr style='font-weight:bold;font-size:1em;color:#ff4500;'>
			<td colspan='10' align='center' ><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ECARTS</td>
		</tr>
		<tr style=''>
			<td colspan='10' style="border: 1px solid #ffffff" >
			<table width="100%">
				<tr bgcolor='#ffe4c4' style=''>
					<td align='center'style="border-right: 1px solid #ffffff" >CODE</td>
					<td align='center'style="border-right: 1px solid #ffffff" >DESIGNATION</td>
					<td align='center'style="border-right: 1px solid #ffffff" >INV. INIT.</td>
					<td align='center'style="border-right: 1px solid #ffffff" >ENTREES</td>
					<td align='center'style="border-right: 1px solid #ffffff" >SORTIES</td>
					<td align='center'style="border-right: 1px solid #ffffff" >QTE VENDUE</td>
					<td align='center'style="border-right: 1px solid #ffffff" >STOCK THEO</td>
					<td align='center'style="border-right: 1px solid #ffffff" >STOCK REEL</td>
					<td align='center'style="border-right: 1px solid #ffffff" >ECART</td>
					<td align='center'style="border-right: 1px solid #ffffff" >CONSO REELLE</td>
				</tr>
				
			<?php
		   }
					$cpteur=1;$i=0;
					while( $data = mysqli_fetch_object($result))
					{$i++;
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
						$numero=$data->numero2;		
						if(($numero>=0)&&($numero<=9)) $numero="0000".$numero ; else if(($numero>=10)&&($numero <=99)) $numero="000".$numero ;else $numero="00".$numero ;
						$Qte_initiale=$data->Qte_initiale;   //$qte_finale=$data->qte_finale;  
						
						
						
						$query_Recordset2 = "SELECT SUM(Qte_entree) AS QteSortie
						FROM operation WHERE date_modification BETWEEN '".$debutN."'	AND '".$finN."'  AND operation.reference1='".$data->numero2."' AND operation.Qte_initiale < operation.qte_finale AND designation_operation <> 'Mise à jour Produit alimentaire'";
						$result2 = mysqli_query($con,$query_Recordset2);$data2 = mysqli_fetch_object($result2);  $data2->QteSortie;
						
						$query_Recordset3 = "SELECT SUM(Qte_entree) AS QteEntree
						FROM operation WHERE  date_modification BETWEEN '".$debutN."'	AND '".$finN."'  AND operation.reference1='".$data->numero2."' AND operation.Qte_initiale > operation.qte_finale AND designation_operation <> 'Mise à jour Produit alimentaire'";
						$result3 = mysqli_query($con,$query_Recordset3);$data3 = mysqli_fetch_object($result3);  $data3->QteEntree;
					
						$QteSortie=!empty($data2->QteSortie)?$data2->QteSortie:0;  $QteEntree=!empty($data3->QteEntree)?$data3->QteEntree:0; 
						
						$query_Recordset4 = "SELECT MAX(Qte_initiale) AS QteInitiale
						FROM operation WHERE  date_modification BETWEEN '".$debutN."'	AND '".$finN."'  AND operation.reference1='".$data->numero2."' AND operation.Qte_initiale > operation.qte_finale AND designation_operation <> 'Mise à jour Produit alimentaire'";
						$result4 = mysqli_query($con,$query_Recordset4);$data4 = mysqli_fetch_object($result4);  $data4->QteInitiale;
						
						$query_Recordset5 = "SELECT SUM(tableencours.qte) AS QteVendue
						FROM factureResto,tableencours,boissonp  WHERE  factureResto.numTable=tableencours.numTable AND tableencours.LigneCde=boissonp.designation AND  tableencours.QteInd=boissonp.Qte  AND date_emission BETWEEN '".$debutN."'	AND '".$finN."'  AND boissonp.numero2='".$data->numero2."'  ";
						$result5 = mysqli_query($con,$query_Recordset5);$data5 = mysqli_fetch_object($result5);  $QteVendue=!empty($data5->QteVendue)?$data5->QteVendue:"-";						
						
						$Ecart=abs($data->Qte_Stock-$data->StockReel);
						
								echo "<tr class='rouge1' bgcolor='".$bgcouleur."'>
								<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$numero."</td>
								<td align='left' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data->designation." ".$data->Qte."</td>
								<td align='center' align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> ".$data4->QteInitiale."</td>
								<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> ".$QteSortie."</td>
								<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$QteEntree."</td>
								<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$QteVendue."</td>
								<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> ".$data->Qte_Stock."</td>
								<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data->StockReel."</td>
								<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> ".$Ecart."</td>
								<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> </td>
								</tr>";	
					} 
					?>
			</table>
			</td>
		</tr>
		<table>	</form>		
	</body>
</html>
