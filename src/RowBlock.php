<?php

namespace Ajax\GridApp;

class RowBlock
{
    protected $width;
    protected $height;
    protected $color;
    protected $bgColor;
    protected $align;
    protected $vAlign;
    protected $text;
    protected $positionColumn;
    protected $positionRow;

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getBgColor(): string
    {
        return $this->bgColor;
    }

    /**
     * @param string $bgColor
     */
    public function setBgColor(string $bgColor): void
    {
        $this->bgColor = $bgColor;
    }

    /**
     * @return string
     */
    public function getAlign(): string
    {
        return $this->align;
    }

    /**
     * @param string $align
     */
    public function setAlign(string $align): void
    {
        $this->align = $align;
    }

    /**
     * @return string
     */
    public function getVAlign(): string
    {
        return $this->vAlign;
    }

    /**
     * @param string $vAlign
     */
    public function setVAlign(string $vAlign): void
    {
        $this->vAlign = $vAlign;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return int
     */
    public function getPositionColumn(): int
    {
        return $this->positionColumn;
    }

    /**
     * @param int $positionColumn
     */
    public function setPositionColumn(int $positionColumn): void
    {
        $this->positionColumn = $positionColumn;
    }

    /**
     * @return int
     */
    public function getPositionRow(): int
    {
        return $this->positionRow;
    }

    /**
     * @param int $positionRow
     */
    public function setPositionRow(int $positionRow): void
    {
        $this->positionRow = $positionRow;
    }

}
