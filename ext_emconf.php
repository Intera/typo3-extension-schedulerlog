<?php
$EM_CONF[$_EXTKEY] = array(
	'title' => 'Scheduler log',
	'description' => 'Writes changes to scheduler tasks to the Backend log',
	'category' => 'be',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'author' => 'Alexander Stehlik',
	'author_email' => 'astehlik@intera.de',
	'author_company' => 'Intera GmbH',
	'version' => '1.0.0',
	'_md5_values_when_last_written' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2.3-7.99.99',
			'scheduler' => '',
		),
		'conflicts' => array(),
		'suggests' => array(),
	),
);
