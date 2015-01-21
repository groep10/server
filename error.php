<?php

class error
{
	private $debug;
	function __construct($debug = false)
	{
		$this->debug = $debug;
	}


	function log($error = null) {
		error_log("log:" . $error . "\r\n", 3,'script_error.log'); 
	}

	function user($error = null)
	{
		error_log("user error :" . $error . "\r\n", 3,'script_error.log'); 
		if($error == null || !$this->debug)
		{
			return die("an error occured when loading the page, please try again later.");
		}
		else
		{
			return die("an error occured when handeling userinfo.<br /><br /> error: ".$error."<br />");
		}
	}
	function city($error = null)
	{
		error_log("city error :" . $error . "\r\n", 3,'script_error.log'); 
		if($error == null || !$this->debug)
		{
			return die("an error occured when loading the page, please try again later.");
		}
		else
		{
			return die("an error occured when handeling city data.<br/><br/> error: ".$error."<br/>");
		}
	}
	
	function db($error,$fatal = false,$conn = false){
		//log the error to the error log for revieuw.
		error_log("db error :" . $error . "\r\n", 3,'script_error.log'); 
		if($this->debug){
			if($conn)  die("<br />there was an unexpected problem with setting up the db connection <br /> <p>debug message: <br / >" . $error . "</p>");
			else if($fatal)  die("<br />there was an unexpected  fatal error in excuting an db query <br /> <p>debug message: <br />" . $error . "</p>");	
			// don't dislay an error when it's not fatall because it will crap up your site.
			// else echo "unexpected db error <br /> <p> error: <br />" . $error . "</p>";
		} else {
			// visiter dusn't need to know what kind of error occured.
			if($fatal)  die("there was an unexpected  fatal error when the website loaded, sorry for the inconvenience. ");	
			// don't dislay an error when it's not fatall because it will crap up your site.
			// else echo "unexpected db error <br /> ";
		}
	}
	
	// to change the debug mode, because the debug value is private and should be.
	public function set_debug($set = false){
		$this->debug = $set;
	}
}
