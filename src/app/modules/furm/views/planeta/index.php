<?php
/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-01-26, 18:23:27
 * 
 * 2014-01-26:
 * -Utworzenie pliku
 */
echo '<h1>Planeta</h1>Najnowsze informacje RSS<br><br>';
?>

<input class="btn btn-furm" type="button" rel=1 onclick="if ($(this).attr('rel') == 1) {
            $(this).attr('rel', 2);
            $('#accordion .panel-collapse').collapse('show');
            $(this).val('Ukryj treść wszystkich');
        } else {
            $(this).attr('rel', 1);
            $(this).val('Pokaż treść wszystkich');
            $('#accordion .panel-collapse').collapse('hide');
        }" value="Pokaż treść wszystkich" />
<br><br>
<div class="panel-group" id="accordion">
    <?php
    foreach ($this->items as $k => $v) {
        /* @var $v \furm\planeta\rss\rssPub */
        ?>


        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a style="float:right" href="<?php echo $v->link; ?>">Przejdź &raquo;</a>
                    <a data-toggle="collapse" data-parent="#accordion" href="#planeta-index-<?php echo $k; ?>" href="<?php echo $v->link; ?>">
                        <?php echo $v->title; ?>
                    </a>
                    <div style="font-size: 10px"><?php echo $v->date; ?></div>
                </h4>
            </div>
            <div id="planeta-index-<?php echo $k; ?>" class="panel-collapse collapse">
                <div class="panel-body">
                    <?php echo $v->desc; ?>
                </div>
            </div>
        </div>




        <!--div style="border: solid 1px #FECA40;background: none repeat scroll 0 0 #FFEEBB; padding: 4px; border-radius: 5px">
            <a style="float:right" href="<?php echo $v->link; ?>">Przejdź &raquo;</a>
            <a style="font-weight: bold; font-size: 14px" href="<?php echo $v->link; ?>" onclick="$('#desc-item-<?php echo $k; ?>').toggle();return false;"><?php echo $v->title; ?></a><br>
            <div style="font-size: 10px"><?php echo $v->date; ?></div>
            <div class="desc" style="display:none;" id="desc-item-<?php echo $k; ?>">
                <br>
        <?php echo $v->desc; ?>
            </div>

        </div><br-->
        <?php
    }
    ?>
</div>