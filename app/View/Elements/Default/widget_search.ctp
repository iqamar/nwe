<div class="designbox">
    <div class="boxheading">
        <h1>Search for Members </h1>
        <div class="boxheading-arrow"></div>
    </div>
    <div class="designbox-content">
        <?php echo $this->Form->create(null, array('url' => '/home/searchFilter/', 'name' => 'myform', 'id' => 'myform')); ?>
        <table width="100%" border="0" cellspacing="2" cellpadding="1">
            <tr>
                <td>Write here Member's Name </td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('keyword', array('name' => 'keyword', 'id' => 'keyword', 'label' => false, 'class' => 'textfield width1')); ?></td>
            </tr>
            <tr>
                <td>Select Member's Location </td>
            </tr>
            <tr><?php echo $this->Form->input('hidden',array('name'=>'hidden','id'=>'hidden','type'=>'hidden','value'=>'hidden')); ?>
                <td><?php echo $this->Form->input('location', array('type'=>'select','options' => array('' => 'All Location', $countryList), 'name' => 'location', 'id' => 'location', 'label' => false, 'class' => 'droplist width1droplist')); ?></td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('Find Now', array('type' => 'submit','name'=>'Submit', 'label' => false, 'class' => 'search-bttn')); ?></td>
            </tr>
        </table>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<?php echo $this->Js->writeBuffer();?>
<script>
$(document).ready(function()
{
    $('#myform').on('submit', function(e)
    {
        e.preventDefault();
       
		 
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
		  
		  
		
    });
});

</script>