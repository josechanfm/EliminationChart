
<svg width="760" height="1000">
	<?php
		$yStart=30;
		$xLeft=45;
		$xRight=430;
		$hBox=18;
		$wBox=160;
		$fontSize=14;
		$wLine=18;
		$hGap=20;
		$yNamePadding=14;
		$xNamePadding=10;
		$rx=5;
	for($i=0;$i<32;$i++){
		$y=$hGap*$i+$yStart;
		$yName=$y+$yNamePadding;
		$xName=$xLeft+$xNamePadding;
  		echo '<rect height="'.$hBox.'" width="'.$wBox.'" y="'.$y.'" x="'.$xLeft.'" stroke="#000" fill="#fff" rx="'.$rx.'"/>';
  		echo '<text xml:space="preserve" text-anchor="start" font-family="Noto Sans JP" font-size="'.$fontSize.'" y="'.$yName.'" x="'.$xName.'" stroke-width="0" stroke="#000" fill="#000000">'.$athletes[$i].'</text>';
	}

	for($i=0;$i<32;$i++){
		$y=$hGap*$i+$yStart;
		$yName=$y+$yNamePadding;
		$xName=$xRight+$wBox-$xNamePadding;
  		echo '<rect height="'.$hBox.'" width="'.$wBox.'" y="'.$y.'" x="'.$xRight.'" stroke="#000" fill="#fff" rx="'.$rx.'"/>';
  		echo '<text xml:space="preserve" text-anchor="end" font-family="Noto Sans JP" font-size="'.$fontSize.'" y="'.$yName.'" x="'.$xName.'" stroke-width="0" stroke="#000" fill="#000000">'.$athletes[$i+32].'</text>';
	}

	$lx1=$xLeft+$wBox;
	$rx1=$xRight;
	$y1=($yStart+$hBox/2);
	for($i=0;$i<16;$i++){
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
	$rx1=$xRight-$wLine;
	$y1=$yStart+($hBox+$hGap)/2;
	for($i=0;$i<8;$i++){
		$lx2=$lx1+$wLine;
		$rx2=$rx1-$wLine;
		$y2=$y1+$hGap*2;
		$line=array($lx1,$y1,$lx2,$y1,$lx2,$y2,$lx1,$y2);
		echo '<polyline points="'.implode(',',$line).'"
            fill="none" stroke="black" />';	
		$line=array($rx1,$y1,$rx2,$y1,$rx2,$y2,$rx1,$y2);
		echo '<polyline points="'.implode(',',$line).'"
            fill="none" stroke="black" />';	
		$y1+=$hGap*4;
	}

	$lx1=$xLeft+$wBox+($wLine*2);
	$rx1=$xRight-($wLine*2);
	$y1=$yStart+($hBox/2)+($hGap/2*3);
	for($i=0;$i<4;$i++){
		$lx2=$lx1+$wLine;
		$rx2=$rx1-$wLine;
		$y2=$y1+($hBox/2)+($hGap/2*7);
		$line=array($lx1,$y1,$lx2,$y1,$lx2,$y2,$lx1,$y2);
		echo '<polyline points="'.implode(',',$line).'"
            fill="none" stroke="black" />';	
		$line=array($rx1,$y1,$rx2,$y1,$rx2,$y2,$rx1,$y2);
		echo '<polyline points="'.implode(',',$line).'"
            fill="none" stroke="black" />';	
		$y1+=$hGap*8;
	}

	$lx1=$xLeft+$wBox+($wLine*3);
	$rx1=$xRight-($wLine*3);
	$y1=$yStart+($hBox/2)+($hGap/2*7);
	for($i=0;$i<2;$i++){
		$lx2=$lx1+$wLine;
		$rx2=$rx1-$wLine;
		$y2=$y1+($hBox/2)+($hGap/2*15);
		$line=array($lx1,$y1,$lx2,$y1,$lx2,$y2,$lx1,$y2);
		echo '<polyline points="'.implode(',',$line).'"
            fill="none" stroke="black" />';	
		$line=array($rx1,$y1,$rx2,$y1,$rx2,$y2,$rx1,$y2);
		echo '<polyline points="'.implode(',',$line).'"
            fill="none" stroke="black" />';	
		$y1+=$hGap*16;
	}


	$lx1=$xLeft+$wBox+($wLine*4);
	$rx1=$xRight-($wLine*4);
	$y1=$yStart+($hBox/2)+($hGap/2*15);
	$lx2=$lx1+$wLine;
	$rx2=$rx1-$wLine;
	$y2=$y1+($hBox/2)+($hGap/2*31);
	$line=array($lx1,$y1,$lx2,$y1,$lx2,$y2,$lx1,$y2);
	echo '<polyline points="'.implode(',',$line).'"
        fill="none" stroke="black" />';	
	$line=array($rx1,$y1,$rx2,$y1,$rx2,$y2,$rx1,$y2);
	echo '<polyline points="'.implode(',',$line).'"
        fill="none" stroke="black" />';	

    $x1=$xLeft+$wBox+($wLine*5);
    $y1=$yStart+($hBox/2)+($hGap/2*30);
    $x2=$xRight-($wLine*5);
	$line=array($x1,$y1,$x2,$y1);
	echo '<polyline points="'.implode(',',$line).'"
        fill="none" stroke="black" />';	

	$data=array(
		'yStart'=>800,
		'xLeft'=>$xLeft,
		'xRight'=>$xRight,
		'hBox'=>25,
		'wBox'=>$wBox,
		'fontSize'=>$fontSize,
		'wLine'=>50,
		'hGap'=>30,
		'yNamePadding'=>16,
		'xNamePadding'=>10,
		'rx'=>10,
		'repechage'=>$repechage
	);
	echo $this->load->view('pdf_svg_repechage',$data,true);
	$edgeData=array(
		'scaleHeight'=>2.7,
		'edgeGap'=>118,
		'scaleX'=>-38,
		'scaleY'=>($yStart-28),
		'rotateY'=>190,
		'rotateX'=>318,
		'rotateGap'=>318,
		'pairs'=>'2',
		'textLeft'=>$xLeft-16,
		'textRight'=>$xRight+175,
		'textUp'=>$yStart+140,
		'textDown'=>$yStart+460,
		'textRotatePadding'=>45,
	);
	echo $this->load->view('pdf_svg_edge',$edgeData,true);

	?>
</svg>
