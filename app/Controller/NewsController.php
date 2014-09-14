<?php
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

Class NewsController extends AppController {

    var $name = 'News';
    var $helpers = array('Form', 'html', 'DatePicker');
    var $components = array('Auth', 'Email', 'RequestHandler','ImageUploader');
    var $uses = array('News','Category_news');

    function beforeFilter() {
        parent::beforeFilter();
        Configure::write('debug', 2);
        $this->user_id = $this->Session->read('userid');//$this->userInfo['users']['id'];

        $this->Auth->allow();
        switch ($this->request->params['action']) {
            case 'index':
            case 'admin':
                $this->Security->validatePost = false;
        }
		
    }

   public function admin_datatable_source (){
        $table = 'news';
        $primaryKey = 'id';
        $columns = array(
            array( 'db' => 'heading', 'dt' => 0 ),
            array(
                'db' => 'created',
                'dt' => 1,
                'formatter' => function( $d, $row ) {
                    return date( 'jS M y', strtotime($d));
                }
            ),
            array('db'=> 'id', 'dt' => 2)
        );
        App::uses('ConnectionManager', 'Model');
        $dataSource = ConnectionManager::getDataSource('default');
        $sql_details = array(
            'user' => $dataSource->config['login'],
            'pass' => $dataSource->config['password'],
            'db'   => $dataSource->config['database'],
            'host' => $dataSource->config['host']
        );
        require( APP . 'Vendor' . DS . 'Datatables/ssp.class.php' );

        $this->layout = $this->autoRender = false;
        $this->response->type('json');
        $this->response->body(json_encode(SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )));
    }

    function admin_index() {
		/*$news = $this->News->find('all', array(
            'order' => 'News.id DESC'
        ));*/
		$categories = ClassRegistry::init('news_categories')->find('all');
		$this->set(compact('news', 'categories'));
    }

    function admin_add() {
        if ($this->request->is('post')) {
            $data = array();
            $data['News']['heading'] = $this->request->data('heading');
            $data['News']['details'] = $this->request->data('details');
            $data['News']['country'] = $this->request->data('country');
            $data['News']['news_url'] = $this->request->data('news_url');
            $data['News']['rss_link'] = $this->request->data('rss_link');
            $data['News']['publish'] = $this->request->data('publish');
            $data['News']['created'] = date('Y-m-d H:i:s');
            $data['News']['user_id'] = $this->user_id;
            $data['News']['share'] = 0;
            
            if ($this->request->data['form']['logo']['error'] < 1){
                $logo = $this->ImageUploader->upload($this->request->params['form']['logo'], 'news', TRUE, TRUE, TRUE);
                $data['News']['image_url'] = $logo;
            }
            
            if ($this->News->save($data)) {
                $news_id = $this->News->getLastInsertID();
                if(sizeof($this->request->data('category'))>0){
                    $insert_data_0[] = array();
                    $i = 0;
                    foreach ($this->request->data('category') as $category_id) {
                        $insert_data_0[$i]['Category_news']['news_id'] = $news_id;
                        $insert_data_0[$i]['Category_news']['category_id'] = $category_id;
                        $insert_data_0[$i]['Category_news']['user_id'] = $this->user_id;
                        $i++;
                    }
                    $this->Category_news->create();
                    $this->Category_news->saveAll($insert_data_0); 
                }
            }
            $this->Session->setFlash('Successfully saved data.', 'custom_flash', array('params' => array('noty_class' => 'success')), 'admin_flash');
            $this->redirect(array('controller' => 'news', 'action' => 'index'));
        } else {
            $countries = ClassRegistry::init('Country')->find('all');
            $categories = ClassRegistry::init('News_category')->find('all');
            $this->set(compact('countries','categories'));
        }
    }

    function admin_view($id) {
        $news = $this->News->findById($id);
        if(empty($news)){
            $this->Session->setFlash('Error: Cannot find requested information, either moved or deleted.', 'custom_flash', array('params' => array('noty_class' => 'error')), 'admin_flash');
            $this->redirect(array('controller' => 'news', 'action' => 'index'));
        } else {
            $categories = ClassRegistry::init('News_category')->find('all');
            $this->set(compact('news','categories'));
        }
    }

    function admin_edit($id = -1) {
        $this->News->id = $id;
        if (!$this->News->exists()) {
            $this->Session->setFlash('Error: Cannot find requested information, either moved or deleted.', 'custom_flash', array('params' => array('noty_class' => 'error')), 'admin_flash');
            //throw new NotFoundException(__('Invalid user'));
            $this->redirect(array('controller' => 'news', 'action' => 'index'));
        }
        
        $data = $this->News->findById($id);

        if ($this->request->is('post')) {
            $insert_data = array();
            $insert_data['News']['heading'] = $this->request->data('heading');
            $insert_data['News']['details'] = $this->request->data('details');
            $insert_data['News']['country'] = $this->request->data('country');
            $insert_data['News']['news_url'] = $this->request->data('news_url');
            $insert_data['News']['rss_link'] = $this->request->data('rss_link');
            $insert_data['News']['publish'] = $this->request->data('publish');
            $insert_data['News']['created'] = date('Y-m-d H:i:s');
            $insert_data['News']['user_id'] = $this->user_id;
            $insert_data['News']['share'] = 0;

            if ($this->request->data['form']['logo']['error'] < 1 && !empty($this->request->params['form']['logo']['tmp_name'])){
                $logo = $this->ImageUploader->upload($this->request->params['form']['logo'], 'news', TRUE, TRUE, TRUE);
                $insert_data['News']['image_url'] = $logo;
                if ($logo) {
                    $path_logo = MEDIA_PATH . 'files' . DS . 'news' . DS . 'thumbnail' . DS . $data['News']['image_url'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_logo = MEDIA_PATH . 'files' . DS . 'news' . DS . 'original' . DS . $data['News']['image_url'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_logo = MEDIA_PATH . 'files' . DS . 'news' . DS . 'logo' . DS . $data['News']['image_url'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_logo = MEDIA_PATH . 'files' . DS . 'news' . DS . 'icon' . DS . $data['News']['image_url'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_logo = MEDIA_PATH . 'files' . DS . 'news' . DS . 'cover' . DS . $data['News']['image_url'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                }
            }
            //pr($insert_data);
            $this->News->create();
            $this->News->id = $id;
            if ($this->News->save($insert_data)) {
                if(sizeof($this->request->data('category'))>0){
                    ClassRegistry::init('Category_news')->deleteAll(array('news_id' => $id));
                    $insert_data_0[] = array();
                    $i = 0;
                    foreach ($this->request->data('category') as $category_id) {
                        $insert_data_0[$i]['Category_news']['news_id'] = $id;
                        $insert_data_0[$i]['Category_news']['category_id'] = $category_id;
                        $insert_data_0[$i]['Category_news']['user_id'] = $this->user_id;
                        $i++;
                    }
                    $this->Category_news->create();
                    $this->Category_news->saveAll($insert_data_0); 
                }
                $this->Session->setFlash('Saved changes.', 'custom_flash', array('params' => array('noty_class' => 'success')), 'admin_flash');
            } else {
                $this->Session->setFlash('Error: Unable to save changes!.', 'custom_flash', array('params' => array('noty_class' => 'error')), 'admin_flash');
            }
            $this->redirect(array('controller' => 'news', 'action' => 'index'));
        } else {
            $countries = ClassRegistry::init('Country')->find('all');
            $categories = ClassRegistry::init('News_category')->find('all');
            $current_cat = ClassRegistry::init('Category_news')->find('list', array(
                'fields' => array('Category_news.category_id'),
                'conditions' => array('Category_news.news_id' => $id)
            ));
            $this->set(compact('data','countries','categories','current_cat'));
        }
    }

    function admin_delete($id) {
        $this->layout = $this->autoRender = false;
        $news = $this->News->findById($id);
        if(empty($news)){
            $this->Session->setFlash('Error: Cannot find requested information, either moved or deleted.', 'custom_flash', array('params' => array('noty_class' => 'error')), 'admin_flash');
            $this->redirect(array('controller' => 'news', 'action' => 'index'));
        } else {
            if($this->News->delete($id)){
                if (!empty($news['News']['image_url'])) {
                    $path_logo = MEDIA_PATH . 'files' . DS . 'news' . DS . 'thumbnail' . DS . $news['News']['image_url'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_logo = MEDIA_PATH . 'files' . DS . 'news' . DS . 'original' . DS . $news['News']['image_url'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_logo = MEDIA_PATH . 'files' . DS . 'news' . DS . 'logo' . DS . $news['News']['image_url'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_logo = MEDIA_PATH . 'files' . DS . 'news' . DS . 'icon' . DS . $news['News']['image_url'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_logo = MEDIA_PATH . 'files' . DS . 'news' . DS . 'cover' . DS . $news['News']['image_url'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                }
                
                $categories = $this->Category_news->findAllByNewsId($id);
                foreach ($categories as $news_category_id){
                    $this->Category_news->delete($news_category_id['Category_news']['id']);
                }
                $this->Session->setFlash('Removed data and all related informations.', 'custom_flash', array('params' => array('noty_class' => 'success')), 'admin_flash');
            } else {
                $this->Session->setFlash('Unable to delete data.', 'custom_flash', array('params' => array('noty_class' => 'error')), 'admin_flash');
            }
        }
        $this->redirect(array('controller' => 'news', 'action' => 'index'));
        /*if (ClassRegistry::init('news')->delete($id)) {
            $this->redirect($this->referer(array('action' => 'index')));
        } else {
            throw new NotFoundException(___('invalid news id'));
        }*/
    }

    /*     * ************************************** User End NewsControler methods*********************************************************************** */

    public function index() {
		
        $uid = $this->userInfo['users']['id'];

        /* News listing on user side */
        $this->loadModel('News');
        $news_lists = $this->News->find('all', array('fields' => array('News.*,countries.name,users_profiles.firstname,users_profiles.lastname,users_profiles.user_id,users_profiles.handler'),
            'joins' => array(array('alias' => 'countries', 'table' => 'countries', 'foreignKey' => false,
                    'conditions' => array('News.country = countries.id')),
                array('alias' => 'users_profiles', 'table' => 'users_profiles', 'foreignKey' => false,
                    'conditions' => array('News.user_id = users_profiles.user_id'))),
            'conditions' => array('News.publish=1'), 'order' => 'News.id DESC', 'limit' => 6));
        $this->set('news_lists', $news_lists);

        /* News categories listing on user side */
        $news_categories = ClassRegistry::init('news_categories')->find('all');
        $this->set('news_categories', $news_categories);

        /* get news's countries */
        $country_news = ClassRegistry::init('News')->find('all', array('fields' => array('DISTINCT News.country,countries.id,countries.name'),
            'joins' => array(array('alias' => 'countries', 'table' => 'countries', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('News.country = countries.id'))),
            'order' => 'News.country ASC', 'group' => 'News.country'));
        $this->set('country_news', $country_news);
		
		if (empty($this->userInfo['users']['id'])) {	
				$this->loadModel('Country');
				$countryList = $this->Country->find('list');
				$this->set('countryList',$countryList);
		}
    }
	public function userarticles($id) {
		$this->loadModel('News');
        $uid = $this->userInfo['users']['id'];
		
		if($id){
			$friend_id=$id;
			$ids=$id;
			
			$checkUserFollowings = ClassRegistry::init('users_followings')->find('all', array('fields' => array('
																										  users_followings.id,
																										  users_followings.status
																										  '),
            'conditions' => array('users_followings.user_id=' . $uid . ' AND users_followings.following_id=' . $id . ' AND users_followings.following_type="users"'
            )
                )
			);
		
			$this->set('checkUserFollowings', $checkUserFollowings);
			$userFollowTable = $checkUserFollowings[0]['users_followings'];
			$following_id = $userFollowTable['id'];
			$this->set('following_id', $following_id);
			$status = $userFollowTable['status'];
			$this->set('following_status', $status);
			$this->set('friend_id', $friend_id);
			
		}else{
			$ids=$uid;
			
		}
		$authorInfo = $this->getCurrentUser($ids);
		$articlesCount=$this->News->find('count',array('conditions'=>array('News.publish=1','News.user_id='.$ids)));
		
		
		$this->set(compact('articlesCount','authorInfo','uid'));
		$this->paginate= array('fields' => array('News.*,countries.name'),'joins' => array(array('alias' => 'countries', 
																								'table' => 'countries', 
																								'foreignKey' => false,
																								'conditions' => array('News.country = countries.id'))),
													'conditions' => array('News.publish=1','News.user_id='.$ids), 'order' => 'News.id DESC', 'limit' => 6);
			$this->set('news_lists', $this->paginate('News'));
    }
	public function add_article(){
		$uid = $this->userInfo['users']['id'];
		
		if ($this->request->is('post')) {
            $data = array();
            $data['News']['heading'] = $this->request->data('heading');
            $data['News']['details'] = $this->request->data('details');
            $data['News']['country'] = $this->request->data('country');
            $data['News']['news_url'] = $this->request->data('news_url');
            $data['News']['rss_link'] = $this->request->data('rss_link');
            $data['News']['publish'] = $this->request->data('published');
            $data['News']['created'] = date('Y-m-d H:i:s');
            $data['News']['user_id'] = $uid;
            $data['News']['share'] = 0;
			$category_id=$this->request->data('category');
            
            if ($this->request->data['form']['image_url']['error'] < 1){
                $logo = $this->ImageUploader->upload($this->request->params['form']['image_url'], 'news', TRUE, TRUE, TRUE);
                $data['News']['image_url'] = $logo;
            }
            
            if ($this->News->save($data)) {
                $news_id = $this->News->getLastInsertID();
                if($this->request->data('category')){
                    $insert_data_0 = array();
                         $insert_data_0['Category_news']['news_id'] = $news_id;
                        $insert_data_0['Category_news']['category_id'] = $category_id;
                        $insert_data_0['Category_news']['user_id'] =  $uid;
                        
                    
				
                    $this->Category_news->create();
                    $this->Category_news->saveAll($insert_data_0); 
                }
            }
            $this->Session->setFlash('Successfully saved data.', 'custom_flash', array('params' => array('noty_class' => 'success')), 'admin_flash');
            $this->redirect(array('controller' => 'news', 'action' => 'index'));
        }else {
            $countries = ClassRegistry::init('Country')->find('all');
            $categories = ClassRegistry::init('News_category')->find('all');
            $this->set(compact('countries','categories'));
        }
	
	}
	public function edit_article($id=null){
		$uid = $this->userInfo['users']['id'];
		//pr($this->request->data);
		
		 
		if($id){
				$edit_news1 = $this->News->find('first',array('conditions'=>array('News.id='.$id)));
				$this->set('edit_news',$edit_news1);
				//$this->request->data['News']['image_url'] = $edit_news1['News']['image_url'];
				$countries = ClassRegistry::init('Country')->find('all');
				$categories = ClassRegistry::init('News_category')->find('all');
				$category_edit =$this->Category_news->find('first',array('conditions'=>array('Category_news.news_id='.$id)));
				$this->set(compact('countries','categories','category_edit'));
		}
			if ($this->request->is('post')) {
				//$this->request->data='';
				$this->request->data['News']['heading'] = $this->request->data('heading');
				$this->request->data['News']['details'] = $this->request->data('details');
				$this->request->data['News']['country'] = $this->request->data('country');
				$this->request->data['News']['news_url'] = $this->request->data('news_url');
				$this->request->data['News']['rss_link'] = $this->request->data('rss_link');
				$this->request->data['News']['publish'] = $this->request->data('published');
				$this->request->data['News']['created'] = date('Y-m-d H:i:s');
				$this->request->data['News']['user_id'] = $uid;
				$this->request->data['News']['share'] = 0;
				$category_id=$this->request->data('category');
				$news_id=$this->request->data('ids');
				if ($this->request->params['form']['image_url']['error'] < 1){
					$logo = $this->ImageUploader->upload($this->request->params['form']['image_url'], 'news', TRUE, TRUE, TRUE);
					$this->request->data['News']['image_url'] = $logo;
				}
				$this->News->id = $this->request->data('ids');
				//pr($this->request->data);
				//exit;*/
				if ($this->News->save($this->request->data)) {
					//$news_id = $this->News->getLastInsertID();
					
					if($this->request->data('category')){
						//$this->request->data='';
						
                        $this->request->data['Category_news']['news_id'] = $news_id;
                        $this->request->data['Category_news']['category_id'] = $category_id;
                        $this->request->data['Category_news']['user_id'] =  $uid;
                        
                    
				
						$this->Category_news->id = $this->request->data('cat_news_id');
						$this->Category_news->save($this->request->data); 
					}
				}
				$this->Session->setFlash('Successfully saved data.', 'custom_flash', array('params' => array('noty_class' => 'success')), 'admin_flash');
				$this->redirect(array('controller' => 'news', 'action' => 'index'));
			}
	
	
	}
	function delete_article($id) {
        
        $news = $this->News->findById($id);
        if(empty($news)){
            $this->Session->setFlash('Error: Cannot find requested information, either moved or deleted.', 'custom_flash', array('params' => array('noty_class' => 'error')), 'admin_flash');
            $this->redirect(array('controller' => 'news', 'action' => 'index'));
        } else {
            if($this->News->delete($id)){
                if (!empty($news['News']['image_url'])) {
                    $path_logo = MEDIA_PATH . 'files' . DS . 'news' . DS . 'thumbnail' . DS . $news['News']['image_url'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_logo = MEDIA_PATH . 'files' . DS . 'news' . DS . 'original' . DS . $news['News']['image_url'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_logo = MEDIA_PATH . 'files' . DS . 'news' . DS . 'logo' . DS . $news['News']['image_url'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_logo = MEDIA_PATH . 'files' . DS . 'news' . DS . 'icon' . DS . $news['News']['image_url'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_logo = MEDIA_PATH . 'files' . DS . 'news' . DS . 'cover' . DS . $news['News']['image_url'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                }
                
                $categories = $this->Category_news->findAllByNewsId($id);
                foreach ($categories as $news_category_id){
                    $this->Category_news->delete($news_category_id['Category_news']['id']);
                }
                $this->Session->setFlash('Removed data and all related informations.', 'custom_flash', array('params' => array('noty_class' => 'success')), 'admin_flash');
            } else {
                $this->Session->setFlash('Unable to delete data.', 'custom_flash', array('params' => array('noty_class' => 'error')), 'admin_flash');
            }
        }
        $this->redirect(array('controller' => 'news', 'action' => 'index'));
       
    }
    public function view($cat__ID = null) {
        $uid = $this->userInfo['users']['id'];
        $this->params['pass'];
        $paramenter = $this->params['pass'];
        $cat__ID = $paramenter[0];
		
        if ($cat__ID != 0) {
            $this->loadModel('News');
            $news_detail = $this->News->find('all', array('fields' => array('News.*,countries.name,users_profiles.firstname,users_profiles.lastname,users_profiles.handler,users_profiles.user_id,users_profiles.photo,users_profiles.tags'),
                'joins' => array(array('alias' => 'countries', 'table' => 'countries', 'foreignKey' => false,
                        'conditions' => array('News.country = countries.id')),
                    array('alias' => 'users_profiles', 'table' => 'users_profiles', 'foreignKey' => false,
                        'conditions' => array('News.user_id = users_profiles.user_id'))),
                'conditions' => array('News.id=' . $cat__ID), 'order' => 'News.id DESC', 'group' => 'News.id')); 
            $this->set('news_detail', $news_detail);
//            $post_data = $news_detail[0]['news'];
//            pr($news_detail);
//            $post_id = $post_data['id'];
//            pr($post_data);

            /* news categories */
            $this->loadModel('Category_news');
            $news_categories = $this->Category_news->find('all', array('fields' => array('news_categories.*,Category_news.*'),
                'joins' => array(
                    array('alias' => 'news_categories', 'table' => 'news_categories', 'foreignKey' => false,
                        'conditions' => array('Category_news.category_id = news_categories.id'))),
                'conditions' => array('Category_news.news_id=' . $cat__ID)));
            $this->set('news_categories', $news_categories);

            $prev_record = $this->News->find('all', array('fields' => array('News.heading,News.id'), 'conditions' => array('News.id <' . $cat__ID), 'order' => 'News.id DESC', 'limit' => 1));
            $next_record = $this->News->find('all', array('fields' => array('News.heading,News.id'), 'conditions' => array('News.id >' . $cat__ID), 'order' => 'News.id ASC', 'limit' => 1));
            $this->set('prev_record', $prev_record);
            $this->set('next_record', $next_record);
            if ($uid) {
                $userEmailID = $this->getUserEmailID($uid);
                $this->set('userEmailID', $userEmailID['email']);
                $userName = $this->getCurrentUser($uid);
                $this->set('userName', $userName['firstname']);

                /* User view this news */

                $this->loadModel('Users_viewing');
                $ip = $_SERVER["REMOTE_ADDR"];
                $datetime = date("Y-m-d H:i:s");

                $this->request->data['Users_viewing']['user_id'] = $uid;
                $this->request->data['Users_viewing']['viewings_id'] = $cat__ID;
                $this->request->data['Users_viewing']['viewings_type'] = "news";
                $this->request->data['Users_viewing']['start_date'] = $datetime;
                $this->request->data['Users_viewing']['viewings_counts'] = 1;

                $checkCounters = ClassRegistry::init('users_viewings')->find('all', array('conditions' => array('users_viewings.user_id=' . $uid . ' AND users_viewings.viewings_id=' . $cat__ID . ' AND users_viewings.viewings_type="news"')));


                if ($checkCounters) {
                    $counts = $checkCounters[0]['users_viewings'];
                    $counters = $counts['viewings_counts'] + 1;
                    if ($this->Users_viewing->updateAll(array('viewings_counts' => $counters), array('Users_viewing.id=' . $counts['id']))) {
                        $this->Session->setFlash('Counter successfully saved.');
                    } else {
                        echo "not updated";
                    }
                } else {
                    if (ClassRegistry::init('Users_viewing')->save($this->request->data)) {
                        //echo "field value saved";
                    } else {
                        echo "field value not saved";
                    }
                }
            } // end session id check

            /* Related News */

            $this->loadModel('Category_news');
            $newsHave_Category = $this->Category_news->find('all', array('fields' => array('Category_news.*'),
                'conditions' => array('Category_news.news_id=' . $cat__ID)));
            $news_cat_Array = $newsHave_Category[0]['Category_news'];
            $news_category_id = $news_cat_Array['category_id'];
            if ($news_category_id) {
                $newsInCategory = $this->Category_news->find('all', array('fields' => array('news.heading,news.id,news.image_url,Category_news.*'),
                    'joins' => array(
                        array('alias' => 'news', 'table' => 'news', 'foreignKey' => false,
                            'conditions' => array('Category_news.news_id = news.id'))),
                    'conditions' => array('Category_news.category_id=' . $news_category_id . ' AND Category_news.news_id!=' . $cat__ID)));
                $this->set('newsInCategory', $newsInCategory);
            }

            /* comments on the News */
            $this->loadModel('Comment');
            $comments_on_news = $this->Comment->find('all', array('fields' => array('Comment.*,users_profiles.firstname,users_profiles.lastname,users_profiles.photo, users_profiles.handler'), 'order' => 'Comment.id DESC',
                'joins' => array(array(
                        'alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('Comment.user_id = users_profiles.user_id'))),
                'conditions' => 'Comment.content_id=' . $cat__ID . ' AND Comment.comment_type="news" AND Comment.parent=0'));
            $this->set('comments_on_news', $comments_on_news);
            
            /* reply to comments */
            $reply_to_comments = $this->Comment->find('all', array('fields' => array('Comment.*,users_profiles.firstname,users_profiles.lastname,users_profiles.photo, users_profiles.handler'),
                'joins' => array(array(
                        'alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('Comment.user_id = users_profiles.user_id'))),
                'conditions' => 'Comment.content_id=' . $cat__ID . ' AND Comment.comment_type="news" AND Comment.parent!=0'));
            $this->set('reply_to_comments', $reply_to_comments);

            $total_comments_onNews = $this->Comment->find('all', array('fields' => array('Comment.id'),
                'conditions' => 'Comment.content_id=' . $cat__ID . ' AND Comment.comment_type="news" AND Comment.parent=0'));
            $this->set('total_comments_onNews', $total_comments_onNews);
			
			
			/*likes on Blog*/
			$this->loadModel('Like');
			$likes_on_post = $this->Like->find('all',array('fields'=>array('count(Like.like) as total_like'),'conditions'=>array('Like.content_id='.$cat__ID.' AND Like.content_type="news" AND Like.like=1'),'group'=>'Like.content_id'));
			$likes = $likes_on_post[0][0];
			$total_like_on_post = $likes['total_like'];
			$this->set('total_like_on_post',$total_like_on_post);
			
			/*check user already like*/
			if ($uid) {
			$log_user_like = $this->Like->find('first',array('fields'=>array('Like.user_id,Like.like'),
																		   'conditions'=>array('(Like.content_id='.$cat__ID.' AND Like.content_type="news") AND 
																								 Like.user_id='.$uid)));
			$user_like = $log_user_like['Like']['user_id'];
			$like = $log_user_like['Like']['like'];
			$this->set('user_like',$user_like);
			$this->set('like',$like);
			}
			$likesOnUpdates = ClassRegistry::init('likes')->find('all', array('fields'=>array('
																					users_profiles.firstname,
																					users_profiles.lastname,
																					users_profiles.photo,
																					users_profiles.tags,
																					users_profiles.user_id,
																					likes.user_id,
																					likes.content_id
																					'),
																		   'order'=>'likes.id DESC',
																			'joins'=> array(
																							 array(
																								   'alias'=> 'users_profiles',
																								   'table'=> 'users_profiles',
																								   'foreignKey'=> false,
																								'conditions'=> array('likes.user_id = users_profiles.user_id'
																												  ))),
																			'conditions'=>array('likes.content_type="news" AND likes.like=1 AND likes.content_id='.$cat__ID)
																									));
			$this->set('likesOnUpdates',$likesOnUpdates);
			
			$whoshareNews = ClassRegistry::init('statusupdates')->find('all', array('fields'=>array('
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
																			'conditions'=>array('statusupdates.content_type="news" AND statusupdates.share='.$cat__ID)
																									));

			$this->set('whoshareNews',$whoshareNews);
			
			$friend_id=$news_detail[0]['users_profiles']['user_id'];
			if($uid){
			
			$checkUserFollowings = ClassRegistry::init('users_followings')->find('all', array('conditions' => array('users_followings.user_id=' . $uid . ' AND users_followings.following_id=' . $friend_id . ' AND users_followings.following_type="users"')));
		
			$this->set('checkUserFollowings', $checkUserFollowings);
			$userFollowTable = $checkUserFollowings[0]['users_followings'];
			$following_id = $userFollowTable['id'];
			$this->set('following_id', $following_id);
			$status = $userFollowTable['status'];
			$this->set('following_status', $status);
			$this->set('friend_id', $friend_id);
			
		
			//$authorInfo = $this->getCurrentUser($ids);
			$articlesCount=$this->News->find('count',array('conditions'=>array('News.publish=1','News.user_id='.$friend_id)));
		
		
			$this->set(compact('articlesCount','uid'));
			}
        }
		
		if (empty($this->userInfo['users']['id'])) {	
				$this->loadModel('Country');
				$countryList = $this->Country->find('list');
				$this->set('countryList',$countryList);
		}
    }

	public function delete_comment() {
			if ($this->userInfo['users']['id']) {
				$uid = $this->userInfo['users']['id'];
			}
		if ($this->request->is('get')) {
			$comment_id = $_GET['comment_id'];
			$content_id = $_GET['content_id'];
			$db = ConnectionManager::getDataSource('default');
			$db->rawQuery("DELETE FROM comments WHERE id=".$comment_id.' AND comments.comment_type="news"');
			
			$your_comments = ClassRegistry::init('comments')->find('all',array('fields'=>array('
																						   comments.content_id
																						   '),
																					'conditions'=>array(' 
																										comments.content_id='.$content_id.' AND comments.comment_type="news"  AND comments.parent = 0'
																										)
																					)
																		);
			
			echo $your_comments = sizeof($your_comments);
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('delete_comment');
		}
		
	}
	
	public function delete_reply() {
			if ($this->userInfo['users']['id']) {
				$uid = $this->userInfo['users']['id'];
			}
		if ($this->request->is('get')) {
			$comment_id = $_GET['comment_id'];
			$reply_id = $_GET['reply_id'];
			$db = ConnectionManager::getDataSource('default');
			$db->rawQuery("DELETE FROM comments WHERE id=".$reply_id.' AND comments.parent='.$comment_id.' AND comments.comment_type="news"');
			
			$your_comments = ClassRegistry::init('comments')->find('all',array('fields'=>array('
																						   comments.parent
																						   '),
																					'conditions'=>array(' 
																										comments.parent='.$comment_id.' AND comments.comment_type="news"'
																										)
																					)
																		);
			
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('delete_comment');
		}
		
	}
	
    public function get_news_ajax() {
        if ($this->request->is('post')) {
            $lastid = $_POST["lastid"];
            $this->loadModel('News');
            $news_lists = $this->News->find('all', array('fields' => array('News.*,countries.name,users_profiles.firstname,users_profiles.lastname,users_profiles.handler'),
                'joins' => array(array('alias' => 'countries', 'table' => 'countries', 'foreignKey' => false,
                        'conditions' => array('News.country = countries.id')),
                    array('alias' => 'users_profiles', 'table' => 'users_profiles', 'foreignKey' => false,
                        'conditions' => array('News.user_id = users_profiles.user_id'))),
                'conditions' => array('News.publish=1 AND News.id <' . $lastid), 'order' => 'News.id DESC', 'limit' => 6));
            $this->set('news_lists', $news_lists);
        }
        $this->autorender = false;
        $this->layout = false;
        $this->render('get_news_ajax');
    }

    public function send() {
        if ($this->request->is('post')) {

            $your_name = $this->request->data['News']['name'];
            $your_email = $this->request->data['News']['email'];
            $friend_name = $this->request->data['News']['fname'];
            $friend_email = $this->request->data['News']['femail'];
            $news_url = $this->request->data['News']['url'];
            $news_title = $this->request->data['News']['news_title'];
            $this->Email->template = 'forward_friend';
            // You can use customised thmls or the default ones you setup at the start 
            $this->set('news_url', $news_url);
            $this->set('news_title', $news_title);
            $this->set('your_name', $your_name);

            $this->Email->sendAs = 'both';
            $this->Email->from = $your_email;
            $this->Email->to = $friend_email;
            $this->Email->subject = $your_name . '<' . $your_email . '> Refer you news.';
            $this->Email->_debug = true;
            if ($this->Email->send()) {
                $this->redirect(array('controller' => 'news', 'action' => 'index'));
            }
        }
    }

    public function share() {
        if ($this->request->is('post')) {
            $user_id = $this->request->data['News']['user_id'];
            $newsId = $this->request->data['News']['id'];
            $update = $this->request->data['Statusupdate']['update'];
            $group = $this->request->data['Entity_update']['group'];
            $connection = $this->request->data['Users_profile']['connection'];
            $created_date = date("Y-m-d H:i:s");
            $newsData = ClassRegistry::init('news')->find('first', array('conditions' => array('id' => $newsId)));
            $newsArray = $newsData['news'];

            if ($update == 1) {
                $this->loadModel('Statusupdate');
                $this->request->data['Statusupdate']['user_id'] = $user_id;
                $this->request->data['Statusupdate']['content_type'] = "news";
                $this->request->data['Statusupdate']['created'] = $created_date;
                $this->request->data['Statusupdate']['modified'] = $created_date;
                $this->request->data['Statusupdate']['photo'] = $newsArray['image_url'];
                $this->request->data['Statusupdate']['user_text'] = strip_tags($newsArray['details']);
                $this->request->data['Statusupdate']['share'] = $newsId;
                if ($this->Statusupdate->save($this->request->data)) {
                    
                } else {
                    echo "updated not saved";
                    exit;
                }
            } /// update end

            if ($group == 1) {
                $group_id = $this->request->data['Entity_update']['group_id'];
                $group_title = $this->request->data['Entity_update']['group_title'];
                $this->request->data = '';
                $title_Url = str_replace(" ", "-", strtolower($newsArray['heading']));
                $news_title = '<a href="/news/view/' . $newsId . '/' . $title_Url . '">' . $newsArray['heading'] . '</a>';
                $news_detail = strip_tags($newsArray['details']);
                $group_update = $news_title . ", " . $news_detail;
                $this->loadModel('Entity_update');
                $this->request->data['Entity_update']['user_id'] = $user_id;
                $this->request->data['Entity_update']['entity_type'] = "news";
                $this->request->data['Entity_update']['created'] = $created_date;
                $this->request->data['Entity_update']['modified'] = $created_date;
                $this->request->data['Entity_update']['image'] = $newsArray['image_url'];
                $this->request->data['Entity_update']['update_text'] = $group_update;
                $this->request->data['Entity_update']['share'] = $newsId;
                $this->request->data['Entity_update']['share_with'] = "groups";
                $this->request->data['Entity_update']['entity_id'] = $group_id;
                $this->request->data['Entity_update']['group_title'] = $group_title;

                if ($this->Entity_update->save($this->request->data)) {
                    
                } else {
                    echo "updated not saved";
                    exit;
                }
            } /// Entity_update end
            if ($connection) {
                $connection_email = $this->request->data['Users_profile']['connection_id'];
                $connection_name = $this->request->data['Users_profile']['connection_name'];
                $your_name = $this->request->data['Users_profile']['name'];
                $your_email = $this->request->data['Users_profile']['email'];
                $news_url = $this->request->data['News']['url'];
                $message = $this->request->data['News']['message'];
                $this->request->data = '';
                $this->Email->template = 'forward_friend';
                // You can use customised thmls or the default ones you setup at the start 
                $this->set('news_url', $news_url);
                $this->set('news_title', $news_title);
                $this->set('your_name', $your_name);

                $this->Email->sendAs = 'both';
                $this->Email->from = $your_email;
                $this->Email->to = $connection_email;
                $this->Email->subject = $your_name . '<' . $your_email . '> Refer you news.';
                $this->Email->_debug = true;
                if ($this->Email->send($message)) {
                    $this->redirect(array('controller' => 'news', 'action' => 'index'));
                }
            }
            $this->redirect(array('controller' => 'news', 'action' => 'index'));
        }
    }

    function view_pdf() {
        Configure::write('debug', 0);
        $this->params['pass'];
        $paramenter = $this->params['pass'];
        $cat__ID = $paramenter[0];
        ini_set('memory_limit', '1024M');
        if ($cat__ID != 0) {
            $this->loadModel('News');
            $this->set('news_detail', $this->read_news($cat__ID));
        }
    }

    function read_news($cat__ID) {

        $this->loadModel('News');
        $news_detail = $this->News->find('all', array('fields' => array('News.*,countries.name,users_profiles.firstname,users_profiles.lastname,users_profiles.handler'),
            'joins' => array(array('alias' => 'countries', 'table' => 'countries', 'foreignKey' => false,
                    'conditions' => array('News.country = countries.id')),
                array('alias' => 'users_profiles', 'table' => 'users_profiles', 'foreignKey' => false,
                    'conditions' => array('News.user_id = users_profiles.user_id'))),
            'conditions' => array('News.publish=1 AND News.id=' . $cat__ID), 'order' => 'News.id DESC', 'group' => 'News.id'));

        return $news_detail;
    }

    /* news by select the category */

    public function news_by_category() {

        if ($this->request->is('post')) {
            $category__ID = $_POST['category__ID'];
            if ($category__ID != 0) {
                $news_per_category = ClassRegistry::init('category_news')->find('all', array('fields' => array('
																											   category_news.*,
																											   news.*,
																											   users_profiles.firstname,
																											   users_profiles.lastname
																											   '),
																							 'joins' => array(
																											  array('alias' => 'news',
																													'table' => 'news',
																													'foreignKey' => false, 
																													'conditions' => array('news.id = category_news.news_id'
																																		  )
																													),
																											  array('alias' => 'users_profiles',
																													'table' => 'users_profiles',
																													'type' => 'left',
																													'foreignKey' => false,
																													'conditions' => array('category_news.user_id = users_profiles.user_id'
																																		  )
																													)
																											  ),
																							 'conditions' => array('category_news.category_id=' . $category__ID,'news.publish=1'),
																							 'order' => 'category_news.id DESC',
																							 'group' => 'category_news.news_id'
																							 )
																				);
            } else {

                $news_per_category = ClassRegistry::init('category_news')->find('all', array('fields' => array('
																											   category_news.*,
																											   news.*,
																											   users_profiles.firstname,
																											   users_profiles.lastname
																											   '),
																							 'joins' => array(
																											  array('alias' => 'news',
																													'table' => 'news',
																													'foreignKey' => false,
																													'conditions' => array('news.id = category_news.news_id')),
																											  array('alias' => 'users_profiles',
																													'table' => 'users_profiles',
																													'type' => 'left', 
																													'foreignKey' => false,
																													'conditions' => array('category_news.user_id = users_profiles.user_id'
																																		  )
																													)
																											  ),
																											  'conditions'=>array('news.publish=1'),
																							 'order' => 'category_news.id DESC',
																							 'group' => 'category_news.news_id'));
            }
            $this->set('news_per_category', $news_per_category);
        }

        $this->autorender = false;
        $this->layout = false;
        $this->render('news_by_category');
    }

    /* news by select the Country */

    public function news_by_country() {

        if ($this->request->is('post')) {
            $country__ID = $_POST['country__ID'];
            if ($country__ID != 0) {
                $news_per_country = ClassRegistry::init('news')->find('all', array('fields' => array('news.*, users_profiles.firstname , users_profiles.lastname'),
                    'joins' => array(
                        array('alias' => 'countries', 'table' => 'countries', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('news.country  = countries.id')),
                        array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('news.user_id = users_profiles.user_id'))),
                    'conditions' => array('news.country=' . $country__ID,'news.publish=1'),
                    'order' => 'news.id DESC'));
            } else {

                $news_per_country = ClassRegistry::init('news')->find('all', array('fields' => array('news.*, users_profiles.firstname , users_profiles.lastname'),
                    'joins' => array(array('alias' => 'countries', 'table' => 'countries', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('news.country  = countries.id')),
                        array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('news.user_id = users_profiles.user_id'))),
                    'conditions' => array('news.publish=1'),
					'order' => 'news.id DESC'));
            }
            $this->set('news_per_country', $news_per_country);
        }

        $this->autorender = false;
        $this->layout = false;
        $this->render('news_by_country');
    }

    /* news by select days */

    public function news_by_date() {

        if ($this->request->is('post')) {
            $days = $_POST['days'];
            if ($days == 7) {
                $get_news_by_date = ClassRegistry::init('news')->find('all', array('fields' => array('news.*'), 'order' => 'news.id DESC',
                    'conditions' => array('news.created >= NOW() - INTERVAL 1 WEEK', 'news.publish' => 1)));
            } else if ($days == 30) {
                $get_news_by_date = ClassRegistry::init('news')->find('all', array('fields' => array('news.*'), 'order' => 'news.id DESC',
                    'conditions' => array('news.created >= NOW() - INTERVAL 1 MONTH AND news.created < NOW() - INTERVAL 1 WEEK', 'news.publish' => 1)));
            } else if ($days == 90) {
                $get_news_by_date = ClassRegistry::init('news')->find('all', array('fields' => array('news.*'), 'order' => 'news.id DESC',
                    'conditions' => array('news.created >= NOW() - INTERVAL 3 MONTH AND news.created < NOW() - INTERVAL 1 MONTH', 'news.publish' => 1)));
            } else {
                $get_news_by_date = ClassRegistry::init('news')->find('all', array('fields' => array('news.*'), 'order' => 'news.id DESC',
                    'conditions' => array('news.publish' => 1)));
            }
            $this->set('get_news_by_date', $get_news_by_date);
        }
        $this->autorender = false;
        $this->layout = false;
        $this->render('news_by_date');
    }

    public function search_news() {

        if ($this->request->is('get')) {
            $search_news = $_GET['search_news'];
            $get_news_search = ClassRegistry::init('news')->find('all', array('fields' => array('news.*,users_profiles.firstname, users_profiles.lastname,users_profiles.user_id'),
                'joins' => array(array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('news.user_id  = users_profiles.user_id'))),
                'conditions' => array('news.publish=1 AND news.heading LIKE "%' . $search_news . '%"'), 'order' => 'news.id DESC', 'group' => 'news.id'));
            $this->set('get_news_search', $get_news_search);
        }
        $this->autorender = false;
        $this->layout = false;
        $this->render('search_news');
    }

    /* popular news */

    public function popular() {

        $get_popular_news = ClassRegistry::init('users_viewings')->find('all', array('fields' => array('news.heading,news.details,news.id,news.created,news.image_url, users_viewings.viewings_counts'),
            'joins' => array(array('alias' => 'news', 'table' => 'news', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('users_viewings.viewings_id  = news.id'))),
            'order' => 'users_viewings.viewings_counts DESC', 'limit' => 6,
            'conditions' => array('news.publish' => 1)));
        $this->set('get_popular_news', $get_popular_news);
    }

    public function popular_news_ajax() {
        if ($this->request->is('post')) {
            $lastid = $_POST["lastid"];
            $get_popular_news_ajax = ClassRegistry::init('news')->find('all', array('fields' => array('news.heading,news.details,news.id,news.created,news.image_url, users_viewings.viewings_counts'),
                'joins' => array(array('alias' => 'users_viewings', 'table' => 'users_viewings', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('users_viewings.viewings_id  = news.id'))),
                'conditions' => array('news.id <' . $lastid), 'order' => 'users_viewings.viewings_counts DESC', 'limit' => 6));
            $this->set('get_popular_news_ajax', $get_popular_news_ajax);
        }
        $this->autorender = false;
        $this->layout = false;
        $this->render('popular_news_ajax');
    }

    /* add comments to post */

    public function add_comments($reply = FALSE) {
        if ($this->request->is('post') && !empty($_POST['user_comment']) && !empty($_POST['news_id']) && !empty($_POST['news_id'])) {
            $user_id = $_POST['user_id'];
            $content_id = $_POST['news_id'];
            $comment_text = $_POST['user_comment'];
            $created_date = date("Y-m-d H:i:s");
            $this->loadModel('Comment');
            $this->request->data['Comment']['user_id'] = $user_id;
            $this->request->data['Comment']['comment_type'] = "news";
            $this->request->data['Comment']['content_id'] = $content_id;
            $this->request->data['Comment']['comment_date'] = $created_date;
            $this->request->data['Comment']['comment_text'] = $comment_text;
            
            if (!$reply) {
                if ($this->Comment->save($this->request->data)) {
                    $last_comment_id = $this->Comment->getInsertID();
                    $comments_this_news = $this->Comment->find('all', array('fields' => array('Comment.*,users_profiles.firstname,users_profiles.lastname,users_profiles.photo, users_profiles.handler'),
                        'joins' => array(array(
                                'alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('Comment.user_id = users_profiles.user_id'))),
                        'conditions' => 'Comment.id=' . $last_comment_id . ' AND Comment.comment_type="news"'));
					
					$comment_on_news = $this->Comment->find('all',array('fields'=>array('Comment.id'),
																					'conditions'=>array('Comment.content_id='.$content_id.' AND Comment.comment_type="news" AND Comment.parent = 0')));
					$this->set('comments_on_news',sizeof($comment_on_news));
                    $this->set('comments_this_news', $comments_this_news);
                    $this->set('content_id', $content_id);
                    $this->set('reply', 'false');
                }
            } else if ($reply && !empty($_POST['parent'])) {
                $parent = $_POST['parent'];
                $this->request->data['Comment']['parent'] = $parent;
                if ($this->Comment->save($this->request->data)) {
                    $last_reply_id = $this->Comment->getInsertID();
                    $reply_to_comments = $this->Comment->find('all', array('fields' => array('Comment.*,users_profiles.firstname,users_profiles.lastname,users_profiles.photo, users_profiles.handler'),
                        'joins' => array(array(
                                'alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('Comment.user_id = users_profiles.user_id'))),
                        'conditions' => 'Comment.parent=' . $parent . ' AND Comment.comment_type="news"'));
                    $this->set('reply_to_comments', $reply_to_comments);
                    $this->set('content_id', $content_id);
                    $this->set('reply', 'true');
                }
            }
        }
        $this->autorender = false;
        $this->layout = false;
        $this->render('add_comments');
    }

    public function news_comments() {
		
        $uid = $this->userInfo['users']['id'];
        $this->params['pass'];
        $paramenter = $this->params['pass'];
        $cat__ID = $paramenter[0];
        if ($cat__ID != 0) {

            $this->loadModel('News');
            $news_InDetail = $this->News->find('all', array('fields' => array('News.*,countries.name,users_profiles.firstname,users_profiles.lastname,users_profiles.handler'),
                'joins' => array(array('alias' => 'countries', 'table' => 'countries', 'foreignKey' => false,
                        'conditions' => array('News.country = countries.id')),
                    array('alias' => 'users_profiles', 'table' => 'users_profiles', 'foreignKey' => false,
                        'conditions' => array('News.user_id = users_profiles.user_id'))),
                'conditions' => array('News.publish=1 AND News.id=' . $cat__ID), 'order' => 'News.id DESC', 'group' => 'News.id'));
            $this->set('news_InDetail', $news_InDetail);

            /* comments on the News */
            $this->loadModel('Comment');
            $comments_on_Onenews = $this->Comment->find('all', array('fields' => array('Comment.*,users_profiles.firstname,users_profiles.lastname,users_profiles.photo, users_profiles.handler'),
                'joins' => array(array(
                        'alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('Comment.user_id = users_profiles.user_id'))),
                'conditions' => 'Comment.content_id=' . $cat__ID . ' AND Comment.comment_type="news" AND Comment.parent=0'));
        }
    }
	
	
	public function add() {
		
		if ($this->userInfo['users']['id']) {
			$uid = $this->userInfo['users']['id']; 
		}
		
		if ($this->request->is('post')) {
			$this->loadModel('News');
			$parent_id = $this->request->data['News']['parent'];
			
			if ($parent_id !=0) {
				$parent = 0;
				$this->loadModel('Statusupdate');
				
			$newsData = $this->News->find('first', array('conditions' => array('News.id' => $parent_id)));
			
            $newsArray = $newsData['News'];
			
				$this->request->data = '';
				$created_date = date('Y-m-d H:i:s');
				$parent = $newsArray['share'];
				$detail = strip_tags(substr($newsArray['details'],0,500));
				$title = trim($newsArray['heading']);
				$title = '<a href="'.NETWORKWE_URL.'/news/view/'.$parent_id.'">'.$title.'</a>';
				$news_description = $title."<br />".$detail;
				
                $this->loadModel('Statusupdate');
                $this->request->data['Statusupdate']['user_id'] = $uid;
                $this->request->data['Statusupdate']['content_type'] = "news";
                $this->request->data['Statusupdate']['created'] = $created_date;
                $this->request->data['Statusupdate']['modified'] = $created_date;
                $this->request->data['Statusupdate']['photo'] = $newsArray['image_url'];
                $this->request->data['Statusupdate']['user_text'] = $news_description;
                $this->request->data['Statusupdate']['share'] = $parent_id;
				$this->request->data['Statusupdate']['update_type'] = 0;
				$this->request->data['Statusupdate']['update_shared'] = 0;
				$this->request->data['Statusupdate']['share_with'] = 1;
                if ($this->Statusupdate->save($this->request->data)) {
                    $this->News->id = $parent_id;
					$parent = $parent+1;
					$this->request->data['News']['share'] = $parent;
					if ($this->News->save($this->request->data)) {
						$this->redirect(array('controller'=>'home','action'=>'index'));
						exit;
					}
                } 
				else {
                    echo "updated not saved";
                    exit;
                }
			}
		}
		
	}

    function admin_categories() {
        $categories = ClassRegistry::init('news_categories')->find('all');
        $this->set('categories', $categories);
    }

    function admin_addCategory() {
        if ($this->request->is('post')) {
            $formData = array('category' => $this->request->data('category_name'));
            $res = ClassRegistry::init('news_categories')->save($formData);
            if($res)
                $this->Session->setFlash('Succefully saved data.', 'custom_flash', array('params' => array('noty_class' => 'success')), 'admin_flash');
            else
                $this->Session->setFlash('Error saving data!', 'custom_flash', array('params' => array('noty_class' => 'error')), 'admin_flash');
            $this->redirect('/admin/news/categories');
        }
    }

    function admin_deleteCategory($id) {
        if (ClassRegistry::init('news_categories')->delete($id)) {
            $this->Session->setFlash('Succefully deleted data.', 'custom_flash', array('params' => array('noty_class' => 'success')), 'admin_flash');
        } else {
            $this->Session->setFlash('Unable to delete data.', 'custom_flash', array('params' => array('noty_class' => 'error')), 'admin_flash');
        }
        $this->redirect('/admin/news/categories');                
    }

    function admin_editCategory($id) {
        if ($this->request->is('post')) {
            $formData = array('category' => $this->request->data('category_name'));
            ClassRegistry::init('news_categories')->id = $id;
            if (ClassRegistry::init('news_categories')->save($formData)) {
                $this->Session->setFlash('Succefully saved data.', 'custom_flash', array('params' => array('noty_class' => 'success')), 'admin_flash');
                $this->redirect('/admin/news/categories');
            } else {
                $this->Session->setFlash('Error saving data!', 'custom_flash', array('params' => array('noty_class' => 'error')), 'admin_flash');
            }
        } else {
            $this->set('category', ClassRegistry::init('news_categories')->find('first', array('conditions' => array('id' => $id))));
        }
    }

}