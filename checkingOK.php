<?php
		@include('config.php'); // decommenter
		@session_start(); //commenter  
		if(isset($_SESSION['EtatF'])&&($_SESSION['EtatF']=="A")){	//echo $_SESSION['reference'];
			$reqsel=mysqli_query($con,"SELECT num_fact,numFactNorm FROM configuration_facture");
			$data=mysqli_fetch_object($reqsel);	$NumFact=NumeroFacture($data->num_fact);  $numFactNorm=NumeroFacture($data->numFactNorm);
			$_SESSION['initial_fiche']=$numFactNorm;
				include('emecef.php');

			header('location:InvoiceTPS.php');  
											 
		}
		else {		
			$date = new DateTime("now"); // 'now' n'est pas n�c�ssaire, c'est la valeur par d�faut
			$tz = new DateTimeZone('Africa/Porto-Novo');
			$date->setTimezone($tz);
			$Heure_actuelle= $date->format("H") .":". $date->format("i").":". $date->format("s");
			$Jour_actuel= $date->format("Y") ."-". $date->format("m")."-". $date->format("d");

			$_SESSION['Date_actuel']=isset($_SESSION['date_emission'])?$_SESSION['date_emission']:$Date_actuel;
			
			if(!isset($_SESSION['PeriodeC']))$_SESSION['PeriodeC']=0; //echo $_SESSION['PeriodeC'];
			if(!isset($_SESSION['PeriodeS']))$_SESSION['PeriodeS']=0; //echo $_SESSION['PeriodeS'];
			
		//echo $_SESSION['NumIFUEn'];	echo "-"; echo $_SESSION['eMCF']; echo $_SESSION['PaymentDto'];

		//if(isset($_SESSION['PeriodeS']))	unset($_SESSION['cham']);

		 //echo $_SESSION['PaymentDto'];  echo $_SESSION['vendeur']="BESSAN Sévérin";
		 
		 //if(isset($_SESSION['view'])) echo $_SESSION['view'];
		 
		 //echo $_SESSION['cham'];

		if(isset($_SESSION['cham'])&&($_SESSION['cham']==1))  $_SESSION['objet'] = utf8_decode("Hébergement");

		if(empty($_GET['numrecu'])){

			$_SESSION['devise']=isset($devise)?$devise:NULL; //echo $_SESSION['edit2'];

			if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) {
				if(isset($_SESSION['PeriodeC'])) {
					$post0="etatsortie='OUI' AND Periode='".$_SESSION['PeriodeC']."'";
					$post_0="etatsortie='OUI' AND Periode='".$_SESSION['PeriodeC']."'";
					}
				if(isset($_SESSION['PeriodeS'])) $post_S="location.etatsortie='OUI' AND location.Periode='".$_SESSION['PeriodeS']."'";
				}else {
					$post0="mensuel_fiche1.etatsortie='NON' AND mensuel_fiche1.Periode='".$_SESSION['PeriodeC']."'";
					$post_0="mensuel_fiche1.etatsortie='NON'";
					if(isset($_SESSION['PeriodeS']))	$post_S="location.etatsortie='NON' AND location.Periode='".$_SESSION['PeriodeS']."'";
				}
			if(!isset($_SESSION['groupe1'])&& !isset($_SESSION['num']))   $_SESSION['groupe1']=$_SESSION['groupe'];

			if(isset($_SESSION['groupe']))
				 {	if(!isset($_SESSION['PeriodeS']))
						$query="SELECT max(mensuel_compte.np) AS np_1 FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.numfichegrpe LIKE '".$_SESSION['code_reel']."' AND ".$post_0;
					 if(isset($_SESSION['PeriodeS']))
					    $query_S="SELECT max(compte1.np) AS np_1 FROM location,compte1 WHERE location.numfiche=compte1.numfiche AND location.numfichegrpe LIKE '".$_SESSION['code_reel']."' AND ".$post_S;
				 }
			else{	if(!isset($_SESSION['PeriodeS']))
						$query="SELECT max(mensuel_compte.np) AS np_1 FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.numfiche='".$_SESSION['num']."' AND ".$post0;
					if(isset($_SESSION['PeriodeS']))
						$query_S="SELECT max(compte1.np) AS np_1 FROM location,compte1 WHERE location.numfiche=compte1.numfiche AND location.numfiche='".$_SESSION['num']."' AND ".$post_S;
				}
			if(!isset($_SESSION['PeriodeS'])) $res1=mysqli_query($con,$query); else $res1=mysqli_query($con,$query_S); $ret=mysqli_fetch_object($res1);$np_1=$ret->np_1;
			if(isset($_SESSION['PeriodeS'])) {$res1S=mysqli_query($con,$query_S); $retS=mysqli_fetch_object($res1S);$np_1S=$ret->np_1;}
/* 				while ($ret=mysqli_fetch_array($res1))
				{	$np_1=$ret['np_1'];
				} */
			if(isset($_SESSION['groupe1']))
			{
				
			if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) 					
				 echo $query="SELECT min(fiche1.datarriv1) AS min_date FROM fiche1,compte WHERE fiche1.codegrpe='".$_SESSION['groupe1']."' AND compte.numfiche=fiche1.numfiche  AND fiche1.datarriv1
			BETWEEN '".$_SESSION['ladate1']."' AND '".$_SESSION['ladate2']."' AND ".$post0;
			else 
				 $query="SELECT min(mensuel_fiche1.datarriv1) AS min_date FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.codegrpe='".$_SESSION['groupe1']."' AND mensuel_compte.numfiche=mensuel_fiche1.numfiche  AND mensuel_fiche1.datarriv1
			BETWEEN '".$_SESSION['ladate1']."' AND '".$_SESSION['ladate2']."' AND ".$post0;
			$res1=mysqli_query($con,$query);$ret=mysqli_fetch_object($res1);$min_date=$ret->min_date;
/* 			while ($ret=mysqli_fetch_array($res1))
				{	$min_date=$ret['min_date'];
				} */

				if(isset($_SESSION['PeriodeS'])){
				$query="SELECT min(location.datarriv1) AS min_date FROM location,compte1 WHERE location.codegrpe='".$_SESSION['groupe1']."' AND compte1.numfiche=location.numfiche  AND location.datarriv1
				BETWEEN '".$_SESSION['ladate1']."' AND '".$_SESSION['ladate2']."' AND ".$post_S;
				$res1_S=mysqli_query($con,$query); $retS=mysqli_fetch_object($res1_S); $min_dateS=$retS->min_date;
				}
			}
			$_SESSION['total_ttB']=isset($_POST['edit_6'])?$_POST['edit_6']:0;
			$_SESSION['update']='OUI';
			$_SESSION['date2']=isset($_POST['ladate2'])?$_POST['ladate2']:0;

			if(isset($_SESSION['groupe'])||isset($_SESSION['groupe1'])) $typeEncaisse="Facture de groupe"; else $typeEncaisse="Entree chambre";

			if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)){
				if(isset($_SESSION['groupe1']))
				$query="SELECT sum(compte.np )as sum_np
				FROM client, fiche1, chambre, compte, view_client
				WHERE fiche1.numcli_1 = client.numcli
				AND fiche1.numcli_2 = view_client.numcli
				AND fiche1.codegrpe = '".$_SESSION['groupe1']."'
				AND chambre.numch = compte.numch
				AND compte.numfiche = fiche1.numfiche
				AND ".$post0;
				else
					$query="SELECT sum(compte.np )as sum_np
				FROM client, fiche1, chambre, compte, view_client
				WHERE fiche1.numcli_1 = client.numcli
				AND fiche1.numcli_2 = view_client.numcli
				AND fiche1.numfiche = '".$_SESSION['num']."'
				AND chambre.numch = compte.numch
				AND compte.numfiche = fiche1.numfiche
				AND ".$post0;
				
			}else {
			if(isset($_SESSION['groupe1']))
				$query="SELECT sum(mensuel_compte.np )as sum_np
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND mensuel_fiche1.codegrpe = '".$_SESSION['groupe1']."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND ".$post0;
			else
				$query="SELECT sum(mensuel_compte.np )as sum_np
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND mensuel_fiche1.numfiche = '".$_SESSION['num']."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND ".$post0;
			}			
			
			$sql_3=mysqli_query($con,$query);
			$Record_set = mysqli_fetch_assoc($sql_3);
			$sum_np=$Record_set['sum_np'];

			$etat_date=0;
			
			if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)){
				if(isset($_SESSION['groupe'])){
					 $query="SELECT compte.date AS debut FROM fiche1,compte WHERE fiche1.numfichegrpe LIKE '".$_SESSION['code_reel']."'  AND compte.numfiche=fiche1.numfiche AND ".$post0;
				if(isset($_SESSION['PeriodeS']))
					 $queryS="SELECT compte1.date AS debut FROM location,compte1 WHERE location.numfichegrpe LIKE '".$_SESSION['code_reel']."'  AND compte1.numfiche=location.numfiche AND ".$post_S;
				}
				else {
						 $query="SELECT compte.date AS debut FROM fiche1,compte WHERE fiche1.numfiche='".$_SESSION['num']."' AND compte.numfiche=fiche1.numfiche AND ".$post0;
					if(isset($_SESSION['PeriodeS']))
						 $queryS="SELECT compte1.date AS debut FROM location,compte1 WHERE location.numfiche LIKE '".$_SESSION['num']."'  AND compte1.numfiche=location.numfiche AND ".$post_S;
				}
				
			}else {
				if(isset($_SESSION['groupe'])){
					 $query="SELECT mensuel_compte.date AS debut FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.numfichegrpe LIKE '".$_SESSION['code_reel']."'  AND mensuel_compte.numfiche=mensuel_fiche1.numfiche AND ".$post0;
					if(isset($_SESSION['PeriodeS']))
						 $queryS="SELECT compte1.date AS debut FROM location,compte1 WHERE location.numfichegrpe LIKE '".$_SESSION['code_reel']."'  AND compte1.numfiche=location.numfiche AND ".$post_S;
				}
				else {
						 $query="SELECT mensuel_compte.date AS debut FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.numfiche='".$_SESSION['num']."' AND mensuel_compte.numfiche=mensuel_fiche1.numfiche AND ".$post0;
					if(isset($_SESSION['PeriodeS']))
						 $queryS="SELECT compte1.date AS debut FROM location,compte1 WHERE location.numfiche LIKE '".$_SESSION['num']."'  AND compte1.numfiche=location.numfiche AND ".$post_S;
				}	
			}

			$res1=mysqli_query($con,$query); $ret=mysqli_fetch_object($res1);$debut=isset($ret->debut)?$ret->debut:NULL;
