<?php
//include_once'test.php';

	//if(isset($user_Id)) echo $_SESSION['user_Id'];

	//echo $_SESSION['module'];

	include_once'menu.php';	include 'others/footerpdf.inc'; //echo $_SESSION['impaye'];
	include 'chiffre_to_lettre.php';  $codegrpe=!empty($_GET['codegrpe'])?$_GET['codegrpe']:NULL;$numfiche=!empty($_GET['numfiche'])?$_GET['numfiche']:NULL;$impaye=!empty($_GET['impaye'])?$_GET['impaye']:NULL;$sal=!empty($_GET['sal'])?$_GET['sal']:NULL;$numresch=!empty($_GET['numresch'])?$_GET['numresch']:NULL;$reduce=!empty($_GET['reduce'])?$_GET['reduce']:NULL;$EtatG=!empty($_GET['etatget'])?$_GET['etatget']:NULL;
	unset($_SESSION['fiche']); unset($_SESSION['num']); unset($_SESSION['Normalise']);unset($_SESSION['reimprime']);
	unset($_SESSION['numrecu']);unset($_SESSION['fact']);unset($_SESSION['Foriginal1']);unset($_SESSION['Foriginal2']);
	unset($_SESSION['EtatF']);$_SESSION['EtatF']='V';
	unset($_SESSION['idr']); //$_SESSION['sal']=isset($_GET['sal'])?$_GET['sal']:NULL;
	//$_SESSION['logo']="logo/".$NomLogo;;  $_SESSION['nomHotel']=$nomHotel; $_SESSION['footer1']="_".$Apostale."_TEL".$telephone1."/".$telephone2;
	//$_SESSION['footer2']="Email:".$Email."_Compte Bancaire:".$NumBancaire."_N° IFU:".$NumUFI;

	//echo $_SESSION['reference'];

	 $_SESSION["path"] = getURI();   $idr  = isset($_POST['Fusion'])?$_POST['Fusion']:NULL;  //$_SESSION['Fusion']=$idr;

	 $cham=!empty($_GET['cham'])?$_GET['cham']:NULL;
	 $sal=!empty($_GET['sal'])?$_GET['sal']:NULL;
	 $mode=!empty($_GET['mode'])?$_GET['mode']:NULL;

	 $PaymentDto = "ESPECE"; //Par défaut

	 if(isset(($mode))&&!empty($mode))
		{   $mode=strtoupper($mode);
			if($mode==2) $PaymentDto = "CHEQUE"; else if($mode==3) $PaymentDto = "VIREMENT"; else if($mode==4) $PaymentDto = "CARTE BANCAIRE";
			else if($mode==5) $PaymentDto = "MOBILE MONEY"; else if($mode==6) $PaymentDto = "AUTRE"; else $PaymentDto = "ESPECE";
		}else {
			 //$PaymentDto = "ESPECE"; //Par défaut
		}


	$DateCloture=$Jour_actuel;
	$query="SELECT * FROM  cloturecaisse WHERE state='0'";
	$req1 = mysqli_query($con,$query) or die (mysqli_error($con));
	while($close=mysqli_fetch_array($req1)){
		$Heure= $close['Heure']; $utilisateur= $close['utilisateur'];
		$DateCloture=$close['DateCloture'];
	}

	$query2="SELECT * FROM  cloturecaisse WHERE state='1' AND DateCloture='".$Jour_actuel."'";
	$req2 = mysqli_query($con,$query2) or die (mysqli_error($con));
	$close2=mysqli_fetch_assoc($req2);	 $Heure= $close2['Heure'];

	$codegrpe=trim($codegrpe); $_SESSION['codegrpe'] = $codegrpe;

 	if(!empty($codegrpe))
		{ $queryRecordset = "SELECT  NumIFU from groupe WHERE codegrpe LIKE '".$codegrpe."'";
		$Result=mysqli_query($con,$queryRecordset);$data=mysqli_fetch_object($Result);  $NumIFU=isset($data->NumIFU)?$data->NumIFU:NULL;}
	if(!empty($numfiche))
		{$queryRecordset = "SELECT  NumIFU from client,mensuel_fiche1 WHERE mensuel_fiche1.numcli_1=client.numcli AND numfiche LIKE '".$numfiche."'";
		$Result=mysqli_query($con,$queryRecordset);$data=mysqli_fetch_object($Result);  $NumIFU=$data->NumIFU;}

	$query_Recordset1 = "SELECT min(datarriv) AS datarriv FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.EtatChambre='active' AND chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON'  AND codegrpe='$codegrpe' ORDER BY nomch ASC";
	$query=mysqli_query($con,$query_Recordset1);
	while($data=mysqli_fetch_array($query)){
	  //$datarriv=$data['datarriv'];
	  $datarriv=substr($data['datarriv'],8,2).'-'.substr($data['datarriv'],5,2).'-'.substr($data['datarriv'],0,4);
	}
	if(!empty($codegrpe))
	{ 	$res1=mysqli_query($con,"SELECT groupe.code_reel  FROM mensuel_fiche1,groupe WHERE groupe.codegrpe='".$codegrpe."'");
			while ($ret=mysqli_fetch_array($res1))
				{	  $code_reel=$ret['code_reel'];
				}

			$res1=mysqli_query($con,"SELECT min(mensuel_fiche1.datarriv) AS min_date FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.codegrpe='$codegrpe'AND mensuel_fiche1.etatsortie='NON'");
			while ($ret=mysqli_fetch_array($res1))
				{	 $min_date=$ret['min_date'];
				}
			$res1=mysqli_query($con,"SELECT min(mensuel_fiche1.datarriv) AS min_date FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.codegrpe='$codegrpe'AND mensuel_fiche1.etatsortie='OUI' AND mensuel_compte.due<0");
				while ($ret=mysqli_fetch_array($res1))
				{	 $min_date2=$ret['min_date'];
				}

			$ans=substr($min_date,0,4);
			$mois=substr($min_date,5,2);
			$jour=substr($min_date,8,2);
			$_SESSION['debut']=substr($min_date,8,2).'-'.substr($min_date,5,2).'-'.substr($min_date,0,4);

			$res1=mysqli_query($con,"SELECT max(mensuel_fiche1.datdep) AS max_date FROM mensuel_fiche1,mensuel_compte WHERE mensuel_fiche1.codegrpe='$codegrpe'AND mensuel_fiche1.etatsortie='NON'");
			while ($ret=mysqli_fetch_array($res1))
				{	 $max_date=$ret['max_date'];
				}
			$_SESSION['fin']=substr($max_date,8,2).'-'.substr($max_date,5,2).'-'.substr($max_date,0,4);


		//Pour connaitre le montant des occupants journalier
		//if(!isset($_GET['sal']))  //Pour les chambres

/* 		$query.=" UNION
		SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,mensuel_compte.due,
		view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.tva,mensuel_compte.ttc_fixe,mensuel_compte.somme, mensuel_compte.taxe,mensuel_compte.typeoccup, mensuel_compte.ttc, mensuel_fiche1.datarriv,mensuel_compte.nuite,mensuel_compte.np
		FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
		WHERE mensuel_fiche1.numcli_1 = client.numcli
		AND mensuel_fiche1.numcli_2 = view_client.numcli
		AND mensuel_fiche1.codegrpe LIKE '".$codegrpe."'
		AND chambre.numch = mensuel_compte.numch
		AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
		AND mensuel_fiche1.etatsortie = 'OUI' AND mensuel_compte.due>=0"; */
		//else      //Pour les salles

			$Fusion0=0; $somC=0;$somS=0;

						$queryC="SELECT DATEDIFF('".$Jour_actuelp."',datarriv) AS DiffDate,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,mensuel_compte.due,
			view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.ttc_fixe,mensuel_compte.ttc_fixeR,mensuel_compte.somme,mensuel_compte.typeoccup,  mensuel_fiche1.datarriv,mensuel_compte.nuite,mensuel_compte.np
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND trim(mensuel_fiche1.codegrpe) LIKE '".$codegrpe."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND mensuel_fiche1.etatsortie = 'NON'"; $queryC1=$queryC; $sqlC=mysqli_query($con,$queryC1); if(mysqli_num_rows($sqlC)>0) $Fusion0+=1;

					  $queryS="SELECT DATEDIFF('".$Jour_actuel."',datarriv) AS DiffDate,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, compte1.due,
			salle.codesalle, compte1.tarif, compte1.ttc_fixe,compte1.ttc_fixeR,compte1.somme,compte1.typeoccup,  location.datarriv,compte1.nuite,compte1.np
			FROM client, location, salle, compte1
			WHERE (location.numcli = client.numcli OR location.numcli = client.numcliS)
			AND trim(location.codegrpe) LIKE '".$codegrpe."'
			AND salle.numsalle = compte1.numsalle
			AND compte1.numfiche = location.numfiche
			AND location.etatsortie = 'NON'";      $queryS1=$queryS;  $sqlS=mysqli_query($con,$queryS1); if(mysqli_num_rows($sqlS)>0) $Fusion0+=1;

			if(!isset($_GET['sal'])) {
			if(($Fusion0==2)&& (isset($_SESSION['Fusion']))&&($_SESSION['Fusion']==2)) {
			$querySi="SELECT DATEDIFF('".$Jour_actuel."',datarriv) AS DiffDate,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, compte1.due,
			salle.codesalle, compte1.tarif, compte1.ttc_fixe,compte1.ttc_fixeR,compte1.somme,compte1.typeoccup,  location.datarriv,compte1.nuite,compte1.np,Periode
			FROM client, location, salle, compte1
			WHERE (location.numcli = client.numcli OR location.numcli = client.numcliS)
			AND trim(location.codegrpe) LIKE '".$codegrpe."'
			AND salle.numsalle = compte1.numsalle
			AND compte1.numfiche = location.numfiche
			AND location.etatsortie = 'NON'";  $sqlSi=mysqli_query($con,$querySi);

 			$nbre_sql=mysqli_num_rows($sqlSi); $j=0;$due=0; $mt1=0;$mtT=0;
			while($row=mysqli_fetch_array($sqlSi))
				{   $nomch=isset($row['nomch'])?$row['nomch']:$row['codesalle'];
					$tarif=$row['tarif'];
					$type=$row['typeoccup'];
					$n=round((strtotime(date('Y-m-d'))-strtotime($row['datarriv']))/86400);
					$dat=(date('H')+1);
					settype($dat,"integer");
					if ($dat<14){$n=$n;}else {$n= $n+1;}
					if ($n==0){$n= $n+1;} $n=(int)$n;
					if(isset($_GET['sal'])) $n=($row['DiffDate']>0)?$row['DiffDate']:1;
					$table[$j]=$n;
					if(($row['ttc_fixeR']!=0)&&($row['ttc_fixeR']!=$row['ttc_fixe']))  $ttc_fixe=$row['ttc_fixeR']; else $ttc_fixe=$row['ttc_fixe'];
					$mt=($ttc_fixe*$n); $mtT+=$mt;
					$mt1+=$row['somme'];
					//$mt1=$row['ttc_fixe']*$row['np'];
					$datarriv=$row['datarriv'];
					$datarriv1[$j]=$row['datarriv'];
					$_SESSION['PeriodeS']=$row['Periode'];
					$j++;
				}  $somC=$mtT-$mt1;


			//if(isset($_GET['sal']))
			$sql3="SELECT numfiche FROM client,location WHERE location.codegrpe='".$codegrpe."' AND (location.numcli = client.numcli OR location.numcli = client.numcliS) AND etatsortie='NON'";
			//else
			//$sql3="SELECT numfiche FROM client,mensuel_fiche1 WHERE mensuel_fiche1.codegrpe='".$codegrpe."' AND mensuel_fiche1.numcli_1=client.numcli AND etatsortie='NON'";
			$req3 = mysqli_query($con,$sql3) or die (mysqli_error($con));
			$k=0;$ListeDesClients = array();
			if(mysqli_num_rows($req3)>0) {
				while ($dataS= mysqli_fetch_array($req3))
					{  $ListeDesClients[$k]=$dataS['numfiche'];$k++;
					}
			}$iii=0;$Ttotalii=0;
			for($k=0;$k<count($ListeDesClients);$k++){
				//if(isset($_GET['sal']))
					$sql3="SELECT id,code,NbreUnites,PrixUnitaire FROM location,fraisconnexe WHERE fraisconnexe.numfiche = location.numfiche  AND location.numfiche='".$ListeDesClients[$k]."' AND fraisconnexe.Ferme='NON'";
				//else
					//$sql3="SELECT id,code,NbreUnites,PrixUnitaire FROM fiche1,fraisconnexe WHERE fraisconnexe.numfiche = fiche1.numfiche  AND fiche1.numfiche='".$ListeDesClients[$k]."' AND fraisconnexe.Ferme='NON'";
				$req3 = mysqli_query($con,$sql3) or die (mysqli_error($con));
				$ListeConnexe=array(); $PrixConnexe=array(); $id=array();$i=0; $Ttotalii=0; $iii=0;

				if(mysqli_num_rows($req3)>0){ $iii=1;
				while ($retA= mysqli_fetch_array($req3))
					{  		$ListeConnexe[$i]=$retA['code'];
							$Unites =$retA['NbreUnites']; $MontantUnites =$retA['PrixUnitaire'];
							$PrixConnexe[$i]=$Unites*$MontantUnites; $id[$i] =$retA['id']+$i; $i++;
							$NbreUnites =$retA['NbreUnites'];  $Ttotali = $NbreUnites * $MontantUnites ;
							$Ttotalii+=$Ttotali;
					}
				}

			}  $somC+=$Ttotalii;
			}
			$sql2=mysqli_query($con,$queryC);
			if(mysqli_num_rows($sql2)>0) $cham=1;
		}
		else {
			if((isset($Fusion0)&&($Fusion0==2))&&(isset($_SESSION['Fusion'])&&($_SESSION['Fusion']==2))) {
			$queryCi="SELECT DATEDIFF('".$Jour_actuelp."',datarriv) AS DiffDate,client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,mensuel_compte.due,
			view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.ttc_fixe,mensuel_compte.ttc_fixeR,mensuel_compte.ttc_fixeR,mensuel_compte.somme,mensuel_compte.typeoccup,  mensuel_fiche1.datarriv,mensuel_compte.nuite,mensuel_compte.np,Periode
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND trim(mensuel_fiche1.codegrpe) LIKE '".$codegrpe."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND mensuel_fiche1.etatsortie = 'NON'";  $sqlCi=mysqli_query($con,$queryCi);

 			$nbre_sql=mysqli_num_rows($sqlCi); $j=0;$due=0; $mt1=0;$mtT=0;
			while($row=mysqli_fetch_array($sqlCi))
				{   $nomch=isset($row['nomch'])?$row['nomch']:$row['codesalle'];
					$tarif=$row['tarif'];
					$type=$row['typeoccup'];
					$n=round((strtotime(date('Y-m-d'))-strtotime($row['datarriv']))/86400);
					$dat=(date('H')+1);
					settype($dat,"integer");
					if ($dat<14){$n=$n;}else {$n= $n+1;}
					if ($n==0){$n= $n+1;} $n=(int)$n;
					if(isset($_GET['sal'])) $n=($row['DiffDate']>0)?$row['DiffDate']:1;
					$table[$j]=$n;
					if(($row['ttc_fixeR']!=0)&&($row['ttc_fixeR']!=$row['ttc_fixe']))  $ttc_fixe=$row['ttc_fixeR']; else $ttc_fixe=$row['ttc_fixe'];
					$mt=($ttc_fixe*$n); $mtT+=$mt;
					$mt1+=$row['somme'];
					//$mt1=$row['ttc_fixe']*$row['np'];
					$datarriv=$row['datarriv'];
					$datarriv1[$j]=$row['datarriv'];
					$_SESSION['PeriodeC']=$row['Periode'];
					$j++;
				}  $somS=$mtT-$mt1;


			//if(isset($_GET['sal']))
			//$sql3="SELECT numfiche FROM client,location WHERE location.codegrpe='".$codegrpe."' AND location.numcli=client.numcli AND etatsortie='NON'";
			//else
			$sql3="SELECT numfiche FROM client,mensuel_fiche1 WHERE mensuel_fiche1.codegrpe='".$codegrpe."' AND mensuel_fiche1.numcli_1=client.numcli AND etatsortie='NON'";
			$req3 = mysqli_query($con,$sql3) or die (mysqli_error($con));
			$k=0;$ListeDesClients = array();
			if(mysqli_num_rows($req3)>0) {
				while ($dataS= mysqli_fetch_array($req3))
					{  $ListeDesClients[$k]=$dataS['numfiche'];$k++;
					}
			}$iii=0;$Ttotalii=0;
			for($k=0;$k<count($ListeDesClients);$k++){
				//if(isset($_GET['sal']))
					//$sql3="SELECT id,code,NbreUnites,PrixUnitaire FROM location,fraisconnexe WHERE fraisconnexe.numfiche = location.numfiche  AND location.numfiche='".$ListeDesClients[$k]."' AND fraisconnexe.Ferme='NON'";
				//else
					$sql3="SELECT id,code,NbreUnites,PrixUnitaire FROM fiche1,fraisconnexe WHERE fraisconnexe.numfiche = fiche1.numfiche  AND fiche1.numfiche='".$ListeDesClients[$k]."' AND fraisconnexe.Ferme='NON'";
				$req3 = mysqli_query($con,$sql3) or die (mysqli_error($con));
				$ListeConnexe=array(); $PrixConnexe=array(); $id=array();$i=0; $Ttotalii=0; $iii=0;

				if(mysqli_num_rows($req3)>0){ $iii=1;
				while ($retA= mysqli_fetch_array($req3))
					{  		$ListeConnexe[$i]=$retA['code'];
							$Unites =$retA['NbreUnites']; $MontantUnites =$retA['PrixUnitaire'];
							$PrixConnexe[$i]=$Unites*$MontantUnites; $id[$i] =$retA['id']+$i; $i++;
							$NbreUnites =$retA['NbreUnites'];  $Ttotali = $NbreUnites * $MontantUnites ;
							$Ttotalii+=$Ttotali;
					}
				}

			}  $somS+=$Ttotalii;
			}
			$sql2=mysqli_query($con,$queryS);
			$sal=1; $_SESSION['objet']="Location de salle";
		}

		$som1=0;$som2=0;$i=1;$j=0;$table=array("");$datarriv1=array();$nbre_sql=mysqli_num_rows($sql2);$due=0; $mt1=0;$mtT=0;
  		while($row=mysqli_fetch_array($sql2))
			{   $nomch=isset($row['nomch'])?$row['nomch']:$row['codesalle'];

				//if(isset($row['nomch'])) $cham=1;

				$tarif=$row['tarif'];
                $type=$row['typeoccup'];
				$n=round((strtotime(date('Y-m-d'))-strtotime($row['datarriv']))/86400);
				$dat=(date('H')+1);
				settype($dat,"integer");
				if ($dat<14){$n=$n;}else {$n= $n+1;}
				if ($n==0){$n= $n+1;} $n=(int)$n;
				if(isset($_GET['sal'])) $n=($row['DiffDate']>0)?$row['DiffDate']:1;
				$table[$j]=$n;
				if(($row['ttc_fixeR']!=0)&&($row['ttc_fixeR']!=$row['ttc_fixe']))   $ttc_fixe=$row['ttc_fixeR']; else  $ttc_fixe=$row['ttc_fixe'];
				$mt=($ttc_fixe*$n); $mtT+=$mt;
				$mt1+=$row['somme'];
				//$mt1=$row['ttc_fixe']*$row['np'];
				$datarriv=$row['datarriv'];
				$datarriv1[$j]=$row['datarriv'];
			$due+=$row['due'];
			//$som2=$som2+$mt1;
			$i++;$j++;
			} $som1=$mtT-$mt1+$somC+$somS;
			
			
			
		//Pour connaitre le montant des occupants de chambre qui sont en impayés
		$query="SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,mensuel_fiche1.datarriv,
		view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.ttc_fixe,mensuel_compte.ttc_fixeR,mensuel_compte.typeoccup, mensuel_fiche1.datarriv,mensuel_compte.nuite,mensuel_compte.np,mensuel_compte.due,mensuel_compte.N_reel
		FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
		WHERE mensuel_fiche1.numcli_1 = client.numcli
		AND mensuel_fiche1.numcli_2 = view_client.numcli
		AND trim(mensuel_fiche1.codegrpe) LIKE '".$codegrpe."'
		AND chambre.numch = mensuel_compte.numch
		AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
		AND mensuel_fiche1.etatsortie = 'OUI' AND mensuel_compte.due>0
		LIMIT 0 , 30";
		$sql2=mysqli_query($con,$query);
		$i=1;$somme_due=0;$ttc0=0;$montant_ht2=0;$ttc=0;
  		while($row=mysqli_fetch_array($sql2))
			{  	$N_reel=$row['N_reel'];
				$datarriv2=$row['datarriv'];
				//$ttc=$row['ttc'];
				//$ht2=$row['ht'];
				//echo $datarriv."".$datarriv2;
						$somme_due+=$row['due'];
				//if($datarriv==$datarriv2)
				if (in_array ($datarriv2, $datarriv1))
						 $etat=1;
				$ttc+=$ttc;//$montant_ht2+=$ht2;
				$i++;
			}
		//echo $datarriv2."".$datarriv1;
		 //$montantdu=$som1+$somme_due;
		  $montantdu=$som1;



		//if(isset($codegrpe)){
		if(isset($_GET['sal']))
			$sql3="SELECT numfiche FROM client,location WHERE location.codegrpe='".$codegrpe."' AND (location.numcli = client.numcli OR location.numcli = client.numcliS) AND etatsortie='NON'";
		else
			$sql3="SELECT numfiche FROM client,mensuel_fiche1 WHERE mensuel_fiche1.codegrpe='".$codegrpe."' AND mensuel_fiche1.numcli_1=client.numcli AND etatsortie='NON'";
		$req3 = mysqli_query($con,$sql3) or die (mysqli_error($con));
		$k=0;$ListeDesClients = array();
		if(mysqli_num_rows($req3)>0) {
			while ($dataS= mysqli_fetch_array($req3))
				{  $ListeDesClients[$k]=$dataS['numfiche'];$k++;
				}
		}$iii=0;$Ttotalii=0;
		for($k=0;$k<count($ListeDesClients);$k++){
			if(isset($_GET['sal']))
				$sql3="SELECT id,code,NbreUnites,PrixUnitaire FROM location,fraisconnexe WHERE fraisconnexe.numfiche = location.numfiche  AND location.numfiche='".$ListeDesClients[$k]."' AND fraisconnexe.Ferme='NON'";
			else
				$sql3="SELECT id,code,NbreUnites,PrixUnitaire FROM fiche1,fraisconnexe WHERE fraisconnexe.numfiche = fiche1.numfiche  AND fiche1.numfiche='".$ListeDesClients[$k]."' AND fraisconnexe.Ferme='NON'";
			$req3 = mysqli_query($con,$sql3) or die (mysqli_error($con));
			$ListeConnexe=array(); $PrixConnexe=array(); $id=array();$i=0; $Ttotalii=0; $iii=0;

			if(mysqli_num_rows($req3)>0){ $iii=1;
			while ($retA= mysqli_fetch_array($req3))
				{  		$ListeConnexe[$i]=$retA['code'];
						$Unites =$retA['NbreUnites']; $MontantUnites =$retA['PrixUnitaire'];
						$PrixConnexe[$i]=$Unites*$MontantUnites; $id[$i] =$retA['id']+$i; $i++;
						$NbreUnites =$retA['NbreUnites'];  $Ttotali = $NbreUnites * $MontantUnites ;
						$Ttotalii+=$Ttotali;
				}
			}

		}
			$sqli="SELECT * FROM fraisconnexe,groupe WHERE groupe.code_reel=fraisconnexe.numfiche AND groupe.codegrpe='".$codegrpe."' AND Ferme='NON'";
			$s=mysqli_query($con,$sqli);
			//$ListeConnexe=array(); $PrixConnexe=array(); $id=array();$i=0; $Ttotalii=0;
			if($nbreresult=mysqli_num_rows($s)>0)
			{	$iii=1;
				while($retA=mysqli_fetch_array($s))
					{ 	$ListeConnexe[$i]=$retA['code'];
						$Unites =$retA['NbreUnites']; $MontantUnites =$retA['PrixUnitaire'];
						$PrixConnexe[$i]=$Unites*$MontantUnites; $id[$i] =$retA['id']+$i; $i++;
						$NbreUnites =$retA['NbreUnites'];  $Ttotali = $NbreUnites * $MontantUnites ;
						$Ttotalii+=$Ttotali;
					}
			}

			$montantdu+=$Ttotalii; $som1+=$Ttotalii;
	}

	else
	{unset($_SESSION['debut']);unset($_SESSION['fin']);
	}
	$numfiche1=!empty($_GET['numfiche1'])?$_GET['numfiche1']:NULL;$fiche=!empty($_GET['fiche'])?$_GET['fiche']:NULL;$numero=!empty($_GET['numero'])?$_GET['numero']:NULL;  $somme=!empty($_GET['somme'])?$_GET['somme']:NULL;$due=!empty($_GET['due'])?$_GET['due']:NULL;
	$test = "DELETE FROM mensuel_fiche1 WHERE mensuel_fiche1.numcli_2=''";
	$reqsup = mysqli_query($con,$test) or die(mysqli_error($con));

	if(!empty($sal))
	{	$res=mysqli_query($con,"SELECT sum(somme) AS somme FROM compte1 WHERE numfiche='$numfiche'");
		while ($ret=mysqli_fetch_array($res))
			{$var1=$ret['somme'];
			}
		$res=mysqli_query($con,"SELECT sum(ttc_fixe) AS ttc_fixe FROM compte1 WHERE numfiche='$numfiche'");
		while ($ret=mysqli_fetch_array($res))
			{$var2=$ret['ttc_fixe'];
			}
	}
	$res=mysqli_query($con,"SELECT numfiche  FROM exonerer_tva WHERE numfiche='$numresch'");
		while ($ret=mysqli_fetch_array($res))
			{$numfiche_1=$ret['numfiche'];
			}

	if((!empty($numresch))&&(empty($sal)))
	{	$res=mysqli_query($con,"SELECT sum(avancerc) AS avancerc FROM reservationch WHERE numresch='$numresch'");
		while ($ret=mysqli_fetch_array($res))
			{$avancerc=$ret['avancerc'];
			}
		$res=mysqli_query($con,"SELECT nuiterc AS nuiterc FROM reservationch WHERE numresch='$numresch'");
		while ($ret=mysqli_fetch_array($res))
			{$nuiterc=$ret['nuiterc'];
			}
		if(empty($numfiche_1))
			$res=mysqli_query($con,"SELECT sum(ttc) AS somme FROM reserverch WHERE reserverch.numresch='$numresch'");
		else
			$res=mysqli_query($con,"SELECT sum(mtrc) AS somme FROM reserverch WHERE reserverch.numresch='$numresch'");
		while ($ret=mysqli_fetch_array($res))
			{ $total=$ret['somme']*$nuiterc;
			}
			$due=$total-$avancerc;
		//else{
		$taxe=0;
		$res=mysqli_query($con,"SELECT typeoccuprc AS typeoccuprc FROM reserverch WHERE reserverch.numresch='$numresch'");
		while ($ret=mysqli_fetch_array($res))
			{  $typeoccuprc=$ret['typeoccuprc'];
			  if($typeoccuprc=='double')
				$taxe+=2000*$nuiterc;
			  else
				$taxe+=1000*$nuiterc;
			}
		//}
		if(!empty($numfiche_1))
			$due+=$taxe;
	}
	if((!empty($numresch))&&(!empty($sal)))
	{	$res=mysqli_query($con,"SELECT sum(avancerc) AS avancerc FROM reservationsal WHERE numresch='$numresch'");
		while ($ret=mysqli_fetch_array($res))
			{$avancerc=$ret['avancerc'];
			}

		$res=mysqli_query($con,"SELECT nuiterc AS nuiterc FROM reservationsal WHERE numresch='$numresch'");
		while ($ret=mysqli_fetch_array($res))
			{$nuiterc=$ret['nuiterc'];
			}
		if(empty($numfiche_1))
		$res=mysqli_query($con,"SELECT sum((0.18*mtrc)+mtrc+0.1) AS somme FROM reserversal WHERE reserversal.numresch='$numresch'");
		else
		$res=mysqli_query($con,"SELECT sum(mtrc) AS somme FROM reserversal WHERE  reserversal.numresch='$numresch'");
		while ($ret=mysqli_fetch_array($res))
			{if(empty($numfiche_1)) $total=(int) ($ret['somme']*$nuiterc);else $total=$ret['somme']*$nuiterc;
			}
		$due=$total-$avancerc;
	}

	$res=mysqli_query($con,"DELETE FROM client_tempon");
	if(isset($_POST['ladate'])) $_SESSION['ladate1']=substr($_POST['ladate'],6,4).'-'.substr($_POST['ladate'],3,2).'-'.substr($_POST['ladate'],0,2);
	if(isset($_POST['ladate2'])) $_SESSION['ladate2']=substr($_POST['ladate2'],6,4).'-'.substr($_POST['ladate2'],3,2).'-'.substr($_POST['ladate2'],0,2);

	mysqli_query($con,"SET NAMES 'utf8'");
	$re=mysqli_query($con,"SELECT * FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND etatsortie='NON' ORDER BY chambre.numch");
