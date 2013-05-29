<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Description of Movimientos
 *
 * @author jcabrera
 */
class Management extends CI_Controller {

    private $crud;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
        $this->crud = new grocery_CRUD();
        $this->crud->set_theme('datatables');
        $this->crud->unset_delete();
    }

    public function index() {
        $this->load->view('Admon', array());
    }

    public function TTL_Keys() {

        $this->crud->set_table('Keyword');
        $this->crud->columns('Name', 'baja');
        $this->crud->display_as('Name', 'Nombre')
                ->display_as('baja', 'Baja');
        $this->crud->set_subject('Keywors');
        $this->crud->callback_column('baja', array($this, 'activo'));

        $this->crud->add_action('Enable', '', 'Management/Extras/Keyword','ui-icon-plus');
        $output = $this->crud->render();
        $this->output($output);
    }

    public function activo($value, $row) {
        return ($value == 1) ? 'inactivo' : 'activo';
    }

    public function TTL_KeysPub() {
        
        $this->crud->set_table('Publication_has_Keyword');
        $this->crud->columns('Publication_idPublication',  'Keyword_idKeyword');
        $this->crud->display_as('Publication_idPublication', 'Publicacion')
        //        ->display_as('RealKey', 'Key Original')
                ->display_as('Keyword_idKeyword', 'Key Mostrado');
        $this->crud->set_subject('Keywors');        
        $this->crud->set_relation('Keyword_idKeyword', 'Keyword', 'Name');
        $this->crud->set_relation('Publication_idPublication', 'Publication', 'Title');

        $output = $this->crud->render();

        $this->output($output);
    }

    /* public function authorPublication(){

      $this->crud->set_table('Author_has_Publication');
      $this->crud->columns('Author_IDAuthor','Publication_idPublication');
      $this->crud->display_as('Author_IDAuthor','Author')
      ->display_as('Publication_idPublication','Publicacion');
      $this->crud->set_subject('Autores y sus publicaciones');
      $this->crud->set_relation('Publication_idPublication','Publication','Title');
      $this->crud->set_relation('Author_IDAuthor','Author','{FirstName} {MiddleName} {LastName} ({NativeName})');
      $output = $this->crud->render();
      $this->output($output);
      }
     * 
     */

    public function TTL_authorPublication() {

        $this->crud->set_table('Author');
        $this->crud->set_relation_n_n('Publicaciones', 'Author_has_Publication', 'Publication', 'Author_IDAuthor', 'Publication_idPublication', 'Title');
        $this->crud->set_relation('Organization_idOrganization', 'Organization', 'Name');
        $this->crud->unset_columns('DOI', 'URL', 'YEAR', 'PublicationCount', 'CitationCount', 'citationCount', 'HIndex', 'GIndex', 'DisplayPhotoURL');
        $this->crud->fields('FirstName', 'LastName', 'MiddleName', 'NativeName', 'Extras', 'DisplayPhotoURL', 'Publicaciones', 'Organization_idOrganization');
        $this->crud->display_as('Extras', 'Desactivado');
        $this->crud->callback_column('Extras', array($this, 'activo'));
        $this->crud->where('Author.IDAuthor >', 0);        
        $output = $this->crud->render();
        $this->output($output);
    }

    function output($output = null) {
        $this->load->view('example', $output);
    }

    public function TTL_Publication() {

        $this->crud->set_table('Publication');
        $this->crud->columns('idPublication', 'Title', 'Year', 'DOI', 'Conference_idConference', 'Journal_idJournal','IdBaja');
        $this->crud->set_relation('Conference_idConference', 'Conference', 'FullName');
        $this->crud->set_relation('Journal_idJournal', 'Journal', 'FullName');
        $this->crud->set_relation('IdBaja', 'Baja', 'Nombre');
        $this->crud->display_as('Year', 'Año')
                ->display_as('Title', 'Titulo')
                ->display_as('Journal_idJournal', 'Journal')
                ->display_as('Conference_idConference', 'Conferencia')
                ->display_as('IdBaja', 'Activo');
        
        $this->crud->add_action('Enable', '', 'Management/IdBaja/Publication','ui-icon-plus');
        $this->crud->set_subject('Publication');

        $output = $this->crud->render();
        $this->output($output);
    }

    public function TTL_Organization() {

        $this->crud->set_table('Organization');
        $this->crud->columns('idOrganization', 'Name','IdBaja');
        $this->crud->display_as('Name', 'Nombre')
                ->display_as('IdBaja','Activo');
        $this->crud->set_relation('IdBaja', 'Baja', 'Nombre');
        $this->crud->set_subject('Centro de investigacion');
        $this->crud->where('idOrganization >', 0);
        $this->crud->add_action('Enable', '', 'Management/IdBaja/Organization','ui-icon-plus');
        $output = $this->crud->render();
        $this->output($output);
    }

    public function TTL_Journal() {

        $this->crud->set_table('Journal');
        $this->crud->columns('idJournal', 'FullName', 'ShortName','IdBaja');
        $this->crud->display_as('FullName', 'Nombre Completo')
                ->display_as('IdBaja', 'Activo')
                ->display_as('ShortName', 'Nombre Corto');
        $this->crud->set_subject('Journals');
        $this->crud->set_relation('IdBaja', 'Baja', 'Nombre');
        $this->crud->where('idJournal >', 0);
        $this->crud->add_action('Enable', '', 'Management/IdBaja/Journal','ui-icon-plus');
        $output = $this->crud->render();
        $this->output($output);
    }

    public function TTL_Conference() {

        $this->crud->set_theme('datatables');
        $this->crud->set_table('Conference');
        //$this->crud->where('id !=', 1);
        $this->crud->columns('idConference', 'FullName', 'ShortName','IdBaja');
        $this->crud->display_as('FullName', 'Nombre Completo')
                ->display_as('IdBaja', 'Activo')
                ->display_as('ShortName', 'Nombre Corto');
        $this->crud->set_subject('Conferencias');
        $this->crud->set_relation('IdBaja', 'Baja', 'Nombre');        
        $this->crud->add_action('Enable', '', 'Management/IdBaja/Conference','ui-icon-plus');
        $this->crud->where('idConference >', 0);
        $output = $this->crud->render();
        $this->output($output);
    }

    public function IdBaja($ruta,$id) {
        $query = $this->db->get_where($ruta, array('id'.$ruta => $id));               
        $res=$query->result();
        $res=$res[0];
        print_r($res);
        $data= array("IdBaja" => ($res->IdBaja ==1) ? 0: 1);
        $this->db->where('id'.$ruta, $id);
        echo $this->db->update($ruta, $data); 
        
        redirect('Management/TTL_'.$ruta, 'refresh');        
        return true;
    }
    public function Extras($ruta,$id) {
        $query = $this->db->get_where($ruta, array('id'.$ruta => $id));               
        $res=$query->result();
        $res=$res[0];
        //print_r($res);
        $data= array("baja" => ($res->baja ==1) ? 0: 1);
        $this->db->where('id'.$ruta, $id);
        //echo $this->db->update($ruta, $data); 
        
        redirect('Management/TTL_Keys', 'refresh');        
        return true;
    }

}

?>
