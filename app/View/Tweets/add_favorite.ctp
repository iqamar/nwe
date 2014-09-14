<?php if ($favorite == 1) {?>
<li> <a href="javascript:favoriteTweet('<?php echo $content_id;?>','0');" class="favorite" style="color:#C70000;">Favorited</a></li>
<?php }
else { ?>
<li> <a href="javascript:favoriteTweet('<?php echo $content_id;?>','1');" class="favorite">Favourite</a></li>
<?php }
?>