<?php
include_once'menu.php';

$idr = isset($_POST['service'])?$_POST['service']:null;  unset($_SESSION['idr']); 

$rz="SELECT MAX(DateAffectation) AS date FROM affectioninterne "; $req=mysqli_query($con,$rz); $data=mysqli_fetch_object($req); $date=$data->date;
//$rz="SELECT DATEDIFF('".$Jour_actuel."','".$date."') AS difference FROM affectioninterne "; $req=mysqli_query($con,$rz); $data=mysqli_fetch_object($req); $difference=$data->difference;
if($date<$Jour_actuel){
	$rz="SELECT Num FROM affectioninterne WHERE DateAffectation < '".$Jour_actuel."'"; $req=mysqli_query($con,$rz);
	if(mysqli_num_rows($req)>0){ 
		while($data=mysqli_fetch_array($req)){
		 $sql="UPDATE produitsencours SET Etat ='0' WHERE Num='".$data['Num']."'";
		 $rek=mysqli_query($con,$sql) or die(mysqli_error($con)); 
		}
	}	
}	
if($date==$Jour_actuel)	$date=$Jour_actuel;
$idr2 = isset($_POST['ladate'])?$_POST['ladate']:$date; 

	if (isset($_POST['AFFECTER'])&& $_POST['AFFECTER']=='AFFECTER') 
	   {  $produit=$_POST['produit']; //if(empty($_POST['nbre_produit'])) $_SESSION['nbre_produit']=1;  else $_SESSION['nbre_produit']=$_POST['nbre_produit']; 
		  $qteAffecte=$_POST['qteAffecte'];  $service=ucfirst($_POST['serv']);  $quantiteStock=$_POST['quantite']; $representant=$_POST['representant'];
		 if($qteAffecte<$quantiteStock)
		  {//$date_affect = date('d-m-Y');
			 mysqli_query($con,"SET NAMES 'utf8'");
			 $check='SELECT Num FROM produitsencours WHERE LigneCde="'.$produit.'" AND Client="'.$service.'"  AND Etat ="1" AND Type="3"';
			 $ret=mysqli_query($con,$check);
				if(mysqli_num_rows($ret)>0){
				$aws=mysqli_fetch_object($ret); $Num=$aws->Num; 
				 $sql="UPDATE produitsencours SET qte =qte+'".$qteAffecte."' WHERE Num='".$Num."'";
				}else {
		   		 $sql="INSERT INTO produitsencours SET Num=NULL,Client='".$service."', LigneCde ='".$produit."', prix ='0',qte ='".$qteAffecte."',Etat='1',Type='3'";
				}
				$reqselR=mysqli_query($con,$sql) or die(mysql_error());			
				
				$qteRestant=$quantiteStock-$qteAffecte;  //$ref="AFFECT_".$produit."_".$service ; 
				 $rz="SELECT * FROM produits WHERE Num='".$produit."' AND Type='".$_SESSION['menuParenT1']."'"; $req=mysqli_query($con,$rz);
				$data=mysqli_fetch_object($req);  $QteInitial= $data->Qte_Stock; $designation=$data->Designation ; 
		  
				if($reqselR)
				{$rek="UPDATE produits SET Qte_Stock='".$qteRestant."',StockReel='".$qteRestant."' WHERE Num='".$produit."'";
				 $query = mysqli_query($con,$rek) or die (mysqli_error($con));
				 
				$check='SELECT MAX(Num) AS Num FROM produitsencours WHERE Etat ="1" AND Type="3"';
				$ret=mysqli_query($con,$check);	$aws=mysqli_fetch_object($ret); $Num=$aws->Num; 
				
				$re="INSERT INTO affectioninterne VALUES('".$Num."','".$Jour_actuel."')"; 
				$query=mysqli_query($con,$re);				 
				 
				 $re="INSERT INTO operation VALUES(NULL,'".$Num."','Affectation Interne','".$produit."','".$QteInitial."','".$qteAffecte."','".$qteRestant."','".$Jour_actuel."','".$Heure_actuelle."','".$representant."','".$qteAffecte."')"; 
				 $query=mysqli_query($con,$re);
				}
				if($query)
				{echo "<script language='javascript'>";
				 echo "var quantite = '".$qteAffecte."';"; 
				 echo "var designation = '".$designation."';"; 
				 echo "var service = '".$service."';"; 
			     echo 'alertify.success("("+quantite+") "+designation+" ===> "+service);';
			     echo "</script>";
				}
				$_SESSION['idr']=$service;
				//$ret1=mysqli_query($con,'SELECT *  FROM produitsencours WHERE Client="'.$service.'" AND Etat="1" AND Type ="3"');
				//$NbreAf=mysqli_num_rows($ret1);

			//	header('location:ticket_affectation.php');
		}
		 else 
			{		
				echo "<script language='javascript'>"; 
				echo " alert('La quantité en stock ne permet pas d'affeter cette quantité de produit');";
				echo "</script>"; 
			} 
	
	 }
	 
	$idr=isset($_SESSION['idr'])? $_SESSION['idr']:$idr;
		
	$ret1=mysqli_query($con,'SELECT *  FROM produitsencours,affectioninterne WHERE affectioninterne.Num=produitsencours.Num AND Client="'.$idr.'" AND Etat="1" AND Type ="3" AND DateAffectation ="'.$idr2.'"');
	$NbreAf=mysqli_num_rows($ret1);
	

