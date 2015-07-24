<?php
namespace Tx\Schedulerlog;

/*                                                                        *
 * This script belongs to the TYPO3 Extension "schedulerlog".             *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\CMS\Scheduler\Controller\SchedulerModuleController;

/**
 * Adds logging to the scheduler backend module.
 */
class LoggingSchedulerModuleController extends SchedulerModuleController {

	/**
	 * Calls the parent save method and writes the data about the updated
	 * task to the Backend log.
	 */
	public function saveTask() {

		parent::saveTask();

		/**
		 * @var \TYPO3\CMS\Core\Authentication\BackendUserAuthentication $beUser
		 */
		$beUser = $GLOBALS['BE_USER'];
		if (!isset($beUser)) {
			return;
		}

		$action = $this->getAction();
		$recUid = $this->getSubmittedUidForLog();
		$details = 'Scheduler task was updated, Class: %s, UID: %s, Type: %s, Disable: %s';

		$data = array(
			$this->submittedData['class'],
			$this->getSubmittedUidForLog(),
			$this->getReadableTypeAndScheduleData(),
			$this->submittedData['disable']
		);

		$beUser->writelog(1, $action, 0, 0, $details, $data, 'tx_scheduler_task', $recUid);
	}

	/**
	 * Returns the action type:
	 * 1=new record, 2=update record
	 *
	 * @return int
	 */
	protected function getAction() {

		$action = 1;

		if (!empty($this->submittedData['uid'])) {
			$action = 2;
		}

		return $action;
	}

	/**
	 * Returns information about the type (on demand, recurring) and information
	 * about the schedule, depending on the type.
	 *
	 * @return string
	 */
	protected function getReadableTypeAndScheduleData() {

		$dateFormat = 'H:i d.m.Y';

		$start = intval($this->submittedData['start']);
		$start = $start ? date($dateFormat, $start) : '';

		if ($this->submittedData['type'] == 1) {
			$type = sprintf('OnDemand (%s)', $start);
		}
		else {
			$end = intval($this->submittedData['end']);
			$end = $end ? date($dateFormat, $end) : '';
			$recurringDetails = sprintf('Start: %s, Interval: %s, End: %s, Multiple: %s, CronCMD: %s', $start, $this->submittedData['interval'], $end, $this->submittedData['multiple'], $this->submittedData['croncmd']);
			$type = 'Recurring (' . $recurringDetails . ')';
		}

		return $type;
	}

	/**
	 * Returns the UID of the submitted record or zero if none was submitted.
	 *
	 * @return int
	 */
	protected function getSubmittedUidForLog() {

		$recUid = 0;

		if (!empty($this->submittedData['uid'])) {
			$recUid = $this->submittedData['uid'];
		}

		return $recUid;
	}
}