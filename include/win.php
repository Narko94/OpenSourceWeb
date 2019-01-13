<?php
/**
 * Принимаем из функции: tWin
 * @id
 * @width: default = 0 => 445px
 * 
 * close.png => 445 - 5 = 440px
 **/
    $w1 = $width;
    $w2 = "style='width:{$w1}px;'";
?>
<div class="win_body" id="<?php print $id; ?>" style="display: none;">
<div class="win_dv" <?php print $w2; ?>>
<div class="win_head"><span class="win_main" id="<?php print $id; ?>_win_main">Название</span><span class="close fas fa-times" onclick="view('<?php print $id; ?>');"></span></div>
<div class="win_content" id="<?php print $id; ?>_1">

</div>
</div>
</div>