<?php
include 'connexion.php'; 
if(($_POST['MontantTTC'])&&($_POST['numfiche'])){
	mysqli_query($con,"SET NAMES 'utf8'");	
	$s=mysqli_query($con,"SELECT numcli_1 FROM fiche1 WHERE numfiche='".$_POST['numfiche']."'");
	$ez=mysqli_fetch_assoc($s); $numcli=$ez['numcli_1'];

	
	//  $numcli;
			$queryRecordset = "SELECT * FROM categorieclient ORDER BY pourcentage DESC";
		$query=mysqli_query($con,$queryRecordset);
		while ($ret= mysqli_fetch_array($query))
		{	$frequence=$ret['frequence'];$MoisAns=$ret['MoisAns'];$NbreVisite=$ret['NbreVisite'];$Recette=$ret['Recette']; $pourcentage=$ret['pourcentage'];
	
			if($NbreVisite>0){
				if($MoisAns=="Mois"){
					$moisC=date('m');  $ansC=date('Y'); 
					$Finmois=date('Y-m-d');
					$Debutmois=date('Y-m-d', strtotime('-' .$frequence. 'month'));
				    $query_Recordset2 = "SELECT  count(fiche1.numfiche)  AS nbre FROM fiche1 WHERE  fiche1.numcli_1='".$numcli."' and datarriv BETWEEN '$Debutmois' AND '$Finmois'";
					$query2=mysqli_query($con,$query_Recordset2);$result=mysqli_fetch_array($query2);  $nbr2=$result['nbre']+1;
					 if($nbr2<=0)
						 {	$queryRecordset1 = "SELECT  count(fiche1.numfiche)  AS nbre FROM fiche1 WHERE  fiche1.numcli_2='".$numcli."' and datarriv BETWEEN '$Debutmois' AND '$Finmois'";
							$query2=mysqli_query($con,$queryRecordset1);$result=mysqli_fetch_array($query);  $nbr2=$result['nbre']+1;
						 }
					if(($_POST['MontantTTC']>=$Recette)&&($NbreVisite>0)&&($nbr2>=$NbreVisite)){
						$queryRecordset = "UPDATE client SET Categorie='".$ret['NomCat']."' WHERE numcli='".$numcli."'";
						$query=mysqli_query($con,$queryRecordset);
						  $reduction = (int)(($pourcentage/100)*$_POST['MontantTTC']); 
						exit();
					}
					else if(($_POST['MontantTTC']>=$Recette)&&(empty($NbreVisite))){
						$queryRecordset = "UPDATE client SET Categorie='".$ret['NomCat']."' WHERE numcli='".$numcli."'";
						$query=mysqli_query($con,$queryRecordset);
						  $reduction = (int)(($pourcentage/100)*$_POST['MontantTTC']); 
						exit();
					}
					else if(($_POST['MontantTTC']>=$Recette)&&(empty($NbreVisite))){
						$queryRecordset = "UPDATE client SET Categorie='".$ret['NomCat']."' WHERE numcli='".$numcli."'";
						$query=mysqli_query($con,$queryRecordset);
						  $reduction = (int)(($pourcentage/100)*$_POST['MontantTTC']); 
						exit();
					}
					else if(empty($Recette)&&($nbr2>=$NbreVisite)){
						$queryRecordset = "UPDATE client SET Categorie='".$ret['NomCat']."' WHERE numcli='".$numcli."'";
						$query=mysqli_query($con,$queryRecordset);
						  $reduction = (int)(($pourcentage/100)*$_POST['MontantTTC']); exit();
					}
					else  {
					//$queryRecordset = "UPDATE client SET Categorie='".$ret['NomCat']."' WHERE numcli='".$numcli."'";
					//$query=mysql_query($queryRecordset);
					//  $reduction = (int)(($pourcentage/100)*$_POST['MontantTTC']); exit();
					}
					}
					if($MoisAns=="Ans"){
					$moisC=date('m');  $ansC=date('Y'); 
					$FinAns=date('Y-m-d');
					$DebutAns=date('Y-m-d', strtotime('-' .$frequence. 'year'));
				    $query_Recordset2 = "SELECT  count(fiche1.numfiche)  AS nbre FROM fiche1 WHERE  fiche1.numcli_1='".$numcli."' and datarriv BETWEEN '$DebutAns' AND '$FinAns'";
					$query2=mysqli_query($con,$query_Recordset2);$result=mysqli_fetch_array($query2);  $nbr3=$result['nbre']+1;
					 if($nbr3<=0)
						 {	$queryRecordset1 = "SELECT  count(fiche1.numfiche)  AS nbre FROM fiche1 WHERE  fiche1.numcli_2='".$numcli."' and datarriv BETWEEN '$DebutAns' AND '$FinAns'";
							$query2=mysqli_query($con,$queryRecordset1);$result=mysqli_fetch_array($query);  $nbr3=$result['nbre']+1;
						 }
					if(($_POST['MontantTTC']>=$Recette)&&($NbreVisite>0)&&($nbr3>=$NbreVisite)){
						$queryRecordset = "UPDATE client SET Categorie='".$ret['NomCat']."' WHERE numcli='".$numcli."'";
						$query=mysqli_query($con,$queryRecordset);
						  $reduction = (int)(($pourcentage/100)*$_POST['MontantTTC']); 
						exit();
					}
					else if(($_POST['MontantTTC']>=$Recette)&&(empty($NbreVisite))){
						$queryRecordset = "UPDATE client SET Categorie='".$ret['NomCat']."' WHERE numcli='".$numcli."'";
						$query=mysqli_query($con,$queryRecordset);
						  $reduction = (int)(($pourcentage/100)*$_POST['MontantTTC']); 
						exit();
					}
					else if(($_POST['MontantTTC']>=$Recette)&&(empty($NbreVisite))){
						$queryRecordset = "UPDATE client SET Categorie='".$ret['NomCat']."' WHERE numcli='".$numcli."'";
						$query=mysqli_query($con,$queryRecordset);
						  $reduction = (int)(($pourcentage/100)*$_POST['MontantTTC']); 
						exit();
					}
					else if(empty($Recette)&&($nbr3>=$NbreVisite)){
						$queryRecordset = "UPDATE client SET Categorie='".$ret['NomCat']."' WHERE numcli='".$numcli."'";
						$query=mysqli_query($con,$queryRecordset);
						  $reduction = (int)(($pourcentage/100)*$_POST['MontantTTC']); exit();
					}
				else  {
					//$queryRecordset = "UPDATE client SET Categorie='".$ret['NomCat']."' WHERE numcli='".$numcli."'";
					//$query=mysql_query($queryRecordset);
					//  $reduction = 0; exit();
					}
				}
			}
	
		}		
		echo $reduction=!empty($reduction)?$reduction:0;
	}

?>