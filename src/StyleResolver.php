<?php
/**
 * Class to apply styles to text
 *
 * @author Andrii Bednarskyi <bednarsasha@gmail.com>
 * @copyright 2021 Enco
 */

namespace Enco;

/**
 * Class to define and use CLI styles
 */
class StyleResolver
{
    /**
     * @var bool
     */
    protected $isDefaultStyleResolved = false;

    /**
     * Apply styles to text
     *
     * @param Style $style
     * @param Style $defaultStyle
     * @param string $text
     *
     * @return string
     * @throws CliColorsException
     */
    public function resolve(Style $style, Style $defaultStyle, string $text): string
    {
        $styleCode = $this->getCliCode($style);
        $defaultStyleCode = $this->getCliCode($defaultStyle);

        $styleName = $style->getName();

        //Shield text
        $text = str_replace("\\<", "<\\", $text);

        $text = str_replace("<$styleName>", $styleCode, $text);
        $text = str_replace("</$styleName>", $defaultStyleCode, $text);

        $text = str_replace("<\\", "<", $text);

        return $text;
    }

    /**
     * Get text color cli code
     *
     * @param Style $style
     *
     * @return string
     * @throws CliColorsException
     */
    public function getColorCode(Style $style): string
    {

        $colorCode = Color::TEXT_CLI_CODE;
        $color = $style->getColor();

        if (!$color->isColorSet()) {
            return '';
        }

        return "{$colorCode};{$color->getRed()};{$color->getGreen()};{$color->getBlue()}m";
    }

    /**
     * Get background color cli code
     *
     * @param Style $style
     *
     * @return string
     * @throws CliColorsException
     */
    public function getBackgroundCode(Style $style): string
    {
        $colorCode = Color::BACKGROUND_CLI_CODE;
        $color = $style->getBackground();

        if (!$color->isColorSet()) {
            return '';
        }

        return "{$colorCode};{$color->getRed()};{$color->getGreen()};{$color->getBlue()}m";
    }

    /**
     * Get font style cli code
     *
     * @param Style $style
     *
     * @return string
     * @throws CliColorsException
     */
    public function getFontStyleCode(Style $style): string
    {
        $fontStyle = $style->getFontStyle();
        $code = '';

        if ($fontStyle->getIsBold()) {
            $code .= FontStyle::BOLD_CODE;
        }
        if ($fontStyle->getIsItalic()) {
            $code .= FontStyle::ITALIC_CODE;
        }
        if ($fontStyle->getIsBlink()) {
            $code .= FontStyle::BLINK_CODE;
        }
        if ($fontStyle->getIsUnderline()) {
            $code .= FontStyle::UNDERLINE_CODE;
        }
        if ($fontStyle->getIsCrossLine()) {
            $code .= FontStyle::CROSS_LINE_CODE;
        }
        if ($fontStyle->getIsOverLine()) {
            $code .= FontStyle::OVER_LINE_CODE;
        }

        return $code;
    }

    /**
     * Get cli code to format text
     *
     * @param Style $style
     *
     * @return string
     * @throws CliColorsException
     */
    protected function getCliCode(Style $style): string
    {
        $cliStyleText = '';
         if ($style->getName() == Style::DEFAULT_STYLE_NAME) {
             $cliStyleText .= "\e[0m";
         }

        $cliStyleText .= $this->getColorCode($style);
        $cliStyleText .= $this->getBackgroundCode($style);
        $cliStyleText .= $this->getFontStyleCode($style);

        return $cliStyleText;
    }
}