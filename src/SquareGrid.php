<?php

namespace Ajax\GridApp;

class SquareGrid implements GridInterface
{
    /** @var int */
    protected $width;

    /** @var int */
    protected $height;

    /**
     * @param int $size
     */
    public function __construct(int $size)
    {
        $this->height = $size;
        $this->width = $size;
    }

    /**
     * {@inheritdoc}
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight(): int
    {
        return $this->height;
    }
}
