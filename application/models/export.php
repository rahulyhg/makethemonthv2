<?php 
Class Export extends CI_Model{
    function get_questions($city){
        $questions = $this->db->query("SELECT q.en_name,q.id,CASE WHEN s.en_name IS NULL THEN 'All' ELSE s.en_name END as scenario,CASE WHEN c.name IS NULL THEN 'All' ELSE c.name END as city, q.en_custom,q.en_supporting_facts
        FROM question q
        LEFT JOIN scenario s ON q.scenario = s.id
        LEFT JOIN cities c ON q.city = c.id
        Where ((q.city = 'all' and q.parent = 0) or q.city = $city) and q.id not IN (SELECT parent from question where city = $city)");
        $data = array();
        foreach($questions->result() as $question){
            $need = 'false';
            if($question->city == "all"){
                $need = 'true';
            }
            $data[]= array('NEED EDIT',$need);
            $data[]= array('Question Id',$question->id);
            $data[]= array('Question name',$question->en_name);
            $data[]= array('Custom',$question->en_custom);
            $data[]= array('Scenario',$question->scenario);
            $data[]= array('Facts',$question->en_supporting_facts);
            $answer = $this->db->get_where('answers',array('id_question'=>$question->id));
            $answer = $answer->result();
            $data[] = array('Option-1',@$answer[0]->en_desc);
            $data[] = array('Option-2',@$answer[1]->en_desc);
            $data[] = array('Option-3',@$answer[2]->en_desc);
            $data[] = array('Consequence-1',@$answer[0]->en_result);
            $data[] = array('Consequence-2',@$answer[1]->en_result);
            $data[] = array('Consequence-3',@$answer[2]->en_result);
            $data[] = array('Cost-1',@$answer[0]->cost);
            $data[] = array('Cost-2',@$answer[1]->cost);
            $data[] = array('Cost-3',@$answer[2]->cost);
            $data[] = array('Extra-1',@$answer[0]->extra_cost);
            $data[] = array('Extra-2',@$answer[1]->extra_cost);
            $data[] = array('Extra-3',@$answer[2]->extra_cost);
            $data[] = array('End Game-1',@$answer[0]->en_end_game);
            $data[] = array('End Game-2',@$answer[1]->en_end_game);
            $data[] = array('End Game-3',@$answer[2]->en_end_game);
            $data[] = array('UW is here-1',@$answer[0]->en_custom);
            $data[] = array('UW is here-2',@$answer[1]->en_custom);
            $data[] = array('UW is here-3',@$answer[2]->en_custom);
            $data[] = array('','');
        }
        return $data;
    }
}
?>