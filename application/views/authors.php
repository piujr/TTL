
<script language="javascript" type="text/javascript" src="<?= base_url() ?>javascript/jit/jit.js"></script>
<script language="javascript" type="text/javascript" src="<?= base_url() ?>javascript/graph2.js"></script>
<link type="text/css" href="<?= base_url() ?>css/graph.css" rel="stylesheet" />


    <script src="<?= base_url() ?>javascript/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui.min.css" />
    <style>
    .ui-autocomplete-loading {
        background: white url('<?= base_url() ?>images/ui-anim_basic_16x16.gif') right center no-repeat;
    }
    </style>
    <script>
    function cargaGrafo(){
        $.ajax({
                    type: "post",
                    url: "<?= base_url() ?>index.php/graph/graphPErsonal",
                    data: "idAuthor=" + $("#idAuthor").val(),
                    success: function(datos){
                        $("#result2").html(datos);
                        init(json,'infovis2');
                       // alert($("#idAuthor").val())
                    }
              });
    }
    $(function() {
            
        $('#idAuthor').val('');
        $('#author').val('');
        /*function log( message ) {
            $( "<div>" ).text( message ).prependTo( "#log" );
            $( "#log" ).scrollTop( 0 );
        }*/
        function buscar(){
            if ($("#idAuthor").val().length ==0 )
                alert('Seleccione un autor');
            else
            $.ajax({
                    type: "post",
                    url: "<?= base_url() ?>index.php/authors/cloudAuthor",
                    data: "idAuthor="+$("#idAuthor").val(),
                    success: function(datos){
                        $("#result").html(datos);
                        cargaGrafo();
                       // alert($("#idAuthor").val())
                    }
              });
        }
    
        $('#buscar').click(function() {
           //alert($("#idAuthor").val());
            buscar();
          });
        $( "#author" ).autocomplete({
            source: "<?= base_url() ?>index.php/authors/searchAuthor",
            minLength: 2,
            select: function( event, ui ) {
                if (ui.item){
                    $('#idAuthor').val(ui.item.id);
                    buscar();
                }
                else
                    $('#idAuthor').val('');
            },
            search: function(event,ui){
                $('#idAuthor').val('');
            }
        });
    });
    </script>
    
    
    
    <div class="ui-widget">
        
        <form >
            <label for="author">Nombre Investigador: </label>
            <input id="author" name="author" size="20"/>
            <input type="hidden"id="idAuthor" name="idAuthor"/>
            <input type="button" id="buscar"name="buscar" value="buscar">
        </form>

    </div>
    <div  style="height:600px; background-color:#FFF">
        <div id="result" name="result" ></div>
        

        
    </div>
    
