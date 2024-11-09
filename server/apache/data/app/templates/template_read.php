<table class='<?php echo $theme ?>'>
    <tr>
        <?php
            foreach ($heads as $head) 
                echo "<th>" . $head . "</th>";
        ?>
    </tr>
    <?php
        foreach ($rows as $row) {
            echo "<tr>";
            foreach ($columns as $col)
                echo "<td>" . $row[$col] . "</td>";
            echo "</tr>";
        }
    ?>
</table>
