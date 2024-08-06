<?php 



namespace App\Service;

    use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService {
    private $dompdf;
    public function __construct()
    {
        $this->dompdf = new DomPdf();
        $pdfOptions=new Options();
        $pdfOptions->set('defaultFont','Garamond');

        $this->dompdf->setOptions($pdfOptions);
        // $this->dompdf->set_option('isPhpEnabled', true);
        // $this->dompdf->set_option('isHtml5ParserEnabled', true);
        // $this->dompdf->set_option('isJavascriptEnabled', true);
        // $this->dompdf->set_option('isRemoteEnabled', true);
        // $this->dompdf->set_option('isHyphensEnabled', true);
        // $this->dompdf->set_option('isFontSubsettingEnabled', true);
        // $this->dompdf->set_option('isImageScaleEnabled', true);
        // $this->dompdf->set_option('isPdfaEnabled', true);
        // $this->dompdf->set_option('isAutoFontRotationEnabled', true);
        // $this->dompdf->set_option('isPrint
        
        
    }
        
    
    public function showPdfFile($html)
    {
        

        // instantiate and use the dompdf class
        $this->dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'landscape');
        // Render the HTML as PDF
        $this->dompdf->render();
        
        // Output the generated PDF to Browser
        $this->dompdf->stream("detail.pdf",[
            'Attachment' => false,
            'inline' => true,
            'isRemoteEnabled' => true,
            'isJavascriptEnabled' => true,
            'isFontSubsettingEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isAutoFontRotationEnabled' => true,
            'isImageScaleEnabled' => true,
            'isPdfaEnabled' => true,
            'isPrintEnabled' => true,
            'isUseCJKFont' => true,
            'isUseFontRefcheck' => true,
            'isUseReferrerPolicy' => true,
            'isUseStream' => true,
            'isUseTempFiles' => true,
            'isUseUnicode' => true,
            'isUseUstringBackend' => true,
            'isUseZlib' => true,
            'isViewerEnabled' => true,
        ]);
        
    }

    public function generateBinaryPDF($html){
        $this->dompdf->loadHtml($html);
        $this->dompdf->output();

    }

}


?>