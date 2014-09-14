<?php
class CommentsController extends AppController {

    var $helpers = array('Form', 'html');
    var $components = array('Auth');
	var $uses = array('User','Connection','Comment','Like','Ratting','Users_following','Comment_like');
    function beforeFilter() {
	parent::beforeFilter();

	//$this->Auth->allow(array('login', 'logout','add'));
	$this->Auth->allow();
	switch ($this->request->params['action']) {
	    case 'index':
	    case 'admin_index':
	    // $this->Security->validatePost = false;
	}
    }

    public function index() {
	if ($this->userInfo['users']['id']) {
		$uid = $this->userInfo['users']['id'];
		//$AllConnections = ClassRegistry::init('connections')->find('all',array('conditions'=>array('AND'=>array('connections.user_id' => $uid,'connections.request'=>1))));
		
		$AllConnections = ClassRegistry::init('users')->find('all', array('fields' => array('users.*,userexps.*,connections.friend_id,connections.request,connections.user_id'), 'joins' => array(array('alias' => 'connections', 'table' => 'connections', 'foreignKey' => false, 'conditions' => array('connections.user_id='.$uid.' AND connections.request=1 AND connections.friend_id = users.id')),
		array('alias' => 'userexps', 'table' => 'userexps', 'foreignKey' => false, 'conditions' => array('userexps.user_id=users.id'),'limit'=>1,'order'=>'userexps.end_date DESC'))));
		$this->set('AllConnections', $AllConnections);
		}
	}

