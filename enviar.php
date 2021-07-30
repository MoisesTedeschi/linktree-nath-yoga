<?php
// Incluindo arquivo com a classe Mail
require_once('mailer/PHPMailer.php');
require_once('mailer/SMTP.php');
require_once('mailer/Exception.php');

// Importe de classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$mail = new PHPMailer(true);


if($_SERVER['REQUEST_METHOD'] == 'POST') {
								
	$erro = '';
	
	if(!isset($_POST['name']) ||
		!isset($_POST['email']) ||
		!isset($_POST['message'])
		) {

		$erro = "Pelo menos um dos campos não existe!";
	}

	$nome= utf8_decode(@$_POST[name]);
	$email= utf8_decode(@$_POST[email]);
	$mensagem= utf8_decode(@$_POST[message]);

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$erro = 'Endereço de email inválido!';
	}
}

try {
	//$mail->SMTPDebug = SMTP::DEBUG_SERVER;

	//Tell PHPMailer to use SMTP
	$mail->isSMTP();

	//Set the hostname of the mail server
	$mail->Host = 'smtp.gmail.comm';

	//Whether to use SMTP authentication
	$mail->SMTPAuth = true;

	//Username to use for SMTP authentication - use full email address for gmail
	$mail->Username = 'username@gmail.com';

	//Password to use for SMTP authentication
	$mail->Password = 'password123456789';

	//Set the encryption system to use - ssl (deprecated) or tls
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

	// use
	// $mail->Host = gethostbyname('smtp.gmail.com');
	// if your network does not support SMTP over IPv6
	//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
	$mail->Port = 587; 

	$mail->setFrom('username@gmail.com', $nome);
	$mail->addAddress('username@gmail.com', utf8_decode('Destinatário'));

	// Conteúdo do Email
	$mail->isHTML(true);
	$mail->Subject = utf8_decode('Contato via formulário - Nathália Soares Yoga.');
	$mail->Body .= "E-mail: ".$email."<br />";
	$mail->Body .= "Mensagem: ".$mensagem;

	// $mail->AltBody = 'Chegou o email teste do Canal TI';

	if($mail->send()) {

		//echo 'Email enviado com sucesso!';
		header ('Location: /sucesso.php');

	} else {
		echo 'Email não enviado!';
	}
} catch (Exception $e) {
	echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
}
?>