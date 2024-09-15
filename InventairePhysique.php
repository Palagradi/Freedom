<?php
include_once'menu.php';
	 $idr = isset($_POST['libelle'])?$_POST['libelle']:null;
	 $debutN=isset($_GET['debutN'])?$_GET['debutN']:date('Y-m-d');$finN=isset($_GET['finN'])?$_GET['finN']:date('Y-m-d');	
     $checkbox1 = isset($_POST['checkbox1'])?$_POST['checkbox1']:null;	//unset($_SESSION['query_Recordset1']);
 if($checkbox1==1) {
  echo '<meta http-equiv="refresh" content="0; url=InventairePhysique.php?menuParent='.$_SESSION['menuParenT'].'&checkbox=1&debutN='.$debutN.'&finN='.$finN.'" />';
  }else{  
  }
		
		$query_Recordset = "SELECT MAX(operation.numero) AS Numop2 FROM operation,produits WHERE produits.Num2=operation.reference1 AND date_modification BETWEEN '".$debutN."'	AND '".$finN."'  AND produits.Type='".$_SESSION['menuParenT1']."' GROUP BY  designation,Qte  ";
		if($_SESSION['menuParenT1']!='Economat')
		$query_Recordset .= "UNION SELECT MAX(operation.numero) AS Numop2 FROM operation,boissonp WHERE boissonp.Num2=operation.reference1 AND date_modification BETWEEN '".$debutN."'	AND '".$finN."'  GROUP BY  designation,Qte ";
		$result2 = mysqli_query($con,$query_Recordset);
		$tab =array(""); $i=0;
		while($data1 = mysqli_fetch_object($result2)){ 
		    $tab[$i]= $data1->Numop2; $i++; echo "&nbsp;";
		}
				
	if(isset($_POST['ok']) && $_POST['ok'] == "OK")
		{$debut=substr($_POST['debut'],8,2).'-'.substr($_POST['debut'],5,2).'-'.substr($_POST['debut'],0,4);
		$fin=substr($_POST['fin'],8,2).'-'.substr($_POST['fin'],5,2).'-'.substr($_POST['fin'],0,4);
		$debutN=$_POST['debut'];$finN=$_POST['fin'];	
		$query_Recordset = "SELECT MAX(operation.numero) AS Numop2 FROM operation,produits WHERE produits.Num2=operation.reference1 AND date_modification BETWEEN '".$debutN."' AND '".$finN."'  AND produits.Type='".$_SESSION['menuParenT1']."' GROUP BY  designation,Qte  ";
		if($_SESSION['menuParenT1']!='Economat')
		$query_Recordset .= "UNION SELECT MAX(operation.numero) AS Numop2 FROM operation,boissonp WHERE boissonp.Num2=operation.reference1 AND date_modification BETWEEN '".$debutN."'	AND '".$finN."'  GROUP BY  designation,Qte ";
		//echo $query_Recordset;	
		$result2 = mysqli_query($con,$query_Recordset);
		$tab =array(""); $i=0;
		while($data1 = mysqli_fetch_object($result2)){ 
		    $tab[$i]= $data1->Numop2; $i++; echo "&nbsp;";
		}
			 
			if( !empty($_POST['choix'])){ 
				$choix =''; 
				//on boucle
				for ($i=0;$i<count($_POST['choix']);$i++)
				{	//on concatène
					  $choix .= $_POST['choix'][$i].'|';
					  $explore = explode('|',$choix);
						if($explore[$i]!='')
							{  
							
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
						{  	$req="UPDATE boissonp SET StockReel='".$explore0[$i]."' WHERE numero='".$explore[$i]."' "; 
							$reqsel=mysqli_query($con,$req);									
						}				
				}		
			}
			
			//if($reqsel)
			//	{	    
					$query_Recordset1 = "SELECT MAX(operation.numero) AS Numop1,produits.Num AS numero,Num2,designation,Qte_initiale,Qte_entree,qte_finale,date_modification,heure_operation,Qte,Seuil,StockReel,operation.designation_operation FROM operation,produits WHERE produits.Num2=operation.reference1  AND date_modification BETWEEN '".$debutN."'	AND '".$finN."'  AND produits.Type='".$_SESSION['menuParenT1']."' GROUP BY  designation,Qte";
					if($_SESSION['menuParenT1']!='Economat')
					$query_Recordset1 .= "UNION SELECT MAX(operation.numero) AS Numop1,boissonp.numero AS numero,Num2,designation,Qte_initiale,Qte_entree,qte_finale,date_modification,heure_operation,Qte,Seuil,StockReel,operation.designation_operation FROM operation,boissonp WHERE boissonp.Num2=operation.reference1  AND date_modification BETWEEN '".$debutN."'	AND '".$finN."'  GROUP BY  designation,Qte";
				$ok=1; $_SESSION['query_Recordset1']=$query_Recordset1;
				//} 
				}else { 	
						//if(isset($idr) && isset($checkbox)){  //echo $checkbox;
						if(isset($idr)){ 
							if($idr=='Boissons')
								    $query_Recordset1 = "SELECT MAX(operation.numero) AS Numop1,operation.numero AS numero,Num2,designation,Qte_initiale,Qte_entree,qte_finale,date_modification,heure_operation,Qte,Seuil,StockReel,operation.designation_operation FROM operation,boissonp WHERE boissonp.Num2=operation.reference1  AND date_modification BETWEEN '".$debutN."'	AND '".$finN."'	 GROUP BY  designation,Qte";  
							else
									$query_Recordset1 = "SELECT MAX(operation.numero) AS Numop1,operation.numero AS numero,Num2,designation,Qte_initiale,Qte_entree,qte_finale,date_modification,heure_operation,Qte,Seuil,StockReel,operation.designation_operation FROM operation,produits WHERE produits.Num2=operation.reference1  AND Famille = '".$idr."' AND date_modification BETWEEN '".$debutN."'	AND '".$finN."'	 AND produits.Type='".$_SESSION['menuParenT1']."'";
								}					
						 else
							{
							if(isset($_GET['checkbox']))
								{   $query_Recordset1 = "SELECT produits.Num AS numero,operation.numero AS Numop1,produits.Num2,designation,Qte_initiale,Qte_entree,qte_finale,date_modification,heure_operation,Qte,Seuil,StockReel,operation.designation_operation  FROM operation,produits WHERE produits.Num2=operation.reference1 AND date_modification BETWEEN '".$debutN."'	AND '".$finN."'   AND produits.Type='".$_SESSION['menuParenT1']."' ";
									if($_SESSION['menuParenT1']!='Economat')
									$query_Recordset1 .= "UNION SELECT boissonp.numero AS numero,operation.numero AS Numop1,Num2,designation,Qte_initiale,Qte_entree,qte_finale,date_modification,heure_operation,Qte,Seuil,StockReel,operation.designation_operation FROM operation,boissonp WHERE boissonp.Num2=operation.reference1 AND date_modification BETWEEN '".$debutN."'	AND '".$finN."'   ";
								}
							else 
								{   $query_Recordset1 = "SELECT produits.Num AS numero,operation.numero AS Numop1,produits.Num2,designation,Qte_initiale,Qte_entree,qte_finale,date_modification,heure_operation,Qte,Seuil,StockReel,operation.designation_operation FROM operation,produits WHERE produits.Num2=operation.reference1  AND operation.numero IN (SELECT MAX(operation.numero) FROM operation,produits WHERE produits.Num2=operation.reference1 AND date_modification BETWEEN '".$debutN."' AND '".$finN."'  AND produits.Type='".$_SESSION['menuParenT1']."' GROUP BY designation,Qte) ";
									if($_SESSION['menuParenT1']!='Economat')					 
									$query_Recordset1 .= "UNION SELECT boissonp.numero AS numero,operation.numero AS Numop1,Num2,designation,Qte_initiale,Qte_entree,qte_finale,date_modification,heure_operation,Qte,Seuil,StockReel,operation.designation_operation FROM operation,boissonp WHERE boissonp.Num2=operation.reference1   AND operation.numero IN (SELECT MAX(operation.numero)  FROM operation,boissonp WHERE boissonp.Num2=operation.reference1  AND date_modification BETWEEN '".$debutN."'	AND '".$finN."'  GROUP BY  designation,Qte)";					 
																							 
								 }
							}
						}
/* $_SESSION['nomHotel']='sdsdsds';
$_SESSION['date_emission']=date('d-m-Y');	$_SESSION['debut']=date('d-m-Y');	$_SESSION['fin']=date('d-m-Y');	
$_SESSION['initial_fiche']="120";
$_SESSION['remise']=0;$_SESSION['avanceA']=0;$_SESSION['montant']=0;$_SESSION['groupe1']="c";	$_SESSION['footer1']="ddd";		$_SESSION['footer2']="ddd";	 */

//if(isset($_SESSION['query_Recordset1'])) echo var_dump($_SESSION['query_Recordset1']) ; //else echo var_dump($query_Recordset1);

if(isset($_GET['debutN'])&& isset($_GET['finN'])){  
				if(isset($_GET['checkbox'])) { //if(isset($idr)) echo $idr;
				}
				else{
					if(isset($_SESSION['query_Recordset1']))	if(empty($idr)) $query_Recordset1=$_SESSION['query_Recordset1'];				
				}
		}	
//echo var_dump($query_Recordset1);		
			
?>
	<head> 
		<link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
			<script type="text/javascript" src="js/date-picker.js"></script>
			<script type="text/javascript" >
				function edition() { options = "Width=700,Height=700" ; window.open( "receipt2.php", "edition", options ) ; } 
			</script><link rel="Stylesheet" href='css/table.css' />
	</head>

<style>
		[type="checkbox"]:not(:checked),
		[type="checkbox"]:checked {
		  position: absolute;
		  left: -9999px;
		}
		 
		[type="checkbox"]:not(:checked) + label,
		[type="checkbox"]:checked + label {
		  position: relative; 
		  padding-left: 25px; 
		  cursor: pointer;    
		}
		
		[type="checkbox"]:not(:checked) + label:before,
		[type="checkbox"]:checked + label:before {
		  content: '';
		  position: absolute;
		  left:0; top: 2px;
		  width: 17px; height: 17px;
		  border: 1px solid #aaa;
		  background: #f8f8f8;
		  border-radius: 3px; 
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.3) 
		}
		 

		[type="checkbox"]:not(:checked) + label:after,
		[type="checkbox"]:checked + label:after {
		  content: '✔';
		  position: absolute;
		  top: 0; left: 4px;
		  font-size: 14px;
		  color: red;
		  transition: all .2s;
		}

		[type="checkbox"]:not(:checked) + label:after {
		  opacity: 0; 
		  transform: scale(0); 
		}

		[type="checkbox"]:checked + label:after {
		  opacity: 1; 
		  transform: scale(1); 
		}

		[type="checkbox"]:disabled:not(:checked) + label:before,
		[type="checkbox"]:disabled:checked + label:before {
		  box-shadow: none;
		  border-color: #bbb;
		  background-color: #ddd;
		}

		[type="checkbox"]:disabled:checked + label:after {
		  color: #999;
		}

		[type="checkbox"]:disabled + label {
		  color: #aaa;
		}
		 

		[type="checkbox"]:checked:focus + label:before,
		[type="checkbox"]:not(:checked):focus + label:before {
		  border: 1px dotted blue;
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
	</style>

	<body bgcolor='azure' style="margin-top:0px;padding-top:0px;">
	<form action='InventairePhysique.php?menuParent=<?php echo $_SESSION['menuParenT']; if(isset($debutN)) echo "&debutN=".$debutN."&finN=".$finN;?>' method='post' id="chgdept" >
		<?php
		//$month = date('m');$day = date('d');$year = date('Y');$today = $year . '-' . $month . '-' . $day;
			echo " <hr width='80%' noshade size=3>	<table align='center'>
				<tr>

				<td style='color:#444739;'>  <b>Période du&nbsp;:&nbsp;&nbsp; </b></td>
				<td>";?>
					<input type='date' name='debut' id='' size='20'  style='width:150px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value="<?php if(isset($debutN))  echo $debutN; else {echo date('Y-m-d'); $debutN=date('d-m-Y');} ?>"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php echo "</td>
				<td  style='color:#444739;'> <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Au:&nbsp;&nbsp; </b></td>
				<td>";?>
					<input type='date' name='fin' id='' size='20'  style='width:150px;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;' value="<?php if(isset($finN))  echo $finN; else {echo date('Y-m-d');$finN=date('d-m-Y');} ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<?php echo "</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='Submit' name='ok' value='OK' class='bouton3' style='border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;font-weight:bold;'/></td> 
				 		
				</tr>

			</table> <hr width='80%' noshade size=3>";

		$j= 0;	$comp=1;
		$req  = mysqli_query($con,"SELECT DISTINCT catPrd FROM categorieproduit WHERE Type='".$_SESSION['menuParenT1']."'") or die(mysqli_error($con));
		$req1 = mysqli_query($con,"SELECT DISTINCT catPrd FROM categorieproduit WHERE Type='".$_SESSION['menuParenT1']."'") or die(mysqli_error($con));	
		while($data = mysqli_fetch_array($req))
		{   $Categorie[$j] = $data['catPrd'];
		    $j++;
		}
		   if($comp==1) $totalRows_Recordset = 1; else $totalRows_Recordset = mysqli_num_rows($req);

		if($totalRows_Recordset==0) echo "<center> Aucune </center>";
			for($n=0;$n<$totalRows_Recordset;$n++)
				{ mysqli_query($con,"SET NAMES 'utf8'");
			     $result = mysqli_query($con,$query_Recordset1);$result0 = mysqli_query($con,$query_Recordset1);
				 $nbre = mysqli_num_rows($result);  $data0 = mysqli_fetch_object($result0); //$numero0=$data0->numero;
				   if(isset($data0->numero))   //if($nbre>0)
				   {	echo "	<table align='center' width='80%'  border='0' cellspacing='0' style='margin-top:-25px;border-collapse: collapse;font-family:Cambria;'>
			   <tr> <td colspan='10' align='right'>"; ?> <br/><input type="checkbox" id='test1' name='checkbox1' value='1'  <?php if(isset($_GET['checkbox'])) echo "checked='checked'"; ?>  onchange="document.forms['chgdept'].submit();"  >  <label for="test1" style='font-weight:bold;color:#444739;'>Consulter les mouvements de Stock</label><?php echo "</td></tr>
			   <tr> <td colspan='10'><br/> <span style='float:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.1em;color:#444739;'>  ";
			   if($comp==1)  echo "Valorisation du Stock de produits "; else echo "Catégorie: ".$Categorie[$n];	echo " </span>";
			   
			   	  if($n==0)	
					echo "<span style='float:right;'>";
				?>
					<select name='libelle' style='margin-bottom:8px;font-family:sans-serif;font-size:90%;border:0px solid teal;width:250px;' id='continent' onchange="document.forms['chgdept'].submit();"  >
					<option value =''> <?php if(isset($idr)) echo $idr; ?> </option> 
				<?php //if(!empty($Categorie)) { echo "<option value='".$Categorie."'>";  echo $Categorie;   echo" </option>";} else { echo "<option value=''>";  echo" </option>";}
				while($data=mysqli_fetch_array($req1))
				{    
					echo" <option value ='".$data['catPrd']."'> ".ucfirst($data['catPrd'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option> ";
				}
				echo "</select> </span>

			  
			  </td>"; 
			  echo " </tr>
							<tr  style='background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=2' style='text-decoration:none;color:white;' title=''>Date <span style='font-size:0.8em;'></span></a></td>    
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=2' style='text-decoration:none;color:white;' title=''>Heure <span style='font-size:0.8em;'></span></a></td>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=2' style='text-decoration:none;color:white;' title=''>Nature Opération <span style='font-size:0.8em;'></span></a></td>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=2' style='text-decoration:none;color:white;' title=''>Réf. <span style='font-size:0.8em;'></span></a></td>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=2' style='text-decoration:none;color:white;' title=''>Désignation<span style='font-size:0.8em;'></span></a></td>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=3' style='text-decoration:none;color:white;' title=''>Seuil<span style='font-size:0.8em;'></span></a></td>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=4' style='text-decoration:none;color:white;' title=''>Qté init.<span style='font-size:0.8em;'></span></a></td>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=5' style='text-decoration:none;color:white;' title=''>Qt&eacute; +/- <span style='font-size:0.8em;'></span></a></td>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=5' style='text-decoration:none;color:white;' title=''>Stock théo.<span style='font-size:0.8em;'></span></a></td>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=5' style='text-decoration:none;color:white;' title=''>Stock réel<span style='font-size:0.8em;'></span></a></td>
							</tr>";
		
					$cpteur=1;$i=0;$dataZ="";	
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
						$numero=$data->Num2;		
						if(($numero>=0)&&($numero<=9)) $numero="0000".$numero ; else if(($numero>=10)&&($numero <=99)) $numero="000".$numero ;else $numero="00".$numero ;
						$Qte_initiale=$data->Qte_initiale;   $qte_finale=$data->qte_finale;  $pls=($qte_finale>$Qte_initiale)?"+":"-&nbsp;"; //if($qte_finale>$Qte_initiale) $pls="+"; else $pls="-";
							echo "
							<tr class='rouge1' bgcolor='".$bgcouleur."'>
							
								<input type='hidden'  name='choix[]' value='".$data->numero."'>
								";
								$var= "text";
								echo "<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($data->date_modification,8,2).'-'.substr($data->date_modification,5,2).'-'.substr($data->date_modification,0,4)."</td>
								<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data->heure_operation."</td>  
								<td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> &nbsp;".$data->designation_operation."</td>
								<td align='center' align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> ".$numero."</td>
								<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> &nbsp;".$data->designation." ".$data->Qte."</td> 
								<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> ".$data->Seuil."</td>
								<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> ".$Qte_initiale."</td>
								<td align='left' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$pls."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ".abs($data->Qte_entree)."</td>
								<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$qte_finale."</td>";
								echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>";
								
								echo "<input  type='";  echo $var; echo "' name='choix0[]'"; 
								echo "style='"; for($j=0; $j<sizeof($tab);$j++) { if($tab[$j] == $data->Numop1)   echo "width:100px;text-align:center;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"; else echo "width:100px;background-color:".$bgcouleur.";text-align:center;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"; }   echo "' ";
								echo "value='"; for($j=0; $j<sizeof($tab);$j++) { if($tab[$j] == $data->Numop1)   echo $data->StockReel; else echo ""; } echo "'"; 
								echo "onkeypress='testChiffres(event);'/>";
								echo "</td>";
								//echo "<td align='center' style=''> <a class='info' href=''  style='color:#FC7F3C;'><i class='fa fa-plus-square'></i><span style='color:#FC7F3C;font-size:0.8em;'>Modifier</span></a>";
								//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='info' href=''  style='color:#B83A1B;'><i class='fa fa-trash-alt'</i><span style='color:#B83A1B;font-size:0.8em;'>Supprimer</span></a></td>";
								echo "</tr>";	
								
								//$designation=$data->designation;$Seuil=$data->Seuil;$StockReel=$data->StockReel;
								$ecrire=fopen('txt/InventairePhysique.txt',"w");
								$dataZ.=$i.';'.$numero.';'.$data->designation.';'.$data->Seuil.';'.$data->qte_finale.';'.'---'."\n";
								$ecrire=fopen('txt/InventairePhysique.txt',"a+");
								fputs($ecrire,$dataZ);	


							
								
					}//unset($var);
					
				echo "<tr> 
				<td colspan='10'> 
				<span style='float:left;text-decoration:none; font-family:Cambria;font-size:1em;color:#444739;'> 
				<br/>
				+ : Augmentation du stock <br/> 
				 -&nbsp; : Diminution du stock";
			 	echo " </span>	

				<span style='float:right;text-decoration:none; font-family:Cambria;font-size:1em;color:#444739;'> 
				<br/>->&nbsp;<a href='InventairePhysiquepdf.php?id=ddddd&logo=".$var."' target='_blank'>Inventaire physique</a>	
				<br/>->&nbsp;<a href='InventairePhysiquepdf.php?id=ddddd&logo=".$var."' target='_blank'>Etat préparatoire d'Inventaire </a>	";	
				if(isset($_GET['checkbox'])) 
					echo "<br/>->&nbsp;<a href='InventairePhysiquepdf.php?id=ddddd&logo=".$var."' target='_blank'>Mouvement du Stock des produits </a>"	;						
				
				echo " </span>";
				echo " </td>"; 
			     echo " </tr>";
			  
			  echo "</table>";

				}else {
					if(isset($idr) || isset($ok)){
						echo "<script language='javascript'>";
						echo 'alertify.error(" Aucune donnée à afficher ");';
						echo "</script>";
					}
				}
			}
	?>				
			</form>	
	
	</body>
</html>
<?php
// echo "<a href='InventairePhysiquepdf.php'> Lien </a>	";	
?>