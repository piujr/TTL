<?php
class AgruparKeys extends CI_Controller {
    public function __construct() {
            parent::__construct();
            $this->load->helper('url'); 
     }
     
    function index(){
                
        $this->db->where('IdBaja' , 1);
        $query = $this->db->get('Keyword'); 
        $rows=$query->result();
        $i=0;
        foreach ($rows as $r):
            $keys[$i]= $r->Name;
            $keysId[$i]= $r->idKeyword;
            $i++;
        endforeach;
        echo "<br>";
        $total=count($keys) ;
        $inicio=0;
        $fin=300;
        echo "del 0 al ". 300 . "<br>";
        for($i=$inicio; $i< $fin; $i++){
            for($j=$i+1; $j<$total; $j++){
                $lev = levenshtein($keys[$i], $keys[$j]);
                $data=array(
                    'idKey1'=>$keysId[$i],
                    'idKey2'=>$keysId[$j],
                    'similaridad'=>$lev
                );
                //$this->db->insert('Similaridad',$data);                                
            }
            echo "$i - $j / ".count($keys). "<br>";
                flush();             
        }
        echo "<pre>";
        echo json_encode($keys);
        echo "</pre>";
        
        }
        
        
     
    function wordMatch($words, $input, $sensitivity){
        $shortest = -1;
        foreach ($words as $word) {
            $lev = levenshtein($input, $word);
            if ($lev == 0) {
                $closest = $word;
                $shortest = 0;
                break;
            }
            if ($lev <= $shortest || $shortest < 0) {
                $closest  = $word;
                $shortest = $lev;
            }
        }
        if($shortest <= $sensitivity){
            return $closest;
        } else {
            return 0;
        }
    } 
}

