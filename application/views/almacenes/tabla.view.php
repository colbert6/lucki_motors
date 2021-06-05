
<div class="table-responsive" style="max-height: 400px;">
    <table id="productos_sm" class="table table-striped">
        <thead>
        <tr>
          <th>Cod. Barras</th>
          <th>Producto</th>
          <th class="text-center"># Stock</th>
          <th class="text-center">Venta (S/.)</th>
        </tr>
        </thead>
        <tbody>
            <?php $c = count($data); ?>
            <?php if($c > 0){ ?>
            <?php foreach ($data as $p): ?>
            <tr>
                <td><?= $p->codbarras ?></td>
                <td><?= $p->categoria." ".$p->marca." ".$p->producto ?></td>
                <td class="text-center"><?= $p->stock ?></td>
                <td class="text-center"><?= $p->precio ?></td>
            </tr>
            <?php endforeach; ?>
            <?php }else{ ?>
            <tr>
                <td class="text-center" colspan="4">No hay Productos</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>