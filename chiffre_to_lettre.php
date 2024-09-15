<?php
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
	
    $chif=array('', 'Un ', 'Deux ', 'Trois ', 'Quatre ', 'Cinq ', 'Six ', 'Sept ', 'Huit ', 'Neuf ', 'Dix ', 'Onze ', 'Douze ', 'Treize ', 'Quatorze ', 'Quinze ', 'Seize ', 'Dix sept ', 'Dix huit ', 'Dix neuf ');
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
            $secon[$i]='Trente';
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
        else if($cent[$i]!=0 || $cent[$i]!='') $trio[$i]=$chif[$cent[$i]] .' Cents';
    }
     
     
$chif2=array('', 'Dix', 'Dingt', 'Trente', 'Quarante', 'Cinquante', 'Soixante', 'Soixante-dix', 'Quatre-vingts', 'Quatre-vingts dix');
    $secon_c=$chif2[$dix_c];
    if($cent_c==1) $trio_c='cent';
    else if($cent_c!=0 || $cent_c!='') $trio_c=$chif[$cent_c] .' Cents';
     
	 $valeur='';
	 
    if(($cent[3]==0 || $cent[3]=='') && ($dix[3]==0 || $dix[3]=='') && ($unite[3]==1))
        $valeur.=$trio[3]. '  ' .$secon[3]. ' ' . $prim[3]. ' Million ';
    else if(($cent[3]!=0 && $cent[3]!='') || ($dix[3]!=0 && $dix[3]!='') || ($unite[3]!=0 && $unite[3]!=''))
        $valeur.=$trio[3]. ' ' .$secon[3]. ' ' . $prim[3].'Millions ';
    else
        $valeur.=$trio[3]. ' ' .$secon[3]. ' ' . $prim[3];
     
    if(($cent[2]==0 || $cent[2]=='') && ($dix[2]==0 || $dix[2]=='') && ($unite[2]==1))
        $valeur.=' mille ';
    else if(($cent[2]!=0 && $cent[2]!='') || ($dix[2]!=0 && $dix[2]!='') || ($unite[2]!=0 && $unite[2]!=''))
        $valeur.=$trio[2]. ' ' .$secon[2]. ' ' . $prim[2]. ' Mille ';
    else
        $valeur.=$trio[2]. ' ' .$secon[2]. ' ' . $prim[2];
     
    $valeur.=$trio[1]. ' ' .$secon[1]. ' ' . $prim[1];
     
    $valeur.=$dev1 .' ' ;
	
	return ucfirst($valeur);
     
}
?>