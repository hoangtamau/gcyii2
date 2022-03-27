<?php
namespace app\modules\usermoney\controllers;
use Yii;
use app\modules\usermoney\models\Usermoney;
use app\modules\usermoney\models\UserHistoryMoney;
use app\modules\usermoney\models\AddToUserMoneyForm; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\easyii\helpers\Globals;
use yii\easyii\modules\payment\models\Payment;
use yii\easyii\helpers\Mail;
use amnah\yii2\user\models\Addresses;
use yii\easyii\helpers\Onepay;
use yii\easyii\helpers\OnepayND;
use yii\easyii\helpers\Paypal;

class UsermoneyController extends \yii\web\Controller
{
    public function actionIndex($tag = null)
    {
        if (!isset(Yii::$app->users->id)) {
            return $this->redirect(["/user/login"]);
        }
        $model = new AddToUserMoneyForm();
        return $this->render('index', [
                'model' => $model,
            ]);
    }
    public function actionSapsi()
    {
        $request = Yii::$app->request;
        if ($request->post()) {
            $money = Yii::$app->request->post('id');
            $money=str_replace( ',', '', $money );
            $money=(int)$money;
            $session = Yii::$app->session;
            $notation = $session->get('notation');
            $usermoneysend=Globals::convertNap($notation,'USD', $money );
            echo $usermoneysend;
        }
    }
    public function actionGetsalecurrency() {   
        $request = Yii::$app->request;
        if ($request->post()) {
            $name = Yii::$app->request->post('id');
            $payment = Payment::findOne(['name' => $name]);
            $arraycur = explode(',', $payment->currency);
            if (count($arraycur) > 0) {
                foreach ($arraycur as $row) {
                    echo "<option value='$row'>$row</option>";
                }
            } else {
                echo "<option>Select ...</option>";
            }
        }
    }
    public function actionRepaycommonwealth() {   
        return $this->render('repaycommonwealth');
    }
    public function actionRepaychangecards() {   
        return $this->render('repaychangecards');
    }    
    public function actionSend() {
        $model = new AddToUserMoneyForm();        
        $post = Yii::$app->request->post();       
        $notation = Yii::$app->session->get('notation');        
        $money=str_replace( ',', '', $post['AddToUserMoneyForm']['money'] );
        $money=(int)$money;
        $money1=(int)$money;
        $payment_method=$post['AddToUserMoneyForm']['payment_method'];
        $currency_payment_method=$post['AddToUserMoneyForm']['currency_payment_method'];
        $userhistorymoney= new UserHistoryMoney();
        $userhistorymoney->uid=Yii::$app->users->id;
        $userhistorymoney->money_send=$money;
        $userhistorymoney->currency_send=$notation;
		
		if($notation=="USD"){
            $userhistorymoney->money_usd=$money;
        }else{
            $moneyusd=Globals::convertNap1($notation,'USD', $money );
            $userhistorymoney->money_usd=$moneyusd;	
        }
		//echo $notation.$money_usd; die();
		
        $userhistorymoney->status="in_checkout";
        $userhistorymoney->workflow = 1;
        $userhistorymoney->ip = ip();
        $userhistorymoney->date=  time();
        $userhistorymoney->payment_method=$payment_method;
        $userhistorymoney->currency_payment_method=$currency_payment_method;        
        if($notation==$currency_payment_method)
        {
            $userhistorymoney->money_payment_method=$money;
        }else{
            // 500 aud khi thanh toán chọn paypal với ty gia thanh toán là USD => đoi 500AUD=>USD
            $money=Globals::convert($notation, $currency_payment_method , $money);
            $userhistorymoney->money_payment_method=$money;
        }
        if ($currency_payment_method == 'AUD') {
            if($payment_method=="Commonwealth"){
                $fee_send=0;
            }else {
                $fee_send = round(floatval(($money * 3.85) / 100) + 0.5, 2);
            }            
        } elseif ($currency_payment_method == "VND") {
            $fee_send = 2000;
        } else {
            $fee_send = round(floatval(($money * 3.85) / 100) + 0.5, 2);
        }
        $userhistorymoney->total_payment_method=$money+$fee_send;        
        $userhistorymoney->fee_send=$fee_send;       
        $vpcURL = '';
        if ($userhistorymoney->validate()) {            
            $userhistorymoney->save(FALSE);
            switch ($payment_method) {
                case 'OnecomND':
                    $onepay = new OnepayND();
                    $data = array();
                    $order_id = $userhistorymoney->id;
                    $vpc_Amount = number_format(($money1 + $fee_send), 2, '.', '') * 100;
                    $actual_link = 'http://' . $_SERVER['HTTP_HOST'];
                    $vpc_ReturnURL = Yii::$app->getUrlManager()->createAbsoluteUrl('repaymoney/onecomnd');
                    $vpc_OrderInfo = $userhistorymoney->id;
                    $vpc_MerchTxnRef = "Order_$order_id" . "_" . time();
                    $data['Title'] = 'VPC 3-Party';
                    $data['AgainLink'] = urlencode($actual_link);
                    $data['vpc_AccessCode'] = $onepay->getCode();
                    $data['vpc_Amount'] = $vpc_Amount;
                    $data['vpc_Command'] = 'pay';
                    $data['vpc_Currency'] = 'VND';
                    $data['vpc_Locale'] = 'vn';
                    $data['vpc_MerchTxnRef'] = $vpc_MerchTxnRef;
                    $data['vpc_Merchant'] = $onepay->getMerchant();
                    $data['vpc_OrderInfo'] = $vpc_OrderInfo;
                    $data['vpc_ReturnURL'] = $vpc_ReturnURL;
                    $data['vpc_TicketNo'] = $_SERVER['REMOTE_ADDR'];
                    $data['vpc_Version'] = 2;
                    $vpcURL = $onepay->buildCheckoutUrl($data);
                    Yii::$app->response->redirect($vpcURL);
                    Yii::$app->end();
                    break;
                case 'Onecom':
                    $onepay = new Onepay();
                    $data = array();
                    $order_id = $userhistorymoney->id;
                    $vpc_Amount = number_format(($money + $fee_send), 2, '.', '') * 100;
                    $actual_link = 'http://' . $_SERVER['HTTP_HOST'];
                    $vpc_ReturnURL = Yii::$app->getUrlManager()->createAbsoluteUrl('repaymoney/onecom');
                    $vpc_OrderInfo = $userhistorymoney->id;
                    $vpc_MerchTxnRef = "MeRef_$order_id" . "_" . time();
                    $data['Title'] = 'PHP+VPC+3-Party';
                    $data['AgainLink'] = urlencode($actual_link);
                    $data['vpc_AccessCode'] = $onepay->getCode();
                    $data['vpc_Amount'] = $vpc_Amount;
                    $data['vpc_Command'] = 'pay';
                    $data['vpc_Locale'] = 'en';
                    $data['vpc_MerchTxnRef'] = $vpc_MerchTxnRef;
                    $data['vpc_Merchant'] = $onepay->getMerchant();
                    $data['vpc_OrderInfo'] = $vpc_OrderInfo;
                    $data['vpc_ReturnURL'] = $vpc_ReturnURL;
                    $data['vpc_TicketNo'] = $_SERVER['REMOTE_ADDR'];
                    $data['vpc_Version'] = 2;
                    $vpcURL = $onepay->buildCheckoutUrl($data);
                    Yii::$app->response->redirect($vpcURL);
                    Yii::$app->end();
                    break;
                case 'Paypal':
                    $pp = new Paypal();
                    $data = array();
                    $order_id = $userhistorymoney->id;
                    $data['cmd'] = "_xclick";
                    $data['no_note'] = "1";
                    $data['no_shipping'] = 2;
                    $data['business'] = $pp->getBusiness();
                    $data['currency_code'] = $currency_payment_method;
                    $data['return'] = Yii::$app->getUrlManager()->createAbsoluteUrl('repaymoney/paypal');
                    $data['cancel_return'] = Yii::$app->getUrlManager()->createAbsoluteUrl('repaymoney/paypalcancel');
                    $data['notify_url'] = Yii::$app->getUrlManager()->createAbsoluteUrl('repaymoney/notifypaypal');
                    $data['rm'] = 2;
                    $data['upload'] = 1;
                    $data['invoice'] = $order_id . '-' . time();
                    $data['lc'] = "AU";
                    $address = Addresses::findOne(['uid' => Yii::$app->users->id]);
                    
                    
                    $data['payer_email'] = $address->email;
                    $data['country'] = $address->country;
                    $data['address1'] = $address->street1;
                    $data['address2'] = '';
                    $data['city'] = $address->city;
                    $data['first_name'] = $address->first_name;
                    $data['last_name'] = '';
                    $data['state'] = '';//$address->state;
                    $data['zip'] = $userhistorymoney->id;
                    $data['item_name'] = "MeRef_$order_id" . "_" . time() . "_Gamecard";
                    $data['item_number'] = 1;//count($this->order->goods);
                    $data['amount'] = Globals::formatprice($money + $fee_send);
                    $data['paymentaction'] = 'authorization';
                    $vpcURL = $pp->buildCheckoutUrlTest($data);
                    Yii::$app->response->redirect($vpcURL);
                    Yii::$app->end();
                    break;
                case 'Commonwealth':
                    $subject = 'Hướng dẫn thanh toán bằng chuyển khoản ngân hàng';
                    $boby = '';
                    $boby.="<table cellspacing='0' cellpadding='0' border='0' style='font:11px Verdana,Arial,Helvetica,sans-serif;color:#333'>
                            <tr><td>Cám ơn bạn đã nạp tiền tại Gamecard</td></tr>
                            <tr><td>Để hoàn tất giao dịch, bạn cần chuyển tiền đến tài khoản của chúng tôi tại ngân hàng của Australia:</td></tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr><td>*** Commonwealth bank:</td></tr>
                            <tr><td>* Name: Phuong V Bui</td></tr>
                            <tr><td>* BSB: 063-138</td></tr>
                            <tr><td>* Account number: 01-038-0196</td></tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr><td>Mã nạp tiền của bạn là: <b>" . $userhistorymoney->id . "</b></td></tr>
                            <tr><td>&nbsp;</td></tr>
                            ";

                    $boby.='</td></tr>
                            <tr><td>Số tiền cần chuyển là: <span style="color:#0066CC;font-weight: bold;" >' . Globals::formatprice($money + $fee_send) . ' ' . $model->currency_payment_method . $notation. '</span></td></tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr><td>Lưu ý: khi chuyển khoản bạn vui lòng ghi số ID order đơn hàng, tên khách hàng vào lý do chuyển khoản để nhân viên Gamecard tiện theo dõi</td></tr>
                    </table>';
                    $us = \amnah\yii2\user\models\User::findOne(['id' => Yii::$app->users->id]);                    
                    $settings = Yii::$app->getModule('admin')->activeModules['shopcart']->settings;                   
                    Mail::send(
                            $us->email, $subject, $settings['templateOnNewOrder'], [
                                'order' => $boby,
                            ]
                    );                    
                    $vpcURL = SITE_PATH."/usermoney/usermoney/repaycommonwealth"; 
                    Yii::$app->response->redirect($vpcURL);
                    Yii::$app->end();
                    break;
                case 'Changecards':
                    $us = \amnah\yii2\user\models\User::findOne(['id' => Yii::$app->users->id]);
                    $address = Addresses::findOne(['uid' => Yii::$app->users->id]);
                    $bodyMail = "<table cellspacing='0' cellpadding='0' border='0' style='font:11px Verdana,Arial,Helvetica,sans-serif;color:#333'>
                                    <tr><td colspan='2'>Thanks for your order: #".$userhistorymoney->id."</td></tr>
                                    <tr><td colspan='2'>&nbsp;</td></tr>
                                    <tr><td colspan='2' style='background: #0184C2; color: #fff;'>Purchasing Information:</td></tr>
                                    <tr><td width='150'>E-mail Address:</td>
                                        <td width='370'>" . $us->email . "</td>
                                    </tr>
                                    <tr><td width='150'>Billing Address:</td>
                                        <td>".$address->first_name .", " . $address->street1 .", ".$address->city.", ".$address->country. "</td>
                                    </tr>
                                    <tr><td width='150'>Billing Phone:</td>
                                        <td>" . $address->phone . "</td>
                                    </tr>";
                    $bodyMail .= "";
                    $subject = "Your Order at Gamecard";                    
                    $settings = Yii::$app->getModule('admin')->activeModules['shopcart']->settings;
                    Mail::send(
                            $us->email, $subject, $settings['templateOnNewOrder'], [
                                'order' => $bodyMail,
                            ]
                    );
                    $vpcURL = SITE_PATH."/usermoney/usermoney/repaychangecards";  
                    Yii::$app->response->redirect($vpcURL);
                    Yii::$app->end();
                    break;                
            }            
            return $this->render('send', [
                'model' => $model,
            ]);
        } else {		
            return $this->render('send', [
                'model' => $model,
            ]);
        }// end userhistorymoney    
    }// end send
}
