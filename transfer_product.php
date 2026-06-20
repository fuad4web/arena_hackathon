<?php
    include 'elements/header.php';
?>

    <style>
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px; }
        .product-card { border: 2px solid #e9ecef; border-radius: 12px; padding: 15px; cursor: pointer; transition: all 0.3s ease; background: white; position: relative; overflow: hidden; }
        .product-card:hover { border-color: #0d6efd; box-shadow: 0 5px 15px rgba(13, 110, 253, 0.1); transform: translateY(-2px); }
        .product-card.selected { border-color: #0d6efd; background-color: #f8f9ff; box-shadow: 0 5px 15px rgba(13, 110, 253, 0.15); }
        .product-card-content { display: flex; gap: 15px; }
        .product-image { width: 80px; height: 80px; border-radius: 8px; object-fit: cover; border: 1px solid #dee2e6; flex-shrink: 0; }
        .product-details { flex: 1; }
        .product-name { font-weight: 600; color: #212529; margin-bottom: 5px; font-size: 14px; line-height: 1.3; }
        .product-barcode { font-size: 12px; color: #6c757d; margin-bottom: 5px; font-family: monospace; background: #f8f9fa; padding: 2px 6px; border-radius: 4px; display: inline-block; }
        .product-price { font-size: 13px; color: #198754; font-weight: 500; margin-bottom: 3px; }
        .product-quantity { font-size: 13px; color: #0d6efd; font-weight: 500; background: #e7f1ff; padding: 2px 8px; border-radius: 12px; display: inline-block; }
        .product-checkbox { position: absolute; opacity: 0; pointer-events: none; }
        .checkmark { position: absolute; top: 10px; right: 10px; width: 20px; height: 20px; border: 2px solid #dee2e6; border-radius: 4px; background: white; transition: all 0.2s ease; }
        .product-card.selected .checkmark { background: #0d6efd; border-color: #0d6efd; }
        .product-card.selected .checkmark:after { content: '✓'; color: white; font-size: 12px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-weight: bold; }
        .no-products { text-align: center; padding: 40px 20px; color: #6c757d; background: #f8f9fa; border-radius: 8px; margin: 20px 0; }
        .no-products i { font-size: 48px; color: #dee2e6; margin-bottom: 15px; display: block; }
    </style>

    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">

            <?php
                include 'elements/sidebar.php';
            ?>

            <div class="pcoded-content">

                <!-- Breadcrumbs -->
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="page-header-title">
                                    <h5 class="m-b-10">Transfer Products</h5>
                                    <p class="m-b-0">Welcome to <?= $selectCompanyName ?></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard"> <i class="fa fa-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Transfer Product</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <?php
                                    echo SuccessMessage();
                                    echo ErrorMessage();
                                ?>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Transfer Product</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="form-container">
                                            <form class="form-material row g-4" method="POST" action="validation/transfer_product">
                                                <!-- Select Branch to Fetch Products -->
                                                <div class="col-md-6">
                                                    <div class="form-group form-default form-static-label enhanced-form-group">
                                                        <select name="source_branch_id" id="sourceBranch" class="form-control enhanced-select" required>
                                                            <option value="">Choose Source Branch</option>
                                                            <?php foreach ($selectBranches as $branch): ?>
                                                                <option value="<?= $branch->id ?>"><?= ucwords($branch->branch_name) ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <span class="form-bar"></span>
                                                        <label class="float-label">Source Branch</label>
                                                        <div class="form-icon">
                                                            <i class="fas fa-warehouse"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Products List -->
                                                <div class="col-12">
                                                    <div class="transfer-section">
                                                        <h5 class="section-title">
                                                            <i class="fas fa-boxes me-2"></i>Select Product to Transfer
                                                        </h5>
                                                        <div class="product-selection-area" id="productList">
                                                            <div class="empty-state">
                                                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                                                <p class="text-muted">Please select a source branch to view available products</p>
                                                            </div>
                                                            <!-- Products will be dynamically loaded here -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Transfer Details Section -->
                                                <div class="col-12 mt-5">
                                                    <div class="transfer-details-section">
                                                        <h5 class="section-title text-center">
                                                            <i class="fas fa-exchange-alt me-2"></i>&nbsp;Transfer Details
                                                        </h5>
                                                        <div class="row g-4">
                                                            <!-- Transfer Quantity -->
                                                            <div class="col-md-6">
                                                                <div class="form-group form-default form-static-label enhanced-form-group">
                                                                    <input type="number" name="quantity" id="transferQuantity" class="form-control enhanced-input" placeholder="Enter quantity to transfer" required min="1">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Transfer Quantity</label>
                                                                    <div class="form-icon">
                                                                        <i class="fas fa-sort-amount-up"></i>
                                                                    </div>
                                                                    <div class="form-help">
                                                                        <small class="text-muted">Enter the quantity you want to transfer</small>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Destination Branch -->
                                                            <div class="col-md-6">
                                                                <div class="form-group form-default form-static-label enhanced-form-group">
                                                                    <select name="destination_branch_id" class="form-control enhanced-select" required>
                                                                        <option value="">Choose Destination Branch</option>
                                                                        <?php foreach ($selectBranches as $branch): ?>
                                                                            <option value="<?= $branch->id ?>"><?= ucwords($branch->branch_name) ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Destination Branch</label>
                                                                    <div class="form-icon">
                                                                        <i class="fas fa-truck-loading"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Submit Button -->
                                                <div class="col-12">
                                                    <div class="form-submit-section">
                                                        <button type="submit" name="transfer" class="btn btn-primary btn-transfer-product">
                                                            <i class="fas fa-exchange-alt me-2"></i>Transfer Product
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>

<?php
    include 'elements/footer.php';
?>

<script>
    // alert("sdjkgkasdu");
    // Fetch products for the selected branch
    document.getElementById('sourceBranch').addEventListener('change', function() {
        const branchId = this.value;
        if (branchId) {
            fetch(`validation/fetch_products.php?branch_id=${branchId}`)
                .then(response => response.json())
                .then(data => {
                    let productList = '';
                    if (data.length > 0) {
                        productList += `
                            <div class="row" id="productGridContainer">
                        `;
                        
                        data.forEach(product => {
                            // Use product.image or product.product_pics or default image
                            const productImage = product.image || product.product_pics || 'https://via.placeholder.com/80?text=No+Image';
                            
                            productList += `
                                <div class="product-card col-md-3" data-product-code="${product.code}">
                                    <input class="form-check-input product-checkbox" type="radio" name="product_code" value="${product.code}" id="product_${product.code}" required>
                                    <div class="checkmark"></div>
                                    <div class="product-card-content">
                                        <img src="${productImage}" alt="${product.name}" class="product-image" onerror="this.src='https://via.placeholder.com/80?text=No+Image'">
                                        <div class="product-details">
                                            <div class="product-name">${product.name}</div>
                                            <div class="product-barcode">Barcode: ${product.barcode || 'N/A'}</div>
                                            <div class="product-price">Price: ₦${parseFloat(product.price).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                                            <div class="product-quantity">Qty: ${parseFloat(product.quantity).toLocaleString()} available</div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        
                        productList += `</div>`;
                        
                        // Add event listeners for card clicks
                        setTimeout(() => {
                            const productCards = document.querySelectorAll('.product-card');
                            productCards.forEach(card => {
                                card.addEventListener('click', function() {
                                    // Remove selected class from all cards
                                    productCards.forEach(c => c.classList.remove('selected'));
                                    
                                    // Add selected class to clicked card
                                    this.classList.add('selected');
                                    
                                    // Get the checkbox inside this card
                                    const checkbox = this.querySelector('.product-checkbox');
                                    if (checkbox) {
                                        checkbox.checked = true;
                                        
                                        // Trigger change event on checkbox
                                        checkbox.dispatchEvent(new Event('change', { bubbles: true }));
                                    }
                                });
                            });
                        }, 100);
                        
                    } else {
                        productList = `
                            <div class="no-products">
                                <i class="fas fa-box-open"></i>
                                <p class="text-danger mb-0">No products found for this branch.</p>
                                <p class="text-muted small mt-2">Select a different branch or add products first.</p>
                            </div>
                        `;
                    }
                    document.getElementById('productList').innerHTML = productList;
                })
                .catch(error => {
                    console.error('Error fetching products:', error);
                    document.getElementById('productList').innerHTML = `
                        <div class="no-products">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p class="text-danger mb-0">Error loading products. Please try again.</p>
                        </div>
                    `;
                });
        } else {
            document.getElementById('productList').innerHTML = '';
        }
    });
    
    // <div class="form-check">
    //     <input class="form-check-input" type="radio" name="product_code" value="${product.code}" required>
    //     <label class="form-check-label">
    //         ${product.name} (Available: ${product.quantity})
    //     </label>
    // </div>
    
    // <div class="product-card col-md-3" data-product-id="${product.id}">
    //     <div class="product-radio"></div>
    //     <div class="product-card-header">
    //         <img src="${product.image}" alt="${product.name}" class="product-image" onerror="this.src='./assets/images/default-product.jpg'">
    //         <div class="product-info">
    //             <div class="product-name">${product.name}</div>
    //             <div class="product-barcode">${product.barcode}</div>
    //         </div>
    //     </div>
    //     <div class="product-details">
    //         <div class="product-quantity">
    //             Available: <span class="quantity-badge">${product.quantity}</span>
    //         </div>
    //         <div class="product-price">$${product.price}</div>
    //     </div>
    // </div>
</script>
