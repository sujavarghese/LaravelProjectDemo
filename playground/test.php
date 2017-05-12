<?php

echo 'Hello';
$b = '4MRA-63';
$ada = '4MRA-63-02';
$p = str_replace('-', '\-', $b);
echo $p;
$bname_pattern = '/^'.$p.'*/';
print '\n';
echo preg_match($bname_pattern, $ada).'<br>';
$ada2 = '4MRA-62-01';
echo preg_match($bname_pattern, $ada2).'<br>';

?>