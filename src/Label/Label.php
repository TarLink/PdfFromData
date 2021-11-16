<?php

namespace Glfromd\Label;

use Fpdf\Fpdf;
use Glfromd\Model\Address;

class Label
{
    private Address $address;
    private $uid = '';

    public function __construct($address,$uid)
    {
        $this->address = $address;
        $this->uid = $uid;
    }

    /**
     * Output PDF.
     *
     * @return string
     */
    public function generate(): void
    {
        $pdf = new Fpdf();
        $pdf->AddPage();

        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(10,30,"Name: ");
        $pdf->Cell(20);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(10,30,"{$this->address->getFirstname()} {$this->address->getLastname()}",0,1);

        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(10,0,"Company: ");
        $pdf->Cell(20);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(10,0,"{$this->address->getCompanyName()}",0,1);

        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(10,30,"Address: ");
        $pdf->Cell(20);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(10,30,"{$this->address->getStreetAddress1()} ( {$this->address->getStreetAddress2()} ), ");
        $pdf->Ln(22);
        $pdf->Cell(30);
        $pdf->Cell(10,0,"{$this->address->getCity()}, {$this->address->getState()}, {$this->address->getCountry()},");
        $pdf->Ln(6);
        $pdf->Cell(30);
        $pdf->Cell(10,0,"zip {$this->address->getZip()}",0,1);

        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(10,30,"Phone: ");
        $pdf->Cell(20);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(10,30,"{$this->address->getPhone()}",0,1);

        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(10,0,"Email: ");
        $pdf->Cell(20);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(10,0,"{$this->address->getEmail()}",0,1);

        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(10,30,"UID: ");
        $pdf->Cell(20);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(10,30,"{$this->uid}",0,1);

        $pdf->Output();
    }
}
