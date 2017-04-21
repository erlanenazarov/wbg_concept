<?php
/**
 * Created by PhpStorm.
 * User: Эрлан
 * Date: 20.04.2017
 * Time: 20:20
 */

require_once('vendor/autoload.php');

include('lib/Languages.php');
include('lib/functions.php');

$language = new Languages();
$currentLanguage = $language->getLanguage();

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'none';

switch($action) {
    case 'language':
            $lg = $_REQUEST['lg'];
            $language->setLanguage($lg, (7 * 24 * 60 * 60));
            header('location: /');
        break;
    case 'send-mail':
            $name = $_REQUEST['name'];
            $email = $_REQUEST['email'];
            $org = $_REQUEST['org'];
            $title = $_REQUEST['title'];
            $phoneNumber = $_REQUEST['phone_number'];
            $country = $_REQUEST['country'];
            $preference = $_REQUEST['preference'];
            $specRequest = isset($_REQUEST['spec_request']) ? $_REQUEST['spec_request'] : null;

            $today = new DateTime('now');

            if($language->getLanguage() == 'ru') {
                $message = "Новая заявка!" . "\r\n<br>" .
                    "<b>Имя</b>: " . $name . "\r\n<br>" .
                    "<b>Эл. почта</b>: " . $email . "\r\n<br>" .
                    "<b>Организация</b>: " . $org . "\r\n<br>" .
                    "<b>Название</b>: " . $title . "\r\n<br>" .
                    "<b>Номер телефона</b>: " . $phoneNumber . "\r\n<br>" .
                    "<b>Страна</b>: " . $country . "\r\n<br>" .
                    "<b>Диетические предпочтения</b>: " . $preference . "\r\n<br>";

                if ($specRequest != null) {
                    $message .= "<b>Специальные запросы</b>: " . $specRequest . "\r\n<br>";
                }

                $message .= "Дата отправки: " . $today->format('d') . " " . $today->format('M') . ", " . $today->format('Y');
            } else {
                $message = "New request!" . "\r\n<br>" .
                    "<b>Name</b>: " . $name . "\r\n<br>" .
                    "<b>E-Mail</b>: " . $email . "\r\n<br>" .
                    "<b>Organization</b>: " . $org . "\r\n<br>" .
                    "<b>Title</b>: " . $title . "\r\n<br>" .
                    "<b>Phone number</b>: " . $phoneNumber . "\r\n<br>" .
                    "<b>Country</b>: " . $country . "\r\n<br>" .
                    "<b>Dietary preferences</b>: " . $preference . "\r\n<br>";

                if ($specRequest != null) {
                    $message .= "<b>Special requests</b>: " . $specRequest . "\r\n<br>";
                }

                $message .= "Sending date: " . $today->format('d') . " " . $today->format('M') . ", " . $today->format('Y');
            }
            header('Content-Type: application/json');
            if(sendMail($message, [$email, 'conference@concept.kg'])) {
                die(json_encode(array('success' => 'True', 'message' => $message)));
            } else {
                die(json_decode(array('success' => 'False')));
            }
        break;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Digital CASA project</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://nst1.gismeteo.ru/assets/flat-ui/legacy/css/informer.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<section class="main">
    <div class="group">
        <div class="logo">
            <img src="public/images/logo.png" width="100%">
        </div>
        <div class="help-text">
            <span><?php if($currentLanguage == 'en') { ?>May 30 - 31<?php } else { ?>май 30 - 31<?php } ?></span><br>
            <?php if($currentLanguage == 'en') { ?>Kyrgyz Republic<?php } else { ?>Кыргызская Республика<?php } ?>
        </div>
        <div class="languages">
            <ul>
                <li><?php if($currentLanguage == 'en') { ?>Please choose the language<?php } else { ?>Пожалуйста, выберите язык<?php } ?>:</li>
                <li><a href="?action=language&lg=ru"><img src="public/images/russian.png"></a></li>
                <li><a href="?action=language&lg=en"><img src="public/images/english.png"></a></li>
            </ul>
        </div>
    </div>
    <header>
        <div class="text"><?php if($currentLanguage == 'en') { ?>Choose the language for registration<?php } else { ?>Выберите язык для регистрации<?php } ?></div>
        <div class="buttons">
            <div><button type="button" class="button pop-up-trigger" data-target="ru"><?php if($currentLanguage == 'en') { ?>RUSSIAN<?php } else { ?>РУССКИЙ<?php } ?></button></div>
            <div><button type="button" class="button pop-up-trigger" data-target="en"><?php if($currentLanguage == 'en') { ?>ENGLISH<?php } else { ?>АНГЛИЙСКИЙ<?php } ?></button></div>
        </div>
    </header>
    <div class="group">
        <aside class="wrap-left">
            <p><?php if($currentLanguage == 'en') { ?>Click here to<?php } else { ?>Нажмите чтобы<?php } ?> <a href="#" class="link"><?php if($currentLanguage == 'en') { ?>download<?php } else { ?>скачать<?php } ?> agenda</a></p>
            <p><?php if($currentLanguage == 'en') { ?>Click here to<?php } else { ?>Нажмите чтобы<?php } ?> <a href="#" class="link"><?php if($currentLanguage == 'en') { ?>download<?php } else { ?>скачать<?php } ?> cityguide</a></p>
            <!--English-->
            <?php if($currentLanguage == 'en') { ?>
                <div id="gsInformerID-bc4R8hJDGU4K6O" class="gsInformer" style="height:201px">
                    <div class="gsIContent">
                        <div id="cityLink">
                            <a href="https://www.gismeteo.com/city/daily/5327/" target="_blank">Weather in Bishkek</a>
                        </div>
                        <div class="gsLinks">
                            <table>
                                <tr>
                                    <td>
                                        <div class="leftCol">
                                            <a href="https://www.gismeteo.com/" target="_blank">
                                                <img alt="Gismeteo" title="Gismeteo" src="https://nst1.gismeteo.ru/assets/flat-ui/img/logo-mini2.png" align="middle" border="0" />
                                                <span>Gismeteo</span>
                                            </a>
                                        </div>
                                        <div class="rightCol">
                                            <a href="https://www.gismeteo.com/city/weekly/5327/" target="_blank">2-week forecast</a>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <script async src="https://www.gismeteo.ru/api/informer/getinformer/?hash=bc4R8hJDGU4K6O" type="text/javascript"></script>
            <?php } else { ?>
                <!-- Russian -->
                <div id="gsInformerID-165prbA8N7M583" class="gsInformer" style="height:201px">
                    <div class="gsIContent">
                        <div id="cityLink">
                            <a href="https://www.gismeteo.ru/weather-bishkek-5327/" target="_blank">Погода в Бишкеке</a>
                        </div>
                        <div class="gsLinks">
                            <table>
                                <tr>
                                    <td>
                                        <div class="leftCol">
                                            <a href="https://www.gismeteo.ru/" target="_blank">
                                                <img alt="Gismeteo" title="Gismeteo"
                                                     src="https://nst1.gismeteo.ru/assets/flat-ui/img/logo-mini2.png"
                                                     align="middle" border="0"/>
                                                <span>Gismeteo</span>
                                            </a>
                                        </div>
                                        <div class="rightCol">
                                            <a href="https://www.gismeteo.ru/weather-bishkek-5327/2-weeks/" target="_blank">Прогноз
                                                на 2 недели</a>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <script async src="https://www.gismeteo.ru/api/informer/getinformer/?hash=165prbA8N7M583" type="text/javascript"></script>
            <?php } ?>
        </aside>
        <aside class="wrap-right">
            <div class="title"><?php if($currentLanguage == 'en') { ?>VISA GUIDANCE<?php } else { ?>Визовое сопровождение<?php } ?></div>
            <div class="content">
                <p>
                    <?php if($currentLanguage == 'en') { ?>
                        Note: citizens of Afghanistan, Uzbekistan, Kazakhstan, Tajikistan,
                        Turkey are all visa free for Kyrgyz Republic. For more information
                        for citizens of other countries, you can check visa requirements by
                        clicking the following <a href="#">link</a> or contacting Kyrgyz Concept: <a href="mailto:visa@concept.kg">visa@concept.kg</a>
                    <?php } else { ?>
                        Примечание: граждане Афганистана, Узбекистана, Казахстана, Таджикистана,
                        Турции имеют безвизовый доступ в Кыргызскую Республику. Более подробную информацию
                        для граждан других стран можете проверить
                        перейдя по следующей <a href="#">ссылке</a> или вы можете связаться с Kyrgyz Concept: <a href="mailto:visa@concept.kg">visa@concept.kg</a>
                    <?php } ?>
                </p>
            </div>
        </aside>
    </div>
</section>

<div class="overlay" id="registration-modal">
    <div class="modal-carcass">
        <div class="child">
            <span class="md-close">Close</span>
            <div class="modal-header" id="register-header">registration form</div>
            <div class="modal-content">
                <form action="?action=send-mail" method="POST" id="registration-form">
                    <div class="wrap-left">
                        <ul>
                            <li><label for="name">Name:</label></li>
                            <li><label for="email">Email Address:</label></li>
                            <li><label for="org">Organization:</label></li>
                            <li><label for="title">Title:</label></li>
                            <li><label for="phone-number">Phone number:</label></li>
                            <li><label for="country">Country:</label></li>
                            <li><label for="preference">Dietary preference:</label></li>
                            <li><label for="request">Special request:</label></li>
                        </ul>
                    </div>
                    <div class="wrap-right">
                        <ul>
                            <li><input type="text" id="name" name="name" required oninput="$(this).css('border-color', '#356ba8');"></li>
                            <li><input type="email" id="email" name="email" required oninput="$(this).css('border-color', '#356ba8');"></li>
                            <li><input type="text" id="org" name="org" required oninput="$(this).css('border-color', '#356ba8');"></li>
                            <li><input type="text" id="title" name="title" required oninput="$(this).css('border-color', '#356ba8');"></li>
                            <li><input type="number" id="phone-number" name="phone_number" required oninput="$(this).css('border-color', '#356ba8');"></li>
                            <li><input type="text" id="country" name="country" required oninput="$(this).css('border-color', '#356ba8');"></li>
                            <li><input type="text" id="preference" name="preference" required oninput="$(this).css('border-color', '#356ba8');"></li>
                            <li><textarea id="request" name="spec_request"></textarea></li>
                        </ul>
                        <button class="submit-button" type="submit" id="submit">submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="overlay" id="thanks-modal">
    <div class="modal-carcass">
        <div class="child">
            <span class="md-close">Close</span>
            <div class="modal-content">
                <div class="header" id="thanks-header">Thank You!</div>
                <div class="text" id="thanks-text">
                    FORM IS SENDED<br>
                    OUR MANAGERS WILL CONTACT WITH YOU!<br>
                    CHECK YOUR EMAIL FOR COPY OF SENT FORM!
                </div>
            </div>
        </div>
    </div>
</div>

<div class="overlay" id="fail-modal">
    <div class="modal-carcass">
        <div class="child">
            <span class="md-close">Close</span>
            <div class="modal-content">
                <div class="header" id="fail-header">Sorry :(</div>
                <div class="text" id="fail-text">
                    Server catch an error, try later...
                </div>
            </div>
        </div>
    </div>
</div>

<script src="public/js/jquery-3.2.1.min.js"></script>
<script src="public/js/app.js"></script>
</body>
</html>