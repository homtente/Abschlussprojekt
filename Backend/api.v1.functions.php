<?php
// Impot der Klasse API Functions
include_once "inc/class.api.functions.php";


// Vererbung der Klasse API Functions zu qsauditFunctionsv1
class qsauditFunctionsV1 extends ApiFunctions
{

	// Initialisierung der URL für die Autark API
	private string $url;

	// Construct function für URL Wert aus conf.autark.logis.api.php
	public function __construct()
	{
		$this->url = AUTARK_AUTADES_API;
	}

	// Funktion zum Filtern des JSON aus der Autark API, um nur Schraubwerte zu erhalten
	public function filter_for_screwdata($result) {
		
		$stations = [
			"L2-120.1",
			"L2-121.1",
			"L2-150.1",
			"L2-211.1",
			"L2-220.1",
			"L2-240.1",
			"L2-261.2",
			"L2-280.2",
			"L2-290.1",
			"L2-310.3",
			"L2-360.1",
			"L2-410.1",
			"L2-411.1",
			"L2-440.2",
			"L2-460.2",
		];

		// Initialisierung eines leeren Arrays für Ergebnisse aus Filterung
		$result_filtered = [

		];
		$arbeitsfolgen = [
			"LastDrehmoment",
			"LastDrehmomentMax",
			"LastDrehmomentMin",
			"LastDrehwinkel",
			"LastDrehwinkelMax",
			"LastDrehwinkelMin",
			"LastSchwellmoment",
			"FirstDrehmoment",
			"FirstDrehwinkel",
			"FirstSchwellmoment",
		];

    // Durchlaufe jedes Element im "payload"-Array
	// erstes data objekt unter payload
		foreach ($result as $item) {
			// wenn "name": von data in array
			if (isset($item->data->name) && in_array($item->data->name, $stations) && (isset($item->children))) {
				
				// Druchlaufe Children der Stationen -> Bereiche 
				foreach ($item->children as $item2) {
					// Bereiche haben mehrere Arbeitsfolgen Item3 Objekt = Eine Arbeitsfolge
					foreach ($item2->children as $item3) {
						
						// Wenn Bereich->Arbeitsfolge enthalten im Array Arbeitsfolgen
						if (in_array($item3->data->beschreibung, $arbeitsfolgen)) {
							
							// Füge in Resultfilterd die  Station, den Bereich, die Arbeitsfolge mit Schraubdaten zusammen
							$result_filtered[$item->data->name][$item2->data->bereich][$item3->data->beschreibung] = $item3->data->pid1;
						}

						
					}
				}
			}
		}

		// Rückgabe von Ergebnis Array
		return $result_filtered;
	}

	// Funktion für Filterung der Abwahlen
	public function filter_for_workerInterventions($result) {

		$searched_stations = [
			"L2-800",
			"L2-801",
			"L2-802",
			"L2-803",
			"L2-804",
			"L2-805",
			"L2-010.1",
			"L2-020.1",
			"L2-030.1",
			"L2-051.1/052.1",
			"L2-080.2",
			"L2-055.1",
			"L2-030.2",
			"L2-082.1",
			"L2-082.2",
			"L2-040.1",
			"L2-040.2",
			"L2-050.1",
			"L2-060.1",
			"L2-070.1",
			"L2-070.2",
			"L2-080.3",
			"L2-080.1",
			"L2-090.1",
			"L2-100.1",
			"L2-110.7",
			"L2-110.1",
			"L2-110.2",
			"L2-120.1",
			"L2-121.1",
			"L2-140.1",
			"L2-130.8",
			"L2-140.7",
			"L2-140.2",
			"L2-150.1",
			"L2-150.1",
			"L2-160.1",
			"L2-161.1",
			"L2-170.1",
			"L2-171.1",
			"L2-180.1",
			"L2-190.1",
			"L2-210.1",
			"L2-211.1",
			"L2-212.2",
			"L2-220.1",
			"L2-230.1",
			"L2-230.2",
			"L2-240.1",
			"L2-250.1",
			"L2-260.1",
			"L2-261.1",
			"L2-261.2",
			"L2-270.2",
			"L2-280.1",
			"L2-280.2",
			"L2-290.1",
			"L2-290.2",
			"L2-300.1",
			"L2-310.2",
			"L2-310.3",
			"L2-340.1",
			"L2-340.2",
			"L2-340.3",
			"L2-350.1",
			"L2-360.1",
			"L2-370.1",
			"L2-371.1",
			"L2-372.1",
			"L2-370.1",
			"L2-371.1",
			"L2-372.1",
			"L2-390.1",
			"L2-400.1",
			"L2-410.1",
			"L2-410.1",
			"L2-411.1",
			"L2-420.1",
			"L2-421.1",
			"L2-422.2",
			"L2-430.1",
			"L2-440.1",
			"L2-440.2",
			"L2-440.2",
			"L2-450.1",
			"L2-451.1",
			"L2-452.1",
			"L2-460.1",
			"L2-460.2",
			"L2-460.3",
			"L2-490.1",
			"L2-490.2",
			"L2-490.2",
			"L2-500.1",
			"L2-510.1",
			"L2-520.1",
			"L2-522.1",
			"L2-530.1",
			"L2-53x.x",
			"L2-531.2",
			"L2-540.1",
			"L2-541.1",
			"L2-540.1",
			"L2-541.1",
			"L2-550.1",
			"L2-570.1",
			"L2-590.1",
			"L2-591.1",
			"L2-610.1",
			"L2-611.1",
			"L2-612.2",
			"L2-620.1"
		];
		
	
		$results_filterd = [

		];


		// Gehe in  obejct stations und durchlaufe jeden Eintrag
		foreach ($result->stations as $item) {
			// Prüfe ob Station workerinterventions hat und ob es im array der gesuchten Maschinen ist
			if (in_array($item->station, $searched_stations)) {

				
				foreach ($item->stationState as $stationState) {

					foreach ($stationState->workerInterventions as $interventions) {

						$results_filterd[$item->station] = $interventions;
					}
				
				}
			}
		}
		return $results_filterd;
	}

