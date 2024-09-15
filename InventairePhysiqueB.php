<?php
include_once'menu.php';
	 $idr = isset($_POST['libelle'])?$_POST['libelle']:null;
	 $debutN=isset($_POST['debut'])?$_POST['debut']:date('Y-m-d');$finN=isset($_POST['fin'])?$_POST['fin']:date('Y-m-d');	
     $checkbox1 = isset($_POST['checkbox1'])?$_POST['checkbox1']:null;	
 if($checkbox1==1) { //echo $_SESSION['checkbox']=isset($_GET['checkbox'])?$_GET['checkbox']:NULL;
	 	// //$pre_sql="CREATE table IF NOT EXISTS checkbox(Qte int)"; $req1 = mysqli_query($con, $pre_sql) or die (mysqli_error($con));
	 	// //$pre_sql="CREATE table IF NOT EXISTS QteLigneT(Qte int)"; $req1 = mysqli_query($con, $pre_sql) or die (mysqli_error($con));
  echo '<meta http-equiv="refresh" content="0; url=InventairePhysique.php?menuParent='.$_SESSION['menuParenT'].'&checkbox=1" />';
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
							$req="UPDATE boissonb SET StockReel='".$explore0[$i]."' WHERE numero='".$explore[$i]."' "; 
							$reqsel=mysqli_query($con,$req);	
													
						}				
				}		
			}
			
			if($reqsel)
				{	//echo "<script language='javascript'>";
					//echo 'alertify.success("Stock réel mis à jour");';
					//echo "</script>";
					//header("Location: InventairePhysique.php?menuParent=Restauration");
					$query_Recordset1 = "SELECT boissonb.numero AS numero,operation.numero AS Numop1,numero2,designation,Qte_initiale,Qte_entree,qte_finale,date_modification,heure_operation,Qte,Seuil,StockReel FROM operation,boissonb WHERE boissonb.numero2=operation.reference1  AND date_modification BETWEEN '".$debutN."'	AND '".$finN."' AND designation_operation <> 'Mise à jour Produit alimentaire'";
					//echo '<meta http-equiv="refresh" content="1; url=InventairePhysique.php?menuParent=Restauration" />';
				}
		}else { //$debutN=isset($debutN)?$debutN:date('Y-m-d');$finN=isset($finN)?$finN:date('Y-m-d');	
						if(isset($idr))
						    $query_Recordset1 = "SELECT boissonb.numero AS numero,operation.numero AS Numop1,numero2,designation,Qte_initiale,Qte_entree,qte_finale,date_modification,heure_operation,Qte,Seuil,StockReel FROM operation,boissonb WHERE boissonb.numero2=operation.reference1 
						 AND Categorie = '".$idr."' AND date_modification BETWEEN '".$debutN."'	AND '".$finN."'	AND designation_operation <> 'Mise à jour Produit alimentaire' ORDER BY operation.numero ";
					   else
							{
							if(isset($_GET['checkbox']))
								{   $query_Recordset1 = "SELECT boissonb.numero AS numero,operation.numero AS Numop1,numero2,designation,Qte_initiale,Qte_entree,qte_finale,date_modification,heure_operation,Qte,Seuil,StockReel
								FROM operation,boissonb WHERE boissonb.numero2=operation.reference1 AND date_modification BETWEEN '".$debutN."'	AND '".$finN."'  AND designation_operation <> 'Mise à jour Produit alimentaire' ORDER BY operation.numero ";
								}
							else 
								{$query_Recordset1 = "SELECT boissonb.numero AS numero,operation.numero AS Numop1,numero2,designation,Qte_initiale,Qte_entree,qte_finale,date_modification,heure_operation,Qte,Seuil,StockReel
								FROM operation,boissonb WHERE boissonb.numero2=operation.reference1  AND designation_operation <> 'Mise à jour Produit alimentaire' AND operation.numero IN (SELECT MAX(operation.numero)  FROM operation,boissonb WHERE boissonb.numero2=operation.reference1  
									AND date_modification BETWEEN '".$debutN."'	AND '".$finN."' AND designation_operation <> 'Mise à jour Produit alimentaire' GROUP BY  designation,Qte  ORDER BY operation.numero) ";
								}
							}
				}
	 

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

	<body bgcolor='azure' style="margin-top:-20px;padding-top:0px;">
	<form action='InventairePhysique.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>' method='post' id="chgdept" >
		<?php
		//$month = date('m');$day = date('d');$year = date('Y');$today = $year . '-' . $month . '-' . $day;
			echo " <hr width='70%' noshade size=3>	<table align='center'>
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

			</table> <hr width='70%' noshade size=3>";

		 $j= 0;
		$comp=1;
		$req = mysqli_query($con,"SELECT DISTINCT Categorie  FROM boissonb");
		$req1 = mysqli_query($con,"SELECT * FROM config_boisson ORDER BY LibCateg") or die (mysqli_error($con));	
		while($data = mysqli_fetch_array($req))
		{   $Categorie[$j] = $data['Categorie'];
		    $j++;
		}
		   if($comp==1) $totalRows_Recordset = 1; else $totalRows_Recordset = mysqli_num_rows($req);
		 
		 
			//echo  "";
			$query_Recordset = "SELECT MAX(operation.numero) AS Numop2 FROM operation,boissonb WHERE boissonb.numero2=operation.reference1 AND date_modification BETWEEN '".$debutN."'	AND '".$finN."' GROUP BY  designation,Qte  ORDER BY operation.numero";
				$result2 = mysqli_query($con,$query_Recordset);	//$nbre2 = mysqli_num_rows($result2);
				$tab =array(""); $i=0;
				//while( $data = mysqli_fetch_object($result))
				while($data1 = mysqli_fetch_object($result2)){ 
				  $tab[$i]= $data1->Numop2; $i++; echo "&nbsp;";
				}				
					//echo sizeof($tab);
					
		if($totalRows_Recordset==0) echo "<center> Aucune </center>";
			for($n=0;$n<$totalRows_Recordset;$n++)
				{ mysqli_query($con,"SET NAMES 'utf8'");
/* 				 if($comp==1)
					{ */  
/* 				if(isset($_SESSION['query_Recordset1'])){ 
							 echo $query_Recordset1 = $_SESSION['query_Recordset1'];
						}else {echo 12;
					
						} */
/* 					}
				 else 
					 $query_Recordset1 = "SELECT * FROM boissonb WHERE Categorie='".$Categorie[$n]."' ORDER BY numero2 ASC"; */
				 
				 
			     $result = mysqli_query($con,$query_Recordset1);
				 $nbre = mysqli_num_rows($result);
				   if($nbre>0)
				   {	echo "	<table align='center' width='70%'  border='0' cellspacing='0' style='margin-top:-25px;border-collapse: collapse;font-family:Cambria;'>
			   <tr> <td colspan='10' align='right'>"; ?> <input type="checkbox" id='test1' name='checkbox1' value='1'  <?php if(isset($_GET['checkbox'])) echo "checked='checked'"; ?>  onchange="document.forms['chgdept'].submit();"  >  <label for="test1" style='font-weight:bold;color:#444739;'>Consulter les mouvements de Stock</label><?php echo "</td></tr>
			   <tr> <td colspan='10'><br/> <span style='float:left;text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.1em;color:#444739;'>  ";
			   if($comp==1)  echo "Valorisation du Stock de Boissons "; else echo "Catégorie: ".$Categorie[$n];	echo " </span>";
			   
			   	  if($n==0)	
					echo "<span style='float:right;'>";
				?>
					<select name='libelle' style='margin-bottom:8px;font-family:sans-serif;font-size:90%;border:0px solid teal;width:250px;' id='continent' onchange="document.forms['chgdept'].submit();"  >
					<option value =''> </option> 
				<?php //if(!empty($Categorie)) { echo "<option value='".$Categorie."'>";  echo $Categorie;   echo" </option>";} else { echo "<option value=''>";  echo" </option>";}
				while($data=mysqli_fetch_array($req1))
				{    
					echo" <option value ='".$data['LibCateg']."'> ".ucfirst($data['LibCateg'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option> ";
				}
				echo "</select> </span>

			  
			  </td>"; 
			  echo " </tr>
							<tr  style='background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=2' style='text-decoration:none;color:white;' title=''>Date Op.<span style='font-size:0.8em;'></span></a></td>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=2' style='text-decoration:none;color:white;' title=''>Heure op.<span style='font-size:0.8em;'></span></a></td>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=2' style='text-decoration:none;color:white;' title=''>Réf. Op.<span style='font-size:0.8em;'></span></a></td>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=2' style='text-decoration:none;color:white;' title=''>Désignation<span style='font-size:0.8em;'></span></a></td>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=3' style='text-decoration:none;color:white;' title=''>Seuil<span style='font-size:0.8em;'></span></a></td>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=4' style='text-decoration:none;color:white;' title=''>Qté init.<span style='font-size:0.8em;'></span></a></td>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=5' style='text-decoration:none;color:white;' title=''>Qt&eacute; +/- <span style='font-size:0.8em;'></span></a></td>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=5' style='text-decoration:none;color:white;' title=''>Stock théo.<span style='font-size:0.8em;'></span></a></td>
								<td style='border-right: 2px solid #ffffff' align='center' ><a class=''  href='Bar.php?menuParent=".$_SESSION['menuParenT']."&trie=5' style='text-decoration:none;color:white;' title=''>Stock réel<span style='font-size:0.8em;'></span></a></td>
								
					
						<td align='center' >Actions</td>
							</tr>";
		
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
						$Qte_initiale=$data->Qte_initiale;   $qte_finale=$data->qte_finale;  $pls=($qte_finale>$Qte_initiale)?"+":"-"; //if($qte_finale>$Qte_initiale) $pls="+"; else $pls="-";
							echo "
							<tr class='rouge1' bgcolor='".$bgcouleur."'>
							
								<input type='hidden'  name='choix[]' value='".$data->numero."'>
								";
		 //for($j=0; $j<sizeof($tab)-1;$j++) { if($tab[$j] == $data->Numop1)   $var= "<input  type='text' value='1' > ";   else $var= "<input  type='hidden' value='2' > "; } 
		  $var= "text";
								//echo " <td>"; echo $tab[$j]."&nbsp;".$data->Numop1;  echo"</td>";
								echo "<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($data->date_modification,8,2).'-'.substr($data->date_modification,5,2).'-'.substr($data->date_modification,0,4)."</td>
								<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$data->heure_operation."</td>
								<td align='center' align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> ".$numero."</td>
								<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> ".$data->designation." ".$data->Qte."</td> 
								<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> ".$data->Seuil."</td>
								<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> ".$Qte_initiale."</td>
								<td align='left' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$pls."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ".$data->Qte_entree."</td>
								<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$qte_finale."</td>";
								echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>";
								
echo "<input  type='";  echo $var; echo "' name='choix0[]'"; 
echo "style='"; for($j=0; $j<sizeof($tab);$j++) { if($tab[$j] == $data->Numop1)   echo "width:100px;text-align:center;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"; else echo "width:100px;background-color:".$bgcouleur.";text-align:center;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;"; }   echo "' ";
echo "value='";     for($j=0; $j<sizeof($tab);$j++) { if($tab[$j] == $data->Numop1)   echo $data->StockReel; else echo ""; } echo "'"; 
    //for($j=0; $j<sizeof($tab);$j++) { if($tab[$j] != $data->Numop1)   echo "readonly='readonly'"; }
echo "onkeypress='testChiffres(event);'/>";

echo "</td>";
								echo "<td align='center' style=''> <a class='info' href=''  style='color:#FC7F3C;'><i class='fa fa-plus-square'></i><span style='color:#FC7F3C;font-size:0.8em;'>Modifier</span></a>";
								echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='info' href=''  style='color:#B83A1B;'><i class='fa fa-trash-alt'</i><span style='color:#B83A1B;font-size:0.8em;'>Supprimer</span></a></td>";
								echo "</tr>";	
					} unset($var);
					
				echo "<tr> 
				<td colspan='10'> 
				<span style='float:left;text-decoration:none; font-family:Cambria;font-size:1em;color:#444739;'> 
				<br/>
				+ : Augmentation du stock <br/> 
				 -&nbsp; : Diminution du stock";
			 	echo " </span>			  
			  </td>"; 
			  echo " </tr>";
			  
			  echo "</table>";

				}
			}
	?>				
			</form>		
	</body>
</html>
<?php

?>