var labelType, useGradients, nativeTextSupport, animate;

(function() {
  var ua = navigator.userAgent,
      iStuff = ua.match(/iPhone/i) || ua.match(/iPad/i),
      typeOfCanvas = typeof HTMLCanvasElement,
      nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
      textSupport = nativeCanvasSupport 
        && (typeof document.createElement('canvas').getContext('2d').fillText == 'function');
  //I'm setting this based on the fact that ExCanvas provides text support for IE
  //and that as of today iPhone/iPad current text support is lame
  labelType = (!nativeCanvasSupport || (textSupport && !iStuff))? 'Native' : 'HTML';
  nativeTextSupport = labelType == 'Native';
  useGradients = nativeCanvasSupport;
  animate = !(iStuff || !nativeCanvasSupport);
})();

var Log = {
  elem: false,
  write: function(text){
    if (!this.elem) 
      this.elem = document.getElementById('log');
    this.elem.innerHTML = text;
    this.elem.style.left = (500 - this.elem.offsetWidth / 2) + 'px';
  }
};


function init(){
  // init data
  /*
  var json = [
      {
        "adjacencies": [
            "graphnode21", 
            "graphnode1",
//            {
//              "nodeTo": "graphnode1",
//              "nodeFrom": "graphnode0",
//              "data": {
//                "$color": "#557EAA"
//              }
//            }
        ],
        "data": {
          "$color": "#83548B",
          "$type": "circle",
          "$dim": 20,
          "description": "no se que chingada"
        },
        "id": "graphnode0",
        "name": "graphnode0"
        
      }, {
        "adjacencies": [
            {
              "nodeTo": "graphnode2",
              "nodeFrom": "graphnode1",
              "data": {
                "$color": "#557EAA"
              }
            }
        ],
        "data": {
          "$color": "#EBB056",
          "$type": "circle",
          "$dim": 11,
          "description": "no se "
        },
        "id": "graphnode1",
        "name": "graphnode1"        
      }
      
  ];
  
 var json= [{"id":"56665667","name":"56665667","data":{"color":"red","$type":"circle","$dim":"10","description":"Rene Alejandro Venegas"},
                "adjacencies":[
                    {
                        "nodeFrom":"56665667",
                        "nodeTo":"Inter1"
                    },
                        "9489472","12636014","66842","9492374","483897","159042"
                    ]
                }
            ];
     
    
var json =[{"id":"56665667","name":"Rene Alejandro Venegas","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Rene Alejandro Venegas"},"adjacencies":["12636014","9489472","9492374","66842","483897","159042"]},{"id":"55306195","name":"Carlos  Rodriguez-Penagos","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Carlos  Rodriguez-Penagos"},"adjacencies":["2261900","2066823","66842","159042","2493701","53032819","3495859","10493359","18111209","23373065","23746340","51234486","3371268","3388608","131950","3519681","3569421","3614782","440362"]},{"id":"54769144","name":"John W. Atkinson","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"John W. Atkinson"},"adjacencies":["23373065","11366132"]},{"id":"54769142","name":"John P. Atkinson","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"John P. Atkinson"},"adjacencies":["23373065","51234486","23746340","36889072","541747","23609316","159042","23631152","23837609","24089277","25324814","8440828","18194229","21671024"]},{"id":"54274389","name":"Ricardo  Baeza","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Ricardo  Baeza"}},{"id":"53704510","name":"Andres Soto Varela","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Andres Soto Varela"},"adjacencies":["23523419","51234486"]},{"id":"53183571","name":"Rafael Hernandez Guzman","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Rafael Hernandez Guzman"},"adjacencies":["12636014","11366132","20034025","66842","541747","53032819","9489472"]},{"id":"53032819","name":"John  Atkinson","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"John  Atkinson"},"adjacencies":["2066823","66842","159042","440362","53173","2493701","10493359","2261900","131950","541747","9489472","9492374","2043801","7920","3352653","434963","3371268","724280","3527744","452405","2521999","1349380","3569421","663311","52762434","3614782","23523419","194680","35260177","3388608","3495859","3519681","18111209","22953124","483897","18194229","23373065","3826418","318746","12636014","3519686","52824871","4212559","3315194"]},{"id":"52824871","name":"Juan-Manuel Torres Moreno","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Juan-Manuel Torres Moreno"},"adjacencies":["541747","22953124","10493359","2066823","434963","440362"]},{"id":"52762434","name":"Alfonso  Medina-Urrea","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Alfonso  Medina-Urrea"},"adjacencies":["2493701","440362","2066823","7920","66842","159042","3371268","452405","541747","9492374","10493359","2043801","53173","318746","434963","3527744","3569421","663311","724280","18111209","2261900","22953124","131950","3495859"]},{"id":"52550226","name":"Juan Carlos Gomez","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Juan Carlos Gomez"},"adjacencies":["51234486","23746340","9489472","24089277","541747","23523419","8440828","483897","9492374","25324814","23631152","23876291","24666224","2261900","23837609","66842","12636014","18194229","23373065"]},{"id":"52426822","name":"Leonel  Ruiz-Miyares","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Leonel  Ruiz-Miyares"},"adjacencies":["159042"]},{"id":"51946663","name":"Rodrigo  Alfaro","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Rodrigo  Alfaro"},"adjacencies":["2689617"]},{"id":"51391637","name":"Andres Soto Jaramillo","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Andres Soto Jaramillo"},"adjacencies":["9489472","11366132","12636014","66842","541747"]},{"id":"51234486","name":"Antonio  Gonzalez","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Antonio  Gonzalez"},"adjacencies":["23746340","23373065","24089277","8440828","23523419","23837609","25324814","23609316","36889072","541747","18194229","483897","23631152","9489472","23876291","24931530","19701026","7920","21671024"]},{"id":"50959417","name":"Leonel Ruiz Miyares","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Leonel Ruiz Miyares"},"adjacencies":["159042","2521999","66842","131950","434963"]},{"id":"46055889","name":"Rodrigo  Alfaro","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Rodrigo  Alfaro"}},{"id":"36889072","name":"Michael John Atkinson","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Michael John Atkinson"},"adjacencies":["8440828","23373065","23837609","541747","23523419","23631152","9489472","18194229","483897","23746340","2043801","2066823","24089277","2521999","7920","66842","440362"]},{"id":"35421761","name":"Alfonso Soto Gonzalez","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Alfonso Soto Gonzalez"},"adjacencies":["23373065"]},{"id":"35260177","name":"Rafael  Guzman","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Rafael  Guzman"},"adjacencies":["9492374","9489472","12636014","2066823","66842","483897","159042","440362","541747","663311","10493359","7920","53173","131950","20034025","452405","2043801","11366132","2261900","2521999","3315194","21671024","194680","434963","23746340"]},{"id":"34067429","name":"Rodrigo  Alfaro","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Rodrigo  Alfaro"},"adjacencies":["2066823","2261900","66842","3519681","159042","3569421","440362","10493359","724280","2043801","2493701","53173","131950"]},{"id":"25324814","name":"Marco Antonio Juarez-Oropeza","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Marco Antonio Juarez-Oropeza"},"adjacencies":["23631152","23523419","23746340","18194229","23373065","23837609","24089277","541747","8440828","21671024","23876291"]},{"id":"24931530","name":"Rodrigo  Alfaro","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Rodrigo  Alfaro"},"adjacencies":["23523419","23837609"]},{"id":"24666224","name":"Juan Carlos Gomez-Esteban","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Juan Carlos Gomez-Esteban"},"adjacencies":["8440828","23837609","483897","23631152","23746340","24089277","7920","66842","131950","10493359","18194229","23373065"]},{"id":"24089277","name":"Roberto R Focaccia","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Roberto R Focaccia"},"adjacencies":["23523419","23746340","23373065","23837609","8440828","541747","9489472"]},{"id":"23876291","name":"Ricardo  Baeza","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Ricardo  Baeza"},"adjacencies":["9489472","23746340","12636014","18194229","11366132","20034025","66842","19701026"]},{"id":"23837609","name":"Aurelio  Lopez-Colombo","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Aurelio  Lopez-Colombo"},"adjacencies":["23746340","23373065","8440828","23523419","23631152","483897","541747"]},{"id":"23746340","name":"Gerardo E. Guillen","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Gerardo E. Guillen"},"adjacencies":["23373065","23609316","23523419","9489472","8440828","541747","23631152","11366132","12636014","18194229","66842","131950","483897","20034025","2043801","2066823","2261900","3495859","9492374","19701026","21671024"]},{"id":"23631152","name":"Maria del Pilar Carrera","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Maria del Pilar Carrera"},"adjacencies":["23373065","8440828","23609316","7920","483897","541747"]},{"id":"23609316","name":"Howard John Atkinson","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Howard John Atkinson"},"adjacencies":["23373065","483897","2043801","11366132","18194229","541747","8440828","20034025","66842","21671024"]},{"id":"23523419","name":"John L. D. Atkinson","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"John L. D. Atkinson"},"adjacencies":["8440828","9489472","541747","23373065","2261900","66842","131950","3527744","7920","9492374","10493359","159042","434963","440362"]},{"id":"23373065","name":"John P. Atkinson","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"John P. Atkinson"},"adjacencies":["11366132","8440828","541747","21671024","66842","12636014","483897","20034025","2043801","2261900","9489472","7920","10493359","159042","18194229"]},{"id":"22953124","name":"Juan Manuel Torres-Moreno","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Juan Manuel Torres-Moreno"},"adjacencies":["541747","10493359","66842","2066823","159042","3826418","2493701","131950","3352653","7920","2261900","3495859","434963","440362","3569421","3584801","2043801","53173","2521999","194680","3371268","318746"]},{"id":"21671024","name":"Manuel  Palomar-Pardave","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Manuel  Palomar-Pardave"},"adjacencies":["20034025","11366132","66842","9489472","12636014","9492374","18194229","541747","131950","2066823"]},{"id":"20034025","name":"Manuel Eduardo Palomar-Pardave","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Manuel Eduardo Palomar-Pardave"},"adjacencies":["66842","11366132","9489472","12636014","9492374","131950","159042","18194229","2493701","13502149","483897","2261900","3527744"]},{"id":"19701026","name":"Maria del Pilar Garcia-Santos","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Maria del Pilar Garcia-Santos"},"adjacencies":["11366132","12636014","18194229"]},{"id":"18194229","name":"Aurelio  Lopez-Malo","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Aurelio  Lopez-Malo"},"adjacencies":["12636014","483897","66842","131950","9489472","11366132","440362","541747","663311","9492374","2066823","2521999","159042","434963"]},{"id":"18111209","name":"Azucena  Montes","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Azucena  Montes"},"adjacencies":["2493701","440362","2066823","66842","131950","159042","3371268","452405","9489472","3527744","541747","663311","724280","2043801","10493359","7920","2261900","53173","194680","3388608","3584801","3826418","9492374","3352653","318746","3495859","434963","3519681"]},{"id":"13502149","name":"Juan Carlos Carretero","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Juan Carlos Carretero"},"adjacencies":["11366132","12636014","66842","9489472"]},{"id":"12636014","name":"Javier  Tejada","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Javier  Tejada"},"adjacencies":["11366132","9489472","9492374","66842","483897","3527744","440362","2066823","2493701","7920","434963","10493359"]},{"id":"11366132","name":"Igor Leonidovich Eremenko","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Igor Leonidovich Eremenko"},"adjacencies":["66842","9489472","483897","3527744","9492374"]},{"id":"10765809","name":"Ricardo  Baeza","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Ricardo  Baeza"}},{"id":"10493359","name":"Luis Villasenor Pineda","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Luis Villasenor Pineda"},"adjacencies":["66842","159042","131950","3352653","2066823","440362","2493701","2043801","53173","2521999","7920","434963","541747","2261900","3371268","724280","3614782","3519686","9489472","452405","3826418","3388608","5810412","3519681","3527744","3584801","194680","9492374","3495859","663311","1002476","1349380","318746","483897","3569421","3315194","3522597","8440828"]},{"id":"9492374","name":"John  Atkinson","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"John  Atkinson"},"adjacencies":["9489472","2261900","66842","2066823","440362","541747","53173","159042","7920","2493701","663311","483897","434963","452405","3527744","724280","2043801","2521999","131950","194680","3569421","3371268","3388608","3584801","1349380","3826418","3352653","3519681"]},{"id":"9489472","name":"Juan Carlos Gomez","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Juan Carlos Gomez"},"adjacencies":["159042","541747","66842","7920","663311","2493701","434963","440362","483897","2066823","2261900","3527744","2043801","3519686","2521999","194680","3371268","3388608","3584801","724280","1349380","8440828","53173","131950","2689617"]},{"id":"8440828","name":"Juan Jose Zarranz","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Juan Jose Zarranz"},"adjacencies":["483897","541747","7920"]},{"id":"5810412","name":"Luis Alberto Pineda Cortes","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Luis Alberto Pineda Cortes"},"adjacencies":["159042","434963","440362","2261900","66842","2043801","2066823","53173","131950","663311"]},{"id":"4212559","name":"Ernesto Cuadros Vargas","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Ernesto Cuadros Vargas"},"adjacencies":["1349380","2066823"]},{"id":"3827435","name":"Jose Tecuapacho Zecua","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Jose Tecuapacho Zecua"},"adjacencies":["3522597","541747","2066823"]},{"id":"3826418","name":"Alberto  Barron-Cedeno","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Alberto  Barron-Cedeno"},"adjacencies":["159042","2066823","66842","53173","440362","434963","541747","2261900","2493701","131950","2521999","3584801","2043801","7920","3519686","452405","3527744","1349380","3352653","3388608","663311","724280","194680","3371268","318746","3495859"]},{"id":"3614782","name":"Antonio  Juarez-gonzalez","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Antonio  Juarez-gonzalez"},"adjacencies":["66842","3352653","131950","159042","2066823","2493701","440362","2043801","3371268","53173","3519686","724280","2261900","2521999","3519681","434963","541747","3569421","7920","318746","452405","3527744"]},{"id":"3584801","name":"Darnes Vilarino Ayala","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Darnes Vilarino Ayala"},"adjacencies":["159042","66842","2066823","53173","434963","440362","131950","3527744","541747","2043801","7920","2493701","3519686","452405","2261900","2521999","3371268","724280","3352653"]},{"id":"3569421","name":"Yulia Nikolaevna Ledeneva","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Yulia Nikolaevna Ledeneva"},"adjacencies":["2066823","2261900","3519681","541747","159042","66842","2493701","440362","2521999","53173","7920","318746","452405","724280","3371268","131950","3495859","434963","3527744","1349380","2043801","17509","3352653"]},{"id":"3527744","name":"Marcelo Luis Errecalde","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Marcelo Luis Errecalde"},"adjacencies":["159042","2066823","2261900","66842","53173","2493701","434963","440362","131950","541747","724280","3371268","452405","1349380","2043801","2521999","7920","318746","3519681","3519686","194680","3352653","3388608"]},{"id":"3522597","name":"Maria Josefa Somodevilla Garcia","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Maria Josefa Somodevilla Garcia"},"adjacencies":["2066823","541747","2493701","7920","159042","440362","66842","1349380","2043801","2261900","53173","3371268","131950","3519686","434963"]},{"id":"3519686","name":"David Pinto Avendano","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"David Pinto Avendano"},"adjacencies":["66842","159042","2066823","53173","440362","2043801","2521999","2493701","131950","3352653","434963","7920","3371268","452405","483897","1349380","194680"]},{"id":"3519681","name":"Rene Arnulfo Garcia-hernandez","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Rene Arnulfo Garcia-hernandez"},"adjacencies":["2066823","2493701","66842","7920","159042","2261900","541747","53173","131950","440362","724280","2043801","434963","452405","1349380","3352653","318746","2521999","3371268"]},{"id":"3495859","name":"Carlos Rodriguez Penagos","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Carlos Rodriguez Penagos"},"adjacencies":["2066823","159042","2261900","2493701","66842","131950","541747","7920","440362","724280","3371268","2043801","2521999","318746","53173","3352653","434963"]},{"id":"3388608","name":"Heriberto  Cuayahuitl","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Heriberto  Cuayahuitl"},"adjacencies":["66842","159042","440362","2261900","2493701","663311","2066823","131950","541747","2043801","53173","2521999","724280","1002476","3371268","434963"]},{"id":"3371268","name":"Paloma  Moreda","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Paloma  Moreda"},"adjacencies":["2493701","159042","2066823","440362","66842","131950","724280","2043801","53173","3352653","434963","452405","7920","541747","2261900","2521999","318746","663311"]},{"id":"3352653","name":"Manuel Alberto Perez-Coutino","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Manuel Alberto Perez-Coutino"},"adjacencies":["66842","131950","159042","2043801","440362","2493701","2066823","724280","53173","541747","7920","2261900","434963","452405","1349380","2521999","318746","194680"]},{"id":"3315194","name":"Jorge Rafael Gutierrez-pulido","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Jorge Rafael Gutierrez-pulido"},"adjacencies":["66842","2043801","2066823","131950","159042","1349380","2521999","440362","2493701","7920","434963"]},{"id":"2689617","name":"Rodrigo A. Alfaro","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Rodrigo A. Alfaro"},"adjacencies":["541747","2066823","7920","440362"]},{"id":"2521999","name":"Hugo Jair Escalante","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Hugo Jair Escalante"},"adjacencies":["66842","131950","2066823","159042","7920","434963","440362","2043801","541747","2261900","1349380","53173","2493701","452405","194680","483897","724280","318746"]},{"id":"2493701","name":"Manuel  Palomar","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Manuel  Palomar"},"adjacencies":["440362","2066823","159042","66842","434963","53173","131950","7920","2261900","724280","2043801","541747","452405","318746","663311","194680","1349380"]},{"id":"2261900","name":"Ana Gabriela Maguitman","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Ana Gabriela Maguitman"},"adjacencies":["2066823","7920","66842","159042","440362","131950","541747","53173","434963","663311","724280","452405","1349380","2043801","194680","483897","318746"]},{"id":"2066823","name":"Alexander F. Gelbukh","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Alexander F. Gelbukh"},"adjacencies":["53173","159042","66842","452405","440362","131950","724280","434963","541747","7920","2043801","663311","194680","318746","1349380","17509","483897"]},{"id":"2043801","name":"Thamar  Solorio","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Thamar  Solorio"},"adjacencies":["66842","159042","131950","440362","53173","434963","541747","724280","7920","452405","1349380","318746","663311","1002476","194680"]},{"id":"1349380","name":"Ernesto  Cuadros-vargas","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Ernesto  Cuadros-vargas"},"adjacencies":["66842","7920","541747","53173","131950","434963","159042","194680","440362","452405","724280"]},{"id":"1002476","name":"Alejandro  Barbosa","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Alejandro  Barbosa"},"adjacencies":["66842","159042"]},{"id":"724280","name":"Hiram  Calvo","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Hiram  Calvo"},"adjacencies":["159042","66842","440362","131950","434963","452405","53173","541747","7920","318746","663311","194680"]},{"id":"663311","name":"Maria Felisa Verdejo","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Maria Felisa Verdejo"},"adjacencies":["440362","131950","159042","541747","53173","66842","194680","7920","483897","434963","452405"]},{"id":"541747","name":"Juan Manuel Torres Moreno","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Juan Manuel Torres Moreno"},"adjacencies":["159042","66842","440362","7920","53173","131950","434963","452405","194680","483897","318746","17509"]},{"id":"483897","name":"Jeffrey A. Harvey","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Jeffrey A. Harvey"},"adjacencies":["66842","434963","7920","131950"]},{"id":"452405","name":"Igor A. Bolshakov","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Igor A. Bolshakov"},"adjacencies":["53173","159042","434963","440362","66842","7920","131950","194680","318746","17509"]},{"id":"440362","name":"Felisa  Verdejo","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Felisa  Verdejo"},"adjacencies":["159042","66842","131950","53173","7920","434963","318746","194680"]},{"id":"434963","name":"Ted  Pedersen","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Ted  Pedersen"},"adjacencies":["159042","66842","53173","131950","7920","318746","194680"]},{"id":"318746","name":"Laura Alonso i Alemany","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Laura Alonso i Alemany"},"adjacencies":["159042","66842","53173","131950","7920"]},{"id":"194680","name":"Azucena Montes Rendon","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Azucena Montes Rendon"},"adjacencies":["53173","66842","159042","7920","131950"]},{"id":"159042","name":"Paolo  Rosso","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Paolo  Rosso"},"adjacencies":["66842","131950","53173","7920","17509"]},{"id":"131950","name":"Aurelio  Lopez-lopez","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Aurelio  Lopez-lopez"},"adjacencies":["66842","7920","53173"]},{"id":"66842","name":"Manuel  Montes-y-gomez","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Manuel  Montes-y-gomez"},"adjacencies":["7920","53173"]},{"id":"53173","name":"Grigori  Sidorov","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Grigori  Sidorov"},"adjacencies":["7920"]},{"id":"17509","name":"Dina  Wonsever","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Dina  Wonsever"}},{"id":"7920","name":"Ricardo A. Baeza-yates","data":{"color":"#557EAA","$type":"circle","$dim":"10","description":"Ricardo A. Baeza-yates"}}];
 */
  // end
  // init ForceDirected
  var fd = new $jit.ForceDirected({
    //id of the visualization container
    injectInto: 'infovis',
    //Enable zooming and panning
    //by scrolling and DnD
    Navigation: {
      enable: true,
      //Enable panning events only if we're dragging the empty
      //canvas (and not a node).
      panning: 'avoid nodes',
      zooming: 20 //zoom speed. higher is more sensible
    },
    // Change node and edge styles such as
    // color and width.
    // These properties are also set per node
    // with dollar prefixed data-properties in the
    // JSON structure.
   Node: {
      color: '#000000',
      overridable: true
    },
    Edge: {
      overridable: true,
      color: '#6E6C6D',
      lineWidth: 0.3
    },
    //Native canvas text styling
    Label: {
      type: labelType, //Native or HTML
      size: 9,
      color: '#23A4FF',
      style: 'bold'
    },
    //Add Tips
    Tips: {
      enable: true,
      onShow: function(tip, node) {
        //count connections
        var count = 0;
        node.eachAdjacency(function() { count++; });
        //display node info in tooltip
        //inspeccionar(node.data);
        tip.innerHTML = "<div class=\"tip-title\">" + node.data.description + "</div>"
          + "<div class=\"tip-text\"><b>Relaciones:</b> " + count + "</div>";
      }
    },
    // Add node events
    Events: {
      enable: true,
      type: 'Native',
      //Change cursor style when hovering a node
      onMouseEnter: function() {
        fd.canvas.getElement().style.cursor = 'move';
      },
      onMouseLeave: function() {
        fd.canvas.getElement().style.cursor = '';
      },
      //Update node positions when dragged
      onDragMove: function(node, eventInfo, e) {
          var pos = eventInfo.getPos();
          node.pos.setc(pos.x, pos.y);
          fd.plot();
      },
      //Implement the same handler for touchscreens
      onTouchMove: function(node, eventInfo, e) {
        $jit.util.event.stop(e); //stop default touchmove event
        this.onDragMove(node, eventInfo, e);
      },
      //Add also a click handler to nodes
      onClick: function(node) {
        if(!node) return;
        // Build the right column relations list.
        // This is done by traversing the clicked node connections.
        var html = "<h4>" + node.name + "</h4><b> Relaciones:</b><ul><li>",
            list = [];
        node.eachAdjacency(function(adj){
          list.push(adj.nodeTo.name);
        });
        //append connections information
        $jit.id('inner-details').innerHTML = html + list.join("</li><li>") + "</li></ul>";
      }
    },
    //Number of iterations for the FD algorithm
    iterations: 270,
    //Edge length
    levelDistance: 220,
    // Add text to the labels. This method is only triggered
    // on label creation and only for DOM labels (not native canvas ones).
    onCreateLabel: function(domElement, node){
      domElement.innerHTML = node.name;
      var style = domElement.style;
      style.fontSize = "0.8em";
      style.color = "#ddd";
    },
    // Change node styles when DOM labels are placed
    // or moved.
    onPlaceLabel: function(domElement, node){
      var style = domElement.style;
      var left = parseInt(style.left);
      var top = parseInt(style.top);
      var w = domElement.offsetWidth;
      style.left = (left - w / 2) + 'px';
      style.top = (top + 10) + 'px';
      style.display = '';
    }
  });
  // load JSON data.
  fd.loadJSON(json);
  // compute positions incrementally and animate.
  fd.computeIncremental({
    iter: 40,
    property: 'end',
    onStep: function(perc){
      Log.write(perc + '% loaded...');
    },
    onComplete: function(){
      Log.write('done');
      fd.animate({
        modes: ['linear'],
        transition: $jit.Trans.Elastic.easeOut,
        duration: 2500
      });
    }
  });
  // end
}
