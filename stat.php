<?php
		//session_start();
		//include_once 'menucp2.php';
		include ('menu.php');
		$resT=mysqli_query($con,"SELECT * FROM  hotel"); 
		$reXt=mysqli_fetch_assoc($resT); $nomHotel=$reXt['nomHotel'];
		
		$double=2; //$_SESSION['double']=$double;
	
		
?>

<?php 
		
		$Tmois=array('JANVIER','FEVRIER','MARS','AVRIL','MAI','JUIN','JUILLET','AOUT','SEPTEMBRE','OCTOBRE','NOVEMBRE','DECEMBRE');	
				
		//$update=mysqli_query($con,"DELETE  FROM view_fiche1 WHERE numcli_1=''");
	echo "<div style='float:center;'><span style='font-size:1.3em;color:#444739;'><b>NOM DE L'ETABLISSEMENT.......................................".$nomHotel."............................................MOIS DE........................  </b></span>";
		switch ($_POST['se5'])
		{	/* for($i=0;$i<12;$i++){
				} */	
			case '01': echo '&nbsp;à&nbsp; <b><i>JANVIER&nbsp;</i></b>'; break; 
			case '02': echo '&nbsp;à&nbsp; <b><i>FEVRIER&nbsp;</i></b>  '; break;
			case '03': echo '&nbsp;à&nbsp; <b><i>MARS&nbsp;</i></b>  '; break;
			case '04': echo '&nbsp;à&nbsp; <b><i>AVRIL&nbsp;</i></b>  '; break;
			case '05': echo '&nbsp;à&nbsp; <b><i>MAI&nbsp;</i></b>  '; break;
			case '06': echo '&nbsp;à&nbsp; <b><i>JUIN&nbsp;</i></b>  '; break;
			case '07': echo '&nbsp;à&nbsp; <b><i>JUILLET&nbsp;</i> </b>  '; break;
			case '08': echo '&nbsp;à&nbsp; <b><i>AOUT&nbsp;</i></b>  '; break;
			case '09': echo '&nbsp;à&nbsp; <b><i>SEPTEMBRE&nbsp;</i> </b> '; break;
			case '10': echo '&nbsp;à&nbsp; <b><i>OCTOBRE&nbsp; </i></b> '; break;
			case '11': echo '&nbsp;à&nbsp; <b><i>NOVEMBRE&nbsp;</i></b>  '; break;
			case '12': echo '&nbsp;à&nbsp; <b><i>DECEMBRE&nbsp;</i></b>  '; break;
			default: echo ' '; break;
		}
		echo "<b>".$_POST['se6'].'</b> <br><br></div> ';    
	
	if (isset($_POST['VALIDER'])&& $_POST['VALIDER']=='Valider') 
	{	$_SESSION['se5']=$_POST['se5'];$_SESSION['se6']=$_POST['se6'];$_SESSION['choix']=$_POST['choix']; 
		$debut=$_POST['se3'].'-'.$_POST['se2'].'-'.$_POST['se1'];	
		$fin=$_POST['se6'].'-'.$_POST['se5'].'-'.$_POST['se4'];	
		$_SESSION['debut']=$debut;$_SESSION['fin']=$fin;
		
		//  taxe nuite chambres ventilles simple
		$res=mysqli_query($con,"SELECT sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and encaissement.typeoccup='individuelle' AND Type_encaisse NOT IN ('Reservation salle','Reservation chambre')"); 
		$rers1=mysqli_fetch_array($res);
		// chambres ventilles double
		$res=mysqli_query($con,"SELECT sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and encaissement.typeoccup='double' AND Type_encaisse NOT IN ('Reservation salle','Reservation chambre')"); 
		$rers2=mysqli_fetch_array($res);
		// chambres climatise simple
		$res=mysqli_query($con,"SELECT sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and encaissement.typeoccup='individuelle' AND Type_encaisse NOT IN ('Reservation salle','Reservation chambre')"); 
		$rers3=mysqli_fetch_array($res);
		// chambres climatise double
		$res=mysqli_query($con,"SELECT sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and encaissement.typeoccup='double' AND Type_encaisse NOT IN ('Reservation salle','Reservation chambre')"); 
		$rers4=mysqli_fetch_array($res);
	
	    $var=$rers1['np']+$double*$rers2['np']+$rers3['np']+$double*$rers4['np'];	

		mysqli_query($con,"SET NAMES 'utf8'");
		$ref=mysqli_query($con,"SELECT DISTINCT client.pays AS pays,pays.continent as continent
							FROM fiche1, client, pays
							WHERE datarriv>='".$debut."' and datarriv<='".$fin."' and fiche1.numcli_1=client.numcli  and client.pays=pays.libpays 
						UNION
							SELECT DISTINCT client.pays AS pays,pays.continent as continent
							FROM fiche1, client, pays
							WHERE datarriv>='".$debut."' and datarriv<='".$fin."' and fiche1.numcli_2=client.numcli and fiche1.numcli_1<> fiche1.numcli_2 and client.pays=pays.libpays 
							GROUP BY  pays 
							ORDER BY continent, pays"); $var1=0;
		while ($rerf=mysqli_fetch_array($ref))
		{ $pays=addslashes($rerf['pays']);
				$res=mysqli_query($con,"SELECT sum(np) AS np FROM encaissement,chambre,fiche1,client WHERE fiche1.numfiche=encaissement.ref AND fiche1.numcli_1=client.numcli AND client.pays='$pays' AND chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and encaissement.typeoccup='individuelle' "); 
				$rers1=mysqli_fetch_array($res);
				$res=mysqli_query($con,"SELECT sum(np) AS np FROM encaissement,chambre,fiche1,client WHERE fiche1.numfiche=encaissement.ref AND fiche1.numcli_1=client.numcli AND client.pays='$pays' AND chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and encaissement.typeoccup='double' "); 
				$rers2=mysqli_fetch_array($res);
				$res=mysqli_query($con,"SELECT sum(np) AS np FROM encaissement,chambre,fiche1,client WHERE fiche1.numfiche=encaissement.ref AND fiche1.numcli_1=client.numcli AND client.pays='$pays' AND chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and encaissement.typeoccup='individuelle' "); 
				$rers3=mysqli_fetch_array($res);
				$res=mysqli_query($con,"SELECT sum(np) AS np FROM encaissement,chambre,fiche1,client WHERE fiche1.numfiche=encaissement.ref AND fiche1.numcli_1=client.numcli AND client.pays='$pays' AND chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and encaissement.typeoccup='double' "); 
				$rers4=mysqli_fetch_array($res);
									
				 $var11=$rers1['np']+$double*$rers2['np']+$rers3['np']+$double*$rers4['np'];
					
			$var1+=$var11;
		} $nbre_result=mysqli_num_rows($ref); $incrementer_nuite=0;$supplement_nuite=0;
	     $difference_nuite=$var-$var1;
		  $var."<br/>".$var1;

		echo "<table align='center' border='1' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'> "; 
		echo"<tr bgcolor='#FDF5E6' style='color:teal; font-size:16px; '> ";
			echo"<td rowspan='2' align='center' > PAYS DE PROVENANCE</td> ";
			
			echo"<td rowspan='2' align='center' >CONTINENTS</td> ";
			
			echo"<td align='center' colspan='5' >ARRIVEES</td> ";
			
			echo"<td colspan='2' align='center'  >SEXE </td> ";
			echo"<td rowspan='2' align='center' > Nbre de Nuité </td> ";
			echo"<td colspan='5' align='center' >MOTIF DE LA VISITE </td> ";
			
			echo"<td colspan='3' align='center' >MODE DE TRANSPORT</td> ";
			
			echo"<td colspan='6' align='center' >PROFESSIONS</td> ";
			
			echo"<td colspan='2' align='center' >ETAT CIVIL</td> ";
			
		echo"</tr> "; 
		echo"<tr bgcolor='#FDF5E6' style='color:teal; font-size:16px; '> ";
			
			$Tarrives=array('Enfants','Adolescents','Adultes','3ème Ages','Total');
			for($i=0;$i<5;$i++) echo"<td>".$Tarrives[$i]."</td> ";
			
			echo"<td>M </td> ";
			echo"<td>F </td> ";
			
			$Tmotif=array('Vacances','Affaires','Parents et amis','Professionnel','Autres buts');
			for($i=0;$i<5;$i++) echo"<td>".$Tmotif[$i]."</td> ";
			
			$Tmode=array('Terre','Mer','Air');
			for($i=0;$i<3;$i++) echo"<td>".$Tmode[$i]."</td> ";
			
			$Tprofession=array('Libérale','Ouvrier','Employé','Cadre','Inactif','Divers');
			for($i=0;$i<6;$i++) echo"<td>".$Tprofession[$i]."</td> ";
						
			$TEtatcivil=array('Marié','Célibataire');
			for($i=0;$i<2;$i++) echo"<td>".$TEtatcivil[$i]."</td> ";
			
		echo"</tr> "; 
		
		
		echo"<tr> "; 
		$nbre_0=0;$nbre_1=0;$compteurT1=0;$compteurT2=0;$compteurT3=0;$compteurT4=0;$compteurT=0;$compteurT01=0;$total_nuiteN=0;$first=0;$sexe_mf=0;$motif_T=0;$VacancesT=0;$AffairesT=0;$ParentsT=0;
		$ProfessionnelT=0;$AutresbutsT=0;$TerreT=0;$MerT=0;$AirT=0;$LiberaleT=0;$OuvrierT=0;$EmployeT=0;$CadreT=0;$InactifT=0;$DiversT=0;$MarieT=0;$CelibataireT=0;
		// requete pour compter les fiches
		mysqli_query($con,"SET NAMES 'utf8'");
		

							
							
		$ref=mysqli_query($con,"SELECT DISTINCT client.pays AS pays,pays.continent as continent
							FROM fiche1, client, pays
							WHERE datarriv>='".$debut."' and datarriv<='".$fin."' and fiche1.numcli_1=client.numcli  and client.pays=pays.libpays 
						UNION
							SELECT DISTINCT client.pays AS pays,pays.continent as continent
							FROM fiche1, client, pays
							WHERE datarriv>='".$debut."' and datarriv<='".$fin."' and fiche1.numcli_2=client.numcli and fiche1.numcli_1<> fiche1.numcli_2 and client.pays=pays.libpays 
							GROUP BY  pays 
							ORDER BY continent, pays"); //echo $m=mysqli_num_rows($ref);
				 while ($rerf=mysqli_fetch_array($ref))
				{ 	$pays=addslashes($rerf['pays']); $first++;
					echo"<tr bgcolor='white'> "; 
				/* 	{	/* $res=mysqli_query($con,"SELECT sum(np) AS np FROM encaissement,chambre,fiche1,client WHERE fiche1.numfiche=encaissement.ref AND fiche1.numcli_1=client.numcli AND client.pays='$pays' AND chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and encaissement.typeoccup='individuelle' "); 
						$rers1=mysqli_fetch_array($res);
						$res=mysqli_query($con,"SELECT sum(2*np) AS np FROM encaissement,chambre,fiche1,client WHERE fiche1.numfiche=encaissement.ref AND fiche1.numcli_1=client.numcli AND client.pays='$pays' AND chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and encaissement.typeoccup='double' "); 
						$rers2=mysqli_fetch_array($res);
						$res=mysqli_query($con,"SELECT sum(np) AS np FROM encaissement,chambre,fiche1,client WHERE fiche1.numfiche=encaissement.ref AND fiche1.numcli_1=client.numcli AND client.pays='$pays' AND chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and encaissement.typeoccup='individuelle' "); 
						$rers3=mysqli_fetch_array($res);
						$res=mysqli_query($con,"SELECT sum(2*np) AS np FROM encaissement,chambre,fiche1,client WHERE fiche1.numfiche=encaissement.ref AND fiche1.numcli_1=client.numcli AND client.pays='$pays' AND chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and encaissement.typeoccup='double' "); 
						$rers4=mysqli_fetch_array($res);					
					$NuiteP=$rers1['np']+$rers2['np']+$rers3['np']+$rers4['np']; */					
					//}					
					 //if($NuiteP>0) { */
					 echo"<td> "; echo $rerf['pays'];echo"</td> ";
					 echo"<td> ";echo ucfirst($rerf['continent']);echo"</td> ";

				   	$res=mysqli_query($con,"SELECT client.datnaiss as datnaiss
					FROM fiche1, client,encaissement
					WHERE datarriv>='".$debut."' and datarriv<='".$fin."' and fiche1.numcli_1=client.numcli and client.pays='$pays' AND encaissement.ref=fiche1.numfiche"); 					
					$compteur1=0;$compteur2=0;$compteur3=0;$compteur4=0;$nbre_result1=mysqli_num_rows($res);
					while ($rerf=mysqli_fetch_array($res))
						{  $age=date('Y')-substr($rerf['datnaiss'],6,4);
							if(($age>0)&&($age<=15))
								$compteur1++; //Nbre d'enfants
							if(($age>15)&&($age<18))
								$compteur2++; //Nbre d'ado
							if(($age>=18)&&($age<=50))
								$compteur3++; //Nbre d'adultes
							if($age>50)
								$compteur4++; //Nbre des vieillards
						}						
				  $res=mysqli_query($con,"SELECT client.datnaiss as datnaiss
					FROM fiche1, client,encaissement
					WHERE datarriv>='".$debut."' and datarriv<='".$fin."' and fiche1.numcli_2=client.numcli and fiche1.numcli_1<>fiche1.numcli_2 and client.pays='$pays' AND encaissement.ref=fiche1.numfiche"); 
				   		while ($rerf=mysqli_fetch_array($res))
						{  $age=date('Y')-substr($rerf['datnaiss'],6,4);
							if(($age>0)&&($age<=15))
								$compteur1++; //Nbre d'enfants
							if(($age>15)&&($age<18))
								$compteur2++; //Nbre d'ado
							if(($age>=18)&&($age<=50))
								$compteur3++; //Nbre d'adultes
							if($age>50)
								$compteur4++; //Nbre des vieillards
						}
					echo"<td align='center'> ";echo $compteur1;  echo"</td> ";
					echo"<td align='center'> ";echo $compteur2; echo"</td> ";
					echo"<td align='center'> ";echo $compteur3; echo"</td> ";
					echo"<td align='center'> ";echo $compteur4;echo"</td> ";
					
					$compteurT1+=$compteur1; $compteurT2+=$compteur2;$compteurT3+=$compteur3;$compteurT4+=$compteur4;
					$compteurT0=$compteur1+$compteur2+$compteur3+$compteur4;	
					echo"<td align='center'> ";echo $compteurT0;  echo"</td> ";	$compteurT01+=$compteurT0;
					
						// requete pour compter les sexes
						mysqli_query($con,"SET NAMES 'utf8'");
					$Tsexe=array('M','F');	//$nbre_.$i=0;
					for($i=0;$i<2;$i++){
					$res=mysqli_query($con,"SELECT count(sexe) as Sexe
							FROM fiche1, client,encaissement 
							WHERE datarriv>='".$debut."' and datarriv<='".$fin."' and fiche1.numcli_1=client.numcli and client.pays='$pays' and client.sexe='".$Tsexe[$i]."' AND encaissement.ref=fiche1.numfiche"); 
						$rers1=mysqli_fetch_array($res);						
					$res=mysqli_query($con,"SELECT count(sexe) as Sexe
							FROM fiche1, client,encaissement 
							WHERE datarriv>='".$debut."' and datarriv<='".$fin."' and fiche1.numcli_2=client.numcli and client.pays='$pays' and fiche1.numcli_1<>fiche1.numcli_2 and client.sexe='".$Tsexe[$i]."' AND encaissement.ref=fiche1.numfiche"); 
						$rers2=mysqli_fetch_array($res);	
	
					echo"<td align='center'> "; $sexe=$rers1['Sexe']+$rers2['Sexe'];echo $sexe;echo"</td> "; if($i==0?$nbre_0+=$sexe:$nbre_1+=$sexe);
					}
					//if($_POST['choix']==2)
					// requete pour compter les Nuités
					//{	


			
			$somme=array("");$i=0;$Nuite=0;
			for($k=0;$k<$Ntypech;$k++){
				for($j=0;$j<$Ntypeoccup;$j++){	// 
				$req="SELECT sum(np) AS np FROM encaissement,chambre,fiche1,client WHERE fiche1.numfiche=encaissement.ref AND fiche1.numcli_1=client.numcli AND client.pays='$pays' AND chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='".$typech[$k]."' and encaissement.typeoccup='".$typeoccup[$j]."' ";
				$res=mysqli_query($con,$req);
				$rers1=mysqli_fetch_array($res) ; 
					$somme[$i]=$rers1['np'];	
			 		if($etat_taxe==2){
						if($typeoccup[$j]=="double")  $somme[$i]*=2;$i++;
 					}
					$Nuite+=$somme[$i];
					//echo"<td align=''>".$somme[$i]."</td> "; $i++;
				}
			}
			
/* 					$res=mysqli_query($con,"SELECT sum(np) AS np FROM encaissement,chambre,fiche1,client WHERE fiche1.numfiche=encaissement.ref AND fiche1.numcli_1=client.numcli AND client.pays='$pays' AND chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and encaissement.typeoccup='individuelle' "); 
					$rers1=mysqli_fetch_array($res);
					$res=mysqli_query($con,"SELECT sum(np) AS np FROM encaissement,chambre,fiche1,client WHERE fiche1.numfiche=encaissement.ref AND fiche1.numcli_1=client.numcli AND client.pays='$pays' AND chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and encaissement.typeoccup='double' "); 
					$rers2=mysqli_fetch_array($res);
					$res=mysqli_query($con,"SELECT sum(np) AS np FROM encaissement,chambre,fiche1,client WHERE fiche1.numfiche=encaissement.ref AND fiche1.numcli_1=client.numcli AND client.pays='$pays' AND chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and encaissement.typeoccup='individuelle' "); 
					$rers3=mysqli_fetch_array($res);
					$res=mysqli_query($con,"SELECT sum(np) AS np FROM encaissement,chambre,fiche1,client WHERE fiche1.numfiche=encaissement.ref AND fiche1.numcli_1=client.numcli AND client.pays='$pays' AND chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and encaissement.typeoccup='double' "); 
					$rers4=mysqli_fetch_array($res); */
					

					//$Nuite=$rers1['np']+$double*$rers2['np']+$rers3['np']+$double*$rers4['np'];
					
	//Commenté le 23.01.2019			
/* 					if($difference_nuite>0) 
						{ if($pays=="Benin")
							{	$Nuite+=$difference_nuite;
							}
						}
						else
						{  $difference_nuite=abs($difference_nuite); 
							if($pays=="Benin")
							{	$Nuite-=$difference_nuite;
							}
						} */ 
						
						
					echo"<td align='center'> "; echo $Nuite;echo"</td> ";
					 $total_nuiteN+=$Nuite;
					 
					//}					
					$TmotiF=array('Vacances/Loisirs','Affaires','Parents et Amis','Professionnel','Autre');
					for($i=0;$i<5;$i++) {
					// requete pour compter les motifs sejour 
					$res=mysqli_query($con,"SELECT count(motifsejoiur) as Motif
							FROM fiche1, client,encaissement
							WHERE datarriv>='".$debut."' and datarriv<='".$fin."' and fiche1.numcli_1=client.numcli and client.pays='$pays' and motifsejoiur='".$TmotiF[$i]."' AND encaissement.ref=fiche1.numfiche"); 
						$rers1=mysqli_fetch_array($res);
					$res=mysqli_query($con,"SELECT count(motifsejoiur) as Motif
							FROM fiche1, client,encaissement
							WHERE datarriv>='".$debut."' and datarriv<='".$fin."' and fiche1.numcli_2=client.numcli and fiche1.numcli_1<>fiche1.numcli_2 and client.pays='$pays' and motifsejoiur='".$TmotiF[$i]."' AND encaissement.ref=fiche1.numfiche"); 
						$rers2=mysqli_fetch_array($res);
					echo"<td align='center'> ";
					  if($i==0) echo $nbre1=$rers1['Motif']+$rers2['Motif'];if($i==1) echo $nbre2=$rers1['Motif']+$rers2['Motif'];	if($i==2) echo $nbre3=$rers1['Motif']+$rers2['Motif'];if($i==3) echo $nbre4=$rers1['Motif']+$rers2['Motif'];if($i==4) echo $nbre5=$rers1['Motif']+$rers2['Motif'];
					echo"</td> "; 
				} $VacancesT+=$nbre1;  $AffairesT+=$nbre2; $ParentsT+=$nbre3;$ProfessionnelT+=$nbre4;$AutresbutsT+=$nbre5;	
								
				// requete pour compter les modes de transport
					for($i=0;$i<3;$i++)	{
					$res=mysqli_query($con,"SELECT count(modetransport) as Mode
							FROM fiche1, client,encaissement
							WHERE datarriv>='".$debut."' and datarriv<='".$fin."' and fiche1.numcli_1=client.numcli and client.pays='$pays' and modetransport='".strtolower($Tmode[$i])."' AND encaissement.ref=fiche1.numfiche"); 
						$rers1=mysqli_fetch_array($res);
						$res=mysqli_query($con,"SELECT count(modetransport) as Mode
							FROM fiche1, client,encaissement
							WHERE datarriv>='".$debut."' and datarriv<='".$fin."' and fiche1.numcli_2=client.numcli and fiche1.numcli_1<>fiche1.numcli_2 and client.pays='$pays' and modetransport='".strtolower($Tmode[$i])."' AND encaissement.ref=fiche1.numfiche"); 
						$rers2=mysqli_fetch_array($res);	
				
					echo"<td align='center'> ";if($i==0) echo $nbre1=$rers1['Mode']+$rers2['Mode']; if($i==1) echo $nbre2=$rers1['Mode']+$rers2['Mode'];if($i==2) echo $nbre3=$rers1['Mode']+$rers2['Mode'];echo"</td> ";
					}$TerreT+=$nbre1;$MerT+=$nbre2;$AirT+=$nbre3;	
			for($i=0;$i<6;$i++)	{		
					// requete pour compter les profession
					$res=mysqli_query($con,"SELECT count(profession) as Prof
							FROM fiche1, client,encaissement
							WHERE datarriv>='".$debut."' and datarriv<='".$fin."' and fiche1.numcli_1=client.numcli and client.pays='$pays' and profession='".$Tprofession[$i]."' AND encaissement.ref=fiche1.numfiche"); 
						$rers1=mysqli_fetch_array($res);
					$res=mysqli_query($con,"SELECT count(profession) as Prof
							FROM fiche1, client,encaissement
							WHERE datarriv>='".$debut."' and datarriv<='".$fin."' and fiche1.numcli_2=client.numcli and fiche1.numcli_1<>fiche1.numcli_2 and client.pays='$pays' and profession='".$Tprofession[$i]."' AND encaissement.ref=fiche1.numfiche"); 
						$rers2=mysqli_fetch_array($res);
					echo"<td align='center'> ";
					if($i==0) echo $nbre1=$rers1['Prof']+$rers2['Prof'];if($i==1) echo $nbre2=$rers1['Prof']+$rers2['Prof'];if($i==2) echo $nbre3=$rers1['Prof']+$rers2['Prof'];
					if($i==3) echo $nbre4=$rers1['Prof']+$rers2['Prof'];if($i==4) echo $nbre5=$rers1['Prof']+$rers2['Prof'];if($i==5) echo $nbre6=$rers1['Prof']+$rers2['Prof'];
					echo"</td> ";  
				}	$LiberaleT+=$nbre1; $OuvrierT+=$nbre2;$EmployeT+=$nbre3; $CadreT+=$nbre4; $InactifT+=$nbre5; $DiversT+=$nbre6;
					
			// requete pour compter les  états civils 
			for($i=0;$i<2;$i++)
					{$res=mysqli_query($con,"SELECT count(etatcivil) as Civil
							FROM fiche1, client,encaissement
							WHERE datarriv>='".$debut."' and datarriv<='".$fin."' and fiche1.numcli_1=client.numcli and client.pays='$pays' and etatcivil='".$TEtatcivil[$i]."' AND encaissement.ref=fiche1.numfiche"); 
					$rers1=mysqli_fetch_array($res);
					$res=mysqli_query($con,"SELECT count(etatcivil) as Civil
							FROM fiche1, client,encaissement
							WHERE datarriv>='".$debut."' and datarriv<='".$fin."' and fiche1.numcli_2=client.numcli and fiche1.numcli_1<>fiche1.numcli_2 and client.pays='$pays' and etatcivil='".$TEtatcivil[$i]."' AND encaissement.ref=fiche1.numfiche"); 
					$rers2=mysqli_fetch_array($res);
					echo"<td align='center'> ";if($i==0) echo $nbre1=$rers1['Civil']+$rers2['Civil'];if($i==1) echo $nbre2=$rers1['Civil']+$rers2['Civil'];echo"</td> ";  
				} $MarieT+=$nbre1;$CelibataireT+=$nbre2;
				echo"</tr> "; 
		}		
		echo"<tr bgcolor='#faebd7'style='font-size:16px; '> "; 		
					echo"<td colspan='2' align='center'> TOTAL </td> ";
						// requete pour compter le total 
					echo"<td align='center'> ";echo $compteurT1; echo"</td> ";
					echo"<td align='center'> ";echo $compteurT2;echo"</td> ";
					echo"<td align='center'> ";echo $compteurT3; echo"</td> ";
					echo"<td align='center'> ";echo $compteurT4;echo"</td> ";
					echo"<td align='center'> ";echo $compteurT01;  echo"</td> ";
						
						// requete pour compter les sexes
					echo"<td align='center'> ";echo $nbre_0;echo"</td> ";
					echo"<td align='center'> ";echo $nbre_1;echo"</td> ";

					// requete pour compter les nuité 
					echo"<td align='center'> "; echo $total_nuiteN;echo"</td> ";
					
					// reequete pour compter les motifs sejour 
					echo"<td align='center'> ";echo $VacancesT;echo"</td> ";
					echo"<td align='center'> ";echo $AffairesT;echo"</td> ";
					echo"<td align='center'> ";echo $ParentsT;echo"</td> ";
					echo"<td align='center'> ";echo $ProfessionnelT;echo"</td> ";
					echo"<td align='center'> ";echo $AutresbutsT;echo"</td> ";
					
					// reequete pour compter les modes de transport
					echo"<td align='center'> ";echo $TerreT;echo"</td> ";
					echo"<td align='center'> ";echo $MerT;echo"</td> ";
					echo"<td align='center'> ";echo $AirT;echo"</td> ";
					
					// reequete pour compter les profession
					echo"<td align='center'> ";echo $LiberaleT;echo"</td> ";
					echo"<td align='center'> ";echo $OuvrierT;echo"</td> ";
					echo"<td align='center'> ";echo $EmployeT;echo"</td> ";
					echo"<td align='center'> ";echo $CadreT;echo"</td> ";
					echo"<td align='center'> ";echo $InactifT;echo"</td> ";
					echo"<td align='center'> ";echo $DiversT;echo"</td> ";

					// reequete pour compter les  états civils 
					echo"<td align='center'> ";echo $MarieT;echo"</td> ";
					echo"<td align='center'> ";echo $CelibataireT;echo"</td> ";
					
				echo"</tr> "; 
		echo"</table> "; 
	}
	
	echo "<br/><u><b>NB:</b></u> Les renseignements contenus dans ce questionnaire sont confidentiels; ils sont couverts par le secret statistique. les résultats seront publié sous formes anonyme conformement à l'article 25 de la loi n° 99-014 du 29 janvier 1999, portant création, organisation et fonctionnement du Conseil National de la Statistique (CNS) &nbsp;";
	//echo $var;
	
		echo "<br/><br/><br/>
		<a href='statistique.php'><img src='logo/excel.png' alt='Version Excel' title='Version Excel' width='30' height='30' class='noprt' style='clear:both;'></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=''><img src='logo/im10.jpg' width='80' id='button-imprimer' class='noprt' style=''></a>";
	?>
<script type='text/javascript'>
   var bouton = document.getElementById('button-imprimer');
bouton.onclick = function(e) {
  e.preventDefault();
  print();
}
 </script>
 </body>
  </html>