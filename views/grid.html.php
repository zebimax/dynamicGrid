<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Grid app example</title>
    <link rel="stylesheet" type="text/css" href="css/app.css">
</head>
<body>
<div class="container">
    <table class="grid-table">
        <?php
        $rows = $gridView['rows'];
        use Ajax\GridApp\RowBlock;
        /** @var RowBlock $item */
        foreach ($rows as $row):
            echo '<tr>';
            $rowBlocks =  $row['items'];
            foreach ($rowBlocks as $item):
                echo sprintf(
                    '<td rowspan="%s" colspan="%s" style="text-align: %s;vertical-align: %s;color: %s;background-color: %s">%s</td>',
                    $item->getHeight(),
                    $item->getWidth(),
                    $item->getAlign(),
                    $item->getVAlign(),
                    $item->getColor(),
                    $item->getBgColor(),
                    $item->getText()
                );
            endforeach;
            echo '</tr>';
        endforeach;
        ?>
    </table>
</div>
</body>
</html>
