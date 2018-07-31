<?php

/**
* ownCloud - MailNotify Plugin
*
* @author Bastien Ho
* @copyleft 2013 bastienho@eelv.fr
* 
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
* License as published by the Free Software Foundation; either 
* version 3 of the License, or any later version.
* 
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU AFFERO GENERAL PUBLIC LICENSE for more details.
*  
* 
*/

OCP\Util::addStyle('superlog', 'superlog');
OCP\Util::addScript('superlog', 'superlog');

OCP\App::registerAdmin('superlog','settings');
//OCP\App::registerPersonal('superlog', 'settings');

\OC::$server->getEventDispatcher()->addListener(\OCP\App\ManagerEvent::EVENT_APP_ENABLE, function (\OCP\App\ManagerEvent $event) {
    \OCA\Superlog\Log::log($event->getAppID(),'','enable app');
});

\OC::$server->getEventDispatcher()->addListener(\OCP\App\ManagerEvent::EVENT_APP_DISABLE, function (\OCP\App\ManagerEvent $event) {
    \OCA\Superlog\Log::log($event->getAppID(),'','disable app');
});

/* HOOKS */
// Users
OC_Hook::connect('OC_User', 'pre_login', \OCA\Superlog\Hooks::class, 'prelogin');
OC_Hook::connect('OC_User', 'post_login', \OCA\Superlog\Hooks::class, 'login');
OC_Hook::connect('OC_User', 'logout', \OCA\Superlog\Hooks::class, 'logout');

// Filesystem
OC_Hook::connect('OC_Filesystem', 'post_write', \OCA\Superlog\Hooks::class, 'write');
OC_Hook::connect('OC_Filesystem', 'post_delete', \OCA\Superlog\Hooks::class, 'delete');
OC_Hook::connect('OC_Filesystem', 'post_rename', \OCA\Superlog\Hooks::class, 'rename');
OC_Hook::connect('OC_Filesystem', 'post_copy', \OCA\Superlog\Hooks::class, 'copy');

OC_Hook::connect('\OC\Files\Storage\Shared', 'file_put_contents', \OCA\Superlog\Hooks::class, 'all');

// Cleanning settings
\OCP\BackgroundJob::addRegularTask(\OCA\Superlog\Log::class, 'clean');
if (isset($_POST['superlog_lifetime']) && is_numeric($_POST['superlog_lifetime'])) {
   OC::$server->getConfig()->setAppValue('superlog', 'superlog_lifetime', $_POST['superlog_lifetime']);
}

