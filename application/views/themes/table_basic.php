


<h3> <?php echo $title?> </h3>

<div class="table-responsive" style="max-height: 400px;">
    <table class="table table-striped"> 

        <thead>
            <tr>

            <?php foreach ($data[0] as $key => $value): ?>
                <th> <?= $key ?> </th>
            <?php endforeach ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $key => $value): ?>
               <tr> 
                    <?php foreach ($value as $sub_key => $sub_value): ?>
                        <td> <?= $sub_value ?> </td>
                    <?php endforeach ?>      
               </tr> 
            <?php endforeach ?>           

            
        </tbody>

       
            
    </table>
</div>

    <?php if($campo_suma && count($data) ) : 
        $total_campo_suma = array_sum(array_column($data, $campo_suma));
    ?>

    <h3> Suma del Campo <?php echo  $campo_suma; ?> = <?php echo  number_format($total_campo_suma, 2, '.', ','); ?></h3>

<?php endif; ?>


