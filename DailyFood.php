<?php
include_once'menu.php';  

	$Qte = isset($_GET['Qte'])?$_GET['Qte']:0;   
	$numero = !empty($_GET['numero'])?$_GET['numero']:0;
	
	if(($numero>0)&&($Qte>0)){echo "&nbsp;";

	echo $Qte."<br/>".$numero;

	}
	$num=isset($_GET['num'])?$_GET['num']:NULL; 

	if(isset($_POST['choix1']))
	{	if( !empty($_POST['choix1'])){
				$choix1 ='';
				for ($i=0;$i<count($_POST['choix1']);$i++)
				{	$choix1 .= $_POST['choix1'][$i].'|';
					$explore = explode('|',$choix1);
					if(($explore[$i]!='')&& ($explore[$i]>0))
						{
              $sql="SELECT composition FROM plat WHERE numero='".$_GET['num']."'  ";
              $reqselz=mysqli_query($con,$sql);	$dataz=mysqli_fetch_assoc($reqselz); //$composition=$dataz['composition'];
             {
               $compositionT= array(); $compositionT=!empty($dataz['composition'])?str_split($dataz['composition']):NULL;
               $composition="";$state0=0; $state1=0; $tempon="";
			   if(!isset($compositionT))$compositionT= array("");
               for($j=0;$j<count($compositionT);$j++){//echo $compositionT[$j];
                   if(($compositionT[$j]==";")&&($j-1>=0)){
                       $sql="SELECT UniteRestante,StockCuisine,Designation FROM produits WHERE Num2='".$compositionT[$j-1]."'  ";
                       $reqselz=mysqli_query($con,$sql);	$dataz=mysqli_fetch_assoc($reqselz);

                      $StockCuisine0=$dataz['StockCuisine']; $UniteRestante=0;
                       if(((int)$explore[$i]*4)<=$dataz['UniteRestante']){
                          $ValeurUnite=((int)$explore[$i]*4);
                          $UniteRestante=$dataz['UniteRestante']-((int)$explore[$i]*4);
                       }else {
                          $ValeurUnite=($dataz['StockCuisine']*$compositionT[$j+1]*4)  + $dataz['UniteRestante'];
                          if($ValeurUnite>0)
                            { $ValeurUnite=$ValeurUnite-((int)$explore[$i]*4);
                              //$StockCuisine=(int)($ValeurUnite/(4*$compositionT[$j+1]));
                              $UniteRestante=$ValeurUnite%(4*$compositionT[$j+1]);
                            }
                       }
                       if($dataz['StockCuisine']==0){//echo 12;
                         if(($dataz['UniteRestante']==0)||(((int)$explore[$i]*4)>$dataz['UniteRestante'])){//echo 5;
                           //||(((int)$explore[$i]*4)<$ValeurUnite)
                           if(empty($tempon))
                               $tempon.=$dataz['Designation'];
                           else
                               $tempon.=",".$dataz['Designation'];
                           $explorei=$explore[$i];
                           $state0+=1; $state1=1;//break;
                         }
                       }

                     }else {
						echo 23;
                     }
                }//echo $state1;
			 
                if($state1==1){
                //echo '<meta http-equiv="refresh" content="1; url=DailyFood.php?menuParent='.$_SESSION['menuParenT'].'&pj=1" />';
                }

                $sql="SELECT composition FROM plat WHERE numero='".$_GET['num']."'  ";
                $reqselz=mysqli_query($con,$sql);	$dataz=mysqli_fetch_assoc($reqselz);
                $compositionT= array(); $compositionT=!empty($dataz['composition'])?str_split($dataz['composition']):NULL;
                $composition=""; if($state1==0) $state0=0; //$state1=0;
				if(!isset($compositionT))$compositionT= array("");
               for($j=0;$j<count($compositionT);$j++){//echo $compositionT[$j];
                    if($j==0) $tx2=$j;
                   if(($compositionT[$j]==";")&&($j-1>=0)){
                       $sql="SELECT UniteRestante,StockCuisine FROM produits WHERE Num2='".$compositionT[$j-1]."'  ";
                       $reqselz=mysqli_query($con,$sql);	$dataz=mysqli_fetch_assoc($reqselz);

                        $StockCuisine=$dataz['StockCuisine'];

                       if(((int)$explore[$i]*4)<=$dataz['UniteRestante']){ //echo 12;
                          $ValeurUnite=((int)$explore[$i]*4);
                          if($ValeurUnite>0)
                            { //$ValeurUnite=$ValeurUnite-((int)$explore[$i]*4);
                              $UniteRestante=$dataz['UniteRestante']-((int)$explore[$i]*4);
                            }
                       }else { //echo 13;
                          $ValeurUnite=($dataz['StockCuisine']*$compositionT[$j+1]*4)  + $dataz['UniteRestante'];
                          if($ValeurUnite>0)
                            { $ValeurUnite=$ValeurUnite-((int)$explore[$i]*4);
                              //$StockCuisine=(int)($ValeurUnite/(4*$compositionT[$j+1]));
                              $UniteRestante=$ValeurUnite%(4*$compositionT[$j+1]);
                            }
                       }
                       //echo $ValeurUnite; echo "--"; echo $StockCuisine; echo "--"; echo  $UniteRestante; echo "<br/>";
                       //if($StockCuisine0>0) {//$state+=2;
                         if($ValeurUnite>=0){
                           if($state1==0){
                             //update produits
                             $sql="UPDATE produits SET StockCuisine='".$StockCuisine."',UniteRestante='".$UniteRestante."' WHERE Num2='".$compositionT[$j-1]."' ";
                             $reqInsert = mysqli_query($con,$sql);
                            if($tx2==0)
                             $sql="UPDATE plat SET NbreJ=NbreJ+'".$explore[$i]."',Nbre=Nbre+'".$explore[$i]."',state=1 WHERE numero='".$_GET['num']."' ";
                             $reqInsert = mysqli_query($con,$sql); //unset($plat);
                           }$tx2++;
                         }

                     }else{
					echo 24;
                          //echo $sql="UPDATE plat SET NbreJ=NbreJ+'".$explore[$i]."',Nbre=Nbre+'".$explore[$i]."',state=1 WHERE numero='".$_GET['num']."' ";
                       echo "<script language='javascript'>";
                       echo "</script>";
                     }
                     if($state0<0) break;
                   }//echo $state;
                  if($state0==0)
                    {	echo "<script language='javascript'>";
                      //var post="avec un message d\'avertissement:Aucun produit n\'a été défini dans la composition de ce plat.";
                      echo 'alertify.success(" La mise à jour de la liste journalière des plats a été effectuée avec succès");';
                      echo "</script>";
                      //echo '<meta http-equiv="refresh" content="1; url=DailyFood.php?menuParent='.$_SESSION['menuParenT'].'" />';
                     }
                     else {
                         echo "<script language='javascript'>";
                         //echo 'alertify.error("Mise à jour impossible. La quantité de produits entrant dans la composition du plat est insuffisante. ");';
                         echo "</script>";
                         //echo '<meta http-equiv="refresh" content="2; url=DailyFood.php?menuParent='.$_SESSION['menuParenT'].'" />';
                     }
               }
						}
				}
			}
	}



