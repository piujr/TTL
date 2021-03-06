<?php
class Estadisticas extends CI_Controller {
    private  $tmpl;
    public function __construct() {
            parent::__construct();
             $this->load->helper('url'); 
             
             $this->tmpl = array (
                    'table_open'          => '<table border="1" width="200px" cellpadding="4" cellspacing="0">',

                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr class="evenRowColor">',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr class="oddRowColor">',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );
          //  echo $this->config->item('index_page');
     }
    function index(){
        $data['title']='Grafos';       
    }
    function Tipo($tipo){        
        $data['title']='Estadisticas';        
        switch ($tipo){
            case 1: 
                $data['destino']='orgXinstituto';
                $data['destinoDetalle']='showAuthors';
                $data['titulo']="Publicaciones por intituto";
                   break;
            case 2: 
                $data['destino']='publicXconf';
                $data['destinoDetalle']='showPublicAuthors';
                $data['titulo']="Publicaciones por congreso";
                break;
            case 3: 
                $data['destino']='publicXjournal';
                $data['destinoDetalle']='showPublicAuthors';
                $data['titulo']="Publicaciones por revista";
                break;            
        }        
        $data['mainContent']='est_conferencia';
        $this->load->view('mainTemplate',$data);
    } 
    private function  creaAcronimo($string){
         $arr=explode(" ",$string); 
         $acronimo="";
         foreach($arr as $v):
             $acronimo.=  substr($v, 0,1);
         endforeach;
         return $acronimo;
    }    
    function orgXinstituto(){        
        
     $query= $this->db->query("SELECT DISTINCT 
  Author.IDAuthor,
  Organization.Name,
  Publication.idPublication,
  Organization.idOrganization,
  count(DISTINCT   Publication.idPublication) AS FIELD_1,
  COUNT( DISTINCT if(idConference > 0,  Publication.idPublication, NULL)) AS conferencias,
  COUNT(DISTINCT if(idJournal > 0,    Publication.idPublication, NULL)) AS journals,
  COUNT(DISTINCT if(idJournal = 0 AND idConference = 0, Publication.idPublication, NULL)) AS Otro
FROM
  Organization
  INNER JOIN Author ON (Organization.idOrganization = Author.Organization_idOrganization)
  INNER JOIN Author_has_Publication ON (Author.IDAuthor = Author_has_Publication.Author_IDAuthor)
  INNER JOIN Publication ON (Publication.idPublication = Author_has_Publication.Publication_idPublication)
  INNER JOIN Conference ON (Conference.idConference = Publication.Conference_idConference)
  INNER JOIN Journal ON (Journal.idJournal = Publication.Journal_idJournal)
WHERE
    Publication.IdBaja = 1 AND
    Organization.IdBaja = 1 AND
    Conference.IdBaja = 1 AND
    Journal.IdBaja = 1 AND
  Author.IdBaja = 1 
GROUP BY 
  Organization.idOrganization
ORDER BY
  Organization.name
        ");
       
         $resultados=$query->result();
         $json['cols'][0]['id']="";
         $json['cols'][0]['label']="Intituto";
         $json['cols'][0]['type']="string";
         $json['cols'][1]['id']="";
         $json['cols'][1]['label']="Journal";
         $json['cols'][1]['type']="number";
         $json['cols'][2]['id']="";
         $json['cols'][2]['label']="Conference";
         $json['cols'][2]['type']="number";
         $json['cols'][3]['id']="";
         $json['cols'][3]['label']="Otro";
         $json['cols'][3]['type']="number";
         
         $cont=0;
         foreach($resultados as $r): 
             $orden['id'][$cont]=$r->idOrganization;
             //$instituto =$this->creaAcronimo(ucwords(htmlentities($r->Name, ENT_QUOTES,'UTF-8')));
             $instituto =ucwords($r->Name);
            if (strlen(trim($instituto)) == 0 )
                $instituto ="Otro";
            $json['rows'][$cont]['c'][0]['v']=$instituto ;
            $json['rows'][$cont]['c'][0]['f']=null;            
            $json['rows'][$cont]['c'][1]['v']=$r->journals +0;
            $json['rows'][$cont]['c'][1]['f']=null;        
            $json['rows'][$cont]['c'][2]['v']=$r->conferencias +0;
            $json['rows'][$cont]['c'][2]['f']=null;        
            $json['rows'][$cont]['c'][3]['v']=$r->Otro +0;
            $json['rows'][$cont]['c'][3]['f']=null;        
            //$json['rows'][$cont]['c'][4]['v']=$r->idOrganization;        
            $cont++;
         endforeach;
         $res['data']=$json;
         $res['title']="Publicaciones por intituto";
         $res['orden']=$orden;
         echo json_encode($res);
         
         
    }    
    function publicXconf(){
        //COUNT(DISTINCT if (IDAuthor > 0,IDAuthor,NULL) ) AS autores,
          $query= $this->db->query("  SELECT
                    COUNT(DISTINCT Publication.`idPublication` ) AS autores,
                    COUNT(DISTINCT if (IDAuthor > 0,IDAuthor,NULL) ) AS autoresDistintos,
                    Conference.FullName as nombre,
                    Conference.idConference
                FROM
                    Author
                    INNER JOIN Author_has_Publication ON Author.IDAuthor = Author_has_Publication.Author_IDAuthor
                    INNER JOIN Publication ON Publication.idPublication = Author_has_Publication.Publication_idPublication
                    INNER JOIN Conference ON Conference.idConference = Publication.Conference_idConference                    
                Where 
                    Publication.IdBaja = 1 AND
                    Conference.IdBaja = 1 AND
                Author.IdBaja  =1 and 
                Publication.Conference_idConference >0
                GROUP BY idConference
                HAVING autores > 2
                order by autores                       ");
         $resultados=$query->result();
         $json['cols'][0]['id']="";
         $json['cols'][0]['label']="Conferencia";
         $json['cols'][0]['type']="string";
         $json['cols'][1]['id']="";
         $json['cols'][1]['label']="Publicaciones";
         $json['cols'][1]['type']="number";
         $json['cols'][2]['id']="";
         $json['cols'][2]['label']="Autores";
         $json['cols'][2]['type']="number";
         
         
         $cont=0;
         foreach($resultados as $r): 
             $orden['id'][$cont]=$r->idConference;
            $json['rows'][$cont]['c'][0]['v']= ($r->nombre=="")? 'Desconocido' : $r->nombre ;
            $json['rows'][$cont]['c'][0]['f']=null;
            $json['rows'][$cont]['c'][1]['v']=$r->autores +0;
            $json['rows'][$cont]['c'][1]['f']=null;        
            $json['rows'][$cont]['c'][2]['v']=$r->autoresDistintos +0;
            $json['rows'][$cont]['c'][2]['f']=null;        
            $cont++;
         endforeach;
         $res['data']=$json;
         $res['orden']=$orden;
         $res['title']="Publicaciones por institución en congresos";
         echo json_encode($res);
         
    }
    function publicXjournal(){
        //COUNT(DISTINCT if (IDAuthor > 0,IDAuthor,NULL) ) AS autores,
          $query= $this->db->query("  SELECT 
  COUNT(DISTINCT Publication.`idPublication`) AS autores,
  COUNT(DISTINCT if(IDAuthor > 0, IDAuthor, NULL)) AS autoresDistintos,
  Journal.FullName AS nombre,
  Journal.idJournal
FROM
  Author
  INNER JOIN Author_has_Publication ON (Author.IDAuthor = Author_has_Publication.Author_IDAuthor)
  INNER JOIN Publication ON (Publication.idPublication = Author_has_Publication.Publication_idPublication)
  INNER JOIN Journal ON (Journal.idJournal = Publication.Journal_idJournal)
WHERE
        Publication.IdBaja = 1 AND
        Journal.IdBaja = 1 AND
  Author.IdBaja  = 1 AND 
  Publication.Journal_idJournal > 0
GROUP BY
  Journal.FullName,
  Journal.idJournal
ORDER BY
  autores                 ");
        
        
       
         $resultados=$query->result();
         $json['cols'][0]['id']="";
         $json['cols'][0]['label']="Conferencia";
         $json['cols'][0]['type']="string";
         $json['cols'][1]['id']="";
         $json['cols'][1]['label']="Publicaciones";
         $json['cols'][1]['type']="number";
         $json['cols'][2]['id']="";
         $json['cols'][2]['label']="Autores";
         $json['cols'][2]['type']="number";
         
         
         $cont=0;
         foreach($resultados as $r): 
             $orden['id'][$cont]=$r->idJournal;
            $json['rows'][$cont]['c'][0]['v']= ($r->nombre=="")? 'Desconocido' : $r->nombre ;
            $json['rows'][$cont]['c'][0]['f']=null;
            $json['rows'][$cont]['c'][1]['v']=$r->autores +0;
            $json['rows'][$cont]['c'][1]['f']=null;        
            $json['rows'][$cont]['c'][2]['v']=$r->autoresDistintos +0;
            $json['rows'][$cont]['c'][2]['f']=null;        
            $cont++;
         endforeach;
         $res['data']=$json;
          $res['orden']=$orden;
         $res['title']="Publicaciones por institución en revistas";
         echo json_encode($res);
         
    }    
    function showAuthors(){
        $id= $this->input->post('id');
        $tipo= $this->input->post('tipo');
        
        //$id=$nombreA = $this->input->get('id');
        //$tipo=$nombreA = $this->input->get('tipo');
        
        
        //COUNT(DISTINCT if (IDAuthor > 0,IDAuthor,NULL) ) AS autores,
        switch ($tipo){
            
        case 1:
           $queryString=  sprintf("  SELECT DISTINCT                     
                    count(distinct Publication.idPublication) AS publicaciones,
                    Journal.FullName,
                    Journal.FullName,  
                    GROUP_CONCAT(  DISTINCT Publication.Title SEPARATOR '; ') as PublicNames,
                     GROUP_CONCAT( DISTINCT IFNULL(Author.`FirstName`,''),' ',  IFNULL(Author.`MiddleName`,''),' ', IFNULL(Author.`LastName`,'') SEPARATOR '; ') as authors
                     
                  FROM
                    Organization
                    INNER JOIN Author ON (Organization.idOrganization = Author.Organization_idOrganization)
                    INNER JOIN Author_has_Publication ON (Author.IDAuthor = Author_has_Publication.Author_IDAuthor)
                    INNER JOIN Publication ON (Publication.idPublication = Author_has_Publication.Publication_idPublication)
                    INNER JOIN Journal ON (Journal.idJournal = Publication.Journal_idJournal)
                  WHERE
                    Publication.IdBaja = 1 AND
                    Journal.IdBaja = 1 AND
                    Organization.IdBaja = 1 AND
                  Author.IdBaja =1 and
                    Organization.idOrganization = %d AND 
                    Publication.Journal_idJournal > 0
                  GROUP BY
                    Journal.FullName
                  ORDER BY
                    Journal.FullName  ",$id);
            break;
        case 2:
        $queryString=  sprintf("SELECT DISTINCT 
                    count(distinct Publication.idPublication) AS publicaciones,
                    Conference.FullName,
                    GROUP_CONCAT(DISTINCT Publication.Title SEPARATOR '; ') AS PublicNames,
                    GROUP_CONCAT(DISTINCT IFNULL(Author.FirstName, ''), ' ', IFNULL(Author.MiddleName, ''), ' ', IFNULL(Author.LastName, '') SEPARATOR '; ') AS authors,
                    Conference.FullName
                  FROM
                    Organization
                    INNER JOIN Author ON (Organization.idOrganization = Author.Organization_idOrganization)
                    INNER JOIN Author_has_Publication ON (Author.IDAuthor = Author_has_Publication.Author_IDAuthor)
                    INNER JOIN Publication ON (Publication.idPublication = Author_has_Publication.Publication_idPublication)
                    INNER JOIN Conference ON (Publication.Conference_idConference = Conference.idConference)
                  WHERE
                      Publication.IdBaja = 1 AND
                      Conference.IdBaja = 1 AND
                      Organization.IdBaja = 1 AND
                    Author.IdBaja  = 1 AND 
                    Organization.idOrganization = %d AND 
                    Publication.Conference_idConference > 0
                  GROUP BY
                    Conference.FullName
                  ORDER BY
                    Conference.FullName
               ",$id); 
            break;
        case 3:
            $queryString=  sprintf("SELECT DISTINCT 
                    count(distinct Publication.idPublication) AS publicaciones,
                    Conference.FullName,
                    GROUP_CONCAT(DISTINCT Publication.Title SEPARATOR '; ') AS PublicNames,
                    GROUP_CONCAT(DISTINCT IFNULL(Author.FirstName, ''), ' ', IFNULL(Author.MiddleName, ''), ' ', IFNULL(Author.LastName, '') SEPARATOR '; ') AS authors,
                    Conference.FullName
                  FROM
                    Organization
                    INNER JOIN Author ON (Organization.idOrganization = Author.Organization_idOrganization)
                    INNER JOIN Author_has_Publication ON (Author.IDAuthor = Author_has_Publication.Author_IDAuthor)
                    INNER JOIN Publication ON (Publication.idPublication = Author_has_Publication.Publication_idPublication)
                    INNER JOIN Conference ON (Publication.Conference_idConference = Conference.idConference)
                  WHERE
                      Publication.IdBaja = 1 AND
                      Conference.IdBaja = 1 AND
                      Organization.IdBaja = 1 AND
                    Author.IdBaja  = 1 AND 
                    Organization.idOrganization = %d AND 
                      Publication.Conference_idConference = 0  and Publication.`Journal_idJournal` = 0
                  GROUP BY
                    Conference.FullName
                  ORDER BY
                    Conference.FullName
               ",$id); 
            break;
        }
        
        
         $query= $this->db->query($queryString);         
        $this->load->library('table');
        $this->table->set_heading('#', 'Nombre', 'Titulos Pubs.', 'Autores');
        $tmpl = array (
                    'table_open'          => '<table border="1" width="200px" cellpadding="4" cellspacing="0">',

                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr class="evenRowColor">',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr class="oddRowColor">',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );

        $this->table->set_template($tmpl); 
        echo $this->table->generate($query);
         /*$cont=0;
         foreach($resultados as $r): 
            
         endforeach;*/
         //$this->load->view('ajax/showAuthors');
         
    }
    function showPublicAuthors(){
         $this->load->library('table');
        $id= $this->input->post('id');
        $tipo= $this->input->post('tipo');
         $page= $this->input->post('page');
        echo $id ."-" . $tipo ."-".$page ;
        if ($tipo +0  == 1 )
            $this->table->set_heading('Author', 'Titulo publicación.');
       else
           $this->table->set_heading( 'Nombre del autor');
        if(strcmp("publicXconf", $page)==0)
                switch ($tipo){

                case 1:
                   $queryString=  sprintf("  SELECT 
                              Group_Concat(DISTINCT IFNULL(Author.FirstName, ''), ' ', IFNULL(Author.MiddleName, ''), ' ', IFNULL(Author.LastName, '') SEPARATOR '; ') AS name,
                            Publication.Title
                          FROM
                            Author
                            INNER JOIN Author_has_Publication ON (Author.IDAuthor = Author_has_Publication.Author_IDAuthor)
                            INNER JOIN Publication ON (Publication.idPublication = Author_has_Publication.Publication_idPublication)
                            INNER JOIN Conference ON (Conference.idConference = Publication.Conference_idConference)
                          WHERE
                                Publication.IdBaja = 1 AND
                                Conference.IdBaja = 1 AND
                            Author.IdBaja  = 1 AND 
                            Publication.Conference_idConference > 0 AND 
                            Conference.idConference = %d
                          GROUP BY                                                       
                            Publication.Title  
                           ORDER BY 
                            Publication.Title  
                           ",$id);
                    break;
                case 2:
                $queryString=  sprintf("SELECT 
                                Concat(ifnull(Author.FirstName,''), ' ', ifnull(Author.MiddleName,''), ' ', ifnull(Author.LastName,'')) AS name
                              FROM
                                Author
                                INNER JOIN Author_has_Publication ON (Author.IDAuthor = Author_has_Publication.Author_IDAuthor)
                                INNER JOIN Publication ON (Publication.idPublication = Author_has_Publication.Publication_idPublication)
                                INNER JOIN Conference ON (Conference.idConference = Publication.Conference_idConference)
                              WHERE
                                    Publication.IdBaja = 1 AND
                                    Conference.IdBaja = 1 AND                                    
                                Author.IdBaja  = 1 AND 
                                Publication.Conference_idConference > 0 AND 
                                Conference.idConference = %d
                              GROUP BY
                                Author.IDAuthor
                                ORDER BY 
                                Author.FirstName,
                                Author.MiddleName,
                                Author.LastName
                       ",$id); 
                    break;

                }
        else
            switch ($tipo){
                case 1:                   
                   $queryString=  sprintf("  SELECT DISTINCT
                              Group_Concat(DISTINCT  IFNULL(Author.FirstName, ''), ' ', IFNULL(Author.MiddleName, ''), ' ', IFNULL(Author.LastName, '') SEPARATOR '; ') AS name,
                            Publication.Title
                          FROM
                            Author
                            INNER JOIN Author_has_Publication ON (Author.IDAuthor = Author_has_Publication.Author_IDAuthor)
                            INNER JOIN Publication ON (Publication.idPublication = Author_has_Publication.Publication_idPublication)
                            INNER JOIN Journal ON (Journal.idJournal = Publication.Journal_idJournal)
                          WHERE
                                Publication.IdBaja = 1 AND
                                Journal.IdBaja = 1 AND
                            Author.IdBaja  = 1 AND 
                            Journal.idJournal = %d
                          GROUP BY

                            Publication.Title
                          ORDER BY
                            Publication.Title ",$id);
                    break;
                case 2:
                $queryString=  sprintf("SELECT 
                                Concat(ifnull(Author.FirstName,''), ' ', ifnull(Author.MiddleName,''), ' ', ifnull(Author.LastName,'')) AS name
                              FROM
                                Author
                                INNER JOIN Author_has_Publication ON (Author.IDAuthor = Author_has_Publication.Author_IDAuthor)
                                INNER JOIN Publication ON (Publication.idPublication = Author_has_Publication.Publication_idPublication)
                                INNER JOIN Journal ON (Journal.idJournal= Publication.Journal_idJournal)
                              WHERE
                                    Publication.IdBaja = 1 AND
                                    Journal.IdBaja = 1 AND
                                Author.IdBaja  = 1 AND                                 
                                Journal.idJournal = %d
                               GROUP by
                                    Author.`IDAuthor`
                                  ORDER BY
                                    Author.FirstName,
                                    Author.MiddleName,
                                    Author.LastName
                       ",$id); 
                    break;

                }
        
         $query= $this->db->query($queryString);
         $resultados=$query->result();
        
        
        $tmpl = array (
                    'table_open'          => '<table border="1" width="200px" cellpadding="4" cellspacing="0">',

                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr class="evenRowColor">',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr class="oddRowColor">',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );

        $this->table->set_template($tmpl); 
        echo $this->table->generate($query);
         /*$cont=0;
         foreach($resultados as $r): 
            
         endforeach;*/
         //$this->load->view('ajax/showAuthors');
         
    }
    function investigadoresKeys(){
        $queryString="SELECT 
            Keyword.Name,
            COUNT( DISTINCT Author.FirstName) AS nautores,
            GROUP_CONCAT(DISTINCT IFNULL(Author.FirstName, ' '), ' ', IFNULL(Author.MiddleName, ' '), ' ', IFNULL(Author.LastName, ' ') ORDER BY Author.FirstName,Author.MiddleName,Author.LastName DESC SEPARATOR ', ') AS Nombre
          FROM
            Keyword
            INNER JOIN Publication_has_Keyword ON (Keyword.idKeyword = Publication_has_Keyword.Keyword_idKeyword)
            INNER JOIN Publication ON (Publication_has_Keyword.Publication_idPublication = Publication.idPublication)
            INNER JOIN Author_has_Publication ON (Publication.idPublication = Author_has_Publication.Publication_idPublication)
            INNER JOIN Author ON (Author_has_Publication.Author_IDAuthor = Author.IDAuthor)
          WHERE
                Publication.IdBaja = 1 AND                
            Author.IdBaja  = 1 AND 
            Keyword.IdBaja = 1            
          GROUP BY
            Keyword.Name
          
          ORDER BY
           nautores Desc";
        /*
         * HAVING
            nautores > 4
         */
         $query= $this->db->query($queryString);
         //$resultados=$query->result();
        $this->load->library('table');
        $this->table->set_heading('Keyword', '#Autores', 'Autores');
        $this->table->set_template($this->tmpl); 
        $data['queryTable']= $this->table->generate($query);
        $data['title']=$data['titulo']="Palabras claves e investigadores asociados";
            $data['mainContent']='investigadoresKeys';
            $this->load->view('mainTemplate',$data);
        
    }   
    function selGraph(){
        $data['title']=$data['titulo']="Palabras claves e investigadores asociados";
        $data['mainContent']='selectGraph';
         $this->load->view('mainTemplate',$data);
    }
    
    function listRelInst(){
         $queryString="
          SELECT 
            Organization.idOrganization,
            Organization.Name,
            GROUP_CONCAT(DISTINCT Publication.idPublication) AS publicaciones,
            GROUP_CONCAT(DISTINCT '\"',Publication.Title,'\"') AS publicacionesN
          FROM
            Author
            INNER JOIN Author_has_Publication ON (Author.IDAuthor = Author_has_Publication.Author_IDAuthor)
            INNER JOIN Publication ON (Author_has_Publication.Publication_idPublication = Publication.idPublication)
            INNER JOIN Organization ON (Author.Organization_idOrganization = Organization.idOrganization)
          WHERE
            Author.IdBaja = 1 AND 
            Publication.IdBaja = 1 AND 
            Organization.IdBaja = 1
          GROUP BY
            Organization.idOrganization,
            Organization.Name";
         
         $query= $this->db->query($queryString);
         $resultados=$query->result();
         $dat= array(
             array("Institucion","Instituciones relacionadas","Publicaciones")
         );
         foreach ($resultados as $r):             
             $queryString="
                SELECT 
                    GROUP_CONCAT(DISTINCT '\"', Organization.Name, '\"') AS rel
                  FROM
                    Author
                    INNER JOIN Author_has_Publication ON (Author.IDAuthor = Author_has_Publication.Author_IDAuthor)
                    INNER JOIN Publication ON (Author_has_Publication.Publication_idPublication = Publication.idPublication)
                    INNER JOIN Organization ON (Author.Organization_idOrganization = Organization.idOrganization)
                  WHERE
                    Author.IdBaja = 1 AND 
                    Publication.IdBaja = 1 AND 
                    Organization.IdBaja = 1 AND 
                    Publication.idPublication IN ({$r->publicaciones}) AND 
                    Organization.idOrganization != {$r->idOrganization}";
                
                    $query= $this->db->query($queryString); 
                $res=$query->result();                
                $dat[]= array($r->Name,$res[0]->rel,$r->publicacionesN);
                
         endforeach;
        $this->load->library('table');
        $data['queryTable']= $this->table->generate($dat);
        $data['title']=$data['titulo']="Palabras claves e investigadores asociados";
            $data['mainContent']='investigadoresKeys';
            $this->load->view('mainTemplate',$data);
        
    }
    public function Cloud(){
        $queryString="SELECT 
            Keyword.idKeyword,
            COUNT(Author.IDAuthor) AS Frequencia,
            Keyword.Name
          FROM
            Keyword
            INNER JOIN Publication_has_Keyword ON (Keyword.idKeyword = Publication_has_Keyword.Keyword_idKeyword)
            INNER JOIN Publication ON (Publication_has_Keyword.Publication_idPublication = Publication.idPublication)
            INNER JOIN Author_has_Publication ON (Publication.idPublication = Author_has_Publication.Publication_idPublication)
            INNER JOIN Author ON (Author_has_Publication.Author_IDAuthor = Author.IDAuthor)
          WHERE
            Keyword.IdBaja = 1
          GROUP BY
            Keyword.idKeyword,
            Keyword.Name";     
         $query= $this->db->query($queryString); 
         $res=$query->result();
         
        $data['totalKeyWords']= count($res);
        $data['keys']= $res;
        $data['title']=$data['titulo']="Cloud";
        $data['mainContent']='cloud';
        $this->load->view('mainTemplate',$data);
    }
    
}
?>
