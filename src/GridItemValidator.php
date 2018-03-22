<?php

namespace Ajax\GridApp;

class GridItemValidator implements GridItemValidatorInterface
{
    const TEXT_KEY    = 'text';
    const CELLS_KEY   = 'cells';
    const ALIGN_KEY   = 'align';
    const VALIGN_KEY  = 'valign';
    const COLOR_KEY   = 'color';
    const BGCOLOR_KEY = 'bgcolor';

    protected $namedColors  = [
        'aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure', 'beige', 'bisque', 'black',
        'blanchedalmond', 'blue', 'blueviolet', 'brown', 'burlywood', 'cadetblue', 'chartreuse',
        'chocolate', 'coral', 'cornflowerblue', 'cornsilk', 'crimson', 'cyan', 'darkblue', 'darkcyan',
        'darkgoldenrod', 'darkgray', 'darkgreen', 'darkkhaki', 'darkmagenta', 'darkolivegreen', 'darkorange',
        'darkorchid', 'darkred', 'darksalmon', 'darkseagreen', 'darkslateblue', 'darkslategray', 'darkturquoise',
        'darkviolet', 'deeppink', 'deepskyblue', 'dimgray', 'dodgerblue', 'firebrick', 'floralwhite', 'forestgreen',
        'fuchsia', 'gainsboro', 'ghostwhite', 'gold', 'goldenrod', 'gray', 'green', 'greenyellow', 'honeydew',
        'hotpink', 'indianred', 'indigo', 'ivory', 'khaki', 'lavender', 'lavenderblush', 'lawngreen', 'lemonchiffon',
        'lightblue', 'lightcoral', 'lightcyan', 'lightgoldenrodyellow', 'lightgreen', 'lightgrey', 'lightpink',
        'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray', 'lightsteelblue', 'lightyellow', 'lime',
        'limegreen', 'linen', 'magenta', 'maroon', 'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple',
        'mediumseagreen', 'mediumslateblue', 'mediumspringgreen', 'mediumturquoise', 'mediumvioletred', 'midnightblue',
        'mintcream', 'mistyrose', 'moccasin', 'navajowhite', 'navy', 'oldlace', 'olive', 'olivedrab', 'orange',
        'orangered', 'orchid', 'palegoldenrod', 'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip',
        'peachpuff', 'peru', 'pink', 'plum', 'powderblue', 'purple', 'red', 'rosybrown', 'royalblue', 'saddlebrown',
        'salmon', 'sandybrown', 'seagreen', 'seashell', 'sienna', 'silver', 'skyblue', 'slateblue', 'slategray',
        'snow', 'springgreen', 'steelblue', 'tan', 'teal', 'thistle', 'tomato', 'turquoise', 'violet', 'wheat',
        'white', 'whitesmoke', 'yellow', 'yellowgreen'
    ];
    protected $alignValues  = ['left', 'center', 'right', 'justify', 'char'];
    protected $vAlignValues = ['top', 'middle', 'bottom', 'baseline'];

    /**
     * {@inheritdoc}
     */
    public function validateGridItem(array $itemConfig, int $maxCellNumber)
    {
        $block = [];
        foreach ($itemConfig as $configKey => $configValue) {
            switch ($configKey) {
                case self::TEXT_KEY:
                    $block['text'] = (string)$configValue;
                    break;
                case self::CELLS_KEY:
                    $block['cells'] = $this->validateCells($configValue, $maxCellNumber);
                    break;
                case self::ALIGN_KEY:
                    $block['align'] = $this->validateAlign($configValue);
                    break;
                case self::VALIGN_KEY:
                    $block['valign'] = $this->validateVAlign($configValue);
                    break;
                case self::COLOR_KEY:
                    $block['color'] = $this->validateHtmlColor($configValue);
                    break;
                case self::BGCOLOR_KEY:
                    $block['bgcolor'] = $this->validateHtmlColor($configValue);
                    break;
                default:
                    throw new \InvalidArgumentException(
                        sprintf('Unknown config key "%s"', $configKey)
                    );
            }
        }

        return $block;
    }

    /**
     * @param string $cells
     * @param int    $maxCellNumber
     *
     * @return array
     */
    protected function validateCells(string $cells, int $maxCellNumber): array
    {
        $cellItems = explode(',', $cells);
        if (empty($cellItems)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid cells value "%s"', $cells)
            );
        }
        if (min($cellItems) < 1 || max($cellItems) > $maxCellNumber) {
            throw new \InvalidArgumentException(
                sprintf('Cell value must be between "%s" and "%s"', 1, $maxCellNumber)
            );
        }

        return $cellItems;
    }

    /**
     * Validates 3 or 6 hex color or named color , adding #-sign if not found.
     *
     * @param string $color the color hex value or color name string to validate
     *
     * @return string
     */
    protected function validateHtmlColor(string $color): string
    {
        if (in_array(strtolower($color), $this->namedColors)) {
            // A color name was entered instead of a Hex Value, so just exit
            return $color;
        }

        if (preg_match('/^#([a-f0-9]{6}|[a-f0-9]{3})$/i', $color)) {
            // Verified OK
        } elseif (preg_match('/^([a-f0-9]{6}|[a-f0-9]{3})$/i', $color)) {
            $color = '#' . $color;
        }

        return $color;
    }

    /**
     * Validates align value
     *
     * @param string $value
     *
     * @return string
     */
    protected function validateAlign(string $value): string
    {
        if (!in_array($value, $this->alignValues)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid align value "%s"', $value)
            );
        }

        return $value;
    }

    /**
     * Validates valign value
     *
     * @param string $value
     *
     * @return string
     */
    protected function validateVAlign(string $value): string
    {
        if (!in_array($value, $this->vAlignValues)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid valign value "%s"', $value)
            );
        }

        return $value;
    }
}
