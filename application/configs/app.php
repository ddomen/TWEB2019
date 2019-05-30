<?php

$APP_CONFIGURATION = [
    'NomeAzienda' => 'Car Rental',
    'image' => new stdClass,
    'url' => new stdClass
];

$APP_CONFIGURATION['url']->home = 'public/';
$APP_CONFIGURATION['url']->aboutus = 'public/aboutus';
$APP_CONFIGURATION['url']->contacts = 'public/contattaci';
$APP_CONFIGURATION['url']->rules = 'public/rules';
$APP_CONFIGURATION['url']->catalog = 'public/catalog';
$APP_CONFIGURATION['url']->faq = 'public/faq';
$APP_CONFIGURATION['url']->login = 'public/login';

$APP_CONFIGURATION['image']->brand = 'images/Brand.png';
$APP_CONFIGURATION['image']->messanger = 'images/question.png';