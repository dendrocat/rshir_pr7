<?php

class Model_Services {

    public function draw($id, $size) {
        $c = intdiv($size, 2);
        switch ($id % 3) {
            case 0:
                return "<circle cx='{$c}' cy='{$c}' r='{$c}' fill='red'>";
            case 1:
                return "<rect width='100%' height='100%' fill='blue'>";
            case 2:
                return "<polygon points='{$c},0 0,{$size} {$size},{$size}' fill='green'>";
        }
    }

    public function sortShell($arr) {
        $size = count($arr);
        $step = intdiv($size, 2);
        while ($step > 0) {
            for ($i = $step; $i < $size; ++$i) 
                for ($j = $i - $step; $j >= 0; $j -= $step) {
                    $prev = $j + $step;
                    if ($arr[$j] > $arr[$prev])
                        [$arr[$j], $arr[$prev]] = [$arr[$prev], $arr[$j]];
                }
            $step = intdiv($step, 2);
        }
        return $arr;
    }

    public function exec($com) {
        return shell_exec($com);
    }
}


?>