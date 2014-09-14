<?php

class PostCategoriesController extends AppController {

    var $name = 'PostCategories';
    var $helpers = array('Form', 'html', 'DatePicker');
    var $components = array('Auth');
    //'ImageResize'

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
		
	}
	public function add_category() {
		if ($this->Session->read(@$userid)) {
			$cuser = $this->Session->read(@$userid);
			$uid = $cuser['userid']; 
			
		}
		if ($this->request->is('post')) {
			$category_title = $_POST["category_title"];
			$this->request->data['post_categories']['title'] = $category_title;
			$created_date = date("Y-m-d H:i:s");
			$this->request->data['post_categories']['created'] = $created_date;
			$this->request->data['post_categories']['modified'] = $created_date;
			if (ClassRegistry::init('post_categories')->save($this->request->data)) {
				
				$list_categories = ClassRegistry::init('post_categories')->find('all');
				$this->set('list_categories',$list_categories);
			}
		}
		$this->autorender = false;
	    $this->layout = false;
	    $this->render('add_category');
	}
	
	public function add_tags() {
		if ($this->Session->read(@$userid)) {
			$cuser = $this->Session->read(@$userid);
			$uid = $cuser['userid']; 
			
		}
		if ($this->request->is('post')) {
			$post_tags = $_POST["tags"];
			$post_tags = @explode(',',$post_tags);
			print_r($post_tags);
			echo $total = sizeof($post_tags);
			for($i=0;$i<sizeof($post_tags);$i++) {
				$this->request->data = '';
				$this->request->data['post_tags']['tag'] = $post_tags[$i];
				$this->request->data['post_tags']['user_id'] = $uid;
				if (ClassRegistry::init('post_tags')->save($this->request->data)) {
				
				}
			}
		}
			
	}
}
?>