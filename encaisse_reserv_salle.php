<?php 
	session_start(); 
	ob_start();
	include 'menuprin1.php'; 
	include 'connexion.php';
	include 'chiffre_to_lettre.php';  $codegrpe=$_GET['codegrpe'];$impaye=$_GET['impaye'];$sal=$_GET['sal'];$numresch=$_GET['numresch'];
		$numfiche1=$_GET['numfiche1'];$fiche=$_GET['fiche'];$numero=$_GET['numero']; $numfiche=$_GET['numfiche']; $somme=$_GET['somme'];$due=$_GET['due'];
if (($_POST['edit5']!=0))
				{ 	$_SESSION['chambre']=0;	
					$res=mysql_query("SELECT numfiche  FROM exonerer_tva WHERE numfiche='".$_POST['edit2']."'");
					while ($ret=mysql_fetch_array($res)) 
						{$numfiche_1=$ret['numfiche'];
						}
				$res=mysql_query("SELECT nuiterc AS nuiterc FROM reservationsal WHERE numresch='".$_POST['edit2']."'");
				while ($ret=mysql_fetch_array($res)) 
					{$nuiterc=$ret['nuiterc'];
					}
				if(empty($numfiche_1))
				$res=mysql_query("SELECT sum((0.18*mtrc)+mtrc+0.1) AS somme FROM reserversal WHERE reserversal.numresch='".$_POST['edit2']."'");
				else
				$res=mysql_query("SELECT sum(mtrc) AS somme FROM reserversal WHERE  reserversal.numresch='".$_POST['edit2']."'");
				while ($ret=mysql_fetch_array($res)) 
					{if(empty($numfiche_1)) $total=(int) ($ret['somme']*$nuiterc);else $total=$ret['somme']*$nuiterc;
					}
				$due=$total-$avancerc;
			    $_SESSION['total']=$total;
		
					$ret=mysql_query('SELECT DISTINCT salle.numsalle,reservationsal.datarrivch,salle.typesalle,reserversal.codesalle,reserversal.tarifrc,reserversal.mtrc FROM reservationsal,reserversal,salle WHERE reserversal.numresch=reservationsal.numresch   AND reserversal.numsalle=salle.numsalle AND reserversal.numresch="'.$_POST['edit2'].'"');
					while ($ret1=mysql_fetch_array($ret))
					{ $codesalle=$ret1['codesalle']; 
					  $typesalle=$ret1['typesalle']; 					
					  $tarifrc=$ret1['tarifrc'];	
					  $ttc1=(int)($tarifrc);
					  $np_sal=$_POST['edit5']/$ttc1;
					  $mtttc=(int)($tarifrc);
					  $debut=$ret1['datarrivch']; 
					  $fin=$ret1['datarrivch']; 
					  $numsalle=$ret1['numsalle'];
					  $_SESSION['np_sal']=$np_sal-1;
					  if($mtttc==$_POST['edit5'])
					  {		$tr1="UPDATE reserversal SET  avancerc=avancerc+'$mtttc', nuite_payee='".$np_sal."' WHERE numresch='".$_POST['edit2']."' AND numsalle='$numsalle'";
							$tre_1=mysql_query($tr1);
							$tr="UPDATE reservationsal SET  avancerc=avancerc+'$mtttc' WHERE numresch='".$_POST['edit2']."' AND numsalle='$numsalle'";
							$tre=mysql_query($tr);
							$etat=1;
							//echo $tr1."<br/>".$tr;
					  }
					}
					if($total==$_POST['edit5'])
					{$ret=mysql_query('SELECT sum(mtrc) AS mtrc,sum(tarifrc) AS tarifrc  FROM reserversal,salle WHERE reserversal.numsalle=salle.numsalle AND reserversal.numresch="'.$_POST['edit2'].'"');
					while ($ret1=mysql_fetch_array($ret))
					{ $mtrc=$ret1['mtrc']; 
					  $tarifrc=$ret1['tarifrc'];
					  if($etat!=1)
					{$tr1="UPDATE reserversal SET  avancerc=avancerc+'".$_POST['edit5']."', nuite_payee='".$np_sal."' WHERE numresch='".$_POST['edit2']."' AND numsalle='$numsalle'";
					$tre_1=mysql_query($tr1);
					$tr="UPDATE reservationsal SET  avancerc=avancerc+'".$_POST['edit5']."' WHERE numresch='".$_POST['edit2']."' AND numsalle='$numsalle'";
					$tre=mysql_query($tr);
					}
					$_SESSION['mtht']=$mtrc;
					$_SESSION['mtttc']=(int)(($tarifrc+0.1)*$nuiterc);
		
					//echo $tr1."<br/>".$tr;
					}
					}
					$_SESSION['mtht']=$mtrc;
					$_SESSION['mtttc']=(int)(($tarifrc+0.1)*$nuiterc);
					
					$_SESSION['debut']=substr($debut,8,2).'/'.substr($debut,5,2).'/'.substr($debut,0,4);
					$_SESSION['fin']=substr($fin,8,2).'/'.substr($fin,5,2).'/'.substr($fin,0,4);
					$tu=mysql_query("INSERT INTO encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$_POST['edit2']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation salle','".$typesalle."','','$mtrc','$ttc1','$np_sal')");
					$update=mysql_query("UPDATE configuration_facture SET num_fact=num_fact+1 ");
					header('location:recurc2.php');

				}
