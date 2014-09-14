<?php

foreach ($employers as $employer) {
    echo $this->Html->tableCells($employer);
}
echo "<br><br><br><br><br><br>";
print_r($employers);