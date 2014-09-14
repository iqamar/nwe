<?php
Class PressReleasesController extends AppController{
    //var $name = 'Press Releases';
    //var $helpers = array('Form', 'html', 'DatePicker');
     var $components = array('Auth','Email','RequestHandler');
    //var $jobs = array('Job', 'jobs_description', 'jobs_functional_area', 'jobs_keyword', 'jobs_location', 'jobs_qualifications');

    function beforeFilter() {
	parent::beforeFilter();


	$this->Auth->allow();
	
	switch ($this->request->params['action']) {
	    case 'index':
	    case 'admin':
		$this->Security->validatePost = false;
	}
    }
	
    public function index() {
	  
		$this->loadModel('press_release');
	  
		$conditions=array('press_release.publish'=>1);
		$this->paginate=array('conditions'=>$conditions, 'order'=>'press_release.created DESC','limit'=>10);
		
		$this->set('press_releases',$this->paginate('press_release'));
	}
	
	function admin_index(){
		$this->set('press', ClassRegistry::init('press_releases')->find('all'));
                $this->set('categories', ClassRegistry::init('press_categories')->find('all'));
	}
	
    function admin_add(){
        if ($this->request->is('post')){
            
//            $ext = pathinfo($this->request->data['logo']['name'], PATHINFO_EXTENSION);
//	    $news_logo = strtotime(date('m/d/Y h:i:s a', time())) . "." . $ext;
//	    $filename = WWW_ROOT . 'files/news_logo/' . $news_logo;
//	    
//	    move_uploaded_file($this->request->data['logo']['tmp_name'], $filename);
            
            if($this->request->data['form']['logo']['error'] < 1){
                $ext = pathinfo($this->request->params['form']['logo']['name'], PATHINFO_EXTENSION);
                $imageName = strtotime(date('m/d/Y h:i:s a', time())) . '.' . $ext;
                $filename = $imageName;
                move_uploaded_file($this->request->params['form']['logo']['tmp_name'], $filename);
            }
            
            $formData = array('headline' => $this->request->data('headline'),
                'details' => $this->request->data('details'),
                'image_url' => '/files/press_logo/'.$imageName,
                'category' => json_encode($this->request->data('cat')),
                'country' => $this->request->data('locations'),
                'city' => $this->request->data('city'),
                'organization_info' => $this->request->data('org_info'),
                'contact_info' => $this->request->data('contact_info'),
                'publish' => $this->request->data('publish')       
                );
            
                if(ClassRegistry::init('press_releases')->save($formData)){
                    
                    $this->Session->setFlash(___('The press has been submitted '), 'flash_message ', array('plugin' => 'alaxos'));
                    $this->redirect('/admin/press');
                   // $this->redirect($this->referer(array('action' => 'index')));
                }
 else {
     $this->Session->setFlash(___("The press couldn't be saved, please check the inputs and try again."), 'flash_error', array('plugin' => 'alaxos'));
 }
        }
        else{
        $this->set('countries', ClassRegistry::init('countries')->find('all'));
        $this->set('categories', ClassRegistry::init('press_categories')->find('all'));
        }
    }
    
    function admin_view($id){
        
        if(!ClassRegistry::init('press_releases')->find('first', array('conditions' => array('id' => $id)))){
            echo "Invalid press ID";
            $this->autoRender = FALSE;
            end();
        }
        
        $press = ClassRegistry::init('press_releases')->find('all', array('conditions' => array('id' => $id)));
        $country = ClassRegistry::init('countries')->find('first', array('conditions' => array('id' => $press[0]['press_releases']['country'])));
        $this->set('press', $press);
        $this->set('country', $country);
    }
    
    function admin_edit($id){
        
        if(!ClassRegistry::init('press_releases')->find('all', array('conditions' => array('id' => $id)))){
            echo "Invalid press ID";
            $this->autoRender = FALSE;
            end();
        }
        
         $imageResult = ClassRegistry::init('press_releases')->find('first', array('conditions' => array('id' => $id)));
           $imageName = $imageResult['press_releases']['image_url'];
           $this->set('imageName', $imageName);
           
                if ($this->request->is('post')){
           
          // $imageResult = ClassRegistry::init('news')->find('all', array('conditions' => array('id' => $id)));
          // $imageName = $imageResult['news']['image_url'];
          // $this->set('imageName', $imageResult);
                   
           if($this->request->data['form']['logo']['error'] < 1){
                $ext = pathinfo($this->request->params['form']['logo']['name'], PATHINFO_EXTENSION);
                $imageName = strtotime(date('m/d/Y h:i:s a', time())) . '.' . $ext;
                $filename = WWW_ROOT . 'files/press_logo/' . $imageName;
                move_uploaded_file($this->request->params['form']['logo']['tmp_name'], $filename);
                $imageName = '/files/press_logo/'.$imageName;
            }
   
       
            $formData = array('headline' => $this->request->data('headline'),
                'details' => $this->request->data('details'),
                'image_url' => $imageName,
                'category' => json_encode($this->request->data('cat')),
                'country' => $this->request->data('locations'),
                'city' => $this->request->data('city'),
                'organization_info' => $this->request->data('org_info'),
                'contact_info' => $this->request->data('contact_info'),
                'publish' => $this->request->data('publish')       
                );
                ClassRegistry::init('press_releases')->id = $id;
                if(ClassRegistry::init('press_releases')->save($formData)){
                    
                    $this->Session->setFlash(___('The press has been submitted '), 'flash_message ', array('plugin' => 'alaxos'));
                    $this->redirect('/admin/press');
                }
 else {
     $this->Session->setFlash(___("The press couldn't be saved, please check the inputs and try again."), 'flash_error', array('plugin' => 'alaxos'));
 }
        }
        else{
        
        $data = ClassRegistry::init('press_releases')->find('first', array('conditions' => array('id' => $id)));   
        //print_r($data);
        $this->set('data', $data);
        $this->set('countries', ClassRegistry::init('countries')->find('all'));
        $this->set('country', ClassRegistry::init('countries')->find('first', array('conditions' => array('id' => $data['press_releases']['country']))));
        }
    }
    
    function admin_delete($id){
    if(ClassRegistry::init('press_releases')->delete($id)){
        $this->redirect($this->referer(array('action' => 'index')));
    }
    else{
        throw new NotFoundException(___('invalid press id'));
    }
        
    }
    
       function admin_categories(){
        $categories = ClassRegistry::init('press_categories')->find('all');
        $this->set('categories', $categories);
    }
    
    function admin_addCategory(){
        if($this->request->is('post')){
            $formData = array('category' => $this->request->data('category_name'));
            ClassRegistry::init('press_categories')->save($formData);
                $this->redirect('/admin/press/categories');
        }
    }
    
    function admin_deleteCategory($id){
        if(ClassRegistry::init('press_categories')->delete($id)){
            $this->redirect('/admin/press/categories');
        }
        
    }
    
    function admin_editCategory($id){
        if($this->request->is('post')){
            $formData = array('category' => $this->request->data('category_name'));
            ClassRegistry::init('press_categories')->id = $id;
            if(ClassRegistry::init('press_categories')->save($formData)){
                $this->redirect('/admin/press/categories');
            }
            
        }
        else{
            $this->set('category', ClassRegistry::init('press_categories')->find('first', array('conditions' => array('id' => $id))));
        }
    }
	
 public function view() {
	 	$cuser = $this->Session->read(@$userid);
	 	$uid = $cuser['userid'];
		$this->params['pass'];
		$paramenter = $this->params['pass'];
		$press__ID = $paramenter[0];
		if ($press__ID !=0) {
		 	   $press_detail = ClassRegistry::init('press_releases')->find('all',array('fields'=>array('press_releases.*,users_profiles.firstname, users_profiles.lastname, users_profiles.handler'),
																  'joins'=>array(
																				 array('alias' => 'users_profiles', 'table' => 'users_profiles', 'foreignKey' => false,
																					   'conditions' => array('press_releases.user_id = users_profiles.user_id'))),
														  'conditions'=>array('press_releases.publish=1 AND press_releases.id='.$press__ID),'order'=>'press_releases.id DESC'));
	    $this->set('press_detail',$press_detail);	
			
	}
  } // view method end here
  
      function press_pdf() { 
		Configure::write('debug',0);
		$this->params['pass'];
		$paramenter = $this->params['pass'];
		$press__ID = $paramenter[0];
		ini_set('memory_limit', '1024M');
		if ($press__ID !=0) {
			 $press_detail_pdf = ClassRegistry::init('press_releases')->find('all',array('fields'=>array('press_releases.*,users_profiles.firstname, users_profiles.lastname, users_profiles.handler'),
																  'joins'=>array(
																				 array('alias' => 'users_profiles', 'table' => 'users_profiles', 'foreignKey' => false,
																					   'conditions' => array('press_releases.user_id = users_profiles.user_id'))),
														  'conditions'=>array('press_releases.publish=1 AND press_releases.id='.$press__ID),'order'=>'press_releases.id DESC'));

	   		$this->set('press_detail_pdf', $press_detail_pdf);
		}	
    }
}