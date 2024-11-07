	<?php
	//include 'phpqrcode/qrlib.php';
/* 	if (isset($_POST['client']))
			{echo 12; echo $_POST['clientP'];
			}	 */
			// QRcode::png('PHP QR Code :)');

			if (isset($_POST['Valider']))
			{ 	if((!empty($table))||(!empty($vt)) ||(!empty($tk))) {
				 $tva=!empty($tva)?$tva:0; $type="1";
				 if (isset($_GET['clt'])) echo $_GET['clt'];
				$remise= (int)$_POST['remise']; $Mtpercu= (int)$_POST['Mtpercu'];    $total=(int)$_POST['m'];  //$total+=$remise;
				 if(($Mtpercu<=0)&&($total>0)){
					  echo "<script language='javascript'>";
					  echo 'alertify.error(" Renseignez le montant reçu");';
					  echo "</script>";					  
					  
				 }
				 else if($_POST['m']==0){
					  echo "<script language='javascript'>";
					  echo 'alertify.error("Aucune ligne à valider");';
					  echo "</script>";
				 }
				 else if($Mtpercu<$total) { 
					  echo "<script language='javascript'>";
					  echo 'alertify.error(" Montant renseigné non valide");';
					  echo "</script>";
				 }
				 else{
					 	$update=mysqli_query($con,"UPDATE ConfigResto SET num_fact=num_fact+1 ");
						$reqsel=mysqli_query($con,"SELECT num_fact,numFactNorm FROM ConfigResto");
						$data=mysqli_fetch_assoc($reqsel);
						$numFact=convertNumero(1,$data['num_fact']); $NomClient=isset($_GET['client'])?$_GET['client']:NULL;						
						$numFactNorm=NumeroFacture($data['numFactNorm']);

					 //if(isset($tk)&&($tk==1)) $table=0; 
					 
					  $productlist=array();
					  

					  $sql = "SELECT nomTable FROM RTables WHERE RealNameTable='".$table."'";
					  $reqselRTablesX=mysqli_query($con,$sql);
					  if(mysqli_num_rows($reqselRTablesX)>0){
						  $data1X=mysqli_fetch_object($reqselRTablesX);
						  $table=$data1X->nomTable;	
					  }else 
						  $table=(int)($table);
					 
					  $Query="INSERT INTO factureResto SET id=NULL,numFactNorm='".$numFactNorm."',numTable = '".$table."',date_emission = '".$Jour_actuelp."', heure_emission = '".$Heure_actuelle."',login='".$_SESSION["login"]."',seller = '".$_SESSION["nom"]." ".$_SESSION["prenom"]."', num_facture = '".$numFact."',
					  Type = '".$type."', tva = '".$tva."', montant_ttc = '".$_POST['m']."', Remise = '".$remise."', somme_paye = '".$Mtpercu."',NbreCV='".$cv."'";
					 $exec=mysqli_query($con,$Query);
					 if(isset($exec)){
						 echo "<script language='javascript'>";
						 echo 'alertify.success(" La commande a été validée !");';
						 echo "</script>";
							  
						   $sql = "SELECT * FROM tableEnCours WHERE numTable='".$table."' AND created_at='".$Jour_actuel."' AND Etat <> 'Desactive' ORDER BY Num ASC";
						  $reqselRTables=mysqli_query($con,$sql);
						  while($data1=mysqli_fetch_array($reqselRTables)){

								$reqA=mysqli_query($con,"SELECT * FROM boisson WHERE numero='".$data1['Num2']."' AND Depot='2'");
								$data2=mysqli_fetch_assoc($reqA);$Qte_initial= !empty($data2['Qte_Stock'])?$data2['Qte_Stock']:0;

								$update="UPDATE boisson SET StockReel=StockReel-'".$data1['qte']."' WHERE numero='".$data1['Num2']."' AND designation = '".$data1['LigneCde']."' AND Depot='2'";
								$Query=mysqli_query($con,$update);

								$ref="BAR".$data1['Num2'] ; $quantiteF=abs($Qte_initial-$data1['qte']);$service="Client";
							    $re="INSERT INTO operation VALUES(NULL,'".$ref."','Restauration','".$data1['Num2']."','".$Qte_initial."','".$data1['qte']."','".$quantiteF."','".$Jour_actuel."','".$Heure_actuelle."','".$service."','".$data1['qte']."')";
								$req=mysqli_query($con,$re);

								$LigneCde=strtoupper($data1['LigneCde']);
								if(!empty($TPS_2)&&($TPS_2==1)) {
								$LigneCde.=" E "; 	$TypeTxe="E";  //L'entreprise est inscrite au régime TPS
								}
								else if($data1['TVA']==0) { //Ici les factures normalisees sont exonerees
									$LigneCde.="  (A-EX)";  $TypeTxe="A";
								}
								else {  //les factures normalisees seront taxables par defaut
									$LigneCde.=" B "; $TypeTxe="B";
								}

								$List=array(
								 "DESIGNPROD" => strtoupper($LigneCde),
								 "LTAXE" => $TypeTxe,
								 "PRIXUNITTTC" => $data1['prix'] ,
								 "MTTAXESPE" => "" ,
								 "QUANTITE" => $data1['qte'],
								 "DESCTAXESPE" => "",
								 );
								 array_push($productlist,$List);
								 //echo "<br/>".var_dump($List);
						  }
						    $Query="UPDATE tableEnCours SET Etat='Desactive',num_facture = '".trim($numFact)."' WHERE numTable = '".$table."' AND Etat = '' AND created_at='".$Jour_actuel."'";
							$exec=mysqli_query($con,$Query); $_SESSION['numFact'] = trim($numFact);

							include 'others/GenerateMecefBill.php';

							 $userId=$_SESSION['userId'];
							 $userName=$NomClient;
							 $customerIFU=null; $customerName=$NomClient; $Aib_duclient="";
							 $_SESSION['Date_actuel']=isset($_SESSION['date_emission'])?$_SESSION['date_emission']:$Jour_actuelp;
							 $totalAmount=$_POST['m']; $totalpayee = $Mtpercu;
							 $jsonData = formatData($userId,$userName,$customerIFU,$customerName,$Aib_duclient,$productlist,$totalAmount,$totalpayee);
						 	 push($jsonData);
						 }
						 // echo '<meta http-equiv="refresh" content="0; url=servir.php?menuParent='.$_SESSION['menuParenT'].'&tk='.$tk.'" />';		
							$menuParent = $_SESSION['menuParenT'];	$tk = "";
							ob_end_clean(); // Terminer et vider tout tampon de sortie
							header("Location: servir.php?menuParent=$menuParent&tk=$tk");
							exit;						 
					}
					
				 }
			}
			if (isset($_POST['Supprimer']))
			{	if( !empty($_POST['choix'])){
					$choix ='';
					for ($i=0;$i<count($_POST['choix']);$i++)
					{	//on concatène
						 $choix .= $_POST['choix'][$i].'|';
						 $explore = explode('|',$choix);
						if($explore[$i]!='')
							{   //echo $explore[$i]; echo "<br/>".$i;
								$reqsel=mysqli_query($con,"SELECT numTable,Num2,qte,LigneCde FROM tableEnCours WHERE Num='".$explore[$i]."' AND created_at='".$Jour_actuel."'");
								$data=mysqli_fetch_assoc($reqsel);  $numTable1=$data['numTable']; $Num=$data['Num2']; $qte=$data['qte']; $LigneCde=addslashes($data['LigneCde']);

								$sql="DELETE FROM tableEnCours WHERE Num='".$explore[$i]."'";
								$reqsel=mysqli_query($con,$sql);

								$reqsel=mysqli_query($con,"DELETE FROM operation WHERE reference1='".$Num."'");

								$check=mysqli_query($con,"SELECT * FROM boisson WHERE numero='".$Num."' AND Depot = '2' AND pc=0");
								if(mysqli_num_rows($check)>0){
										$update="UPDATE boisson SET QteStock=QteStock+$qte,StockReel=StockReel+$qte WHERE numero='".$Num."' AND Depot = '2' AND pc=0 AND designation='".$LigneCde."'";
								}else {
								$check=mysqli_query($con,"SELECT * FROM boisson WHERE numero='".$Num."' AND Depot = '2' AND pc<>0 AND designation='".$LigneCde."'"); //Pack
									if(mysqli_num_rows($check)>0){
										$update="UPDATE boisson SET QteStock=QteStock+$qte,StockReel=StockReel+$qte WHERE numero='".$Num."' AND Depot = '2' AND pc<>0";
									}else{
										$check=mysqli_query($con,"SELECT * FROM plat WHERE numero='".$Num."' AND (designation='".$LigneCde."' OR designation2='".$LigneCde."')");
										if(mysqli_num_rows($check)>0){
										$update="UPDATE plat SET Nbre=Nbre+$qte WHERE numero='".$Num."' AND (designation='".$LigneCde."' OR designation2='".$LigneCde."')"; //Pour les repas
										}else {
										$update="UPDATE portion SET Nbrep=Nbrep+$qte WHERE numPlat='".$Num."' AND libellePortion='".$LigneCde."'"; //Pour les portions
										}
									}											
								}	
								$reqk=mysqli_query($con,$update);
								
/* 								 echo "<script language='javascript'>";
								 echo 'alertify.success(" Suppression effectuée !");';
								 echo 'self.location=self.location ';
								 echo "</script>"; */						 
							}
					}

				}
					$menuParent = $_SESSION['menuParenT'];$_SESSION['delete']=1;
					ob_end_clean(); // Terminer et vider tout tampon de sortie
					header("Location: servir.php?menuParent=$menuParent&table=$table&tk=$tk&delete=ok");
					exit;	
			}		
				 
