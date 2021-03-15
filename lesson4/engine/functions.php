<?php
function renderGalery($way, $src, $wrapperClass = 'galery', $itemClass = 'galery_item', $imgClass = 'pic_mini', $alt = 'photo')
{
    $imgs = scandir($way);
    echo "<ul class='$wrapperClass'>";
    foreach ($imgs as $imgName) {
        if ($imgName != '.' && $imgName != '..') {
            echo "<li class='$itemClass'><img class='$imgClass' src='$src{$imgName}' alt='$alt'></li>";
        }
    }
    echo '</ul>';
}
