<?php
/*
**	Global functions for use
*/


//Validate the passed in email compared to a list of allowed emails
//e.g. monash.edu or gsk.com
function Begin()
{
	header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
	session_start();
}

function GetVar($name)
{
	if(isset($_GET[$name]))
		return $_GET[$name];
	if(isset($_POST[$name]))
		return $_POST[$name];
	return null;
}

function TranslateString($text, $toLang)
{
	$text = urlencode($text);
	$toLang = urlencode($toLang);

	$url = 'http://api.microsofttranslator.com/v2/Http.svc/Translate?appId=86C013378FF4FBB847243EE1367A1E3D278D0E49&text='.$text.'&from=en&to='.$toLang;
	
	$data = file_get_contents($url);
	$data = (string)simplexml_load_string($data);
	
	return $data;
}

function LoginAdmin()
{
	$result = SqlQuery("SELECT * FROM administrator WHERE name={0} AND password={1} LIMIT 1", $_SESSION['username'], $_SESSION['pass']);
	if(mysql_numrows($result) <= 0)
	{
		return false;
	}
	$data = mysql_fetch_array($result);
	
	$_SESSION['is_teacher'] = $data['teacher'];
	return true;
}

function GeneratePassword($length)
{
	//There should be a number at least every 3 characters
	$lastNumber = -1;

	$pwd = '';
	for($i=0; $i<$length; $i+=1)
	{
		$c = mt_rand(1,2);
		
		if($c == 0 || ($i - $lastNumber >= 3))
		{
			//Generate Digit
			$pwd .= chr(mt_rand(ord('0'), ord('9')));
			$lastNumber = $i;
		}
		else if($c == 1)
		{
			$ch = chr(mt_rand(ord('a'), ord('z')));
			
			//no lowercase L's
			if($ch == 'l')
				$ch = 'L';
				
			$pwd .= $ch;
		}
		else
		{
			$pwd .= chr(mt_rand(ord('A'), ord('Z')));
		}
	}
	
	return $pwd;
}
function ValidateEmail($emailAddress)
{
	global $config;
	$email = strtolower(trim($emailAddress));
	//if(preg_match("/[.+a-zA-Z0-9_-]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $email) == 0)
	//	return false;
	if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email) == false)
	{
		LogInfo('Invalid Email: {0}', $email);
		return false;
	}
	
	return true;
		
	//validate end of email
	$preAt = explode("@", $email);
	$afterAt = $preAt[1];//after @
	$found = false; //has a valid email been found?
	
	
	if($found == false)
		return false;
	else
	{
		if($afterAt == "student.monash.edu")
		{
			if(!preg_match("/^[a-zA-Z]{1,5}[0-9]{1,3}$/", $data))
			{
				return false;
			}
		}
		else if($afterAt == "monash.edu")
		{
			if(!preg_match("/^[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/", $data))
			{
				return false;
			}
		}
	}
	

	$firstName = $preAt[0];
	$temp = explode(".", $afterAt);
	$lastName = $config['names'][$afterAt];
		
		
	$details = array(
		'firstName' => $firstName,
		'lastName' => $lastName
	);
	
	return $details;
}
//Send an Email
//$sendTo = array of address or single address string of who to send the email to
function SendMail($sendTo, $subject, $message, $from = '')
{
	//From Default
	global $config;
	if($from == '')
		$from = $config['emailFrom'];
	
	$useForce = false;
	//Check force email setting
	if(array_key_exists('useForceEmails', $config))
	{
		$useForce = $config['useForceEmails'];
	}
	
	if($useForce == true)
	{
		if($sendTo == '')
			return;
					
		//Convert $sendTo to an array
		if(!is_array($sendTo))
		{
			$sendTo = array(strval($sendTo));
		}
		
		if(array_key_exists('forceEmailSend', $config))
		{
			$sendTo = $config['forceEmailSend'];
			$bcc = implode(', ', $config['forceEmailSend']);
		}
		
		if($sendTo == '')
			return;
		
		//use SendExternalMail instead
		//return SendExternalMail($sendTo, $subject, $message);
		
		//Combine Emails to Send to
		//$sendTo = implode(', ', $sendTo);
		
		
		//Headers
		$headers = 'From: ' . $from . "\r\n" .
					'Reply-To: ' . $from . "\r\n".
					'Return-Path: ' . $from . "\r\n".
					'Content-Type: text/html; charset="iso-8859-1' . "\r\n".
					"Content-Transfer-Encoding: 7bit\r\n".
					'Bcc: ' . $bcc . "\r\n".
					'X-Mailer: PHP/' . phpversion();
					
		return mail($sendTo[0], $subject, $message, $headers);
	}
	else
	{
		if($sendTo == '')
			return;
				
		//Convert $sendTo to an array
		if(!is_array($sendTo))
		{
			$sendTo = array(strval($sendTo));
		}
		
		if(array_key_exists('forceEmailSend', $config))
		{
			$bcc = implode(', ', $config['forceEmailSend']);
		}
		
		if($sendTo == '')
			return;
		
		//use SendExternalMail instead
		//return SendExternalMail($sendTo, $subject, $message);
		
		//Combine Emails to Send to
		$sendTo = implode(', ', $sendTo);
		
		
		//Headers
		$headers = 'From: ' . $from . "\r\n" .
					'Reply-To: ' . $from . "\r\n".
					'Return-Path: ' . $from . "\r\n".
					'Content-Type: text/html; charset="iso-8859-1' . "\r\n".
					"Content-Transfer-Encoding: 7bit\r\n".
					'Bcc: ' . $bcc . "\r\n".
					'X-Mailer: PHP/' . phpversion();
				
		return mail($sendTo, $subject, $message, $headers);
	}
}

