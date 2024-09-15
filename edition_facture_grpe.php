<?php
     ob_start();
	session_start(); 

		   if($_SESSION['poste']==cpersonnel)
		include 'menucp.php'; 
	   	   if($_SESSION['poste']==agent)
		include 'menuprin1.php'; 
			   if($_SESSION['poste']==directrice)
		include 'menudirec.php'; 
			   if($_SESSION['poste']==admin)
		include 'admin.php';
		include 'connexion.php'; 
 require_once('Connexion_2.php');		
		
		
	// automatisation du numéro
	function random($car) {
		$string = "F";
		$chaine = "0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
		}
	function chiffre_en_lettre($montant, $devise1='', $devise2='')
{
    if(empty($devise1)) $dev1='Dinars';
    else $dev1=$devise1;
    if(empty($devise2)) $dev2='';
    else $dev2=$devise2;
    $valeur_entiere=intval($montant);
    $valeur_decimal=intval(round($montant-intval($montant), 2)*100);
    $dix_c=intval($valeur_decimal%100/10);
    $cent_c=intval($valeur_decimal%1000/100);
    $unite[1]=$valeur_entiere%10;
    $dix[1]=intval($valeur_entiere%100/10);
    $cent[1]=intval($valeur_entiere%1000/100);
    $unite[2]=intval($valeur_entiere%10000/1000);
    $dix[2]=intval($valeur_entiere%100000/10000);
    $cent[2]=intval($valeur_entiere%1000000/100000);
    $unite[3]=intval($valeur_entiere%10000000/1000000);
    $dix[3]=intval($valeur_entiere%100000000/10000000);
    $cent[3]=intval($valeur_entiere%1000000000/100000000);
	
    $chif=array('', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize', 'dix sept', 'dix huit', 'dix neuf');
        $secon_c='';
        $trio_c='';
    for($i=1; $i<=3; $i++){
        $prim[$i]='';
        $secon[$i]='';
        $trio[$i]='';
        if($dix[$i]==0){
            $secon[$i]='';
            $prim[$i]=$chif[$unite[$i]];
        }
        else if($dix[$i]==1){
            $secon[$i]='';
            $prim[$i]=$chif[($unite[$i]+10)];
        }
        else if($dix[$i]==2){
            if($unite[$i]==1){
            $secon[$i]='Vingt et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='Vingt';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==3){
            if($unite[$i]==1){
            $secon[$i]='Trente et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='trente';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==4){
            if($unite[$i]==1){
            $secon[$i]='Quarante et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='Quarante';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==5){
            if($unite[$i]==1){
            $secon[$i]='Cinquante et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='Cinquante';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==6){
            if($unite[$i]==1){
            $secon[$i]='Soixante et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='Soixante';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==7){
            if($unite[$i]==1){
            $secon[$i]='Soixante et';
            $prim[$i]=$chif[$unite[$i]+10];
            }
            else {
            $secon[$i]='Soixante';
            $prim[$i]=$chif[$unite[$i]+10];
            }
        }
        else if($dix[$i]==8){
            if($unite[$i]==1){
            $secon[$i]='Quatre-vingts et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='Quatre-vingt';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==9){
            if($unite[$i]==1){
            $secon[$i]='Quatre-vingts et';
            $prim[$i]=$chif[$unite[$i]+10];
            }
            else {
            $secon[$i]='Quatre-vingts';
            $prim[$i]=$chif[$unite[$i]+10];
            }
        }
        if($cent[$i]==1) $trio[$i]='Cent';
        else if($cent[$i]!=0 || $cent[$i]!='') $trio[$i]=$chif[$cent[$i]] .' cents';
    }
     
     
$chif2=array('', 'dix', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante-dix', 'quatre-vingts', 'quatre-vingts dix');
    $secon_c=$chif2[$dix_c];
    if($cent_c==1) $trio_c='Cent';
    else if($cent_c!=0 || $cent_c!='') $trio_c=$chif[$cent_c] .' cents';
     
    if(($cent[3]==0 || $cent[3]=='') && ($dix[3]==0 || $dix[3]=='') && ($unite[3]==1))
        echo $trio[3]. '  ' .$secon[3]. ' ' . $prim[3]. ' million ';
    else if(($cent[3]!=0 && $cent[3]!='') || ($dix[3]!=0 && $dix[3]!='') || ($unite[3]!=0 && $unite[3]!=''))
        echo $trio[3]. ' ' .$secon[3]. ' ' . $prim[3]. ' millions ';
    else
        echo $trio[3]. ' ' .$secon[3]. ' ' . $prim[3];
     
    if(($cent[2]==0 || $cent[2]=='') && ($dix[2]==0 || $dix[2]=='') && ($unite[2]==1))
        echo ' mille ';
    else if(($cent[2]!=0 && $cent[2]!='') || ($dix[2]!=0 && $dix[2]!='') || ($unite[2]!=0 && $unite[2]!=''))
        echo $trio[2]. ' ' .$secon[2]. ' ' . $prim[2]. ' mille ';
    else
        echo $trio[2]. ' ' .$secon[2]. ' ' . $prim[2];
     
    echo $trio[1]. ' ' .$secon[1]. ' ' . $prim[1];
     
    echo ' '. $dev1 .' ' ;
     
}
		
	//enregistrement de la fiche
	
		  if (isset($_POST['ENREGISTRER'])&& $_POST['ENREGISTRER']=='ENREGISTRER') 
			{ $_SESSION['np']=$_POST['edit23']; 
			  $_SESSION['numch']= $_POST['combo3'];
			  /* $res=mysql_query("SELECT nomch FROM chambre WHERE numch='".$_SESSION['numch']."'"); 
					while ($ret=mysql_fetch_array($res)) 
						{
							$nomch=$ret['nomch'];
						}echo $nomch; */
			  //$_SESSION['numero_c']= 'CL30107';
			  $_SESSION['numero_c']= $_POST['combo_5'];
			  $_SESSION['date']= date('Y-m-d');
			  $res=mysql_query("SELECT numfiche FROM fiche1 WHERE numcli='".$_SESSION['numero_c']."'AND etatsortie='NON' AND codegrpe='".$_SESSION['groupe']."' AND datarriv='".$_SESSION['date']."'"); 
					while ($ret=mysql_fetch_array($res)) 
						{
							$numero_f=$ret['numfiche'];
						} //echo "<br/>"  ; 
						//echo $numero_f
			 $totalRows_Recordset = mysql_num_rows($res);
			 if($totalRows_Recordset==2) $etat_6=6;
			  $_SESSION['ttc']=$_POST['edit26'];
			  $numch= $_POST['combo3'];

			  	    $date=$_POST['edit_24'];	
                    $_SESSION['numch']= $_POST['combo3'];	
                    $_SESSION['type_occup']= $_POST['combo4'];					
					if($_POST['combo4']=='double')	$etat1=1;					
					$res=mysql_query("SELECT nomch FROM chambre WHERE numch='".$_SESSION['numch']."'"); 
					while ($ret=mysql_fetch_array($res)) 
						{
							$nomch=$ret['nomch'];
						}
					$taxe=$_POST['edit28'];
					$tarif=$_POST['edit24'];
					$type_chambre=$_POST['edit22'];
					$type_occupation=$_POST['combo4'];
					$montant_ht=$_POST['edit25'];
					$Ttaxe=$_POST['combo5'];
					$Tnuite=$_POST['edit28'];
					//$Ttva=0;
					$Ttva=$_POST['combo6'];
					$TVA=$_POST['edit29'];
					$Mttc=$_POST['edit26'];
					$Avance=$_POST['edit27'];
					$numcli=$_POST['combo_5'];
							
			$ret="SELECT * FROM fiche1, compte WHERE fiche1.numfiche=compte.numfiche and numch='$numch' and etatsortie='NON' LIMIT 1";
            $ret1=mysql_query($ret);
			$ret2=mysql_fetch_array($ret1);
			if ($ret2)
              {   
					$etat_3=5;

				 
				if (($ret2['datarriv']==date('Y-m-d')) and ($ret2['typeoccup'])=='double')
				{   if (($numero_f!='')AND ($numch!=''))
					{$reta=mysql_query("INSERT INTO compte VALUES ('$numero_f','".$_SESSION['numch']."','". $_SESSION['type_occup']."','".$_POST['edit24']."','".$_POST['edit23']."','".$_POST['edit25']."','".$_POST['combo5']."','".$_POST['edit28']."','".$_POST['combo6']."','".$_POST['edit29']."','".$_POST['edit26']."','".$_POST['edit30']."','".$_SESSION['due']."','".$_POST['edit32']."')");
						if($reta) 
							{ //header('location:fiche.php');
							  $etat_2='true';
							}
					}else $msg_1='Veuillez sélectionner la chambre à occuper';
				}
				else 
				{
					echo "<script language='javascript'>alert('Cette chambre est occupée');</script>";
				}
			} else 
			{
				
				$_SESSION['nuit']=$_POST['combo5'];
				//$_SESSION['numch']=$_POST['combo3']; 
				$_SESSION['tch']=$_POST['edit22']; 
				//$_SESSION['occup']=$_POST['combo4']; 
				$_SESSION['tarif']=$_POST['edit24']; 
				$_SESSION['mt']=$_POST['edit25']; 
				$_SESSION['taxe']=$_POST['edit28']; 
				$_SESSION['tv']=$_POST['combo6']; 
				$_SESSION['tva']=$_POST['edit29']; 
				//$_SESSION['somme']=$_POST['edit30']; 
				$_SESSION['due']=$_POST['edit31']; 
				//enregistrement du compte
                if (($numero_f!='')AND ($numch!='')){				
				$reto=mysql_query("INSERT INTO compte VALUES ('$numero_f','".$_SESSION['numch']."','". $_SESSION['type_occup']."','".$_POST['edit24']."','".$_POST['edit23']."','".$_POST['edit25']."','".$_POST['combo5']."','".$_POST['edit28']."','".$_POST['combo6']."','".$_POST['edit29']."','".$_POST['edit26']."','".$_POST['edit30']."','".$_SESSION['due']."','".$_POST['edit32']."')");
				//echo "INSERT INTO compte VALUES ('$numfiche','".$_SESSION['numch']."','". $_SESSION['type_occup']."','".$_POST['edit24']."','".$_POST['edit23']."','".$_POST['edit25']."','".$_POST['combo5']."','".$_POST['edit28']."','".$_POST['combo6']."','".$_POST['edit29']."','".$_POST['edit26']."','".$_POST['edit30']."','".$_SESSION['due']."','".$_POST['edit32']."')";
				}if ($reto)
				{ $etat_2='true';  
				  if ($_SESSION['somme']!=0)
					{
						$en=mysql_query("INSERT INTO encaissement VALUES ('".date('Y-m-d')."','".$_SESSION['num']."','".$_SESSION['somme']."','".$_SESSION['login']."')");
						if ($en)
						{if ($_SESSION['somme']!=0){// header('location:recufiche.php');
						} else {$smg='Enrégistrement effectué avec succès'; header('location:fiche.php');}
						} else 
						{
							echo "<script language='javascript'>alert('Echec d'enregistrement');</script>"; 
						}
					}
				} else {echo "<script language='javascript'>alert('Echec d'enregistrement'); </script>"; }
			}
			//requete pour compter le nombre d'occuper 
			$ze=mysql_query("SELECT count(numch) FROM fiche1, compte WHERE numch='".$_SESSION['numch']."' and fiche1.numfiche=compte.numfiche and datarriv='".date('Y-m-d')."'");
			$zer=mysql_fetch_array($ze);
			if ($zer[0]==0)
			{
				//echo $zer[0];
				$ze1=mysql_query("SELECT fiche1.numfiche FROM fiche1, compte WHERE etatsortie='NON' and fiche1.numfiche=compte.numfiche and numch='".$_SESSION['numch']."'");
				//echo "SELECT numfiche FROM fiche1, compte WHERE etatsortie='NON' and fiche1.numfiche=compte.numfiche and numch='".$_POST['combo3']."'"; 
				$zer1=mysql_fetch_array($ze1);
				if ($zer1)
					{"<script language='javascript'>alert('La chambre est occupée'); </script>"; }

			} else 
				{
					if ($zer[0]==1)
					{
					 $ze2=mysql_query("SELECT typeoccup FROM compte,fiche1 WHERE numch='".$_SESSION['numch']."' and fiche1.numfiche=compte.numfiche and  datarriv='".date('Y-m-d')."'");
						$zer2=mysql_fetch_array($ze2);
						if ($zer2)
						{
							switch ($zer2)
							{
								//case 'individuelle': { echo "<script language='javascript'>alert('Cette chambre est occupée');</script>"; } break; 
								case 'double': 
									{$ret=mysql_query("INSERT INTO compte VALUES ('$numero_f', '".$_SESSION['numch']."', '". $_SESSION['type_occup']."', '0', '0', '0','0','0','0','0','0','0','0','0')");header('location:recufiche.php');} break; 
								default: echo''; break; 
							}
						} 
					} else 
					{
						// echo "<script language='javascript'>alert('Cette chambre est occupée');</script>";
					}
				}
			//$_SESSION['sum']=$_POST['edit_37']; 
			$_SESSION['date']= date('Y-m-d');
			$res=mysql_query("SELECT sum(ttc) AS total FROM fiche1,compte WHERE fiche1.numfiche=compte.numfiche AND etatsortie='NON' AND codegrpe='".$_SESSION['groupe']."' AND datarriv='".$_SESSION['date']."'"); 
			while ($ret=mysql_fetch_array($res)) 
				{
					$total=$ret['total'];
				}
			$_SESSION['total_tt']= $total;
			
			}				
	if (isset($_POST['va'])&& $_POST['va']=='VALIDER') 
		{
		    $etat5=3;
			$_SESSION['total_ttA']= $_POST['edit_37'];
			$_SESSION['np']=$_POST['edit23']; 
		    $somme_remise=$_POST['edit33'];
			//$nuite_payee=$_POST['edit32'];
			$_SESSION['date']=$_POST['edit_25'];
            $_SESSION['somme1']= $_POST['edit_37']; 
            $_SESSION['ttc']= $_POST['edit_38'];
			$_SESSION['avance']= $somme_remise;
			$_SESSION['net']= $_POST['edit31'];			
			if($_POST['edit30']!='')
			{$etat='true';
			$en=mysql_query("INSERT INTO encaissement VALUES ('".date('Y-m-d')."','$numero_f','".$_POST['edit30']."','".$_SESSION['login']."')");
			$_SESSION['date']= date('Y-m-d');
			$res=mysql_query("SELECT sum(ttc) AS total FROM fiche1,compte WHERE fiche1.numfiche=compte.numfiche AND etatsortie='NON' AND codegrpe='".$_SESSION['groupe']."' AND datarriv='".$_SESSION['date']."'"); 
			while ($ret=mysql_fetch_array($res)) 
				{
					$total=$ret['total'];
				}
			$_SESSION['total_tt']=$total;
			$_SESSION['total_ttc']= ucfirst(chiffre_en_lettre($total,$devise1='Francs CFA',$devise2=''));
			header('location:facture_de_groupe.php'); 
			}
			else $msg_4='Enregistrement effectué avec succès';		
		}
?>
<html>  
	<head> 
		<title> SYGHOC </title>
		<script type="text/javascript">
		function Aff()
		{
			if (document.getElementById("edit23").value!='') 
			{
				document.getElementById("edit25").value=(('\t'+document.getElementById("edit24").value)*document.getElementById("edit23").value).toFixed(4); 
			}
		}
		function Aff1()
		{
			if (document.getElementById("edit23").value!='') 
			{
				if(document.getElementById("combo4").value=='individuelle')
				document.getElementById("edit28").value=document.getElementById("edit23").value*document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value; 
				else
				document.getElementById("edit28").value=2*document.getElementById("edit23").value*document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value; 
			}
		}
		function Aff2()
		{
			if (document.getElementById("edit25").value!='') 
			{
				document.getElementById("edit29").value=(document.getElementById("edit25").value*document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value).toFixed(4);  
				y=parseFloat(document.getElementById("edit28").value)+parseFloat(document.getElementById("edit29").value)+parseFloat(document.getElementById("edit25").value); 
				document.getElementById("edit26").value=Math.floor(y);
			}
		}
		function Aff3()
		{
			if (document.getElementById("edit33").value!='') 
			{
				document.getElementById("edit31").value=parseInt(document.getElementById("edit_38").value)-parseInt(document.getElementById("edit33").value);
				document.getElementById("edit32").value=Math.floor(document.getElementById("edit33").value/
							(parseInt(document.getElementById('combo5').options[document.getElementById('combo5').selectedIndex].value)+
							 ((document.getElementById('combo6').options[document.getElementById('combo6').selectedIndex].value)*('\t'+document.getElementById("edit24").value)+parseInt('\t'+document.getElementById("edit24").value)))); 
			}
		}
		function Aff4()
		{
			if (document.getElementById("edit27").value!='') 
			{
				document.getElementById("edit33").value=parseInt(document.getElementById("edit30").value)+parseInt(document.getElementById("edit27").value);
			} else
			{
				document.getElementById("edit33").value=parseInt(document.getElementById("edit30").value);
			} 
		}
			</script>
	</head> 
	<body>
		<table align='center'>
		<tr>
				<td>
					<fieldset> 
						<legend align='center'><span style='font-weight:bold;'> SELECTION DES CHAMBRES POUR LES MEMBRES DU GROUPE</span></legend> 
						<form action='edition_facture_grpe.php' method='post' >
						<input type='hidden' name='edit_35' id='edit_35' value='<?php echo $chaine = random(5);?>'/>
							<table style=''> 
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								
							
								<span style='font-style:italic;font-size:0.8em;'> Pour une occupation double, sélectionnez les deux occupants de la chambre</span>


								<tr>
									<td><b>  Somme Remise : </b> </td>
									<td> <input type='text' name='edit30' id='edit30' onblur='Aff4();'value='<?php if($etat5==3)echo $somme_remise;?>'/> </td>
									<td> <b> Total payé : </b>  </td>
									<td> <input type='text' name='edit33' id='edit33' onblur='Aff3();'value='<?php if($etat5==3)echo $total_paye;?>'/> </td>
								</tr>
<!-- 								<tr>
								<td><b>  Somme due :  </b> </td>
									<td> <input type='text' name='edit31' id='edit31' readonly value='<?php if($etat5==3)echo $somme_due;?>'/> </td>
									<td> <b> Nuite Payée : </b>  </td>
									<td> <input type='text' name='edit32' id='edit32' readonly value='<?php if($etat5==3)echo $nuite_payee;?>'/> </td>
								</tr> -->
								<tr>
									<td colspan='4' align='center'> <br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								     <input type='submit' name='va' id='va' value='VALIDER' />
									</td>
								</tr>
	
	
							</table>

						</form>
					</fieldset>
				</td>
			</tr>
			
		</table>
<?php echo $msg; ?>		
	</body>
	<script type="text/javascript">
		
		

		// fonction pour selectionner le type de chambre
		function action6(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit22').value = '\t'+leselect;	
					}
				}
				xhr.open("POST","ftypech.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo3');
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("numch="+sh);
		}
		// fonction pour selectionner le tarif
		function action7(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit24').value = leselect;	
					}
				}
				xhr.open("POST","ftarif.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo4');
				sel1 = document.getElementById('combo3');
				sh1=sel1.options[sel1.selectedIndex].value;
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("objet="+sh+"&numch="+sh1);
		}
		
		//affichage des informations concernant le client 
		
		
		var momoElement1 = document.getElementById("combo3");
		if(momoElement1.addEventListener){
		  momoElement1.addEventListener("change", action6, false);
		 // momoElement1.addEventListener("change", action7, false);
		  //momoElement1.addEventListener("change", Verif, false);
		}else if(momoElement1.attachEvent){
		  momoElement1.attachEvent("onchange", action6);
		 // momoElement1.attachEvent("onchange", action7);
		  //momoElement1.attachEvent("onchange", verif);
		}
		
		var momoElement2 = document.getElementById("combo4");
		if(momoElement2.addEventListener){
		  momoElement2.addEventListener("change", action7, false);
		 
		}else if(momoElement2.attachEvent){
		  momoElement2.attachEvent("onchange", action7);
		 
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