/*
	if (isset($_POST['va'])&& $_POST['va']=='VALIDER')
		{	$_SESSION['sal'] = $_POST['sal'];
			if(($_POST['edit5']!='')&&($_POST['edit5']!=0)){

		if(((mysqli_num_rows($req1)>0)&&($DateCloture==$Jour_actuel)&&(mysqli_num_rows($req2)<=0)) || ((mysqli_num_rows($req1)<=0)&&($DateCloture==$Jour_actuel)&&(mysqli_num_rows($req2)<=0)))
		//if((mysqli_num_rows($req1)==0)&&($DateCloture!=$Jour_actuel))
		{
		 $_SESSION['numfiche']=$_POST['edit15'];
		 mysqli_query($con,"SET NAMES 'utf8' ");
			switch ($_POST['combo1'])
			{
				case 'fiche':
				{
					$s=mysqli_query($con,"SELECT mensuel_compte.typeoccup,mensuel_compte.numch,chambre.typech,mensuel_compte.somme,mensuel_compte.ttc,mensuel_compte.ttc_fixe,mensuel_compte.np,mensuel_compte.tarif AS tarif1,nomcli,prenomcli,nomch,mensuel_fiche1.datarriv as datarriv,mensuel_compte.date AS date FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche and mensuel_fiche1.numfiche='".$_POST['edit2']."'");
					while($ez=mysqli_fetch_array($s))
					{$_SESSION['tarif1']=$ez['tarif1'];
					$_SESSION['montant_ttc']=$ez['ttc'];
					$somme=$ez['somme']+ $_POST['edit5'];
					$due=$ez['ttc']- $somme;
					$_SESSION['datarriv']=$ez['datarriv'];
					$np=$_POST['edit5']/$ez['ttc_fixe'];
					$date=$ez['date'];
					$numch=$ez['numch'];
					if(empty($date))
					{$_SESSION['date']=substr($ez['datarriv'],8,2).'/'.substr($ez['datarriv'],5,2).'/'.substr($ez['datarriv'],0,4);
					}
					else{
					$date1=substr($date,0,2); $date2=substr($date,3,2); $date3=substr($date,6,4);
					$date=date("d/m/Y", mktime(0,0,0,date($date2),date($date1),date($date3)));
					$date=str_replace('-','/',$date);
					$_SESSION['date']=$date;}
					$_SESSION['datdep']=$ez['datdep'];
					$_SESSION['edit2']=$_POST['edit2'];
					$np1=$ez['np'];
					$_SESSION['ttc_fixe']=$ez['ttc_fixe'];
					if($ez['typech']=='V') $_SESSION['tch']='Ventillée'; else $_SESSION['tch']='Climatisée';
					$_SESSION['occup']=$ez['typeoccup'];
					$np2=$np1+$np;
					$_SESSION['np']=$np2;
					$_SESSION['nomclient']=$ez['nomcli']." ".$ez['prenomcli'];$_SESSION['nomch']=$ez['nomch'];
					}
					if(is_int($np)){
					$de=mysqli_query($con,"UPDATE mensuel_compte SET somme='$somme', due='$somme'-due, np='$np2',date='".$_SESSION['date']."' WHERE numfiche='".$_POST['edit2']."'");
					$s1=mysqli_query($con,"SELECT np,ttax,typeoccup,ttc_fixe,tva FROM mensuel_compte WHERE numfiche='".$_POST['edit2']."'");
					$ez1=mysqli_fetch_array($s1);
					$_SESSION['nuit']=$ez1['np'];
					if($ez1['typeoccup']=='double')
					$_SESSION['ttax']=2000; else $_SESSION['ttax']=1000;
					$_SESSION['tva']=round($TvaD*$_POST['edit5'],4);
				  //$_SESSION['somme_paye']=$_POST['edit5'];
					$_SESSION['somme_due']=$_POST['edit3'];
					$_SESSION['nuite']=$np;
					if ($de)
					{  	$en=mysqli_query($con,"INSERT INTO encaissement VALUES (NULL,'".$Jour_actuelp."','$Heure_actuelle','".$_POST['edit2']."','".$_POST['edit5']."','".$_SESSION['login']."','Encaissement chambre','$numch','".$_SESSION['occup']."','".$_SESSION['tarif1']."','".$_SESSION['ttc_fixe']."','$np')");

						$enA=mysqli_query($con,"INSERT INTO mensuel_encaissement VALUES (NULL,'".$Jour_actuelp."','$Heure_actuelle','".$_POST['edit2']."','".$_POST['edit5']."','".$_SESSION['login']."','Encaissement chambre','$numch','".$_SESSION['occup']."','".$_SESSION['tarif1']."','".$_SESSION['ttc_fixe']."','$np')");
							$avc=$_SESSION['ttc_fixe']*$np;
							$rit=mysqli_query($con,'UPDATE utilisateur SET montant_encaisse=montant_encaisse+"'.$avc.'" WHERE login="'.$_SESSION['login'].'"');
							$update=mysqli_query($con,"UPDATE configuration_facture SET num_fact=num_fact+1 ");
						echo "<script language='javascript'> alert('Encaissement fait avec succès.'); </script>";
			            header('location:recufiche2.php?menuParent=Consultation');
					}
					}else {$msg_4="<span style='font-style:italic;font-size:0.9em;color:blue;'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					La somme à encaisser doit correspondance à une certaine nuitée pour le client</span>"; }
				}
				break;
				case 'location':
				{
					$s=mysqli_query($con,"SELECT compte1.somme,compte1.ttc,compte1.ttc_fixe,compte1.np,compte1.tarif AS tarif1,nomcli,prenomcli,codesalle,datarriv FROM salle,location,compte1,client WHERE salle.numsalle=compte1.numsalle AND location.numcli=client.numcli AND location.numfiche=compte1.numfiche and location.numfiche='".$_POST['edit2']."'");
					while($ez=mysqli_fetch_array($s))
					{$_SESSION['tarif1']=$ez['tarif1'];
					$_SESSION['montant_ttc']=$ez['ttc'];
					$somme=$ez['somme']+ $_POST['edit5'];
					$due=$ez['ttc']- $somme;
					$_SESSION['datarriv']=$ez['datarriv'];
					$_SESSION['datdep']=$ez['datdep'];
					$np=$_POST['edit5']/$ez['ttc_fixe'];
					$_SESSION['np']=$np;
					$_SESSION['edit2']=$_POST['edit2'];
					$_SESSION['ttc_fixe']=$ez['ttc_fixe'];
					$_SESSION['codesalle']=$ez['codesalle'];
					$np1=$ez['np']+$np;
					$_SESSION['nomclient']=$ez['nomcli']." ".$ez['prenomcli'];$_SESSION['nomch']=$ez['nomch'];
					}
					$de=mysqli_query($con,"UPDATE compte1 SET somme='$somme', due='$due'  WHERE numfiche='".$_POST['edit2']."'");
					$s1=mysqli_query($con,"SELECT numsalle,tarif,np,ttax,typeoccup,ttc_fixe,tva FROM compte1 WHERE numfiche='".$_POST['edit2']."'");
					$ez1=mysqli_fetch_array($s1);
					$_SESSION['nuit']=$ez1['np'];
					if($ez1['typeoccup']=='double')
					$_SESSION['ttax']=2000; else $_SESSION['ttax']=1000;
					$_SESSION['tva']=round(0.18*$_POST['edit5'],4);
					$_SESSION['somme_paye']=$_POST['edit5'];
					$_SESSION['somme_due']=$_POST['edit3'];
					$_SESSION['nuite']=$np;
					$numsalle=$ez1['numsalle'];
					$typeoccup=$ez1['typeoccup'];
					$tarif=$ez1['tarif'];
					if($_POST['edit5']!='')
					$np=$_POST['edit5']/$ez1['ttc_fixe'];
					$ttc_fixe=$ez1['ttc_fixe'];

					$s=mysqli_query($con,"SELECT typesalle FROM salle WHERE numsalle='".$numsalle."'");
					while($ez=mysqli_fetch_array($s))
					{$typesalle=$ez['typesalle'];
					}

					if ($de)
					{  	$en=mysqli_query($con,"INSERT INTO encaissement VALUES (NULL,'".$Jour_actuelp."','$Heure_actuelle','".$_POST['edit2']."','".$_POST['edit5']."','".$_SESSION['login']."','Encaissement salle','$typesalle','RAS','$tarif','$ttc_fixe','$np')");
						$enA=mysqli_query($con,"INSERT INTO mensuel_encaissement VALUES (NULL,'".$Jour_actuelp."','$Heure_actuelle','".$_POST['edit2']."','".$_POST['edit5']."','".$_SESSION['login']."','Encaissement salle','$typesalle','RAS','$tarif','$ttc_fixe','$np')");
						$avc=$ttc_fixe*$np;
						//$rit=mysqli_query($con,'UPDATE utilisateur SET montant_encaisse=montant_encaisse+"'.$avc.'" WHERE login="'.$_SESSION['login'].'"');
						echo "<script language='javascript'> alert('Encaissement fait avec succès.'); </script>";
						$update=mysqli_query($con,"UPDATE configuration_facture SET num_fact=num_fact+1 ");
			       header('location:reufiche_sal.php?menuParent=Consultation');
					}
				}
				break;
				case 'reservation':
				{	$_SESSION['avc']=$_POST['edit5'];
					$_SESSION['numresch']=$_POST['edit2'];

					$s=mysqli_query($con,"SELECT du,au FROM reeditionfacture2,reedition_facture WHERE reeditionfacture2.numfiche='".$_POST['edit2']."' AND reeditionfacture2.numrecu=reedition_facture.numrecu");
					while($ez=mysqli_fetch_array($s))
					{//$_SESSION['mtht']=$ez['tarifrc'];

					}

					$s=mysqli_query($con,"SELECT sum(montantrc*nuiterc) AS tarifrc FROM reservationch WHERE numresch='".$_POST['edit2']."'");
					while($ez=mysqli_fetch_array($s))
					{$_SESSION['mtht']=$ez['tarifrc'];
					 $_SESSION['tva']=0.18*$ez['tarifrc'];
					}

					$s=mysqli_query($con,"SELECT nuiterc AS nuiterc FROM reservationch WHERE numresch='".$_POST['edit2']."'");
					while($ez=mysqli_fetch_array($s))
					{ $nuiterc=$ez['nuiterc'];
					}

					$s=mysqli_query($con,"SELECT sum(ttc) AS ttc FROM reserverch WHERE numresch='".$_POST['edit2']."'");
					while($ez=mysqli_fetch_array($s))
					{$_SESSION['mtttc']=$ez['ttc']*$nuiterc;
					}
					$_SESSION['taxe']=0;$i=0; $taxe=array("");
					$s=mysqli_query($con,"SELECT typeoccuprc AS typeoccuprc FROM reserverch WHERE numresch='".$_POST['edit2']."'");
					$nbre_rows=mysqli_num_rows($s);
					while($ez=mysqli_fetch_array($s))
					{	$typeoccuprc=$ez['typeoccuprc'];
						if($typeoccuprc=='individuelle')
							$taxe[$i]=1000*$nuiterc;
						else
							$taxe[$i]=2000*$nuiterc;
					$i++;
					}
					$_SESSION['taxe']=array_sum($taxe);
					$s=mysqli_query($con,"SELECT * FROM reservationsal,salle,reserversal WHERE salle.numsalle=reservationsal.numsalle AND reservationsal.numresch= reserversal.numresch and reserversal.numresch='".$_POST['edit2']."'");
					$nbre=mysqli_num_rows($s);
						while($ez=mysqli_fetch_array($s))
						{ $montant=(int)(0.1+$ez['tarifrc']);
							$codegrpe=$ez['codegrpe'];
							if(!empty($codegrpe))
							$_SESSION['client']=$codegrpe;
							else $_SESSION['client']=$ez['nomdemch'].' '.$ez['prenomdemch'];
						$tarifrc=$ez['mtrc'];
						}
					if($nbre==0)
					{	$s=mysqli_query($con,"SELECT * FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reserverch.numresch='".$_POST['edit2']."'");
						$nbre=mysqli_num_rows($s);
						$nbre1=mysqli_num_rows($s);
						while($ez=mysqli_fetch_array($s))
						{ 	$_SESSION['numresch']=$_POST['edit2'];
							$codegrpe=$ez['codegrpe'];
							if(!empty($codegrpe))
							$_SESSION['client']=$codegrpe;
							else $_SESSION['client']=$ez['nomdemch'].' '.$ez['prenomdemch'];
							$tva=0.18*$ez['tarifrc'];
							$_SESSION['debut']=substr($ez['datarrivch'],8,2).'/'.substr($ez['datarrivch'],5,2).'/'.substr($ez['datarrivch'],0,4);
							$_SESSION['fin']=substr($ez['datdepch'],8,2).'/'.substr($ez['datdepch'],5,2).'/'.substr($ez['datdepch'],0,4);
							$edit5=$_POST['edit5'];

						}
			if(($_SESSION['mtttc']==$_POST['edit5']))
				{  $np=$_SESSION['nuite'];
				   $ret=mysqli_query($con,'SELECT numch,ttc,typeoccuprc,tarifrc FROM reserverch WHERE  numresch="'.$_POST['edit2'].'"');
					while ($ret1=mysqli_fetch_array($ret))
					 {  $numch=$ret1['numch'];
						$ttc=$ret1['ttc']; $ttc1=$ret1['ttc']*$np;
						$typeoccuprc=$ret1['typeoccuprc'];
						$tarifrc=$ret1['tarifrc'];
						$tr1="UPDATE reserverch SET  avancerc=avancerc+'$ttc1', nuite_payee='$np' WHERE numresch='".$_POST['edit2']."' AND numch='$numch'";
						$tre_1=mysqli_query($con,$tr1);
						$tr="UPDATE reservationch SET  avancerc=avancerc+'$ttc1' WHERE numresch='".$_POST['edit2']."' AND numch='$numch'";
						$tre=mysqli_query($con,$tr);
						//echo $tr1."".$tr;
						$_SESSION['mt']=$_POST['edit3'];
						$_SESSION['av']=$_POST['edit4'];
						mysqli_query($con,"SET NAMES 'utf8' ");

						if (($_POST['edit5']!=0))
						{ 	$tu=mysqli_query($con,"INSERT INTO encaissement VALUES (NULL,'".$Jour_actuelp."','$Heure_actuelle','".$_POST['edit1']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation chambre','$numch','$typeoccuprc','$tarifrc','$ttc','$np')");
							$tuA=mysqli_query($con,"INSERT INTO mensuel_encaissement VALUES (NULL,'".$Jour_actuelp."','$Heure_actuelle','".$_POST['edit1']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation chambre','$numch','$typeoccuprc','$tarifrc','$ttc','$np')");
							$avc=$ttc*$np;
							//$rit=mysqli_query($con,'UPDATE utilisateur SET montant_encaisse=montant_encaisse+"'.$avc.'" WHERE login="'.$_SESSION['login'].'"');
							header('location:recurc2.php?menuParent=Consultation');
						}
					  }
					if (($_POST['edit5']!=0))
						{	$update=mysqli_query($con,"UPDATE configuration_facture SET num_fact=num_fact+1 ");
							header('location:recurc2.php?menuParent=Consultation');
						}
			    }
				else{
				$ret=mysqli_query($con,'SELECT numch,ttc,typeoccuprc,tarifrc FROM reserverch WHERE  numresch="'.$_POST['edit2'].'"');
				while ($ret1=mysqli_fetch_array($ret))
					 { 	  $numch=$ret1['numch'];
						  $ttc=$ret1['ttc'];
						  $typeoccuprc=$ret1['typeoccuprc'];
						  $tarifrc=$ret1['tarifrc'];
						 // if((is_int($_POST['edit5']/$ttc))||((($_POST['edit5']!='')||($_POST['edit5']!=0))&&(is_int($ttc/$_POST['edit5'])))||($_POST['edit5']==0))
				if((is_int($_POST['edit5']/$ttc))||(is_int($ttc/$_POST['edit5'])))
				  {		if($ttc>0)
						{if($_POST['edit5']>=$ttc) $np=(int)($_POST['edit5']/$ttc);else $np=(int)($ttc/$_POST['edit5']);}
						$tr1="UPDATE reserverch SET  avancerc=avancerc+'".$_POST['edit5']."', nuite_payee=nuite_payee+'$np' WHERE numresch='".$_POST['edit2']."' AND numch='$numch'";
						$tre_1=mysqli_query($con,$tr1);
						$tr="UPDATE reservationch SET  avancerc=avancerc+'".$_POST['edit5']."' WHERE numresch='".$_POST['edit2']."' AND numch='$numch'";
						//echo $tr1."".$tr;
						$tre=mysqli_query($con,$tr);

						$n_p=1;
						$_SESSION['mt']=$_POST['edit3'];
						$_SESSION['av']=$_POST['edit4'];
						$tre=mysqli_query($con,$tr1);
						if (($_POST['edit5']!=0))
						{ 	$update=mysqli_query($con,"UPDATE configuration_facture SET num_fact=num_fact+1 ");
							$tu=mysqli_query($con,"INSERT INTO encaissement VALUES (NULL,'".$Jour_actuelp."','$Heure_actuelle','".$_POST['edit2']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation chambre','$numch','$typeoccuprc','$tarifrc','$ttc','$np')");
							$avc=$ttc*$np;
							$rit=mysqli_query($con,'UPDATE utilisateur SET montant_encaisse=montant_encaisse+"'.$avc.'" WHERE login="'.$_SESSION['login'].'"');
								header('location:recurc2.php?menuParent=Consultation');
							if ($_POST['edit_7']!=0)
							{	$ret=mysqli_query($con,'SELECT salle.typesalle,reserversal.codesalle,reserversal.tarifrc  FROM reserversal,salle WHERE reserversal.numsalle=salle.numsalle AND  numresch="'.$_POST['edit2'].'"');
								while ($ret1=mysqli_fetch_array($ret))
								{ $codesalle=$ret1['codesalle'];
								  $typesalle=$ret1['typesalle'];
								  $tarifrc=$ret1['tarifrc'];
								  $ttc1=(int)($tarifrc+0.1);
								  $np_sal=$_SESSION['avc_salle']/$ttc1;$_SESSION['np_sal']=$np_sal-1;
								}
						$tr1="UPDATE reserversal SET  avancerc='".$_POST['edit_7']."', nuite_payee ='$np_sal' WHERE numresch='".$_POST['edit2']."'";
						$tre1=mysqli_query($con,$tr1);
						$tr="UPDATE reservationsal SET  avancerc=avancerc+'".$_POST['edit_7']."' WHERE numresch='".$_POST['edit2']."'";
						$tu=mysqli_query($con,"INSERT INTO encaissement VALUES (NULL,'".$Jour_actuelp."','$Heure_actuelle','".$_POST['edit2']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation salle','".$typesalle."','','$tarifrc','$ttc1','$np_sal')");
						$tuA=mysqli_query($con,"INSERT INTO mensuel_encaissement VALUES (NULL,'".$Jour_actuelp."','$Heure_actuelle','".$_POST['edit2']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation salle','".$typesalle."','','$tarifrc','$ttc1','$np_sal')");
						$avc=$ttc1*$np_sal;
						$rit=mysqli_query($con,'UPDATE utilisateur SET montant_encaisse=montant_encaisse+"'.$avc.'" WHERE login="'.$_SESSION['login'].'"');
						}
							if(!$tu)
							{echo "<script language='javascript'> alert('Encaissement non effectué.'); </script>";
							}
						}
						else
						{header('location:encaissement.php?menuParent=Consultation');}
						exit();
					}
				}
			}
		}
			if(($nbre!=0)&&($nbre1==0))
			{ if (($_POST['edit5']!=0))
				{ 	$_SESSION['chambre']=0;
					$res=mysqli_query($con,"SELECT numfiche  FROM exonerer_tva WHERE numfiche='".$_POST['edit2']."'");
					while ($ret=mysqli_fetch_array($res))
						{$numfiche_1=$ret['numfiche'];
						}
				$res=mysqli_query($con,"SELECT nuiterc AS nuiterc FROM reservationsal WHERE numresch='".$_POST['edit2']."'");
				while ($ret=mysqli_fetch_array($res))
					{$nuiterc=$ret['nuiterc'];
					}
				if(empty($numfiche_1))
				$res=mysqli_query($con,"SELECT sum((0.18*mtrc)+mtrc+0.1) AS somme FROM reserversal WHERE reserversal.numresch='".$_POST['edit2']."'");
				else
				$res=mysqli_query($con,"SELECT sum(mtrc) AS somme FROM reserversal WHERE  reserversal.numresch='".$_POST['edit2']."'");
				while ($ret=mysqli_fetch_array($res))
					{if(empty($numfiche_1)) $total=(int) ($ret['somme']*$nuiterc);else $total=$ret['somme']*$nuiterc;
					}
				$due=$total-$avancerc;
			    $_SESSION['total']=$total;

					$ret=mysqli_query($con,'SELECT DISTINCT salle.numsalle,reservationsal.datarrivch,salle.typesalle,reserversal.codesalle,reserversal.tarifrc,reserversal.mtrc FROM reservationsal,reserversal,salle WHERE reserversal.numresch=reservationsal.numresch   AND reserversal.numsalle=salle.numsalle AND reserversal.numresch="'.$_POST['edit2'].'"');
					while ($ret1=mysqli_fetch_array($ret))
					{ $codesalle=$ret1['codesalle'];
					  $typesalle=$ret1['typesalle'];
					  $tarifrc=$ret1['tarifrc'];
					  $ttc1=(int)($tarifrc+0.1);
					  $np_sal=$_POST['edit5']/$ttc1;
					  $mtttc=(int)($tarifrc+0.1);
					  $debut=$ret1['datarrivch'];
					  $fin=$ret1['datarrivch'];
					  $numsalle=$ret1['numsalle'];
					  $_SESSION['np_sal']=$np_sal-1;
					  if($mtttc==$_POST['edit5'])
					  {		$tr1="UPDATE reserversal SET  avancerc=avancerc+'$mtttc', nuite_payee='".$np_sal."' WHERE numresch='".$_POST['edit2']."' AND numsalle='$numsalle'";
							$tre_1=mysqli_query($con,$tr1);
							$tr="UPDATE reservationsal SET  avancerc=avancerc+'$mtttc' WHERE numresch='".$_POST['edit2']."' AND numsalle='$numsalle'";
							$tre=mysqli_query($con,$tr);
							$etat=1;
					  }
					}
					if($total==$_POST['edit5'])
					{$ret=mysqli_query($con,'SELECT sum(mtrc) AS mtrc,sum(tarifrc) AS tarifrc  FROM reserversal,salle WHERE reserversal.numsalle=salle.numsalle AND reserversal.numresch="'.$_POST['edit2'].'"');
					while ($ret1=mysqli_fetch_array($ret))
					{ $mtrc=$ret1['mtrc'];
					  $tarifrc=$ret1['tarifrc'];
					  if($etat!=1)
					{$tr1="UPDATE reserversal SET  avancerc=avancerc+'".$_POST['edit5']."', nuite_payee='".$np_sal."' WHERE numresch='".$_POST['edit2']."' AND numsalle='$numsalle'";
					$tre_1=mysqli_query($con,$tr1);
					$tr="UPDATE reservationsal SET  avancerc=avancerc+'".$_POST['edit5']."' WHERE numresch='".$_POST['edit2']."' AND numsalle='$numsalle'";
					$tre=mysqli_query($con,$tr);
					}
					$_SESSION['mtht']=$mtrc;
					$_SESSION['mtttc']=(int)($tarifrc+0.1);

					}
					}
					$_SESSION['debut']=substr($debut,8,2).'/'.substr($debut,5,2).'/'.substr($debut,0,4);
					$_SESSION['fin']=substr($fin,8,2).'/'.substr($fin,5,2).'/'.substr($fin,0,4);
					$tu=mysqli_query($con,"INSERT INTO encaissement VALUES (NULL,'".date('Y-m-d')."','$Heure_actuelle','".$_POST['edit2']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation salle','".$typesalle."','','$mtrc','$ttc1','$np_sal')");
					$tuA=mysqli_query($con,"INSERT INTO mensuel_encaissement VALUES (NULL,'".date('Y-m-d')."','$Heure_actuelle','".$_POST['edit2']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation salle','".$typesalle."','','$mtrc','$ttc1','$np_sal')");
					$avc=$ttc1*$np_sal;
					//$rit=mysqli_query($con,'UPDATE utilisateur SET montant_encaisse=montant_encaisse+"'.$avc.'" WHERE login="'.$_SESSION['login'].'"');
					$update=mysqli_query($con,"UPDATE configuration_facture SET num_fact=num_fact+1 ");
					header('location:recurc2.php?menuParent=Consultation');

				}
			}
			}

			break;
			default: echo '';
			}
		// }else if((mysqli_num_rows($req1)==0)&&($DateCloture==$Jour_actuel)){
		// 	echo "<script language='javascript'>";
		// 	echo 'alertify.error("La caisse a déjà été clôturée pour le compte de ce jour");';
		// 	echo "</script>";
		}else if((mysqli_num_rows($req1)==0)&&($DateCloture==$Jour_actuel)){
			echo "<script language='javascript'>";
			echo "var Heure = '".$Heure."';";
			echo 'alertify.error("Encaissement impossible. La caisse a déjà été clôturée pour le compte de ce jour à "+Heure+".");';
			echo "</script>";
		}else {
				$DateCloture=substr($DateCloture,8,2).'-'.substr($DateCloture,5,2).'-'.substr($DateCloture,0,4);
				echo "<script language='javascript'>";
				echo "var date = '".$DateCloture."';"; echo "var utilisateur = '".ucfirst($utilisateur)."';";
				//echo 'alertify.error("Encaissement impossible. La caisse a déjà été clôturée.");';
				echo 'alertify.error("Encaissement impossible. L\'agent "+utilisateur+" n\'a pas encore été clôturé sa caisse en date du "+date+" .");';
				echo "</script>";
		}

		}	else $msg_4="<span style='font-style:italic;font-size:0.9em;color:blue;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Vous devez renseigner le champ Somme à encaisser</span>";

		}
 */

		//Ici, je cherche à connaitre le montant minimum d'une nuitée à payer par un groupe pour déclencher une facture simple
		if(isset($code_reel))
			{$query="SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,mensuel_compte.due,
			view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.ttc_fixe,
			mensuel_compte.somme,mensuel_compte.np, mensuel_compte.typeoccup,chambre.numch AS numch, mensuel_compte.numfiche FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND mensuel_fiche1.numfichegrpe LIKE '".$code_reel."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND mensuel_fiche1.etatsortie = 'NON'";$sql2=mysqli_query($con,$query);
			$ttc_fixe=0; $i=0;$sommeArrhes=0; $somme=0;
			while($row=mysqli_fetch_array($sql2))
				{	$ttc_fixe+=$row['ttc_fixe'];
					//if($i==0){
						$edit0_1=$row['numfiche'];
						$numch=$row['numch'];
						$typeoccup=$row['typeoccup'];
						$tarif=$row['tarif'];
						$somme+=$row['somme'];
					//}$i++;
					//if(($row['somme']>0)&&($row['np']==0)) //Dans le cas des Arrhes
						//$sommeArrhes+=$row['somme'];
					//else
						//{
							//$modulo=$row['somme'] % $row['ttc_fixe'];
							//$sommeArrhes+=$modulo;
						//}
				}
			//	if
				$modulo=($ttc_fixe!=0)?$somme % $ttc_fixe:0;
				$sommeArrhes+=$modulo;
			}

	//if(isset($_POST['edit1___0'])) echo $_POST['edit1___0'];

	//if(isset($_POST['va1'])&& $_POST['va1']=='VALIDER')
		if(isset($_POST['edit1___0']))
		{
	 	if(($_POST['solde']==2)&&($_POST['Rpayer']==$_POST['edit5'])){    //Encaissement d'un facture déjà

			if(isset($_POST['impaye'])) $post0="mensuel_fiche1.etatsortie='OUI'";	else $post0="mensuel_fiche1.etatsortie='NON'";
/* 			$post_0="mensuel_view_fiche2.etatsortie='OUI'";
			if(isset($_SESSION['sal'])) $post_S="location.etatsortie='OUI'";
			}else {
				$post0="mensuel_fiche1.etatsortie='NON'"; */

			if(isset($_SESSION['groupe1']))
				//echo "<br/>1-".
			$query="SELECT mensuel_compte.numfiche AS numfiche
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND mensuel_fiche1.codegrpe = '".$_SESSION['groupe1']."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND ".$post0;
			else
				//echo "<br/>2-".
				$query="SELECT mensuel_compte.numfiche AS numfiche
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND mensuel_fiche1.numfiche = '".$_SESSION['num']."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND ".$post0;

			//$sql3=mysqli_query($con,$query);

			$sql3=mysqli_query($con,$query);
			if (!$sql3) {
				printf("Error: %s\n", mysqli_error($con));
				exit();
			}
			$i=0; $nombre=array("");$soustraire=0;$sommeArrhes=0;	 $Listcompte=array(); $k=0; $Tttc_fixe=0;
			//echo "<br/>1-". mysqli_num_rows($sql3);
			while($row=mysqli_fetch_array($sql3))
			{   echo $queryA="UPDATE mensuel_compte SET somme='".$row['due']."',due='0' WHERE numfiche='".$row['numfiche']."'";
				   	 $queryB="UPDATE compte SET somme='".$row['due']."',due='0' WHERE numfiche='".$row['numfiche']."'";
				$reqA=mysqli_query($con,$queryA);$reqB=mysqli_query($con,$queryB);
			}



		//¨Pour Location de Salle
		if(isset($_POST['impaye'])) $post0="location.etatsortie='OUI'";	else $post0="location.etatsortie='NON'";
			if(isset($_SESSION['groupe1']))
				//echo "<br/>1-".
			$query="SELECT compte1.numfiche AS numfiche,due
			FROM client, location, salle, compte1
			WHERE location.numcli = client.numcli
			AND location.codegrpe = '".$_SESSION['groupe1']."'
			AND salle.numsalle = compte1.numsalle
			AND compte1.numfiche = location.numfiche
			AND ".$post0;
			else
				//echo "<br/>2-".
				$query="SELECT compte1.numfiche AS numfiche,due
			FROM client, location, salle, compte1
			WHERE location.numcli = client.numcli
			AND location.numfiche = '".$_SESSION['num']."'
			AND salle.numsalle = compte1.numsalle
			AND compte1.numfiche = location.numfiche
			AND ".$post0;

			//$sql3=mysqli_query($con,$query);

			$sql3=mysqli_query($con,$query);
			if (!$sql3) {
				printf("Error: %s\n", mysqli_error($con));
				exit();
			}
			$i=0;
			//echo "<br/>1-". mysqli_num_rows($sql3);
			while($row=mysqli_fetch_array($sql3))
			{   $query="UPDATE compte1 SET somme='".$row['due']."',due='0' WHERE numfiche='".$row['numfiche']."'";
				$reqA=mysqli_query($con,$query );
			}
			$id_request=$_POST['id_request']; $numFactNorm=$_POST['numFactNorm'];  $state=0;$NumFact1="";$NumFactN="25";$client="";$objet="";$debut="";$fin="";$TotalTaxe=0;$TotalTva=0;$Tttc_fixe=0;$remise=0;$_SESSION['modulo']=0;$avanceA=$_POST['Mtotal'];$Tps=0;
			echo $query="INSERT INTO reedition_facture VALUES (NULL,'".$state."','".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['login']."','0','0','".$numFactNorm."','".$id_request."','".$client."','".$objet."','".$debut."','".$fin."','".$TotalTaxe."','".$TotalTva."','".$Tttc_fixe."','".$remise."','".$_SESSION['modulo']."','".$avanceA."','".$Tps."')";
			$tu=mysqli_query($con,$query);

					echo "<script language='javascript'>";
					echo 'alertify.success(" Encaissement effectué avec succès.");';
					echo "</script>";
			}else
			{
			 $montant_1=$_POST['edit9']; $_SESSION['sal'] = $_POST['sal']; $_SESSION['Fconnexe']= $_POST['Fconnexei'];
			  $_SESSION['cham']= $_POST['cham'];  $_SESSION['Nd']=$_POST['edit1___0'];  $_SESSION['NumIFU']=$_POST['NumIFU'];
			  $_SESSION['sal'] = $_POST['sal'];
			  //if(!empty($_POST['impaye']))
			  $_SESSION['solde']=$_POST['solde'];  // Valeur 1 : le client a soldé sa facture

		//$_SESSION['exonorer_tva']=!empty($_POST['ExonorerTva'])?$_POST['ExonorerTva']:NULL;
		$_SESSION['exonerer_AIB']=!empty($_POST['exonerer_AIB'])?$_POST['exonerer_AIB']:NULL;

		$_SESSION['NormSencaisser']=0; if(isset($impaye) && isset($_GET['solde']) && ($_GET['solde']==0)) $_SESSION['NormSencaisser']=1;

		if((($_POST['Rpayer']!='')&&($_POST['Rpayer']!=0))|| isset($_POST['view'])|| ($_SESSION['NormSencaisser']==1)|| isset($_POST['Fusion'])){

		if(((mysqli_num_rows($req1)>0)&&($DateCloture==$Jour_actuel)&&(mysqli_num_rows($req2)<=0)) || ((mysqli_num_rows($req1)<=0)&&($DateCloture==$Jour_actuel)&&(mysqli_num_rows($req2)<=0)) || isset($_POST['view']))
		  {
			if(isset($_POST['edit5'])&& $_POST['edit5']>0) $updateBD=1; else $updateBD=0; $_SESSION['updateBD']=$updateBD;

			$ExonorerTva=!empty($_POST['ExonorerTva'])?$_POST['ExonorerTva']:0; $_SESSION['ExonorerTva']=$ExonorerTva;

			$_SESSION['du']=$_POST['ladate'];
			$_SESSION['au']=$_POST['ladate2'];
			$_SESSION['nom_client']=$_POST['edit6'];
			$_SESSION['montantpayee']=$_POST['edit10'];
			$_SESSION['code_reel']=$_POST['code_reel'];
			$_SESSION['groupe']=$_POST['edit6'];
			$_SESSION['somme']=$_POST['edit9'];
			$_SESSION['Mtotal']=$_POST['Mtotal'] + (int)$_POST['arrhes'];
			if($_POST['edit5']>$_SESSION['Mtotal']) $_SESSION['Mtotal'] = $_POST['edit5'];  //Ici le client a payé plus qu'il ne doit.
			//echo $_SESSION['Mtotal'];
			$_SESSION['avanceA']=$_POST['Rpayer'];
			$_SESSION['remise']=$_POST['remise'];$_SESSION['arrhes']=(int)$_POST['arrhes'];
			$_SESSION['sommePayee']=$_POST['edit5'];

			if(isset($_POST['exhonerer_tva'])){  //Exonere de la TVA
				//Gerer par le formulaire ExonereTVA.php
				$ValTVA=$_POST['ValTVA'];
			}else $ValTVA=0;
			if(isset($_POST['Apply_AIB'])){  //Appliquer AIB
						$req="INSERT INTO Applyaib VALUES('".$Jour_actuel."','".$_POST['edit6']."','','1','".$_POST['ValAIB']."','".$_POST['PourcentAIB']."')";
						$sql=mysqli_query($con,$req); $_SESSION['Apply_AIB'] = $_POST['Apply_AIB']; $_SESSION['PourcentAIB']= $_POST['PourcentAIB'];
						 $_SESSION['ValAIB']=$_POST['ValAIB']; $ValAIB=$_POST['ValAIB'];
					}else $ValAIB=0;


		$ttc_fixe=$_POST['ttc_fixe'];	 $Rpayer=$ValTVA-$ValAIB;
		if(!isset($_POST['view']))
			//if(($_SESSION['NormSencaisser']==1)&&(isset($_SESSION['impaye'])))
				//$Rpayer+=$_POST['Mtotal'];
			//else
				$Rpayer+=isset($_POST['Mtotal'])?$_POST['Mtotal']:$_POST['Rpayer'];
		//else if (($_SESSION['NormSencaisser']==0)&&(isset($_SESSION['impaye'])))
			//{$Rpayer+=$_POST['Mtotal'];	$numfiche=$_POST['edit0_1'];}
		else
			{$Rpayer+=$_POST['Mtotal'];	$numfiche=$_POST['edit0_1'];}
		//$Rpayer=$_POST['Rpayer']+$ExonorerTva;
		if($ttc_fixe!=0) $modulo=$Rpayer % $ttc_fixe;  if($ttc_fixe>$Rpayer) $modulo=$_POST['edit5'];
		$_SESSION['modulo'] = $modulo;  //echo $_SESSION['Mtotal']."<br/>".$_SESSION['avanceA']."<br/>".$modulo  ;

		if($modulo>0) //if(($modulo>0)&&($_POST['arrhes']>0))
		$_SESSION['sommeArrhes']=$modulo;	else $_SESSION['sommeArrhes']=0;

		 if(isset($modulo) && ($modulo>0) && ($_POST['edit1_0']<=0))// Le client a payé un montant qui ne correspond pas exactement à une nuité
			{	$query = "VALUES (NULL,'".$Jour_actuel."','".$Heure_actuelle."','".$numfiche."','".$modulo."','".$_SESSION['login']."','Facture de groupe','".$_POST['numch']."','".$_POST['typeoccup']."','".$_POST['tarif']."','$ttc_fixe','0')";
				 if($updateBD==1){
					 if(isset($_SESSION['solde'])&&($_SESSION['solde']==1)){
					$InsertA=mysqli_query($con,"INSERT INTO encaissement ".$query);
					$InsertB=mysqli_query($con,"INSERT INTO mensuel_encaissement ".$query);
					 }
				 }

			//if($ttc_fixe>$_POST['Rpayer']){
				if(($ttc_fixe>$Rpayer)&&($updateBD==1)){ 	// Le client a payé un montant inférieur à une nuité
					//echo $ttc_fixe ."<br/>".$Rpayer;
					$query="SET somme=somme+'".$modulo."'  WHERE numfiche='".$numfiche."'";
					$reqA=mysqli_query($con,"UPDATE mensuel_compte ".$query);$reqB=mysqli_query($con,"UPDATE compte ".$query);
					echo "<script language='javascript'>";
					echo 'alertify.success(" Encaissement effectué avec succès.");';
					echo "</script>";
					echo "<center><iframe src='receiptH.php";  echo "' width='600'  height='700' scrolling='no' allowtransparency='true' FRAMEBORDER='yes'  style='margin-left:30%;'></iframe></center>";
					$_SESSION['nature'] = 'Hébergement';
				}
			}

			if(!empty($_POST['impaye'])) $_SESSION['impaye']=$_POST['impaye'];    if(!empty($_POST['PaymentDto'])) $_SESSION['PaymentDto']=$_POST['PaymentDto'];
			//echo $_POST['edit1___0']."<br/>".$_POST['Np'];
			if((isset($_POST['edit1_0'])&& $_POST['edit1_0']>0)||($_POST['edit1___0']>$_POST['Np'])||(($_POST['edit1___0']>0)&&(isset($_POST['view'])))	|| (($_SESSION['NormSencaisser']==1)&&(isset($_SESSION['impaye']))))    // La somme à encaisser est >= à une nuité ou bien le client voudrait se faire délivrer une facture à laquelle il à droit.
				{ 	$_SESSION['NuitePayee']=$_POST['edit1_0'];  $_SESSION['Nuitep']=$_POST['edit1_0'];$_SESSION['Fusion0K']=isset($_POST['Fusion'])?$_POST['Fusion']:0;
					if($_POST['edit9']==0)  $_SESSION['Mtotal']=$_POST['M_total'];$_SESSION['N']=$_POST['n'];
					if(!empty($_POST['PeriodeC'])) $_SESSION['PeriodeC']=$_POST['PeriodeC']; 
					if(!empty($_POST['PeriodeS'])) $_SESSION['PeriodeS']=$_POST['PeriodeS'];
					//if($updateBD==0) $_SESSION['sommeArrhes']= 0;
					
					if(isset($_POST['Fusion'])) { $_SESSION['cham']=1;$_SESSION['sal']=1; }
					
				if(isset($_POST['button_checkbox_2']))
					{   //$update=mysqli_query($con,"UPDATE configuration_facture SET num_fact=num_fact+1 ");
						$_SESSION['NuitePayee']=(int)$_POST['edit1___0'];
						$_SESSION['Mtotal']=$_POST['Mtotal'];
						if($_POST['edit1___0']>$_POST['Np']) {
							$_SESSION['retro']=1;
							$_SESSION['avanceA']=(int)$_POST['edit1__0']+(int)$_POST['edit5'];
						}
						$_SESSION['view'] = $_POST['view']; $_SESSION['solde']=0;
						$_SESSION['avanceA'] =0;
						if(($_SESSION['NormSencaisser']==1)&&(isset($_SESSION['impaye']))) {
							$_SESSION['NuitePayee'] =$_POST['edit1___0'];
						}
						if(isset($_SESSION['view'])){
							echo "<a class='info1' href='".substr($_SESSION["path"],0,-4); echo "'>";
							//echo "<img src='logo/cal.gif' alt='' title='' width='20' height='20' style='border:1px solid blue;float:right;' >";
							echo "<i class='fa fa-undo' ari-hidden='true' style='float:right;color:red;'></i>";
							echo "<span style='font-size:0.9em;color:red;'>Retour au Formulaire</span></a>";
							} 
						echo "<center><iframe src='checkingOK.php";  echo "' width='1000' height='800' style=''></iframe></center>";
						$_SESSION['Visualiser']=1;
					}
				else if(isset($_POST['button_checkbox_3'])) { $_SESSION['view']=0;
						if(($_SESSION['NormSencaisser']==1)&&(isset($_SESSION['impaye']))) {
							$_SESSION['NuitePayee'] =$_POST['edit1___0'];
							$_SESSION['Mtotal']=$_POST['Mtotal'];
						}
						$update=mysqli_query($con,"UPDATE configuration_facture SET numFactNorm=numFactNorm+1 ");
						$_SESSION['NuitePayee']=(int)$_POST['edit1___0']; $_SESSION['Normalise']=1;
						if($_POST['edit1___0']>$_POST['Np']) 	{
							$_SESSION['retro']=1;
							$_SESSION['avanceA']=(int)$_POST['edit1__0']+(int)$_POST['edit5'];
						} unset($_SESSION['sommeArrhes']);
						if(!isset($_SESSION['impaye'])) $_SESSION['retro']=1;

						if(($_SESSION['NormSencaisser']==1)&&(isset($_SESSION['impaye']))) $_SESSION['solde']=0;

						$connected=is_connected();
						if(($_SESSION['serveurused']=="mecef")||(($_SESSION['serveurused']=="emecef")&&($connected=='true')))
						{	//echo $_SESSION['Mtotal']; echo $_POST['Mtotal'];
							if(isset($_SESSION['TotalTTC'])&&($_SESSION['TotalTTC']==0)) {
								$_SESSION['TotalTTC']=$_POST['Mtotal'];
							}
							if(isset($_SESSION['Mtotal'])&& ($_SESSION['Mtotal']==0)) {
								$_SESSION['Mtotal']=$_POST['Mtotal'];
							}
							echo "<center><iframe src='checkingOK.php";  echo "' width='1000' height='800' style=''></iframe></center>";
						}
							else {  //Ici pour sortir la facture non normalisée
									//echo "<center>
									//	<iframe src='checkingOK.php";  echo "' width='1000' height='800' style=''></iframe>
									//</center>";

									$rallback=1; //echo $_GET['sal'];
								}
					if(!isset($rallback)){
 						echo '
						<script type="text/javascript">
						$(document).ready(function(){
							let timerInterval
							Swal.fire({
								title: "Patientez SVP !",
								html: "Le processus de Facturation prendra fin dans <b></b> milliseconds.",
								timer: 4500,
								timerProgressBar: true,
								didOpen: () => {
									Swal.showLoading()
									timerInterval = setInterval(() => {
										const content = Swal.getContent()
										if (content) {
											const b = content.querySelector("b")
											if (b) {
												b.textContent = Swal.getTimerLeft()
											}
										}
									}, 100)
								},
								willClose: () => {
									clearInterval(timerInterval)
								}
							}).then((result) => {
								if (result.dismiss === Swal.DismissReason.timer) {
									console.log("I was closed by the timer")
								}
							})
						});
						</script>	';
					}
				}
				else // Le client a droit à une facture mais exige un réçu: Délivrance de la facture à la fin du séjour
				 {	if($updateBD==1){
					$modulo=$_POST['edit5']; $_SESSION['modulo']=$modulo; //$_SESSION['sommeArrhes']=$modulo;

					$query = "VALUES (NULL,'".$Jour_actuel."','".$Heure_actuelle."','".$numfiche."','".$modulo."','".$_SESSION['login']."','Facture de groupe','".$_POST['numch']."','','".$_POST['tarif']."','".$ttc_fixe."','".$_POST['edit1_0']."')";
					//$InsertA=mysqli_query($con,"INSERT INTO encaissement ".$query); $InsertB=mysqli_query($con,"INSERT INTO mensuel_encaissement ".$query);

					$query="SET somme=somme+'".$modulo."'  WHERE numfiche='".$numfiche."'";
					$reqA=mysqli_query($con,"UPDATE mensuel_compte ".$query);$reqB=mysqli_query($con,"UPDATE compte ".$query);
					echo "<script language='javascript'>";
					echo 'alertify.success("Encaissement effectué avec succès.");';
					echo "</script>";

					$update=mysqli_query($con,"UPDATE configuration_facture SET numrecu=numrecu+1 ");
					//header('location:recufiche.php?menuParent=Hébergement');
					$_SESSION['nature'] = 'Hébergement';$_SESSION['ttc_fixe'] = $ttc_fixe;
					//echo "<iframe src='receiptH.php";  echo "' width='600'  height='675' scrolling='no' allowtransparency='true' FRAMEBORDER='yes'  style='margin-left:30%;margin-top:-25px;'></iframe>";
					}
				 }
				}
				}else if((mysqli_num_rows($req1)==0)&&($DateCloture==$Jour_actuel)){
					echo "<script language='javascript'>";
					echo "var Heure = '".$Heure."';";
					echo 'alertify.error("Encaissement impossible. La caisse a déjà été clôturée pour le compte de ce jour à "+Heure+".");';
					echo "</script>";
				}else {
						$DateCloture=substr($DateCloture,8,2).'-'.substr($DateCloture,5,2).'-'.substr($DateCloture,0,4);
						echo "<script language='javascript'>";
						echo "var date = '".$DateCloture."';"; echo "var utilisateur = '".ucfirst($utilisateur)."';";

						echo 'alertify.error("Encaissement impossible. L\'agent "+utilisateur+" n\'a pas encore été clôturé sa caisse en date du "+date+" .");';
						echo "</script>";
				}
		}
 		else {//$msg_4="<span style='font-style:italic;font-size:0.9em;color:blue;'>Vous devez renseigner le champ Somme à encaisser</span>";
					if(!isset($_SESSION['Fusion'])&&($_SESSION['Fusion']!=2)){
					echo "<script language='javascript'>";
					echo 'alertify.error(" Vous devez renseigner le champ Somme à encaisser");';
					echo "</script>";
					}
				}
		}
		}

		if((isset($Fusion0)&&($Fusion0==2))&&(!isset($_SESSION['Fusion']))&&(!isset($_GET['p']))&&($_SESSION['Visualiser']==0))  {
			echo "<script language='javascript'>";
			echo 'alertify.alert("Le système a détecté que le même client a une facture en Hébergement de Chambre(s) et en Location de Salle(s). Cochez \'Fusionner H & L\' pour combiner les deux factures.");';
			//echo 'alertify.custom = alertify.extend("custom");'; echo 'alertify.custom("I\'m a custom log message");';
			echo "</script>";
		}
		if((isset($Fusion0)&&($Fusion0==2))&&(isset($_SESSION['Fusion']))&&($_SESSION['Fusion']==2)&&(!isset($_POST['view']))&&($_SESSION['Visualiser']==0))  {
			echo "<script language='javascript'>";
			echo 'alertify.error("Changement d\'état pris en compte. Une seule facture sera délivrée au client.");';
			//echo 'alertify.custom = alertify.extend("custom");'; echo 'alertify.custom("Changement d\'état pris en compte. Une seule facture sera délivrée au client.");';
			echo "</script>";
		}

		if(isset($_POST['Fusion'])){ //echo 85;
				echo "<script language='javascript'>";
				//solde=0&Vente=1&impaye=1&Numclt=".$ret1['numcli']."&numfiche=".$ret1['numfiche']."&due=".$due."&Mtotal=".$due."&groupe=".$ret1['groupe']."&Totalpaye=".$ret1['somme']
				//echo "var solde = '".$_GET['solde']."';";   echo "var Vente = '".$_GET['Vente']."';";
				//echo "var Numclt = '".$_GET['Numclt']."';";	echo "var numfiche = '".$_GET['numfiche']."';";
				//echo "var due = '".$_GET['due']."';";		echo "var Mtotal = '".$_GET['Mtotal']."';";
				//echo "var groupe = '".$_GET['groupe']."';";	echo "var Totalpaye = '".$_GET['Totalpaye']."';";
				//echo "var Nbre = '".$_GET['Nbre']."';";
				// if(($_GET['confirm']==1)){
				// 	echo 'swal("Normaliser la facture sans Encaisser pour N° Enrég. : "+numfiche+". \n Veuillez noter que cette action est irréversible. \nVoulez-vous vraiment continuer ?", {
				// 		dangerMode: true, buttons: true,
				// 	}).then((value) => { var Es = value;  document.location.href="loccupV.php?menuParent=Consultation&Nbre="+Nbre+"&solde="+solde+"&Vente="+Vente+"&Numclt="+Numclt+"&numfiche="+numfiche+"&due="+due+"&Mtotal="+Mtotal+"&groupe="+groupe+"&Totalpaye="+Totalpaye+"&px1="+Es;
				// 	}); ';
				// }else if(($_GET['confirm']==2)){
				// 	echo 'swal("Encaisser & Normaliser la facture pour N° Enrég. : "+numfiche+". \n Veuillez noter que cette action est irréversible. \nVoulez-vous vraiment continuer ?", {
				// 		dangerMode: true, buttons: true,
				// 	}).then((value) => { var Es = value;  document.location.href="loccupV.php?menuParent=Consultation&Nbre="+Nbre+"&solde="+solde+"&Vente="+Vente+"&Numclt="+Numclt+"&numfiche="+numfiche+"&due="+due+"&Mtotal="+Mtotal+"&groupe="+groupe+"&Totalpaye="+Totalpaye+"&px2="+Es;
				// 	}); ';
				// }else
				//{

			// 	alertify.confirm(" Voulez-vous vraiment continuer ?",function(e){
			// 		if(e) {
			// 		$('#form').submit();
			// 		return true;
			// 		//alert(var1);
			// 	}
			// }

			//	}
				echo "</script>";
		}

