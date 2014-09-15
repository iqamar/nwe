<style>
	
	#myList li{float:left;width:48%;margin:5px;display:none;}
</style>
<div id="content" style="padding:0px;">
	<div id="content-inner">	
		<!-- Post -->
		<article class="is-post is-post-excerpt">
			<div style="clear:both;"></div>
			<div style="width:100%;float:left;min-height:800px;">
				<div class="is-calendar-no">
					<div class="innerL-no">												
						<h2 class="pageTitle">Functional Area</h2>
						<hr/>
						<ul class="news-list" id="myList">
							
							<?php 
								
								//pr($data);exit;
								$i=0;
								foreach($data as $row){
									
									echo "<li>".$this->Html->link($row['FA']['title'].'&nbsp; Jobs',array('controller'=>'search','action'=>'searchByFunction/'.$row['FA']['id']),array('class'=>'current','escape'=>false))."<span>(".$row[0]['COUNT(JFA.job_id)'].")</span></li>";
									
									/*$jobexp = $row['Job']['min_experience'].'&nbsp;-&nbsp;'.$row['Job']['max_experience'];
									$postdate = date("F j, Y", strtotime($row['Job']['modified']));
									$class='joblist';
									if($i++ % 2 ==0){
										$class ='altjoblist';
									}
									echo "<li class='".$class."'>".$this->Html->image('company_logos/'.$row['Company']['logo'],array('class'=>'compLogo'))."<div class='leftrow'>".$this->Html->link($row['Job']['title'],array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id']),array('escape'=>false))."</a><table id='jobsDesc'><tr><th>".$this->Html->Image('company-icon.png',array('width'=>16))."&nbsp;&nbsp;".$row['Company']['title']."</th><td>".$this->Html->Image('experience-icon.png',array('width'=>16))."&nbsp;Experience: ".$jobexp."</td></tr><tr><th>".$this->Html->Image('location-icon.png',array('width'=>16)).$row['Job']['city']."&nbsp;,&nbsp;".$row['Country']['name']."&nbsp;&nbsp;</th><td>&nbsp;&nbsp;".$this->Html->Image('date-icon.png',array('width'=>16))."&nbsp;&nbsp;".$postdate."</td></tr></table></div>".$this->Html->link($this->Html->Image('forward.png'),array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id']),array('escape'=>false,'class'=>'userJobs'))."<div style='clear:both'></div></li>";
									*/
								}
							?>
						</ul>
						<div class="clear">&nbsp;</div>
						<div id="loadMore">Load more</div>
						<hr/>
												
					</div>
				</div>
			</div>
			<div style="clear:both;">&nbsp;</div>
		</article>
	</div>
</div>
<script type="text/javascript">
 $(document).ready(function(){
	
	$('#myList li:lt(30)').show();
    
    var items =  <?php echo count($data); ?>;
    var shown =  30;
    $('#loadMore').click(function () {
        
        shown = $('#myList li:visible').size()+20;
        if(shown< items) {$('#myList li:lt('+shown+')').show();}
        else {$('#myList li:lt('+items+')').show();
             $('#loadMore').hide();
             }
    });
    
   
});


</script>