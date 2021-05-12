<?php

namespace App\Http\Controllers\Dashboard;

use \App\Http\Requests\Dashboard\Vehicle\RetrieveVehiclesRequest;
use \App\Models\Vehicle;
use Curl\Curl;

class VehicleController extends Controller
{
	private $carvana_api_url = 'https://apim.carvana.io/search-api/api/v1/search/search';
	private $default_search_parameters = array(
		'pagination' => array(
			'page' => 1,
			'pageSize' => 20,
		),
	);

	/**
	 * Pull Carvana's search results
	 * 
	 * @param $request 
	 * @return json response
	 */
	public function retrieveVehicles(RetrieveVehiclesRequest $request)
	{
		$page = 1;
		// Setup the page to pull... You can pass a page in the url to see a different page of results.
		if (!is_null($request->page)) {
			$page = intval($request->page);
		}

		// Retieve the desired page of vehical inventory and save all of them into the database
		$result = $this->save_carvana_vehicle_inventory($page);

		return response()->json(array(
			'status' => TRUE,
			'result' => $result,
			'success' => TRUE
		));
	}

	/**
	 * Fetch a single page of vehicles from carvana
	 * 
	 * @param int $page_id the page id to pull
	 * @return an array of vehicle records
	 */
	private function fetch_carvana_inventory_by_page(int $page_id): array
	{
		// Setup a new curl request
		$curl = new Curl();

		// Set the headers for the curl
		$curl->setHeaders(array(
			'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:88.0) Gecko/20100101 Firefox/88.0',
			'Accept' => '*/*',
			'Accept-Language' => 'en-US,en;q=0.5',
			'Content-Type' => 'application/json',
			'Origin' => 'https://www.carvana.com',
			'Connection' => 'keep-alive',
			'Referer' => 'https://www.carvana.com/',
			'Pragma' => 'no-cache',
			'Cache-Control' => 'no-cache',
		));

		// Submit the post request with the page_id that is passed to this function
		$curl->post($this->carvana_api_url, array_merge($this->default_search_parameters, array(
			'pagination' => array(
				'page' => $page_id
			)
		)));

		// Setup an empty array of vehicles
		$response = array();

		// If an error occures while curling display the error
		if ($curl->error) {
			echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . PHP_EOL;
			print_r($curl);
		} else {
			// Set the response to the vehicles that were found in the inventory response
			if (isset($curl->response) && isset($curl->response->inventory) && isset($curl->response->inventory->vehicles)) {
				$response = $curl->response->inventory->vehicles;
			} else {
				echo 'Error: curl response is invalid';
				print_r($curl);
			}
		}

		// Manual clean up.
		$curl->close();

		// Return the response array of vehicles. If the array is empty then something went wrong.
		return $response;
	}

	/**
	 * Persist a single vehicle record to the database
	 * 
	 * Since the interview test askes for this function to return a boolean 
	 * the vehicle found or created is stored in a temporary class variable 
	 * called "last_vehicle_from_save"
	 * 
	 * @param array $vehicle
	 * @return a boolean indicating success or failure
	 */
	private function save_carvana_inventory(array $vehicle)
	{
		// firstOrCreate:: checks and verifis that a vehicle has not been created 
		// by doing a select statement on the vehicle_id
		// if none exists then a new record is entered with the merger of the first 
		// and second arrays

		$vehicle = Vehicle::firstOrCreate(array(
			'vehicle_id' => $vehicle['vehicleId']
		), array(
			'make' => $vehicle['make'],
			'mileage' => $vehicle['mileage'],
			'model' => $vehicle['model'],
			'price' => $vehicle['price']['total'],
			'vehicle_id' => $vehicle['vehicleId'],
			'vin' => $vehicle['vin']
		));

		// Temporarily save this vehicle in the class to be used later on
		//$this->last_vehicle_from_save = $vehicle;

		// Determine if the vehicle was recently created ie. entered into the database
		// If true: this is a new vehicle else this vehicle already exists
		return $vehicle;//->wasRecentlyCreated;
	}

	/**
	 * Retrieve, loop through, and save all vehicles given a page id
	 * 
	 * @param int $page_id id of the page that will be looked at
	 * @return array/object of a success / failure if all vehicles have been saved into the database
	 */
	private function save_carvana_vehicle_inventory(int $page_id = 1): array
	{
		// Setup a results array to be displayed at the end
		$result = array(
			'existing_vehicles_found' => array(),
			'message' => '',
			'new_vehicles_added' => array(),
			'success' => FALSE
		);
		// Set a flag to determine if there are all new vehicles.
		$new_vehicles_found = FALSE;

		// Loop through the results of the fetch_carvana_inventory_by_page to save the individual vehicle
		foreach ($this->fetch_carvana_inventory_by_page($page_id) as $_vehicle) {

			// Since the scope of the project requires the _vehicle object to an array convert it to one
			$_vehicle = json_decode(json_encode($_vehicle), TRUE);

			// Save the vehicle in the database using the save_carvana_inventory function
			$new_vehicle = $this->save_carvana_inventory($_vehicle);

			// Determine if the vehicle has been saved into the database
			if (!$new_vehicle->wasRecentlyCreated) {
				// Keep track of the existing vehicles
				$result['existing_vehicles_found'][] = $new_vehicle;
			} else {
				$new_vehicles_found = TRUE;
				// Keep track of the new vehicles as well
				$result['new_vehicles_added'][] = $new_vehicle;
			}
		}
		// If there are any already saved vehicles then we consider this an unsuccessful pull and display that in the message
		if (!$new_vehicles_found) {
			$result['message'] = 'No new vehicles were found';
		} else {
			$result['message'] = 'New vehicles were added to the database';
			$result['success'] = TRUE;
		}

		// Return the results
		return $result;
	}
}
