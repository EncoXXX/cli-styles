# CLI styles for PHP

With this library you can stylize CLI output

Available styles:
* Bold
* Italic
* Blink
* Underline
* Cross line
* Over line
* Text color
* Background color

### How to use:

You can add different styles to different part of text. For example, you specify
two styles with names 'success' and 'error'. So your text
must be like:
```html
Some text without styles
<success>Text with success styles</success>
Some text without styles
<error>Text with error styles</error>
Some text without styles
```

<b>NOTE: </b> You can`t yse tags hierarchy. This text will be incorrect:
```html
Some text without styles
<success>Text with success styles
    <error>Text with error styles</error>
    Text with success styles
</success>
Some text without styles
```

In your code you must use 2 classes: `\Enco\CliStyles` and `\Enco\Style`<br>

`\Enco\Style` uses to define style<br>
You are obligated to set style name. Otherwise, the exception will be thrown<br>
The name must match `^[a-z0-9_-]+$` regular expression<br>
Available methods:
```php
use \Enco\Style;

public function setName(string $name): Style;
public function setColor(string $color): Style; //Only color hash. Ex: #ff0024
public function setBackground(string $background): Style; //Only color hash. Ex: #ff0024
public function setBold(bool $isBold = true): Style;
public function setItalic(bool $isItalic = true): Style;
public function setUnderline(bool $isUnderline = true): Style;
public function setCrossLine(bool $isCrossLine = true): Style;
public function setOverLine(bool $isOverline = true): Style;
public function setBlink(bool $isBlink = true): Style;
```
Also, you can specify default style, that applies to text without tags<br>
To do this you just need to specify `\Enco\Style::DEFAULT_STYLE_NAME` constabt as name of style

`\Enco\CliStyles` uses to apply styles to text<br>
You must add styles, that you want to use

Available methods: 
```php
use Enco\CliStyles;
use Enco\Style;

public function addStyle(Style $style): CliStyles;
public function addText(string $text): CliStyles
public function resolve(): string;
public function __toString(): string; //Symlink to resolve() method
```

You can use ``$cliStylesObject`` to echo text. Styles will be applied automatically. Example: 
```php
$cliStylesObject = new \Enco\CliStyles();
...
echo $cliStylesObject;
```

Also, you can escape tag: 
```html
<error>This is example of \<error>\</error> tags</error>
```
Output will be:
```
This is example of <error></error> tags
```

PHP code example:
```php
use Enco\CliStyles;
use Enco\Style;

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
<temp>Some text with styles</temp>\n
<error>One more text with styles</error>\n
";

$cliColors = new CliStyles();
$cliColors->setText($text)
    ->addStyle($style)
    ->addStyle($defaultStyle)
    ->addStyle($errorStyle);

echo $cliColors;
```

You always can ask questions to `<bednarsasha@gmail.com>`