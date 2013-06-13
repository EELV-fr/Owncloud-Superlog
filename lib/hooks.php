<?php

class OC_SuperLog_Hooks{
	
	
	
	
	// Webapp Files	
	static public function write($path) {
		OC_SuperLog::log($path,NULL,'write');
	}
	static public function delete($path) {
		OC_SuperLog::log($path,NULL,'delete');
	}
	static public function rename($paths) {
		if(isset($_REQUEST['target'])){
			OC_SuperLog::log($paths['oldpath'],$paths['newpath'],'move');
		}
		else{
			OC_SuperLog::log($paths['oldpath'],$paths['newpath'],'rename');
		}		
	}
	static public function copy($paths) {
		OC_SuperLog::log($paths['oldpath'],$paths['newpath'],'copy');
	}
	
	
	// Users
	static public function login($vars) {
		OC_SuperLog::log('/','/','login');
	}
	static public function logout($vars) {
		OC_SuperLog::log('/','/','logout');
	}
	
	// Webdav
	static public function dav($vars) {
		OC_SuperLog::log('/','/','dav');
	}
	
	static public function all($vars) {
		$action='unknown';		
		$path=$vars;
		$protocol='web';
			
		if(isset($vars['SCRIPT_NAME']) && basename($vars['SCRIPT_NAME'])=='remote.php'){
			$pos=strpos($vars['REQUEST_URI'],'remote.php/webdav');
			if($pos==-1) return;
			
			$action=strtolower($vars['REQUEST_METHOD']);
			if($action=='put') $action='write';
			$path=urldecode(substr($vars['REQUEST_URI'],$pos+17));			
			$protocol='webdav';
		} 
		if(!in_array($action,array('head'))){
			OC_SuperLog::log($path,NULL,$action,$protocol);
		}		
		
	}
}

