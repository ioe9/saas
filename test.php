<?php
function xrange($start,$end,$step=1) {
	for ($i=$start;$i<=$end;$i+=$step) {
		yield $i;
	}
}
$a = memory_get_usage();
//$letter = range(1,1000000);
foreach (xrange(1,1000000) as $i) {
	echo $i;
};


$b = memory_get_usage();
echo (int)(($b-$a)/1024);
echo 'KB';
?>