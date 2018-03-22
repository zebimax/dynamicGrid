<?php

namespace Ajax\GridApp;

class SquareGridBuilder
{
    const EMPTY_BLOCK_ALIGN = 'center';
    const EMPTY_BLOCK_VALIGN = 'middle';
    const EMPTY_BLOCK_COLOR = '#000';
    const EMPTY_BLOCK_BGCOLOR = '#fff';

    /** @var GridInterface */
    protected $grid;
    /** @var GridItemValidatorInterface */
    protected $gridValidator;

    /**
     * GridBuilder constructor.
     *
     * @param GridInterface     $grid
     * @param GridItemValidatorInterface $validator
     */
    public function __construct(GridInterface $grid, GridItemValidatorInterface $validator)
    {
        $this->grid          = $grid;
        $this->gridValidator = $validator;
    }

    /**
     * @param array $items
     *
     * @return array returns array of grid rows with array of row items
     */
    public function buildView(array $items): array
    {
        $usedGridCells = [];
        $rowBlocks     = [];
        $maxCellNumber = $this->grid->getHeight() * $this->grid->getWidth();
        foreach ($items as $item) {
            $block = $this->gridValidator->validateGridItem($item, $maxCellNumber);
            foreach ($block['cells'] as $cellsItem) {
                if (in_array($cellsItem, $usedGridCells)) {
                    throw new \InvalidArgumentException(
                        sprintf('Cell %s was used more than once', $cellsItem)
                    );
                }
                $usedGridCells[] = $cellsItem;
            }
            $rowBlock = $this->createBlock($block['cells']);

            $rowBlock->setText($block['text']);
            $rowBlock->setBgColor($block['bgcolor']);
            $rowBlock->setColor($block['color']);
            $rowBlock->setAlign($block['align']);
            $rowBlock->setVAlign($block['valign']);
            $rowBlocks[] = $rowBlock;
        }
        $sorted = $this->finishGridRows($maxCellNumber, $usedGridCells, $rowBlocks);

        return ['rows' => $sorted];
    }

    /**
     * Creates RowBlock for each config item cells
     *
     * @param array $cells
     *
     * @return RowBlock
     */
    protected function createBlock(array $cells): RowBlock
    {
        $block      = new RowBlock();
        $gridWidth  = $this->grid->getWidth();
        $gridHeight = $this->grid->getHeight();
        $blockRows  = [];
        foreach ($cells as $cell) {
            $cellRow               = intdiv($cell - 1, $gridHeight) + 1;
            $cellColumn            = $cell % $gridWidth ? : $gridWidth;
            $blockRows[$cellRow][] = $cellColumn;
        }
        $this->assertCellsMakeRectangle($blockRows);

        $columns = current($blockRows);

        $block->setHeight(count($blockRows));
        $block->setWidth(count($columns));
        $block->setPositionColumn(min($columns));
        $block->setPositionRow(min(array_keys($blockRows)));

        return $block;
    }

    /**
     * @param $maxCellNumber
     * @param $usedGridCells
     * @param $rowBlocks
     *
     * @return array
     */
    protected function finishGridRows(int $maxCellNumber, array $usedGridCells, array $rowBlocks): array
    {
        $allCells   = range(1, $maxCellNumber);
        $unused     = array_diff($allCells, $usedGridCells);
        $restBlocks = $this->makeEmptyBlocks($unused);
        $allBlocks  = array_merge($rowBlocks, $restBlocks);
        $rows = [];
        $gridHeight = $this->grid->getHeight();
        /** @var RowBlock $block */
        for ($i = 1; $i <= $gridHeight; $i++) {
            foreach ($allBlocks as $block) {
                if ($block->getPositionRow() === $i) {
                    $rows[$i]['items'][] = $block;
                }
            }
        }
        $sorted = [];
        foreach ($rows as $key => $row) {
            $sorted[$key]['items'] = $this->sortRowBlocks($row['items']);
        }

        return $sorted;
    }

    /**
     * Makes array of RowBlock for each unused cell
     *
     * @param array $unusedCells
     *
     * @return RowBlock[]
     */
    protected function makeEmptyBlocks(array $unusedCells): array
    {
        $emptyBlocks = [];
        foreach ($unusedCells as $unusedCell) {
            $rowBlock = $this->createBlock([$unusedCell]);
            $rowBlock->setText($unusedCell);
            $rowBlock->setAlign(self::EMPTY_BLOCK_ALIGN);
            $rowBlock->setVAlign(self::EMPTY_BLOCK_VALIGN);
            $rowBlock->setColor(self::EMPTY_BLOCK_COLOR);
            $rowBlock->setBgColor(self::EMPTY_BLOCK_BGCOLOR);

            $emptyBlocks[] = $rowBlock;
        }

        return $emptyBlocks;
    }

    /**
     * Sorts blocks by start column position
     *
     * @param array $rowBlocks
     *
     * @return array
     */
    protected function sortRowBlocks(array $rowBlocks): array
    {
        uasort(
            $rowBlocks,
            function (RowBlock $firstRow, RowBlock $secondRow) {
                $firstRowColumn  = $firstRow->getPositionColumn();
                $secondRowColumn = $secondRow->getPositionColumn();

                return ($firstRowColumn < $secondRowColumn) ? -1 : 1;
            }
        );

        return $rowBlocks;
    }

    /**
     * Checks that provided cells make rectangle in grid
     *
     * @param array $blockRows
     */
    protected function assertCellsMakeRectangle(array $blockRows): void
    {
        $firstRowArray       = array_slice($blockRows, 0, 1, true);
        $restRows            = array_slice($blockRows, 1, null, true);
        $firstRow            = current($firstRowArray);
        $currentKey          = key($firstRowArray);
        $currentColumn       = current($firstRow);
        $firstRowRestColumns = array_slice($firstRow, 1, null, true);
        foreach ($firstRowRestColumns as $columnNumber) {
            if ($currentColumn + 1 !== $columnNumber) {
                throw new \InvalidArgumentException('Block items are invalid');
            }
            $currentColumn = $columnNumber;
        }
        foreach ($restRows as $key => $row) {
            if ($currentKey + 1 !== $key) {
                throw new \InvalidArgumentException('Block items are invalid');
            }
            if ($row !== $firstRow) {
                throw new \InvalidArgumentException('Block items are invalid');
            }
            $currentKey = $key;
        }
    }
}