/* 			while ($ret=mysqli_fetch_array($res1))
			{	 $debut=isset($ret['debut'])?$ret['debut']:NULL;
			} */
			if(isset($_SESSION['PeriodeS'])) { $res1S=mysqli_query($con,$queryS);$retS=mysqli_fetch_object($res1S); $debutS=isset($retS->debut)?$retS->debut:NULL;}

			if(!isset($debut)||($debut==NULL))
			{	
		
			if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)){
				if(isset($_SESSION['groupe'])){
					 if(isset($_SESSION['cham']))
						  $query="SELECT min(fiche1.datarriv1) AS min_date FROM fiche1,compte WHERE fiche1.codegrpe LIKE '".$_SESSION['groupe']."'  AND compte.numfiche=fiche1.numfiche AND ".$post0;
					 else 
						 $query="SELECT min(location.datarriv1) AS min_date FROM location,compte1 WHERE location.codegrpe LIKE '".$_SESSION['groupe']."'  AND compte1.numfiche=location.numfiche AND ".$post_S;						 
					}
				else {
					 if(isset($_SESSION['cham']))
						$query="SELECT min(fiche1.datarriv1) AS min_date FROM fiche1,compte WHERE fiche1.numfiche='".$_SESSION['num']."' AND compte.numfiche=fiche1.numfiche AND ".$post0;
					 else
						$query="SELECT min(location.datarriv1) AS min_date FROM location,compte1 WHERE location.numfiche='".$_SESSION['num']."' AND compte1.numfiche=location.numfiche AND ".$post_S;
						 
					}
			}
			else {
					if(isset($_SESSION['groupe'])){
					 if(isset($_SESSION['cham']))
						 $query="SELECT min(mensuel_fiche1.datarriv1) AS min_date FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.codegrpe LIKE '".$_SESSION['groupe']."'  AND mensuel_compte.numfiche=mensuel_fiche1.numfiche AND ".$post0;
					 else 
						 $query="SELECT min(location.datarriv1) AS min_date FROM location,compte1 WHERE location.codegrpe LIKE '".$_SESSION['groupe']."'  AND compte1.numfiche=location.numfiche AND ".$post_S;						 
					}
				else {
					 if(isset($_SESSION['cham']))
						$query="SELECT min(mensuel_fiche1.datarriv1) AS min_date FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.numfiche='".$_SESSION['num']."' AND mensuel_compte.numfiche=mensuel_fiche1.numfiche AND ".$post0;
					 else
						$query="SELECT min(location.datarriv1) AS min_date FROM location,compte1 WHERE location.numfiche='".$_SESSION['num']."' AND compte1.numfiche=location.numfiche AND ".$post_S;
						 
					}
			}

			$res1=mysqli_query($con,$query); $ret=mysqli_fetch_object($res1);  $min_date=isset($ret->min_date)?$ret->min_date:NULL;
