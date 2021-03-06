<?php

namespace app\controllers;

use yii\easyii\modules\shopcart\models\Order;
use Yii;
use yii\easyii\modules\shopcart\models\Good;
use yii\easyii\helpers\Mail;


class RepayController extends \yii\web\Controller {
	public $enableCsrfValidation = false;
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionOnecomnd() {
        //Start working with repay oncome here
        if (isset($_GET["vpc_SecureHash"]) && isset($_GET["vpc_MerchTxnRef"])) {
            $SECURE_SECRET = "3C27F492A0F05BF49CD60D24AE0A5929";
            $vpc_Txn_Secure_Hash = $_GET["vpc_SecureHash"];
            $vpc_MerchTxnRef = $_GET["vpc_MerchTxnRef"];
            unset($_GET["vpc_SecureHash"]);
            $array_merchtxnref = explode("_", $vpc_MerchTxnRef);
            $querystring = '';
            foreach ($_GET as $key => $value) {
                $value = urlencode(stripslashes($value));
                $querystring .= "$key=$value&";
            }
            $upadteOrder = Order::updateAll(array('data' => $querystring), ['order_id' => $array_merchtxnref[1]]);
            if (count($array_merchtxnref) == 3 && $array_merchtxnref[0] == 'Order' && is_numeric($array_merchtxnref[1]) && is_numeric($array_merchtxnref[2])) {
                $errorExists = false;
                if (strlen($SECURE_SECRET) > 0 && $_GET["vpc_TxnResponseCode"] != "7" && $_GET["vpc_TxnResponseCode"] != "No Value Returned") {
                    ksort($_GET);
                    $md5HashData = "";
                    foreach ($_GET as $key => $value) {
                        if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0, 4) == "vpc_") || (substr($key, 0, 5) == "user_"))) {
                            $md5HashData .= $key . "=" . $value . "&";
                        }
                    }
                    $md5HashData = rtrim($md5HashData, "&");
                    if (strtoupper($vpc_Txn_Secure_Hash) == strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*', $SECURE_SECRET)))) {
                        $hashValidated = "CORRECT";
                    } else {
                        $hashValidated = "INVALID HASH";
                    }
                } else {
                    $this->redirect($this->goHome());
                    exit();
                }
                $amount = ($_GET["vpc_Amount"]);
                $locale = ($_GET["vpc_Locale"]);
                $command = ($_GET["vpc_Command"]);
                $version = ($_GET["vpc_Version"]);
                $orderInfo = ($_GET["vpc_OrderInfo"]);
                $merchantID = ($_GET["vpc_Merchant"]);
                $merchTxnRef = ($_GET["vpc_MerchTxnRef"]);
                $transactionNo = ($_GET["vpc_TransactionNo"]);
                $txnResponseCode = ($_GET["vpc_TxnResponseCode"]);
                $orderId = $array_merchtxnref[1];
                $order_info = Order::findOne(['order_id' => $orderId]);
                $html = '';
                $transStatus = "";
                $returnurl = '';
                $status_oncome = '';
                if ($hashValidated == "CORRECT" && $txnResponseCode == "0") {
                    $status_oncome = 'completed';
                    Order::updateAll(['status' => 'completed'], ['order_id' => $array_merchtxnref[1]]);
                    $html .='<p style="font-size:14px;font-weight:bold;line-height:35px;">C??m ??n qu?? kh??ch, qu?? tr??nh thanh to??n ???? ???????c ho??n t???t. Ch??ng t??i s??? ki???m tra v?? chuy???n h??ng s???m cho qu?? kh??ch!
                             <br> <a style="font-weight:bold; text-decoration:underline" href="' . Yii::$app->getHomeUrl() . '">Tr??? l???i trang ch???</a>.</p>';
					
				} elseif ($hashValidated == "CORRECT" && $txnResponseCode != "0") {
                    $status_oncome = 'canceled';
                    Order::updateAll(['status' => 'canceled'], ['order_id' => $array_merchtxnref[1]]);
                    $html.='<p style="font-size:14px;font-weight:bold;line-height:35px;">Qu?? tr??nh thanh to??n kh??ng th??nh c??ng b???n vui l??ng th???c hi???n l???i !
                                <br><a style="font-weight:bold; text-decoration:underline" href="' . Yii::$app->getHomeUrl() . '">Tr??? l???i trang ch???</a>.</p>';
                } elseif ($hashValidated == "INVALID HASH") {
                    $status_oncome = 'pending';
                    $html.='<p style="font-size:14px;font-weight:bold;line-height:35px;">Qu?? tr??nh thanh to??n ??ang trong tr???ng th??i ch??? 
                        <br> <a style="font-weight:bold; text-decoration:underline" href="' . Yii::$app->getHomeUrl() . '">Tr??? l???i trang ch???</a>.</p>';

                    Order::updateAll(['status' => 'pending'], ['order_id' => $array_merchtxnref[1]]);
                }
                $bodyMail = "<table cellspacing='0' cellpadding='0' border='0' style='font:11px Verdana,Arial,Helvetica,sans-serif;color:#333'>
                                <tr><td colspan='2'>Thanks for your order</td></tr>
                                <tr><td colspan='2'>&nbsp;</td></tr>
                                <tr><td colspan='2' style='background: #0184C2; color: #fff;'>Purchasing Information:</td></tr>
                                <tr><td width='150'>E-mail Address:</td>
                                    <td width='370'>" . $order_info['email'] . "</td>
                                </tr>
                                <tr><td width='150'>Billing Address:</td>
                                    <td>" . $order_info['address'] . "</td>
                                </tr>
                                <tr><td width='150'>Billing Phone:</td>
                                    <td>" . $order_info['phone'] . "</td>
                                </tr>
                                <tr><td width='150'>Order Grand Total:</td>
                                    <td>" . $amount . "</td>
                                </tr>
                                <tr><td width='150'>Payment Method:</td>
                                    <td>" . $order_info['payment_method'] . "</td>
                                </tr>
                                ";

                if ($status_oncome == 'completed') {
                    $bodyMail .= '<tr><td>Status Order: </td><td>Payment Successful</td></tr>
                                    <tr><td colspan="2"><b>We will send cards in soon</b></td></tr>';
                } else {
                    $bodyMail .= '<tr><td>Status Order: </td><td>Payment Fail</td></tr>
                                    <tr><td colspan="2"><b style="color: red;">You should try to payment again </b></td></tr>';
                }
                /*$bodyMail .= "<tr><td colspan='2'>&nbsp;</td></tr>
                                  <tr><td colspan='2' style='background: #0184C2; color: #fff;'>Order Summary:</td></tr>
                                  <tr><td width='150'>Order #:</td>
                                  <td>" . $orderId . "</td>
                                  </tr>
                                  <tr><td>Products on order: </td><td></td></tr>
                                  <tr><td colspan='2'>" . Good::getListProduct($orderId) . "</td></tr>
                                  </table>";
                $subject = "Your Order at Easy";
                $settings = Yii::$app->getModule('admin')->activeModules['shopcart']->settings;
                Mail::send(
                            $order_info['email'], $subject, $settings['templateOnNewOrder'], [
                            'order' => $bodyMail,
                        ]
                );*/
                //$request = Yii::$app->request->post;
                //return $this->render('index', array('html' => $html));
                Yii::$app->session->setFlash("successrepay",$html);
                Yii::$app->response->redirect(['/repay/repay']);
                Yii::$app->end();
            } else {
                $this->redirect($this->goHome());
                exit();
            }
        } else {
            $this->redirect($this->goHome());
            exit();
        }
    }
	public function actionOnecomvnd() {		
        if (isset($_GET["vpc_SecureHash"]) && isset($_GET["vpc_MerchTxnRef"]) && isset($_GET["vpc_TxnResponseCode"])) {

            // *********************
            // START OF MAIN PROGRAM
            // *********************
            // Define Constants
            // ----------------
            // This is secret for encoding the MD5 hash
            // This secret will vary from merchant to merchant
            // To not create a secure hash, let SECURE_SECRET be an empty string - ""
            // $SECURE_SECRET = "secure-hash-secret";
            $SECURE_SECRET = "202BD0DC106EB249FCDB1D6A784F2176";

            // get and remove the vpc_TxnResponseCode code from the response fields as we
            // do not want to include this field in the hash calculation
            $vpc_Txn_Secure_Hash = $_GET["vpc_SecureHash"];
            $vpc_MerchTxnRef = $_GET["vpc_MerchTxnRef"];
            $vpc_AcqResponseCode = $_GET["vpc_AcqResponseCode"];
            unset($_GET["vpc_SecureHash"]);
            $array_merchtxnref = explode("_", $vpc_MerchTxnRef);
			/*
            $querystring = '';
            foreach ($_GET as $key => $value) {
                $value = urlencode(stripslashes($value));
                $querystring .= "$key=$value&";
            }*/
			$payer_status  = '';
            $querystring = '';
			//$stringkey = array("vpc_CardNum", "vpc_3DSenrolled", "vpc_3DSXID", "vpc_3DSECI");
			$stringkey = array("vpc_CardNum", "vpc_3DSenrolled", "vpc_TxnResponseCode", "vpc_AVS_Street01","vpc_TxnResponseCode","vpc_CommercialCard","vpc_AVS_City","vpc_AVS_Country");
            foreach ($_GET as $key => $value) {
                $value = urlencode(stripslashes($value));		
				if(in_array($key ,$stringkey)){
					if($key=="vpc_AVS_Street01"){
						$value=str_replace(',',' ', $value);
					}
					$payer_status .= "$key=$value,";
				}	
                $querystring .= "$key=$value&";
            }
			
            if (count($array_merchtxnref) == 3 && $array_merchtxnref[0] == 'MeRef' && is_numeric($array_merchtxnref[1]) && is_numeric($array_merchtxnref[2])) {

                //$upadteOrder = Order::updateAll(array('data' => $querystring), ['order_id' => $array_merchtxnref[1]]);
				$upadteOrder = Order::updateAll(['data' => $querystring,'info_payer' =>$payer_status], ['order_id' => $array_merchtxnref[1]]);
                // set a flag to indicate if hash has been validated
                $errorExists = false;

                if (strlen($SECURE_SECRET) > 0 && $_GET["vpc_TxnResponseCode"] != "7" && $_GET["vpc_TxnResponseCode"] != "No Value Returned") {

                    ksort($_GET);
                    //$md5HashData = $SECURE_SECRET;
                    //kh???i t???o chu???i m?? h??a r???ng
                    $md5HashData = "";
                    // sort all the incoming vpc response fields and leave out any with no value
                    foreach ($_GET as $key => $value) {
                        //        if ($key != "vpc_SecureHash" or strlen($value) > 0) {
                        //            $md5HashData .= $value;
                        //        }
                        //      ch??? l???y c??c tham s??? b???t ?????u b???ng "vpc_" ho???c "user_" v?? kh??c tr???ng v?? kh??ng ph???i chu???i hash code tr??? v???
                        if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0, 4) == "vpc_") || (substr($key, 0, 5) == "user_"))) {
                            $md5HashData .= $key . "=" . $value . "&";
                        }
                    }
                    //  X??a d???u & th???a cu???i chu???i d??? li???u
                    $md5HashData = rtrim($md5HashData, "&");

                    //    if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper ( md5 ( $md5HashData ) )) {
                    //    Thay h??m t???o chu???i m?? h??a
                    if (strtoupper($vpc_Txn_Secure_Hash) == strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*', $SECURE_SECRET)))) {
                        // Secure Hash validation succeeded, add a data field to be displayed
                        // later.

                        $hashValidated = "CORRECT";
                    } else {
                        // Secure Hash validation failed, add a data field to be displayed
                        // later.
                        $hashValidated = "INVALID HASH";
                    }
                } else {
                    // Secure Hash was not validated, add a data field to be displayed later.
                    $this->redirect($this->goHome());
                    exit();
                    // $hashValidated = "INVALID HASH";
                }

                // Define Variables
                // ----------------
                // Extract the available receipt fields from the VPC Response
                // If not present then let the value be equal to 'No Value Returned'
                // Standard Receipt Data
                $amount = ($_GET["vpc_Amount"]);
                $locale = ($_GET["vpc_Locale"]);
                $batchNo = ($_GET["vpc_BatchNo"]);
                $command = ($_GET["vpc_Command"]);
                $message = ($_GET["vpc_Message"]);
                $version = ($_GET["vpc_Version"]);
                $cardType = ($_GET["vpc_Card"]);
                $orderInfo = ($_GET["vpc_OrderInfo"]);
                $receiptNo = ($_GET["vpc_ReceiptNo"]);
                $merchantID = ($_GET["vpc_Merchant"]);
                //$authorizeID = null2unknown($_GET["vpc_AuthorizeId"]);
                $merchTxnRef = ($_GET["vpc_MerchTxnRef"]);
                $transactionNo = ($_GET["vpc_TransactionNo"]);
                $acqResponseCode = ($_GET["vpc_AcqResponseCode"]);
                $txnResponseCode = ($_GET["vpc_TxnResponseCode"]);
                // 3-D Secure Data
                $verType = array_key_exists("vpc_VerType", $_GET) ? $_GET["vpc_VerType"] : "No Value Returned";
                $verStatus = array_key_exists("vpc_VerStatus", $_GET) ? $_GET["vpc_VerStatus"] : "No Value Returned";
                $token = array_key_exists("vpc_VerToken", $_GET) ? $_GET["vpc_VerToken"] : "No Value Returned";
                $verSecurLevel = array_key_exists("vpc_VerSecurityLevel", $_GET) ? $_GET["vpc_VerSecurityLevel"] : "No Value Returned";
                $enrolled = array_key_exists("vpc_3DSenrolled", $_GET) ? $_GET["vpc_3DSenrolled"] : "No Value Returned";
                $xid = array_key_exists("vpc_3DSXID", $_GET) ? $_GET["vpc_3DSXID"] : "No Value Returned";
                $acqECI = array_key_exists("vpc_3DSECI", $_GET) ? $_GET["vpc_3DSECI"] : "No Value Returned";
                $authStatus = array_key_exists("vpc_3DSstatus", $_GET) ? $_GET["vpc_3DSstatus"] : "No Value Returned";

                $orderId = $array_merchtxnref[1];

                $order_info = Order::findOne(['order_id' => $orderId]);
                $html = '';
                $transStatus = "";

                $status_oncome = '';
		//echo $hashValidated; die();		
                if ($hashValidated == "CORRECT" && $txnResponseCode == "0") {
                    //$transStatus = "Giao d???ch th??nh c??ng";
                    $status_oncome = 'completed';
                    Order::updateAll(['status' => $status_oncome], ['order_id' => $array_merchtxnref[1]]);
                    $html .='<p style="font-size:14px;font-weight:bold;line-height:35px;">C??m ??n qu?? kh??ch, qu?? tr??nh thanh to??n ???? ???????c ho??n t???t. Ch??ng t??i s??? ki???m tra v?? chuy???n h??ng s???m cho qu?? kh??ch!
                    <br> <a style="font-weight:bold; text-decoration:underline" href="' . Yii::$app->getHomeUrl() . '">Tr??? l???i trang ch???</a>.</p>';
                } elseif ($hashValidated == "CORRECT" && $txnResponseCode != "0") {
                    //$transStatus = "Giao d???ch th???t b???i";
                    $status_oncome = 'canceled';
                    Order::updateAll(['status' => $status_oncome], ['order_id' => $array_merchtxnref[1]]);
                    $html.='<p style="font-size:14px;font-weight:bold;line-height:35px;">Qu?? tr??nh thanh to??n kh??ng th??nh c??ng b???n vui l??ng th???c hi???n l???i !
                    <br> <a style="font-weight:bold; text-decoration:underline" href="' . Yii::$app->getHomeUrl() . '">Tr??? l???i trang ch???</a>.</p>';
                } elseif ($hashValidated == "INVALID HASH") {
                    //$transStatus = "Giao d???ch Pendding";
                    $status_oncome = 'pending';
                    $html.='<p style="font-size:14px;font-weight:bold;line-height:35px;">Qu?? tr??nh thanh to??n ??ang trong tr???ng th??i ch??? 
                           <br> <a style="font-weight:bold; text-decoration:underline" href="' . Yii::$app->getHomeUrl() . '">Tr??? l???i trang ch???</a>.</p>';

                    Order::updateAll(['status' => $status_oncome], ['order_id' => $array_merchtxnref[1]]);
                }
                //return $this->render('index', array('html' => $html));
                
                Yii::$app->session->setFlash("successrepay",$html);
                Yii::$app->response->redirect(['/repay/repay']);
                Yii::$app->end();
                
                
            } else {
                $this->redirect($this->goHome());
                exit();
            }
        }
    }
    public function actionOnecom() {		
        if (isset($_GET["vpc_SecureHash"]) && isset($_GET["vpc_MerchTxnRef"]) && isset($_GET["vpc_TxnResponseCode"])) {

            // *********************
            // START OF MAIN PROGRAM
            // *********************
            // Define Constants
            // ----------------
            // This is secret for encoding the MD5 hash
            // This secret will vary from merchant to merchant
            // To not create a secure hash, let SECURE_SECRET be an empty string - ""
            // $SECURE_SECRET = "secure-hash-secret";
            $SECURE_SECRET = "EB27A9161BBB79239D69D9F5A9E02D7D";

            // get and remove the vpc_TxnResponseCode code from the response fields as we
            // do not want to include this field in the hash calculation
            $vpc_Txn_Secure_Hash = $_GET["vpc_SecureHash"];
            $vpc_MerchTxnRef = $_GET["vpc_MerchTxnRef"];
            $vpc_AcqResponseCode = $_GET["vpc_AcqResponseCode"];
            unset($_GET["vpc_SecureHash"]);
            $array_merchtxnref = explode("_", $vpc_MerchTxnRef);
			/*
            $querystring = '';
            foreach ($_GET as $key => $value) {
                $value = urlencode(stripslashes($value));
                $querystring .= "$key=$value&";
            }*/
			$payer_status  = '';
            $querystring = '';
			//$stringkey = array("vpc_CardNum", "vpc_3DSenrolled", "vpc_3DSXID", "vpc_3DSECI");
			$stringkey = array("vpc_CardNum", "vpc_3DSenrolled", "vpc_TxnResponseCode", "vpc_AVS_Street01","vpc_TxnResponseCode","vpc_CommercialCard","vpc_AVS_City","vpc_AVS_Country");
            foreach ($_GET as $key => $value) {
                $value = urlencode(stripslashes($value));		
				if(in_array($key ,$stringkey)){
					if($key=="vpc_AVS_Street01"){
						$value=str_replace(',',' ', $value);
					}
					$payer_status .= "$key=$value,";
				}	
                $querystring .= "$key=$value&";
            }
			
            if (count($array_merchtxnref) == 3 && $array_merchtxnref[0] == 'MeRef' && is_numeric($array_merchtxnref[1]) && is_numeric($array_merchtxnref[2])) {

                //$upadteOrder = Order::updateAll(array('data' => $querystring), ['order_id' => $array_merchtxnref[1]]);
				$upadteOrder = Order::updateAll(['data' => $querystring,'info_payer' =>$payer_status], ['order_id' => $array_merchtxnref[1]]);

                // set a flag to indicate if hash has been validated
                $errorExists = false;

                if (strlen($SECURE_SECRET) > 0 && $_GET["vpc_TxnResponseCode"] != "7" && $_GET["vpc_TxnResponseCode"] != "No Value Returned") {

                    ksort($_GET);
                    //$md5HashData = $SECURE_SECRET;
                    //kh???i t???o chu???i m?? h??a r???ng
                    $md5HashData = "";
                    // sort all the incoming vpc response fields and leave out any with no value
                    foreach ($_GET as $key => $value) {
                        //        if ($key != "vpc_SecureHash" or strlen($value) > 0) {
                        //            $md5HashData .= $value;
                        //        }
                        //      ch??? l???y c??c tham s??? b???t ?????u b???ng "vpc_" ho???c "user_" v?? kh??c tr???ng v?? kh??ng ph???i chu???i hash code tr??? v???
                        if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0, 4) == "vpc_") || (substr($key, 0, 5) == "user_"))) {
                            $md5HashData .= $key . "=" . $value . "&";
                        }
                    }
                    //  X??a d???u & th???a cu???i chu???i d??? li???u
                    $md5HashData = rtrim($md5HashData, "&");

                    //    if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper ( md5 ( $md5HashData ) )) {
                    //    Thay h??m t???o chu???i m?? h??a
                    if (strtoupper($vpc_Txn_Secure_Hash) == strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*', $SECURE_SECRET)))) {
                        // Secure Hash validation succeeded, add a data field to be displayed
                        // later.

                        $hashValidated = "CORRECT";
                    } else {
                        // Secure Hash validation failed, add a data field to be displayed
                        // later.
                        $hashValidated = "INVALID HASH";
                    }
                } else {
                    // Secure Hash was not validated, add a data field to be displayed later.
                    $this->redirect($this->goHome());
                    exit();
                    // $hashValidated = "INVALID HASH";
                }

                // Define Variables
                // ----------------
                // Extract the available receipt fields from the VPC Response
                // If not present then let the value be equal to 'No Value Returned'
                // Standard Receipt Data
                $amount = ($_GET["vpc_Amount"]);
                $locale = ($_GET["vpc_Locale"]);
                $batchNo = ($_GET["vpc_BatchNo"]);
                $command = ($_GET["vpc_Command"]);
                $message = ($_GET["vpc_Message"]);
                $version = ($_GET["vpc_Version"]);
                $cardType = ($_GET["vpc_Card"]);
                $orderInfo = ($_GET["vpc_OrderInfo"]);
                $receiptNo = ($_GET["vpc_ReceiptNo"]);
                $merchantID = ($_GET["vpc_Merchant"]);
                //$authorizeID = null2unknown($_GET["vpc_AuthorizeId"]);
                $merchTxnRef = ($_GET["vpc_MerchTxnRef"]);
                $transactionNo = ($_GET["vpc_TransactionNo"]);
                $acqResponseCode = ($_GET["vpc_AcqResponseCode"]);
                $txnResponseCode = ($_GET["vpc_TxnResponseCode"]);
                // 3-D Secure Data
                $verType = array_key_exists("vpc_VerType", $_GET) ? $_GET["vpc_VerType"] : "No Value Returned";
                $verStatus = array_key_exists("vpc_VerStatus", $_GET) ? $_GET["vpc_VerStatus"] : "No Value Returned";
                $token = array_key_exists("vpc_VerToken", $_GET) ? $_GET["vpc_VerToken"] : "No Value Returned";
                $verSecurLevel = array_key_exists("vpc_VerSecurityLevel", $_GET) ? $_GET["vpc_VerSecurityLevel"] : "No Value Returned";
                $enrolled = array_key_exists("vpc_3DSenrolled", $_GET) ? $_GET["vpc_3DSenrolled"] : "No Value Returned";
                $xid = array_key_exists("vpc_3DSXID", $_GET) ? $_GET["vpc_3DSXID"] : "No Value Returned";
                $acqECI = array_key_exists("vpc_3DSECI", $_GET) ? $_GET["vpc_3DSECI"] : "No Value Returned";
                $authStatus = array_key_exists("vpc_3DSstatus", $_GET) ? $_GET["vpc_3DSstatus"] : "No Value Returned";

                $orderId = $array_merchtxnref[1];

                $order_info = Order::findOne(['order_id' => $orderId]);
                $html = '';
                $transStatus = "";

                $status_oncome = '';
				
                if ($hashValidated == "CORRECT" && $txnResponseCode == "0") {
                    //$transStatus = "Giao d???ch th??nh c??ng";
                    $status_oncome = 'completed';
                    Order::updateAll(['status' => $status_oncome], ['order_id' => $array_merchtxnref[1]]);
                    $html .='<p style="font-size:14px;font-weight:bold;line-height:35px;">C??m ??n qu?? kh??ch, qu?? tr??nh thanh to??n ???? ???????c ho??n t???t. Ch??ng t??i s??? ki???m tra v?? chuy???n h??ng s???m cho qu?? kh??ch!
                    <br> <a style="font-weight:bold; text-decoration:underline" href="' . Yii::$app->getHomeUrl() . '">Tr??? l???i trang ch???</a>.</p>';
		
				} elseif ($hashValidated == "CORRECT" && $txnResponseCode != "0") {
                    //$transStatus = "Giao d???ch th???t b???i";
                    $status_oncome = 'canceled';
                    Order::updateAll(['status' => $status_oncome], ['order_id' => $array_merchtxnref[1]]);
                    $html.='<p style="font-size:14px;font-weight:bold;line-height:35px;">Qu?? tr??nh thanh to??n kh??ng th??nh c??ng b???n vui l??ng th???c hi???n l???i !
                    <br> <a style="font-weight:bold; text-decoration:underline" href="' . Yii::$app->getHomeUrl() . '">Tr??? l???i trang ch???</a>.</p>';					
				
				
				} elseif ($hashValidated == "INVALID HASH") {
                    //$transStatus = "Giao d???ch Pendding";
                    $status_oncome = 'pending';
                    $html.='<p style="font-size:14px;font-weight:bold;line-height:35px;">Qu?? tr??nh thanh to??n ??ang trong tr???ng th??i ch??? 
                           <br> <a style="font-weight:bold; text-decoration:underline" href="' . Yii::$app->getHomeUrl() . '">Tr??? l???i trang ch???</a>.</p>';

                    Order::updateAll(['status' => $status_oncome], ['order_id' => $array_merchtxnref[1]]);
                }
                //return $this->render('index', array('html' => $html));
                
                Yii::$app->session->setFlash("successrepay",$html);
                Yii::$app->response->redirect(['/repay/repay']);
                Yii::$app->end();
                
                
            } else {
                $this->redirect($this->goHome());
                exit();
            }
        }
    }
    public function actionRepay() {
        return $this->render('repay');
    }
    public function actionPaypalcancel(){
        $html.='<p style="font-size:14px;font-weight:bold;line-height:20px;">Qu?? tr??nh thanh to??n kh??ng th??nh c??ng b???n vui l??ng th???c hi???n l???i !
               <br><a style="color:red;" href="' . Yii::$app->getHomeUrl() . '">Tr??? l???i trang ch???</a></p>';
        Yii::$app->session->setFlash("successrepay",$html);
        Yii::$app->response->redirect(['/repay/repay']);
        Yii::$app->end();
    }

    public function actionPaypal() {			
        if (isset($_POST["txn_id"]) && isset($_POST["txn_type"]) && isset($_POST['item_name'])) {
            $transaction_info = $_POST["item_name"];
            $array_merchtxnref = explode("_", $transaction_info); 
			$querystring = '';
			foreach ($_POST as $key => $value) {
				$value = urlencode(stripslashes($value));
				$querystring .= "$key=$value&";
			}
			$upadteOrder = Order::updateAll(array('data' => $querystring), ['order_id' => $array_merchtxnref[1]]);
			
			if ($_POST['payment_status'] == 'Completed') {				
				$status_paypal = 'completed';
                Order::updateAll(['status' => $status_paypal], ['order_id' => $array_merchtxnref[1]]);			
            } else if ($_POST['payment_status'] == 'Pending') {
				$status_paypal = 'paypal_pending';
                Order::updateAll(['status' => $status_paypal], ['order_id' => $array_merchtxnref[1]]);
            } else {
                $status_paypal = 'paypal_pending';
                Order::updateAll(['status' => $status_paypal], ['order_id' => $array_merchtxnref[1]]);
            }
        }
        $html.='<p style="font-size:14px;font-weight:bold;line-height:20px;">C??m ??n qu?? kh??ch, qu?? tr??nh thanh to??n ???? ???????c ho??n t???t. Ch??ng t??i s??? ki???m tra v?? chuy???n h??ng s???m cho qu?? kh??ch!
                <br> <a style="color:red;" href="' . Yii::$app->getHomeUrl() . '">Tr??? l???i trang ch???</a>.</p>';
        Yii::$app->session->setFlash("successrepay",$html);
        Yii::$app->response->redirect(['/repay/repay']);
        Yii::$app->end();
    }

    public function actionNotifyPaypal() {
        if (isset($_POST["txn_id"]) && isset($_POST["txn_type"]) && isset($_POST['item_name'])) {			
            $transaction_info = $_POST["item_name"];
            $array_merchtxnref = explode("_", $transaction_info);
            $querystring = 'trong_';
            foreach ($_POST as $key => $value) {
                //$value = urlencode(stripslashes($value));
				$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value);
                $querystring .= "$key=$value&";
            }
            Order::updateAll(['data' => $querystring], ['order_id' => $array_merchtxnref[1]]);
            if ($array_merchtxnref[0] == 'MeRef' && is_numeric($array_merchtxnref[1]) && is_numeric($array_merchtxnref[2])) {
                if (Order::checkcomplete_paypal($array_merchtxnref[1], $array_merchtxnref[2])) {
                    $req = 'cmd=_notify-validate';
					
					$payer_status  = '';
					$stringkey = array("first_name","last_name", "payer_email","receiver_email", "payer_status", "payment_status", "address_street", "invoice");
					
                    foreach ($_POST as $key => $value) {
                        $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
						if(in_array($key ,$stringkey)){	
							if($key=="address_street"){
								$value=str_replace(',',' ', $value);
							}
							$payer_status .= "$key=$value,";
						}
                        $req .= "&$key=$value";
                    }
					Order::updateAll(['info_payer' =>$payer_status], ['order_id' => $array_merchtxnref[1]]);
                    $data = array();
                    $data['item_name'] = $_POST['item_name'];
                    $data['item_number'] = $_POST['item_number'];
                    $data['payment_status'] = $_POST['payment_status'];
                    $data['payment_amount'] = $_POST['mc_gross'];
                    $data['payment_currency'] = $_POST['mc_currency'];
                    $data['txn_id'] = $_POST['txn_id'];
                    $data['receiver_email'] = $_POST['receiver_email'];
                    $data['payer_email'] = $_POST['payer_email'];
                    $data['custom'] = $_POST['custom'];
                    $status_paypal = '';
                    if ($data['payment_status'] == "Completed") {
                        Order::updateAll(['status' => 'completed'], ['order_id' => $array_merchtxnref[1]]);
                        $status_paypal = 'completed';						
                    } elseif ($data['payment_status'] == "Pending") {
                        Order::updateAll(['status' => 'paypal_pending'], ['order_id' => $array_merchtxnref[1]]);
                        $status_paypal = 'pending';
                    } else {
                        Order::updateAll(['status' => 'canceled'], ['order_id' => $array_merchtxnref[1]]);
                        $status_paypal = 'canceled';
                    }
                }
                if (Order::check_paypal_auto_complete($array_merchtxnref[1], $array_merchtxnref[2])) {
                    $data = array();
                    $data['payment_status'] = $_POST['payment_status'];
                    if ($data['payment_status'] == "Completed") {
                        Order::updateAll(['status' => 'completed'], ['order_id' => $array_merchtxnref[1]]);
                        $status_paypal = 'completed';						
                    }
                }
            }
        }
    }

}
