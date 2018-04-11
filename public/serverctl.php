<?php

$type = $_GET['type'];

switch ($type) {
    case 'log':
		getLog();
		break;

    case 'restart':
		restartServer();
		break;
}

function getLog() {
	$dir = '/var/source/7d2d/7DaysToDieServer_Data/';
	exec('ls '. $dir, $dirRet);
	
	$newestLog = '';
	$newestTime = 0;
	foreach ($dirRet as $file) {
		if (preg_match('/^output_log__([0-9]{4})-([0-9]{2})-([0-9]{2})__([0-9]{2})-([0-9]{2})-([0-9]{2})\.txt$/', $file, $ret)) {
			$currentTime = mktime($ret[4], $ret[5], $ret[6], $ret[2], $ret[3], $ret[1]);
			if ($newestTime < $currentTime) {
				$newestTime = $currentTime;
				$newestLog = $ret[0];
			}
		}
	}
	
	exec('tail -n 80 '. $dir. $newestLog, $logRet);
	
	echo json_encode($logRet);
}

function restartServer() {
	$restartScript = '/var/source/7d2d/restartserver.sh';
	
	exec('sh '. $restartScript, $restartRet);

	$ret = array('status' => 1);
	echo json_encode($ret);
}