?>
<html>
	<head> 
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script type="text/javascript" src="js/date-picker.js"></script>
		<link rel="Stylesheet" href='css/table.css' />	
		</script>	<script src="js/sweetalert.min.js"></script>			
	</head>
	<body bgcolor='azure' style="">
	<div align="" style="">
		<div align="center" style="">
		    	 <form action="Affectation.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>" method="POST" id="chgdept" name='affectation'> 		 <br/>
				<table width="800" border="0" cellpadding="1" cellspacing="1" id="tab">
					<tr>
						<td colspan="2">
							<h2 style="text-align:center; font-family:Cambria;color:maroon;">AFFECTATION INTERNE - DE PRODUITS</h2>
						</td>
					</tr>
					<tr style=''>
						<td><hr/> 
						</td>
					</tr>

					 <tr style='background:#EFECCA;'>   <!--  #C0C0C0  !-->
						<td  align='center' colspan="2" style="font-size:1.2em;">
						<span style="" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						Service d'affectation: <span style="font-style:italic;font-size:0.8em;color:#800000;"> </span> 
						&nbsp;&nbsp;
						<?php 
						if(isset($idr)&& !empty($idr)){ echo $idr;
						}else {?>
							<select name='service' class='rouge1' style='width:200px;font-family:sans-serif;font-size:0.8em;' required id='service' onchange="document.forms['chgdept'].submit();" /> 
								<option value=''> </option> 
									<?php
									  mysqli_query($con,"SET NAMES 'utf8'");
										$ret=mysqli_query($con,'SELECT * FROM service');
										while ($ret1=mysqli_fetch_array($ret))
											{
												echo '<option value="'.$ret1['nom'].'">';
												echo($ret1['nom']);
												echo '</option>'; 
											}
									?> 
							</select>
							<?php } ?> 
							<span style='color:#BD8D46;'>
								<a class='info2'>
									<span style='color:#BD8D46;font-size:0.7em;'> Nombre d'affectations du <?php echo $Date_actuel;?></span> 
									 <?php if(isset($NbreAf) && ($NbreAf>0) && isset($idr)) echo "(".$NbreAf.")";  ?>
								</a>
							</span> 
							</span>


						</td>
					</tr>
			
			
						<?php
						
