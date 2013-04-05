<?php
class Authors extends CI_Controller {
    public function __construct() {
            parent::__construct();
            $this->load->helper('url'); 
     }
     
    function index(){
        $data['title']='Grafos';
        $data['mainContent']='authors';
        $this->load->view('mainTemplate',$data);
        
        }
    function searchAuthor(){
        $nombreA = $this->input->get('term');
        
        
        $this->db->select("IDAuthor as id, CONCAT(FirstName,' ', IF (MiddleName IS NULL ,'',MiddleName),' ', IF (LastName IS NULL, '', LastName) ) as value",false);
        $this->db->where('Extras' , 0); 
        $this->db->like("CONCAT_WS(Author.FirstName,' ', MiddleName,' ',LastName )",$nombreA,'both'); 
        $this->db->limit(10);
        $query = $this->db->get('Author'); 
        $rows=$query->result();
        echo json_encode($rows);
        
        //$this->load->view('searchAuthor');
    }
    //function cloudAuthor($var, $id){
      function cloudAuthor(){
        /*if ($var == "idAuthor"){
            $idAuthor=$id;
        }else            return;
         
         */
        //print_r($this->input->post());
         $idAuthor= $this->input->post('idAuthor');
        $queryString=sprintf("SELECT Author.IDAuthor
           , Keyword.Name,Author.FirstName, Author.LastName, Author.MiddleName,idKeyword,
           count(Keyword.Name) as Frequencia
           FROM
             Author_has_Publication
           INNER JOIN Author
           ON Author_has_Publication.Author_IDAuthor = Author.IDAuthor
           INNER JOIN Publication
           ON Author_has_Publication.Publication_idPublication = Publication.idPublication
           INNER JOIN Publication_has_Keyword
           ON Publication_has_Keyword.Publication_idPublication = Publication.idPublication
           INNER JOIN Keyword
           ON Publication_has_Keyword.Keyword_idKeyword = Keyword.idKeyword
           WHERE
             Author.Extras = 0
             AND Author.IDAuthor = %d
             AND Keyword.baja = 0 
           GROUP BY
              Keyword.idKeyword,Author.IDAuthor
           order by
                   Frequencia desc",$idAuthor);
        $query= $this->db->query($queryString);
         $authoresKeywords=$query->result();
         //print_r($resultados);
            $i=0;
            $maximum = 0;
            $totalKeyWords=  sizeof($authoresKeywords);
            $limite=30;
            $maximum= $authoresKeywords[0]->Frequencia;
            $minimum= $authoresKeywords[$totalKeyWords-1]->Frequencia;
            foreach($authoresKeywords as $v):
                if ($i < $limite){
                    $keys[$i]=$v;
                    $i++;
                }else break;
            endforeach;
            $data['nombreAuthor']=$authoresKeywords[0]->FirstName. " " .$authoresKeywords[0]->MiddleName. " ". $authoresKeywords[0]->LastName;
        $data['keys']=$keys;
      
        $data['totalKeyWords']=$totalKeyWords;
        
        $data['maximun']= $maximum;
        $data['minimum']= $minimum;
        $data['min_size']= 5;
        $data['max_size']= 35;
        $data['spread']= ($maximum - $minimum) +.001;
        $data['title']='CloudTag';  
        //print_r($data);  
        //$data['mainContent']='cloudAuthor';
        $this->load->view('cloudAuthor',$data);

    }
    
}