/* 			while ($ret=mysqli_fetch_array($res1))
				{	  $min_date=$ret['min_date'];
				} */

				  $ans=substr($min_date,0,4);	$mois=substr($min_date,5,2);$jour=substr($min_date,8,2);
			      $_SESSION['debut']=substr($min_date,8,2).'-'.substr($min_date,5,2).'-'.substr($min_date,0,4);
			}
			else
			{	 $ans=substr($debut,6,4);$mois=substr($debut,3,2);$jour=substr($debut,0,2); $etat_date=1;
				 $_SESSION['debut']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour),date($ans)));
			}

		//echo $debutS;

			if(isset($_SESSION['PeriodeS'])&&($_SESSION['PeriodeS']>0)){        //Location de salle ici
				if(!isset($debutS)||($debutS==NULL))
				{	if(isset($_SESSION['groupe']))
						 $query="SELECT min(location.datarriv1) AS min_date FROM location,compte1 WHERE location.codegrpe LIKE '".$_SESSION['groupe']."'  AND compte1.numfiche=location.numfiche AND ".$post_S;
					else
						 $query="SELECT min(location.datarriv1) AS min_date FROM location,compte1 WHERE location.numfiche='".$_SESSION['num']."' AND compte1.numfiche=location.numfiche AND ".$post_S;
						$res1=mysqli_query($con,$query);$retS=mysqli_fetch_object($res1);  $min_dateS=isset($retS->min_date)?$retS->min_date:NULL;

						$ans=substr($min_dateS,0,4);	$mois=substr($min_dateS,5,2);$jour=substr($min_dateS,8,2);
						$_SESSION['debutS']=substr($min_dateS,8,2).'-'.substr($min_dateS,5,2).'-'.substr($min_dateS,0,4);
				}
				else
				{	 	$ans=substr($debutS,6,4);$mois=substr($debutS,3,2);$jour=substr($debutS,0,2); $etat_date=1;
						$_SESSION['debutS']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour),date($ans)));
				}
			}

			if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)){
				if(isset($_SESSION['groupe1']))
					//echo "<br/>1-".
				$query="SELECT compte.numfiche AS numfiche,N_reel,datarriv1,compte.np as NuiteP,somme, compte.somme AS SommeP,compte.ttc_fixe,compte.ttc_fixeR,fiche1.numfichegrpe,compte.date AS date,compte.due AS due
				FROM client, fiche1, chambre, compte, view_client
				WHERE fiche1.numcli_1 = client.numcli
				AND fiche1.numcli_2 = view_client.numcli
				AND fiche1.codegrpe = '".$_SESSION['groupe1']."'
				AND chambre.numch = compte.numch
				AND compte.numfiche = fiche1.numfiche
				AND ".$post0;
				else
					//echo "<br/>2-".
					$query="SELECT compte.numfiche AS numfiche,compte.np as NuiteP,N_reel,datarriv1,somme, compte.somme AS SommeP,compte.ttc_fixe,compte.ttc_fixeR,fiche1.numfichegrpe,compte.date AS date,compte.due AS due
				FROM client, fiche1, chambre, compte, view_client
				WHERE fiche1.numcli_1 = client.numcli
				AND fiche1.numcli_2 = view_client.numcli
				AND fiche1.numfiche = '".$_SESSION['num']."'
				AND chambre.numch = compte.numch
				AND compte.numfiche = fiche1.numfiche
				AND ".$post0;
	
			}
			else 
			{
				if(isset($_SESSION['groupe1']))
					echo "<br/>1-".
				$query="SELECT mensuel_compte.numfiche AS numfiche,N_reel,datarriv1,mensuel_compte.np as NuiteP,somme, mensuel_compte.somme AS SommeP,mensuel_compte.ttc_fixe,mensuel_compte.ttc_fixeR,mensuel_fiche1.numfichegrpe,mensuel_compte.date AS date,mensuel_compte.due AS due
				FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
				WHERE mensuel_fiche1.numcli_1 = client.numcli
				AND mensuel_fiche1.numcli_2 = view_client.numcli
				AND mensuel_fiche1.codegrpe = '".$_SESSION['groupe1']."'
				AND chambre.numch = mensuel_compte.numch
				AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
				AND ".$post0;
				else
					//echo "<br/>2-".
					$query="SELECT mensuel_compte.numfiche AS numfiche,mensuel_compte.np as NuiteP,N_reel,datarriv1,somme, mensuel_compte.somme AS SommeP,mensuel_compte.ttc_fixe,mensuel_compte.ttc_fixeR,mensuel_fiche1.numfichegrpe,mensuel_compte.date AS date,mensuel_compte.due AS due
				FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
				WHERE mensuel_fiche1.numcli_1 = client.numcli
				AND mensuel_fiche1.numcli_2 = view_client.numcli
				AND mensuel_fiche1.numfiche = '".$_SESSION['num']."'
				AND chambre.numch = mensuel_compte.numch
				AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
				AND ".$post0;
			}
			//$sql3=mysqli_query($con,$query);

			$sql3=mysqli_query($con,$query);
			if (!$sql3) {
				printf("Error: %s\n", mysqli_error($con));
				exit();
			}
			$i=0; $nombre=array("");$soustraire=0;$sommeArrhes=0;	 $Listcompte=array(); $k=0; $Tttc_fixe=0;
			//echo "<br/>1-". mysqli_num_rows($sql3);
			while($row_1=mysqli_fetch_array($sql3))
			{   $nombre= $row_1['numfiche'];
			  //$sommeArrhes=$row_1['sommeP'];
				$Listcompte[$k]=$nombre;
			  if($row_1['ttc_fixeR']>0) $nombre2= $row_1['ttc_fixeR']; else $nombre2= $row_1['ttc_fixe'];
				$k++;
			  $numfichegrpe= $row_1['numfichegrpe'];

				$nuite= round((strtotime($Jour_actuel)-strtotime($row_1['datarriv1']))/86400);
				$dat=(date('H')+1);
				settype($dat,"integer");
				if ($dat<14)
				{ $nuite=$nuite;
				} else
				{ $nuite= $nuite+1;
				}
				if($nuite==0)
				{$nuite= $nuite+1;
				}
				$nuite=(int)$nuite; 
				
				$postT[$nombre] = $nuite; 
				
				if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) 
					$postT[$nombre] = $row_1['N_reel'];	
				else $Nuite_Payee=$nuite;
				
			if(isset($numfichegrpe)&&(!empty($numfichegrpe))&&(isset($_SESSION['impaye']))&&($_SESSION['impaye']==1))
			{ //echo 	$nuite;
				//Facture de groupe délicat lorsque les clients ne sont pas arrivés un même jour
				//Partie à revoir avec attention
			}else if(isset($numfichegrpe)&&(!empty($numfichegrpe)))	{

			}else {
				$nuite=isset($np_1)?$np_1:0;
				$nuite+=$_SESSION['NuitePayee'];
			}			
			
			if(isset($_SESSION['Nd'])&&($_SESSION['Nd']>0)&& is_numeric($_SESSION['Nd'])&& is_int($_SESSION['Nd']))  $nuite=$_SESSION['Nd'];							
							
			 $SommePayee=$nuite*$nombre2;

			 if(!isset($_SESSION['impaye']))
			  $Tttc_fixe +=$SommePayee; else $Tttc_fixe +=$row_1['due'];

			if(!isset($_SESSION['fiche'])){
				if(($i==0)&&(isset($_SESSION['sommeArrhes']))){
				 if(!isset($_SESSION['remise']))
				 $SommePayee=$SommePayee+$_SESSION['sommeArrhes'];
				 //$SommePayee2=$SommePayee;
			 }
			 $due= abs($SommePayee-$row_1['due'])  ;
			 	if(isset($numfichegrpe)&&(!empty($numfichegrpe))&&(isset($_SESSION['impaye']))&&($_SESSION['impaye']==1)) {  //Traitement des impayés pour un groupe
				$SommePayee=$row_1['somme']+$row_1['due'];  $Tttc_fixe=$SommePayee;
				if($row_1['ttc_fixeR']>0) $nuite =$row_1['due']/$row_1['ttc_fixeR'];else	$nuite =$row_1['due']/$row_1['ttc_fixe'];
				$due=0; $nuite= $row_1['N_reel'];
			 }

				//if((!isset($_SESSION['updateBD']))||(isset($_SESSION['retro'])&& ($_SESSION['retro']==1)&&(isset($_SESSION['updateBD']))&&($_SESSION['updateBD']==1)))
				if(isset($_SESSION['retro'])&& ($_SESSION['retro']==1)||(isset($_SESSION['updateBD']))&&($_SESSION['updateBD']==1))
				 	{	if(($_SESSION['NormSencaisser']==1)&&(isset($_SESSION['impaye'])))  //Normaliser la facture sans encaisser
							$update=NULL;
						else 
							$update = " somme='".$SommePayee."', "; 
					} else {$update=NULL; }
				 $TauxR=(isset($_SESSION['pourcent'])&&($_SESSION['pourcent']>0))?$_SESSION['pourcent']:0;	
								  
				 $pos="SET ".$update."np='".$nuite."',N_reel='".$nuite."',TauxR='".$TauxR."' ";
				 
				 if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1))  
					{if($_SESSION['NormSencaisser']==0) $pos.=",due='".$due."' "; //else $pos.=NULL;
					}
				 //$pos.=",due=abs($SommePayee-due) "; //Pour le cas de la régularisation d'une facture impayee
				 $pos.=" WHERE numfiche='".$nombre."'";

				 //if(!isset($_SESSION['button_checkbox_2']))
				 {					 
				 $req1="UPDATE mensuel_compte ".$pos;	 $req2="UPDATE compte ".$pos;
				 if(isset($_SESSION['cham'])&&($_SESSION['cham']==1)){
					  if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $req_=mysqli_query($con,$req1);
					  if($_SESSION['serveurused']=="emecef"){
					  if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $reqA=mysqli_query($con,$req2);
					  }
				  }
				 }

				}

			}  
			
 			echo '<pre>';
				print_r($postT);
			echo '</pre>'; 
			
			if((isset($_SESSION['PeriodeS'])&&($_SESSION['PeriodeS']==1))||(isset($_SESSION['Fusion0K'])&&($_SESSION['Fusion0K']==2)))
				
			include('CheckingOKS1.php');  //Traitement spécial pour Location de Salle

			if(isset($_SESSION['cham'])&&($_SESSION['cham']==1)){

			if((isset($_POST['exonorer_tva'])) && ($_POST['exonorer_tva']==1))
				$sql=mysqli_query($con,"INSERT INTO exonerer_tva VALUES('".$Jour_actuel."','".$nombre."')");
			if((isset($_POST['exonerer_AIB'])) && ($_POST['exonerer_AIB']==1))
				$sql=mysqli_query($con,"INSERT INTO exonerer_aib VALUES('".$Jour_actuel."','".$nombre."')");
			 $i++;
			}
			$nbre=mysqli_num_rows($sql3);

			if((isset($_POST['defalquer_impaye'])) && ($_POST['defalquer_impaye']==1))
			{
				/* $sql2=mysqli_query($con,"CREATE OR REPLACE view view_temporaire AS SELECT mensuel_compte.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2,
			view_client.nomcli AS nom2, view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.tva,mensuel_compte.ttc_fixe,mensuel_compte.np,mensuel_compte.N_reel AS N_reel,mensuel_compte.taxe,mensuel_compte.typeoccup, mensuel_compte.ttc, mensuel_fiche1.datarriv1,mensuel_compte.nuite,mensuel_compte.somme AS somme
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND mensuel_fiche1.codegrpe = '".$_SESSION['groupe1']."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND mensuel_fiche1.etatsortie = 'NON'
			AND mensuel_fiche1.datarriv1
			BETWEEN '".$_SESSION['ladate1']."'
			AND '".$_SESSION['ladate2']."'" );	 */
			}
			else
			{/* $sql2=mysqli_query($con,"CREATE OR REPLACE view view_temporaire AS SELECT mensuel_compte.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2,
			view_client.nomcli AS nom2, view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.tva,mensuel_compte.ttc_fixe,mensuel_compte.np,mensuel_compte.N_reel AS N_reel,mensuel_compte.taxe,mensuel_compte.typeoccup, mensuel_compte.ttc, mensuel_fiche1.datarriv1,mensuel_compte.nuite,mensuel_compte.somme AS somme
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND mensuel_fiche1.codegrpe = '".$_SESSION['groupe1']."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND mensuel_fiche1.etatsortie = 'NON'
			AND mensuel_fiche1.datarriv1
			BETWEEN '".$_SESSION['ladate1']."'
			AND '".$_SESSION['ladate2']."'" );	 */

			}

		if(isset($_SESSION['PeriodeS'])&&($_SESSION['PeriodeS']==1))
			{
				if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) $post_S2="location.etatsortie='OUI' AND compte1.due>0 AND mensuel_fiche1.Periode='".$_SESSION['PeriodeC']."'" ; else $post_S2="location.etatsortie='NON' AND compte1.due<=0 AND mensuel_fiche1.Periode='".$_SESSION['PeriodeC']."'";
			}
			//}else {
				if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) $post="mensuel_fiche1.etatsortie='OUI' AND mensuel_compte.due>0 AND mensuel_fiche1.Periode='".$_SESSION['PeriodeC']."'" ; else $post="mensuel_fiche1.etatsortie='NON' AND mensuel_compte.due<=0 AND mensuel_fiche1.Periode='".$_SESSION['PeriodeC']."'";
			//}
		if(isset($_SESSION['groupe']))
			 $sql="SELECT GrpeTaxation,ttva,ttax,mensuel_compte.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2,
			view_client.nomcli AS nom2, view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif,mensuel_compte.ttc_fixeR,mensuel_compte.ttc_fixe,mensuel_compte.np, mensuel_compte.typeoccup,  mensuel_fiche1.datarriv1,mensuel_compte.nuite,mensuel_compte.somme AS somme
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli AND codegrpe='".$_SESSION['code_reel']."' AND ".$post;
		else
			 $sql="SELECT GrpeTaxation,ttva,ttax,mensuel_compte.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2,
			view_client.nomcli AS nom2, view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.ttc_fixeR,mensuel_compte.ttc_fixe,mensuel_compte.np,mensuel_compte.typeoccup, mensuel_fiche1.datarriv1,mensuel_compte.nuite,mensuel_compte.somme AS somme
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli AND mensuel_fiche1.numfiche='".$_SESSION['num']."' AND ".$post;
			$res=mysqli_query($con,$sql);
		while ($ret=mysqli_fetch_array($res))
			{$num_fiche=$ret['numfiche'];  $num1=$ret['num1']; $nom1=$ret['nom1']; $prenom1=$ret['prenom1']; $num2=$ret['num2'];$nom2=$ret['nom2']; $nomch=$ret['nomch']; $tarif=$ret['tarif'];
			 $tva=$ret['tarif']*$ret['ttva'];
			 $ttc_fixe=$ret['ttc_fixe']; $np=$ret['np']; $taxe=$ret['ttax']; $typeoccup=$ret['typeoccup']; $datarriv1=$ret['datarriv1']; $nuite=$ret['nuite'];$somme=$ret['somme'];//$ttc=$ret['ttc'];
			}
 		$reqsel=mysqli_query($con,"SELECT num_fact,numFactNorm FROM configuration_facture");
		$data=mysqli_fetch_object($reqsel);	$NumFact=NumeroFacture($data->num_fact);  $numFactNorm=NumeroFacture($data->numFactNorm);

		if(isset($_SESSION['cham'])&&($_SESSION['cham']==1)){ 
			if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)){
				if(isset($_SESSION['groupe']))
				//echo "<br/>1-".
				$sql="SELECT GrpeTaxation,ttva,ttax,N_reel,compte.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2,
				view_client.nomcli AS nom2, view_client.prenomcli AS prenom2, chambre.nomch, compte.tarif,compte.ttc_fixeR,compte.ttc_fixe,compte.np,compte.N_reel AS N_reel,compte.typeoccup, fiche1.datarriv1,compte.nuite,compte.somme AS somme
				FROM client, fiche1, chambre, compte, view_client
				WHERE fiche1.numcli_1 = client.numcli
				AND fiche1.numcli_2 = view_client.numcli
				AND trim(fiche1.codegrpe) LIKE '".trim($_SESSION['groupe'])."'
				AND chambre.numch = compte.numch
				AND compte.numfiche = fiche1.numfiche
				AND ".$post0;
				else
				  //echo "<br/>2-".
				$sql="SELECT GrpeTaxation,ttva,ttax,N_reel,compte.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2,
				view_client.nomcli AS nom2, view_client.prenomcli AS prenom2, chambre.nomch, compte.tarif, compte.ttc_fixeR,compte.ttc_fixe,compte.np,compte.N_reel AS N_reel,compte.typeoccup, fiche1.datarriv1,compte.nuite,compte.somme AS somme
				FROM client, fiche1, chambre, compte, view_client
				WHERE fiche1.numcli_1 = client.numcli
				AND fiche1.numcli_2 = view_client.numcli
				AND fiche1.numfiche LIKE '".$_SESSION['num']."'
				AND chambre.numch = compte.numch
				AND compte.numfiche = fiche1.numfiche
				AND ".$post0;
			}
			else 
			{	if(isset($_SESSION['groupe']))
			  //echo "<br/>1-".
				$sql="SELECT GrpeTaxation,ttva,ttax,N_reel,mensuel_compte.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2,
				view_client.nomcli AS nom2, view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif,mensuel_compte.ttc_fixeR,mensuel_compte.ttc_fixe,mensuel_compte.np,mensuel_compte.N_reel AS N_reel,mensuel_compte.typeoccup, mensuel_fiche1.datarriv1,mensuel_compte.nuite,mensuel_compte.somme AS somme
				FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
				WHERE mensuel_fiche1.numcli_1 = client.numcli
				AND mensuel_fiche1.numcli_2 = view_client.numcli
				AND trim(mensuel_fiche1.codegrpe) LIKE '".trim($_SESSION['groupe'])."'
				AND chambre.numch = mensuel_compte.numch
				AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
				AND ".$post0;
				else
				  //echo "<br/>2-".
				$sql="SELECT GrpeTaxation,ttva,ttax,N_reel,mensuel_compte.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2,
				view_client.nomcli AS nom2, view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.ttc_fixeR,mensuel_compte.ttc_fixe,mensuel_compte.np,mensuel_compte.N_reel AS N_reel,mensuel_compte.typeoccup, mensuel_fiche1.datarriv1,mensuel_compte.nuite,mensuel_compte.somme AS somme
				FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
				WHERE mensuel_fiche1.numcli_1 = client.numcli
				AND mensuel_fiche1.numcli_2 = view_client.numcli
				AND mensuel_fiche1.numfiche LIKE '".$_SESSION['num']."'
				AND chambre.numch = mensuel_compte.numch
				AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
				AND ".$post0;
			}

			//echo "<br/>".$sql;
			$result=mysqli_query($con,$sql);
			$data=""; $TotalTva=0;$TotalTaxe=0;  $i=0;
			if (!$result) {
				printf("Error: %s\n", mysqli_error($con));
				exit();
			}
			$TotalHT=0;$productlist=array(); $ListEncaissement=array(); $p=0; $t=0; $MttaxesejourT=0; $montant_ht0=0;  $Tnuite=array();

			while($row=mysqli_fetch_array($result))
			{ if($row['num1']!=$row['num2'])
			   {$numcli=substr($row['num1'],0,5)." | ".substr($row['num2'],0,5);
				$client=substr(strtoupper($row['nom1'])." ".strtoupper($row['prenom1'])." |"." ".strtoupper($row['nom2'])." ".strtoupper($row['prenom2']),0,35);}
			  else
				{ $numcli=$row['num1'];
				  $client=strtoupper($row['nom1'])." ".strtoupper($row['prenom1']);
				 }

			  $nomch=$row['nomch'];  $np=$row['np']; $type=$row['typeoccup'];
				$tarif=$row['ttc_fixe'];  $tarif_1=$row['tarif'];

				if($row['ttc_fixeR']>0) {
					$tarif=$row['ttc_fixeR'];
				}
				else {
					$tarif=$row['ttc_fixe'];
					$tarif_1=$row['tarif'];
				}

				 $N_reel=$row['N_reel'];
				$n=(strtotime($Jour_actuel)-strtotime($row['datarriv1']))/86400;
				$dat=(date('H')+1);
				settype($dat,"integer");
				if ($dat<14){$n=$n;}else {$n= $n+1;}
				if ($n==0){$n= $n+1;}
			 //$nuite=$n;
				 $n_p= $np; //$n_p= $n-$np;
				 if($n_p<=0) $n_p=1; //$n_p=-$np;
				 
				 if(isset($_SESSION['view'])&&($_SESSION['view']==1)) $n_p=$n;   


			if($tarif<=20000) $taxe = 500; else if(($tarif>20000) && ($tarif<=100000))	$taxe = 1500; else $taxe = 2500;

			if(isset($numfichegrpe)&&(!empty($numfichegrpe))&&(isset($_SESSION['impaye']))&&($_SESSION['impaye']==1)) {   //Facture de groupe impayee
				 $Np=$row['N_reel']; $Tnuite[$t]=$row['N_reel']; $t++; //echo 50;
				 
/*  			echo '<pre>';
				print_r($Tnuite);
			echo '</pre>';  */
			 
				 
			}else{
/* 				 $Np=$n;	 // la variabe de session $_SESSION['Nd'] est pour le cas des impayés
				 if(isset($_SESSION['Nd'])&&($_SESSION['Nd']>0)&& is_numeric($_SESSION['Nd'])) {
				 $Np=$_SESSION['Nd']; //unset($_SESSION['Nd']); 
				 }
				 else {	
					 $Np=$n_p;
					}
				$Tnuite[$t]=$Np; $t++; */
				
				//echo $row['numfiche']; 
				
				 $numfiche=$row['numfiche']; 
				
				$Np=$postT[$numfiche];
				
				} 
				
				
			if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) 
				$Nuite_Payee=$row['N_reel'];	
			else $Nuite_Payee=$Np;		
			 
			 echo "<br/>Nuitée = ".$Nuite_Payee;
			 
			if($row['ttc_fixeR']>0) {    //Réduction spéciale sur le prix de la chambre
				$tarif=$row['ttc_fixeR'];
			} else $tarif=$row['ttc_fixe'];
			if($tarif<=20000) $taxe = 500; else if(($tarif>20000) && ($tarif<=100000))	$taxe = 1500; else $taxe = 2500;
			$tarif_1=round(($tarif-$taxe)/$TvaD);

			//$Nuite_Payee=$_SESSION['NuitePayee'];$Np=(int)$Nuite_Payee;
			$Mtotal=$tarif*$Nuite_Payee;   $TotalHT+=$tarif;
			$tarif_2=$tarif_1*$Nuite_Payee;  //$tva=round($TvaD*$tarif_2); $tva*=$Nuite_Payee;
		     $MtSpecial=$taxe; //$TotalTaxe+=$taxe;  $TotalTva+=$tva;
			 $taxei=$taxe; $taxe*=$Nuite_Payee;
			  $MttaxesejourT+=$taxe;
			//$montant_ht=$row['tarif'];  //Ne pas considérer le montant HT car le montant est déjà arrondi depuis le formulaire loccup.php
			if($tarif<=20000) $taxe = 500; else if(($tarif>20000) && ($tarif<=100000))	$taxe = 1500; else $taxe = 2500;
			$montant_ht= ($tarif - $taxe)/(1+$TvaD);
			$tva=0;
			if($row['ttva']!=0)$tva=round($TvaD*$montant_ht); $tva*=$Nuite_Payee;
			$montant_ht*=$Nuite_Payee;  $montant_ht=round($montant_ht);  //Ici on arrondi le montant après avoir multiplier par le total de nuitée

			$Mttaxespe = $taxe; //$Mttaxespe = $taxe/$Nuite_Payee;
			$PrixUnitaireTTC=($Mtotal/$Nuite_Payee);
			//echo "<br/>".$Mttaxespe."<br/>";
			$PrixUnitTTC=$PrixUnitaireTTC-$Mttaxespe;

			$nomch="    CHAMBRE  ".strtoupper($row['nomch']); $nomch0=$nomch;

			 $TypeTxe="B"; $nomch.="  (B)"; //les factures normalisees seront taxables par defaut
			 $TypeFacture=0;  //Changement d'etat au cas ou c'est exoneree
			 if(isset($_SESSION['groupe1']))
			  	$sql_TVA = "SELECT * FROM ExonereTVA WHERE groupe='".$_SESSION['groupe1']."' AND numfiche='".$row['numfiche']."' AND date ='".$Jour_actuel."' AND Exonere='1'";
			 else
			 		$sql_TVA = "SELECT * FROM ExonereTVA WHERE numfiche='".$row['numfiche']."' AND date ='".$Jour_actuel."' AND Exonere='1'";
			 $ras_TVA=mysqli_query($con,$sql_TVA);	$ratT=mysqli_fetch_assoc($ras_TVA);

			 if($row['GrpeTaxation']=='A') $GrpeTaxation='A-EX';else $GrpeTaxation=$row['GrpeTaxation'];
			 $TypeTxe=$row['GrpeTaxation'];
			 if(($ratT['Exonere']==1)||($row['ttva']==0)) {
				 	$TypeFacture=2; $tva=0;
					if($row['ttva']!=0) {
					$Mtotal-=$ratT['ValeurTVA']; //Exonere TVA uniquement
					$PrixUnitTTC/=(1+$TvaD);  $PrixUnitTTC=round($PrixUnitTTC);
					}
					$nomch="    CHAMBRE  ".strtoupper($row['nomch']);

			}else {
					$nomch="    CHAMBRE  ".strtoupper($row['nomch']);
				 }

				 $nomch.="  (".$GrpeTaxation.")";

				if(isset($_SESSION['groupe1']))
					{
						$sqlT = "SELECT * FROM Applyaib WHERE groupe='".$_SESSION['groupe1']."' AND date ='".$Jour_actuel."' AND apply='1'";
						if(isset($_SESSION['Fconnexe'])&&($_SESSION['Fconnexe']>0))
						$sql_Connexe="SELECT * FROM fraisconnexe WHERE numfiche='".$_SESSION['groupe1']."' AND Ferme='NON'";
					}
				else
					{
						$sqlT = "SELECT * FROM Applyaib WHERE numfiche='".$row['numfiche']."' AND date ='".$Jour_actuel."' AND apply='1'";
						if(isset($_SESSION['Fconnexe'])&&($_SESSION['Fconnexe']>0))
						$sql_Connexe="SELECT * FROM fraisconnexe WHERE numfiche='".$row['numfiche']."' AND Ferme='NON'";
					}

				$rasT=mysqli_query($con,$sqlT);	$ratT=mysqli_fetch_assoc($rasT);
				if($ratT['apply']==1) {
				 $Aib_duclient="AIB".$ratT['Pourcentage'];
				 if($TypeFacture==2) $TypeFacture=5;  //AIB applicable TVA Exoneré
				 else $TypeFacture=4; //AIB applicable
			 }else $Aib_duclient="";

			if(isset($_SESSION['pourcent'])&&($_SESSION['pourcent']>0)){
				echo $PrixUnitTTC=$tarif-$taxe; //Exple : 8500-500;
				$PrixUnitTTC/=(1+$TvaD);
				echo "<br/>".$PrixUnitTTC=round($PrixUnitTTC);
				//$montant_ht=$PrixUnitTTC;
				echo "<br/>".$remise = $PrixUnitTTC*($_SESSION['pourcent']/100);
				echo "<br/>".$netC = $PrixUnitTTC - $remise ;
				echo "<br/>".$tvAi = round($netC*$TvaD);
				echo "<br/>".$NeTaPayer = $netC + $tvAi+$taxe;
				$tva+=$tvAi;
				echo "<br/>".$PrixUnitTTC = round($NeTaPayer) ;
				$_SESSION['end'] = "(".$_SESSION['pourcent']." %)";

			} //else {
			//echo "<br/>".
			//$montant_ht0+=$montant_ht;
			//}

			 $List=array(
				"DESIGNPROD" => "HEBERGEMENT CHAMBRE ".strtoupper($nomch0),
				"LTAXE" => $TypeTxe,
				"PRIXUNITTTC" => $PrixUnitTTC ,
				"MTTAXESPE" => "" ,
				"QUANTITE" => $Np,
				"DESCTAXESPE" => "",
			  );
				array_push($productlist,$List);

				//$RegimeTVA=isset($_SESSION['RegimeTVA'])?$_SESSION['RegimeTVA']:$RegimeTVA;
				
				//echo $_SESSION['serveurused'];

				if($_SESSION['serveurused']=="emecef")
					{	//$client=isset($_SESSION['client'])?$_SESSION['client']:$_SESSION['groupe'];
						$taxSpecific=0;//$RegimeTVA=0;
						echo "<br/>1-".
						$insert="INSERT INTO produitsencours SET Num=NULL,SIGNATURE_MCF='',Client='".$client."', LigneCde ='".$nomch0."',prix ='".$PrixUnitTTC."',qte ='".$Np."',Etat='4',GrpeTaxation='".$TypeTxe."',taxSpecific='".$taxSpecific."',RegimeTVA='".$RegimeTVA."',Type=1";
						echo "<br/>-------------";
						if(isset($_SESSION['view'])&&($_SESSION['view']==0))
							$insertOK=mysqli_query($con,$insert); 
					}

			 $taxeDeSejourT=$taxei*$Nuite_Payee;
			 //echo "<br/>".$Nuite_Payee."<br/>";
			 $TotalTva+=$tva; $TotalTaxe+=$taxeDeSejourT;   //$Mtotal=$montantHT+$tva+$taxe; //

			 $Mtotal=$montant_ht+$tva+$taxei;   //$clientN="        ".$client;

			  if($GrpeTaxation=='E')
			 		{$PrixUnitaireTTC = (int) ($tarif);   //Mode TPS
					 $Mtotali=$PrixUnitaireTTC*$Nuite_Payee;
					 //$montant_ht0+=$PrixUnitaireTTC-$taxei;
					 $PUnitaire=($PrixUnitaireTTC-$taxei)*$Nuite_Payee;
					 $montant_ht0+=$PUnitaire;
					}
			 else
			 		{
						$PrixUnitaireTTC = (int) ($Mtotal/$Nuite_Payee);
						$montant_ht0+=$montant_ht;
					}

			//if(isset($_POST['exonorer_tva']) && ($_POST['exonorer_tva']==1)) $tva=0;
			$ecrire=fopen('txt/facture.txt',"w");
			$data.=$numcli.';'.$client.';'.$nomch.';'.$PrixUnitaireTTC.';'.$Nuite_Payee.';'.$Mtotali."\n";
			$ecrire2=fopen('txt/facture.txt',"a+");
			fputs($ecrire2,$data);

			$type=0;

			if($RegimeTVA==0) $nomch.="  (E)"; else if($row['ttva']==0) {$type=1; $nomch.="  (A-EX)";	} else { $type=2; $nomch.="  (B)";}

			//if(isset($_SESSION['groupe'])) $_SESSION['client']=$client;	//$_SESSION['client']=$client;  $_SESSION['cli']

			$recu=substr($NumFact, 0, -3);$heure=$Heure_actuelle;	 	//$Mttc+=$ttc_fixe;

			$nomch=$row['nomch'];
			//$np=$row['np'];
			$np=$Nuite_Payee;  $type=$row['typeoccup'];
			if($row['ttc_fixeR']>0) {   //Réduction spéciale sur le prix de la chambre
				$ttc_fixe=$row['ttc_fixeR'];
				if($row['ttc_fixeR']<=20000) $taxe = 500; else if(($row['ttc_fixeR']>20000) && ($row['ttc_fixeR']<=100000))	$taxe = 1500; else $taxe = 2500;
				$tarif=($row['ttc_fixeR']-$taxe)/$TvaD;
			}
			else {
				$ttc_fixe=$row['ttc_fixe'];
				$tarif=$row['tarif'];
			}
			 $numfiche=$row['numfiche'];

			$req="SELECT numch,typech,GrpeTaxation,RegimeTVA  FROM chambre WHERE nomch='".$nomch."'";
			$sqlB=mysqli_query($con,$req);
			while($rowB=mysqli_fetch_array($sqlB))
			{ $numch=$rowB['numch'];
			  $typech=$rowB['typech']; $GrpeTaxation=$rowB['GrpeTaxation'];
				$RegimeTVAi=$rowB['RegimeTVA'];//if($typech=="V") $typech="Ventillee";if($typech=="CL") $typech="Climatisee";
			}
			if(isset($_SESSION['cham'])&&($_SESSION['cham']==1)) { //echo 25;
				if($np!=0)
				{	$avc=$ttc_fixe*$np; $ttc_fixe2=$ttc_fixe;

					if(isset($_SESSION['groupe1']))
						 $sql_TVA2 = "SELECT * FROM ExonereTVA WHERE groupe='".$_SESSION['groupe1']."' AND numfiche='".$numfiche."' AND date ='".$Jour_actuel."' AND Exonere='1'";
					else
						 $sql_TVA2 = "SELECT * FROM ExonereTVA WHERE numfiche='".$numfiche."' AND date ='".$Jour_actuel."' AND Exonere='1'";
						 $ValeurTVA2=0;$ras_TVA2=mysqli_query($con,$sql_TVA2);
						 $ratT2=mysqli_fetch_assoc($ras_TVA2);
						 $ttc_fixe2=$ttc_fixe-$ratT2['ValeurTVA'];  //Ici on fait le cummul des TVA pour un groupe.

					if(isset($_SESSION['Normalise'])) { $NumFact=$numFactNorm;$TypeF=3;} else $TypeF=2;  //$tarif2=$ttc_fixe2/$np;
					$query="INSERT INTO reeditionfacture2 VALUES (NULL,'".$TypeF."','".$NumFact."','".$numfiche."','".$numch."','".$typech."','".$TypeFacture."','".$GrpeTaxation."','".$type."','".round($tarif)."','".$np."','".$RegimeTVAi."','".$ttc_fixe2."')";
					if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $tu=mysqli_query($con,$query);

					if(!isset($_SESSION['fiche'])){
					if(isset($_SESSION['retro'])&& ($_SESSION['retro']==1)) $np=$_SESSION['Nuitep'];
					$pos="VALUES (NULL,'".$Jour_actuel."','".$Heure_actuelle."','".$numfiche."','".$avc."','".$_SESSION['login']."','".$typeEncaisse."','".$numch."','".$type."','".$tarif_1."','".$ttc_fixe2."','".$np."')";
					$sql1="INSERT INTO mensuel_encaissement ".$pos; $sql2="INSERT INTO encaissement ".$pos;
					if(isset($_SESSION['updateBD'])&&($_SESSION['updateBD']==1)&&($np>0)&&(isset($_SESSION['view'])&&($_SESSION['view']==0)))
						{$en=mysqli_query($con,$sql1);$en=mysqli_query($con,$sql2);
						}

						$select=mysqli_query($con,"SELECT  max(num_encaisse) AS num_encaisse FROM encaissement");
						$datap=mysqli_fetch_object($select); 
						$ListEncaissement[$p]=$datap->num_encaisse;  $p++;//Mettre en session les numeros des encaissement en vue de faire un eventuel roolback
					}
				}
			}
		}
		//if(isset($_SESSION['impaye']))