?>			<table class='rouge1' style='width:500px;border:3px solid maroon;background-color:#F4FEFE;font-family:Calibri;font-size:1em;'>
				<tr>
					<td  colspan='1' style='font-weight:bold;font-size:1.1em;color:#FF0000;font-style:italic;font-family: Georgia;'> 
					<?php if(!empty($table)) { $_SESSION['tableS']=$table ;echo  "Table : " .$table." / ".$cv." CV" ; }if(empty($table)) echo "Commande en cours ...";
					
					$table0=(int)($table);	
					$Query="SELECT id FROM RTables WHERE RealNameTable='".$table."'";
					$exec=mysqli_query($con,$Query);
					 $data=mysqli_fetch_object($exec);
					if(mysqli_num_rows($exec)>0){
					$table0=(int)($data->id);	
					}
		
					$reqx="SELECT nomserv,prenoms FROM RTables,serveur WHERE serveur.id=RTables.serveur AND nomTable='".$table0."'";
					$reqselx=mysqli_query($con,$reqx);
					$datax=mysqli_fetch_object($reqselx);
					$serveur=!empty($datax->nomserv)?($datax->nomserv." ".$datax->prenoms):NULL; 
	/* 				if(mysqli_num_rows($exec)>0){
						
					} */
					?>
					</td><td colspan='2' align='center'><?php echo "<span style='color:gray;font-weight:normal;font-style:normal;font-size:0.8em;'>".$Date_actuel2." | ".$Heureactuelle;?></td>
					<td colspan='1' align='right'>
					
					<?php 
					echo "<a class='info2' href='#' ";
					//if(isset($tk)&&($tk==1)&&($table==0)){} 
					//else 
					echo "onclick='findServ(".$table0.",0,1,\"".addslashes($table)."\"); return false;' ";
					echo "style='font-size:0.9em;font-style:normal;color:teal;' id='test'>";
					?>					
					<span style='font-size:1em;font-style:normal;color:teal;'>
					<?php  						
					$query=mysqli_query($con,"SELECT nomserv,prenoms FROM tableenCours,serveur WHERE serveur.id=tableenCours.serveur AND  numTable='".$table0."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'"); 
					$data=mysqli_fetch_assoc($query); 
					if(!empty($data['nomserv'])) { 
						echo "Serveur(se) <span style='color:red;'>";
						echo $data['nomserv']." ".$data['prenoms']; 
						echo "</span>";
					}else if(!empty($serveur)) { 
						echo "Serveur(se) permanent(e)<span style='color:red;'>";
						echo $serveur; 
						echo "</span>";
					}
					else  if(isset($tk)&&($tk==1)&&($table==0)){
						echo "Vendeur(se) <span style='color:red;'>";
						echo $_SESSION["nom"]." ".$_SESSION["prenom"];
						echo "</span>"; 
					}
					else echo "Affecter un(e) serveur(se)"; 
					//}
					?>&nbsp;</span>
					<i class='fas fa-plus-square' aria-hidden='true' style='font-size:140%;color:teal;'></i>
					</a>
					&nbsp;&nbsp;
					 <input type='hidden' name='NameTable' id='NameTable' value='<?php echo $table; ?>'/> <input type='hidden' name='cv' id='cv' value='<?php echo $cv; ?>'/>
					 <input type='hidden' name='tk' id='tk' value='<?php echo $tk; ?>'/>
					<a class='info2' href='#' style='' onclick='CheckClient();return false;'>
					<span style='font-size:0.9em;font-style:normal;color:black;'>
					<?php 
					if(isset($_GET['table'])&&($table==$_GET['table']) && isset($_GET['client'])) {
					$client = explode("(",$_GET['client']); echo "Client<span style='color:red;'>".$client[0]."</span>";			
					}else if(mysqli_num_rows($reqselRTables)>0)
					{   //echo $table0=(int)($table);
						$Query="SELECT clientresto.entrepriseName,nomclt,prenomclt FROM tableEnCours,clientresto WHERE clientresto.id=tableEnCours.client AND numTable='".$table0."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'";
						$exec=mysqli_query($con,$Query);
						 $data=mysqli_fetch_object($exec);
						if(mysqli_num_rows($exec)>0){	echo "Client<span style='color:red;'>";					 
						echo !empty($data->entrepriseName)?$data->entrepriseName:$data->nomclt." ".$data->prenomclt; echo "</span>";
						}else echo "Nom du client";
					}
					else
						echo "Nom du client";
					?></span>
					<i class='fas fa-plus-square' aria-hidden='true' style='font-size:140%;color:#FEBE89;'></i>
					</a>
					&nbsp;&nbsp;
					<a class='info2' href='#' style='' onclick='JSalert2();return false;'>
					<span style='font-size:0.9em;font-style:normal;color:black;'>
					<?php
					if(isset($_GET['table'])&&($table==$_GET['table']) 
						&&(isset($mode)&&(!empty($mode))&&(!is_null($mode))&&($mode!='null'))
					) {		
						echo "Mode de règlement <span style='color:red;'>"; echo modePayement($_GET['mode']); echo "</span>";
					}else if(mysqli_num_rows($reqselRTables)>0){ 
						//$table0=(int)($table);
						$Query="SELECT modeReglement FROM tableEnCours WHERE numTable='".$table0."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'";
						$exec=mysqli_query($con,$Query);
						 $data=mysqli_fetch_object($exec);
						if(mysqli_num_rows($exec)>0){					 
						$modeReglement=($data->modeReglement>0)?$data->modeReglement:1;	
											
						}else {
/* 							$Query="SELECT modeReglement FROM tableEnCours,RTables WHERE RTables.id=tableEnCours.numTable AND RealNameTable='".$table."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'";
		 					$exec=mysqli_query($con,$Query);
							 $data=mysqli_fetch_object($exec);
							if(mysqli_num_rows($exec)>0){					 
							$modeReglement=($data->modeReglement>0)?$data->modeReglement:1;								
							}  */
						}
							$data=mysqli_fetch_object($exec);
							echo "Mode de règlement <span style='color:red;'>"; echo modePayement($modeReglement); echo "</span>";						
					}else {
						echo "Mode de règlement<span style='color:red;'> Espèce </span>";	
					}
					?></span>	 <i class='fas fa-plus-square' aria-hidden='true' style='font-size:140%;color:red;'></i></a>
					&nbsp;</td>
				</tr>
				<tr style='background-color:#DCDCDC;font-weight:bold;'>
					<td style='padding-left:5px;'> Désignation</td>
					<td  align='right'>Prix Unit.</td>
					<td  align='center'>Qté</td>
					<td  style='padding-right:5px;' align='right'>Montant</td>
				</tr>
				<?php if(isset($reqselRTables)){ 
				$total=0;
				echo "<form action='servir.php?menuParent=".$menuParenT."&val=1&table=".$table."&cv=".$cv."&tk=".$tk."'' method='post'>";
				echo "<input type='hidden' name='' id='Nomclt' value=''/>";
				echo "<input type='hidden' name='' id='Quantify' value=''/>";
				$Nbre=0;
				while($data1=mysqli_fetch_array($reqselRTables)){
					$mt=$data1['qte']*$data1['prix'];$total+=$mt;$Nbre++;
					echo "<tr style='background-color:#C3D9E0;'>
							<td style='padding-left:5px;border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>";   if(isset($del)) echo "<input type='checkbox' name='choix[]' value='".$data1['Num']."'> ";
							   echo "<span>".ucfirst($data1['LigneCde'])." ".$data1['QteInd']."</span>";							   
							    $sqlP = "SELECT * FROM portion WHERE libellePortion='".$data1['LigneCde']."'";$reqselP=mysqli_query($con,$sqlP);
								if(mysqli_num_rows($reqselP)>0)			  
							   echo "<span style='float:right;font-size:0.9em;'>P</span>";
							echo "</td>
							<td  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;padding-right:10px;' align='right'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$data1['prix']."</td>
							<td  style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' align='center'>".$data1['qte'];
						//echo "<input type='number' name='' min='1' value='1' style='width:50px;background-color:#C3D9E0;text-align:center;'>";
							echo "</td>
							<td  style='padding-right:5px;border-right: 2px solid #ffffff; border-top: 2px solid #ffffff' align='right'>".$mt."</td>
						</tr>";
				}
				}$total=!empty($total)? $total:0;
				echo " 
				<tr><td>&nbsp;</td>	</tr>
				<tr>
					<td style='color:#798081;font-size:1em;'>Nbre produits : ".$Nbre."	</td>		
					<td  colspan='2' align='right' style='color:#798081;font-size:1.1em;'>Total :		</td>
					<td  align='right'> <a class='info' href='#' style='color:#798081;font-size:1em;padding-right:5px;'>".$total."</td>
					<input type='hidden' id='total' value='".$total."' />
				</tr>
				<tr>
					<td  align='left' style='font-size:1.1em;font-weight:bold;color:#A0522D;'><br>Remise accordée : </td>
					<td  align='left'><br><input type='text' name='remise' id='remise' style='width:100px;background-color:#D3D3D3;' onkeyup='remiseR();' onchange='remiseR();' onkeypress='testChiffres(event);' autocomplete='OFF' /></td>

					<td  align='right' style='font-size:1.1em;font-weight:bold;color:#A0522D;'><br>&nbsp;Montant reçu :</td>
					<td  align='right'><br><input type='text' name='Mtpercu' id='Mtpercu' onkeyup='monnaie();' onkeypress='testChiffres(event);' autocomplete='OFF' style='text-align:right;font-weight:bold;width:100px;background-color:#D3D3D3;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'";  echo "/></td>
				</tr>
				<tr>
				<td  align='left' style='font-size:1.1em;font-weight:bold;color:#A0522D;'><br>Net à payer :	</td>
				<td  align='left'> <br> <span id='rem'>".$total."</span></td>
					<td  align='right' style='font-size:1.1em;font-weight:bold;color:#A0522D;'><br>&nbsp;&nbsp;Monnaie :		</td>
					<td  align='right'> <br> <span id='mon'>0	</span>	</td>
				</tr>
				";
				/* else{
						echo "<tr style='background-color:#C3D9E0;'>
							<td colspan='2'> &nbsp;		</td>
							<td colspan='2' align='right'>&nbsp;	 </td>
						</tr>";

						echo "<tr>
					<td  colspan='3' align='right' style=''>Total :		</td>
					<td  align='right'> <a class='info' href='#' style='color:#798081;'>0	</td>
				</tr>

				<tr>
					<td  align='left' style='font-size:1.1em;font-weight:bold;color:#A0522D;'><br>Montant perçu :		</td>
					<td  align='left'><br><input type='text' name='MontantP' autocomplete='off' style='font-weight:bold;width:100px;background-color:#D3D3D3;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'"; echo "/></td>
					<td  align='left' style='font-size:1.1em;font-weight:bold;color:#A0522D;'><br>Remise accordée :		</td>
					<td  align='left'><br><input type='text' name='Remise'  style='font-weight:bold;width:100px;background-color:#D3D3D3;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;'";  if((empty($table))&&(empty($vt))) echo "readonly"; echo "/></td>
				</tr>
				<tr>
					<td  align='right' style='font-size:1.1em;font-weight:bold;color:#A0522D;'><br>&nbsp;&nbsp;Monnaie :		</td>
					<td  align='right'> <br> 0	</td>
					<td  align='right' style='font-size:1.1em;font-weight:bold;color:#A0522D;'><br>&nbsp;&nbsp;Net à payer :		</td>
					<td  align='right'> <br> 0	</td>
				</tr>
				";
				} */
				//<i style='font-size:2em;margin-bottom:-12px;' class='fas fa-cart-plus' aria-hidden='true'></i>
				?>
				<tr>
					<td colspan='4' align='center'>
					 <hr/> <span style='float:left;'>
					 <a class='info' <?php //if((!empty($table))||(!empty($vt)))  
						 echo "onclick='edition5();return false;'";
					 //else  echo "onclick='Alert();return false;'";
					 ?> style='color:orange;' > <span style='font-size:0.9em;font-style:normal;color:maroon;'>Ajouter une boisson </span><img src='logo/Resto/add-to-cart.png' alt='' width='45' height='46' border='0'style='padding-bottom:5px;'>  </a>
					  &nbsp;&nbsp;&nbsp;<a class='info' <?php 
					  //if((!empty($table))||(!empty($vt)))  
						  echo "onclick='edition8();return false;'";
					 // else echo "onclick='Alert();return false;'";
					  ?> style='color:maroon;'><span style='font-size:0.9em;font-style:normal;color:maroon;'>Ajouter un pack ou <br/>casier de boissons</span><img src='logo/Resto/add.png' alt='' width='35' height='40' border='0' >  </a>
					   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					   <a class='info2' <?php 
					  //if((!empty($table))||(!empty($vt)))  
						   echo "onclick='edition4();return false;'";
					   //else echo "onclick='Alert();return false;'";
					   ?> style='color:#FF00FF;' > <span style='font-size:0.9em;font-style:normal;color:maroon;'>Ajouter un plat </span><img src='logo/Resto/add-soup.png' alt='' width='45' height='45' border='0'>	</a>
					  &nbsp;&nbsp;&nbsp;<a class='info2' <?php
					  //if((!empty($table))||(!empty($vt)))  
						  echo "onclick='edition9();return false;'"; 
					  //else echo "onclick='Alert();return false;'";
					  ?> style='color:#6495ed;' > <span style='font-size:0.9em;font-style:normal;color:maroon;'>Ajouter une portion de plat</span><img src='logo/Resto/soup.png' alt='' width='40' height='45' border='0'></a>

					   
					</span>
					<span style='float:right;'>
						<?php
							if(empty($del))
							   {
						    ?> <a class='info2' href='servir.php?<?php echo "menuParent=".$menuParenT."& "; ?> del=1&table=<?php if(!empty($table)) echo $table; if(!empty($tk)) echo "0&tk=".$tk; ?>' style='color:#DC143C;' > <span style='font-size:0.9em;font-style:normal;color:#DC143C;'>Supprimer une ligne de commande</span>	<i style='font-size:2em;' class='fa fa-trash-alt' aria-hidden='true'></i></a>
						<?php
							   }
							else
								{
									?>
									<a class='info2' ><span style='font-size:0.9em;font-style:normal;color:red;'>Supprimer</span><input type='submit' name='Supprimer'  value='&#x274C;' class="buttonT button6"> </a>
						<?php
								}
						?>
						&nbsp;&nbsp;&nbsp;
						<input type='hidden' value='<?php if(isset($total)) echo $total; ?>' name='m' id='m' />
						<a class='info2' ><span style='font-size:0.9em;font-style:normal;color:blue;'>Valider la commande</span><input type='submit' name='Valider'  value='✔' class="button button5"> </a></form>
					</span> </td>
				</tr>
			</table>
			

			
			
