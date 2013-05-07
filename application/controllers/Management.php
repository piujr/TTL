<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
/**
 * Description of Movimientos
 *
 * @author jcabrera
 */
class Management extends CI_Controller {
     public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->load->helper('url'); 
            $this->load->library('grocery_CRUD');
     }
     public function index(){         
         $this->load->view('Admon',array());	
     }
    public function TTL_Keys(){
        $crud = new grocery_CRUD();

        $crud->set_table('Keyword');
        $crud->columns('Name','baja');
        $crud->display_as('Name','Nombre')
                 ->display_as('baja','Baja');
        $crud->set_subject('Keywors');
        //$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

        $output = $crud->render();

        $this->output($output);
    }
    public function TTL_KeysPub(){
        $crud = new grocery_CRUD();

        $crud->set_table('Publication_has_Keyword');
        $crud->columns('Publication_idPublication','RealKey','Keyword_idKeyword');
        $crud->display_as('Publication_idPublication','Publicacion')
                 ->display_as('RealKey','Original')
                 ->display_as('Keyword_idKeyword','Mostrado');
        $crud->set_subject('Keywors');
        $crud->set_relation('Keyword_idKeyword','Keyword','Name');
        $crud->set_relation('RealKey','Keyword','Name');
        $crud->set_relation('Publication_idPublication','Publication','Title');

        $output = $crud->render();

        $this->output($output);
    }
    /*public function authorPublication(){
        $crud = new grocery_CRUD();
        $crud->set_table('Author_has_Publication');
            $crud->columns('Author_IDAuthor','Publication_idPublication');
        $crud->display_as('Author_IDAuthor','Author')
             ->display_as('Publication_idPublication','Publicacion');
        $crud->set_subject('Autores y sus publicaciones');
        $crud->set_relation('Publication_idPublication','Publication','Title');
        $crud->set_relation('Author_IDAuthor','Author','{FirstName} {MiddleName} {LastName} ({NativeName})');        
        $output = $crud->render();
        $this->output($output);
    }
     * 
     */
    public function TTL_authorPublication(){
        $crud = new grocery_CRUD();
        $crud->set_table('Author');
        $crud->set_relation_n_n('Publicaciones', 'Author_has_Publication', 'Publication', 'Author_IDAuthor', 'Publication_idPublication', 'Title');        
        $crud->set_relation('Organization_idOrganization', 'Organization','Name');
        $crud->unset_columns('DOI','URL','YEAR','PublicationCount','CitationCount','citationCount','HIndex','GIndex','DisplayPhotoURL');
        $crud->fields('FirstName', 'LastName', 'MiddleName', 'NativeName','Extras','DisplayPhotoURL','Publicaciones','Organization_idOrganization' );
        $crud->display_as('Extras','Desactivado');
        $output = $crud->render();
        $this->output($output);
    }
    function output($output = null){
        $this->load->view('example',$output);	
    }
    
    public function TTL_Publications(){
        $crud = new grocery_CRUD();
        $crud->set_table('Publication');
        $crud->columns('idPublication','Title','Year','DOI','Conference_idConference','Journal_idJournal');
        $crud->set_relation('Conference_idConference', 'Conference','FullName');
        $crud->set_relation('Journal_idJournal', 'Journal','FullName');
        $crud->display_as('Year','Año')
                 ->display_as('Title','Titulo')
                 ->display_as('Journal_idJournal','Journal')
                 ->display_as('Conference_idConference','Conferencia');
        $crud->set_subject('Publication');
        $output = $crud->render();
        $this->output($output);
    }
    public function TTL_Organization(){
         $crud = new grocery_CRUD();
        $crud->set_table('Organization');
        $crud->columns('idOrganization','Name');
        $crud->display_as('Name','Nombre');
        $crud->set_subject('Centro de investigacion');
        $output = $crud->render();
        $this->output($output);
    }
    public function TTL_Journal(){
         $crud = new grocery_CRUD();
        $crud->set_table('Journal');
        $crud->columns('idJournal','FullName','ShortName');
        $crud->display_as('FullName','Nombre Completo')
        ->display_as('ShortName','Nombre Corto');
        $crud->set_subject('Journals');
        $output = $crud->render();
        $this->output($output);
    }
    public function TTL_Conference(){
        $crud = new grocery_CRUD();
        $crud->set_theme('datatables');
        $crud->set_table('Conference');
        //$crud->where('id !=', 1);
        $crud->columns('idConference','FullName','ShortName');
        $crud->display_as('FullName','Nombre Completo')
        ->display_as('ShortName','Nombre Corto');
        $crud->set_subject('Conferencias');
        $crud->unset_delete();
        //$crud->add_action('Eliminar', '', '','ui-icon-circle-minus',array($this,'just_a_test'));
        //$crud->callback_before_update(array($this,'log_user_before_delete'));
        $output = $crud->render();
        $this->output($output);
    }
 
    
    
}
?>