/* 		{
			$Tempon=$Tnuite[0];
			for($i=0;$i<count($Tnuite);$i++){
				//if($Tempon>$Tnuite[$i])
					//echo $Tnuite[$i];
			} 	
		} */
		//echo "<br/>". max($Tnuite);
		
		$client=isset($_SESSION['client'])?$_SESSION['client']:NULL;  
		$client=isset($_SESSION['groupe'])?$_SESSION['groupe']:NULL;
		$_SESSION['client']=$client;

		if(isset($_SESSION['cham'])&&($_SESSION['cham']==1)) {
		$List=array(
			"DESIGNPROD" => "TAXE DE SEJOUR",
			"LTAXE" => "F",
			"PRIXUNITTTC" => $MttaxesejourT ,
			"MTTAXESPE" => "" ,
			"QUANTITE" => 1,
			"DESCTAXESPE" => "",
			);

			array_push($productlist,$List);  //Ici on insère la taxe de séjour

			if($_SESSION['serveurused']=="emecef")
				{	$taxSpecific=0;$LigneCde="TAXE DE SEJOUR";$PrixUnitTTC=$MttaxesejourT;$Np=1;$TypeTxe="F";
					//echo "<br/><br/>".
					$insert="INSERT INTO produitsencours SET Num=NULL,SIGNATURE_MCF='',Client='".$client."', LigneCde ='".$LigneCde."',prix ='".$PrixUnitTTC."',qte ='".$Np."',Etat='4',GrpeTaxation='".$TypeTxe."',taxSpecific='".$taxSpecific."',RegimeTVA='".$RegimeTVA."',Type=1";
					if(isset($_SESSION['view'])&&($_SESSION['view']==0))
						$insertOK=mysqli_query($con,$insert);
				}

			if(isset($_SESSION['Fconnexe'])&&($_SESSION['Fconnexe']>0))
				{
					//$numfichep=isset($_SESSION['code_reel'])?$_SESSION['code_reel']:$_SESSION['num'];
					$taxSpecific=0; $Ttotal=0; $HT_connexe=0;
					
					if(isset($_SESSION['code_reel']))
					{	$sql3="SELECT DISTINCT fraisconnexe.numfiche AS numfiche FROM mensuel_fiche1,fraisconnexe WHERE fraisconnexe.numfiche=mensuel_fiche1.numfiche AND mensuel_fiche1.numfichegrpe='".$_SESSION['code_reel']."' AND etatsortie='NON'";
						$req3 = mysqli_query($con,$sql3) or die (mysqli_error($con));
						$k=0;$ListeDesFiches = array();
						if(mysqli_num_rows($req3)>0) {
							while ($dataS= mysqli_fetch_array($req3))
								{  $ListeDesFiches[$k]=$dataS['numfiche'];$k++;
								}
						}	
					
					for($k=0;$k<count($ListeDesFiches);$k++){
					$sql_Connexe="SELECT * FROM fraisconnexe WHERE numfiche='".$ListeDesFiches[$k]."' AND Ferme='NON'";
					//$sql_Connexe="SELECT * FROM fraisconnexe WHERE numfiche='".$numfichep."' AND Ferme='NON'";
					$s=mysqli_query($con,$sql_Connexe);
					if($nbreresult=mysqli_num_rows($s)>0)
					{	while($retA=mysqli_fetch_array($s))
							{ 		$designation=ucfirst($retA['code']);
									$Qte =$retA['NbreUnites'];
									$PrixUnitTTC =$retA['PrixUnitaire'];
									$NbreUnites =$retA['NbreUnites']; 
									$Mtotalp=$PrixUnitTTC*$Qte;
									$Ttotal+=$Mtotalp; $montant_ht0+=$Mtotalp;
									$HT_connexe +=  $Mtotalp/1.18;  $clienti=""; $GrpeTaxation=$retA['GrpeTaxation'];
									//echo "<br/><br/>".
									$insert="INSERT INTO produitsencours SET Num=NULL,SIGNATURE_MCF='',Client='".$client."', LigneCde ='".$designation."',prix ='".$PrixUnitTTC."',qte ='".$Qte."',Etat='4',GrpeTaxation='".$GrpeTaxation."',taxSpecific='".$taxSpecific."',RegimeTVA='".$RegimeTVA."',Type=1";
									$insertOK=mysqli_query($con,$insert);

									$update="UPDATE fraisconnexe SET Ferme='OUI' WHERE numfiche='".$ListeDesFiches[$k]."'";
									if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $updateOK=mysqli_query($con,$update);
								
									$ecrire=fopen('txt/facture.txt',"w"); $designation.=" (".$GrpeTaxation.")";
									$numclip=isset($numcli)?$numcli:NULL;
									$data.=$numclip.';'.$clienti.';'.$designation.';'.$PrixUnitTTC.';'.$Qte.';'.$Mtotalp."\n";
									$ecrire2=fopen('txt/facture.txt',"a+");
									fputs($ecrire2,$data);
							}
						} 
					}					
				}
				else {
					$sql3="SELECT fiche1.numfiche AS numfiche,GrpeTaxation,id,code,NbreUnites,PrixUnitaire FROM fiche1,fraisconnexe WHERE fraisconnexe.numfiche = fiche1.numfiche  AND fiche1.numfiche='".$_SESSION['num']."' AND fraisconnexe.Ferme='NON'";
					$req3 = mysqli_query($con,$sql3) or die (mysqli_error($con));
						if(mysqli_num_rows($req3)>0){ 
						while ($retA= mysqli_fetch_array($req3))
							{  	
								$designation=ucfirst($retA['code']);
								$Qte =$retA['NbreUnites'];
								$PrixUnitTTC =$retA['PrixUnitaire'];
								$NbreUnites =$retA['NbreUnites']; 
								$Mtotalp=$PrixUnitTTC*$Qte;
								$Ttotal+=$Mtotalp; $montant_ht0+=$Mtotalp;
								$HT_connexe +=  $Mtotalp/1.18;  $clienti=""; $GrpeTaxation=$retA['GrpeTaxation'];

								//echo "<br/><br/>".
								$insert="INSERT INTO produitsencours SET Num=NULL,SIGNATURE_MCF='',Client='".$client."', LigneCde ='".$designation."',prix ='".$PrixUnitTTC."',qte ='".$Qte."',Etat='4',GrpeTaxation='".$GrpeTaxation."',taxSpecific='".$taxSpecific."',RegimeTVA='".$RegimeTVA."',Type=1";
								if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $insertOK=mysqli_query($con,$insert);
								
								$update="UPDATE fraisconnexe SET Ferme='OUI' WHERE numfiche='".$retA['numfiche']."'";
								if(isset($_SESSION['view'])&&($_SESSION['view']==0)) $updateOK=mysqli_query($con,$update);

								$ecrire=fopen('txt/facture.txt',"w"); $designation.=" (".$GrpeTaxation.")";
								$numclip=isset($numcli)?$numcli:NULL;
								$data.=$numclip.';'.$clienti.';'.$designation.';'.$PrixUnitTTC.';'.$Qte.';'.$Mtotalp."\n";
								$ecrire2=fopen('txt/facture.txt',"a+");
								fputs($ecrire2,$data);
							}
						}	
				}									
					$_SESSION['HT_connexe'] =	round($HT_connexe);
			}
		}
			$_SESSION['ListEncaissement']=$ListEncaissement;		$_SESSION['Listcompte']=$Listcompte;

			if(isset($_SESSION['groupe']))
				 $_SESSION['groupe'];
			else if(isset($_SESSION['cli']))
				 $_SESSION['client']=$_SESSION['cli'] ;
			else
				 $_SESSION['client']=$client ;

			if(isset($_SESSION['N'])&&($_SESSION['N']>0)) $n=$_SESSION['N']; else  $n=$_SESSION['NuitePayee'];

		  $_SESSION['TotalHT'] = $montant_ht0; //$TotalHT = $n*$TotalHT;
			$_SESSION['TotalTva'] = $TotalTva;  //$TotalTva = $n*$TotalTva;
			$_SESSION['TotalTaxe'] = $TotalTaxe; //$TotalTaxe= $n*$TotalTaxe;

			//echo $TotalHT; ;

			if((isset($_POST['defalquer_impaye'])) && ($_POST['defalquer_impaye']==1))
			{
			}else{ //$N_reel=0;
			if(isset($_SESSION['groupe']))
				  $sql="SELECT max(mensuel_compte.N_reel) AS N_reel,etatsortie FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.codegrpe='".$_SESSION['groupe']."' AND ".$post_0;
			else
				  $sql="SELECT mensuel_compte.N_reel AS N_reel,etatsortie FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.numfiche='".$_SESSION['num']."' AND ".$post0;
			$res1=mysqli_query($con,$sql); 
				while ($ret=mysqli_fetch_array($res1))
				{	$N_reel=$ret['N_reel'];
						/* if ($np>$N_reel)
						{$N_reel=$np;
						} Commentaire du 29.10.2020 */
						if ($n>$N_reel)
						{$N_reel=$n;
						}
				} if(!isset($_SESSION['fiche'])){  if((!empty($np_1))&&($np_1>0)) $N_reel-=$np_1; }  //max($Tnuite)  echo $N_reel;

			if(isset($N_reel)&& ($N_reel>0))
			 {  echo "<br/>".
				 $N_reel=max($postT); 
				if($_SESSION['debut']==$Date_actuel2) $N_reel-=1; //Ce cas survient lorsque le client est venu entre 00h et 12h. Cas à revoir. Commentaire du 14_04_2022
				 $_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$N_reel,date($ans)));
				 $_SESSION['finp']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$N_reel,date($ans)));
			}

			if(isset($_SESSION['debut'])&&(isset($_SESSION['fin']))){
				//if($_SESSION['debut']==$_SESSION['fin'])  echo $_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)-1,date($ans)));
			}
			if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) {
				if(isset($_SESSION['groupe1']))
					$query="SELECT MAX(N_reel) AS N_reelx, fiche1.heuresortie,fiche1.etatsortie,compte.date,compte.numfiche AS numfiche,compte.np as NuiteP, compte.somme AS SommeP,compte.ttc_fixe, compte.N_reel,fiche1.datarriv1
					FROM client, fiche1, chambre, compte, view_client
					WHERE fiche1.numcli_1 = client.numcli
					AND fiche1.numcli_2 = view_client.numcli
					AND fiche1.codegrpe = '".$_SESSION['groupe1']."'
					AND chambre.numch = compte.numch
					AND compte.numfiche = fiche1.numfiche
					AND ".$post0;
					else
						echo "<br/>".$query="SELECT MAX(N_reel) AS N_reelx, fiche1.heuresortie,fiche1.etatsortie,compte.date,compte.numfiche AS numfiche,compte.np as NuiteP, compte.somme AS SommeP,compte.ttc_fixe, compte.N_reel,fiche1.datarriv1
					FROM client, fiche1, chambre, compte, view_client
					WHERE fiche1.numcli_1 = client.numcli
					AND fiche1.numcli_2 = view_client.numcli
					AND fiche1.numfiche = '".$_SESSION['num']."'
					AND chambre.numch = compte.numch
					AND compte.numfiche = fiche1.numfiche
					AND ".$post0;
	
			}
			else {
				if(isset($_SESSION['groupe1']))
					$query="SELECT MAX(N_reel) AS N_reelx, mensuel_fiche1.heuresortie,mensuel_fiche1.etatsortie,mensuel_compte.date,mensuel_compte.numfiche AS numfiche,mensuel_compte.np as NuiteP, mensuel_compte.somme AS SommeP,mensuel_compte.ttc_fixe, mensuel_compte.N_reel,mensuel_fiche1.datarriv1
				FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
				WHERE mensuel_fiche1.numcli_1 = client.numcli
				AND mensuel_fiche1.numcli_2 = view_client.numcli
				AND mensuel_fiche1.codegrpe = '".$_SESSION['groupe1']."'
				AND chambre.numch = mensuel_compte.numch
				AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
				AND ".$post0;
				else
					echo "<br/>".$query="SELECT MAX(N_reel) AS N_reelx, mensuel_fiche1.heuresortie,mensuel_fiche1.etatsortie,mensuel_compte.date,mensuel_compte.numfiche AS numfiche,mensuel_compte.np as NuiteP, mensuel_compte.somme AS SommeP,mensuel_compte.ttc_fixe, mensuel_compte.N_reel,mensuel_fiche1.datarriv1
				FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
				WHERE mensuel_fiche1.numcli_1 = client.numcli
				AND mensuel_fiche1.numcli_2 = view_client.numcli
				AND mensuel_fiche1.numfiche = '".$_SESSION['num']."'
				AND chambre.numch = mensuel_compte.numch
				AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
				AND ".$post0;
			}
			$sql3=mysqli_query($con,$query);
			$i=0; $nombre=array(""); $t=0; $TFin=array(); $N_reel=max($postT);  
			while($row_1=mysqli_fetch_array($sql3))
			{ $nombre= $row_1['numfiche'];   $NuiteP= $row_1['NuiteP'];  $heuresortie=$row_1['heuresortie'];
			    //if(isset($numfichegrpe)&&(!empty($numfichegrpe)))  //Le cas d'un groupe
					if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)){
						if($row_1['etatsortie']=='OUI')
							{			
									$N_reel=$row_1['N_reelx'];
									if($_SESSION['debut']==$Date_actuel2) $N_reel-=1; 				
									if(!empty($row_1['date'])){
										 	$ans=substr($row_1['date'],6,4);
										    $mois=substr($row_1['date'],3,2);
											$jour=substr($row_1['date'],0,2);
											//echo "<br/>".
											$_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$N_reel,date($ans)));
											//$_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$NuiteP,date($ans)));
									}
									else { 
											 $ans=substr($row_1['datarriv1'],0,4);
											 $mois=substr($row_1['datarriv1'],5,2);
											 $jour=substr($row_1['datarriv1'],8,2);
											 $_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$N_reel,date($ans)));
									}
									$TFin[$t]=$_SESSION['fin']; $t++;
								}	
								
						}else					
					//if(!isset($_SESSION['fin']))
					//echo "<br/>".
					$_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$NuiteP,date($ans)));
					
					echo "<br/>".$_SESSION['fin'];
					
					//echo "<br/>".$_SESSION['impaye'];
				 //echo "<br/>".$_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+$NuiteP,date($ans)));
				 //$req="UPDATE mensuel_compte SET date='".$NuiteP."' WHERE numfiche='".$nombre."'";
				 
				if(isset($_SESSION['cham'])){
					 if($_SESSION['debut']==$_SESSION['fin']){
						 $ans=substr($_SESSION['fin'],6,4); $mois=substr($_SESSION['fin'],3,2); $jour=substr($_SESSION['fin'],0,2);
						 if((substr($heuresortie,0,2)>=00)&&(substr($heuresortie,0,2)<=07) )
						 {		 $_SESSION['debut']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)-1,date($ans)));
						 }else {
								$_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)+1,date($ans)));
						 }
					 }
				}
				
	 

				 if(isset($_SESSION['fin']))
				 {  
					if(isset($_SESSION['view'])&&($_SESSION['view']==0))
						{	$req="UPDATE mensuel_compte SET date='".$_SESSION['fin']."' WHERE numfiche='".$nombre."'";
							$req=mysqli_query($con,$req);
							$req="UPDATE compte SET date='".$_SESSION['fin']."' WHERE numfiche='".$nombre."'";
							if($_SESSION['serveurused']=="emecef")  $req=mysqli_query($con,$req);
							
							$Dsortie= substr($_SESSION['fin'],6,4).'-'.substr($_SESSION['fin'],3,2).'-'.substr($_SESSION['fin'],0,2);
							$query="UPDATE location SET datsortie='".$Dsortie."' WHERE numfiche= '".$nombre."'";
							$update=mysqli_query($con,$query);
						}
				 }

				 //$_SESSION['compte2']="UPDATE compte SET date='".$_SESSION['finp']."' WHERE numfiche='".$nombre."'";
				 //$_SESSION['mensuel_compte2']="UPDATE mensuel_compte SET date='".$_SESSION['finp']."' WHERE numfiche='".$nombre."'";

			//$other=mysqli_query($con,"SELECT * FROM etat_facture WHERE numero_fiche='".$nombre."'");$nbre_other=mysqli_num_rows($other);
			//if($nbre_other==0) {$soustraire=1;$req=mysqli_query($con,"INSERT INTO etat_facture (`numero_fiche` ,`nbre_nuite`)VALUES ('".$nombre."', '$NuiteP')");}
			//else $update=mysqli_query($con,"UPDATE etat_facture SET nbre_nuite=$NuiteP WHERE numero_fiche='".$nombre."'");
			   $i++;  	//echo $_SESSION['debut'];
			}  	
			
			//if(isset($TFin)) echo max($TFin[0]);
			
			//echo $_SESSION['fin'];	
			
			$ans0=substr($_SESSION['fin'],6,4); $mois0=substr($_SESSION['fin'],3,2); $jour0=substr($_SESSION['fin'],0,2);
			if($_SESSION['debut']==$_SESSION['fin']) 
			$_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois0),date($jour0)+1,date($ans0)));				
									 
			
		}
		if(isset($_SESSION['groupe']))
		$query="SELECT mensuel_compte.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2,
		view_client.nomcli AS nom2, view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif,mensuel_compte.ttc_fixe,mensuel_compte.np,mensuel_compte.typeoccup,mensuel_fiche1.datarriv1,mensuel_compte.nuite,mensuel_compte.somme AS somme
		FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client WHERE mensuel_fiche1.numcli_1 = client.numcli
		AND mensuel_fiche1.numcli_2 = view_client.numcli AND codegrpe='".$_SESSION['groupe']."' AND ".$post;
		else
		$query="SELECT mensuel_compte.numfiche AS numfiche,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2,
		view_client.nomcli AS nom2, view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif,mensuel_compte.ttc_fixe,mensuel_compte.np, mensuel_compte.typeoccup,mensuel_fiche1.datarriv1,mensuel_compte.nuite,mensuel_compte.somme AS somme
		FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client WHERE mensuel_fiche1.numcli_1 = client.numcli
		AND mensuel_fiche1.numcli_2 = view_client.numcli AND mensuel_fiche1.numfiche='".$_SESSION['num']."' AND ".$post;

 		$sql=mysqli_query($con,$query);
		while($row=mysqli_fetch_array($sql))
			{ if($row['num1']!=$row['num2'])
			   {  $numcli=$row['num1']." | ".$row['num2'];$clientN=strtoupper($row['nom1'])." ".strtoupper($row['prenom1']);
				  $client=substr(strtoupper($row['nom1'])." ".strtoupper($row['prenom1'])." |"." ".strtoupper($row['nom2'])." ".strtoupper($row['prenom2']),0,30);}
			  else
				{ $numcli=$row['num1'];
				  $client=strtoupper($row['nom1'])." ".strtoupper($row['prenom1']);$clientN=strtoupper($row['nom1'])." ".strtoupper($row['prenom1']);
				 }
			 }

		//if(($_SESSION['Mtotal']< $_SESSION['avanceA'])&&($_SESSION['modulo'] > 0))
			

		//if(empty($_SESSION['modulo'])) $_SESSION['modulo']=0;
		if(empty($_SESSION['avanceA'])) $_SESSION['avanceA']=0;
		//$_SESSION['Mtotal']=isset($_SESSION['groupe'])?$_SESSION['Mtotal']:$_SESSION['edit26'];
		//if(!isset($_SESSION['Fconnexe']))
		$Mtotal= $_SESSION['Mtotal']-$_SESSION['arrhes'];$avanceA = $_SESSION['avanceA'];

		if($_SESSION['modulo'] >= 0)
		{ //$Mtotal= $_SESSION['avanceA'] - $_SESSION['modulo']; $avanceA = $_SESSION['avanceA']+ $_SESSION['modulo'];

		}
		//else if($_SESSION['modulo'] == 0 ) { //$Mtotal= $_SESSION['avanceA'] ; $avanceA = $_SESSION['avanceA'];
		//}
		else {  $avanceA = $_SESSION['avanceA'] + $_SESSION['modulo']; //$Mtotal= $_SESSION['Mtotal'] ;
		}

		if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) {
			$_SESSION['modulo']=0;
			//$_SESSION['Mtotal']=$_SESSION['avanceA'];
		}

		if(isset($_SESSION['groupe']))
		 $query="SELECT MAX(numrecu) AS  numrecu FROM reedition_facture WHERE nom_client= '".$_SESSION['groupe']."'";
		else
		 $query="SELECT MAX(numrecu) AS  numrecu FROM reedition_facture WHERE nom_client= '".$_SESSION['client']."'";
		$Result=mysqli_query($con,$query);$data=mysqli_fetch_object($Result); $numrecu=$data->numrecu;

		if(isset($numrecu)&&!empty($numrecu))
			{$query="UPDATE reedition_facture SET num_facture='".$NumFact."' WHERE numrecu= '".$numrecu."'";
			$update=mysqli_query($con,$query);
			}
		$NumFact1=0;$NumFactN=0;

		if(isset($_SESSION['Normalise'])) { $NumFactN=$numFactNorm;$_SESSION['initial_fiche']=$numFactNorm; } else { $NumFact1=$NumFact; $_SESSION['initial_fiche']=$NumFact;}

		if(isset($_SESSION['groupe1']))
			 $sql_TVA = "SELECT * FROM ExonereTVA WHERE groupe='".$_SESSION['groupe1']."' AND numfiche='".$row['numfiche']."' AND date ='".$Jour_actuel."' AND Exonere='1'";
		else
			 $sql_TVA = "SELECT * FROM ExonereTVA WHERE numfiche='".$row['numfiche']."' AND date ='".$Jour_actuel."' AND Exonere='1'";
		$ras_TVA=mysqli_query($con,$sql_TVA);
		//if($ras_TVA['Exonere']==1) {
			$ValeurTVA=0;
			while($ratT=mysqli_fetch_array($ras_TVA)){
					$ValeurTVA+=$ratT['ValeurTVA'];  //Ici on fait le cummul des TVA pour un groupe.
			}
			 $avanceA-=$ratT['ValeurTVA'];
		//}

		//$_SESSION['TotalTTC'] = $Mtotal;
		$remise=!empty($_SESSION['remise'])?$_SESSION['remise']:0;

		$ValAIB=isset($_SESSION['ValAIB'])?$_SESSION['ValAIB']:0;
			if(isset($_SESSION['impaye']))
			$_SESSION['Tttc_fixe'] =  $_SESSION['Mtotal'];
		else
			$_SESSION['Tttc_fixe']=$Tttc_fixe+$ValAIB;

		if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1))
		{unset($_SESSION['retro']);$objet='Facture impayée';}else $objet='Hébergement';

		if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) $_SESSION['retro']=1;
			$client=isset($_SESSION['client'])?$_SESSION['client']:$_SESSION['groupe'];
		$Tps=$RegimeTVA;

		if(isset($_SESSION['cham'])&&($_SESSION['cham']==1)){
			
		if(!isset($_SESSION['solde'])||($_SESSION['solde']!=1)) ;$avanceA=0;
							  
		if(isset($_SESSION['retro'])&& ($_SESSION['retro']==1))
			{$state=1;
				 //echo "<br/>1-".
			if(isset($_SESSION['view'])&&($_SESSION['view']==0)){		  
				$query="INSERT INTO reedition_facture VALUES (NULL,'".$state."','".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['login']."','0','".$NumFact1."','".$NumFactN."','0','".$client."','".$objet."','".$_SESSION['debut']."','".$_SESSION['fin']."','".$TotalTaxe."','".$TotalTva."','".$_SESSION['Tttc_fixe']."','".$remise."','".$_SESSION['modulo']."','".$avanceA."','".$Tps."')";
				 $tu=mysqli_query($con,$query); $avanceA=$_SESSION['sommePayee']; $state=2; // ici $avanceA a changé de valeur pour la suite
				if($_SESSION['sommePayee']>0) {
					  $query="INSERT INTO reedition_facture VALUES (NULL,'".$state."','".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['login']."','0','".$NumFact1."','".$NumFactN."','0','".$client."','".$objet."','".$_SESSION['debut']."','".$_SESSION['fin']."','".$TotalTaxe."','".$TotalTva."','".$_SESSION['Tttc_fixe']."','".$remise."','".$_SESSION['modulo']."','".$avanceA."','".$Tps."')";
				$tu=mysqli_query($con,$query);}
				}
			}
		else
		{	$state=0; 		if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)) $state=2;
		 if(isset($_SESSION['fin'])) {
			//echo "<br/>".
			$query="INSERT INTO reedition_facture VALUES (NULL,'".$state."','".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['login']."','0','".$NumFact1."','".$NumFactN."','0','".$client."','".$objet."','".$_SESSION['debut']."','".$_SESSION['fin']."','".$TotalTaxe."','".$TotalTva."','".$_SESSION['Tttc_fixe']."','".$remise."','".$_SESSION['modulo']."','".$avanceA."','".$Tps."')";
			if(isset($_SESSION['view'])&&($_SESSION['view']==0))
				$tu=mysqli_query($con,$query);}
		}
		}

		if($_SESSION['Tttc_fixe']!=$_SESSION['avanceA']) $_SESSION['ANNULER']=1;else $_SESSION['ANNULER']=0;

		 //$rit=mysqli_query($con,'UPDATE utilisateur SET montant_encaisse=montant_encaisse+"'.$avanceA.'" WHERE login="'.$_SESSION['login'].'"');
		//$_SESSION['Mtotal']=isset($_SESSION['somme'])?$_SESSION['somme']:$_SESSION['edit26'];

		if(isset($_SESSION['groupe1'])&&(!empty($_SESSION['groupe1'])))
			$sql = "SELECT NumIFU,adressegrpe AS adresse,contactgrpe AS TelClt,email AS Email FROM groupe WHERE  codegrpe = '".trim($_SESSION['groupe'])."'";
		else
			$sql = "SELECT nomcli,prenomcli,NumIFU,adresse,Telephone AS TelClt,Email AS Email  FROM client WHERE numcli LIKE '".trim($_SESSION['Numclt'])."'";

			$res = mysqli_query($con, $sql) or die (mysqli_error($con));
			$data =  mysqli_fetch_assoc($res);	$_SESSION['NumIFU']=$data['NumIFU']; $_SESSION['AdresseClt']=$data['adresse'];
