<?php

defined('BASEPATH') OR exit('No direct script access allowed');



header('Access-Control-Allow-Origin: *');

function contains($needle, $haystack) {

	return strpos($haystack, $needle) !== false;

	 }



	class CyberOptApi extends CI_Controller {



		public function getJWTToken() {

			$url=$_SERVER['HTTP_REFERER'];

			if(contains("test",$url)){

				$curl = curl_init();



				$data = '{

					"login-email": "antonette@vanasekinsurance.com",

					"login-password": "VanaCare*2020",

					"login-remember": true

				}';



				curl_setopt_array($curl, array(

					CURLOPT_URL => "https://api.thecoalition.com/api/login",

					CURLOPT_RETURNTRANSFER => true,

					CURLOPT_ENCODING => "",

					CURLOPT_MAXREDIRS => 10,

					CURLOPT_TIMEOUT => 0,

					CURLOPT_FOLLOWLOCATION => true,

					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

					CURLOPT_CUSTOMREQUEST => "POST",

					CURLOPT_POSTFIELDS =>$data,

					CURLOPT_HTTPHEADER => array(

						"Content-Type: application/json",

						"Accept: application/json"

					),

				));



				$response = curl_exec($curl);



				

				if (!$response) {

					echo 'fail';

					return;

				}

				echo $response;

				curl_close($curl);



			}

			else{

				$curl = curl_init();



				$data = '{

					"login-email": "antonette@vanasekinsurance.com",

					"login-password": "VanaCare*2020",

					"login-remember": true

				}';



				curl_setopt_array($curl, array(

					CURLOPT_URL => "https://api.thecoalition.com/api/login",

					CURLOPT_RETURNTRANSFER => true,

					CURLOPT_ENCODING => "",

					CURLOPT_MAXREDIRS => 10,

					CURLOPT_TIMEOUT => 0,

					CURLOPT_FOLLOWLOCATION => true,

					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

					CURLOPT_CUSTOMREQUEST => "POST",

					CURLOPT_POSTFIELDS =>$data,

					CURLOPT_HTTPHEADER => array(

						"Content-Type: application/json",

						"Accept: application/json"

					),

				));



				$response = curl_exec($curl);



				curl_close($curl);

				if (!$response) {

					echo 'fail';

					return;

				}

				echo $response;



			}





		}



		public function encodeURI($url) {

			$unescaped = array(

				'%2D'=>'-','%5F'=>'_','%2E'=>'.','%21'=>'!', '%7E'=>'~',

				'%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')'

			);

			$reserved = array(

				'%3B'=>';','%2C'=>',','%2F'=>'/','%3F'=>'?','%3A'=>':',

				'%40'=>'@','%26'=>'&','%3D'=>'=','%2B'=>'+','%24'=>'$'

			);

			$score = array(

				'%23'=>'#'

			);

			return strtr(rawurlencode($url), array_merge($reserved,$unescaped,$score));



		}



		public function getIndustries() {

			if (!$this->input->post()) {

				return;

			}

			$token = $this->input->post('token');

			$industry = $this->input->post('industry');



			$url = "https://api.thecoalition.com/api/industries?search=".$industry;



			$curl = curl_init();



			curl_setopt_array($curl, array(

				CURLOPT_URL => $this->encodeURI($url),

				CURLOPT_RETURNTRANSFER => true,

				CURLOPT_ENCODING => "",

				CURLOPT_MAXREDIRS => 10,

				CURLOPT_TIMEOUT => 0,

				CURLOPT_FOLLOWLOCATION => true,

				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

				CURLOPT_CUSTOMREQUEST => "GET",

				CURLOPT_HTTPHEADER => array(

					"Content-Type: application/json",

					"Accept: application/json",

					"Authorization: Bearer ".$token

				),

			));



			$response = curl_exec($curl);



			curl_close($curl);



			if (!$response) {

				echo 'fail';

				return;

			}

			echo $response;



		}



		public function getAddress() {

			if (!$this->input->post()) {

				return;

			}

			$keyword = $this->input->post('keyword');



			$curl = curl_init();



			curl_setopt_array($curl, array(

				CURLOPT_URL => "https://maps.googleapis.com/maps/api/place/autocomplete/json?input=".$keyword."&types=establishment&key=AIzaSyCVsbH_wdEgmvtsD_-9Ai0IhrA54vC0Bzw",

				CURLOPT_RETURNTRANSFER => true,

				CURLOPT_ENCODING => "",

				CURLOPT_MAXREDIRS => 10,

				CURLOPT_TIMEOUT => 0,

				CURLOPT_FOLLOWLOCATION => true,

				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

				CURLOPT_CUSTOMREQUEST => "GET",

				CURLOPT_HTTPHEADER => array(

					"x-rapidapi-host: google-translate1.p.rapidapi.com",

					"x-rapidapi-key: d1ec636ac5msh35885a399298175p14f2e4jsn92997c76c589",

					"Content-Type: application/json"

				),

			));



			$response = curl_exec($curl);



			curl_close($curl);



			if (!$response) {

				echo 'fail';

				return;

			}



			$jsonData = json_decode($response);

			$predictions = $jsonData->predictions;

			$places = array();

			foreach ($predictions as $prediction) {

				$places[] = $prediction;

			}

			echo json_encode($places);

		}



		public function getSpecificAddress() {

			if (!$this->input->post()) {

				return;

			}

			$reference = $this->input->post('reference');



			$curl = curl_init();



			curl_setopt_array($curl, array(

				CURLOPT_URL => "https://maps.googleapis.com/maps/api/place/details/json?reference=".$reference."&sensor=true&key=AIzaSyCVsbH_wdEgmvtsD_-9Ai0IhrA54vC0Bzw",

				CURLOPT_RETURNTRANSFER => true,

				CURLOPT_ENCODING => "",

				CURLOPT_MAXREDIRS => 10,

				CURLOPT_TIMEOUT => 0,

				CURLOPT_FOLLOWLOCATION => true,

				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

				CURLOPT_CUSTOMREQUEST => "GET",

			));



			$response = curl_exec($curl);



			curl_close($curl);



			if (!$response) {

				echo 'fail';

				return;

			}

			$jsonData = json_decode($response);



			$address = $jsonData->result->address_components;



			$street_number = '';

			$street = '';

			$city = '';

			$state = '';

			$zip = '';

			foreach ($address as $record) {

				if (in_array('street_number', $record->types)) {

					$street_number = $record->long_name;

				}

				else if (in_array('route', $record->types)) {

					$street = $record->long_name;

				}

				else if (in_array('locality', $record->types)) {

					$city = $record->long_name;

				}

				else if (in_array('administrative_area_level_1', $record->types)) {

					$state = $record->short_name;

				}

				else if (in_array('postal_code', $record->types)) {

					$zip = $record->long_name;

				}

			}

			$data['street'] = $street_number ? $street_number . ' ' . $street : $street;

			$data['city'] = $city;

			$data['state'] = $state;

			$data['zip'] = $zip;

			echo json_encode($data);

		}



		public function getCurrentCyber() {

			if (!$this->input->post()) {

				return;

			}

			$email = $this->input->post('email');

			$data = $this->MCyber->getCurrentCyberData($email);

			echo json_encode($data);

		}



		public function setPackage() {



			if (!$this->input->post()) {

				return;

			}

			$email = $this->input->post('email');

			$token = $this->input->post('token');

			$company_name = $this->input->post('company_name');

			$domains = $this->input->post('domain_names');

			$domain_str_array = explode(',', $domains);

			$domain_array = array();

			foreach ($domain_str_array as $index=>$domain) {

				$domain_array[$index] = $domain;

			}

			$domain_names = json_encode($domain_array);



			$data = '{

				"company_name": "'.$company_name.'",

				"domain_names": '.$domain_names.',

				"insurance_market": "SURPLUS"

			}';



			$curl = curl_init();



			curl_setopt_array($curl, array(

				CURLOPT_URL => "https://api.thecoalition.com/api/packages",

				CURLOPT_RETURNTRANSFER => true,

				CURLOPT_VERBOSE=>true,

				CURLOPT_ENCODING => "",

				CURLOPT_MAXREDIRS => 10,

				CURLOPT_TIMEOUT => 0,

				CURLOPT_FOLLOWLOCATION => true,

				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

				CURLOPT_CUSTOMREQUEST => "POST",

				CURLOPT_POSTFIELDS =>$data,

				CURLOPT_HTTPHEADER => array(

					"Content-Type: application/json",

					"Accept: application/json",

					"Authorization: Bearer ".$token

				),

			));

			$response = curl_exec($curl);

			curl_close($curl);

			if (!$response || !strpos($response, 'uuid')) {

				echo 'fail';

				return;

			}

			echo $response;

			if ($email) {

				$this->MCyber->setCyberData($email, $company_name, $domain_names);

			}

		}



		public function updatePackage1() {

			if (!$this->input->post()) {

				return;

			}



			$email = $this->input->post('email');

			$token = $this->input->post('token');

			$uuid = $this->input->post('uuid');

			$industry_keyword = $this->input->post('industry_keyword');

			$company_revenue = $this->input->post('company_revenue');

			$company_employee_count = $this->input->post('company_employee_count');

			$company_employee_count = ($company_employee_count == '1001') ? '1001+' : $company_employee_count;

			$company_industry = $this->input->post('company_industry');

			$industry_num = $company_industry;



			$curl = curl_init();



			curl_setopt_array($curl, array(

				CURLOPT_URL => "https://api.thecoalition.com/api/industries/".$company_industry,

				CURLOPT_RETURNTRANSFER => true,

				CURLOPT_ENCODING => "",

				CURLOPT_MAXREDIRS => 10,

				CURLOPT_TIMEOUT => 0,

				CURLOPT_FOLLOWLOCATION => true,

				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

				CURLOPT_CUSTOMREQUEST => "GET",

				CURLOPT_HTTPHEADER => array(

					"Content-Type: application/json",

					"Accept: application/json",

					"Authorization: Bearer ".$token

				),

			));



			$response = curl_exec($curl);



			curl_close($curl);



			if (!$response || !strpos($response, 'display_name')) {

				echo 'fail';

				return;

			}

			$company_industry = $response;



			$data = '{

				"company_industry":'.$company_industry.',

				"company_revenue":'.$company_revenue.',

				"company_employee_count":"'.$company_employee_count.'",

				"company_gross_profit_net_revenue":null,

				"coverage_instances":{},

				"application_responses":{}

			}';



			$curl = curl_init();



			curl_setopt_array($curl, array(

				CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid,

				CURLOPT_RETURNTRANSFER => true,

				CURLOPT_ENCODING => "",

				CURLOPT_MAXREDIRS => 10,

				CURLOPT_TIMEOUT => 0,

				CURLOPT_FOLLOWLOCATION => true,

				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

				CURLOPT_CUSTOMREQUEST => "PATCH",

				CURLOPT_POSTFIELDS =>$data,

				CURLOPT_HTTPHEADER => array(

					"Content-Type: application/json",

					"Accept: application/json",

					"Authorization: Bearer ".$token

				),

			));



			$response = curl_exec($curl);



			curl_close($curl);



			if (!$response || !strpos($response, 'uuid')) {

				echo 'fail';

				return;

			}

			echo $response;



			if ($email) {

				$updateData = array('company_industry_keyword' => $industry_keyword, 'company_industry' => $industry_num, 'company_revenue' => $company_revenue, 'company_employee_count' => $company_employee_count);

				$this->MCyber->updateCyberData($email, $updateData);

			}

		}



		public function updatePackage2() {

			if (!$this->input->post()) {

				return;

			}



			$email = $this->input->post('email');

			$token = $this->input->post('token');

			$uuid = $this->input->post('uuid');



			$street_line_1 = $this->input->post('street_line_1');

			$city = $this->input->post('city');

			$state = $this->input->post('state');

			$postcode = $this->input->post('postcode');

			$street_line_2 = $this->input->post('street_line_2');



			if (!$street_line_2) {

				$street_line_2 = '';

			}



			$data = '{

				"company_address":{"street_line_1":"'.$street_line_1.'","street_line_2":"'.$street_line_2.'","city":"'.$city.'","state":"'.$state.'","postcode":"'.$postcode.'"}

			}';



			$curl = curl_init();



			curl_setopt_array($curl, array(

				CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid,

				CURLOPT_RETURNTRANSFER => true,

				CURLOPT_ENCODING => "",

				CURLOPT_MAXREDIRS => 10,

				CURLOPT_TIMEOUT => 0,

				CURLOPT_FOLLOWLOCATION => true,

				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

				CURLOPT_CUSTOMREQUEST => "PATCH",

				CURLOPT_POSTFIELDS =>$data,

				CURLOPT_HTTPHEADER => array(

					"Content-Type: application/json",

					"Accept: application/json",

					"Authorization: Bearer ".$token

				),

			));



			$response = curl_exec($curl);



			curl_close($curl);



			if (!$response || !strpos($response, 'uuid')) {

				echo 'fail';

				return;

			}

			echo $response;



			if ($email) {

				$updateData = array('street_line_1' => $street_line_1, 'street_line_2' => $street_line_2, 'city' => $city, 'state' => $state, 'postcode' => $postcode);

				$this->MCyber->updateCyberData($email, $updateData);

			}

		}



		public function updatePackage_TechEo_Optional() {

			if (!$this->input->post()) {

				return;

			}



			$token = $this->input->post('token');

			$uuid = $this->input->post('uuid');



			$has_tech_eo = $this->input->post('has_tech_eo');

			$wants_tech_eo = $this->input->post('wants_tech_eo');



			$mitigating_clauses = $this->input->post('mitigating_clauses');

			$tech_eo_dispute = $this->input->post('tech_eo_dispute');

			$tech_eo_dispute_explanation = $this->input->post('tech_eo_dispute_explanation');

			$is_msp_or_bad_industry = $this->input->post('is_msp_or_bad_industry');

			$professional_services = $this->input->post('professional_services');

			$services_by_contract = $this->input->post('services_by_contract');



			$curl = curl_init();



			curl_setopt_array($curl, array(

				CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid,

				CURLOPT_RETURNTRANSFER => true,

				CURLOPT_ENCODING => "",

				CURLOPT_MAXREDIRS => 10,

				CURLOPT_TIMEOUT => 0,

				CURLOPT_FOLLOWLOCATION => true,

				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

				CURLOPT_CUSTOMREQUEST => "GET",

				CURLOPT_HTTPHEADER => array(

					"Content-Type: application/json",

					"Accept: application/json",

					"Authorization: Bearer ".$token

				),

			));



			$response = curl_exec($curl);



			curl_close($curl);



			if (!$response || !strpos($response, 'uuid')) {

				echo 'fail';

				return;

			}

			$res_package = json_decode($response);

			$packageData = $res_package->application_responses;



			$data = '{

				"application_responses":{"prior_claims":"'.$packageData->prior_claims.'"';

				if (isset($packageData->prior_claims_explanation)) {

					$data .= ',"prior_claims_explanation":"'.$packageData->prior_claims_explanation.'"';

				}

				if ($packageData->aware_of_new_claims) {

					$data .= ',"aware_of_new_claims":"'.$packageData->aware_of_new_claims.'"';

				}

				if (isset($packageData->aware_of_new_claims_explanation)) {

					$data .= ',"aware_of_new_claims_explanation":"'.$packageData->aware_of_new_claims_explanation.'"';

				}

				if ($packageData->encrypts_data) {

					$data .= ',"encrypts_data":"'.$packageData->encrypts_data.'"';

				}

				if ($packageData->pii_phi) {

					$data .= ',"pii_phi":"'.$packageData->pii_phi.'"';

				}

				if (isset($packageData->pii_phi_count)) {

					$data .= ',"pii_phi_count":"'.$packageData->pii_phi_count.'"';

				}

				if (isset($packageData->cc_customer_count)) {

					$data .= ',"cc_customer_count":"'.$packageData->cc_customer_count.'"';

				}

				if (isset($packageData->backup_and_restore)) {

					$data .= ',"backup_and_restore":"'.$packageData->backup_and_restore.'"';

				}

				if (isset($packageData->content_complaints)) {

					$data .= ',"content_complaints":"'.$packageData->content_complaints.'"';

				}

				if (isset($packageData->dual_control)) {

					$data .= ',"dual_control":"'.$packageData->dual_control.'"';

				}

				if (isset($packageData->reviews_content)) {

					$data .= ',"reviews_content":"'.$packageData->reviews_content.'"';

				}

				$data .= ',"has_tech_eo":"'.$has_tech_eo.'"';

				$data .= ',"wants_tech_eo":"'.$wants_tech_eo.'"';

				if ($tech_eo_dispute) {

					$data .= ',"tech_eo_dispute":"'.$tech_eo_dispute.'"';

				}

				if ($tech_eo_dispute_explanation) {

					$data .= ',"tech_eo_dispute_explanation":"'.$tech_eo_dispute_explanation.'"';

				}

				if ($is_msp_or_bad_industry) {

					$data .= ',"is_msp_or_bad_industry":"'.$is_msp_or_bad_industry.'"';

				}

				if ($professional_services) {

					$data .= ',"professional_services":"'.$professional_services.'"';

				}

				if ($services_by_contract) {

					$data .= ',"services_by_contract":"'.$services_by_contract.'"';

				}

				if ($mitigating_clauses) {

			// {"CUSTOMER_SIGN_OFF":false,"DISCLAIMER_OF_WARRANTIES":false,"HOLD_HARMLESS_AGREEMENTS":true,"LIMITATION_OF_LIABILITY":false,"EXCLUSION_OF_DAMAGES":true,"INDEMNIFICATION":false,"BINDING_ARBITRATION":false,"MILESTONES":false}

					$mitigating_array = explode(',', $mitigating_clauses);

					$data .= ',"mitigating_clauses":{"CUSTOMER_SIGN_OFF":';

					if (in_array('CUSTOMER_SIGN_OFF', $mitigating_array)) {

						$data .= 'true';

					}

					else {

						$data .= 'false';

					}

					$data .= ',"DISCLAIMER_OF_WARRANTIES":';

					if (in_array('DISCLAIMER_OF_WARRANTIES', $mitigating_array)) {

						$data .= 'true';

					}

					else {

						$data .= 'false';

					}

					$data .= ',"HOLD_HARMLESS_AGREEMENTS":';

					if (in_array('HOLD_HARMLESS_AGREEMENTS', $mitigating_array)) {

						$data .= 'true';

					}

					else {

						$data .= 'false';

					}

					$data .= ',"LIMITATION_OF_LIABILITY":';

					if (in_array('LIMITATION_OF_LIABILITY', $mitigating_array)) {

						$data .= 'true';

					}

					else {

						$data .= 'false';

					}

					$data .= ',"EXCLUSION_OF_DAMAGES":';

					if (in_array('EXCLUSION_OF_DAMAGES', $mitigating_array)) {

						$data .= 'true';

					}

					else {

						$data .= 'false';

					}

					$data .= ',"INDEMNIFICATION":';

					if (in_array('INDEMNIFICATION', $mitigating_array)) {

						$data .= 'true';

					}

					else {

						$data .= 'false';

					}

					$data .= ',"BINDING_ARBITRATION":';

					if (in_array('BINDING_ARBITRATION', $mitigating_array)) {

						$data .= 'true';

					}

					else {

						$data .= 'false';

					}

					$data .= ',"MILESTONES":';

					if (in_array('MILESTONES', $mitigating_array)) {

						$data .= 'true';

					}

					else {

						$data .= 'false';

					}



					$data .= '}';

				}

				$data .= '}';

				$data .= '}';



				$curl = curl_init();



				curl_setopt_array($curl, array(

					CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid,

					CURLOPT_RETURNTRANSFER => true,

					CURLOPT_ENCODING => "",

					CURLOPT_MAXREDIRS => 10,

					CURLOPT_TIMEOUT => 0,

					CURLOPT_FOLLOWLOCATION => true,

					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

					CURLOPT_CUSTOMREQUEST => "PATCH",

					CURLOPT_POSTFIELDS =>$data,

					CURLOPT_HTTPHEADER => array(

						"Content-Type: application/json",

						"Accept: application/json",

						"Authorization: Bearer ".$token

					),

				));



				$response = curl_exec($curl);



				curl_close($curl);



				if (!$response || !strpos($response, 'uuid')) {

					echo 'fail';

					return;

				}

				echo $response;

			}



			public function updatePackage_Question() {

				if (!$this->input->post()) {

					return;

				}



				$email = $this->input->post('email');

				$token = $this->input->post('token');

				$uuid = $this->input->post('uuid');

				$prior_claims = $this->input->post('prior_claims');

				$prior_claims = $prior_claims ? 'Yes' : 'No';

				$prior_claims_explanation = $this->input->post('prior_claims_explanation');



				$aware_of_new_claims = 'No';

				$aware_of_new_claims_explanation = '';



				$encrypts_data = 'Yes';



				$pii_phi = 'Yes';

				$pii_phi_count = '<100,000';

				$cc_customer_count = '<100,000';



				$has_tech_eo = $this->input->post('has_tech_eo');

				$wants_tech_eo = $this->input->post('wants_tech_eo');



				$mitigating_clauses = $this->input->post('mitigating_clauses');

				$tech_eo_dispute = $this->input->post('tech_eo_dispute');

				$tech_eo_dispute_explanation = $this->input->post('tech_eo_dispute_explanation');

				$is_msp_or_bad_industry = $this->input->post('is_msp_or_bad_industry');

				$professional_services = $this->input->post('professional_services');

				$services_by_contract = $this->input->post('services_by_contract');

				$coverage_instances = $this->input->post('coverage_instances');



				$data = '{

					"application_responses":{"prior_claims":"'.$prior_claims.'"';

					if ($prior_claims_explanation) {

						$data .= ',"prior_claims_explanation":"'.$prior_claims_explanation.'"';

					}

					if ($aware_of_new_claims) {

						$data .= ',"aware_of_new_claims":"'.$aware_of_new_claims.'"';

					}

		// if ($aware_of_new_claims_explanation) {

		//     $data .= ',"aware_of_new_claims_explanation":"'.$aware_of_new_claims_explanation.'"';

		// }

					if ($encrypts_data) {

						$data .= ',"encrypts_data":"'.$encrypts_data.'"';

					}

					if ($pii_phi) {

						$data .= ',"pii_phi":"'.$pii_phi.'"';

					}

					if ($pii_phi_count) {

						$data .= ',"pii_phi_count":"'.$pii_phi_count.'"';

					}

					if ($cc_customer_count) {

						$data .= ',"cc_customer_count":"'.$cc_customer_count.'"';

					}

					if ($has_tech_eo) {

						$data .= ',"has_tech_eo":"'.$has_tech_eo.'"';

					}

					if ($wants_tech_eo) {

						$data .= ',"wants_tech_eo":"'.$wants_tech_eo.'"';

					}

					if ($tech_eo_dispute) {

						$data .= ',"tech_eo_dispute":"'.$tech_eo_dispute.'"';

					}

					if ($tech_eo_dispute_explanation) {

						$data .= ',"tech_eo_dispute_explanation":"'.$tech_eo_dispute_explanation.'"';

					}

					if ($is_msp_or_bad_industry) {

						$data .= ',"is_msp_or_bad_industry":"'.$is_msp_or_bad_industry.'"';

					}

					if ($professional_services) {

						$data .= ',"professional_services":"'.$professional_services.'"';

					}

					if ($services_by_contract) {

						$data .= ',"services_by_contract":"'.$services_by_contract.'"';

					}

					if ($mitigating_clauses) {

			// {"CUSTOMER_SIGN_OFF":false,"DISCLAIMER_OF_WARRANTIES":false,"HOLD_HARMLESS_AGREEMENTS":true,"LIMITATION_OF_LIABILITY":false,"EXCLUSION_OF_DAMAGES":true,"INDEMNIFICATION":false,"BINDING_ARBITRATION":false,"MILESTONES":false}

						$mitigating_array = explode(',', $mitigating_clauses);

						$data .= ',"mitigating_clauses":{"CUSTOMER_SIGN_OFF":';

						if (in_array('CUSTOMER_SIGN_OFF', $mitigating_array)) {

							$data .= 'true';

						}

						else {

							$data .= 'false';

						}

						$data .= ',"DISCLAIMER_OF_WARRANTIES":';

						if (in_array('DISCLAIMER_OF_WARRANTIES', $mitigating_array)) {

							$data .= 'true';

						}

						else {

							$data .= 'false';

						}

						$data .= ',"HOLD_HARMLESS_AGREEMENTS":';

						if (in_array('HOLD_HARMLESS_AGREEMENTS', $mitigating_array)) {

							$data .= 'true';

						}

						else {

							$data .= 'false';

						}

						$data .= ',"LIMITATION_OF_LIABILITY":';

						if (in_array('LIMITATION_OF_LIABILITY', $mitigating_array)) {

							$data .= 'true';

						}

						else {

							$data .= 'false';

						}

						$data .= ',"EXCLUSION_OF_DAMAGES":';

						if (in_array('EXCLUSION_OF_DAMAGES', $mitigating_array)) {

							$data .= 'true';

						}

						else {

							$data .= 'false';

						}

						$data .= ',"INDEMNIFICATION":';

						if (in_array('INDEMNIFICATION', $mitigating_array)) {

							$data .= 'true';

						}

						else {

							$data .= 'false';

						}

						$data .= ',"BINDING_ARBITRATION":';

						if (in_array('BINDING_ARBITRATION', $mitigating_array)) {

							$data .= 'true';

						}

						else {

							$data .= 'false';

						}

						$data .= ',"MILESTONES":';

						if (in_array('MILESTONES', $mitigating_array)) {

							$data .= 'true';

						}

						else {

							$data .= 'false';

						}



						$data .= '}';

					}

					$data .= '}';

					if ($coverage_instances) {

						$data .= ',"coverage_instances":{}';

					}

					$data .= '}';



					$curl = curl_init();



					curl_setopt_array($curl, array(

						CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid,

						CURLOPT_RETURNTRANSFER => true,

						CURLOPT_ENCODING => "",

						CURLOPT_MAXREDIRS => 10,

						CURLOPT_TIMEOUT => 0,

						CURLOPT_FOLLOWLOCATION => true,

						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

						CURLOPT_CUSTOMREQUEST => "PATCH",

						CURLOPT_POSTFIELDS =>$data,

						CURLOPT_HTTPHEADER => array(

							"Content-Type: application/json",

							"Accept: application/json",

							"Authorization: Bearer ".$token

						),

					));



					$response = curl_exec($curl);



					curl_close($curl);



					if (!$response || !strpos($response, 'uuid')) {

						echo 'fail';

						return;

					}

					echo $response;



					if ($email) {

						$updateData = array('prior_claims' => $prior_claims, 'prior_claims_explanation' => $prior_claims_explanation, 'aware_of_new_claims' => $aware_of_new_claims, 

							'aware_of_new_claims_explanation' => $aware_of_new_claims_explanation, 'encrypts_data' => $encrypts_data, 'pii_phi' => $pii_phi, 

							'pii_phi_count' => $pii_phi_count, 'cc_customer_count' => $cc_customer_count, 'has_tech_eo' => $has_tech_eo,

							'wants_tech_eo' => $wants_tech_eo, 'tech_eo_dispute' => $tech_eo_dispute, 'tech_eo_dispute_explanation' => $tech_eo_dispute_explanation,

							'is_msp_or_bad_industry' => $is_msp_or_bad_industry, 'professional_services' => $professional_services, 'services_by_contract' => $services_by_contract,

							'mitigating_clauses' => $mitigating_clauses);

						$this->MCyber->updateCyberData($email, $updateData);

					}

				}



				public function updatePackage_EffectiveDate($email, $token, $uuid) {

					$effective_date = @date('Y-m-d', mktime(0, 0, 0, @date('m'), @date('d') + 3, @date('Y')));

					$real_effective_date = $effective_date;

					$date = strtotime($effective_date);

					$new_date = strtotime('+ 1 year', $date);

					$end_date = date('Y-m-d', $new_date);

					$retroactive_date = "1970-01-01T00:00:00Z";



					$effective_date .= 'T09:00:00Z';

					$end_date .= 'T09:00:00Z';



					$data = '{

						"effective_date":"'.$effective_date.'",

						"end_date":"'.$end_date.'",

						"retroactive_date":"'.$retroactive_date.'"

					}';



					$curl = curl_init();



					curl_setopt_array($curl, array(

						CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid,

						CURLOPT_RETURNTRANSFER => true,

						CURLOPT_ENCODING => "",

						CURLOPT_MAXREDIRS => 10,

						CURLOPT_TIMEOUT => 0,

						CURLOPT_FOLLOWLOCATION => true,

						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

						CURLOPT_CUSTOMREQUEST => "PATCH",

						CURLOPT_POSTFIELDS =>$data,

						CURLOPT_HTTPHEADER => array(

							"Content-Type: application/json",

							"Accept: application/json",

							"Authorization: Bearer ".$token

						),

					));



					$response = curl_exec($curl);



					curl_close($curl);



					if (!$response || !strpos($response, 'uuid')) {

						return 'fail';

					}





					if ($email) {

						$updateData = array('effective_date' => $real_effective_date);

						$this->MCyber->updateCyberData($email, $updateData);

					}

					return $response;

				}



				public function createPackage_Type() {

					if (!$this->input->post()) {

						return;

					}

					$email = $this->input->post('email');

					$token = $this->input->post('token');

					$uuid = $this->input->post('uuid');

					$result = $this->updatePackage_EffectiveDate($email, $token, $uuid);

					if($result=='fail'){

						echo 'fail';

						return;

					}

					$curl = curl_init();



					curl_setopt_array($curl, array(

						CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid,

						CURLOPT_RETURNTRANSFER => true,

						CURLOPT_ENCODING => "",

						CURLOPT_MAXREDIRS => 10,

						CURLOPT_TIMEOUT => 0,

						CURLOPT_FOLLOWLOCATION => true,

						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

						CURLOPT_CUSTOMREQUEST => "GET",

						CURLOPT_HTTPHEADER => array(

							"Content-Type: application/json",

							"Accept: application/json",

							"Authorization: Bearer ".$token

						),

					));



					$response = curl_exec($curl);



					curl_close($curl);



					if (!$response || !strpos($response, 'uuid')) {

						echo 'fail';

						return;

					}



					$packageData = json_decode($response);



					$newData['company_name'] = $packageData->company_name;

					$newData['domain_names'] = $packageData->domain_names;

					$newData['company_industry'] = $packageData->company_industry;

					$newData['company_revenue'] = $packageData->company_revenue;

					$newData['company_employee_count'] = $packageData->company_employee_count;

					$newData['company_gross_profit_net_revenue'] = $packageData->company_gross_profit_net_revenue;

					$newData['company_address'] = $packageData->company_address;

					$newData['coverage_instances'] = $packageData->coverage_instances;

					$newData['application_responses'] = $packageData->application_responses;

		// $newData['aggregate_limit'] = 1000000;

		// $newData['default_retention'] = 5000;

					$newData['insurance_market'] = $packageData->insurance_market;

					$newData['renewal_of'] = $packageData->renewal_of;

					$newData['effective_date'] = $packageData->effective_date;

					$newData['end_date'] = $packageData->end_date;

					$newData['retroactive_date'] = $packageData->retroactive_date;

					$newData['bundle'] = "most_popular";

					$curl = curl_init();



					curl_setopt_array($curl, array(

						CURLOPT_URL => "https://api.thecoalition.com/api/packages",

						CURLOPT_RETURNTRANSFER => true,

						CURLOPT_ENCODING => "",

						CURLOPT_MAXREDIRS => 10,

						CURLOPT_TIMEOUT => 0,

						CURLOPT_FOLLOWLOCATION => true,

						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

						CURLOPT_CUSTOMREQUEST => "POST",

						CURLOPT_POSTFIELDS =>json_encode($newData),

						CURLOPT_HTTPHEADER => array(

							"Content-Type: application/json",

							"Accept: application/json",

							"Authorization: Bearer ".$token

						),

					));



					$response = curl_exec($curl);



					curl_close($curl);

					if (!$response || !strpos($response, 'uuid')) {

						echo 'fail';

						return;

					}

					$jsonData = json_decode($response);

		// $responseData['most_popular'] = $jsonData->uuid;

		// $responseData['essential'] = $jsonData->uuid;

		// $responseData['comprehensive'] = $jsonData->uuid;

		// echo json_encode($responseData);

		// $uuid = $jsonData->uuid;



					$response_update = $this->autoUpdateFinalPackage($token, $jsonData->uuid, $jsonData);

					if (!$response_update) {

						echo 'fail';

						return;

					}

					$updateJsonData = json_decode($response_update);



					foreach ($updateJsonData->coverage_instances as $key=>$data) {

						$responseData['coverage_instances'][] = $key;

					}



					$responseData['final_uuid'] = $jsonData->uuid;



					$responseData['require_tech_eo'] = $jsonData->company_industry->require_tech_eo == true ? 'yes' : 'no';

					$responseData['reject_media_liability'] = $jsonData->company_industry->reject_media_liability == true ? 'yes' : 'no';

					$responseData['reject_business_interruption'] = $jsonData->company_industry->reject_business_interruption == true ? 'yes' : 'no';

					$responseData['reject_ftf'] = $jsonData->company_industry->reject_ftf == true ? 'yes' : 'no';

					$responseData['reject_tech_eo'] = $jsonData->company_industry->reject_tech_eo == true ? 'yes' : 'no';

					$responseData['aggregate_limit'] = $jsonData->aggregate_limit;

					$responseData['default_retention'] = $jsonData->default_retention;



					echo json_encode($responseData);

				}



				public function customizePackage() {

					if (!$this->input->post()) {

						return;

					}



					$token = $this->input->post('token');

					$uuid = $this->input->post('uuid');



					$curl = curl_init();



					curl_setopt_array($curl, array(

						CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid,

						CURLOPT_RETURNTRANSFER => true,

						CURLOPT_ENCODING => "",

						CURLOPT_MAXREDIRS => 10,

						CURLOPT_TIMEOUT => 0,

						CURLOPT_FOLLOWLOCATION => true,

						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

						CURLOPT_CUSTOMREQUEST => "GET",

						CURLOPT_HTTPHEADER => array(

							"Content-Type: application/json",

							"Accept: application/json",

							"Authorization: Bearer ".$token

						),

					));



					$response = curl_exec($curl);



					curl_close($curl);



					if (!$response || !strpos($response, 'uuid')) {

						echo 'fail';

						return;

					}



					$packageData = json_decode($response);



					$newData['company_name'] = $packageData->company_name;

					$newData['domain_names'] = $packageData->domain_names;

					$newData['company_industry'] = $packageData->company_industry;

					$newData['company_revenue'] = $packageData->company_revenue;

					$newData['company_employee_count'] = $packageData->company_employee_count;

					$newData['company_gross_profit_net_revenue'] = $packageData->company_gross_profit_net_revenue;

					$newData['company_address'] = $packageData->company_address;

					$newData['coverage_instances'] = $packageData->coverage_instances;



					$packageData->application_responses->content_complaints = 'No';

					$packageData->application_responses->reviews_content = 'Yes';

					$packageData->application_responses->backup_and_restore = 'Yes';

					$packageData->application_responses->dual_control = 'Yes';



					$newData['application_responses'] = $packageData->application_responses;

					$newData['aggregate_limit'] = $packageData->aggregate_limit;

					$newData['default_retention'] = $packageData->default_retention;

					$newData['insurance_market'] = $packageData->insurance_market;

					$newData['renewal_of'] = $packageData->renewal_of;

					$newData['effective_date'] = $packageData->effective_date;

					$newData['end_date'] = $packageData->end_date;

					$newData['retroactive_date'] = $packageData->retroactive_date;



					$curl = curl_init();



					curl_setopt_array($curl, array(

						CURLOPT_URL => "https://api.thecoalition.com/api/packages",

						CURLOPT_RETURNTRANSFER => true,

						CURLOPT_ENCODING => "",

						CURLOPT_MAXREDIRS => 10,

						CURLOPT_TIMEOUT => 0,

						CURLOPT_FOLLOWLOCATION => true,

						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

						CURLOPT_CUSTOMREQUEST => "POST",

						CURLOPT_POSTFIELDS =>json_encode($newData),

						CURLOPT_HTTPHEADER => array(

							"Content-Type: application/json",

							"Accept: application/json",

							"Authorization: Bearer ".$token

						),

					));



					$response = curl_exec($curl);



					curl_close($curl);

					if (!$response || !strpos($response, 'uuid')) {

						echo 'fail';

						return;

					}

					$jsonData = json_decode($response);

					$response_update = $this->autoUpdateFinalPackage($token, $uuid, $jsonData);

					$updateJsonData = json_decode($response_update);



					foreach ($updateJsonData->coverage_instances as $key=>$data) {

						$responseData['coverage_instances'][] = $key;

					}



					$responseData['final_uuid'] = $jsonData->uuid;



					$responseData['require_tech_eo'] = $jsonData->company_industry->require_tech_eo == true ? 'yes' : 'no';

					$responseData['reject_media_liability'] = $jsonData->company_industry->reject_media_liability == true ? 'yes' : 'no';

					$responseData['reject_business_interruption'] = $jsonData->company_industry->reject_business_interruption == true ? 'yes' : 'no';

					$responseData['reject_ftf'] = $jsonData->company_industry->reject_ftf == true ? 'yes' : 'no';

					$responseData['reject_tech_eo'] = $jsonData->company_industry->reject_tech_eo == true ? 'yes' : 'no';

					$responseData['aggregate_limit'] = $jsonData->aggregate_limit;

					$responseData['default_retention'] = $jsonData->default_retention;



					echo json_encode($responseData);

				}



				public function updateFinalPackage() {

					if (!$this->input->post()) {

						return;

					}



					$token = $this->input->post('token');

					$uuid = $this->input->post('uuid');

					$aggregate_limit = (int)$this->input->post('aggregate_limit');

					$default_retention = (int)$this->input->post('default_retention');

					$instances = $this->input->post('instances');

					$instances_array = explode(',', $instances);



					$content_complaints = 'No';

					$reviews_content = 'Yes';

					$backup_and_restore = 'Yes';

					$dual_control = 'Yes';



					$curl = curl_init();



					curl_setopt_array($curl, array(

						CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid,

						CURLOPT_RETURNTRANSFER => true,

						CURLOPT_ENCODING => "",

						CURLOPT_MAXREDIRS => 10,

						CURLOPT_TIMEOUT => 0,

						CURLOPT_FOLLOWLOCATION => true,

						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

						CURLOPT_CUSTOMREQUEST => "GET",

						CURLOPT_HTTPHEADER => array(

							"Content-Type: application/json",

							"Accept: application/json",

							"Authorization: Bearer ".$token

						),

					));



					$response = curl_exec($curl);



					curl_close($curl);



					if (!$response || !strpos($response, 'uuid')) {

						echo 'fail';

						return;

					}

					$packageData = json_decode($response);



					$newData['aggregate_limit'] = $aggregate_limit;

					$newData['default_retention'] = $default_retention;



					if ($content_complaints != "Unknown") {

						$packageData->application_responses->content_complaints = $content_complaints;

					}

					if ($reviews_content != "Unknown") {

						$packageData->application_responses->reviews_content = $reviews_content;

					}

					if ($backup_and_restore != "Unknown") {

						$packageData->application_responses->backup_and_restore = $backup_and_restore;

					}

					if ($dual_control != "Unknown") {

						$packageData->application_responses->dual_control = $dual_control;

					}

					$newData['application_responses'] = $packageData->application_responses;



					foreach ($instances_array as $data) {

						if ($data == '')

							break;

						$newData['coverage_instances'][$data] = new stdClass();

					}



					$curl = curl_init();



					curl_setopt_array($curl, array(

						CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid,

						CURLOPT_RETURNTRANSFER => true,

						CURLOPT_ENCODING => "",

						CURLOPT_MAXREDIRS => 10,

						CURLOPT_TIMEOUT => 0,

						CURLOPT_FOLLOWLOCATION => true,

						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

						CURLOPT_CUSTOMREQUEST => "PATCH",

						CURLOPT_POSTFIELDS =>json_encode($newData),

						CURLOPT_HTTPHEADER => array(

							"Content-Type: application/json",

							"Accept: application/json",

							"Authorization: Bearer ".$token

						),

					));



					$response = curl_exec($curl);



					curl_close($curl);



					if (!$response) {

						echo 'fail';

						return;

					}



					if (!strpos($response, 'uuid') && !strpos($response, 'dual_control')) {

						echo 'fail';

						return;

					}



					if (!strpos($response, 'uuid') && strpos($response, 'dual_control')) {

						$newData['application_responses']->dual_control = 'Yes';



						$curl = curl_init();



						curl_setopt_array($curl, array(

							CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid,

							CURLOPT_RETURNTRANSFER => true,

							CURLOPT_ENCODING => "",

							CURLOPT_MAXREDIRS => 10,

							CURLOPT_TIMEOUT => 0,

							CURLOPT_FOLLOWLOCATION => true,

							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

							CURLOPT_CUSTOMREQUEST => "PATCH",

							CURLOPT_POSTFIELDS =>json_encode($newData),
							CURLOPT_HTTPHEADER => array(

								"Content-Type: application/json",

								"Accept: application/json",

								"Authorization: Bearer ".$token

							),

						));



						$response = curl_exec($curl);



						curl_close($curl);



						if (!$response || !strpos($response, 'uuid')) {

							echo 'fail';

							return;

						}

					}



					echo $response;

				}

				public function autoUpdateFinalPackage($token, $uuid, $jsonData=null) {



					$aggregate_limit = $jsonData->aggregate_limit;

					$default_retention = $jsonData->default_retention;

					$instances = 'network,regulatory_defense,pci,breach_response,crisis_management,extortion,asset_restoration,reputation,computer_replacement,service_fraud';



					if($jsonData->company_industry->reject_media_liability != true)

						$instances .= ",media_liability";

					if($jsonData->company_industry->reject_business_interruption != true)

						$instances .= ",business_interruption";

					if($jsonData->company_industry->reject_ftf != true)

						$instances .= ",funds_transfer";

					if($jsonData->company_industry->reject_tech_eo != true && $jsonData->company_industry->require_tech_eo){

						$instances .= ",tech_eo";

					} else {

						$instances .= ",bipd_third_party";

					}



					$instances_array = explode(',', $instances);



					$content_complaints = 'No';

					$reviews_content = 'Yes';

					$backup_and_restore = 'Yes';

					$dual_control = 'Yes';



					$curl = curl_init();



					curl_setopt_array($curl, array(

						CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid,

						CURLOPT_RETURNTRANSFER => true,

						CURLOPT_ENCODING => "",

						CURLOPT_MAXREDIRS => 10,

						CURLOPT_TIMEOUT => 0,

						CURLOPT_FOLLOWLOCATION => true,

						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

						CURLOPT_CUSTOMREQUEST => "GET",

						CURLOPT_HTTPHEADER => array(

							"Content-Type: application/json",

							"Accept: application/json",

							"Authorization: Bearer ".$token

						),

					));



					$response = curl_exec($curl);



					curl_close($curl);



					if (!$response || !strpos($response, 'uuid')) {

						return false;

					}

					$packageData = json_decode($response);



					$newData['aggregate_limit'] = $aggregate_limit;

					$newData['default_retention'] = $default_retention;



					$packageData->application_responses->content_complaints = $content_complaints;

					$packageData->application_responses->reviews_content = $reviews_content;

					$packageData->application_responses->backup_and_restore = $backup_and_restore;

					$packageData->application_responses->dual_control = $dual_control;



					$newData['application_responses'] = $packageData->application_responses;



					foreach ($instances_array as $data) {

						if ($data == '')

							break;

						$newData['coverage_instances'][$data] = new stdClass();

					}



					$curl = curl_init();



					curl_setopt_array($curl, array(

						CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid,

						CURLOPT_RETURNTRANSFER => true,

						CURLOPT_ENCODING => "",

						CURLOPT_MAXREDIRS => 10,

						CURLOPT_TIMEOUT => 0,

						CURLOPT_FOLLOWLOCATION => true,

						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

						CURLOPT_CUSTOMREQUEST => "PATCH",

						CURLOPT_POSTFIELDS =>json_encode($newData),

						CURLOPT_HTTPHEADER => array(

							"Content-Type: application/json",

							"Accept: application/json",

							"Authorization: Bearer ".$token

						),

					));



					$response = curl_exec($curl);

					curl_close($curl);

					if (!$response) {

						return false;

					}



					if (!strpos($response, 'uuid') && !strpos($response, 'dual_control')) {

						return false;

					}



					if (!strpos($response, 'uuid') && strpos($response, 'dual_control')) {

						$newData['application_responses']->dual_control = 'Yes';



						$curl = curl_init();



						curl_setopt_array($curl, array(

							CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid,

							CURLOPT_RETURNTRANSFER => true,

							CURLOPT_ENCODING => "",

							CURLOPT_MAXREDIRS => 10,

							CURLOPT_TIMEOUT => 0,

							CURLOPT_FOLLOWLOCATION => true,

							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

							CURLOPT_CUSTOMREQUEST => "PATCH",

							CURLOPT_POSTFIELDS =>json_encode($newData),

							CURLOPT_HTTPHEADER => array(

								"Content-Type: application/json",

								"Accept: application/json",

								"Authorization: Bearer ".$token

							),

						));



						$response = curl_exec($curl);



						curl_close($curl);



						if (!$response || !strpos($response, 'uuid')) {

							return false;

						}

					}



					return $response;

				}



				public function finalPackage() {

					if (!$this->input->post()) {

						return;

					}



					$email = $this->input->post('email');

					$token = $this->input->post('token');

					$uuid = $this->input->post('uuid');



					$newData = new stdClass();

					$curl = curl_init();



					curl_setopt_array($curl, array(

						CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid."/issue-quotation",

						CURLOPT_RETURNTRANSFER => true,

						CURLOPT_ENCODING => "",

						CURLOPT_MAXREDIRS => 10,

						CURLOPT_TIMEOUT => 0,

						CURLOPT_FOLLOWLOCATION => true,

						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

						CURLOPT_CUSTOMREQUEST => "POST",

						CURLOPT_POSTFIELDS =>json_encode($newData),

						CURLOPT_HTTPHEADER => array(

							"Content-Type: application/json",

							"Accept: application/json",

							"Authorization: Bearer ".$token

						),

					));



					$response = curl_exec($curl);



					curl_close($curl);



					if (!$response) {

						echo 'fail';

						return;

					}

					if (!strpos($response, 'uuid') && !strpos($response, 'already-issued')) {

						echo 'fail';

						return;

					}



					$curl = curl_init();



					curl_setopt_array($curl, array(

						CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid,

						CURLOPT_RETURNTRANSFER => true,

						CURLOPT_ENCODING => "",

						CURLOPT_MAXREDIRS => 10,

						CURLOPT_TIMEOUT => 0,

						CURLOPT_FOLLOWLOCATION => true,

						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

						CURLOPT_CUSTOMREQUEST => "GET",

						CURLOPT_HTTPHEADER => array(

							"Content-Type: application/json",

							"Accept: application/json",

							"Authorization: Bearer ".$token

						),

					));



					$response = curl_exec($curl);



					curl_close($curl);

					$packageData = json_decode($response);



					if ($email) {

						$this->MCyber->deleteCyberCurrentByEmail($email);

						$data = array(

							'customer_email' => $email,

							'company_name' => $packageData->company_name,

							'domain_names' => json_encode($packageData->domain_names),

							'company_revenue' => $packageData->company_revenue,

							'company_employee_count' => $packageData->company_employee_count,

							'company_industry' => $packageData->company_industry->display_name,

							'street_line_1' => $packageData->company_address->street_line_1,

							'street_line_2' => $packageData->company_address->street_line_2,

							'city' => $packageData->company_address->city,

							'state' => $packageData->company_address->state,

							'postcode' => $packageData->company_address->postcode,

							'prior_claims' => $packageData->application_responses->prior_claims,

							'prior_claims_explanation' => (isset($packageData->application_responses->prior_claims_explanation) ? $packageData->application_responses->prior_claims_explanation : ''),

							'aware_of_new_claims' => $packageData->application_responses->aware_of_new_claims,

							'aware_of_new_claims_explanation' => (isset($packageData->application_responses->aware_of_new_claims_explanation) ? $packageData->application_responses->aware_of_new_claims_explanation : ''),

							'encrypts_data' => $packageData->application_responses->encrypts_data,

							'pii_phi' => $packageData->application_responses->pii_phi,

							'pii_phi_count' => (isset($packageData->application_responses->pii_phi_count) ? $packageData->application_responses->pii_phi_count : ''),

							'cc_customer_count' => (isset($packageData->application_responses->cc_customer_count) ? $packageData->application_responses->cc_customer_count : ''),

							'has_tech_eo' => isset($packageData->application_responses->has_tech_eo)?$packageData->application_responses->has_tech_eo:false,

							'wants_tech_eo' => isset($packageData->application_responses->wants_tech_eo)?$packageData->application_responses->wants_tech_eo:false,

							'tech_eo_dispute' => (isset($packageData->application_responses->tech_eo_dispute) ? $packageData->application_responses->tech_eo_dispute : ''),

							'tech_eo_dispute_explanation' => (isset($packageData->application_responses->tech_eo_dispute_explanation) ? $packageData->application_responses->tech_eo_dispute_explanation : ''),

							'is_msp_or_bad_industry' => (isset($packageData->application_responses->is_msp_or_bad_industry) ? $packageData->application_responses->is_msp_or_bad_industry : ''),

							'professional_services' => (isset($packageData->application_responses->professional_services) ? $packageData->application_responses->professional_services : ''),

							'services_by_contract' => (isset($packageData->application_responses->services_by_contract) ? $packageData->application_responses->services_by_contract : ''),

							'mitigating_clauses' => (isset($packageData->application_responses->mitigating_clauses) ? json_encode($packageData->application_responses->mitigating_clauses) : ''),

							'effective_date' => $packageData->effective_date,

							'aggregate_limit' => $packageData->aggregate_limit,

							'default_retention' => $packageData->default_retention

						);

						$this->MCyber->insertCompleteQuote($data);

					}



					echo $response;

				}



				public function getPackage() {

					if (!$this->input->post()) {

						return;

					}



					$token = $this->input->post('token');

					$uuid = $this->input->post('uuid');

					$curl = curl_init();



					curl_setopt_array($curl, array(

						CURLOPT_URL => "https://api.thecoalition.com/api/packages/".$uuid,

						CURLOPT_RETURNTRANSFER => true,

						CURLOPT_ENCODING => "",

						CURLOPT_MAXREDIRS => 10,

						CURLOPT_TIMEOUT => 0,

						CURLOPT_FOLLOWLOCATION => true,

						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

						CURLOPT_CUSTOMREQUEST => "GET",

						CURLOPT_HTTPHEADER => array(

							"Content-Type: application/json",

							"Accept: application/json",

							"Authorization: Bearer ".$token

						),

					));



					$response = curl_exec($curl);



					curl_close($curl);



					if (!$response || !strpos($response, 'uuid')) {

						echo 'fail';

						return;

					}

					echo $response;

				}



				public function getPDFFile() {

					if (!$this->input->post()) {

						return;

					}



					$token = $this->input->post('token');

					$file_id = $this->input->post('file_id');

					$file_name = $this->input->post('file_name');

					$curl = curl_init();



					curl_setopt_array($curl, array(

						CURLOPT_URL => "https://api.thecoalition.com/api/documents/".$file_id."/content",

						CURLOPT_RETURNTRANSFER => true,

						CURLOPT_ENCODING => "",

						CURLOPT_MAXREDIRS => 10,

						CURLOPT_TIMEOUT => 0,

						CURLOPT_FOLLOWLOCATION => true,

						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

						CURLOPT_CUSTOMREQUEST => "GET",

						CURLOPT_HTTPHEADER => array(

							"Content-Type: application/json",

							"Accept: application/json",

							"Authorization: Bearer ".$token

						),

					));



					$response = curl_exec($curl);



					curl_close($curl);



					$date = date('YmdHis');



					$fp = fopen($file_name, "w");

					fwrite($fp, $response);

					fclose($fp);



					echo $file_name;

				}

			}

