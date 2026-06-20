<?php
require '../connect.php';
require '../functions.php';
#########
# Simple data vending...
#########
    					        
$getapp = $connect->dbrow("select * from appinfo");
$dapp = $getapp;
$blockedNo = $dapp["blockedNo"];
$allowNo = $dapp["allowNo"];
$data_restriction_volume = $dapp["data_restriction_volume"];
$blockedInfo = json_decode($dapp["blockedInfo"], true);
$orderstatus = $blockedInfo["order_status"];
$allowstatus = $blockedInfo["allow_status"];
$allowMembstatus = $blockedInfo["allowMemb_status"];

#$blockedNo = '07026392322,07065186886,09064215894,07040988509,07065186886,07030237966,09066552233,09033024846';
$suspectedNo = explode(",", $blockedNo);
$allowNo = explode(",", $allowNo);
$allowMemb = explode(",", $allowMemb);

if(isset($_REQUEST["username"]) && isset($_REQUEST["password"])) {
    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];
    $dataplan = $_REQUEST["dataplan"];
    $phone = $_REQUEST["phone"];
    
    $endpoint = 2;
    
    #search user...
    $queryMemb = $connect->dbrow("select * from members where phoneno='$username'");
    $allowCP = $queryMemb["allowCP"];
    
    $clientNumb = getReferral($username);
    
    $email = getemailfromphone($username);
    $userplan = getusrPlan($email);
    $userbal = getusrBal($email);
    $userid = getuseridfromemail($email);
    $mytime=date("D j F, Y; h:i a");
    $dataid = mt_rand(11111, 99090).mt_rand(11111, 99090).mt_rand(11111, 99090);
    
    //The URL that we want to send a PUT request to.
    $userInfo = userInfo($userid);
    $webhook = userInfo($userid)['webhook'];
    
    // Get plan info...
    $planInfo = getPlan($userplan);
    $switchPrice = $planInfo['switchPrice'];
    
    
   if(!empty($email)) {
       
        #search user...
        $srchUser = $connect->dbrow("select * from auth where email='$email'");
        #mobilenumber verification won't be done here,
        #validation holdsd in category...
        
        if(!password_verify($password, $srchUser["pword"])) {
            $resp["msg"] = "Invalid password supplied";
            $resp["status"] = "8";
        } else if(count(getproduct_byprodID($dataplan)) == 0) {
            $resp["msg"] = "Product code does not exist";
            $resp["status"] = "9";
        } else {
            if(isset($_REQUEST["dataplan"]) && isset($_REQUEST["phone"])) {
                $product_id = $dataplan;
                $pname = getproduct_byprodID($dataplan)["pname"];
                $category = getproduct_byprodID($dataplan)["category"];
                //info about the product...
                $productInfo = getproduct($pname);
                $memo = '';
                
                $purchaseLimit = datavolume_receivePhone($phone, "today_sme_gift");
                
                if($allowCP > 0) {
                    
                    $srchType = $connect->dbrow("select * from scptype where id='$allowCP'");
                    $typeName = $srchType["name"];
                    
                    //What's the cost price for the product this user is buying...
                    $srchCp = $connect->dbrow("select * from scp where type='$typeName' and prodID='".$productInfo["prodID"]."'");
                    $cost_price = $srchCp["cost_price"];
                    
                    if($cost_price <= 0) {
                        $cost_price = $productInfo["cost_price"];
                    } else { $cost_price = $srchCp["cost_price"]; }
                    
                } else {
                    $cost_price = $productInfo["cost_price"];
                }
                $commission = $productInfo["commission"];
                $endpoint = $productInfo["endpoint"];
                $dataRoute = $productInfo["dataRoute"];
                $fetchStatus = $productInfo["fetchStatus"];

                if($calcType == "Naira") {
                    $comm_amnt = $commission; 
                } else {
                    $comm_amnt = ($topay*$commission)/100;
                }
                
                if(in_array($username, $allowMemb)) { $status = $allowMembstatus; } else if(in_array($phone, $allowNo)) { $status = $allowstatus; } else if(in_array($phone, $suspectedNo)) { $status = $orderstatus; } else if(getAPI_fetchStatus("sme", "Data Bundle") > 0 && strpos(strtolower($pname), "sme") !== FALSE) { $status = getAPI_fetchStatus("sme", "Data Bundle"); } else if(getAPI_fetchStatus("gift", "Data Bundle") > 0 && strpos(strtolower($pname), "gift") !== FALSE) { $status = getAPI_fetchStatus("gift", "Data Bundle");  } else { $status = 0; }
                
                if($category == "Data Bundle") {
                    
                    if(strpos(strtolower($pname), "mtn")!== false) {
                        $networkName = "mtn";
                    } else if(strpos(strtolower($pname), "glo")!== false) {
                        $networkName = "glo";
                    } else if(strpos(strtolower($pname), "airtel")!== false) {
                        $networkName = "airtel";
                    } else if(strpos(strtolower($pname), "9mobile")!== false) {
                        $networkName = "9mobile";
                    } else { $networkName = ''; }
                    
                    $srch = $connect->dbrow("select * from products where pname='$pname' and planname='$userplan' and category='Data Bundle'");
                   
                    if(strpos(strtolower($pname), "direct")!== false) {
                        $dfee = $connect->dbrow("select * from directfee where pname='$pname'");
                        
                        // Which pricing table is active for this plan...
                        if($switchPrice == 1){
                            $topay = $dfee["amount"] - (($dfee["amount"]*$srch["percent"])/100);
                        } else if($switchPrice == 2){
                            $topay = $dfee["amount"] - (($dfee["amount"]*$srch["percent2"])/100);
                        } else if($switchPrice == 3){
                            $topay = $dfee["amount"] - (($dfee["amount"]*$srch["percent3"])/100);
                        }
                    } else {
                        
                        // Which pricing table is active for this plan...
                        
                        if($switchPrice == 1) {
                            $topay = $srch["price"];
                        } else if($switchPrice == 2) {
                            $topay = $srch["price2"];
                        } else if($switchPrice == 3) {
                            $topay = $srch["price3"];
                        }
                    }
                    
                    if(strlen($phone) > 11 || strlen($phone) < 11 || !is_numeric($phone)) {
                        $resp["msg"] = "Invalid mobile number";
                        $resp["status"] = "9999";
                    } 
                    // else if(!is_numeric($phone)) {
                    //     $resp["msg"] = "Invalid mobile number";
                    //     $resp["status"] = "9999";
                    // }
                    else if($topay == 0 || $topay < 0) {
                        $resp["msg"] = "Error: Contact admin, no valid price";
                        $resp["status"] = "9999";
                    } else if($topay > $userbal) {
                        $resp["msg"] = "Insufficient wallet balance";
                        $resp["status"] = "3";
                    } else if($srch["available"] == 0 OR $dataplan == "mtn3000sme" OR $dataplan == "mtngift3000") {
                        $resp["msg"] = "Failed: ". strtoupper($pname)." is not available at the moment. Please try again later";
                        $resp["status"] = "9999";
                    } else {
                        $type = "sme"; #direct , sme ....
                        $mobileno = $phone;
                
                        // Custom API Is enabled for this user....
                        if($userInfo['custom_api'] == 1) {
                            if ($networkName == "mtn") {
                                //Check custom_build_api table if to know the API enable for this user...
                                if(strpos(strtolower($pname), "direct")!== false) {
                                    $srchCustom = $connect->dbrow("SELECT * FROM `custom_build_api` where user_id = '$userid' and product_group ='MTN Direct'");
                                } elseif (strpos(strtolower($pname), "sme")!== false) {
                                    $srchCustom = $connect->dbrow("SELECT * FROM `custom_build_api` where user_id = '$userid' and product_group ='MTN SME'");
                                } elseif (strpos(strtolower($pname), "gift")!== false) {
                                    $srchCustom = $connect->dbrow("SELECT * FROM `custom_build_api` where user_id = '$userid' and product_group ='MTN Gifting'");
                                }
                                
                            } elseif ($networkName == "glo") {
                                $srchCustom = $connect->dbrow("SELECT * FROM `custom_build_api` where user_id = '$userid' and product_group ='GLO Data'");
                            } elseif ($networkName == "airtel") {
                                $srchCustom = $connect->dbrow("SELECT * FROM `custom_build_api` where user_id = '$userid' and product_group ='Airtel Data'");
                            } elseif ($networkName == "9mobile") {
                                $srchCustom = $connect->dbrow("SELECT * FROM `custom_build_api` where user_id = '$userid' and product_group ='9mobile Data'");
                            }
                            
                            // Which API is enabled for this user...
                            $apiID = isset($srchCustom)? $srchCustom['api_id']:getproductAPI($pname, "Data Bundle");

                            //Get API Info....
                            $api = getAPI($apiID);
                        } else {
                        
                            //Let's make a search for the api key...
                            $apiID = getproductAPI($pname, "Data Bundle");
                            $api = getAPI($apiID);
                            
                            if($dataRoute > 0 && !empty(getAPI($dataRoute))) { #dataRoute was set
                                $api = getAPI($dataRoute);
                            }
                        }
                        
                        //Get API Info....
                        $api = getAPI($apiID);

                        $vendorID = $api["api_vendor_id"];
                        $systemcode = $api["api_system_code"];
                        $vendorInfo = getVendor($vendorID);
                        $vendor_code = $vendorInfo["vendor_code"];
                            
                        if ($vendor_code == 'ipay' OR $vendor_code == 'ipaysme2' OR $vendor_code == 'ipaycg') {
                            $dRequest = $vendor_code; // we are using a single vendor class
                            $vendor_code = 'ipay';
                        }
                        
                        if(file_exists("../classes/class_".$vendor_code.".php")) {
                            require_once "../classes/class_".$vendor_code.".php";
                            $setter = new $vendor_code();
                            $isSent = false;
                            
                            if ($networkName == "mtn") {
                                //Check basket_user table if this user has bucket plan enabled...
                                if(strpos(strtolower($pname), "direct")!== false) {
                                    $srchBucket = $connect->dbrow("SELECT * FROM `basket_user` where userid = '$userid' and product_group ='MTN Direct'");
                                } elseif (strpos(strtolower($pname), "sme")!== false) {
                                    $srchBucket = $connect->dbrow("SELECT * FROM `basket_user` where userid = '$userid' and product_group ='MTN SME'");
                                } elseif (strpos(strtolower($pname), "gift")!== false) {
                                    $srchBucket = $connect->dbrow("SELECT * FROM `basket_user` where userid = '$userid' and product_group ='MTN Gifting'");
                                }
                                
                            } elseif ($networkName == "glo") {
                                $srchBucket = $connect->dbrow("SELECT * FROM `basket_user` where userid = '$userid' and product_group ='GLO Data'");
                            } elseif ($networkName == "airtel") {
                                $srchBucket = $connect->dbrow("SELECT * FROM `basket_user` where userid = '$userid' and product_group ='Airtel Data'");
                            } elseif ($networkName == "9mobile") {
                                $srchBucket = $connect->dbrow("SELECT * FROM `basket_user` where userid = '$userid' and product_group ='9mobile Data'");
                            }
                            
                            //Since all data are depending on this to form to a ussd code, then we have...
                            $dataRequest = dataRequest_prodID($product_id);
                            $realfee = $dataRequest["realFee"];
                            $pryFee = $dataRequest["pryFee"];
                            
                            if($vendor_code == "localairtime") {
                                if($systemcode == "data_home_endpoint" AND strpos(strtolower($pname), "gift") !== FALSE) {
                                    
    					            $ussd = $realfee.$mobileno.$pryFee;
    					            $status = 0;
                                    
                                } else if(strpos(strtolower($pname), "direct")!== false) {
                                    $ussd = $realfee.$mobileno.$pryFee;  $type = "direct";
                                } else if($networkName == "glo" || $networkName == "mtn") {
    					            $ussd = $realfee.$mobileno.$pryFee;
                                } else if($networkName == "9mobile" || $networkName == "airtel") {
    					            $ussd = $realfee.$mobileno.$pryFee;
					            }
					            
					            if($setter->postdata("data_bundle", $ussd)) {
                                    $isSent = true;
                                } else { $isSent = false; }
					            
                            } else if($vendor_code == "smeplug") {
                                    
                                //Let's generate ussd code...
                                $ussd = str_replace(" ", "", $realfee.$mobileno.$pryFee);
                                
                                $smeplugId = $dataRequest["sme_plug_id"];
                                
                                if(strpos(strtolower($pname), "direct")!== false) {
                                    $type = 'direct';
                                    $data = json_encode([ "network_id" => 1, "plan_id" => $smeplugId, "phone" => $mobileno]);
                                } else {
                                    $data = json_encode([ "network_id" => 1, "plan_id" => $smeplugId, "phone" => $mobileno]);
                                }
                                
                                if($purchaseLimit >= $data_restriction_volume) {
                                    $newStatus = 14; // Limit exceeded...
                                } else {
                                    $setter->postdata($data);
                                    $isSent = true;
                                }
                                
                            } else if($vendor_code == "bwsub" OR $vendor_code == "gwts" OR $vendor_code == "olanet" OR $vendor_code == "iyiinstant") { // they use same documentation
                                
                                $vendorCode = $dataRequest[strtolower($vendor_code)];
                                
                                if($networkName == 'mtn') {
                                    $data = json_encode([ "network" => 1, "plan" => $vendorCode, "mobile_number" => $mobileno, "Ported_number" => true ]);
                                }
                                else if($networkName == 'airtel') {
                                    $data = json_encode([ "network" => 4, "plan" => $vendorCode, "mobile_number" => $mobileno, "Ported_number" => true ]);
                                }
                                else if($networkName == 'glo') {
                                    $data = json_encode([ "network" => 2, "plan" => $vendorCode, "mobile_number" => $mobileno, "Ported_number" => true ]);
                                }
                                
                                if($purchaseLimit >= $data_restriction_volume) {
                                    $newStatus = 14; // Limit exceeded...
                                } else {
                                    $setter->postdata($data);
                                    $isSent = true;
                                }
                                
                                $memo = json_encode(["staff" => $api["api_name"], "timed" => date("D j F, Y; h:i a") ]);
                                
                            } else if($vendor_code == "mysimhosting") {
                                
                                $mysimhost = $dataRequest["mysimhost"];
                                
                                $data = json_encode([ "network" => 1, "plan" => $mysimhost, "number" => $mobileno, "senderID" => "131Connect" ]);
                                
                                if($purchaseLimit >= $data_restriction_volume) {
                                    $newStatus = 14; // Limit exceeded...
                                } else {
                                    $setter->postdata($data);
                                    $isSent = true;
                                }
                                
                            } else if($vendor_code == "simservers") {
                                $ussd = str_replace(" ", "", $realfee.$mobileno.$pryFee);
                                $simserver = $dataRequest["simserver"];
                                
                                $data = json_encode(["process" => "buy", "user_reference" => $dataid, "product_code" => $simserver, "recipient" => $mobileno]);
                                
                                if($purchaseLimit >= $data_restriction_volume) {
                                    $newStatus = 14; // Limit exceeded...
                                } else {
                                    $setter->postdata($data);
                                    $isSent = true;
                                }
                                
                            } else if($vendor_code == "ipay") {
                                $ussd = str_replace(" ", "", $realfee.$mobileno.$pryFee);
                                $ipay = $dataRequest[$dRequest];
                                
                                $data = json_encode([ "product_code" => $ipay, "phone" => $mobileno ]);
                                
                                if($purchaseLimit >= $data_restriction_volume) {
                                    $newStatus = 14; // Limit exceeded...
                                } else {
                                    $setter->postdata($data);
                                    $isSent = true;
                                    $status = 1;
                                }
                                
                            }  else if($vendor_code == "iyiinstantcron" OR $vendor_code == "yafunyafuncron" OR $vendor_code == "mysimhostingcron" OR $vendor_code == "simserverscron"
                                 OR $vendor_code == "smeplugcron" OR $vendor_code == "olanetcron" OR $vendor_code == "bwsubcron" OR $vendor_code == "gwtscron" OR $vendor_code == "ipaycron"
                                 OR $vendor_code == "ipaycgcron" OR $vendor_code == "ipaysme2cron"    
                            ) {
                               
                                if($purchaseLimit >= $data_restriction_volume) {
                                    $newStatus = 14; // Limit exceeded...
                                } else {
                                    $data = [];
                                    $setter->postdata($data);
                                    $isSent = true;
                                }
                                
                            }
                            
                            if(($vendor_code == "olanet" OR $vendor_code == "bwsub" OR $vendor_code == "gwts" OR $vendor_code == "simservers" OR $vendor_code == "iyiinstant") AND $isSent == true) {
                                $bfrAmnt = $userbal;
                                $aftAmnt = $userbal - $topay;
                                
                                $response = isset($_SESSION["response"]) ? $_SESSION["response"] : "Limit exceeded";
                                //Based on the response we put on SESSION, we check the response to determine if delivered or not...
                                $status = isset($newStatus) ? $newStatus : $status;
                                
                                if(updatebal($aftAmnt, $userid)) {
                                    if($srchBucket != NULL) {
                                        $insert_query = "insert into baskethistory ( userid, network, product, amount, phoneno, plan, status, timed, msg, dataid, category, wallet_balance, bfrAmnt, aftAmnt, cost_price, ussd, endpoint, sms, recip, dnd, electrictoken, waec, datapin, memo, rcvsent, rcvnsent, channel) values ('$userid', '".strtoupper($networkName)."', '$pname', '$topay', '$mobileno', '$userplan', '$status', '$mytime', '".addslashes($response)."', '$dataid', 'data', '$aftAmnt', '$bfrAmnt', '$aftAmnt', '$cost_price', '$ussd', '$endpoint', '', '', '', '', '', '', '$memo', '', '', 'API')";
                                    } else {
                                        $insert_query = "insert into mybuys ( userid, network, product, amount, phoneno, plan, status, timed, msg, dataid, category, wallet_balance, bfrAmnt, aftAmnt, cost_price, ussd, endpoint, sms, recip, dnd, electrictoken, waec, datapin, memo, rcvsent, rcvnsent, channel) values ('$userid', '".strtoupper($networkName)."', '$pname', '$topay', '$mobileno', '$userplan', '$status', '$mytime', '".addslashes($response)."', '$dataid', 'data', '$aftAmnt', '$bfrAmnt', '$aftAmnt', '$cost_price', '$ussd', '$endpoint', '', '', '', '', '', '', '$memo', '', '', 'API')";
                                    }
                                    
                                    $connect->dbcountchanges($insert_query);
                                
                                    $resp["msg"] = "Order successful";
                                    $resp["status"] = "1";
                                    $resp["orderid"] = $dataid;
                                    $resp["datasize"] = $pname;
                                    $resp["amount_charge"] = $topay;
                                    $resp["network"] = strtoupper($networkName);
                                    
                                }
                                
                            }
                            else if($vendor_code == "ipay" AND $isSent == true) {
                                $bfrAmnt = $userbal;
                                $aftAmnt = $userbal - $topay;
                                
                                $response = isset($_SESSION["response"]) ? $_SESSION["response"] : "Limit exceeded";
                                //Based on the response we put on SESSION, we check the response to determine if delivered or not...
                                $status = isset($newStatus) ? $newStatus : $status;
                                
                                if(updatebal($aftAmnt, $userid)) {
                                    if($srchBucket != NULL) {
                                        $insert_query = "insert into baskethistory ( userid, network, product, amount, phoneno, plan, status, timed, msg, dataid, category, wallet_balance, bfrAmnt, aftAmnt, cost_price, ussd, endpoint, sms, recip, dnd, electrictoken, waec, datapin, memo, rcvsent, rcvnsent, channel) values ('$userid', '".strtoupper($networkName)."', '$pname', '$topay', '$mobileno', '$userplan', '$status', '$mytime', '".addslashes($response)."', '$dataid', 'data', '$aftAmnt', '$bfrAmnt', '$aftAmnt', '$cost_price', '$ussd', '$endpoint', '', '', '', '', '', '', '$memo', '', '', 'API')";
                                    } else {
                                        $insert_query = "insert into mybuys ( userid, network, product, amount, phoneno, plan, status, timed, msg, dataid, category, wallet_balance, bfrAmnt, aftAmnt, cost_price, ussd, endpoint, sms, recip, dnd, electrictoken, waec, datapin, memo, rcvsent, rcvnsent, channel) values ('$userid', '".strtoupper($networkName)."', '$pname', '$topay', '$mobileno', '$userplan', '$status', '$mytime', '".addslashes($response)."', '$dataid', 'data', '$aftAmnt', '$bfrAmnt', '$aftAmnt', '$cost_price', '$ussd', '$endpoint', '', '', '', '', '', '', '$memo', '', '', 'API')";
                                    }
                                    
                                    $connect->dbcountchanges($insert_query);
                                
                                    $resp["msg"] = "Order successful";
                                    $resp["status"] = "1";
                                    $resp["orderid"] = $dataid;
                                    $resp["datasize"] = $pname;
                                    $resp["amount_charge"] = $topay;
                                    $resp["network"] = strtoupper($networkName);
                                    
                                }
                            }
                            else if($vendor_code == "smeplug") {
                                $bfrAmnt = $userbal;
                                $aftAmnt = $userbal - $topay;
                                
                                if(isset($newStatus) AND $newStatus != NULL) {
                                    $response = "Limit exceeded";
                                    $status = $newStatus;
                                } else {
                                    $response = $_SESSION["response"];
                                    //Based on the response we put on SESSION, we check the response to determine if delivered or not...
                                    $rsp = json_decode($response);
                                    if(strpos(strtolower($rsp->data->msg), "successful") !== FALSE || strpos(strtolower($rsp->data->msg), "gift")!== FALSE) {
                                        $status = 1;
                                    } else if(strpos(strtolower($rsp->msg), "not sending") !== FALSE || strpos(strtolower($rsp->msg), "not") !== FALSE || strpos(strtolower($rsp->msg), "invalid") !== FALSE) {
                                        $status = 4;
                                    } else {
                                        $status = '-2';
                                    }
                                }
                                
                                if(updatebal($aftAmnt, $userid)) {
                                    
                                    if($srchBucket != NULL) {
                                        $insert_query = "insert into baskethistory ( userid, network, product, amount, phoneno, plan, status, timed, msg, dataid, category, wallet_balance, bfrAmnt, aftAmnt, cost_price, ussd, endpoint, sms, recip, dnd, electrictoken, waec, datapin, memo, rcvsent, rcvnsent, channel) values ('$userid', '".strtoupper($networkName)."', '$pname', '$topay', '$mobileno', '$userplan', '$status', '$mytime', '".addslashes($response)."', '$dataid', 'data', '$aftAmnt', '$bfrAmnt', '$aftAmnt', '$cost_price', '$ussd', '$endpoint', '', '', '', '', '', '', '', '', '', 'API')";
                                    } else {
                                        $insert_query = "insert into mybuys ( userid, network, product, amount, phoneno, plan, status, timed, msg, dataid, category, wallet_balance, bfrAmnt, aftAmnt, cost_price, ussd, endpoint, sms, recip, dnd, electrictoken, waec, datapin, memo, rcvsent, rcvnsent, channel) values ('$userid', '".strtoupper($networkName)."', '$pname', '$topay', '$mobileno', '$userplan', '$status', '$mytime', '".addslashes($response)."', '$dataid', 'data', '$aftAmnt', '$bfrAmnt', '$aftAmnt', '$cost_price', '$ussd', '$endpoint', '', '', '', '', '', '', '', '', '', 'API')";
                                    }
                                    
                                    $connect->dbcountchanges($insert_query);
                                    
                                    if($status == 4) {
                                        $resps = json_encode([ "txref" => $dataid, "apprBy" => "System Refund" ]);
                                        $memo = json_encode(["staff" => $api["api_name"], "msg" => 'System Refund', "timed" => date("D j F, Y; h:i a") ]);
                                        $connect->dbcountchanges("insert into payn (email, telno, amount, bfrAmnt, aftAmnt, timed, status, memo, method, reference) values ('$email', '$username', '$topay', '$aftAmnt', '$bfrAmnt', '$mytime', '4', '$resps', '$pname', '')"); 
                                        $connect->dbcountchanges("INSERT INTO `mybuys`(`userid`, `network`, `amount`, `bfrAmnt`, `aftAmnt`, `phoneno`, `plan`, `status`, `timed`, `msg`, `product`, `category`, `dataid`, `sms`, `recip`, `dnd`, `wallet_balance`, `cost_price`, `electrictoken`, `ussd`, `waec`, `datapin`, `memo`, `rcvsent`, `rcvnsent`, channel) values ('$userid', '".strtoupper($networkName)."', '$topay', '$aftAmnt', '$bfrAmnt', '$mobileno', '$userplan', '-4', '$mytime', 'Order refund', '$pname', 'data', '$dataid', '', '', '', '$bfrAmnt', '$topay', '', '', '', '', '$memo', '', '', 'API')");
                                        
                                        updatebal($bfrAmnt, $userid);
                                        
                                    } else { #Success, no hassle
                                        if(!empty($clientNumb) && $comm_amnt > 0) {
                                            $orderInfo = $pname;
                                            $saveTrns = "insert into referral_transactions (referralNumb, clientNumb, orderInfo, amount, orderDate) values ('$username', '$clientNumb', '$orderInfo', '$comm_amnt', '$mytime')";
                                            #since transaction has been saved, then we need to update the referral wallet
                                            $connect->dbcountchanges($saveTrns);
                                        }
                                    }
                                }
                                
                                $resp["msg"] = "Order successful";
                                $resp["status"] = "1";
                                $resp["orderid"] = $dataid;
                                $resp["datasize"] = $pname;
                                $resp["amount_charge"] = $topay;
                                $resp["network"] = strtoupper($networkName);
                                
                            } else if(getAPI_fetchStatus("gift", "Data Bundle") > 0 && strpos(strtolower($pname), "gift") !== FALSE) {
                		        $resp["msg"] = $dapp["corpOffMsg"];
                                $resp["status"] = "6";
                            } else if($isSent AND $vendor_code == 'localairtime') {
                                $bfrAmnt = $userbal;
                                $aftAmnt = $userbal - $topay;
                                
                                if($purchaseLimit >= $data_restriction_volume) {
                                    $status = 14; // Limit exceeded...
                                } else {
                                    if($systemcode == "data_home_endpoint") { $status = 0; $endpoint = 1; } else if($status == 0) { $status = 2; } else { $status = $status; }
                                }
                                
                                if(updatebal($aftAmnt, $userid)) {
                                    if($srchBucket != NULL) {
                                        $insert_query = "insert into baskethistory ( userid, network, product, amount, phoneno, plan, status, timed, msg, dataid, category, wallet_balance, bfrAmnt, aftAmnt, cost_price, channel, ussd, datatype, endpoint, sms, recip, dnd, electrictoken, waec, datapin, memo, rcvsent, rcvnsent) values ('$userid', '".strtoupper($networkName)."', '$pname', '$topay', '$mobileno', '$userplan', '$status', '$mytime', 'Request sent', '$dataid', 'data', '$aftAmnt', '$bfrAmnt', '$aftAmnt', '$cost_price', 'API', '$ussd', '$type', '$endpoint', '', '', '', '', '', '', '', '', '')";
                                    } else {
                                        $insert_query = "insert into mybuys ( userid, network, product, amount, phoneno, plan, status, timed, msg, dataid, category, wallet_balance, bfrAmnt, aftAmnt, cost_price, channel, ussd, datatype, endpoint, sms, recip, dnd, electrictoken, waec, datapin, memo, rcvsent, rcvnsent) values ('$userid', '".strtoupper($networkName)."', '$pname', '$topay', '$mobileno', '$userplan', '$status', '$mytime', 'Request sent', '$dataid', 'data', '$aftAmnt', '$bfrAmnt', '$aftAmnt', '$cost_price', 'API', '$ussd', '$type', '$endpoint', '', '', '', '', '', '', '', '', '')";
                                    }
                                    
                                    if($connect->dbcountchanges($insert_query)) {
                                        $descr = $pname . " ".$mobileno;
                                        $savedsms = "insert into datasms (descr, sms, timed) values ('$descr', '$ussd', '$mytime')";
                                        $connect->dbcountchanges($savedsms);
                                    }
                                    if(!empty($clientNumb) && $comm_amnt > 0) {
                                        $orderInfo = $pname;
                                        $saveTrns = "insert into referral_transactions (referralNumb, clientNumb, orderInfo, amount, orderDate, orderDate, status) values ('$username', '$clientNumb', '$orderInfo', '$comm_amnt', '$mytime', '0', '$dataid')";
                                        #since transaction has been saved, then we need to update the referral wallet
                                        $connect->dbcountchanges($saveTrns);
                                    }
                                    
                                    $resp["msg"] = "Order successful";
                                    $resp["status"] = "1";
                                    $resp["orderid"] = $dataid;
                                    $resp["datasize"] = $pname;
                                    $resp["amount_charge"] = $topay;
                                    $resp["network"] = strtoupper($networkName); 
                                    
                                } else {
                                    $resp["msg"] = "Transaction failed, please retry";
                                    $resp["status"] = "9999";
                                }
                            } else if($isSent AND ($vendor_code == 'smeplugcron' OR $vendor_code == 'olanetcron' OR $vendor_code == 'bwsubcron'  OR $vendor_code == "gwtscron" OR $vendor_code == 'yafunyafuncron' 
                                    OR $vendor_code == 'mysimhostingcron' OR $vendor_code == 'simserverscron' OR $vendor_code == 'iyiinstantcron'
                            )) {
                                $bfrAmnt = $userbal;
                                $aftAmnt = $userbal - $topay;
                                
                                if(updatebal($aftAmnt, $userid)) {
                                    // Ussd is missing because it's not on localairtime and once switched back to app, it causes issue...
                                    // Get localairtime ussd and store it down incase...
                                    
                                    //Since all data are depending on this to form to a ussd code, then we have...
                                    $dataRequest = dataRequest_prodID($product_id);
                                    $realfee = $dataRequest["realFee"];
                                    $pryFee = $dataRequest["pryFee"];
                                        
                                    if(strpos(strtolower($pname), "direct")!== false) {
                                        $ussd = $realfee.$mobileno.$pryFee;  $type = "direct";
                                    } else if($networkName == "glo" || $networkName == "mtn") {
        					            $ussd = $realfee.$mobileno.$pryFee;
                                    } else if($networkName == "9mobile" || $networkName == "airtel") {
        					            $ussd = $realfee.$mobileno.$pryFee;
    					            }
                                    
                                    if($srchBucket != NULL) {
                                       $insert_query = "insert into baskethistory ( userid, network, product, amount, phoneno, plan, status, timed, msg, dataid, category, wallet_balance, bfrAmnt, aftAmnt, cost_price, channel, ussd, datatype, endpoint, sms, recip, dnd, electrictoken, waec, datapin, memo, rcvsent, rcvnsent) values ('$userid', '".strtoupper($networkName)."', '$pname', '$topay', '$mobileno', '$userplan', '0', '$mytime', 'Request sent', '$dataid', 'data', '$aftAmnt', '$bfrAmnt', '$aftAmnt', '$cost_price', 'API', '$ussd', '$type', '$endpoint', '', '', '', '', '', '', '', '', '')";
                                    } else {
                                        $insert_query = "insert into mybuys ( userid, network, product, amount, phoneno, plan, status, timed, msg, dataid, category, wallet_balance, bfrAmnt, aftAmnt, cost_price, channel, ussd, datatype, endpoint, sms, recip, dnd, electrictoken, waec, datapin, memo, rcvsent, rcvnsent) values ('$userid', '".strtoupper($networkName)."', '$pname', '$topay', '$mobileno', '$userplan', '0', '$mytime', 'Request sent', '$dataid', 'data', '$aftAmnt', '$bfrAmnt', '$aftAmnt', '$cost_price', 'API', '$ussd', '$type', '$endpoint', '', '', '', '', '', '', '', '', '')";
                                    }
                                   
                                    if($connect->dbcountchanges($insert_query)) {
                                        $descr = $pname . " ".$mobileno;
                                        $savedsms = "insert into datasms (descr, sms, timed) values ('$descr', '$ussd', '$mytime')";
                                        $connect->dbcountchanges($savedsms);
                                    }
                                    if(!empty($clientNumb) && $comm_amnt > 0) {
                                        $orderInfo = $pname;
                                        $saveTrns = "insert into referral_transactions (referralNumb, clientNumb, orderInfo, amount, orderDate, orderDate, status) values ('$username', '$clientNumb', '$orderInfo', '$comm_amnt', '$mytime', '0', '$dataid')";
                                        #since transaction has been saved, then we need to update the referral wallet
                                        $connect->dbcountchanges($saveTrns);
                                    }
                                    
                                    $resp["msg"] = "Order successful";
                                    $resp["status"] = "1";
                                    $resp["orderid"] = $dataid;
                                    $resp["datasize"] = $pname;
                                    $resp["amount_charge"] = $topay;
                                    $resp["network"] = strtoupper($networkName); 

                                } else {
                                    $resp["msg"] = "Transaction failed, please retry";
                                    $resp["status"] = "9999";
                                }
                                
                                
                            } else {
                		        $resp["msg"] = "Error: Product is currently unavailable";
                                $resp["status"] = "6";
                            }
                            
                        }  else {
            		        $resp["msg"] = "Failed: Access remote server not found";
                            $resp["status"] = "5";
            		    }
                    }
                    
                } else if($category == "Broadband data") { #smile, spectranet vending...
                    $bundleName = $pname;
                    if(strpos(strtolower($pname), "smile")!== false) {
                        $networkName = "smile";
                    } else { $networkName = ""; }
                    
                    if(in_array($username, $allowMemb)) { $status = $allowMembstatus; } else if(in_array($phone, $allowNo)) { $status = $allowstatus; } else if(in_array($phone, $suspectedNo)) { $status = $orderstatus; } else { $status = 0; }
                    
                    $loadAir = $connect->dbrow("SELECT * FROM `product` where pname='$bundleName'");
                    $commission = $loadAir["commission"];
                    $calcType = $loadAir["calcType"];
                    if($calcType == "Naira") {
                        $comm_amnt = $commission; 
                    } else {
                        $comm_amnt = ($topay*$commission)/100;
                    }
                    
                    if($allowCP > 0) {
                        
                        $srchType = $connect->dbrow("select * from scptype where id='$allowCP'");
                        $typeName = $srchType["name"];
                        
                        //What's the cost price for the product this user is buying...
                        $srchCp = $connect->dbrow("select * from scp where type='$typeName' and prodID='".$loadAir["prodID"]."'");
                        $cost_price = $srchCp["cost_price"];
                
                        if($cost_price <= 0) {
                            $cost_price = $loadAir["cost_price"];
                        } else { $cost_price = $srchCp["cost_price"]; }
                        
                    } else {
                        $cost_price = $loadAir["cost_price"];
                    }
                    
                    // Custom API Is enabled for this user....
                    if($userInfo['custom_api'] == 1) {
                        //Check custom_build_api table if to know the API enable for this user...
                        $srchCustom = $connect->dbrow("SELECT * FROM `custom_build_api` where user_id = '$userid' and product_group ='Broadband Data'");
                        
                        // Which API is enabled for this user...
                        $apiID = isset($srchCustom)? $srchCustom['api_id']:getproductAPI($pname, "Broadband data");
                        
                        //Get API Info....
                        $api = getAPI($apiID);
                    } else {
                        //Let's make a search for the api key...
                        $apiID = getproductAPI($networkName, "Broadband data");
                        $api = getAPI($apiID);
                    }
                    
                    #vendor ID from API...
                    $vendorID = $api["api_vendor_id"];
                    $vendorInfo = getVendor($vendorID);
                    $vendor_code = $vendorInfo["vendor_code"];
                    
                    $srchProd = $connect->dbrow("SELECT * FROM `products` where pname='$bundleName' and planname='$userplan'");
                    
                    if($switchPrice == 1) {
                        $price = $srchProd["price"];
                        $percent = $srchProd["percent"];
                        $commission = $srchProd["commission"];
                    } else if($switchPrice == 2) {
                        $price = $srchProd["price2"];
                        $percent = $srchProd["percent2"];
                        $commission = $srchProd["commission2"];
                    } else if($switchPrice == 3) {
                        $price = $srchProd["price3"];
                        $percent = $srchProd["percent3"];
                        $commission = $srchProd["commission3"];
                    }
                    
                    if($percent > 0) {
                        $vat = ($price * $percent)/100; $topay = $price - $vat;
                    } else { $vat = $commission; $topay = $price + $vat; }
                    
                    #$topay = 50; # a test
                    
                    //Allocated fee..
                    $srch = $connect->dbrow("select * from allocate where category='$category'");
                    $amount_allocate = $srch["amount"];
                    $blc_allocate = $srch["blc"];
    
                    $newBlc_Allocate = $blc_allocate + $price;
                    
                    if(strlen($phone) < 5 || !is_numeric($phone)) {
                        $resp["msg"] = "Invalid mobile number";
                        $resp["status"] = "9999";
                    } else if($topay == 0 || $topay < 0) {
                        $resp["msg"] = "Error: Contact admin, no valid price";
                        $resp["status"] = "9999";
                    } else if($topay > $userbal) {
                        $resp["msg"] = "Insufficient wallet balance";
                        $resp["status"] = "3";
                    } else if($srchProd["available"] == 0) {
                        $resp["msg"] = "Failed: ". strtoupper($bundleName)." is not available at the moment. Please try again later";
                        $resp["status"] = "9999";
                    } else {
                        $aftAmnt = $userbal - $topay;
                        
                        $data = array();
                        $data["deviceName"] = $networkName;
					    $data["accNo"] = $phone;
					    $data["bundle"] = $bundleName;
					    $data["prodID"] = $dataplan;
					    $data["refID"] = $dataid;
					    $data = json_encode($data);
                        
                        if(file_exists("../classes/class_".$vendor_code.".php")) {
                            require_once "../classes/class_".$vendor_code.".php";
    					    $setter = new $vendor_code();
    					    $orderInfo = $bundleName;
    					    
    					    if($rstatus > 0) {
    					        updatebal($aftAmnt, $userid);

        						$connect->dbcountchanges("insert into  mybuys  (userid, network, product, amount, bfrAmnt, aftAmnt, phoneno, plan, status, timed, msg, dataid, category, wallet_balance, cost_price, ussd, sms, recip, dnd, electrictoken, waec, datapin, datatype, channel, memo, rcvsent, rcvnsent) values ('$userid', '$networkName', '$bundleName',  '$topay', '$userbal', '$aftAmnt', '$phone', '$userplan', '$rstatus', '$mytime',  'Fraud Notice', '$dataid', 'Broadband data', '$aftAmnt', '$cost_price', '', '', '', '', '', '', '', 'smile', 'API', '$memo', '', '')");
        					 
        						if(!empty($clientNumb) && $comm_amnt > 0) {
        							$saveTrns = "insert into referral_transactions (referralNumb, clientNumb, orderInfo, amount, orderDate, status, dataid) values ('$usertelno', '$clientNumb', '$orderInfo', '$comm_amnt', '$mytime', '1', '$dataid')";
        							#since transaction has been saved, then we need to update the referral wallet
        							$connect->dbcountchanges($saveTrns);
        						} 
        						
        						$status = 0;
    					    
    					    } else if($newBlc_Allocate > $amount_allocate && $amount_allocate > 0) {
    					        
    					        updatebal($aftAmnt, $userid);

        						$connect->dbcountchanges("insert into  mybuys  (userid, network, product, amount, bfrAmnt, aftAmnt, phoneno, plan, status, timed, msg, dataid, category, wallet_balance, cost_price, ussd, sms, recip, dnd, electrictoken, waec, datapin, datatype, channel, memo, rcvsent, rcvnsent) values ('$userid', '$networkName', '$bundleName',  '$topay', '$userbal', '$aftAmnt', '$phone', '$userplan', '0', '$mytime',  'Allocation exhausted', '$dataid', 'Broadband data', '$aftAmnt', '$cost_price', '', '', '', '', '', '', '', 'smile', 'API', '', '', '')");
        					 
        						if(!empty($clientNumb) && $comm_amnt > 0) {
        							$saveTrns = "insert into referral_transactions (referralNumb, clientNumb, orderInfo, amount, orderDate, status, dataid) values ('$usertelno', '$clientNumb', '$orderInfo', '$comm_amnt', '$mytime', '1', '$dataid')";
        							#since transaction has been saved, then we need to update the referral wallet
        							$connect->dbcountchanges($saveTrns);
        						} 
        						
        						$status = 0;
        						
					        } else {
    					        
        					    $result = $setter->postdata("broadband", $data);
        						$msg = addslashes($_SESSION["response"]);
        						
        					    if($result) {
        					        updatebal($aftAmnt, $userid);
            						
            						$connect->dbcountchanges("insert into  mybuys  (userid, network, product, amount, bfrAmnt, aftAmnt, phoneno, plan, status, timed, msg, dataid, category, wallet_balance, cost_price, ussd, sms, recip, dnd, electrictoken, waec, datapin, datatype, channel, memo, rcvsent, rcvnsent) values ('$userid', '$networkName', '$bundleName',  '$topay', '$userbal', '$aftAmnt', '$phone', '$userplan', '1', '$mytime',  '$msg', '$dataid', 'Broadband data', '$aftAmnt', '$cost_price', '', '', '', '', '', '', '', 'smile', 'API', '', '', '')");
            					 
        					        #update Allocation..
                                    $connect->dbcountchanges("update allocate set blc='$newBlc_Allocate' where category='$category'");
            					    
            						if(!empty($clientNumb) && $comm_amnt > 0) {
            							$saveTrns = "insert into referral_transactions (referralNumb, clientNumb, orderInfo, amount, orderDate, status, dataid) values ('$usertelno', '$clientNumb', '$orderInfo', '$comm_amnt', '$mytime', '1', '$dataid')";
            							#since transaction has been saved, then we need to update the referral wallet
            							$connect->dbcountchanges($saveTrns);
            						} 
            						$status = 1;
        					    } else {
            						$status = 0;
        					        
        					        updatebal($aftAmnt, $userid);
            						$connect->dbcountchanges("insert into  mybuys  (userid, network, product, amount, bfrAmnt, aftAmnt, phoneno, plan, status, timed, msg, dataid, category, wallet_balance, cost_price, ussd, sms, recip, dnd, electrictoken, waec, datapin, datatype, channel, memo, rcvsent, rcvnsent) values ('$userid', '$networkName', '$bundleName',  '$topay', '$userbal', '$aftAmnt', '$phone', '$userplan', '0', '$mytime',  '$msg', '$dataid', 'Broadband data', '$aftAmnt', '$cost_price', '', '', '', '', '', '', '', 'smile', 'API', '', '', '')");
            							
    							    #update Allocation..
                                    $connect->dbcountchanges("update allocate set blc='$newBlc_Allocate' where category='$category'");
            							
            						if(!empty($clientNumb) && $comm_amnt > 0) {
            							$saveTrns = "insert into referral_transactions (referralNumb, clientNumb, orderInfo, amount, orderDate, orderDate, status) values ('$usertelno', '$clientNumb', '$orderInfo', '$comm_amnt', '$mytime', '1', '$dataid')";
            							#since transaction has been saved, then we need to update the referral wallet
            							$connect->dbcountchanges($saveTrns);
            						} 
            						
            						$sms_r = json_decode($dapp["sms"], true);
            						$senderid = $sms_r["senderName"];
            						
            						if($sms_r["gateway"] == "dnd") {
            							$pname = 'DND Route';
            						} else { $pname = 'Non DND Route'; }
            						
            						$loadapi = $connect->dbrow("select * from product where category='BulkSMS' and pname='$pname'");
            						$apiID = $loadapi["apiKey"];
            						$api = getAPI($apiID);
            						$vendorID = $api["api_vendor_id"];
                                    $systemcode = $api["api_system_code"];
            						$vendorInfo = getVendor($vendorID);
            						$vendor_code = $vendorInfo["vendor_code"];
            						
            						require_once "../classes/class_".$vendor_code.".php";
            						$setter = new $vendor_code();
            						
            						$data = array();
            						$data["message"] = "Pending order of $bundleName has been received. Kindly check request";
            						$data["recevier"] = "07030237966";
            						$data["sender"] = $senderid;
            						$data = json_encode($data);
            						$setter->postdata($systemcode, $data);
        					    }
    					    }
    					    $resp["msg"] = "Order successful";
        					$resp["status"] = "1";
        					$resp["orderstatus"] = $status;
        					$resp["orderid"] = $dataid;
        					$resp["datasize"] = $bundleName;
                            $resp["amount_charge"] = $topay;
        					$resp["network"] = strtoupper($networkName);
    					    
                        } else {
            		        $resp["msg"] = "Failed: Access remote server not found";
                            $resp["status"] = "5";
            		    }
                    }
                    
                    
                } else { }
                
            } else {
		        $resp["msg"] = "Invalid parameter supplied";
                $resp["status"] = "9";
            }
        }
       
   } else {
        $resp["msg"] = "Invalid username";
        $resp["status"] = "7";
    }
    
} else {
    $resp["msg"] = "Username and password parameter not passed";
    $resp["status"] = "9999";
}

echo json_encode($resp);
