<?php

Class PressController extends AppController{
    
    
    //var $name = 'Press Releases';
    //var $helpers = array('Form', 'html', 'DatePicker');
    //var $components = array('Auth');
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
    
	function admin_index(){
		$this->set('press', ClassRegistry::init('press_releases')->find('all'));
                $this->set('categories', ClassRegistry::init('press_categories')->find('all'));
	}
	
    function admin_add(){
        $userID = $this->Session->read(@$userid);
        
        if ($this->request->is('post')){
            if ($this->request->data['form']['logo']['error'] < 1) {
                $ext = pathinfo($this->request->params['form']['logo']['name'], PATHINFO_EXTENSION);
                $imageName = strtotime(date('m/d/Y h:i:s a', time())) . '.' . $ext;

               $this->__imageresize($this->request->params['form']['logo']['tmp_name'], MEDIA_PATH."/files/press/thumbnail/$imageName",80,80); 
               $this->__imageresize($this->request->params['form']['logo']['tmp_name'], MEDIA_PATH."/files/press/logo/$imageName",165,165); 
               $this->__imageresize($this->request->params['form']['logo']['tmp_name'], MEDIA_PATH."/files/press/icon/$imageName",45,45); 
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
                  $catlist = $this->request->data('cat');
                if(ClassRegistry::init('press_releases')->save($formData)){
                    $last_press_id = ClassRegistry::init('press_releases')->getInsertID();
                    $category = array();
                    for ($i = 0; $i < sizeof($catlist); $i++) {
                    
                    $category = array('press_id' => $last_press_id, 'category_id' => $catlist[$i], 'user_id' => $userID['userid']);
                    ClassRegistry::init('category_presses')->create();
                    ClassRegistry::init('category_presses')->save($category);
                    
                   // $this->redirect($this->referer(array('action' => 'index')));
                    }
                    
                    //$this->Session->setFlash(___('The press has been submitted '), 'flash_message ', array('plugin' => 'alaxos'));
                    $this->redirect('/admin/press');
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
           
                if ($this->request->data['form']['logo']['error'] < 1) {
                $ext = pathinfo($this->request->params['form']['logo']['name'], PATHINFO_EXTENSION);
                $imageName = strtotime(date('m/d/Y h:i:s a', time())) . '.' . $ext;

               $this->__imageresize($this->request->params['form']['logo']['tmp_name'], MEDIA_PATH."/files/press/thumbnail/$imageName",80,80); 
               $this->__imageresize($this->request->params['form']['logo']['tmp_name'], MEDIA_PATH."/files/press/logo/$imageName",165,165); 
               $this->__imageresize($this->request->params['form']['logo']['tmp_name'], MEDIA_PATH."/files/press/icon/$imageName",45,45); 
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
                    
                   
//                    $category = array();
//                    $catlist = $this->request->data('cat');
//                    for ($i = 0; $i < sizeof($catlist); $i++) {
//                    
//                    $category = array('press_id' => $id, 'category_id' => $catlist[$i], 'user_id' => $userID['userid']);
//                    ClassRegistry::init('category_presses')->press_id = $id;
//                    ClassRegistry::init('category_presses')->create();
//                    ClassRegistry::init('category_presses')->save($category);
//                    }
                
                   // $this->Session->setFlash(___('The press has been submitted '), 'flash_message ', array('plugin' => 'alaxos'));
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
        $this->set('categories', ClassRegistry::init('press_categories')->find('all'));
        //$this->set('selectedCategories', ClassRegistry::init('category_presses')->find('all', array('conditions' => array('press_id' => $id))));
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
}