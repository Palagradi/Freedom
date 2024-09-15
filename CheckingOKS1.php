<?php
			$post_S="location.etatsortie='NON' AND location.Periode='".$_SESSION['PeriodeS']."'";
			
			if(isset($_SESSION['groupe1']))
				$query="SELECT DATEDIFF('".$Jour_actuel."',datarriv) AS DiffDate,N_reel,datarriv,somme,compte1.numfiche AS numfiche,compte1.np as NuiteP, compte1.somme AS SommeP,compte1.ttc_fixe,compte1.ttc_fixeR,location.numfichegrpe,compte1.date AS date,compte1.due AS due,nomcli, prenomcli,client.numcli AS numcli,numcliS FROM client, location, salle, compte1
			WHERE (location.numcli = client.numcli OR location.numcli = client.numcliS)
			AND location.codegrpe = '".$_SESSION['groupe1']."'
			AND salle.numsalle = compte1.numsalle
			AND compte1.numfiche = location.numfiche
			AND ".$post_S;
			else
				$query="SELECT DATEDIFF('".$Jour_actuel."',datarriv) AS DiffDate,N_reel,datarriv,somme,compte1.numfiche AS numfiche,compte1.np as NuiteP, compte1.somme AS SommeP,compte1.ttc_fixe,compte1.ttc_fixeR,location.numfichegrpe,compte1.date AS date,compte1.due AS due,nomcli, prenomcli,client.numcli AS numcli,numcliS FROM client, location, salle, compte1
			WHERE (location.numcli = client.numcli OR location.numcli = client.numcliS)
			AND location.numfiche = '".$_SESSION['num']."'
			AND salle.numsalle = compte1.numsalle
			AND compte1.numfiche = location.numfiche
			AND ".$post_S;

			$sql3=mysqli_query($con,$query);
			if (!$sql3) {
				printf("Error: %s\n", mysqli_error($con));
				exit();
			}			
			$iS=0; $nombreS=array("");$soustraire=0;$sommeArrhesS=0;	 $ListcompteS=array(); $kS=0; $Tttc_fixeS=0;
			while($row_1S=mysqli_fetch_array($sql3))
			{  $nombreS= $row_1S['numfiche'];
				$ListcompteS[$kS]=$nombreS;
			  if($row_1S['ttc_fixeR']>0) $nombre2= $row_1S['ttc_fixeR']; else $nombre2= $row_1S['ttc_fixe'];
				$kS++;
				$numfichegrpe= $row_1S['numfichegrpe'];

				$nuiteS= round((strtotime($Jour_actuel)-strtotime($row_1S['datarriv']))/86400);
				$dat=(date('H')+1);
				settype($dat,"integer");
				
				$nuiteS=($row_1S['DiffDate']>0)?$row_1S['DiffDate']:1;
				
				$numcli=!empty($row_1S['numcliS'])?$row_1S['numcliS']:$row_1S['numcli'];
				$client=strtoupper($row_1S['prenomcli'])." ".strtoupper($row_1S['prenomcli']);
				
				if(isset($_SESSION['groupe1'])) $client=$_SESSION['groupe1'];


			if(isset($numfichegrpe)&&(!empty($numfichegrpe))&&(isset($_SESSION['impaye']))&&($_SESSION['impaye']==1))
			{ //echo 	$nuiteS;
				//Facture de groupe délicat lorsque les clients ne sont pas arrivés un même jour
				//Partie à revoir avec attention
			}else if(isset($numfichegrpe)&&(!empty($numfichegrpe)))	{

			}else {
				//$nuiteS=$np_1S;
				//$nuiteS+=$_SESSION['NuitePayee'];
			}
			 $SommePayeeS=$nuiteS*$nombre2;

			 if(!isset($_SESSION['impaye']))
			  $Tttc_fixeS +=$SommePayeeS; else $Tttc_fixeS +=$row_1S['due'];

			if(!isset($_SESSION['fiche'])){
				if(($iS==0)&&(isset($_SESSION['sommeArrhesS']))){
				 if(!isset($_SESSION['remise']))
				 $SommePayeeS=$SommePayeeS+$_SESSION['sommeArrhesS'];
				 //$SommePayee2=$SommePayeeS;
			 }
				$due= abs($SommePayeeS-$row_1S['due'])  ;
			 	if(isset($_SESSION['groupe1'])&&(!empty($_SESSION['groupe1']))&&(isset($_SESSION['impaye']))&&($_SESSION['impaye']==1)) {  //Traitement des impayés pour un groupe
				$SommePayeeS=$row_1S['somme']+$row_1S['due'];  $Tttc_fixeS=$SommePayeeS;
				if($row_1S['ttc_fixeR']>0) $nuiteS =$row_1S['due']/$row_1S['ttc_fixeR'];
				else	 $nuiteS =$row_1S['due']/$row_1S['ttc_fixe'];
				$due=0; //echo "<br/>".$nuiteS= $row_1S['N_reel'];
			 }
			 			 
						$exec=mysqli_query($con,"SELECT DATEDIFF('".gmdate('Y-m-d')."','".$row_1S['datarriv']."') AS DiffDate");
						$row_Recordset1 = mysqli_fetch_assoc($exec);
						$n=$row_Recordset1['DiffDate'];
	
						$N_reel=$n-$row_1S['NuiteP']; if ($n!=0) $N_reel--;	//echo $N_reel;
						if(($_SESSION['Mtotal']!=$_SESSION['avanceA'])&&($_SESSION['avanceA']!=0)) { 
						$N_reel=$_SESSION['Nd']; $_SESSION['Mtotal']=$_SESSION['avanceA']; $nuiteS=$_SESSION['Nd'];
						$NuiteP=$_SESSION['Nd']; $N_reel--; $NuiteP--;
						
						 if($row_1S['ttc_fixeR']>0) $nombre2= $row_1S['ttc_fixeR']; else $nombre2= $row_1S['ttc_fixe'];
						 $SommePayeeS=$N_reel*$nombre2;
						 
						}
						if($_SESSION['EtatF']!='V') $_SESSION['avanceA']=0;
				 			{
								if(!empty($row_1S['date'])){
										$ans=substr($row_1S['date'],6,4);
										$mois=substr($row_1S['date'],3,2);
										$jour=substr($row_1S['date'],0,2);
										$_SESSION['debut']=substr($row_1S['date'],0,2).'-'.substr($row_1S['date'],3,2).'-'.substr($row_1S['date'],6,4);
										if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1))
											$_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$NuiteP,date($ans)));
										else 
											$_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$N_reel,date($ans)));
								}
								else {  $ans=substr($row_1S['datarriv'],0,4);
										$mois=substr($row_1S['datarriv'],5,2);
										$jour=substr($row_1S['datarriv'],8,2);
										$_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$N_reel,date($ans)));
									}
							}
							
							

				//if((!isset($_SESSION['updateBD']))||(isset($_SESSION['retro'])&& ($_SESSION['retro']==1)&&(isset($_SESSION['updateBD']))&&($_SESSION['updateBD']==1)))
				if(isset($_SESSION['retro'])&& ($_SESSION['retro']==1)||(isset($_SESSION['updateBD']))&&($_SESSION['updateBD']==1))
				 	{ if(($_SESSION['NormSencaisser']==1)&&(isset($_SESSION['impaye'])))
						  $update =NULL;
					  else 
						 $update = " somme='".$SommePayeeS."', ";
				
					} else {$update=NULL; }
				 $TauxR=(isset($_SESSION['pourcent'])&&($_SESSION['pourcent']>0))?$_SESSION['pourcent']:0;
				 $pos="SET ".$update."np='".$nuiteS."',N_reel='".$nuiteS."',TauxR='".$TauxR."' ";
				 if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1))  {
					 if($_SESSION['NormSencaisser']==0)  $pos.=",due='".$due."' ";
				 }
				 //$pos.=",due=abs($SommePayeeS-due) "; //Pour le cas de la régularisation d'une facture impayee
				 $pos.=" WHERE numfiche='".$nombreS."'";
					 //echo "<br/>".
				  $req1="UPDATE compte1 ".$pos;	 
				  if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $req_=mysqli_query($con,$req1);
			}
		}
		
?>				