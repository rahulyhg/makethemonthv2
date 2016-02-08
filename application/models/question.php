<?php 
Class Question extends CI_Model{
    function get_all($page){
        $start_page = ($page-1)*15;
        $questions = $this->db->query("SELECT q.en_name,q.id,CASE WHEN s.en_name IS NULL THEN 'All' ELSE s.en_name END as scenario,CASE WHEN c.name IS NULL THEN 'All' ELSE c.name END as city FROM question q
        LEFT JOIN scenario s ON q.scenario = s.id
        LEFT JOIN cities c ON q.city = c.id
        where q.parent = 0 and is_custom = 0
        order by q.id desc
        LIMIT $start_page,15");
        return $questions->result();
    }
    function get_nr_pages(){
        $questions = $this->db->query("SELECT q.en_name,q.id,CASE WHEN s.en_name IS NULL THEN 'All' ELSE s.en_name END as scenario,CASE WHEN c.name IS NULL THEN 'All' ELSE c.name END as city FROM question q
        LEFT JOIN scenario s ON q.scenario = s.id
        LEFT JOIN cities c ON q.city = c.id
        where q.parent = 0 and is_custom = 0
        order by q.id desc");
        return round($questions->num_rows/15 + 1);
    }
    function get_all_custom($page){
        $start_page = ($page-1)*15;
        $questions = $this->db->query("SELECT q.en_name,q.id,CASE WHEN s.en_name IS NULL THEN 'All' ELSE s.en_name END as scenario,CASE WHEN c.name IS NULL THEN 'All' ELSE c.name END as city FROM question q
        LEFT JOIN scenario s ON q.scenario = s.id
        LEFT JOIN cities c ON q.city = c.id
        where q.parent = 0 and is_custom = 1
        order by q.id desc
        LIMIT $start_page,15");
        return $questions->result();
    }
    function get_nr_pages_custom(){
        $questions = $this->db->query("SELECT q.en_name,q.id,CASE WHEN s.en_name IS NULL THEN 'All' ELSE s.en_name END as scenario,CASE WHEN c.name IS NULL THEN 'All' ELSE c.name END as city FROM question q
        LEFT JOIN scenario s ON q.scenario = s.id
        LEFT JOIN cities c ON q.city = c.id
        where q.parent = 0 and is_custom = 1
        order by q.id desc");
        return round($questions->num_rows/15 + 1);
    }
    function add($array){
        if(isset($array['is_custom'])){
            $is_custom = 1;
        }else{
            $is_custom = 0;
        }
        $question = array(
            'en_name'=>$array['en_name'],
            'fr_name'=>$array['fr_name'],
            'is_custom'=>$is_custom,
            'en_supporting_facts' => $array['en-supporting-facts'],
            'fr_supporting_facts' => $array['fr-supporting-facts'],
            'icon'=>$array['icon'],
            'season'=>$array['season'],
            'scenario'=>$array['scenario'],
            'city'=>$array['city']
        );
        $this->db->insert('question',$question);
        $question_id = $this->db->insert_id();
        for($i=1;$i<4;$i++){
            if(!empty($array['en_answer_desc-'.$i])){
                $answer = array(
                    'en_desc' =>$array['en_answer_desc-'.$i],
                    'fr_desc' =>$array['fr_answer_desc-'.$i],
                    'en_result' =>$array['en_answer_result-'.$i],
                    'fr_result' =>$array['fr_answer_result-'.$i],
                    'stress' =>$array['en_answer_stress-'.$i],
                    'cost' =>$array['en_answer_cost-'.$i],
                    'id_question'=>$question_id
                );
                if(!empty($array['en_answer_show_help-'.$i])){
                    $answer['en_facts'] = $array['en_answer_facts-'.$i];
                    $answer['fr_facts'] = $array['en_answer_facts-'.$i];
                }else{
                    $answer['en_facts'] = "";
                    $answer['fr_facts'] = "";
                }
                if(!empty($array['en_answer_end_game-'.$i])){
                    $answer['en_end_game'] = $array['en_answer_end_game-'.$i];
                    $answer['fr_end_game'] = $array['fr_answer_end_game-'.$i];
                }else{
                    $answer['en_end_game'] = "";
                    $answer['fr_end_game'] = "";
                }
                if(!empty($array['extra_cost-'.$i])){
                    $answer['extra_cost'] = $array['extra_cost-'.$i];
                }else{
                    $answer['extra_cost'] = 0;
                }
                if(!empty($array['en_answer_show_help-'.$i])){
                    $answer['show_help'] = $array['en_answer_show_help-'.$i];
                }else{
                    $answer['show_help'] = 0;
                }
                if(!empty($array['defered_credit-'.$i])){
                    $answer['credit'] = $array['defered_credit-'.$i];
                }else{
                    $answer['credit'] = 0;
                }
                if(!empty($array['defered_bills-'.$i])){
                    $answer['bills'] = $array['defered_bills-'.$i];
                }else{
                    $answer['bills'] = 0;
                }
                if(!empty($array['defered_car-'.$i])){
                    $answer['car'] = $array['defered_car-'.$i];
                }else{
                    $answer['car'] = 0;
                }
                $this->db->insert('answers',$answer);
            }
        }
        return $question_id;
    }
    function get($id){
        $question = $this->db->get_where('question',array('id'=>$id))->result();
        $data['question'] = $question[0];
        $query = $this->db->select('*')->from('answers')->where('id_question',$id)->order_by('id','ASC')->get()->result();
        $answers = array();
        $i = 1;
        foreach($query as $answer){
            $answers['id-'.$i]=$answer->id;
            $answers['en_answer_desc-'.$i]=$answer->en_desc;
            $answers['fr_answer_desc-'.$i]=$answer->fr_desc;
            $answers['en_answer_result-'.$i]=$answer->en_result;
            $answers['fr_answer_result-'.$i]=$answer->fr_result;
            $answers['en_answer_facts-'.$i]=$answer->en_facts;
            $answers['fr_answer_facts-'.$i]=$answer->fr_facts;
            $answers['en_answer_end_game-'.$i]=$answer->en_end_game;
            $answers['fr_answer_end_game-'.$i]=$answer->fr_end_game;
            $answers['en_answer_stress-'.$i]=$answer->stress;
            $answers['en_answer_cost-'.$i]=$answer->cost;
            $answers['extra_cost-'.$i]=$answer->extra_cost;
            $answers['en_answer_strike-'.$i]=$answer->strike;
            $answers['en_answer_show_help-'.$i]=$answer->show_help;
            $answers['defered_credit-'.$i]=$answer->credit;
            $answers['defered_bills-'.$i]=$answer->bills;
            $answers['defered_car-'.$i]=$answer->car;
            $i++;
        }
        $data['answers'] = $answers;
        return $data;
    }
    function update($id,$array){
        if(isset($array['is_custom'])){
            $is_custom = 1;
        }else{
            $is_custom = 0;
        }
        $question = array(
            'en_name'=>$array['en_name'],
            'fr_name'=>$array['fr_name'],
            'is_custom'=>$is_custom,
            'en_supporting_facts' => $array['en-supporting-facts'],
            'fr_supporting_facts' => $array['fr-supporting-facts'],
            'icon'=>$array['icon'],
            'season'=>$array['season'],
            'scenario'=>$array['scenario'],
            'city'=>$array['city']
        );
        $this->db->where('id',$id);
        $this->db->update('question',$question);
        unset($question['en_custom']);
        unset($question['fr_custom']);
        $this->db->where('parent',$id);
        $this->db->update('question',$question);
        $children_ids = $this->db->select('id')->from('question')->where('parent',$id)->get()->result();
        $question_id = $id;
        for($i=1;$i<4;$i++){
            if(!empty($array['en_answer_desc-'.$i])){
                if(!empty($array['answer_id-'.$i])){
                    $answer = array(
                        'en_desc' =>$array['en_answer_desc-'.$i],
                        'fr_desc' =>$array['fr_answer_desc-'.$i],
                        'en_result' =>$array['en_answer_result-'.$i],
                        'fr_result' =>$array['fr_answer_result-'.$i],
                        'stress' =>$array['en_answer_stress-'.$i],
                        'cost' =>$array['en_answer_cost-'.$i],
                        'id_question'=>$question_id
                    );
                    if(!empty($array['en_answer_show_help-'.$i])){
                        $answer['en_facts']=$array['en_answer_facts-'.$i];
                        $answer['fr_facts']=$array['fr_answer_facts-'.$i];
                    }else{
                        $answer['en_facts']="";
                        $answer['fr_facts']="";
                    }
                    if(!empty($array['en_answer_end_game-'.$i])){
                        $answer['en_end_game'] = $array['en_answer_end_game-'.$i];
                        $answer['fr_end_game'] = $array['fr_answer_end_game-'.$i];
                    }else{
                        $answer['en_end_game'] = "";
                        $answer['fr_end_game'] = "";
                    }
                    if(!empty($array['en_answer_show_help-'.$i])){
                        $answer['show_help'] = $array['en_answer_show_help-'.$i];
                    }else{
                        $answer['show_help'] = 0;
                    }
                    if(!empty($array['extra_cost-'.$i])){
                        $answer['extra_cost'] = $array['extra_cost-'.$i];
                    }else{
                        $answer['extra_cost'] = 0;
                    }
                    if(!empty($array['en_answer_strike-'.$i])){
                        $answer['strike'] = $array['en_answer_strike-'.$i];
                    }else{
                        $answer['strike'] = 0;
                    }
                    if(!empty($array['defered_credit-'.$i])){
                        $answer['credit'] = $array['defered_credit-'.$i];
                    }else{
                        $answer['credit'] = 0;
                    }
                    if(!empty($array['defered_bills-'.$i])){
                        $answer['bills'] = $array['defered_bills-'.$i];
                    }else{
                        $answer['bills'] = 0;
                    }
                    if(!empty($array['defered_car-'.$i])){
                        $answer['car'] = $array['defered_car-'.$i];
                    }else{
                        $answer['car'] = 0;
                    }
                    $this->db->where('id',$array['answer_id-'.$i]);
                    $this->db->update('answers',$answer);
                    $data = array(
                        'en_desc' =>$array['en_answer_desc-'.$i],
                        'fr_desc' =>$array['fr_answer_desc-'.$i],
                        'en_result' =>$array['en_answer_result-'.$i],
                        'fr_result' =>$array['fr_answer_result-'.$i]
                    );
                    foreach($children_ids as $id_q){
                        $data['id_question'] = $id_q->id;
                        $answer_id = $this->db->select('id')->from('answers')->where('id_question',$id_q->id)->order_by('id','ASC')->limit($i,$i-1)->get()->result();
                        $this->db->where('id',$answer_id[0]->id);
                        $this->db->update('answers',$data);
                    }
                }else{
                    $answer = array(
                        'en_desc' =>$array['en_answer_desc-'.$i],
                        'fr_desc' =>$array['fr_answer_desc-'.$i],
                        'en_custom' =>$array['en_answer_custom-'.$i],
                        'fr_custom' =>$array['fr_answer_custom-'.$i],
                        'en_result' =>$array['en_answer_result-'.$i],
                        'fr_result' =>$array['fr_answer_result-'.$i],
                        'stress' =>$array['en_answer_stress-'.$i],
                        'cost' =>$array['en_answer_cost-'.$i],
                        'id_question'=>$question_id
                    );
                    if(!empty($array['en_answer_show_help-'.$i])){
                        $answer['en_facts']=$array['en_answer_facts-'.$i];
                        $answer['fr_facts']=$array['fr_answer_facts-'.$i];
                    }
                    if(!empty($array['en_answer_end_game-'.$i])){
                        $answer['en_end_game'] = $array['en_answer_end_game-'.$i];
                        $answer['fr_end_game'] = $array['fr_answer_end_game-'.$i];
                    }else{
                        $answer['en_end_game'] = "";
                        $answer['fr_end_game'] = "";
                    }
                    if(!empty($array['en_answer_show_help-'.$i])){
                        $answer['show_help'] = $array['en_answer_show_help-'.$i];
                    }
                    if(!empty($array['en_answer_strike-'.$i])){
                        $answer['strike'] = $array['en_answer_strike-'.$i];
                    }
                    if(!empty($array['extra_cost-'.$i])){
                        $answer['extra_cost'] = $array['extra_cost-'.$i];
                    }else{
                        $answer['extra_cost'] = 0;
                    }
                    if(!empty($array['defered_credit-'.$i])){
                        $answer['credit'] = $array['defered_credit-'.$i];
                    }
                    if(!empty($array['defered_bills-'.$i])){
                        $answer['bills'] = $array['defered_bills-'.$i];
                    }
                    if(!empty($array['defered_car-'.$i])){
                        $answer['car'] = $array['defered_car-'.$i];
                    }
                    $this->db->insert('answers',$answer);
                    foreach($children_ids as $id_q){
                        $answer['id_question'] = $id_q->id;
                        $this->db->insert('answers',$answer);
                    }
                }
            }else{
                $this->db->delete('answers',array('id'=>$array['answer_id-'.$i]));
                foreach($children_ids as $id_q){
                    $answer_id = $this->db->select('id')->from('answers')->where('id_question',$id_q->id)->order_by('id','ASC')->limit($i,$i-1)->get()->result();
                    if($answer_id){
                        $this->db->delete('answers',array('id'=>$answer_id[0]->id));
                    }
                }
            }
        }
        return 'ok';
    }
    function delete($id){
        $this->db->delete('answers',array('id_question'=>$id));
        $children_ids = $this->db->select('id')->from('question')->where('parent',$id)->get()->result();
        foreach($children_ids as $id_q){
            $this->db->delete('answers',array('id_question'=>$id_q->id));
            $this->db->delete('question',array('id'=>$id_q->id));
        }
        return $this->db->delete('question',array('id'=>$id));
    }
    function delete_local($id){
        $this->db->delete('answers',array('id_question'=>$id));
        return $this->db->delete('question',array('id'=>$id));
    }
    function get_by_filter($array,$type,$city = null){
        $where= 'WHERE ';
        if(isset($array['type']) && isset($array['city'])){
            if($array['type'] == 'all'){
                $where.= 's.id IS NULL';
            }else{
                $where.= 's.id = '.$array['type'];
            }
            $where.=' and ';
            if($array['city'] == 'all'){
                $where.= 'c.id IS NULL';
            }else{
                $where.= 'c.id = '.$array['city'];
            }
        }elseif(isset($array['type'])){
            if($array['type'] == 'all'){
                $where.= 's.id IS NULL';
            }else{
                $where.= 's.id = '.$array['type'];
            }
        }else{
            if($array['city'] == 'all'){
                $where.= 'c.id IS NULL';
            }else{
                $where.= 'c.id = '.$array['city'];
            }
        }
        if($type == "superadmin"){
            $where.=" and q.parent = 0";
        }else{
            $where.=" and ((q.city = 'all' and q.parent = 0) or q.city = $city) and q.id not IN (SELECT parent from question where city = $city)";
        }
        $questions = $this->db->query("SELECT q.en_name,q.id, q.parent,CASE WHEN s.en_name IS NULL THEN 'All' ELSE s.en_name END as scenario,CASE WHEN c.name IS NULL THEN 'All' ELSE c.name END as city FROM question q
        LEFT JOIN scenario s ON q.scenario = s.id
        LEFT JOIN cities c ON q.city = c.id
        ".$where);
        $questions = $questions->result();
        $i=1;
        $content = '';
        foreach($questions as $question){
            if($i%2==0){
                $class = 'even';
            }else{
                $class = '';
            }
            if($question->parent == 0){
                $class.= ' need-edited';
            }
            $content.='
            <li class="'.$class.'">
                <div class="no">'.$question->id.'</div>
                <div class="long-text">'.$question->en_name.'</div>
                <div class="for-city has-filter">'.$question->scenario.'</div>
                <div class="for-city has-filter">'.$question->city.'</div>
                <div class="options">
                    <a href="'.WEBSITE_URL.$type.'/questions/edit/'.$question->id.'" class="button-box edit">Edit</a>';
            if($type == 'superadmin'){
                $content.='<a href="'.WEBSITE_URL.'superadmin/questions/delete/'.$question->id.'" class="button-box delete">Delete</a>';
            }
            $content.='</div>
            </li>';
            $i++;
        }     
        return $content; 
    }

    function get_local($city,$page){
        $start_page = ($page-1)*15;
        $questions = $this->db->query("SELECT q.en_name,q.id,CASE WHEN s.en_name IS NULL THEN 'All' ELSE s.en_name END as scenario,CASE WHEN c.name IS NULL THEN 'All' ELSE c.name END as city, q.parent
        FROM question q
        LEFT JOIN scenario s ON q.scenario = s.id
        LEFT JOIN cities c ON q.city = c.id
        Where ((q.city = 'all' and q.parent = 0) or q.city = $city) and q.id not IN (SELECT parent from question where city = $city)  and q.is_custom = 0
        order by q.parent ASC,q.id desc
        LIMIT $start_page,15");
        return $questions->result();
    }
    function get_local_custom($city,$page){
        $start_page = ($page-1)*15;
        $questions = $this->db->query("SELECT q.en_name,q.id,CASE WHEN s.en_name IS NULL THEN 'All' ELSE s.en_name END as scenario,CASE WHEN c.name IS NULL THEN 'All' ELSE c.name END as city, q.parent
        FROM question q
        LEFT JOIN scenario s ON q.scenario = s.id
        LEFT JOIN cities c ON q.city = c.id
        Where ((q.city = 'all' and q.parent = 0) or q.city = $city) and q.id not IN (SELECT parent from question where city = $city) and q.is_custom = 1
        order by q.parent ASC,q.id desc
        LIMIT $start_page,15");
        return $questions->result();
    }
    function get_nr_pages_local($city){
        $questions = $this->db->query("SELECT q.en_name,q.id,CASE WHEN s.en_name IS NULL THEN 'All' ELSE s.en_name END as scenario,CASE WHEN c.name IS NULL THEN 'All' ELSE c.name END as city, q.parent
        FROM question q
        LEFT JOIN scenario s ON q.scenario = s.id
        LEFT JOIN cities c ON q.city = c.id
        Where ((q.city = 'all' and q.parent = 0) or q.city = $city) and q.id not IN (SELECT parent from question where city = $city) and q.is_custom = 0");
        return round($questions->num_rows/15 + 1);
    }
    function get_nr_pages_local_custom($city){
        $questions = $this->db->query("SELECT q.en_name,q.id,CASE WHEN s.en_name IS NULL THEN 'All' ELSE s.en_name END as scenario,CASE WHEN c.name IS NULL THEN 'All' ELSE c.name END as city, q.parent
        FROM question q
        LEFT JOIN scenario s ON q.scenario = s.id
        LEFT JOIN cities c ON q.city = c.id
        Where ((q.city = 'all' and q.parent = 0) or q.city = $city) and q.id not IN (SELECT parent from question where city = $city) and q.is_custom = 1");
        return round($questions->num_rows/15 + 1);
    }
    function update_local($id,$array,$city){
        $question = $this->db->get_where('question',array('id'=>$id))->result();
        if($question[0]->parent>0 && $question[0]->city == $city){
            $data = array(
                'en_custom' =>isset($array['en_custom'])?$array['en_custom']:"",
                'fr_custom' =>isset($array['fr_custom'])?$array['fr_custom']:"",
                'en_supporting_facts' => $array['en-supporting-facts'],
                'fr_supporting_facts' => $array['fr-supporting-facts'],
            );
            $this->db->where('id',$id);
            $this->db->update('question',$data);
            for($i=1;$i<4;$i++){
                if(!empty($array['en_answer_desc-'.$i])){
                    if(!empty($array['answer_id-'.$i])){
                        $answer = array(
                            'cost' =>$array['en_answer_cost-'.$i]
                        );
                        if(!empty($array['en_answer_show_help-'.$i])){
                            $answer['show_help'] = $array['en_answer_show_help-'.$i];
                        }else{
                            $answer['show_help'] = 0;
                        }
                        if(!empty($array['en_answer_show_help-'.$i])){
                            $answer['en_facts']=$array['en_answer_facts-'.$i];
                            $answer['fr_facts']=$array['fr_answer_facts-'.$i];
                        }else{
                            $answer['en_facts'] = "";
                            $answer['fr_facts'] = "";
                        }
                        if(!empty($array['extra_cost-'.$i])){
                            $answer['extra_cost'] = $array['extra_cost-'.$i];
                        }else{
                            $answer['extra_cost'] = 0;
                        }
                        if(!empty($array['en_answer_end_game-'.$i])){
                            $answer['en_end_game'] = $array['en_answer_end_game-'.$i];
                            $answer['fr_end_game'] = $array['fr_answer_end_game-'.$i];
                        }else{
                            $answer['en_end_game'] = "";
                            $answer['fr_end_game'] = "";
                        }
                        $this->db->where('id',$array['answer_id-'.$i]);
                        $this->db->update('answers',$answer);
                    }
                }
            }
            return 'ok';
        }else{
            $question = $question[0];
            $question->en_custom = isset($array['en_custom'])?$array['en_custom']:"";
            $question->fr_custom = isset($array['fr_custom'])?$array['fr_custom']:"";
            $question->fr_supporting_facts = isset($array['fr-supporting-facts'])?$array['fr-supporting-facts']:"";
            $question->en_supporting_facts = isset($array['en-supporting-facts'])?$array['en-supporting-facts']:"";
            $question->city = $city;
            $question->parent = $question->id;
            $question = (array) $question;
            unset($question['id']);
            $this->db->insert('question',$question);
            $question_id = $this->db->insert_id();
            for($i=1;$i<4;$i++){
                if(!empty($array['en_answer_desc-'.$i])){
                    $answer = array(
                        'en_desc' =>$array['en_answer_desc-'.$i],
                        'fr_desc' =>$array['fr_answer_desc-'.$i],
                        'en_result' =>$array['en_answer_result-'.$i],
                        'fr_result' =>$array['fr_answer_result-'.$i],
                        'stress' =>$array['en_answer_stress-'.$i],
                        'cost' =>$array['en_answer_cost-'.$i],
                        'id_question'=>$question_id
                    );
                    if(!empty($array['en_answer_show_help-'.$i])){
                        $answer['en_facts']=$array['en_answer_facts-'.$i];
                        $answer['fr_facts']=$array['fr_answer_facts-'.$i];
                    }
                    if(!empty($array['en_answer_end_game-'.$i])){
                        $answer['en_end_game'] = $array['en_answer_end_game-'.$i];
                        $answer['fr_end_game'] = $array['fr_answer_end_game-'.$i];
                    }else{
                        $answer['en_end_game'] = "";
                        $answer['fr_end_game'] = "";
                    }
                    if(!empty($array['en_answer_show_help-'.$i])){
                        $answer['show_help'] = $array['en_answer_show_help-'.$i];
                    }
                    if(!empty($array['en_answer_strike-'.$i])){
                        $answer['strike'] = $array['en_answer_strike-'.$i];
                    }
                    if(!empty($array['extra_cost-'.$i])){
                        $answer['extra_cost'] = $array['extra_cost-'.$i];
                    }else{
                        $answer['extra_cost'] = 0;
                    }
                    if(!empty($array['defered_credit-'.$i])){
                        $answer['credit'] = $array['defered_credit-'.$i];
                    }
                    if(!empty($array['defered_bills-'.$i])){
                        $answer['bills'] = $array['defered_bills-'.$i];
                    }
                    if(!empty($array['defered_car-'.$i])){
                        $answer['car'] = $array['defered_car-'.$i];
                    }
                    $this->db->insert('answers',$answer);
                }
            }
            return $question_id;
        }
    }
    function check_if($id,$city){
        $questions = $this->db->query("SELECT COUNT(*) as total FROM question q
        LEFT JOIN scenario s ON q.scenario = s.id
        LEFT JOIN cities c ON q.city = c.id
        Where ((q.city = 'all' and q.parent = 0) or q.city = $city) and q.id not IN (SELECT parent from question where city = $city) AND q.id = $id")->result();
        if($questions[0]->total == 1){
            return false;
        }
        return true;
    }
    function get_frontend($id){
        $question = $this->db->get_where('question',array('id'=>$id))->result();
        $data['question'] = $question[0];
        $data['answers'] = $this->db->select('*')->from('answers')->where('id_question',$id)->order_by('id','ASC')->get()->result();
        return $data;
    }
    function get_answer($id){
        $this->db->select('a.*,q.en_supporting_facts, q.fr_supporting_facts');
        $this->db->from('answers a');
        $this->db->join('question q','a.id_question = q.id');
        $this->db->where('a.id',$id);
        $answer = $this->db->get()->result();
        return $answer[0];
    }
    function get_ids($city,$scenario,$not_in = ""){
        if($not_in){
            $where = implode(',',$not_in);
            $where = ' and q.id not in ('.$where.') and q.parent not in ('.$where.')';
        }
        $questions = $this->db->query("SELECT q.id FROM question q
        WHERE q.city = $city and q.parent <> 0 and (q.scenario = 'all' or q.scenario = (SELECT CASE WHEN s.parent = 0 THEN s.id ELSE s.parent END FROM scenario s
        WHERE s.id = $scenario))".@$where);
        $data = array();
        foreach($questions->result() as $id){
            $data[] = $id->id;
        }
        return $data;
    }
}
?>