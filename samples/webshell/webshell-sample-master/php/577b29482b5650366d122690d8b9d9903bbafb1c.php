<?php

$a=กฏ`!@#$%^&*()_+~-=\\|][}{\'";:?/.,><';

$a1=str_split($a);

for ($i=0; $i < count($a1); $i++) {

    for ($j=0; $j < count($a1)-1; $j++) {

        echo $a1[$i] ." + ".$a1[$j] ."=". ($a1[$i] ^$a1[$j]);

		echo "<br>";

	}

}
?>