?>


<html>
	<head>
		<title>SYGHOC</title>
		<script type="text/javascript" src="date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
	</head>
	<body> 
		<form action='encaissement.php' method='post' name='encaissement'>
			<table align='center' style='font-size:1.1em;'>
				<tr>
					<td>
						
					</td>
					<td> 
						
					</td> 
				</tr>
				<tr>
					<td>
						<fieldset> 
							<legend align='center'style='color:#DA4E39;'><b> ENCAISSEMENT FICHE INDIVUDUELLE</b></legend> 
							<table>
								<tr>
									 <span style='font-style:italic;font-size:0.9em;'>Attention: si le client occupe toujours la même chambre, alors encaisser le montant. Dans le cas d'un  </br>changement de chambre, alors faites d'abord le départ du client
									 et procéder encore à une entrée du client.</span>
								</tr>
								<tr>
									<td></br> Type d'encaissement: </td>
									<td>
										</br><select name='combo1' id='combo1' style='width:150px;'>
											<?php
											if(($numero!='')||($fiche==1)) echo "<option value='fiche'> Hébergement</option> ";
											if(($sal==1)&&(empty($numresch))) echo"<option value='location'> Location</option> ";
											if(($numresch!='')) echo"<option value='reservation'> Réservation</option>";
											else
											{echo "<option value='fiche'> Hébergement</option> 
												<option value='location'> Location</option> 
												<option value='reservation'> Réservation</option> ";
											}
											?>
									<td></br> Date: </td>
									<td> </br><input type='text' name='edit1' id='edit1' value='<?php echo date('d-m-Y') ?>' readonly /> <td>
								</tr>
								<tr>
									<td> N° de la fiche: </td>
									<td> <input type='text' name='edit2' id='edit2' value='<?php if($numfiche!='') echo $numfiche;  if($numero!='') echo $numero; if($numresch!='') echo $numresch;?>'  /> </td>
									<td>Nuit&eacute;e dû ce jour: </td>
									<td> <input type='text' name='edit3' id='edit3' value='<?php if((!empty($sal))&&(empty($numresch))) { echo $var2; } else {echo $due; }   ?>' readonly />  <td>
								</tr>
								<tr>
									<td> Total des Nuités payées: </td>
									<td> <input type='text' name='edit4' id='edit4' value='<?php if(!empty($sal)) { echo $var1; }  else { if($somme!='') echo $somme; } echo $avancerc; ?>' readonly /> </td>
									<td>Somme à encaisser: </td>
									<td> <input type='text' name='edit5' id='edit5' value='' onkeypress="testChiffres(event);" /> <td>
								</tr>
								<tr><td style='color:peachpuff'>hidden </td>
									<td> <input type='hidden' name='' id='' value='' /> <td>
								</tr>
								<tr>
							   <p id="">
							   </p>
								</tr>
								<tr> 
									<td colspan='4' align='center'><?php if($casse_facture!=1) echo "<input type='submit' name='va' value='VALIDER'"; echo 'onclick="if(!confirm(\'Voulez-vous vraiment continuer?\')) return false;"'; echo "/>";?> </td>
								</tr> 
							</table>
						</fieldset> 
					</td> 
				 <input type='hidden' name='edit15' id='edit15' readonly value="<?php echo $chaine = random(5);?>" /> 
				 <input type='hidden' name='edit_15' id='edit_15' readonly value="<?php echo $code_reel = $code_reel;?>" /> 
					<td>
						</td> 
				</tr>
			</table>
			<?php echo $msg_4;?>
           </div>
			
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
		{document.getElementById('edit1_0').value=document.getElementById('edit9').value;
		}
		function Aff2()
		{	/* if((document.getElementById("exonorer_tva").checked == false) || (document.getElementById("exonerer_AIB").checked == false))
				{ */
				document.getElementById("edit9").value=(document.getElementById("edit9").value-document.getElementById("hidden1").value).toFixed(4);
/* 				}
			else
				{document.getElementById("edit9").value=document.getElementById("edit9").value-document.getElementById("hidden3").value);
				} */
		}
		function Aff3()
		{	/* if((document.getElementById("exonorer_tva").value!=1)||(document.getElementById("exonerer_AIB").value!=1))
				{ */
				document.getElementById("edit9").value=(document.getElementById("edit9").value-document.getElementById("hidden2").value).toFixed(4);
/* 				}
			else
				{document.getElementById("edit9").value=document.getElementById("edit9").value-document.getElementById("hidden3").value);
				}	 */

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