<?php

use Tx\Schedulerlog\LoggingSchedulerModuleController;
use TYPO3\CMS\Scheduler\Controller\SchedulerModuleController;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][SchedulerModuleController::class]['className']
	= LoggingSchedulerModuleController::class;
