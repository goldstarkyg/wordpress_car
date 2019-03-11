<?php
//---------------------------------------
//variables for website design

$collumCount = 4;
$cellPadding = 4;
$cellSpacing = 4;
$tableBorder = 'none';
$tdWidth = 130;
$makeColor = '#FFFFFF';
$makeCountColor = 'rgb(255, 255, 255)';

//---------------------------------------

    $makes = array();
    foreach($this->car_list as $car)
    {
        if(array_key_exists($car->Make, $makes))
        {
            $makes[$car->Make] += 1;
        }else
        {
            $makes[$car->Make] = 1;
        }
    }
    ksort($makes);
    
    $rowCount;
    if(count($makes)%$collumCount > 0)
    {
        $rowCount = (count($makes)/$collumCount) + 1;
    }else
    {
        $rowCount = count($makes)/$collumCount;
    }
?>

<table id='makesTable' cellspacing='<?php echo $cellSpacing; ?>' cellpadding='<?php echo cellPadding; ?>' border='<?php echo $tableBorder; ?>'>
    <tbody>
        <?php
        $keys = array_keys($makes);
        for($row=0; $row<$rowCount; $row++)
        {
            echo '<tr>';
            for($col=0; $col<$collumCount; $col++)
            {
                if(count($makes) > ($row * $collumCount) + $col)
                {
                    ?>
                    <td align="left" style="color: <?php echo $makeCountColor ?>; width: <?php echo $tdWidth ?>; border: none;">
                        <span><a href="/inventory/?mk=<?php echo $keys[($row * $collumCount) + $col] ?>" style="text-decoration: none;"><?php echo $keys[($row * $collumCount) + $col] ?></a> (<?php echo $makes[$keys[($row * $collumCount) + $col]] ?>)</span>
                    </td>
                    <?php
                }else
                {
                    echo '<td></td>';
                }
            }
            echo '</tr>';
        }
        ?> 
    </tbody>
</table>