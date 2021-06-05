<style type="text/css">

 	.typeahead{
        font-size: 16px;
        width: 100%;
    }
    .dropdown-menu>li>a {
        white-space: normal !important;
    }
    

.twitter-typeahead{
	width: 100%;
}
.typeahead, .tt-query, .tt-hint {
	width: 100%;	
}
.typeahead {
	background-color: #FFFFFF;
}
.typeahead:focus {
	border: 2px solid #0097CF;
}
.tt-query {
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
}
.tt-hint {
	color: #999999;
	/*width: 100%;*/
}
.tt-menu {
	background-color: #FFFFFF;
	border: 1px solid rgba(0, 0, 0, 0.2);
	border-radius: 8px;
	box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
	margin-top: 6px;
	padding: 8px 0;
	width: 100%;
}
.tt-suggestion {
	font-size: 16px;  /* Set suggestion dropdown font size */
	padding: 3px 20px;
}
.tt-suggestion:hover {
	cursor: pointer;
	background-color: #0097CF;
	color: #FFFFFF;
}
.tt-suggestion p {
	margin: 0;
}
.tt-suggestion:nth-child(odd) {
    background-color:#eeeeee;
}
</style>

<?php
	
	$dni = isset($cliente_base[0]->dni)? $cliente_base[0]->dni: '';
	$ruc = isset($cliente_base[0]->ruc)? $cliente_base[0]->ruc: '';
	$razon_social = isset($cliente_base[0]->razon_social)? $cliente_base[0]->razon_social: '';
	$direccion = isset($cliente_base[0]->direccion)? $cliente_base[0]->direccion: '';

?>

<div class="form-group" style="margin-bottom: 0px;">
    <label for="dni_cliente" class="col-xs-3 col-sm-4 control-label" style="text-align: left;">Dni </label>
    <div class="col-xs-9 col-sm-8">
    	<div class="input-group ">
			<input type="text" class="form-control" id="dni_cliente" name="dni_cliente" placeholder="Dni" value="<?php echo $dni; ?>">
			<span class="input-group-btn">
              <button type="button" class="btn btn-info btn-flat" onclick="buscar_cliente()"><i class="fa fa-plus"></i></button>
            </span>
        </div>

    </div>
 </div>

 <div class="form-group" style="margin-bottom: 0px;">
    <label for="ruc_cliente" class="col-xs-3 col-sm-4 control-label" style="text-align: left;">Ruc </label>
    <div class="col-xs-9 col-sm-8">
     	<input type="text" class="form-control" id="ruc_cliente" name="ruc_cliente" placeholder="Ruc" value="<?php echo $ruc; ?>">
    </div>
 </div>

<div class="form-group" style="margin-bottom: 0px;">
    <label for="cliente" class="col-xs-10 col-sm-2 control-label">Cliente </label>
    <div class="col-xs-12 col-sm-10">      
        <input type="text" class="form-control tt-query" id="cliente" name="cliente" value="<?php echo $razon_social; ?>">            
    </div>
</div>

<div class="form-group" >
    <label for="dirección_cliente" class="col-xs-8 col-sm-2 control-label">Direccion </label>
    <div class="col-xs-12 col-sm-12">
      <input type="text" class="form-control input-sm" id="dirección_cliente" name="direccion_cliente" placeholder="Dirección" value="<?php echo $direccion; ?>" >
    </div>
</div>



<script type="text/javascript">
  
  $(document).ready(function () {   

  	var states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
	  'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii',
	  'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
	  'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
	  'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire',
	  'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota',
	  'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
	  'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont y su casa y tambien la otra ves Vermont y su casa y tambien la otra ves Vermont y su casa y tambien la otra ves Vermont y su casa y tambien la otra ves',
	  'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
	];

  	

  	var substringMatcher = function(strs) {
	  return function findMatches(q, cb) {
	    var matches, substringRegex;

	    // an array that will be populated with substring matches
	    matches = [];

	    // regex used to determine if a string contains the substring `q`
	    substrRegex = new RegExp(q, 'i');

	    // iterate through the pool of strings and for any string that
	    // contains the substring `q`, add it to the `matches` array
	    $.each(strs, function(i, str) {
	      if (substrRegex.test(str)) {
	        matches.push(str);
	        console.log(str);
	      }
	    });

	    cb(matches);
	  };
	};



	var fuente = function() {
	  return function fuentes(query, process) {
            $.ajax({
                url:  "http://localhost/infarsel/pedidos/cliente_buscar/1",
                type: 'GET',
                data: 'query=' + query,
                dataType: 'JSON',
                success: function (data) {
                	var objects, substringRegex;

                    objects = [];
                    map = {};

                    substrRegex = new RegExp(query, 'i');

                    $.each(data, function (i, object) {
                        map[object.texto] = object;
                        if (substrRegex.test(object.texto)) {
                        	objects.push(object.texto);
                        	console.log(object.texto);
                    	}
                    });
                    process(objects);
                }
            });
        };
	};

	var fuenteb = function(strs) {
	  return function fuentebb(q, cb) {
	  	$.ajax({
                url:  "http://localhost/infarsel/pedidos/medicamento_buscar",
                type: 'GET',
                data: 'query=' + q,
                dataType: 'JSON',
                async: false,
                success: function (datass) {
                	var matches, substringRegex;
                	matches = [];
                	substrRegex = new RegExp(q, 'i');

                    //map = {};

                    $.each(datass, function (i, str) {
                        //map[str.texto] = str;

                        str = str.texto;
                        if (substrRegex.test(str)) {
				        matches.push(str);
				        console.log(str);
				      }
                    });
                    cb(matches);
                }
            });

	   

	  };
	};

	var bestPictures = new Bloodhound({
	  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('texto'),
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  prefetch: 'http://localhost/infarsel/pedidos/medicamento_buscar',
	  minLength: 5,
	  remote: {
	    url: 'http://localhost/infarsel/pedidos/medicamento_buscar?get=%QUERY',
	    wildcard: '%QUERY',
	    cache: false
	  }
	});
    
    
    // Initializing the typeahead with remote dataset
    $('#cliente').typeahead({
		hint: true,
		highlight: true,
		minLength: 5,
		delay: 300,
	},{
        items: 10,

        //source: fuente(),
       	//source : substringMatcher(states),
        //source: fuenteb(states),

        source: bestPictures,
        display: function(item) {        // display: 'name' will also work
        return item.texto;
	    },

	    limit: 5,
	    templates: {
	        suggestion: function(item) {
	        	console.log(item.pv);
	            return '<div>'+ item.texto +'</div>';
	        }
	    },
	    onselect: function (obj) {
	      alert('Selected '+obj.pv)
	    }



    }).on('typeahead:opened', onOpened)
    .on('typeahead:selected', onAutocompleted)
    .on('typeahead:autocompleted', onSelected);
function onOpened($e) {
console.log('opened');
}


function onAutocompleted($e, datum) {
console.log('autocompleted');
console.log(datum.pv);
}


function onSelected($e, datum) {
console.log('selected');
console.log(datum.pv);
};

  });

</script>