    public function add_comment() {

	if ($this->request->is('post')) {
	    $user_id = $_POST['user_id'];
		$uid = $_POST['user_id'];
		$post_admin = $_POST['admin_id'];
	    $comment_type = $_POST['comment_type'];
	    $content_id = $_POST['content_id'];
	    $comment_date = $_POST['comment_date'];
		$comment_text = $_POST['comment_text'];
		$parent = $_POST['parent'];
	    $this->request->data['Comment']['user_id'] = $user_id;
	    $this->request->data['Comment']['comment_type'] = $comment_type;
	    $this->request->data['Comment']['content_id'] = $content_id;
		$this->request->data['Comment']['comment_date'] = $comment_date;
	    $this->request->data['Comment']['comment_text'] = $comment_text;
		$this->request->data['Comment']['parent'] = $parent;
		
	    //print_r($this->request->data);
		$this->set('content_id',$content_id);
		$this->set('comment_type',$comment_type);
	    if ($this->Comment->save($this->request->data)) {
		$this->Session->setFlash('User successfully saved.');
		$lastid = $this->Comment->getInsertID();
		$created_date = date("Y-m-d H:i:s");
		$this->request->data = '';
		if ($post_admin != $uid) {
			$this->request->data['master_activities']['status'] = 1; 
			$this->request->data['master_activities']['activity_id'] = $lastid; 
			$this->request->data['master_activities']['activity_type'] = "comments";
			$this->request->data['master_activities']['viewed'] = 0;
			$this->request->data['master_activities']['user_id'] = $uid;
			$this->request->data['master_activities']['post_owner'] = $post_admin;
			$this->request->data['master_activities']['created'] = $created_date;
			if (ClassRegistry::init('master_activities')->save($this->request->data)) {
				
			}
		}
		$this->request->data = '';
		/*comment Owner like his own comment  start*/
		if ($parent == 0 && $comment_type !='updates') {
			$this->request->data['Comment_like']['content_type'] = 'comments';
			$this->request->data['Comment_like']['created'] = date("Y-m-d");
			$this->request->data['Comment_like']['like'] = 1;
			$this->request->data['Comment_like']['user_id'] = $uid;
			$this->request->data['Comment_like']['comment_id'] = $lastid;
			$this->request->data['Comment_like']['content_id'] = $content_id;
			if (ClassRegistry::init('Comment_like')->save($this->request->data)) {
				$this->Session->setFlash('Record sucsessfully added');
				//$this->redirect(array('controller' => 'home', 'action' => 'index'));
			}
		}
	} 
		else {
		echo "not saved";
	    }
		/*user friends  start*/	
	$reqUser = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),'conditions'=>array('(connections.user_id='.$uid.' OR connections.friend_id='.$uid.') AND connections.request=1')));
			
		foreach ($reqUser as $rfid) {
				if ($rfid['connections']['friend_id'] != $user_id) {
					$comResult[] .= $rfid['connections']['friend_id'];
				}
				if ($rfid['connections']['user_id'] != $user_id) {
					$comResult[] .= $rfid['connections']['user_id'];
				} 
		}
		/*user friends  end*/
		if ($comment_type == 'articles'){
			$comment_type = 'articles';
		}
		else if ($comment_type == 'company') {
				$comment_type = 'company';
		} else{
			$comment_type = 'updates';
			}
		
		/*comments  start*/
			 if (sizeof($comResult)>1) { 
			  	$comResult =@implode(',',$comResult);
				}
		$userComments = ClassRegistry::init('comments')->find('all', array('fields' => array('
																							 comments.comment_text,
																							 comments.created,
																							 comments.content_id,
																							 comments.id,
																							 comments.user_id,
																							 users_profiles.firstname,
																							 users_profiles.lastname,
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
																		   'conditions' => array('comments.comment_type="'.$comment_type.'" AND 
																								 comments.parent =0 AND comments.content_id='.$content_id
																													   )
																		   )
															  );
		
		$this->set('userComments', $userComments);
		/*comments  end*/
		if ($comment_type != 'updates') {
		/*Comments on comment start here*/
		$commentsParents = ClassRegistry::init('comments')->find('all',array('fields'=>array('comments.id'),'conditions'=>array('comments.parent=0 AND comments.comment_type="articles" AND comments.content_id='.$content_id)));
			
		foreach ($commentsParent as $commentsIDS) {
					$commentIdArray[] .= $commentsIDS['comments']['id'];
		}
		//print_r($commentIdArray);
		if ($commentIdArray) {
		if (sizeof($commentIdArray)>1){
			$commentIdArray = @implode(',',$commentIdArray);
		$userCommentsOnComments = ClassRegistry::init('comments')->find('all',array('fields' => array('
																									  comments.comment_text,
																									  comments.created,
																									  comments.content_id,
																									  comments.id,
																									  users_profiles.firstname,
																									  users_profiles.lastname,
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
																					'conditions' => array(array('comments.parent IN ('.$commentIdArray.')') ,
																																	 'comments.comment_type="'.$comment_type.'" AND comments.content_id='.$content_id
																																	 )
																					)
																		);
		}
		else {
			
			$userCommentsOnComments = ClassRegistry::init('comments')->find('all',array('fields' => array('
																										  comments.comment_text,
																									  	  comments.created,
																									  	  comments.content_id,
																									  	  comments.id,
																									      users_profiles.firstname,
																									      users_profiles.lastname,
																									      users_profiles.photo
																										  '),
																						'order'=>'comments.id DESC',
																						'joins' => array(array('alias' => 'users_profiles',
																											   'table' => 'users_profiles',
																											   'type' => 'left',
																											   'foreignKey' => false,
																											   'conditions' => array('comments.user_id = users_profiles.user_id'
																																	 )
																											   )
																										 ),
																						'conditions' => array(array('comments.parent IN ('.$commentIdArray[0].')'),'comments.comment_type="'.$comment_type.'" AND comments.content_id='.$content_id
																																						   )
																						)
																			);
		}
		}
		else {
			$userCommentsOnComments = ClassRegistry::init('comments')->find('all',array('fields' => array('
																										  comments.comment_text,
																									  	  comments.created,
																									  	  comments.content_id,
																									  	  comments.id,
																									      users_profiles.firstname,
																									      users_profiles.lastname,
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
																						'conditions' => array('comments.comment_type="'.$comment_type.'" AND comments.content_id='.$content_id)
																						)
																			);
		}
	
			$this->set('userAjaxCommentsOnComments',$userCommentsOnComments);
			/*Comments on comment end here*/

		
		/*total replys on the comment*/
			$checkUserReplys = ClassRegistry::init('comments')->find('all',
			array('conditions'=>array('comments.parent=0 AND comments.comment_type="articles"')));
		if ($checkUserReplys) {
		foreach ($checkUserReplys as $reply) {
			$commentIDs[] .= $reply['comments']['id'];
		}
	
			if (sizeof($commentIDs)>1) {
				$commentIDs = @implode(",",$commentIDs);
				$countReplys = ClassRegistry::init('comments')->find('all' ,array('fields'=>array('count(comments.parent) as total_reply,comments.parent'),
				'conditions'=>array(array('comments.parent IN ('.$commentIDs.')'),'comments.comment_type="articles"'),'group'=>'comments.parent'));
			}
			else {
				$countReplys = ClassRegistry::init('comments')->find('all' ,array('fields'=>array('count(comments.parent) as total_reply,comments.parent'),
				'conditions'=>array(array('comments.parent IN ('.$commentIDs[0].')'),'comments.comment_type="articles"'),'group'=>'comments.parent'));
			}
			
			$this->set('countReplys',$countReplys);
			
			}
			
		} // reply on comments without type updates end here
		
		$this->set('total_comments_post',sizeof($userComments));
		$this->set('post_admin',$post_admin);
	    $this->autorender = false;
	    $this->layout = false;
	    $this->render('add_comment');
}
}
		public function updateConnection() {
			if ($this->request->is('post')) {
				$uidd = $this->request->data['friend_id'];
				$req_id = $this->request->data['user_id'];
				$this->Connection->friend_id = $uidd;
				$this->Connection->user_id = $req_id;
				$this->request->data['connections']['request']=1;
				$output = $this->Connection->saveConnection($req_id,$uidd,$this->request->data['connections']['request']);
				$this->redirect(array('controller' => 'home', 'action' => 'index'));	
			}
		}


    public function add_like() {
	if ($this->userInfo['users']['id']) {
		$uid = $this->userInfo['users']['id'];
	}
	
	if ($this->request->is('get')) {
	    $user_id = $_GET['user_id'];
		$id = $_GET['id'];
	    $content_type = $_GET['content_type'];
	    $content_id = $_GET['content_id'];
	    $created = $_GET['created'];
		$like = $_GET['like']; 
	    $this->request->data['Like']['user_id'] = $user_id;
	    $this->request->data['Like']['content_type'] = $content_type;
	    $this->request->data['Like']['content_id'] = $content_id;
		$this->request->data['Like']['created'] = $created;
	    $this->request->data['Like']['like'] = $like;
	    //print_r($this->request->data);
			if ($content_type == 'news'){
				$content_type = 'news';
				$post_record = ClassRegistry::init('news')->find('first',array('conditions'=>array('news.id='.$content_id)));
				$post_admin_id = $post_record['news']['user_id'];
			}
			elseif ($content_type == 'company'){
				$content_type = 'company';
				$post_record = ClassRegistry::init('companies')->find('first',array('conditions'=>array('companies.id='.$content_id)));
				$post_admin_id = $post_record['companies']['user_id'];
			}
			elseif ($content_type == 'blog'){
				$content_type = 'blog';
				$post_record = ClassRegistry::init('blogs')->find('first',array('conditions'=>array('blogs.id='.$content_id)));
				$post_admin_id = $post_record['blogs']['user_id'];
			}
			elseif ($content_type == 'groups'){
				$content_type = 'groups';
				$post_record = ClassRegistry::init('groups')->find('first',array('conditions'=>array('groups.id='.$content_id)));
				$post_admin_id = $post_record['groups']['user_id'];
			}
			else{
				$content_type = 'updates';
				$post_record = ClassRegistry::init('statusupdates')->find('first',array('conditions'=>array('statusupdates.id='.$content_id)));
				$post_admin_id = $post_record['statusupdates']['user_id'];
			}
			$this->set('content_id',$content_id);
			$this->set('like',$like);
		$checkLike = ClassRegistry::init('likes')->find('first',array('conditions'=>array('likes.user_id='.$user_id.' AND likes.content_id='.$content_id.' AND likes.content_type="'.$content_type.'"')));
		
		if ($checkLike) {
			$id = $checkLike['likes']['id'];
	    if($this->Like->updateAll(array('like' =>'"'.$like.'"'), array('Like.id' => $id))) {
			if ($post_admin_id != $uid) {
				$master_activity_dt = ClassRegistry::init('master_activities')->find('first',array('fields'=>array('master_activities.id'),
																												   'conditions'=>array('master_activities.activity_id='.$id)));
				$notify_Id = $master_activity_dt['master_activities']['id'];
	
				if ($like == 0) {
						if ($notify_Id) {
							$db = ConnectionManager::getDataSource('default');
							$db->rawQuery('DELETE FROM master_activities WHERE id ='.$notify_Id.' AND activity_type="likes"');
						}
					}
					else {
						$this->request->data['master_activities']['status'] = 1; 
						$created_date = date("Y-m-d H:i:s");
						$this->request->data['master_activities']['activity_id'] = $id; 
						$this->request->data['master_activities']['activity_type'] = "likes";
						$this->request->data['master_activities']['viewed'] = 0;
						$this->request->data['master_activities']['user_id'] = $uid;
						$this->request->data['master_activities']['post_owner'] = $post_admin_id;
						$this->request->data['master_activities']['created'] = $created_date;
						if (ClassRegistry::init('master_activities')->save($this->request->data)) {
							
						}
					}
			}
			
	    } else {
		echo "not updated";
	    }
		}
		else {
			
			if (ClassRegistry::init('Like')->save($this->request->data)){
				$lastid = $this->Like->getInsertID();
				if ($post_admin_id != $uid) {
					$this->request->data['master_activities']['status'] = 1; 
					$created_date = date("Y-m-d H:i:s");
					$this->request->data['master_activities']['activity_id'] = $lastid; 
					$this->request->data['master_activities']['activity_type'] = "likes";
					$this->request->data['master_activities']['viewed'] = 0;
					$this->request->data['master_activities']['user_id'] = $uid;
					$this->request->data['master_activities']['post_owner'] = $post_admin_id;
					$this->request->data['master_activities']['created'] = $created_date;
					if (ClassRegistry::init('master_activities')->save($this->request->data)) {
						
					}
				}
				
			}
			else {
				
				echo "field value not saved";
			}
		}
		
	$countLike = ClassRegistry::init('likes')->find('all' ,array('fields'=>array('count(likes.like) as total_like'),'conditions'=>array('likes.content_id='.$content_id.' AND likes.content_type="'.$content_type.'" AND likes.like=1')));
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
																			'conditions'=>array('likes.content_type="'.$content_type.'" AND likes.like=1 AND likes.content_id='.$content_id)
																									));
			$this->set('likesOnUpdates',$likesOnUpdates);
			
			$countLike = $countLike[0][0];
			$countLike = $countLike['total_like'];	
			$this->set('total_Liked',$countLike);
			$this->set('content_type',$content_type);
	    	$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('add_like');
		}
		
}

		/*comments like*/
   public function comment_like() {
	if ($this->userInfo['users']['id']) {
		$uid = $this->userInfo['users']['id'];
	}
	
	if ($this->request->is('get')) {
	    $user_id = $_GET['user_id'];
		$id = $_GET['id'];
	    $content_type = $_GET['content_type'];
	    $content_id = $_GET['content_id'];
	    $created = $_GET['created'];
		$comment_id = $_GET['comment_id'];
		$like = $_GET['like']; 
	    $this->request->data['Comment_like']['user_id'] = $user_id;
	    $this->request->data['Comment_like']['content_type'] = $content_type;
	    $this->request->data['Comment_like']['content_id'] = $content_id;
		$this->request->data['Comment_like']['created'] = $created;
	    $this->request->data['Comment_like']['like'] = $like;
		$this->request->data['Comment_like']['comment_id'] = $comment_id;
	    //print_r($this->request->data);
			
		$checkCommentLike = ClassRegistry::init('comment_likes')->find('all',array('conditions'=>array('comment_likes.user_id='.$user_id.' AND comment_likes.comment_id='.$comment_id.' AND comment_likes.content_type="comments"')));
		
		if ($checkCommentLike) {
	    if($this->Comment_like->updateAll(array('comment_likes' =>'"'.$like.'"'), array('comment_likes.id' => $id))) {
		$this->Session->setFlash('Like comment successfully saved.');
		//echo "field value updated";
	    } else {
		echo "not updated";
	    }
		}
		else {
			
			if (ClassRegistry::init('Comment_like')->save($this->request->data)){
				//echo "field value saved";
			}
			else {
				
				echo "field value not saved";
			}
		}
		
	$countCommentLike = ClassRegistry::init('comment_likes')->find('all' ,array('fields'=>array('count(comment_likes.like) as total_comment_like'),'conditions'=>array('comment_likes.comment_id='.$comment_id.' AND comment_likes.content_type="'.$content_type.'"')));
			$countCommentsLike = $countCommentLike[0][0];
			$countCommentsLike = $countCommentsLike['total_comment_like'];	
			$this->set('countCommentsLike',$countCommentsLike);
	    	$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('comment_like');
		}
		
}

		public function rateTheArticle() {
			
			if ($this->userInfo['users']['id']) {
				$uid = $this->userInfo['users']['id'];
	}
	
	if ($this->request->is('get')) {
	    $user_id = $_GET['user_id'];
		$rate = $_GET['rate'];
	    $content_type = $_GET['content_type'];
	    $content_id = $_GET['content_id'];
	    $this->request->data['Ratting']['user_id'] = $user_id;
	    $this->request->data['Ratting']['content_type'] = $content_type;
	    $this->request->data['Ratting']['content_id'] = $content_id;
	    $this->request->data['Ratting']['rate'] = $rate;
			if ($content_type == 'articles'){
			$content_type = 'articles';
		}
			else{
			$content_type = 'updates';
			}
			
			if (ClassRegistry::init('Ratting')->save($this->request->data)){
				//echo "field value saved";
			}
			else {
				
				echo "field value not saved";
			}
		$countRate = ClassRegistry::init('rattings')->find('all' ,array('fields'=>array('count(rattings.user_id) as total_user,sum(rattings.rate) as total_rate'),'conditions'=>array('rattings.content_id='.$content_id.' AND rattings.content_type="'.$content_type.'"')));
		//$this->set('countRate',$countRate);
			$totalRate = $countRate[0][0];
			$totalUser = $totalRate['total_user'];	
		 	$totalRatting = $totalRate['total_rate'];
			$countedRate = ceil($totalRatting/$totalUser);
			$this->set('countedRate',$countedRate);
	    $this->autorender = false;
	    $this->layout = false;
	    $this->render('add_ratting');
		}
		}
	
	/*Follow the current post*/
		public function add_follow() {
			if ($this->userInfo['users']['id']) {
				$uid = $this->userInfo['users']['id'];
	}
	
	if ($this->request->is('get')) {
	    $user_id = $_GET['user_id'];
		$following_id = $_GET['following_id'];
	    $following_type = $_GET['following_type'];
	    //$content_id = $_GET['content_id'];
		$start_date = $_GET['start_date'];
		$end_date = $_GET['end_date'];
		$status = $_GET['status'];
		$id = $_GET['id'];
		$contact_id = $_GET['contact_id'];
		$connection = $_GET['connection'];
		if ($connection) {
			$this->set('connection',$connection);
		}
		if ($following_type == 'users' && $status == 0) {
			$retweeted_tweets_byuser = ClassRegistry::init('tweets')->find('all',array('fields'=>array('tweets.id'),
																					'conditions'=>array('tweets.parent_id =0 AND tweets.status=2 AND tweets.user_id='.$following_id)));
			
					foreach ($retweeted_tweets_byuser as $retweeted_by_user) {
						$content_array[] = $retweeted_by_user['tweets']['id'];
					}
					if ($content_array) {
						if (sizeof($content_array)>1) {
						$content_IDS = @implode(',',$content_array);
						}
						else {
						$content_IDS = $content_array[0];
						}
					}
					if ($content_IDS) {
						$db = ConnectionManager::getDataSource('default');
						$db->rawQuery('DELETE FROM tweets WHERE parent_id IN('.$content_IDS.') AND tweets.user_id='.$user_id);
					}
		}
		
	    $this->request->data['Users_following']['user_id'] = $user_id;
		if ($following_type == 'users') {
			$this->request->data['Users_following']['status'] = $status;
		}
		else {
		$this->request->data['Users_following']['status'] = 2;
		}
	    $this->request->data['Users_following']['following_type'] = $following_type;
	    //$this->request->data['Users_following']['content_id'] = $content_id;
	    $this->request->data['Users_following']['following_id'] = $following_id;
		$this->request->data['Users_following']['start_date'] = $start_date;
		
			if ($following_type == 'articles'){
			$following_type = 'articles';
			
			}
			else if ($following_type == 'updates'){
			$following_type = 'updates';
			}
			else if ($following_type == 'users'){
			$following_type = 'users';
			}
			if ($id !='') {
			if($this->Users_following->updateAll(array('status' =>$status), array('Users_following.id' => $id))){	
			}
			else {
				echo "not updated";	
			}
			}
			else {
			if (ClassRegistry::init('Users_following')->save($this->request->data)){
				$id = $this->Users_following->getInsertID();
			}
			else {
				echo "field value not saved";
			}
			}
			$this->set('following_type',$following_type);
			$this->set('status',$status);
			$this->set('id',$id);
			
			if  ($following_type == 'users') {
				$countFollow = ClassRegistry::init('users_followings')->find('all' ,array('fields'=>array('count(users_followings.following_id) as total_follow'),'conditions'=>array('users_followings.following_id='.$following_id.' AND users_followings.following_type="'.$following_type.'" AND users_followings.status=2')));
			$totalFollows = $countFollow[0][0];
			$totalFollows = $totalFollows['total_follow'];	
			$this->set('totalFollows',$totalFollows);
			$this->set('contact_id',$contact_id);
			}
			else {
		$countFollow = ClassRegistry::init('users_followings')->find('all' ,array('fields'=>array('count(users_followings.following_id) as total_follow'),'conditions'=>array('users_followings.following_id='.$following_id.' AND users_followings.following_type="'.$following_type.'"')));
			$totalFollows = $countFollow[0][0];
			$totalFollows = $totalFollows['total_follow'];	
			$this->set('totalFollows',$totalFollows);
			}
	    $this->autorender = false;
	    $this->layout = false;
	    $this->render('add_follow');
		}
		}

	
}
?>