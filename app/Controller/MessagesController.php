<?php

App::uses('AppController', 'Controller');

class MessagesController extends AppController {

	var $helpers = array('Form', 'html');
	var $components = array('Auth');
	var $uses = array('User');
	
    function beforeFilter() {
	
	parent::beforeFilter();
	
//	Configure::write('debug', 2);
	
	$this->Auth->allow();
	switch ($this->request->params['action']) {
	    case 'index':
	    case 'admin_index':
	}
    }	

    function index() {
		
		$this->loadModel('msg_inbox');
        
		$uid = $this->userInfo['users']['id']; 
		
		
		$this->paginate=array('fields'=>array(
					'
					msg_inbox.*,
					From.id,
					From.role_id,
					From.email,
					From.status,
					Sendto.id,
					Sendto.role_id,
					Sendto.email,
					Sendto.status,
					FromProfile.user_id,
					FromProfile.firstname,
					FromProfile.lastname,
					FromProfile.photo,
					ToProfile.user_id,
					ToProfile.firstname,
					ToProfile.lastname,
					ToProfile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = `msg_inbox`.`from_user_id`'
						),
						array(
							'alias' => 'Sendto',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`Sendto`.`id` = `msg_inbox`.`to_user_id`'
						),
						array(
							'alias' => 'FromProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`FromProfile`.`user_id` = `From`.`id`'
						),
						array(
							'alias' => 'ToProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`ToProfile`.`user_id` = `Sendto`.`id`'
						)
						
						
					),
					'conditions'=>array('AND'=>array('msg_inbox.to_user_id'=>$uid,'msg_inbox.status'=>2)), 'limit'=>10,'order'=>'created desc');
			
			
			$this->set('data', $this->paginate('msg_inbox'));
			$unreadCount = $this->msg_inbox->find('count',array('conditions'=>array('AND'=>array('msg_inbox.to_user_id'=>$uid,'msg_inbox.status'=>2,'msg_inbox.unread'=>1))));
			$this->set('unreadCount',$unreadCount);
			if ($this->request->is('ajax')) {
				$this->autoRender = false;
				$this->render('inbox','ajax');
			}
       
        
        
    }
	function unreadCount() {
		$this->loadModel('msg_inbox');
       $uid = $this->userInfo['users']['id'];
		$this->autoRender = false;
		$unreadCount = $this->msg_inbox->find('count',array('conditions'=>array('AND'=>array('msg_inbox.to_user_id'=>$uid,'msg_inbox.status'=>2,'msg_inbox.unread'=>1))));
		echo $unreadCount;
		//$this->set('unreadCount',$unreadCount);
	
	}
	function sent() {
			
		$this->loadModel('msg_sent');
        $uid = $this->userInfo['users']['id'];
		
		
		$this->paginate=array('fields'=>array(
					'
					msg_sent.*,
					From.id,
					From.role_id,
					From.email,
					From.status,
					Sendto.id,
					Sendto.role_id,
					Sendto.email,
					Sendto.status,
					FromProfile.user_id,
					FromProfile.firstname,
					FromProfile.lastname,
					FromProfile.photo,
					ToProfile.user_id,
					ToProfile.firstname,
					ToProfile.lastname,
					ToProfile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = `msg_sent`.`from_user_id`'
						),
						array(
							'alias' => 'Sendto',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`Sendto`.`id` = `msg_sent`.`to_user_id`'
						),
						array(
							'alias' => 'FromProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`FromProfile`.`user_id` = `From`.`id`'
						),
						array(
							'alias' => 'ToProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`ToProfile`.`user_id` = `Sendto`.`id`'
						)
						
						
					),
					'conditions'=>array('AND'=>array('msg_sent.from_user_id'=>$uid,'msg_sent.status'=>2)), 'limit'=>10,'order'=>'created desc');
			
			
			$this->set('data', $this->paginate('msg_sent'));
		
			if ($this->request->is('ajax')) {
				$this->autoRender = false;
				$this->render('sent','ajax');
			}
       
        
        
    }
	function trashed_list() {
			
		$this->loadModel('msg_inbox');
		$this->loadModel('msg_sent');
        $uid = $this->userInfo['users']['id'];
		$this->set('uid',$uid);
		$page = $this->request->data['page'];
		$this->paginate=array('fields'=>array(
					'
					msg_inbox.*,
					From.id,
					From.role_id,
					From.email,
					From.status,
					FromProfile.user_id,
					FromProfile.firstname,
					FromProfile.lastname,
					FromProfile.photo
					
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = `msg_inbox`.`from_user_id`'
						),
						
						array(
							'alias' => 'FromProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`FromProfile`.`user_id` = `From`.`id`'
						),
						
					),
					'conditions'=>array('AND'=>array('msg_inbox.status=1','OR'=>array('msg_inbox.to_user_id'=>$uid))),'order'=>'msg_inbox.created desc');
					$msg_inbox = $this->paginate('msg_inbox');
			$this->paginate=array('fields'=>array(
					'
					msg_sent.*,
					Sendto.id,
					Sendto.role_id,
					Sendto.email,
					Sendto.status,
					ToProfile.user_id,
					ToProfile.firstname,
					ToProfile.lastname,
					ToProfile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'Sendto',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`Sendto`.`id` = `msg_sent`.`to_user_id`'
						),
						array(
							'alias' => 'ToProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`ToProfile`.`user_id` = `Sendto`.`id`'
						)
						
						
					),
					'conditions'=>array('AND'=>array('msg_sent.status=1','OR'=>array('msg_sent.from_user_id'=>$uid))),'order'=>'msg_sent.created desc');
			//$msg_sent = $this->msg_sent->find('all',array('conditions'=>array('msg_sent.from_user_id'=>$uid)));
			//$msg_inbox = $this->msg_inbox->find('all',array('conditions'=>array('msg_inbox.to_user_id'=>$uid)));
			//$this->paginate=array('limit'=>2);
			$msg_sent = $this->paginate('msg_sent'); 
			
			 $data=array_merge($msg_sent,$msg_inbox);
			 
			$this->set(compact('data'));


			//$d = array_merge($msg_sent,$msg_inbox);
			//pr($d);
			//$this->set('data',$d);
			
			
			//$ds = ;
			//$this->set('data',$this->paginate($d));
		
			if ($this->request->is('ajax')) {
				$this->autoRender = false;
				$this->render('trashed_list','ajax');
			}
       
        
        
    }
	function view() {
			
		$this->loadModel('msg_inbox');
		$this->loadModel('msg_sent');
        $uid = $this->userInfo['users']['id'];
		$msg_id = $this->request->data['msg_id'];
		$this->set('cat', $this->request->data['cat']);
		$page = $this->request->data['cat'];
		
		if($page=='sent'){
			$data=$this->msg_sent->find('first',array('fields'=>array(
					'
					msg_sent.*,
					From.id,
					From.role_id,
					From.email,
					From.status,
					Sendto.id,
					Sendto.role_id,
					Sendto.email,
					Sendto.status,
					FromProfile.user_id,
					FromProfile.firstname,
					FromProfile.lastname,
					FromProfile.photo,
					ToProfile.user_id,
					ToProfile.firstname,
					ToProfile.lastname,
					ToProfile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = `msg_sent`.`from_user_id`'
						),
						array(
							'alias' => 'Sendto',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`Sendto`.`id` = `msg_sent`.`to_user_id`'
						),
						array(
							'alias' => 'FromProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`FromProfile`.`user_id` = `From`.`id`'
						),
						array(
							'alias' => 'ToProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`ToProfile`.`user_id` = `Sendto`.`id`'
						)
						
						
					),
					'conditions'=>array('msg_sent.id'=>$msg_id)));
			if($data['msg_sent']['msg_parent_id']!=0){
				$redata=$this->msg_sent->find('all',array('fields'=>array(
					'
					msg_sent.*,
					From.id,
					From.role_id,
					From.email,
					From.status,
					Sendto.id,
					Sendto.role_id,
					Sendto.email,
					Sendto.status,
					FromProfile.user_id,
					FromProfile.firstname,
					FromProfile.lastname,
					FromProfile.photo,
					ToProfile.user_id,
					ToProfile.firstname,
					ToProfile.lastname,
					ToProfile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = `msg_sent`.`from_user_id`'
						),
						array(
							'alias' => 'Sendto',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`Sendto`.`id` = `msg_sent`.`to_user_id`'
						),
						array(
							'alias' => 'FromProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`FromProfile`.`user_id` = `From`.`id`'
						),
						array(
							'alias' => 'ToProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`ToProfile`.`user_id` = `Sendto`.`id`'
						)
						
						
					),
					'conditions'=>array('msg_sent.id'=>$data['msg_sent']['msg_parent_id'])));
					$this->set('rerow', $redata);
			}
			$this->set('row', $data);
			
		}else{
			$data=$this->msg_inbox->find('first',array('fields'=>array(
					'
					msg_inbox.*,
					From.id,
					From.role_id,
					From.email,
					From.status,
					Sendto.id,
					Sendto.role_id,
					Sendto.email,
					Sendto.status,
					FromProfile.user_id,
					FromProfile.firstname,
					FromProfile.lastname,
					FromProfile.photo,
					ToProfile.user_id,
					ToProfile.firstname,
					ToProfile.lastname,
					ToProfile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = `msg_inbox`.`from_user_id`'
						),
						array(
							'alias' => 'Sendto',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`Sendto`.`id` = `msg_inbox`.`to_user_id`'
						),
						array(
							'alias' => 'FromProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`FromProfile`.`user_id` = `From`.`id`'
						),
						array(
							'alias' => 'ToProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`ToProfile`.`user_id` = `Sendto`.`id`'
						)
						
						
					),
					'conditions'=>array('msg_inbox.id'=>$msg_id)));
			if($data['msg_inbox']['msg_parent_id']!=0){
				$redata=$this->msg_inbox->find('all',array('fields'=>array(
					'
					msg_inbox.*,
					From.id,
					From.role_id,
					From.email,
					From.status,
					Sendto.id,
					Sendto.role_id,
					Sendto.email,
					Sendto.status,
					FromProfile.user_id,
					FromProfile.firstname,
					FromProfile.lastname,
					FromProfile.photo,
					ToProfile.user_id,
					ToProfile.firstname,
					ToProfile.lastname,
					ToProfile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = `msg_inbox`.`from_user_id`'
						),
						array(
							'alias' => 'Sendto',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`Sendto`.`id` = `msg_inbox`.`to_user_id`'
						),
						array(
							'alias' => 'FromProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`FromProfile`.`user_id` = `From`.`id`'
						),
						array(
							'alias' => 'ToProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`ToProfile`.`user_id` = `Sendto`.`id`'
						)
						
						
					),
					'conditions'=>array('msg_inbox.id'=>$data['msg_inbox']['msg_parent_id'])));
					$this->set('rerow', $redata);
			}
			if($data['msg_inbox']['unread']==1){
				$this->msg_inbox->updateAll(array('msg_inbox.unread'=>0),array('msg_inbox.id'=>$msg_id));
			}
			$this->set('row', $data);
			
		}
		if($this->request->is('ajax')){
			if($page=='sent') {
				$this->autoRender = false;
				$this->render('sent_view','ajax');
			}else{
				$this->autoRender = false;
				$this->render('view','ajax');
			}
		}
       
    }
	function trash_view() {
			
		$this->loadModel('msg_inbox');
		$this->loadModel('msg_sent');
        $uid = $this->userInfo['users']['id']; 
		$msg_id = $this->request->data['msg_id'];
		$this->set('cat', $this->request->data['cat']);
		$page = $this->request->data['cat'];
		
		if($page=='sent'){
			$data=$this->msg_sent->find('first',array('fields'=>array(
					'
					msg_sent.*,
					From.id,
					From.role_id,
					From.email,
					From.status,
					Sendto.id,
					Sendto.role_id,
					Sendto.email,
					Sendto.status,
					FromProfile.user_id,
					FromProfile.firstname,
					FromProfile.lastname,
					FromProfile.photo,
					ToProfile.user_id,
					ToProfile.firstname,
					ToProfile.lastname,
					ToProfile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = `msg_sent`.`from_user_id`'
						),
						array(
							'alias' => 'Sendto',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`Sendto`.`id` = `msg_sent`.`to_user_id`'
						),
						array(
							'alias' => 'FromProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`FromProfile`.`user_id` = `From`.`id`'
						),
						array(
							'alias' => 'ToProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`ToProfile`.`user_id` = `Sendto`.`id`'
						)
						
						
					),
					'conditions'=>array('msg_sent.id'=>$msg_id)));
			if($data['msg_sent']['msg_parent_id']!=0){
				$redata=$this->msg_sent->find('all',array('fields'=>array(
					'
					msg_sent.*,
					From.id,
					From.role_id,
					From.email,
					From.status,
					Sendto.id,
					Sendto.role_id,
					Sendto.email,
					Sendto.status,
					FromProfile.user_id,
					FromProfile.firstname,
					FromProfile.lastname,
					FromProfile.photo,
					ToProfile.user_id,
					ToProfile.firstname,
					ToProfile.lastname,
					ToProfile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = `msg_sent`.`from_user_id`'
						),
						array(
							'alias' => 'Sendto',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`Sendto`.`id` = `msg_sent`.`to_user_id`'
						),
						array(
							'alias' => 'FromProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`FromProfile`.`user_id` = `From`.`id`'
						),
						array(
							'alias' => 'ToProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`ToProfile`.`user_id` = `Sendto`.`id`'
						)
						
						
					),
					'conditions'=>array('msg_sent.id'=>$data['msg_sent']['msg_parent_id'])));
					$this->set('rerow', $redata);
			}
			$this->set('row', $data);
			
		}elseif($page=='inbox'){
			$data=$this->msg_inbox->find('first',array('fields'=>array(
					'
					msg_inbox.*,
					From.id,
					From.role_id,
					From.email,
					From.status,
					Sendto.id,
					Sendto.role_id,
					Sendto.email,
					Sendto.status,
					FromProfile.user_id,
					FromProfile.firstname,
					FromProfile.lastname,
					FromProfile.photo,
					ToProfile.user_id,
					ToProfile.firstname,
					ToProfile.lastname,
					ToProfile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = `msg_inbox`.`from_user_id`'
						),
						array(
							'alias' => 'Sendto',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`Sendto`.`id` = `msg_inbox`.`to_user_id`'
						),
						array(
							'alias' => 'FromProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`FromProfile`.`user_id` = `From`.`id`'
						),
						array(
							'alias' => 'ToProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`ToProfile`.`user_id` = `Sendto`.`id`'
						)
						
						
					),
					'conditions'=>array('msg_inbox.id'=>$msg_id)));
			if($data['msg_inbox']['msg_parent_id']!=0){
				$redata=$this->msg_inbox->find('all',array('fields'=>array(
					'
					msg_inbox.*,
					From.id,
					From.role_id,
					From.email,
					From.status,
					Sendto.id,
					Sendto.role_id,
					Sendto.email,
					Sendto.status,
					FromProfile.user_id,
					FromProfile.firstname,
					FromProfile.lastname,
					FromProfile.photo,
					ToProfile.user_id,
					ToProfile.firstname,
					ToProfile.lastname,
					ToProfile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = `msg_inbox`.`from_user_id`'
						),
						array(
							'alias' => 'Sendto',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`Sendto`.`id` = `msg_inbox`.`to_user_id`'
						),
						array(
							'alias' => 'FromProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`FromProfile`.`user_id` = `From`.`id`'
						),
						array(
							'alias' => 'ToProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`ToProfile`.`user_id` = `Sendto`.`id`'
						)
						
						
					),
					'conditions'=>array('msg_inbox.id'=>$data['msg_inbox']['msg_parent_id'])));
					$this->set('rerow', $redata);
			}
			$this->set('row', $data);
			if($data['msg_inbox']['unread']==1){
				
				$this->msg_inbox->updateAll(array('msg_inbox.unread'=>0),array('msg_inbox.id'=>$msg_id));
				
			}
			
		}
		if($this->request->is('ajax')){
			
			$this->autoRender = false;
			$this->render('trash_view','ajax');
			
		}
       
    }
	function reply() {
			
		$this->loadModel('msg_inbox');
		$this->loadModel('msg_sent');
		
        $uid = $this->userInfo['users']['id'];
		
		$msg_id = $this->request->data['msg_id'];
		$page = $this->request->data['cat'];
		$this->set('cat', $this->request->data['cat']);
		$model = 'msg_'.$page;
		
			$data=$this->$model->find('first',array('fields'=>array(
					'
					'.$model.'.*,
					From.id,
					From.role_id,
					From.email,
					From.status,
					Sendto.id,
					Sendto.role_id,
					Sendto.email,
					Sendto.status,
					FromProfile.user_id,
					FromProfile.firstname,
					FromProfile.lastname,
					FromProfile.photo,
					ToProfile.user_id,
					ToProfile.firstname,
					ToProfile.lastname,
					ToProfile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = `'.$model.'`.`from_user_id`'
						),
						array(
							'alias' => 'Sendto',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`Sendto`.`id` = `'.$model.'`.`to_user_id`'
						),
						array(
							'alias' => 'FromProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`FromProfile`.`user_id` = `From`.`id`'
						),
						array(
							'alias' => 'ToProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`ToProfile`.`user_id` = `Sendto`.`id`'
						)
						
						
					),
					'conditions'=>array($model.'.id'=>$msg_id)));
			
			if($data[$model]['msg_parent_id']!=0){
				$redata=$this->$model->find('all',array('fields'=>array(
					'
					'.$model.'.*,
					From.id,
					From.role_id,
					From.email,
					From.status,
					Sendto.id,
					Sendto.role_id,
					Sendto.email,
					Sendto.status,
					FromProfile.user_id,
					FromProfile.firstname,
					FromProfile.lastname,
					FromProfile.photo,
					ToProfile.user_id,
					ToProfile.firstname,
					ToProfile.lastname,
					ToProfile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = '.$model.'.`from_user_id`'
						),
						array(
							'alias' => 'Sendto',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`Sendto`.`id` = `'.$model.'`.`to_user_id`'
						),
						array(
							'alias' => 'FromProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`FromProfile`.`user_id` = `From`.`id`'
						),
						array(
							'alias' => 'ToProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`ToProfile`.`user_id` = `Sendto`.`id`'
						)
						
						
					),
					'conditions'=>array($model.'.id'=>$data[$model]['msg_parent_id'])));
					$this->set('rerow', $redata);
			}
			$this->set('row', $data);
			if($page=='inbox' && $data[$model]['unread']==1){
				
				$this->$model->updateAll(array($model.'.unread'=>0),array($model.'.id'=>$msg_id));
				
			}
		
			if ($this->request->is('ajax')) {
				$this->autoRender = false;
				$this->render('reply','ajax');
			}
       
    }
	public function replyTo() {
			$this->layout = false;
			$this->autoRender = false;
            $this->loadModel('msg_inbox');
			$this->loadModel('msg_sent');
			$uid = $this->userInfo['users']['id'];
			//$this->set('cat', $this->request->data['cat']);
            $this->Email->template = 'message';
			$from_id = $this->request->data['from_id'];
			$to_id = $this->request->data['to_id'];
			$subject = $this->request->data['subject'];
			$message = $this->request->data['message'];
			$msg_id = $this->request->data['msg_id'];
			
			$this->msg_inbox->create();
			$this->request->data['msg_inbox']['from_user_id']= $from_id;
			$this->request->data['msg_inbox']['to_user_id']= $to_id;
			$this->request->data['msg_inbox']['subject']= $subject;
			$this->request->data['msg_inbox']['message']= $message;
			$this->request->data['msg_inbox']['msg_parent_id']=$msg_id;
			$this->request->data['msg_inbox']['unread']= 1;
			$this->request->data['msg_inbox']['type']= 'inbox';
			$this->request->data['msg_inbox']['status']= 2;
			
			if($this->msg_inbox->save($this->request->data)){
				
				$this->msg_sent->create();
				$this->request->data['msg_sent']['from_user_id']= $from_id;
				$this->request->data['msg_sent']['to_user_id']= $to_id;
				$this->request->data['msg_sent']['subject']= $subject;
				$this->request->data['msg_sent']['message']= $message;
				$this->request->data['msg_sent']['msg_parent_id']= $msg_id;
				$this->request->data['msg_sent']['unread']= 0;
				$this->request->data['msg_sent']['type']= 'sent';
				$this->request->data['msg_sent']['status']= 2;
				if($this->msg_sent->save($this->request->data)){
					/*
					$this->set('subject', $this->request->data['subject']);
					$this->set('email', $this->request->data['from_email']);
					$this->set('sendername', $this->request->data['To_name']);
					$this->set('data', $this->request->data['message']);
					$this->Email->sendAs = 'both';
					$this->Email->from = "NetworkWE<".$this->request->data['from_email'].">";
					$this->Email->to = $this->request->data['to_email'];
					$this->Email->subject = $this->request->data['subject'];
					$this->Email->_debug = true;
					$this->Email->smtpOptions = array(
						 'port'=>'25',
						 'timeout'=>'30',
						 'host' => 'host2.gulfbankers.com',
						 'username'=>'networkwe@networkwe.net',
						 'password'=>'Net12345',
						 'client' => 'NetworkWE'
					);

					 
					 $this->Email->delivery = 'smtp';
					if ($this->Email->send()) {
						
						$this->Session->setFlash(__('The email has been sent successfully!',true),'success_msg',array(),'email_sent');
						$this->redirect(array('action' => 'index/#reply'));
						
					}*/
					
					$strBody="";
					$email = $this->request->data['to_email'];
					$json_fields='{"api_key":"'.MAILER_API_KEY.'",
					"email_details":{"fromname":"'.$this->fullescape(MAILER_MESSAGE_COMPOSE_FROMNAME).'",
					"subject":"'.$this->fullescape($this->request->data['subject']).'","from":"'.MAILER_MESSAGE_COMPOSE_FROMEMAIL.'",
					"replytoid":"'.$this->request->data['from_email'].'",
					"content":"'.$this->fullescape($strBody).'"},
					"settings":{"template":"1078"},
					"recipients":["'.$email.'"],
					"attributes":{"CONNECTION_NAME":["'.$this->fullescape($this->request->data['subject']).'"],
					"NAME":["'.$this->userInfo['users_profiles']['firstname'].' '.$this->userInfo['users_profiles']['lastname'].'"],
					"TITLE":["'.$this->userInfo['users_profiles']['tags'].'"],
					"MSG_TEXT":["'.$this->fullescape($message).'"],
					"UNSUB_URL":["'.$this->fullescape(UNSUB_URL."?xEmail=".$email).'"]}}';
					
					//pr($json_fields);							
					
					$ch = curl_init();
					curl_setopt($ch,CURLOPT_URL, MAILER_SEND_API);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch,CURLOPT_POST, true);
					curl_setopt($ch,CURLOPT_POSTFIELDS, array('data' => $json_fields));
					$api_result = curl_exec($ch);
					curl_close($ch);
					if ($api_result == "success") {
						$this->Session->setFlash(__('The email has been sent successfully!',true),'success_msg',array(),'email_sent');
						$this->redirect(array('action' => 'index/#reply'));
					}
					
					
				}
			}
			
        
        
    }
	function forward() {
			
		$this->loadModel('msg_inbox');
		$this->loadModel('msg_sent');
		
        $uid = $this->userInfo['users']['id'];
		$msg_id = $this->request->data['msg_id'];
		$page = $this->request->data['cat'];
		$this->set('cat', $this->request->data['cat']);
		$model = 'msg_'.$page;
		
			$data=$this->$model->find('first',array('fields'=>array(
					'
					'.$model.'.*,
					From.id,
					From.role_id,
					From.email,
					From.status,
					Sendto.id,
					Sendto.role_id,
					Sendto.email,
					Sendto.status,
					FromProfile.user_id,
					FromProfile.firstname,
					FromProfile.lastname,
					FromProfile.photo,
					ToProfile.user_id,
					ToProfile.firstname,
					ToProfile.lastname,
					ToProfile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = `'.$model.'`.`from_user_id`'
						),
						array(
							'alias' => 'Sendto',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`Sendto`.`id` = `'.$model.'`.`to_user_id`'
						),
						array(
							'alias' => 'FromProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`FromProfile`.`user_id` = `From`.`id`'
						),
						array(
							'alias' => 'ToProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`ToProfile`.`user_id` = `Sendto`.`id`'
						)
						
						
					),
					'conditions'=>array($model.'.id'=>$msg_id)));
			
			if($data[$model]['msg_parent_id']!=0){
				$redata=$this->$model->find('all',array('fields'=>array(
					'
					'.$model.'.*,
					From.id,
					From.role_id,
					From.email,
					From.status,
					Sendto.id,
					Sendto.role_id,
					Sendto.email,
					Sendto.status,
					FromProfile.user_id,
					FromProfile.firstname,
					FromProfile.lastname,
					FromProfile.photo,
					ToProfile.user_id,
					ToProfile.firstname,
					ToProfile.lastname,
					ToProfile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = '.$model.'.`from_user_id`'
						),
						array(
							'alias' => 'Sendto',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`Sendto`.`id` = `'.$model.'`.`to_user_id`'
						),
						array(
							'alias' => 'FromProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`FromProfile`.`user_id` = `From`.`id`'
						),
						array(
							'alias' => 'ToProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`ToProfile`.`user_id` = `Sendto`.`id`'
						)
						
						
					),
					'conditions'=>array($model.'.id'=>$data[$model]['msg_parent_id'])));
					$this->set('rerow', $redata);
			}
			$this->set('row', $data);
			if($page=='inbox' && $data[$model]['unread']==1){
				
				$this->$model->updateAll(array($model.'.unread'=>0),array($model.'.id'=>$msg_id));
				
			}
			$this->loadModel('Connection');
			$conn= $this->Connection->find('all',array('conditions'=>array('AND' => array('Connection.request=1', 'OR'=> array('Connection.user_id'=>$uid,'Connection.friend_id'=>$uid)))));
			if($conn){
				foreach($conn as $row){
					if($uid == $row['Connection']['friend_id']){
						$connection = $row['Connection']['user_id'];
					}else{
						$connection = $row['Connection']['friend_id'];
					}
					//$findCon[] = $this->Users_profile->find('all',array('conditions'=>array('Users_profile.user_id'=>$row['Connection']['friend_id'])));
					$findCon[]=$this->Users_profile->find('all',array('fields'=>array(
					'
					
					Users_profile.user_id,
					Users_profile.firstname,
					Users_profile.lastname,
					Users_profile.photo,
					users.id,
					users.role_id,
					users.email,
					users.status
					'
					),
					 'joins' => array(
						array(
							'alias' => 'users',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`users`.`id` = `Users_profile`.`user_id`'
						)	
						
					),
					'conditions'=>array('Users_profile.user_id'=>$connection)));
				}
			
			$this->set('con',$findCon);
			}
		
			if ($this->request->is('ajax')) {
				$this->autoRender = false;
				$this->render('forward','ajax');
			}
       
    }
	public function compose() {
			//$this->layout = false;
			//$this->autoRender = false;
			$uid = $this->userInfo['users']['id'];
			$this->loadModel('Users_profile');
			$data=$this->Users_profile->find('first',array('fields'=>array(
					'
					From.id,
					From.role_id,
					From.email,
					From.status,
					Users_profile.user_id,
					Users_profile.firstname,
					Users_profile.lastname,
					Users_profile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = `Users_profile`.`user_id`'
						)	
						
					),
					'conditions'=>array('Users_profile.user_id'=>$uid)));
			$this->set('data',$data);
			$this->loadModel('Connection');
			$conn= $this->Connection->find('all',array('conditions'=>array('AND' => array('Connection.request=1', 'OR'=> array('Connection.user_id'=>$uid,'Connection.friend_id'=>$uid)))));
			if($conn){
				foreach($conn as $row){
					if($uid == $row['Connection']['friend_id']){
						$connection = $row['Connection']['user_id'];
					}else{
						$connection = $row['Connection']['friend_id'];
					}
					//$findCon[] = $this->Users_profile->find('all',array('conditions'=>array('Users_profile.user_id'=>$row['Connection']['friend_id'])));
					$findCon[]=$this->Users_profile->find('all',array('fields'=>array(
					'
					
					Users_profile.user_id,
					Users_profile.firstname,
					Users_profile.lastname,
					Users_profile.photo,
					users.id,
					users.role_id,
					users.email,
					users.status
					'
					),
					 'joins' => array(
						array(
							'alias' => 'users',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`users`.`id` = `Users_profile`.`user_id`'
						)	
						
					),
					'conditions'=>array('Users_profile.user_id'=>$connection)));
				}
			
			$this->set('con',$findCon);
			}
			
						
			if ($this->request->is('ajax')) {
				$this->autoRender = false;
				$this->render('compose','ajax');
			}
            
        
    }
	public function send(){
		//$this->layout = false;
		$this->autoRender = false;
		$uid = $this->userInfo['users']['id'];
		
		$this->loadModel('msg_inbox');
		
		if($this->request->data['fw_content']){
			$forward = $this->request->data['fw_content'];
			$forward2 = $this->request->data['fw_fw_content'];
			$message=$this->request->data['messaged'].'<div style="clear:both;"></div>'.$forward.'<div style="clear:both;"></div>'.$forward2;
			
		}else{
			$message=$this->request->data['messaged'];
		}
			
		//pr($this->request->data);exit;
		if((!empty($this->request->data['ms4'])) && (!empty($this->request->data['subject']))){
			$conEmail = $this->request->data['ms4'];
			$cm= str_replace(array('[',']','"','"'), '', $conEmail);
			$toids = explode(",", $cm);
			//$sdata= array_merge($sdata1,$cemail);
			$countIDs = $this->User->find('count',array('conditions'=>array('AND'=>array('User.id'=>$toids,'User.email !='=>''))));
			if($countIDs >0){
				foreach($toids as $ids){
					$toemail = $this->User->find('first',array('conditions'=>array('User.id'=>$ids)));
					$this->msg_inbox->create();
					$this->request->data['msg_inbox']['from_user_id']= $uid;
					$this->request->data['msg_inbox']['to_user_id']= $ids;
					$this->request->data['msg_inbox']['subject']= $this->request->data['subject'];
					$this->request->data['msg_inbox']['message']= $message;
					$this->request->data['msg_inbox']['msg_parent_id']= 0;
					$this->request->data['msg_inbox']['unread']= 1;
					$this->request->data['msg_inbox']['type']= 'inbox';
					$this->request->data['msg_inbox']['status']= 2;
					
					if($this->msg_inbox->save($this->request->data)){
						$this->loadModel('msg_sent');
						$this->msg_sent->create();
						$this->request->data['msg_sent']['from_user_id']= $uid;
						$this->request->data['msg_sent']['to_user_id']= $ids;
						$this->request->data['msg_sent']['subject']= $this->request->data['subject'];
						$this->request->data['msg_sent']['message']= $message;
						$this->request->data['msg_sent']['msg_parent_id']= 0;
						$this->request->data['msg_sent']['unread']= 0;
						$this->request->data['msg_sent']['type']= 'sent';
						$this->request->data['msg_sent']['status']= 2;
						
						
						if($this->msg_sent->save($this->request->data)){
						
							$this->Email->template = 'message';
							/*
							$this->set('subject', $this->request->data['subject']);
							$this->set('email', $this->request->data['from_email']);
							$this->set('sendername', $this->request->data['from_name']);
							$this->set('data', $message);
							$this->Email->sendAs = 'both';
							$this->Email->from = "NetworkWE<".$this->request->data['from_email'].">";
							$this->Email->to = $toemail['User']['email'];
							$this->Email->subject = $this->request->data['subject'];
							$this->Email->_debug = true;
							$this->Email->smtpOptions = array(
								 'port'=>'25',
								 'timeout'=>'30',
								 'host' => 'host2.gulfbankers.com',
								 'username'=>'networkwe@networkwe.net',
								 'password'=>'Net12345',
								 'client' => 'NetworkWE'
							);

							 
							 $this->Email->delivery = 'smtp';
							if ($this->Email->send()) {
								
								//$this->render('compose','ajax');
								//echo 'email Sent!';
								
							}*/
							//pr($toemail['User']['email']);
							$strBody="";
							$email = $toemail['User']['email'];
							$json_fields='{"api_key":"'.MAILER_API_KEY.'",
							"email_details":{"fromname":"'.$this->fullescape(MAILER_MESSAGE_COMPOSE_FROMNAME).'",
							"subject":"'.$this->fullescape($this->request->data['subject']).'","from":"'.MAILER_MESSAGE_COMPOSE_FROMEMAIL.'",
							"replytoid":"'.$this->request->data['from_email'].'",
							"content":"'.$this->fullescape($strBody).'"},
							"settings":{"template":"1078"},
							"recipients":["'.$email.'"],
							"attributes":{"CONNECTION_NAME":["'.$this->request->data['subject'].'"],
							"NAME":["'.$this->userInfo['users_profiles']['firstname'].' '.$this->userInfo['users_profiles']['lastname'].'"],
							"TITLE":["'.$this->userInfo['users_profiles']['tags'].'"],
							"MSG_TEXT":["'.$this->fullescape($message).'"],
							"UNSUB_URL":["'.$this->fullescape(UNSUB_URL."?xEmail=".$email).'"]}}';
							
							//pr($json_fields);							
							
							$ch = curl_init();
							curl_setopt($ch,CURLOPT_URL, MAILER_SEND_API);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch,CURLOPT_POST, true);
							curl_setopt($ch,CURLOPT_POSTFIELDS, array('data' => $json_fields));
							$api_result = curl_exec($ch);
							curl_close($ch);
							if ($api_result == "success") {
								$this->Session->setFlash(__('The email has been sent successfully!',true),'success_msg',array(),'email_sent');
								$this->render('compose','ajax');
							}
							
							
						}
						
					}
				
					
				}
				
				$this->Session->setFlash(__('The email has been sent successfully!',true),'success_msg',array(),'email_sent');
				$this->redirect(array('controller'=>'messages','action' => 'index/#compose'));
			}else{
				$this->Session->setFlash(__('No user found! please try again.',true),'error_msg',array(),'email_sent');
				$this->redirect(array('controller'=>'messages','action' => 'index/#compose'));
			}
			
		}else{
			$this->Session->setFlash(__('The email did not sent! please try again.',true),'error_msg',array(),'email_sent');
			$this->redirect(array('controller'=>'messages','action' => 'index/#compose'));
		}
		
			
		
		
		//$this->render('index');	
        
	}
	private function fullescape($in)
    {
	    $out = '';
	    $out = urlencode($in);
	    $out = str_replace('+','%20',$out);
	    $out = str_replace('_','%5F',$out);
	    $out = str_replace('.','%2E',$out);
	    $out = str_replace('-','%2D',$out);
	    return $out;
    } 
	public function msgtrash(){
		
		//$this->autoRender = false;
		$uid = $this->userInfo['users']['id'];		
		$this->loadModel('msg_inbox');
		$this->loadModel('msg_sent');
		$page = $this->request->data['cat'];
		
		$this->set('cat', $this->request->data['cat']);
		
		$data = $this->request->data['delcheckbox'];
		if($page=='trashList'){
				
				//$data=str_replace('on,','',$data);
				$data=str_replace(',0','',$data);
				foreach(explode(",",$data) as $row){
					
					$typearray = explode("-",$row);
					//pr($typearray);
					$model = 'msg_'.$typearray[1];
					$rec = $typearray[0];
					//pr($model);
					//pr($rec);
					
					$today='NOW()';
					$this->$model->updateAll(array($model.'.modified'=>$today,$model.'.status'=>1),array($model.'.id'=>$rec));
					
				}
				$this->Session->setFlash(__('Message has been deleted.',true),'success_msg',array(),'search_trash');
				$this->redirect(array('controller'=>'messages','action' => 'index/#inbox'));
		}else
		if($page=='inbox'){
			if(!empty($data)){
				$del_id = explode(",", $data);
				$i=0;
				 
				foreach($del_id as $row){
					$today='NOW()';
					//$this->msg_inbox->updateAll(array('msg_inbox.status'=>1),array('msg_inbox.id'=>$row));
					
						
					
					$this->msg_inbox->updateAll(array('msg_inbox.modified'=>$today,'msg_inbox.status'=>1),array('msg_inbox.id'=>$row));
						
					
				}
			
				$this->Session->setFlash(__('Message has been deleted.',true),'success_msg',array(),'inbox_trash');
				$this->redirect(array('controller'=>'messages','action' => 'index/#inbox'));
			}else{
				$this->Session->setFlash(__('The message cannot be deleted.',true),'error_msg',array(),'inbox_trash');
				$this->redirect(array('controller'=>'messages','action' => 'index/#inbox'));
			}
		}elseif($page=='sent'){
			if(!empty($data)){
				$del_id = explode(",", $data);
				$i=0;
				
				foreach($del_id as $row){
					$today='NOW()';
					//$this->msg_inbox->updateAll(array('msg_inbox.status'=>1),array('msg_inbox.id'=>$row));
					
					$this->msg_sent->updateAll(array('msg_sent.modified'=>$today,'msg_sent.status'=>1),array('msg_sent.id'=>$row));
										
				}
			
				$this->Session->setFlash(__('Message has been deleted.',true),'success_msg',array(),'sent_trash');
				$this->redirect(array('controller'=>'messages','action' => 'index/#inbox'));
			}else{
				$this->Session->setFlash(__('The message cannot be deleted.',true),'error_msg',array(),'sent_trash');
				$this->redirect(array('controller'=>'messages','action' => 'index/#inbox'));
			}
		
		}
        
	}
	public function undelete(){
		
		$uid = $this->userInfo['users']['id'];		
		$this->loadModel('msg_inbox');
		$this->loadModel('msg_sent');
		$page = $this->request->data['cat'];
		
		$this->set('cat', $this->request->data['cat']);
		$data = $this->request->data['delcheckbox'];
		
		if(!empty($data)){
			if($page=='undeleteList'){
				
				$data=str_replace('on,','',$data);
				$data=str_replace(',0','',$data);
				foreach(explode(",",$data) as $row){
					
					$typearray = explode("-",$row);
					//pr($typearray);
					$model = 'msg_'.$typearray[1];
					$rec = $typearray[0];
					//pr($model);
					//pr($rec);
					
					$today='NOW()';
					$this->$model->updateAll(array($model.'.modified'=>$today,$model.'.status'=>2),array($model.'.id'=>$rec));
					
				}
			}else{
				
			
				$data=str_replace(',','',$data);
				
					
					$typearray = explode("-",$data);
					//pr($typearray);
					$model = 'msg_'.$typearray[1];
					$rec = $typearray[0];
					//pr($model);
					//pr($rec);
					$today='NOW()';
					$this->$model->updateAll(array($model.'.modified'=>$today,$model.'.status'=>2),array($model.'.id'=>$rec));
				
			}
			//die();
			/*
			$typearray = explode("-",$data);
			$type = explode(",",$typearray[1]);
					
				$model = 'msg_'.$type[0];
				$del_id = explode(",", str_replace("-".$type[0],"",$data));
				pr($del_id);
				*/
				
			/*	$i=0;
				
				foreach($del_id as $row){
					$today='NOW()';
					$this->$model->updateAll(array($model.'.modified'=>$today,$model.'.status'=>2),array($model.'.id'=>$row));
					
				}*/
			
			$this->redirect(array('controller'=>'messages','action' => 'index/#inbox'));
		}else{
			$this->redirect(array('controller'=>'messages','action' => 'index/#inbox'));
		}
		
        
	}
	public function permdelete(){
		
		$uid = $this->userInfo['users']['id'];		
		$this->loadModel('msg_inbox');
		$this->loadModel('msg_sent');
		$page = $this->request->data['cat'];
		
		$this->set('cat', $this->request->data['cat']);
		$data = $this->request->data['delcheckbox'];
		
		if(!empty($data)){
			if($page=='deleteList'){
				
				$data=str_replace('on,','',$data);
				$data=str_replace(',0','',$data);
				foreach(explode(",",$data) as $row){
					$typearray = explode("-",$row);
					$model = 'msg_'.$typearray[1];
					$rec = $typearray[0];
					
					$this->$model->delete($rec);
					
					
				}
			}else{
				$data=str_replace(',','',$data);
				$typearray = explode("-",$data);				
				$model = 'msg_'.$typearray[1];
				$rec = $typearray[0];					
				$this->$model->delete($rec);
			}
		
			$this->redirect(array('controller'=>'messages','action' => 'index/#inbox'));
		}else{
			$this->redirect(array('controller'=>'messages','action' => 'index/#inbox'));
		}
		
        
	}
	
	function searchMail() {
			
		$this->loadModel('msg_inbox');
		$this->loadModel('msg_sent');
        $uid = $this->userInfo['users']['id']; 
		$this->set('uid',$uid);
		$page = $this->request->data['page'];
		$keyword = $this->request->data['keyword'];
		
		$this->paginate=array('fields'=>array(
					'
					msg_inbox.*,
					From.id,
					From.role_id,
					From.email,
					From.status,
					FromProfile.user_id,
					FromProfile.firstname,
					FromProfile.lastname,
					FromProfile.photo
					
					'
					),
					 'joins' => array(
						array(
							'alias' => 'From',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`From`.`id` = `msg_inbox`.`from_user_id`'
						),
						
						array(
							'alias' => 'FromProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`FromProfile`.`user_id` = `From`.`id`'
						),
						
					), 
					'conditions'=>array('AND'=>array('msg_inbox.status=2','msg_inbox.to_user_id'=>$uid,'OR'=>array('From.email LIKE'=>'%'.$keyword.'%','FromProfile.firstname LIKE'=>'%'.$keyword.'%','FromProfile.lastname LIKE'=>'%'.$keyword.'%','msg_inbox.subject LIKE'=>'%'.$keyword.'%','msg_inbox.message LIKE'=>'%'.$keyword.'%'))),'order'=>'msg_inbox.created desc');
					$msg_inbox = $this->paginate('msg_inbox');
			
			$this->paginate=array('fields'=>array(
					'
					msg_sent.*,
					Sendto.id,
					Sendto.role_id,
					Sendto.email,
					Sendto.status,
					ToProfile.user_id,
					ToProfile.firstname,
					ToProfile.lastname,
					ToProfile.photo
					'
					),
					 'joins' => array(
						array(
							'alias' => 'Sendto',
							'table' => 'users',
							'type' => 'LEFT',
							'conditions' => '`Sendto`.`id` = `msg_sent`.`to_user_id`'
						),
						array(
							'alias' => 'ToProfile',
							'table' => 'users_profiles',
							'type' => 'LEFT',
							'conditions' => '`ToProfile`.`user_id` = `Sendto`.`id`'
						)
						
						
					),
					'conditions'=>array('AND'=>array('msg_sent.status=2','msg_sent.from_user_id'=>$uid,'OR'=>array('ToProfile.firstname LIKE'=>'%'.$keyword.'%','ToProfile.lastname LIKE'=>'%'.$keyword.'%','Sendto.email LIKE'=>'%'.$keyword.'%','msg_sent.subject LIKE'=>'%'.$keyword.'%','msg_sent.message LIKE'=>'%'.$keyword.'%'))),'order'=>'msg_sent.created desc');
			$msg_sent = $this->paginate('msg_sent'); 
			$data=array_merge($msg_sent,$msg_inbox);
			$this->set(compact('data'));
		
			if ($this->request->is('ajax')) {
				$this->autoRender = false;
				$this->render('search_mail','ajax');
			}
       
        
        
    }

    
}
?>
