<?php 
Class Stats extends CI_Model{
    function create($city){
        $data = array(
            'city' => $city
        );
        $this->db->insert('sts_general',$data);
        return $this->db->insert_id();
    }
    function update($id,$info){
        $data = array(
            'information'=>json_encode($info)
        );
        $this->db->where('id',$id);
        $this->db->update('sts_general',$data);
    }
    function get_all_cities(){
        $result = $this->db->select('information')->from('sts_general')->where('information is not null',null,false)->get()->result();
        $data = array();
        foreach($result as $sts){
            $info = array();
            $json = json_decode($sts->information);
            if(isset($json->city)){
                $city = $this->db->select('name')->from('cities')->where('id',$json->city)->get()->result();
                $info['city'] = $city[0]->name;
                $info['end'] = $json->final == 'false'?0:($json->end == 'lose'?-1:1);
                $data[] = $info;
            }
        }
        return $data;
    }
    function get_city($id){
        $where = array(
            'information is not null'=>null,
            'city'=>$id
        );
        $result = $this->db->select('information')->from('sts_general')->where($where)->get()->result();
        $data = array();
        foreach($result as $sts){
            $info = array();
            $json = json_decode($sts->information);
            if(isset($json->city)) {
                $info['end'] = $json->final == 'false' ? 0 : ($json->end == 'lose' ? -1 : 1);
                $data[] = $info;
            }
        }
        return $data;
    }
    function get_played_time($filter = null){
        if(!empty($filter)){
            $where = "and";
            if(isset($filter['status'])){
                switch($filter['status']){
                    case 1:
                        $where.= ' information like \'%"end":"win"%\'';
                        break;
                    case 2:
                        $where.= ' information like \'%"end":"lose"%\'';
                        break;
                    default:
                        $where.= ' information like \'%"final":"false"%\'';
                        break;
                }
            }
            if(isset($filter['status']) && (isset($filter['scenario']) || isset($filter['city']))){
                $where.= ' and ';
            }
            if(isset($filter['scenario']) && !isset($filter['city'])){
                $scenarioIds = $this->db->get_where('scenario',array('parent'=>$filter['scenario']))->result();
                $where.=' (';
                foreach($scenarioIds as $scenario){
                    $where.= ' information like \'%"scenario":"'.$scenario->id.'"%\' or';
                }
                $where = rtrim($where,'or').') ';
            }elseif(isset($filter['scenario']) && isset($filter['city'])){
                $scenarioId = $this->db->get_where('scenario',array('city'=>$filter['city'],'parent'=>$filter['scenario']))->result();
                if(empty($scenarioId)){
                    return false;
                }
                $where.= ' information like \'%"scenario":"'.$scenarioId[0]->id.'"%\' and ';
            }
            if(isset($filter['city'])){
                $where.=' city = '.$filter['city'];
            }
        }
        $sql = "Select YEAR(add_on) as 'year', Month(add_on) as month, day(add_on) as day, COUNT(*) as total from sts_general
        where information is not null ".@$where."
        GROUP by Year(add_on), Month(add_on), day(add_on)";
        $result = $this->db->query($sql)->result();
        return $result;
    }
    function get_played_time_city($id,$filter = null){
        if(!empty($filter)){
            $where = "and";
            if(isset($filter['status'])){
                switch($filter['status']){
                    case 1:
                        $where.= ' information like \'%"end":"win"%\'';
                        break;
                    case 2:
                        $where.= ' information like \'%"end":"lose"%\'';
                        break;
                    default:
                        $where.= ' information like \'%"final":"false"%\'';
                        break;
                }
            }
            if(isset($filter['status']) && isset($filter['scenario'])){
                $where.= ' and ';
            }
            if(isset($filter['scenario'])){
                $scenarioId = $this->db->get_where('scenario',array('city'=>$id,'parent'=>$filter['scenario']))->result();
                if(empty($scenarioId)){
                    return false;
                }
                $where.= ' information like \'%"scenario":"'.$scenarioId[0]->id.'"%\'';
            }
        }
        $sql = "Select YEAR(add_on) as 'year', Month(add_on) as month, day(add_on) as day, COUNT(*) as total from sts_general
        WHERE city = $id and information is not null ".@$where."
        GROUP by Year(add_on), Month(add_on), day(add_on)";
        $result = $this->db->query($sql)->result();
        return $result;
    }
    function start_end($id = null){
        if(!is_null($id)){
            $where = " WHERE city = ".$id;
        }
        $start = $this->db->query('select add_on from sts_general '.@$where.' order BY add_on ASC limit 1')->result();
        $start = explode(" ",$start[0]->add_on);
        $end = $this->db->query('select add_on from sts_general '.@$where.' order BY add_on DESC limit 1')->result();
        $end = explode(" ",$end[0]->add_on);
        $data = array(
            'start'=>$start[0],
            'end'=>$end[0]
        );
        return $data;
    }
    function download_track($id = null,$filter = array()){
        if(!empty($filter)){
            $where = "";
            if(isset($filter['status']) && $filter['status'] != ""){
                switch($filter['status']){
                    case 1:
                        $where.= ' and information like \'%"end":"win"%\'';
                        break;
                    case 2:
                        $where.= ' and information like \'%"end":"lose"%\'';
                        break;
                    default:
                        $where.= ' and information like \'%"final":"false"%\'';
                        break;
                }
            }
            if(isset($filter['scenario']) && $filter['scenario'] != ""){
                if(!isset($filter['city'])){
                    $scenarioIds = $this->db->get_where('scenario',array('parent'=>$filter['scenario']))->result();
                    $where.=' and (';
                    foreach($scenarioIds as $scenario){
                        $where.= ' information like \'%"scenario":"'.$scenario->id.'"%\' or';
                    }
                    $where = rtrim($where,'or').') ';
                }else{
                    $scenarioId = $this->db->get_where('scenario',array('city'=>$filter['city'],'parent'=>$filter['scenario']))->result();
                    if(empty($scenarioId)){
                        return false;
                    }
                    $where.= ' and information like \'%"scenario":"'.$scenarioId[0]->id.'"%\' ';
                }
            }
            if(isset($filter['city']) && $filter['city'] != ""){
                $where.=' and city = '.$filter['city'];
            }
            if(isset($filter['from-date'])){
                $where.=' and add_on > "'.$filter['from-date'].'" ';
            }
            if(isset($filter['to-date'])){
                $where.=' and add_on < "'.$filter['to-date'].'" ';
            }
        }
        if(!is_null($id)){
            $city = ' and city = '.$id;
        }
        $sql = "SELECT information FROM sts_general
                WHERE information IS NOT NULL AND information LIKE '%question%' ".@$city." ".@$where."
                ORDER BY add_on DESC";
        $results = $this->db->query($sql)->result();
        $data = array();
        $i = 1;
        foreach($results as $player){
            $player = json_decode($player->information);
            $days = (array) $player->day;
            $day = end($days);
            $question = $this->db->select('en_name')->from('question')->where('id',$day->question)->get()->result();
            if(isset($day->answer)){
                $answer = $this->db->select('en_desc')->from('answers')->where('id',$day->answer)->get()->result();
            }
            $city = $this->db->select('name')->from('cities')->where('id',$player->city)->get()->result();
            $scenario = $this->db->select('en_name')->from('scenario')->where('id',$player->scenario)->get()->result();
            $info = array(
                $i,
                @$city[0]->name,
                @$scenario[0]->en_name,
                $player->rent,
                count($days),
                $day->question,
                @$question[0]->en_name,
                @$answer[0]->en_desc,
                ($player->final == "false"?"Give Up":($player->end == "lose"?"Lose":"Win"))
            );
            $data[] = $info;
            $i++;
        }
        return $data;
    }
}
?>