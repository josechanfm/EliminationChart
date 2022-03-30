
<svg width="760" height="1000">
	<?php
		$yStart=150;
		$xLeft=80;
		$xRight=450;
		$hBox=50;
		$wBox=140;
		$fontSize=20;
		$wLine=50;
		$hGap=100;
		$yNamePadding=25;
		$xNamePadding=10;
		$rx=15;
	for($i=0;$i<4;$i++){
		$y=$hGap*$i+$yStart;
		$yName=$y+$yNamePadding;
		$xName=$xLeft+$xNamePadding;
  		echo '<rect height="'.$hBox.'" width="'.$wBox.'" y="'.$y.'" x="'.$xLeft.'" stroke="#000" fill="#fff" rx="'.$rx.'"/>';
  		echo '<text xml:space="preserve" text-anchor="start" font-family="Noto Sans JP" font-size="'.$fontSize.'" y="'.$yName.'" x="'.$xName.'" stroke-width="0" stroke="#000" fill="#000000">sadsfa</text>';
	}

	for($i=0;$i<4;$i++){
		$y=$hGap*$i+$yStart;
		$yName=$y+$yNamePadding;
		$xName=$xRight+$wBox-$xNamePadding;
  		echo '<rect height="'.$hBox.'" width="'.$wBox.'" y="'.$y.'" x="'.$xRight.'" stroke="#000" fill="#fff" rx="'.$rx.'"/>';
  		echo '<text xml:space="preserve" text-anchor="end" font-family="Noto Sans JP" font-size="'.$fontSize.'" y="'.$yName.'" x="'.$xName.'" stroke-width="0" stroke="#000" fill="#000000">aaaaaa</text>';
	}

	$lx1=$xLeft+$wBox;
	$rx1=$xRight;
	$y1=($yStart+$hBox/2);
	for($i=0;$i<2;$i++){
		$lx2=$lx1+$wLine;
		$rx2=$rx1-$wLine;
		$y2=$y1+$hGap;
		$line=array($lx1,$y1,$lx2,$y1,$lx2,$y2,$lx1,$y2);
		echo '<polyline points="'.implode(',',$line).'"
            fill="none" stroke="black" />';	
		$line=array($rx1,$y1,$rx2,$y1,$rx2,$y2,$rx1,$y2);
		echo '<polyline points="'.implode(',',$line).'"
            fill="none" stroke="black" />';	
		$y1+=$hGap*2;
	}

	$lx1=$xLeft+$wBox+$wLine;
	$rx1=$xRight-($wLine);
	$y1=$yStart+($hBox/2)+($hGap/2);
	$lx2=$lx1+$wLine;
	$rx2=$rx1-$wLine;
	$y2=$y1+($hBox/2*3)+($hGap);
	$line=array($lx1,$y1,$lx2,$y1,$lx2,$y2,$lx1,$y2);
	echo '<polyline points="'.implode(',',$line).'"
        fill="none" stroke="black" />';	
	$line=array($rx1,$y1,$rx2,$y1,$rx2,$y2,$rx1,$y2);
	echo '<polyline points="'.implode(',',$line).'"
        fill="none" stroke="black" />';	

    $x1=$xLeft+$wBox+($wLine*2);
    $y1=$yStart+($hBox/2)+($hGap/2*3);
    $x2=$xRight-($wLine*2);
	$line=array($x1,$y1,$x2,$y1);
	echo '<polyline points="'.implode(',',$line).'"
        fill="none" stroke="black" />';	
	

	$data=array(
		'yStart'=>600,
		'xLeft'=>$xLeft,
		'xRight'=>$xRight,
		'hBox'=>30,
		'wBox'=>$wBox,
		'fontSize'=>$fontSize,
		'wLine'=>50,
		'hGap'=>40,
		'yNamePadding'=>20,
		'xNamePadding'=>10,
		'rx'=>10,
	);
	echo $this->load->view('pdf_svg_repechage',$data,true);

	$edgeData=array(
		'scaleHeight'=>1.2,
		'edgeGap'=>165,
		'scaleX'=>-10,
		'scaleY'=>($yStart-30),
		'rotateY'=>225,
		'rotateX'=>335,
		'rotateGap'=>200,
		'pairs'=>'2',
		'textLeft'=>$xLeft-20,
		'textRight'=>$xRight+160,
		'textUp'=>$yStart+50,
		'textDown'=>$yStart+250,
		'textRotatePadding'=>45,
	);
	echo $this->load->view('pdf_svg_edge',$edgeData,true);

	// //draw Edge shape
	// $scaleHeight=1.2;
	// $edgeGap=20;
	// $scaleX=-10;
	// $scaleY=($yStart-30);
	// $rotateY=225;
	// drawEdge($scaleX,$scaleY,$rotateY,$scaleHeight);

	// $scaleY=$scaleY+165;
	// $rotateY+=200;
	// drawEdge($scaleX,$scaleY,$rotateY,$scaleHeight);


	?>


</svg>


<?php
 function drawEdge2($scaleX,$scaleY,$rotateY,$scaleHeight){
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

/*
M75,111 
L57,111 
L57,111 
C47,111 
39,142 
39,181 
C39,220 
47,251 
57,251 
L75,251 
L75,111 
 */
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
		z' style='color: rgb(0, 0, 0);' class='selected' fill-opacity='1' height='{$scaleHeight}' transform='rotate(180 335,{$rotateY});'/>
		";
	echo $shape31;
	echo $shape32;

}?>

<!--
<path fill='#ffffff' stroke='#222222' stroke-width='1' stroke-linejoin='round' stroke-dashoffset='' fill-rule='nonzero' marker-start='' marker-mid='' marker-end='' id='svg_1' d='
M75,111 
L57,111 
L57,111 
C47,111 
39,142 
39,181 
C39,220 
47,251 
57,251 
L75,251 
L75,111 
z' style='color: rgb(0, 0, 0);' class='selected' fill-opacity='1'/>
-->