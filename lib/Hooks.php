<?php

namespace OCA\Superlog;

class Hooks{
	// Webapp Files	
	static public function write($path) {
		Log::log($path,NULL,'write');
	}
	static public function delete($path) {
		Log::log($path,NULL,'delete');
	}
	static public function rename($paths) {
		if(isset($_REQUEST['target'])){
			Log::log($paths['oldpath'],$paths['newpath'],'move');
		}
		else{
			Log::log($paths['oldpath'],$paths['newpath'],'rename');
		}		
	}
	static public function copy($paths) {
		Log::log($paths['oldpath'],$paths['newpath'],'copy');
	}
	
	
	// Users
	static public function prelogin($vars) {
		Log::log($vars['uid'],'/','login attempt');
	}
	static public function login($vars) {
		Log::log('/','/','login');
	}
	static public function logout($vars) {
		Log::log('/','/','logout');
	}
	
	// Webdav
	static public function dav($vars) {
		Log::log('/','/','dav');
	}
	
	// Apps
	static public function app_enable($vars){
		Log::log($vars['app'],'','enable app');
	}
	static public function app_disable($vars){
		Log::log($vars['app'],'','disable app');
	}
	
	static public function all($vars) {
		$action='unknown';		
		$path=$vars;
		$protocol='web';
			
		if(isset($vars['SCRIPT_NAME']) && basename($vars['SCRIPT_NAME'])=='remote.php'){
			$paths=explode('/',$vars['REQUEST_URI']);
			$pos=array_search('remote.php',$paths);
			$protocol=$paths[$pos+1];
			$path='';
			for($i=$pos+2 ; $i<sizeof($paths) ; $i++){
				$path.='/'.$paths[$i];
			}
			
			$action=strtolower($vars['REQUEST_METHOD']);			
			
			if($protocol=='webdav'){	
				if($action=='put') $action='write';			
			}
			if($protocol=='carddav'){			
							
			}
			if($protocol=='caldav'){			
							
			}			
			
		} 
		if(!in_array($action,array('head'))){
			Log::log($path,NULL,$action,$protocol);
		}		
		
	}
}

