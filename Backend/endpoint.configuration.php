<?php

namespace endpoint\configuration\vw_qs_audit;

include_once "inc/class.api.router.module.php";

class ApiEndpoints extends \moduleApiRouter
{


	public function __construct()
	{

		parent::__construct();

		$this->folder = dirname(__DIR__);

		/* LIST ALL ROUTES AND ENDPOINTS */

		$this->endpoints["v1/autadesapi_productionoverview"] = array("file" => "api.v1.functions.php", "class" => "qsauditFunctionsV1", "method" => "autadesapi_overview", "login" => false);
		$this->endpoints["v1/autadesapi_productionProtocol"] = array("file" => "api.v1.functions.php", "class" => "qsauditFunctionsV1", "method" => "autadesapi_Protocol", "login" => false);
		$this->endpoints["v1/autadesapi_pidComparison"] = array("file" => "api.v1.functions.php", "class" => "qsauditFunctionsV1", "method" => "autadesapi_pidComparison_protocol", "login" => false);
	}
}
