<?php
/**
 * Style model
 *
 * @author Andrii Bednarskyi <bednarsasha@gmail.com>
 * @copyright 2021 Enco
 */

namespace Enco;

/**
 * Style model
 */
class Style
{
    const NAME_PATTERN = '/^[a-z0-9_-]+$/';
    const DEFAULT_STYLE_NAME = 'default'; //Use to stylize text without styles
    const RESET_STYLES_CODE = "\e[0m";

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var Color
     */
    protected $color;

    /**
     * @var FontStyle
     */
    protected $fontStyle;

    /**
     * @var Color
     */
    protected $background;

    /**
     * Style constructor
     */
    public function __construct()
    {
        $this->color = new Color();
        $this->background = new Color();
        $this->fontStyle = new FontStyle();
    }

    /**
     * Set name of style
     *
     * @param string $name
     *
     * @return Style
     * @throws CliColorsException
     */
    public function setName(string $name): Style
    {
        $this->validateName($name);

        $this->name = $name;

        return $this;
    }

    /**
     * Set text color
     *
     * @param string $color
     *
     * @return Style
     * @throws CliColorsException
     */
    public function setColor(string $color): Style
    {
        $this->isNameIsset();
        $this->color->setColor($color);

        return $this;
    }

    /**
     * Set background color
     *
     * @param string $color
     *
     * @return $this
     * @throws CliColorsException
     */
    public function setBackground(string $color): Style
    {
        $this->isNameIsset();
        $this->background->setColor($color);

        return $this;
    }

    /**
     * Set bold font
     *
     * @param bool $isBold
     *
     * @return $this
     * @throws CliColorsException
     */
    public function setBold(bool $isBold = true): Style
    {
        $this->isNameIsset();
        $this->fontStyle->setBold($isBold);

        return $this;
    }

    /**
     * Set italic font
     *
     * @param bool $isItalic
     *
     * @return $this
     * @throws CliColorsException
     */
    public function setItalic(bool $isItalic = true): Style
    {
        $this->isNameIsset();
        $this->fontStyle->setItalic($isItalic);

        return $this;
    }

    /**
     * Set underline for text and underline color
     *
     * @param bool $isUnderline
     * @param string $color
     *
     * @return $this
     * @throws CliColorsException
     */
    public function setUnderline(bool $isUnderline = true): Style
    {
        $this->isNameIsset();
        $this->fontStyle->setUnderline($isUnderline);

        return $this;
    }

    /**
     * Set cross line
     *
     * @param bool $isCrossLine
     *
     * @return $this
     * @throws CliColorsException
     */
    public function setCrossLine(bool $isCrossLine = true): Style
    {
        $this->isNameIsset();
        $this->fontStyle->setCrossLine($isCrossLine);

        return $this;
    }

    /**
     * Set overline
     *
     * @param bool $isOverline
     *
     * @return $this
     * @throws CliColorsException
     */
    public function setOverLine(bool $isOverline = true): Style
    {
        $this->isNameIsset();
        $this->fontStyle->setOverLine($isOverline);

        return $this;
    }

    /**
     * Set blink text
     *
     * @param bool $isBlink
     *
     * @return $this
     * @throws CliColorsException
     */
    public function setBlink(bool $isBlink = true): Style
    {
        $this->isNameIsset();
        $this->fontStyle->setIsBlink($isBlink);

        return $this;
    }

    /**
     * Returns style name
     *
     * @return string
     * @throws CliColorsException
     */
    public function getName(): string
    {
        $this->isNameIsset();

        return $this->name;
    }

    /**
     * Returns text color
     *
     * @return Color
     * @throws CliColorsException
     */
    public function getColor(): Color
    {
        $this->isNameIsset();

        return $this->color;
    }

    /**
     * Returns background color
     *
     * @return Color
     * @throws CliColorsException
     */
    public function getBackground(): Color
    {
        $this->isNameIsset();

        return $this->background;
    }

    /**
     * Returns font style
     *
     * @return FontStyle
     * @throws CliColorsException
     */
    public function getFontStyle(): FontStyle
    {
        $this->isNameIsset();

        return $this->fontStyle;
    }

    /**
     * Check if name isset
     *
     * @throws CliColorsException
     */
    protected function isNameIsset()
    {
        $this->validateName($this->name);
    }

    /**
     * Validate style name
     *
     * @param string $name
     *
     * @throws CliColorsException
     */
    protected function validateName(string $name): void
    {
        if (trim($name, ' ') == '') {
            throw new CliColorsException('You must specify style name');
        }

        if (preg_match(self::NAME_PATTERN, $name) === 0) {
            throw new CliColorsException('Name must match' . self::NAME_PATTERN . ' regular expression');
        }
    }
}
