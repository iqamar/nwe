<script src="/js/jquery-1.9.1.js"></script>
<script>

$(document).ready(function(){
  $(".delete").click(function(){
    if (!confirm("Are you sure you want to delete all this category and all it's articles?")){
      return false;
    }
  });
});
</script>
<a href="/admin/help/addCategory"><img alt="Add" src="/alaxos/img/toolbar/add.png"></a><br><br>
<?php

foreach ($categories as $category) {
    
    $articles = ClassRegistry::init('help_sections')->find('all', array('conditions' => array('category_id' => $category['help_categories']['id'])));
    
    ?>
<span style="font: bold; font-size: 18px;"><?=$category['help_categories']['category_name']?>
    <a class="delete" href="/admin/help/deleteCategory/<?=$category['help_categories']['id']?>">Delete</a>
    <a href="/admin/help/editCategory/<?=$category['help_categories']['id']?>">Edit</a>
</span><br><br>
<?php
    foreach ($articles as $article) {
        ?>
<span><a href="/admin/help/view/<?=$article['help_sections']['id']?>"><?=$article['help_sections']['article']?></a>
    <a class="icon-edit" href="/admin/help/edit/<?=$article['help_sections']['id']?>"></a>
    <a class="icon-remove" id="remove" href="/admin/help/delete/<?=$article['help_sections']['id']?>"></a>
</span><br>
<?php

    }
    
    echo "<br><br>";
    
}

?>