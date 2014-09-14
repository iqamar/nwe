<?php 
$this->Html->addCrumb(' Dashboard', '/recruiter');
$this->Html->addCrumb(' Users', array('controller' => 'recruiter', 'action' => 'users'));
echo $this->element('Recruiter/breadcrumb'); ?>

<script type="text/javascript">
(function(b,c){var $=b.jQuery||b.Cowboy||(b.Cowboy={}),a;$.throttle=a=function(e,f,j,i){var h,d=0;if(typeof f!=="boolean"){i=j;j=f;f=c}function g(){var o=this,m=+new Date()-d,n=arguments;function l(){d=+new Date();j.apply(o,n)}function k(){h=c}if(i&&!h){l()}h&&clearTimeout(h);if(i===c&&m>e){l()}else{if(f!==true){h=setTimeout(i?k:l,i===c?e-m:e)}}}if($.guid){g.guid=j.guid=j.guid||$.guid++}return g};$.debounce=function(d,e,f){return f===c?a(d,e,false):a(d,f,e!==false)}})(this);

var NETWORKWE_URL = '<?php echo NETWORKWE_URL?>';
var media = '<?php echo MEDIA_URL?>';
$(document).ready(function(){
    var NETWORKWE_URL = '<?php echo NETWORKWE_URL?>';

    $('body').on('click',function(event) {
        if($(event.target).parents('#assign_users_ajax_response').length === 0 ) {
            $('#assign_users_ajax_response').hide();
        }
    });
    
    $("#assign_users_input").keyup( $.debounce( 900, function(e){
        auto_suggest(e);
        return false;
    }));
    
    $.noty.defaults = {
        layout: 'center',
        dismissQueue: false
    };

        /*function post(){
        $("#test").empty();
        var postData = {name: $("#assign_search").val()};
      
        $.post("<?php echo NETWORKWE_URL?>/recruiter/user_search_ajax", postData, function(callback){
            //$("#test2").html(callback);
            var json = jQuery.parseJSON(callback);
            
           
           $.each(json, function(key, value){
                var US = value.US;
                var UP = value.UP;          
                   $("#test").append(UP.firstname + "<img src='<?php echo NETWORKWE_URL?>/files/users/" + UP.photo +"' height='30' width='30'> <a href=<?php echo NETWORKWE_URL?>/recruiter/assignUser/"+US.id+">Assign</a><br>");
           });
           
           
           
           });
    }
    
    
    //setup before functions
var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms, 5 second for example

        //on keyup, start the countdown
$('#assign_search').keyup(function(){
            typingTimer = setTimeout(post, doneTypingInterval);
        });

        //on keydown, clear the countdown 
$('#assign_search').keydown(function(){

            clearTimeout(typingTimer);
        });*/
    
});
function auto_suggest(e){
    var key = e.keyCode;
    if (e.which === 13) {
        e.preventDefault();
        hide_auto_suggest();
        return false;
    } else if (e.which === 40) {
        return false;
    } else if (e.which === 38) {
        return false;
    }
    
    var searchbox = $("#assign_users_input").val();
    if(searchbox.length < 1){
        hide_auto_suggest();
    }
    var dataString = 'name:' + searchbox;
    if (searchbox !== '' && searchbox.length >= 3){

        $.ajaxSetup({
            beforeSend: function() {
                $("#assign_users_input").css("background", "#fff url(" + media + "/img/loading.gif) no-repeat center right");
            }
        });            
        $.ajax({
            type: "GET",
            url: NETWORKWE_URL + "/recruiter/user_search_ajax/" + dataString,
            cache: false,
            timeout: 3500,
            success: function(html){
                if(searchbox.length >= 1){
                    $("#assign_users_ajax_response").html(html).show();
                    /*var json = jQuery.parseJSON(callback);
                    $.each(json, function(key, value){
                         var US = value.US;
                         var UP = value.UP;          
                            $("#assign_users_ajax_response").append(UP.firstname + "<img src='<?php echo NETWORKWE_URL?>/files/users/" + UP.photo +"' height='30' width='30'> <a href=<?php echo NETWORKWE_URL?>/recruiter/assignUser/"+US.id+">Assign</a><br>");
                    });*/
                }
                $("#assign_users_input").css("background", "#fff");
            },
            error: function(x, t, m) {
                if(t==="timeout") {
                    $("#assign_users_input").css("background", "#fff");
                }
            }
        });
    }
}
    
