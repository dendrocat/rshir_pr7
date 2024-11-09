<?php
    if (isset($until)) {
        $p = "<p>Массив до сортировки: ";
        foreach($until as $el) 
            $p .= $el . " ";
        echo $p . "</p>";
        $p = "<p>Массив после сортировки: ";
        foreach($after as $el) 
            $p .= $el . " ";
        echo $p . "</p>";
    }
?>