<?php $this->Paginator->options(array('update'=>'#ser','evalScripts'=>true)); ?>
<!-- Sidebar -->
<div id="sidebar">
	
	
	<?php echo $this->Form->create('Search',array('id'=>'Search','name'=>'Search')); ?>
	<?php 
	$countries = $this->requestAction('/search/countries/'); 
	$functionalArea = $this->requestAction('/search/functionalArea/');
	//pr($functionalArea);
	?>
	
	<section class="is-search">		
			<input type="text" class="text" name="keyword" placeholder="Search" id="keyword" />
	</section>
	<!-- Recent Posts -->
	<section class="is-recent-posts">
		<header>
			<h2>Refine Search</h2>
		</header>
			
			<?php echo $this->Form->input('functionalArea',array('type'=>'select','options'=>array(''=>'All Functional Area',$functionalArea),'id'=>'functionalArea','label'=>false)); ?>&nbsp;
			<?php echo $this->Form->input('location',array('type'=>'select','options'=>array(''=>'All Location',$countries),'id'=>'location','label'=>false)); ?>&nbsp;
			<?php echo $this->Form->input('experience',array('type'=>'select','options'=>array(''=>'All Experience','1'=>'0-1','2'=>'1-5','3'=>'5-10','4'=>'More than 10'),'id'=>'experience','label'=>false)); ?>&nbsp;
			<!--h2>All Jobs Type</h2>
			<input type="radio" name="jobType" value="All Jobs Type" id="alltype"><label for="alltype">All Type</label><br/>
			<input type="radio" name="jobType" value="All Jobs Type" id="fulltime"><label for="fulltime">Full Time</label><br/>
			<input type="radio" name="jobType" value="All Jobs Type" id="parttime"><label for="parttime">Part Time</label><br/>
			<input type="radio" name="jobType" value="All Jobs Type" id="contract"><label for="contract">Contract</label><br/>
			<input type="radio" name="jobType" value="All Jobs Type" id="internship"><label for="internship">Internship</label><br/>
			<input type="radio" name="jobType" value="All Jobs Type" id="temprorary"><label for="temprorary">Temprorary</label><br/-->&nbsp;
			
			
			
			<h2>Freshness</h2>
			<input type="radio" name="freshness" value="" id="alltime" align="left" checked><label for="alltime">All Time</label><br/>
			<input type="radio" name="freshness" value="1" id="last24" align="left"><label for="last24">Last 24 Hours</label><br/>
			<input type="radio" name="freshness" value="2" id="last7" align="left"><label for="last7">Last 7 Days</label><br/>
			<input type="radio" name="freshness" value="3" id="last15" align="left"><label for="last15">Last 15 Days</label><br/>
			<input type="radio" name="freshness" value="4" id="last30" align="left"><label for="last30">Last 30 Days</label><br/>
			<input type="radio" name="freshness" value="5" id="last60" align="left"><label for="last60">Last 60 Days</label><br/>
			<input type="radio" name="freshness" value="6" id="last90" align="left"><label for="last90">Last 90 Days</label><br/>
			&nbsp;
			
		
		
	<?php echo $this->Form->submit('Search',array('type'=>'button','class'=>'button next','id'=>'submit_btn','style'=>'border:0px;')); ?>	
	
	</section>
	
	
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
		var country = document.getElementById("location").value;
		var experience = document.getElementById("experience").value;
		var freshness = $('input[name=freshness]:checked').val();
		var page = 1;
 
		
			
		 $("#ser").html("<div id='content' style='min-height:800px;'><img src='../../477.GIF' style='margin:200px 0px 0px 200px;' alt='Searching' /><p style='margin-left:320px;color:#C20A1D;'>Searching....</p></div>");
        $.ajax({
              url     : baseUrl+'/search/jobSearch',
              type    : 'POST',

			cache: false,
              data    : {keyword: keyword,functionalArea: functionalArea,country:country,experience: experience,freshness:freshness,page:page},
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