function hide_auto_suggest(){
    if($('#assign_users_ajax_response').is(':visible'))
        $('#assign_users_ajax_response').hide();
}

function assign_user(id){
    if(id){
        var dataString = 'id:' + id;
        $.ajaxSetup({
            beforeSend: function() {
                $('#user-' + id + ' a').html('Please wait...');
            }
        }); 
        $.ajax({
            type: "GET",
            url: NETWORKWE_URL + "/recruiter/assign_user/" + dataString,
            cache: false,
            timeout: 3500,
            success: function(resp){
                if(jQuery.parseJSON(resp) === true ){
                    $('#user-'+id).hide();
                    $('#user-'+id).prev('li').hide();
                    noty({layout: 'center',text: 'Assigned user ',type: 'success'});
                }
                else {
                    $('#user-' + id + ' a').html('Assign');
                    noty({layout: 'center',text: 'User already assigned!',type: 'warning'});
                }
            },
            error: function(x, t, m) {
                if(t==="timeout") {
                    $('#user-' + id + ' a').html('Assign');
                    noty({layout: 'center',text: 'Request timed out!',type: 'error'});
                }
            }
        });
    }
    else
        noty({layout: 'center',text: 'User ID missing!',type: 'error'});
}
</script>
<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Users</h2>
            <span class="span2">
                <button data-target="#assign_users_modal" data-toggle="modal" class="btn btn-primary btn-lg">Assign Users</button>
            </span>
	    <div class="box-icon">
                <!--a title="Add" href="/recruiter/users_add" class="btn btn-small btn-primary" style="width:60px;">Add users</a-->
                <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
	    </div>
	</div>
	
	<div class="box-content" style="padding-top:10px;">
            	
	   <table class="table table-striped table-bordered bootstrap-datatable datatable">
<!--               <input name="assign_search" id="assign_search"/>
               <div id="test"></div>
               <div id="test2"></div>-->
			<thead>
				<tr>
					<th>Name</th>
					<th>Employer</th>
					<th>Email</th>
					<th>Location</th>
					<th>Modified</th>			
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php				
	
			foreach ($users as $data):	
//print_r($users);
			?>
				<tr>
					<td><?php echo $this->Html->link($data[0]['fullname'],'/recruiter/view_user/'.$data['Users_profile']['user_id'],array('escape'=>false)); ?></td>
					<td><?php echo $data['Company']['title']; ?></td>
					<td><?php echo $data['User']['email']; ?></td>
					<td><?php echo $data['Company']['city']."<br/>".$data['CON']['name']; ?></td>
					<td><?php echo date('M d Y h:i',strtotime($data['Recruiter_user']['modified'])); ?></td>
					<td class="center">
						<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-trash icon-white')) . " ", '/recruiter/unassign_users/'.$data['Recruiter_user']['id'], array('class' => 'btn btn-danger', 'escape' => false), "Are you sure you wish to delete this member?"); ?>
					</td>
					
				</tr>
			<?php endforeach; ?>

			</tbody>
	    </table>
	</div>
    </div><!--/span-->

</div><!--/row-->

<div class="modal fade" id="assign_users_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title" id="myModalLabel">Assign Users</h3>
      </div>
      <div class="modal-body">
          <label>Search Users: <input type="text" id="assign_users_input" placeholder="Type to search"></label>
          <div id="assign_users_ajax_response"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>