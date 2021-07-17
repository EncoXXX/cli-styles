<?php
/**
 * Color model
 *
 * @author Andrii Bednarskyi <bednarsasha@gmail.com>
 * @copyright 2021 Enco
 */

namespace Enco;

/**
 * Color model
 */
class Color
{
    const TEXT_CLI_CODE = "\e[38;2";
    const BACKGROUND_CLI_CODE = "\e[48;2";
    const COLOR_REGULAR_EXP = '/^[0-9a-f]{6}+$/';

    /**
     * @var int
     */
    protected $red = -1;

    /**
     * @var int
     */
    protected $green = -1;

    /**
     * @var int
     */
    protected $blue = -1;

    /**
     * @var string[]
     */
    protected $hexChars = ['a', 'b', 'c', 'd', 'e', 'f'];

    /**
     * @var int[]
     */
    protected $hexDigits = [10, 11, 12, 13, 14, 15];

    /**
     * @param string $color
     *
     * @return Color
     * @throws CliColorsException
     */
    public function setColor(string $color): Color
    {
        $color = $this->validateColorHash($color);
        $this->resolveColorHash($color);
        return $this;
    }

    /**
     * Returns red color
     *
     * @return int
     * @throws CliColorsException
     */
    public function getRed(): int
    {
        if ($this->red == -1) {
            throw new CliColorsException('Color is not set');
        }

        return $this->red;
    }

    /**
     * Returns green color
     *
     * @return int
     * @throws CliColorsException
     */
    public function getGreen(): int
    {
        if ($this->green == -1) {
            throw new CliColorsException('Color is not set');
        }

        return $this->green;
    }

    /**
     * Returns blue color
     *
     * @return int
     * @throws CliColorsException
     */
    public function getBlue(): int
    {
        if ($this->blue == -1) {
            throw new CliColorsException('Color is not set');
        }

        return $this->blue;
    }

    /**
     * Convert color hash to RGB colors
     *
     * @param string $color
     */
    public function resolveColorHash(string $color): void
    {
        $colorDigits = [];
        for ($i = 0; $i < strlen($color); $i++) {
            $colorDigits[] = (int) str_replace($this->hexChars, $this->hexDigits, $color[$i]);
        }

        $red = ($colorDigits[0] * 16) + $colorDigits[1];
        $green = ($colorDigits[2] * 16) + $colorDigits[3];
        $blue = ($colorDigits[4] * 16) + $colorDigits[5];

        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    /**
     * Validate and returns color hash
     *
     * @param string $color
     *
     * @return string
     * @throws CliColorsException
     */
    protected function validateColorHash(string $color): string
    {
        if (strlen($color) < 6) {
            throw new CliColorsException('Wrong color hash 1');
        }

        if ($color[0] == '#') {
            $color = substr($color,1);
        }

        $color = strtolower($color);

        if (preg_match(self::COLOR_REGULAR_EXP, $color) === 0) {
            throw new CliColorsException('Wrong color hash 2');
        }

        return $color;
    }

    /**
     * Is color isset
     *
     * @return bool
     */
    public function isColorSet(): bool
    {
        return !($this->red == -1);
    }
}
