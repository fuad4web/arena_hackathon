<?php
include 'core/init.php';

if ($getFromU->loggedIn() !== true) {
     echo '<script>window.location.replace("' . BASE_URL . 'validation/logout");</script>';
}

$user_id = $_SESSION['id'];
$user = $getFromU->userData($user_id);
include 'elements/functions.php';

if (!isset($_GET['code'])) {
     echo '<script>window.location.replace("' . BASE_URL . 'validation/logout");</script>';
} else {
    $code = $_GET['code'];
    $swap = $getFromU->select_all_val_row('swaps', 'trans_code', $code);
    $customerInfo = !empty($swap?->customer_id) ? $getFromU->select_all_val_row('customers', 'id', $swap?->customer_id) : "";
    $selectCompanyInfo = $getFromU->select_all_val_row_no_cond('company_settings');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Swap Receipt - <?= $code ?></title>
     
     <style>
          /* PRINT-SPECIFIC STYLES */
          @media print {
               /* Hide everything except receipt */
               body * { visibility: hidden !important; }
               
               #printReceipt, #printReceipt * { visibility: visible !important; }
               
               #printReceipt { position: absolute !important; left: 0 !important; top: 0 !important; width: 100% !important; max-width: 280px !important; margin: 0 !important; padding: 0 !important; }
               
               /* Remove print buttons */
               .print-btn, .back-btn { display: none !important; }
               
               /* Prevent page breaks */
               .receipt-product { page-break-inside: avoid !important; }
               
               /* Ensure no extra white space */
               body { margin: 0 !important; padding: 0 !important; }
               
               /* Force printer to use thermal paper settings */
               @page { margin: 0 !important; padding: 0 !important; size: auto !important; }
          }
          
          /* RECEIPT STYLING - Optimized for POS printers */
          body { font-family: "Courier New", Courier, monospace !important; background: white !important; margin: 0 !important; padding: 10px !important; }
          
          #printReceipt { width: 280px !important; max-width: 280px !important; margin: 0 auto !important; padding: 5px !important; background: white !important; font-size: 12px !important; line-height: 1.2 !important; color: #000000 !important; /* Pure black for best contrast */ font-weight: normal !important; -webkit-print-color-adjust: exact !important; /* For Chrome/Safari */ print-color-adjust: exact !important; /* Standard property */ text-shadow: none !important; -webkit-text-stroke: 0.2px !important; /* Improves text sharpness */ }
          
          /* Header styling */
          #printReceipt .header { text-align: center !important; margin-bottom: 8px !important; border-bottom: 2px solid #000 !important; padding-bottom: 5px !important; }
          
          #printReceipt .header h5 { font-size: 16px !important; font-weight: 900 !important; /* Extra bold for thermal printers */ margin: 3px 0 !important; text-transform: uppercase !important; letter-spacing: 0.5px !important; }
          
          #printReceipt .header p { font-size: 10px !important; font-weight: 700 !important; /* Bold for better visibility */ margin: 2px 0 !important; }
          
          /* Company info */
          .company-info { text-align: center !important; font-size: 10px !important; font-weight: 700 !important; /* Bold for better visibility */ margin-bottom: 5px !important; border-bottom: 1px dashed #000 !important; padding-bottom: 5px !important; }
          
          .company-info span { display: block !important; line-height: 1.3 !important; }
          
          /* Receipt divider */
          .receipt-divider { text-align: center !important; margin: 5px 0 !important; font-size: 10px !important; letter-spacing: 3px !important; }
          
          /* Transaction info */
          .transaction-info { font-size: 10px !important; font-weight: 700 !important; /* Bold for better visibility */ margin-bottom: 8px !important; padding-bottom: 5px !important; border-bottom: 1px dashed #000 !important; }
          
          .transaction-info span { display: block !important; line-height: 1.4 !important; }
          
          /* Product items */
          .receipt-product { margin: 5px 0 !important; padding-bottom: 4px !important; border-bottom: 1px dotted #555 !important; /* Darker for better visibility */ }
          
          .receipt-product .product-name { font-weight: 800 !important; /* Extra bold */ font-size: 12px !important; display: block !important; text-transform: uppercase !important; letter-spacing: 0.3px !important; margin-bottom: 2px !important; }
          
          .product-details { display: flex !important; justify-content: space-between !important; font-size: 11px !important; font-weight: 700 !important; /* Bold for better visibility */ }
          
          .product-details .qty-price { font-weight: 800 !important; /* Extra bold for numbers */ }
          
          .product-details .total { font-weight: 900 !important; /* Extra bold for totals */ }
          
          /* Totals section */
          .totals-section { margin-top: 10px !important; border-top: 2px solid #000 !important; padding-top: 8px !important; }
          
          .total-row { display: flex !important; justify-content: space-between !important; margin: 3px 0 !important; font-size: 12px !important; }
          
          .total-label { font-weight: 800 !important; /* Extra bold for labels */ text-transform: uppercase !important; letter-spacing: 0.3px !important; }
          
          .total-value { font-weight: 900 !important; /* Extra bold for values */ }
          
          /* Payment section */
          .payment-section { background: #000000 !important; /* Pure black for thermal printers */ color: #FFFFFF !important; /* Pure white for contrast */ margin: 8px 0 !important; padding: 5px !important; font-weight: 900 !important; /* Extra bold */ font-size: 12px !important; text-transform: uppercase !important; letter-spacing: 0.5px !important; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
          
          .payment-row { display: flex !important; justify-content: space-between !important; margin: 3px 0 !important; }
          
          /* Footer */
          .receipt-footer { text-align: center !important; margin-top: 10px !important; padding-top: 8px !important; border-top: 2px solid #000 !important; font-size: 10px !important; font-weight: 800 !important; /* Extra bold */ text-transform: uppercase !important; }
          
          .receipt-footer span { display: block !important; margin: 3px 0 !important; letter-spacing: 0.5px !important; }
          
          /* Receipt number */
          .receipt-number { text-align: center !important; font-size: 10px !important; font-weight: 900 !important; /* Extra bold */ margin-top: 5px !important; padding-top: 5px !important; border-top: 1px dashed #000 !important; }

          #printReceipt .additional_info { font-size: 8px; text-align: center; }
          
          /* Button styles (hidden when printing) */
          .print-btn, .back-btn { display: block !important; width: 280px !important; margin: 10px auto !important; padding: 10px !important; font-size: 14px !important; text-align: center !important; cursor: pointer !important; }
          
          .print-btn { background: #dc3545 !important; color: white !important; border: none !important; }
          
          .back-btn { background: #198754 !important; color: white !important; border: none !important; }
     </style>
</head>

<body>
     <!-- RECEIPT CONTENT -->
     <div id="printReceipt">
          <div class="header">
               <h5><?= htmlspecialchars($selectCompanyInfo->name) ?></h5>
               <p><?= htmlspecialchars($selectCompanyInfo->address) ?></p>
          </div>
          
          <div class="company-info">
               <span>Email: <?= htmlspecialchars($selectCompanyInfo->email) ?></span>
               <span>Phone: <?= htmlspecialchars($selectCompanyInfo->phone_no) ?></span>
          </div>
          
          <div class="receipt-divider">•••••••••••••••••••••••</div>
          
         <div class="transaction-info">
               <span>Date: <?= date('d/m/Y H:i:s', strtotime($swap?->created_at)) ?></span>
               <span>Receipt #: <?= $code ?></span>
               <span>Cashier: <?= htmlspecialchars($user?->name ?? 'System') ?></span>
               <span>Customer Name: <?= htmlspecialchars($customerInfo?->name ?? 'Walk-in Customer') ?></span>
               <span>Customer Phone Number: <?= htmlspecialchars($customerInfo?->phone_number ?? 'N/A') ?></span>
          </div>
          
          <div class="receipt-divider">–––––––––––––––––––––––</div>
          
          <!-- Products -->
          <div class="products-list">
               <div class="receipt-product">
                    <span class="product-name"><?= strtoupper(htmlspecialchars($swap?->brought_product_name)) ?></span>
                    <div class="product-details">
                        <span class="qty-price">
                            <?= $swap?->brought_quantity ?> x <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= number_format($swap?->brought_unit_value, 2) ?>
                        </span>
                        <span class="total">
                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= number_format(($swap?->brought_unit_value * $swap?->brought_quantity), 2) ?>
                        </span>
                    </div>
                    <span class="product-name"><?= strtoupper(htmlspecialchars($swap?->wanted_product_name)) ?></span>
                    <div class="product-details">
                        <span class="qty-price">
                            <?= $swap?->wanted_quantity ?> x <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= number_format($swap?->wanted_unit_value, 2) ?>
                        </span>
                        <span class="total">
                            <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= number_format(($swap?->wanted_unit_value * $swap?->wanted_quantity), 2) ?>
                        </span>
                    </div>
                </div>
          </div>
          
          <div class="receipt-divider">–––––––––––––––––––––––</div>
          
          <!-- Totals -->
          <div class="totals-section">
               <div class="total-row">
                    <span class="total-label">Cash customer added (shown on receipt):</span>
                    <span class="total-value"><?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?><?= number_format($swap?->cash_added, 2) ?></span>
               </div>
          </div>

        <?php if(!empty($swap?->additional_info)): ?>
            <div class="additional_info">
                <div><strong>Notes:</strong> <?= nl2br(htmlspecialchars($swap?->additional_info)) ?></div>
            </div>
        <?php endif; ?>
          
          <!-- Footer -->
          <div class="receipt-footer">
               <span><?= $selectCompanyReceiptFooter ?? 'Thank You For Shopping With Us. No Returns Without Original Receipt.' ?></span>
          </div>
          
          <div class="receipt-number">
               Receipt No: <?= $code ?>
          </div>
          
          <!-- Blank space for cutting -->
          <div style="height: 20px; border-top: 1px dashed #000; margin-top: 10px;"></div>
     </div>
     
     <!-- Buttons (Hidden when printing) -->
     <button class="print-btn" onclick="printReceipt()">🖨️ Print Receipt</button>
     <button class="back-btn" onclick="window.history.back()">⬅ Back to Orders</button>
     
     <script>
          // Optimized print function
          function printReceipt() {
               // Hide buttons before printing
               document.querySelectorAll('.print-btn, .back-btn').forEach(btn => {
                    btn.style.display = 'none';
               });
               
               // Set print-specific styles
               const style = document.createElement('style');
               style.innerHTML = `
                    @page {
                         margin: 0 !important;
                         padding: 0 !important;
                         size: auto !important;
                    }
                    body {
                         margin: 0 !important;
                         padding: 0 !important;
                    }
                    #printReceipt {
                         margin: 0 !important;
                         padding: 0 !important;
                    }
               `;
               document.head.appendChild(style);
               
               // Trigger print
               window.print();
               
               // Restore buttons after printing (with delay)
               setTimeout(() => {
                    document.querySelectorAll('.print-btn, .back-btn').forEach(btn => {
                         btn.style.display = 'block';
                    });
               }, 500);
          }
          
          // Auto-print on page load (optional - uncomment if needed)
          window.addEventListener('load', function() {
              setTimeout(printReceipt, 1000);
          });
          
          // Prevent browser print dialog buttons from appearing
          window.onbeforeprint = function() {
               document.querySelectorAll('.print-btn, .back-btn').forEach(btn => {
                    btn.style.visibility = 'hidden';
               });
          };
          
          window.onafterprint = function() {
               document.querySelectorAll('.print-btn, .back-btn').forEach(btn => {
                    btn.style.visibility = 'visible';
               });
          };
     </script>
</body>
</html>
