<?php $this->Paginator->options(array('update'=>'#ser','evalScripts'=>true)); ?>
<div class="searchpanel">
<?php echo $this->Form->create('Search',array('id'=>'Search','name'=>'Search')); ?>
<?php 
	$countries = $this->requestAction('/search/countries/'); 
	$functionalArea = $this->requestAction('/search/functionalArea/');
	$industry = $this->requestAction('/search/industry/');
	//pr($functionalArea);
	?>
	<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="2"><h1>Filter Your Job Search </h1></td>
		</tr>
 		<tr>
			<td colspan="3">
				<ul>
					<li><strong>Posting Time:</strong></li>
					<li><input type="radio" name="freshness" value="" id="alltime" align="left" checked><label for="alltime">All Time</label></li>
					<li><input type="radio" name="freshness" value="1" id="last24" align="left"><label for="last24">Last 24 Hours</label></li>
					<li><input type="radio" name="freshness" value="2" id="last7" align="left"><label for="last7">Last 7 Days</label></li>
					<li><input type="radio" name="freshness" value="4" id="last30" align="left"><label for="last30">Last 30 Days</label></li>
					<li><input type="radio" name="freshness" value="5" id="last60" align="left"><label for="last60">Last 60 Days</label></li>
					<li><input type="radio" name="freshness" value="6" id="last90" align="left"><label for="last90">Last 90 Days</label></li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>
				<input name="keyword" type="text" id="keyword" class="textfield"  placeholder="What you are looking?" size="52" />
			</td>
			<td colspan="2">
				<?php echo $this->Form->input('functionalArea',array('type'=>'select','options'=>array(''=>'All Functional Areas',$functionalArea),'id'=>'functionalArea','style'=>'float:left;width:165px;margin-right:8px;','class'=>'droplist','label'=>false)); ?>
				<?php echo $this->Form->input('industry',array('type'=>'select','options'=>array(''=>'All Industry',$industry),'id'=>'industry','style'=>'float:left;width:165px;','class'=>'droplist','label'=>false)); ?>
			</td>

		</tr>
		<tr>
			<td>
				<?php echo $this->Form->input('location',array('type'=>'select','options'=>array(''=>'All Locations',$countries),'id'=>'location','class'=>'droplist','label'=>false)); ?>
			</td>
			<td>
				<?php echo $this->Form->input('experience',array('type'=>'select','options'=>array(''=>'Select Experience','1'=>'0-1','2'=>'1-5','3'=>'5-10','4'=>'More than 10'),'id'=>'experience','style'=>'width:250px;','class'=>'droplist','label'=>false)); ?>
			</td>
			
			<td><?php echo $this->Form->submit('Search',array('type'=>'submit','class'=>'inner-searchbttn','id'=>'submit_btn')); ?></td>
		</tr>
	</table>
	<?php echo $this->Form->end(); ?>
</div>
<script>
	$(function() {
	
	$("#keyword").keypress(function(e) {

         if(e.which == 13) {
             e.preventDefault();
             $("#submit_btn").click();
          }
    });
	
      $('#submit_btn').click(function(event){
	  
		 
		var keyword = document.getElementById("keyword").value;
		var functionalArea = document.getElementById("functionalArea").value;
		var industry = document.getElementById("industry").value;
		var country = document.getElementById("location").value;
		var experience = document.getElementById("experience").value;
		var freshness = $('input[name=freshness]:checked').val();
		var page = 1;
 
		
			
		$("#ser").html("<div id='content' style='min-height:400px;'><img src='http://media.networkwe.com/img/loading.gif' style='margin:200px 0px 0px 200px;' alt='Searching' /></div>");
        $.ajax({
              url     : '/search/jobSearch',
              type    : 'POST',

			cache: false,
              data    : {keyword: keyword,functionalArea: functionalArea,industry:industry,country:country,experience: experience,freshness:freshness,page:page},
              success : function(data){
				
				 $("#ser").html(data);
				 
              },
			 error : function(data) {
			   $("#ser").html("there is error");
			}
          });
    
     return false;  
     });
	 
	 });

</script>
<?php echo $this->Js->writeBuffer();?>
