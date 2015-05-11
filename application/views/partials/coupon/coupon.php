<h1>
    Coupon
</h1>
<?php
include '../flashes';
if($coupon){
echo "coupon: ".$coupon->title;
}else{
    echo 'no coupon set';
}
