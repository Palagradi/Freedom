<?php
include_once'menu.php';  //$req = mysqli_query($con,"DELETE FROM QteBoisson WHERE qte='Hhhh'");
/* 	$req = mysqli_query($con,"SELECT * FROM config_boisson ORDER BY LibCateg") or die (mysqli_error($con));
	//$nbre=mysqli_num_rows($req);
	$reqsel=mysqli_query($con,"SELECT * FROM boisson ");
	$nbreBoisson=mysqli_num_rows($reqsel);$nbre=$nbreBoisson+1; */
	//
	// $req="SELECT * FROM produits WHERE Type='".$_SESSION['menuParenT1']."'";
	// $reqsel=mysqli_query($con,$req);
	// $nbrePalimentaire=mysqli_num_rows($reqsel);$nbre=$nbrePalimentaire+1;
	// if(($nbre>=0)&&($nbre<=9)) $nbre="00000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="0000".$nbre ;else $nbre="00".$nbre ;
	//
	// $sql=mysqli_query($con,"SELECT * FROM typeproduits LIMIT 1"); $NbrePrdts=10;
	// $result=mysqli_fetch_object($sql); $Numero=$result->Numero;$Famille=$result->Famille;$UnitStockage=$result->UnitStockage;$PoidsNet1=$result->PoidsNet;
	// $TypePrdts=$result->TypePrdts;$DateService=$result->DateService;$DatePeremption=$result->DatePeremption;$Fournisseur1=$result->Fournisseur;$PrixFournisseur1=$result->PrixFournisseur;$StockAlerte=$result->StockAlerte;$PrixVente=$result->PrixVente;

 $num=isset($_GET['num'])?$_GET['num']:NULL; //$delete=isset($_GET['delete'])?$_GET['delete']:NULL;
 //$rowspan=6;
	// 	if(isset($num)){ //$rowspan=8;
	// 		echo "<script language='javascript'>";
	// 		echo "var Nprix = '".$_GET['num']."';"; echo "var numfiche = '".$_GET['num']."';";
	// 		echo 'swal("Vous êtes sur le point de changer le prix de la chambre. Le client concerné sera désormais facturé à "+Nprix+". Veuillez noter que cette opération est irréversible. Voulez-vous vraiment continuer ?", {
	// 			dangerMode: true, buttons: true,
	// 		}).then((value) => { var Es = value;  document.location.href="Food_journalier.php?menuParent='.$_SESSION['menuParenT'].'&numfiche="+numfiche+"&Nprix='.$_GET['num'].'&test="+Es;
	// 		}); ';
	// 		echo "</script>";
	// }
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
               $compositionT= array(); $compositionT=str_split($dataz['composition']);
               $composition="";$state0=0; $state1=0; $tempon="";
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

                     }
                }//echo $state1;

                if($state1==1){
                //echo '<meta http-equiv="refresh" content="1; url=Food_journalier.php?menuParent='.$_SESSION['menuParenT'].'&pj=1" />';
                }

                $sql="SELECT composition FROM plat WHERE numero='".$_GET['num']."'  ";
                $reqselz=mysqli_query($con,$sql);	$dataz=mysqli_fetch_assoc($reqselz);
                $compositionT= array(); $compositionT=str_split($dataz['composition']);
                $composition=""; if($state1==0) $state0=0; //$state1=0;
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
                      //echo '<meta http-equiv="refresh" content="1; url=Food_journalier.php?menuParent='.$_SESSION['menuParenT'].'" />';
                     }
                     else {
                         echo "<script language='javascript'>";
                         //echo 'alertify.error("Mise à jour impossible. La quantité de produits entrant dans la composition du plat est insuffisante. ");';
                         echo "</script>";
                         //echo '<meta http-equiv="refresh" content="2; url=Food_journalier.php?menuParent='.$_SESSION['menuParenT'].'" />';
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

			$(document).ready( function() {
		  // détection de la saisie dans le champ de recherche
		  $('#q').keyup( function(){
			$field = $(this);
			$('#resultsB').html(''); // on vide les resultats

			//document.getElementById('q').style.backgroundColor="#84CECC";
			var fiche =  document.getElementById('fiche');
			$('#ajax-loader').remove(); // on retire le loader

			// on commence à traiter à partir du 2ème caractère saisie
			if( $field.val().length > 1 )
			{  $('#resultsB').html('');
			  // on envoie la valeur recherché en GET au fichier de traitement
			  $.ajax({
			type : 'GET', // envoi des données en GET ou POST
			url : 'ajax-search2C.php' , // url du fichier de traitement
			data : 'q='+$(this).val() , // données à envoyer en  GET ou POST
			beforeSend : function() { // traitements JS à faire AVANT l'envoi
				$field.after('<img src="logo/wp2d14cca2.gif" alt="loader" id="ajax-loader" />'); // ajout d'un loader pour signifier l'action
			},
			success : function(data){ // traitements JS à faire APRES le retour d'ajax-search.php
				$('#ajax-loader').remove(); // on enleve le loader
				$('#resultsB').html(data); // affichage des résultats dans le bloc
			}
			  });
			}
		  });
		});
		</script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
			<script type="text/javascript" >
				function edition1() { options = "Width=800,Height=450" ; window.open( "CatBois.php", "edition1", options ) ; }
				function edition2() { options = "Width=800,Height=450" ; window.open( "QuantBois.php", "edition2", options ) ; }
				function devis() {
					document.getElementById('Prixvente').value=document.getElementById('Prixvente').value+document.getElementById('devise').value;
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
      //echo '<meta http-equiv="refresh" content="1; url=Food_journalier.php?menuParent='.$_SESSION['menuParenT'].'" />';
    }else   if(isset($_GET['nump'])&&(isset($_GET['px'])&&($_GET['px']=="null"))){
      echo "<script language='javascript'>";
      //echo " var plat = '".$designation."';";
      echo 'swal("Opération annulée","","error")';
      echo "</script>";
      //echo '<meta http-equiv="refresh" content="1; url=Food_journalier.php?menuParent='.$_SESSION['menuParenT'].'" />';
    }else {
      // Gestion des erreurs
    }
      if(isset($state1)&&($state1==1)){
      echo "<script language='javascript'>";
      echo "var tempon = '".$tempon."';";
      if(substr_count($tempon,",")==0)
          echo 'swal("La quantité de " +tempon+ " entrant dans la composition du plat est insuffisante. Voulez-vous néanmoins continuer ?", {
            dangerMode: true, buttons: true,
          }).then((value) => { var Es = value;  document.location.href="Food_journalier.php?menuParent='.$_SESSION['menuParenT'].'&explorei='.$explorei.'&nump='.$_GET['num'].'&px="+Es;
          }); ';
      else
          echo 'swal("Les quantités de " +tempon+ " entrant dans la composition du plat sont insuffisantes. Voulez-vous néanmoins continuer ?", {
            dangerMode: true, buttons: true,
          }).then((value) => { var Es = value;  document.location.href="Food_journalier.php?menuParent='.$_SESSION['menuParenT'].'&explorei='.$explorei.'&nump='.$_GET['num'].'&px="+Es;
          }); ';
      echo "</script>";
      }

    ?>

		<form class="ajax" action="" method="get">
			<p align='center'>
				<label style='font-size:22px;font-weight:bold; padding:3px;color:#B83A1B;font-family: Cambria, Verdana, Geneva, Arial;' for="q">Rechercher un plat
				<span style='font-size:35px;color:#777;'></span></label>
				 <input style='font-size:1.2em;text-align:center;background-color:#EFFBFF;width:400px;padding:3px;border:1px solid #aaa;-moz-border-radius:7px;-webkit-border-radius:7px;border-radius:7px;height:35px;line-height:22px;' type="text" name="q" id="q" placeholder="Renseignez les informations sur le plat ici"/>
			</p>
		</form>
		<!--fin du formulaire-->

		<!--preparation de l'affichage des resultats-->
		<div id="resultsC">

			<table align='center' width='80%' border='0' cellpadding='3' style='margin-top:0px;border-collapse: collapse;font-family:Cambria;'>

		<tr><td colspan='8' > <span style="float:left;font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#4C767A;" >Liste des plats | repas  </span>
			<?php
			//mysqli_query($con,"SET NAMES 'utf8'");
			//$result =   mysqli_query($con, 'SELECT *  FROM boisson	LIMIT 0,10' );
				$reqsel=mysqli_query($con,"SELECT * FROM plat order by Nbre DESC");
			$nbreplat=mysqli_num_rows($reqsel);
			$PlatsParPage=25; //Nous allons afficher 5 contribuable par page.
			$nombreDePages=ceil($nbreplat/$PlatsParPage); //Nous allons maintenant compter le nombre de pages.

			if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
			{
				  $pageActuelle=intval($_GET['page']);

				 if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
				 {
					   $pageActuelle=$nombreDePages;
				 }
			}
			else // Sinon
			{
				  $pageActuelle=1; // La page actuelle est la n°1
			}
			 $premiereEntree=($pageActuelle-1)*$PlatsParPage;
			$res=mysqli_query($con,"SELECT * FROM plat order by Nbre DESC LIMIT $premiereEntree, $PlatsParPage ");
			$nbre1=mysqli_num_rows($res);


			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span style='color:maroon;font-size:1em;font-weight:normal;'></span> "; //Pour l'affichage, on centre la liste des pages
			$k=!empty($_GET['page'])?$_GET['page']-1:NULL; if(empty($_GET['page'])) $T=25; else $T=$_GET['i']-25;
      ?>
				        <B> <span style='font-style:italic;color:maroon;'>(En date du <?php echo $Date_actuel2; ?>)</span></B>
      <?php
						//{
						//  if(!empty($fiche))
						// 	echo '<span style="color:black;font-size:0.9em;font-weight:normal;"> <a href="Food_journalier.php?menuParent=Restauration&page='.$k.'&i='.$T.'" title="Suivant" style="text-decoration:none;"> &nbsp;<<&nbsp; </a> </span>';
						//   else  if(!empty($fiche1))
						// 	echo '<span style="color:black;font-size:0.9em;font-weight:normal;"> <a href="Food_journalier.php?menuParent=Restauration&page='.$k.'&i='.$T.'" title="Suivant" style="text-decoration:none;"> &nbsp;<<&nbsp; </a> </span>';
						//   else
						// 	echo '<span style="color:black;font-size:0.9em;font-weight:normal;"> <a href="Food_journalier.php?menuParent=Restauration&page='.$k.'&i='.$T.'" title="Suivant" style="text-decoration:none;"> &nbsp;<<&nbsp; </a></span> ';
						//
      //     }
			// 	for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
			// 	{
			// 		 //On va faire notre condition
			// 		 if($i==$pageActuelle) //Si il s'agit de la page actuelle...
			// 		 {
			// 			 echo '<span style="color:black;font-size:0.9em;font-weight:normal;"> [ '.$i.' ] </span>';
			// 		 }
			// 		 if($i==1)
			// 		 {
			// 			  if(!empty($fiche))
			// 				echo '<span style="color:black;font-size:0.9em;font-weight:normal;"> <a href="Food_journalier.php?menuParent=Restauration&page='.$i.'&i=0">'.$i.'</a> </span>';
			// 			  else  if(!empty($fiche1))
			// 				echo '<span style="color:black;font-size:0.9em;font-weight:normal;"> <a href="Food_journalier.php?menuParent=Restauration&page='.$i.'&i=0">'.$i.'</a></span> ';
			// 			  else
			// 				echo '<span style="color:black;font-size:0.9em;font-weight:normal;"> <a href="Food_journalier.php?menuParent=Restauration&page='.$i.'&i=0">'.$i.'</a> </span>';
			// 		 }
			// 	} $j=!empty($j)?$j:NULL;
			// if(empty($_GET['page']))$j+=2; else $j=$_GET['page'] +1;  if(empty($_GET['page'])) $T=25; else $T=25*$_GET['page'];
			// 	if($i>=$j)
			// 			{
			// 			 if(!empty($fiche))
			// 				echo ' <span style="color:black;font-size:0.9em;font-weight:normal;"><a href="Food_journalier.php?menuParent=Restauration&page='.$j.'&i='.$T.'" title="Suivant" style="text-decoration:none;"> &nbsp;>>&nbsp; </a> </span>';
			// 			  else  if(!empty($fiche1))
			// 				echo '<span style="color:black;font-size:0.9em;font-weight:normal;"> <a href="Food_journalier.php?menuParent=Restauration&page='.$j.'&i='.$T.'" title="Suivant" style="text-decoration:none;"> &nbsp;>>&nbsp; </a> </span>';
			// 			  else
			// 				echo '<span style="color:black;font-size:0.9em;font-weight:normal;"> <a href="Food_journalier.php?menuParent=Restauration&page='.$j.'&i='.$T.'" title="Suivant" style="text-decoration:none;"> &nbsp;>>&nbsp; </a> </span>';
			// 			}

		?>
						<span style="float:right;font-weight:normal;font-size:1em;color:#4C767A;font-style:italic;" >
						<?php if(isset($StockAlerte)&&($StockAlerte==-1))  { ?> <a href="DpInterne.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&p=3"  style="text-decoration:none;color:teal;">Liste des boissons en rupture<img src="logo/pdf_small.gif"style=""/> <a/><?php } ?>
						<?php if(isset($DatePeremption)&&($DatePeremption==-1))  { ?>  &nbsp;&nbsp;&nbsp;<a href="DpInterne.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&p=2"  style="text-decoration:none;color:teal;">Liste des boissons périmés<img src="logo/pdf_small.gif"style=""/> <a/><?php } ?>
						&nbsp;&nbsp;&nbsp;<a href="food.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&p=1" style="text-decoration:none;color:teal;">Liste complète des plats <img src="logo/pdf_small.gif"style=""/> <a/></span>
		<?php
		echo "</td></tr>"; ?>

		<form action="Food_journalier.php?menuParent=<?php echo $_SESSION['menuParenT']; if(isset($_GET['num'])) echo "&num=".$_GET['num']; //else echo "&plat=".$plat; if(isset($_GET['famille'])) echo "&famille=".urlencode($_GET['famille']); if(isset($_GET['produit'])) echo "&produit=".urlencode($_GET['produit']);?>" method="POST" id='chgdept' >

				<tr style='border: 2px solid #ffffff;background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
					<td rowspan='2'  style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='Food_journalier.php?menuParent=Restauration&trie=1' style='text-decoration:none;color:white;' title="">N° d'Enrég.<span style='font-size:0.8em;'></span></a></td>
					<td rowspan='2'  style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='Food_journalier.php?menuParent=Restauration&trie=1' style='text-decoration:none;color:white;' title="">Type de menu<span style='font-size:0.8em;'></span></a></td>
					<td rowspan='2' style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Food_journalier.php?menuParent=Restauration&trie=2' style='text-decoration:none;color:white;' title=''>Catégorie plat<span style='font-size:0.8em;'></span></a></td>
					<td rowspan='2'  style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Food_journalier.php?menuParent=Restauration&trie=3' style='text-decoration:none;color:white;' title=''>Désignation<span style='font-size:0.8em;'></span></a></td>
					<td  colspan='3'  style="border: 2px solid #ffffff" align="center" ><a class='info'  href='Food_journalier.php?menuParent=Restauration&trie=5' style='text-decoration:none;color:white;' title=''>Nbre journalier de plats  <span style='font-size:0.8em;'></span></a></td>
          <td rowspan='2'  style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Food_journalier.php?menuParent=Restauration&trie=3' style='text-decoration:none;color:white;' title=''>Actions<span style='font-size:0.8em;'></span></a></td>
				</tr>
      	<tr  style='background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
            <td  style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Food_journalier.php?menuParent=Restauration&trie=5' style='text-decoration:none;color:white;' title=''>Cuisinés <span style='font-size:0.8em;'></span></a></td>
            <td   style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Food_journalier.php?menuParent=Restauration&trie=5' style='text-decoration:none;color:white;' title=''>Consommés<span style='font-size:0.8em;'></span></a></td>
            <td style="border-right: 2px solid #ffffff" align="center" >En attente <span style='font-size:0.8em;'></span></td>
      	</tr>
		<?php
			mysqli_query($con,"SET NAMES 'utf8'");
			$result=mysqli_query($con,"SELECT  * FROM plat order by Nbre DESC LIMIT $premiereEntree, $PlatsParPage ");
			$cpteur=1;
		    // parcours et affichage des résultats
		    while( $data = mysqli_fetch_object($result))
		    {
				if($cpteur == 1)
					{
						$cpteur = 0;
						$bgcouleur = "#DDEEDD";
					}
					else
					{
						$cpteur = 1;
						$bgcouleur = "#dfeef3";
					}
			$nbre=$data->numero; $QteCde=$data->Nbre;
			if(($nbre>=0)&&($nbre<=9)) $nbre="0000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="000".$nbre ;else $nbre="00".$nbre ;
		    ?>
				 	<tr class='rouge1' bgcolor=' <?=($QteCde>0)?"#FFDEAD":$bgcouleur; ?>' >
						<td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $nbre;  ?> </td>
						<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $data->CategorieMenu; ?> </td>
						<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data->CategoriePlat; ?></td>
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
              <?php //if(isset($QteCde)&&($QteCde>0))  echo $QteCde; ?>
							<input
					 <?php
					  if(isset($QteCde)&&($QteCde>0)&&($data->state==1)) {$color="red";$title="Mettre à jour<br/>  le nombre de plats";}
					 else { $color="#FC7F3C";$title="L'ajouter à la liste<br/> journalière des plats";}
						if(isset($_GET['num'])&& ($_GET['num']==$data->numero)){ echo "autofocus";?>
						onblur="document.forms['chgdept'].submit();" <?php } else echo " readonly";  ?>
						<?php //if(isset($QteCde)&&($QteCde>0)) {echo "placeholder='"; echo $QteCde; echo "'"; }?>
						value='<?php if(isset($QteCde)&&($QteCde>0)&&($data->state==1)) { if(isset($_GET['aj']) && ($_GET['aj']==$data['numero'])) echo $QteCde; } ?>'
						type='text' name='choix1[]' style='width:50px;<?php if(isset($_GET['aj']) && ($_GET['aj']==$data['numero'])) { }
						 else echo "background-color:#E1E6FA;" ?>text-align:center;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;border:1px solid red;'  maxlength='3' onkeypress='testChiffres(event);'/>
						 &nbsp;
						<?php
						echo "<a class='info2' href='Food_journalier.php?menuParent="; echo "'>
            <img src='logo/Change.png' alt='' title='' width='17' height='17' border='0' style='float:left;'>
            <span style='font-size:0.9em;color:blue;'>Réinitialiser la quantité</span></a>
            <a class='info2' href='Food_journalier.php?menuParent=".$_SESSION['menuParenT']."&num=".$data->numero; echo "'
						style='color:".$color.";'><i class='fa fa-plus-square'></i><span style='color:#FC7F3C;font-size:0.9em;'>";
						echo $title;
						echo "</span></a>";
						echo "</td>";

			}
			?>	</form>
					</tr>
			</table>


		</div>
	</body>
</html>
<?php
	// $Recordset1->Close();
?>
