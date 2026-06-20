<?php
include '../core/init.php';

$response = [
    'success' => false,
    'message' => '',
    'errors' => [],
    'customer' => null
];

// Only process AJAX requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

// Check required fields
if(!isset($_POST['name']) || !isset($_POST['phone_number'])) {
    $response['message'] = 'Please fill all required fields';
    
    if(empty($_POST['name'])) $response['errors']['customerName'] = 'Name is required';
    if(empty($_POST['phone_number'])) $response['errors']['customerPhone'] = 'Phone number is required';
//     if(empty($_POST['status'])) $response['errors']['customerStatus'] = 'Status is required';
    
    echo json_encode($response);
    exit;
}

// Get form data
$name = trim($_POST['name']);
$phone_number = trim($_POST['phone_number']);
$status = 'regular';
$address = trim($_POST['address'] ?? '');
$user_id = $_SESSION['id'] ?? null;
$currentSessionBranch = $_SESSION['branch_id'] ?? null;

// Validate inputs
if(empty($name)) {
    $response['errors']['customerName'] = 'Name is required';
}

if(empty($phone_number)) {
    $response['errors']['customerPhone'] = 'Phone number is required';
} elseif(!preg_match('/^[0-9]{10,15}$/', $phone_number)) {
    $response['errors']['customerPhone'] = 'Please enter a valid phone number';
}

if(empty($status)) {
    $response['errors']['customerStatus'] = 'Status is required';
}

// If validation errors, return them
if(!empty($response['errors'])) {
    $response['message'] = 'Please fix the errors below';
    echo json_encode($response);
    exit;
}

// Get branch ID
if($currentSessionBranch) {
    $branch_id = $currentSessionBranch;
} elseif($user_id) {
    $branch_id = $getFromU->select_one_val('user', 'branch_id', 'id', $user_id);
} else {
    $response['message'] = 'Branch information not found';
    echo json_encode($response);
    exit;
}

// Check if phone number already exists
if($getFromU->check_exist_two_col('customers', 'phone_number', 'phone_number', $phone_number, 'branch_id', $branch_id) === true) {
    $customerName = $getFromU->select_one_val('customers', 'name', 'phone_number', $phone_number);
    $response['message'] = ucwords($customerName) . ' is using this Phone number';
    $response['errors']['customerPhone'] = 'This phone number is already registered';
    echo json_encode($response);
    exit;
}

// Check if name already exists
// if($getFromU->check_exist_one_col('customers', 'name', $name) === true) {
//     $response['message'] = 'Customer name already exists';
//     $response['errors']['customerName'] = 'This name is already registered';
//     echo json_encode($response);
//     exit;
// }

// Prepare data for insertion
$customerData = [
    'branch_id' => $branch_id,
    'name' => $name,
    'phone_number' => $phone_number,
    'status' => $status,
    'address' => $address,
];
// exit(var_dump($customerData));

// Save to database
try {
    $saveCustomer = $getFromU->create('customers', $customerData);
    
    if($saveCustomer) {
        // Get the newly created customer
        $newCustomer = $getFromU->select_one_row('customers', 'phone_number', $phone_number);
        
        $response['success'] = true;
        $response['message'] = 'Customer saved successfully!';
        $response['customer'] = [
            'id' => $newCustomer->id ?? null,
            'name' => $name,
            'phone' => $phone_number,
            'status' => $status
        ];
        
        // Store in session for non-AJAX requests compatibility
        $_SESSION['status'] = "Customer saved Successfully";
        $_SESSION['code'] = "success";
    } else {
        $response['message'] = 'Failed to save customer. Please try again.';
    }
} catch(Exception $e) {
    $response['message'] = 'An error occurred: ' . $e->getMessage();
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
