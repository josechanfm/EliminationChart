<?php
class Bouts_scheduler {
	protected $CI;
    public function __construct()
    {
		$this->CI =& get_instance();
        $this->CI->load->model('match_contests_model','contests');
        $this->CI->load->model('match_programs_model','programs');
        $this->CI->load->model('match_programs_athletes_model','athletes');
        $this->CI->load->model('match_bouts_model','bouts');
        $this->CI->load->library('bouts_sequence');
        $this->CI->load->library('bouts_scheduler');
    }
    public function generate($contestId=377){
    	$result=array(
    		'set_programs'=>$this->set_programs($contestId),
    		'set_bouts'=>$this->set_bouts($contestId),
    		'set_bouts_schedule'=>$this->set_bouts_schedule($contestId)
    	);
    	return isset($result)?$result:false;
    }
    private function set_programs($contestId=null){
        $gameSizeSetting=array(
            'RRB'=>array(2,3,4,5,6),
            'ERM'=>array(7,8)
        );
        //$contest=$this->contests->get($contestId);
        $programs=$this->CI->programs->get_many_by('contest_id',$contestId);
        foreach($programs as $p){
            $athleteCount=$this->CI->athletes->count_by('program_id',$p->id);
            $chartSize=pow(2,strlen(decbin($athleteCount-1)));
            $data=[];
            if($athleteCount<=5){
                $data['contest_system']='RRB';
                $data['chart_size']=$athleteCount;
            }else{
                $data['contest_system']='ERM';
                $data['chart_size']=$chartSize;
            }
            $result=$this->CI->programs->update($p->id,$data);
        }
        return isset($result)?$result:false;
    }
    private function set_bouts($contestId=null){
        $contest=$this->CI->contests->get($contestId);
        //echo json_encode($contest);
        $contestSections=$this->get_contest_sections($contestId);
        //$contestSections=$this->db->select('date,mat,section,count(*) as count')->where('contest_id',$contestId)->group_by('date,mat,section')->order_by('date,mat,section')->get('match_programs')->result();
        //echo json_encode($contestSections);

        $result=array('created'=>[],'exists'=>[]);
        foreach($contestSections as $cs){
            $programs=$this->CI->programs->get_many_by(array('contest_id'=>$contest->id,'date'=>$cs->date,'mat'=>$cs->mat, 'section'=>$cs->section));
            foreach($programs as $p){
                $boutCount=$this->CI->bouts->count_by('program_id',$p->id);
                if($boutCount<=0){
                    $athletes=$this->CI->athletes->get_many_by('program_id',$p->id);
                    //prepare and call different 賽制, RRB=>循環賽, EER=>淘汰賽
                    $f='get_'.strtolower($p->contest_system).'_bouts';
                    $data=$this->$f($p,$athletes);
                    $result['created'][$p->id]=$this->CI->bouts->insert_many($data,TRUE);
                }else{
                    $result['exists'][]=$p->id;
                }
            }
        }
        return isset($result)?$result:false;
    }

    private function set_bouts_schedule($contestId=null){
        $contestSections=$this->get_contest_sections($contestId);
        //echo json_encode($contestSections);
        foreach($contestSections as $cs){
            $programs=$this->CI->programs->get_many_by(array('contest_id'=>$contestId,'date'=>$cs->date,'mat'=>$cs->mat, 'section'=>$cs->section));
            $programIds=array_column(json_decode(json_encode($programs),TRUE),'id');
            $bouts=$this->CI->bouts->get_many_by('program_id',$programIds);
            $data=$this->set_sequence($programs,$bouts);
            if(is_array($data)){
                $result=$this->CI->db->update_batch('match_bouts',$data,'id');
            }
        }
        return isset($result)?$result:false;
    }

