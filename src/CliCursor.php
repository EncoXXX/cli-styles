<?php
/**
 * Class for cursor management
 *
 * @author Andrii Bednarskyi <bednarsasha@gmail.com>
 * @copyright 2021 Enco
 */

declare(strict_types=1);

namespace Enco;

/**
 * Class for cursor management
 */
class CliCursor
{
    protected const SAVE_POSITION = "\e[s"; //Save cursor position
    protected const RESTORE_POSITION = "\e[u"; //Restore saved cursor position

    protected const MOVE_UP = "\e[%1A"; //Move cursor %1 lines up
    protected const MOVE_DOWN = "\e[%1B"; //Move cursor %1 lines down
    protected const MOVE_LEFT = "\e[%1C"; //Move cursor %1 cols left
    protected const MOVE_RIGHT = "\e[%1D"; //Move cursor %1 cols right

    protected const MOVE_UP_LINES = "\e[%1F"; // Move cursor %1 lines up and set to start of line
    protected const MOVE_DOWN_LINES = "\e[%1E"; //Move cursor %1 lines down and set to start of line

    protected const SET_COL = "\e[%1G"; //Set cursor to %1 column
    protected const SET_LINE = "\e[%1d"; //Set cursor to %1 line
    protected const SET_POSITION = "\e[%1;%2H"; //Set cursor to %1 line and %2 column

    protected const ERASE_WINDOW = "\e[2J"; //Erase all content
    protected const ERASE_LINE = "\e[2K"; //Erase line (cursor position does not change)

    protected const SCROLL_UP = "\e[%1T"; //Scroll up to %1 lines. Adds new lines on the top of window. Lines in the bottom will be erased
    protected const SCROLL_DOWN = "\e[%1S"; //Scroll down to %1 lines. Adds new lines on the bottom. Lines in the header will be erased

    protected const HIDE_CURSOR = "\e[?25l"; //Hide cursor
    protected const SHOW_CURSOR = "\e[?25h"; //Show cursor

    protected const GET_WIDTH_COMMAND = 'tput cols'; //Get width in chars
    protected const GET_WIDTH_COMMAND_BSD = 'tput co'; //Get width in chars (for BSD systems)
    protected const GET_HEIGHT_COMMAND = 'tput lines'; //Get height in lines
    protected const GET_HEIGHT_COMMAND_BSD = 'tput li'; //Get height in lines (for BSD systems)

    /**
     * Save cursor position. Can be saved only one position
     *
     * @return $this
     */
    public function saveCursorPosition(): CliCursor
    {
        echo self::SAVE_POSITION;

        return $this;
    }

    /**
     * Restore cursor position from saved one
     *
     * @return $this
     */
    public function restoreCursorPosition(): CliCursor
    {
        echo self::RESTORE_POSITION;

        return $this;
    }

    /**
     * Move cursor left
     *
     * @param int $cols
     *
     * @return $this
     * @throws CliCursorException
     */
    public function moveLeft(int $cols): CliCursor
    {
        if ($cols < 1) {
            throw new CliCursorException('Column cursor must be more than 0');
        }

        echo $this->resolve(self::MOVE_LEFT, $cols);

        return $this;
    }

    /**
     * Move cursor right
     *
     * @param int $cols
     *
     * @return $this
     * @throws CliCursorException
     */
    public function moveRight(int $cols): CliCursor
    {
        if ($cols < 1) {
            throw new CliCursorException('Column cursor must be more than 0');
        }

        echo $this->resolve(self::MOVE_RIGHT, $cols);

        return $this;
    }

    /**
     * Move cursor up
     * If $moveToStartOfLine = true -> also moves cursor to first column
     *
     * @param int $lines
     * @param bool $moveToStartOfLine
     *
     * @return $this
     * @throws CliCursorException
     */
    public function moveUp(int $lines, bool $moveToStartOfLine = false): CliCursor
    {
        if ($lines < 1) {
            throw new CliCursorException('Line cursor must be more than 0');
        }

        if ($moveToStartOfLine) {
            echo $this->resolve(self::MOVE_UP_LINES, $lines);

            return $this;
        }

        echo $this->resolve(self::MOVE_UP, $lines);

        return $this;
    }

