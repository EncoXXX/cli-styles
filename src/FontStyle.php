<?php
/**
 * Font style model
 *
 * @author Andrii Bednarskyi <bednarsasha@gmail.com>
 * @copyright 2021 Enco
 */
namespace Enco;

/**
 * Font style model
 */
class FontStyle
{
    const BOLD_CODE = "\e[1m";
    const ITALIC_CODE = "\e[3m";
    const UNDERLINE_CODE = "\e[4m";
    const BLINK_CODE = "\e[5m";
    const CROSS_LINE_CODE = "\e[9m";
    const OVER_LINE_CODE = "\e[53m";

    /**
     * @var bool
     */
    protected $isBold = false;

    /**
     * @var bool
     */
    protected $isItalic = false;

    /**
     * @var bool
     */
    protected $isUnderline = false;

    /**
     * @var bool
     */
    protected $isCrossLine = false;

    /**
     * @var bool
     */
    protected $isOverLine = false;

    /**
     * @var bool
     */
    protected $isBlink = false;

    /**
     * Set bold text
     *
     * @param bool $isBold
     *
     * @return $this
     */
    public function setBold(bool $isBold = true): FontStyle
    {
        $this->isBold = $isBold;

        return $this;
    }

    /**
     * Set Italic text
     *
     * @param bool $isItalic
     *
     * @return $this
     */
    public function setItalic(bool $isItalic = true): FontStyle
    {
        $this->isItalic = $isItalic;

        return $this;
    }

    /**
     * Set underline for text
     *
     * @param bool $isUnderline
     *
     * @return $this
     */
    public function setUnderline(bool $isUnderline = true): FontStyle
    {
        $this->isUnderline = $isUnderline;

        return $this;
    }

    /**
     * Set cross line for text
     *
     * @param bool $isCrossLine
     *
     * @return $this
     */
    public function setCrossLine(bool $isCrossLine = true): FontStyle
    {
        $this->isCrossLine = $isCrossLine;

        return $this;
    }

    /**
     * Set overline for text
     *
     * @param bool $isOverLine
     *
     * @return $this
     */
    public function setOverLine(bool $isOverLine = true): FontStyle
    {
        $this->isOverLine = $isOverLine;

        return $this;
    }

    /**
     * Set blink text
     *
     * @param bool $isBlink
     *
     * @return $this
     */
    public function setIsBlink(bool $isBlink = true): FontStyle
    {
        $this->isBlink = $isBlink;

        return $this;
    }

    /**
     * Get is bold flag
     *
     * @return bool
     */
    public function getIsBold(): bool
    {
        return $this->isBold;
    }

    /**
     * Get is Italic flag
     *
     * @return bool
     */
    public function getIsItalic(): bool
    {
        return $this->isItalic;
    }

    /**
     * Get is underline flag
     *
     * @return bool
     */
    public function getIsUnderline(): bool
    {
        return $this->isUnderline;
    }

    /**
     * Get is cross line flag
     *
     * @return bool
     */
    public function getIsCrossLine(): bool
    {
        return $this->isCrossLine;
    }

    /**
     * @return bool
     */
    public function getIsOverLine(): bool
    {
        return $this->isOverLine;
    }

    /**
     * Get is blink flag
     *
     * @return bool
     */
    public function getIsBlink(): bool
    {
        return $this->isBlink;
    }
}