//if((isset($_GET['2'])&&($_GET['2']==2))) 	{echo "</center><iframe src='checkingOK.php";  echo "' width='1000' height='800' style=''></iframe></center>";}
?>
<html>
	<head>
		<script type="text/javascript" src="date-picker.js"></script>
		<script type="text/javascript" src="js/verifyCheckBoxes1.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<link rel="Stylesheet" type="text/css"  href='css/input.css' />
		<link rel="Stylesheet" href='css/table.css' />
		<link rel="Stylesheet" type="text/css"  href='css/input2.css' />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
			<style>
			.alertify-log-custom {
				background: blue;
			}
				td {
				  padding: 8px 0;
				}
			</style>
			<script src="js/sweetalert.min.js"></script>
			<script src="js/sweetalert2/sweetalert2@10.js"></script>
			<script src="js/jquery-3.3.1.min.js"></script>
			<script src="js/sweetalert2/sweetalert.min.js"></script>

			<script type="text/javascript" >

					function confirmation(){ //alert ('ffff');
								var somme = document.getElementById("edit5").value;
								//var var1 = document.getElementById("view").value;
								//if(var1==1))
								{
								alertify.confirm("En cliquant sur ce bouton OK, vous reconnaissez que le client a soldé sa facture d'une valeur de  ["+somme+"]. Veuillez noter que cette action est irréversible. Voulez-vous vraiment continuer ?",function(e){
			 						if(e) {
									$('#form').submit();
									return true;
									//alert(var1);
								} else {
									return false;
								}

								});
								}
							//else {
							//	alert(12);
							//}
					}


					function edition1() { options = "Width=800,Height=350" ; window.open( "others/ExonereTVA.php", "edition", options ) ; }

					function myFunction() {
						var mode =' <?php echo $PaymentDto; ?> ';
						//var menu = '<?php echo $_SESSION["path"]; ?>';
						alertify.success(" Mode de règlement : "+mode);

					{var arrhes = 0 ; if (document.getElementById("arrhes").value!='') arrhes = document.getElementById("arrhes").value;
					if(document.getElementById("ValTVA").value!="")
						var ValTVA = parseInt(document.getElementById("ValTVA").value);
					else
						var ValTVA=0;
					var connexe = parseInt(document.getElementById("Fconnexe").value);
					var facture =(parseInt(document.getElementById("Mtotal").value)+ValTVA-connexe-parseInt(document.getElementById("ValAIB").value))/parseInt(document.getElementById("ttc_fixe").value);
					document.getElementById("edit1___0").value = facture; }

					}

					function JSalert(){
							swal("1 : Espèce | 2 : Chèque | 3 : Virement | 4 : Carte Bancaire | 5 : Mobile Money | 6 : Autre", {
								content: {
									element: "input",
									attributes: {
									placeholder: "1 | 2 | 3 | 4 | 5 | 6",
									type: "number",
									},
									},
							})
							.then((value) => {
								//document.getElementById('modeP').value=value;
								//location.reload();
								var menu = '<?php echo $_SESSION["path"]; ?>';
								document.location.href=menu+'&mode='+value;

							});
						}
			</script>
	</head>
	<body bgcolor='azure' style="margin-top:-20px;padding-top:0px;"<?php if(isset($_GET['codegrpe'])&& !isset($_GET['p'])&&($_SESSION['Visualiser']==0)){ ?>onload="myFunction()" <?php } ?>>

	<?php  $PourcentAIB=1;
	 if(($idr==2)&&(!isset($_POST['view']))){
		 $_SESSION['Fusion']=(!empty($idr))?$idr:NULL;
		 echo '<meta http-equiv="refresh" content="0; url='.substr($_SESSION["path"],0,-4).'" />'; 
	 }
	if(isset($rallback)){  //$_GET['sal']
			echo "<script language='javascript'>"; //echo $impaye;
			//echo " var return = document.getElementById('impaye').value;";
			if(isset($sal)) echo "var sal = '".$sal."';";   echo "var path = '".$_SESSION["path"]."';";
			echo 'swal("Vous n\'êtes pas connectez à Internet. Par conséquent, la connexion avec eMECeF est impossible.","","error")';
			echo "</script>";
			if(!isset($sal)) 
				echo '<meta http-equiv="refresh" content="1; url=loccup.php?menuParent=Consultation" />';  //Commentaire du 12.01.2022
			else 
				echo '<meta http-equiv="refresh" content="1; url=loccup.php?menuParent=Consultation&sal=1" />';
		}
	if((!isset($_GET['p'])) ) {   //&& ($_SESSION['Fusion']!=2)
	?>
	<div align="" style="">
		<form action='<?=$_SESSION["path"]; echo "&p=1"; //if(isset($_POST['Fusion']) && ($_POST['Fusion']=2)) echo "&f=1";?>' method='post' name='encaissement' id="form">
			<table align='center' style='' id="tab">
				<tr>
					<input type='hidden' name='id_request' id='id_request' value='<?php if(isset($_GET['id_request'])) echo $_GET['id_request'];	?>' readonly />
					<input type='hidden' name='numFactNorm' id='numFactNorm' value='<?php if(isset($_GET['numFactNorm'])) echo $_GET['numFactNorm'];?>' />
					<input type='hidden' name='mHT' id='mHT' value='0' readonly />
					<input type='hidden' name='PaymentDto'  value='<?=$PaymentDto;	?>' readonly />
					<input type='hidden' name='solde' id='solde' value='<?php if(isset($_GET['solde'])) echo $_GET['solde'];	?>' readonly />
					<input type='hidden' name='PeriodeC' id='Periode' value='<?php if(isset($_GET['Periode'])&& !isset($_GET['sal'])) echo $_GET['Periode'];	?>' readonly />
					<input type='hidden' name='PeriodeS' id='Periode' value='<?php  if(isset($_GET['Periode'])&& isset($_GET['sal'])) echo $_GET['Periode'];	?>' readonly />
					<input type='hidden' name='Vente' id=''  value='<?php if(isset($_GET['Vente'])) echo $_GET['Vente']; ?>' style='' readonly >

					<input type='hidden' name='PourcentAIB' id='PourcentAIB' value='<?php echo isset($PourcentAIB)?$PourcentAIB:1;	?>' />
					<input type='hidden' name='TvaD' id='TvaD' value='<?php echo $TvaD;	?> ' />
					
					<input type='hidden' name='Visualiser' id='Visualiser' value='<?php echo isset($_SESSION['Visualiser'])?$_SESSION['Visualiser']:0;?> ' />

				 <input type='hidden' name='edit15' id='edit15' readonly value="<?php echo $chaine = random('F',5);?>" />
				 <input type='hidden' name='code_reel' id='edit_15' readonly value="<?php if(isset($code_reel)) echo $code_reel;?>" />
					<td>
						<fieldset  style='margin-left:auto; margin-right:auto;border:0px solid white;background-color:#D0DCE0;font-family:Cambria;'>
							<legend align='center' style='color:#3EB27B;font-size:1.2em;'><b></b></legend>
							<table width='800' style='margin-right:25px;margin-left:25px;' >
								<tr>
								<td colspan="4">
									<?php if(!isset($impaye)&& !isset($_GET['Vente'])) { ?>
									<span>
									<a class='info1' id='FraisC' target="_blank" style="text-decoration:none;" title='Ajouter des frais Connexes' href="popup.php?codegrpe=<?php echo isset($_GET['codegrpe'])?$_GET['codegrpe']:NULL; if(isset($_GET['sal'])) echo "?&sal=".$_GET['sal']; //echo "&Numclt=" ; echo isset($_GET['Numclt'])?$_GET['Numclt']:NULL; ?>" onclick="window.open(this.href, 'Formulaire pour ajout de Frais Connexes ','target=_parent, height=450, width=750, top=180, left=250, color=black, toolbar=no, menubar=no, location=no, resizable=no, scrollbars=no, status=no'); return false">
									<img src='logo/add.png' alt='' title='' width='20' height='22' style='margin-top:0px;float:left;' border='0'><span style='font-size:1em;' >&nbsp;Ajouter des Frais Connexes
									<?php if(isset($Ttotalii)&&($Ttotalii>0)) echo "<center style='color:red;'> Total : ".$Ttotalii."</center>"; ?>
									</span></a>
									 </span>
									<?php } ?>
									<h3 style='margin-top:-10px;margin-bottom:-20px;text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'>
									<?php //if(isset($impaye))
									if(isset($_GET['Vente'])) echo "VENTE DE PRODUITS - ENCAISSEMENT";
									else {
										if(isset($_GET['solde'])&&($_GET['solde']==2)) echo "ENCAISSEMENT D'UNE FACTURE NORMALISEE";
										else if(isset($_GET['solde'])&&($_GET['solde']==0))  echo "FACTURE NORMALISEE SANS ENCAISSEMENT";
										//if(isset($_GET['solde'])&&($_GET['solde']==1))
										else echo "ENCAISSEMENT & FACTURE NORMALISEE";
									//else echo "REGULARISATION - FACTURE IMPAYEE";
									}
									//else if(isset($_GET['sal'])) echo "ENCAISSEMENT LOCATION DE SALLE";
									//else echo "ENCAISSEMENT FACTURE DE GROUPE " ;
									?>
									</h3>
									<?php if(!isset($_GET['solde'])||($_GET['solde']!=2)){ ?>
									<span style='float:right;'>
										<input type="checkbox" name='view' id="view" onchange="visualiser();" value='1' <?php //if($TypeFacture==0) echo "disabled"; ?>>
										<label for="view" style='font-weight:bold;color:gray;'></label>
										<a class='info2' id='view0' target="" style="text-decoration:none;" title='Visualiser la Facture' href="<?php if(isset($_SESSION["path"])) echo $_SESSION["path"];?>&view=1" >
											<i class='fa fa-low-vision' ari-hidden='true' style='margin-top:3px;float:right;color:gray;'></i>
											<span style='font-size:1em;color:orange' >&nbsp;Cochez ici pour visualiser la Facture</span>
										</a>
									 </span>
									 <?php } ?>
								</td>
							</tr>
								<tr>
									 <span style='font-style:italic;font-size:0.9em;'></span>
									<input type='hidden' name='codegrpe' id='codegrpe' value='<?php if(!empty($codegrpe)) echo $codegrpe; ?>' readonly />
								</tr>

									<tr>
										<td colspan='4'><hr style='margin-bottom:-20px;'/>&nbsp;</td>
								</tr>
								<tr>
									<td colspan='4'>
									<span>
									<a class='info1' target="" style="text-decoration:none;" href='#' style='' onclick='JSalert();return false;' >
									<img src='logo/plus.png' alt='' title='' width='28' height='25' style='margin-top:-3px;float:left;margin-right:5px;' border='0'> <span> Mode de règlement : <?=$PaymentDto ?></span></a>
									 </span>

								<?php
									echo "<span style='align:center;'>"; if($Fusion0!=2)  echo "&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;"; echo "&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
									<input  type='checkbox' name='Apply_AIB' id='button_checkbox_4'"; if(isset($_GET['solde'])&&($_GET['solde']==2))  echo "disabled='disabled'";  echo "onclick='pal();'/>
									<label for='button_checkbox_4' style='color:#444739;'>Appliquer l'AIB	("; echo isset($PourcentAIB)?$PourcentAIB:1; echo "%) </label></span>	&nbsp; &nbsp;";

									$sqlT = "SELECT SUM(ValeurTVA) AS ValeurTVA FROM ExonereTVA WHERE groupe='".$codegrpe."' AND date ='".$Jour_actuel."' ";
									$rasT=mysqli_query($con,$sqlT);	$ratT=mysqli_fetch_assoc($rasT); $ValeurTVA=!empty($ratT['ValeurTVA'])?$ratT['ValeurTVA']:0;
									echo "<input type='hidden' name='ValTVA'  id='ValTVA' value='".$ValeurTVA."' readonly />";

								if($Fusion0==2) {
								echo "<span style='float:right;'>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
									<input type='checkbox' name='Fusion' id='button_checkbox_6' value='2'"; if(isset($_SESSION['Fusion'])&&($_SESSION['Fusion']==2)) echo "checked='checked'";?>
									onchange="document.forms['form'].submit();"
								<?php echo "'>
									<label for='button_checkbox_6' style='color:#444739;'>Fusionner

									<a class='info1' style'' title='' href='#'><span style=''>Hébergement</span><b style='color:red;'>H</b></a>
									 &
									<a class='info1' style'' title='' href='#'><span>Location de Salle</span><b style='color:red;'>L</b></a>
									</label></span>	";
								}



								//if($TvaD!=0) {
								echo "<span style='float:right'>
									<input type='checkbox' name='exhonerer_tva' id='button_checkbox_5' value='1'"; if(isset($_GET['solde'])&&($_GET['solde']==2))  echo "disabled='disabled'";
									if($ValeurTVA>0) echo "checked='checked'";
								echo "onchange='edition1();return false;'>
									<label for='button_checkbox_5' style='color:#444739;'>Exonérer de la TVA	</label></span>	";
									 //include_once('occupExo.php');
								////}	else {
								     //echo "&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;";
								//}
								?>
								</td>
								</tr>
								<tr>
										<td colspan='4'><hr style='margin-top:-15px;margin-bottom:-15px;'/>&nbsp;</td>
								</tr>

								<?php
							/* 	echo "<tr>
									<td> Pourcentage Impôt: </td>
									<td> <input type='text' name='pourcentage' id='pourcentage' value=''readonly onkeyup='changer();' onkeypress='testChiffres(event);'   size='10'/> &nbsp;%
									</td>
									<td>Désignation Impôt: </td>
									<td> <input type='text' name='designation' id='designation' value='' />
									 </td>
								</tr>"; */
								?>
								<tr>
									<td colspan="" style="">  Période du : </td>
							       <td style=" border: 0px solid black;"> <input type="text" name="ladate" id="ladate" size="24" value="<?php if(!empty($_GET['Arrivee'])) echo
										 substr($_GET['Arrivee'],8,2).'-'.substr($_GET['Arrivee'],5,2).'-'.substr($_GET['Arrivee'],0,4); else if(isset($_SESSION['debut'])) echo $_SESSION['debut'];  else { } ?>" readonly />
							       <a href="javascript:show_calendar('encaissement.ladate');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
										 </a>
						          </td>

								<td colspan="" style="">  &nbsp;&nbsp;&nbsp;&nbsp;Au : </td>
							       <td style=" border: 0px solid black;"> <input type="text" name="ladate2" id="ladate2" size="20" value="<?php if(empty($impaye)) { echo $Date_actuel2;} else if(!empty($_GET['Sortie'])) echo
										 substr($_GET['Sortie'],8,2).'-'.substr($_GET['Sortie'],5,2).'-'.substr($_GET['Sortie'],0,4); else echo $_SESSION['fin'];?>" readonly />
							           <a href="javascript:show_calendar('encaissement.ladate2');" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
										</a>
						          </td>
								</tr>

								<input type='hidden' name='cham' id=''  value='<?php if(!empty($cham)) echo $cham; ?>' style='' readonly >

								<tr><input type='hidden' name='sal' id='sal'  value='<?php if(!empty($sal)) echo $sal; ?>' style='' readonly >
									<td>Nom du groupe : </td>
									<td>
									<input type='text' name='edit6' id='edit6'  value='<?php if(!empty($codegrpe)) echo $codegrpe; ?>' style='' readonly >
									</td>
									<td>&nbsp;&nbsp;&nbsp; Somme due : </td>
									<td> <input type='text' name='edit99' id='edit99' size="24" value='<?php if(!empty($_GET['impaye'])) echo $_GET['montant'];  else  if(!empty($codegrpe)) { $montantduP=$montantdu; 	echo $montantdu; }else echo 0;?>'readonly />
									<input type='hidden' name='edit9' id='edit9' size="24" value='<?php if(!empty($codegrpe)) { $montantduP=$montantdu; $montantdu-=$ValeurTVA;	echo $montantdu; }else echo 0;?>'readonly />
									<input type='hidden' name='edit7' id='edit7' value='<?php echo date('d-m-Y'); ?>' readonly />
									<td>
								</tr>
								<?php  /* echo "<input  type='checkbox' name='exonorer_tva'  id='button_checkbox_1' value='1' onclick='Aff2();'/>
									<label for='button_checkbox_1' style='color:#444739;'>Exonérer de la TVA	</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input  type='checkbox' name='exonerer_AIB' id='button_checkbox_2'  value='1' onclick='Aff3();'/>
									<label for='button_checkbox_2' style='color:#444739;'>Exonérer de AIB	</label>&nbsp; &nbsp;"; */
									?>



								<?php //if(!empty($reduce)&&($reduce==1)){
								 //if($EtatG%2==0) {
								echo "
								<tr>
									<td> <span style='font-size:1em;'>Remise accordée :</span> </td>
									<td> <input type='number' name='pourcent' id='pourcent'  maxlength='3'  min='0' placeholder=' 0%' value='"; if(!empty($Ttotal)) echo $Ttotal ; echo "' onblur='AffA();' onchange='AffA();' onkeyup='AffA();' onkeypress='testChiffres(event);'/> </td>

									<td> <span style='font-size:1em;'>&nbsp;&nbsp;&nbsp;Montant à déduire :</span> </td>
									<td><input type='text' name='remise' id='remise' placeholder='0 ' value='' onblur='AffB();' onchange='AffB();' onkeyup='AffB();' onkeypress='testChiffres(event);' /> </td>
								</tr>

								<tr>
									<td> <span style='font-size:1em;'>Arrhes :</span> </td>
									<td> <input type='text' name='arrhes' id='arrhes'  placeholder='0' ";  if(isset($sommeArrhes)) echo "value='".$sommeArrhes."'";   echo " readonly onkeypress='testChiffres(event);'/> </td>

									<td><span style='font-size:1em;'>&nbsp;&nbsp;&nbsp;Montant à payer :</span> </td>
									<td><input type='text' name='Mtotal' id='Mtotal'"; if(isset($sommeArrhes)) $montantdu-=$sommeArrhes; if(!empty($_GET['impaye'])) $montantdu=$_GET['montant'];  if(isset($montantdu)) echo "value='".$montantdu."'"; echo "placeholder='' readonly /> </td>
									</td>
								</tr>";

							if(!isset($_GET['impaye']) || (isset($_GET['impaye']) && isset($_GET['solde']) && (($_GET['solde']==1)||($_GET['solde']==2))))
							{
								echo "<tr>";
								echo "<td>"; if(isset($Ttotal)&&($Ttotal>0)){
									echo "<span style='color:red;font-size:1em;'>Somme ";
									if(isset($_GET['impaye'])) echo "à encaisser "; else echo "encaissée ";
									echo ":</span>";
								}
								else {
									echo "<span style='font-size:1em;'>Somme ";
									if(isset($_GET['impaye'])) echo "à encaisser "; else echo "encaissée ";
									echo " :</span>";
									}
								echo "</td>";
								echo "<td>";
								echo "<input type='text' name='edit5' id='edit5' value='' required autofocus onkeyup='AffC();' onchange='AffC();' onkeypress='testChiffres(event);'/>";
								echo "</td>
								<td><span style='font-size:1em;'>&nbsp;&nbsp;&nbsp;Total ";
								if(isset($_GET['impaye'])) echo "à payer"; else echo "payé ";
								echo " :</span> </td>
								<td><input type='text' name='Rpayer' id='Rpayer'"; echo "placeholder='' readonly /> </td>
								</td>
								</tr>";
								}
								else
								{ 	echo "<input type='hidden' name='edit5' id='edit5' value='0' required />";
									echo "<input type='hidden' name='Rpayer' id='Rpayer'"; echo "placeholder='' readonly />";
								}

								echo "<input type='hidden' name='Fconnexe' id='Fconnexe' value='";if(isset($Ttotalii)&&($Ttotalii>0)) echo $Ttotalii; else echo 0; echo "'/>";
/*
								$sql0="SELECT * FROM fraisconnexe,groupe WHERE groupe.code_reel=fraisconnexe.numfiche AND groupe.codegrpe='".$codegrpe."' AND Ferme='NON'";
								$iii=0;
								$req0 = mysqli_query($con,$sql0) or die (mysqli_error($con));
								if(mysqli_num_rows($req0)>0){
								$iii=1;
								} */
								echo "<input type='hidden' name='Fconnexei' id='Fconnexei' value='".$iii."'  />";

								 ?>
								</tr>

								<tr>
										<td colspan='4'><hr style='margin-bottom:-20px;'/>&nbsp;</td>
								</tr>
								<tr>

									<td align=''>&nbsp;&nbsp;
									<input type="checkbox" name='button_checkbox_1' id="button_checkbox_1"  onClick="verifyCheckBoxes1();" value='1' checked>
									<label for="button_checkbox_1" style='font-weight:bold;color:gray;'>Reçu Ticket</label>
									</td>
									<td colspan='2' align='center'>
									<input type="checkbox" name='button_checkbox_2' id="button_checkbox_2" onClick="verifyCheckBoxes2();" onchange="verifyNuite();" value='1' <?php if($TypeFacture==1) echo "disabled"; ?>>
									<label for="button_checkbox_2" style='font-weight:bold;color:gray;'>Facture ordinaire</label>
									</td>
									<td align='right'>&nbsp;&nbsp; &nbsp;
									<input type="checkbox" name='button_checkbox_3' id="button_checkbox_3" onClick="verifyCheckBoxes3();" onchange="verifyIFU();" value='1' <?php if($TypeFacture==0) echo "disabled"; ?>>
									<label for="button_checkbox_3" style='font-weight:bold;color:gray;'>Facture Normalisée</label>
									</td>
								</tr>
									<tr>
										<td colspan='4'><hr style='margin-top:-15px;margin-bottom:-15px;'/>&nbsp;</td>
								</tr>

								<tr>
									<td colspan='4' align='center'>
									<?php

										if(!isset($_GET['impaye']) || (isset($_GET['impaye']) && isset($_GET['solde']))){
											echo "<input  type='button' name='va1' class='bouton2'  id='btn'";
											if($_GET['solde']==0) echo 'onclick="NormaliserSencaisser();"'; else echo 'onclick="confirmation();"';
											echo "value='VALIDER'";
											echo " style=''/>";
										}
										//else { echo "value='NORMALISER'"; }

									?> &nbsp;</td>
								</tr>
							</table>
						</fieldset>
					</td>
				</tr>
			</table> <input type='hidden' name='NumIFU' id='NumIFU' value='<?php if(isset($NumIFU)) echo $NumIFU;?>'/>


			<input type='hidden' name='impaye' id='impaye' value='<?php if($impaye!='') echo $impaye; ?>'readonly /></td>
			<?php //if($reduce!=1){ echo "<td>&nbsp;&nbsp;Somme à encaisser: </td>";
			echo "<td> <input type='hidden' name='edit10' id='edit10' value='' onkeyup='changer();' onkeypress='testChiffres(event);'/>
			<input type='hidden' id='t' />";
			 //}


			//echo $req="SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.tva,mensuel_compte.ttc_fixe, mensuel_compte.taxe,mensuel_compte.typeoccup, mensuel_compte.ttc, mensuel_fiche1.datarriv,mensuel_compte.nuite,mensuel_compte.np,mensuel_compte.due AS due FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client WHERE chambre.EtatChambre='active' AND mensuel_fiche1.numcli_1 = client.numcli AND mensuel_fiche1.numcli_2 = view_client.numcli AND mensuel_fiche1.codegrpe = '".$_GET['codegrpe']."' AND chambre.numch = mensuel_compte.numch AND mensuel_compte.numfiche = mensuel_fiche1.numfiche AND mensuel_fiche1.etatsortie = 'NON'";

			if(isset($_GET['sal']))
					$req="SELECT tarif,ttva,compte1.numfiche AS numfiche,compte1.np as NuiteP, compte1.somme AS somme,compte1.ttc_fixe,location.numfichegrpe,compte1.due,location.datarriv
			FROM client, location, salle, compte1
			WHERE location.numcli = client.numcli
			AND location.codegrpe = '".$_GET['codegrpe']."'
			AND salle.numsalle = compte1.numsalle
			AND compte1.numfiche = location.numfiche
			AND location.etatsortie = 'NON'";
			else
					$req="SELECT tarif,ttva,mensuel_compte.numfiche AS numfiche,mensuel_compte.np as NuiteP, mensuel_compte.somme AS somme,mensuel_compte.ttc_fixe,mensuel_fiche1.numfichegrpe,mensuel_compte.due,mensuel_fiche1.datarriv
			FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND mensuel_fiche1.codegrpe = '".$_GET['codegrpe']."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND mensuel_fiche1.etatsortie = 'NON'";
			$sql2=mysqli_query($con,$req);

			$somme_due=0;$MontantTotal=0;$somme=0;$ttc_fixe=0; $TaxeSejour=0;
			$ListeTaxe=array();$i=0; $montantHT=0;
		   //$PourcentAIB = isset($PourcentAIB)?$PourcentAIB:1;
			 $PourcentAIB /= 100; $ValAIB=0;
			while($row=mysqli_fetch_array($sql2))
				{  	//$N_reel=$row['N_reel'];
					//$due2=$row['due'];
					//$ttc=$row['ttc'];
					//$somme_due+=$due2;

					//$sqlT = "SELECT ValeurTVA AS TValeurTVA FROM exoneretva WHERE numfiche='".$row['numfiche']."'	AND date LIKE '".$Jour_actuel."'";
					//$rasT=mysqli_query($con,$sqlT);	$ratT=mysqli_fetch_assoc($rasT);
					//$TValeurTVA = isset($ratT['TValeurTVA'])?$ratT['TValeurTVA']:0;

					$n=round((strtotime($Jour_actuel)-strtotime($row['datarriv']))/86400);
					$dat=(date('H')+1);
					settype($dat,"integer");
					if ($dat<14){$n=$n;}else {$n= $n+1;}
					if ($n==0){$n= $n+1;} $n=(int)$n;

					$mt=$row['ttc_fixe']*$n; $MontantTotal+=$mt; $somme+=$row['somme'];
					$due = $mt-$row['somme']; $ttc_fixe+=$row['ttc_fixe'];
					$somme_due+=$due;  //echo "<br/>".
					//$ttc_fixe=$row['ttc_fixe'];

					if($ttc_fixe<=20000) $taxe = 500;	else if(($ttc_fixe>20000) && ($ttc_fixe<=100000))	$taxe = 1500;		else $taxe = 2500; $TaxeSejour+=$taxe;

					 		$ListeTaxe[$i]=$n*$taxe;$i++; // $TaxeSejour*=$n;

				$montantHT0=$row['tarif'];
				$Tva=round($row['tarif']*$row['ttva']);

				 if($row['ttva']!=0){
					 //$montantHT0=round($n*(($ttc_fixe-$taxe)/(1+$TvaD)));
					 //$Tva=round($montantHT0*$TvaD);
				 }else {

				 }


				 $ValAIB0=$montantHT0*$PourcentAIB;
				 $ValAIB+=$ValAIB0;  //Calcul de l'AIB sur le montant HT
				 $montantHT+=$montantHT0;

 				//echo $taxe;
				}//echo $MontantTotal."<br/>". $somme."<br/>". $somme_due."<br/>".$ttc_fixe;
				//$TaxeSejour=0;

			 	if((isset($ttc_fixe))&&($ttc_fixe>0)){

				$np=(int)($MontantTotal/$ttc_fixe); $n-=$np;

				}
				$TaxeSejour=0;
				for($j=0;$j<count($ListeTaxe);$j++)
					 	 $TaxeSejour+=$ListeTaxe[$j];

				//echo $TaxeSejour;

			$ValAIB0=$TaxeSejour*$PourcentAIB;   //On calcule l'AIB sur la taxe de séjour

			$ValAIB+=$ValAIB0;  $ValAIB = round($ValAIB);

			if(isset($_GET['ttc_fixe'])) $ttc_fixe=$_GET['ttc_fixe'];

				//if($somme_due<=20000) $TaxeSejour = 500;	else if(($somme_due>20000) && ($somme_due<=100000))	$TaxeSejour = 1500;		else $TaxeSejour = 2500;

			 //$ValAIB=round($montantHT*$PourcentAIB);
			 ?>
			 <input type='hidden' name='impaye' id='impaye'  value='<?php if(isset($_GET['impaye'])) echo $_GET['impaye']; else echo 0; ?>' />

			<input type='hidden' name='edit1__0' id='edit1__0'  value='<?php   //if($n<=0)
			 if(isset($np)) { $var=$somme-$np*$ttc_fixe; if($var>0) echo $var; else echo 0; }  ?>' />
			<input type='hidden' name='ValTVA_' id='ValTVA_' value='<?php  if(isset($_GET['impaye'])) echo 0; else  if(isset($ValeurTVA)) echo $Tva-$ValeurTVA; else { } ?>' />
			<input type='hidden' name='ValAIB_' id='ValAIB_' value='<?php { if(isset($ValAIB)) echo $ValAIB; } ?>' />
			<input type='hidden' name='ValAIB' id='ValAIB' value='0' />
			<input type='hidden' name='edit1___0' id='edit1___0'  value='' />
			<input type='hidden' name='edit1_0' id='edit1_0'  value='<?php  ?>' />
			<input type='hidden' name='M_total' id='M_total'  value='<?php { if(isset($MontantTotal)) echo $MontantTotal; } ?>' />
			<input type='hidden' name='edit3T' id='edit3T' value='<?php if(!empty($codegrpe)) { echo $montantduP; }else echo 0;?>' readonly />
			<input type='hidden' name='Np' id='Np'  value='<?php { if(isset($np)) echo $np; }  ?>' />
			<input type='hidden' name='' id='TaxeSejour'  value='<?php  if(isset($TaxeSejour)) echo $TaxeSejour;  ?>' />
			<input type='hidden' name='n' id=''  value='<?php if(isset($n)) echo $n; ?>' />

		 	<input type='hidden' name='edit0_1' id='edit0_1'  value='<?php if(isset($edit0_1)) echo $edit0_1;  ?>' />
			 <input type='hidden' name='ttc_fixe' id='ttc_fixe'  value='<?php if(isset($ttc_fixe)) echo $ttc_fixe; ?>' />
			 <input type='hidden' name='numch' id=''  value='<?php if(isset($numch)) echo $numch; ?>' />
			 <input type='hidden' name='typeoccup' id=''  value='<?php //if(isset($typeoccup)) echo $typeoccup; ?>' />
			 <input type='hidden' name='tarif' id=''  value='<?php if(isset($tarif)) echo $tarif; ?>' />

		 	<input type='hidden' name='NumIFU' id='NumIFU' value='<?php if(isset($NumIFU)) echo $NumIFU;?>'/>
			<input type='hidden' name='' id='TypeFacture' value='<?php if(isset($TypeFacture)) echo $TypeFacture;?>'/>

			<input type='hidden' name='hidden1' id='hidden1' value='<?php if(isset($montant_ht)) echo $montant_ht*$TvaD; ?>' />
			<input type='hidden' name='' id='montant_ht' value='<?php if(isset($montant_ht)) echo $montant_ht; ?>' />
			<input type='hidden' name='hidden3' id='hidden3' value='<?php if(!empty($codegrpe)) echo $montantdu; ?>'readonly />

		</form>
	</div>
	<?php
	}

	//echo $_SESSION['query'];

	?>