    /**
     * Move cursor down
     * If $moveToStartOfLine = true -> also moves cursor to first column
     *
     * @param int $lines
     * @param bool $moveToStartOfLine
     *
     * @return $this
     * @throws CliCursorException
     */
    public function moveDown(int $lines, bool $moveToStartOfLine = false): CliCursor
    {
        if ($lines < 1) {
            throw new CliCursorException('Line cursor must be more than 0');
        }

        if ($moveToStartOfLine) {
            echo $this->resolve(self::MOVE_DOWN_LINES, $lines);

            return $this;
        }

        echo $this->resolve(self::MOVE_DOWN, $lines);

        return $this;
    }

    /**
     * Set cursor column
     *
     * @param int $col
     *
     * @return CliCursor
     * @throws CliCursorException
     */
    public function setCol(int $col): CliCursor
    {
        if ($col < 1)
        {
            throw new CliCursorException('Column cursor must be more than 0');
        }

        echo $this->resolve(self::SET_COL, $col);

        return $this;
    }

    /**
     * Set cursor line
     *
     * @param int $line
     *
     * @return $this
     * @throws CliCursorException
     */
    public function setLine(int $line): CliCursor
    {
        if ($line < 1) {
            throw new CliCursorException('Line cursor must be more than 0');
        }

        echo $this->resolve(self::SET_LINE, $line);

        return $this;
    }

    /**
     * Set cursor position
     *
     * @param int $line
     * @param int $col
     *
     * @return CliCursor
     * @throws CliCursorException
     */
    public function setPosition(int $line, int $col): CliCursor
    {
        if ($line < 1) {
            throw new CliCursorException('Line cursor must be more than 0');
        }
        if ($col < 1) {
            throw new CliCursorException('Column cursor must be more than 0');
        }

        echo $this->resolve(self::SET_POSITION, $line, $col);

        return $this;
    }

    /**
     * Erase window
     *
     * @return CliCursor
     */
    public function eraseWindow(): CliCursor
    {
        echo self::ERASE_WINDOW;
        $this->setPosition(1, 1);

        return $this;
    }

    /**
     * Erase current line
     *
     * @return $this
     */
    public function eraseCurrentLine(): CliCursor
    {
        echo self::ERASE_LINE;
        $this->setCol(1);

        return $this;
    }

    /**
     * Scroll up to $height lines (add new lines to the header)
     * BE CAREFUL, lines at bottom will be erased
     *
     * @param int $height
     *
     * @return $this
     * @throws CliCursorException
     */
    public function scrollUp(int $height): CliCursor
    {
        if ($height < 1) {
            throw new CliCursorException('Height to scroll up must be more than 0');
        }

        echo $this->resolve(self::SCROLL_UP, $height);

        return $this;
    }

    /**
     * Scroll down to $height lines (add new lines to the bottom)
     * BE CAREFUL, lines at header will be erased
     *
     * @param int $height
     *
     * @return $this
     * @throws CliCursorException
     */
    public function scrollDown(int $height): CliCursor
    {
        if ($height < 1) {
            throw new CliCursorException('Height to scroll up must be more than 0');
        }

        echo $this->resolve(self::SCROLL_DOWN, $height);

        return $this;
    }

    /**
     * Hide cursor
     *
     * @return $this
     */
    public function hideCursor(): CliCursor
    {
        echo self::HIDE_CURSOR;

        return $this;
    }

    /**
     * @return $this
     */
    public function showCursor(): CliCursor
    {
        echo self::SHOW_CURSOR;

        return $this;
    }

    /**
     * Returns terminal width (cols)
     *
     * @return int
     */
    public function getTerminalWidth(): int
    {
        $width = [];

        $cmd = self::GET_WIDTH_COMMAND;
        $cmdBsd = self::GET_WIDTH_COMMAND_BSD;
        $command = "$cmd > /dev/null 2>&1 && $cmd || $cmdBsd";
        exec($command, $width);

        return (int) $width[0];
    }

    /**
     * Returns terminal height (lines)
     *
     * @return int
     */
    public function getTerminalHeight(): int
    {
        $height = [];

        $cmd = self::GET_HEIGHT_COMMAND;
        $cmdBsd = self::GET_HEIGHT_COMMAND_BSD;
        $command = "$cmd > /dev/null 2>&1 && $cmd || $cmdBsd";
        exec($command, $height);

        return (int) $height[0];
    }

    /**
     * Insert variable into string
     *
     * @param string $cliCode
     * @param mixed ...$params
     *
     * @return string
     */
    protected function resolve(string $cliCode, ...$params): string
    {
        $params = array_reverse($params, true);
        foreach ($params as $name => $value) {
            $name = (int) $name + 1; //Because array keys starts of 0
            $cliCode = str_replace("%{$name}", $value, $cliCode);
        }

        return $cliCode;
    }
}