/* 							echo"<td><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre de produits à affecter&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
							<input type='text' id=''";  if(isset($_SESSION['nbre_produit'])) echo "value='".$_SESSION['nbre_produit']."'";  echo "name='nbre_produit' style='width:130px;' onkeypress='testChiffres(event);'/> 
							</td>"; */?>				

					<tr style=''>
						<td colspan='2'><hr style=''/>
						</td>
					</tr>

					<tr><td> 
					<table ALIGN='CENTER' height="" cellpadding="4" cellspacing="4">
					<tr>
						<td style=""> D&eacute;signation  : </td>
						<td >&nbsp;
							<select name='produit' id='produit' style='width:200px;font-family:sans-serif;font-size:0.8em;margin-left:30px;'> 
								<option value=''>  </option> 
									<?php
									  mysqli_query($con,"SET NAMES 'utf8'");
										$ret=mysqli_query($con,'SELECT Num,Designation FROM produits WHERE TypePrdts=2');
										while ($ret1=mysqli_fetch_array($ret))
											{
												echo '<option value="'.$ret1['Num'].'">';
												echo($ret1['Designation']);
												echo '</option>'; 
											}
									?> 
							</select>						
						</td>
					</tr>
					<tr>
						<td  style=""> Seuil fix&eacute; : <span style="font-style:italic;font-size:0.8em;color:#800000;"> </span></td>
						<td >&nbsp;&nbsp;<input type="text" id="Seuil" name="seuil" readonly value="" style="width:200px;margin-left:30px;"/> </td>
					</tr>
					<tr>
					
					<input type="hidden" name="serv" value='<?php if(isset($idr)) echo $idr;?>'/>
				
					<tr>
						<td  style=""> Quantit&eacute; en Stock: </td>
						<td >&nbsp;&nbsp;<input type="text" id="Qtestock" name="quantite" readonly value="" style="width:200px;margin-left:30px;"/> </td>
					</tr>

					 <tr>
						<td  style=""> Quantit&eacute;e affect&eacute;e: </td>
						<td >&nbsp;&nbsp;<input type="number" id="" name="qteAffecte" min='1' style="width:200px;margin-left:30px;" onkeypress='testChiffres(event);' placeholder='1' /> </td>
					</tr>
					 <tr>
						<td  style=""> Représentant du Service: <span style="font-style:italic;font-size:0.8em;color:#800000;"></span> </td>
						<td >&nbsp;&nbsp;<input type="text" id="" name="representant" style="width:200px;margin-left:30px;"/> </td>
					</tr>
					<tr><td> &nbsp; </td></tr>
					</table>
					</td></tr>
					<tr>
						<td colspan="2" align="center" > <input type="submit" value="AFFECTER" id="" class="bouton2"  name="AFFECTER" style=""/>
						&nbsp;&nbsp;<input type="reset" value="ANNULER" class="bouton2"  name="Annuler" style=""/> </td>
					</tr>	<tr><td> &nbsp; </td></tr>
				</table>
		    </div>
			
				<table align="center" width="800" border="0" cellspacing="0" style="margin-top:10px;border-collapse: collapse;font-family:Cambria;">
				<tr><td colspan='7' > <span style="align:left;font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:maroon;" >Liste des affectations  
				<span style='color:black;font-size:0.7em;font-weight:normal;'>
				<?php echo "<span style='font-size:1.1em;color:teal;font-style:italic;font-weight:bold;'>[".substr($idr2,8,2).'-'.substr($idr2,5,2).'-'.substr($idr2,0,4)."]</span>"; ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				
						<?php
					/* $reqsel=mysqli_query($con,"SELECT * FROM clients WHERE Type='".$_SESSION['menuParenT1']."' ORDER BY Num2 ASC ");
					$nbre_clts=mysqli_num_rows($reqsel);
					$CltsParPage=25; //Nous allons afficher 5 contribuable par page.
					$nombreDePages=ceil($nbre_clts/$CltsParPage); //Nous allons maintenant compter le nombre de pages.
					 
					if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
					{
						  $pageActuelle=intval($_GET['page']);
					 
						 if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
						 {
							   $pageActuelle=$nombreDePages;
						 }
					}
					else // Sinon
					{
						  $pageActuelle=1; // La page actuelle est la n°1    
					}
					 $premiereEntree=($pageActuelle-1)*$CltsParPage;
					
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:red;'>Page :</span> "; //Pour l'affichage, on centre la liste des pages
						for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
						{
							 //On va faire notre condition
							 if($i==$pageActuelle) //Si il s'agit de la page actuelle...
							 {
								 echo ' [ '.$i.' ] '; 
							 }	
							 else //Sinon...
							 {
								  if(!empty($fiche))
									echo ' <a href="createclt.php?menuParent='.$_SESSION['menuParenT1'].'&page='.$i.'">'.$i.'</a> ';
								  else 
									echo ' <a href="createclt.php?menuParent='.$_SESSION['menuParenT1'].'&page='.$i.'">'.$i.'</a> ';
							 }
						} */
					if(!isset($_GET['state']))
					{?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a class='info3'  href="Affectation.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&state=1" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
					<img src="logo/cal.gif" style="border:1px solid #ffebcd;" alt="Calendrier" title=""><span style='font-size:0.8em;color:maroon;'>Calendrier</span></a>
					<?php }
					else  {?>				
						 <input required type='date' name='ladate' id='' style='border-radius: 15px;margin-bottom:2px;' onchange="document.forms['chgdept'].submit();">
					<?php }?>
					</form>
					</span>
					<span style="float:right;" >
						<a href="etat_stock.php" class='info2' style="text-decoration:none;">
						<span style='font-weight:normal;color:black;font-size:0.7em;'>Liste des affectations de produits</span><img src="logo/pdf_small.gif"/> 
						<a/>
					</span>
					</td></tr> 
					<tr style=" background-color:silver;color:maroon;font-size:1.1em; ">
						<td style="border: 2px solid #ffebcd" align="center" >N°</td>
						<td style="border: 2px solid #ffebcd" align="center" >Heure d'affectation</td>
						<td style="border: 2px solid #ffebcd" align="center" >Désignation</td>
						<td style="border: 2px solid #ffebcd" align="center" >Service d'affectation</td>
						<td style="border: 2px solid #ffebcd" align="center" >Qté affectée</td>
						<td style="border: 2px solid #ffebcd" align="center" >Représentant</td>
						<td style="border: 2px solid #ffebcd" align="center" >Actions</td>
					</tr>
					<?php
						  mysqli_query($con,"SET NAMES 'utf8'");
							$rz="SELECT Num FROM affectioninterne WHERE DateAffectation ='".$idr2."'"; 
							$req=mysqli_query($con,$rz); $Liste = array(); $i=0;$j=0;
							while($data=mysqli_fetch_array($req)){$i++; $j++;
							 $Liste[$i]=$data['Num'];
							
/* 							$dataL='';
							for($j=1;$j<=count($Liste);$j++){
								$dataL.=$Liste[$j];
								if(($j>0) &&($j<count($Liste)))
									$dataL.=",";
							} */
					   $query_Recordset1 = "SELECT produitsencours.Num AS Num,produits.Designation,produitsencours.Client,produitsencours.qte,heure_operation,operation.service FROM produits,produitsencours,operation WHERE operation.ref_operation=produitsencours.Num AND produits.Type='".$_SESSION['menuParenT1']."' AND produits.Num=produitsencours.LigneCde AND produitsencours.Num In ('".$Liste[$i]."') AND produitsencours.Type='3' ORDER BY heure_operation DESC ";
					   $Recordset_2 = mysqli_query($con,$query_Recordset1);
							$cpteur=1;$dataT=""; 
							while($data=mysqli_fetch_array($Recordset_2))
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
								$nbre=$data['Num'];	 

								//$queryRecordset = "SELECT heure_operation,service FROM operation WHERE ref_operation='".$data['Num']."'";
								//$Recordset = mysqli_query($con,$queryRecordset);	$data0=mysqli_fetch_object($Recordset);						
							
								//$ecrire=fopen('txt/client.txt',"w");
								//$dataT.=$nbre.';'.$data['NomClt'].';'.$data['AdresseClt'].';'.$data['TelClt'].';'.$data['EmailClt']."\n";	
								//$ecrire2=fopen('txt/client.txt',"a+");
								//fputs($ecrire2, $dataT); 
								
								//if(($nbre>=0)&&($nbre<=9)) $nbre="0000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="000".$nbre ;else $nbre="00".$nbre ;
								
								echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>"; 
								echo " 	<td align='center'style='border-right: 2px solid #ffebcd; border-top: 2px solid #ffebcd;'>".$j.".</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffebcd; border-top: 2px solid #ffebcd;'>".$data['heure_operation']."</td>";
								echo " 	<td align=''style='border-right: 2px solid #ffebcd; border-top: 2px solid #ffebcd;'>".$data['Designation']."</td>";
								echo " 	<td align=''style='border-right: 2px solid #ffebcd; border-top: 2px solid #ffebcd;'>".$data['Client']."</td>";
								echo " 	<td align='center'style='border-right: 2px solid #ffebcd; border-top: 2px solid #ffebcd;'>".$data['qte']."</td>";
								echo " 	<td align=''style='border-right: 2px solid #ffebcd; border-top: 2px solid #ffebcd;'>".$data['service']."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffebcd;border-top: 2px solid #ffebcd;'>";
									echo " 	<a class='info3' href='createclt.php?menuParent=".$_SESSION['menuParenT']."&update=".$data['Num']."'><img src='logo/b_edit.png' alt='' width='16' height='16' border='0'><span style='font-size:0.8em;'>Modifier</span></a>";
									echo " 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
									echo " 	<a class='info3' href='createclt.php?menuParent=".$_SESSION['menuParenT']."&delete=".$data['Num']."'><img src='logo/b_drop.png' alt='Supprimer' width='16' height='16' border='0'><span style='font-size:0.8em;color:red;'>Supprimer</span></a>";
									echo " 	</td>";
									echo " 	</tr> ";
							}
						}
					?>
					<tr></tr>
				</table>
				
				