<script type="text/javascript">
		function visualiser(){
			if((document.getElementById("edit1___0").value>0)||(document.getElementById("Vente").value>0))
			//alertify.success("Cliquez maintenant sur le bouton VALIDER pour avoir un aperçu de la facture");
			document.getElementById("button_checkbox_2").disabled = false;
			document.getElementById("button_checkbox_2").checked = true;
			document.getElementById("button_checkbox_1").checked = false;
			//document.getElementById("Rpayer").readonly = true;
			$('#form').submit();
		}
		function NormaliserSencaisser(){
			{var arrhes = 0 ; if (document.getElementById("arrhes").value!='') arrhes = document.getElementById("arrhes").value;
		if(document.getElementById("ValTVA").value!="")
			var ValTVA = parseInt(document.getElementById("ValTVA").value);
		else
			var ValTVA=0;
		var connexe = parseInt(document.getElementById("Fconnexe").value);
		var facture =(parseInt(document.getElementById("Mtotal").value)+ValTVA-connexe-parseInt(document.getElementById("ValAIB").value))/parseInt(document.getElementById("ttc_fixe").value);
		document.getElementById("edit1___0").value = facture; }

			if(document.getElementById("edit1___0").value>0)
			document.getElementById("button_checkbox_2").disabled = false;
			document.getElementById("button_checkbox_2").checked = false;
			document.getElementById("button_checkbox_3").checked = true;
			document.getElementById("button_checkbox_1").checked = false;
			//alertify.success("Veuillez confirmer dans un délai d'une minuite le mode paiement du client. Sinon Patientez SVP");

			$('#form').submit();
		}
		function verifyIFU(){
			//if(document.getElementById('NumIFU').value <=0 )
			if(document.getElementById('TypeFacture').value <=0 )
			{ /* if((document.getElementById("button_checkbox_3").checked) )
				{alertify.error(" Pour établir la facture normalisée, <br/> le Numéro IFU du client est requise. ");
				 	 var timeout = setTimeout(
					function() {
						document.getElementById("button_checkbox_3").checked = false;
						document.getElementById("button_checkbox_1").checked = true;
						}
					,1500);

				} */
			}else {
				if(document.getElementById('Rpayer').value < document.getElementById('ttc_fixe').value )
				//if(parseInt(document.getElementById('Rpayer').value) < parseInt(document.getElementById('ttc_fixe').value) )
				{if((document.getElementById("button_checkbox_3").checked) )
					{alertify.error("Le montant à encaisser ne permet pas d'établir une facture pour le client. ");
					var timeout = setTimeout(
					function() {
						document.getElementById("button_checkbox_3").checked = false;
						document.getElementById("button_checkbox_1").checked = true;
						}
					,1500);
					}
				}

			}
	}
	function verifyNuite(){
			if(parseInt(document.getElementById('Rpayer').value) < parseInt(document.getElementById('ttc_fixe').value) )
				{if((document.getElementById("button_checkbox_2").checked) )
					{alertify.error("Le montant à encaisser ne permet pas d'établir une facture pour le client. ");
					var timeout = setTimeout(
					function() {
						document.getElementById("button_checkbox_2").checked = false;
						document.getElementById("button_checkbox_1").checked = true;
						}
					,1500);
					}
				}
	}

	function AffC()
		{ //document.getElementById("edit5").value=12;	 Mtotal 
			if(document.getElementById("Visualiser").value==0){
				alertify.error("Veuillez visualiser la facture avant de la normaliser SVP.");
				document.getElementById("edit5").value="";
			}		
			var arrhes = 0 ; if (document.getElementById("arrhes").value!='') arrhes = document.getElementById("arrhes").value;
			if(document.getElementById("ValTVA").value!="")
				var ValTVA = parseInt(document.getElementById("ValTVA").value);
			else
				var ValTVA=0;



 			if((document.getElementById("edit5").value!='')) //&& (document.getElementById("edit5").value>0)) Fconnexe
			//if(document.getElementById("edit5").value>0)
				{  //document.getElementById("ttp").value = document.getElementById('ValTVA').value;
					var connexe = parseInt(document.getElementById("Fconnexe").value);
					var facture =(parseInt(document.getElementById("edit5").value)+ValTVA-connexe-parseInt(document.getElementById("ValAIB").value))/parseInt(document.getElementById("ttc_fixe").value);
					document.getElementById("edit1___0").value = facture;

					var variableP = parseInt(document.getElementById("edit5").value) + parseInt(arrhes);
					document.getElementById("Rpayer").value =  variableP ;
					var variable = variableP + parseInt(document.getElementById('ValTVA').value) - parseInt(document.getElementById('ValAIB').value);
					var Mtotal = parseInt(document.getElementById("Mtotal").value);
					//var variable = parseInt(document.getElementById("edit5").value) + ExonererTva + parseInt(arrhes);
					//var Mtotal = parseInt(document.getElementById("Mtotal").value);
					//document.getElementById("Rpayer").value =variable-ExonererTva ;

					//document.getElementById("edit1_0").value=variable;

					if(variable>0)
						{	var reduction=0; if (document.getElementById("remise").value!='')  reduction = document.getElementById("remise").value;
							var variableR = variable + parseInt(reduction);
						 	var ttc_fixe=document.getElementById("ttc_fixe").value;
							document.getElementById("edit1_0").value=parseInt(variableR/ttc_fixe);

							//if((document.getElementById("edit1_0").value >=1)||(facture>document.getElementById("Np").value)){
								if((document.getElementById("edit1_0").value >=1)||(facture>document.getElementById("Np").value)&&(!empty(document.getElementById("Np").value))){
								document.getElementById("button_checkbox_1").checked = false;
								if(document.getElementById('TypeFacture').value <=0 )
									document.getElementById("button_checkbox_2").checked = true;
								else
								   {	if(document.getElementById("solde").value!=2){
										document.getElementById("button_checkbox_3").checked = true;
										document.getElementById("solde").value=1;
										}else
											document.getElementById("button_checkbox_1").checked = true;
								   }
							}else{
								document.getElementById("button_checkbox_2").checked = false;
								document.getElementById("button_checkbox_3").checked = false;
								document.getElementById("button_checkbox_1").checked = true;
							}
						}
					//else
						//document.getElementById("edit32").value=0;
				} else {
					var variable = parseInt(arrhes);
					document.getElementById("Rpayer").value =  variable ;
				}
		}

		//if (document.getElementById("edit3T").value==0)
			//document.getElementById('edit3T').value = document.getElementById('edit9').value;    // edit9 subtitué à edit3 (encaissement)

		var checkbox_aib = document.getElementById("button_checkbox_4");
		var checkbox_tva = document.getElementById("button_checkbox_5");

		if (document.getElementById("mHT").value==0)
			document.getElementById('mHT').value = document.getElementById('edit9').value;
			var mHT=document.getElementById("mHT").value;

			var PourcentAIB = document.getElementById('PourcentAIB').value/100;
			var TaxeSejour = document.getElementById('TaxeSejour').value;
			var TvaD = document.getElementById('TvaD').value;    //0.18
			var TvaDHT = parseFloat(TvaD) + 1 ;  //1.18;
			var montantHT=Math.round((mHT-TaxeSejour)/TvaDHT);
		//	var AIB=Math.round(montantHT*PourcentAIB);
	  	var AIB = parseFloat(document.getElementById('ValAIB_').value);
			//var TVA = document.getElementById('ValTVA').value;
			if (checkbox_tva.checked)
			//var TVA = document.getElementById('ValTVA_').value;
			var TVA = 0;
		function pal(){
				if (checkbox_aib.checked) {
						document.getElementById('ValAIB').value = AIB ;
						if (checkbox_tva.checked)
							{//document.getElementById('edit9').value = Math.round(parseInt(document.getElementById("mHT").value) - TVA+AIB);
							 document.getElementById('Mtotal').value = Math.round(parseInt(document.getElementById("mHT").value) - TVA+AIB);
							 //document.getElementById('ValTVA').value = TVA ;
							 //document.getElementById('ValAIB').value = AIB ;
							}
						else
							{ //document.getElementById('edit9').value = Math.round(parseInt(document.getElementById("edit3T").value) + AIB);
						  	document.getElementById('Mtotal').value = Math.round(parseInt(document.getElementById("edit3T").value) + AIB);
						  	//document.getElementById('ValAIB').value = AIB ;
							}
					}else {
						document.getElementById('ValTVA').value = 0;
						if (checkbox_tva.checked)
							{//document.getElementById('edit9').value = Math.round(parseInt(document.getElementById("edit3T").value) -TVA);
							document.getElementById('Mtotal').value = Math.round(parseInt(document.getElementById("mHT").value) -TVA);
							//document.getElementById('ValTVA').value = TVA ;
						 }
						else
							{//document.getElementById('edit9').value = document.getElementById('edit3T').value;
							document.getElementById('Mtotal').value = document.getElementById('edit3T').value;
							}
					}
			 if (document.getElementById("edit9").value!=''){

				}
			}

			function Aff()
			{document.getElementById('edit1_0').value=document.getElementById('edit9').value;
			}


