<?php
$tmpl = new OC_Template('superlog', 'settings');
$tmpl->assign('superlog_lifetime', OC::$server->getConfig()->getAppValue('superlog', 'superlog_lifetime','2'));

return $tmpl->fetchPage();
