<?php
session_start();
if(isset($_SESSION['remise'])&& ($_SESSION['remise']>0))
	require('fpdf17/fpdf.php');
else
	require('fpdf17/fpdf2.php');
//@include('connexion.php');  

include 'chiffre_to_lettre.php'; //include 'fpdf2/code128.php';
		
class PDF extends FPDF
{ /* 	function temporaire( $texte )
	{
		$this->SetFont('Arial','B',50);
		$this->SetTextColor(203,203,203);
		$this->Rotate(45,55,190);
		$this->Text(75,190,$texte);
		$this->Rotate(0);
		$this->SetTextColor(0,0,0);
	} */
	//if(isset($_GET['d'])&& ($_GET['d']==1)) $this->temporaire( "Duplicata" );
	function Header()
	{  	if($this->PageNo()==1)
	    {	
		global $mydate;
		//$this->Ln('4');
		$this->SetFont('Arial','B',14);
		//Titre encadré
		$this->SetTextColor(100,150,255);
		//$sDateReturn=substr(date("Y-m-d")).'-'.substr(date("Y-m-d")).'-'.substr(date("Y-m-d"));
		if(isset($_SESSION['nomHotel'])) $this->Cell(0,0,$_SESSION['nomHotel'],0,1,'');   
		//$this->Ln('0');
		$this->SetFont('Arial','I',10);
		$this->SetTextColor(0,0,0);
		if(empty($_SESSION['date_emission']))
		$this->Cell(0,0,'                            
		                                                                                                                                  Cotonou le, '.substr(date("Y-m-d"),8,2).'/'.substr(date("Y-m-d"),5,2).'/'.substr(date("Y-m-d"),0,4),0,1,'');
		else
				$this->Cell(0,0,'                            
		                                                                                                                                  Cotonou le, '.substr($_SESSION['date_emission'],8,2).'/'.substr($_SESSION['date_emission'],5,2).'/'.substr($_SESSION['date_emission'],0,4),0,1,'');$this->Ln('4');
		$this->SetFont('Arial','B',13);
		$this->SetTextColor(100,150,255);
		//Titre encadré
		$this->Cell(0,60,'              ',0,1,'');    //CODIAM
		
		//$this->Ln('4');
		$this->SetFont('Arial','B',13);
		$this->SetTextColor(0,0,0);
		

										
		//Titre encadré
		$this->Cell(0,0,"Facture N°: ".$_SESSION['initial_fiche'],0,1,'C');
		if(isset($_SESSION['logo'])) $this->Image($_SESSION['logo'],10,15,30,20);
		$this->SetFont('Arial','',10);
		
		$this->SetTextColor(0,0,0);
		$this->fact_dev( "Détails de la facture ", "" );
		if(isset($_SESSION['remise'])&& ($_SESSION['remise']>0))
			$this->addDate($_SESSION['remise']);  //REMISE
		else
			$this->addDate($_SESSION['avanceA']);
		if($_SESSION['montant']<$_SESSION['avanceA']) $_SESSION['montant']=$_SESSION['avanceA'] ;
		if(isset($_SESSION['remise'])&& ($_SESSION['remise']>0))
			$this->addClient($_SESSION['montant']-$_SESSION['remise']);  //SOMME PAYEE
		else
			$this->addClient($_SESSION['montant']-$_SESSION['avanceA']);  //SOMME PAYEE
		$this->addPageNumber($_SESSION['montant']);
		
		
		$this->SetTextColor(0,0,0);
		$this->addReglement($_SESSION['groupe1']);
		
		$this->SetTextColor(0,0,0);
		$this->addEcheance( "Hébergement");
		//$_SESSION['fin']="04-04-2014";
		$this->addNumTVA(  "Du"." ".$_SESSION['debut']." "."au"." ".$_SESSION['fin'] );
		$this->Ln('10');	
		}
		
	
		
	}		// Ajoute une remarque (en bas, a gauche)
		function addRemarque($remarqu,$remarque)
		{
			$this->SetFont( "Arial", "", 10);
			$length = $this->GetStringWidth( "Remarque : " . $remarque );
			$r1  = 10;
			$r2  = $r1 + $length;
			$y1  = $this->h - 45.5;
			$y2  = $y1+5;
			$this->SetXY( $r1 , $y1 );
			$this->Cell($length,4, $remarqu. $remarque);
		}
	function Footer()
	{ //Positionnement à 1,5 cm du bas
		$this->SetY(-15);
		$this->SetFont('Arial','B',10);
		$this->Cell(0,0,'',0,0,'L');
		//Police Arial italique 8
		$this->SetFillColor(200,220,255);
		$this->SetFont('Arial','I',8);	
		//Numéro et nombre de pages
		if(isset($_SESSION['nomHotel'])&& isset($_SESSION['footer1']))
			$this->Cell(-200,10,'('.$_SESSION['nomHotel'].')'.$_SESSION['footer1'] ,0,0,'C');
		if(isset($_SESSION['footer2']))
			$this->Cell(0,18,$_SESSION['footer2'],0,0,'C');
		$this->Cell(0,25,'REPUBLIQUE DU BENIN                                                                                                                 ',0,0,'R');

//$this->addRemarque(" Signature",$_SESSION['chiffre_en_lettre']);

//$this->addCadreEurosFrancs("Détails de la facture",$_SESSION['montant'],$_SESSION['avanceA'],$_SESSION['montant']- $_SESSION['avanceA']);


    $this->SetTextColor(128);
    // Numéro de page
    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
	
	}
	
	// Chargement des données
function LoadData($file)
{
    // Lecture des lignes du fichier
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Tableau coloré
function FancyTable($header, $data)
{
    // Couleurs, épaisseur du trait et police grasse
    $this->SetFillColor(193,229,252);
	 //$this->SetFillColor(255,0,0);
    //$this->SetTextColor(255);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    //$this->SetFont('arial','B',7);
    // En-tête
    $w = array(25,65,18,10,22,15,11,25);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);

    $this->Ln();
    // Restauration des couleurs et de la police
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Données
    $fill = false;
    foreach($data as $row)
    {   $this->SetFont('arial','',8);
        $this->Cell($w[0],6,substr($row[0],0,17),'LR',0,'C',$fill);
        $this->Cell($w[1],6,utf8_decode($row[1]),'LR',0,'C',$fill);
		$this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
        $this->Cell($w[3],6,number_format($row[3],0,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[4],6,number_format($row[4],4,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[5],6,number_format($row[5],4,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[6],6,number_format($row[6],0,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[7],6,number_format($row[7],0,',',' '),'LR',0,'C',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Trait de terminaison
    $this->Cell(array_sum($w),0,'','T');
}
}


$pdf = new PDF();
// Titres des colonnes
$header = array('N° Client', 'Nom & Prénoms', 'Chambre', 'Nuité', 'Montant HT','TVA','Taxe','Montant TTC');
// Chargement des données
$data = $pdf->LoadData('txt/facture.txt');
$pdf->AddPage();
$pdf->FancyTable($header,$data);

//$pdf->SetFont('Arial','B',10);
//$pdf->Cell(0,5,'Hello World !',1);

$val=$_SESSION['montant'];  $devise=isset($_GET['devise'])?$_GET['devise']:"Francs CFA"; if($devise=="F CFA") $devise="Francs CFA";

/* $tot_prods = array( array ( "px_unit" => 600, "qte" => 1, "tva" => 1 ),
                    array ( "px_unit" =>  10, "qte" => 1, "tva" => 1 ));
$tab_tva = array( "1"       => 19.6,
                  "2"       => 5.5);
$params1  = "Arrêté la présente facture à la somme de :";
$params2=chiffre_en_lettre($val, $devise1=$devise);
$pdf->addTVAs( $params1,$params2, $tab_tva, $tot_prods);  // les données des tableaux
$pdf->addCadreEurosFrancs('logo\signature.png','AKPOVO Jean de Dieu');  //Tableau 2 */




$pdf->Output();
//$req=mysql_query("DROP VIEW IF EXISTS view_temporaire");
//$_SESSION['avanceA']=0;
//$_SESSION['montant']=0;
$_SESSION['defalquer_impaye']=0;unset($_SESSION['date_emission']);
?>
