<?php
include_once'menu.php';  

	$Qte = isset($_GET['Qte'])?$_GET['Qte']:0;   
	$numero = !empty($_GET['numero'])?$_GET['numero']:0;
	$portion = !empty($_GET['numero'])?$_GET['portion']:0;

	if(($numero>0)&&($Qte>0)&&($Qte!='null')){		
		 if($portion!=0)
			 $sql="UPDATE portion SET NbreJJp='".$Qte."',Nbrep='".$Qte."',state=1 WHERE id='".$numero."' ";
		 else 
			 $sql="UPDATE plat SET NbreJ='".$Qte."',Nbre='".$Qte."',state=1 WHERE numero='".$numero."' ";
         $reqInsert = mysqli_query($con,$sql); 
		 if($reqInsert){
			$menuParent = $_SESSION['menuParenT'];	$_SESSION['ok']=1;
			//ob_end_clean(); // Terminer et vider tout tampon de sortie
			//header("Location: DailyFood.php?menuParent=$menuParent&ok=1");
			//exit;	
			echo "<script language='javascript'>";
			echo 'alertify.success(" Quantité augmentée avec succès !");';
			echo "</script>";			
		 }							 
							 
		      $sql="SELECT composition FROM plat WHERE numero='".$numero."'  ";
              $reqselz=mysqli_query($con,$sql);	$dataz=mysqli_fetch_assoc($reqselz); //$composition=$dataz['composition'];
             {
/*                $compositionT= array(); $compositionT=!empty($dataz['composition'])?str_split($dataz['composition']):NULL;
               $composition="";$state0=0; $state1=0; $tempon="";
			   if(!isset($compositionT))$compositionT= array("");
               for($j=0;$j<count($compositionT);$j++){
                   if(($compositionT[$j]==";")&&($j-1>=0)){
                        $sql="SELECT UniteRestante,StockCuisine,Designation FROM produits WHERE Num2='".$compositionT[$j-1]."' AND Type='".$_SESSION['menuParenT1']."'";
                       $reqselz=mysqli_query($con,$sql);	$dataz=mysqli_fetch_assoc($reqselz);

                      $StockCuisine0=$dataz['StockCuisine']; $UniteRestante=0;
                       if(((int)$Qte*4)<=$dataz['UniteRestante']){
                          $ValeurUnite=((int)$Qte*4);
                          $UniteRestante=$dataz['UniteRestante']-((int)$Qte*4);
                       }else {
                          $ValeurUnite=($dataz['StockCuisine']*$compositionT[$j+1]*4)  + $dataz['UniteRestante'];
                          if($ValeurUnite>0)
                            { $ValeurUnite=$ValeurUnite-((int)$Qte*4);
                              //$StockCuisine=(int)($ValeurUnite/(4*$compositionT[$j+1]));
                              $UniteRestante=$ValeurUnite%(4*$compositionT[$j+1]);
                            }
                       }
                       if($dataz['StockCuisine']==0){//echo 12;
                         if(($dataz['UniteRestante']==0)||(((int)$Qte*4)>$dataz['UniteRestante'])){//echo 5;
                           if(empty($tempon))
                               $tempon.=$dataz['Designation'];
                           else
                               $tempon.=",".$dataz['Designation'];
                           $explorei=$Qte;
                           $state0+=1; $state1=1;//break;
                         }
                       }

                     }else {
						//echo 23;
                     }
                } */
				
	
	
/* 				$state1=0;
                $sql="SELECT composition FROM plat WHERE numero='".$numero."'  ";
                $reqselz=mysqli_query($con,$sql);	$dataz=mysqli_fetch_assoc($reqselz);
                $compositionT= array(); $compositionT=!empty($dataz['composition'])?str_split($dataz['composition']):NULL;
                $composition=""; if($state1==0) $state0=0; //$state1=0;
				if(!isset($compositionT))$compositionT= array("");
               for($j=0;$j<count($compositionT);$j++){//echo $compositionT[$j];
                    if($j==0) $tx2=$j;
                   if(($compositionT[$j]==";")&&($j-1>=0)){
                       $sql="SELECT UniteRestante,StockCuisine FROM produits WHERE Num2='".$compositionT[$j-1]."' AND Type='".$_SESSION['menuParenT1']."' ";
                       $reqselz=mysqli_query($con,$sql);	$dataz=mysqli_fetch_assoc($reqselz);

                        $StockCuisine=$dataz['StockCuisine'];

                       if(((int)$Qte*4)<=$dataz['UniteRestante']){ //echo 12;
                          $ValeurUnite=((int)$Qte*4);
                          if($ValeurUnite>0)
                            { //$ValeurUnite=$ValeurUnite-((int)$explore[$i]*4);
                              $UniteRestante=$dataz['UniteRestante']-((int)$Qte*4);
                            }
                       }else { 
                          $ValeurUnite=($dataz['StockCuisine']*$compositionT[$j+1]*4)  + $dataz['UniteRestante'];
                          if($ValeurUnite>0)
                            { echo $ValeurUnite=$ValeurUnite-((int)$Qte*4);
                              //$StockCuisine=(int)($ValeurUnite/(4*$compositionT[$j+1]));
                              $UniteRestante=$ValeurUnite%(4*$compositionT[$j+1]);
                            }
                       }
                       //echo $ValeurUnite; echo "--"; echo $StockCuisine; echo "--"; echo  $UniteRestante; echo "<br/>";
                       //if($StockCuisine0>0) {//$state+=2;
                         if($ValeurUnite>0){echo $ValeurUnite."<br/>".$state1;
                           //if($state1==0){ Commenté ce 08.11.2024
                             //update produits
                             echo $sql="UPDATE produits SET StockCuisine='".$StockCuisine."',UniteRestante='".$UniteRestante."' WHERE Num2='".$compositionT[$j-1]."' AND Type='".$_SESSION['menuParenT1']."'";
                             $reqInsert = mysqli_query($con,$sql);
                            if($tx2==0)
                             $sql="UPDATE plat SET NbreJ=NbreJ+'".$Qte."',Nbre=Nbre+'".$Qte."',state=1 WHERE numero='".$numero."' ";
                             $reqInsert = mysqli_query($con,$sql); //unset($plat);
                           //}
						   $tx2++;
                         }else{
							echo "Insuffisant";	 
						 }

                     }else{
							//echo 24;
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
                     } */
					 
					 
               }				
					
	} $_SESSION['ok']=0;
	$num=isset($_GET['num'])?$_GET['num']:NULL;
	if(isset($_POST['choix1']))
	{	if( !empty($_POST['choix1'])){
				$choix1 ='';
				for ($i=0;$i<count($_POST['choix1']);$i++)
				{	$choix1 .= $_POST['choix1'][$i].'|';
					$explore = explode('|',$choix1);
					if(($explore[$i]!='')&& ($explore[$i]>0))
						{
						}
				}
			}
	}


	if(!empty($_GET['Qte'])){ $_SESSION['Qte']=$_GET['Qte'];
		echo "<script language='javascript'>";
		echo 'swal("Voulez-vous vraiment continuer ?", {
		  dangerMode: true, buttons: true,
		}).then((value) => { var Es = value;  document.location.href="DailyFood.php?menuParent='.$_SESSION['menuParenT'].'&test="+Es;
		}); ';
		echo "</script>";
	}
	
	if($portion!=0){
	 $sql="UPDATE portion SET NbreJJp='".$Qte."',Nbrep='".$Qte."',state=1 WHERE id='".$numero."' ";
	 $rek="UPDATE configresto SET pvp=2";
	 $query = mysqli_query($con,$rek) or die (mysqli_error($con));
	 $pvp = 2;
	}
	else {	 
	if(isset($_GET['checkpvp']))
		{$checkpvp=$_GET['checkpvp'];$pvp=$checkpvp;}
	else 	
		$checkpvp=isset($_POST['checkpvp'])?$_POST['checkpvp']:NULL;

	if(isset($checkpvp))
		{   $checkpvp=2;
		}else 
		{   $checkpvp=1;
		} 
	$rek="UPDATE configresto SET pvp='".$checkpvp."'";
	$query = mysqli_query($con,$rek) or die (mysqli_error($con));
	$pvp = $checkpvp ;
	}
	if(isset($_GET['pvp'])) $pvp= $_GET['pvp'];
	if(isset($pvp)&&($pvp==2)) {$name="portion";$names="portions"; }else {$name="plat";$names="plats";}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title><?php echo $title; ?></title>
		<link rel="icon" href="<?php echo $icon; ?>" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
		<link rel="Stylesheet" href='css/table.css' />
		<link rel="Stylesheet" type="text/css"  href='css/input.css'/>
		
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
			border:1px solid #B1221C;
			color:#B1221C;
			font:bold 12px Verdana;
			height:auto;font-family:cambria;font-size:0.9em;
		}
		.bouton2:hover{color:white;
			cursor:pointer;background-color: #B1221C;border:1px solid #B1221C;
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
	
			function JSalertQte(param, param2, param3 = 0) {
			let name = (param3 === 1) ? "Portion" : "Plat"; 

			// Utilisation de template literals pour formater correctement la chaîne
			swal({
				title: `${name} de ${param2}`,  // Utilisation de template literals pour insérer `name` et `param2`
				content: {
					element: "input",
					attributes: {
						placeholder: "Quantité à définir aujourd'hui",
						type: "number",
						min: "1", // Définition du minimum
					},
				},
				buttons: ["Annuler", "OK"], // Ajout d'un bouton d'annulation
			})
			.then((value) => {
				// Vérification si l'utilisateur a saisi une valeur
				if (value && value.trim() !== "") {
					document.location.href = `DailyFood.php?menuParent=<?php echo $_SESSION["menuParenT"]; ?>&Qte=${value}&numero=${param}&portion=${param3}`;
				} else {
					// Optionnel : Vous pouvez ajouter un message d'erreur si la valeur est vide ou incorrecte
					swal("Erreur", "Veuillez saisir un nombre valide.", "error");
				}
			});
		}
				
				
function addQuantite(numero = 0, designation = "",param3=0) {
	let name = (param3 === 1) ? "Portion" : "Plat"; 
    const title = `Définir une quantité de ${name} de <span style="color: maroon; font-weight: bold;">${designation}</span> pour une période`;
    swal({
        title: "",
        content: {
            element: "div",
            attributes: {
                innerHTML: `
                <h4 style="text-align: center;">${title}</h4>
                <div class='swal-custom-form'>
                    <style>
                        .swal-custom-form {
                            display: flex;
                            flex-direction: column;
                            gap: 10px;
                            font-family: Arial, sans-serif;
                        }
                        .swal-custom-form .row {
                            display: flex;
                            align-items: center;
                        }
                        .swal-custom-form label {
                            width: 170px;
                            font-weight: bold;
                            color: maroon;
                            margin-right: 10px;
                            text-align: right;
                        }
                        .swal-custom-form input {
                            flex: 1;
                            padding: 5px;
                            height: 25px;
                            border: 1px solid #ccc;
                            border-radius: 4px;
                            margin-right: 15px;
                        }
                    </style>
                    <input id='numero' type='hidden' value='${numero}'/>
					<br/>
                    <div class='row'>
                        <label for='quantite'>Quantité :</label>
                        <input id='quantite' type='number' min='1' placeholder='Entrez la quantité'/>
                    </div><br/>
                    <div class='row'>
                        <label for='dateDebut'>Date de début :</label>
                        <input id='dateDebut' type='date'/>
                    </div><br/>
                    <div class='row'>
                        <label for='dateFin'>Date de fin :</label>
                        <input id='dateFin' type='date'/>
                    </div><br/>
                </div>
                `
            }
        },
        buttons: true
    }).then((willSubmit) => {
        if (willSubmit) {
            const numero = document.getElementById('numero').value;
            const quantite = document.getElementById('quantite').value.trim();
            const dateDebut = document.getElementById('dateDebut').value;
            const dateFin = document.getElementById('dateFin').value;

            // Validation
            if (!quantite) {
                swal("Erreur", "La quantité est requise.", "error");
                return;
            }
            if (!dateDebut) {
                swal("Erreur", "La date de début est requise.", "error");
                return;
            }
            if (!dateFin) {
                swal("Erreur", "La date de fin est requise.", "error");
                return;
            }
            if (new Date(dateFin) < new Date(dateDebut)) {
                swal("Erreur", "La date de fin doit être postérieure à la date de début.", "error");
                return;
            }

            // Envoi des données en AJAX
            const formData = new FormData();
            formData.append('numero', numero);
            formData.append('quantite', quantite);
            formData.append('dateDebut', dateDebut);
            formData.append('dateFin', dateFin);
			formData.append('portion', param3);

            fetch('update_plat.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    swal("Succès", data.message, "success").then(() => {
                        location.reload(); // Recharge la page après le message de succès
                    });
                } else {
                    swal("Erreur", data.message, "error");
                }
            })
            .catch(error => swal("Erreur", "Une erreur s'est produite lors de la mise à jour.", "error"));
        }
    });
}


			</script>
	</head>
	<body bgcolor='azure' style="">
	
			<table align='center' width='98%'>
			<tr>
			<td style='text-align:left;'>
				<h2 style='font-family:Cambria;color:maroon;font-weight:bold;float:left;'>QUANTIFICATION PREVISIONNELLE <span style=''><?php if(isset($pvp)&&($pvp==2)) echo "DES PORTIONS"; else echo "DES PLATS";?> </span></h2>				
				<form action="" method="POST" id="chgdept" style='float:right;'>
					<span style='float:right; margin-right:25px;'>
					<input type='checkbox' <?php if(isset($pvp)&&($pvp==2)) echo "checked='checked'"; ?> name='checkpvp' id='button_checkbox2' onchange="document.forms['chgdept'].submit();" <?php if(isset($pvp)&&($pvp==2)) echo "value='2'"; else echo "value='1'"; ?> >
					<label for='button_checkbox2' style='color:#444739;'>
					<?php echo "Les portions de plats"; ?> </label></span>
				</form>			
			</td>
			</tr>
			<tr>
				<td style='text-align:left;'><hr style=''/>	</td>
			</tr>
		</table>

    <?php
    if(isset($_GET['nump'])&&(isset($_GET['px'])&&($_GET['px']!="null"))){
      $sql="SELECT designation,composition FROM plat WHERE numero='".$_GET['nump']."'  ";
      $reqselz=mysqli_query($con,$sql);	$dataz=mysqli_fetch_assoc($reqselz); //$composition=$dataz['composition'];
      $compositionT= array(); $compositionT=str_split($dataz['composition']);
      $composition=""; $designation=$dataz['designation'];
     for($j=0;$j<count($compositionT);$j++){
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

		<tr><td colspan='8' > <span style="float:left;font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#4C767A;" >Liste des <?=$names; ?> disponibles</span>

		<?php echo "</td></tr>"; ?>

		<form action="DailyFood.php?menuParent=<?php echo $_SESSION['menuParenT']; if(isset($_GET['num'])) echo "&num=".$_GET['num']; //else echo "&plat=".$plat; if(isset($_GET['famille'])) echo "&famille=".urlencode($_GET['famille']); if(isset($_GET['produit'])) echo "&produit=".urlencode($_GET['produit']);?>" method="POST" id='chgdept' >

		<tr style='border: 1px solid #ffffff;background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
			<td rowspan='2'  style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><a class='info'>N° d'Enrég.<span style='font-size:0.8em;'></span></a></td>
			<td rowspan='2'  style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><a class='info'>Type de menu<span style='font-size:0.8em;'></span></a></td>
			<td rowspan='2' style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><a class='info' ><?php if(isset($pvp)&&($pvp==2)) echo "Plat principal"; else echo "Catégorie"; ?><span style='font-size:0.8em;'></span></a></td>
			<td rowspan='2'  style="border-right: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><a class='info' >Désignation <?=$name; ?><span style='font-size:0.8em;'></span></a></td>
			<td  colspan='4'  style="border-bottom: 1px solid #ffffff;border-top: 1px solid #ffffff;" align="center" ><a >Nbre de <?=$names; ?> prévu ce <span style='font-size:0.9em;color:#FFFFE0;'><?php echo $Date_actuel2; ?></span></a></td>					
			<td  colspan='4'  style="border: 1px solid #ffffff" align="center" ><a class='info' >Nbre de <?=$names; ?> prévu pour la période<span style='font-size:0.8em;'></span></a></td>					
		</tr>
      	<tr style='background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
            <td  style="border-right: 1px solid #ffffff" align="center" ><a class='info' >Cuisinés <span style='font-size:0.8em;'></span></a></td>
            <td   style="border-right: 1px solid #ffffff" align="center" ><a class='info' >Consommés<span style='font-size:0.8em;'></span></a></td>
            <td style="border-right: 1px solid #ffffff" align="center" >En attente <span style='font-size:0.8em;'></span></td>
			 <td style="border-right: 1px solid #ffffff" align="center" >Actions <span style='font-size:0.8em;'></span></td>
			
			 <td  style="border-right: 1px solid #ffffff" align="center" ><a class='info'>Début <span style='font-size:0.8em;'></span></a></td>
            <td   style="border-right: 1px solid #ffffff" align="center" ><a class='info' >Fin<span style='font-size:0.8em;'></span></a></td>
			<td   style="border-right: 1px solid #ffffff" align="center" ><a class='info' >Nbre quotidien<span style='font-size:0.8em;'></span></a></td>
			 <td style="border-right: 1px solid #ffffff" align="center" >Actions <span style='font-size:0.8em;'></span></td>
			
      	</tr>
</thead>
<tbody id="">
		<?php
			mysqli_query($con,"SET NAMES 'utf8'");
			if(isset($pvp)&&($pvp==2))
				$req="SELECT designation,TypeMenu,catPlat,plat.numero,NbreJ,NbreC,Nbre,Begin,NbreJP,End,libellePortion,NbreJJp,NbreCp,Nbrep,Beginp,NbreJPp,Endp,portion.id AS portion_id FROM plat,portion,categorieplat,menu WHERE categorieplat.id=plat.categPlat AND menu.id=plat.categMenu AND plat.numero = portion.numPlat";
			else 
				$req="SELECT * FROM plat,categorieplat,menu WHERE categorieplat.id=plat.categPlat AND menu.id=plat.categMenu order by Nbre DESC";
			$result=mysqli_query($con,$req);
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
			$nbre=$data->numero; $QteCde=$data->NbreJ;if(isset($pvp)&&($pvp==2)) $QteCde=$data->NbreJP;
			if(($nbre>=0)&&($nbre<=9)) $nbre="0000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="000".$nbre ;else $nbre="00".$nbre ;
			
/* 			if (isset($data->NbreJP) && isset($data->NbreJ) && isset($Jour_actuelp) && isset($data->Begin) && isset($data->End)) {
					if (($data->NbreJP > 0) && ($data->NbreJ <= 0) && ($Jour_actuelp >= $data->Begin) && ($Jour_actuelp <= $data->End)) {
						$QteCde
				}
			} */
					
		    ?>
				 	<tr class='rouge1' bgcolor=' <?php echo ($QteCde>0)?$bgcouleur:"#FFDEAD"; ?>' >
						<td align="center" style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'><?php echo $nbre;  ?> </td>
						<td style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'><?php echo $data->TypeMenu; ?> </td>
						<td style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'> <?php if(isset($pvp)&&($pvp==2)) echo ucfirst($data->designation); else echo $data->catPlat; ?></td>
						<td align='' style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'>
							<!-- <a onclick="open('CompoPlat.php?<?php //echo "designation=".$data->numero; ?>', 'Popup', 'scrollbars=1,resizable=1,height=300,width=770'); return false;" href='CompoPlat.php' class='info' > !-->

						 <?php
/* 							if(!empty($data->Portion)){
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
									//echo "<span style='color:maroon'><table width='210'><tr><td>Définir une portion de ce ".$name."</td> </tr></table></span>";
							} */
							$NbreJ=0;
							?>

					<?php if(isset($pvp)&&($pvp==2)) echo ucfirst($data->libellePortion); else echo ucfirst($data->designation); ?></a></td>
					  <td align='center' style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'> <?php 
						if (isset($data->NbreJP) && isset($data->NbreJ) && isset($Jour_actuelp) && isset($data->Begin) && isset($data->End)) {
							if (($data->NbreJP > 0) && ($data->NbreJ <= 0) && ($Jour_actuelp >= $data->Begin) && ($Jour_actuelp <= $data->End)) {
								$NbreJ=$data->NbreJP;
								$rek="UPDATE plat SET NbreJ='".$data->NbreJP."' WHERE numero='".$data->numero."' ";
								$query = mysqli_query($con,$rek) or die (mysqli_error($con));
							} else {
								$NbreJ=$data->NbreJ;
							}
						} else {$NbreJ=$data->NbreJ; } $NbreC=isset($data->NbreC)?$data->NbreC:0;
						
						if(isset($pvp)&&($pvp==2)){
							if (isset($data->NbreJPp) && isset($data->NbreJJp) && isset($Jour_actuelp) && isset($data->Beginp) && isset($data->Endp)) {
								if (($data->NbreJPp > 0) && ($data->NbreJJp <= 0) && ($Jour_actuelp >= $data->Beginp) && ($Jour_actuelp <= $data->Endp)) {
									$NbreJJp=$data->NbreJPp;
									$rek="UPDATE portion SET NbreJJp='".$data->NbreJPp."' WHERE id='".$data->portion_id."' ";
									$query = mysqli_query($con,$rek) or die (mysqli_error($con));
								} else {
									$NbreJJp=$data->NbreJJp;
								}
							} else {$NbreJJp=$data->NbreJJp; }
							if($NbreJJp==0){
									$rek="UPDATE portion SET NbreJJp='".$data->NbreJ."' WHERE id='".$data->portion_id."' ";
									$query = mysqli_query($con,$rek) or die (mysqli_error($con));
							}else $NbreJ=$NbreJJp;	$NbreC=isset($data->NbreCp)?$data->NbreCp:0;						
						}						
					  
					  echo $NbreJ;
					  ?></td>
					  <td align='center' style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'> <?php echo $NbreC; ?></td>
					  <td align='center' style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'> <?php echo $NbreJ-$NbreC;?></td>
			  
			  			 <td align='center' style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'>
						<?php
						echo "<a class='info2' href='DailyFood.php?menuParent="; echo "'>
						<img src='logo/Change.png' alt='' title='' width='17' height='17' border='0' style=''>
						<span style='font-size:0.9em;color:maroon;'>Réinitialiser le nombre de ".$names." de <br/> ".ucfirst($data->designation) ;
						echo "</span></a>&nbsp;&nbsp;&nbsp;
						<a href='#' class='info2'";
						if(isset($pvp)&&($pvp==2))
							echo "onclick='JSalertQte(".$data->portion_id.", \"".ucfirst(htmlspecialchars($data->libellePortion, ENT_QUOTES, 'UTF-8'))."\",1); return false;'";
						else 
							echo "onclick='JSalertQte(".$data->numero.", \"".ucfirst(htmlspecialchars($data->designation, ENT_QUOTES, 'UTF-8'))."\"); return false;'";
						echo "style='color:".$color.";'><i class='fa fa-plus-square'></i><span style='color:maroon;font-size:0.9em;'>";
						echo "Redéfinir le nombre de <br/> ";
						if(isset($pvp)&&($pvp==2)) echo ucfirst($data->libellePortion) ; else echo ucfirst($data->designation) ;
						echo " pour ce jour</span></a>";
						echo "</td>";
						?>		
			  
			  <td align='center' style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'> 
			  <?php 
			  if(isset($pvp)&&($pvp==2))
				echo !empty($data->Beginp)?substr($data->Beginp,8,2)."-".substr($data->Beginp,5,2)."-".substr($data->Beginp,0,4):NULL; 
			  else 
				echo !empty($data->Begin)?substr($data->Begin,8,2)."-".substr($data->Begin,5,2)."-".substr($data->Begin,0,4):NULL; 
			  ?></td>
			  <td align='center' style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'>
			  <?php 
			  if(isset($pvp)&&($pvp==2))
				  echo !empty($data->Beginp)?substr($data->Endp,8,2)."-".substr($data->Endp,5,2)."-".substr($data->Endp,0,4):NULL;
			  else 
				  echo !empty($data->Begin)?substr($data->End,8,2)."-".substr($data->End,5,2)."-".substr($data->End,0,4):NULL;
			  ?>
			  </td>
			  <td align='center' style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'> <?php 
			  if(isset($pvp)&&($pvp==2)) echo $data->NbreJPp; else echo $data->NbreJP;
			  ?></td>			  
			<td align='center' style='border-right: 1px solid #ffffff; border-top: 1px solid #ffffff'> 

				<?php
				echo "<a class='info2' href='DailyFood.php?menuParent="; echo "'>
				<img src='logo/Change.png' alt='' title='' width='17' height='17' border='0' style=''>
				<span style='font-size:0.9em;color:maroon;'>Réinitialiser le nombre de ".$names." de <br/> ".ucfirst($data->designation) ;
				echo "</span></a>&nbsp;&nbsp;&nbsp;
				<a href='#' class='info2'";
				if (isset($pvp) && ($pvp == 2)) {
					// For `libellePortion`, encode it properly for JavaScript context.
					echo "onclick='addQuantite(".$data->portion_id.", \"".ucfirst(htmlspecialchars($data->libellePortion, ENT_QUOTES, 'UTF-8'))."\", 1); return false;'";
				} else {
					// For `designation`, encode it properly for JavaScript context.
					echo "onclick='addQuantite(".$data->numero.", \"".ucfirst(htmlspecialchars($data->designation, ENT_QUOTES, 'UTF-8'))."\"); return false;'";
				}
				echo "style='color:".$color.";'><i class='fa fa-plus-square'></i><span style='color:maroon;font-size:0.9em;'>";
				echo "Redéfinir le nombre de <br/> ";
				if (isset($pvp) && ($pvp == 2)) {
					echo ucfirst($data->libellePortion);
				} else {
					echo ucfirst($data->designation);
				}
				echo " pour la période</span></a>";
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
