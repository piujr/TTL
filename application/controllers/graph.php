<?php

class Graph extends CI_Controller {
    public function __construct() {
            parent::__construct();
     }
    function index(){
        
        
        $query= $this->db->query("SELECT
                                Author.IDAuthor,
                                Author.FirstName,
                                Author.LastName,
                                Author.MiddleName,
                                Author.DisplayPhotoURL,
                                GROUP_CONCAT(DISTINCT idKeyword SEPARATOR ' ,')as GroupKeys,
                                 GROUP_CONCAT(DISTINCT Keyword.name SEPARATOR ' ,') as GroupKeysName
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
                                    Publication.IdBaja = 1 AND                                    
                                Author.IdBaja = 1 AND
                                Keyword.IdBaja = 1
                                GROUP BY
                                  IDAuthor
                                order by
                                        IDAuthor desc
                               
                                ");
        
        
        //$data['query']=$this->db->get('Author');
        //print_r($data['query']->result());
        $resultados=$query->result();
        $contador=0;
        foreach($resultados as $v):
            //print_r($v);
            $idAuthorString[$contador]=$v->IDAuthor;
            $llaves=$v->GroupKeys;
            if (substr($llaves, -1) ==",")
                    $llaves= substr($llaves, 0, -1);
                    
                    
            $queryString=sprintf("SELECT
                            Author.IDAuthor,  count(DISTINCT idKeyword) as totalKeys
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
                                Publication.IdBaja = 1 AND
                                Keyword.IdBaja =1 AND
                            Author.IdBaja = 1 and Keyword.idKeyword in (%s)
                            and IDAuthor not in (%s)
                            GROUP BY
                              IDAuthor
                            HAVING totalKeys > 3
                            order by
                                totalKeys  DESC",  $llaves,implode(", ",$idAuthorString));
        //echo $queryString."\n";
            $query2=$this->db->query($queryString);
            $json[$contador]['id']=$v->IDAuthor;
            $json[$contador]['name']=$v->FirstName." ".$v->MiddleName." ".$v->LastName;
            $json[$contador]['data']['foto']=$v->DisplayPhotoURL;
            $json[$contador]['data']['color']='#DF013A';
            $json[$contador]['data']['$type']='circle';
            $json[$contador]['data']['$dim']='10';
            $json[$contador]['data']['description']=substr($v->GroupKeysName, 0,300) ."..." ;
            $contadorAdj=0;
            foreach($query2->result() as $r):                
                $json[$contador]['adjacencies'][$contadorAdj]=$r->IDAuthor;
                $contadorAdj++;
            endforeach;            
            
            $contador++;
        endforeach;
        
        $data['title']='Grafos';
        $data['json']=$json;
        $this->load->helper('url'); 
        $data['mainContent']='graph';
        $this->load->view('mainTemplate',$data);
        
    }

    function graphPErsonal(){
        $idAuthor= $this->input->post('idAuthor');
        $sql= sprintf("SELECT
            Author.IDAuthor,
            Author.FirstName,
            Author.LastName,
            Author.MiddleName,
            GROUP_CONCAT(DISTINCT idKeyword SEPARATOR ' ,')as GroupKeys,
             GROUP_CONCAT(DISTINCT Keyword.name SEPARATOR ' ,') as GroupKeysName
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
                Publication.IdBaja = 1 AND
                Keyword.IdBaja =1 AND
            Author.IdBaja= 1
            and Author.IDAuthor = %d
            GROUP BY
              IDAuthor
            order by
                    IDAuthor desc",$idAuthor);
        $query= $this->db->query($sql);
        
        
        //$data['query']=$this->db->get('Author');
        //print_r($data['query']->result());
        $resultados=$query->result();
        $contador=0;
        foreach($resultados as $v):
            //print_r($v);
            $idAuthorString[$contador]=$v->IDAuthor;
            $llaves=$v->GroupKeys;
            if (substr($llaves, -1) ==",")
                    $llaves= substr($llaves, 0, -1);
                                        
            $queryString=sprintf("SELECT
                            Author.IDAuthor, count(DISTINCT idKeyword) as totalKeys,                            Author.IDAuthor, count(DISTINCT idKeyword) as totalKeys,
                            Group_Concat(DISTINCT Keyword.Name)  as Ukeys,
                            CONCAT( IFNULL(Author.`FirstName`,'') ,' ',  IFNULL(Author.`MiddleName`,''),' ', IFNULL(Author.`LastName`,'')) as authorsName
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
                                Publication.IdBaja = 1 AND
                                Keyword.IdBaja =1 AND
                            Author.IdBaja= 1 and Keyword.idKeyword in (%s)
                            and IDAuthor not in (%s)
                            GROUP BY
                              IDAuthor
                            HAVING totalKeys > 3
                            order by
                                totalKeys  DESC",  $llaves,implode(", ",$idAuthorString));
        //echo $queryString."\n";
            $query2=$this->db->query($queryString);
            $json[$contador]['id']=$v->IDAuthor;
            $json[$contador]['name']=$v->FirstName." ".$v->MiddleName." ".$v->LastName;
            $json[$contador]['data']['color']='#000000';
            $json[$contador]['data']['$type']='circle';
            $json[$contador]['data']['$dim']='12';
            $json[$contador]['data']['description']=substr($v->GroupKeysName, 0,300) ."..." ;
            $contadorAdj=0;
            $q2=$query2->result();
            foreach($q2 as $r):                                
                $json[$contador]['adjacencies'][$contadorAdj]=$r->IDAuthor;                
                $contadorAdj++;                
            endforeach;
            $contador++;
        endforeach;
         foreach($q2 as $r):                                
                $json[$contador]['id']=$r->IDAuthor;
                $json[$contador]['name']=$r->authorsName;
                $json[$contador]['data']['color']='#000';
                $json[$contador]['data']['$type']='triangle';
                $json[$contador]['data']['$dim']=7; 
                $json[$contador]['data']['description']=substr($r->Ukeys, 0,300) ."..." ;
                $contador++;                
        endforeach;    
       
        //echo json_encode($json);
        $data['title']='Grafos';
        $data['json']=$json;
        $this->load->helper('url'); 
        $data['mainContent']='graphPersonal';
        $this->load->view('graphPersonal',$data);
        
    }
    
}
?>
