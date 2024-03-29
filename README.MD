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

You can add different styles to different parts of text. For example, you specify
two styles with names 'success' and 'error'. So your text
must be like:
```html
Some text without styles
<success>Text with success styles</success>
Some text without styles
<error>Text with error styles</error>
Some text without styles
```

<b>NOTE: </b> You can`t use tags hierarchy. This text will be incorrect:
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

public function setName(string $name): Style; //Set name of style. Used like html tags
public function setColor(string $color): Style; //Only color hash. Ex: #ff0024
public function setBackground(string $background): Style; //Only color hash. Ex: #ff0024
public function setBold(bool $isBold = true): Style;
public function setItalic(bool $isItalic = true): Style;
public function setUnderline(bool $isUnderline = true): Style;
public function setCrossLine(bool $isCrossLine = true): Style;
public function setOverLine(bool $isOverline = true): Style;
public function setBlink(bool $isBlink = true): Style;

public static function formatLink(string $url, string $text): string;
```
Also, you can specify default style, that applies to text without tags<br>
To do this you just need to specify `\Enco\Style::DEFAULT_STYLE_NAME` constant as name of style

`\Enco\CliStyles` uses to apply styles to text<br>
You must add styles, that you want to use

Available methods:

```php
use Enco\CliStylesPool;
use Enco\Style;

public function addStyle(Style $style): CliStylesPool;
public function addText(string $text): CliStylesPool
public function resolve(): string;
public function __toString(): string; //Symlink to resolve() method
```

You can use ``$cliStylesObject`` to echo text. Styles will be applied automatically. Example:

```php
$cliStylesObject = new \Enco\CliStylesPool();
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
use Enco\CliStylesPool;
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

$cliColors = new CliStylesPool();
$cliColors->setText($text)
    ->addStyle($style)
    ->addStyle($defaultStyle)
    ->addStyle($errorStyle);

echo $cliColors;
```

### Cli cursor management
You can manage CLI cursor position. For ex. mov cursor or set absolute position

To manage CLI cursor you must use ``\Enco\CliCursor``

Available methods:
```php
use \Enco\CliCursor;
    
public function saveCursorPosition(): CliCursor //You can save only one position
public function restoreCursorPosition(): CliCursor //Restore cursor position from saved one
public function moveLeft(int $cols): CliCursor //Move cursor left. $cols must be > 0
public function moveRight(int $cols): CliCursor //Move cursor right. $cols must be > 0
public function moveUp(int $lines, bool $moveToStartOfLine = false): CliCursor //Move cursor up. If $moveToStartOfLine = true -> also moves cursor to first column
public function moveDown(int $lines, bool $moveToStartOfLine = false): CliCursor // Move cursor down. If $moveToStartOfLine = true -> also moves cursor to first column
public function setCol(int $col): CliCursor //Set cursor column position (horizontal)
public function setLine(int $line): CliCursor //Set cursor line position (vertical)
public function setPosition(int $line, int $col): CliCursor //Set absolute cursor position in both directions
public function eraseWindow(): CliCursor //Erase window (works like `clear` in bash) and set position to 1;1
public function eraseCurrentLine(): CliCursor //Erase current line and set cursor position to start of line
public function scrollUp(int $height): CliCursor //Scroll terminal up (add new lines to header). $height must be > 0. Lines at bottom will be erased
public function scrollDown(int $height): CliCursor //Scroll terminal down (add new lines to bottom). $height must be > 0. Lines at header will be erased
public function hideCursor(): CliCursor //Hide cursor (cursor in terminal will be invisible, but still works)
public function showCursor(): CliCursor //Show cursor position (cursor blink in terminal)
public function getTerminalWidth(): int //Returns terminal width in cols
public function getTerminalHeight(): int //Returns terminal height in lines
```

You must be careful to use ``\Enco\CliStyles`` and ``\Enco\CliCursor``, because ``\Enco\CliCursor`` in some cases can reset styles (when new text override styled text)

Code example:
```php
use Enco\CliCursor;

$cursor = new CliCursor();
$cursor->eraseWindow();
echo '1'; //After echo cursor moves right, so position will be 1, 2
$cursor->setPosition(2, 2);
echo '2'; //After echo cursor moves right, so position will be 2, 3
$cursor->setPosition(3, 3);
echo '3'; //After echo cursor moves right, so position will be 3, 4
$cursor->moveLeft(1)
       ->moveDown(1);
echo "Height: " . $cursor->getTerminalHeight() . ' lines. ';
echo "Width: " . $cursor->getTerminalWidth() . 'columns';
```

Output will be:
```
1
 2
  3
  Height: 52 lines. Width: 204 columns
```

You always can ask questions to `<bednarsasha@gmail.com>`