    private function set_sequence($programs,$bouts){
    	//echo json_encode($programs);
        $bouts=json_decode(json_encode($bouts),true);
   		// echo json_encode($programs);
   		// echo '############';
   		// echo json_encode($bouts);
   		if(sizeof($bouts)<=0){
   			return false;
   		}
        $roundMax=max(array_column(json_decode(json_encode($bouts),TRUE),'round'));
        //echo json_encode($roundMax);
        $counter=0;
       	$data=[];
        while($roundMax>2){
        	//filter 
			$mBouts=array_filter($bouts,function($data) use($roundMax){return $data['round']==$roundMax;});
			//echo json_encode($mBouts);
			$column=array_column($mBouts,'program_sequence');
			array_multisort($column, SORT_ASC, $mBouts);
			foreach ($mBouts as $mb) {
				$data[]=array(
					'id'=>$mb['id'],
					'serial'=>$counter++
				);
				# code...
			}
			$roundMax/=2;
        }
		//repechage first round
		$mBouts=array_filter($bouts,function($data) use($roundMax){return $data['round']==-3;});
		$column=array_column($mBouts,'program_sequence');
		array_multisort($column, SORT_ASC, $mBouts);
		foreach ($mBouts as $mb) {
			$data[]=array(
				'id'=>$mb['id'],
				'serial'=>$counter++
			);
		}
        //repechage second round
	    $mBouts=array_filter($bouts,function($data) use($roundMax){return $data['round']==-2;});
	    $column=array_column($mBouts,'program_sequence');
		array_multisort($column, SORT_ASC, $mBouts);
		foreach ($mBouts as $mb) {
			$data[]=array(
				'id'=>$mb['id'],
				'serial'=>$counter++
			);
		}
        //Final round
	    $mBouts=array_filter($bouts,function($data) use($roundMax){return $data['round']==2;});
	    $column=array_column($mBouts,'program_sequence');
		array_multisort($column, SORT_ASC, $mBouts);
		foreach ($mBouts as $mb) {
			$data[]=array(
				'id'=>$mb['id'],
				'serial'=>$counter++
			);
		}

     //    echo '-3, ';
     //    echo '-2, ';
     //    echo '2<br>';

    	// echo sizeof($bouts);
    	// echo '====';
    	// echo sizeof($programs);
    	// echo '<br>';
		//echo json_encode($data);
    	return $data;
    }
	private function get_rrb_bouts($program,$athletes){
        $chartSize=$program->chart_size;
        //跟據人數提取對賽輪次表
		$promotionList=$this->get_promotion_rrb($program->chart_size);
		//echo json_encode($promotionList);
		$data=[];
		foreach($promotionList as $i=>$pl){
				$data[]=array(
					'program_id'=>$program->id,
					'program_sequence'=>$program->sequence,
					'date'=>$program->date,
					'mat'=>$program->mat,
					'sequence'=>$i++,
	                'contest_system'=>$program->contest_system,
					'round'=>$pl['round'],
					'white'=>$pl['white'],
					'blue'=>$pl['blue'],
				);
		}
		//echo json_encode($data);
		return $data;
	}
    private function get_erm_bouts($program,$athletes){
        $chartSize=$program->chart_size;
        $prelims=$chartSize-2;
        $repechage=4;
        $final=1;
        $totalBouts=$prelims+$repechage+$final;
        $data=[];
        for($i=0;$i<$totalBouts;$i++){
            $data[]=array(
                'program_id'=>$program->id,
                'program_sequence'=>$program->sequence,
                'date'=>$program->date,
                'mat'=>$program->mat,
                'sequence'=>$i,
                'contest_system'=>$program->contest_system,
            );
        }
        //set each round
        $i=0;
        for($cs=$chartSize;$cs>=4;$cs=$cs/2){
            for($k=0;$k<$cs/2;$k++){
                $data[$i]['round']=$cs;
                $i++;
            }
        }
        //復活賽
        $data[$i++]['round']=-3;
        $data[$i++]['round']=-3;
        $data[$i++]['round']=-2;
        $data[$i++]['round']=-2;
        $data[$i++]['round']=2;

        //assign athletes to bout of bule and white
        foreach($athletes as $i=>$athlete){
            if($athlete->seat!==NULL){
                $color=$athlete->seat%2==0?'white':'blue';
                $num=(int)($athlete->seat/2);
                $data[$num][$color]=$athlete->athlete_id;
            }
        }
        return $data;
	}
    private function get_promotion_erm($chartSize){
        ///普級
        $totalBouts=$chartSize+2;
        $winner=0;
        $startPoint=$chartSize/2;
        for($j=0;$j<$startPoint-2;$j++){
            $rise[$startPoint+$j]['white']=$winner++;
            $rise[$startPoint+$j]['blue']=$winner++;
        }
        //repechage first round
        $rise[$totalBouts-5]['white']=($totalBouts-11)*-1;
        $rise[$totalBouts-5]['blue']=($totalBouts-10)*-1;
        $rise[$totalBouts-4]['white']=($totalBouts-9)*-1;
        $rise[$totalBouts-4]['blue']=($totalBouts-8)*-1;

        //repechage second round
        $rise[$totalBouts-3]['blue']=($totalBouts-7)*-1;
        $rise[$totalBouts-2]['blue']=($totalBouts-6)*-1;
        $rise[$totalBouts-3]['white']=($totalBouts-5);
        $rise[$totalBouts-2]['white']=($totalBouts-4);

        //final
        $rise[$totalBouts-1]['white']=$totalBouts-7;
        $rise[$totalBouts-1]['blue']=$totalBouts-6;
        return $rise;
    }
    private function get_promotion_rrb($chartSize=1){
		$arr=array(
			5=>array(
				32=>array([2,5],[3,4]),
				16=>array([1,5],[2,3]),
				8=>array([1,4],[5,3]),
				4=>array([1,3],[4,2]),
				2=>array([1,2],[4,5]),
			),
			4=>array(
				8=>array([1,4],[2,3]),
				4=>array([1,3],[4,2]),
				2=>array([1,2],[3,4]),
			),
			3=>array(
				8=>array([2,3]),
				4=>array([1,3]),
				2=>array([1,2]),
			),
			2=>array(
				2=>array([1,2])
			),
			1=>array(
				2=>array([1,1])
			),
			0=>array(
			)
		);
		$rise=[];
		$i=0;
		foreach($arr[$chartSize] as $round=>$bouts){
			foreach ($bouts as $r) {
				$rise[]=array(
					'round'=>$round,
					'white'=>$r[0]-1,
					'blue'=>$r[1]-1,
					// 'white'=>$ath[$r[0]-1]->athlete_id,
					// 'blue'=>$ath[$r[1]-1]->athlete_id,
				);
			}
		}
		// foreach($data as $i=>$d){
		// 	echo json_encode($d);
		// 	echo '<br>';
		// }
		// echo '<hr>';

		return $rise;
    }
    public function get_contest_sections($contestId){
        return $this->CI->db->select('date,mat,section,count(*) as count')->where('contest_id',$contestId)->group_by('date,mat,section')->order_by('date,mat,section')->get('match_programs')->result();

    }

}
