<?php
require('fpdf17/fpdf.php');
@include('connexion.php');
session_start();
class PDF extends FPDF
{   
	function Header()
	{    if($this->PageNo()==1)
	    {	if($_GET['d']==1) $this->temporaire( "Duplicata" );
		global $mydate;
		//$this->Ln('4');
		$this->SetFont('Arial','B',14);
		//Titre encadré
		$this->SetTextColor(100,150,255);
		//$sDateReturn=substr(date("Y-m-d")).'-'.substr(date("Y-m-d")).'-'.substr(date("Y-m-d"));
		$this->Cell(0,0,'ARCHEVECHE DE COTONOU',0,1,'');   
		//$this->Ln('0');
		$this->SetFont('Arial','I',10);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'                            
		                                                                                                                                  Cotonou le, '.substr(date("Y-m-d"),8,2).'/'.substr(date("Y-m-d"),5,2).'/'.substr(date("Y-m-d"),0,4),0,1,'');
		$this->Ln('4');
		$this->SetFont('Arial','B',13);
		$this->SetTextColor(100,150,255);
		//Titre encadré
		$this->Cell(0,60,'              CODIAM',0,1,'');
		
		//$this->Ln('4');
		$this->SetFont('Arial','B',13);
		$this->SetTextColor(115,8,0);
		

										
		//Titre encadré
		$this->Cell(0,0,"Reçu N°: ".$_SESSION['initial_fiche'],0,1,'C');
		$this->Image('logo/codi.jpg',25,15,30,20);
		$this->SetFont('Arial','',10);
		
		$this->SetTextColor(0,0,0);
		$this->fact_dev( "Détails du reçu ", "" );
		$this->addDate($_SESSION['avanceA']); 
		if($_SESSION['montant']<$_SESSION['avanceA']) $_SESSION['montant']=$_SESSION['avanceA'] ;
		$this->addClient($_SESSION['montant']-$_SESSION['avanceA']);
		$this->addPageNumber($_SESSION['montant']);
		
		
		$this->SetTextColor(115,8,0);
		$this->addReglement($_SESSION['groupe1']);
		
		$this->addEcheance( "Hébergement");
		//$_SESSION['fin']="04-04-2014";
		$this->addNumTVA(  "Du"." ".$_SESSION['debut']." "."au"." ".$_SESSION['fin'] );
		$this->Ln('10');	
		}
		
	
		
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
		$this->Cell(0,10,'(CODIAM HOTEL SARL)_01 BP 429_TEL 21 30 37 27/21 15 37 81_N°RCCMRB/COT/13B 10160                                      ',0,0,'R');
		$this->Cell(0,18,'E-mail:codiamsa@gmail.compte Bancaire B.O.A N°09784420006_N° IFU:3201300800616                                              ',0,0,'R');
		$this->Cell(0,25,'REPUBLIQUE DU BENIN                                                                                                                 ',0,0,'R');
		// Ajoute une remarque (en bas, a gauche)
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
//$this->addRemarque("* Les montants du Détails de la facture correspondent tous à des montants dus à la date du jour",$_SESSION['chiffre_en_lettre']);

//$this->addCadreEurosFrancs("Détails de la facture",$_SESSION['montant'],$_SESSION['avanceA'],$_SESSION['montant']- $_SESSION['avanceA']);
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
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
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
    {   $this->SetFont('times','B',8);
        $this->Cell($w[0],6,$row[0],'LR',0,'C',$fill);
        $this->Cell($w[1],6,utf8_decode($row[1]),'LR',0,'C',$fill);
		$this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
        $this->Cell($w[3],6,number_format($row[3],0,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[4],6,number_format($row[4],4,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[5],6,number_format(-$row[5],4,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[6],6,number_format($row[6],0,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[7],6,number_format($row[7],4,',',' '),'LR',0,'C',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Trait de terminaison
    $this->Cell(array_sum($w),0,'','T');
}
}


$pdf = new PDF();
// Titres des colonnes
$header = array('N° Client', 'Nom & Prénoms', 'Chambre', 'Nuité', 'Montant HT','AIB','Taxe','Montant TTC');
// Chargement des données
$data = $pdf->LoadData('facture.txt');
$pdf->AddPage();
$pdf->FancyTable($header,$data);

$pdf->Output();
//$req=mysql_query("DROP VIEW IF EXISTS view_temporaire");
//$_SESSION['avanceA']=0;
//$_SESSION['montant']=0;
$_SESSION['defalquer_impaye']=0;
?>
