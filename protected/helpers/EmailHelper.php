<?php
class EmailHelper {
	public static function getMassEmails($registered = FALSE) {
		if ($registered) {
			$emails = Profile::getRegisteredEmails();
		} else {
			$emails = Profile::getAllEmails();
		}
		return $emails;
	}
	
	public static function sendMail($message, $subject) {
		try {
			$mandrill = new Mandrill('9Vh3J8I8dFCoI-1xW5PFwA');
			$message = array(
				'text' => $message,
				'subject' => $subject,
				'from_email' => 'webmaster@anpanels.com',
				'from_name' => '',
				'to' => array(),
			);
			$async = false;
    			$ip_pool = 'Main Pool';
    			$send_at = 'example send_at';
    			$result = $mandrill->messages->send($message);
		} catch (Mandrill_Error $e) {
			//Do something?
		}
	}
}
?>