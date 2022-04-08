<?php 

class Match_programs_model extends MY_Model {
	public $has_many = array( 'bouts' => array( 
		'model' => 'match_bouts_model',
		'primary_key'=>'program_id', 
	) );

    function ajax_view_match_programs_contests($contest_id){
        return $this->db->where('contest_id',$contest_id)->get('view_match_programs_contests')->result();
    }
}