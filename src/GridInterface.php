<?php

namespace Ajax\GridApp;

interface GridInterface
{
    /**
     * @return int
     */
    public function getHeight(): int;
    /**
     * @return int
     */
    public function getWidth(): int;
}
