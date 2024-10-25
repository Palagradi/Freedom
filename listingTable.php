<?php
		if(!empty($_GET['trie'])){
			$req="(SELECT tableencours.numTable AS numTable,RTables.NbreCV AS NbreCV,tableencours.updated_at AS updated_at,RTables.status,RTables.id,RealNameTable FROM tableencours,RTables WHERE RTables.nomTable=tableencours.numTable AND created_at='".$Jour_actuel."' AND Etat <> 'Desactive' AND NbreCV<>0 AND RTables.status=0 ORDER BY updated_at DESC)
			UNION 
			(SELECT * FROM RTables WHERE nomTable NOT IN (SELECT numTable FROM tableencours,RTables WHERE RTables.nomTable=tableencours.numTable AND created_at='".$Jour_actuel."' AND Etat <> 'Desactive' AND NbreCV<>0 AND RTables.status=1)
			AND nomTable NOT IN (SELECT nomTable FROM RTables WHERE RTables.status=1)
			)"; 
			$reqsel=mysqli_query($con,$req); $j=0; $array = array(); 
			while($data=mysqli_fetch_array($reqsel))
				{
				  $NbreCV=$data['NbreCV']; $Heure=$data['updated_at']; 	$j++; $status=$data['status'];
				  $i=$data['numTable']; if($i<10) $ii="0".$i; else $ii=$i;$array[$j]=$i; 			
				  $checkFormaHour = explode(":",$Heure); 
				  $reqsel0=mysqli_query($con,"SELECT serveur.id AS serveurId,nomserv,prenoms FROM RTables,serveur WHERE serveur.id=RTables.serveur AND nomTable='".$i."' AND RTables.status=0");
				  $data0=mysqli_fetch_object($reqsel0);
				  $query=mysqli_query($con,"SELECT serveur.id AS serveurId,nomserv,prenoms FROM tableenCours,serveur WHERE serveur.id=tableenCours.serveur AND  numTable='".$i."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'"); $data1=mysqli_fetch_object($query);
				  $serveur=!empty($data1->nomserv)?$data1->nomserv." ".$data1->prenoms:"";
				  if(empty($data1->nomserv)) {
					$reqx="SELECT * FROM RTables,serveur WHERE RTables.status=0 AND serveur.id=RTables.serveur AND nomTable='".$i."' ORDER BY nomTable DESC";
					$reqselx=mysqli_query($con,$reqx);
					$datax=mysqli_fetch_object($reqselx);
					$serveur=!empty($datax->nomserv)?($datax->nomserv." ".$datax->prenoms):""; 
					}
					
					$reqxT="SELECT RealNameTable FROM RTables WHERE RTables.nomTable=".$i." AND NbreCV<>0 AND status=0";
					$reqselxT=mysqli_query($con,$reqxT);$dataxT=mysqli_fetch_object($reqselxT);
				
				  if(!empty($serveur)) $user="user0"; else $user="user";			  
					if(($j==1)||(($j!=0)&&($array[$j-1]!=$i))){				
					echo " <table  WIDTH='' style=' border-spacing: 5px 5px;border:3px solid white;"; if($j%5!=0) echo "float:left;";  echo "' class=''>
					<tr>
						<td style='padding: 10px;padding-bottom: 10px;'><a href='' class='info2' id='test'>";
							if(count($checkFormaHour)!=3) $Heure="&nbsp;"; 
							//echo "<span style='color:white;display:block;float:top;margin-left:20px;'>".$Heure."</span>"; //else echo "<span style='color:blue;display:block;float:top;margin-bottom:-25px;'>&nbsp;</span>";
							echo "<input type='submit'"; echo "class='bouton5' id='full' ";   echo "name='table' value='"; if(!empty($dataxT->RealNameTable)) echo $dataxT->RealNameTable; else echo $ii; echo "' onclick='redirect();' style='width:90px;height:45px;font-size:1.2em;";
							if(count($checkFormaHour)==3) { echo "background: #7E45D8;"; $current=1;} else $current=0;
							echo "'/><span style='color:blue;display:block;position:relative;margin-top:-20px;background: white;z-index:1;width:25px;height:12px;border:0px solid white;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;display:block;top:0px;font-size:0.6em;font-weight:bold;color:maroon;text-align:center;'> &nbsp;"; echo $NbreCV." CV&nbsp;"; echo"</span>
							</a>&nbsp;";
							echo "&nbsp;<span style='color:maroon;position:sticky;z-index:1;'>".$Heure."</span>";
							//echo "<a href='servir.php?menuParent=".$_SESSION['menuParenT']."&serv=1&tab=".$ii; ?>
							 <a class='info2' href='#' 
							 <?php if(empty($serveur)) {?>
							 onclick='findServ(<?php echo $ii; echo ",1"; echo ",".$current;?>);return false;' 
							 <?php } else { ?>
							 onclick='delServ(<?php echo $ii;?>);return false;' 
							<?php } ?>
							 style='font-size:0.9em;font-style:normal;color:teal;'
							<?php 
							//if(!empty($data0->serveur)) echo "&p=1"; if(!empty($serveur)) echo "&serv=1"; else echo "&serv=0";							
							echo "' class='info2' id='test'><span style='float:right;color:blue;display:block;position:relative;margin-top:-10px;background: white;z-index:1;width:20px;height:20px;border:0px solid white;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;display:block;top:0px;font-size:0.8em;color:maroon;";
							if(!empty($data0->nomserv)) echo "border-bottom:20px solid yellow;";
							echo "'>"; 
							echo "<img src='logo/Resto/".$user.".png' alt='' width='20' height='20' border='1'>"; if(!empty($serveur)) { $serveur ="<center>".$serveur."</center>"; //echo "<g style='color:gray;'>Retirer le mode permanent</g>"; 
							echo  "<center style=''><i class='fas fa-minus'></i></center>";
							}
							if(!empty($serveur)) echo "<span style='color:#B83A1B;font-size:1.2em;'>".$serveur; 
							else echo "<span style='color:gray;font-size:1.1em;'>Affecter un(e) serveur(se) <br/>de façon permanente à la table ";
							echo "</span>"; echo"</span>
							</a>
						</td>
						<td><span style='display:block;'>
						<a href='receipt.php' onclick='edition3();return false;' class='info'><span style='font-size:0.9em;color:maroon;font-weight:bold;'>Modifier</span> </a>
						</a></span></td>
					</tr></table>";
					}	else $j--;				
			if($i==$Nbre) $printf=1;		
			}			
		}else { 
		$reqTable=mysqli_query($con,"SELECT * FROM RTables WHERE NbreCV<>0"); $j=0;
		while($dataT=mysqli_fetch_object($reqTable)){	$j++;		
		$i=$dataT->nomTable ;
		//for($i=1;$i<=$Nbre;$i++){
		 if($i<10) $ii="0".$i; else $ii=$i;
		    $req="SELECT * FROM RTables WHERE nomTable='".$i."' ORDER BY nomTable DESC";
			$reqsel=mysqli_query($con,$req);
			$data=mysqli_fetch_assoc($reqsel);$NbreCV=$data['NbreCV'];$status=$data['status'];
			$query=mysqli_query($con,"SELECT nomserv,prenoms FROM tableenCours,serveur WHERE serveur.id=tableenCours.serveur AND  numTable='".$i."' AND created_at='".$Jour_actuel."' AND Etat<> 'Desactive'"); 
			$data1=mysqli_fetch_object($query);
			$serveur=!empty($data1->nomserv)?($data1->nomserv." ".$data1->prenoms):$data['serveur']; 
			if(empty($data1->nomserv)) {
			$reqx="SELECT * FROM RTables,serveur WHERE serveur.id=RTables.serveur AND nomTable='".$i."' ORDER BY nomTable DESC";
			$reqselx=mysqli_query($con,$reqx);
			$datax=mysqli_fetch_object($reqselx);
			$serveur=!empty($datax->nomserv)?($datax->nomserv." ".$datax->prenoms):$data['serveur']; 
			}
			echo "
			<table  WIDTH='' style='border-spacing: 5px 5px;border:3px solid white;"; if($j%5!=0) echo "float:left;";  echo "' class=''>
				<tr>
					<td style='padding: 10px;padding-bottom: 10px;'><a href='' class='info2' id='test'>";  if(!empty($serveur)) $user="user0"; else $user="user"; //if(!empty($serv)) echo "<span style='color:white;display:block;float:top;margin-left:20px;'>".$serveur."</span>"; //else echo "<span style='color:blue;display:block;float:top;margin-bottom:-25px;'>&nbsp;</span>";
						echo "<input type='submit'";  echo "class='bouton5' id='full' ";   echo "name='table' value='"; if(!empty($dataT->RealNameTable)) echo $dataT->RealNameTable; else echo $ii; echo "' onclick='redirect();' style='width:90px;height:45px;font-size:1.2em;";
						if($table==$i) echo "border:2px solid red;";	
							$req="SELECT DISTINCT numTable FROM tableEnCours WHERE numTable='".$i."' AND created_at='".$Jour_actuel."' AND Etat <> 'Desactive'";
							$reqsel2=mysqli_query($con,$req);
							$data1=mysqli_fetch_assoc($reqsel2);
									if($data1['numTable']==$i) {echo "background: #7E45D8;";$current=1;} else { echo "background: #00734F;";$current=0; }
									if($status==1) echo "background: gray;";
						echo "'/><span style='color:blue;display:block;position:relative;margin-top:-20px;background: white;z-index:1;width:25px;height:12px;border:0px solid white;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;display:block;top:0px;font-size:0.6em;font-weight:bold;color:maroon;text-align:center;'> &nbsp;"; echo $NbreCV." CV&nbsp;"; echo"</span>
						</a>&nbsp;";?>		
						
						<a class='info2' href='#' 						
						 <?php if(empty($serveur)) {?>
						 onclick='findServ(<?php echo $ii; echo ",1"; echo ",".$current;?>);return false;' 
						 <?php } else { ?>
						 onclick='delServ(<?php echo $ii;?>);return false;' 
						<?php } ?>
						
						style='font-size:0.9em;font-style:normal;color:teal;'
						<?php
						
						//if(!empty($data['serveur'])) echo "&p=1"; if(!empty($serveur)) echo "&serv=1"; else echo "&serv=0";
							
						echo "' class='info2' id='test'><span style='float:right;color:blue;display:block;position:relative;margin-top:-10px;background: white;z-index:1;width:20px;height:20px;border:0px solid white;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;display:block;top:0px;font-size:0.8em;color:maroon;";
						if(!empty($data['serveur'])) echo "border-bottom:20px solid yellow;";
						echo "'>"; 
						echo "<img src='logo/Resto/".$user.".png' alt='' width='20' height='20' border='1'>";
						if(!empty($serveur)) { $serveur ="<center>".$serveur."</center>"; //echo "<g style='color:gray;'>Retirer le mode permanent</g>"; 
						echo  "<center style=''><i class='fas fa-minus'></i></center>";
						}
						if(!empty($serveur)) echo "<span style='color:#B83A1B;font-size:1.2em;'>".$serveur; 
						else echo "<span style='color:gray;font-size:1.1em;'>Affecter un(e) serveur(se) <br/>de façon permanente à la table ";
						echo "</span>"; echo"</span>
						</a>
					</td>
					<td><span style='display:block;'>
					<a href='receipt.php' onclick='edition3();return false;' class='info'><span style='font-size:0.9em;color:maroon;font-weight:bold;'>Modifier</span> </a>
					</a></span></td>
				</tr>
			</table>"; if($i==$Nbre) $printf=1;
		}
					
		}
			
		