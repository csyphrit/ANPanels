<?php
$mail = Mailer::getMail();
if (count($mail) > 0) {
	foreach ($mail as $message) {
		mail($message['to'], $message['subject'], $message['body'], 'From: ' . $message['from'] . "\r\n" . 'Reply-To: ' . $message['replyto'] . "\r\n");
		Mailer::clearMail($message['mailid']);
	}
}
unset($mail);
?>