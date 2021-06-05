<style type="text/css">

	.typeahead{
        font-size: 16px;
        width: 100%;
    }
    .dropdown-menu>li>a {
        white-space: normal !important;
    }    
    .typeahead>li:nth-child(odd) {
        background-color:#fbfbfb;
    }
    .typeahead, .tt-query, .tt-hint {
		width: 100%;	
	}
</style>

<?php
	
	$onSelected = isset($onSelected)? $onSelected: '';

?>

<div class="input-group input-lg">

    <div class="col-md-6">
        <div class="form-group">
            <label for="idserie" class="col-sm-2 control-label">Comp.</label>

            <div class="col-sm-10">
              <select class="form-control" id="idserie" name="idserie" onchange="get_correlativo();"> 
                  <?php foreach($series as $tc) {
                    echo "<option value='{$tc->idserie}' > {$tc->tipo_comprobante} </option>";
                  }
                ?>
              </select>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="idserie" class="col-sm-2 control-label"></label>

              <input type="text" class="form-control" id="correlativo" name="correlativo" placeholder="Correlativo" readonly="readonly" value="<?php echo $series[0]->correlativo; ?>">
            </div>
        </div>
    </div>

 
</div>


<script type="text/javascript">


$(document).ready(function () {   

   


});


</script>

