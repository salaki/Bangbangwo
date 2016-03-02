<?php
include $_SERVER['DOCUMENT_ROOT'].'/include/config.php';
session_start();
if($_SESSION['userid']>0){
        require ("balancedpayments.php");

        $config = array("apikey" => "ak-test-lymUshSo2yn4To7WRumf3gbRgq7gjYFA",

        // set your api key
                "payment_description" => " Charging the card",

        // set the payment description
                "statement_appear_as" => "Example Company"

        // set the statement

        );

        Balancedpayments::config($config);

        if($_POST['action']=='add_credit'){


        /**************Tokenize the card*********************/
         $card_params = array(
                "number"           => $_POST['cc-number'],
                "expiration_month" => $_POST['cc-ex-month'],
                "expiration_year"  => $_POST['cc-ex-year'],
                "security_code"    => $_POST['ex-csc'],
         );
         $card_info_array = Balancedpayments::tokenize_card($card_params);

        if($card_info_array[0]['category_code']=='card-not-validated'){
             header('Location:/card_detail.php?response=2');
        }else{

             /**************Create the customer*********************/    
            $userDetail=mysql_fetch_array(mysql_query("SELECT * FROM members WHERE id=".$_SESSION['userid']));
            $name = $userDetail['fname']." ".$userDetail['lname'];
            $email = $userDetail['email'];

             $userdata       = array("name" => $name, "email" => $email, "adddres" => "", "meta[user_id]" => $_SESSION['userid']);
             $customer_array = Balancedpayments::create_user($userdata);
             $customer_id    = $customer_array['customers'][0]['id'];


             $card_id= $card_info_array['cards'][0]['id'];
             
            /**************Attach the card to the customer*********************/
                $addcard = Balancedpayments::add_card($customer_id, $card_id);
                mysql_query("INSERT INTO credit_card_detail(user_id,card_no,customer_id,added_date) values('".$_SESSION['userid']."','".$card_id."','".$customer_id."','".date("Y-m-s H:i:s")."')");
                
                if($_POST['type']=='hire'){
                     header('Location:/dashboard');
                }else{
                    header('Location:/card_detail.php?response=1');
                }
        }
        die();
        ////
        }elseif($_POST['action']=='payment'){
           /************** Charge the Card*********************/
           
            $detail=mysql_fetch_array(mysql_query("SELECT * FROM credit_card_detail WHERE user_id=".$_SESSION['userid']." LIMIT 1"));
            $response = Balancedpayments::charge_card($detail['card_no'], $amount); 
          
            
            die();
        }
}

/************** Creat bank Account *********************/
// $bankDetails = array(
// 	"account_number"        => "9900000002",
// 	"account_type"          => "checking",
// 	"name"                  => "Syed Yousaf Ehsan Navqi Bank Test",
// 	"routing_number"        => "021000021",
// 	"address[city]"         => "Tenerife",
// 	"address[line1]"        => "Av Juan Carlos",
// 	"address[line2]"        => "",
// 	"address[state]"        => "Santa Cruz De Tenerife",
// 	"address[postal_code]"  => "38650",
// 	"address[country_code]" => "ES",
// );
// $bank_data_array = Balancedpayments::creatBankAccountDirect($bankDetails);
// echo "<pre/>";
// print_r($bank_data_array);

/************** Get bank account by id *********************/
// get bank account by id
// $bankAccountId   = "BA1oi3o5CoTt94I8sKHSTFo9";
// $bankAcountArray = Balancedpayments::getBankAccountById($bankAccountId);
// print_r($bankAcountArray);

/************** Get All bank Accounts *********************/
// $limitOffset = array(
// 	'limit'  => "10",
// 	'offset' => '0',
// );

// $bankAcountArray = Balancedpayments::getAllBankAccounts($limitOffset);
// print_r($bankAcountArray);

/************************ update bank Account ***************************/
// $updateBankDetails = array(
// 	"links[customer]"                  => "CU4SUGO6YhgivR19Ze121ybr", // customer id
// 	"links[bank_account_verification]" => "BZ1NndEHupZUuYDNPf75qXPv", // verfication id
// 	// in meta data you can add any thing that you want as follows
// 	"meta[user_id]"  => "182381",
// 	"meta[facebook]" => "facebook.com/link",

// );
// $bank_account_id = "BA1oi3o5CoTt94I8sKHSTFo9";// bank account id that you want to edit
// $bank_data_array = Balancedpayments::updateBankAccount($updateBankDetails, $bank_account_id);
// print_r($bank_data_array);

/************************ Add the bank account to customer ***************************/
// $customer_data = array(
// 	"customer" => "/customers/CU4SUGO6YhgivR19Ze121ybr"// customer Link
// );
// $bank_account_id = "BA15jLxp4neimaQLn1QPB73D";// bank account id that you want to edit
// $responseArray   = Balancedpayments::addBankToCustomer($bank_account_id, $customer_data);
// print_r($responseArray);

/************************ Delete bank Acount ***************************/

// $bank_account_id = "BA1oi3o5CoTt94I8sKHSTFo9";// bank account id that you want to edit
// $responseArray   = Balancedpayments::deleteBankAccount($bank_account_id);
// print_r($responseArray);

/************************ Debit bank Acount ***************************/

// $debit_details = array(
// 	"amount"                  => "10000", // integer
// 	"appears_on_statement_as" => "My Company Name",
// 	"description"             => "Description Goes here",
// 	"meta[userid]"            => "1231234123",
// );
// $bank_account_id = "BA5fuL1sBPBcHHYJjN4tQ9E1";// bank account id that you want to edit
// $responseArray   = Balancedpayments::debitBankAccount($bank_account_id, $debit_details);
// echo '<pre/>';
// print_r($responseArray);


//$arr=Balancedpayments::deleteBankAccount();
//echo "<pre/>";
//print_r($arr);
