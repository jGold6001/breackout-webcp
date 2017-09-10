<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Gamer extends CI_Model{
        
        public function getData(){
            $this->db->order_by('score', 'DESC');
            $query = $this->db->get('players');
            return $query->result_array(); 
        }
        
        public function isCountGreaterMax(){
            $countRecords = count( $this->getData());
            if($countRecords > 80)
                $this->deleteMinScorePlayer();
        }
        
        public function addOrUpdateData($data){
            if($this->isNameExist($data))
                $this->updateData($data);
            else
                $this->createData($data); 
        }
        
        
        private function isNameExist($data){
            foreach($this->getData() as $item){
                if($item['name'] == $data['name'])
                    return true;
            }
            return false;
        }
        
        private function createData($data){
            $this->db->insert('players', $data);
        }
        
        private function updateData($data){
            $this->db->where('name', $data['name']);
            $this->db->update('players', $data);
        }
        
        
        private function deleteMinScorePlayer(){
             $minScore = $this->getMinScore();
             $id = $this->getIdElement($minScore);
             $this->deleteData($id);
        }
        
        private function deleteData($id){
            $this->db->where('id', $id);
            $this->db->delete('players');
        }
        
        private function getMinScore(){
            $this->db->select_min('score');
            $query = $this->db->get('players',0,1);
            return $query->result_array()[0]['score'];
        }
        
        private function getIdElement($score){
            $this->db->where('score', $score);
            $query = $this->db->get('players',0,1);
            return $query->result_array()[0]['id'];
        }
    }
?>