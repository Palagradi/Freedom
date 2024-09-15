<?php
include_once'menu.php';
	include 'chiffre_to_lettre.php'; 
	//$numfiche1=$_GET['numfiche1'];
	//$sal=$_GET['sal'];
	$numero=!empty($_GET['numero'])?$_GET['numero']:NULL;
	//echo "SELECT *  FROM payement_loyer,loyer  WHERE loyer.Numero=payement_loyer.Numero AND Etat='Npaye' AND Loyer.numero='$numero'";
		$reqselP=mysqli_query($con,"SELECT *  FROM payement_loyer,loyer  WHERE loyer.Numero=payement_loyer.Numero AND Etat='Npaye' AND Loyer.numero='$numero'");
		$rowP=mysqli_fetch_assoc($reqselP);  
	$montant=$rowP['Montant']; $debut_jour=substr($rowP['DatePayement'],0,2);
	$paye=0;
	$mois=!empty($_GET['mois'])?$_GET['mois']:NULL;	$ans=!empty($_GET['ans'])?$_GET['ans']:NULL;
	$moisT = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aôut","Septembre","Octobre","Novembre","Décembre");
	
	//$ans= date("Y");
	
		// automatisation du numéro
	function random($car) {
		$string = "";
		$chaine = "0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
		}
		
		// automatisation du numéro
	function random2($car) {
		$string = "G";
		$chaine = "0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
		}

	mysqli_query($con,"SET NAMES 'utf8'");
	$date=date('Y-m-d'); $jour=date("d");/* $mois=date("m");$annee=date("Y");
	if(($jour==20)||($jour==21)||($jour==22)||($jour==23)||($jour==24)||($jour==25)||($jour==26)||($jour==27)||($jour==28)||($jour==29)||($jour==30)||($jour==31))
		{$mois=date("m");$annee=date("Y");}
	else
		{if($mois==01) {$mois=12;  $annee=$annee-1;}else $mois=$mois-1;} */
	 //if(substr($mois,0,1)==0) $mois=substr($mois,1,1);else $mois=substr($mois,0,2);
	$mois_suivant=date("m"); //echo $mois."<br/>";
	$nbj=date("t",mktime(0,0,0,$mois,1,$ans));//nbre de jours du mois $i
	$jmoins=31-$nbj;
	$montant_ttc=100000;
	$montant_ht=84745.7627;
	$montant_tva=$montant_ht*0.18;
	if (isset($_POST['va'])&& $_POST['va']=='VALIDER') 
		{	if(($_POST['edit5']!='')&&($_POST['edit5']!=0))
			{if($_POST['edit5']==$_POST['edit3'])
				{	//$ret="INSERT INTO payement_loyer VALUES('$date','$mois','$annee','$montant_ttc','$montant_ht','$montant_tva')"; 
					$date=date('Y-m-d'); $mois=$_POST['mois'];$annee=$_POST['annee'];
					$de=mysqli_query($con,"UPDATE payement_loyer SET Etat='paye' WHERE mois_payement='$mois' AND annee_payement='$annee' AND Numero='".$_POST['edit2']."'");
					//$req=mysqli_query($ret);
					$en=mysqli_query($con,"INSERT INTO encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$_POST['edit2']."','".$_POST['edit5']."','".$_SESSION['login']."','Payement Loyer','".$_POST['edit2']."','','$montant_ht','$montant_ttc','1')");
					$req=mysqli_query($en); 					$_SESSION['mois_payement']=$mois;

		$reqselP=mysqli_query($con,"SELECT *  FROM payement_loyer,loyer  WHERE loyer.Numero=payement_loyer.Numero AND Etat='Npaye' AND Loyer.numero='".$_POST['edit2']."'");
		$rowP=mysql_fetch_assoc($reqselP);  
		$montant=$rowP['Montant'];  $debut_jour=substr($rowP['DatePayement'],0,2);
	
					$_SESSION['numfiche']=$_POST['edit2']; $mois1=$mois+1;
					if(($mois>=1)&&($mois<10)) $mois="0".$mois;
					if(($mois1>=1)&&($mois1<10)) $mois1="0".$mois1;
					$datE= $debut_jour.'/'.$mois.'/'.$annee;
				    $_SESSION['date']= $datE;
					$date_2=$debut_jour.'/'.$mois1.'/'.$annee;
					$_SESSION['date2']=$date_2;
					$_SESSION['tva']=$montant_tva;
					$_SESSION['montant_ht']=$montant_ht;
					$_SESSION['montant_ttc']=$montant_ttc;						
					$update=mysqli_query($con,"UPDATE configuration_facture SET num_fact=num_fact+1");	
					header('location:recu_loyer.php');
				}
				else
				{echo "<script language='javascript'> alert('Le montant à encaisser ne correspond pas au montant du Loyer.'); </script>"; 
				}				
			}else
			{echo "<script language='javascript'> alert('Renseigner le montant à encaisser SVP.'); </script>"; 
			}
		}
?>
<html>
	<head>
		<title>SYGHOC</title>
		<script type="text/javascript" src="date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
			<script type="text/javascript" >
				function edition1() { options = "Width=800,Height=450" ; window.open( "recu_loyer.php", "edition1", options ) ; } 
			</script>		
	</head>
	<body bgcolor='azure' style=""><br/>
		<form action='encaisse_loyer.php' method='post' name='encaisse'>
			<table align='center' width='750' style='' >
				<tr>
					<td>
							<fieldset style='border:2px solid white;background-color:#D0DCE0;font-family:Cambria;'>
							<legend align='center' style='font-size:1.3em;color:#3EB27B;'>	<h3 style="text-align:center; font-family:Cambria;color:maroon;font-weight:bold;"> ENCAISSEMENT <?php echo 'LOCATION MENSUELLE';  ?></h3></legend> 
							<table style=''>
								<input type='hidden' name='nbj' id='nbj' value='<?php echo $nbj; ?>' readonly /> 
								<tr>
									<td style='padding-left:50px;'> </br>N° de la fiche: </td>
									<td> </br><input type='text' name='edit2' id='edit2' value='<?php if($numero!='') echo $numero;?>' readonly /> 
									
							
											<td ></br> Type d'encaissement: </td>
									<td>
										</br><input type='text' name='combo1' id='combo1' value='Loyer' readonly /> 
										
									
									<input type='hidden' name='mois' id='mois' value='<?php echo $mois;?>' readonly />
									<input type='hidden' name='annee' id='annee' value='<?php echo $annee;?>' readonly />
									<td>
								</tr>
								<tr>
									<td style='padding-left:50px;'></br> Mois à payer: </td>
									<td> </br><input type='text' name='edit1' id='edit1' value='<?php echo $moisT[$mois-1]."&nbsp;".$annee;?>' readonly />
									<input type='hidden' name='groupe' id='groupe' value='<?php if(!empty($groupe)) echo $groupe;?>'/>
									<input type='hidden' name='date' id='date' value='<?php if($date!='') echo $date;?>'/>
									
									</td>
									<td></br>Montant dû ce jour: </td>
									<td></br> <input type='text' name='edit3' id='edit3' value='<?php echo $montant ?>' readonly />  <td>
								</tr>
								<tr>
									<td style='padding-left:50px;'></br>Somme remise: </td>
									<td> </br><input type='text' name='edit5' id='edit5' value=''  onkeyup='Aff();' onkeypress="testChiffres(event);" /> </td>
									<td></br>Reste à payer: </td>
									<td></br> <input type='text' name='edit4' id='edit4' value='' readonly /> <td>
								</tr>
								<tr><td style='color:peachpuff'>&nbsp;&nbsp; </td>
									<td> <input type='hidden' name='hidden' id='' value='<?php echo $chaine = random($Nbre_char);?>' /> <td>
								</tr>
								<tr>
							   <p id="">
							   </p>
								</tr>
								<tr> 
									<td colspan='4' align='center'> <input class='bouton2' type='submit' name='va' value='VALIDER' style="" <?php  echo "onclick='edition1();return false;'"; ?>/><br/>&nbsp; </td>
								</tr> 
							</table>
						</fieldset> 
			
		</form> 

<script type="text/javascript">
 
var res, plus, diz, s, un, mil, mil2, ent, deci, centi, pl, pl2, conj;
 
var t=["","un","deux","trois","quatre","cinq","six","sept","huit","neuf"];
var t2=["dix","onze","douze","treize","quatorze","quinze","seize","dix-sept","dix-huit","dix-neuf"];
var t3=["","","vingt","trente","quarante","cinquante","soixante","soixante","quatre-vingt","quatre-vingt"];
 
 
 
//window.onload=calcule
 
function calcule(){
    document.getElementById("t").onchange=function()
{
/*         document.getElementById("lettres").firstChild.data=trans(this.value)
		document.getElementById("lettre").value=document.getElementById("lettres").firstChild.data=trans(this.value) */
 }
}
 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// traitement des deux parties du nombre;
function decint(n){
 
    switch(n.length){
        case 1 : return dix(n);
        case 2 : return dix(n);
        case 3 : return cent(n.charAt(0)) + " " + decint(n.substring(1));
        default: mil=n.substring(0,n.length-3);
            if(mil.length<4){
                un= (mil==1) ? "" : decint(mil);
                return un + mille(mil)+ " " + decint(n.substring(mil.length));
            }
            else{    
                mil2=mil.substring(0,mil.length-3);
                return decint(mil2) + million(mil2) + " " + decint(n.substring(mil2.length));
            }
    }
}
 
 
 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// traitement des nombres entre 0 et 99, pour chaque tranche de 3 chiffres;
function dix(n){
    if(n<10){
        return t[parseInt(n)]
    }
    else if(n>9 && n<20){
        return t2[n.charAt(1)]
    }
    else {
        plus= n.charAt(1)==0 && n.charAt(0)!=7 && n.charAt(0)!=9 ? "" : (n.charAt(1)==1 && n.charAt(0)<8) ? " et " : "-";
        diz= n.charAt(0)==7 || n.charAt(0)==9 ? t2[n.charAt(1)] : t[n.charAt(1)];
        s= n==80 ? "s" : "";
 
        return t3[n.charAt(0)] + s + plus + diz;
    }
}
 
 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// traitement des mots "cent", "mille" et "million"
function cent(n){
return n>1 ? t[n]+ " cent" : (n==1) ? " cent" : "";
}
 
function mille(n){
return n>=1 ? " mille" : "";
}
 
function million(n){
return n>=1 ? " millions" : " million";
}
 
 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// conversion du nombre
function trans(n){
 
    // vérification de la valeur saisie
    if(!/^\d+[.,]?\d*$/.test(n)){
        return "L'expression entrée n'est pas un nombre."
    }
 
    // séparation entier + décimales
    n=n.replace(/(^0+)|(\.0+$)/g,"");
    n=n.replace(/([.,]\d{2})\d+/,"$1");
    n1=n.replace(/[,.]\d*/,"");
    n2= n1!=n ? n.replace(/\d*[,.]/,"") : false;
 
    // variables de mise en forme
    ent= !n1 ? "" : decint(n1);
    deci= !n2 ? "" : decint(n2);
    if(!n1 && !n2){
        return  "Zéro Francs CFA. (Mais, de préférence, entrez une valeur non nulle!)"
    }
    conj= !n2 || !n1 ? "" : "  et ";
    euro= !n1 ? "" : !/[23456789]00$/.test(n1) ? " Francs CFA" : " Francs CFA";
    centi= !n2 ? "" : " centime";
    pl=  n1>1 ? "" : "";
    pl2= n2>1 ? "" : "";
 
    // expression complète en toutes lettres
    return (ent + euro + pl + conj + deci + centi + pl2).replace(/\s+/g," ").replace("cent s E","cents E");
 
}
 
</script>
	</body>
	<script type="text/javascript">
	
	
		function Aff()
		{if(document.getElementById('edit5').value>=document.getElementById('edit3').value)
			document.getElementById('edit4').value=document.getElementById('edit5').value-document.getElementById('edit3').value;
		}
		
		
		
		function action(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit3').value = leselect;	
					}
				}
				xhr.open("POST","enmontant.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo1');
				sel1 = document.getElementById('edit2');
				sh1=sel1.value;
				sh = sel.options[sel.selectedIndex].value;
				xhr.send("type="+sh+"&num="+sh1);
		}
		
	
	
		function action1(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit4').value = leselect;	
					}
				}
				xhr.open("POST","endue.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('combo1');
				sel1 = document.getElementById('edit2');
				sh1=sel1.value;
				sh = sel.options[sel.selectedIndex].value;
				//sl=document.getElementById('edit8').options[document.getElementById('edit8').selectedIndex].value
				xhr.send("type="+sh+"&num="+sh1);
		}
		
		function action2(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit9').value = leselect;	
					}
				}
				xhr.open("POST","montantdue.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit6');
				sh2=sel.options[sel.selectedIndex].value;
				sel1 = document.getElementById('ladate');
				sh1=sel1.value;
				sh_1 = document.getElementById('ladate2');
				sh = sh_1.value;
				xhr.send("nom="+sh2+"&date1="+sh1+"&date2="+sh);
		}		
		
		var momoElement = document.getElementById("edit2");
		if(momoElement.addEventListener){
		  momoElement.addEventListener("blur", action, false);
		  momoElement.addEventListener("keyup", action, false);
		  momoElement.addEventListener("blur", action1, false);
		  momoElement.addEventListener("keyup", action1, false);
		}else if(momoElement.attachEvent){
		  momoElement.attachEvent("onblur", action);
		  momoElement.attachEvent("onkeyup", action);
		  momoElement.attachEvent("onblur", action1);
		  momoElement.attachEvent("onkeyup", action1);

		}			

		var momoElement2 = document.getElementById("edit6");
		if(momoElement2.addEventListener){
		  momoElement2.addEventListener("blur", action2, false);
		  momoElement2.addEventListener("keyup", action2, false);
		  momoElement2.addEventListener("change", action2, false);
		}else if(momoElement2.attachEvent){
		  momoElement2.attachEvent("onblur", action2);
		  momoElement2.attachEvent("onkeyup", action2);
		  momoElement2.attachEvent("change", action2);
  
		}
		
		
		function changer()
		{
			if (document.getElementById("edit9").value!='') 
			{
				document.getElementById("t").value=parseInt(document.getElementById("edit9").value); 
			}
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