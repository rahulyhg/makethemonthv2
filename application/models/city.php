<?php 
Class City extends CI_Model{
    function get_all(){
        $query = $this->db->select('*')->from('cities')->order_by('name','ASC')->get()->result();
        $data = array();
        foreach($query as $city){
            $last = $this->db->select('MAX(u.last_login) as last_login')->from('cities c')->join('user_details ud','c.id = ud.city')->join('user u','u.id = ud.user_id')->where('c.id',$city->id)->get()->result();
            $city->last_login = $last[0]->last_login;
            if($city->last_login == ""){
                $city->last_login = 'No user for this city';
            }
            $data[]=$city;
        }
        return $data;
    }
    function change_status($id,$status){
        $this->db->where('id',$id);
        $query = $this->db->update('cities',array('status'=>$status));
        return $query;
    }
    function add_city($name,$code){
        $this->db->select('id');
        $this->db->from('cities');
        $this->db->where('m_code',$code);
        $exist = $this->db->count_all_results();
        if($exist>0){
            return 'This city is already in database..';
        }
        $data = array(
            'name'=>$name,
            'm_code'=>$code
        );
        return $this->db->insert('cities',$data);
    }
    function load_city($id = null){
        if($id == ""){
            return false;
        }
        $city = $this->db->get_where('cities',array('id'=>$id))->result();
        if($city[0]->id != $city[0]->q_id){
            $city_main = $this->db->get_where('cities',array('q_id'=>$city[0]->q_id))->result();
            $city[0]->en_facts = $city_main[0]->en_facts;
            $city[0]->fr_facts = $city_main[0]->fr_facts;
        }
        return $city[0];
    }
    function update_local($id,$array){
        $data = array(
            'url_donate'=>$array['url-donate'],
            'en_facts'=>$array['en_city-facts'],
            'fr_facts'=>$array['fr_city-facts'],
            'do_more'=>$array['do-more'],
            'invest'=>$array['invest'],
            'involved'=>$array['involved']
        );
        $this->db->where('id',$id);
        return $this->db->update('cities',$data);
    }
}
?>