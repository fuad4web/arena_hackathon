    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
    <!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
    <!-- Warning Section Ends -->

    <!-- Required Jquery -->
    <!-- <script type="text/javascript" src="assets/js/jquery/jquery.min.js "></script> -->
    <script type="text/javascript" src="assets/js/jquery/jquery-3.6.0.min.js "></script>
    <script type="text/javascript" src="assets/js/bootstrap/js/bootstrap-bundle.min.js "></script>
    <!-- <script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script> -->
    <script type="text/javascript" src="assets/js/myscript.js"></script>

    <script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js "></script>
    <script>
        const COMPANY_VAT = <?= (float) $selectCompanyVat ?>;
        const COMPANY_EDIT = <?= json_encode($companyPriceEditability) ?>;
    </script>
    <script type="text/javascript" src="assets/js/order.js"></script>
    <script type="text/javascript" src="assets/js/datepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Toastr Notification -->
    <link rel="stylesheet" type="text/css" href="assets/toastr/toastr.min.js">
    <script type="text/javascript" src="assets/datatables/datatables.min.js"></script>

    <!-- waves js -->
    <script src="assets/pages/waves/js/waves.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Morris Chart js -->
    <script src="assets/js/raphael/raphael.min.js"></script>
    <script src="assets/js/morris.js/morris.js"></script>
    <!-- Custom js -->
    <script src="assets/pages/chart/morris/morris-custom-chart.js"></script>

    <!-- slimscroll js -->
    <script src="assets/js/jquery.mCustomScrollbar.concat.min.js "></script>

    <!-- notification js -->
    <script type="text/javascript" src="assets/js/bootstrap-growl.min.js"></script>
    <script type="text/javascript" src="assets/pages/notification/notification.js"></script>

    <!-- menu js -->
    <script src="assets/js/pcoded.min.js"></script>
    <script src="assets/js/vertical/vertical-layout.min.js "></script>

    <script type="text/javascript" src="assets/js/script.js "></script>

    <script type="text/javascript" src="assets/js/script-two.js"></script>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(function () {
          function togglePackSize() {
               const isPack = $('#is_pack').val() === '1';

               $('#pack_size').toggle(isPack);

               $('#pack_size_input')
                    .prop('required', isPack);

               if (!isPack) {
                    $('#pack_size_input').val('');
               }
          }

          $('#is_pack').on('change', togglePackSize);

          // Run on page load too
          togglePackSize();

        });
    </script>   
        
    <?php
        $noAvailProds = ($countAvailableProducts / $productsNumber) * 100 ?? 0;
        $noUnavailProds = ($countUnavailableProducts / $productsNumber) * 100 ?? 0;
    ?>

    <script>
        "use strict";
        setTimeout(function() {
            $(document).ready(function() {
                donutChart();

                $(window).on('resize', function() {
                    window.donutChart.redraw();
                });

            });

            function donutChart() {
                window.areaChart = Morris.Donut({
                    element: 'donut-example',
                    redraw: true,
                    data: [{
                            label: "Price of Available Produts <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>",
                            value: <?= $sumAvailableProducts ?>
                        },
                        {
                            label: "Price of Pending Produts <?= $getFromU->getCurrencySymbol($selectDefaultCurrency) ?>",
                            value: <?= $sumUnavailableProducts ?>
                        }
                    ],
                    colors: ['#FF9F55', '#448AFF']
                });
            }
        }, 350);


        $(document).ready(function() {

            $('#saveCustomer').on('click', function(e) {
                e.preventDefault();

                // Collect form data
                var name = $('#customerName').val();
                var phone_number = $('#customerPhone').val();
                var address = $('#customerAddress').val();

                // Ensure required fields are filled
                if (name === "" || phone_number === "") {
                    alert('Name and phone number are required.');
                    return;
                }

                $.ajax({
                    url: 'validation/save_customer.php', // The PHP file to handle saving the customer
                    type: 'POST',
                    data: {
                        name: name,
                        phone_number: phone_number,
                        address: address
                    },
                    success: function(response) {
                        // Parse the JSON response
                        var data = JSON.parse(response);

                        if (data.success) {
                            alert(data.message);
                            $('#exampleModal').modal('hide'); // Hide the modal
                            $('#customerForm')[0].reset(); // Reset the form fields
                        } else {
                            alert(data.message); // Show the error message
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    }
                });
            });
            

            // select 2 js for customer search
            // Initialize Select2 for customer selection
            $('.select2-customer').select2({
                placeholder: "Search by name or phone...",
                allowClear: true,
                width: '100%',
                theme: 'bootstrap4',
                ajax: {
                    url: 'validation/fetch_customers.php', // AJAX endpoint for live search
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term, // search term
                            branch_id: '<?= $branch_id ?? "" ?>' // pass branch ID
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.customers || []
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1 // Start searching after 1 character
            });
            
            // If you want to keep existing options AND allow search
            $('.select2-customer').select2({
                placeholder: "Search by name or phone...",
                allowClear: true,
                width: '100%',
                theme: 'bootstrap4'
            });
        });


        // save customer info
        $(document).ready(function() {
            // Clear form when modal is closed
            $('#exampleModal').on('hidden.bs.modal', function() {
                $('#customerForm')[0].reset();
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#errorAlert, #successAlert').addClass('d-none');
                $('#saveCustomerBtn').prop('disabled', false);
                $('#loadingSpinner').addClass('d-none');
                $('#btnText').text('Save Customer');
            });
            
            // Clear validation on input
            $('input, select').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('');
            });
            
            // Form submission
            $('#customerForm').submit(function(e) {
                e.preventDefault();
                
                // Clear previous errors
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#errorAlert, #successAlert').addClass('d-none');
                
                // Show loading
                $('#saveCustomerBtn').prop('disabled', true);
                $('#loadingSpinner').removeClass('d-none');
                $('#btnText').text('Saving...');
                
                // Get form data
                var formData = $(this).serialize();
                
                // Add AJAX call
                $.ajax({
                    url: 'validation/save_customer.php', // Create separate AJAX file
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Success
                            $('#successMessage').text(response.message);
                            $('#successAlert').removeClass('d-none');
                            
                            // If you want to add the new customer to Select2 dropdown
                            if (typeof updateCustomerDropdown === 'function') {
                                updateCustomerDropdown(response.customer);
                            }
                            
                            // Clear form after 1.5 seconds and close modal after 2 seconds
                            setTimeout(function() {
                                $('#customerForm')[0].reset();
                                setTimeout(function() {
                                    $('#exampleModal').modal('hide');
                                }, 500);
                            }, 1500);
                            
                        } else {
                            // Error
                            $('#errorMessage').text(response.message);
                            $('#errorAlert').removeClass('d-none');
                            
                            // Field-specific errors
                            if (response.errors) {
                                $.each(response.errors, function(field, message) {
                                    $('#' + field).addClass('is-invalid');
                                    $('#' + field + 'Error').text(message);
                                });
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#errorMessage').text('An error occurred. Please try again.');
                        $('#errorAlert').removeClass('d-none');
                        console.error('AJAX Error:', error);
                    },
                    complete: function() {
                        // Reset button state
                        $('#saveCustomerBtn').prop('disabled', false);
                        $('#loadingSpinner').addClass('d-none');
                        $('#btnText').text('Save Customer');
                    }
                });
            });
            
            // Function to update customer dropdown (if using Select2)
            window.updateCustomerDropdown = function(customer) {
                // If using Select2
                if ($('#customer_phone').hasClass('select2-hidden-accessible')) {
                    var newOption = new Option(
                        customer.name + (customer.phone ? ' (' + customer.phone + ')' : ''),
                        customer.phone || customer.id,
                        false,
                        false
                    );
                    $('#customer_phone').append(newOption).trigger('change');
                    $('#customer_phone').val(customer.phone || customer.id).trigger('change');
                } 
                // If using datalist
                else if ($('#customerOptions').length) {
                    var newOption = $('<option>').val(customer.name);
                    $('#customerOptions').append(newOption);
                }
            };
        });
    </script>
    
    <script>
        // Pack size toggle functionality
        document.getElementById('is_pack').addEventListener('change', function() {
            const packSizeDiv = document.getElementById('pack_size');
            const packSizeInput = document.getElementById('pack_size_input');
            
            if (this.value === '1') {
                packSizeDiv.style.display = 'block';
                packSizeInput.required = true;
            } else {
                packSizeDiv.style.display = 'none';
                packSizeInput.required = false;
                packSizeInput.value = '';
            }
        });

        // Enhanced file upload functionality
        const fileUploadInput = document.getElementById('product_pics');
        const fileUploadArea = document.querySelector('.file-upload-area');
        const filePreview = document.getElementById('file-preview');
        const previewImage = document.getElementById('preview-image');
        const fileName = document.getElementById('file-name');
        const fileBrowseBtn = document.querySelector('.file-browse-btn');

        // Click browse button to trigger file input
        fileBrowseBtn.addEventListener('click', function() {
            fileUploadInput.click();
        });

        // File input change event
        fileUploadInput.addEventListener('change', function(e) {
            handleFiles(this.files);
        });

        // Drag and drop functionality
        fileUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        fileUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        fileUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            const files = e.dataTransfer.files;
            fileUploadInput.files = files;
            handleFiles(files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                
                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('Please select an image file (JPG, PNG, GIF)');
                    return;
                }
                
                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB');
                    return;
                }
                
                // Display file name
                fileName.textContent = file.name;
                
                // Display image preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    filePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
                
                // Hide upload text
                document.querySelector('.file-upload-text').style.display = 'none';
            }
        }

        // Click on upload area to trigger file input
        fileUploadArea.addEventListener('click', function() {
            fileUploadInput.click();
        });

        const isPackSelect = document.getElementById('is_pack');
        const packSizeDiv = document.getElementById('pack_size');
        
        // Set initial state
        if (isPackSelect.value === '1') {
            packSizeDiv.style.display = 'block';
        } else {
            packSizeDiv.style.display = 'none';
        }
    </script>

    
    <script>
        // Quantity validation
        document.getElementById('transferQuantity').addEventListener('input', function() {
            const quantity = parseInt(this.value);
            const maxQuantity = 50; // You can set this based on selected product
            
            if (quantity < 1) {
                this.setCustomValidity('Quantity must be at least 1');
            } else if (quantity > maxQuantity) {
                this.setCustomValidity(`Quantity cannot exceed ${maxQuantity}`);
            } else {
                this.setCustomValidity('');
            }
        });

        // Form submission enhancement
        document.querySelector('form').addEventListener('submit', function(e) {
            const selectedProduct = document.querySelector('.product-card.selected');
            const quantity = document.getElementById('transferQuantity').value;
            const destinationBranch = document.querySelector('select[name="destination_branch_id"]').value;
            
            if (!selectedProduct) {
                e.preventDefault();
                alert('Please select a product to transfer');
                return;
            }
            
            if (!quantity || quantity < 1) {
                e.preventDefault();
                alert('Please enter a valid quantity');
                return;
            }
            
            if (!destinationBranch) {
                e.preventDefault();
                alert('Please select a destination branch');
                return;
            }
            
            // Add loading state to button
            const submitBtn = document.querySelector('.btn-transfer-product');
            submitBtn.innerHTML = '<div class="loading-spinner"></div> Processing Transfer...';
            submitBtn.disabled = true;
        });
    </script>

    <script>
        $(document).ready(function() {
            function reload() {
                window.location.reload();
            }

            $('#my_table').DataTable();

            $('#payment_mode').on('change', function () {
                if ($(this).val() === 'creditor') {
                    $('.col-md-3.hidden').removeClass('hidden');
                } else {
                    $('.col-md-3').has('#jkashuias').addClass('hidden');
                }
            });
        });
    </script>
    </body>

    </html>

    <?php
        if (isset($_SESSION['status']) || isset($_SESSION['code'])):
            ?>
                <script>
                    $(document).ready(function() {
                        function notify(message, type) {
                            $.growl({
                                message: message,
                                url: ''
                            }, {
                                element: 'body',
                                type: type,
                                allow_dismiss: true,
                                label: 'Cancel',
                                className: 'btn-xs btn-inverse',
                                placement: {
                                    from: 'top',
                                    align: 'right'
                                },
                                spacing: 10,
                                z_index: 999999,
                                delay: 3000,
                                timer: 3000,
                                mouse_over: false,
                                animate: {
                                    enter: 'animated flipInX',
                                    exit: 'animated flipOutX'
                                },
                                offset: {
                                    x: 30,
                                    y: 30
                                }
                            });
                        };

                        notify('<?= $_SESSION['status'] ?>', '<?= $_SESSION['code'] ?>');
                    });
                </script>

            <?php
                unset($_SESSION['status']);
                unset($_SESSION['code']);
        endif;
    ?>
    