</div>		
</body>	
	<script type="text/javascript">
	// fonction pour selectionner le tarif
		function action7(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						var mavariable = leselect.split('||');
/* 						if(!empty(mavariable[0])){
						document.getElementById('Qtestock').value = mavariable[0];
						document.getElementById('PrixVente').value = mavariable[1];
						}else { */
						document.getElementById('Qtestock').value = mavariable[1];
						document.getElementById('Seuil').value = mavariable[3];
						//document.getElementById('PrixVente2').value = mavariable[2];
						//}
					}
				}
				xhr.open("POST","InfoProduit.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('produit');
				//sel1 = document.getElementById('combo3');
				//sh1=sel1.options[sel1.selectedIndex].value;
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("numPdt="+sh);
		}

		var momoElement2 = document.getElementById("produit");
		if(momoElement2.addEventListener){
		  momoElement2.addEventListener("change", action7, false);

		}else if(momoElement2.attachEvent){
		  momoElement2.attachEvent("onchange", action7);

		}

		//fonction standard
		function getXhr(){
			xhr=null;
				if(window.XMLHttpRequest){
					xhr=new XMLHttpRequest();
				}
				else if(window.ActiveXObject){
					try {
			                xhr = new ActiveXObject("Msxml2.XMLHTTP");
			            } catch (e) {
			                xhr = new ActiveXObject("Microsoft.XMLHTTP");
			            }
				}
				else{
					alert("votre navigateur ne suporte pas les objets XMLHttpRequest");
				}
				return xhr;
			}
    </script>
</html>