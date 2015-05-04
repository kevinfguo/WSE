<?php
ini_set('display_errors', true); ini_set('display_startup_errors', true); error_reporting(E_ALL);

function printpre($obj) {
    echo '<pre>';
    if(is_object($obj) || is_array($obj)) {
        print_r ($obj);
    } else {
       echo $obj;
    } 
    echo '</pre>';
  }

function cmp($a,$b){
	if ($a["count"] == $b["count"]) {
        return 0;
    }
    return ($a["count"] > $b["count"]) ? -1 : 1;
}

function opinion_val($val){
	if ($val > 0.2){
		return 'positively';
	}else if ($val <= 0.2 && $val > 0){
		return 'slightly positively';
	}else if ($val == 0){
		return 'neutrally';
	}else if ($val < 0 && $val >= -0.2){
		return 'slightly negatively';
	}else{
		return 'negatively';
	}
}
?>