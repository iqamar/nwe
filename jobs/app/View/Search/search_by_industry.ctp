<style>
	#myList li{float:left;width:48%;margin:5px;display:none;border-bottom:1px dashed #CCCCCC;}
	#loadMore1 {
		background: none repeat scroll 0 0 #CCCCCC;
		cursor: pointer;
		padding: 5px;
		text-align: center;
	}
	#loadMore1:hover {
		color:#C70000;
	}
</style>
<div class="clear">&nbsp;</div>
<div class="box">
	<div class="boxheading">
		<h1>Jobs by Industry</h1>
		<div class="boxheading-arrow"></div>
	</div>
	<ul class="news-list" id="myList">
	<?php 
		$i=0;
		foreach($data as $row){
			
			echo "<li>".$this->Html->link($row['IND']['title'],array('controller'=>'search','action'=>'jobsByIndustry/'.$row['IND']['id'].'-'.$row['IND']['title']),array('escape'=>false,'style'=>'max-width:280px;height:30px;overflow:hidden;display:block;float:left;'))."<span class='num'>(".$row[0]['COUNT(J.id)']."&nbsp;Jobs)</span></li>";
			
		}
	?>
	</ul>
	<div class="clear">&nbsp;</div>
	<div id="loadMore1">Load more</div>
	<div class="clear"></div>
</div>
<script type="text/javascript">
 $(document).ready(function(){
	
	$('#myList li:lt(30)').show();
    
    var items =  <?php echo count($data); ?>;
    var shown =  30;
    $('#loadMore1').click(function () {
        
        shown = $('#myList li:visible').size()+20;
        if(shown< items) {$('#myList li:lt('+shown+')').show();}
        else {$('#myList li:lt('+items+')').show();
             $('#loadMore1').hide();
             }
    });
    
   
});
</script>