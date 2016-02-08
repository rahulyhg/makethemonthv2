<?php 
Class F_emails extends CI_Model{
    function invite_users($name, $email, $arg,$day){
        $id = $this->db->select('id')->from('f_users')->where('email',$email)->get()->result();
        if(empty($id)){
            $data = array(
                'name' => $name,
                'email'=> $email,
                'day'=>$day
            );
            $this->db->insert('f_users',$data);
            $id = $this->db->insert_id();
        }else{
            $id = $id[0]->id;
        }
        $ci = get_instance();
        $ci->load->helper('security');
        $ci->load->library('email');
        /*$ci->email->initialize(array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.sendgrid.net',
            'smtp_user' => 'dev.alex',
            'smtp_pass' => 'uBdeF5RKJTH2',
            'smtp_port' => 587,
            'crlf' => "\r\n",
            'newline' => "\r\n"
        ));
        $ci->email->initialize(array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.mandrillapp.com',
            'smtp_user' => 'robert@codenamerob.com',
            'smtp_pass' => '4fehAZPlBJa73xxKigbaYg',
            'smtp_port' => 587,
            'mailtype' => 'html',
            'crlf' => "\r\n",
            'newline' => "\r\n"
        ));*/
        foreach($arg as $line){
            $token = do_hash($line['email'].$line['name']);
            $data = array(
                'name'=>$line['name'],
                'email'=>$line['email'],
                'by_user'=>$id,
                'token'=> $token
            );
            $ci->email->from($email, $name);
            $ci->email->to($line['email']);
            $ci->email->subject('Can you MaketheMonth?');
            $ci->email->set_mailtype('html');
            $message = '<html>
                <body style="text-align: center">
                     <h1>Your friend '.$name.' just played <a style="text-decoration:none;  color:#D7281E;" href="'.WEBSITE_URL.'home/share/'.$token.'">MaketheMonth.ca</a> and made it to day '.$day.'</h1>
                     <p>I need the text for email :D</p>
                     <a href="'.WEBSITE_URL.'home/share/'.$token.'" style="background-color:#D7281E; color:#fff; display:inline-block; width:100px; font-size:20px; line-height:40px; text-decoration:none;">Play</a>
                </body>
            </html>';
            $ci->email->message($message);
            $ci->email->send();
            $this->db->insert('invited_users',$data);
        }
        return true;
    }
    function check_user($token){
        $id = $this->db->select('id')->from('invited_users')->where('token',$token)->get()->result();
        if(!empty($id)){
            $id = $id[0]->id;
            $ci = get_instance();
            $ci->load->helper('date');
            $datestring = "%Y-%m-%d %h:%i:%s";
            $time = time();
            $data = array(
                'came'=>mdate($datestring, $time),
                'token'=>''
            );
            $this->db->where('id',$id);
            $this->db->update('invited_users',$data);
        }
    }
}
?>