<div id="content" style="padding:0px;">
	<div id="content-inner">	
<?php if(!empty($similarJobs)){ ?>

		<!-- Post -->
		<article class="is-post is-post-excerpt">
			<div style="clear:both;"></div>
			<div style="width:100%;float:left;min-height:200px;">
				<div class="is-calendar-no">
					<div class="innerL-no">												
						<h2 class="pageTitle">People also applied to</h2>
							
						<ul class="news-list">
							<?php 
							$i=0;
							foreach($similarJobs as $row){
								$postdate = date("F j, Y, g:i a", strtotime($row['Job']['modified']));
								$class='joblist';
								if($i++ % 2 ==0){
									$class ='altjoblist';
								}
								echo "<li class='".$class."'>".$this->Html->image('company_logos/'.$row['Company']['logo'],array('class'=>'compLogo'))."<div class='leftrow'>".$this->Html->link($row['Job']['title'],array('action'=>'jobDetails/'.$row['Job']['id']),array('escape'=>false))."</a><p>".$row['Company']['title']."</p><p>".$row['Job']['city']."&nbsp;,&nbsp;".$row['Country']['name']."&nbsp;&nbsp;-&nbsp;&nbsp;".$postdate."</p></div>".$this->Html->link($this->Html->Image('forward.png'),array('controller'=>'search','action'=>'jobDetails/'.$row['Job']['id']),array('escape'=>false,'class'=>'userJobs'))."<div style='clear:both'></div></li>";
								}
							?>
						</ul>
						<div style="clear:both;"></div>
						<?php echo $this->Html->link('View all jobs like this  >>',array('controller'=>'search','action'=>'index'),array('class'=>'readMore')); ?>
					</div>
				</div>
			</div>
			<div style="clear:both;"></div>
		</article>
		<hr/>
<?php } ?>
		<!-- Post -->
		<article class="is-post is-post-excerpt">
			
			<header style="margin:0px;padding:0px;">
				<?php echo $this->Html->Image('company_logos/'.$data['Company']['logo'],array('class'=>'applyprofileimg','style'=>'border:1px solid #ddd;')); ?>
				<div style="width:70%;float:left;margin:5px 0px 0px 15px">
					<h2><?php echo $this->Html->link($data['Job']['title'],'#',array('escape'=>false)); ?></h2>
					<span class="byline"><?php echo $this->Html->link($data['Company']['title'],$data['Company']['weburl'],array('escape'=>false)); ?>&nbsp;-&nbsp;<?php echo $data['Job']['city'].",&nbsp;".$data['Country']['name']; ?></span>
					<?php 
						$pdate=date('d-m-Y H:i:s',strtotime($data['Job']['start_date'])); 
					?>
					<p>Posted <?php echo $this->Time->timeAgoInWords($pdate); ?></p>
				</div>
			</header>
			<div style="clear:both;"></div>
			<hr/>
			
			<div class="info" style="right:-120px;">
				<span class="date"><span class="month">Sept<span>ember</span></span> <span class="day">09</span><span class="year">, 2013</span></span>
				<ul class="stats">
					<li><a href="#" class="link-icon24 link-icon24-1">16</a></li>
					<li><a href="#" class="link-icon24 link-icon24-2">32</a></li>
					<li><a href="#" class="link-icon24 link-icon24-3">64</a></li>
					<li><a href="#" class="link-icon24 link-icon24-4">128</a></li>
				</ul>										
				<span class="date" style="border:0px solid #DDDDDD;padding: 1em 0 0;margin: 0.75em 0 0 0;border-top:1px solid #DDDDDD;"><span class="month">Nov<span>ember</span></span> <span class="day">09</span><span class="year">, 2013</span></span>
			</div>
			
			<div class="flash flash_success">Applied on <?php echo date('d-m-Y',strtotime($data['Job']['expiry_date'])); ?></div>
							
			<div style="width:60%;float:left;">
				<div class="is-calendar">
					<div class="inner">
						
						<table>
						<strong>Job Summary</strong>
						<tbody>											
							<tr>
								<td >Posted on</td>
								<td><?php echo date('d-m-Y',strtotime($data['Job']['start_date'])); ?></td>																
							</tr>
							<tr>
								<td >Expiry Date</td>
								<td><?php echo date('d-m-Y',strtotime($data['Job']['expiry_date'])); ?></td>																											
							</tr>
							<tr>
								<td >Functional Area</td>
								<td>Retail Banking</td>																	
							</tr>
							<tr>
								<td >Job Role</td>
								<td><?php echo $data['Job']['title']; ?></td>																
							</tr>
							<tr>
								<td >Location</td>
								<td><?php echo $data['Job']['city'].",&nbsp;".$data['Country']['name']; ?></td>																											
							</tr>
							<tr>
								<td >Nationality</td>
								<td>N/A</td>																	
							</tr>
						</tbody>	
						</table>
					</div>
				</div>
			</div>
			<div style="width:35%;float:right;">
				<div class="is-calendar">
					<div class="inner">												
						<table>
						<strong>Job Specification</strong>
						<tbody>											
							<tr>
								<td >Job Code</td>
								<td><?php echo $data['Job']['job_code']; ?></td>																
							</tr>
							<tr>
								<td >Job Type</td>
								<td>Permanent</td>																											
							</tr>
							<tr>
								<td >Experience</td>
								<td>9 to 10 Years</td>																	
							</tr>
							<tr>
								<td >Qualification</td>
								<td>Any Graduates</td>																
							</tr>
							<tr>
								<td >Offered Salary</td>
								<td>Unspecified</td>																											
							</tr>
							
						</tbody>	
						</table>
					</div>
				</div>
			</div>
			<div style="clear:both;"></div>
			<hr/>
			<div class="inner">
				<h3>Job Description</h3><br/>										
				<?php echo $data['Job']['description']; ?>
				<div class="clear">&nbsp;</div>
			</div>	
				
				
		</article>
	</div>
</div>