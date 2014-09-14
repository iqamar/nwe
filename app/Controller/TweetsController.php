<?php
class TweetsController extends AppController {


  var $helpers = array('Form', 'html');
    var $components = array('Auth');
	var $uses = array('User','Comment','Connection','Favorite','Tweet','Users_following','Tweet_comment');
    function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
		switch ($this->request->params['action']) {
			case 'index':
			case 'admin_index':	
		}
    }

	   
    public function index() {
		  /*
                 * To find no.of jobs in a country
                 * START
                 */
                $this->loadModel('Job');
                $jobsByCountry = $this->Job->find('all',
                        array(
                            'fields'=>array('count(*) AS cnt,Country.name AS cname'),
                            'conditions'=>array('Job.country_id !=' => '0'),
                            'group' => array('Job.country_id')
                            ) 
                        );
                $this->set('jobsByCountry',$jobsByCountry);
                /*
                 * END
                 */

			$zero = 0;
		//$userData = $this->Session->read(@$userid);
		if (empty($this->userInfo['users']['id'])) {	
				$this->loadModel('Country');
				$countryList = $this->Country->find('list');
				$this->set('countryList',$countryList);
			}
		if ($this->userInfo['users']['id']) {

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
				 $following_result[] .= $user_Following_Row['users_followings']['following_id']; 
			}
		}
		/*  To remove dublicate entry from array*/
		
		$following_result = array_unique($following_result);

		if($following_result){
			if (sizeof($following_result)>1) {
			 	$following_result =@implode(',',$following_result);
			}
				else {
						foreach ($following_result as $key=>$value) {
									$following_result = $value;
						}
				}
				$following_result =$following_result.",".$uid;
		}
		else {
			
			$following_result = $uid;	
		}
		
				if ($following_result) {
				$user_tweets = ClassRegistry::init('tweets')->find('all', array('fields' => array('
																								  tweets.tweet,
																								  tweets.id,
																								  tweets.user_id,
																								  tweets.photo,
																								  tweets.created,
																								  users_profiles.firstname,
																								  users_profiles.lastname,
																								  users_profiles.photo,
																								  users_profiles.user_id,
																								  users_profiles.handler,
																								  favorites.favorite,
																								  favorites.content_id,
																								  favorites.id ,
																								  favorites.user_id,
																								  count(favorites.favorite) as total_favorites
																								  ')
																				,'order'=>'tweets.id DESC',
																				'limit'=>5,
																				'joins'=>array(
																							   array('alias' => 'favorites',
																									 'table' => 'favorites',
																									 'type' => 'left',
																									 'foreignKey' => false,
																									 'conditions' => array('favorites.content_id = tweets.id '
																														   )
																									 ),
																							   array('alias' => 'users_profiles',
																									 'table' => 'users_profiles',
																									 'type' => 'left',
																									 'foreignKey' => false,
																									 'conditions' => array('tweets.user_id = users_profiles.user_id'
																														   )
																									 )
																							   ),
																				'conditions'=>array(array('tweets.user_id IN ('.$following_result.')'),
																							   'tweets.parent_id =0'),
																				'group'=>'tweets.id'));	
				
				$tweets_retweeted_byUser = ClassRegistry::init('tweets')->find('all', array('fields' => array('
																											  tweets.parent_id,
																											  tweets.id,
																											  tweets.user_id,
																											  users_profiles.firstname,
																											  users_profiles.lastname,
																											  users_profiles.photo,
																											  users_profiles.tags,
																											  users_profiles.user_id,
																											  users_profiles.handler
																											  '
																											  ),
																							'joins'=>array(
																										   array('alias' => 'users_profiles',
																												 'table' => 'users_profiles',
																												 'type' => 'left',
																												 'foreignKey' => false,
																												 'conditions' => array('users_profiles.user_id = tweets.user_id'
																																	   )
																												 )
																										   ),
																							'order'=>'tweets.id DESC',
																							'limit'=>5,
																							'conditions'=>array(array('tweets.user_id IN ('.$following_result.')'),
																																		  'tweets.parent_id !=0 AND 
																																		  tweets.retweet=1'
																																		  )			  
																							
																							)
																			   );
				$this->set('tweets_retweeted_byUser',$tweets_retweeted_byUser);
																							
		$total_tweets = ClassRegistry::init('tweets')->find('all', array('fields' => array('tweets.id'),'conditions'=>array(array('tweets.user_id IN ('.$following_result.')'),
																																		  'tweets.parent_id =0'
																																		  )
																								   )
																	);
				$this->set('total_tweets',sizeof($total_tweets));
		}
	
	$this->set('user_tweets', $user_tweets);
	
	/*Tweet count for current user*/
	$tweets_count_added_user= ClassRegistry::init('tweets')->find('all',
																array('conditions'=>array('tweets.user_id='.$uid.' AND tweets.status=2')));
		
	$this->set('tweets_count_added_user',sizeof($tweets_count_added_user));

					/**************************************      To show user following and followers          ***********************/
				$userFollowings = ClassRegistry::init('users_followings')->find('all' ,array('fields'=>array('
																											 users_followings.id,
																											 users_followings.status,
																											 count(users_followings.following_id) as total_following
																											 '),
																							 'conditions'=>array('users_followings.user_id='.$uid.' AND 
																											users_followings.following_type ="users" AND users_followings.status=2'
																								)
																							 )
																				);
		
		$userFollows = ClassRegistry::init('users_followings')->find('all' ,array('fields'=>array('
																								  users_followings.id,
																								  users_followings.status ,
																								  count(users_followings.user_id) as total_follow
																								  '),
																				  'conditions'=>array('users_followings.following_id='.$uid.' AND 
																									  users_followings.following_type ="users" AND 
																									  users_followings.status=2'
																									  )
																				  )
																	 );
		
		
		$userFollowingsbyYou = $userFollowings[0][0];
		$userFollowingsbyYou = $userFollowingsbyYou['total_following'];
		$this->set('following',$userFollowingsbyYou);
		
		$userFollowYou = $userFollows[0][0];
		$userFollowYou = $userFollowYou['total_follow'];
		$this->set('followers',$userFollowYou);		
		
					/*user friends  start*/	
	$reqUser = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),
																					'conditions'=>array('(connections.user_id='.$uid.' OR connections.friend_id='.$uid.') AND connections.request=1')));
			
		foreach ($reqUser as $rfid) {
				if ($rfid['connections']['friend_id'] != $uid) {
					$comResult[] .= $rfid['connections']['friend_id'];
				}
				if ($rfid['connections']['user_id'] != $uid) {
					$comResult[] .= $rfid['connections']['user_id'];
				} 
		}
		/*user friends  end*/
		
		if($comResult){
			if (sizeof($comResult)>1) {
			 	$result =@implode(',',$comResult);
			}
			else {
					foreach ($comResult as $key=>$value) {
									$result = $value;
						}
			}
					$result =$result.",".$uid;
		}
		else {
			$result = $uid;	
		}
				$user_tweet_comments = ClassRegistry::init('Tweet_comment')->find('all', array('fields' => array('
																												 Tweet_comment.tweet_comment,
																												 Tweet_comment.id,
																												 Tweet_comment.content_id,
																												 Tweet_comment.created,
																												 Tweet_comment.user_id,
																												 users_profiles.firstname,
																												 users_profiles.lastname,
																												 users_profiles.photo,
																												 users_profiles.handler,
																												 users_profiles.user_id,
																												 users_profiles.tags,
																												 favorites.favorite,
																												 favorites.content_id,
																												 favorites.id,
																												 favorites.user_id
																												 '),
																							   'order'=>'Tweet_comment.id DESC',
																							   'joins'=>array(	
																											  array('alias' => 'favorites',
																													'table' => 'favorites',
																													'type' => 'left',
																													'foreignKey' => false,
																												    'conditions' => array('Tweet_comment.id  = favorites.content_id'
																																	  )
																												),
																											  array('alias' => 'users_profiles',
																													'table' => 'users_profiles',
																													'type' => 'left',
																													'foreignKey' => false,
																										'conditions' => array('Tweet_comment.user_id = users_profiles.user_id'
																															  )
																										)
																											  ),
																							   'conditions'=>array('Tweet_comment.comment_type = "tweets"'
																																	),
																							   'group' => 'Tweet_comment.id'));																																													
		$this->set('user_tweet_comments',$user_tweet_comments);
		/***********************************  Total reply on each tweet     **********/	
		$tweets_comments_count= ClassRegistry::init('Tweet_comment')->find('all', array('fields'=> array(
																								  'Tweet_comment.content_id,
																								  count(Tweet_comment.content_id) as commenttotal
																								  '),
																				'conditions'=>array('Tweet_comment.comment_type="tweets"'),
																				'order'=>'Tweet_comment.id DESC',
																				'group'=>'Tweet_comment.content_id'
																				)
																   );
		
	   $this->set('tweets_comments_count',$tweets_comments_count);	
		 /***********************************    Likes on updates in home page        **********/
		 if ($uid) {
		$favorites_on_Tweet = ClassRegistry::init('favorites')->find('all', array('fields'=>array('
																								  favorites.user_id,
																								  favorites.favorite,
																								  favorites.content_id,
																								  favorites.id
																								  '),
																								   'order'=>'favorites.id',
																					 'conditions'=>array(
																										 'favorites.content_type="tweets" AND favorites.user_id='.$uid)));

		$this->set('favorites_on_Tweet',$favorites_on_Tweet);

		 }
	
	/***********************************   Retweeted tweets by user        **********/
	$retweeted_tweets = ClassRegistry::init('tweets')->find('all',array('fields'=>array('tweets.parent_id,tweets.id,tweets.user_id,users_profiles.firstname, users_profiles.lastname, users_profiles.handler, users_profiles.user_id'),
																						'joins'=>array(array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('tweets.user_id = users_profiles.user_id'))),
																						'conditions'=>array('tweets.parent_id !=0 AND (tweets.status=2 AND tweets.retweet=1)')));
		$this->set('retweeted_tweets',$retweeted_tweets);
		
	} // Session check
		
	else {
		
		$user_tweets = ClassRegistry::init('tweets')->find('all', array('fields' => array('
																				  tweets.tweet,
																				  tweets.id,
																				  tweets.user_id,
																				  tweets.photo,
																				  tweets.created,
																				  users_profiles.firstname,
																				  users_profiles.lastname,
																				  users_profiles.photo,
																				  users_profiles.user_id,
																				  users_profiles.handler,
																				  favorites.favorite,
																				  favorites.content_id,
																				  favorites.id ,
																				  favorites.user_id,
																				  count(favorites.favorite) as total_favorites
																				  '),
																'order'=>'tweets.id DESC',
																'limit'=>5,
																'joins'=>array(
																			   array('alias' => 'favorites',
																					 'table' => 'favorites',
																					 'type' => 'left',
																					 'foreignKey' => false,
																					 'conditions' => array('favorites.content_id = tweets.id '
																										   )
																					 ),
																			   array(
																					 'alias' => 'users_profiles',
																					 'table' => 'users_profiles',
																					 'type' => 'left',
																					 'foreignKey' => false,
																					 'conditions' => array('tweets.user_id = users_profiles.user_id')
																					 )
																			   ),
																'group'=>'tweets.id'));	
		
		
		$this->set('user_tweets', $user_tweets);
		
		$this->set('user_tweet_comments',$user_tweet_comments);
		/***********************************  Total reply on each tweet     **********/	
		$tweets_comments_count= ClassRegistry::init('Tweet_comment')->find('all', array('fields'=> array(
																								  'Tweet_comment.content_id,
																								  count(Tweet_comment.content_id) as commenttotal
																								  '),
																				'conditions'=>array('Tweet_comment.comment_type="tweets"'),
																				'order'=>'Tweet_comment.id DESC',
																				'group'=>'Tweet_comment.content_id'
																				)
																   );
		
	   $this->set('tweets_comments_count',$tweets_comments_count);	
		$this->render('bl_tweets');
	}
		
  }

  	public function get_tweets_ajax() {
			$this->params['pass'];
			$paramenter = $this->params['pass'];
			$lastid = $paramenter[0];
		if ($lastid) {
			if ($this->userInfo['users']['id']) {
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
				$result = $result.",".$uid;
		}
		else {
			
			$result = $uid;	
		}
		
		if ($result) {
				$user_tweets = ClassRegistry::init('tweets')->find('all', array('fields' => array('
																								  tweets.tweet,
																								  tweets.id,
																								  tweets.user_id,
																								  tweets.photo,
																								  tweets.created,
																								  users_profiles.firstname,
																								  users_profiles.lastname,
																								  users_profiles.photo,
																								  users_profiles.user_id,
																								  users_profiles.handler,
																								  favorites.favorite,
																								  favorites.content_id,
																								  favorites.id ,
																								  favorites.user_id,
																								  count(favorites.favorite) as total_favorites
																								  ')
																				,'order'=>'tweets.id DESC',
																				'limit'=>10,
																				'joins'=>array(
																							   array('alias' => 'favorites',
																									 'table' => 'favorites',
																									 'type' => 'left',
																									 'foreignKey' => false,
																									 'conditions' => array('favorites.content_id = tweets.id '
																														   )
																									 ),
																							   array('alias' => 'users_profiles',
																									 'table' => 'users_profiles',
																									 'type' => 'left',
																									 'foreignKey' => false,
																									 'conditions' => array('tweets.user_id = users_profiles.user_id'
																														   )
																									 )
																							   ),
																				'conditions'=>array(array('tweets.user_id IN ('.$result.')'),
																							   'tweets.parent_id =0 AND tweets.id <'.$lastid),
																				'group'=>'tweets.id'));	
				$this->set('user_tweets', $user_tweets);
				
				$tweets_retweeted_byUser = ClassRegistry::init('tweets')->find('all', array('fields' => array('
																											  tweets.parent_id,
																											  tweets.id,
																											  tweets.user_id,
																											  users_profiles.firstname,
																											  users_profiles.lastname,
																											  users_profiles.photo,
																											  users_profiles.tags,
																											  users_profiles.handler
																											  '
																											  ),
																							'joins'=>array(
																										   array('alias' => 'users_profiles',
																												 'table' => 'users_profiles',
																												 'type' => 'left',
																												 'foreignKey' => false,
																												 'conditions' => array('users_profiles.user_id = tweets.user_id'
																																	   )
																												 )
																										   ),
																							'order'=>'tweets.id DESC',
																							'conditions'=>array(array('tweets.user_id IN ('.$result.')'),
																																		  'tweets.parent_id !=0 AND 
																																		  tweets.retweet=1'
																																		  )			  
																							
																							)
																			   );
				$this->set('tweets_retweeted_byUser',$tweets_retweeted_byUser);
																							

		}
		
				$user_tweet_comments = ClassRegistry::init('Tweet_comment')->find('all', array('fields' => array('
																												 Tweet_comment.tweet_comment,
																												 Tweet_comment.id,
																												 Tweet_comment.content_id,
																												 Tweet_comment.created,
																												 Tweet_comment.user_id,
																												 users_profiles.firstname,
																												 users_profiles.lastname,
																												 users_profiles.photo,
																												 users_profiles.handler,
																												 users_profiles.user_id,
																												 users_profiles.tags,
																												 favorites.favorite,
																												 favorites.content_id,
																												 favorites.id,
																												 favorites.user_id
																												 '),
																							   'order'=>'Tweet_comment.id DESC',
																							   'joins'=>array(	
																											  array('alias' => 'favorites',
																													'table' => 'favorites',
																													'type' => 'left',
																													'foreignKey' => false,
																												    'conditions' => array('Tweet_comment.id  = favorites.content_id'
																																	  )
																												),
																											  array('alias' => 'users_profiles',
																													'table' => 'users_profiles',
																													'type' => 'left',
																													'foreignKey' => false,
																										'conditions' => array('Tweet_comment.user_id = users_profiles.user_id'
																															  )
																										)
																											  ),
																							   'conditions'=>array('Tweet_comment.comment_type = "tweets"'
																																	),
																							   'group' => 'Tweet_comment.id'));																																													
		$this->set('user_tweet_comments',$user_tweet_comments);
		
			
			/***********************************  Total reply on each tweet     **********/	
		$tweets_comments_count= ClassRegistry::init('Tweet_comment')->find('all', array('fields'=> array(
																								  'Tweet_comment.content_id,
																								  count(Tweet_comment.content_id) as commenttotal
																								  '),
																				'conditions'=>array('Tweet_comment.comment_type="tweets"'),
																				'order'=>'Tweet_comment.id DESC',
																				'group'=>'Tweet_comment.content_id'
																				)
																   );
		
	   $this->set('tweets_comments_count',$tweets_comments_count);	
		 /***********************************    Likes on updates in home page        **********/
		 if ($uid) {
		$favorites_on_Tweet = ClassRegistry::init('favorites')->find('all', array('fields'=>array('favorites.user_id,favorites.favorite,favorites.content_id'),
																								   'order'=>'favorites.id',
																					 'conditions'=>array(
																										 'favorites.content_type="tweets" AND favorites.user_id='.$uid)));

		$this->set('favorites_on_Tweet',$favorites_on_Tweet);

		 }

	/***********************************   Retweeted tweets by user        **********/
	$retweeted_tweets = ClassRegistry::init('tweets')->find('all',array('fields'=>array('tweets.parent_id,tweets.id,tweets.user_id,users_profiles.firstname, users_profiles.lastname, users_profiles.handler, users_profiles.user_id'),
																						'joins'=>array(array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('tweets.user_id = users_profiles.user_id'))),
																						'conditions'=>array('tweets.parent_id !=0 AND (tweets.status=2 AND tweets.retweet=1)')));
		$this->set('retweeted_tweets',$retweeted_tweets);
		
		$this->autorender = false;
	    $this->layout = false;
	    $this->render('get_tweets_ajax');
		
		} // Session Check condition end
		else {
			
		$user_tweets = ClassRegistry::init('tweets')->find('all', array('fields' => array('
																								  tweets.tweet,
																								  tweets.id,
																								  tweets.user_id,
																								  tweets.photo,
																								  tweets.created,
																								  users_profiles.firstname,
																								  users_profiles.lastname,
																								  users_profiles.photo,
																								  users_profiles.user_id,
																								  users_profiles.handler,
																								  favorites.favorite,
																								  favorites.content_id,
																								  favorites.id ,
																								  favorites.user_id,
																								  count(favorites.favorite) as total_favorites
																								  ')
																				,'order'=>'tweets.id DESC',
																				'limit'=>10,
																				'joins'=>array(
																							   array('alias' => 'favorites',
																									 'table' => 'favorites',
																									 'type' => 'left',
																									 'foreignKey' => false,
																									 'conditions' => array('favorites.content_id = tweets.id '
																														   )
																									 ),
																							   array('alias' => 'users_profiles',
																									 'table' => 'users_profiles',
																									 'type' => 'left',
																									 'foreignKey' => false,
																									 'conditions' => array('tweets.user_id = users_profiles.user_id'
																														   )
																									 )
																							   ),
																				'conditions'=>array('tweets.parent_id =0 AND tweets.id <'.$lastid),
																				'group'=>'tweets.id'));	
				$this->set('user_tweets', $user_tweets);
				
				$tweets_comments_count= ClassRegistry::init('Tweet_comment')->find('all', array('fields'=> array(
																								  'Tweet_comment.content_id,
																								  count(Tweet_comment.content_id) as commenttotal
																								  '),
																				'conditions'=>array('Tweet_comment.comment_type="tweets"'),
																				'order'=>'Tweet_comment.id DESC',
																				'group'=>'Tweet_comment.content_id'
																				)
																   );
		
	   $this->set('tweets_comments_count',$tweets_comments_count);	
				
				$this->autorender = false;
	    		$this->layout = false;
	    		$this->render('bl_get_tweets_ajax');
			
		}
		
			
		} // lastid condition end
		
	}

	public function add_tweet() {
	  if ($this->userInfo['users']['id']) {
		  $error = 0;
		if ($this->request->is('post')) {
			$user_id = $_POST["user_id"];
			$photo = $_FILES["photo"];
			$status = $_POST["status"];
			$tweets = $_POST["tweet"];
			$this->request->data = '';
			
				$uid = $this->userInfo['users']['id'];
				$this->request->data['Tweet']['user_id'] = $user_id;
				$this->request->data['Tweet']['status'] = $status;
				$this->request->data['Tweet']['tweet'] = $tweets;
				$this->request->data['Tweet']['photo'] = $filename['name'];
				$date_created = date("Y-m-d H:i:s");
				$this->request->data['Tweet']['created'] = $date_created;
				$this->request->data['Tweet']['modified_by'] = $uid;
				$this->request->data['Tweet']['photo'] = $photo;
							/*file uploading*/
			$filename = $this->request->data['Tweet']['photo'];
			$photo = $this->request->data['Tweet']['photo'];
			$imagename = $filename['name'];
			$typess = $filename['type'];
			
			$uploadFolder = "files/tweet/original";
			$uploadPath = MEDIA_PATH . $uploadFolder;
			  if ($filename['name']) {
				if ($filename['type'] == "image/gif" || $filename['type'] == "image/jpeg" || $filename['type'] == "image/png" || $filename['type'] == "image/jpg") {
					$imageName = $filename['name'];
					if (file_exists($uploadPath . '/' . $imageName)) {
						$imageName = date('His') . $imageName;
						}
					
					$full_image_path = $uploadPath . '/' . $imageName;
					$this->request->data['Tweet']['photo'] = $imageName;
					if (move_uploaded_file($filename['tmp_name'], $full_image_path)) {
				  		$data['photo'] = $this->request->data['Tweet']['photo'];
						 $this->request->data['Tweet']['photo'] = $data['photo'];
					} 
					else {
						$mesg = "There was a problem uploading file. Please try again.";
						$error = 1;
					}
				}
				else {
						$mesg = "Unacceptable file type.";
						$error = 1;
				}
			  }
			
			
			//$this->loadModel('Tweet');
			$this->loadModel('Favorite');
			if ($error == 0) {
			if ($this->Tweet->save($this->request->data)) {
					$lastid = $this->Tweet->getInsertID();
					$this->request->data = '';
					$this->request->data['Favorite']['content_type'] = 'tweets';
					$this->request->data['Favorite']['created'] = date("Y-m-d H:i:s");
					$this->request->data['Favorite']['favorite'] = 1;
					$this->request->data['Favorite']['user_id'] = $uid;
					$this->request->data['Favorite']['content_id'] = $lastid;
					if (ClassRegistry::init('Favorite')->save($this->request->data)) {
						$mesg = "Your tweet has been added successfully";
						$this->Session->setFlash($mesg,'success_msg');
						$this->redirect(array('controller' => 'tweets', 'action' => 'index'));
					}
					else {
						
						$mesg = "Tweet Favorite does not submitted, try again.";
					    $this->Session->setFlash($mesg,'error_msg');
						$this->redirect(array('controller' => 'tweets', 'action' => 'index'));
					}
			}
			else {
						
					$mesg = "Tweet does not saved, try again.";
					$this->Session->setFlash($mesg,'error_msg');
					$this->redirect(array('controller' => 'tweets', 'action' => 'index'));
			}
		}
		else {
			$this->Session->setFlash($mesg,'error_msg');
			$this->redirect(array('controller' => 'tweets', 'action' => 'index'));
			}
		}
	}

  }
  /* Tweet user profile*/
	public function profile() {
		if ($this->userInfo['users']['id']) {
			//$user_Array = $this->Session->read(@$userid);
			
			if ($this->params['pass']) {
				$paramenter = $this->params['pass'];
				$uid = $paramenter[0];
				$this->set('userID',$uid);	
			}
			else {
				$uid = $this->userInfo['users']['id'];
				$this->set('userID',$uid);
			}
		}
		if ($uid) {
			
					/***********************************Retweeted tweets by you **********/
	$retweeted_tweets_byU = ClassRegistry::init('tweets')->find('all',array('fields'=>array('tweets.parent_id,tweets.user_id'),
																					'conditions'=>array('tweets.parent_id !=0 AND tweets.status=2 AND tweets.user_id='.$uid)));
		$this->set('retweeted_tweets_byU',$retweeted_tweets_byU);

		foreach ($retweeted_tweets_byU as $retweeted_by_U) {
			
			$content_array[] = $retweeted_by_U['tweets']['parent_id'];
		}
		if ($content_array) {
			
			$content_IDS = @implode(',',$content_array);
		}
		if ($content_IDS) {
			$profile_tweets = ClassRegistry::init('tweets')->find('all', array('fields' => array('
																								 tweets.tweet,
																								 tweets.id,
																								 tweets.photo,
																								 tweets.created,
																								 tweets.modified,
																								 tweets.user_id,
																								 users_profiles.firstname,
																								 users_profiles.lastname,
																								 users_profiles.photo,
																								 users_profiles.user_id,
																								 users_profiles.handler,
																								 favorites.favorite,
																								 favorites.content_id,
																								 favorites.id ,
																								 favorites.user_id,
																								 count(favorites.favorite) as total_favorites
																								 '),
																			   'order'=>'tweets.modified DESC',
																			   'joins'=>array(
																							  array('alias' => 'favorites',
																									'table' => 'favorites',
																									'type' => 'left',
																									'foreignKey' => false,
																									'conditions' => array('favorites.content_id = tweets.id
																														  ')
																									),
																							  array('alias' => 'users_profiles',
																									'table' => 'users_profiles',
																									'type' => 'left',
																									'foreignKey' => false, 
																									'conditions' => array('tweets.user_id = users_profiles.user_id'
																														  )
																									)
																							  ),
																			   'conditions'=>array('OR'=>array(array('tweets.id IN('.$content_IDS.')'),
																																   'tweets.user_id ='.$uid.' AND
																																   tweets.parent_id=0')),'group'=>'tweets.id'
																			   )
																  );
			
		}
		else {
			
			$profile_tweets = ClassRegistry::init('tweets')->find('all', array('fields' => array('
																								 tweets.tweet,
																								 tweets.id,
																								 tweets.photo,
																								 tweets.created,
																								 users_profiles.firstname,
																								 users_profiles.lastname,
																								 users_profiles.photo,
																								 users_profiles.user_id,
																								 users_profiles.handler,
																								 favorites.favorite,
																								 favorites.content_id,
																								 favorites.id ,
																								 favorites.user_id,
																								 count(favorites.favorite) as total_favorites
																								 '),
																			   'order'=>'tweets.id DESC',
																			   'joins'=>array(
																							  array('alias' => 'favorites',
																									'table' => 'favorites',
																									'type' => 'left',
																									'foreignKey' => false,
																									'conditions' => array('favorites.content_id = tweets.id '
																														  )
																									),
																							  array('alias' => 'users_profiles',
																									'table' => 'users_profiles', 
																									'type' => 'left',
																									'foreignKey' => false,
																									'conditions' => array('tweets.user_id = users_profiles.user_id'
																														  )
																									)
																							  ),
																			   'conditions'=>array('tweets.user_id ='.$uid.' AND tweets.parent_id=0'),'group'=>'tweets.id'
																			   )
																  );
			
			
			
			
			
		}

		$this->set('profile_tweets',$profile_tweets);
		
		/*************Total tweets counts START***************/
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
				$result =$result.",".$uid;
		}
		else {
			
			$result = $uid;	
		}

		
		if ($result) {
			$total_tweets = ClassRegistry::init('tweets')->find('all', array('fields' => array('tweets.id'),'conditions'=>array(array('tweets.user_id IN ('.$result.')'),
																																		  'tweets.parent_id =0'
																																		  )
																								   )
																	);
				$this->set('total_tweets',sizeof($total_tweets));
		}
		
		/*************Total tweets counts END***************/
		
		/***retweet by whome***/
		if ($result) {
			$tweets_retweeted_byUser = ClassRegistry::init('tweets')->find('all', array('fields' => array('
																											  tweets.parent_id,
																											  tweets.id,
																											  tweets.user_id,
																											  users_profiles.firstname,
																											  users_profiles.lastname,
																											  users_profiles.photo,
																											  users_profiles.tags,
																											  users_profiles.user_id,
																											  users_profiles.handler
																											  '
																											  ),
																							'joins'=>array(
																										   array('alias' => 'users_profiles',
																												 'table' => 'users_profiles',
																												 'type' => 'left',
																												 'foreignKey' => false,
																												 'conditions' => array('users_profiles.user_id = tweets.user_id'
																																	   )
																												 )
																										   ),
																							'order'=>'tweets.id DESC',
																							'conditions'=>array(array('tweets.user_id IN ('.$result.')'),
																																		  'tweets.parent_id !=0 AND 
																																		  tweets.retweet=1'
																																		  )			  
																							
																							)
																			   );
				$this->set('tweets_retweeted_byUser',$tweets_retweeted_byUser);
		}
		
		/***********************************   Retweeted tweets by user **********/
	$retweeted_tweets = ClassRegistry::init('tweets')->find('all',array('fields'=>array('
																						tweets.parent_id,
																						tweets.id,
																						tweets.user_id,
																						users_profiles.firstname,
																						users_profiles.lastname,
																						users_profiles.handler,
																						users_profiles.user_id
																						'),
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
		$this->set('retweeted_tweets',$retweeted_tweets);

		
				/***********************************  Total reply on each tweet     **********/	
		$tweets_comments_count= ClassRegistry::init('Tweet_comment')->find('all', array('fields'=> array(
																								  'Tweet_comment.content_id,
																								  count(Tweet_comment.content_id) as commenttotal
																								  '),
																				'conditions'=>array('Tweet_comment.comment_type="tweets"'),
																				'order'=>'Tweet_comment.id DESC',
																				'group'=>'Tweet_comment.content_id'
																				)
																   );
		
	   $this->set('tweets_comments_count',$tweets_comments_count);
		
		 /***********************************    favorites on tweet page        **********/
		$favorites_on_Tweet = ClassRegistry::init('favorites')->find('all', array('fields'=>array('favorites.user_id,favorites.favorite,favorites.content_id'),
																								   'order'=>'favorites.id',
																					 'conditions'=>array(
																										 'favorites.content_type="tweets" AND favorites.user_id='.$uid)));

		$this->set('favorites_on_Tweet',$favorites_on_Tweet);
		
							/*user friends  start*/	
	$reqUser = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),
																					'conditions'=>array('(connections.user_id='.$uid.' OR connections.friend_id='.$uid.') AND connections.request=1')));
			
		foreach ($reqUser as $rfid) {
				if ($rfid['connections']['friend_id'] != $uid) {
					$comResult[] .= $rfid['connections']['friend_id'];
				}
				if ($rfid['connections']['user_id'] != $uid) {
					$comResult[] .= $rfid['connections']['user_id'];
				} 
		}
		/*user friends  end*/
		if($comResult){
			if (sizeof($comResult)>1) {
			 	$result =@implode(',',$comResult);
			}
			else {
					foreach ($comResult as $key=>$value) {
									$result = $value;
						}	
			}
			$result =$result.",".$uid;
		}
		else {
			$result = $uid;	
		}
				
				$user_tweet_comments = ClassRegistry::init('Tweet_comment')->find('all', array('fields' => array('
																												 Tweet_comment.tweet_comment,
																												 Tweet_comment.content_id,
																												 Tweet_comment.created,
																												 Tweet_comment.user_id,
																												 Tweet_comment.id,
																												 users_profiles.firstname,
																												 users_profiles.lastname,
																												 users_profiles.photo,
																												 users_profiles.handler,
																												 users_profiles.user_id,
																												 users_profiles.tags,
																												 favorites.favorite,
																												 favorites.content_id,
																												 favorites.id,
																												 favorites.user_id
																												 '),
																							   'order'=>'Tweet_comment.id DESC',
																							   'joins'=>array(
																											  array('alias' => 'favorites',
																													'table' => 'favorites',
																													'type' => 'left',
																													'foreignKey' => false, 
																													'conditions' => array('Tweet_comment.id  = favorites.content_id'
																																		  )
																													),
																											  array('alias' => 'users_profiles',
																													'table' => 'users_profiles',
																													'type' => 'left',
																													'foreignKey' => false,
																													'conditions' => array('Tweet_comment.user_id = users_profiles.user_id'
																																		  )
																													)
																											  ),
																							   'conditions'=>array('Tweet_comment.comment_type = "tweets"'),'group' => 'Tweet_comment.id'
																							   )
																				  );																																													
		$this->set('user_tweet_comments',$user_tweet_comments);
		
		/*Tweet count for current user*/
	$tweets_count_added_user= ClassRegistry::init('tweets')->find('all',
																array('conditions'=>array('tweets.user_id='.$uid.' AND tweets.status=2')));
		
	$this->set('tweets_count_added_user',sizeof($tweets_count_added_user));

					/**************************************      To show user following and followers          ***********************/
				$userFollowings = ClassRegistry::init('users_followings')->find('all' ,array('fields'=>array('users_followings.id,users_followings.status, count(users_followings.following_id) as total_following'),'conditions'=>array('users_followings.user_id='.$uid.' AND users_followings.following_type="users" AND users_followings.status=2')));
		
		$userFollows = ClassRegistry::init('users_followings')->find('all' ,array('fields'=>array('users_followings.id,users_followings.status ,count(users_followings.user_id) as total_follow'),'conditions'=>array('users_followings.following_id='.$uid.' AND users_followings.following_type="users" AND users_followings.status=2')));
		
		
		$userFollowingsbyYou = $userFollowings[0][0];
		$userFollowingsbyYou = $userFollowingsbyYou['total_following'];
		$this->set('following',$userFollowingsbyYou);
		
		$userFollowYou = $userFollows[0][0];
		$userFollowYou = $userFollowYou['total_follow'];
		$this->set('followers',$userFollowYou);
		$x_users_profile = $this->getCurrentUser($uid);	
		$this->set('userName',$x_users_profile);
		
		}
	}
	
	/*User tweets added by user own*/
	public function user_tweets() {
			if ($this->request->is('get')) {
				$user_id = $_GET['user_id'];
	
	/***********************************Retweeted tweets by you **********/
	$retweeted_tweets_byU = ClassRegistry::init('tweets')->find('all',array('fields'=>array('tweets.parent_id,tweets.user_id'),
																							'conditions'=>array('tweets.parent_id !=0 AND tweets.status=2 AND (tweets.user_id='.$user_id.' AND tweets.retweet=1)')));
		$this->set('retweeted_tweets_byU',$retweeted_tweets_byU);
		foreach ($retweeted_tweets_byU as $retweeted_by_U) {
			
			$content_array[] = $retweeted_by_U['tweets']['parent_id'];
		}
		if ($content_array) {
			
			$content_IDS = @implode(',',$content_array);
		}
		if ($content_IDS) {
			$curent_user_added_tweets = ClassRegistry::init('tweets')->find('all', array('fields' => array('
																										   	 tweets.tweet,
																											 tweets.id,
																											 tweets.photo,
																											 tweets.user_id,
																											 tweets.created,
																											 users_profiles.firstname,
																											 users_profiles.lastname,
																											 users_profiles.photo,
																											 users_profiles.user_id,
																											 users_profiles.handler,
																											 favorites.favorite,
																											 favorites.content_id,
																											 favorites.id ,
																											 favorites.user_id,
																											 count(favorites.favorite) as total_favorites
																										   '),
																						 'order'=>'tweets.id DESC',
																						 'joins'=>array(
																										array('alias' => 'favorites',
																											  'table' => 'favorites',
																											  'type' => 'left',
																											  'foreignKey' => false,
																											  'conditions' => array('favorites.content_id = tweets.id '
																																	)
																											  ),
																										array('alias' => 'users_profiles',
																											  'table' => 'users_profiles',
																											  'type' => 'left',
																											  'foreignKey' => false,
																											  'conditions' => array('tweets.user_id = users_profiles.user_id'
																																	)
																											  )
																										),
																						 'conditions'=>array('OR'=>array(array('tweets.id IN('.$content_IDS.')'),'tweets.user_id ='.$user_id.' AND tweets.parent_id=0')),'group'=>'tweets.id'
																						 )
																			);
			
		}
		else {
			$curent_user_added_tweets = ClassRegistry::init('tweets')->find('all', array('fields' =>array('
																										  	 tweets.tweet,
																											 tweets.id,
																											 tweets.photo,
																											 tweets.user_id,
																											 tweets.created,
																											 users_profiles.firstname,
																											 users_profiles.lastname,
																											 users_profiles.photo,
																											 users_profiles.user_id,
																											 users_profiles.handler,
																											 favorites.favorite,
																											 favorites.content_id,
																											 favorites.id ,
																											 favorites.user_id,
																											 count(favorites.favorite) as total_favorites
																										  '),
																						 'order'=>'tweets.id DESC',	
																						 'joins'=>array(
																										array('alias' => 'favorites',
																											  'table' => 'favorites',
																											  'type' => 'left',
																											  'foreignKey' => false, 
																											  'conditions' => array('favorites.content_id = tweets.id '
																																	)
																											  ),
																										array('alias' => 'users_profiles',
																											  'table' => 'users_profiles',
																											  'type' => 'left',
																											  'foreignKey' => false,
																											  'conditions' => array('tweets.user_id = users_profiles.user_id'
																																	)
																											  )
																										),
																						 'conditions'=>array('tweets.user_id ='.$user_id.' AND tweets.parent_id=0'),'group'=>'tweets.id'
																						 )
																			);
		}
		
		$this->set('curent_user_added_tweets',$curent_user_added_tweets);
		
		/*user friends  start*/	
	$reqUser = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),
																					'conditions'=>array('(connections.user_id='.$user_id.' OR connections.friend_id='.$user_id.') AND connections.request=1')));
			
		foreach ($reqUser as $rfid) {
				if ($rfid['connections']['friend_id'] != $user_id) {
					$comResult[] .= $rfid['connections']['friend_id'];
				}
				if ($rfid['connections']['user_id'] != $user_id) {
					$comResult[] .= $rfid['connections']['user_id'];
				} 
		}
		/*user friends  end*/
		
		if($comResult){
			if (sizeof($comResult)>1) {
			 	$result =@implode(',',$comResult);
			}
				else {
						foreach ($comResult as $key=>$value) {
									$result = $value;
						}
				}
				
				$user_tweet_comments = ClassRegistry::init('Tweet_comment')->find('all', array('fields' => array('
																												 Tweet_comment.tweet_comment,
																												 Tweet_comment.content_id,
																												 Tweet_comment.created,
																												 Tweet_comment.id,
																												 users_profiles.firstname,
																												 users_profiles.lastname,
																												 users_profiles.photo,
																												 users_profiles.handler,
																												 users_profiles.user_id,
																												 users_profiles.tags,
																												 favorites.favorite,
																												 favorites.content_id,
																												 favorites.id,
																												 favorites.user_id
																												 '),
																							   'order'=>'Tweet_comment.id DESC',
																							   'joins'=>array(
																											  array('alias' => 'favorites',
																													'table' => 'favorites',
																													'type' => 'left',
																													'foreignKey' => false,
																													'conditions' => array('Tweet_comment.id  = favorites.content_id'
																																		  )
																													),
																											  array('alias' => 'users_profiles',
																													'table' => 'users_profiles',
																													'type' => 'left',
																													'foreignKey' => false,
																													'conditions' => array('Tweet_comment.user_id = users_profiles.user_id'
																																		  )
																													)
																											  ),
																							   'conditions'=>array(
																												   array('Tweet_comment.user_id IN ('.$result.','.$user_id.')'),
																												   'Tweet_comment.comment_type = "tweets"'),
																							   'group' => 'Tweet_comment.id'
																							   )
																				  );																																													
 		
		$this->set('user_tweet_comments',$user_tweet_comments);
		}
		
		/***********************************  Total reply on each tweet     **********/	
		$tweets_comments_count= ClassRegistry::init('Tweet_comment')->find('all', array('fields'=> array(
																								  'Tweet_comment.content_id,
																								  count(Tweet_comment.content_id) as commenttotal
																								  '),
																				'conditions'=>array('Tweet_comment.comment_type="tweets"'),
																				'order'=>'Tweet_comment.id DESC',
																				'group'=>'Tweet_comment.content_id'
																				)
																   );
		
	   $this->set('tweets_comments_count',$tweets_comments_count);	
			/***********************************   Retweeted tweets by user        **********/
	$retweeted_tweets = ClassRegistry::init('tweets')->find('all',array('fields'=>array('tweets.parent_id,tweets.id,tweets.user_id,users_profiles.firstname, users_profiles.lastname, users_profiles.handler, users_profiles.user_id'),
																						'joins'=>array(array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('tweets.user_id = users_profiles.user_id'))),
																						'conditions'=>array('tweets.parent_id !=0 AND tweets.status=2')));
		$this->set('retweeted_tweets',$retweeted_tweets);
		
		
		 if ($user_id) {
		$favorites_on_Tweet = ClassRegistry::init('favorites')->find('all', array('fields'=>array('favorites.user_id,favorites.favorite,favorites.content_id'),
																								   'order'=>'favorites.id',
																					 'conditions'=>array(
																										 'favorites.content_type="tweets" AND favorites.user_id='.$user_id)));

		$this->set('favorites_on_Tweet',$favorites_on_Tweet);
		
		/*Tweet count for current user*/
	$tweets_count_added_user= ClassRegistry::init('tweets')->find('all',
																array('conditions'=>array('tweets.user_id='.$user_id.' AND tweets.status=2')));
		
	$this->set('tweets_count_added_user',sizeof($tweets_count_added_user));

					/**************************************      To show user following and followers          ***********************/
				$userFollowings = ClassRegistry::init('users_followings')->find('all' ,array('fields'=>array('users_followings.id,users_followings.status, count(users_followings.following_id) as total_following'),'conditions'=>array('users_followings.user_id='.$user_id.' AND users_followings.following_type="users" AND users_followings.status=2')));
		
		$userFollows = ClassRegistry::init('users_followings')->find('all' ,array('fields'=>array('users_followings.id,users_followings.status ,count(users_followings.user_id) as total_follow'),'conditions'=>array('users_followings.following_id='.$user_id.' AND users_followings.following_type="users" AND users_followings.status=2')));
		
		
		$userFollowingsbyYou = $userFollowings[0][0];
		$userFollowingsbyYou = $userFollowingsbyYou['total_following'];
		$this->set('following',$userFollowingsbyYou);
		
		$userFollowYou = $userFollows[0][0];
		$userFollowYou = $userFollowYou['total_follow'];
		$this->set('followers',$userFollowYou);		
		$this->set('userName',$this->userInfo['users_profiles']);

		 }
		
		
		$this->autorender = false;
	    $this->layout = false;
	    $this->render('user_tweets');
		}
	}
	
	/* Tweeter User following */
	public function user_following() {
			if ($this->request->is('get')) {
				$user_id = $_GET['user_id'];
				
				$userFollowings = ClassRegistry::init('users_followings')->find('all' ,array(
																							 'fields'=>array('users_followings.id, users_profiles.firstname, users_profiles.lastname , users_profiles.photo, users_profiles.handler,users_profiles.user_id,users_profiles.tags'),
																							 'joins'=>array(array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('users_followings.following_id = users_profiles.user_id'))),
																							 'conditions'=>array('users_followings.user_id='.$user_id.' AND users_followings.following_type="users" AND users_followings.status=2')));
				$this->set('userFollowings',$userFollowings);
				
				/*Tweet count for current user*/
	$tweets_count_added_user= ClassRegistry::init('tweets')->find('all',
																array('conditions'=>array('tweets.user_id='.$user_id.' AND tweets.status=2')));
		
	$this->set('tweets_count_added_user',sizeof($tweets_count_added_user));

					/**************************************      To show user following and followers          ***********************/
				$userFollowings = ClassRegistry::init('users_followings')->find('all' ,array('fields'=>array('users_followings.id,users_followings.status, count(users_followings.following_id) as total_following'),'conditions'=>array('users_followings.user_id='.$user_id.' AND users_followings.following_type="users" AND users_followings.status=2')));
		
		$userFollows = ClassRegistry::init('users_followings')->find('all' ,array('fields'=>array('users_followings.id,users_followings.status ,count(users_followings.user_id) as total_follow'),'conditions'=>array('users_followings.following_id='.$user_id.' AND users_followings.following_type="users" AND users_followings.status=2')));
		
		
		$userFollowingsbyYou = $userFollowings[0][0];
		$userFollowingsbyYou = $userFollowingsbyYou['total_following'];
		$this->set('following',$userFollowingsbyYou);
		
		$userFollowYou = $userFollows[0][0];
		$userFollowYou = $userFollowYou['total_follow'];
		$this->set('followers',$userFollowYou);		
		$this->set('userName',$this->userInfo['users_profiles']);
			}
		$this->autorender = false;
	    $this->layout = false;
	    $this->render('user_following');
	}
	
		/* Tweeter User followers you*/
	public function user_followers() {
			if ($this->request->is('get')) {
				$user_id = $_GET['user_id'];
				
				$userFollowers = ClassRegistry::init('users_followings')->find('all' ,array(
																							 'fields'=>array('users_followings.id, users_profiles.firstname, users_profiles.lastname , users_profiles.photo, users_profiles.handler,users_profiles.user_id,users_profiles.tags'),
																							 'joins'=>array(array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('users_followings.user_id = users_profiles.user_id'))),
																							 'conditions'=>array('users_followings.following_id='.$user_id.' AND users_followings.following_type="users" AND users_followings.status=2')));
				$this->set('userFollowers',$userFollowers);
				
				/*Tweet count for current user*/
	$tweets_count_added_user= ClassRegistry::init('tweets')->find('all',
																array('conditions'=>array('tweets.user_id='.$user_id.' AND tweets.status=2')));
		
	$this->set('tweets_count_added_user',sizeof($tweets_count_added_user));

					/**************************************      To show user following and followers          ***********************/
				$userFollowings = ClassRegistry::init('users_followings')->find('all' ,array('fields'=>array('users_followings.id,users_followings.status, count(users_followings.following_id) as total_following'),'conditions'=>array('users_followings.user_id='.$user_id.' AND users_followings.following_type="users" AND users_followings.status=2')));
		
		$userFollows = ClassRegistry::init('users_followings')->find('all' ,array('fields'=>array('users_followings.id,users_followings.status ,count(users_followings.user_id) as total_follow'),'conditions'=>array('users_followings.following_id='.$user_id.' AND users_followings.following_type="users" AND users_followings.status=2')));
		
		
		$userFollowingsbyYou = $userFollowings[0][0];
		$userFollowingsbyYou = $userFollowingsbyYou['total_following'];
		$this->set('following',$userFollowingsbyYou);
		
		$userFollowYou = $userFollows[0][0];
		$userFollowYou = $userFollowYou['total_follow'];
		$this->set('followers',$userFollowYou);		
		$this->set('userName',$this->userInfo['users_profiles']);
			}
		$this->autorender = false;
	    $this->layout = false;
	    $this->render('user_followers');
	}
	
	
	/*User tweets added by user own*/
	public function user_favorites() {
			if ($this->request->is('get')) {
				$user_id = $_GET['user_id'];

			$tweet_favorites = ClassRegistry::init('tweets')->find('all', array('fields' => array('tweets.tweet,tweets.photo, tweets.created ,users_profiles.firstname, users_profiles.lastname,users_profiles.photo,users_profiles.user_id,users_profiles.handler,favorites.favorite,favorites.content_id,favorites.id ,favorites.user_id'),'order'=>'favorites.id DESC',																																																																																																	   'joins'=>array(																																																  array('alias' => 'favorites', 'table' => 'favorites', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('favorites.content_id = tweets.id ')),																																																																																																																												   array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('tweets.user_id = users_profiles.user_id'))),																																																															'conditions'=>array('favorites.user_id ='.$user_id.' AND favorites.content_type="tweets"')));
		
		$this->set('tweet_favorites',$tweet_favorites);
		
		/*user friends  start*/	
	$reqUser = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),
																					'conditions'=>array('(connections.user_id='.$user_id.' OR connections.friend_id='.$user_id.') AND connections.request=1')));
			
		foreach ($reqUser as $rfid) {
				if ($rfid['connections']['friend_id'] != $user_id) {
					$comResult[] .= $rfid['connections']['friend_id'];
				}
				if ($rfid['connections']['user_id'] != $user_id) {
					$comResult[] .= $rfid['connections']['user_id'];
				} 
		}
		/*user friends  end*/
		
		if($comResult){
			if (sizeof($comResult)>1) {
			 	$result =@implode(',',$comResult);
			}
				else {
						foreach ($comResult as $key=>$value) {
									$result = $value;
						}
				}
				
				$user_tweet_comments = ClassRegistry::init('Tweet_comment')->find('all', array('fields' => array('
																												 Tweet_comment.tweet_comment,
																												 Tweet_comment.content_id,
																												 Tweet_comment.created,
																												 users_profiles.firstname,
																												 users_profiles.lastname,
																												 users_profiles.photo,
																												 users_profiles.handler,
																												 users_profiles.user_id,
																												 users_profiles.tags,
																												 favorites.favorite,
																												 favorites.content_id,
																												 favorites.id,
																												 favorites.user_id
																												 '),
																							   'order'=>'Tweet_comment.id DESC',
																							   'joins'=>array(
																											  array('alias' => 'favorites',
																													'table' => 'favorites',
																													'type' => 'left',
																													'foreignKey' => false,
																													'conditions' => array('Tweet_comment.id  = favorites.content_id'
																																		  )
																													),
																											  array('alias' => 'users_profiles',
																													'table' => 'users_profiles',
																													'type' => 'left',
																													'foreignKey' => false,
																													'conditions' => array('Tweet_comment.user_id = users_profiles.user_id'
																																		  )
																													)
																											  ),
																							   'conditions'=>array(
																												   array('Tweet_comment.user_id IN ('.$result.','.$user_id.')'),
																												   'Tweet_comment.comment_type = "tweets"'),
																							   'group' => 'Tweet_comment.id'
																							   )
																				  );																																													
 		
		$this->set('user_tweet_comments',$user_tweet_comments);
		}
		
			/***********************************   Retweeted tweets by user        **********/
	$retweeted_tweets = ClassRegistry::init('tweets')->find('all',array('fields'=>array('tweets.parent_id,tweets.id,tweets.user_id,users_profiles.firstname, users_profiles.lastname, users_profiles.handler, users_profiles.user_id'),
																						'joins'=>array(array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('tweets.user_id = users_profiles.user_id'))),
																						'conditions'=>array('tweets.parent_id !=0 AND tweets.status=2')));
		$this->set('retweeted_tweets',$retweeted_tweets);
		
		
		 if ($user_id) {
		$favorites_on_Tweet = ClassRegistry::init('favorites')->find('all', array('fields'=>array('favorites.user_id,favorites.favorite,favorites.content_id'),
																								   'order'=>'favorites.id',
																					 'conditions'=>array(
																										 'favorites.content_type="tweets" AND favorites.user_id='.$user_id)));

		$this->set('favorites_on_Tweet',$favorites_on_Tweet);
		
		/*Tweet count for current user*/
	$tweets_count_added_user= ClassRegistry::init('tweets')->find('all',
																array('conditions'=>array('tweets.user_id='.$user_id.' AND tweets.status=2')));
		
	$this->set('tweets_count_added_user',sizeof($tweets_count_added_user));

					/**************************************      To show user following and followers          ***********************/
				$userFollowings = ClassRegistry::init('users_followings')->find('all' ,array('fields'=>array('users_followings.id,users_followings.status, count(users_followings.following_id) as total_following'),'conditions'=>array('users_followings.user_id='.$user_id.' AND users_followings.following_type="users" AND users_followings.status=2')));
		
		$userFollows = ClassRegistry::init('users_followings')->find('all' ,array('fields'=>array('users_followings.id,users_followings.status ,count(users_followings.user_id) as total_follow'),'conditions'=>array('users_followings.following_id='.$user_id.' AND users_followings.following_type="users" AND users_followings.status=2')));
		
		
		$userFollowingsbyYou = $userFollowings[0][0];
		$userFollowingsbyYou = $userFollowingsbyYou['total_following'];
		$this->set('following',$userFollowingsbyYou);
		
		$userFollowYou = $userFollows[0][0];
		$userFollowYou = $userFollowYou['total_follow'];
		$this->set('followers',$userFollowYou);		
		$this->set('userName',$this->userInfo['users_profiles']);

		 }
		
		
		$this->autorender = false;
	    $this->layout = false;
	    $this->render('user_favorites');
		}
	}
	
	
	/* Tweeter User Comments adding*/
	public function add_tweet_replay() {
			if ($this->request->is('get')) {
				$user_id = $_GET['user_id'];
				$content_id = $_GET['content_id'];
				$comment_type = $_GET['comment_type'];
				$created = $_GET['created'];
				$tweet_reply = $_GET['tweet_reply'];
				$tweet_admin = $_GET['tweet_admin'];
				$this->loadModel('Tweet_comment');
				$this->request->data['Tweet_comment']['user_id'] = $user_id;
				$this->request->data['Tweet_comment']['comment_type'] = $comment_type;
				$this->request->data['Tweet_comment']['content_id'] = $content_id;
				$this->request->data['Tweet_comment']['created'] = $created;
				$this->request->data['Tweet_comment']['modified'] = $created;
				$this->request->data['Tweet_comment']['tweet_comment'] = $tweet_reply;
				$this->set('tweet_admin',$tweet_admin);
				$this->set('content_id',$content_id);
				 if ($this->Tweet_comment->save($this->request->data)) {
					$this->Session->setFlash('User successfully saved.');
					$tweet_comment_id = $this->Tweet_comment->getInsertID(); 
				 }
				 else {
					 
					 echo "Tweet replay not saved";
					 exit;
				 }
			} // post tweet replay end
			
			
			/*user friends  start*/	
	$reqUser = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),
																					'conditions'=>array('(connections.user_id='.$user_id.' OR connections.friend_id='.$user_id.') AND connections.request=1')));
			
		foreach ($reqUser as $rfid) {
				if ($rfid['connections']['friend_id'] != $user_id) {
					$comResult[] .= $rfid['connections']['friend_id'];
				}
				if ($rfid['connections']['user_id'] != $user_id) {
					$comResult[] .= $rfid['connections']['user_id'];
				} 
		}
		/*user friends  end*/
		if($comResult){
			if (sizeof($comResult)>1) {
			 	$result =@implode(',',$comResult);
			}
			else {
					foreach ($comResult as $key=>$value) {
									$result = $value;
						}	
			}
			$result .=$result.",".$user_id;
		}
		else {
			$result = $user_id;	
		}
				$user_tweet_comments = ClassRegistry::init('Tweet_comment')->find('all', array('fields' => array('
																												 Tweet_comment.tweet_comment,
																												 Tweet_comment.content_id,
																												 Tweet_comment.user_id,
																												 Tweet_comment.id,
																												 Tweet_comment.created,
																												 users_profiles.firstname,
																												 users_profiles.lastname,
																												 users_profiles.photo,
																												 users_profiles.handler,
																												 users_profiles.user_id,
																												 users_profiles.tags,
																												 favorites.favorite,
																												 favorites.content_id,
																												 favorites.id,
																												 favorites.user_id
																												 '),
																							   'order'=>'Tweet_comment.id DESC',
																							   'joins'=>array(
																											  array('alias' => 'favorites',
																													'table' => 'favorites',
																													'type' => 'left',
																													'foreignKey' => false,
																													'conditions' => array('Tweet_comment.id  = favorites.content_id'
																																		  )
																													),
																											  array('alias' => 'users_profiles',
																													'table' => 'users_profiles',
																													'type' => 'left', 
																													'foreignKey' => false,
																													'conditions' => array('Tweet_comment.user_id = users_profiles.user_id'
																																		  )
																													)
																											  ),
																							   'conditions'=>array('Tweet_comment.comment_type = "tweets" AND Tweet_comment.content_id='.$content_id),'group' => 'Tweet_comment.id'
																							   )
																				  );
				
		$this->set('user_tweet_comments',$user_tweet_comments);

		$this->autorender = false;
	    $this->layout = false;
	    $this->render('add_tweet_replay');
		}
	/*Delete comment on tweet*/	
	public function delete_comment() {
		if ($this->request->is('get')) {
			$comment_id = $_GET['comment_id'];
			$content_id = $_GET['content_id'];
			$db = ConnectionManager::getDataSource('default');
			$db->rawQuery("DELETE FROM tweet_comments WHERE id=".$comment_id.' AND comment_type= "tweets"');
			
			$total_tweet_reply = ClassRegistry::init('tweet_comments')->find('all',array('fields'=>array('tweet_comments.content_id'),
																											'conditions'=>array('tweet_comments.content_id='.$content_id.' AND tweet_comments.comment_type="tweets"')));
			echo $total_tweet_reply = sizeof($total_tweet_reply);
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('delete_comment');
		}
		
	}
		
		/* Tweeter User Comments adding END HERE*/
		
		public function add_favorite() {
			if ($this->userInfo['users']['id']) {
				$uid = $this->userInfo['users']['id'];
			}
			if ($this->request->is('get')) {
	   			$user_id = $_GET['user_id'];
				$favorite = $_GET['favorite'];
	    		$content_id = $_GET['content_id'];
				$created = date("Y-m-d H:i:s");
				$content_type = "tweets";
				$this->request->data = '';
				$this->loadModel('Favorite');
				$checkInDB = $this->Favorite->find('first',array('fields'=>array('Favorite.id'),'conditions'=>array('Favorite.content_id='.$content_id)));
				if ($checkInDB) {
					$id = $checkInDB['Favorite']['id'];
					$this->Favorite->id = $id;
					$this->request->data['Favorite']['created'] = $created;
					$this->request->data['Favorite']['favorite'] = $favorite;
				}
				else {
					$this->request->data['Favorite']['user_id'] = $user_id;
					$this->request->data['Favorite']['content_type'] = $content_type;
					$this->request->data['Favorite']['content_id'] = $content_id;
					$this->request->data['Favorite']['created'] = $created;
					$this->request->data['Favorite']['favorite'] = $favorite;
				}
				if (ClassRegistry::init('Favorite')->save($this->request->data)){
				//echo "field value saved";
				}
				else {
				
				echo "field value not saved";
				}
				
			}
			$this->set('favorite',$favorite);
			$this->set('content_id',$content_id);
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('add_favorite');
		}
		
		public function retweet() {
		 	if ($this->userInfo['users']['id']) {
				$uid = $this->userInfo['users']['id'];
			}
			if ($this->request->is('post')) {
	   			$user_id = $_POST['user_id'];
				$photo = $_POST['photo'];
	    		$tweet = $_POST['tweet'];
				$parent_id = $_POST['parent_id'];
				$created = date("Y-m-d H:i:s");
				$this->loadModel('Tweet');
				$this->request->data = '';
				if ($parent_id) {
					$this->request->data['tweets']['modified'] = $created;
					$this->Tweet->id = $parent_id;
					if($this->Tweet->save($this->request->data)) {
						
					}
				}
				$isRetweetedinDB = $this->Tweet->find('first',array('fields'=>array('Tweet.id'),
																		 'conditions'=>array('Tweet.user_id='.$uid.' AND Tweet.parent_id='.$parent_id.' AND Tweet.retweet=0')));
				$this->request->data = '';
				
				if ($isRetweetedinDB) {
					//$retweet_array = $isRetweetedinDB[0]['Tweet'];
					$tweet__id = $isRetweetedinDB['Tweet']['id'];
					$this->Tweet->id = $tweet__id;
					$this->request->data['Tweet']['retweet'] = 1;
					$this->request->data['Tweet']['status'] = 2;
					$this->request->data['Tweet']['parent_id'] = $parent_id;
					$this->request->data['Tweet']['created'] = $created;
					if (ClassRegistry::init('Tweet')->save($this->request->data)){
					//echo "field value saved";
					}
					else {
					
					echo "field value not saved";
					}
				}
				else {
					$this->Tweet->id = '';
					$this->request->data['Tweet']['user_id'] = $uid;
					$this->request->data['Tweet']['parent_id'] = $parent_id;
					$this->request->data['Tweet']['photo'] = $photo;
					$this->request->data['Tweet']['created'] = $created;
					$this->request->data['Tweet']['status'] = 2;
					$this->request->data['Tweet']['retweet'] = 1;
					$this->request->data['Tweet']['tweet'] = $tweet;
					$this->request->data['Tweet']['modified_by'] = $uid;
					if (ClassRegistry::init('Tweet')->save($this->request->data)){
					//echo "field value saved";
					}
					else {
					
					echo "field value not saved";
					}
				}
			}
			$total_retweets = $tweets_count_added_user= ClassRegistry::init('tweets')->find('all',
																array('conditions'=>array('tweets.user_id='.$uid.' AND tweets.status=2')));
			echo $total_teweets = sizeof($total_retweets);
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('retweet');
		}
		
		public function back_tweet() {
		 	if ($this->userInfo['users']['id']) {
				$uid = $this->userInfo['users']['id'];
			}
			if ($this->request->is('post')) {
				$parent_id = $_POST['parent_id'];
				$created = date("Y-m-d H:i:s");
				$this->request->data = '';
				$this->loadModel('Tweet');
				$isRetweetedinDB = $this->Tweet->find('all',array('fields'=>array('Tweet.id'),
																				  'conditions'=>array('Tweet.user_id='.$uid.' AND Tweet.parent_id='.$parent_id)));
				if ($isRetweetedinDB) {
					$retweet_array = $isRetweetedinDB[0]['Tweet'];
					$tweet__id = $retweet_array['id'];
					if ($tweet__id) {
						$this->Tweet->id = $tweet__id;
						$this->request->data['Tweet']['user_id'] = $uid;
						$this->request->data['Tweet']['parent_id'] = $parent_id;
						$this->request->data['Tweet']['retweet'] = 0;
						$this->request->data['Tweet']['status'] = 0;
						$this->request->data['Tweet']['created'] = $created;
						if (ClassRegistry::init('Tweet')->save($this->request->data)){
						//echo "field value saved";
						}
						else {
						
						echo "field value not saved";
						}
					}
				
				}
			}
			$total_retweets = $tweets_count_added_user= ClassRegistry::init('tweets')->find('all',
																array('conditions'=>array('tweets.user_id='.$uid.' AND tweets.status=2')));
			echo $total_teweets = sizeof($total_retweets);
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('retweet');
		}
		
	public function tweet_favorite_users() {
		if ($this->userInfo['users']['id']) {
				$uid = $this->userInfo['users']['id'];
			}
			if ($this->request->is('post')) {
	   			$tweet_id = $_POST['tweet_id'];
				$this->loadModel('Tweet');
				$user_current_tweet = $this->Tweet->find('all',array('fields'=>array('
																					 Tweet.tweet,
																					 Tweet.id,
																					 Tweet.parent_id,
																					 users_profiles.firstname,
																					 users_profiles.lastname,
																					 users_profiles.photo,
																					 users_profiles.user_id ,
																					 users_profiles.handler
																					 '),
																	 'joins'=>array(
																					array('alias' => 'users_profiles',
																						  'table' => 'users_profiles',
																						  'type' => 'left',
																						  'foreignKey' => false,
																						  'conditions' => array('Tweet.user_id = users_profiles.user_id'
																												)
																						  )
																					),
																	 'conditions'=>array('Tweet.id='.$tweet_id
																						 )
																	 )
														 );
				$this->set('user_current_tweet',$user_current_tweet);
				
		
				$this->loadModel('Favorite');
				$user_favorite_tweets = $this->Favorite->find('all',array('fields'=>array('
																						  Favorite.content_id,
																						  users_profiles.firstname,
																						  users_profiles.lastname,
																						  users_profiles.photo,
																						  users_profiles.user_id,
																						  users_profiles.handler
																						  '),
																		  'joins'=>array(
																						 array('alias' => 'users_profiles',
																							   'table' => 'users_profiles',
																							   'type' => 'left',
																							   'foreignKey' => false,
																							   'conditions' => array('Favorite.user_id = users_profiles.user_id'
																													 )
																							   )
																						 ),
																		  'conditions'=>array('Favorite.content_id='.$tweet_id
																							  )
																		  )
															  );
				$this->set('user_favorite_tweets',$user_favorite_tweets);
				
				/* TO COUNT USER FOLLOWERS*/
				$this->loadModel('Users_following');
				$user_following = $this->Users_following->find('all',array('fields'=>array('
																						   Users_following.following_id,
																						   Users_following.following_type,
																						   Users_following.status
																						   '),
																		   'conditions'=>array('Users_following.following_type ="users" AND Users_following.status =2'
																							   )
																		   )
															   );

				$this->set('user_following',$user_following);
				
			
			$this->set('tweet_id',$tweet_id);
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('tweet_favorite_users');
		}
	}
	
		public function tweet_retweet_users() {
		if ($this->userInfo['users']['id']) {
				$uid = $this->userInfo['users']['id'];
			}
			if ($this->request->is('post')) {
	   			$tweet_id = $_POST['tweet_id'];
				$this->loadModel('Tweet');
				$user_current_tweet = $this->Tweet->find('all',array('fields'=>array('
																					 Tweet.tweet,
																					 Tweet.user_id,
																					 Tweet.id,
																					 Tweet.parent_id,
																					 Tweet.created,
																					 users_profiles.firstname,
																					 users_profiles.lastname,
																					 users_profiles.photo,
																					 users_profiles.user_id ,
																					 users_profiles.handler
																					 '),
																	 'joins'=>array(
																					array('alias' => 'users_profiles',
																						  'table' => 'users_profiles',
																						  'type' => 'left',
																						  'foreignKey' => false,
																						  'conditions' => array('Tweet.user_id = users_profiles.user_id'
																												)
																						  )
																					),
																	 'conditions'=>array('Tweet.id='.$tweet_id
																						 )
																	 )
														 );
				$this->set('user_current_tweet',$user_current_tweet);
				

				$user_retweet_tweets = $this->Tweet->find('all',array('fields'=>array('
																					  Tweet.user_id,
																					  users_profiles.firstname,
																					  users_profiles.lastname,
																					  users_profiles.photo,
																					  users_profiles.user_id,
																					  users_profiles.handler
																					  '),
																	  'joins'=>array(
																					 array('alias' => 'users_profiles',
																						   'table' => 'users_profiles',
																						   'type' => 'left',
																						   'foreignKey' => false,
																						   'conditions' => array('Tweet.user_id = users_profiles.user_id'
																												 )
																						   )
																					 ),
																	  'conditions'=>array('Tweet.parent_id='.$tweet_id
																						  )
																	  )
														  );
				$this->set('user_retweet_tweets',$user_retweet_tweets);
				
				/* TO COUNT USER FOLLOWERS*/
				$this->loadModel('Users_following');
				$user_following = $this->Users_following->find('all',array('fields'=>array('
																						   Users_following.following_id,
																						   Users_following.following_type,
																						   Users_following.status
																						   '),
																		   'conditions'=>array('Users_following.following_type ="users" AND Users_following.status =2'
																							   )
																		   )
															   );

				$this->set('user_following',$user_following);
				
			
			$this->set('tweet_id',$tweet_id);
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('tweet_retweet_users');
				
			}
		}
	
		public function delete_tweet() {
			if ($this->userInfo['users']['id']) {
				$uid = $this->userInfo['users']['id'];
			}
		if ($this->request->is('get')) {
			$tweet_id = $_GET['tweet_id'];
			$total_tweet = $_GET['total_tweet'];
			$db = ConnectionManager::getDataSource('default');
			$db->rawQuery("DELETE FROM tweets WHERE id=".$tweet_id." OR parent_id=".$tweet_id);
			$db->rawQuery("DELETE FROM favorites WHERE content_id=".$tweet_id.' AND content_type= "tweets"');
			$db->rawQuery("DELETE FROM tweet_comments WHERE content_id=".$tweet_id.' AND comment_type= "tweets"');
			
			$your_tweets = ClassRegistry::init('tweets')->find('all',array('fields'=>array('
																						   tweets.parent_id,
																						   tweets.user_id
																						   '),
																					'conditions'=>array(' 
																										tweets.status=2 AND 
																										tweets.user_id='.$uid
																										)
																					)
																		);
			
			$your_tweets = sizeof($your_tweets);
			$total_tweet = $total_tweet-1;
			echo $your_tweets.':::'.$total_tweet;
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('delete_tweet');
		}
		
	}
	
} ?>
