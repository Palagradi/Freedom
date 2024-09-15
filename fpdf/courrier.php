<?php 
	# PHP ADODB document - made with PHAkt
	# FileName="Connection_php_adodb.htm"
	# Type="ADODB"
	# HTTP="true"
	# DBTYPE="mysql"
	
	$MM_courrier_HOSTNAME = 'localhost';
	$MM_courrier_DATABASE = 'codiam';
	$MM_courrier_DBTYPE   = preg_replace('/:.*$/', '', $MM_courrier_DATABASE);
	$MM_courrier_DATABASE = preg_replace('/^[^:]*?:/', '', $MM_courrier_DATABASE);
	$MM_courrier_USERNAME = '';
	$MM_courrier_PASSWORD = '';
	$MM_courrier_LOCALE = '';
	$MM_courrier_MSGLOCALE = '';
	$MM_courrier_CTYPE = 'P';
	$KT_locale = $MM_courrier_MSGLOCALE;
	$KT_dlocale = $MM_courrier_LOCALE;
	$KT_serverFormat = '%Y-%m-%d %H:%M:%S';
	$QUB_Caching = 'false';

	$KT_localFormat = $KT_serverFormat;
	
	if (!defined('CONN_DIR')) define('CONN_DIR',dirname(__FILE__));
	require_once(CONN_DIR.'/../adodb/adodb.inc.php');
	$courrier=&KTNewConnection($MM_courrier_DBTYPE);

	if($MM_courrier_DBTYPE == 'access' || $MM_courrier_DBTYPE == 'odbc'){
		if($MM_courrier_CTYPE == 'P'){
			$courrier->PConnect($MM_courrier_DATABASE, $MM_courrier_USERNAME,$MM_courrier_PASSWORD);
		} else $courrier->Connect($MM_courrier_DATABASE, $MM_courrier_USERNAME,$MM_courrier_PASSWORD);
	} else if (($MM_courrier_DBTYPE == 'ibase') or ($MM_courrier_DBTYPE == 'firebird')) {
		if($MM_courrier_CTYPE == 'P'){
			$courrier->PConnect($MM_courrier_HOSTNAME.':'.$MM_courrier_DATABASE,$MM_courrier_USERNAME,$MM_courrier_PASSWORD);
		} else $courrier->Connect($MM_courrier_HOSTNAME.':'.$MM_courrier_DATABASE,$MM_courrier_USERNAME,$MM_courrier_PASSWORD);
	}else {
		if($MM_courrier_CTYPE == 'P'){
			$courrier->PConnect($MM_courrier_HOSTNAME,$MM_courrier_USERNAME,$MM_courrier_PASSWORD, $MM_courrier_DATABASE);
		} else $courrier->Connect($MM_courrier_HOSTNAME,$MM_courrier_USERNAME,$MM_courrier_PASSWORD, $MM_courrier_DATABASE);
   }

	if (!function_exists('updateMagicQuotes')) {
		function updateMagicQuotes($HTTP_VARS){
			if (is_array($HTTP_VARS)) {
				foreach ($HTTP_VARS as $name=>$value) {
					if (!is_array($value)) {
						$HTTP_VARS[$name] = addslashes($value);
					} else {
						foreach ($value as $name1=>$value1) {
							if (!is_array($value1)) {
								$HTTP_VARS[$name1][$value1] = addslashes($value1);
							}
						}
					}
				}
			}
			return $HTTP_VARS;
		}
		
		if (!get_magic_quotes_gpc()) {
			$_GET = updateMagicQuotes($_GET);
			$_POST = updateMagicQuotes($_POST);
			$_COOKIE = updateMagicQuotes($_COOKIE);
		}
	}
	if (!isset($_SERVER['REQUEST_URI']) && isset($_ENV['REQUEST_URI'])) {
		$_SERVER['REQUEST_URI'] = $_ENV['REQUEST_URI'];
	}
	if (!isset($_SERVER['REQUEST_URI'])) {
		$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'].(isset($_SERVER['QUERY_STRING'])?"?".$_SERVER['QUERY_STRING']:"");
	}
?>