<?php 
    // core/Classes/PdfService.php
    
    namespace Core\Classes;

    use Dompdf\Dompdf;
    use Dompdf\Options;
    use TCPDF as TCPDF;
    use PDO;

    require_once __DIR__ . '/../../vendor/autoload.php';

    class PdfService {
        protected $pdo;

        function __construct($pdo) {
            $this->pdo = $pdo;
        }
        
        
        public function generatePdf($html, $filename)
        {
            $pdf = new TCPDF();
            $pdf->AddPage();
            $pdf->writeHTML($html, true, false, true, false, '');

            // Save the PDF to a local path
            // $localPath = __DIR__ . '/../../recordpdfs/' . $filename;
            $pdf->Output($filename, 'D');

            return $filename;
        }



        public function generatePdfFromDatabase($first_table, $second_table, $first_value, $second_value, $filename) {
            $stmt = $this->pdo->prepare("SELECT * FROM `$first_table` AS a INNER JOIN `$second_table` AS b ON a.user_id = b.id WHERE a.created_at >= :firstCol AND a.created_at <= :secondCol");
            $stmt->bindParam(":firstCol", $first_value, PDO::PARAM_STR);
            $stmt->bindParam(":secondCol", $second_value, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            // Create HTML content for PDF
            $html = $this->generateHtmlFromData($data);
        
            // Generate and save PDF
            return $this->generatePdf($html, $filename);
        }
        
        
        private function generateHtmlFromData($data)
        {
            $html = '<center><table class="" cellpadding="2" cellspacing="2" style="text-align: center; border-collapse: collapse; border-color: #fff; background-color: #448AFF; color: #fff;" id="my_table" border="1">
                <tr>
                    <th>S/N</th>
                    <th>Receipt No.</th>
                    <th>Payment Mode</th>
                    <th>Total Cost</th>
                    <th>Staff Name</th>
                </tr>';
        
            $i = 0;
            foreach ($data as $record) {
                $i++;
        
                $html .= "<tr>
                    <th scope='row'>$i</th>
                    <td>{$record['trans_code']}</td>
                    <td>{$record['payment_mode']}</td>
                    <td>&#8358;" . number_format($record['grand_total'], 2, '.', ',') . "</td>
                    <td>{$record['fullname']}</td>
                </tr>";
            }
        
            $html .= '</table></center>';
            return $html;
        }
        
    }
?>
