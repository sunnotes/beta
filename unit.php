<?php
$reg = '/(^cx$)|(^js[1-9][0-9]*(\.[0-9]{2})?$)/';
$tmp = 'js12.31';
if(preg_match($reg, $tmp))
echo 'yes';
else
echo 'no';
?>