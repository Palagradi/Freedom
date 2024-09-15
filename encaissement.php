<?php  //echo $_SESSION['pourcent'];
	//session_start();
	//ob_start();
	include 'menu.php';  $ConnexeI=isset($_GET['Connexe'])?$_GET['Connexe']:0;
	include 'others/footerpdf.inc'; unset($_SESSION['numrecu']);unset($_SESSION['fact']); unset($_SESSION['Foriginal1']);unset($_SESSION['Foriginal2']);
	unset($_SESSION['groupe']);unset($_SESSION['groupe1']); unset($_SESSION['fiche']); unset($_SESSION['code_reel']); unset($_SESSION['Normalise']);
	unset($_SESSION['EtatF']);$_SESSION['EtatF']='V';
	$A=mysqli_query($con,"SELECT num_fact  FROM configuration_facture");
	$data=mysqli_fetch_assoc($A);
	$num_fact=$data['num_fact'];
	$_SESSION['num_fact']=$num_fact;
	unset($_SESSION['idr']); //echo $_SESSION['userId'];
	unset($_SESSION['remise']);unset($_SESSION['']);unset($_SESSION['exhonerer_tva']);unset($_SESSION['aIb']);unset($_SESSION['tVa']);unset($_SESSION['reimprime']);

	$_SESSION["path"] = getURI();  $cham=!empty($_GET['cham'])?$_GET['cham']:NULL;  //echo $_SESSION['serveurused'];

	$mode=!empty($_GET['mode'])?$_GET['mode']:NULL;  $PaymentDto = "ESPECE"; //Par défaut
	 if(isset(($mode))&&!empty($mode))
		{   $mode=strtoupper($mode);
			if($mode==2) $PaymentDto = "CHEQUE"; else if($mode==3) $PaymentDto = "VIREMENT"; else if($mode==4) $PaymentDto = "CARTE BANCAIRE";
			else if($mode==5) $PaymentDto = "MOBILE MONEY"; else if($mode==6) $PaymentDto = "AUTRE"; else $PaymentDto = "ESPECE";
		}


		include 'chiffre_to_lettre.php';  $codegrpe=!empty($_GET['codegrpe'])?$_GET['codegrpe']:NULL;$impaye=!empty($_GET['impaye'])?$_GET['impaye']:NULL;$sal=!empty($_GET['sal'])?$_GET['sal']:NULL;$numresch=!empty($_GET['numresch'])?$_GET['numresch']:NULL;
	$reduce=!empty($_GET['reduce'])?$_GET['reduce']:NULL;$EtatG=!empty($_GET['etatget'])?$_GET['etatget']:NULL;$n=!empty($_GET['n'])?$_GET['n']:NULL;$Ttypeoccup=!empty($_GET['typeoccup'])?$_GET['typeoccup']:NULL;
	//echo $numero=!empty($_GET['numero'])?$_GET['numero']:NULL;

 //echo $_SESSION['verrou'];
	//$query="SELECT * FROM  cloturecaisse WHERE DateCloture = '".$Jour_actuel."' AND utilisateur='".$_SESSION['login']."'";
	$DateCloture=$Jour_actuel;
	$query="SELECT * FROM  cloturecaisse WHERE state='0'";
	$req1 = mysqli_query($con,$query) or die (mysqli_error($con));
	while($close=mysqli_fetch_array($req1)){
		$Heure= $close['Heure']; $utilisateur= $close['utilisateur'];
		$DateCloture=$close['DateCloture'];
	}

$query2="SELECT * FROM  cloturecaisse WHERE state='1' AND DateCloture='".$Jour_actuel."'";
$req2 = mysqli_query($con,$query2) or die (mysqli_error($con));
$close2=mysqli_fetch_assoc($req2);	 $Heure= isset($close2['Heure'])?$close2['Heure']:NULL;

//echo $_SESSION['verrou'];
//echo mysqli_num_rows($req1); echo "-".mysqli_num_rows($req2)."-".$DateCloture."-".$Jour_actuel;

	if(!empty($codegrpe))
	{	/* $res1=mysqli_query($con,"SELECT groupe.code_reel  FROM fiche1,groupe WHERE groupe.codegrpe='$codegrpe'");
			while ($ret=mysqli_fetch_assoc($res1))
				{	  $code_reel=$ret['code_reel'];
				}

			$res1=mysqli_query($con,"SELECT min(fiche1.datarriv) AS min_date FROM fiche1,compte WHERE fiche1.codegrpe='$codegrpe'AND fiche1.etatsortie='NON'");
			while ($ret=mysqli_fetch_assoc($res1))
				{	 $min_date=$ret['min_date'];
				}
			$res1=mysqli_query($con,"SELECT min(fiche1.datarriv) AS min_date FROM fiche1,compte WHERE fiche1.codegrpe='$codegrpe'AND fiche1.etatsortie='OUI'");
				while ($ret=mysqli_fetch_assoc($res1))
				{	 $min_date2=$ret['min_date'];
				}
			if(!empty($min_date2))
			{if((!empty($min_date))&&($min_date2<=$min_date))
				$min_date=$min_date2;
			if(empty($min_date))
				$min_date=$min_date2;
			}
			$ans=substr($min_date,0,4);
			$mois=substr($min_date,5,2);
			$jour=substr($min_date,8,2);
			$_SESSION['debut']=substr($min_date,8,2).'-'.substr($min_date,5,2).'-'.substr($min_date,0,4);

			$res1=mysqli_query($con,"SELECT max(fiche1.datdep) AS max_date FROM fiche1,compte WHERE fiche1.codegrpe='$codegrpe'AND fiche1.etatsortie='NON'");
			while ($ret=mysqli_fetch_assoc($res1))
				{	 $max_date=$ret['max_date'];
				}
			$_SESSION['fin']=substr($max_date,8,2).'-'.substr($max_date,5,2).'-'.substr($max_date,0,4);


		//Pour connaitre le montant des occupants journalier
		$sql2=mysqli_query($con,"SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,compte.due,
		view_client.prenomcli AS prenom2, chambre.nomch, compte.tarif, compte.tva,compte.ttc_fixe, compte.taxe,compte.typeoccup, compte.ttc, fiche1.datarriv,compte.nuite,compte.np
		FROM client, fiche1, chambre, compte, view_client
		WHERE fiche1.numcli_1 = client.numcli
		AND fiche1.numcli_2 = view_client.numcli
		AND fiche1.codegrpe = '$codegrpe'
		AND chambre.numch = compte.numch
		AND compte.numfiche = fiche1.numfiche
		AND fiche1.etatsortie = 'NON'
		UNION
		SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,compte.due,
		view_client.prenomcli AS prenom2, chambre.nomch, compte.tarif, compte.tva,compte.ttc_fixe, compte.taxe,compte.typeoccup, compte.ttc, fiche1.datarriv,compte.nuite,compte.np
		FROM client, fiche1, chambre, compte, view_client
		WHERE fiche1.numcli_1 = client.numcli
		AND fiche1.numcli_2 = view_client.numcli
		AND fiche1.codegrpe = '".$codegrpe."'
		AND chambre.numch = compte.numch
		AND compte.numfiche = fiche1.numfiche
		AND fiche1.etatsortie = 'OUI' AND compte.due>0
		LIMIT 0 , 30" );
		$som1=0;$som2=0;$i=1;$j=0;$table=array("");$datarriv1=array();$nbre_sql=mysqli_num_rows($sql2);$due=0;
  		while($row=mysqli_fetch_assoc($sql2))
			{   $nomch=$row['nomch'];
				$tarif=$row['tarif'];
                $type=$row['typeoccup'];
				$n=round((strtotime(date('Y-m-d'))-strtotime($row['datarriv']))/86400);
				$dat=(date('H')+1);
				settype($dat,"integer");
				if ($dat<14){$n=$n;}else {$n= $n+1;}
				if ($n==0){$n= $n+1;} $n=(int)$n;
				$table[$j]=$n;
				$mt=$row['ttc_fixe']*$n;
				$mt1=$row['ttc_fixe']*$row['np'];
				$datarriv=$row['datarriv'];
				$datarriv1[$j]=$row['datarriv'];
			$due+=$row['due'];
			$som1+=$mt;
			$som2=$som2+$mt1;
			$i++;$j++;
			}


		$sql2=mysqli_query($con,"SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,compte.due,
		view_client.prenomcli AS prenom2, chambre.nomch, compte.tarif, compte.tva,compte.ttc_fixe, compte.taxe,compte.typeoccup, compte.ttc,compte.ht,fiche1.datarriv,compte.nuite,compte.np
		FROM client, fiche1, chambre, compte, view_client
		WHERE fiche1.numcli_1 = client.numcli
		AND fiche1.numcli_2 = view_client.numcli
		AND fiche1.codegrpe = '".$codegrpe."'
		AND chambre.numch = compte.numch
		AND compte.numfiche = fiche1.numfiche
		AND fiche1.etatsortie = 'NON'
		LIMIT 0 , 30" );
		$som1=0;$som2=0;$i=1;$j=0;$table=array("");$due=0;$montant_ht=0;
  		while($row=mysqli_fetch_assoc($sql2))
			{   $nomch=$row['nomch'];
				$tarif=$row['tarif'];
                $type=$row['typeoccup'];
				$n=round((strtotime(date('Y-m-d'))-strtotime($row['datarriv']))/86400);
				$dat=(date('H')+1);
				settype($dat,"integer");
				if ($dat<14){$n=$n;}else {$n= $n+1;}
				if ($n==0){$n= $n+1;} $n=(int)$n;
				$table[$j]=$n;
				$mt=$row['ttc_fixe']*$n;
				$mt1=$row['ttc_fixe']*$row['np'];
				$datarriv=$row['datarriv'];	$ht=$row['ht'];
			$due+=$row['due'];
			$som1+=$mt; $montant_ht+=$ht;
			$som2+=$mt1;
			$i++;$j++;
			}
		//for($i=0;$i<$nbre_sql;$i++) echo "".$datarriv1[$i]."";

		//Pour connaitre le montant des occupants de chambre qui sont en impayés
		$sql2=mysqli_query($con,"SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,fiche1.datarriv,
		view_client.prenomcli AS prenom2, chambre.nomch, compte.tarif, compte.tva,compte.ttc_fixe, compte.taxe,compte.typeoccup, compte.ttc,compte.ht, fiche1.datarriv,compte.nuite,compte.np,compte.due,compte.N_reel,compte.ttc
		FROM client, fiche1, chambre, compte, view_client
		WHERE fiche1.numcli_1 = client.numcli
		AND fiche1.numcli_2 = view_client.numcli
		AND fiche1.codegrpe = '$codegrpe'
		AND chambre.numch = compte.numch
		AND compte.numfiche = fiche1.numfiche
		AND fiche1.etatsortie = 'OUI' AND compte.due>0
		LIMIT 0 , 30" );
		$i=1;$somme_due=0;$ttc0=0;$montant_ht2=0;
  		while($row=mysqli_fetch_assoc($sql2))
			{  	$N_reel=$row['N_reel'];
				$datarriv2=$row['datarriv'];
				$ttc=$row['ttc'];$ht2=$row['ht'];
				//echo $datarriv."".$datarriv2;
						$somme_due+=$row['due'];
				//if($datarriv==$datarriv2)
				if (in_array ($datarriv2, $datarriv1))
						 $etat=1;
				$ttc+=$ttc;$montant_ht2+=$ht2;
				$i++;
			}
		//echo $datarriv2."".$datarriv1;
		 $montantdu=$som1-$som2+$somme_due; */
	}
	else
	{//$_SESSION['debut']="";$_SESSION['fin']="";
	}
	$numfiche1=!empty($_GET['numfiche1'])?$_GET['numfiche1']:NULL;$fiche=!empty($_GET['fiche'])?$_GET['fiche']:NULL;$numero=!empty($_GET['numero'])?$_GET['numero']:NULL; $numfiche=!empty($_GET['numfiche'])?$_GET['numfiche']:NULL; $somme=!empty($_GET['somme'])?$_GET['somme']:NULL;
	$due=!empty($_GET['due'])?$_GET['due']:NULL;
	$_SESSION['due']=$due;
		if(!empty($numfiche))
		{$queryRecordset = "SELECT  NumIFU from client c JOIN mensuel_fiche1 m WHERE m.numcli_1=c.numcli AND numfiche LIKE '".$numfiche."'";
		$Result=mysqli_query($con,$queryRecordset);$data=mysqli_fetch_object($Result);  $NumIFU=isset($data->NumIFU)?$data->NumIFU:NULL;}

		$res=mysqli_query($con,"SELECT ttc_fixe  FROM mensuel_compte,mensuel_fiche1 WHERE mensuel_compte.numfiche=mensuel_fiche1.numfiche  AND mensuel_fiche1.numfiche='$numfiche'");
			$ret=mysqli_fetch_assoc($res);
				{	$ttc_fixe=$ret['ttc_fixe'];
				}
		//$i = 1;
		$res=mysqli_query($con,"CREATE TABLE `table_tempon` (`montant` int NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1");
		$table=array("");
		if($ttc_fixe!=0)
			$compteur=$due/$ttc_fixe; $compteur=isset($compteur)?$compteur:1;
		//$comparant=$ttc_fixe;
		for($l=1;$l < $compteur;$l++)
			{ $table[$l]=$ttc_fixe*$l;
			 //echo $table[$i]."";
			//$i++;
			$req="INSERT INTO `table_tempon` (`montant`) VALUES('".$table[$l]."')";
			$res=mysqli_query($con,$req);
			}
		//Appel d'une fonction pr trier le tableau avant affichage
			for($j=0;$j < $compteur-1;$j++)
			{$min=$table[$j];
			for($k=$j+1;$k < $compteur;$k++)
				{if($min<$table[$k])
					 {$table[$j]=$table[$k];
					  $table[$k]=$min;
					 }
				}
			}

	$test = "DELETE FROM fiche1 WHERE fiche1.numcli_2=''";
	$reqsup = mysqli_query($con,$test) or die(mysql_error());

	if(!empty($sal))
	{	$res=mysqli_query($con,"SELECT sum(somme) AS somme FROM compte1 WHERE numfiche='$numfiche'");
		while ($ret=mysqli_fetch_assoc($res))
			{$var1=$ret['somme'];
			}
		$res=mysqli_query($con,"SELECT sum(ttc_fixe) AS ttc_fixe FROM compte1 WHERE numfiche='$numfiche'");
		while ($ret=mysqli_fetch_assoc($res))
			{$var2=$ret['ttc_fixe'];
			}
	}
	$res=mysqli_query($con,"SELECT numfiche  FROM exonerer_tva WHERE numfiche='$numresch'");
		while ($ret=mysqli_fetch_assoc($res))
			{$numfiche_1=$ret['numfiche'];
			}

	if((!empty($numresch))&&(empty($sal)))
	{	$res=mysqli_query($con,"SELECT sum(avancerc) AS avancerc FROM reservationch WHERE numresch='$numresch'");
		while ($ret=mysqli_fetch_assoc($res))
			{$avancerc=$ret['avancerc'];
			}
		$res=mysqli_query($con,"SELECT nuiterc AS nuiterc FROM reservationch WHERE numresch='$numresch'");
		while ($ret=mysqli_fetch_assoc($res))
			{$nuiterc=$ret['nuiterc'];
			}
		if(empty($numfiche_1))
			$res=mysqli_query($con,"SELECT sum(ttc) AS somme FROM reserverch WHERE reserverch.numresch='$numresch'");
		else
			$res=mysqli_query($con,"SELECT sum(mtrc) AS somme FROM reserverch WHERE reserverch.numresch='$numresch'");
		while ($ret=mysqli_fetch_assoc($res))
			{ $total=$ret['somme']*$nuiterc;
			}
			$due=$total-$avancerc;
		//else{
		$taxe=0;
		$res=mysqli_query($con,"SELECT typeoccuprc AS typeoccuprc FROM reserverch WHERE reserverch.numresch='$numresch'");
		while ($ret=mysqli_fetch_assoc($res))
			{  $typeoccuprc=$ret['typeoccuprc'];
			  // if($typeoccuprc=='double')
				// $taxe+=2000*$nuiterc;
			  // else
				// $taxe+=1000*$nuiterc;
			}
		//}
		if(!empty($numfiche_1))
			$due+=$taxe;
	}
	if((!empty($numresch))&&(!empty($sal)))
	{	$res=mysqli_query($con,"SELECT sum(avancerc) AS avancerc FROM reservationsal WHERE numresch='$numresch'");
		while ($ret=mysqli_fetch_assoc($res))
			{$avancerc=$ret['avancerc'];
			}

		$res=mysqli_query($con,"SELECT nuiterc AS nuiterc FROM reservationsal WHERE numresch='$numresch'");
		while ($ret=mysqli_fetch_assoc($res))
			{$nuiterc=$ret['nuiterc'];
			}
		if(empty($numfiche_1))
		$res=mysqli_query($con,"SELECT sum((0.18*mtrc)+mtrc+0.1) AS somme FROM reserversal WHERE reserversal.numresch='$numresch'");
		else
		$res=mysqli_query($con,"SELECT sum(mtrc) AS somme FROM reserversal WHERE  reserversal.numresch='$numresch'");
		while ($ret=mysqli_fetch_assoc($res))
			{if(empty($numfiche_1)) $total=(int) ($ret['somme']*$nuiterc);else $total=$ret['somme']*$nuiterc;
			}
		$due=$total-$avancerc;
	}

