<?php
	include_once'menu.php';  //$req = mysqli_query($con,"DELETE FROM QteBoisson WHERE qte='Hhhh'");
	$reqCat = mysqli_query($con,"SELECT * FROM config_boisson ORDER BY LibCateg") or die (mysqli_error($con));
	//$nbre=mysqli_num_rows($req);
	$reqsel=mysqli_query($con,"SELECT * FROM boisson WHERE Depot = '1' ");
	$nbreBoisson=mysqli_num_rows($reqsel);$nbre=$nbreBoisson+1;  //$pvc=2;

		if(isset($_GET['ok'])){ 
		echo "<script language='javascript'>";  
		if(isset($_SESSION['ok'])&&($_SESSION['ok']==1)){
			if($_GET['ok']==1){
			echo 'alertify.success("Dépôt approvisionné avec succès !");';
			$_SESSION['ok']=0;
			}
			if($_GET['ok']==2){
			echo 'alertify.success("Bar approvisionné avec succès !");';
			$_SESSION['ok']=0;
			}
			if($_GET['ok']==3){
			echo 'alertify.error(" Ce type boisson existe déjà ");';
			}
			if($_GET['ok']==4){
			echo 'alertify.success("Boisson enrégistrée avec succès !");';
			}
		}
		else if(isset($_SESSION['ok'])&&($_SESSION['ok']==0)&&(isset($_GET['checkpvc']))){
			echo 'alertify.error("Pour passer au mode Pack [P] et Casier [C], Veuillez repartir dans le menu Dépôt principal.");';
		}else {}
		echo "</script>";
	}
	
	$update=isset($_GET['update'])?$_GET['update']:NULL; $delete=isset($_GET['delete'])?$_GET['delete']:NULL; $ap=isset($_GET['ap'])?$_GET['ap']:NULL;
	$add=isset($_GET['add'])?$_GET['add']:NULL; $adp=isset($_GET['adp'])?$_GET['adp']:NULL; $update2=isset($_GET['update2'])?$_GET['update2']:NULL;
	
	$NQteI=isset($_GET['NQteI'])?$_GET['NQteI']:NULL; $Npc=isset($_GET['Npc'])?$_GET['Npc']:NULL;	
				
	if(isset($_GET['checkpvc']))
		{$checkpvc=$_GET['checkpvc'];$pvc=$checkpvc;}
	else 	
		$checkpvc=isset($_POST['checkpvc'])?$_POST['checkpvc']:NULL;
	
	if(isset($update)|| isset($ap)|| isset($add)) $checkpvc=$_GET['checkpvc'];
	else {
	if((isset($checkpvc))||isset($checkpvc0))
		{   $checkpvc=1;
		}else 
		{   $checkpvc=2;
		} 
	$rek="UPDATE configresto SET pvc='".$checkpvc."'";
	$query = mysqli_query($con,$rek) or die (mysqli_error($con));
	$pvc = $checkpvc ;
		
	}
	if(isset($_GET['pvc'])) $pvc= $_GET['pvc'];
	
	if(isset($NQteI)&&(!empty($NQteI))&&($NQteI!="null")) {
		$QteInd=ucfirst(trim(strtoupper($NQteI)));
		//Vérifier l'existence dans la BD avant insertion
		 $reqsel=mysqli_query($con,"SELECT * FROM QteBoisson WHERE LibQte = '".$QteInd."' ");
	     if(mysqli_num_rows($reqsel)>0){
			echo "<script language='javascript'>";
			echo 'alertify.error("Cette quantité est déjà définie !");';
			echo "</script>";
		 }
		 else {
		$query = mysqli_query($con,"INSERT INTO QteBoisson SET LibQte='".$QteInd."'") or die (mysqli_error($con));
		echo "<script language='javascript'>";
		echo 'alertify.success("Nouvelle Quantité enrégistrée avec succès !");';
		echo "</script>";
		 }
	}
	if(isset($Npc)&&(!empty($Npc))&&($Npc!="null")) {
		$separators = "/[\/]| de /";
		$Npc=ucfirst(trim(strtolower($Npc)));
		//$pack = explode(" de ",$Npc);
		$pack = preg_split($separators,$Npc,-1, PREG_SPLIT_NO_EMPTY); 
		if(((isset($pack[0])&&(($pack[0]=="Pack")||($pack[0]=="Casier")))&& (isset($pack[1])&&(($pack[1]>0)||($pack[1]<1000))))||
		((isset($pack[0])&&(($pack[0]=="P")||($pack[0]=="C")))&& (isset($pack[1])&&(($pack[1]>0)||($pack[1]<1000)))))			
		{ 
			if($pack[1]==1){
				echo "<script language='javascript'>";
				echo 'alertify.error("Invalide. Le nombre d\'unités doit nécessairement être superieur à 1");';
				echo "</script>";
			}
			else {
			//Vérifier l'existence dans la BD avant insertion
 		   if($pack[0]=="Casier") $Npc .=" [C/".$pack[1]."]"; else $Npc .=" [P/".$pack[1]."]";
		    $query = mysqli_query($con,"INSERT INTO casier SET Libellepc='".$Npc."',qte='".$pack[1]."'") or die (mysqli_error($con));
		  	echo "<script language='javascript'>";
			if($pack[0]=="Casier")
				echo 'alertify.success("Casier enrégistré avec succès !");';
			else 
				echo 'alertify.success("Pack enrégistré avec succès !");';
			echo "</script>"; 
			}
		}else {
			echo "<script language='javascript'>";
			echo 'alertify.error("Invalide. Respectez le standard de nommage. Exemple : Pack de 48");';
			echo "</script>";
		}			
	}
	$reqQte = mysqli_query($con,"SELECT * FROM QteBoisson ORDER BY LibQte") or die (mysqli_error($con));	
	
	$reqCond= mysqli_query($con,"SELECT * FROM Conditionnement") or die (mysqli_error($con));
	
	$reqCas = mysqli_query($con,"SELECT * FROM casier") or die (mysqli_error($con));
	
	if(isset($update)||isset($add)||isset($ap)){if(!empty($pvc)&&($pvc==2)) $rowspan=9; else  $rowspan=7; 
	if(isset($update)) {
		if(!empty($pvc)&&($pvc==2))
			$req="SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson,casier WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND casier.id=boisson.pc AND pc<>0 AND numero='".$update."' AND Depot = '1'";
		else 
			$req="SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND pc=0 AND numero='".$update."' AND Depot = '1'";
	}
	else if(isset($ap)) //Ici le bar
	{
	 if($ap==0){
		echo $reqX="SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson,casier WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND casier.id=boisson.pc AND pc<>0 AND numero='".$adp."' AND Depot = '1'";
		$result0=mysqli_query($con,$reqX);$response=mysqli_fetch_object($result0);
		$numero2=$response->numero2;$pc=$response->pc;
		$Categorie=$response->Categorie;$Qte=$response->Qte;
		$designation=$response->designation;				
		$Conditionne=$response->Conditionne;
		$PrixUnitaire=$response->PrixUnitaire;
		$PrixPack=$response->PrixPack;				
		$QteStock=0;$QteStockPack=0;$QteStockPack=0;$Seuil=0;$StockReel=0;
		$RegimeTVA=$response->RegimeTVA;
		$rek1="INSERT INTO boisson SET numero2='".$numero2."',Categorie='".$Categorie."',pc='".$pc."',designation='".$designation."',Qte='".$Qte."',Conditionne='".$Conditionne."',PrixUnitaire='".$PrixUnitaire."',PrixPack='".$PrixPack."',Seuil='".$Seuil."',QteStock='".$QteStock."',StockReel='".$QteStock."',created_at='".$Jour_actuel."',updated_at='".$Jour_actuel."',Depot = '2',RegimeTVA='".$RegimeTVA."'";	
		$query = mysqli_query($con,$rek1) or die (mysqli_error($con));
		$reqX="SELECT numero FROM boisson WHERE numero2='".$numero2."' AND Depot = '2'";
		$result1 = mysqli_query($con,$reqX) or die (mysqli_error($con));$response2=mysqli_fetch_object($result1);
		$ap=$response2->numero;
	 }
		if(!empty($pvc)&&($pvc==2))
			$req="SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson,casier WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND casier.id=boisson.pc AND pc<>0 AND numero='".$ap."' AND Depot = '2'";
		else 
			$req="SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND pc=0 AND numero='".$ap."' AND Depot = '2'";
	}		
	else if(isset($add)){
		if(!empty($pvc)&&($pvc==2))
			$req="SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson,casier WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND casier.id=boisson.pc AND pc<>0 AND numero='".$add."' AND Depot = '1'";
		else 
			$req="SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND pc=0 AND numero='".$add."' AND Depot = '1'";
	}
		$reqk=mysqli_query($con,$req);
		while($dataP = mysqli_fetch_object($reqk)){
			$nbre = $dataP->numero2;$designation=$dataP->designation;
			$Categoriec=$dataP->Categorie;$Qtec=$dataP->Qte;$Conditionnec=$dataP->Conditionne;$Libellepcc=$dataP->pc;
			$Categorie=$dataP->LibCateg;$Qte=$dataP->LibQte;$Conditionne=$dataP->LibConditionne;$Seuil=$dataP->Seuil;$QteStock=$dataP->QteStock;
			$PrixUnitaire=$dataP->PrixUnitaire;$PrixPack=$dataP->PrixPack;			
			if($pvc==2){
				$Libellepc=$dataP->Libellepc;$qtepc=$dataP->qtepc;
				$PrixPack=$dataP->PrixPack; 
			}else{
				$PrixUnitaire=$dataP->PrixUnitaire;
			}
		}
	}else { if(!empty($pvc)&&($pvc==2)) $rowspan=9; else  $rowspan=7; }

	if(($nbre>=0)&&($nbre<=9)) $nbre="00000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="0000".$nbre ;else $nbre="00".$nbre ;

	if(isset($_POST['ENREGISTRER'])&& ($_POST['ENREGISTRER']=="Modifier")){
		
		    $categorie=$_POST['Libellepc'];$designation=$_POST['designation'];$Qte=$_POST['quantite'];$Conditionne=$_POST['conditionnement'];$Prix=$_POST['Prixvente'];$Seuil=(int)$_POST['Seuil'];

			$categorie=$_POST['Libellepc'];$designation=addslashes($_POST['designation']);$Qte=$_POST['quantite'];$Conditionne=$_POST['conditionnement'];$QteStock=!empty($_POST['QteStock'])?$_POST['QteStock']:0;
			$PrixUnitaire=!empty($_POST['Prixvente'])?$_POST['Prixvente']:0;  $PrixPack=!empty($_POST['PrixventeP'])?$_POST['PrixventeP']:0;
			$Seuil=!empty($_POST['Seuil'])?$_POST['Seuil']:0; $pack=!empty($_POST['pack'])?$_POST['pack']:0; 
/* 			if($_POST['pvc']==2)  //Modification de Pack de boissons
			{   $PrixPack=$PrixUnitaire; $PrixUnitaire=0; */
			if($update2!=0){
				$rek2="UPDATE boisson SET Categorie='".$categorie."', designation='".$designation."',Qte='".$Qte."',Conditionne='".$Conditionne."',pc='".$pack."',PrixUnitaire='".$PrixUnitaire."',Seuil='".$Seuil."',PrixPack='".$PrixPack."',updated_at='".$Jour_actuel."' WHERE numero='".$update2."' AND Depot = '2'";	
			}
				$rek="UPDATE boisson SET Categorie='".$categorie."', designation='".$designation."',Qte='".$Qte."',Conditionne='".$Conditionne."',pc='".$pack."',PrixUnitaire='".$PrixUnitaire."',Seuil='".$Seuil."',PrixPack='".$PrixPack."',updated_at='".$Jour_actuel."' WHERE numero='".$update."' AND Depot = '1'";
			
			$query = mysqli_query($con,$rek) or die (mysqli_error($con));$query = mysqli_query($con,$rek2) or die (mysqli_error($con));
				
				//$rek2="UPDATE boisson SET categorie='".$categorie."', designation='".$designation."',Qte='".$Qte."',Conditionne='".$Conditionne."',pc='".$pack."',PrixPack='".$PrixPack."',QteStock='".$QteStock."',updated_at='".$Jour_actuel."' WHERE numero='".$update."' AND Depot = '2'";
	/* 		}else {
				$rek="UPDATE boisson SET categorie='".$categorie."', designation='".$designation."',Qte='".$Qte."',Conditionne='".$Conditionne."',PrixUnitaire='".$PrixUnitaire."',Seuil='".$Seuil."',QteStock='".$QteStock."',updated_at='".$Jour_actuel."' WHERE numero='".$update."' AND Depot = '1'";
				$rek2="UPDATE boisson SET categorie='".$categorie."', designation='".$designation."',Qte='".$Qte."',Conditionne='".$Conditionne."',PrixUnitaire='".$PrixUnitaire."',Seuil='".$Seuil."',QteStock='".$QteStock."',updated_at='".$Jour_actuel."' WHERE numero='".$update."' AND Depot = '2'";
			} */
			

/* 			$rz="SELECT * FROM boisson WHERE numero2='".$update."' AND Depot = '1'"; $reqA=mysqli_query($con,$rz);
			$data2=mysqli_fetch_assoc($reqA);$Qte_initial= $data2['QteStock'];
			$ref="PRIN".$update ; $quantiteF=$_POST['qte']+$_POST['QteAj']; $service="Depot";	
			if($_POST['QteAj']>0) {$re="INSERT INTO operation VALUES(NULL,'".$ref."','Approvisionnement Depot','".$update."','".$Qte_initial."','".$_POST['QteAj']."','".$quantiteF."','".$Jour_actuel."','".$Heure_actuelle."','','".$_POST['QteAj']."')";
			$req=mysqli_query($con,$re);
			} */

			if($query){
			echo "<script language='javascript'>";
			echo 'alertify.success("Modification effectuée avec succès !");';
			echo "</script>";
			$req = mysqli_query($con,"SELECT * FROM config_boisson ORDER BY LibCateg") or die (mysqli_error($con));
 			if($_POST['pvc']==2)
				echo '<meta http-equiv="refresh" content="0; url=DpInterne.php?menuParent='.$_SESSION['menuParenT'].'" />';
			else 
				echo '<meta http-equiv="refresh" content="0; url=DpInterne.php?menuParent='.$_SESSION['menuParenT'].'&pvc=1" />';	 		
			}
	}
	if(isset($_POST['Enregistrer'])&&($_POST['Enregistrer']=="Enrégistrer")){
			$numero=isset($_GET['add'])?$_GET['add']:NULL;$adp=isset($_GET['adp'])?$_GET['adp']:$numero;
			if($_POST['pvc']==2) 
				$rek="SELECT QteStock as QteStock,StockReel as StockReel FROM boisson WHERE numero='".$adp."' AND pc<>'0' AND Depot = '1'";
			else 
				$rek="SELECT QteStock as QteStock,StockReel as StockReel FROM boisson WHERE numero='".$adp."' AND pc='0' AND Depot = '1'";
			$query = mysqli_query($con,$rek) or die (mysqli_error($con));
			$data=mysqli_fetch_assoc($query); $Qte_initial=isset($data['QteStock'])?$data['QteStock']:0; $qte=$Qte_initial-$_POST['QteAf'];	$Qte_initial0=isset($data['StockReel'])?$data['StockReel']:0; $qteR=$Qte_initial0-$_POST['QteAf'];
			
		if(!empty($_POST['ap']))	{	// Pour le Bar
			if($Qte_initial>=$_POST['QteAf']){

			if($_POST['pvc']==2)  //dimunition du stock de Pack du depot 
			{	$rek="UPDATE boisson SET QteStock='".$qte."',StockReel='".$qteR."' WHERE numero='".$adp."' AND pc<>'0' AND Depot = '1'";
				$query = mysqli_query($con,$rek) or die (mysqli_error($con)); //dimunition du stock du depot
				$rek="SELECT QteStock as QteStock,StockReel as StockReel FROM boisson WHERE numero='".$ap."' AND pc<>'0' AND Depot = '2'";	
			}
			else {
				$rek="UPDATE boisson SET QteStock='".$qte."',StockReel='".$qteR."' WHERE numero='".$adp."' AND pc='0' AND Depot = '1'";
				$query = mysqli_query($con,$rek) or die (mysqli_error($con)); //dimunition du stock du depot
				$rek="SELECT QteStock as QteStock,StockReel as StockReel FROM boisson WHERE numero='".$ap."' AND pc='0' AND Depot = '2'";	
			}				
			$query = mysqli_query($con,$rek) or die (mysqli_error($con));
			$data=mysqli_fetch_assoc($query); $Qte_initial0=$data['QteStock']; $qte=$Qte_initial0+$_POST['QteAf']; $qteR=$data['StockReel']+$_POST['QteAf'];
			
			if($_POST['pvc']==2)  //Augmentation Qte de Pack de boissons 
				$rek="UPDATE boisson SET QteStock='".$qte."',StockReel='".$qteR."' WHERE numero='".$ap."' AND pc<>'0' AND Depot = '2' ";
			else
				$rek="UPDATE boisson SET QteStock='".$qte."',StockReel='".$qteR."' WHERE numero='".$ap."' AND pc='0' AND Depot = '2' ";
			
			$query = mysqli_query($con,$rek) or die (mysqli_error($con)); //Augmentation du stock du bar

			$ref="BAR".$ap ; $quantiteF=$Qte_initial-$_POST['QteAf'];
			$re="INSERT INTO operation VALUES(NULL,'".$ref."','Approvisionnement Bar','".$ap."','".$Qte_initial."','".$_POST['QteAf']."','".$quantiteF."','".$Jour_actuel."','".$Heure_actuelle."','Bar','".$_POST['QteAf']."')";
			$req=mysqli_query($con,$re);

			if($query){
/* 			echo "<script language='javascript'>";
			echo 'alertify.success(" L\'approvisionnement du Bar a été effectué avec succès !");';
			echo "</script>"; */
			$req = mysqli_query($con,"SELECT * FROM config_boisson ORDER BY LibCateg") or die (mysqli_error($con));$_SESSION['ok']=1;
			if($_POST['pvc']==2)
				echo '<meta http-equiv="refresh" content="0; url=DpInterne.php?menuParent='.$_SESSION['menuParenT'].'&ok=2" />';
			else 
				echo '<meta http-equiv="refresh" content="0; url=DpInterne.php?menuParent='.$_SESSION['menuParenT'].'&pvc=1&ok=2&checkpvc='.$_GET['checkpvc'].'" />';
			}
			}else{
				echo "<script language='javascript'>";
				echo 'alertify.error("La quantité à affecter est supérieure au stock disponible dans le Dépôt");';
				echo "</script>";
				$req = mysqli_query($con,"SELECT * FROM config_boisson ORDER BY LibCateg") or die (mysqli_error($con));
/* 				if($_POST['pvc']==2)
					echo '<meta http-equiv="refresh" content="1; url=DpInterne.php?menuParent='.$_SESSION['menuParenT'].'" />';
				else 
					echo '<meta http-equiv="refresh" content="2; url=DpInterne.php?menuParent='.$_SESSION['menuParenT'].'&pvc=1" />'; */
			}
		}
		if(!empty($_POST['add'])){  //Pour le dépot
	 		$qte=$Qte_initial+$_POST['QteAf'];
			if($_POST['pvc']==2) 
				$rek="UPDATE boisson SET QteStock='".$qte."' WHERE numero='".$add."' AND pc<>'0' AND Depot = '1' ";
			else 
				$rek="UPDATE boisson SET QteStock='".$qte."' WHERE numero='".$add."' AND pc='0' AND Depot = '1' ";
			$query = mysqli_query($con,$rek) or die (mysqli_error($con)); //Augmentation du stock du depot
			
			$ref="DEPOT".$ap ; $quantiteF=$qte;
			$re="INSERT INTO operation VALUES(NULL,'".$ref."','Approvisionnement Dépôt','".$ap."','".$Qte_initial."','".$_POST['QteAf']."','".$quantiteF."','".$Jour_actuel."','".$Heure_actuelle."','Bar','".$_POST['QteAf']."')";
			$req=mysqli_query($con,$re);

			if($query){
/* 			echo "<script language='javascript'>"; 
			echo 'alertify.success(" L\'approvisionnement du Dépôt a été effectué avec succès !");';
			echo "</script>"; */
			$req = mysqli_query($con,"SELECT * FROM config_boisson ORDER BY LibCateg") or die (mysqli_error($con));$_SESSION['ok']=1;
 			if($_POST['pvc']==2)
				echo '<meta http-equiv="refresh" content="0; url=DpInterne.php?menuParent='.$_SESSION['menuParenT'].'&ok=1" />';
			else 
				echo '<meta http-equiv="refresh" content="0; url=DpInterne.php?menuParent='.$_SESSION['menuParenT'].'&pvc=1&ok=1&checkpvc='.$_GET['checkpvc'].'" />'; 
			} 
		}
	}
	if(isset($_POST['ENREGISTRER'])&& ($_POST['ENREGISTRER']=="Enrégistrer")){		
		$code=(int)$_POST['code']; $categorie=$_POST['Libellepc'];
		$req = mysqli_query($con,"SELECT * FROM config_boisson WHERE LibCateg='".$categorie."'") or die (mysqli_error($con));
		if(mysqli_num_rows($req)==0){
		 $sql="INSERT INTO config_boisson SET LibCateg='".$categorie."'";
		 $query = mysqli_query($con,$sql) or die (mysqli_error($con)); 			
		}
		$data = mysqli_fetch_object($req);
		$categorie=$data->id;
		$designation=addslashes($_POST['designation']);$Qte=$_POST['quantite'];$Conditionne=$_POST['conditionnement'];
		$QteStock=!empty($_POST['QteStock'])?$_POST['QteStock']:0;	$TPS_2=isset($_POST['TPS_2'])?$_POST['TPS_2']:1;
		$PrixUnitaire=!empty($_POST['Prixvente'])?$_POST['Prixvente']:0;$PrixPack=!empty($_POST['PrixventeP'])?$_POST['PrixventeP']:0;  $Seuil=!empty($_POST['Seuil'])?$_POST['Seuil']:0; 
		$pack=!empty($_POST['pack'])?$_POST['pack']:0; 
		if($_POST['pvc']==2)  //Gestion des Pack de boissons
		{   //$PrixPack=$PrixUnitaire; $PrixUnitaire=0;$SeuilPack=$Seuil; $Seuil=0; $QteStock=$QteStock; $QteStock=0;
			$sql0="SELECT * FROM boisson WHERE Depot = '1' AND designation='".$designation."' AND Qte ='".$Qte."' AND Conditionne='".$Conditionne."' AND pc='".$pack."'";
		}else {
			$sql0="SELECT * FROM boisson WHERE Depot = '1' AND designation='".$designation."' AND Qte ='".$Qte."' AND Conditionne='".$Conditionne."'";
		}		
		$reqsel=mysqli_query($con,$sql0);
		if(mysqli_num_rows($reqsel)>0){
			echo "<script language='javascript'>";
			//echo 'alertify.error(" Attention : Ce type boisson existe déjà ");';
			echo "</script>"; $_SESSION['ok']=1;
			if($_POST['pvc']==2)
				echo '<meta http-equiv="refresh" content="0; url=DpInterne.php?menuParent='.$_SESSION['menuParenT'].'&ok=3" />'; 
			else 
				echo '<meta http-equiv="refresh" content="0; url=DpInterne.php?menuParent='.$_SESSION['menuParenT'].'&ok=3&checkpvc='.$_GET['checkpvc'].'" />'; 
		}else{
		 $rek ="INSERT INTO boisson SET numero2='".$code."',categorie='".$categorie."',pc='".$pack."',designation='".$designation."',Qte='".$Qte."',Conditionne='".$Conditionne."',PrixUnitaire='".$PrixUnitaire."',PrixPack='".$PrixPack."',Seuil='".$Seuil."',QteStock='".$QteStock."',StockReel='".$QteStock."',created_at='".$Jour_actuel."',updated_at='".$Jour_actuel."',Depot = '1',RegimeTVA='".$TPS_2."'";
		 $rek1="INSERT INTO boisson SET numero2='".$code."',categorie='".$categorie."',pc='".$pack."',designation='".$designation."',Qte='".$Qte."',Conditionne='".$Conditionne."',PrixUnitaire='".$PrixUnitaire."',PrixPack='".$PrixPack."',Seuil='".$Seuil."',QteStock='".$QteStock."',StockReel='".$QteStock."',created_at='".$Jour_actuel."',updated_at='".$Jour_actuel."',Depot = '2',RegimeTVA='".$TPS_2."'";
		 $query = mysqli_query($con,$rek) or die (mysqli_error($con)); $query = mysqli_query($con,$rek1) or die (mysqli_error($con));
			if($query){
			echo "<script language='javascript'>";
			//echo 'alertify.success(" Boisson enrégistrée avec succès !");';
			echo "</script>";
			if($_POST['pvc']==2)
				echo '<meta http-equiv="refresh" content="0; url=DpInterne.php?menuParent='.$_SESSION['menuParenT'].'&ok=4" />'; 
			else 
				echo '<meta http-equiv="refresh" content="0; url=DpInterne.php?menuParent='.$_SESSION['menuParenT'].'&ok=4&checkpvc='.$_GET['checkpvc'].'" />'; 
			} 
		}
	}