function AffA()
{
	if (document.getElementById("pourcent").value!='')
	{  var Vpourcent = document.getElementById("pourcent").value/100;
		document.getElementById("remise").value= Math.round((document.getElementById("pourcent").value/100)*montantHT)  ;
		//document.getElementById("Mtotal").value= document.getElementById("edit9").value
		//-(0.01*document.getElementById("pourcent").value*document.getElementById("edit9").value)
		// + TaxeSejour;
		 var montantHT2 = montantHT - document.getElementById("remise").value;
		 var tva2 = Math.round(TvaD*parseFloat(montantHT - document.getElementById("remise").value));
		 document.getElementById("Mtotal").value=   parseInt(montantHT2) + parseInt(tva2) + parseInt(TaxeSejour);
	}
}
 function AffB()
{
	if (document.getElementById("remise").value!='')
	{
		document.getElementById("pourcent").value= (100*document.getElementById("remise").value/document.getElementById("edit9").value).toFixed(2)  ;
		document.getElementById("Mtotal").value= document.getElementById("edit9").value-document.getElementById("remise").value ;
	}
}

//window.onload=calcule

function calcule(){
    document.getElementById("t").onchange=function()
{
/*         document.getElementById("lettres").firstChild.data=trans(this.value)
		document.getElementById("lettre").value=document.getElementById("lettres").firstChild.data=trans(this.value) */
 }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// traitement des deux parties du nombre;
function decint(n){

    switch(n.length){
        case 1 : return dix(n);
        case 2 : return dix(n);
        case 3 : return cent(n.charAt(0)) + " " + decint(n.substring(1));
        default: mil=n.substring(0,n.length-3);
            if(mil.length<4){
                un= (mil==1) ? "" : decint(mil);
                return un + mille(mil)+ " " + decint(n.substring(mil.length));
            }
            else{
                mil2=mil.substring(0,mil.length-3);
                return decint(mil2) + million(mil2) + " " + decint(n.substring(mil2.length));
            }
    }
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// traitement des nombres entre 0 et 99, pour chaque tranche de 3 chiffres;
function dix(n){
    if(n<10){
        return t[parseInt(n)]
    }
    else if(n>9 && n<20){
        return t2[n.charAt(1)]
    }
    else {
        plus= n.charAt(1)==0 && n.charAt(0)!=7 && n.charAt(0)!=9 ? "" : (n.charAt(1)==1 && n.charAt(0)<8) ? " et " : "-";
        diz= n.charAt(0)==7 || n.charAt(0)==9 ? t2[n.charAt(1)] : t[n.charAt(1)];
        s= n==80 ? "s" : "";

        return t3[n.charAt(0)] + s + plus + diz;
    }
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// traitement des mots "cent", "mille" et "million"
function cent(n){
return n>1 ? t[n]+ " cent" : (n==1) ? " cent" : "";
}

function mille(n){
return n>=1 ? " mille" : "";
}

function million(n){
return n>=1 ? " millions" : " million";
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// conversion du nombre
function trans(n){

    // vérification de la valeur saisie
    if(!/^\d+[.,]?\d*$/.test(n)){
        return "L'expression entrée n'est pas un nombre."
    }

    // séparation entier + décimales
    n=n.replace(/(^0+)|(\.0+$)/g,"");
    n=n.replace(/([.,]\d{2})\d+/,"$1");
    n1=n.replace(/[,.]\d*/,"");
    n2= n1!=n ? n.replace(/\d*[,.]/,"") : false;

    // variables de mise en forme
    ent= !n1 ? "" : decint(n1);
    deci= !n2 ? "" : decint(n2);
    if(!n1 && !n2){
        return  "Zéro Francs CFA. (Mais, de préférence, entrez une valeur non nulle!)"
    }
    conj= !n2 || !n1 ? "" : "  et ";
    euro= !n1 ? "" : !/[23456789]00$/.test(n1) ? " Francs CFA" : " Francs CFA";
    centi= !n2 ? "" : " centime";
    pl=  n1>1 ? "" : "";
    pl2= n2>1 ? "" : "";

    // expression complète en toutes lettres
    return (ent + euro + pl + conj + deci + centi + pl2).replace(/\s+/g," ").replace("cent s E","cents E");

}

</script>

	</body>
	<script type="text/javascript">


		// function Aff3()
		// {	if (checkbox_aib.checked) {
		// 		  if (checkbox_tva.checked)
		// 			document.getElementById("edit9").value=Math.round(mHT-document.getElementById("hidden1").value-document.getElementById("hidden2").value);
		// 		  else
		// 			 document.getElementById("edit9").value=Math.round(mHT-document.getElementById("hidden2").value);
		// 		}
		// 	else
		// 		{if (checkbox_tva.checked)
		// 			document.getElementById("edit9").value=Math.round(mHT-document.getElementById("hidden1").value);
		// 		 else
		// 			 document.getElementById("edit9").value=mHT;
		// 		}
		//
		// }


		function action(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit3').value = leselect;
					}
				}
				xhr.open("POST","enmontant.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo1');
				sel1 = document.getElementById('edit2');
				sh1=sel1.value;
				sh = sel.options[sel.selectedIndex].value;
				xhr.send("type="+sh+"&num="+sh1);
		}



		function action1(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit4').value = leselect;
					}
				}
				xhr.open("POST","endue.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo1');
				sel1 = document.getElementById('edit2');
				sh1=sel1.value;
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("type="+sh+"&num="+sh1);
		}

		function action2(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit9').value = leselect;
					}
				}
				xhr.open("POST","montantdue.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit6');
				sh2=sel.options[sel.selectedIndex].value;
				sel1 = document.getElementById('ladate');
				sh1=sel1.value;
				sh_1 = document.getElementById('ladate2');
				sh = sh_1.value;
				xhr.send("nom="+sh2+"&date1="+sh1+"&date2="+sh);
		}

		var momoElement = document.getElementById("edit2");
		if(momoElement.addEventListener){
		  momoElement.addEventListener("blur", action, false);
		  momoElement.addEventListener("keyup", action, false);
		  momoElement.addEventListener("blur", action1, false);
		  momoElement.addEventListener("keyup", action1, false);
		}else if(momoElement.attachEvent){
		  momoElement.attachEvent("onblur", action);
		  momoElement.attachEvent("onkeyup", action);
		  momoElement.attachEvent("onblur", action1);
		  momoElement.attachEvent("onkeyup", action1);

		}

		var momoElement2 = document.getElementById("edit6");
		if(momoElement2.addEventListener){
		  momoElement2.addEventListener("blur", action2, false);
		  momoElement2.addEventListener("keyup", action2, false);
		  momoElement2.addEventListener("change", action2, false);
		}else if(momoElement2.attachEvent){
		  momoElement2.attachEvent("onblur", action2);
		  momoElement2.attachEvent("onkeyup", action2);
		  momoElement2.attachEvent("change", action2);

		}


		function changer()
		{
			if (document.getElementById("edit9").value!='')
			{
				document.getElementById("t").value=parseInt(document.getElementById("edit9").value);
			}
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
