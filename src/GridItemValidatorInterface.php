<?php

namespace Ajax\GridApp;

interface GridItemValidatorInterface
{
    /**
     * @param array $itemConfig
     * @param int   $maxCellNumber
     *
     * @return array returns validated grid item config
     */
    public function validateGridItem(array $itemConfig, int $maxCellNumber);
}
