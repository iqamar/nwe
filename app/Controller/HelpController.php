<?php

Class HelpController extends AppController{

    

    var $name = 'Help';

    var $helpers = array('Form', 'html', 'DatePicker');

    var $components = array('Auth');

    

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

        $categories = ClassRegistry::init('help_categories')->find('all');

        $this->set('categories', $categories);

    }

    

    function admin_all(){

        

        

    }

    

    function admin_add(){

        if ($this->request->is('post')) {

            $formData = array(

              'article' => $this->request->data('article'),

                'details' => $this->request->data('details'),

                'category_id' => $this->request->data('category')

            );

			

			ClassRegistry::init('help_sections')->save($formData);

                        $this->redirect('/admin/help');

        }

        else{

            $helpData = ClassRegistry::init('help_sections')->find('all');

            $helpCategory = ClassRegistry::init('help_categories')->find('all');

            

            $this->set('helpData', $helpData);

            $this->set('helpCategory', $helpCategory);

        }

        

    }

    

    function admin_edit($id){

        

        if ($this->request->is('post')){

            

            $formData = array(

              'article' => $this->request->data('article'),

                'details' => $this->request->data('details'),

                'category_id' => $this->request->data('category')

            );

            ClassRegistry::init('help_sections')->id = $id;

            ClassRegistry::init('help_sections')->save($formData);

            $this->redirect('/admin/help');

        }

        else{

            

        $press = ClassRegistry::init('help_sections')->find('first', array('conditions' => array('id' => $id)));

        $helpCategory = ClassRegistry::init('help_categories')->find('first', array('conditions' => array('id' => $press['help_sections']['category_id'])));

        $categories = ClassRegistry::init('help_categories')->find('all');

        $this->set('press', $press);

        $this->set('helpCategory', $helpCategory);

        $this->set('categories', $categories);

        

        }

    }

    

    function admin_view($id){

    	$helpArticle = ClassRegistry::init('help_sections')->find('first', array('conditions' => array('id' => $id)));

        $this->set('helpArticle', $helpArticle);

}



function admin_delete($id){

    

    if(ClassRegistry::init('help_sections')->delete($id)){

        $this->redirect('/admin/help');

    }

    else{

        throw new NotFoundException(___('invalid news id'));

    }

        

    }



    function admin_categories(){

        $categories = ClassRegistry::init('help_categories')->find('all');

        $this->set('categories', $categories);

    }

    

    function admin_addCategory(){

        if($this->request->is('post')){

            $formData = array('category_name' => $this->request->data('category_name'));

            ClassRegistry::init('help_categories')->save($formData);

                $this->redirect('/admin/help/categories');

        }

    }

    

    function admin_deleteCategory($id){

        if(ClassRegistry::init('help_categories')->delete($id)){

            $this->redirect('/admin/help/categories');

        }

        

    }

    

    function admin_editCategory($id){

        if($this->request->is('post')){

            $formData = array('category_name' => $this->request->data('category_name'));

            ClassRegistry::init('help_categories')->id = $id;

            if(ClassRegistry::init('help_categories')->save($formData)){

                $this->redirect('/admin/help/categories');

            }

            

        }

        else{

            $this->set('category', ClassRegistry::init('help_category')->find('first', array('conditions' => array('id' => $id))));

        }

    }

    

    }