?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title><?php echo $title; ?></title>
		<link rel="icon" href="<?php echo $icon; ?>" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
		<link rel="Stylesheet" href='css/table.css' />
		
		<link href="js/datatables/dataTables.bootstrap4.css" rel="stylesheet">
		
		
		<link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
		<script src="js/sweetalert.min.js"></script>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/ajax.js"></script>
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
		</style>
		<script type="text/javascript" >
		</script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
			<script type="text/javascript" >
				function edition1() { options = "Width=800,Height=450" ; window.open( "CatBois.php", "edition1", options ) ; }
				function edition2() { options = "Width=800,Height=450" ; window.open( "QuantBois.php", "edition2", options ) ; }
				function devis() {
					document.getElementById('Prixvente').value=document.getElementById('Prixvente').value+document.getElementById('devise').value;
				}
	
				function JSalertQte(param,param2){
				swal("Plat de "+param2,{
				  content: {
					element: "input",
					attributes: {
					  placeholder: "Quantité à augmenter ",
					  type: "number",
					  min : "1",
					},
				  },
				})
					.then((value) => {
						document.location.href='DailyFood.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&Qte='+value+'&numero='+param;
					});
				}
			</script>
	</head>
	<body bgcolor='azure' style="">

    <?php
    if(isset($_GET['nump'])&&(isset($_GET['px'])&&($_GET['px']!="null"))){
      $sql="SELECT designation,composition FROM plat WHERE numero='".$_GET['nump']."'  ";
      $reqselz=mysqli_query($con,$sql);	$dataz=mysqli_fetch_assoc($reqselz); //$composition=$dataz['composition'];
      $compositionT= array(); $compositionT=str_split($dataz['composition']);
      $composition=""; $designation=$dataz['designation'];//if($state1==0) $state0=0; //$state1=0;
     for($j=0;$j<count($compositionT);$j++){//echo $compositionT[$j];
       if($j==0) $tx=$j;
         if(($compositionT[$j]==";")&&($j-1>=0)){
             $sql="SELECT UniteRestante,StockCuisine FROM produits WHERE Num2='".$compositionT[$j-1]."'  ";
             $reqselz=mysqli_query($con,$sql);	$dataz=mysqli_fetch_assoc($reqselz);
              $StockCuisine=$dataz['StockCuisine'];
             if(((int)$_GET['explorei']*4)<=$dataz['UniteRestante']){ //echo 12;
                $ValeurUnite=((int)$_GET['explorei']*4);
                $UniteRestante=$dataz['UniteRestante']-((int)$_GET['explorei']*4);
             }else {
                $ValeurUnite=($dataz['StockCuisine']*$compositionT[$j+1]*4)  + $dataz['UniteRestante'];
                //if($ValeurUnite>0)  //Ici ce n'est pas nécessaire de vérifier cette condition puisque l'utilisateur a déjà accepté
                    $ValeurUnite=$ValeurUnite-((int)$_GET['explorei']*4);
                    $UniteRestante=$ValeurUnite%(4*$compositionT[$j+1]);
                    $sql="UPDATE produits SET StockCuisine='".$StockCuisine."',UniteRestante='".$UniteRestante."' WHERE Num2='".$compositionT[$j-1]."' ";
                    $reqInsert = mysqli_query($con,$sql);//echo $tx;
                    if($tx==0)
                    $sql="UPDATE plat SET NbreJ=NbreJ+'".$_GET['explorei']."',Nbre=Nbre+'".$_GET['explorei']."',state=1 WHERE numero='".$_GET['nump']."' ";
                    $reqInsert = mysqli_query($con,$sql); //unset($plat);
             }$tx=1;
               // if($ValeurUnite>=0){
               //   //if($state1==0){
               //     //update produits
               //     echo $sql="UPDATE produits SET StockCuisine='".$StockCuisine."',UniteRestante='".$UniteRestante."' WHERE Num2='".$compositionT[$j-1]."' ";
               //     $reqInsert = mysqli_query($con,$sql);
               //     $sql="UPDATE plat SET NbreJ=NbreJ+'".$_GET['explorei']."',Nbre=Nbre+'".$_GET['explorei']."',state=1 WHERE numero='".$_GET['nump']."' ";
               //     $reqInsert = mysqli_query($con,$sql); //unset($plat);
               //   }
               }
         }

      echo "<script language='javascript'>";
      echo " var plat = '".$designation."';";
      echo 'swal("Le plat "+plat+" a été ajouté avec succès","","success")';
      echo "</script>";
      //echo '<meta http-equiv="refresh" content="1; url=DailyFood.php?menuParent='.$_SESSION['menuParenT'].'" />';
    }else   if(isset($_GET['nump'])&&(isset($_GET['px'])&&($_GET['px']=="null"))){
      echo "<script language='javascript'>";
      //echo " var plat = '".$designation."';";
      echo 'swal("Opération annulée","","error")';
      echo "</script>";
      //echo '<meta http-equiv="refresh" content="1; url=DailyFood.php?menuParent='.$_SESSION['menuParenT'].'" />';
    }else {
      // Gestion des erreurs
    }
      if(isset($state1)&&($state1==1)){
      echo "<script language='javascript'>";
      echo "var tempon = '".$tempon."';";
      if(substr_count($tempon,",")==0)
          echo 'swal("La quantité de " +tempon+ " entrant dans la composition du plat est insuffisante. Voulez-vous néanmoins continuer ?", {
            dangerMode: true, buttons: true,
          }).then((value) => { var Es = value;  document.location.href="DailyFood.php?menuParent='.$_SESSION['menuParenT'].'&explorei='.$explorei.'&nump='.$_GET['num'].'&px="+Es;
          }); ';
      else
          echo 'swal("Les quantités de " +tempon+ " entrant dans la composition du plat sont insuffisantes. Voulez-vous néanmoins continuer ?", {
            dangerMode: true, buttons: true,
          }).then((value) => { var Es = value;  document.location.href="DailyFood.php?menuParent='.$_SESSION['menuParenT'].'&explorei='.$explorei.'&nump='.$_GET['num'].'&px="+Es;
          }); ';
      echo "</script>";
      }

    ?>
		<!--fin du formulaire-->

		<!--preparation de l'affichage des resultats-->
		<div class="table-responsive">
			<table id="dataTable"  align='center' width='100%' border='0' cellspacing='1' style='margin-top:0px;border-collapse: collapse;font-family:Cambria;'>
		<thead>

			<!-- <table align='center' width='auto' border='0' cellpadding='3' style='margin-top:0px;border-collapse: collapse;font-family:Cambria;'>-->

		<tr><td colspan='8' > <span style="float:left;font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#4C767A;" >Liste des plats | repas  </span>

		<?php
		echo "</td></tr>"; ?>

		<form action="DailyFood.php?menuParent=<?php echo $_SESSION['menuParenT']; if(isset($_GET['num'])) echo "&num=".$_GET['num']; //else echo "&plat=".$plat; if(isset($_GET['famille'])) echo "&famille=".urlencode($_GET['famille']); if(isset($_GET['produit'])) echo "&produit=".urlencode($_GET['produit']);?>" method="POST" id='chgdept' >

				<tr style='border: 2px solid #ffffff;background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
					<td rowspan='2'  style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='DailyFood.php?menuParent=Restauration&trie=1' style='text-decoration:none;color:white;' title="">N° d'Enrég.<span style='font-size:0.8em;'></span></a></td>
					<td rowspan='2'  style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='DailyFood.php?menuParent=Restauration&trie=1' style='text-decoration:none;color:white;' title="">Type de menu<span style='font-size:0.8em;'></span></a></td>
					<td rowspan='2' style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='DailyFood.php?menuParent=Restauration&trie=2' style='text-decoration:none;color:white;' title=''>Catégorie plat<span style='font-size:0.8em;'></span></a></td>
					<td rowspan='2'  style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='DailyFood.php?menuParent=Restauration&trie=3' style='text-decoration:none;color:white;' title=''>Désignation<span style='font-size:0.8em;'></span></a></td>
					<td  colspan='4'  style="border: 2px solid #ffffff" align="center" ><a href='DailyFood.php?menuParent=Restauration&trie=5' style='text-decoration:none;color:white;' title=''>Nbre de plats du <span style='font-size:0.9em;color:yellow;'><?php echo $Date_actuel2; ?></span></a></td>
					
					<td  colspan='4'  style="border: 2px solid #ffffff" align="center" ><a class='info'  href='DailyFood.php?menuParent=Restauration&trie=5' style='text-decoration:none;color:white;' title=''>Nbre de plats couvrant la période<span style='font-size:0.8em;'></span></a></td>
					
				</tr>
      	<tr style='background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
            <td  style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='DailyFood.php?menuParent=Restauration&trie=5' style='text-decoration:none;color:white;' title=''>Cuisinés <span style='font-size:0.8em;'></span></a></td>
            <td   style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='DailyFood.php?menuParent=Restauration&trie=5' style='text-decoration:none;color:white;' title=''>Consommés<span style='font-size:0.8em;'></span></a></td>
            <td style="border-right: 2px solid #ffffff" align="center" >En attente <span style='font-size:0.8em;'></span></td>
			 <td style="border-right: 2px solid #ffffff" align="center" >Actions <span style='font-size:0.8em;'></span></td>
			
			 <td  style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='DailyFood.php?menuParent=Restauration&trie=5' style='text-decoration:none;color:white;' title=''>Du <span style='font-size:0.8em;'></span></a></td>
            <td   style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='DailyFood.php?menuParent=Restauration&trie=5' style='text-decoration:none;color:white;' title=''>Au<span style='font-size:0.8em;'></span></a></td>
			<td   style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='DailyFood.php?menuParent=Restauration&trie=5' style='text-decoration:none;color:white;' title=''>Nbre quotidien<span style='font-size:0.8em;'></span></a></td>
			 <td style="border-right: 2px solid #ffffff" align="center" >Actions <span style='font-size:0.8em;'></span></td>
			
      	</tr>
