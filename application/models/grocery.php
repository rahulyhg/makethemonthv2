<?php 
Class Grocery extends CI_Model{
    function load_master(){
        $this->db->select('*');
        $this->db->from('grocery');
        $this->db->where('city IS NULL');
        $grocery = $this->db->get()->result();
        if(empty($grocery)){
            return false;
        }else{
            $data = array();
            $data['grocery'] = $grocery[0];
            $this->db->select('*');
            $this->db->from('grocery_option');
            $this->db->where('id_grocery',$grocery[0]->id);
            $this->db->order_by('id','ASC');
            $options = $this->db->get()->result();
            $data['options'] = $options;
            return $data;
        }
    }
    function update_master($array){
        $data = array(
            'en_name'=>$array['en_name'],
            'fr_name'=>$array['fr_name'],
            'general_icon'=>$array['icon'],
            'en_adition'=>$array['en_adition'],
            'fr_adition'=>$array['fr_adition']  
        );
        $this->db->where('city IS NULL');
        $this->db->update('grocery',$data);
        for($i=1;$i<4;$i++){
            $info = array(
                'icon'=>$array['icon-'.$i],
                'en_name'=>$array['en_answer_desc-'.$i],
                'fr_name'=>$array['fr_answer_desc-'.$i],
                'en_content'=>$array['en_answer_result-'.$i],
                'fr_content'=>$array['fr_answer_result-'.$i],
                'cost'=>$array['answer_cost-'.$i]
            );
            $this->db->where('id',$array['option_id-'.$i]);
            $this->db->update('grocery_option',$info);
        }
        return true;
    }
    function load_local($city){
        $this->db->select('*');
        $this->db->from('grocery');
        $this->db->where('city',$city);
        $grocery = $this->db->get()->result();
        if(empty($grocery)){
            $this->db->select('*');
            $this->db->from('grocery');
            $this->db->where('city IS NULL');
            $this->db->order_by('id','ASC');
            $grocery = $this->db->get()->result();
            if(empty($grocery)){
                return false;
            }
        }
        $data = array();
        $data['grocery'] = $grocery[0];
        $this->db->select('*');
        $this->db->from('grocery_option');
        $this->db->where('id_grocery',$grocery[0]->id);
        $this->db->order_by('id','ASC');
        $options = $this->db->get()->result();
        $data['options'] = $options;
        return $data;
    }
    function update_local($city,$array){
        $this->db->select('id');
        $this->db->from('grocery');
        $this->db->where('city',$city);
        $grocery = $this->db->get()->result();
        if(empty($grocery)){
            $this->db->select('*');
            $this->db->from('grocery');
            $this->db->where('city IS NULL');
            $grocery = $this->db->get()->result();
            $grocery = $grocery[0];
            $data = array(
                'en_name'=>$grocery->en_name,
                'fr_name'=>$grocery->fr_name,
                'general_icon'=>$grocery->general_icon,
                'en_adition'=>$array['en_adition'],
                'fr_adition'=>$array['fr_adition'],
                'city'=>$city
            );
            $this->db->insert('grocery',$data);
            $grocery_id = $this->db->insert_id();
            $this->db->select('*');
            $this->db->from('grocery_option');
            $this->db->where('id_grocery',$grocery->id);
            $this->db->order_by('id','ASC');
            $options = $this->db->get()->result();
            $i = 1;
            foreach($options as $option){
                $info = array(
                    'icon'=>$option->icon,
                    'en_name'=>$option->en_name,
                    'fr_name'=>$option->fr_name,
                    'en_content'=>$option->en_content,
                    'fr_content'=>$option->fr_content,
                    'cost'=>$array['answer_cost-'.$i],
                    'id_grocery'=>$grocery_id
                );
                $this->db->insert('grocery_option',$info);
                $i++;
            }
        }else{
            $data = array(
                'en_adition'=>$array['en_adition'],
                'fr_adition'=>$array['fr_adition']
            );     
            $this->db->where('city',$city);
            $this->db->update('grocery',$data);
            for($i=1;$i<4;$i++){
                $info = array(
                    'cost'=>$array['answer_cost-'.$i]
                );
                $this->db->where('id',$array['option_id-'.$i]);
                $this->db->update('grocery_option',$info);
            }
        }   
        return true;
    }
}
?>