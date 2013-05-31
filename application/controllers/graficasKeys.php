<?php

class graficasKeys extends CI_Controller {
    public function __construct() {
            parent::__construct();
            $this->load->helper('url'); 
     }
    function index(){
        
        $query= $this->db->query("Select Name, idKeyword from Keyword 
            INNER JOIN Publication_has_Keyword ON
            (Publication_has_Keyword.Keyword_idKeyword = Keyword.idKeyword) 
            WHERE 
            Keyword.baja= 0
            GROUP BY Name, idKeyword 
                ");            
        $rows=$query->result();
        //print_r($_POST['keys']);
        
        if (isset($_POST['keys'])){
            
            $in=implode(',',$_POST['keys']);
            $json=array();
            $query= $this->db->query("SELECT
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
                    Publication.IdBaja = 0 AND
                Author.Extras = 0
                AND Keyword.baja = 0 
                AND Keyword.idKeyword in ($in)
                GROUP BY
                  IDAuthor
                order by
                        IDAuthor desc
                ");
            $resultados=$query->result();            
            $contador=0;
            foreach($resultados as $v):
                $idAuthorString[$contador]=$v->IDAuthor;
                $llaves=$v->GroupKeys;
                if (substr($llaves, -1) ==",")
                        $llaves= substr($llaves, 0, -1);
                $queryString=sprintf("SELECT
                     Author.IDAuthor, count(DISTINCT idKeyword) as totalKeys
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
                        Publication.IdBaja = 0 AND                                
                     Author.Extras = 0 and Keyword.idKeyword in (%s)
                     and IDAuthor not in (%s)
                     GROUP BY
                       IDAuthor                     
                     order by
                         totalKeys  DESC",  $llaves,implode(", ",$idAuthorString));               
                $query2=$this->db->query($queryString);
                $json[$contador]['id']=$v->IDAuthor;
                $json[$contador]['name']=$v->FirstName." ".$v->MiddleName." ".$v->LastName;
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
               $data['json']=$json;
        }
       // print_r($json);
        $data['Keyword']=$rows;
        $data['title']='Graficas por Keywords';
        $data['mainContent']='mapaKeywords';
        $this->load->view('mainTemplate',$data);
    }
}