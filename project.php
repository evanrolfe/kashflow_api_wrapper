<?php

class Kashflow_Project extends Kashflow_Api
{
	public function __construct($params = array())
	{
		parent::__construct();

		$required_params = array("Name","Reference");

		//Check the correct parameters are set
		foreach($required_params as $key)
		{
			if(!isset($params[$key]))
				throw new PhpErrorException("The parameter: ".$key." is required to create a Kashflow_Project object.");

			$this->params[$key] = $params[$key];
		}

		//Set default values for useless but required fields
			$this->params["ID"]				= 0;
			$this->params["Number"]			= 0;		
			$this->params["Description"]	= "";
			$this->params["CustomerID"]		= 0;
			$this->params["Status"]			= 1;
			$this->params["Date1"]			= time();
			$this->params["Date2"]			= time()+4*7*24*60*60;	//Arbitrary :(
	}

	/*
	 * Return the Kashflow CustomerID of this inserted customer
	 */
	public function save()
	{
		$project_obj = new SoapVar($this->params, SOAP_ENC_OBJECT, "Project", "KashFlow");

		$response = $this->client->InsertOrUpdateProject(array(
			"UserName" => $this->username,
			"Password" => $this->password,
			"Project" => $project_obj,			
		));

		if($response->Status=="OK")
		{
			$this->kf_id = $response->InsertOrUpdateProjectResult;
			return true;
		}else{
			throw new PhpErrorException($response->StatusDetail);
		}
	}
}