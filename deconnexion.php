<?php
	session_start(); 
	include 'connexion.php'; 
	//if ((isset($_POST['dec']) and $_POST['dec']=='Déconnexion')||(!empty($_SESSION['lien'])))
		{mysqli_query($con,"SET NAMES 'utf8' ");
			$req=mysqli_query($con,"TRUNCATE table menu_Tempon");
			$req=mysqli_query($con,"DROP TABLE IF EXISTS reservation_tempon2");
			$res=mysqli_query($con,"DELETE FROM client_tempon");	
			$or="SELECT jour FROM reservation_tempon";
			$or1=mysqli_query($con,$or);
			$nbre=mysqli_num_rows($or1);
				while ($roi= mysqli_fetch_array($or1))
				{	$jour=$roi['jour'];
					$date=date('d-m-Y');				
					//if(($date!=$jour)&&($_SESSION['poste']==agent)&& ($nbre>0)) 		
					//$req=mysql_query("DROP TABLE IF EXISTS reservation_tempon");					
				}
				
		//Destruction de la session et deconnexion de l'utilisateur	
		/* 	if(!empty($_SESSION['lien']))
				{$re="UPDATE utilisateur SET etatconnect='".$_SESSION['lien']."' WHERE login='".$_SESSION['login']."'"; 
				$rT=mysql_query($re);unset($_SESSION['lien']);unset($_SESSION['lien']);
				//header('location:index.php');
				}
			else */				
			$ri='UPDATE utilisateur SET etatconnect=0 WHERE login="'.$_SESSION['login'].'"';
			$rit=mysqli_query($con,$ri);
			if ($rit)
			{			
				session_unset();    
				$_SESSION = array(); //méthode alternative:
				session_destroy(); 
				header('location:index.php');
			} else 
			echo "<script language='javascript'>"; 
			echo " alert(Deconnexion non effectuée');";
			echo "</script>";

		}
	//include 'backup.php'; 
?>