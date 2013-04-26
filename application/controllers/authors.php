<?php
class Authors extends CI_Controller {
    public $debug=true;
    
    public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->load->helper('url'); 
            $this->load->library('grocery_CRUD');
     }
     
     private function AddInvestigador($idM){
         
         echo "<pre>";
            $json_url_base = "http://academic.research.microsoft.com/json.svc/search?AppId=d485d5b2-3e14-42d7-b090-a0d3eb8296d4&AuthorID=";
           $json_url_fin="&ResultObjects=Author&StartIdx=1&EndIdx=10";
            
            $json_url=$json_url_base . $idM .$json_url_fin;    

            $string = file_get_contents($json_url);            
            $json_MAS=json_decode($string,true);
            $Au=$json_MAS['d']['Author']['Result'];
            
            //print_r($Au);
            
            flush();

            foreach($Au as $res)
            {                
                $return["name"]=$res["FirstName"]. " ". $res["MiddleName"]. " ".$res["LastName"];
                //$return["res"]=$res;
                //insertar los intereses a la DB para que despues se les asigne al autor
                $ResearchInterestDomain= $res['ResearchInterestDomain'];
                if (is_array($ResearchInterestDomain))
                    foreach($ResearchInterestDomain as $k=>$domain)
                    {                       
                        $data=array(
                            "idDomain"=>$domain['DomainID'], 
                            "SubDomain"=>$domain['SubDomainID'], 
                            "PublicationCount"=>$domain['PublicationCount'], 
                            "CitationCount"=>$domain['CitationCount'], 
                            "Name"=>$domain['Name']
                        );                        
                        $return["interes"][$k]=$domain["Name"];
                        if (!$this->debug)
                            if (!$this->db->insert('Domain', $data)){                                
                                $return["Error"]["Domain"]=$this->db->_error_message();
                            }
                    }
                /*******************************************/
                // Insertar la afiliacion del autor
                $afiliacion=$res['Affiliation'];                
                if (is_array($afiliacion)){
                    $data=array(
                        "idOrganization" => $afiliacion['ID'], 
                        "PublicationCount" => $afiliacion['PublicationCount'], 
                        "AutorCount" => $afiliacion['AuthorCount'], 
                        "CitationCount" => $afiliacion['CitationCount'], 
                        "Name" => $afiliacion['Name']
                    );                
                    $return["afiliado"]=$afiliacion["Name"];
                    if (!$this->debug)
                        if (!$this->db->insert('Organization', $data))
                            $return["Error"]["Organization"]=$this->db->_error_message();
                }else
                    $return["afiliado"]="No tiene afiliacion";                
                     
                /*******************************************/
                // Insertar al autor
                $data=array(
                    "IDAuthor"          => $res['ID'], 
                    "PublicationCount"  => $res['PublicationCount'], 
                    "CitationCount"     => $res['CitationCount'], 
                    "FirstName"         => $res['FirstName'], 
                    "LastName"          => $res['LastName'], 
                    "MiddleName"        => $res['MiddleName'], 
                    "NativeName"        => $res['NativeName'], 
                    "DisplayPhotoURL"   => $res['DisplayPhotoURL'], 
                    "HIndex"            => $res['HIndex'], 
                    "GIndex"            => $res['GIndex'], 
                    "Organization_idOrganization"  => $res['Affiliation']['ID']
                );                
                if (!$this->debug)
                    if (!$this->db->insert('Author', $data))
                        $return["Error"]["Author"]=$this->db->_error_message();
                
                 /*******************************************/
                // Insertar y asignar el interes al autor
                if (is_array($ResearchInterestDomain))
                    foreach($ResearchInterestDomain as $domain)
                    {                        
                        $data=array(
                            "Domain_idDomain" =>$domain['DomainID'], 
                            "Author_IDAuthor" =>$res['ID']
                        );
                        if (!$this->debug)
                            if (!$this->db->insert('Domain_has_Author', $data))
                                $return["Error"]["Domain_has_Author"]=$this->db->_error_message();
                    }
                //Falta agregar las keys, y además las publicaciones 
                $return=  array_merge($return,$this->addPublicaciones($idM));
                
                }
            
        echo "</pre>";        
        return $return;
    
     }
     
     private function addPublicaciones($idM){
        $json_url_base = "http://academic.research.microsoft.com/json.svc/search?AppId=d485d5b2-3e14-42d7-b090-a0d3eb8296d4&AuthorID=";
        $json_url_fin="&ResultObjects=Publication&StartIdx=1&EndIdx=100";
        
        $return =array();
        $data=array(
            array(
                "Type" =>"Unknown", 
                "idPublicationType" =>"0"
                ),
            array(
                "Type" =>"Paper", 
                "idPublicationType" =>"1"
                ),
            array(
                "Type" =>"Book", 
                "idPublicationType" =>"2"
                ),
            array(
                "Type" =>"Poster", 
                "idPublicationType" =>"3",                 
                ),            
            );
            if (!$this->debug)
                $this->db->insert_batch('PublicationType', $data);                    
            $data=array(
                'idConference'=>0,  "FullName"=>'', 'ShortName'=>''
                    );
            if (!$this->debug)
                $this->db->insert('Conference', $data);                
            $data=array(
                'idJournal'=>0,  "FullName"=>'', 'ShortName'=>''
                    );
            if (!$this->debug)
                $this->db->insert('Journal', $data);                    
        // obtengo los datos de MicrosoftR
        $json_url= $json_url_base . $idM . $json_url_fin;
        $string = file_get_contents($json_url);	    
        $json_MAS=json_decode($string,true);
        //echo $json_url;
        $NPub=$json_MAS['d']['Publication']['TotalItem'];
        $Publications=$json_MAS['d']['Publication']['Result'];
        
        //print_r($Publications);
        
        foreach ($Publications as $k=>$p) {
            /*if ($v['PublicationCount'] != $NPub){
                echo "Numero incorrecto de publicaciones de ".$v['PublicationCount']. ": ".$v['PublicationCount'] ." <==>". $p['TotalItem']."\n" ;         
            }*/
            $IDJournal=0;
            $IDconferencia=0;
            $return["publicaciones"][$k]=$p['Title'];
            if (is_array($p['Conference'])){
                $conference=$p['Conference'];
                $IDconferencia=$conference['ID'];                
                $data=array(
                    'idConference'=>$conference['ID'],
                    'FullName'=>$conference['FullName'],
                    'ShortName'=>$conference['ShortName']
                );                
                if (!$this->debug)
                    if (!$this->db->insert('Conference', $data))
                            $return["Error"]['Conference']=$this->db->_error_message();                
            }

            if (is_array($p['Journal'])){         
                $Journal=$p['Journal'];
                $IDJournal=$Journal['ID'];   
                $data=array(
                    'idJournal'=>$Journal['ID'],
                    'FullName'=>$Journal['FullName'],
                    'ShortName'=>$Journal['ShortName'],
                    'ISSN'=>$Journal['ShortName']
                );
                if (!$this->debug)
                    if (!$this->db->insert('Journal', $data))
                            $return["Error"]["Journal"]=$this->db->_error_message();
            }
            
             $data=array(
                    'idPublication'=>$p['ID'],
                    'CitationCount'=>$p['CitationCount'],
                    'Year'=>$p['Year'],
                    'Title'=>$p['Title'],
                    'ReferenceCount'=>$p['ReferenceCount'],
                    'PublicationType_idPublicationType'=>$p['Type'],
                    'Conference_idConference'=>$IDconferencia,
                    'Journal_idJournal'=>$IDJournal,
                    'DOI'=>$p['DOI'],
                );
             if (!$this->debug)
                    if (!$this->db->insert('Publication', $data))
                            $return["Error"]["Publication"]=$this->db->_error_message();
             /*Insertar la relacion autor -> Publicacion */
            foreach($p['Author'] as $PA) {                 
                $data=array(
                    'Author_IDAuthor'=>$PA['ID'],
                    'Publication_idPublication'=>$p['ID']
                );
                 if (!$this->debug)
                    if (!$this->db->insert('Author_has_Publication', $data))
                            $return["Error"]['Author_has_Publication']=$this->db->_error_message();
            }
            flush(); 
            /*Insertar los keywords*/
            foreach ($p['Keyword'] as $key) {
                $data=array(
                    'idKeyword'=>$key['ID'],
                    'Name'=>$key['Name']
                );
                 if (!$this->debug)
                    if (!$this->db->insert('Keyword', $data))
                            $return["Error"]['Keyword']=$this->db->_error_message();

                 $data2=array(
                    'Publication_idPublication'=>$p['ID'],
                    'Keyword_idKeyword'=>$key['ID'],
                    'RealKey'=>$key['ID']
                    );
                 
                 if (!$this->debug)
                    if (!$this->db->insert('Publication_has_Keyword', $data2))
                            $return["Error"]['Publication_has_Keyword']=$this->db->_error_message();             
            }
        } 
        return $return;
        
     }
     function CRUD(){         
        $this->grocery_crud->set_table('Author');
        $output = $this->grocery_crud->render();
        $this->_example_output($output);
     }
     function _example_output($output = null){
        $this->load->view('example',$output);
     } 
     function add(){         
        $this->debug=false;
        $data['mainContent']='addInve';       
        $data['title']='Titulo';        
        $data['res']=''; 
        if ( isset($_POST['IDM'])){
            $res=$this->AddInvestigador(intval($_POST['IDM']));
            $data['res']=$res;
        }
        
        $this->load->view('mainTemplate',$data);
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
        $this->db->like("CONCAT_WS(',',Author.FirstName,' ', MiddleName,' ',LastName )",$nombreA,'both');
        $this->db->or_like("NativeName",$nombreA);         
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

