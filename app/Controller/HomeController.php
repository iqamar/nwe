<?php
class HomeController extends AppController {


  var $helpers = array('Form', 'html');
    var $components = array('Auth');
	
	
	var $uses = array('User','Comment','Connection','Statusupdate','Users_following');
    function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
		switch ($this->request->params['action']) {
			case 'index':
			case 'admin_index':	
		}
    }
	public function extractProcess($return=""){
		$this->autoRender = false;
		if(isset($_POST["url"]))
		{
			$get_url = $_POST["url"]; 
			App::import('Vendor', 'simple_html_dom', array('file'=> 'simple_html_dom.php'));
						
			$get_content = file_get_html($get_url); 
			if($get_content->find('meta[property=og:title]')){
				foreach($get_content->find('meta[property=og:title]') as $element) 
				{
					$page_title = $element->content;
				}
			}else{
				foreach($get_content->find('title') as $element) 
				{
					$page_title = $element->plaintext;
				}
				
			}
			if($get_content->find('meta[property=og:description]')){
				foreach($get_content->find('meta[property=og:description]') as $element) 
				{
					
					$page_body = $element->content;
				}
			}elseif($get_content->find('META[name="description"]')){
				foreach($get_content->find('META[name="description"]') as $element) 
				{
					$page_body = $element->content;
					
				}
			}else{
				foreach($get_content->find('body') as $element) 
				{				
					$page_body = trim($element->plaintext);
					$pos=strpos($page_body, '', 400); //Find the numeric position to substract
					$page_body = substr($page_body,0,$pos ); //shorten text to 200 chars
				}
			}
			$image_urls = array();
			if($get_content->find('meta[property=og:image]')){
				
				foreach($get_content->find('meta[property=og:image]') as $element){
					
					if(!preg_match('/blank.(.*)/i', $element->content) && filter_var($element->content, FILTER_VALIDATE_URL))
					{
						$image_urls[] =  $element->content;
					}
					$image_urls[] =  $element->content;
				}
			}
			$output = array('title'=>$page_title, 'images'=>$image_urls, 'content'=> $page_body);
		 	if($return==1){
                                return $output;
                        }else{
                                echo json_encode($output);
                        }
			exit;
	//echo json_encode($output); 
		}
		
	}
	
    public function sharer() {
                $zero = 0;
                $uid = @$this->userInfo['users']['id'];
                if ($uid){
                                                
                        $user_data = $this->getCurrentUser();
                        $this->set('user_data', $user_data);


                        if ($this->request->is('post')) {

				$txt = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '',$this->request->data['Statusupdate']['user_text']);
				$share_image = $this->request->data['Statusupdate']['share_image'];
				$share_url = $this->request->data['Statusupdate']['share_url'];
				$share_title = $this->request->data['Statusupdate']['share_title'];
				$share_content = $this->request->data['Statusupdate']['share_content'];
				$share_source = $this->request->data['Statusupdate']['share_source'];
                                //$uid = $this->request->data['Statusupdate']['user_id'];
                                $this->request->data['Statusupdate']['share_with'] = $this->request->data['Statusupdate']['share_with'];

				$this->request->data['Statusupdate']['user_text'] =  $txt.'<div class="clear"></div><div class="extracted_url">';
                                if(!empty($share_image)){
                                        $this->request->data['Statusupdate']['user_text'] .='<div class="extracted_thumb" id="extracted_thumb"><img src="'.$share_image.'" width="100" height="100"></div>';
                                }
                                 $this->request->data['Statusupdate']['user_text'] .= '<div class="extracted_content"><h4><a href="'.$share_url.'" target="_blank">'.$share_title.'</a></h4><p>'.$share_content.'</p></div></div>';
                                if(!empty($share_source)){
                                        $this->request->data['Statusupdate']['user_text'] .= '<div style="float:right;background:#EDEDED;padding:4px;color:#333;">Shared From: <b>'.$share_source.'</b></div>';
                                }



                                $this->request->data['Statusupdate']['user_id'] = $this->request->data['Statusupdate']['user_id'];
                                $this->request->data['Statusupdate']['content_type'] = "updates";
				$this->request->data['Statusupdate']['update_type'] = 1;
				unset($this->request->data['Statusupdate']['share_image']);
				unset($this->request->data['Statusupdate']['share_url']);
				unset($this->request->data['Statusupdate']['share_title']);
				unset($this->request->data['Statusupdate']['share_content']);
				unset($this->request->data['Statusupdate']['share_source']);

/* echo "<pre>";
print_r($this->request->data);
exit;*/


                                if ($this->Statusupdate->save($this->request->data)) {
                                        $this->Session->setFlash('Successfully shared');
					$this->redirect(array('controller'=> 'home', 'action'=> 'index'));
                               }
                                else {
                                        $this->Session->setFlash('Your post was not shared. Please try again');
                                }


                        }else{

				if(!(empty($_GET['u']))){
					$_POST['url'] = $_GET['u'];
				
					$crowlJSON=$this->extractProcess(1);
					$this->autoRender = true;
					$this->set('share_url', $_GET['u']);
					$this->set('share_source', $_GET['source']);
					$this->set('crowlJSON',$crowlJSON);
				}else{
				 $this->redirect(array('controller'=> 'home', 'action'=> 'index'));
				}
			}
		}
}	
    public function index() {
		$this->loadModel('Job');
		$zero = 0;
		$uid= $this->userInfo['users']['id'];
		if ($uid) {
			
			
			$user_data = $this->getCurrentUser();
			$this->set('user_data', $user_data);
			
					
			if ($this->request->is('post')) {
				//$uid = $this->request->data['Statusupdate']['user_id'];
				$this->request->data['Statusupdate']['share_with'] = $this->request->data['Statusupdate']['sharewith'];
				$this->request->data['Statusupdate']['user_text'] = $this->request->data['Statusupdate']['user_text'];
				$this->request->data['Statusupdate']['user_id'] = $this->request->data['Statusupdate']['user_id'];
				$this->request->data['Statusupdate']['content_type'] = "updates";
				
				/*file uploading*/
				$filename = $this->request->data['Statusupdate']['photo'];
				$imagename = $filename['name'];
							
				$uploadFolder = "files/update/original/";
				$uploadPath = MEDIA_PATH . $uploadFolder;
				$imageName = time().$filename['name'];
				$full_image_path = $uploadPath . '/'. $imageName;
		
				if (move_uploaded_file($filename['tmp_name'], $full_image_path)) {
					  //$data['photo'] = $this->request->data['Statusupdate']['photo'];
					 $this->request->data['Statusupdate']['photo'] = $imageName;
				} 
				else{
					$this->request->data['Statusupdate']['photo'] = '';
					//$this->Session->setFlash('There was a problem uploading file. Please try again.');
				}
				
				if ($this->Statusupdate->save($this->request->data)) {
					$lastid = $this->Statusupdate->getInsertID();
					$this->request->data['likes']['content_type'] = 'updates';
					$this->request->data['likes']['created'] = date("Y-m-d H:i:s");
					$this->request->data['likes']['like'] = 1;
					$this->request->data['likes']['user_id'] = $uid;
					$this->request->data['likes']['content_id'] = $lastid;
					if (ClassRegistry::init('likes')->save($this->request->data)) {
						$this->request->data = '';
						$this->request->data['master_activities']['activity_type'] = 'updates';
						$this->request->data['master_activities']['created'] = date("Y-m-d H:i:s");
						$this->request->data['master_activities']['activity_id'] = $lastid;
						if (ClassRegistry::init('master_activities')->save($this->request->data)) {
						$this->Session->setFlash('Record successfully added');
						$this->redirect(array('controller'=> 'home', 'action'=> 'index'));
					}
				}
					$this->Session->setFlash('Record successfully added');
				
				}
				else {
					$this->Session->setFlash('File not saved');
				}

			
			}
		
	

		/***********************************    User followers updates        **********/
			
		$user_Following_Updates = ClassRegistry::init('users_followings')->find('all',array('fields'=>array('users_followings.following_id'),'conditions'=>array('users_followings.user_id='.$uid.' AND users_followings.status=2')));
		if ($user_Following_Updates) {
			foreach ($user_Following_Updates as $user_Following_Row) {
				 $result[] .= $user_Following_Row['users_followings']['following_id']; 
			}
		}
		/*  To remove dublicate entry from array*/
		$result = array_unique($result);
		
		
	

	/*user congrates messages for getting new job*/
	
			$JobMonth=Date('m');
		if ($result) {
			$result =@implode(',',$result);
			$uers_get_new_job_messgae = ClassRegistry::init('users_experiences')->find('all', array('fields'=>array(
																											 'users_experiences.id,
																											 users_experiences.start_date,
																											 users_profiles.firstname,
																											 users_profiles.lastname ,
																											 users_profiles.photo,
																											 users_profiles.tags,
																											 users_profiles.user_id'
																											 ),
																									'limit'=>4,
																									'joins'=> array(
																													 array(
																														   'alias'=> 'users_profiles',
																														   'table'=> 'users_profiles',
																														   'foreignKey'=> false,
																														   'conditions'=> array(
																																'users_experiences.user_id = users_profiles.user_id'
																															)
																														   )),																					
																									'conditions'=> array(array(
																															'users_experiences.user_id IN('.$result.')'),
																														  	'MONTH(users_experiences.start_date)='.$JobMonth
																															)
																									));


	$this->set('uers_get_new_job_messgae', $uers_get_new_job_messgae);
		}
		
	/*already send message for new job*/
			$uers_already_send = ClassRegistry::init('users_messages')->find('all',array('fields'=> array('users_messages.id,users_messages.user_id,users_messages.friend_id'),
																									'conditions'=> array('users_messages.user_id='.$uid)));

			$this->set('uers_already_send', $uers_already_send);
	/*user congrates messages on new jobs listing*/
	$whoSendYouCongrats = ClassRegistry::init('users_messages')->find('all', array('fields'=>array(
																								    'users_messages.id,
																									users_messages.subject_id,
																									users_messages.user_message,
																									users_messages.created,
																									users_profiles.firstname,
																									users_profiles.lastname ,
																									users_profiles.photo,
																									users_profiles.tags'
																									),
																				   'order'=>'users_messages.id DESC',
																					'joins'=> array(
																									 array(
																										   'alias'=> 'users_profiles',
																										   'table'=> 'users_profiles',
																										   'foreignKey'=> false,
																										'conditions'=> array('users_messages.user_id = users_profiles.user_id'
																														  )
																											))));
			$this->set('whoSendYouCongrats',$whoSendYouCongrats);
		
		
		if ($uid) {
		        $postsSubmittedByUsers = ClassRegistry::init('news')->find('all', array('fields'=> array('
                                                                                                                                                                                                          news.heading,
                                                                                                                                                                                                          news.details,
                                                                                                                                                                                                          news.image_url,
                                                                                                                                                                                                          news.publish,
                                                                                                                                                                                                          news.created,
                                                                                                                                                                                                          news.id
                                                                                                                                                                                                          '),
                                                                                                                                                                        'limit'=>5,
                                                                                                                                                                        'order'=>'news.id DESC',
                                                                                                                                                                        'conditions'=>array('news.publish=1')
                                                                                                                                                                        )
                                                                                                                                           );

                } //session check  end


$cnt=0;
        foreach ($postsSubmittedByUsers as $newsData){
                $modifiedNews[$cnt]["news"] = $newsData["news"];
                $modifiedNews[$cnt]["users_profiles"] = Array("firstname" => "NetworkWE","lastname" => "","photo" => "network_we_462014.png","handler" =>"");
                $cnt++;
         }
//print_r($modifiedNews);
//exit;
//              $this->set('postsSubmittedByUsers',$postsSubmittedByUsers);
 $this->set('postsSubmittedByUsers',$modifiedNews);

	
		//print_r($postsSubmittedByUsers);
		//exit;
		
		/*Home page friend connection notification*/
		
		if ($uid) {
		
		$currentUser_Connections = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),'conditions'=>array('(connections.user_id='.$uid.' OR connections.friend_id='.$uid.') AND connections.request=1'),'order'=>'connections.created DESC'));
		
		foreach ($currentUser_Connections as $CurrnettUser) {
			if ($CurrnettUser['connections']['friend_id'] != $uid){
				 $user_Connection_Array[] .= $CurrnettUser['connections']['friend_id'];
			 }
			 if ($CurrnettUser['connections']['user_id'] != $uid){
				 $user_Connection_Array[] .= $CurrnettUser['connections']['user_id'];
			 }
		  }
		
		
		
		$friend_of_friend_Arrays = @implode(',',$user_Connection_Array);
		if ($friend_of_friend_Arrays !='') {
		$profile_user_for_newconnectionsss = ClassRegistry::init('users_profiles')->find('all', array('fields'=>array('users_profiles.firstname,
																													  users_profiles.lastname,
																													  users_profiles.photo ,
																													  users_profiles.user_id'
																													  ),
																							'conditions'=>array(
																												'users_profiles.user_id IN ('.$friend_of_friend_Arrays.')'
																												)
																												));
		}
		
		$this->set('profile_user_for_newconnectionsss',$profile_user_for_newconnectionsss);

		$new_connections = ClassRegistry::init('connections')->find('all', array('fields'=>array('connections.user_id,
																								 connections.friend_id,
																								 connections.created'
																								 ),
																							'conditions'=>array(
																											'connections.request'=>1,
																											'connections.created >'=>date('Y-m-d',strtotime("-2 weeks"))
																												),
																							'order'=>'connections.created DESC','limit'=>12
																												));

			foreach ($new_connections as $newUserOf_friend) {
				$user_con_id = $newUserOf_friend['connections']['user_id'];
				$friend_con_id = $newUserOf_friend['connections']['friend_id'];
				$con_date = $newUserOf_friend['connections']['created'];
				if (in_array($user_con_id,$user_Connection_Array)) {	
					if ($user_con_id != $uid && $friend_con_id != $uid) {
				$recentlyJoinArray[] = ClassRegistry::init('users_profiles')->find('all', array('fields'=>array('users_profiles.firstname,
																												users_profiles.id,
																												users_profiles.lastname,
																												users_profiles.photo,
																												users_profiles.tags,
																												connections.created,
																												users_profiles.user_id'
																												),
																				'joins'=> array(array(
																									'alias'=> 'connections',
																									'table'=> 'connections',
																									'type'=> 'left',
																									'foreignKey'=> false,
												'conditions'=> array('(connections.user_id = users_profiles.user_id) OR (connections.friend_id = users_profiles.user_id)'))), 
																							'conditions'=>array(
																												'users_profiles.user_id'=>$user_con_id,
																												'connections.created ="'.$con_date.'"'
																												)
																												));
				
				$recentlyFriendsJoin[] = ClassRegistry::init('users_profiles')->find('all', array('fields'=>array('users_profiles.firstname,
																												   users_profiles.id,
																												   users_profiles.lastname,
																												   users_profiles.photo,
																												   users_profiles.tags,
																												   users_profiles.user_id,
																												   connections.created'),
																			    'joins'=> array(array(
																								'alias'=> 'connections',
																								'table'=> 'connections',
																								'type'=> 'left',
																								'foreignKey'=> false,
												'conditions'=> array('(connections.user_id = users_profiles.user_id) OR (connections.friend_id = users_profiles.user_id)'))),
																							'conditions'=>array(
																												'users_profiles.user_id'=>$friend_con_id,
																												'connections.created ="'.$con_date.'"'
																												)
																												));
					}
				}
				else if (in_array($friend_con_id,$user_Connection_Array)) {
						if ($user_con_id != $uid && $friend_con_id != $uid) {
					$recentlyJoinArray[] = ClassRegistry::init('users_profiles')->find('all', array('fields'=>array('users_profiles.firstname,
																													users_profiles.id,
																													users_profiles.lastname,
																													users_profiles.photo,
																													users_profiles.tags,
																													users_profiles.user_id,
																													connections.created'
																													),
																				'joins'=> array(array(
																								'alias'=> 'connections',
																								'table'=> 'connections',
																								'type'=> 'left',
																								'foreignKey'=> false,
												'conditions'=> array('(connections.user_id = users_profiles.user_id) OR (connections.friend_id = users_profiles.user_id)'))),
																							'conditions'=>array(
																												'users_profiles.user_id'=>$friend_con_id,
																												'connections.created ="'.$con_date.'"'
																												)
																												));
				
				$recentlyFriendsJoin[] = ClassRegistry::init('users_profiles')->find('all', array('fields'=>array('users_profiles.firstname,
																												  users_profiles.id,
																												  users_profiles.lastname,
																												  users_profiles.photo,
																												  users_profiles.tags,
																												  users_profiles.user_id,
																												  connections.created'
																												  ),
																				'joins'=> array(array(
																								'alias'=> 'connections',
																								'table'=> 'connections',
																								'type'=> 'left',
																								'foreignKey'=> false,
												'conditions'=> array('(connections.user_id = users_profiles.user_id) OR (connections.friend_id = users_profiles.user_id)'))),
																							'conditions'=>array(
																												'users_profiles.user_id'=>$user_con_id,
																												'connections.created = "'.$con_date.'"'
																												)
																												));
						}
					
				}
				
				
			} 
			$this->set('recentlyJoinArray',$recentlyJoinArray);
			$this->set('recentlyFriendsJoin',$recentlyFriendsJoin);
		}
		
	}else{
		$this->loadModel('Job');
		$this->loadModel('Country');
		$countryList = $this->Country->find('list');
		$this->set('countryList',$countryList);
		$jobResults = $this->Job->find("all", array(
		"fields" => array(
						  "Job.title,
						  Job.id,
						  Job.city,
						  Job.created,
						  Job.modified,
						  countries.name,
						  companies.logo,
						  companies.id"
						  ),
        "joins" => array(
            array(
                "table" => "countries",
                "alias" => "countries",
				"type" => "LEFT",
                "conditions" => array(
                    "Job.country_id = countries.id"
                )
            ),
            array(
                "table" => "companies",
                "alias" => "companies",
				"type" => "LEFT",
                "conditions" => array(
                    "Job.company_id = companies.id"
                )
            )),
			'conditions' => array('Job.status'=>2),
			'order'=>'created DESC',
			'limit'=>10
		));
		$this->set('relatedjobs',$jobResults);
		$user_tweets = ClassRegistry::init('tweets')->find('all', array('fields' => array('
																								  tweets.tweet,
																								  tweets.id,
																								  tweets.photo,
																								  tweets.created,
																								  users_profiles.firstname,
																								  users_profiles.lastname,
																								  users_profiles.photo,
																								  users_profiles.user_id,
																								  users_profiles.handler
																								  '),
																				'order'=>'tweets.created DESC',
																				'limit' =>6,
																				'joins'=>array(	
																							   array('alias' => 'users_profiles',
																									 'table' => 'users_profiles',
																									 'type' => 'left', 'foreignKey' => false, 
																									 'conditions' => array('tweets.user_id = users_profiles.user_id'
																														   )
																									 )
																							   ),																																																															
																				'conditions'=>array('tweets.parent_id =0 AND tweets.status=2'),
																				'group'=>'tweets.id'
																				)
																   );
		
		$this->set('latestTweets',$user_tweets);
		$retweeted_tweets_by_user = ClassRegistry::init('tweets')->find('all',array('fields'=>array('
																								tweets.parent_id,
																								tweets.id,tweets.user_id,
																								users_profiles.firstname,
																								users_profiles.lastname,
																								users_profiles.handler,
																								users_profiles.user_id'
																								),
																				'joins'=>array(
																							   array('alias' => 'users_profiles',
																									 'table' => 'users_profiles',
																									 'type' => 'left',
																									 'foreignKey' => false,
																									 'conditions' => array('tweets.user_id = users_profiles.user_id'
																														   )
																									 )
																							   ),
																				'conditions'=>array('tweets.parent_id !=0 AND tweets.status=2'
																									)
																				)
																	);
		$this->set('relatestTweets',$reuser_tweets);															
		$postsSubmittedByUsers = ClassRegistry::init('news')->find('all', array('fields'=> array('news.heading,news.details,news.image_url,news.publish,news.created,news.id'),'limit'=>5,'order'=>'news.id DESC','conditions'=>array('news.publish=1')));
		$cnt=0;
        foreach ($postsSubmittedByUsers as $newsData){
                $modifiedNews[$cnt]["news"] = $newsData["news"];
                $modifiedNews[$cnt]["users_profiles"] = Array("firstname" => "NetworkWE","lastname" => "","photo" => "network_we_462014.png","handler" =>"");
                $cnt++;
         }
		$this->set('postsSubmittedByUsers',$modifiedNews);
		$get_latest_posts_networkwe = $this->get_latest_posts();
		$this->set('get_latest_posts_networkwe',$get_latest_posts_networkwe);
		
		$this->render("default");
		
		}
		
    }
	
    
	/*user own updates*/
   public function myupdates() {
		
	   if (@$this->userInfo['users']['id']) {
			$this->params['pass'];
			$paramenter = $this->params['pass'];
			$uid = $paramenter[0];
			
			if ($uid) {
				$this->loadModel('Statusupdate');
				
				$my_updates_row = $this->Statusupdate->get_updates($uid);
				$this->set('my_updates_row',$my_updates_row);
				
				$update_likes = $this->Statusupdate->get_updates_likes();
				$this->set('update_likes',$update_likes);
				
				$get_count_comments = $this->Statusupdate->get_count_comment();
				$this->set('get_count_comments',$get_count_comments);
				
				$get_comments = $this->Statusupdate->get_user_comments();
				$this->set('get_comments',$get_comments);
			}
	   }
   }
   
   
	public function delete_update() {
		
		if ($this->request->is('get')) {
			
			$update_id = $_GET['update_id'];
			
			$this->loadModel('Statusupdate');
			
			$update_newt =  $this->Statusupdate->find('first',array('fields' => array('Statusupdate.share,Statusupdate.content_type'),
																					  'conditions' => array('Statusupdate.id='.$update_id)));
			if ($update_newt) {
				
					$content_type = $update_newt['Statusupdate']['content_type'];
					
					if ($content_type == 'blog') {
						
						$share = $update_newt['Statusupdate']['share'];
						
						$db = ConnectionManager::getDataSource('default');
						
						$db->rawQuery("UPDATE blogs SET parent = (parent - 1)  WHERE id=".$share);
						
					}
					
					else if ($content_type == 'news') {
						
						$share = $update_newt['Statusupdate']['share'];
						
						$db = ConnectionManager::getDataSource('default');
						
						$db->rawQuery("UPDATE news SET share = (share - 1)  WHERE id=".$share);
						
					}
			}
			
			$db = ConnectionManager::getDataSource('default');
			
			$db->rawQuery("DELETE FROM statusupdates WHERE id=".$update_id);
			
			$db->rawQuery("DELETE FROM likes WHERE content_id=".$update_id.' AND content_type= "updates"');
			
			$db->rawQuery("DELETE FROM comments WHERE content_id=".$update_id.' AND comment_type= "updates"');
			
			$db->rawQuery("DELETE FROM master_activities WHERE activity_id=".$update_id.' AND activity_type= "updates"');
			
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('delete_update');
		}
		
	}
	
	/*VIEW SINGLE UPDATE ON HOME PAGE*/
	public function view() {
		if (@$this->userInfo['users']['id']) {
			$uid = $this->userInfo['users']['id'];
			$this->params['pass'];
			$paramenter = $this->params['pass'];
			 $post_id = $paramenter[0];
			 $m_activity_id = $paramenter[1];
			$ustatus = ClassRegistry::init('statusupdates')->find('first', array('fields'=> array('
																										 statusupdates.user_text,
																										 statusupdates.content_type,
																										 statusupdates.photo,
																										 statusupdates.user_id,
																										 statusupdates.share,
																										 statusupdates.created,
																										 statusupdates.id,
																										 statusupdates.share_with,
																										 users_profiles.firstname,
																										 users_profiles.lastname,
																										 users_profiles.user_id,
																										 users_profiles.photo,
																										 likes.like,
																										 likes.content_id,
																										 likes.id,likes.user_id,
																										 count(likes.like) as total,
																										 statusupdates.created
																										 '),
																					   'order'=>'statusupdates.id DESC',
																					   'joins'=>array(
																									  array('alias'=> 'likes',
																											'table'=> 'likes',
																											'type'=> 'left',
																											'foreignKey'=> false,
																											'conditions'=> array('statusupdates.id  = likes.content_id AND likes.like=1')),	
																									  array('alias'=> 'users_profiles',
																											'table'=> 'users_profiles',
																											'type'=> 'left',
																											'foreignKey'=> false,
																										    'conditions'=> array('statusupdates.user_id = users_profiles.user_id'
																															  )
																											)
																									  ),
																					   'conditions'=>array('statusupdates.id ='.$post_id	
																										 )));	
			$this->set('ustatus', $ustatus);
			
			/*who likes on update*/
		$likesOnUpdates = ClassRegistry::init('likes')->find('all', array('fields'=>array('
																							users_profiles.firstname,
																							users_profiles.lastname,
																							users_profiles.photo,
																							users_profiles.tags,
																							users_profiles.user_id,
																							likes.content_id,
																							likes.user_id
																							'),
																				   'order'=>'likes.id DESC',
																					'joins'=> array(
																									 array(
																										   'alias'=> 'users_profiles',
																										   'table'=> 'users_profiles',
																										   'foreignKey'=> false,
																										'conditions'=> array('likes.user_id = users_profiles.user_id'
																														  ))),
																					'conditions'=>array('likes.content_type="updates" AND likes.like=1 AND likes.content_id='.$post_id)
																											));
			$this->set('likesOnUpdates',$likesOnUpdates);
			
			$likes_on_Update = ClassRegistry::init('likes')->find('all', array('fields'=>array('likes.user_id,likes.like,likes.content_id'),'order'=>'likes.id',
																					 'conditions'=>array(
																										 'likes.content_type="updates" AND likes.user_id='.$uid.' AND likes.content_id='.$post_id)));
			
		$this->set('likes_on_Update',$likes_on_Update);
		
		$user_comments = ClassRegistry::init('comments')->find('all', array('fields'=> array('
																							  comments.comment_text,
																							  comments.created,
																							  comments.content_id,
																							  comments.user_id,
																							  comments.id,
																							  users_profiles.lastname,
																							  users_profiles.firstname,
																							  users_profiles.photo,
																							  users_profiles.user_id,
																							  users_profiles.handler
																							  '),
																					'order'=>'comments.id DESC',
																					'joins'=> array(
																									 array('alias'=> 'users_profiles',
																										   'table'=> 'users_profiles',
																										   'type'=> 'left',
																										   'foreignKey'=> false,
																										   'conditions'=> array('comments.user_id = users_profiles.user_id'
																																 )
																										   )
																									 ),
																					'conditions'=> array('comments.comment_type ="updates" AND comments.content_id='.$post_id)
																																
																					)
																	   );
	
		

		$this->set('user_comments', $user_comments);
		
		/*to get user who share update*/
		$share_on_Update = ClassRegistry::init('statusupdates')->find('all', array('fields'=>array('statusupdates.share'),
																								   'conditions'=>array(
																													   'statusupdates.content_type="updates" AND statusupdates.share !=0 AND statusupdates.share='.$post_id)));
		$this->set('share_on_Update',$share_on_Update);
		
		/*who share an update*/
		$shareOnUpdates = ClassRegistry::init('statusupdates')->find('all', array('fields'=>array('
																							users_profiles.firstname,
																							users_profiles.lastname,
																							users_profiles.photo,
																							users_profiles.tags,
																							users_profiles.user_id,
																							statusupdates.share
																							'),
																				   'order'=>'statusupdates.id DESC',
																					'joins'=> array(
																									 array(
																										   'alias'=> 'users_profiles',
																										   'table'=> 'users_profiles',
																										   'foreignKey'=> false,
																										'conditions'=> array('statusupdates.user_id = users_profiles.user_id'
																														  ))),
																					'conditions'=>array('statusupdates.content_type="updates" AND statusupdates.share !=0  AND statusupdates.share='.$post_id)
																											));
			$this->set('shareOnUpdates',$shareOnUpdates);
			
			/**  View the update and check is it viewed or not?**/
		
			$uid = $this->userInfo['users']['id'];
			if ($post_id != 0 && $m_activity_id) {
				$userAlreadyViewed = ClassRegistry::init('users_viewings')->find('first',array('fields'=>array('users_viewings.id'),
																								'conditions'=>array('users_viewings.id='.$m_activity_id.' AND users_viewings.user_id='.$uid.' AND users_viewings.viewings_type="updates"')));
				
				if (sizeof($userAlreadyViewed) == 0) {
					//echo sizeof($userAlreadyViewed);
					$this->request->data['users_viewings']['viewings_id'] = $m_activity_id;
					$this->request->data['users_viewings']['user_id'] = $uid;
					$this->request->data['users_viewings']['viewings_type'] = "updates";
					$this->request->data['users_viewings']['viewings_counts'] = 1;
					$view_date = date('Y-m-d H:i:s');
					$this->request->data['users_viewings']['start_date'] = $view_date;
					$this->request->data['users_viewings']['end_date'] = $view_date;
					if (ClassRegistry::init('users_viewings')->save($this->request->data)) { 
					}
				}
				
				//ClassRegistry::init('master_activities')->updateAll(array('viewed' =>$view), array('master_activities.id' => $id));
			}
		}
			
		
	}
	public function bl_get_home_ajax() {
		$this->params['pass'];
		$paramenter = $this->params['pass'];
		$lastid = $paramenter[0];
		if ($lastid) {
			
		
		 if($lastid =='tops'){
					$updates_by_ajax = ClassRegistry::init('statusupdates')->find('all', array('fields'=> array('
																										 statusupdates.user_text,
																										 statusupdates.content_type,
																										 statusupdates.photo,
																										 statusupdates.user_id,
																										 statusupdates.share,
																										 statusupdates.created,
																										 statusupdates.id,
																										 statusupdates.share_with,
																										 statusupdates.update_type,
																										 likes.like,
																										 likes.content_id,
																										 likes.id,likes.user_id,
																										 count(likes.like) as total,
																										 statusupdates.created
																										 '),
																					   'order'=>'statusupdates.id DESC',
																					   'limit'=>5,
																					   'joins'=>array(
																									  array('alias'=> 'likes',
																											'table'=> 'likes',
																											'type'=> 'left',
																											'foreignKey'=> false,
																											'conditions'=> array('statusupdates.id  = likes.content_id AND likes.like=1'))






																									  ),
																					   'conditions'=>array(
																										 array('statusupdates.content_type IN ("updates","news","blog","jobs")')																										
																										 ),
																					   'group'=> 'statusupdates.id'));	
			}else{
																										 																			 
			$updates_by_ajax = ClassRegistry::init('statusupdates')->find('all', array('fields'=> array('
																										 statusupdates.user_text,
																										 statusupdates.content_type,
																										 statusupdates.photo,
																										 statusupdates.user_id,
																										 statusupdates.share,
																										 statusupdates.created,
																										 statusupdates.update_type,
																										 statusupdates.id,
																										 statusupdates.share_with,
																										 likes.like,
																										 likes.content_id,
																										 likes.id,likes.user_id,
																										 count(likes.like) as total,
																										 statusupdates.created
																										 '),
																					   'order'=>'statusupdates.id DESC',
																					   'limit'=>10,
																					   'joins'=>array(
																									  array('alias'=> 'likes',
																											'table'=> 'likes',
																											'type'=> 'left',
																											'foreignKey'=> false,
																											'conditions'=> array('statusupdates.id  = likes.content_id AND likes.like=1'))





																									  ),
																					   'conditions'=>array(
																										 array('statusupdates.content_type IN ("updates","news","blog","jobs")'),
																										'statusupdates.id <'.$lastid	
																										 ),
																					   'group'=> 'statusupdates.id'));																																													
 
		
	}

$cnt = 0;
foreach ($updates_by_ajax as $updates){
        //$final_updates[$cnt]
        $userIDs[$cnt] = $updates["statusupdates"]["user_id"];
        $cnt++;
}
$strUserIDs =  implode(",", $userIDs);
$usersDetails = ClassRegistry::init('users_profiles')->find('all', array('fields'=> array('users_profiles.user_id,
                                                                                                 users_profiles.firstname,
                                                                                                 users_profiles.lastname,
                                                                                                 users_profiles.user_id,
                                                                                                 users_profiles.photo'), 'conditions'=>array(
                                array('users_profiles.user_id IN ('.$strUserIDs.')'))));
foreach ($updates_by_ajax as $key => $updates){
        foreach ($usersDetails as $UD){
                if($updates["statusupdates"]["user_id"] == $UD["users_profiles"]["user_id"]){
                        $updates_by_ajax[$key]["users_profiles"]=$UD["users_profiles"];
                        break;
                }
        }
}	
	 $this->set('updates_by_ajax', $updates_by_ajax);
		
	$updates_comments_count= ClassRegistry::init('comments')->find('all', array('fields'=> array(
																								  'comments.content_id,
																								  count(comments.content_id) as commenttotal
																								  '),
																				'conditions'=>array('comments.comment_type="updates"'),
																				'order'=>'comments.id DESC',
																				'group'=>'comments.content_id'
																				)
																   );
		
	$this->set('updates_comments_count',$updates_comments_count);
	

		/*to get user who share update*/
		$share_on_Update = ClassRegistry::init('statusupdates')->find('all', array('fields'=>array('
																								   statusupdates.id,
																								   statusupdates.share,
																								   users_profiles.firstname,
																								   users_profiles.lastname,
																								   users_profiles.user_id
																								   '),
																				   'joins'=> array(
																									 array('alias'=> 'users_profiles',
																										   'table'=> 'users_profiles',
																										   'type'=> 'left',
																										   'foreignKey'=> false,
																										   'conditions'=> array('statusupdates.user_id = users_profiles.user_id'
																																 )
																										   )
																									 ),
																								   'conditions'=>array(
																													   'statusupdates.content_type="updates" AND statusupdates.share !=0')));
		$this->set('share_on_Update',$share_on_Update);


		
				
				$user_comments = ClassRegistry::init('comments')->find('all', array('fields'=> array('
																									  comments.comment_text,
																									  comments.created,
																									  comments.content_id,
																									  comments.user_id,
																									  comments.id,
																									  users_profiles.lastname,
																									  users_profiles.firstname,
																									  users_profiles.photo,
																									  users_profiles.user_id,
																									  users_profiles.handler
																									  '),
																					'order'=>'comments.id DESC',
																					'joins'=> array(
																									 array('alias'=> 'users_profiles',
																										   'table'=> 'users_profiles',
																										   'type'=> 'left',
																										   'foreignKey'=> false,
																										   'conditions'=> array('comments.user_id = users_profiles.user_id'
																																 )
																										   )
																									 ),
																					'conditions'=> array('comments.comment_type ="updates"')
																																
																					)
																	   );
	
		

		$this->set('user_comments', $user_comments);
		
			
	
			
		/*who likes on update*/
		$likesOnUpdates = ClassRegistry::init('likes')->find('all', array('fields'=>array('
																							users_profiles.firstname,
																							users_profiles.lastname,
																							users_profiles.photo,
																							users_profiles.tags,
																							users_profiles.user_id,
																							likes.content_id,
																							likes.user_id
																							'),
																				   'order'=>'likes.id DESC',
																					'joins'=> array(
																									 array(
																										   'alias'=> 'users_profiles',
																										   'table'=> 'users_profiles',
																										   'foreignKey'=> false,
																										'conditions'=> array('likes.user_id = users_profiles.user_id'
																														  ))),
																					'conditions'=>array('likes.content_type="updates" AND likes.like=1')
																											));
			$this->set('likesOnUpdates',$likesOnUpdates);
			
		/*who share an update*/
		$shareOnUpdates = ClassRegistry::init('statusupdates')->find('all', array('fields'=>array('
																							users_profiles.firstname,
																							users_profiles.lastname,
																							users_profiles.photo,
																							users_profiles.tags,
																							users_profiles.user_id,
																							statusupdates.share
																							'),
																				   'order'=>'statusupdates.id DESC',
																					'joins'=> array(
																									 array(
																										   'alias'=> 'users_profiles',
																										   'table'=> 'users_profiles',
																										   'foreignKey'=> false,
																										'conditions'=> array('statusupdates.user_id = users_profiles.user_id'
																														  ))),
																					'conditions'=>array('statusupdates.content_type="updates" AND statusupdates.share !=0')
																											));
			$this->set('shareOnUpdates',$shareOnUpdates);
			
		}
		$this->autorender = false;
	    $this->layout = false;
	    $this->render('bl_get_home_ajax');
		
	}
	
	public function get_home_ajax() {
			$this->params['pass'];
			$paramenter = $this->params['pass'];
			$lastid = $paramenter[0];
		if ($lastid) {
			if (@$this->userInfo['users']['id']) {
			
			$uid = $this->userInfo['users']['id']; 
					/***********************************    User Connections updates        **********/
		$reqUser = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),'conditions'=>array('(connections.user_id='.$uid.' OR connections.friend_id='.$uid.') AND connections.request=1')));
			
		if ($reqUser) {
			foreach ($reqUser as $rfid) {
				if ($rfid['connections']['friend_id'] != $uid){
				 $result[] .= $rfid['connections']['friend_id'];
				 }
				 if ($rfid['connections']['user_id'] != $uid){
				 $result[] .= $rfid['connections']['user_id'];
			 	}
			}
		}
			/***********************************    User followers updates        **********/
			
		$user_Following_Updates = ClassRegistry::init('users_followings')->find('all',array('fields'=>array('users_followings.following_id'),'conditions'=>array('users_followings.user_id='.$uid.' AND users_followings.status=2')));
		if ($user_Following_Updates) {
			foreach ($user_Following_Updates as $user_Following_Row) {
				 $result[] .= $user_Following_Row['users_followings']['following_id']; 
			}
		}
		/*  To remove dublicate entry from array*/
		$result = array_unique($result);
		
		if($result){
			if (sizeof($result)>1) {
			 	$result =@implode(',',$result);
			}
				else {
						foreach ($result as $key=>$value) {
									$result = $value;
						}
				}
		}
		 if($lastid =='tops'){
					$updates_by_ajax = ClassRegistry::init('statusupdates')->find('all', array('fields'=> array('
																										 statusupdates.user_text,
																										 statusupdates.content_type,
																										 statusupdates.photo,
																										 statusupdates.user_id,
																										 statusupdates.share,
																										 statusupdates.created,
																										 statusupdates.id,
																										 statusupdates.share_with,
																										 statusupdates.update_type,
																										 likes.like,
																										 likes.content_id,
																										 likes.id,likes.user_id,
																										 count(likes.like) as total,
																										 statusupdates.created
																										 '),
																					   'order'=>'statusupdates.id DESC',
																					   'limit'=>5,
																					   'joins'=>array(
																									  array('alias'=> 'likes',
																											'table'=> 'likes',
																											'type'=> 'left',
																											'foreignKey'=> false,
																											'conditions'=> array('statusupdates.id  = likes.content_id AND likes.like=1'))






																									  ),
																					   'conditions'=>array(
																							array('statusupdates.content_type IN ("updates","news","blog","jobs","jobchange")')																										
																										 ),
																					   'group'=> 'statusupdates.id'));	
			}else{
																										 																			 
			$updates_by_ajax = ClassRegistry::init('statusupdates')->find('all', array('fields'=> array('
																										 statusupdates.user_text,
																										 statusupdates.content_type,
																										 statusupdates.photo,
																										 statusupdates.user_id,
																										 statusupdates.share,
																										 statusupdates.created,
																										 statusupdates.update_type,
																										 statusupdates.id,
																										 statusupdates.share_with,
																										 likes.like,
																										 likes.content_id,
																										 likes.id,likes.user_id,
																										 count(likes.like) as total,
																										 statusupdates.created
																										 '),
																					   'order'=>'statusupdates.id DESC',
																					   'limit'=>10,
																					   'joins'=>array(
																									  array('alias'=> 'likes',
																											'table'=> 'likes',
																											'type'=> 'left',
																											'foreignKey'=> false,
																											'conditions'=> array('statusupdates.id  = likes.content_id AND likes.like=1'))





																									  ),
																					   'conditions'=>array(
																							array('statusupdates.content_type IN ("updates","news","blog","jobs","jobchange")'),
																										'statusupdates.id <'.$lastid	
																										 ),
																					   'group'=> 'statusupdates.id'));																																													
 
		
	}

$cnt = 0;
foreach ($updates_by_ajax as $updates){
        //$final_updates[$cnt]
        $userIDs[$cnt] = $updates["statusupdates"]["user_id"];
        $cnt++;
}
$strUserIDs =  implode(",", $userIDs);
$usersDetails = ClassRegistry::init('users_profiles')->find('all', array('fields'=> array('users_profiles.user_id,
                                                                                                 users_profiles.firstname,
                                                                                                 users_profiles.lastname,
                                                                                                 users_profiles.user_id,
                                                                                                 users_profiles.photo'), 'conditions'=>array(
                                array('users_profiles.user_id IN ('.$strUserIDs.')'))));
foreach ($updates_by_ajax as $key => $updates){
        foreach ($usersDetails as $UD){
                if($updates["statusupdates"]["user_id"] == $UD["users_profiles"]["user_id"]){
                        $updates_by_ajax[$key]["users_profiles"]=$UD["users_profiles"];
                        break;
                }
        }
}	
	 $this->set('updates_by_ajax', $updates_by_ajax);
		
	$updates_comments_count= ClassRegistry::init('comments')->find('all', array('fields'=> array(
																								  'comments.content_id,
																								  count(comments.content_id) as commenttotal
																								  '),
																				'conditions'=>array('comments.comment_type="updates"'),
																				'order'=>'comments.id DESC',
																				'group'=>'comments.content_id'
																				)
																   );
		
	$this->set('updates_comments_count',$updates_comments_count);
	
	
	$likes_on_Update = ClassRegistry::init('likes')->find('all', array('fields'=>array('likes.user_id,likes.like,likes.content_id'),'order'=>'likes.id',
																					 'conditions'=>array(
																										 'likes.content_type="updates" AND likes.user_id='.$uid)));
		$this->set('likes_on_Update',$likes_on_Update);
		
		
		$share_user_update = ClassRegistry::init('statusupdates')->find('all', array('fields'=>array('
																								   statusupdates.id,
																								   statusupdates.update_shared,
																								   users_profiles.firstname,
																								   users_profiles.lastname,
																								   users_profiles.user_id
																								   '),
																				   'joins'=> array(
																									 array('alias'=> 'users_profiles',
																										   'table'=> 'users_profiles',
																										   'type'=> 'left',
																										   'foreignKey'=> false,
																										   'conditions'=> array('statusupdates.user_id = users_profiles.user_id'
																																 )
																										   )
																									 ),
																								   'conditions'=>array(
																													   'statusupdates.content_type="updates" AND update_shared=1')));
		$this->set('share_user_update',$share_user_update);
		
		/*to get user who share update*/
		$share_on_Update = ClassRegistry::init('statusupdates')->find('all', array('fields'=>array('statusupdates.share'),
																								   'conditions'=>array(
																													   'statusupdates.content_type="updates" AND statusupdates.share !=0')));
		$this->set('share_on_Update',$share_on_Update);


		$reqUser = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),'conditions'=>array('(connections.user_id='.$uid.' OR connections.friend_id='.$uid.') AND connections.request=1')));
			
		foreach ($reqUser as $rfid) {
			$comResult[] = $rfid['connections']['friend_id'];
			$comResult[] .= $rfid['connections']['user_id'];
		}
		
				
				$user_comments = ClassRegistry::init('comments')->find('all', array('fields'=> array('
																									  comments.comment_text,
																									  comments.created,
																									  comments.content_id,
																									  comments.user_id,
																									  comments.id,
																									  users_profiles.lastname,
																									  users_profiles.firstname,
																									  users_profiles.photo,
																									  users_profiles.user_id,
																									  users_profiles.handler
																									  '),
																					'order'=>'comments.id DESC',
																					'joins'=> array(
																									 array('alias'=> 'users_profiles',
																										   'table'=> 'users_profiles',
																										   'type'=> 'left',
																										   'foreignKey'=> false,
																										   'conditions'=> array('comments.user_id = users_profiles.user_id'
																																 )
																										   )
																									 ),
																					'conditions'=> array('comments.comment_type ="updates"')
																																
																					)
																	   );
	
		

		$this->set('user_comments', $user_comments);
		
			
			}
			
		/*who likes on update*/
		$likesOnUpdates = ClassRegistry::init('likes')->find('all', array('fields'=>array('
																							users_profiles.firstname,
																							users_profiles.lastname,
																							users_profiles.photo,
																							users_profiles.tags,
																							users_profiles.user_id,
																							likes.content_id,
																							likes.user_id
																							'),
																				   'order'=>'likes.id DESC',
																					'joins'=> array(
																									 array(
																										   'alias'=> 'users_profiles',
																										   'table'=> 'users_profiles',
																										   'foreignKey'=> false,
																										'conditions'=> array('likes.user_id = users_profiles.user_id'
																														  ))),
																					'conditions'=>array('likes.content_type="updates" AND likes.like=1')
																											));
			$this->set('likesOnUpdates',$likesOnUpdates);
			
		/*who share an update*/
		$shareOnUpdates = ClassRegistry::init('statusupdates')->find('all', array('fields'=>array('
																							users_profiles.firstname,
																							users_profiles.lastname,
																							users_profiles.photo,
																							users_profiles.tags,
																							users_profiles.user_id,
																							statusupdates.share
																							'),
																				   'order'=>'statusupdates.id DESC',
																					'joins'=> array(
																									 array(
																										   'alias'=> 'users_profiles',
																										   'table'=> 'users_profiles',
																										   'foreignKey'=> false,
																										'conditions'=> array('statusupdates.user_id = users_profiles.user_id'
																														  ))),
																					'conditions'=>array('statusupdates.content_type="updates" AND statusupdates.share !=0')
																											));
			$this->set('shareOnUpdates',$shareOnUpdates);
			
		}
		$this->autorender = false;
	    $this->layout = false;
	    $this->render('get_home_ajax');
		
	}

	
	public function ajax_add() {
		if ($this->request->is('post')) {
		$uid = $this->request->data['Statusupdate']['user_id'];
			$this->request->data['Statusupdate']['share_with'] = $this->request->data['Statusupdate']['share_with'];
			//echo $this->request->data['Statusupdate']['user_text1'];
			if(!empty($this->request->data['Statusupdate']['link_content'])){
				
					$this->request->data['Statusupdate']['update_type'] = 1;
				
				$txt = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $this->request->data['Statusupdate']['user_text']);
				
				$this->request->data['Statusupdate']['user_text'] = $txt.'<div class="clear"></div>'.$this->request->data['Statusupdate']['link_content'];
			}else{
				
				$this->request->data['Statusupdate']['user_text'] = $this->request->data['Statusupdate']['user_text'];
				$this->request->data['Statusupdate']['update_type'] = 0;
			}
			$this->request->data['Statusupdate']['user_id'] = $this->request->data['Statusupdate']['user_id'];
			$this->request->data['Statusupdate']['content_type'] = "updates";
			
			/*file uploading*/
			$filename = $this->request->data['Statusupdate']['photo'];
			//$this->request->data['Statusupdate']['photo'] = $filename['name'];
			//$photo = $this->request->data['Statusupdate']['photo'];
			$imagename = $filename['name'];
			$typess = $filename['type'];
			
			$imageTypes = array("image/gif", "image/jpeg", "image/png","image/jpg");
			
			$uploadFolder = 'files/update/original/';
			$uploadPath = MEDIA_PATH . $uploadFolder;
			foreach ($imageTypes as $type) {
			
				if ($type == $filename['type']) {
					$imageName = $filename['name'];
					if (file_exists($uploadPath . '/'. $imageName)) {
						$imageName = $uid.time() . $imageName;
						}
				$full_image_path = $uploadPath . '/'. $imageName;
			
			if (move_uploaded_file($filename['tmp_name'], $full_image_path)) {
				  //$data['photo'] = $this->request->data['Statusupdate']['photo'];
				 $this->request->data['Statusupdate']['photo'] = $imageName;

				
			} 
			else {
				 $this->request->data['Statusupdate']['photo'] = '';
			}
		}
			else {
			
		$this->Session->setFlash('Unacceptable file type');
		}
			} //loop end
				if ($this->Statusupdate->save($this->request->data)) {
					$lastid = $this->Statusupdate->getInsertID();
					$created_date = date("Y-m-d H:i:s");
					$this->request->data = '';
					$this->request->data['master_activities']['status'] = 1; 
					$this->request->data['master_activities']['activity_id'] = $lastid; 
					$this->request->data['master_activities']['activity_type'] = "updates";
					$this->request->data['master_activities']['viewed'] = 0;
					$this->request->data['master_activities']['user_id'] = $uid;
					$this->request->data['master_activities']['post_owner'] = $uid;
					$this->request->data['master_activities']['created'] = $created_date;
					if (ClassRegistry::init('master_activities')->save($this->request->data)) {
						$this->Session->setFlash('Record successfully added','success_msg');
					}
				}
				else {
					echo "not saved";
					$this->Session->setFlash('File not saved');
				}
			//exit;
		}
		$updates_added_by_ajax = ClassRegistry::init('statusupdates')->find('all', array('fields'=> array('
																										   statusupdates.user_text,
																										   statusupdates.content_type,
																										   statusupdates.photo,
																										   statusupdates.user_id,
																										   statusupdates.share,
																										   statusupdates.created,
																										   statusupdates.id,
																										   statusupdates.update_type,
																										   users_profiles.firstname,
																										   users_profiles.lastname,
																										   users_profiles.user_id,
																										   users_profiles.photo,
																										   likes.like,
																										   likes.content_id,
																										   likes.id,
																										   likes.user_id,
																										   count(likes.like) as total,
																										   statusupdates.created
																										   '),
																						 'order'=>'statusupdates.id DESC',
																						 'joins'=>array(
																										array('alias'=> 'likes',
																											  'table'=> 'likes',
																											  'type'=> 'left',
																											  'foreignKey'=> false,
																											  'conditions'=> array('statusupdates.id  = likes.content_id'
																																	)
																											  ),
																										array('alias'=> 'users_profiles',
																											  'table'=> 'users_profiles',
																											  'type'=> 'left',
																											  'foreignKey'=> false,
																											  'conditions'=> array('statusupdates.user_id = users_profiles.user_id'
																															  )
																											  )
																										),
																						'conditions'=>array('statusupdates.content_type = "updates" AND statusupdates.id='.$lastid),
																						'group'=> 'statusupdates.id'
																						)
																			);
		$this->set('updates_added_by_ajax',$updates_added_by_ajax);
		$this->set('uid',$uid);
		
		$user_comments = ClassRegistry::init('comments')->find('all', array('fields'=> array('
																								  comments.comment_text,
																								  comments.created,
																								  comments.content_id,
																								  comments.user_id,
																								  comments.id,
																								  users_profiles.lastname,
																								  users_profiles.firstname,
																								  users_profiles.photo,
																								  users_profiles.user_id,
																								  users_profiles.handler
																								  '),
																				'order'=>'comments.id DESC',
																				'joins'=> array(
																								 array('alias'=> 'users_profiles',
																									   'table'=> 'users_profiles',
																									   'type'=> 'left',
																									   'foreignKey'=> false,
																									   'conditions'=> array('comments.user_id = users_profiles.user_id'
																															 )
																									   )
																								 ),
																				'conditions'=> array('comments.user_id='.$uid ,'comments.comment_type="updates"'
																									  )
																				)
																   );
				/*who likes on update*/
		$likesOnUpdates = ClassRegistry::init('likes')->find('all', array('fields'=>array('
																							users_profiles.firstname,
																							users_profiles.lastname,
																							users_profiles.photo,
																							users_profiles.tags,
																							users_profiles.user_id,
																							likes.content_id,
																							likes.user_id
																							'),
																				   'order'=>'likes.id DESC',
																					'joins'=> array(
																									 array(
																										   'alias'=> 'users_profiles',
																										   'table'=> 'users_profiles',
																										   'foreignKey'=> false,
																										'conditions'=> array('likes.user_id = users_profiles.user_id'
																														  ))),
																					'conditions'=>array('likes.content_type="updates"')
																											));
			$this->set('likesOnUpdates',$likesOnUpdates);
		
		$this->set('user_comments',$user_comments);
		$this->autorender = false;
		$this->layout = false;
		$this->render('ajax_add');
	}
	
	public function share() {
		
			if ($this->request->is('post')) {
				$this->loadModel('Statusupdate');
				$share = $this->request->data['user_share'];

				$orignaltext = $this->request->data['user_text'];
				$sharetext = $this->request->data['share_text'];
				//$updatedText .= $sharetext;
				if ($sharetext) {
					$updatedText .= $sharetext.'<div class="clear"></div>'.$orignaltext;	
				}else{
					$updatedText .= '<div class="clear"></div>'.$orignaltext;	
				}
				
				$this->request->data['Statusupdate']['share_with'] = $this->request->data['share_with'];
				$this->request->data['Statusupdate']['user_text'] = $updatedText;
				$this->request->data['Statusupdate']['user_id'] = $this->request->data['user_id'];
				$this->request->data['Statusupdate']['content_type'] = $this->request->data['content_type'];
				$this->request->data['Statusupdate']['update_type'] = $this->request->data['update_type'];
				$this->request->data['Statusupdate']['photo'] = $this->request->data['photo'];
				$this->request->data['Statusupdate']['share'] = $share;
				//$this->request->data['Statusupdate']['share_date'] = date("d-m-Y");
				//$this->request->data['shares']['share'] = $share;
				
					if (ClassRegistry::init('Statusupdate')->save($this->request->data)) {
						$lastid = $this->Statusupdate->getInsertID();
						if ($share != 0) {
							$this->request->data = '';
							$this->Statusupdate->id = $share;
							$this->request->data['Statusupdate']['update_shared'] = 1;
							if ($this->Statusupdate->save($this->request->data)) {
	
							}
						}
				
						$this->Session->setFlash('Record successfully added');
						$this->redirect(array('controller'=> 'home', 'action'=> 'index'));
					}
			}
		

	}
	
    public function add() {

	//echo "this is the index for home page";
    }
	function search(){ 
		//if ($this->request->data['term']) 
		$siteusers = ClassRegistry::init('users_profiles')->find('all');
		$this->set('siteusers',$siteusers);
		if($this->request->is('post'))
		{ 
		 $usernames = $this->request->data['User']['username'];
		 $uss = ClassRegistry::init('users')->find('all',array('conditions'=>array('users.username'=> $usernames)));

		$this->redirect(array('controller'=>'users','action'=>'search'));
		   		}
			}
			
			


	/*************** Method Modified by Imran *****************************/

    public function searchFilter() {
		//Configure::write('debug', 2);
        $this->loadModel('Country');
        $this->loadModel('Users_profile');
        $this->loadModel('Company');
        $countryList = $this->Country->find('list');
        $this->set('countryList', $countryList);
		 if(isset($this->request->data)) {
		
			$country = $this->request->params['named']['scope'];
			$keyword = trim($this->request->params['named']['query']);
			$this->set('keyword',$keyword);
			$this->set('country',$country);
			
			$conditionsu=array();
			if (!empty($keyword)) {
				$conditionsu = array('CONCAT(Users_profile.firstname, " ", Users_profile.lastname) LIKE' =>$keyword.'%');
			}
			$cond=array();
			$i = 1;
			if(!empty($country)){
				$cond[$i++] = array('country_id '=>$country);
				
			}
			$cond[$i++] = array('AND' => array('Users_profile.firstname !='=>''));
			$cond[$i++] = array('AND' => array('Users_profile.firstname !='=>'Anonymous'));
			$cond[$i++] = array('AND' => array('User.status >'=>0));
			$cond[$i++] = array('AND' => array('User.role_id ='=>1));
			$condition = array_merge($conditionsu,array('AND'=>array($cond)));
			//$this->Users_profile->recursive = 2;
			//$this->Users_profile->bindModel(array('belongsTo'=>array('Country'=>array('foreignKey'=>'country_id'))));
			$this->paginate=array('fields'=>array(
			'Users_profile.id,
			Users_profile.user_id,
			
					Users_profile.handler,
					CONCAT(Users_profile.firstname ," ", Users_profile.lastname) AS fullname,
					Users_profile.firstname,
					Users_profile.country_id,
					Users_profile.nationality,
					Users_profile.photo,
					Users_profile.gender,
					Users_profile.tags,
					Country.id,					
					Country.name,
					User.id,
					User.role_id,
					User.status'
					),
					 'joins' => array(
						array(
							'alias' => 'Country',
							'table' => 'countries',
							'type' => 'LEFT',
							'conditions' => '`Country`.`id` = `Users_profile`.`country_id`'
						),
						array(
							'alias' => 'User',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`User`.`id` = `Users_profile`.`user_id`'
						)
					),
					'conditions'=>$condition, 'limit'=>10,'order'=>'fullname asc');
			
			//pr($this->paginate('Users_profile'));	
			$this->set('datau', $this->paginate('Users_profile'));
		
			
			if ($this->request->is('ajax')) {
				$this->layout = false;
				$this->autoRender = false;
				$this->render('search_filter','ajax');
			}
		}
    }
	
	
			
	public function searchFilterAjax($limit = 5,$offset = 0){
  $this->loadModel('Job');
  $this->loadModel('Country');
  $this->loadModel('Users_profile');
  $this->loadModel('Company');
  $countryList = $this->Country->find('list');
                $this->set('countryList',$countryList);
                $this->autoLayout = false;
  $this->Job->recursive = 2;
  
  if(isset($this->request->data)){
   $keyword = $this->request->data['keyword'];
   $country = $this->request->data['location'];
   $conditions=array();
   if(!empty($keyword)){
                                $conditions = array('Job.title LIKE'  =>'%'. $keyword . '%');
   }
   $cond=array();
   if(!empty($country)){
    $cond[] = array(' AND'=>array('Country.id '=>$country));
   }
     
   $condition = array_merge($conditions,array(' AND'=>array($cond)));
   $data = $this->Job->find('all',array('conditions'=>array($condition),'limit'=>$limit,'offset'=>$offset));
   $this->set('data',$data);
  }
 }
        
        public function searchFilterUserAjax($limit = 5,$offset = 0){
  $this->loadModel('Job');
  $this->loadModel('Country');
  $this->loadModel('Users_profile');
  $this->loadModel('Company');
  $countryList = $this->Country->find('list');
                $this->set('countryList',$countryList);
                $this->autoLayout = false;
  $this->Job->recursive = 2;
  $keyword = $this->request->data['keyword'];
                $country = $this->request->data['location'];

                $conditionsu=array();
                if(!empty($keyword)){
                        $conditionsu = array('Users_profile.firstname LIKE'=>'%'. $keyword . '%');
                }
                $condu=array();
                if(!empty($country)){
                        $condu[] = array(' AND'=>array('Country.id '=>$country));
                }
                $this->Users_profile->recursive = 2;
                $this->Users_profile->bindModel(array('belongsTo'=>array('Country'=>array('foreignKey'=>'country_id'))));
                $conditionu = array_merge($conditionsu,array(' AND'=>array($condu)));
                $datau = $this->Users_profile->find('all',array('conditions'=>array($conditionu),'limit'=>$limit,'offset'=>$offset));
                $this->set('datau',$datau);
 }

/*************** Methods added by Danish,,,,,END   *****************************/

	public function search_people() {
				if (@$this->userInfo['users']['id']) {
					
					$uid = $this->userInfo['users']['id'];
				}
				if ($this->request->is('get')) {
					$this->loadModel('Users_profile');
					$search_str = $_GET['search_str'];
					if ($search_str) {
					$search_Result_People = ClassRegistry::init('Users_profile')->find('all',array('fields'=>array("
																												   Users_profile.user_id,
																												   CONCAT(Users_profile.firstname,'', Users_profile.lastname) as fullname,Users_profile.photo"),
																								   'limit'=>10,
																								   'order'=>'Users_profile.id DESC',
																								   'conditions'=>array("CONCAT(Users_profile.firstname,'', Users_profile.lastname) LIKE "=>"%$search_str%",'Users_profile.user_id !='.$uid
																															   )
																								   )
																					   );
					//print_r($search_Result_People);
					$this->set('search_Result_People',$search_Result_People);
					}
					
				}
					$this->autorender = false;
					$this->layout = false;
					$this->render('search_people');
	}
	
	/*Search connection for email sending*/
	public function search_connection() {
				if (@$this->userInfo['users']['id']) {
					
					$uid = $this->userInfo['users']['id'];
				}
				if ($this->request->is('get')) {
					$this->loadModel('Users_profile');
					$search_str = $_GET['search_str'];
					if ($search_str) {
					$search_Result_People = ClassRegistry::init('Users_profile')->find('all',array('fields'=>array("
																												   Users_profile.user_id,
																												   CONCAT(Users_profile.firstname,'', Users_profile.lastname) as fullname,Users_profile.photo,users.email"),
																								   'limit'=>10,
																								   'order'=>'Users_profile.id DESC',
																								   'joins'=>array(
																												  array('alias'=> 'users',
																														'table'=> 'users',
																														'type'=> 'left',
																														'foreignKey'=> false,
																													    'conditions'=> array('Users_profile.user_id  = users.id'
																																		  )
																														)
																												  ),
																								   'conditions'=>array("CONCAT(Users_profile.firstname,'', Users_profile.lastname) LIKE "=>"%$search_str%",'Users_profile.user_id !='.$uid
																															   )
																								   )
																					   );
					//print_r($search_Result_People);
					$this->set('search_Result_People',$search_Result_People);
					}
					
				}
					$this->autorender = false;
					$this->layout = false;
					$this->render('search_connection');
	}
	
	
	public function delete_comment() {
		if ($this->request->is('get')) {
			$comment_id = $_GET['comment_id'];
			$content_id = $_GET['content_id'];
			$db = ConnectionManager::getDataSource('default');
			$db->rawQuery("DELETE FROM comments WHERE id=".$comment_id.' AND comment_type= "updates"');
			$db->rawQuery("DELETE FROM master_activities WHERE activity_id=".$comment_id.' AND activity_type= "comments"');
			
			$comments_this_update = ClassRegistry::init('comments')->find('all',array('fields'=>array('comments.content_id
																												  '),
																	 'conditions'=>array('comments.content_id='.$content_id.' AND comments.comment_type="updates"')
																	 )
																				  );
			echo $total_comments = sizeof($comments_this_update);
			
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('delete_comment');
		}
		
	}
	public function view_comments() {

	if ($this->request->is('get')) {
	    $post_id = $_GET['post_id'];
		$post_admin = $_POST['admin_id'];
		$moreComments = ClassRegistry::init('comments')->find('all', array('fields' => array('
																							 comments.comment_text,
																							 comments.created,
																							 comments.content_id,
																							 comments.id,
																							 comments.user_id,
																							 users_profiles.firstname,
																							 users_profiles.lastname,
																							 users_profiles.user_id,
																							 users_profiles.photo
																								 '),
																			   'order'=>'comments.id DESC', 
																			   'joins' => array(
																								array('alias' => 'users_profiles',
																									  'table' => 'users_profiles',
																									  'type' => 'left',
																									  'foreignKey' => false,
																									  'conditions' => array('comments.user_id = users_profiles.user_id'
																															)
																									  )
																								),
																			   'conditions' => array('comments.comment_type="updates" AND comments.content_id='.$post_id
																									 )
																			   )
																  );
	$this->set('moreComments',$moreComments);
	$this->set('post_admin',$post_admin);
	
	}
	$this->autorender = false;
	$this->layout = false;
	$this->render('view_comments');
 }
	
	public function notifications() {
		
		$user_notifications = ClassRegistry::init('master_activities')->find('all',array('fields' => array('
																										   	 master_activities.created
																											 '
																											 ),
																						 'group' => 'DATE_FORMAT(master_activities.created,"%Y-%m-%d")',
																						   'conditions' => array('master_activities.status =1'),
																						   'order'=>'master_activities.created DESC'
																						   ));
		$this->set('user_notifications',$user_notifications);
		
	}
	
	public function clear() {
		
		$uid =  $this->userInfo['users']['id'];	
		
		$user_notifications = ClassRegistry::init('clear_notifications')->find('first',array('fields' => array('
																											 clear_notifications.id
																											 '),
																						   'conditions' => array('clear_notifications.user_id ='.$uid)
																						   ));
		$clear_id = $user_notifications['clear_notifications']['id'];
		
			$clear_date = date('Y-m-d H:i:s');
					
			$this->request->data['clear_notifications']['created'] = $clear_date;
			
			$this->request->data['clear_notifications']['user_id'] = $uid;
		
		if ($clear_id) {
			
			ClassRegistry::init('clear_notifications')->id = $clear_id;
			
			if (ClassRegistry::init('clear_notifications')->save($this->request->data)) {
				
			}
		}
		else {
			
			if (ClassRegistry::init('clear_notifications')->save($this->request->data)) {
				
			}
			
		}
		
		$this->redirect('/');
	}
	
	
	public function date_activity() {
		
		$uid = @$this->userInfo['users']['id']; 
		$date_wise_notification = '';
		if (!empty($this->request->params['requested'])) {
			//print_r($this->params->params['pass']);
			$parameters = $this->params->params['pass'];
			$date_created = $parameters[0];
			$date_created = "'".$date_created."'";
			$date_wise_notification = ClassRegistry::init('master_activities')->find('all',array('fields' => array('
																										   	 master_activities.created,																							
																											 master_activities.id,
																											 master_activities.activity_id,
																											 master_activities.activity_type,
																											 master_activities.user_id,
																											 master_activities.post_owner,
																											 master_activities.viewed
																											 '
																											 ),
																						   'conditions' => array('master_activities.status =1 AND DATE_FORMAT(master_activities.created,"%Y-%m-%d") ='.$date_created),
																						   'order'=>'master_activities.created DESC'
																						   ));
			
			/*echo "<pre>";
			print_r($date_wise_notification);*/
			
			return $date_wise_notification;
		}
		else {
			return $date_wise_notification;
		}
		
	}
		
	public function delete_notification() {
		
			if ($this->request->is('get')) {
			$notification_id = $_GET['notification_id'];
			$type = $_GET['type'];
			$db = ConnectionManager::getDataSource('default');
			$db->rawQuery("DELETE FROM master_activities WHERE id=".$notification_id);
			$db->rawQuery("DELETE FROM users_viewings WHERE viewings_id=".$notification_id." AND viewings_type=".'"'.$type.'"');
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('delete_update');
		}
		
	}
	
	public function user_login() {
		
		
	}

} ?>
