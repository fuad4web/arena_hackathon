$(document).ready(function () {

     let order_products = [];
     let return_products = [];
     let customer_status = 'regular'; // Default customer status

     // Detect customer selection or sales selection and fetch their status
     $("#customer_phone").on("input change blur", function () {
          const selectedCustomer = $(this).val();
          // console.log('This is: ' + $('#sales_type').val());
          if (!selectedCustomer) return;
     
          $.ajax({
               url: "validation/customer_status.php", // Endpoint to fetch customer status
               method: "POST",
               data: { customer_name: selectedCustomer },
               success: function (response) {
                    customer_status = response; // Update the global customer status
               },
               error: function () {
                    Swal.fire({
                         icon: 'error',
                         title: 'Unable to fetch Customer',
                         text: 'Error fetching customer status.',
                         confirmButtonText: 'OK',
                         confirmButtonColor: '#fd0d55ff',
                         backdrop: true,
                         allowOutsideClick: false
                    });
                    // alert("Error fetching customer status");
               }
          });
     });

     // Sync sales_type select with customer_status
     $("#sales_type").on("change", function () {
          customer_status = $(this).val(); // Update customer_status based on sales type selection
          $("input[name='sales_type']").val($(this).val()); // Set input value to selected option
     });



     $("#first_date").datepicker({
          format: 'yyyy-mm-dd'
     });
     $("#second_date").datepicker({
          format: 'yyyy-mm-dd'
     });

     $('#selectRecords').click(function () {
          var first_value = $("#first_date").val();
          var second_value = $("#second_date").val();
          $.ajax({
               url: "validation/product_record",
               method: "POST",
               data: {
                    first_value: first_value,
                    second_value: second_value
               },
               success: function (data) {
                    $('#mypurrecords').html(data);
               }
          });
     });


     // global: let order_products = order_products || [];
     // --- Add product (scan/search) (unchanged except parseFloat usage for quantity)
     $('#submit_barcode').click(function () {
          var valuess = $("#product_barcode").val();
          if (!valuess) return;

          $.ajax({
               url: "validation/barcode.php",
               method: "POST",
               dataType: "json",
               data: { valuess: valuess },
               success: function (data) {
                    const d = data[0];
                    if (!d) return;

                    // price selection based on customer_status
                    let packPrice = d.price;
                    switch (customer_status?.trim().toLowerCase()) {
                         case 'regular': packPrice = d.price; break;
                         case 'special': packPrice = d.special_price ?? d.price; break;
                         case 'market':  packPrice = d.market_price ?? d.price; break;
                         default: packPrice = d.price; break;
                    }

                    const isPack = (d.is_pack == 1 || d.is_pack === true);
                    const packSizeFromServer = parseInt(d.pack_size) || (isPack ? 1 : 1);

                    // derived single price if not provided
                    const singlePrice = parseFloat(d.single_price ?? (isPack ? (packPrice / packSizeFromServer) : packPrice));

                    // IMPORTANT: use parseFloat for quantity (DB might contain fractional pack count)
                    const dbQuantityFloat = parseFloat(d.quantity) || 0.0;
                    // available base units (bottles) = dbQuantityFloat * packSize (or 1)
                    const availableBaseUnits = dbQuantityFloat * (isPack ? packSizeFromServer : 1);

                    order_products.push({
                         id: d.id,
                         name: d.name,
                         code: d.code,
                         product_pics: d.product_pics,
                         is_pack: isPack ? 1 : 0,
                         pack_size: packSizeFromServer,
                         pack_price: parseFloat(packPrice),
                         single_price: parseFloat(singlePrice),
                         // For pack products we keep both quantities:
                         pack_qty: isPack ? 1 : 0,
                         bottle_qty: isPack ? 0 : 1,
                         // max in base units (float)
                         max_base: availableBaseUnits,
                         // compute total price:
                         total_price: isPack ? parseFloat(packPrice * 1 + singlePrice * 0) : parseFloat(singlePrice * 1)
                    });

                    display_products(order_products);
               },
               error: function (err) {
                    console.error(err);
                    alert('Error fetching product — check console.');
               }
          });
     });


     // Render order table
     function display_products(order_products) {
          let order_products_string = '';
          let count = 1;

          order_products.forEach(d => {
               // get active pack price according to customer_status
               let packPrice = d.pack_price ?? d.price;
               switch (customer_status?.trim().toLowerCase()) {
                    case 'regular': packPrice = d.pack_price ?? d.price; break;
                    case 'special': packPrice = d.special_price ?? d.pack_price ?? d.price; break;
                    case 'market':  packPrice = d.market_price ?? d.pack_price ?? d.price; break;
                    default: packPrice = d.pack_price ?? d.price; break;
               }
               const singlePrice = d.single_price ?? (d.pack_size ? (packPrice / d.pack_size) : packPrice);

               // compute current totals
               const totalPackBase = (parseInt(d.pack_qty) || 0) * (d.pack_size || 1);
               const totalBottleBase = (parseInt(d.bottle_qty) || 0);
               const baseCount = totalPackBase + totalBottleBase;
               const unitPriceToShow = (d.is_pack ? packPrice : singlePrice);

               order_products_string += `
                    <tr data-id="${d.id}" class="product-row">
                         <th scope='row' class="serial-number">${count++}</th>
                         <td class="product-image-cell">
                              <div class="product-image-wrapper">
                                   <img src="${d.product_pics}" alt="${d.name}" class="product-thumbnail" onerror="this.src='https://via.placeholder.com/40?text=Product'">
                              </div>
                         </td>
                         <td class="product-name-cell">
                              <div class="product-name-wrapper">
                                   <input class="form-control product-name-input" type="text" value="${d.name}" readonly>
                                   <input type="hidden" name="ids[]" value="${d.id}">
                                   <small class="product-code">Product Code: |${d.code}|</small>
                              </div>
                         </td>
                         <td class="price-cell">
                              <div class="price-wrapper">
                                   <input class="form-control price price-input" type="number" value="${(d.is_pack ? packPrice : singlePrice).toFixed(2)}" ${COMPANY_EDIT === 'uneditable' ? 'readonly' : ''}>
                                   <div class="price-badge">
                                        <span class="currency-symbol">₦</span>
                                   </div>
                              </div>
                         </td>
                         <td class="quantity-cell" style="min-width:360px;">
                              <div class="quantity-controls-wrapper">
                                   ${ d.is_pack ? `
                                   <div class="pack-quantity-controls">
                                        <div class="quantity-group pack-qty-group">
                                        <label class="quantity-label">Pack Quantity</label>
                                        <div class="input-with-buttons">
                                             <button class="quantity-btn decrease-btn pack-decrease" data-id="${d.id}">−</button>
                                             <input class="form-control pack-qty pack-input" data-id="${d.id}" type="number" min="0" value="${d.pack_qty}">
                                             <button class="quantity-btn increase-btn pack-increase" data-id="${d.id}">+</button>
                                        </div>
                                        </div>
                                        
                                        <div class="quantity-group bottle-qty-group">
                                        <label class="quantity-label">Bottles from Packs</label>
                                        <div class="input-with-buttons">
                                             <button class="quantity-btn decrease-btn bottle-decrease" data-id="${d.id}">−</button>
                                             <input class="form-control bottle-qty bottle-input" data-id="${d.id}" type="number" min="0" value="${d.bottle_qty}">
                                             <button class="quantity-btn increase-btn bottle-increase" data-id="${d.id}">+</button>
                                        </div>
                                        </div>
                                        
                                        <div class="quantity-group pack-size-group">
                                        <label class="quantity-label">Pack Size</label>
                                        <div class="pack-size-display">
                                             <input class="form-control pack-size pack-size-input" readonly data-id="${d.id}" type="number" min="1" value="${d.pack_size}">
                                             <span class="unit-text">units</span>
                                        </div>
                                        </div>
                                   </div>
                                   ` : `
                                   <div class="single-quantity-controls">
                                        <div class="quantity-group">
                                        <label class="quantity-label">Quantity</label>
                                        <div class="input-with-buttons">
                                             <button class="quantity-btn decrease-btn single-decrease" data-id="${d.id}">−</button>
                                             <input class="form-control single-qty single-input" data-id="${d.id}" type="number" min="1" value="${d.bottle_qty}">
                                             <button class="quantity-btn increase-btn single-increase" data-id="${d.id}">+</button>
                                        </div> 
                                        </div>
                                   </div>
                                   `}
                                   <div class="base-count-display">
                                        <span class="base-count-badge">${baseCount} base units</span>
                                   </div>
                              </div>
                              <input type="hidden" name="pack_size[]" value="${d.pack_size}">
                         </td>
                         <td class="total-price-cell">
                              <div class="total-price-wrapper">
                                   <input class="form-control total_price total-price-input" name="total_price[]" type="number" id="total_price" value="${parseFloat(d.total_price).toFixed(2)}" ${COMPANY_EDIT === 'uneditable' ? 'readonly' : ''}>
                                   <div class="total-price-badge">
                                        <span class="total-text">₦</span>
                                   </div>
                              </div>
                         </td>
                         <td class="action-cell">
                              <div class="action-wrapper">
                                   <button type="button" class="btn-remove-item" data-id="${d.id}" aria-label="Remove item">
                                        <i class="fas fa-trash-alt remove-icon"></i>
                                        <span class="remove-text">Remove</span>
                                   </button>
                              </div>
                         </td>
                    </tr>
               `;

               // Add this CSS to your stylesheet
               const styles = `
               <style>
               .product-row { background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%); border: 1px solid #e3e6f0; border-radius: 12px; margin: 8px 0; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 2px 4px rgba(0,0,0,0.04); }
               
               .product-row:hover { background: linear-gradient(135deg, #ffffff 0%, #f0f4ff 100%); border-color: #4dabf7; box-shadow: 0 8px 25px rgba(77, 171, 247, 0.15); transform: translateY(-2px); }
               
               /* Table Cell Styling */
               .product-row td, .product-row th { vertical-align: middle; padding: 16px 12px !important; border: none !important; }
               
               /* Serial Number */
               .serial-number { font-weight: 600; color: #4dabf7; font-size: 14px; text-align: center; background: #e7f3ff; border-radius: 8px; min-width: 50px; padding: 8px !important; }
               
               .product-image-cell { width: 80px; }
               
               .product-image-wrapper { width: 56px; height: 56px; border-radius: 12px; overflow: hidden; border: 3px solid #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); margin: 0 auto; transition: all 0.3s ease; }
               
               .product-row:hover .product-image-wrapper { transform: scale(1.05); box-shadow: 0 6px 20px rgba(77, 171, 247, 0.2); }
               
               .product-thumbnail { width: 100%; height: 100%; object-fit: cover; display: block; }
               
               /* Product Name */
               .product-name-cell { min-width: 200px; }
               
               .product-name-wrapper { position: relative; }
               
               .product-name-input { border: 2px solid #e9ecef; border-radius: 10px; padding: 10px 15px; font-weight: 600; color: #2d3748; background: white; transition: all 0.3s ease; font-size: 14px; }
               
               .product-name-input:focus { border-color: #4dabf7; box-shadow: 0 0 0 3px rgba(77, 171, 247, 0.1); }
               
               .product-code { display: block; font-size: 11px; color: #718096; margin-top: 4px; padding-left: 2px; font-family: 'Monaco', 'Menlo', monospace; }
               
               .price-cell { width: 120px; }
               
               .price-wrapper { position: relative; }
               
               .price-input { border: 2px solid #e9ecef; width: 150px; border-radius: 10px; padding: 10px 15px 10px 40px; font-weight: 600; color: #2b6cb0; background: white; text-align: right; font-size: 14px; }
               
               .price-badge { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); background: #2b6cb0; color: white; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600; }
               
               .currency-symbol { font-family: Arial, sans-serif; }
               
               /* Quantity Cell */
               .quantity-cell { min-width: 400px; }
               
               .quantity-controls-wrapper { padding: 8px; }
               
               .pack-quantity-controls, .single-quantity-controls { display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap; }
               
               .quantity-group { flex: 1; min-width: 140px; }
               
               .quantity-label { display: block; font-size: 11px; color: #718096; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
               
               .input-with-buttons { display: flex; gap: 4px; align-items: center; }
               
               .quantity-btn { width: 32px; height: 32px; border: 2px solid #e2e8f0; background: white; border-radius: 8px; color: #4a5568; font-size: 18px; font-weight: bold; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; user-select: none; }
               
               .quantity-btn:hover:not(:disabled) { background: #4dabf7; border-color: #4dabf7; color: white; transform: scale(1.05); }
               
               .quantity-btn:active:not(:disabled) { transform: scale(0.95); }
               
               .quantity-btn:disabled { opacity: 0.5; cursor: not-allowed; }
               
               .pack-input, .bottle-input, .single-input, .pack-size-input { border: 2px solid #e2e8f0; border-radius: 8px; padding: 6px 12px; text-align: center; font-weight: 600; color: #2d3748; background: white; flex: 1; max-width: 70px; font-size: 14px; height: 32px; }
               
               .pack-input:focus, .bottle-input:focus, .single-input:focus { border-color: #4dabf7; box-shadow: 0 0 0 3px rgba(77, 171, 247, 0.1); outline: none; }
               
               .pack-size-group { min-width: 120px; }
               
               .pack-size-display { display: flex; align-items: center; gap: 8px; }
               
               .pack-size-input { background: #f7fafc; color: #718096; border-color: #cbd5e0; }
               
               .unit-text { font-size: 12px; color: #718096; font-weight: 500; }
               
               .base-count-display { margin-top: 8px; padding-top: 8px; border-top: 1px dashed #e2e8f0; }
               
               .base-count-badge { display: inline-block; background: #e6fffa; color: #234e52; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
               
               .total-price-cell { width: 140px; }
               
               .total-price-wrapper { position: relative; }
               
               .total-price-input { border: 2px solid #48bb78; border-radius: 10px; padding: 10px 15px 10px 50px; font-weight: 700; width: 150px; color: #276749; background: #f0fff4; text-align: right; font-size: 14px; }
               
               .total-price-badge { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); background: linear-gradient(135deg, #48bb78, #38a169); color: white; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
               
               /* Action Cell */
               .action-cell { width: 100px; }
               
               .action-wrapper { display: flex; justify-content: center; }
               
               .btn-remove-item { background: linear-gradient(135deg, #fed7d7, #fc8181); border: none; border-radius: 10px; padding: 10px 16px; color: #c53030; font-weight: 600; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(254, 215, 215, 0.3); }
               
               .btn-remove-item:hover { background: linear-gradient(135deg, #feb2b2, #f56565); color: white; transform: translateY(-2px); box-shadow: 0 6px 12px rgba(245, 101, 101, 0.2); }
               
               .btn-remove-item:active { transform: translateY(0); }
               
               .remove-icon { font-size: 16px; }
               
               .remove-text { white-space: nowrap; }
               
               /* Responsive adjustments */
               @media (max-width: 1200px) { .pack-quantity-controls, .single-quantity-controls {     flex-direction: column;     align-items: stretch; } .quantity-group {     min-width: 100%; } }
               
               /* Animations */
               @keyframes slideIn { from {     opacity: 0;     transform: translateX(-20px); } to {     opacity: 1;     transform: translateX(0); } }
               
               .product-row { animation: slideIn 0.3s ease-out; }
               </style>
               `;

               // Add the styles to the document head
               document.head.insertAdjacentHTML('beforeend', styles);
               // order_products_string += `
               // <tr data-id="${d.id}">
               //      <th scope='row'>${count++}</th>
               //      <td><img src="${d.product_pics}" width="40" height="40" style="border-radius:50%" alt="${d.name}"></td>
               //      <td>
               //           <input class="form-control" type="text" value="${d.name}" readonly>
               //           <input type="hidden" name="ids[]" value="${d.id}">
               //      </td>

               //      <td>
               //           <input class="form-control price" type="number" value="${(d.is_pack ? packPrice : singlePrice).toFixed(2)}" readonly>
               //      </td>

               //      <td style="min-width:360px;">
               //           <div class="d-flex align-items-center">
               //                ${ d.is_pack ? `
               //                <div style="margin-right:8px;">
               //                     <label style="font-size:11px">Pack qty</label>
               //                     <input class="form-control pack-qty" data-id="${d.id}" type="number" min="0" value="${d.pack_qty}" style="width:95px;">
               //                </div>
               //                <div style="margin-right:8px;">
               //                     <label style="font-size:11px">Bottles from packs</label>
               //                     <input class="form-control bottle-qty" data-id="${d.id}" type="number" min="0" value="${d.bottle_qty}" style="width:110px;">
               //                </div>
               //                <div style="margin-right:8px;">
               //                     <label style="font-size:11px">Pack size</label>
               //                     <input class="form-control pack-size" readonly data-id="${d.id}" type="number" min="1" value="${d.pack_size}" style="width:95px;">
               //                </div>
               //                ` : `
               //                <div style="margin-right:8px;">
               //                     <label style="font-size:11px">Qty</label>
               //                     <input class="form-control single-qty" data-id="${d.id}" type="number" min="1" value="${d.bottle_qty}" style="width:95px;">
               //                </div>
               //                `}
               //                <div style="padding-left:8px;">
               //                <small class="text-muted">(${baseCount} base)</small>
               //                </div>
               //           </div>

               //           <input type="hidden" name="pack_size[]" value="${d.pack_size}">
               //      </td>

               //      <td>
               //           <input class="form-control total_price" name="total_price[]" type="number" value="${parseFloat(d.total_price).toFixed(2)}" readonly>
               //      </td>

               //      <td>
               //           <i class="fa fa-trash fa-2x close-card" data-id="${d.id}" style="cursor:pointer"></i>
               //      </td>
               // </tr>
               // `;
          });

          $('#product_sales').html(order_products_string);
          // $("#product_barcode").val('');
          $('#product_barcode').val('').focus();

          // recalc grand
          let sumTotal_price = 0;
          order_products.forEach(o => sumTotal_price += parseFloat(o.total_price || 0));

          const vatAmount = sumTotal_price * (COMPANY_VAT/100);
          const grandTotalWithVat = sumTotal_price + vatAmount;
          
          $('#vat_amount').text(vatAmount.toFixed(2));
          $('#product_subtotal').text(sumTotal_price.toFixed(2));
          $('#grand-total-display').text(grandTotalWithVat.toFixed(2));
          $('#grand_total_price').val(sumTotal_price.toFixed(2));
     }

     // Handle edits: pack_qty / bottle_qty / pack_size / single-qty
     // Event handler for quantity changes
     $("#product_sales").on("input change", ".pack-qty, .bottle-qty, .pack-size, .single-qty", function () {
          updateProductQuantity($(this));
     });

     // Event handler for button clicks
     $("#product_sales").on("click", ".single-decrease, .single-increase, .pack-decrease, .pack-increase, .bottle-decrease, .bottle-increase", function (e) {
          e.preventDefault();
          handleQuantityButtonClick($(this));
     });

     // Event handler for price input changes (when price editing is enabled)
     $("#product_sales").on("input change", ".price-input", function () {
          const id = $(this).closest('tr').data('id');
          const newPrice = parseFloat($(this).val()) || 0;
          
          // Find and update the product in order_products array
          const product = order_products.find(p => p.id == id);
          if (product) {
               product.pack_price = newPrice;
               // If this is a pack product, recalculate single_price
               if (product.is_pack && product.pack_size > 0) {
                    product.single_price = newPrice / product.pack_size;
               } else {
                    product.single_price = newPrice;
               }
               // Recalculate total price
               updateProductQuantity($(this));
          }
     });

     // Function to handle button clicks
     function handleQuantityButtonClick($button) {
          const id = $button.data('id');
          const row = $(`tr[data-id="${id}"]`);
          let input;
          let currentValue;
          
          if ($button.hasClass('single-decrease')) {
               input = row.find('.single-qty');
               currentValue = parseInt(input.val()) || 0;
               if (currentValue > 1) {
                    input.val(currentValue - 1).trigger('change');
               }
          } else if ($button.hasClass('single-increase')) {
               input = row.find('.single-qty');
               currentValue = parseInt(input.val()) || 0;
               input.val(currentValue + 1).trigger('change');
          } else if ($button.hasClass('pack-decrease')) {
               input = row.find('.pack-qty');
               currentValue = parseInt(input.val()) || 0;
               if (currentValue > 0) {
                    input.val(currentValue - 1).trigger('change');
               }
          } else if ($button.hasClass('pack-increase')) {
               input = row.find('.pack-qty');
               currentValue = parseInt(input.val()) || 0;
               input.val(currentValue + 1).trigger('change');
          } else if ($button.hasClass('bottle-decrease')) {
               input = row.find('.bottle-qty');
               currentValue = parseInt(input.val()) || 0;
               if (currentValue > 0) {
                    input.val(currentValue - 1).trigger('change');
               }
          } else if ($button.hasClass('bottle-increase')) {
               input = row.find('.bottle-qty');
               currentValue = parseInt(input.val()) || 0;
               input.val(currentValue + 1).trigger('change');
          }
     }

     // Function to update product quantity (your existing logic)
     function updateProductQuantity($input) {
          const id = $input.data('id');
          const row = $input.closest('tr');

          const prodIndex = order_products.findIndex(p => p.id == id);
          if (prodIndex < 0) return;
          const prod = order_products[prodIndex];

          // update pack_size if changed (keep as integer >=1)
          const packSizeInput = row.find('.pack-size');
          if (packSizeInput.length) {
               let newPackSize = parseInt(packSizeInput.val(), 10) || 1;
               if (newPackSize < 1) newPackSize = 1;
               prod.pack_size = newPackSize;
          }

          if (prod.is_pack) {
               // read pack and bottle fields
               let packQty = parseInt(row.find('.pack-qty').val(), 10) || 0;
               let bottleQty = parseInt(row.find('.bottle-qty').val(), 10) || 0;

               // enforce bottleQty <= pack_size
               if (bottleQty > prod.pack_size) {
                    bottleQty = prod.pack_size;
                    row.find('.bottle-qty').val(bottleQty);
                    Swal.fire({
                         icon: 'warning',
                         title: 'Packsize Exceeded',
                         text: 'Bottles taken from pack cannot exceed pack size (' + prod.pack_size + ').',
                         confirmButtonText: 'OK',
                         confirmButtonColor: '#0d6efd',
                         backdrop: true,
                         allowOutsideClick: false
                    });
                    // alert('Bottles taken from pack cannot exceed pack size (' + prod.pack_size + ').');
               }

               // Now compute base units for this line
               const baseSold = (packQty * prod.pack_size) + bottleQty;

               // maxBase is a FLOAT - total base units available
               const maxBase = parseFloat(prod.max_base || 0);

               if (baseSold > maxBase) {
                    // Compute the maximum packs and bottles allowed given maxBase
                    // Prefer keeping bottleQty as-is when possible, otherwise adjust.
                    const maxPacksIfNoBottles = Math.floor(maxBase / prod.pack_size);
                    const remainderIfMaxPacks = maxBase - (maxPacksIfNoBottles * prod.pack_size);

                    // If user wants some bottles, compute max packs that still allow requested bottles
                    let allowedPacksGivenBottles = Math.floor((maxBase - bottleQty) / prod.pack_size);
                    if (allowedPacksGivenBottles < 0) allowedPacksGivenBottles = 0;

                    // If allowed packs with requested bottles still insufficient, clamp bottleQty to remainder
                    if (allowedPacksGivenBottles < packQty) {
                         // try to reduce packs first to fit requested bottleQty
                         packQty = allowedPacksGivenBottles;
                         // If still not enough, clamp bottleQty
                         let newRemainder = Math.floor(maxBase - (packQty * prod.pack_size));
                         if (bottleQty > newRemainder) {
                              bottleQty = Math.max(0, newRemainder);
                         }
                    } else {
                         // packs were fine, but baseSold still > maxBase => clamp packQty
                         packQty = Math.floor(maxBase / prod.pack_size);
                         bottleQty = Math.max(0, Math.floor(maxBase - (packQty * prod.pack_size)));
                    }

                    // Ensure bottleQty <= pack_size
                    if (bottleQty > prod.pack_size) {
                         bottleQty = prod.pack_size;
                    }

                    row.find('.pack-qty').val(packQty);
                    row.find('.bottle-qty').val(bottleQty);
                    Swal.fire({
                         icon: 'warning',
                         title: 'Adjust Quantity',
                         text: 'Adjusted quantities to available stock',
                         confirmButtonText: 'OK',
                         confirmButtonColor: '#0d6efd',
                         backdrop: true,
                         allowOutsideClick: false
                    });
               }

               // Apply to prod
               prod.pack_qty = packQty;
               prod.bottle_qty = bottleQty;

               // recompute price
               let packPrice = prod.pack_price ?? prod.price;
               switch (customer_status?.trim().toLowerCase()) {
                    case 'special': packPrice = prod.special_price ?? packPrice; break;
                    case 'market': packPrice = prod.market_price ?? packPrice; break;
                    default: break;
               }
               const singlePrice = prod.single_price ?? (prod.pack_size ? (packPrice / prod.pack_size) : packPrice);
               prod.total_price = parseFloat((prod.pack_qty * packPrice) + (prod.bottle_qty * singlePrice));
          } else {
               // single product
               let singleQty = parseInt(row.find('.single-qty').val(), 10) || 1;
               const maxBaseSingle = parseFloat(prod.max_base || 0);

               // Remove alert for testing
               // alert(maxBaseSingle);
               
               if (singleQty > maxBaseSingle) {
                    singleQty = Math.floor(maxBaseSingle);
                    row.find('.single-qty').val(singleQty);
                    Swal.fire({
                         icon: 'warning',
                         title: 'Adjust Quantity',
                         text: 'Adjusted to available stock',
                         confirmButtonText: 'OK',
                         confirmButtonColor: '#0d6efd',
                         backdrop: true,
                         allowOutsideClick: false
                    });
               }

               prod.bottle_qty = singleQty;
               const singlePrice = prod.single_price ?? prod.price;
               prod.total_price = parseFloat(singleQty * singlePrice);
          }

          display_products(order_products);
     }


     // remove row
     $("#product_sales").on("click", ".btn-remove-item", function () {
          const id = $(this).data('id');
          order_products = order_products.filter(o => o.id != id);
          display_products(order_products);
     });

     // place order (AJAX)
     $("#savesjkbsd").click(function (e) {
          e.preventDefault();

          if (!$('#customer_phone').val() || $('#customer_phone').val() === '') {
               Swal.fire({
                    icon: 'warning',
                    title: 'Customer Required',
                    text: 'Select Customer returning orders.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0d6efd',
                    backdrop: true,
                    allowOutsideClick: false
               });
               return;
               // alert('Customer not Selected');
               // return;
          }

          let credit = $('#jkashuias').val();

          if ($('#payment_mode').val() == 'creditor' && ($('#jkashuias').val() < 0 || !$('#jkashuias').val())) {
               let credit = 0;
          }

          const payload = order_products.map(p => ({
               id: p.id,
               name: p.name,
               code: p.code,
               is_pack: p.is_pack ? 1 : 0,
               pack_size: p.pack_size || 1,
               pack_qty: parseInt(p.pack_qty || 0),
               bottle_qty: parseInt(p.bottle_qty || 0),
               pack_price: parseFloat(p.pack_price || 0),
               single_price: parseFloat(p.single_price || 0),
               total_price: parseFloat(p.total_price || 0)
          }));

          $.ajax({
               url: 'validation/purchase_product.php',
               method: 'post',
               dataType: 'json',
               data: {
                    type: 'place_order',
                    data: JSON.stringify(payload),
                    pro_purchase: true,
                    payment_mode: $('#payment_mode').val(),
                    customer_phone: $('#customer_phone').val(),
                    additional_info: $('#additional_info').val(),
                    sales_type: $("input[name='sales_type']").val(),
                    credit: credit
               },
               beforeSend: function () {
                    $('#savesjkbsd').attr('disabled', 'disabled').text('Please wait . . . ');
               },
               success: function (res) {
                    $('#savesjkbsd').attr('disabled', false).text('Purchase Product');
                    if (res.success) {
                         Swal.fire({
                              icon: 'success',
                              title: 'Purchase Successful',
                              text: res.message || 'Purchase successful',
                              confirmButtonText: 'OK',
                              confirmButtonColor: '#0d6efd',
                              backdrop: true,
                              allowOutsideClick: true
                         });
                         // alert(res.message || 'Purchase successful. Remaining stock: ' + (res.remaining_text || 'N/A'));
                         order_products = [];
                         display_products(order_products);
                         let basePath = window.location.pathname.split('/')[1];
                         if (basePath && basePath !== 'orders') window.location.href = '/' + basePath + '/orders';
                         else window.location.href = '/orders';
                    } else {
                         Swal.fire({
                              icon: 'warning',
                              title: res.message,
                              text: res.message,
                              confirmButtonText: 'OK',
                              confirmButtonColor: '#0d6efd',
                              backdrop: true,
                              allowOutsideClick: false
                         });
                         return;
                         // alert(res.message || 'An error occurred while placing order.');
                    }
               },
               error: function (err) {
                    console.error(err);
                    $('#savesjkbsd').attr('disabled', false).text('Purchase Product');
                    Swal.fire({
                         icon: 'warning',
                         title: 'Operation Failed',
                         text: 'Unable to perform operation.',
                         confirmButtonText: 'OK',
                         confirmButtonColor: '#0d6efd',
                         backdrop: true,
                         allowOutsideClick: false
                    });
                    return;
                    // alert('An error occurred. Check console for details.');
               }
          });
     });

     $("#returnProduct").click(function (e) {
          e.preventDefault();

          if (!$('#customer_phone').val() || $('#customer_phone').val() === '') {
               Swal.fire({
                    icon: 'warning',
                    title: 'Customer Required',
                    text: 'Select Customer returning Product.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0d6efd',
                    backdrop: true,
                    allowOutsideClick: false
               });
               return;
          }

          const payload = order_products.map(p => ({
               id: p.id,
               name: p.name,
               code: p.code,
               is_pack: p.is_pack ? 1 : 0,
               pack_size: p.pack_size || 1,
               pack_qty: parseInt(p.pack_qty || 0),
               bottle_qty: parseInt(p.bottle_qty || 0),
               pack_price: parseFloat(p.pack_price || 0),
               single_price: parseFloat(p.single_price || 0),
               total_price: parseFloat(p.total_price || 0)
          }));

          $.ajax({
               url: 'validation/returns_product.php',
               method: 'POST',
               dataType: 'json',
               data: {
                    type: 'return_product',
                    data: JSON.stringify(payload),
                    customer_phone: $('#customer_phone').val(),
                    sales_type: $("select[name='sales_type']").val(), // Changed from input to select
                    credit: $('#jkashuias').val()
               },
               beforeSend: function () {
                    $('#returnProduct').attr('disabled', 'disabled').text('Please wait . . . ');
               },
               success: function (res) {
                    $('#returnProduct').attr('disabled', false).text('Purchase Product');
                    if (res.success) {
                         Swal.fire({
                              icon: 'success',
                              title: 'Customer Required',
                              text: res.message || 'Purchase successful. Remaining stock: ' + (res.remaining_text || 'N/A'),
                              confirmButtonText: 'OK',
                              confirmButtonColor: '#0d6efd',
                              backdrop: true,
                              allowOutsideClick: false
                         });
                         // alert();
                         order_products = [];
                         display_products(order_products);
                         let basePath = window.location.pathname.split('/')[1];
                         if (basePath && basePath !== 'return_product') window.location.href = '/' + basePath + '/return_product';
                         else window.location.href = '/return_product';
                    } else {
                         alert(res.message || 'An error occurred while placing order.');
                    }
               },
               error: function (err) {
                    console.error(err);
                    $('#returnProduct').attr('disabled', false).text('Purchase Product');
                    Swal.fire({
                         icon: 'error',
                         title: 'Unable to return',
                         text: 'An Error Ocurred, check consol for more details',
                         confirmButtonText: 'OK',
                         confirmButtonColor: '#fd650dff',
                         backdrop: true,
                         allowOutsideClick: false
                    });
               }
          });
     });


     // $("#return_product").click(function (e) {
     //      e.preventDefault();
     //      // alert("Return Product");
     //      // exit();

     //      if (!$('#customer_phone').val() || $('#customer_phone').val() === '') {
     //           Swal.fire({
     //                icon: 'warning',
     //                title: 'Customer Required',
     //                text: 'Please select a customer before proceeding.',
     //                confirmButtonText: 'OK',
     //                confirmButtonColor: '#0d6efd',
     //                backdrop: true,
     //                allowOutsideClick: false
     //           });
     //           return;
     //      }

     //      const payload = return_products.map(p => ({
     //           id: p.id,
     //           name: p.name,
     //           code: p.code,
     //           is_pack: p.is_pack ? 1 : 0,
     //           pack_size: p.pack_size || 1,
     //           pack_qty: parseInt(p.pack_qty || 0),
     //           bottle_qty: parseInt(p.bottle_qty || 0),
     //           pack_price: parseFloat(p.pack_price || 0),
     //           single_price: parseFloat(p.single_price || 0),
     //           total_price: parseFloat(p.total_price || 0)
     //      }));

     //      $.ajax({
     //           url: 'validation/returns_product.php',
     //           method: 'post',
     //           dataType: 'json',
     //           data: {
     //                type: 'return_order',
     //                data: JSON.stringify(payload),
     //                return_product: true,
     //                reason: $('#reason').val(),
     //                customer_phone: $('#customer_phone').val(),
     //                sales_type: $("input[name='return_sales_type']").val()
     //           },
     //           beforeSend: function () {
     //                $('#return_product').attr('disabled', 'disabled').text('Please wait . . . ');
     //           },
     //           success: function (res) {
     //                $('#return_product').attr('disabled', false).text('Return Product');
     //                if (res.success) {
     //                     Swal.fire({
     //                          icon: 'success',
     //                          title: 'Order Successful',
     //                          text: res.message || 'Return successful. Remaining stock: ' + (res.remaining_text || 'N/A'),
     //                          confirmButtonText: 'OK',
     //                          confirmButtonColor: '#0dfd55ff',
     //                          backdrop: true,
     //                          allowOutsideClick: false
     //                     });
     //                     return;

     //                     return_products = [];
     //                     display_products(return_products);
     //                     let basePath = window.location.pathname.split('/')[1];
     //                     if (basePath && basePath !== 'return_product') window.location.href = '/' + basePath + '/return_product';
     //                     else window.location.href = '/return_product';
     //                } else {
     //                     Swal.fire({
     //                          icon: 'error',
     //                          title: 'Customer Required',
     //                          text: res.message || 'An error occurred while returning orders.',
     //                          confirmButtonText: 'OK',
     //                          confirmButtonColor: '#0d6efd',
     //                          backdrop: true,
     //                          allowOutsideClick: false
     //                     });
     //                     return;
     //                }
     //           },
     //           error: function (err) {
     //                console.error(err);
     //                $('#return_product').attr('disabled', false).text('Return Product');
     //                Swal.fire({
     //                     icon: 'error',
     //                     title: 'Error Ocurred',
     //                     text: 'An error occurred. Check console for details.',
     //                     confirmButtonText: 'OK',
     //                     confirmButtonColor: '#0d6efd',
     //                     backdrop: true,
     //                     allowOutsideClick: false
     //                });
     //                return;
     //                // alert();
     //           }
     //      });
     // });

});
