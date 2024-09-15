<?php 
	
		session_start();  //Commenter
		
		@include 'connexion.php'; unset($_SESSION['state']); unset($_SESSION['db']); //echo 12;
		
/* 		if(!isset($_SESSION['groupe'])) 
			{if(isset($_SESSION['modulo']) && ($_SESSION['modulo'] > 0))  $_SESSION['somme'] =  $_SESSION['somme'] - $_SESSION['modulo'];} */

		
 		if(isset($_SESSION['groupe']))
		 $query="SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,mensuel_compte.due,
		view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.tva,mensuel_compte.ttc_fixe, mensuel_compte.taxe,mensuel_compte.typeoccup, mensuel_compte.ttc, mensuel_fiche1.datarriv,mensuel_compte.nuite,mensuel_compte.np
		FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
		WHERE mensuel_fiche1.numcli_1 = client.numcli
		AND mensuel_fiche1.numcli_2 = view_client.numcli
		AND mensuel_fiche1.numfichegrpe LIKE '".$_SESSION['code_reel']."'
		AND chambre.numch = mensuel_compte.numch
		AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
		AND mensuel_fiche1.etatsortie = 'NON'";
		else
	     $query="SELECT client.numcli AS num1, client.nomcli AS nom1, client.prenomcli AS prenom1, view_client.numcli AS num2, view_client.nomcli AS nom2,
		view_client.prenomcli AS prenom2, chambre.nomch, mensuel_compte.tarif, mensuel_compte.tva,mensuel_compte.ttc_fixe, mensuel_compte.taxe,mensuel_compte.typeoccup, mensuel_compte.ttc, mensuel_fiche1.datarriv,mensuel_compte.nuite,mensuel_compte.np,mensuel_compte.numfiche
		FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
		WHERE mensuel_fiche1.numcli_1 = client.numcli
		AND mensuel_fiche1.numcli_2 = view_client.numcli
		AND mensuel_fiche1.numfiche = '".$_SESSION['num']."'
		AND chambre.numch = mensuel_compte.numch
		AND mensuel_compte.numfiche = mensuel_fiche1.numfiche
		AND mensuel_fiche1.etatsortie = 'NON'";

		//Pour connaitre le montant des occupants journalier
		$sql2=mysqli_query($con,$query);
	
		$som1=0;$som2=0;$i=1;$j=0;$somme_jour=0;$table=array("");$somme_jour2=0;$ttc_fixe=0;$ttc1=0;
  		while($row=mysqli_fetch_array($sql2))
			{   $nomch=$row['nomch'];  
				$tarif=$row['tarif']; 
                $type=$row['typeoccup'];
				$n=(strtotime(date('Y-m-d'))-strtotime($row['datarriv']))/86400;
				$dat=(date('H')+1); 
				settype($dat,"integer");
				if ($dat<14){$n=$n;}else {$n= $n+1;}
				if ($n==0){$n=$n+1;}
				//echo "<br/>".
				$table[$j]=$n-$row['np'];
				$mt=$row['ttc_fixe']*$n;
				$mt1=$row['ttc_fixe']*$row['np'];
				$datarriv=$row['datarriv'];
			$som1+=$mt;
			$som2+=$mt1;
			$somme_jour+=$row['ttc_fixe']*$n;$somme_jour2+=$row['ttc_fixe']*$row['np'];$ttc_fixe+=$row['ttc_fixe'];
			 $ttc1+=$row['ttc_fixe'];
			$i++;$j++;
			}
			$nbre=mysqli_num_rows($sql2);	
			//echo "<br/>".$somme_jour."<br/>".$ttc1;
			$min=$table[0];
			for($j=0;$j<$nbre;$j++)
				{if($table[$j]<$table[0])
					$min=$table[$j];
				}

			$edit10=$_SESSION['somme'];  //echo $ttc1;
			if ($ttc1!=0)
				$np=$edit10/$ttc1; 

			$nombre=mysqli_num_rows($sql2);		
			$_SESSION['numfich']=isset($_POST['edit2'])?$_POST['edit2']:NULL;
            $_SESSION['numfiche2']=isset($_POST['edit_15'])?$_POST['edit_15']:NULL;		

			$_SESSION['nombre']=$nombre;			
	
			mysqli_query($con,"SET NAMES 'utf8' ");
			$_SESSION['date']= date('Y-m-d');
			if(isset($_POST['edit6']))  $_SESSION['groupe1']=$_POST['edit6'];
				
			$_SESSION['total_tt1']=isset($total)?$total:0; 

			if(isset($_SESSION['groupe']))
			   { $ladate1=substr($_SESSION['du'],6,4).'-'.substr($_SESSION['du'],3,2).'-'.substr($_SESSION['du'],0,2);
				 $ladate2=substr($_SESSION['au'],6,4).'-'.substr($_SESSION['au'],3,2).'-'.substr($_SESSION['au'],0,2);
				 $query="SELECT * FROM mensuel_fiche1, mensuel_compte WHERE mensuel_fiche1.numfiche=mensuel_compte.numfiche and mensuel_fiche1.datarriv between'$ladate1' AND '$ladate2' AND mensuel_fiche1.datdep between '$ladate1'  AND '$ladate2' AND mensuel_fiche1.numfichegrpe LIKE '".$_SESSION['code_reel']."' AND mensuel_fiche1.etatsortie='NON'";
			   }
			else
				echo $query="SELECT * FROM mensuel_fiche1, mensuel_compte WHERE mensuel_fiche1.numfiche=mensuel_compte.numfiche AND mensuel_fiche1.numfiche = '".$_SESSION['num']."' AND mensuel_fiche1.etatsortie='NON'";
			$s=mysqli_query($con,$query);
			$datarriv1=array();$j=0;$nbre_result=mysqli_num_rows($s);$date=0;$np_2=0;
			while($ret1=mysqli_fetch_array($s)){
			$n=(strtotime(date('Y-m-d'))-strtotime($ret1['datarriv']))/86400;
			$dat=(date('H')+1); 
			settype($dat,"integer");
			if ($dat<14){$n=$n;}else {$n= $n+1;}
			if ($n==0){$n= $n+1;}
			$mt=($n*$ret1['ttc'])/$ret1['nuite'];
			$var1=$ret1['somme'];							
			$var = $mt-$var1; 
			$_SESSION['var1']=$var; 
			$datarriv1[$j]=$ret1['datarriv'];$j++;$np3=$ret1['np'];$np_2+=$np3;
			}//$difference=$somme_jour-$somme_jour2;
			//echo $somme_jour."<br/>".$somme_jour2;
			for($j=0;$j<$nbre_result;$j++) {
			if($np_2==0)  $date=1;}
	    if((is_int($np)&&($np!=0)))
		{$np1=$np;
			include("checkingOK.php"); 
		}
		else {
			//$msg_4="<span style='font-style:italic;font-size:0.9em;color:blue;display:block;margin-left:380px;'> La somme à encaisser doit correspondance à une certaine nuitée pour tous les membres du groupe</span>";
			echo "<script language='javascript'>";
			echo 'alertify.error(" La somme à encaisser doit correspondre à une certaine nuitée pour tous les membres du groupe");';  
			echo "</script>";
		}
?>