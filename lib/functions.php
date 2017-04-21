<?php
/**
 * Created by PhpStorm.
 * User: Эрлан
 * Date: 20.04.2017
 * Time: 20:20
 */

/**
 * @param $body
 * @param $to:array
 * @return bool
 */


function sendMail($body, $to) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'wbg.concept@gmail.com';
    $mail->Password = 'afrodita97';

    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('admin@wbg-concept.com', 'Mailer');
    foreach($to as $el) {
        $mail->addAddress($el);
    }

    $mail->isHTML(true);                                  // Set email format to HTML
    $l = new Languages();
    $mail->Subject = $l->getLanguage() == 'ru' ? 'Новая заявка' : 'New request';
    $mail->Body    = $body;


    return $mail->send();
}