?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" style=''>
	<head>
		<title><?php echo $title; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
		<link rel="Stylesheet" href='css/table.css' />
		<link rel="Stylesheet" type="text/css"  href='css/input.css' />
		<link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		
		<link href="js/datatables/dataTables.bootstrap4.css" rel="stylesheet">
		
		<link href="js/editableSelect/jquery-editable-select.min.css" rel="stylesheet">
		
		<script src="js/sweetalert.min.js"></script>
		
		<meta name="viewport" content="width=device-width">
		<style>
			.alertify-log-custom {
				background: blue;
			}
		#lien1:hover {
			text-decoration:underline;background-color: gold;font-size:1.1em;
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
		.rouge {
			color:#B83A1B;
		}
		</style>

		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
			<script type="text/javascript" >
			function JSalert(){
				swal("Entrez ci-dessous la nouvelle Quantité indiquée ", {
					  content: "input",
					})
					.then((value) => {
					  document.location.href='DpInterne.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&NQteI='+value;
					});
				}
			function JSalert2(){
				swal("Entrez ci-dessous le nouveau Pack ou Casier ", {			  
					content: {
					element: "input",
					attributes: {
					placeholder: "Exemple de nom : Pack de 10 ou Casier de 10 ou P/10 ou C/10",
					},
					},
					})
					.then((value) => {
					  document.location.href='DpInterne.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&Npc='+value;
					});
				}
				function devis() {
					document.getElementById('Prixvente').value=document.getElementById('Prixvente').value+document.getElementById('devise').value;
				}
			</script>
	</head>
	<body bgcolor='azure' style="overflow: visible;" >
	<div class="container">
			<form action="" method="POST" id="chgdept">
			<table align='center' width='98%' height="auto" border="0" cellpadding="0" cellspacing="0" id="tab">
	<?php

			if(!empty($_GET['delete'])){ $_SESSION['delete']=$_GET['delete'];
			echo "<script language='javascript'>";
			echo 'swal("Cette action est irréversible. Voulez-vous continuer ?", {
			  dangerMode: true, buttons: true,
			}).then((value) => { var Es = value;  document.location.href="DpInterne.php?menuParent='.$_SESSION['menuParenT'].'&test="+Es;
			}); ';
			echo "</script>";
		}  //https://sweetalert.js.org/docs/#configuration
		if(!empty($_GET['test'])&& ($_GET['test']=='true')){
			//echo $_SESSION['delete'];
/* 			$rz="SELECT * FROM produits WHERE Num='".$_SESSION['aj']."' AND Type='".$_SESSION['menuParenT1']."'"; $req=mysqli_query($con,$rz);
			$data=mysqli_fetch_object($req);  $Qte_initial= $data->Qte_Stock; $Qte_Stock=$Qte_initial+$_SESSION['qte'];$update=$data->Num2 ;
		 	$rek="UPDATE produits SET Qte_Stock='".$Qte_Stock."',StockReel='".$Qte_Stock."' WHERE Num='".$_SESSION['aj']."' AND Type='".$_SESSION['menuParenT1']."'";
			$query = mysqli_query($con,$rek) or die (mysqli_error($con)); $ref="PRIN".$update ;  $service=" "; $designationOperation ='Mise à jour Produits';
			if($query){
			$re="INSERT INTO operation VALUES(NULL,'".$ref."','".$designationOperation."','".$update."','".$Qte_initial."','".$_SESSION['qte']."','".$Qte_Stock."','".$Jour_actuel."','".$Heure_actuelle."','','".$_SESSION['qte']."')";
			$req=mysqli_query($con,$re);
			echo "<script language='javascript'>";
			echo 'alertify.success(" Opération effectuée avec succès !");';
			echo "</script>"; */
		} if(!empty($_GET['test'])&& ($_GET['test']=='null')){
			echo "<script language='javascript'>";
			echo 'alertify.error(" L\'opération a été annulée !");';
			echo "</script>";
		}
		
		
		
			echo "
				<input type='hidden' name='pvc' value='".$pvc."'>		
				<tr>
					<td colspan='8'>
						<h2 style='text-align:center; font-family:Cambria;color:Maroon;font-weight:bold;'>"; if(isset($update)) echo "MISE A JOUR D'INFORMATIONS SUR UNE BOISSON"; else if(isset($ap))  echo "APPROVISIONNEMENT DU BAR"; else if(isset($add)) echo "APPROVISIONNEMENT DU DEPOT"; else echo "ENREGISTREMENT DES BOISSONS"; echo "</h2>
					</td>
				</tr>
				<tr>
					<td rowspan='".$rowspan."' align='left'>
						<img title='' src='logo/bar/".rand(1,33).".png' width='250' height='300'/>
					</td>
					<td colspan='2' style='padding-left:25px;' >N° d'Enrég. : &nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>";
					echo "<td colspan='2'><input type='text' id='code' name='code' style='width:250px;'  readonly onkeyup='myFunction()' value='".$nbre."'/> </td>
					<td rowspan='".$rowspan."' align='right' style='padding-left:25px;'>
						<img title='' src='logo/bar/".rand(1,33).".png' width='250' height='300'/>
					</td>
				</tr>
				<tr>
					<td colspan='2' style='padding-left:25px;'> Libellé Catégorie : &nbsp;&nbsp;&nbsp;<span class='rouge'>*</span></td>
					<td colspan='2'>";

