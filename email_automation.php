<?php

// Dados de autenticação do servidor de e-mail
$smtp_server = "smtp.example.com";
$smtp_user = "email@example.com";
$smtp_pass = "password";

// Configurações do e-mail
$from_email = "email@example.com";
$subject = "Assunto do e-mail";
$body = "Corpo do e-mail";

// Lê a lista de destinatários a partir de um arquivo CSV
$destinatarios = array_map('str_getcsv', file('destinatarios.csv'));

// Conecta ao servidor de e-mail
$transport = (new Swift_SmtpTransport($smtp_server, 25))
  ->setUsername($smtp_user)
  ->setPassword($smtp_pass);

$mailer = new Swift_Mailer($transport);

foreach ($destinatarios as $destinatario) {
    $nome = $destinatario[0];
    $email = $destinatario[1];
    $personalizado_subject = str_replace("{nome}", $nome, $subject);
    $personalizado_body = str_replace("{nome}", $nome, $body);
    $message = (new Swift_Message($personalizado_subject))
      ->setFrom([$from_email => $nome])
      ->setTo([$email])
      ->setBody($personalizado_body);
    $result = $mailer->send($message);
}