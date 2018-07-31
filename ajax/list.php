<?php
OCP\JSON::checkLoggedIn();
OCP\JSON::callCheck();
$params = \OCA\Superlog\Log::params($_REQUEST);

if(isset($_SERVER['HTTP_REFERER']) && basename($_SERVER['HTTP_REFERER'])!='admin'){
	$params['user']=OC_User::getUser();
}
if(false === $list = \OCA\Superlog\Log::get($params)){
	OCP\JSON::error(array('message'=>'Error retreiving superlog list'));
} 
else{
	OCP\JSON::success(array('data'=>$list));
}

