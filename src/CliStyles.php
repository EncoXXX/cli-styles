<?php
/**
 * CLI colors
 *
 * @author Andrii Bednarskyi <bednarsasha@gmail.com>
 * @copyright 2021 Enco
 */

namespace Enco;

/**
 * CLI colors
 */
class CliStyles
{
    /**
     * @var string
     */
    protected $text;

    /**
     * @var array
     */
    protected $styles = [];

    /**
     * @var Style
     */
    protected $defaultStyle;

    /**
     * CliColors constructor
     */
    public function __construct()
    {
        $this->defaultStyle = new Style();
        $this->defaultStyle->setName(Style::DEFAULT_STYLE_NAME);
    }

    /**
     * Add styles to text
     *
     * @param Style $style
     *
     * @return $this
     * @throws CliColorsException
     */
    public function addStyle(Style $style): CliStyles
    {
        if ($style->getName() == Style::DEFAULT_STYLE_NAME) {
            $this->defaultStyle = $style;

            return $this;
        }
        $this->styles[] = $style;

        return $this;
    }

    /**
     * Add text
     *
     * @param string $text
     *
     * @return $this
     */
    public function setText(string $text): CliStyles
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Allows use this object like echo $object.
     * Applies resolve method
     *
     * @return string
     * @throws CliColorsException
     */
    public function __toString()
    {
        return $this->resolve();
    }

    /**
     * Applies styles to text
     *
     * @param bool $resetStylesAfterResolve
     *
     * @return string
     * @throws CliColorsException
     */
    public function resolve(bool $resetStylesAfterResolve = true): string
    {
        $text = $this->text;
        $styleResolver = new StyleResolver();

        foreach ($this->styles as $style) {
            $text = $styleResolver->resolve($style, $this->defaultStyle, $text);
        }
        $resetStylesCode = $resetStylesAfterResolve ? Style::RESET_STYLES_CODE : '';

        return $text . $resetStylesCode;
    }
}
