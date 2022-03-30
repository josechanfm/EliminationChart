<?php
// $scaleHeight=1.2;
// $edgeGap=20;
// $scaleX=-10;
// $scaleY=($yStart-30);
// $rotateY=225;
for($i=0;$i<$pairs;$i++){
	drawEdge($scaleX,$scaleY,$rotateX,$rotateY,$scaleHeight);
	$scaleY=$scaleY+$edgeGap;
	$rotateY+=$rotateGap;
}

$textA="<g transform='translate({$textLeft}, {$textUp})'><text text-anchor='end' transform='rotate(-90)' font-size='16px'>Pool A</text></g>";
$textB="<g transform='translate({$textLeft}, {$textDown})'><text text-anchor='end' transform='rotate(-90)' font-size='16px'>Pool B</text></g>";
$textUp+=$textRotatePadding;
$textDown+=$textRotatePadding;
$textC="<g transform='translate({$textRight}, {$textUp})'><text text-anchor='end' transform='rotate(90)' font-size='16px'>Pool C</text></g>";
$textD="<g transform='translate({$textRight}, {$textDown})'><text text-anchor='end' transform='rotate(90)' font-size='16px'>Pool D</text></g>";

echo $textA;
echo $textB;
echo $textC;
echo $textD;
//drawEdge($scaleX,$scaleY,$rotateX,$rotateY,$scaleHeight);

// $scaleY=$scaleY+$edgeGap;
// $rotateY+=$rotateGap;
// drawEdge($scaleX,$scaleY,$rotateX,$rotateY,$scaleHeight);

function drawEdge($scaleX,$scaleY,$rotateX,$rotateY,$scaleHeight){
    $s=array(
    	$scaleX+75,$scaleY+11,
    	$scaleX+57,$scaleY+11,
    	$scaleX+57,$scaleY+11,
    	$scaleX+47,$scaleY+11,
    	$scaleX+39,$scaleY+37,
    	$scaleX+39,$scaleY+69,
    	$scaleX+39,$scaleY+101,
    	$scaleX+47,$scaleY+126,
    	$scaleX+57,$scaleY+126,
    	$scaleX+75,$scaleY+126,
    	$scaleX+75,$scaleY+11,
    );

	$shape31="<path fill='#ffffff' stroke='#222222' stroke-width='1' stroke-linejoin='round' stroke-dashoffset='' fill-rule='nonzero' marker-start='' marker-mid='' marker-end='' id='svg_1' d='
		M{$s[0]},{$s[1]}
		L{$s[2]},{$s[3]} 
		L{$s[4]},{$s[5]} 
		C{$s[6]},{$s[7]} 
		{$s[8]},{$s[9]} 
		{$s[10]},{$s[11]} 
		C{$s[12]},{$s[13]} 
		{$s[14]},{$s[15]} 
		{$s[16]},{$s[17]} 
		L{$s[18]},{$s[19]} 
		L{$s[20]},{$s[21]} 
		z' style='color: rgb(0, 0, 0);' class='selected' fill-opacity='1' height='{$scaleHeight}'/>
		";
	$scaleY=197+$scaleY;
	$shape32="<path fill='#ffffff' stroke='#222222' stroke-width='1' stroke-linejoin='round' stroke-dashoffset='' fill-rule='nonzero' marker-start='' marker-mid='' marker-end='' id='svg_1' d='
		M{$s[0]},{$s[1]}
		L{$s[2]},{$s[3]} 
		L{$s[4]},{$s[5]} 
		C{$s[6]},{$s[7]} 
		{$s[8]},{$s[9]} 
		{$s[10]},{$s[11]} 
		C{$s[12]},{$s[13]} 
		{$s[14]},{$s[15]} 
		{$s[16]},{$s[17]} 
		L{$s[18]},{$s[19]} 
		L{$s[20]},{$s[21]} 
		z' style='color: rgb(0, 0, 0);' class='selected' fill-opacity='1' height='{$scaleHeight}' transform='rotate(180 $rotateX,{$rotateY});'/>
		";
	echo $shape31;
	echo $shape32;
}
?>