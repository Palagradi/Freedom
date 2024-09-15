<?php 
 $query_Recordset1 = "SELECT datarriv FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.EtatChambre='active' AND chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON' AND mensuel_fiche1.numfichegrpe LIKE '".$_SESSION['code_reel']."'";
$re=mysqli_query($con,$query_Recordset1);$j=0;
while($ret1=mysqli_fetch_array($re))
{	$n=round((strtotime(date('Y-m-d'))-strtotime($ret1['datarriv']))/86400);
	$dat=(date('H')+1);
	settype($dat,"integer");
	if ($dat<14){$n=$n;}else {$n= $n+1;}
	if ($n==0){$n= $n+1;} $n=(int)$n; $j+=$n; //echo $n."<br/>";
} //$n=$j;

 $query_Recordset2 = "SELECT MIN(datarriv) AS datarriv,MAX(mensuel_compte.date) AS dateD  FROM chambre,mensuel_fiche1,mensuel_compte,client WHERE chambre.EtatChambre='active' AND chambre.numch=mensuel_compte.numch AND mensuel_fiche1.numcli_1=client.numcli AND mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.etatsortie='NON' AND mensuel_fiche1.numfichegrpe LIKE '".$_SESSION['code_reel']."'";
$re=mysqli_query($con,$query_Recordset2);$j=0;
$ret1=mysqli_fetch_object($re); $datarriv=$ret1->datarriv; $dateD=$ret1->dateD;

	if(!empty($ret1->dateD))
		{$date1=substr($ret1->dateD,0,2); $date2=substr($ret1->dateD,3,2); $date3=substr($ret1->dateD,6,4);
		 $d=date("d/m/Y", mktime(0,0,0,date($date2),date($date1),date($date3)));
		 $dp=date("d/m/Y", mktime(0,0,0,date($date2),date($date1)+$n,date($date3)));
		}
	else{ $date1=substr($ret1->datarriv,0,4); $date2=substr($ret1->datarriv,5,2); $date3=substr($ret1->datarriv,8,2);
		  $d=date("d/m/Y", mktime(0,0,0,date($date2),date($date3),date($date1)));
		  $dp=date("d/m/Y", mktime(0,0,0,date($date2),date($date3)+$n,date($date1)));
		} 