</thead>
<tbody id="">
		<?php
			mysqli_query($con,"SET NAMES 'utf8'");
			$result=mysqli_query($con,"SELECT * FROM plat,categorieplat,menu WHERE categorieplat.id=plat.categPlat AND menu.id=plat.categMenu order by Nbre DESC");
			$cpteur=1;
		    // parcours et affichage des résultats
		    while( $data = mysqli_fetch_object($result))
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
			$nbre=$data->numero; $QteCde=$data->Nbre;
			if(($nbre>=0)&&($nbre<=9)) $nbre="0000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="000".$nbre ;else $nbre="00".$nbre ;
		    ?>
				 	<tr class='rouge1' bgcolor=' <?php echo ($QteCde>0)?$bgcouleur:"#FFDEAD"; ?>' >
						<td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $nbre;  ?> </td>
						<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $data->TypeMenu; ?> </td>
						<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->catPlat; ?></td>
						<td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>
							<a onclick="open('CompoPlat.php?<?php echo "designation=".$data->numero; ?>', 'Popup', 'scrollbars=1,resizable=1,height=300,width=770'); return false;" href='CompoPlat.php' class='info' >

						 <?php
							if(!empty($data->Portion)){
								echo "<span style='color:maroon;'>";
								//echo "<strong>Liste des portions du plat</strong>";

								$Portion0 = explode("|",$data->Portion);
								if(count($Portion0)>1)
								$PortionT = explode(";",$Portion0[1]);

								echo "<font style=''>
								<table border ='1' width='100%'>
								<tr style='font-weight:bold;color:maroon;'><td align='left'> &nbsp;Liste des portions</td>
								<td> &nbsp;Qté</td>
								<td> &nbsp;Prix</td> </tr>
									";
								for($i=0;$i<count($PortionT);$i++)
								{
									$PortionTi = explode("_",$PortionT[$i]);
									echo "
									<tr><td align='left'> + ".$PortionTi[0]."</td>
									<td align='center'> ".ucfirst($PortionTi[1])."</td>
									<td align='center'> ".$PortionTi[2]."</td> </tr>";

								}$PortionT=[];

								echo "</table></font></span>";
							}else {
									echo "<span style='color:maroon'>
									<table width='210'><tr><td>Définir une portion de ce plat</td> </tr></table></span>";
							}
							?>

							<?php echo ucfirst($data->designation); ?></a></td>
					  <td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->NbreJ; ?></td>
					  <td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->NbreC; ?></td>
					  <td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $QteCde;?></td>
			  
			  			 <td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>
						<?php
						echo "<a class='info2' href='DailyFood.php?menuParent="; echo "'>
						<img src='logo/Change.png' alt='' title='' width='17' height='17' border='0' style=''>
						<span style='font-size:0.9em;color:blue;'>Réinitialiser le nombre de plats de <br/> ".ucfirst($data->designation) ;
						echo "</span></a>&nbsp;&nbsp;&nbsp;
						<a href='#' class='info2' onclick='JSalertQte(".$data->numero.", \"".addslashes(ucfirst($data->designation))."\"); return false;' 
						style='color:".$color.";'><i class='fa fa-plus-square'></i><span style='color:#FC7F3C;font-size:0.9em;'>";
						echo "Augmenter le nombre de plats <br/>de ".ucfirst($data->designation) ;
						echo "</span></a>";
						echo "</td>";
						?>		
			  
			  <td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> 
			  <?=!empty($data->Begin)?substr($data->Begin,8,2)."-".substr($data->Begin,5,2)."-".substr($data->Begin,0,4):NULL; 
			  ?></td>
			  <td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>
			  <?=!empty($data->Begin)?substr($data->End,8,2)."-".substr($data->End,5,2)."-".substr($data->End,0,4):NULL;?>
			  </td>
			  <td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->NbreJP;?></td>			  
<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> 

	<?php
	echo "<a class='info2' href='DailyFood.php?menuParent="; echo "'>
	<img src='logo/Change.png' alt='' title='' width='17' height='17' border='0' style=''>
	<span style='font-size:0.9em;color:blue;'>Réinitialiser le nombre de plats de <br/> ".ucfirst($data->designation) ;
	echo "</span></a>&nbsp;&nbsp;&nbsp;
	<a href='#' class='info2' onclick='JSalertQte(".$data->numero.", \"".addslashes(ucfirst($data->designation))."\"); return false;' 
	style='color:".$color.";'><i class='fa fa-plus-square'></i><span style='color:#FC7F3C;font-size:0.9em;'>";
	echo "Augmenter le nombre de plats <br/>de ".ucfirst($data->designation) ;
	echo "</span></a>";
	echo "</td>";
	?>	
</td>
              <?php 

			}
			?>	</form>
			  
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
	</body>
</html>
<?php
	// $Recordset1->Close();
?>
