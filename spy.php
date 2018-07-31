<?php
require_once 'apps/superlog/lib/log.php';
require_once 'apps/superlog/lib/hooks.php';
\OCA\Superlog\Hooks::all($_SERVER);
