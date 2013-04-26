<?php
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
         
     }
    public function keys(){
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
    public function keysPub(){
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
    public function authorPublication(){
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
    public function authorPublicationN(){
        $crud = new grocery_CRUD();
        
        $crud->set_table('Author_has_Publication');
        $crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
        $crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');

        $crud->unset_columns('description','special_features','last_update');
        $crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');
 
        
        $output = $crud->render();
        $this->output($output);
    }
    


    function output($output = null){
        $this->load->view('example',$output);	
    }
    
    public function Publications(){
    }
    public function Organization(){
    }
    public function Journal(){
    }
    public function Conference(){
    }
    public function Domain(){
    }
    
}
?>
