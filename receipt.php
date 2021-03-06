<?php

class Kashflow_Receipt extends Kashflow_Api
{
	public function __construct($params = array())
	{
		parent::__construct();

		$required_params = array("CustomerID","InvoiceDate","CustomerReference","ProjectID");

		//Check the correct parameters are set
		foreach($required_params as $key)
		{
			if(!isset($params[$key]))
				throw new PhpErrorException("The parameter: ".$key." is required to create a Kashflow_Receipt object.");

			$this->params[$key] = $params[$key];
		}

		//Invoice Line Items
		$this->params['Lines'] = array();

		//Set default values for useless but required fields
			$this->params['DueDate']		= $this->params['InvoiceDate'];
			$this->params["InvoiceDBID"]	= 0;
			$this->params["InvoiceNumber"]	= 0;		
			$this->params["Paid"]			= 0;
			$this->params["SuppressTotal"]	= 0;
			$this->params["ExchangeRate"]	= 0;
			$this->params["NetAmount"]		= 0;
			$this->params["VATAmount"]		= 0;
			$this->params["AmountPaid"]		= 0;		
	}

	public function add_line_item($params = array())
	{

		$required_params = array("Quantity","Description","Rate");

		$line_params = array();

		//Check the correct parameters are set
		foreach($required_params as $key)
		{
			if(!isset($params[$key]))
				throw new PhpErrorException("The parameter: ".$key." is required to create a Kashflow_Invoice object.");

			$line_params[$key] = $params[$key];
		}

		//Set default values for useless but required fields		
		$line_params["LineID"]      		= 0;
		$line_params["ChargeType"]  		= 0;
		$line_params["VatAmount"]   		= "";
		$line_params["VatRate"]     		= "";
		$line_params["Sort"]       			= 1;
		$line_params["ProjID"]      		= 0;
		$line_params["VatAmount"]			= 0;
		$line_params["VatRate"]				= 0;
		$line_params["Sort"]				= 0;
		$line_params["ValuesInCurrency"]	= 0;
		$line_params["ProductID"]			= 0;


		//Add this line to the invoice
		$this->params['Lines'][] = new SoapVar($line_params,SOAP_ENC_OBJECT,"InvoiceLine","KashFlow");
	}

	/*
	 * Return the Kashflow CustomerID of this inserted customer
	 */
	public function save()
	{
		$invoice_obj = new SoapVar($this->params, SOAP_ENC_OBJECT, "Invoice", "KashFlow");
		$response = $this->client->InsertReceipt(array(
			"UserName" => $this->username,
			"Password" => $this->password,
			"Inv" => $invoice_obj,			
		));

		if($response->Status=="OK")
		{
			$this->kf_id = $response->InsertReceiptResult;
			return true;
		}else{
			throw new PhpErrorException($response->StatusDetail);
		}
	}
}