function SendGuestMail($sendTo, $subject, $message, $from = '')
{
	//From Default
	global $config;
	if($from == '')
		$from = $config['emailFrom'];
	
	$useForce = false;
	//Check force email setting
	//if(array_key_exists('useForceEmails', $config))
	//{
	//	$useForce = $config['useForceEmails'];
	//}
	
	if($sendTo == '')
		return;

	
	if(array_key_exists('forceEmailSend', $config))
	{
		//$sendTo = $config['forceEmailSend'];
		$bcc = implode(', ', $config['forceEmailSend']);
	}
	
	if($sendTo == '')
		return;
	
	
	//Headers
	$headers = 'From: ' . $from . "\r\n" .
				'Reply-To: ' . $from . "\r\n".
				'Return-Path: ' . $from . "\r\n".
				'Content-Type: text/html; charset="iso-8859-1' . "\r\n".
				"Content-Transfer-Encoding: 7bit\r\n".
				'Bcc: ' . $bcc . "\r\n".
				'X-Mailer: PHP/' . phpversion();
				
	return mail($sendTo, $subject, $message, $headers);
}

//Used to Send mail through the monash server
function SendExternalMail($to, $subject, $message)
{
	//Make $to an array
	if(!is_array($to))
	{
		$to = array($to);
	}

	//Create Post Data
	$postData = http_build_query(array(
		'to' => $to,
		'subject' => $subject,
		'msg' => $message,
		'secret' => md5('ieisshithouse')
	));
	
	//HTTP Options
	$opts = array('http' =>
		array(
			'method' => 'POST',
			'header' => 'Content-type: application/x-www-form-urlencoded',
			'content' => $postData,
		)
	);
	
	//Make HTTP Call
	$context = stream_context_create($opts);
	$url = 'http://s1.pharmatopia.monash.edu/mail.php';
	$result = file_get_contents($url, false, $context);

	return ($result == '1');
}

//Includes a file & returns the contents
//this differs from file_get_contents because files are processed (eg. php files are run)
//before being returned
function ProcessFile($file, $tokens = null)
{
	ob_start();
	include($file);
	$data = ob_get_clean();
	
	if($tokens != null)
		$data = ReplaceTokens($data, $tokens);
		
	return $data;
}


//For Internal use
function SqlStringArray($a)
{
	if(count($a) < 1)
		return '';
		
	$query = $a[0];
	
	$argc = count($a);
	
	for($i=1; $i<$argc; $i+=1)
	{
		$val = strval($a[$i]);
		$val = mysql_real_escape_string($val);
		
		if(!is_numeric($val))
			$val = '\''.$val.'\'';
		
		$query = str_replace('{'.($i-1).'}', $val, $query);
	}
	
	return $query;
}

//Inserts Extra parameters into an sql string safely
//eg. SqlString('SELECT * FROM table WHERE name = {0}', $name);
function SqlString($query)
{
	$args = func_get_args();
	return SqlStringArray($args);
}





?>