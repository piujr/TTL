
    <script type="text/javascript">
     var Orden;
     
     function OpenDialog(fila, columna) {
        //alert(Orden.id[fila]+'_' +fila +'_' + columna);
        $( "#dialog" ).load("<?= base_url() ?>index.php/estadisticas/<?=$destinoDetalle?>",{'id': Orden.id[fila], 'page':'<?=$destino?>', 'tipo': columna}).dialog({
            modal: true,
            resizable: false,
            height:400,
            width: 950,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
   
  
    
    function drawChart() {
      var jsonData = $.ajax({
          url: "<?= base_url() ?>index.php/estadisticas/<?= $destino?>",
          dataType:"json",
          async: false,
          success: function (jsonData1) {
                jsonData = jsonData1.data;
                var data = new google.visualization.DataTable(jsonData);
                Orden = jsonData1.orden;
               //alert(Orden.id[1]);
                var options = {
                title: jsonData1.title,
                vAxis: {title: 'Organizacion',  titleTextStyle: {color: 'red'}},
                width: 1000, height: 1000,
                 is3D: false,                
                 fontSize: 10,
                isStacked: true
              };

                // Instantiate and draw our chart, passing in some options.
                //ColumnChart
                var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                
                
                
                 function selectHandler() {
                    /*var selectedItem = chart.getSelection()[0];
                    if (selectedItem) {
                      var topping = data.getValue(selectedItem.row, 3);
                      var topping2  = data.getValue(selectedItem.row, 2);
                     alert(e);
                      alert('The user selected ' + topping + topping2);
                    }*/ 
                        
                           var selection = chart.getSelection();
                           
                           var row, column;
                           for (var i = 0; i < selection.length; i++) {
                                var item = selection[i];
                                if (item.row != null && item.column != null) {
                                  row= item.row ;
                                  column=item.column;
                                } else if (item.row != null) {
                                  row= item.row ;
                                } else if (item.column != null) {
                                  column=item.column;
                                }
                              }
                              
                             OpenDialog(row,column);
                  }

                google.visualization.events.addListener(chart, 'select', selectHandler);
                chart.draw(data, options);
                
                 

            }
          });
          

   
    } 
    function barMouseOver(e) {           
            alert(chart.getSelection());
          }
       

    </script>
 
</head>
<!--
<div id="topbar">
<div class="wrapper">
    <div id="topnav">
        <ul>        
    
    <li><a href="<?= base_url() ?>index.php/estadisticas/conferencias">Publicaciones por Institución</a></li>
    <li><a href="<?= base_url() ?>index.php/estadisticas/conferencias">Número de investigadores por tema</a></li>
    <li><a href="<?= base_url() ?>index.php/estadisticas/conferencias">Investigadores y sus palabras claves asociadas</a></li>
    <li><a href="<?= base_url() ?>index.php/estadisticas/conferencias">Palabras claves e investigadores asociados</a></li>
    <li><a href="<?= base_url() ?>index.php/estadisticas/conferencias">Diversidad de temas por Institución</a></li>
    
    <li><a href="<?= base_url() ?>index.php/estadisticas/conferencias">Distribución de Publicaciones de la Línea TecLyC</a></li>
    <li><a href="<?= base_url() ?>index.php/estadisticas/conferencias">Número de publicaciones de los miembros de la línea TecLyC por congreso.</a></li>
    <li><a href="<?= base_url() ?>index.php/estadisticas/conferencias">Descripción de los congresos donde publican los miembros de la línea TecLyC</a></li>
    <li><a href="<?= base_url() ?>index.php/estadisticas/conferencias">Número de publicaciones de los miembros de la línea TecLyC por revista</a></li>
    <li><a href="<?= base_url() ?>index.php/estadisticas/conferencias">Descripción de las revistas donde publican los miembros de la línea TecLyC</a></li>
        </ul>
 </div>   
    </div>
    
</div>
-->
<script src="<?= base_url() ?>javascript/jquery.bgiframe-2.1.2.js"></script>
    
<h1><?=$titulo?></h1>
<br>
<div id="chart_div"></div>
<div id="dialog" title="Detalles">
    
</div>