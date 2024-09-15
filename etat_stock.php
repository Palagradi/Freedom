<?php
require('fpdf17/fpdf.php');
@include('connexion.php');
session_start();
class PDF extends FPDF
{   
	function Header()
	{    if($this->PageNo()==1)
	    {	//$this->temporaire( "Hotel Codiam" );
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
		$this->Ln(5);
		
				//Titre encadré
		$this->Cell(0,0,'LISTE DES DISPONIBILITES DES PRODUITS ',0,1,'C');
		//$this->Image('logo/codi.jpg',25,15,30,20);
		//$this->Image($_SESSION['logo'],25,15,30,20);
		//$this->SetFont('Arial','',10);
		//$this->Ln(5);

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
     $w = array(30,64,30,30,40);
	 //$w = array(25,52,58,10,22,22);
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
        $this->Cell($w[1],6,$row[1],'LR',0,'',$fill);
	//$this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
        $this->Cell($w[2],6,number_format($row[2],0,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[3],6,number_format($row[3],0,',',' '),'LR',0,'C',$fill);
		$this->Cell($w[4],6,$row[4],'LR',0,'',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Trait de terminaison
    $this->Cell(array_sum($w),0,'','T');
}
}


$pdf = new PDF();
// Titres des colonnes
$header = array('Référence', 'Désignation', 'Seuil', 'Qté en stock','Observations');
// Chargement des données
$data = $pdf->LoadData('txt/etat_stock.txt');
$pdf->AddPage();
$pdf->FancyTable($header,$data);

$pdf->Output();

?>
