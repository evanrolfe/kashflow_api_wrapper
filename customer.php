<?php

class Kashflow_Customer extends Kashflow_Api
{
	public function __construct($params = array())
	{
		parent::__construct();

		$required_params = array("Name","Telephone","Email","Address1","Postcode","Created","Updated");

		//Check the correct parameters are set
		foreach($required_params as $key)
		{
			if(!isset($params[$key]))
				throw new PhpErrorException("The parameter: ".$key." is required to create a Kashflow_Customer object.");

			$this->params[$key] = $params[$key];
		}

		//Automatically Set the default values for useless fields (kashflow api fuckin sucks)
		$this->params['CustomerID'] = 0;
		$this->params['CurrencyID'] = 0;
		$this->params['PaymentTerms'] = "0";
		$this->params['ShowDiscount'] = "0";
		$this->params['Source'] = 0;
		$this->params['Discount'] = "0";
		$this->params['OutsideEC'] = 0;
		$this->params['EC'] = 0;

		$this->params['ExtraText1'] = "0";
		$this->params['ExtraText2'] = "0";
		for($i=1;$i<=20;$i++)
		{
			$checkbox = "CheckBox".$i;
			$this->params[$checkbox] = "";
		}		
	}

	/*
	 * Return the Kashflow CustomerID of this inserted customer
	 */
	public function save()
	{
		$customer_obj = new SoapVar($this->params, SOAP_ENC_OBJECT, "Customer", "KashFlow");
		$response = $this->client->InsertCustomer(array(
			"UserName" => $this->username,
			"Password" => $this->password,
			"custr" => $customer_obj,			
		));

		if($response->Status=="OK")
		{
			$this->kf_id = $response->InsertCustomerResult;
			return true;
		}else{
			throw new PhpErrorException($response->StatusDetail);
		}
	}
}