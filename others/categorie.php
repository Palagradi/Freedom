<?php
		if(!empty($_GET['numcli'])){
		$queryRecordset = "SELECT NumIFU FROM client WHERE numcli='".$_GET['numcli']."'";
		$query=mysqli_query($con,$queryRecordset);	$data= mysqli_fetch_assoc($query);
		if(isset($data['NumIFU'])&& $data['NumIFU'] > 0 ){		
		echo "<td>Numéro IFU :&nbsp;<input type='text'  style='width:150px;'  readonly name='NumIFU' id='NumIFU' value='".$data['NumIFU']."' />&nbsp;&nbsp;</td> ";
		}		
		$queryRecordset = "SELECT * FROM categorieclient";
		$query=mysqli_query($con,$queryRecordset);$afficher=0;
		while ($ret= mysqli_fetch_array($query))
		{	$frequence=$ret['frequence'];$MoisAns=$ret['MoisAns'];$NbreVisite=$ret['NbreVisite'];
			if($NbreVisite>0){
				if($MoisAns=="Mois"){
						$moisC=date('m');  $ansC=date('Y');
						//$Debutmois=$ansC.'-'.$moisP.'-'.'01'; $Finmois=$ansC.'-'.$moisC.'-'.'31';
						$Finmois=date('Y-m-d');
						//$DebutAns=$ansC.'-'.'01'.'-'.'01'; $FinAns=$ansC.'-'.'12'.'-'.'31';
						$Debutmois=date('Y-m-d', strtotime('-' .$frequence. 'month'));
						$query_Recordset2 = "SELECT  count(fiche1.numfiche)  AS nbre FROM fiche1 WHERE  fiche1.numcli_1='".$_GET['numcli']."' and datarriv BETWEEN '$Debutmois' AND '$Finmois'";
						$query2=mysqli_query($con,$query_Recordset2);$result=mysqli_fetch_array($query2);  $nbr2=$result['nbre']+1;
						 if($nbr2<=0)
							 {	$queryRecordset1 = "SELECT  count(fiche1.numfiche)  AS nbre FROM fiche1 WHERE  fiche1.numcli_2='".$_GET['numcli']."' and datarriv BETWEEN '$Debutmois' AND '$Finmois'";
								$query2=mysqli_query($con,$queryRecordset1);$result=mysqli_fetch_array($query);  $nbr2=$result['nbre']+1;
							 }
						if($nbr2>=$NbreVisite){
							$Categorie=$ret['NomCat']; $afficher=1;
						}
					}
				if($MoisAns=="Ans"){
					$moisC=date('m');  $ansC=date('Y');
					$FinAns=date('Y-m-d');
					$DebutAns=date('Y-m-d', strtotime('-' .$frequence. 'year'));
				    $query_Recordset2 = "SELECT  count(fiche1.numfiche)  AS nbre FROM fiche1 WHERE  fiche1.numcli_1='".$_GET['numcli']."' and datarriv BETWEEN '$DebutAns' AND '$FinAns'";
					$query2=mysqli_query($con,$query_Recordset2);$result=mysqli_fetch_array($query2);  $nbr2=$result['nbre']+1;
					 if($nbr2<=0)
						 {	$queryRecordset1 = "SELECT  count(fiche1.numfiche)  AS nbre FROM fiche1 WHERE  fiche1.numcli_2='".$_GET['numcli']."' and datarriv BETWEEN '$DebutAns' AND '$FinAns'";
							$query2=mysqli_query($con,$queryRecordset1);$result=mysqli_fetch_array($query);  $nbr2=$result['nbre']+1;
						 }
					if($nbr2>=$NbreVisite){
						$Categorie=$ret['NomCat']; $afficher=1;
					}
				}
			}
			if(empty($Categorie)){
				$queryRecordset = "SELECT Categorie FROM client WHERE numcli='".$_GET['numcli']."'";
				$query=mysqli_query($con,$queryRecordset);
				$ret= mysqli_fetch_assoc($query);
				$Categorie=$ret['Categorie'];
					if(empty($Categorie)) $Categorie.="Ordinaire";
				}
		}

		echo "<td>Catégorie :&nbsp;<input type='text'  style='width:150px;'  readonly name='categorie' id='categorie' value='Client ".$Categorie."' /></td> ";
		}else {
			echo "<td>Catégorie :&nbsp;<input type='text'  style='width:150px;'  readonly name='categorie' id='categorie' value='Client ".$Categorie."' /> </td>";
		}
?>
