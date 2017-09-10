<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Game extends CI_Controller{
     
        
        public function index(){
            $this->load->view("game_view");
        }
        
        public function showResults(){
            $this->load->model('Gamer');
            $data['players'] = $this->Gamer->getData();
            $this->load->view("result_views", $data);
        }
        
        public function addData(){
            $data = $this->input->post('data');
            $this->load->model('Gamer');
            $this->Gamer->addOrUpdateData($data);
            $this->Gamer->isCountGreaterMax();
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }
        
    }
?>