/* 			if(isset($data['nomcli']))
				{   $client=strtoupper($row['nomcli'])." ".strtoupper($row['prenomcli']);
				} */
				$_SESSION['TelClt']=$data['TelClt'];
				$_SESSION['EmailClt']=isset($data['EmailClt'])?$data['EmailClt']:NULL;

				//$_SESSION['client']=$client;



				//}
/* 			else {
				$TelClt="Tel : ";$EmailClt="Email : ";
			}  */
			$_SESSION['numFactN']=$NumFactN;
		}


		if((isset($_SESSION['PeriodeS'])&&($_SESSION['PeriodeS']==1))||(isset($_SESSION['Fusion0K'])&&($_SESSION['Fusion0K']==2))) 
			include('CheckingOKS2.php');  //Traitement spécial pour Location de Salle

	if(isset($_SESSION['cham'])&&($_SESSION['cham']==1)){ //echo "<br/>8588".$_SESSION['impaye'];
		if((isset($_POST['exonorer_tva']))||(isset($_POST['exonerer_AIB'])))
			{ header('location:facture_de_groupe1.php');
			}
		else
			{     if(((isset($_SESSION['ANNULER']))&&($_SESSION['ANNULER']==0)&&($_SESSION['verrou']==0))||(isset($_SESSION['view'])) || (($_SESSION['NormSencaisser']==1)&&(isset($_SESSION['impaye']))))  //Vérifier
						{	if($_SESSION['serveurused']=="mecef")
									include 'others/GenerateMecefBill.php';
								else{
									if(!isset($_SESSION['button_checkbox_2'])){
										//if(empty($_SESSION['PeriodeS']))
										{
											echo "<br/>".$_SESSION['debut']."<br/>".$_SESSION['fin'];
											
											//|| (($_SESSION['NormSencaisser']==1)&&(isset($_SESSION['impaye']))
											if(isset($_SESSION['view'])&&($_SESSION['view']==0)){
												//if($_SESSION['TotalTTC']==0)
												  //$_SESSION['TotalTTC']=$_SESSION['Mtotal'];
												  include('emecef.php');
												}
											else {$_SESSION['initial_fiche']="00000/".date('Y');
									 		    if($Tps==1)   //1 pour Regime normal
												  {													  
										 			if(isset($_SESSION['pourcent'])&&($_SESSION['pourcent']>0))
														header('location:FactureNormaliseeR.php');
													else { 
														header('location:InvoiceTPS.php'); 
													}														
												  }
												 else header('location:FactureNormalisee.php');   
											}
										}
									}
									else {
										//if($RegimeTVA==0) header('location:InvoiceTPS.php');
										//else header('location:FactureNormalisee.php');
																			}
									}
							}
				// if(isset($TypeFacture)&& ($TypeFacture==1))

				//else
					//header('location:Facture.php');

		// $re="SELECT userId FROM utilisateur WHERE login='".$_SESSION['login']."'";
		// $ret=mysqli_query($con,$re);$ret1=mysqli_fetch_assoc($ret);
		// $_SESSION['userId']=!empty($ret1['userId'])?$ret1['userId']:NULL;

		$userId=$_SESSION['userId'];
		$userName=$_SESSION['nom']." ".$_SESSION['prenom'];
		//$_SESSION['userId']=
		$_SESSION['vendeur']=$userName;
		$customerIFU=$_SESSION['NumIFU'];//$customerIFU=$NumUFI;
		if($customerIFU==0) $customerIFU=null;
		$customerName=isset($_SESSION['groupe1'])?$_SESSION['groupe1']:$_SESSION['client'];
		//$_SESSION['Date_actuel']=isset($_SESSION['date_emission'])?$_SESSION['date_emission']:$Date_actuel;
		//$productlist="Chambre climatisée";
		$totalAmount=$_SESSION['Tttc_fixe']; //$totalAmount=$Mtotal;
		//$totalpayee = $avanceA; //22.02.22
		$totalpayee = $_SESSION['avanceA'];

		//$explode=explode("/",$numFactNorm); $TC=(int)$explode[0];
		//$TC=$numFactNorm;

		//$NIM_MCF ="ED04001173-".$TC; // NIM de la machine sur laquelle la facture originale est émise

		//$TFacture="v"; //
		$Aib_duclient="";
		//$TFacture="a";
		//if($TFacture=="v")
		if($_SESSION['serveurused']=="mecef"){
			if((isset($_SESSION['ANNULER']))&&($_SESSION['ANNULER']==0)&&($_SESSION['verrou']==0))
			$jsonData = formatData($userId,$userName,$customerIFU,$customerName,$Aib_duclient,$productlist,$totalAmount,$totalpayee);
		}
		//else
		//	$jsonData = formatData_Avoir($userId,$userName,$customerIFU,$customerName,$Aib_duclient,$productlist,$totalAmount,$totalpayee,$NIM_MCF);
		//echo "<br/>".print_r($jsonData);
		if($_SESSION['serveurused']=="mecef"){
		if((isset($_SESSION['ANNULER']))&&($_SESSION['ANNULER']==0)&&($_SESSION['verrou']==0))
		push($jsonData);
		}

		//if($_SESSION['debut']==$Date_actuel2)  //Ce cas survient lorsque le client est venu entre 00h et 12h.
		//echo $_SESSION['debut']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)-1,date($ans)));  //1ere option
		//$_SESSION['fin']=date("d-m-Y", mktime(0, 0, 0,date($mois),date($jour)-1,date($ans)));

		//echo $_SESSION['debut']."<br/>".$_SESSION['fin'];

		if(isset($_SESSION['view'])&&($_SESSION['view']==0)){
				if(isset($_SESSION['impaye'])&&($_SESSION['impaye']==1)&&($_SESSION['serveurused']=="emecef")) {
					for($k=0;$k<count($_SESSION['Listcompte']);$k++){
					if($_SESSION['NormSencaisser']==0){
						//echo "<br/>".
						$_SESSION['req1'] ="DELETE from mensuel_fiche1  WHERE numfiche='".$_SESSION['Listcompte'][$k]."'";
						//echo "<br/>".
						$_SESSION['req2']="DELETE from mensuel_compte  WHERE numfiche='".$_SESSION['Listcompte'][$k]."' AND due =0 ";
						$req_=mysqli_query($con,$_SESSION['req1']);$req_=mysqli_query($con,$_SESSION['req2']);
					}
				}
			}
		}

		//include 'JsonData.php';

		//if(isset($_SESSION['debuti'])) $_SESSION['debut']=$_SESSION['debuti'];  //Pour une facture ordinaire

/* 		$sql="SELECT MAX(id_request) AS  id_request FROM t_mecef";
		$query=mysqli_query($con,$sql);$data=mysqli_fetch_object($query);
		$id_request=$data->id_request;


		$result = array ();
		$result = pull($id_request);
		//echo  var_dump( $result );
 		$_SESSION['QRCODE_MCF'] = $result->QRCODE_MCF;
		$_SESSION['COMPTEUR_MCF'] = $result->COMPTEUR_MCF;
		$_SESSION['DT_HEURE_MCF'] = $result->DT_HEURE_MCF;
	  $_SESSION['NIM_MCF'] = $result->NIM_MCF;
		$_SESSION['SIGNATURE_MCF'] = $result->SIGNATURE_MCF;
		$_SESSION['IFU_MCF'] = $result->IFU_MCF;  */

		// echo '<meta http-equiv="refresh" content="1; url=FactureNormalisee.php?menuParent=Consultation" />';

	}
}

if($_SESSION['serveurused']=="mecef"){
		echo "<script language='javascript'>";
		echo "var timeout = setTimeout(
		function() {
			 document.location.href='JsonData.php'
			}
		,5000);";
	echo "</script>";
}
else{
		 //include('emecef.php');
		 //if($_SESSION['serveurused']=="emecef")
}
}
}
//echo $_SESSION['Mtotal'];
?>
