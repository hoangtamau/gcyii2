<?php
use amnah\yii2\user\models\User;
use amnah\yii2\user\models\Userl;
use amnah\yii2\user\models\Addresses;
use amnah\yii2\user\models\Countries;
use yii\easyii\helpers\Globals;
$clientId = '744065055458-cb74sujp0r2prh8u22ivarpo6p5eg2h4.apps.googleusercontent.com';
$clientSecret = 'TAaHOd4I1prKo92xOwwqUBnO'; 
$redirectURL = 'https://gamecard.vn/lienhe/test'; 
$gClient = new Google_Client();
$gClient->setApplicationName('Gamecard.vn');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);
$google_oauthV2 = new Google_Oauth2Service($gClient);
if(isset($_GET['code'])){
	$gClient->authenticate($_GET['code']);
	$_SESSION['socialClient1'] = 'code';
	$_SESSION['gamecard11'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
}
if (isset($_SESSION['socialClient1'])){
	echo $_SESSION['socialClient1'];
	print_r($_SESSION['gamecard11']);
}
if (isset($_SESSION['gamecard11'])){
	$gClient->setAccessToken($_SESSION['gamecard11']);
}



if ($gClient->getAccessToken()) {
	//Get user profile data from google
	$gpUserProfile = $google_oauthV2->userinfo->get();
	if($gpUserProfile['email']!=""){
		$randompass = Globals::generateRandomString(); 
		if ($user = User::findByUsername($gpUserProfile['email'])) {
			if (Yii::$app->getUser()->login($user)) {
				$getaddress = Addresses::findOne(['uid' => Yii::$app->user->id]);
				if ($getaddress) {
					Yii::$app->session->destroySession('notation');
					$notation = Globals::GetNotation($getaddress->country_code);
					Yii::$app->session->set('notation', $notation);
				} else {
					$location = Yii::$app->geoip->lookupLocation();
					$currency = Globals::GetNotation($location->countryCode);
					Yii::$app->session->set('notation', $currency);
				}
				
				if (empty($user->password)) {
					header("Location: https://gamecard.vn/tai-khoan.html");
				}
			}
		}
		$user = new Userl();
		$user->username = $gpUserProfile['email'];
		$user->email = $gpUserProfile['email'];
		$user->user_url = $gpUserProfile['link'];
		$user->setPassword($randompass);
		$user->generateAuthKey();
		$user->status = 1;
		if ($user->save()) {
			$getaddress = Addresses::findOne(['uid' => $user->id]);
			$address = $getaddress ? $getaddress : new Addresses;
			if (!$getaddress) {                                
				$country = Yii::$app->geoip->lookupLocation();				
				$countryname = Countries::find()->where('country_iso_code_2 = "' . $country->countryCode . '"')->one();
				$address->city = $country->city;
				$address->postal_code = $country->postalCode;
				$address->country = $countryname['country_id'];
				$address->country_name = $countryname['country_name'];
				$address->country_code = $country->countryCode;
				$address->email = $user->email;
				$address->uid = $user->id;
				$address->created = time();
				$address->save(false);
			}
			if (Yii::$app->getUser()->login($user)) {
				header("Location: https://gamecard.vn");
			}
		}			
	}else{
		echo "Không lấy được Email từ google";
	}
}
	$authUrl = $gClient->createAuthUrl();
	echo $output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'">Login</a>';
?>

<a href="https://gamecard.vn/lien-he.html">Liên hệ</a>