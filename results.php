<?php
require_once 'PerformanceMeasurementsDAL.php';

class Utils {
	public static function getBrowser($user_agent) {
		if (strstr($user_agent, 'Firefox')) {
			return 'Firefox';
		}
		if (strstr($user_agent, 'MSIE')) {
			return 'Internet Explorer';
		}
		if (strstr($user_agent, 'Chrome')) {
			return 'Chrome';
		}
	}
}

$DAL = new PerformanceMeasurementsDAL();

if (isset($_GET['json'])) {
	$data = file_get_contents("php://input");

	$data = json_decode($data);

	echo $DAL->addMeasurement($data->user_agent, $data->experiment, $data->timing);	
} else {
	$measurements = $DAL->getMeasurements();
	$html = '<table><tr><th>ID</th><th>User agent</th><th>navigationStart till responseEnd</th><th>responseEnd till loadStart</th></tr>';
	
	foreach ($measurements as $m) {
		$html .= '<tr><td>' . $m->measurementId . '</td><td>' . Utils::getBrowser($m->user_agent) . '</td><td>' . number_format(($m->responseEnd - $m->navigationStart) / 1000.0, 3, ',', '') .  '</td><td>' . number_format(($m->loadEventStart - $m->responseEnd) / 1000.0, 3, ',', '') . '</td></tr>';
	}

	$html .= '</table>';
	echo $html;
}