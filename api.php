<?php

class Kashflow_Api
{
	public function __construct()
	{
		$this->username = "usernamegoeshere";
		$this->password = "passwordgoeshere";

		$this->client = new SoapClient("https://securedwebapp.com/api/service.asmx?WSDL");//, array('trace' => 1,"exceptions"=>1));
	}
}