/* 	// automatisation du numéro
	function random2($car) {
		$string = "F";
		$chaine = "0133456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
		} */

	$res=mysqli_query($con,"DELETE FROM client_tempon");
	$_SESSION['ladate1']=isset($_POST['ladate'])?substr($_POST['ladate'],6,4).'-'.substr($_POST['ladate'],3,2).'-'.substr($_POST['ladate'],0,2):NULL;
	$_SESSION['ladate2']=isset($_POST['ladate2'])?substr($_POST['ladate2'],6,4).'-'.substr($_POST['ladate2'],3,2).'-'.substr($_POST['ladate2'],0,2):NULL;

	mysqli_query($con,"SET NAMES 'utf8'");
	$re=mysqli_query($con,"SELECT * FROM chambre,fiche1,compte,client WHERE chambre.numch=compte.numch AND fiche1.numcli_1=client.numcli AND fiche1.numfiche=compte.numfiche AND etatsortie='NON' ORDER BY chambre.numch");

		if(isset($numfiche))
			{  $query="SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,mensuel_compte.due,
			view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.ttc_fixeR,mensuel_compte.ttc_fixe,
			mensuel_compte.somme,mensuel_compte.np, mensuel_compte.typeoccup,chambre.numch AS numch, mensuel_compte.numfiche FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
			WHERE mensuel_fiche1.numcli_1 = client.numcli
			AND mensuel_fiche1.numcli_2 = view_client.numcli
			AND mensuel_fiche1.numfiche LIKE '".$numfiche."'
			AND chambre.numch = mensuel_compte.numch
			AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
			AND mensuel_fiche1.etatsortie = 'NON'";$sql2=mysqli_query($con,$query);
			$ttc_fixe=0; $i=0;$sommeArrhes=0;

			if(mysqli_num_rows($sql2)>0) $cham=1;

			while($row=mysqli_fetch_array($sql2))
				{	if($row['ttc_fixeR']>0) $ttc_fixe+=$row['ttc_fixeR']; else $ttc_fixe+=$row['ttc_fixe'];
					if($i==0){
						$edit0_1=$row['numfiche'];
						$numch=$row['numch'];
						$typeoccup=$row['typeoccup'];
						$tarif=$row['tarif'];
					}$i++; {if($row['ttc_fixeR']>0) $modulo=$row['somme'] % $row['ttc_fixeR']; else $modulo=$row['somme'] % $row['ttc_fixe'];}
					if(($row['somme']>0)&&($row['np']==0)) //Dans le cas des Arrhes
						{//$var=$row['somme']-$_GET['np']*$ttc_fixe;
						//$sommeArrhes+=$var;
						$sommeArrhes+=$row['somme'];
						}
					else //if($modulo>0)
						$sommeArrhes+=$modulo;
				}//echo $sommeArrhes;
			}

