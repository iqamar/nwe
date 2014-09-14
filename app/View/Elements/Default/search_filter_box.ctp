<div class="box">
	<div class="rgt-container">
		<div class="searchBox">
			<?php echo $this->Form->create('searchFilter',array('id'=>'myform','name'=>'myform')); ?>
			<table>
				<tr>
					<td><input type="text" class="no-bder no-bg sbox" name="keyword" placeholder=" Search by member name" id="keyword" value="<?php echo $keyword; ?>" /></td>
					<td>
						<div class="selectloc">
							<?php echo $this->Form->input('location',array('type'=>'select','options'=>array(''=>'In All Locations',$countryList),'default' => $country,'id'=>'location','class'=>'no-bder no-bg sbox','label'=>false,'div' => false,)); ?>
						</div>
					</td>
					<td><input type="submit" value="Search" id="submit_btn" class="red-bttn"></td>
				</tr>
			</table>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
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
		var country = document.getElementById("location").value;
		var page = 1;
 
		var dataString = 'query:' + keyword + '/scope:' + country;
			
		$("#ser").html("<img src='http://media.networkwe.com/img/loading.gif' style='margin:200px 0px 0px 450px;' alt='Networkwe' />");
        $.ajax({
              url     : '/home/searchFilter/'+dataString,
              type    : 'GET',

			cache: false,
              //data    : {keyword: keyword,country:country,page:page},
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