	// Funktion um Schraubdatenvergleich zu machen
	public function validate_screw_data($screw_data) {

		$result_validate_screw_data = [

		];

		// Gehe in jede Station 
		foreach ($screw_data as $key_station => $value) {
			
			// für jede Arbeitsfolge einer Station
			foreach ($value as $key_workseq => $screw_ints) {

				// Vergleich der Attribute in jeder Arbeitsfolge
				if ($screw_ints->LastDrehmoment >= $screw_ints->LastDrehmomentMin && $screw_ints->LastDrehmoment <= $screw_ints->LastDrehmomentMax) {
					
					$result_validate_screw_data[$key_station][$key_workseq]["Ergebnis_Schraubabgleich"] = true;
					
				} else {

					$result_validate_screw_data[$key_station][$key_workseq]["Ergebnis_Schraubabgleich"] = false;
				}
			}
		}
	
		return $result_validate_screw_data;
	}

	public function check_for_interventions($interventions) {

		$results_interventions = [

		];

		foreach ($interventions as $key_station => $values) {



			foreach ($values as $value) {

				foreach($value as $object) {

					// Wenn Interventions True ist füge hinzu
					if ($object->state) {
						$results_interventions[$key_station][$object->name]["Abwahlen"] = $object->state;
					}
		
					// elseif ($object->state == false) {
						// $results_interventions[$key_station][$object->name]["Abwahlen"] = $object->state;
					// }
				}
			}
		}
	}
	// Get Function, endpoint Parameter in endpoint.configuration festgelegt
	private function get_function($endpoint, $params) {
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json'
		);
		
		$fullURL = $this->url . $endpoint . "?" . http_build_query($params);
		
		$ch = curl_init();


		// Eigenschaften für Curl festlegen
		curl_setopt($ch, CURLOPT_URL, $fullURL);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 35);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		
		$result = curl_exec($ch);
		$responseCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
		
		
		curl_close($ch);

		return json_decode($result);
	}

	public function autadesapi_overview() {
		$endpoint = "productionOverview";
		
		if (!($pId = $this->getStringValue("pId"))) {
			return $this->errorApiCallParameter("pId");
		}
		$params = [
			'pId' => $pId,
		];
	
		$result = $this->get_function($endpoint, $params);

		$mes = new stdClass();
		$mes->success = true;
		$mes->parameter = $params;
		$mes->payload = $result[0]->DMCs;

		$this->outputJSONContent($mes);
	}

	public function autadesapi_Protocol() {
		$endpoint = "productionProtocol/stationstate";

		
		if (!($serialNumber = $this->getStringValue("serialNumber"))) {
			return $this->errorApiCallParameter("serialNumber");
		}

		$params = [
			'serialNumber' => $serialNumber,
		];


		$result = $this->get_function($endpoint, $params);

		$result = $this->filter_for_workerInterventions($result);

		$result = $this->check_for_interventions($result);
		
		$mes = new stdClass();
		$mes->success = true;
		$mes->parameter = $params;
		$mes->payload = $result;

	
		$this->outputJSONContent($mes);
	}

//  Funktion um pidComparison abzurufen beinhaltet
	public function autadesapi_pidComparison_protocol() {
		$endpoint = "pidComparison";

		
		if (!($Pids = $this->getStringValue("Pids"))) {
			return $this->errorApiCallParameter("Pids");
		}

		$params = [
			'Pids' => $Pids,
		];

		$result = $this->get_function($endpoint, $params);
		
		$result = $this->filter_for_screwdata($result);

		$screw_result = $this->validate_screw_data($result);

		$mes = new stdClass();
		$mes->success = true;
		$mes->parameter = $params;
		$mes->payload = $screw_result;
		
		$this->outputJSONContent($mes);
	}


}