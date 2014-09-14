<?php

class ArticlesController extends AppController {

    var $name = 'Articles';
    var $helpers = array('Form', 'html', 'DatePicker');
    var $components = array('Auth');
    //'ImageResize'
    var $article = array('articles'); //, 'jobs_description', 'jobs_functional_area', 'jobs_keyword', 'jobs_location', 'jobs_qualifications');
	var $uses = array('Articles','Comment','Connection','Users_following','Like','Users_viewing','Comment_like');
    function beforeFilter() {
	parent::beforeFilter();


	$this->Auth->allow();
	switch ($this->request->params['action']) {
	    case 'index':
	    case 'admin':
		$this->Security->validatePost = false;
	}
    }

    function admin_index() {
	$jobData = ClassRegistry::init('companies')->find('all');
	$this->set('companies', $jobData);
    }

    function admin_view($id = null) {
	$this->_set_user($id);
    }

    function admin_add() {
	//echo "<pre>";
	//print_r($_REQUEST);
	if ($this->request->is('post')) {


	    $ext = pathinfo($this->request->params['form']['logo']['name'], PATHINFO_EXTENSION);
	    $comapny_logo = strtotime(date('m/d/Y h:i:s a', time())) . "." . $ext;
	    $filename = WWW_ROOT . 'files/companies_logo/' . $comapny_logo;
	    //WWW_ROOT. DS . 'documents'.DS.$this->request->data['Post']['doc_file']['name'];
	    move_uploaded_file($this->request->params['form']['logo']['tmp_name'], $filename);



	    /*

	      if ($this->ImageResize->isUploadedFile($this->request->params['form']['logo'])) {
	      // set the resize data for the FileUpload Component
	      // resize_data holds the resize settings
	      $prefs = array('resize_data' => array(RESIZE_WIDTH, '50', null));
	      $errors = $this->ImageResize->uploadFile($filename, $prefs);
	      }
	     */

	    //$uploadFolder = "images";
	    //full path to upload folder
	    // $uploadPath = WWW_ROOT . $uploadFolder;
	    //echo $_SERVER['DOCUMENT_ROOT'] . $this->request->webroot . 'app/webroot/files/' . $this->data['Document']['submittedfile']['name'];
	    $this->request->data['company_title'] = $this->request->data['selectComapny'];
	    $this->request->data['logo'] = $comapny_logo;
	    /* $formData['posted_on'] = date('Y-m-d H:i:s', (strtotime($this->request->data['startDate'])));
	      $formData['expiry_date'] = date('Y-m-d H:i:s', (strtotime($this->request->data['expiryDate'])));
	      $formData['experience'] = $this->request->data['exp_start'] . " to " . $this->request->data['exp_end']; */
	    $userData = $this->Session->read(@$userid);
	    $this->request->data['created_by'] = $userData['Auth']['User']['id'];
	    $this->request->data['created'] = date('Y-m-d H:i:s', (strtotime(date('m/d/Y h:i:s a', time()))));

	    $this->request->data['enabled'] = '1';

	    /* echo "<pre>";
	      print_r($this->request->data);
	      exit; */

	    //$this->employers->create();

	    if (ClassRegistry::init('companies')->save($this->request->data)) {
		/* $job_id = $this->Job->getLastInsertId();

		  $jdData['job_id'] = $job_id;
		  $jdData['position_function'] = $this->request->data['position_function'];
		  $jdData['desired_profile'] = $this->request->data['desired_profile'];
		  $jdData['extras'] = $this->request->data['more_details'];

		  $jlData['job_id'] = $job_id;
		  $jlData['location_id'] = $this->request->data['locations'];

		  $jfaData['job_id'] = $job_id;
		  $jfaData['functional_area_id'] = $this->request->data['functionalArea'];

		  $jqData['job_id'] = $job_id;
		  $jqData['qualification_id'] = $this->request->data['qualifications'];

		  ClassRegistry::init('jobs_descriptions')->save($jdData);
		  ClassRegistry::init('jobs_locations')->save($jlData);
		  ClassRegistry::init('jobs_functional_areas')->save($jfaData);
		  ClassRegistry::init('jobs_qualifications')->save($jqData); */


		$this->Session->setFlash(___('the job has been saved '), 'flash_message ', array('plugin' => 'alaxos'));

		//$this->redirect(array('action' => 'index'));
	    } else {
		$this->Session->setFlash(___('the job could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
	    }
	} else {
	    $this->set('countries', ClassRegistry::init('countries')->find('all', array('conditions' => array('countries.enabled' => '1'))));
	    $this->set('companies', ClassRegistry::init('companies')->find('all', array('conditions' => array('companies.enabled' => '1'))));
	    $this->set('qualifications', ClassRegistry::init('qualifications')->find('all', array('conditions' => array('qualifications.enabled' => '1'), 'order' => array('qualifications.priority', 'qualifications.title'))));
	    $this->set('functional_areas', ClassRegistry::init('functional_areas')->find('all', array('conditions' => array('functional_areas.enabled' => '1'))));
	}
    }

    function admin_edit($id = null) {
	$this->User->id = $id;
	if (!$this->User->exists()) {
	    throw new NotFoundException(___('invalid id for user'));
	}

	if ($this->request->is('post') || $this->request->is('put')) {
	    if ($this->User->save($this->request->data)) {
		$this->Session->setFlash(___('the user has been saved'), 'flash_message', array('plugin' => 'alaxos'));
		$this->redirect(array('action' => 'index'));
	    } else {
		$this->Session->setFlash(___('the user could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
	    }
	}

	$this->_set_user($id);

	$roles = $this->User->Role->find('list');
	$this->set(compact('roles'));
    }

    function admin_copy($id = null) {
	$this->User->id = $id;
	if (!$this->User->exists()) {
	    throw new NotFoundException(___('invalid id for user'));
	}

	if ($this->request->is('post') || $this->request->is('put')) {
	    $this->User->create();

	    if ($this->User->save($this->request->data)) {
		$this->Session->setFlash(___('the user has been saved'), 'flash_message', array('plugin' => 'alaxos'));
		$this->redirect(array('action' => 'index'));
	    } else {
		//reset id to copy
		$this->request->data['User'][$this->User->primaryKey] = $id;
		$this->Session->setFlash(___('the user could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
	    }
	}

	$this->_set_user($id);

	$roles = $this->User->Role->find('list');
	$this->set(compact('roles'));
    }

    function admin_delete($id = null) {
	/* if (!$this->request->is('post')) {
	  throw new MethodNotAllowedException();
	  } */

	$this->Job->job_id = $id;
	if (!$this->Job->exists()) {
	    throw new NotFoundException(___('invalid id for Job'));
	}

	if ($this->Job->delete($id)) {
	    $this->Session->setFlash(___('Job deleted'), 'flash_message', array('plugin' => 'alaxos'));
	    $this->redirect(array('action' => 'index'));
	} else {
	    $this->Session->setFlash(___('Job was not deleted'), 'flash_error', array('plugin' => 'alaxos'));
	    $this->redirect($this->referer(array('action' => 'index')));
	}
    }

    function admin_actionAll() {
	if (!empty($this->request->data['_Tech']['action'])) {
	    if (isset($this->Auth)) {
		$request = $this->request;
		$request['action'] = $this->request->data['_Tech']['action'];

		if ($this->Auth->isAuthorized($this->Auth->user(), $request)) {
		    $this->setAction($this->request->data['_Tech']['action']);
		} else {
		    $this->Session->setFlash(___d('alaxos', 'not authorized'), 'flash_error', array('plugin' => 'alaxos'));
		    $this->redirect($this->referer());
		}
	    } else {
		/*
		 * Auth is not used -> grant access
		 */
		$this->setAction($this->request->data['_Tech']['action']);
	    }
	} else {
	    $this->Session->setFlash(___d('alaxos', 'the action to perform is not defined'), 'flash_error', array('plugin' => 'alaxos'));
	    $this->redirect($this->referer());
	}
    }

    function admin_deleteAll() {
	$ids = Set :: extract('/User/id[id > 0]', $this->request->data);
	if (count($ids) > 0) {
	    if ($this->User->deleteAll(array('User.id' => $ids), false, true)) {
		$this->Session->setFlash(___('users deleted'), 'flash_message', array('plugin' => 'alaxos'));
		$this->redirect(array('action' => 'index'));
	    } else {
		$this->Session->setFlash(___('users were not deleted'), 'flash_error', array('plugin' => 'alaxos'));
		$this->redirect($this->referer(array('action' => 'index')));
	    }
	} else {
	    $this->Session->setFlash(___('no user to delete was found'), 'flash_error', array('plugin' => 'alaxos'));
	    $this->redirect($this->referer(array('action' => 'index')));
	}
    }

    function search() {
	//if ($this->request->data['term'])
	if ($this->request->is('post')) {
	    echo $usernames = $this->request->data['User']['username'];
	    $uss = ClassRegistry::init('users')->find('all', array('conditions' => array('users.username' => $usernames)));
	    print_r($uss);
	    // exit;
	    // $this->set('user_con',$users);
	    $this->redirect(array('controller' => 'users', 'action' => 'search'));
	}
    }
	
	function detail() {
		if ($this->Session->read(@$userid)) {
			$userData = $this->Session->read(@$userid);
			$uid = $userData['userid'];
		if ($this->params['pass']!=""){
			$arr = $this->params['pass'];
			$id = $arr[0];
			$postById = ClassRegistry::init('articles')->find('all', 
			array('fields' => array('articles.*,likes.like,likes.content_id,likes.id,likes.user_id,count(likes.like) as total'),
			'joins'=>array(array('alias' => 'likes', 'table' => 'likes', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('articles.id = likes.content_id AND likes.content_type="articles"'))),
			'conditions' => array('articles.id='.$id)));
			$this->set('currentPostClick',$postById);
		 }
		 else {
			 echo "empty";
		 }
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
		/*comments  start*/
		$comment_type = 'articles';
		if($comResult){
			 if (sizeof($comResult)>1) { 
			  	$comResult =@implode(',',$comResult);
				
				$userComments = ClassRegistry::init('comments')->find('all', 
		 		
		 		array('fields' => array('comments.*,users_profiles.*,comment_likes.comment_id,comment_likes.user_id,comment_likes.like,count(comment_likes.like) as total'),'order'=>'comments.id DESC', 
		 			'joins' => array(array('alias' => 'comment_likes', 'table' => 'comment_likes', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('comment_likes.comment_id = comments.id')),
					array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('comments.user_id = users_profiles.user_id'))), 
			 		'conditions' => array('comments.user_id IN ('.$comResult.','.$uid.')','comments.comment_type="'.$comment_type.'" AND comments.parent=0 AND comments.content_id='.$id),'group'=>'comments.id'));
			}
			else{
				$userComments = ClassRegistry::init('comments')->find('all', 
		 		 array('fields' => array('comments.*,users_profiles.*,comment_likes.comment_id,comment_likes.user_id,comment_likes.like,count(comment_likes.like) as total'),'order'=>'comments.id DESC', 
		 			'joins' => array(array('alias' => 'comment_likes', 'table' => 'comment_likes', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('comment_likes.comment_id = comments.id')),
		array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('comments.user_id = users_profiles.user_id'))), 
					'conditions' => array('comments.user_id IN ('.$comResult[0].','.$uid.')','comments.comment_type="'.$comment_type.'" AND comments.parent=0 AND comments.content_id='.$id),'group'=>'comments.id'));
			}
		}
		else {
			$userComments = ClassRegistry::init('comments')->find('all', 
			array('fields' => array('comments.*,users_profiles.*,comment_likes.comment_id,comment_likes.user_id,comment_likes.like,count(comment_likes.like) as total'),'order'=>'comments.id DESC', 
		 		'joins' => array(array('alias' => 'comment_likes', 'table' => 'comment_likes', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('comment_likes.comment_id = comments.id')),
		array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('comments.user_id = users_profiles.user_id'))), 
			 	'conditions' => array('comments.user_id='.$uid ,'comments.comment_type="'.$comment_type.'" AND comments.parent=0 AND comments.content_id='.$id),'group'=>'comments.id'));
		}
		
		$this->set('userComments', $userComments);
		/*comments  end*/
		
		$commentLikesForPost = ClassRegistry::init('comment_likes')->find('all',array('fields'=>array('comment_likes.user_id,comment_likes.comment_id'),'conditions'=>array('comment_likes.content_id='.$id.' AND comment_likes.like=1')));
		
		$this->set('commentLikesForPost', $commentLikesForPost);
		
		/*Comments on comment start here*/
		$commentsParent = ClassRegistry::init('comments')->find('all',array('fields'=>array('comments.id'),'conditions'=>array('comments.parent=0 AND comments.comment_type="articles" AND comments.content_id='.$id)));
			
		foreach ($commentsParent as $commentsIDS) {
					$commentIdArray[] .= $commentsIDS['comments']['id'];
		}
		
		if ($commentIdArray) {
			
		if (sizeof($commentIdArray)>1){
			$commentIdArray = @implode(',',$commentIdArray);
			
		$userCommentsOnComments = ClassRegistry::init('comments')->find('all', 
			array('fields' => array('comments.*,users_profiles.*'),'order'=>'comments.id DESC', 
		 		'joins' => array(array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('comments.user_id = users_profiles.user_id'))), 
			 	'conditions' => array(array('comments.parent IN ('.$commentIdArray.')') ,'comments.comment_type="articles" AND comments.content_id='.$id),'group'=>'comments.id'));
		}	
		else {
			$userCommentsOnComments = ClassRegistry::init('comments')->find('all', 
			array('fields' => array('comments.*,users_profiles.*'),'order'=>'comments.id DESC', 
		 		'joins' => array(array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('comments.user_id = users_profiles.user_id'))), 
			 	'conditions' => array(array('comments.parent IN ('.$commentIdArray[0].')') ,'comments.comment_type="articles" AND comments.content_id='.$id),'group'=>'comments.id'));
		}
		}
		else {
			$userCommentsOnComments = ClassRegistry::init('comments')->find('all', 
			array('fields' => array('comments.*,users_profiles.*'),'order'=>'comments.id DESC', 
		 		'joins' => array(array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('comments.user_id = users_profiles.user_id'))), 
			 	'conditions' => array('comments.comment_type="articles" AND comments.content_id='.$id),'group'=>'comments.content_id'));
		}

			$this->set('userCommentsOnComments',$userCommentsOnComments);

			/*Comments on comment end here*/
			
			/*Total comments on post*/
			$countComments = ClassRegistry::init('comments')->find('all' ,array('fields'=>array('count(comments.content_id) as total_comments'),'conditions'=>array('comments.content_id='.$id.' AND comments.comment_type="articles" AND comments.parent=0')));
			$countComments = $countComments[0][0];
			$countComments = $countComments['total_comments'];
			$this->set('countComments',$countComments);
			/*Rating on post*/
			
					$countRate = ClassRegistry::init('rattings')->find('all' ,array('fields'=>array('count(rattings.user_id) as total_user,sum(rattings.rate) as total_rate'),'conditions'=>array('rattings.content_id='.$id.' AND rattings.content_type="articles"')));
			$totalRate = $countRate[0][0];
			$totalUser = $totalRate['total_user'];	
		 	$totalRatting = $totalRate['total_rate'];
			$countedRate = ceil($totalRatting/$totalUser);
			$this->set('countedRate',$countedRate);
			
			/*Check user for ratting for the current post*/
			$checkUserForRate = ClassRegistry::init('rattings')->find('all' ,array('fields'=>array('rattings.user_id,rattings.rate'),'conditions'=>array('rattings.content_id='.$id.' AND rattings.content_type="articles" AND rattings.user_id='.$uid)));
			$checkUserForRate = $checkUserForRate[0]['rattings'];
			$postUser = $checkUserForRate['user_id'];	
		 	$postRatting = $checkUserForRate['rate'];
			$this->set('postUser',$postUser);
			$this->set('postRatting',$postRatting);
			
			/*follows on post*/
			$countFollow = ClassRegistry::init('users_followings')->find('all' ,array('fields'=>array('count(users_followings.following_id) as total_follow'),'conditions'=>array('users_followings.following_id='.$id.' AND users_followings.following_type="articles"')));
			$totalFollows = $countFollow[0][0];
			$totalFollows = $totalFollows['total_follow'];	
			$this->set('totalFollows',$totalFollows);
			
			/*Check user for following for the current post*/
			$checkUserForFollow = ClassRegistry::init('users_followings')->find('all' ,array('fields'=>array('users_followings.user_id,users_followings.following_id'),'conditions'=>array('users_followings.following_id='.$id.' AND users_followings.following_type="articles" AND users_followings.user_id='.$uid)));
			$checkUserForFollow = $checkUserForFollow[0]['users_followings'];
			$postFollowUser = $checkUserForFollow['user_id'];	
		 	$postFollowRatting = $checkUserForFollow['following_id'];
			$this->set('checkUserForFollow',$checkUserForFollow);
			$this->set('postFollowRatting',$postFollowRatting);
			
			/*Likes on post*/
			$countLikes = ClassRegistry::init('likes')->find('all' ,array('fields'=>array('count(likes.like) as total_likes'),'conditions'=>array('likes.content_id='.$id.' AND likes.content_type="articles"')));
	
			$totalLikes = $countLikes[0][0];
		    $totalLikes = $totalLikes['total_likes'];	
			
			$this->set('totalLikes',$totalLikes);
			
			/*Check user for liking for the current post*/
			$checkUserForLike = ClassRegistry::init('likes')->find('all' ,array('fields'=>array('likes.user_id,likes.like'),'conditions'=>array('likes.content_id='.$id.' AND likes.content_type="articles" AND likes.user_id='.$uid)));
			$checkUserForLike = $checkUserForLike[0]['likes'];
			$postLikeUser = $checkUserForLike['user_id'];	
		 	$postLikes = $checkUserForFollow['like'];
			$this->set('postLikeUser',$postLikeUser);
			$this->set('postLikes',$postLikes);
			
			/*Check user for views for the current post*/
			$this->loadModel('Users_viewing');
			$ip= $_SERVER["REMOTE_ADDR"]; 
			$datetime =date("Y-m-d") . ' ' . date('H:i:s') ;
			
			$this->request->data['Users_viewing']['user_id'] = $uid;
			$this->request->data['Users_viewing']['viewings_id'] = $id;
			$this->request->data['Users_viewing']['viewings_type'] = "articles";
			$this->request->data['Users_viewing']['start_date'] = $datetime;
			$this->request->data['Users_viewing']['viewings_counts'] = 1;
			
			$checkCounters = ClassRegistry::init('users_viewings')->find('all',
			array('conditions'=>array('users_viewings.user_id='.$uid.' AND users_viewings.viewings_id='.$id.' AND users_viewings.viewings_type="articles"')));
			
			
			if ($checkCounters) {
				
				$counts = $checkCounters[0]['users_viewings'];
				 $counters = $counts['viewings_counts']+1;
				
	   		 if($this->Users_viewing->updateAll(array('viewings_counts' =>$counters), array('Users_viewing.id='.$counts['id']))) {
				$this->Session->setFlash('Counter successfully saved.');	
	    	  } 
			  else {
					echo "not updated";
	   		 }
			}
		   else {
			
			if (ClassRegistry::init('Users_viewing')->save($this->request->data)){
				//echo "field value saved";
			}
			else {
				
				echo "field value not saved";
			}
		}
			
		$totalCountersByUser = ClassRegistry::init('users_viewings')->find('all',
			array('conditions'=>array('users_viewings.user_id='.'"'.$uid.'"'.' AND users_viewings.viewings_id='.$id.' AND users_viewings.viewings_type="articles"')));
			$postCounts = $totalCountersByUser[0]['users_viewings'];
			$setCounters = $postCounts['viewings_counts'];
			$this->set('setCounters',$setCounters);
			
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
		
}		
}
?>