<?php

class PerformanceMeasurementsDAL {
    private $database;
    
    public function __construct() {
        $this->database = new PDO('sqlite:Measurements.sqlite');
        $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $measurementsTableQuery = 'CREATE TABLE IF NOT EXISTS Measurement (measurementId INTEGER PRIMARY KEY, user_agent TEXT, experiment TEXT, connectEnd INTEGER, connectStart INTEGER, domComplete INTEGER, domContentLoadedEventEnd INTEGER, domContentLoadedEventStart INTEGER, domInteractive INTEGER, domLoading INTEGER, domainLookupEnd INTEGER, domainLookupStart INTEGER, fetchStart INTEGER, loadEventEnd INTEGER, loadEventStart INTEGER, navigationStart INTEGER, redirectEnd INTEGER, redirectStart INTEGER, requestStart INTEGER, responseEnd INTEGER, responseStart INTEGER, unloadEventEnd INTEGER, unloadEventStart INTEGER)';
        $st = $this->database->prepare($measurementsTableQuery);
        $st->execute();
    }

    public function addMeasurement($userAgent, $experiment, $measurement) {
        $query = 'INSERT INTO Measurement (user_agent, experiment, connectEnd, connectStart, domComplete, domContentLoadedEventEnd, domContentLoadedEventStart, domInteractive, domLoading, domainLookupEnd, domainLookupStart, fetchStart, loadEventEnd, loadEventStart, navigationStart, redirectEnd, redirectStart, requestStart, responseEnd, responseStart, unloadEventEnd, unloadEventStart) VALUES(:user_agent, :experiment, :connectEnd, :connectStart, :domComplete, :domContentLoadedEventEnd, :domContentLoadedEventStart, :domInteractive, :domLoading, :domainLookupEnd, :domainLookupStart, :fetchStart, :loadEventEnd, :loadEventStart, :navigationStart, :redirectEnd, :redirectStart, :requestStart, :responseEnd, :responseStart, :unloadEventEnd, :unloadEventStart)';
        $stmt = $this->database->prepare($query);
        $stmt->BindParam(':user_agent', $userAgent, PDO::PARAM_STR);
        $stmt->BindParam(':experiment', $experiment, PDO::PARAM_STR);
        $stmt->BindParam(':connectEnd', $measurement->connectEnd, PDO::PARAM_STR);
		$stmt->BindParam(':connectStart', $measurement->connectStart, PDO::PARAM_STR);
		$stmt->BindParam(':domComplete', $measurement->domComplete, PDO::PARAM_STR);
		$stmt->BindParam(':domContentLoadedEventEnd', $measurement->domContentLoadedEventEnd, PDO::PARAM_STR);
		$stmt->BindParam(':domContentLoadedEventStart', $measurement->domContentLoadedEventStart, PDO::PARAM_STR);
		$stmt->BindParam(':domInteractive', $measurement->domInteractive, PDO::PARAM_STR);
		$stmt->BindParam(':domLoading', $measurement->domLoading, PDO::PARAM_STR);
		$stmt->BindParam(':domainLookupEnd', $measurement->domainLookupEnd, PDO::PARAM_STR);
		$stmt->BindParam(':domainLookupStart', $measurement->domainLookupStart, PDO::PARAM_STR);
		$stmt->BindParam(':fetchStart', $measurement->fetchStart, PDO::PARAM_STR);
		$stmt->BindParam(':loadEventEnd', $measurement->loadEventEnd, PDO::PARAM_STR);
		$stmt->BindParam(':loadEventStart', $measurement->loadEventStart, PDO::PARAM_STR);
		$stmt->BindParam(':navigationStart', $measurement->navigationStart, PDO::PARAM_STR);
		$stmt->BindParam(':redirectEnd', $measurement->redirectEnd, PDO::PARAM_STR);
		$stmt->BindParam(':redirectStart', $measurement->redirectStart, PDO::PARAM_STR);
		$stmt->BindParam(':requestStart', $measurement->requestStart, PDO::PARAM_STR);
		$stmt->BindParam(':responseEnd', $measurement->responseEnd, PDO::PARAM_STR);
		$stmt->BindParam(':responseStart', $measurement->responseStart, PDO::PARAM_STR);
		$stmt->BindParam(':unloadEventEnd', $measurement->unloadEventEnd, PDO::PARAM_STR);
		$stmt->BindParam(':unloadEventStart', $measurement->unloadEventStart, PDO::PARAM_STR);
        $success = $stmt->execute();
            
        if($success) {
            //$id = $this->database->lastInsertId('producerId');
            //$producer->producerId = $id;
            return "success";
        }
        return "failure";
    }

    public function getProducer($id, $fields = null) {
        if (is_int($id) && $id > 0) {
            $producer = null;
            $producers = $this->getProducers($id, $fields);
            if (isset($producers[0])) {
                $producer = $producers[0];
            }
            
            return $producer;
        }
    }
    
    public function getMeasurements() {
        $query = 'SELECT measurementId, user_agent, experiment, connectEnd, connectStart, domComplete, domContentLoadedEventEnd, domContentLoadedEventStart, domInteractive, domLoading, domainLookupEnd, domainLookupStart, fetchStart, loadEventEnd, loadEventStart, navigationStart, redirectEnd, redirectStart, requestStart, responseEnd, responseStart, unloadEventEnd, unloadEventStart FROM Measurement ORDER BY experiment, user_agent';
        $stmt = $this->database->prepare($query);
        
        $stmt->execute();
        $producer;
        $measurements = array();        
           
        while ($measurement = $stmt->fetchObject()) {         
            $measurements[] = $measurement;
        }
        
        return $measurements;
    }
}