//Traitement du cas d'un impayé
if($impaye==1) {$due=isset($_GET['Mtotal'])?$_GET['Mtotal']:0; $somme=isset($_GET['Totalpaye'])?$_GET['Totalpaye']:0; }

	//if ((isset($_POST['va'])&& $_POST['va']=='VALIDER')) {
		if(isset($_POST['edit1___0'])) {  //echo $_POST['edit5'];
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
			 $_SESSION['numfiche']=$_POST['edit15']; $_SESSION['client']=!empty($_POST['client'])?$_POST['client']:NULL;
			 $_SESSION['Numclt']=!empty($_POST['Numclt'])?$_POST['Numclt']:NULL;
			 $_SESSION['remise']=0; $_SESSION['cham']= $_POST['cham'];

			$_SESSION['somme']=$_POST['edit3']; $_SESSION['sommePayee']=$_POST['edit5'];
			$_SESSION['Mtotal']=$_POST['Mtotal']+(int)$_POST['arrhes'];
			if($_POST['edit5']>$_SESSION['Mtotal']) $_SESSION['Mtotal']=$_POST['edit5'];
			if(isset($_POST['remise'])&&($_POST['remise']>0)) $_SESSION['Mtotalr']=$_POST['edit3']-$_POST['arrhes'];
			$_SESSION['avanceA']=$_POST['Rpayer'];

			$_SESSION['remise']=$_POST['remise'];
			$_SESSION['pourcent'] = $_POST['pourcent'];

			$i=0;  // if(!empty($_POST['impaye']))
			$_SESSION['solde']=$_POST['solde'];  // Valeur 1 : le client a soldé sa facture
			$_SESSION['sal']=$_POST['sal'];

			$_SESSION['NormSencaisser']=0; if(isset($impaye) && isset($_GET['solde']) && ($_GET['solde']==0)) $_SESSION['NormSencaisser']=1;

		if(isset($_POST['button_checkbox_1'])) {

/* 					$sqli="SELECT RegimeTVA,ttva,compte.typeoccup,compte.numch,chambre.typech,chambre.DesignationType,compte.somme,compte.ttc_fixeR,compte.ttc_fixe,compte.np,compte.tarif AS tarif1,nomcli,prenomcli,nomch,fiche1.datarriv as datarriv,compte.date AS date FROM chambre,fiche1,compte,client WHERE chambre.numch=compte.numch AND fiche1.numcli_1=client.numcli AND fiche1.numfiche=compte.numfiche and fiche1.numfiche='".$_POST['edit2']."'";
					$s=mysqli_query($con,$sqli);
					while($ez=mysqli_fetch_assoc($s))
					{	$date=$ez['date'];  $_SESSION['RegimeTVA']=$RegimeTVA;
						$_SESSION['datarriv']=$ez['datarriv'];
						if(empty($date))
							{$_SESSION['date']=substr($ez['datarriv'],8,2).'-'.substr($ez['datarriv'],5,2).'-'.substr($ez['datarriv'],0,4);
							}
						else{
						$date1=substr($date,0,2); $date2=substr($date,3,2); $date3=substr($date,6,4);
						$date=date("d/m/Y", mktime(0,0,0,date($date2),date($date1),date($date3)));
						//$date=str_replace('-','/',$date);
						$_SESSION['date']=$date;
						}
					}
					$date=str_replace('/','-',$_SESSION['date']);
					$_SESSION['debuti']=	$_SESSION['date'];

			$update=mysqli_query($con,"UPDATE configuration_facture SET num_fact=num_fact+1 ");
			if($_POST['edit1___0']>$_POST['Np']) {
				$_SESSION['retro']=1;
				$_SESSION['avanceA']=(int)$_POST['edit1__0']+(int)$_POST['edit5'];
			}

					$_SESSION['button_checkbox_2'] = $_POST['button_checkbox_2'];
					echo "<center><iframe src='checkingOK.php";  echo "' width='1000' height='800' style=''></iframe></center>"; */

		}
		else {

		//if(($_POST['Rpayer']!='')&&($_POST['Rpayer']!=0)){
		if((($_POST['Rpayer']!='')&&($_POST['Rpayer']!=0))|| isset($_POST['view'])|| ($_SESSION['NormSencaisser']==1)|| ($_POST['Vente']==1)){
			if(isset($_POST['edit5'])&& $_POST['edit5']>0) $updateBD=1; else $updateBD=0; $_SESSION['updateBD']=$updateBD;

			$_SESSION['impaye']=$_POST['impaye']; $_SESSION['Nd']=$_POST['Nd'];  
			
			if(isset($_POST['view'])) $_SESSION['view']=$_POST['view'];
			
			//Facture impayee

		if(((mysqli_num_rows($req1)>0)&&($DateCloture==$Jour_actuel)&&(mysqli_num_rows($req2)<=0)) || ((mysqli_num_rows($req1)<=0)&&($DateCloture==$Jour_actuel)&&(mysqli_num_rows($req2)<=0)) || isset($_POST['view']) || (isset($_POST['Vente'])&&($_POST['Vente']==1)))
		//if((mysqli_num_rows($req1)==0)&&($DateCloture!=$Jour_actuel))
			{

			// $_SESSION['aIb']=round($_POST['mHT']*0.01,4); $_SESSION['tVa']=round($_POST['mHT']*0.18,4);

			 mysqli_query($con,"SET NAMES 'utf8' ");
/* 				switch ($_POST['combo1'])
				{
				case 'fiche': */
				if(($_POST['combo1']=="Hébergement")|| ($_POST['Vente']==1))
				{  if($_POST['Vente']!=1){
					$s=mysqli_query($con,"SELECT ttva,compte.typeoccup,compte.numch,chambre.typech,chambre.DesignationType,compte.somme,compte.ttc_fixeR,compte.ttc_fixe,compte.np,compte.tarif AS tarif1,nomcli,prenomcli,nomch,fiche1.datarriv as datarriv,compte.date AS date FROM chambre,fiche1,compte,client WHERE chambre.numch=compte.numch AND fiche1.numcli_1=client.numcli AND fiche1.numfiche=compte.numfiche and fiche1.numfiche='".$_POST['edit2']."'");
					while($ez=mysqli_fetch_assoc($s))
					{$_SESSION['tarif']=$ez['tarif1'];

					$_SESSION['montant_ttc']=isset($ez['ttc'])?$ez['ttc']:0;

					$Ttotal=isset($_POST['Ttotal'])?$_POST['Ttotal']:0;

					if(isset($_POST['exhonerer_tva']) || isset($_POST['']) || (isset($_POST['exhonerer_tva']) && isset($_POST[''])))
						{
							if(isset($_POST['remise'])&&($_POST['remise']>0))
								$edit5=$_POST['remise']+$_POST['edit3T']-$Ttotal;
							else
								$edit5=$_POST['edit3T']-$Ttotal;

							//$_SESSION['']=$_POST[''];$_SESSION['exhonerer_tva']=$_POST['exhonerer_tva'];
						}
					else{   if(isset($_POST['view'])) $edit55=$_POST['Mtotal'] ; else $edit55=$_POST['edit5'];
							if(isset($_POST['remise'])&&($_POST['remise']>0))
								$edit5=$_POST['remise']+$edit55-$Ttotal;
							else
								$edit5=$edit55-$Ttotal;
						}

					$somme=$ez['somme']+ $edit5;

					$somme=isset($_GET['due'])?$_GET['due']:0;	 //$due=$ez['ttc']- $somme;

					$_SESSION['datarriv']=$ez['datarriv'];
					$_SESSION['remise']=$_POST['remise'];
					if($ez['ttc_fixeR']>0) $np=$edit5/$ez['ttc_fixeR'];else $np=$edit5/$ez['ttc_fixe'];
					$date=$ez['date'];
					$numch=$ez['numch'];
					if(empty($date))
						{$_SESSION['date']=substr($ez['datarriv'],8,2).'/'.substr($ez['datarriv'],5,2).'/'.substr($ez['datarriv'],0,4);
						}
					else{
					$date1=substr($date,0,2); $date2=substr($date,3,2); $date3=substr($date,6,4);
					$date=date("d/m/Y", mktime(0,0,0,date($date2),date($date1),date($date3)));
					//$_SESSION['date']=$d;
					$date=str_replace('-','/',$date);
					$_SESSION['date']=$date;}
					//$_SESSION['datdep']=$ez['datdep'];
					$_SESSION['num']=$_POST['edit2'];
					$np1=$ez['np'];
					if($ez['ttc_fixeR']>0) $_SESSION['ttc_fixe']=$ez['ttc_fixeR'];else $_SESSION['ttc_fixe']=$ez['ttc_fixe'];
					//if($ez['typech']=='V') $_SESSION['tch']='Ventillée'; else $_SESSION['tch']='Climatisée';
					$_SESSION['tch']=$ez['DesignationType'];
					$_SESSION['occup']=$ez['typeoccup'];
					$np2=$np1+$np;
					$_SESSION['np']=$np2;
					$_SESSION['cli']=$ez['nomcli']." ".$ez['prenomcli'];$_SESSION['nomch']=$ez['nomch'];
					}
				}
				else {
					$_SESSION['datarriv']="";
					$_SESSION['remise']=$_POST['remise'];
					//if($ez['ttc_fixeR']>0) $np=$edit5/$ez['ttc_fixeR'];else $np=$edit5/$ez['ttc_fixe'];
					$date="";
					//$numch=$ez['numch'];
					$_SESSION['date']="";
					$_SESSION['num']=$_POST['edit2'];
					//$_SESSION['ttc_fixe']=$ez['ttc_fixe'];
					//$_SESSION['tch']=$ez['DesignationType'];
					//$_SESSION['occup']=$ez['typeoccup'];
					//$np2=$np1+$np;
					$_SESSION['np']=isset($np2)?$np2:0;
					//$_SESSION['cli']=$ez['nomcli']." ".$ez['prenomcli'];$_SESSION['nomch']=$ez['nomch'];
				}

			$_SESSION['somme']=$_POST['edit3']; $_SESSION['sommePayee']=$_POST['edit5'];
			$_SESSION['Mtotal']=$_POST['Mtotal']+(int)$_POST['arrhes'];
			if(isset($_POST['remise'])&&($_POST['remise']>0)) $_SESSION['Mtotalr']=$_POST['edit3']-$_POST['arrhes'];
			$_SESSION['avanceA']=$_POST['Rpayer'];

			$_SESSION['remise']=$_POST['remise'];
			$_SESSION['pourcent'] = $_POST['pourcent'];

			$_SESSION['n']=abs($_POST['n']);
			$_SESSION['arrhes']=(int)$_POST['arrhes']; $_SESSION['NuitePayee']=$_POST['edit1_0'];

			$_SESSION['N']=$_POST['n'];  //$_SESSION['N']=$_POST['edit1_0'];   //

			$ttc_fixe=$_POST['ttc_fixe'];

			 //if(isset($_POST['view'])) $Rpayer1=$_POST['Mtotal'] ;  else $Rpayer1=$_POST['Rpayer'];
			 $Rpayer1=isset($_POST['Mtotal'])?$_POST['Mtotal']:$_POST['Rpayer'];

			 $Rpayer=$Rpayer1+$_POST['ValTVA']-$_POST['ValAIB']; $numfiche=$_POST['edit0_1'];

			if(isset($_POST['exhonerer_tva'])){  //Exonere de la TVA
				$req="INSERT INTO ExonereTVA VALUES('".$Jour_actuel."','','".$numfiche."','1','".$_POST['ValTVA']."')";
				$sql=mysqli_query($con,$req);
			}
			if(isset($_POST['Apply_AIB'])){  //Appliquer AIB
						$req="INSERT INTO Applyaib VALUES('".$Jour_actuel."','','".$numfiche."','1','".$_POST['ValAIB']."','".$_POST['PourcentAIB']."')";
						$sql=mysqli_query($con,$req); $_SESSION['Apply_AIB'] = $_POST['Apply_AIB']; $_SESSION['PourcentAIB']= $_POST['PourcentAIB'];
						 $_SESSION['ValAIB']=!empty($_POST['ValAIB'])?$_POST['ValAIB']:0;
					}

			if($ttc_fixe!=0) $modulo=$Rpayer % $ttc_fixe;  if($ttc_fixe>$Rpayer1) $modulo=$_POST['edit5'];
			//+$_POST['ValTVA']-$_POST['ValAIB'];
			$_SESSION['modulo'] = isset($modulo)?$modulo:0;  //echo $_SESSION['Mtotal']."<br/>".$_SESSION['avanceA']."<br/>".$modulo  ;

			if(isset($_POST['view'])&& !empty($_POST['view'])) $_SESSION['difference'] = $_POST['edit3']-$_POST['Mtotal'];
			else {
				if($_SESSION['NormSencaisser']==1) $_SESSION['difference']=0;
				else { if(!empty($_POST['Rpayer'])&& !empty($_POST['edit3'])) $_SESSION['difference'] = $_POST['edit3']-$_POST['Rpayer']; }
				}

			if(isset($modulo)&&($modulo>0))
			$_SESSION['sommeArrhes']=$modulo;	else $_SESSION['sommeArrhes']=0; $_SESSION['recufiche'] =1;  //echo $_SESSION['sommeArrhes'];

			 if(isset($modulo) && ($modulo>0) && ($_POST['edit1_0']<=0))	// Le client a payé un montant qui ne correspond pas exactement à une nuité
				{$query = "VALUES (NULL,'".$Jour_actuel."','".$Heure_actuelle."','".$numfiche."','".$modulo."','".$_SESSION['login']."','Facture de groupe','".$_POST['numch']."','".$_POST['typeoccup']."','".$_POST['tarif']."','".$ttc_fixe."','0')";

				 if($updateBD==1){
					 if(isset($_SESSION['solde'])&&($_SESSION['solde']==1)){
					 $InsertA=mysqli_query($con,"INSERT INTO encaissement ".$query);
					 $InsertB=mysqli_query($con,"INSERT INTO mensuel_encaissement ".$query);
					 }
				 }

				if(($ttc_fixe>$Rpayer)&&($updateBD==1)){  // Le client a payé un montant inférieur à une nuité
					$query="SET somme=somme+'".$modulo."'  WHERE numfiche='".$numfiche."'";
					$reqA=mysqli_query($con,"UPDATE mensuel_compte ".$query);$reqB=mysqli_query($con,"UPDATE compte ".$query);
						echo "<script language='javascript'>";
						echo 'alertify.success("Encaissement effectué avec succès.");';
						echo "</script>";
						$update=mysqli_query($con,"UPDATE configuration_facture SET numrecu=numrecu+1 ");
						$_SESSION['nature'] = 'Hébergement';$_SESSION['ttc_fixe'] = $ttc_fixe;
						echo "<iframe src='receiptH.php";  echo "' width='600' height='675' scrolling='no' allowtransparency='true' FRAMEBORDER='yes' style='margin-left:30%;margin-top:-25px;'></iframe>";
					}
				}
			if((isset($_POST['edit1_0'])&& $_POST['edit1_0']>0)||($_POST['edit1___0']>$_POST['Np'])||(($_POST['edit1___0']>0)&&(isset($_POST['view'])))	|| (($_SESSION['NormSencaisser']==1)&&(isset($_SESSION['impaye'])))|| ($_POST['Vente']==1))    // La somme à encaisser est >= à une nuité ou bien le client voudrait se faire délivrer une facture à laquelle il à droit.
				{ 	$_SESSION['NuitePayee']=$_POST['edit1_0']; $_SESSION['num'] = $numfiche;
					if(isset($_POST['impaye'])) $_SESSION['num']=$_POST['edit2'];
					if(!empty($_POST['PaymentDto'])) $_SESSION['PaymentDto']=$_POST['PaymentDto'];
					$_SESSION['Nuitep']=$_POST['edit1_0']; $_SESSION['Fconnexe']= $_POST['Fconnexei'];
					if($_POST['edit3']==0) $_SESSION['Mtotal']=$_POST['M_total'];
					if(!empty($_POST['PeriodeC'])) $_SESSION['PeriodeC']=$_POST['PeriodeC']; 
					if(!empty($_POST['PeriodeS'])) $_SESSION['PeriodeS']=$_POST['PeriodeS'];
					$_SESSION['Nbre'] =$_POST['Nbre']; $_SESSION['Vente']=$_POST['Vente'];
					if(isset($_POST['Fusion'])) { $_SESSION['cham']=1;$_SESSION['sal']=1; }
					if(isset($_POST['button_checkbox_2']))
						{ 	 //$update=mysqli_query($con,"UPDATE configuration_facture SET num_fact=num_fact+1 ");
							if(isset($_POST['view'])) {
							$_SESSION['NuitePayee'] =$_POST['edit1___0'];
							$_SESSION['Mtotal']=$_POST['Mtotal'];  $_SESSION['avanceA'] =0;
							$_SESSION['avanceA']=0;
							$_SESSION['view'] = $_POST['view'];
							$_SESSION['Nd']=$_POST['edit1___0']; $_SESSION['solde']=0;
							}
							if(isset($_SESSION['view'])){
							echo "<a class='info1' href='".substr($_SESSION["path"],0,-4); echo "'>";
							//echo "<img src='logo/cal.gif' alt='' title='' width='20' height='20' style='border:1px solid blue;float:right;' >";
							echo "<i class='fa fa-undo' ari-hidden='true' style='float:right;color:red;'></i>";
							echo "<span style='font-size:0.9em;color:red;'>Retour au Formulaire</span></a>";
							$_SESSION['Visualiser']=1;							
							}							
							if($_POST['Vente']==1)
									{echo "<center><iframe src='checkingOKV.php";  echo "' width='1000' height='800' style=''></iframe></center>";
									}
								else
									{echo "<center><iframe src='checkingOK.php";  echo "' width='1000' height='800' style=''></iframe></center>";}
					}
				else if(isset($_POST['button_checkbox_3'])) { $_SESSION['view']=0;
						if(($_SESSION['NormSencaisser']==1)&&(isset($_SESSION['impaye']))) $_SESSION['NuitePayee'] =$_POST['edit1___0'];  //Normaliser sans encaisser
						$update=mysqli_query($con,"UPDATE configuration_facture SET numFactNorm=numFactNorm+1 ");
						//$_SESSION['NuitePayee']=(int)$_POST['edit1___0'];
							$_SESSION['Normalise']=1;
						if($_POST['edit1___0']>$_POST['Np']) 	{
							$_SESSION['retro']=1;
							$_SESSION['avanceA']=(int)$_POST['edit1__0']+(int)$_POST['edit5'];
						}

						if(($_SESSION['NormSencaisser']==1)&&(isset($_SESSION['impaye']))) $_SESSION['solde']=0;

						$connected=is_connected();
						if(($_SESSION['Vente']==1)&&(($_SESSION['serveurused']=="mecef")||(($_SESSION['serveurused']=="emecef")&&($connected=='true')))) {
							echo "<center><iframe src='checkingOKV.php";  echo "' width='1000' height='800' style=''></iframe></center>";
						}
						else if(($_SESSION['serveurused']=="mecef")||(($_SESSION['serveurused']=="emecef")&&($connected=='true')))
						{
							echo "<center><iframe src='checkingOK.php";  echo "' width='1000' height='800' style=''></iframe></center>";
						}
						else {  //Ici pour sortir la facture non normalisée
									//echo "<center>
									//	<iframe src='checkingOK.php";  echo "' width='1000' height='800' style=''></iframe>
									//</center>";
								$rallback=1;
						}
				if(!isset($rallback)){
						echo '
						<script type="text/javascript">
						$(document).ready(function(){
							let timerInterval
							Swal.fire({
							  title: "Patientez SVP !",
							  html: "Le processus de Facturation prendra fin dans <b></b> milliseconds.",
							  timer: 3500,
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

					$query = "VALUES (NULL,'".$Jour_actuel."','".$Heure_actuelle."','".$numfiche."','".$modulo."','".$_SESSION['login']."','Facture de groupe','".$_POST['numch']."','".$_POST['typeoccup']."','".$_POST['tarif']."','".$ttc_fixe."','".$_POST['edit1_0']."')";
					$InsertA=mysqli_query($con,"INSERT INTO encaissement ".$query); $InsertB=mysqli_query($con,"INSERT INTO mensuel_encaissement ".$query);

					$query="SET somme=somme+'".$modulo."'  WHERE numfiche='".$numfiche."'";
					$reqA=mysqli_query($con,"UPDATE mensuel_compte ".$query);$reqB=mysqli_query($con,"UPDATE compte ".$query);
					echo "<script language='javascript'>";
					echo 'alertify.success("Encaissement effectué avec succès.");';
					echo "</script>";

					$update=mysqli_query($con,"UPDATE configuration_facture SET numrecu=numrecu+1 ");
					//header('location:recufiche.php?menuParent=Hébergement');
					$_SESSION['nature'] = 'Hébergement';$_SESSION['ttc_fixe'] = $ttc_fixe;
					echo "<iframe src='receiptH.php";  echo "' width='600'  height='675' scrolling='no' allowtransparency='true' FRAMEBORDER='yes'  style='margin-left:30%;margin-top:-25px;'></iframe>";
					}
				 }
				}else {
						echo "<script language='javascript'>";
						echo 'alertify.error("La Somme à encaisser doit être supérieure à Zéro");';
						echo "</script>";
					}
/* 					if(is_int($np)){
					$de=mysqli_query($con,"UPDATE compte SET somme='$somme', due='$somme'-due, np='$np2',date='".$_SESSION['date']."' WHERE numfiche='".$_POST['edit2']."'");
					$deA=mysqli_query($con,"UPDATE mensuel_compte SET somme='$somme', due='$somme'-due, np='$np2',date='".$_SESSION['date']."' WHERE numfiche='".$_POST['edit2']."'");
					$s1=mysqli_query($con,"SELECT np,ttax,typeoccup,ttc_fixe,tva FROM compte WHERE numfiche='".$_POST['edit2']."'");
					$ez1=mysqli_fetch_assoc($s1);
					$_SESSION['nuit']=$ez1['np'];
					if($AppliquerTaxe=='OUI'){
					if($ez1['typeoccup']=='double'){
						if($etat_taxe==2)
							$_SESSION['ttax']=2*$Mtaxe;
						else
							$_SESSION['ttax']=$Mtaxe;
					}
					else $_SESSION['ttax']=$Mtaxe;} else $_SESSION['ttax']=0;
					$reqsel=mysqli_query($con,"SELECT valeurTaxe FROM taxes WHERE NomTaxe='TVA'");
					$data=mysqli_fetch_assoc($reqsel);
					$valeurTaxe=$data['valeurTaxe'];
					$_SESSION['tva']=round($valeurTaxe*$edit5,4);
					$_SESSION['somme']=$_POST['edit5'];
					$_SESSION['somme_due']=$_POST['edit3'];
					$_SESSION['np']=$np;
					$NomFraisConnexeC='Frais connexes';
					//echo 12;
					if ($Ttotal>0)
						{
						$s=mysqli_query($con,"SELECT *  FROM connexe,fraisconnexe WHERE connexe.id = fraisconnexe.id and fraisconnexe.numfiche='".$_POST['edit2']."' AND Ferme='NON'");
						$ret1=mysqli_fetch_assoc($s);$NomFraisConnexe =$ret1['NomFraisConnexe'];$NbreUnites=$ret1['NbreUnites'];$NomFraisConnexe ="Frais connexes à l'hébergement";
						$en=mysqli_query($con,"INSERT INTO encaissement VALUES (NULL,'".date('Y-m-d')."','".date('H:i:s')."','".$_POST['edit2']."','".$Ttotal."','".$_SESSION['login']."','$NomFraisConnexeC','','','".$Ttotal."','".$Ttotal."','$NbreUnites')");
						$en1=mysqli_query($con,"INSERT INTO mensuel_encaissement VALUES (NULL,'".date('Y-m-d')."','".date('H:i:s')."','".$_POST['edit2']."','".$Ttotal."','".$_SESSION['login']."','$NomFraisConnexeC','','','".$Ttotal."','".$Ttotal."','$NbreUnites')");
						$deB=mysqli_query($con,"UPDATE fraisconnexe SET MontantPaye='".$Ttotal."', Ferme='OUI' WHERE numfiche='".$_POST['edit2']."'");
						}
					if ($de)
					{
						$en=mysqli_query($con,"INSERT INTO encaissement VALUES (NULL,'".date('Y-m-d')."','$Heure_actuelle','".$_POST['edit2']."','".$edit5."','".$_SESSION['login']."','Encaissement chambre','$numch','".$_SESSION['occup']."','".$_SESSION['tarif']."','".$_SESSION['ttc_fixe']."','$np')");
						$enA=mysqli_query($con,"INSERT INTO mensuel_encaissement VALUES (NULL,'".date('Y-m-d')."','$Heure_actuelle','".$_POST['edit2']."','".$edit5."','".$_SESSION['login']."','Encaissement chambre','$numch','".$_SESSION['occup']."','".$_SESSION['tarif']."','".$_SESSION['ttc_fixe']."','$np')");
						//$rit=mysqli_query($con,'UPDATE utilisateur SET montant_encaisse=montant_encaisse+"'.$_POST['edit5'].'" WHERE login="'.$_SESSION['login'].'"');
						$update=mysqli_query($con,"UPDATE configuration_facture SET num_fact=num_fact+1 ");
						//$_SESSION['tva']=round($_SESSION['tarif1']*$_SESSION['nuite']*0.18,4);
						echo "<script language='javascript'> alert('Encaissement fait avec succès.'); </script>";
			           header('location:recufiche.php?menuParent=Consultation');
					}
					} *///else $msg_4="<span style='font-style:italic;font-size:0.9em;color:blue;display:block;margin-left:350px;'>La somme à encaisser doit correspondance à une certaine nuitée pour le client</span>";
				}
/* 				break;
				case 'location': */
				else if($_POST['combo1']=="location")
				{require("location1.php");
				}
/* 				break;
				case 'reservation': */
				else
				{	if(($_POST['edit3']!=0)&&(($_POST['edit5']==$_POST['edit3'])||($_POST['edit5']==$_POST['Mtotal'])))
						require("reservation.php");
					else {

						}
				}

/* 			break;
			default: echo '';
			} */
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
		}	else {
					echo "<script language='javascript'>";
					echo 'alertify.error(" Vous devez renseigner le champ Somme à encaisser");';
					echo "</script>";
				}
			}
		}
	}
 	if (isset($_POST['va1'])&& $_POST['va1']=='VALIDER')
		{ 	$montant_1=$_POST['edit9'];
		//$_SESSION['exonorer_tva']=$_POST['exonorer_tva'];$_SESSION['exonerer_AIB']=$_POST['exonerer_AIB'];
		if(($_POST['edit10']!='')&&($_POST['edit10']!=0)){
		//Pour connaitre les eventuelles dates d'arrivee des membres du groupe
		$sql2=mysqli_query($con,"SELECT DISTINCT fiche1.datarriv,fiche1.etatsortie
		FROM client, fiche1, chambre, compte, view_client
		WHERE fiche1.numcli_1 = client.numcli
		AND fiche1.numcli_2 = view_client.numcli
		AND fiche1.codegrpe = '".$_POST['edit6']."'
		AND chambre.numch = compte.numch
		AND compte.numfiche = fiche1.numfiche
		ORDER BY fiche1.datarriv ASC
		LIMIT 0 , 30" );

		$i=1;$table=array();
  		while($row=mysqli_fetch_assoc($sql2))
			{    $table['$i']=$row['datarriv'];
					if($row['etatsortie']=='OUI') $etatsortie='OUI';
			}
		$nbre=mysqli_num_rows($sql2);
		if($etatsortie!='OUI')
			{$_SESSION['du']=$_POST['ladate'];
			$_SESSION['au']=$_POST['ladate2'];
			$_SESSION['nom_client']=$_POST['edit6'];
			$_SESSION['montantdue']=$_POST['edit9'];
			$_SESSION['montantpayee']=$_POST['edit10'];
			$_SESSION['groupe']=$_POST['edit6'];
			include("verification.php");
			}
		else
			{$casse_facture=1;$_SESSION['groupe']=$_POST['edit6'];
			$_SESSION['du']=$_POST['ladate'];
			$_SESSION['au']=$_POST['ladate2'];
			$_SESSION['nom_client']=$_POST['edit6'];
			$_SESSION['montantdue']=$_POST['edit9'];
			$_SESSION['montantpayee']=$_POST['edit10'];
			$_SESSION['defalquer_impaye']=$_POST['defalquer_impaye'];
			if(!empty($_POST['impaye']))
				{$_SESSION['defalquer_impaye']=$_POST['impaye'];
					if($_POST['defalquer_impaye']==1)
						include("defalquer_oui.php");
					else
						include("defalquer_non.php");
				}else
					{//include("facture_de_grpe_unique.php");
					include("verification.php");
					}

			}
		}
		else {//$msg_4="<span style='font-style:italic;font-size:0.9em;color:blue;'>Vous devez renseigner le champ Somme à encaisser</span>";
					echo "<script language='javascript'>";
					echo 'alertify.error(" Vous devez renseigner le champ Somme à encaisser");';
					echo "</script>";
				}
		}


?>

<?php
$sqli="SELECT * FROM fraisconnexe WHERE numfiche='".$numfiche."' AND Ferme='NON'";
$s=mysqli_query($con,$sqli);
$ListeConnexe=array(); $PrixConnexe=array(); $id=array();$i=0; $Ttotal=0;$Ttotalii=0;
if($nbreresult=mysqli_num_rows($s)>0)
{	while($retA=mysqli_fetch_array($s))
		{ 	$ListeConnexe[$i]=$retA['code'];
			$Unites =$retA['NbreUnites']; $MontantUnites =$retA['PrixUnitaire'];
			$PrixConnexe[$i]=$Unites*$MontantUnites; $id[$i] =$retA['id']+$i; $i++;
			//$MontantPaye =$retA['MontantPaye'];
			$NbreUnites =$retA['NbreUnites'];  $Ttotali = $NbreUnites * $MontantUnites ;
			$Ttotal+=$Ttotali;  $Ttotalii+=$Ttotali;
		}//$Tmt=$mt+$Ttotal;
}

// if((isset($_SESSION['Ttotali']))&&($_SESSION['Ttotali']>0))
// {
// 	echo 125;
// }

$dueT=!empty($_GET['due'])?$_GET['due']:NULL;
$MTtotal=$dueT+ $Ttotal; $due+= $Ttotal;


?>


<html>
	<head>
		<script type="text/javascript" src="date-picker.js"></script>
		<script type="text/javascript" src="js/verifyCheckBoxes3.js"></script>
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
			#FraisC {
				color:blue;
			}
			a hover {
				text-decoration : underline;
			}
		</style>
		<script src="js/sweetalert.min.js"></script>
		<script src="js/sweetalert2/sweetalert2@10.js"></script>
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/sweetalert2/sweetalert.min.js"></script>

		<script src="js/jquery.min.js"></script>


	<script language='javascript'>

		function confirmation(){ //alert ('ffff');
						var somme = document.getElementById("edit5").value;
						alertify.confirm("En cliquant sur ce bouton OK, vous reconnaissez que le client a soldé sa facture d'une valeur de  ["+somme+"]. Veuillez noter que cette action est irréversible. Voulez-vous vraiment continuer ?",function(e){
						if(e) {
						$('#form').submit();
						return true;
					} else {
						return false;
					}

				});

		}

	function myFunction() {
		var mode =' <?php echo $PaymentDto; ?> ';
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


	function alertity() { var maVariable1 = '<?php echo getURI_(); ?>';
		swal({
		  title: "Are you sure?",
		  text: "Once deleted, you will not be able to recover this imaginary file!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => { var Es = willDelete;  //document.location.href=maVariable1+"&test="+Es;
		  if (willDelete) { return true;
		    swal("Poof! Your imaginary file has been deleted!", {
		      icon: "success",
		    });
		  } else { return false;
		    swal("Your imaginary file is safe!");
		  }
		});
			}


		</script>

	</head>
	<body bgcolor='azure' style="padding-top:0px;"  <?php if(isset($_GET['numfiche'])&& !isset($_GET['p'])){ ?>onload="myFunction()" <?php }?>>

	<?php
	if(isset($rallback)){
			echo "<script language='javascript'>";
			echo 'swal("Vous n\'êtes pas connectez à Internet. Par conséquent, la connexion avec eMECeF est impossible.","","error")';
			echo "</script>";
			if(isset($_GET['Vente']))
				echo '<meta http-equiv="refresh" content="1; url=loccupV.php?menuParent=Consultation" />';
			else
				{
					if(!isset($sal)) 
						echo '<meta http-equiv="refresh" content="1; url=loccup.php?menuParent=Consultation" />';  //Commentaire du 12.01.2022
					else 
						echo '<meta http-equiv="refresh" content="1; url=loccup.php?menuParent=Consultation&sal=1" />';	
				}
		}
	if(!isset($_GET['p'])) { if(isset($_GET['Vente'])) $due=$_GET['due'];
	?>
	<div align="" style="margin-top:0%;">
		<form action='<?=$_SESSION["path"]?>&p=1' method='post' name='encaissement' id='form'>

			<table align='center' style='' id="tab">
					<td>
					<input type='hidden' name='id_request' id='id_request' value='<?php if(isset($_GET['id_request'])) echo $_GET['id_request'];?>' />
					<input type='hidden' name='numFactNorm' id='numFactNorm' value='<?php if(isset($_GET['numFactNorm'])) echo $_GET['numFactNorm'];?>' />
					<input type='hidden' name='ValTVA' id='ValTVA' value='0' />
					<input type='hidden' name='ValAIB' id='ValAIB' value='0' />
					<input type='hidden' name='PourcentAIB' id='PourcentAIB' value='<?php echo isset($PourcentAIB)?$PourcentAIB:1;	?>' />
					<input type='hidden' name='TvaD' id='TvaD' value='<?php echo $TvaD;	?> ' />
					<input type='hidden' name='PeriodeC' id='Periode' value='<?php if(isset($_GET['Periode'])&& !isset($_GET['sal'])) echo $_GET['Periode'];	?>' readonly />
					<input type='hidden' name='PeriodeS' id='Periode' value='<?php  if(isset($_GET['Periode'])&& isset($_GET['sal'])) echo $_GET['Periode'];	?>' readonly />
					<input type='hidden' name='Visualiser' id='Visualiser' value='<?php echo isset($_SESSION['Visualiser'])?$_SESSION['Visualiser']:0;?> ' />
					<input type='hidden' name='mHT' id='mHT'
					value='<?php
						if(!empty($numresch))
							{$resT=mysqli_query($con,"SELECT sum(mtrc) AS mtrcT  FROM reserversal WHERE reserversal.numresch='$numresch'");
							$mtrcT=mysqli_fetch_assoc($resT); echo $mtrcTT=$mtrcT['mtrcT'];
							}
						else if(!empty($numfiche))
							{ echo $due;
							}
						else {

						}
						?>' readonly />
					<input type='hidden' name='PaymentDto'  value='<?=$PaymentDto;	?>' readonly />
					<input type='hidden' name='solde' id='solde' value='<?php if(isset($_GET['solde'])) echo $_GET['solde'];	?>' readonly />
					<input type='hidden' name='sal'  value='<?php if(isset($_GET['sal'])) echo $_GET['sal'];	?>' readonly />
					<input type='hidden' name='Ttxe' id='Ttxe'
					value='<?php
						/* $Ttxe=$Mtaxe*$n;
						if($Ttypeoccup=='individuelle')
							{ echo $Ttxe;
							}
						else
							{ echo $Ttxe*=2;
							} */

						?>' readonly />
					</td>
					<td>

					</td>
				</tr>
				<tr>
					<td>
					<fieldset  style='margin-left:auto; margin-right:auto;border:0px solid white;background-color:#D0DCE0;'>
							<legend align='center'style='color:#3EB27B;font-size:1.3em;'><b> </b></legend>
							<table width='800' style='margin-right:25px;'>
							<tr>
								<?php if(!isset($impaye)) { ?>

								<?php } ?>
								<td colspan="4">
									<?php if(((!isset($_GET['solde'])||($_GET['solde']!=2)))&& !isset($_GET['Vente'])){ ?>
								 <span>
									<a class='info1' id='FraisC' target="_blank" style="text-decoration:none;" href="popup.php?numfiche=<?php echo isset($_GET['numfiche'])?$_GET['numfiche']:$_SESSION['num']; echo "&Numclt=" ; echo isset($_GET['Numclt'])?$_GET['Numclt']:NULL; if(isset($_GET['sal'])) echo "&sal=".$_GET['sal']; ?>" onclick="window.open(this.href, 'Formulaire pour ajout de Frais Connexes ','target=_parent, height=450, width=750, top=180, left=250, color=black, toolbar=no, menubar=no, location=no, resizable=no, scrollbars=no, status=no'); return false">
									<img src='logo/add.png' alt='' title='' width='20' height='22' style='margin-top:0px;float:left;margin-left:7px;' border='0'><span style='' >&nbsp;Ajouter des Frais Connexes
									<?php if(isset($Ttotalii)&&($Ttotalii>0)) echo "<center style='color:red;'> Total : ".$Ttotalii."</center>"; ?></span></a>
								 </span>
								 <?php } ?>
									<h3 style='margin-top:-10px;margin-bottom:-20px;text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'> <?php
									if(isset($_GET['Vente'])) { if(isset($_GET['solde'])&&($_GET['solde']==0))  echo "FACTURE NORMALISEE SANS ENCAISSEMENT"; else echo "VENTE DE PRODUITS - ENCAISSEMENT"; }
									else {
										if(isset($_GET['solde'])&&($_GET['solde']==2)) echo "ENCAISSEMENT D'UNE FACTURE NORMALISEE";
										else if(isset($_GET['solde'])&&($_GET['solde']==0))  echo "FACTURE NORMALISEE SANS ENCAISSEMENT";
										else echo "ENCAISSEMENT & FACTURE NORMALISEE";
									}
/* 									else { echo "ENCAISSEMENT " ;
									if(isset($_GET['sal'])) echo "LOCATION DE SALLE";
									else {if(empty($_GET['numresch'])&& empty($_GET['codegrpe'])) echo 'FICHE INDIVIDUELLE';
									else if(!empty($_GET['codegrpe'])) echo 'FACTURE DE GROUPE'; else  echo 'RESERVATION'; }
									}  */
									?></h3>

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
										<td colspan='4'><hr style='margin-bottom:-20px;'/>&nbsp;</td>
								</tr>
								<tr>
									<td colspan='4'>
									<span>
									<a class='info1' target="" style="text-decoration:none;" href='#' style='' onclick='JSalert();return false;' >
									<img src='logo/plus.png' alt='' title='' width='28' height='25' style='margin-top:-3px;float:left;margin-right:5px;' border='0'> <span> Mode de règlement : <?=$PaymentDto ?></span></a>
									 </span>


									 <span style='float:center'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type='checkbox' name='TaxeSejour' id='button_checkbox3' onclick='pal3();' checked disabled >
 									 <label for='button_checkbox3' style='font-size:1em;color:gray;'>Taxe de Séjour	</label></span>
								<?php //echo $_GET['p'];
								if($AIBD==0){
										}else{
											echo "<span style='align:center;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input  type='checkbox' name='Apply_AIB' id='button_checkbox2' onclick='pal();' disabled/>
											<label for='button_checkbox2' style='color:#444739;font-size:1em;color:gray;'>Appliquer l'AIB	("; echo isset($PourcentAIB)?$PourcentAIB:1; echo "%) </label></span> ";
										}
								if($TvaD!=0) {

									echo "<span style='float:center'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type='checkbox' name='exhonerer_tva' id='button_checkbox1' onclick='pal2();verifyCheckBoxes4();'";
									if((isset($_GET['ttva'])&&($_GET['ttva']==0))||(isset($_GET['checkTVA'])&&($_GET['checkTVA']==0)) )
									echo "disabled checked";
									echo ">
									<label for='button_checkbox1' style='font-size:1em;color:gray;float:right;'>Exonérer de la TVA	</label></span>";

									//echo "<span style='float:right'>&nbsp; <input type='checkbox' name='Apply_tva' id='button_checkbox4' onclick='verifyCheckBoxes5();'>	<label for='button_checkbox4' style='font-size:1em;color:gray;'>Appliquer TVA	</label></span>";
									 //include_once('occupExo.php');
								}	else {
								     //echo "&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;";
								}
								?>
									</td>
								</tr>


								<input type='hidden' name='Vente' id=''  value='<?php if(isset($_GET['Vente'])) echo $_GET['Vente']; ?>' style='' readonly >


								<input type='hidden' name='cham' id=''  value='<?php if(!empty($cham)) echo $cham; ?>' style='' readonly >

								<tr>
										<td colspan='4'><hr style='margin-top:-15px;margin-bottom:-15px;'/>&nbsp;</td>
								</tr>
								<tr>
									<td><span style='margin-left:20px;'>Type d'encaissement :</span> </td>
									<td>
										<input readonly type='text' name='combo1' id='combo1' style='font-size:0.9em;'
											value='<?php
											if(isset($_GET['Vente'])) echo "Vente de produits";
											else {
												if(isset($impaye)){
													if(isset($_GET['cham'])) echo "Hébergement"; else echo "Location de salle";
												}else{
													if(!empty($numero)||isset($fiche)) echo "Hébergement";
													if(($sal==1)&&(empty($numresch))) echo "Location de salle";
													if(($numresch!='')) echo "Réservation";
												}
											}
											?>'/>

									<td><span style=''>&nbsp;&nbsp;&nbsp;N° de la Fiche :</span> </td>
									<td><input readonly type='text' name='edit2' id='edit2' value='<?php if($numfiche!='') echo $numfiche;  if($numero!='') echo $numero; if($numresch!='') echo $numresch;?>'  />
									</td>
								</tr>
								<tr>
									<td>  <span style='margin-left:20px;'>Total à encaisser :</span> </td>
									<td> <input type='text' name='edit4' id='edit4' value='<?php if(!empty($sal)) { echo $var1; }  else	{ if(isset($somme)) echo $somme; else echo 0;}  //echo $avancerc=!empty($avancerc)?$avancerc:0; ?>' readonly />   </td>
									<td> <span style=''>&nbsp;&nbsp;&nbsp;Somme due :</span> </td>
									<td> <input type='text' name='edit3' id='edit3' value='<?php $ConnexeI=!empty($ConnexeI)?$ConnexeI:0; //if(isset($_SESSION['due'])) $due=$_SESSION['due']; else 
									$due=isset($due)?$due:0; if(isset($due)&&($due>0)) echo $due-$ConnexeI; else echo 0; ?>' readonly />  <td>
								</tr>
								<?php
									//echo "SELECT ttc_fixe  FROM mensuel_compte,mensuel_fiche1 WHERE mensuel_compte.numfiche=mensuel_fiche1.numfiche  AND mensuel_fiche1.numfiche='$numfiche'";
								?>


									<?php
									if(!empty($reduce) && ($EtatG%2==0)) {

									}
									else{
									//echo "<td>"; if(($Ttotal>0))
									//echo "<span style='color:red;'>&nbsp;&nbsp;&nbsp;Somme à encaisser :</span>";
									//else echo "<span style=''>&nbsp;&nbsp;&nbsp;Somme à encaisser :</span>";
									//echo "</td>	<td> ";
									}
										if(!empty($reduce) && ($EtatG%2==0)) {

											}
											else
											{if(($Ttotal>0)){
												echo "<input type='hidden' name='Ttotal' id='Ttotal' value='".$Ttotal."'  />";
											if(($montantAuto=='OUI'))
												{  	echo " <select name='edit5' id='edit5' style='width:150px;'>";
													$res=mysqli_query($con,"SELECT DISTINCT montant FROM table_tempon order BY montant DESC ");
													$NbreR=mysqli_num_rows($res);$dueT=$due+$Ttotal;
													//if($NbreR<0)
														echo"<option value='".$dueT."'>".$dueT."</option>";
													 while ($ret= mysqli_fetch_assoc($res))
														{$MTtotal=$ret['montant']+$Ttotal;
														echo '<option value="'.$MTtotal.'">';echo($MTtotal);echo '</option>';
														}
													echo"</select>";
												}
										else{
												// echo "<input type='text' name='edit5' id='edit5' value='' onkeypress='testChiffres(event);' />";
												}
											}else{
											if(($montantAuto=='OUI'))
												{   	echo "<select name='edit5' id='edit5' style='width:150px;'>";
														echo"<option value='".$due."'>".$due."</option>";
														$res=mysql_query("SELECT DISTINCT montant FROM table_tempon order BY montant DESC ");
														 while ($ret= mysql_fetch_array($res))
															{echo '<option value="'.$ret['montant'].'">';echo($ret['montant']);echo '</option>';
															}
														echo"</select>";
												}
											else {
												//echo "<input type='text' name='edit5' id='edit5' value='' onkeypress='testChiffres(event);' />";
												}
											}
											}
										/* 	echo "<select name='edit5' id='edit5' style='width:150px;'>";
													echo"<option value='".$due."'>".$due."</option>";
												for($j=0;$j < $compteur;$j++)
													{
													echo"<option value='".$table[$j]."'>".$table[$j]."</option>";
													}
											echo"</select>"; */
											/*  	echo "<select name='edit5' id='edit5' style='width:150px;'>";
													echo"<option value='".$due."'>".$due."</option>";
													$res=mysqli_query($con,"SELECT DISTINCT montant FROM table_tempon order BY montant DESC ");
													 while ($ret= mysqli_fetch_assoc($res))
														{//$montant=$ret['montant'];
														//echo"<option value='".$montant."'>".$montant."</option>";
														echo '<option value="'.$ret['montant'].'">';echo($ret['montant']);echo '</option>';
														}
											    echo"</select>";  */

											//$etatget=!empty($etatget)?$etatget:NULL;$casse_facture=!empty($casse_facture)?$casse_facture:NULL;


								/* 		if($TvaD==0){
										}else{
											echo "
											<input type='checkbox' name='exhonerer_tva' id='button_checkbox_1' onclick='pal2();'>
											<label for='button_checkbox_1' style='color:#444739;'>Exonérer de la TVA	</label>
											";
										}
										if($AIBD==0){
										}else{
											echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input  type='checkbox' name='' id='button_checkbox_2'   onclick='pal();'/>
											<label for='button_checkbox_2' style='color:#444739;'>Exonérer de AIB	</label>";
										} */
									$etatget=!empty($etatget)?$etatget:NULL;$casse_facture=!empty($casse_facture)?$casse_facture:NULL;

									$arrhes=isset($arrhes)?$arrhes:0;

									?>


								<?php //if($reduce==1){
								 //if($EtatG%2==0) {

								echo "
								<tr>
									<td> <span style='margin-left:20px;'> % Remise accordée  :</span> </td>
									<td>
									<input type='number' name='pourcent' id='pourcent' min='0' placeholder=' %'  value='' onblur='AffA();' onchange='AffA();' onkeyup='AffA();'  onkeypress='testChiffres(event);'";
										if(isset($due)&&($due<0)) echo "readonly"; echo " max='100' />
								 </td>

									<td> <span style=''>&nbsp;&nbsp; Arrhes :</span> </td>
									<td>
									<input type='text' name='arrhes' id='arrhes' "; if($n<0)
									{if(isset($ttc_fixe)) echo "value='".abs(($ttc_fixe*$n)+$due)."'"; }
									else if($n==0) { if(($ttc_fixe!=0)&&($_GET['np']>0)) $arrhes=(int)($somme-($ttc_fixe*$_GET['np']));
									echo "value='".$arrhes."'";	}
									 else echo "value='".$sommeArrhes."'";	 echo "readonly />
									 </td>
								</tr>
								<tr>
									<td> <span style='margin-left:20px;'>Valeur de la Remise  :</span> </td>
									<td> <input type='text' name='remise' readonly id='remise' value='' placeholder='0' onblur='AffB();' onchange='AffB();' onkeyup='AffB();' onkeypress='testChiffres(event);' autocomplete='OFF' /> </td>";
								echo "<td>"; if(($Ttotal>0))  echo "<span style='color:maroon;font-weight:bold;'>&nbsp;&nbsp;&nbsp;Montant à payer :</span>";
								else echo "<span style=''>&nbsp;&nbsp;&nbsp;Net à payer :</span>";	echo "</td>";
								echo "<td>";

								//if(($Ttotal>0))	echo "<input type='hidden' name='Fconnexe' id='Fconnexe' value='".$Ttotal."'  />";

								echo "<input type='hidden' name='Fconnexe' id='Fconnexe' value='";if(($Ttotalii>0)) echo $Ttotalii; else echo 0; echo "'/>";

								//if($numfiche!='') echo $numfiche;
								$sql0="SELECT * FROM fraisconnexe WHERE Ferme ='NON' AND numfiche='".$numfiche."'";
								$iii=0;
								$req0 = mysqli_query($con,$sql0) or die (mysqli_error($con));
								if(mysqli_num_rows($req0)>0){
								$iii=1;
								}
								echo "<input type='hidden' name='Fconnexei' id='Fconnexei' value='".$iii."'  />";

								/* if(($Ttotal>0)){
												echo "<input type='hidden' name='Ttotal' id='Ttotal' value='".$Ttotal."'  />";
											if(($montantAuto=='OUI'))
												{  	echo " <select name='edit5' id='edit5' style='width:150px;'>";
													$res=mysqli_query($con,"SELECT DISTINCT montant FROM table_tempon order BY montant DESC ");
													$NbreR=mysqli_num_rows($res);$dueT=$due+$Ttotal;
													//if($NbreR<0)
														echo"<option value='".$dueT."'>".$dueT."</option>";
													 while ($ret= mysqli_fetch_assoc($res))
														{$MTtotal=$ret['montant']+$Ttotal;
														echo '<option value="'.$MTtotal.'">';echo($MTtotal);echo '</option>';
														}
													echo"</select>";
												}
											else{
												 echo "<input type='text' name='edit5' id='edit5' value='' onkeypress='testChiffres(event);' />";
												}
											}else{
											if(($montantAuto=='OUI'))
												{   	echo "<select name='edit5' id='edit5' style='width:150px;'>";
														echo"<option value='".$due."'>".$due."</option>";
														$res=mysql_query("SELECT DISTINCT montant FROM table_tempon order BY montant DESC ");
														 while ($ret= mysql_fetch_array($res))
															{echo '<option value="'.$ret['montant'].'">';echo($ret['montant']);echo '</option>';
															}
														echo"</select>";
												}
											else */
												echo "<input type='text' name='Mtotal' id='Mtotal'";
												$ConnexeI=isset($ConnexeI)?$ConnexeI:0; $due=isset($due)?$due:0;
												if(isset($impaye)) { $due-=$ConnexeI; echo "value='".$due."'"; }
												else {
													if(($n>0)|| isset($_GET['Vente']))  echo "value='".$due."'";  else echo "value='0'";
												} echo "readonly />";
											//}
											//echo round(($due-1500)/1.18);
								echo "</td>";
								echo "</tr>";

							if( isset($_GET['solde']) && (($_GET['solde']==1)||($_GET['solde']==2)))
								{
								echo "<tr>";
									echo "<td>"; //if(isset($Ttotal)&&($Ttotal>0))
									//echo "<span style='color:red;font-size:1em;margin-left:20px;'>Somme Remise :</span>";
									//else
									echo "<span style='font-size:1em;margin-left:20px;'>Somme ";
									if(isset($_GET['impaye'])) echo "à encaisser "; else echo "encaissée ";
									echo " :</span>";
									echo "</td>";
									echo "<td>";
									echo "<input type='text' name='edit5' id='edit5' value='' required autofocus onkeyup='AffC();' onchange='AffC();' onkeypress='testChiffres(event);' autocomplete='OFF'/>";
									echo "</td>
									<td><span style='font-size:1em;'>&nbsp;&nbsp;&nbsp;Total ";
									if(isset($_GET['impaye'])) echo "à payer"; else echo "payé ";
									echo " :</span>	</td>
									<td><input type='text' name='Rpayer' id='Rpayer'"; echo " placeholder='' readonly /> </td>
									</td>
								</tr>";
								}else
								{
									echo "<input type='hidden' name='edit5' id='edit5' value='0' required />";
									echo "<input type='hidden' name='Rpayer' id='Rpayer'"; echo "placeholder='' readonly />";
								}


								 ?>
								</tr>

									<input type='hidden' name='Vente' id='Vente' value='<?php if(isset($_GET['Vente'])) echo 1; else echo 0; ?>' />
									<input type='hidden' name='Nbre' id='Nbre' value='<?php if(isset($_GET['Nbre'])) echo $_GET['Nbre']; else echo 1; ?>' />

								<tr>
										<td colspan='4'><hr style='margin-bottom:-20px;'/>&nbsp;</td>
								</tr>
								<tr>

									<td align=''>&nbsp;&nbsp;
									<input type="checkbox" name='button_checkbox_1' id="button_checkbox_1"  onClick="verifyCheckBoxes1();" value='1' checked>
									<label for="button_checkbox_1" style='font-weight:bold;color:gray;'>Reçu Ticket</label>
									</td>
									<td colspan='2' align='center'>
									<input type="checkbox" name='button_checkbox_2' id="button_checkbox_2" onClick="verifyCheckBoxes2();" onchange="verifyNuite();" value='1' <?php //echo "disabled"; //if($TypeFacture==1) ?>>
									<label for="button_checkbox_2" style='font-weight:bold;color:gray;'>Facture ordinaire</label>
									</td>
									<td align='right'>&nbsp;&nbsp; &nbsp;
									<input type="checkbox" name='button_checkbox_3' id="button_checkbox_3" onClick="verifyCheckBoxes3();" onchange="verifyIFU();" value='1' <?php if($TypeFacture==0) echo "disabled"; // ?> >
									<label for="button_checkbox_3" style='font-weight:bold;color:gray;'>Facture Normalisée</label>
									</td>
								</tr>
									<tr>
										<td colspan='4'><hr style='margin-top:-15px;margin-bottom:-15px;'/>&nbsp;</td>
								</tr>
								<tr><td colspan='4' align='center'>
								<?php if($casse_facture!=1)
									if(!isset($_GET['impaye']) || (isset($_GET['impaye']) && isset($_GET['solde']))){
										echo "<input  type='button' name='va' class='bouton2'  id='btn'";
										if($_GET['solde']==0) echo 'onclick="NormaliserSencaisser();"'; else echo 'onclick="confirmation();"';
										echo "value='VALIDER'";  echo " style=''/>";
									}
									?>
								&nbsp;</tr>
							</table>
						</fieldset>
					</td>
				 <input type='hidden' name='edit15' id='edit15' readonly value="<?php //echo $chaine = random2(5);?>" />
				 <input type='hidden' name='edit_15' id='edit_15' readonly value="<?php echo $code_reel = !empty($code_reel)?$code_reel:NULL;?>" />
					<td>
						</td>
				</tr>
			</table>
			<?php

			//echo '<p><a href="popup.php" onclick="window.open(\'popup.php?form_inc=sum_ville&amp;id_region='.$id_region.'\', \'Popup\', config=\'height=400, width=400, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no\'); return false;"><img src="logo/more.png" alt="" title="" width="16" height="16" style="margin-top:0em;" border="0"> Ajouter une ville</a></p>'
			?>
			<input type='hidden' name='impaye' id='impaye'  value='<?php if(isset($_GET['impaye'])) echo $_GET['impaye']; else echo 0; ?>' />

			<input type='hidden' name='edit1__0' id='edit1__0'  value='<?php if(isset($impaye)) echo 0;	 else
			 { $np=!empty($_GET['np'])?$_GET['np']:0;	 $var=$somme -$np*$ttc_fixe; if($var>0) echo $var; else echo 0;	} ?>' />
			<input type='hidden' name='edit1___0' id='edit1___0'  value='' />
			<input type='hidden' name='edit1_0' id='edit1_0'  value='' />
			<input type='hidden' name='M_total' id='M_total'  value='<?php { if(isset($_GET['Mtotal'])) echo $_GET['Mtotal']; } ?>' />
			<input type='hidden' name='client' id=''  value='<?php { if(isset($_GET['client'])) echo $_GET['client']; } ?>' />
			<input type='hidden' name='Numclt' id=''  value='<?php { if(isset($_GET['Numclt'])) echo $_GET['Numclt']; } ?>' />
			<input type='hidden' name='Np' id='Np'  value='<?php { if(isset($_GET['np'])) echo $_GET['np']; }  ?>' />
			 <input type='hidden' name='edit0_1' id='edit0_1'  value='<?php if(isset($edit0_1)) echo $edit0_1;  ?>' />
			 <input type='hidden' name='numch' id=''  value='<?php if(isset($numch)) echo $numch; ?>' />
			 <input type='hidden' name='typeoccup' id=''  value='<?php //if(isset($typeoccup)) echo $typeoccup; ?>' />
			 <input type='hidden' name='tarif' id=''  value='<?php if(isset($tarif)) echo $tarif; ?>' />

			<input type='hidden' name='ttva' id='ttva' value='<?php if(isset($_GET['ttva'])) echo $_GET['ttva']; ?>' readonly />
			<input type='hidden' name='edit1' id='edit1' value='<?php echo $Date_actuel2; ?>' readonly />
			<input type='hidden' name='edit3T' id='edit3T' value='<?php if(!empty($sal)) { echo $var1; }  else	{ if(isset($somme)) echo $somme; else echo 0;}  //echo $avancerc=!empty($avancerc)?$avancerc:0; ?>' readonly />
			<input type='hidden' name='n' id='n'  value='<?php if(isset($n)) echo $n; ?>' />
			<input type='hidden' name='ttc_fixe' id='ttc_fixe'  value='<?php if(isset($ttc_fixe)&&($ttc_fixe>0)) echo $ttc_fixe; else if(isset($_GET['ttc_fixe'])) echo $_GET['ttc_fixe'];?>' />
			<input type='hidden' name='NumIFU' id='NumIFU' value='<?php if(isset($NumIFU)) echo $NumIFU;?>'/>
			<input type='hidden' name='' id='TypeFacture' value='<?php if(isset($TypeFacture)) echo $TypeFacture;?>'/>

			 <input type='hidden' name='impaye' id=''  value='<?php if(isset($_GET['impaye'])) echo $_GET['impaye']; ?>' />
			 <input type='hidden' name='Nd' id=''  value='<?php if(isset($_GET['Nd'])) echo $_GET['Nd']; ?>' />

      </div>

		</form>
</div>
	<?php
	}
	?>
<script type="text/javascript">
		function visualiser(){
			if((document.getElementById("edit1___0").value>0)||(document.getElementById("Vente").value>0))
			//alertify.success("Cliquez maintenant sur le bouton VALIDER pour avoir un aperçu de la facture");
			document.getElementById("button_checkbox_2").disabled = false;
			document.getElementById("button_checkbox_2").checked = true;
			document.getElementById("button_checkbox_1").checked = false;
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

			if((document.getElementById("edit1___0").value>0)||(document.getElementById("Mtotal").value==document.getElementById("Rpayer").value))
			document.getElementById("button_checkbox_2").disabled = false;
			document.getElementById("button_checkbox_2").checked = false;
			document.getElementById("button_checkbox_3").checked = true;
			document.getElementById("button_checkbox_1").checked = false;

			alertify.success("Merci de Patientez SVP");
				var timeout = setTimeout(
					function() {
						$('#form').submit();
						}
					,100);
		}
	function verifyCheckBoxes1()
			{  if((document.getElementById("button_checkbox_1").checked) )
				{//alertify.error(" Pour établir la facture normalisée, <br/> le Numéro IFU du client est requise. ");
				 	 //var timeout = setTimeout(
					//function() {
						document.getElementById("button_checkbox_3").checked = false;
						document.getElementById("button_checkbox_2").checked = false;
						//}
					//,1500);

				}
			}

	function verifyCheckBoxes2()
			{  if((document.getElementById("button_checkbox_3").checked) )
				{//alertify.error(" Pour établir la facture normalisée, <br/> le Numéro IFU du client est requise. ");
				 	 //var timeout = setTimeout(
					//function() {
						document.getElementById("button_checkbox_3").checked = false;
						//document.getElementById("button_checkbox_1").checked = true;
						//}
					//,1500);

				}
			}

	function verifyIFU(){   //
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
					{	document.getElementById("button_checkbox_1").checked = false;
						alertify.error("Le montant à encaisser ne permet pas d'établir une facture pour le client. ");
					var timeout = setTimeout(
					function() {
						document.getElementById("button_checkbox_3").checked = false;
						document.getElementById("button_checkbox_2").checked = false;
						document.getElementById("button_checkbox_1").checked = true;
						}
					,1500);
					}
					/* else {
						alertify.error("Le montant à encaisser ne permet pas d'établir une facture pour le client. ");
					var timeout = setTimeout(
					function() {
						document.getElementById("button_checkbox_2").checked = false;
						document.getElementById("button_checkbox_1").checked = true;
						}
					,1500);
					} */
				}

			}
	}
	function verifyNuite(){
			//if(document.getElementById('Rpayer').value < document.getElementById('ttc_fixe').value )
			//if((document.getElementById("Rpayer").value=='') || (parseInt(document.getElementById('Rpayer').value) < parseInt(document.getElementById('ttc_fixe').value)))
				{
					if((document.getElementById("button_checkbox_2").checked) )
					{	document.getElementById("button_checkbox_1").checked = false;
						document.getElementById("button_checkbox_3").checked = false;
						alertify.alert("Veuillez noter que l\'édition de la facture ordinaire suppose que le client n\'a pas encore soldé. En cliquant sur le bouton VALIDER, la chambre sera liberée et le client désormais disponible dans la LISTE DES IMPAYES.");
						var timeout = setTimeout(
						function() {
							//document.getElementById("button_checkbox_2").checked = false;
							//document.getElementById("button_checkbox_1").checked = true;
							//document.getElementById("Rpayer").value = 0;
							//document.getElementById("edit5").value = 0;
							}
						,1500);
						}
				}
	}

	function AffC()
		{ 
			if(document.getElementById("Visualiser").value==0){
				alertify.error("Veuillez visualiser la facture avant de la normaliser SVP.");
				document.getElementById("edit5").value="";
			}
			var arrhes = 0 ; if (document.getElementById("arrhes").value!='') arrhes = document.getElementById("arrhes").value;
			
 			if((document.getElementById("edit5").value!='')) //&& (document.getElementById("edit5").value>0))
				{
					var connexe = parseInt(document.getElementById("Fconnexe").value);
					var facture =(parseInt(document.getElementById("edit1__0").value)-connexe+parseInt(document.getElementById("edit5").value))/parseInt(document.getElementById("ttc_fixe").value);
					document.getElementById("edit1___0").value = facture;

					var variableP = parseInt(document.getElementById("edit5").value) + parseInt(arrhes);
					document.getElementById("Rpayer").value =  variableP ;
					var variable = variableP + parseInt(document.getElementById('ValTVA').value) - parseInt(document.getElementById('ValAIB').value);
					var Mtotal = parseInt(document.getElementById("Mtotal").value);

					if(variable>0)
						{	var reduction=0; if (document.getElementById("remise").value!='')  reduction = document.getElementById("edit3").value - Mtotal;
						//reduction = document.getElementById("remise").value;
							var variableR = variable + parseInt(reduction);
							//var variableR = document.getElementById("edit3").value-variable ;
						 	var ttc_fixe=document.getElementById("ttc_fixe").value;
							//var ttc_fixe=MontantHt/document.getElementById("ttc_fixe").value;

						//document.getElementById("edit1_0").value=variableR;
						document.getElementById("edit1_0").value=parseInt(variableR/ttc_fixe);

							if((document.getElementById("edit1_0").value >=1)||(facture>document.getElementById("Np").value)&&(!empty(document.getElementById("Np").value))){
								if(document.getElementById("Fconnexei").value >0) {
									if(document.getElementById("edit5").value < document.getElementById("Mtotal").value){
										//RAS
									}
									else {
									document.getElementById("button_checkbox_1").checked = false;
									//if(document.getElementById('TypeFacture').value <=0 )   //Commentaire du 09.12.2021
									if((document.getElementById('TypeFacture').value <=0 ) || ((document.getElementById("remise").value>0) && (document.getElementById("edit5").value != document.getElementById("Mtotal").value)))   //La deuxieme partie de la condition concerne un controle pour le cas d'une remise
									document.getElementById("button_checkbox_2").checked = true;
									else
										{
											if(document.getElementById("solde").value!=2){
												document.getElementById("button_checkbox_3").checked = true;
												document.getElementById("button_checkbox_2").disabled = false;
												document.getElementById("solde").value=1;
											}else
												document.getElementById("button_checkbox_1").checked = true;
										//document.getElementById("button_checkbox_3").disabled = false;
										//alertify.success("Veuillez noter que dans le cas de l\'application d\'une remise au client, la chambre sera automatiquement libérée après l\'édition de la facture normalisée. ");
										}
									}
								}else {//alert('eee');
								document.getElementById("button_checkbox_1").checked = false;
								//if(document.getElementById('TypeFacture').value <=0 )   //Commentaire du 09.12.2021
							  if((document.getElementById('TypeFacture').value <=0 ) || ((document.getElementById("remise").value>0) && (document.getElementById("edit5").value != document.getElementById("Mtotal").value)))   //La deuxieme partie de la condition concerne un controle pour le cas d'une remise
									document.getElementById("button_checkbox_2").checked = true;
								else
									{		if(document.getElementById("solde").value!=2){
											document.getElementById("button_checkbox_3").checked = true;
											document.getElementById("button_checkbox_2").disabled = true;
											document.getElementById("solde").value=1;
											}else
												document.getElementById("button_checkbox_1").checked = true;
									//document.getElementById("button_checkbox_3").disabled = false;
									//if (document.getElementById("remise").value!='')
									//alertify.success("Veuillez noter que dans le cas de l\'application d\'une remise au client, la chambre sera automatiquement libérée après l\'édition de la facture normalisée. ");
									}
								}


							}else{
								if(document.getElementById("Vente").value==1) {
									var somme = parseInt(document.getElementById("edit5").value) + parseInt(document.getElementById("arrhes").value);
									if(somme == document.getElementById("Mtotal").value){
										document.getElementById("button_checkbox_1").checked = false;
										document.getElementById("button_checkbox_2").checked = false;
										document.getElementById("button_checkbox_3").checked = true;}
								}else{
									document.getElementById("button_checkbox_2").checked = false;
									document.getElementById("button_checkbox_3").checked = false;
									document.getElementById("button_checkbox_1").checked = true;
								}
							/* 	var timeout = setTimeout(
								function() {
									document.getElementById("button_checkbox_2").checked = false;
									document.getElementById("button_checkbox_3").checked = false;
									document.getElementById("button_checkbox_1").checked = true;
									}
								,1500); */

							}
						}
				} else {
					var variable = parseInt(arrhes);
					//if(document.getElementById("edit5").value==0)
					document.getElementById("Rpayer").value =  variable ;
				}
		}

	var leselect =document.getElementById("edit3").value;  //Commentaire du 09.12.2021

	var leselect =document.getElementById("ttc_fixe").value;

	if(leselect<=20000) var TaxeSejour = 500;	else if((leselect>20000) && (leselect<=100000))	var TaxeSejour = 1500;	else	var TaxeSejour = 2500;

 	var nuite = document.getElementById("n").value;
  TaxeSejour*=nuite;  //ligne Ajoutée le 09.12.2021

  if (document.getElementById("edit3T").value==0)
		document.getElementById('edit3T').value = document.getElementById('edit3').value;

	var checkbox_aib = document.getElementById("button_checkbox2");
	var checkbox_tva = document.getElementById("button_checkbox1");

	if (document.getElementById("Ttxe").value>0)
		var mHT=document.getElementById("edit3T").value - document.getElementById("Ttxe").value;
	else
		var mHT=document.getElementById("edit3T").value

		var PourcentAIB = document.getElementById('PourcentAIB').value/100;
		var TvaD = document.getElementById('TvaD').value;    //0.18
		var TvaDHT = parseFloat(TvaD) + 1 ;  //1.18;
		var montantHT=Math.round((mHT-TaxeSejour)/TvaDHT); var TVA=Math.round(montantHT*TvaD);var AIB=Math.round(montantHT*PourcentAIB);

 function pal(){
		  if (checkbox_aib.checked) {
				  if (checkbox_tva.checked)
					  {//document.getElementById('edit3').value = Math.round(parseInt(document.getElementById("edit3T").value) - TVA+AIB);
						document.getElementById('Mtotal').value = Math.round(parseInt(document.getElementById("edit3T").value) - TVA+AIB);
						document.getElementById('ValAIB').value = AIB ; document.getElementById('ValTVA').value = TVA ;
				  	}
				  else
					  {//document.getElementById('edit3').value = Math.round(parseInt(document.getElementById("edit3T").value) + AIB);
						document.getElementById('Mtotal').value = Math.round(parseInt(document.getElementById("edit3T").value) + AIB);
					  document.getElementById('ValAIB').value = AIB ;
				  	}
			  }else {
					if (checkbox_tva.checked)
						{//document.getElementById('edit3').value = Math.round(parseInt(document.getElementById("edit3T").value) -TVA);
						document.getElementById('Mtotal').value = Math.round(parseInt(document.getElementById("edit3T").value) -TVA);
						document.getElementById('ValTVA').value = TVA ;
					 }
					else
						{//document.getElementById('edit3').value = document.getElementById('edit3T').value;
						document.getElementById('Mtotal').value = document.getElementById('edit3T').value;
					  }
			  }
		 if (document.getElementById("edit3").value!=''){

			}
		}
	 function pal2(){
		  if (checkbox_tva.checked) {
				  if (checkbox_aib.checked)
					  {//document.getElementById('edit3').value = Math.round(parseInt(document.getElementById("edit3T").value) - TVA+AIB);
						document.getElementById('Mtotal').value = Math.round(parseInt(document.getElementById("edit3T").value) - TVA+AIB);
						document.getElementById('ValTVA').value = TVA ; document.getElementById('ValAIB').value = AIB ;
					}
				  else
					  { //document.getElementById('edit3').value = Math.round(parseInt(document.getElementById("edit3T").value) - TVA);
					  	document.getElementById('Mtotal').value = Math.round(parseInt(document.getElementById("edit3T").value) -TVA);
							document.getElementById('ValTVA').value = TVA ;
					  }
			  }else {
			  		if (checkbox_aib.checked)
						 {//document.getElementById('edit3').value = Math.round(parseInt(document.getElementById("edit3T").value) + AIB);
						 document.getElementById('Mtotal').value = Math.round(parseInt(document.getElementById("edit3T").value) +AIB);
						 document.getElementById('ValAIB').value = AIB ;
					 	}
					else
						 {//document.getElementById('edit3').value = document.getElementById('edit3T').value;
						 document.getElementById('Mtotal').value = document.getElementById('edit3T').value;
					 	}
			  }
		 if (document.getElementById("edit3").value!=''){

				}
		}

	var MontantHt = Math.round((document.getElementById("edit3").value-TaxeSejour)/TvaDHT); var tva = TvaD*MontantHt;

function AffA()
{
	if (document.getElementById("pourcent").value!='')
	{
		document.getElementById("remise").value= Math.round((document.getElementById("pourcent").value/100)*MontantHt)  ;
		//document.getElementById("remise").value= Math.round(PourcentAIB*document.getElementById("pourcent").value*MontantHt)  ;
		//document.getElementById("Mtotal").value= Math.round(MontantHt+tva+leselect)  ;
		var Vpourcent = document.getElementById("pourcent").value/100;
		var montantHT2 = montantHT - document.getElementById("remise").value;
		var tva2 = Math.round(TvaD*parseFloat(montantHT - document.getElementById("remise").value));
		document.getElementById("Mtotal").value=   montantHT2 + tva2 + TaxeSejour;
		//	document.getElementById("Mtotal").value=   leselect - montantHT*Vpourcent ;
	}
}
 function AffB()
{
	if (document.getElementById("remise").value!='')
	{
		document.getElementById("pourcent").value= (100*document.getElementById("remise").value/MontantHt).toFixed(0)  ;
		document.getElementById("Mtotal").value= Math.round(MontantHt+tva+leselect)  ;
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


		function Aff()
		{document.getElementById('edit1_0').value=document.getElementById('edit9').value;
		}
		function Aff2()
		{	/* if((document.getElementById("exonorer_tva").checked == false) || (document.getElementById("exonerer_AIB").checked == false))
				{ */
				document.getElementById("edit9").value=(document.getElementById("edit9").value-document.getElementById("hidden1").value).toFixed(4);
/* 				}
			else
				{document.getElementById("edit9").value=document.getElementById("edit9").value-document.getElementById("hidden3").value);
				} */
		}
		function Aff3()
		{	/* if((document.getElementById("exonorer_tva").value!=1)||(document.getElementById("exonerer_AIB").value!=1))
				{ */
				document.getElementById("edit9").value=(document.getElementById("edit9").value-document.getElementById("hidden2").value).toFixed(4);
/* 				}
			else
				{document.getElementById("edit9").value=document.getElementById("edit9").value-document.getElementById("hidden3").value);
				}	 */

		}


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
