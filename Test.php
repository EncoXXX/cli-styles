<?php

use Enco\CliStyles;
use Enco\Style;

spl_autoload_register(function ($class_name) {
    $class_name = str_replace("Enco\\", '', $class_name);
    $class_name = str_replace("\\", '/', $class_name);

    include "src/{$class_name}.php";
});
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

//throw new \Enco\CliColorsException('bla bla bla');

$style = new Style();
$style->setName('temp');
$style->setColor('#555555')
    ->setBackground('#ffffff')
    ->setItalic()
    ->setBold()
    ->setCrossLine();;

$defaultStyle = new Style();
$defaultStyle->setName(Style::DEFAULT_STYLE_NAME)
->setColor('#ff00ff');

$errorStyle = new Style();
$errorStyle->setName('error')
    ->setColor('#ffffff')
    ->setBackground('#ff0000');

$text = "
This is simple text without styles\n
<temp>Some text with styles</temp>
<error>\n\nOne more text with styles\n</error>
";

$cliColors = new CliStyles();
$cliColors->setText($text)
    ->addStyle($style)
    ->addStyle($defaultStyle)
    ->addStyle($errorStyle);

echo $cliColors;
