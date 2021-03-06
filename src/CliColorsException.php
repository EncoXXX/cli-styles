<?php
/**
 * Cli colors exception
 *
 * @author Andrii Bednarskyi <bednarsasha@gmail.com>
 * @copyright 2021 Enco
 */
namespace Enco;

use Throwable;

/**
 * Cli colors exception
 */
class CliColorsException extends \Exception
{
    /**
     * Cli colors exception constructor
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = "\e[48;2;255;0;0m\e[38;2;255;255;255m\n\n\tCLI colors exception: {$message}\n\e[0m\n";
        parent::__construct($message, $code, $previous);
    }
}