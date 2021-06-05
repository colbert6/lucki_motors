<?php 
    //echo '<pre>';
    //print_r($data);
?>


<div class="col-md-6 col-sm-6">
    <h3><?= $info[0]->text ?></h3>
    <input type="hidden" id="idproducto_save" value="<?= $info[0]->id ?>">
</div>

<div class="col-md-6 col-sm-6">
    <div class="form-group">
        <label for="precio_venta" class="control-label">Nuevo precio venta</label>
        <div class="input-group input-group-sm">
        <input type="number" class="form-control" name="precio_venta" id="precio_venta">
            <span class="input-group-btn">
                <button type="button" class="btn btn-info btn-flat" onclick="save_precio()">
                    <i class="fa fa-plus"></i>
                </button>
            </span>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12">

<table class="table table-bordered">
    <thead>
      <tr>
        <th class="text-center">Cantidad</th>
        <th class="text-center">Presentacion</th>
        <th class="text-center">P. Compra</th>
        <th class="text-center">P. Venta</th>
        <th class="text-center">F. Modificacion</th>
        <th class="text-center">Estado</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $d): ?>
        <tr>
            <td class="text-center"><?= $d->cantidad ?></td>
            <td class="text-center"><?= $d->presentacion ?></td>
            <td class="text-center"><?= $d->precio_compra ?></td>
            <td class="text-center"><?= $d->precio_venta ?></td>
            <td class="text-center"><?= $d->fecha_modificacion ?></td>
            <td class="text-center">
                <?php 
                    if($d->estado == "Activo"){
                        echo "<button type='button' class='btn btn-success btn-xs' >{$d->estado}</button>";
                    } else{
                        echo "<button type='button' class='btn btn-danger btn-xs' >{$d->estado}</button>";
                    }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>