/* 				echo "<select name='Libellepc' style='font-family:sans-serif;font-size:90%;border:1px solid black;width:250px;' required='required' >";

				 if(!empty($Categorie)) { echo "<option value='".$Categorie."'>";  echo $Categorie;   echo" </option>";} else { echo "<option value=''>";  echo" </option>";}
					while($data=mysqli_fetch_array($req))
						{
							echo" <option value ='".$data['LibCateg']."'> ".ucfirst($data['LibCateg'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
							<option></option>";
						}

			echo "</select>"; */
				if(isset($ap)||isset($add))
				echo " <input type='text' name='Libellepc' value='".$Categorie."' style='width:250px;font-family:sans-serif;font-size:90%;' readonly='readonly'/>";
				else 
				{?>			
				<select <?php if(empty($Categorie)) echo "id='editable-select'"; ?> name='Libellepc' style="background:#fff;font-family:sans-serif;font-size:100%;border:1px solid gray;width:250px;" required='required'>
				<?php 
				if(!empty($Categorie)) { echo "<option value='".$Categoriec."'>";  echo $Categorie;   echo" </option>";} else { echo "<option value=''>";  echo" </option>";}
				while($data = mysqli_fetch_object($reqCat)){
					echo "<option value ='".$data->LibCateg."'>".ucfirst($data->LibCateg)."</option>";
						if(isset($update))
						echo "<option></option>";
				}
				?>
				</select>				
				<?php
				}
					//echo "<a class='info' href='' style='color:#B83A1B;' onclick='edition1();return false;'> <span style='font-size:0.8em;font-style:normal;' >Ajouter une nouvelle catégorie</span>	 <i class='fa fa-plus-square' aria-hidden='true'></i></a>";
					echo "</td>
				</tr>";

		echo "<tr>
				<td colspan='2' style='padding-left:25px;'>Désignation boisson :&nbsp;&nbsp;<span class='rouge'>*</span>&nbsp;&nbsp;</td>
				<td colspan='2'><input type='text' id='' name='designation' style='width:250px;font-family:sans-serif;font-size:90%;'"; if(isset($ap)||isset($add)) echo "readonly='readonly'"; else echo " required='required'";  echo " onkeypress='' value='";   if(isset($designation)) echo $designation;  echo "'/></td>
			</tr>
			<tr>
				<td colspan='2' style='padding-left:25px;'>Quantité indiquée :&nbsp;&nbsp;&nbsp;<span class='rouge'>*</span></td>
				<td colspan='2'>";
				
			echo "<select name='quantite' style='font-family:sans-serif;font-size:90%;border:1px solid gray;width:250px;' required='required'>";
				 if(!empty($Qte)) { echo "<option value='".$Qtec."'>";  echo $Qte;   echo" </option>";} else { echo "<option value=''>";  echo" </option>";}
				while($data=mysqli_fetch_array($reqQte))
				{ if(!isset($add)&& (!isset($ap)))
					echo" <option value ='".$data['id']."'> ".ucfirst($data['LibQte'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
					<option> </option> ";
				}		
				echo "</select>";
				if(!isset($add)&& (!isset($ap))) echo "&nbsp;<a class='info' href='#' style='color:#B83A1B;' onclick='JSalert();return false;'><span style='font-size:0.9em;font-style:normal;color:maroon;'>Ajouter une nouvelle quantité</span><i class='fa fa-plus-square' aria-hidden='true'></i></a>";
				echo "</td>
			</tr>
			<tr>
				<td colspan='2' style='padding-left:25px;'>Conditionnement :&nbsp;&nbsp;&nbsp;<span class='rouge'>*</span></td>
				<td colspan='2' style=''><select name='conditionnement' style='font-family:sans-serif;font-size:90%;border:1px solid gray;width:250px;' required='required'>";

				  if(!empty($Conditionne)) { echo "<option value='".$Conditionnec."'>";  echo $Conditionne;   echo" </option>";} else { echo "<option value=''>";  echo" </option>";}

					while($data=mysqli_fetch_array($reqCond))
					{   if(!isset($add)&& (!isset($ap)))
						echo" <option value ='".$data['id']."'> ".ucfirst($data['LibConditionne'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
						<option> </option> ";
					}
			echo "</select>
				</td>
			</tr>"; 
			if(!empty($pvc)&&($pvc==2)){
			echo "<tr>
				<td colspan='2' style='padding-left:25px;'><g style='color:maroon;'> Pack [P] et Casier [C] </g>:&nbsp;&nbsp;&nbsp;<span class='rouge'>";
				if(!empty($pvc)&&($pvc==2)) echo "*"; else echo ""; 
				echo "</span></td>
				<td colspan='2' style=''>
				<select name='pack'"; if(!empty($pvc)&&($pvc==2)) echo "required='required'"; else echo ""; echo "style='font-family:sans-serif;font-size:90%;border:1px solid gray;width:250px;'>";			

				  if(!empty($Libellepcc)) { echo "<option value='".$Libellepcc."'>";  echo $Libellepc;   echo" </option>";} else { echo "<option value=''></option>";}

					while($data=mysqli_fetch_array($reqCas))
					{  if(!isset($add)&& (!isset($ap)))
						echo" <option value ='".$data['id']."'> ".ucfirst($data['Libellepc'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
						<option> </option> ";
					}
			echo "</select>";
			if(!isset($add)&& (!isset($ap)))
				echo "&nbsp;<a class='info' href='#' style='color:#B83A1B;' onclick='JSalert2();return false;'><span style='font-size:0.9em;font-style:normal;color:maroon;'>Ajouter un nouveau Pack/Casier</span><i class='fa fa-plus-square' aria-hidden='true'></i></a>";
				echo "</td>
			</tr>";
			
			echo "<tr>
				<td colspan='2' style='padding-left:25px;'><g style='color:maroon;'>Prix du Pack [P] ou Casier [C]</g>";
			
				echo " :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
				<td colspan='2'><input type='text' id='PrixventeP' name='PrixventeP' style='width:250px;font-family:sans-serif;font-size:90%;'";  if(!empty($pvc)&&($pvc==2)) { } else echo "required='required'"; echo "onkeypress='testChiffres(event);'   placeholder='".$devise."' value='";   if(isset($PrixPack)) echo $PrixPack;  echo "'"; if(isset($ap)) echo "readonly='readonly'"; echo "/></td>
			</tr>";
			
			}
			
			if(!isset($add)&& (!isset($ap))){
			echo "<tr>
				<td colspan='2' style='padding-left:25px;'>Stock d'alerte :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
				<td colspan='2'><input type='text' id='Seuil' name='Seuil' style='width:250px;font-family:sans-serif;font-size:90%;' onkeypress='testChiffres(event);'   placeholder='' value='";   if(isset($Seuil)) echo $Seuil;  echo "'";  if(isset($ap)) echo "readonly='readonly'";  echo "/></td>
			</tr>";
			}

			
			echo "<tr>
				<td colspan='2' style='padding-left:25px;'>Prix de vente Unitaire :&nbsp;&nbsp;&nbsp;<span class='rouge'> "; if(!empty($pvc)&&($pvc==2)) { } else echo "*";
				//if(!empty($pvc)&&($pvc==2)) echo ""; else echo "*"; 
				echo "</span></td>
				<td colspan='2'><input type='text' id='Prixvente' name='Prixvente' style='width:250px;font-family:sans-serif;font-size:90%;'";  if(!empty($pvc)&&($pvc==2)) { } else echo "required='required'"; echo "onkeypress='testChiffres(event);'   placeholder='".$devise."' value='";   if(isset($PrixUnitaire)) echo $PrixUnitaire;  echo "'"; if(isset($ap)) echo "readonly='readonly'"; echo "/></td>
			</tr>";
			
/* 			echo "<tr>
				<td colspan='2' style='padding-left:25px;'>Prix du Pack [P] ou Casier [C] :&nbsp;&nbsp;&nbsp;<span class='rouge'>*</span></td>
				<td colspan='2'><input type='text' id='Prixvente' name='Prixvente' style='width:250px;font-family:sans-serif;font-size:90%;' required='required' onkeypress='testChiffres(event);'   placeholder='".$devise."' value='";   if(isset($Prix)) echo $Prix;  echo "'"; if(isset($ap)) echo "readonly='readonly'"; echo "/></td>
			</tr>"; */

		if(isset($update)){
		 echo "<tr>
				<td colspan='2' style='padding-left:25px;'>&nbsp;&nbsp;&nbsp;</td>
				<td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			</tr>";
		}
		if(isset($add)){
		 echo "<tr>
		 <input type='hidden' id='' value='1' name='add'/> 
				<td colspan='2' style='padding-left:25px;'>Stock actuel du Dépôt ";
				if(!empty($pvc)&&($pvc==2)) {
					echo "<span style='color:white;'>["; 
					if(substr($Libellepc,0,1,)=="P") echo "P/"; else echo "C/"; echo $qtepc;
					echo "]</span>";
				}
				echo " :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
				<td colspan='2'><input type='text' id='' value='".$QteStock."' name='qte' style='width:50px;' readonly='readonly' onkeypress='testChiffres(event);'/>
				&nbsp;&nbsp;Qté à Ajouter : &nbsp;
				<input type='number' id='' name='QteAf' style='width:75px;' min='1' max=''/>
				</td>
			</tr>";
		}
		if(isset($ap)){
		 echo "
			<input type='hidden' id='' value='1' name='ap'/>	
				<tr>
				<td colspan='2' style='padding-left:25px;'>Stock actuel du Bar ";
				if(!empty($pvc)&&($pvc==2)) {
					echo "<span style='color:white;'>["; 
					if(substr($Libellepc,0,1,)=="P") echo "P/"; else echo "C/"; echo $qtepc;
					echo "]</span>";
				}
				echo " :&nbsp;&nbsp;&nbsp;<span class='rouge'></span></td>
				<td colspan='2'><input type='text' id='' value='".$QteStock."' name='qte' style='width:50px;' readonly='readonly' onkeypress='testChiffres(event);'/>
				&nbsp;&nbsp;Qté à affecter : &nbsp;
				<input type='number' id='' name='QteAf' style='width:75px;' min='1' max='' />
				</td>
			</tr>";
		} ?>

		<?php
		echo "<tr>
			<td colspan='6' align='center' ><br/><input type='submit' value='"; if(isset($update)) echo "Modifier"; else  echo "Enrégistrer";
			echo "' id='' class='bouton2'  name='"; if(isset($ap)||isset($add)) echo "Enregistrer"; else echo "ENREGISTRER"; echo "' style=''/>
			&nbsp;&nbsp;<input type='reset' value='Annuler' id='' class='bouton2'  name='ANNULER' style=''/> <br/>&nbsp;";
			//echo $pvc;
		?>
		<span style='float:left; margin-left:10px;'>
		<input type='checkbox' <?php if(isset($pvc)&&($pvc==1)) echo "checked='checked'"; ?>
		name='checkpvc0' id='button_checkbox0' onchange="document.forms['chgdept'].submit();"
		<?php if(isset($pvc)&&($pvc==1)) echo "value='2'"; else echo "value='1'"; ?> >
		<label for='button_checkbox0' style='color:#444739;'>Mode Unitaire</label></span>
		<span style='float:right; margin-right:25px;'><input type='checkbox' <?php if(isset($pvc)&&($pvc==2)) echo "checked='checked'"; ?>
		name='checkpvc' id='button_checkbox1' onchange="document.forms['chgdept'].submit();"
		<?php if(isset($pvc)&&($pvc==2)) echo "value='2'"; else {echo "value='1'"; echo "disabled"; }?>  >
		<label for='button_checkbox1' style='color:#444739;'>Pack [P] et Casier [C]</label></span>
		</td>
		</tr>
		</table>
		</form>
<br/>
<!-- <form class="ajax" action="" method="get">
	<p align='center' style='margin-bottom:50px;'>
		<label style='font-size:22px;font-weight:bold; padding:3px;color:#B83A1B;font-family: Cambria, Verdana, Geneva, Arial;' for="q">Rechercher une boisson
		<span style='font-size:15px;color:#777;'></span></label>
		 <input style='text-align:center;background-color:#EFFBFF;width:400px;padding:3px;border:1px solid #aaa;-moz-border-radius:7px;-webkit-border-radius:7px;border-radius:7px;font-size:1.2em;height:30px;line-height:22px;' type="text" name="q" id="q" placeholder="Renseignez les informations sur la boisson ici"/>
	</p>
</form>-->
<!--fin du formulaire-->

<!--preparation de l'affichage des resultats-->
<!--<div id="resultsB">-->
<div class="table-responsive">
	<table id="dataTable"  align='center' width='100%' border='0' cellspacing='1' style='margin-top:0px;border-collapse: collapse;font-family:Cambria;'>
<thead>
<tr><td colspan='10' > <span style="float:left;font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#4C767A;" >Liste des boissons </span>
<span style="float:right;font-family:Cambria;font-size:1em;margin-bottom:5px;color:#4C767A;" ><?php if(!empty($pvc)&&($pvc==2)) echo "4P/24 => Lire : 4 Packs de 24; &nbsp;&nbsp;&nbsp; 5C/24 => Lire : 5 Casiers de 24";  ?></span></td></tr>
		<tr  style='background-color:#3EB27B;color:white;font-size:1.2em;'>
			<td rowspan='2' style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;border-left: 1px solid #ffffff;" align="center" ><label for='1' style=''>N° d'Enrég.</label><span style='font-size:0.8em;'></span></td>
			<td rowspan='2' style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><label for='2' style=''>Catégorie</label><span style='font-size:0.8em;'></span></td>
			<td rowspan='2' style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><label for='3' style=''>Désignation</label><span style='font-size:0.8em;'></span></td>
			<td rowspan='2' style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><label for='5' style=''>Conditionnement</label><span style='font-size:0.8em;'></span></td>
			<td rowspan='2' style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><label for='6' style=''>Quantité <br/>indiquée (Qi)</label> <span style='font-size:0.8em;'></span></td>
			<td rowspan='2' style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><label for='7' style=''>Seuil d'alerte</label><span style='font-size:0.8em;'></span></td>
			<td colspan='2' style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><label for='8' style=''>Quantité <br/>en Stock (Qs)</label> <span style='font-size:0.8em;'></span></td>
			<td rowspan='2' style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><label for='9' style=''><?php if(!empty($pvc)&&($pvc==2)) echo "Prix du Pack/<br/>Casier"; else echo "Prix Unitaire";  ?></label> <span style='font-size:0.8em;'></span></td>
			<td rowspan='2' style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" >Actions</td>
		</tr>
		<tr style='background-color:#3EB27B;color:white;font-size:1.2em;'>
				<td align="center" style="border-top: 1px solid #ffffff">DEPOT</td>
				<td align="center" style="border-top: 1px solid #ffffff;border-right: 1px solid #ffffff">BAR</td>
		</tr>
</thead>
<tbody id="">
<?php
	mysqli_query($con,"SET NAMES 'utf8'");
	if(!empty($pvc)&&($pvc==2)) 
	$result=mysqli_query($con,"SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson,casier WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND casier.id=boisson.pc AND pc<>0 AND Depot = '1' order by numero2 ");
	else 
		$result=mysqli_query($con,"SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND pc=0 AND Depot = '1' order by numero2 ");
	$cpteur=1;
    // parcours et affichage des résultats
    while($data = mysqli_fetch_object($result))
    {
		if($cpteur == 1)
			{
				$cpteur = 0;
				$bgcouleur = "#DDEEDD";$color = "#FC7F3C";
			}
			else
			{
				$cpteur = 1;
				$bgcouleur = "#dfeef3";$color = "#FC7F3C";
			}
	$nbre=$data->numero2;
	if(($nbre>=0)&&($nbre<=9)) $nbre="0000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="000".$nbre ;else $nbre="00".$nbre ;  $Nbre=$data->numero2;
	
	if(!empty($pvc)&&($pvc==2)){
		$result2=mysqli_query($con,"SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson,casier WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND casier.id=boisson.pc AND pc<>0 AND Depot = '2' AND numero2='".$data->numero2."'");
	}
	else 
		$result2=mysqli_query($con,"SELECT * FROM boisson,config_boisson,conditionnement,QteBoisson WHERE QteBoisson.id=boisson.Qte AND conditionnement.id=boisson.Conditionne AND config_boisson.id=boisson.Categorie AND Depot = '2' AND pc=0 AND numero2='".$data->numero2."'");
	$data2 = mysqli_fetch_object($result2);	
    ?>
		 	<tr class='rouge1' bgcolor=' <?php echo $bgcouleur; ?>'>
				<td align="center" style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'><?php echo $nbre;  $nbre=$data->numero; ?></td>
				<td style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'><?php echo $data->LibCateg; ?> </td>
				<td style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'><?php echo $data->designation ; ?></td>
				<td align='' style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'><?php echo $data->LibConditionne; ?></td>
				<td align="center" style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'> <?php echo $data->LibQte; ?></td>
				<td align="center" style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff;padding-right:3px;'><?php echo "<span style=''>"; if(isset($data2->Seuil)) echo $data2->Seuil; else echo "0"; echo "&nbsp;&nbsp;&nbsp;</span>"; ?></td>
				<td align="right" style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff;padding-right:3px;'><?php if(!empty($pvc)&&($pvc==2)) echo "<span style='color:red;'>".$data->QteStock."</span><span style='font-size:0.8em;'>".substr($data->Libellepc,0,1)."/".$data->qtepc."</span>"; else echo "<span style='color:maroon;'>".$data->QteStock."&nbsp;&nbsp;&nbsp;</span>";
				echo "<a class='info2' href='DpInterne.php?menuParent=".$_SESSION['menuParenT']."&add=".$nbre."&checkpvc=".$checkpvc."' style='color:gray'>
				<i class='fa fa-plus-square'></i><span style='color:green;font-size:1em;'>Approvisionner le Dépôt <br/>en <g style='color:red;'>".$data->designation."</g>";
				if(!empty($pvc)&&($pvc==2)) echo "<g style=''> [".substr($data->Libellepc,0,1)."/".$data->qtepc."] </g></span>";
				echo "</a>";
				?></td>
				
	<td align="right" style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff;padding-right:3px;'><?php 
	$numero=isset($data2->numero)?$data2->numero:0;
	if(!empty($pvc)&&($pvc==2)) { echo "<span style='color:red;'>"; if(isset($data2->QteStock)) echo $data2->QteStock; else echo "0"; 
		echo "</span><span style='font-size:0.8em;'>";echo substr($data->Libellepc,0,1)."/".$data->qtepc;  echo "</span>"; }
	else {echo "<span style='color:maroon;'>"; if(isset($data2->QteStock)) echo $data2->QteStock; else echo "-"; }
	echo "</span>";
				echo "<a class='info' href='DpInterne.php?menuParent=".$_SESSION['menuParenT']."&ap=".$numero."&adp=".$nbre."&checkpvc=".$checkpvc."' style='color:gray;'>";
				//echo "<img title='' src='logo/resto/5.png' width='15' height='20' style=''/><span style='color:green;'>Approvisionner<br/> le Bar en <g style='color:red;'>".$data->designation."</g></span>";
				echo "&nbsp;<i class='fa fa-plus-square'></i><span style='color:green;'>Approvisionner le Bar<br/> en <g style='color:red;'>".$data->designation."</g>";
				if(!empty($pvc)&&($pvc==2)) echo "<g style=''> [".substr($data->Libellepc,0,1)."/".$data->qtepc."] </g></span>";
				echo "</a>";
				?></td>								
				<td align="center" style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'><?php if(!empty($pvc)&&($pvc==2)) {if($data->PrixPack==0) echo "-"; else echo $data->PrixPack."<span style='font-size:0.6em;'> ".$devise."</span>&nbsp;"; }else echo $data->PrixUnitaire."<span style='font-size:0.6em;'> ".$devise."</span>&nbsp;"; ?></td>
				<?php
				echo "<td align='center' style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'>
				<a class='info2' href='DpInterne.php?menuParent=".$_SESSION['menuParenT']."&update2=".$numero."&update=".$nbre."&checkpvc=".$checkpvc."'  style='color:#FC7F3C;'><img src='logo/b_edit.png' alt='' width='16' height='16' border='0'><span style='color:#FC7F3C;font-size:0.9em;'>Modifier</span></a>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='info2' href='DpInterne.php?menuParent=".$_SESSION['menuParenT']."&delete=".$nbre."'  style='color:#B83A1B;'><img src='logo/b_drop.png' alt='Supprimer' width='16' height='16' border='0'><span style='color:#B83A1B;font-size:0.9em;'>Supprimer</span></a>
				</td>";
	}
	?>
			</tr>
			</tbody>
		<tfoot></tfoot>
	</table>
	</div>
		<script src="js/editableSelect/jquery-1.12.4.min.js"></script>
		<script src="js/editableSelect/jquery-editable-select.min.js"></script>
		<script src="js/editableSelect/script.js"></script>
		
		<script src="js/datatables/jquery.dataTables.js"></script>
        <script src="js/datatables/dataTables.bootstrap4.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>
        <!-- Custom scripts for this page-->
        <script src="js/sb-admin-datatables.min.js"></script>
        <script src="js/sb-admin-charts.min.js"></script>
        <script src="js/custom.js"></script>
	</div>	
</body>
</html>
<?php
	// $Recordset1->Close();
?>
