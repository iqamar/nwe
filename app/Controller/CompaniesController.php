<?php
App::uses('AppController', 'Controller');

class CompaniesController extends AppController {

/*
 * Controller name
 *
 * @var string
 */
 	var $helpers = array('Paginator');
	var $name = 'Company';
	var $uses = array('Company','User','Users_profile');
 function beforeFilter() {
	parent::beforeFilter();


	$this->Auth->allow();

    }
	public function extractProcess(){
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
					
			echo json_encode($output); 
		}
		
	}
	
	public function index() {
		
		if (@$this->userInfo['users']['id']) {
		
		$uid = $this->userInfo['users']['id'];
		$this->set('uid',$uid);
		//$this-loadModel('Company');
		$this->paginate = array('fields' =>array('
												  Company.id,
												  Company.title,
												  Company.user_id,
												  Company.weburl,
												  Company.logo,
												  countries.name,
												  users_followings.id,
												  users_followings.status
												  '),
								 'order'=>'Company.id DESC',
								 'limit' => 10,
								 'joins' => array(
												  array('alias' => 'countries',
														'table' => 'countries',
														'type' => 'left',
														'foreignKey' => false,
														'conditions' => array('Company.country_id = countries.id'
																			  )
														),
												  array(
														'alias' => 'users_followings',
														'table' => 'users_followings',
														'type' => 'left',
														'foreignKey' => false,
														'conditions' => array('users_followings.following_id = Company.id AND users_followings.status=2')
														)
												  ),
								 'conditions' => array('(users_followings.following_type = "company" AND Company.flag="page") AND
													   (users_followings.status=2 AND users_followings.user_id='.$uid.')')
								 );
		
		//$companyListing = ClassRegistry::init('companies')->find('all', );
		$companyListing = $this->paginate('Company');

		$this->set('companyListing',$companyListing);
		$company_followed_by_user = ClassRegistry::init('users_followings')->find('all',
																				  array(
																						'conditions' => array('users_followings.user_id'=>$uid,
																											  'users_followings.following_type="company" AND
																								   				users_followings.status=2')
																						));
		$this->set('company_followed_by_user',sizeof($company_followed_by_user));
		}
	}
		public function search() {
		
		if (@$this->userInfo['users']['id']) {
		
		$uid = $this->userInfo['users']['id'];
		$this->set('uid',$uid);
		//$this-loadModel('Company');
		$this->paginate = array('fields' =>array('
												  Company.id,
												  Company.user_id,
												  Company.title,
												  Company.logo,
												  Company.city,
												  Company.weburl,
												  countries.name,
												  industries.title
												  '),
								 'order'=>'Company.id DESC',
								 'limit' => 10,
								 'joins' => array(
												  array('alias' => 'countries',
														'table' => 'countries',
														'type' => 'left',
														'foreignKey' => false,
														'conditions' => array('Company.country_id = countries.id'
																			  )
														),
												  array('alias' => 'industries',
														'table' => 'industries',
														'type' => 'left',
														'foreignKey' => false,
														'conditions' => array('Company.industry_id = industries.id'
																			  )
														)
												  ),
								 'conditions'=>array('Company.status=2 AND Company.flag="page"')
								 );
		$companyListing = $this->paginate('Company');
		//$companyListing = ClassRegistry::init('companies')->find('all', );

		$this->set('companyListing',$companyListing);
		
		$company_followed_by_user = ClassRegistry::init('users_followings')->find('all',
																				  array(
																						'conditions' => array('users_followings.user_id'=>$uid,
																											  'users_followings.following_type="company"')
																						));
		$this->set('company_followed_by_user',sizeof($company_followed_by_user));
		$this->set('companies_followed_by_user',$company_followed_by_user);
		
		$company_followed_by_user = ClassRegistry::init('users_followings')->find('all',
																				  array(
																						'conditions' => array('users_followings.user_id'=>$uid,
																											  'users_followings.following_type="company" AND
																								   				users_followings.status=2')
																						));
		$this->set('company_followed_by_user',sizeof($company_followed_by_user));
		
		$loggeduers_following_companies = ClassRegistry::init('users_followings')->find('all',
															array('conditions' => array('users_followings.user_id='.$uid.' AND users_followings.following_type="company"')));
			
			$this->set('loggeduers_following_companies',$loggeduers_following_companies);
		
		}

	}
	
	public function search_companies() {
		if (@$this->userInfo['users']['id']) {
			
			$uid = $this->userInfo['users']['id'];
			$this->set('uid',$uid);
		}
		if ($this->request->is('get')) {
			$this->loadModel('Company');
			$company_title = $_GET['company_title'];
			if ($company_title) {
			/*$comResult = ClassRegistry::init('companies')->find('all',array('fields'=>array('
																							companies.id,
																							companies.title
																							'),
																			'conditions'=>array('companies.title LIKE'=>'%'.$company_title.'%')));*/
			
			
			$comResult = ClassRegistry::init('companies')->find('all',array('fields' =>array('
																							  companies.id,
																							  companies.user_id,
																							  companies.title,
																							  companies.logo,
																							  companies.city,
																							  companies.weburl,
																							  countries.name,
																							  industries.title
																							  '),
																			 'joins' => array(
																							  array('alias' => 'countries',
																									'table' => 'countries',
																									'type' => 'left',
																									'foreignKey' => false,
																									'conditions' => array('companies.country_id = countries.id'
																														  )
																									),
																							  array('alias' => 'industries',
																									'table' => 'industries',
																									'type' => 'left',
																									'foreignKey' => false,
																									'conditions' => array('companies.industry_id = industries.id'
																														  )
																									)
																							  ),
																			 'conditions'=>array('companies.title LIKE'=>'%'.$company_title.'%',
																								 'companies.status=2 AND companies.flag="page"')
																								 
																							)
																 );
			
			
			}
			else {
				$comResult = ClassRegistry::init('companies')->find('all',array('fields' =>array('
																							  companies.id,
																							  companies.user_id,
																							  companies.title,
																							  companies.logo,
																							  companies.city,
																							  companies.weburl,
																							  countries.name,
																							  industries.title
																							  '),
																			 'order'=>'companies.id DESC',
																			 'joins' => array(
																							  array('alias' => 'countries',
																									'table' => 'countries',
																									'type' => 'left',
																									'foreignKey' => false,
																									'conditions' => array('companies.country_id = countries.id'
																														  )
																									),
																							  array('alias' => 'industries',
																									'table' => 'industries',
																									'type' => 'left',
																									'foreignKey' => false,
																									'conditions' => array('companies.industry_id = industries.id'
																														  )
																									)
																							  ),
																			 'conditions'=>array('companies.status=2')	 
																							)
																 );
			}
			
			$loggeduers_following_companies = ClassRegistry::init('users_followings')->find('all',
															array('conditions' => array('users_followings.user_id='.$uid.' AND users_followings.following_type="company"')));
			
			$this->set('loggeduers_following_companies',$loggeduers_following_companies);
					
					
			}
			$this->set('comResult',$comResult);
			$this->autorender = false;
			$this->layout = false;
			$this->render('search_companies');
	}
	
		public function search_users() {
		if ($this->request->is('get')) {
			$this->loadModel('Users_profile');
			$admin_title = $_GET['admins_title'];
			$companyid = $_GET['company_id'];
			$owner_id = $_GET['user_id'];
			$this->set('companyid',$companyid);
			$this->set('owner_id',$owner_id);
			if ($admin_title) {
				$userSearchResult = ClassRegistry::init('Users_profile')->find('all',array('fields'=>'Users_profile.firstname, Users_profile.lastname, Users_profile.photo,Users_profile.user_id','conditions'=>array('Users_profile.firstname LIKE'=>'%'.$admin_title.'%'),'limit'=>10));
				$this->set('userSearchResult',$userSearchResult);
			}		
		}
		
			$this->autorender = false;
			$this->layout = false;
			$this->render('search_users');
		
	}
	
	 public function delete_admin() {
		 if ($this->request->is('get')) {
		 	$this->loadModel('Company_user');
			$company_user_id = $_GET['company_user_id'];
			$this->Company_user->id = $company_user_id;
			$db = ConnectionManager::getDataSource('default');
			$db->rawQuery("DELETE FROM company_users WHERE id=".$company_user_id);
		 }
		 
		 $this->autorender = false;
			$this->layout = false;
			$this->render('delete_admin');
	 }
	
		public function resultant_companies() {
		echo "this is the testing method. this is the testing method. this is the testing method. this is the testing method. this is the testing method.";
		if ($this->request->is('get')) 
		{
			//$this->loadModel('Company');
			$this->autoRender = false;
			$this->layout = 'ajax';
			$country_id = $_GET['country_id'];
			if ($country_id != 0) {
			$companyByCountryResult = ClassRegistry::init('companies')->find('all',array('conditions'=>array('companies.country_id'=>$country_id)));
			}
			else 
			{
				$companyByCountryResult = ClassRegistry::init('companies')->find('all');
			}
			$this->set('companyByCountryResult',$companyByCountryResult);
			
		}
			
			$this->render('/elements/Company/find_company');
	}
	
	
	public function follow_company() {
			
		if ($this->request->is('get')) {
			
			
			$uid = @$this->userInfo['users']['id'];
			$this->loadModel('Company');
			$companyid = $_GET['companyid'];
			$uid = $_GET['user_id'];
			$status = $_GET['status'];
			$start_date = $_GET['start_date'];
			$end_date = $_GET['end_date'];
			$user_following_id = $_GET['user_following_id'];
			$this->loadModel('Users_following');
			if ($user_following_id == '') {
				$this->request->data['users_followings']['start_date'] = $start_date;
			}
			else {
				$this->request->data['users_followings']['end_date'] = $end_date;
			}
			if ($user_following_id == '') {
				$this->request->data['users_followings']['following_id'] = $companyid;
				$this->request->data['users_followings']['user_id'] = $uid;
				$this->request->data['users_followings']['status'] = $status;
				$this->request->data['users_followings']['following_type'] = 'company';
				$comFollow = ClassRegistry::init('users_followings')->save($this->request->data);
				$user_following_id = ClassRegistry::init('users_followings')->getInsertID();
				}
				else if ($this->Users_following->updateAll(array('status' =>$status), array('Users_following.id' => $user_following_id))) {
					
				}
				else {
					echo "not updated successfully";
				}
			
			}
			else {
			echo "not get";
			}
			$this->set('comFollow',$comFollow);
			$this->set('status',$status);
			$this->set('user_following_id',$user_following_id);
			$this->set('companyID',$companyid);
			$this->autorender = false;
			$this->layout = false;
			$this->render('follow_company');
	}
	
	public function validity() {
		
		if (@$this->userInfo['users']['id']) {
			$uid = $this->userInfo['users']['id'];
		}
			if ($this->request->is('post')) {
				$this->loadModel('Company');
				$this->request->data['Company']['user_id'] = $uid;
				$company_title = $this->request->data['Company']['title'];
				$primary_email = $this->request->data['Company']['primary_email'];

				$topLevel = @explode('@',$primary_email);
				$topLevel = $topLevel[1];
				$companyBYuser = ClassRegistry::init('companies')->find('all', array('conditions'=>array('companies.primary_email LIKE '=> "%$topLevel")));
				
				if ($companyBYuser){
					$error = "A company with this domain already exists";
				}
				if ($topLevel == 'gmail.com' || $topLevel == 'yahoo.com' || $topLevel == 'hotmail.com' || $topLevel == 'ymail.com' || $topLevel == 'live.com') {
					$error = "This domain is not valid, user your company Email id";
					
				}
				
				if ($error) {
					//$mesg = "A Confirmation link has been sent to your mentioned Email.";
					$this->Session->setFlash($error,'error_msg',array(),'company_valid');
					$this->set('set_flash_error','yes');
					$this->redirect(array('controller'=>'companies','action'=>'validity'));
				}
				
				else if (ClassRegistry::init('Company')->save($this->request->data)){
						$this->request->data = '';
						$company_id = $this->Company->getInsertID();
						$this->request->data['company_users']['company_id'] = $company_id;
						$this->request->data['company_users']['user_id'] = $uid;
						$this->request->data['company_users']['status'] = 2;
						$dt_created = date("Y-m-d H:i:s");
						$this->request->data['company_users']['created'] = $dt_created;
						if (ClassRegistry::init('company_users')->save($this->data['company_users'])) {
							$company_link = NETWORKWE_URL.'/companies/add/'.$company_id;
							$this->set('company_link', $company_link);
							$this->Email->template = 'company_template'; 
							$this->Email->sendAs = 'both';
							$this->Email->from ="NetworkWe<support@networkwe.com> via NetworkWe";
							$this->Email->to = $primary_email; 
							
							$this->Email->subject = 'NetworkWe Company page Confirmation.';
							$this->Email->_debug = true;  
							if ($this->Email->send()) {
								$this->set('set_flash_success','yes');
								$mesg = "A Confirmation link has been sent to your mentioned Email.";
								$this->Session->setFlash($mesg,'success_msg',array(),'company_valid');
							}
							//$this->redirect(array('controller'=>'companies','action'=>'add',$company_id));
						}
						else {
								echo "company user not saved";	
						}
				}
				else {
					
						echo "company not saved";
				}
				
		}
	}
	
	public function add() {

		if (@$this->userInfo['users']['id']) {
			$uid = $this->userInfo['users']['id'];
			$user_profile = $this->userInfo['users_profiles'];
			$this->set('user_profile',$user_profile);
			
			$paramenter = $this->params['pass'];
			$companyid = $paramenter[0];
			
			if ($companyid) {
				
							$Update_Company_Detail = ClassRegistry::init('companies')->find('all',array('fields' =>array('
																														 companies.*,
																														 countries.name,
																														 industries.title,
																														 companies_types.title
																														 '),
																										'joins' => array(
																														 array(
																															   'alias' => 'countries',
																															   'table' => 'countries',
																															   'type' => 'left',
																															   'foreignKey' => false,
																															   'conditions' => array('companies.country_id = countries.id'
																																					 )
																															   ),
																														 array('alias' => 'industries',
																															   'table' => 'industries',
																															   'type' => 'left',
																															   'foreignKey' => false,
																															   'conditions' => array('companies.industry_id = industries.id'
																																					 )
																															   ),
																														 array('alias' => 'companies_types',
																															   'table' => 'companies_types', 
																															   'type' => 'left',
																															   'foreignKey' => false,
																															   'conditions' => array('companies.company_type_id = companies_types.id'
																																					 )
																															   )
																														 ),
																										'conditions' => array('companies.id'=>$companyid)
																							)
																							);	
			    $this->set('Update_Company_Detail',$Update_Company_Detail);
				
				$this->set('companyid',$companyid);
				
			$this->loadModel('Company_user');
			$this->loadModel('Users_profile');
			$admin_users_to_page = $this->Company_user->find('all', array('fields'=>array('users_profiles.*,Company_user.id'),'order'=>'Company_user.id DESC','limit'=>10,
															'joins'=>array(
																  array('alias' => 'users_profiles', 'table' => 'users_profiles', 'foreignKey' => false,
																'conditions' => array('Company_user.user_id = users_profiles.user_id AND Company_user.company_id='.$companyid))),
													'condition'=>array('Company_user.company_id='.$companyid)));

			$this->set('admin_users_to_page',$admin_users_to_page);
			}
			
			$company__Types = ClassRegistry::init('companies_types')->find('all',array('fields'=>array(
																									  'companies_types.id','companies_types.title','companies_types.status'),
																		  							  'conditions'=>array('companies_types.status=2')));
			$this->set('company__Types',$company__Types);
			
			$company__OF_Indus = ClassRegistry::init('industries')->find('all',array('fields'=>array(
																									  'industries.id','industries.title')));
			$this->set('company__OF_Indus',$company__OF_Indus);
			
						$company_Operating_status = ClassRegistry::init('company_operating_statuses')->find('all',array('fields'=>array(
																							'company_operating_statuses.operating_status','company_operating_statuses.id')));
			$this->set('company_Operating_status',$company_Operating_status);
			
			$company_countries = ClassRegistry::init('countries')->find('all',array('fields'=>array(
																							'countries.name','countries.id')));
			$this->set('company_countries',$company_countries);
	
		}
			if ($this->request->is('post')) {
				$this->loadModel('Company');
				$error = 0;
				$this->request->data['Company']['user_id'] = $uid;
				$this->request->data['Company']['status'] = 2;
				$companyid = $this->request->data['Company']['companyid'];
				$fileName = $this->request->data['Company']['image'];
				$fileLogo = $this->request->data['Company']['logo'];
				
				$old_data_images = ClassRegistry::init('companies')->find('all',
																	 array('fields'=>array('companies.image,companies.logo'),
																	 		'conditions'=>array('companies.id'=> $companyid)));
				if ($old_data_images) {
				foreach ($old_data_images as $get_image_company) {
					
					$image = $get_image_company['companies']['image'];
					$logo = $get_image_company['companies']['logo'];
				}
				}
				
				$imageName = $imageName['name'];
				$typess = $fileName['type'];
			
					$imageTypes = array("image/gif", "image/jpeg", "image/png","image/jpg");
					$uploadFolder = "files/company/";
					$uploadPath = MEDIA_PATH . $uploadFolder;

						  if ($fileName['name']) {	
							if ($fileName['type'] == "image/gif" || $fileName['type'] == "image/jpeg" || $fileName['type'] == "image/png" || $fileName['type'] == "image/jpg") {
								$imageName = date('His').$fileName['name'];
								
								$full_image_path = $uploadPath . 'original/' . $imageName;
								if (move_uploaded_file($fileName['tmp_name'], $full_image_path)) {
									$data['image'] = $imageName;
									$this->request->data['Company']['image'] = $data['image'];
									
									$source_image = $uploadPath.'original/'.$data['image'];
									$destination_logo_path = $uploadPath.'cover/'.$data['image'];
									$this->__imageresize($source_image, $destination_logo_path, 237, 653);	
								} 
								else {
									$mesg = "There was a problem uploading Cover image. Please try again";
									$error = 1;
								}
							}
							else {
								$mesg = "Unacceptable Cover image type";
								$error = 1;
							}
						  }
						  if ($fileLogo['name']) {
							if ($fileLogo['type'] == "image/gif" || $fileLogo['type'] == "image/jpeg" || $fileLogo['type'] == "image/png" || $fileLogo['type'] == "image/jpg") {
								$logoName = date('His').$fileLogo['name'];
								
								$full_logo_path = $uploadPath . 'original/' . $logoName;
								if (move_uploaded_file($fileLogo['tmp_name'], $full_logo_path)) {
									$data['logo'] = $logoName;
									$this->request->data['Company']['logo'] = $data['logo'];
									 
									$source_image = $uploadPath.'original/'.$data['logo'];
									$destination_logo_path = $uploadPath.'logo/'.$data['logo'];
									$this->__imageresize($source_image, $destination_logo_path, 100, 100);
																	
									$destination_thumb_path = $uploadPath.'thumbnail/'.$data['logo'];
									$this->__imageresize($source_image, $destination_thumb_path, 100, 100);
									
									$destination_icon_path = $uploadPath.'icon/'.$data['logo'];
									$this->__imageresize($source_image, $destination_icon_path, 60, 60);
									 
								} 
								else {
									$mesg = "There was a problem uploading Logo. Please try again";
									$error = 1;
								}
							}
							else {
								$mesg = "Unacceptable Logo type";
								$error = 1;
							}
						  }
							
					if ($imageName == '') {
						
						if($image) {
						 $this->request->data['Company']['image'] = $image;
						}
						else {
							$this->request->data['Company']['image'] = '';
						}
					}
						
					if ($logoName == '') {
						$this->request->data['Company']['logo'] = $logo;
					}

					$this->Company->id = $companyid;
					if ($error == 0) {
						if ($this->Company->save($this->request->data)) {
							//$company_id = $this->Company->getInsertID();
							$this->loadModel('Users_following');
							$check_following = $this->Users_following->find('first',array('fields'=>array('
																										  Users_following.id
																										  '),
																						  'conditions'=>array('Users_following.following_id='.$companyid. ' AND 
																											  Users_following.following_type ="company" AND 
																											  Users_following.user_id='.$uid)));
							$following_id = $check_following['Users_following']['id'];
							
							$this->request->data = '';
							$this->request->data['Users_following']['user_id'] = $uid;
							$this->request->data['Users_following']['following_id'] = $companyid;
							$this->request->data['Users_following']['following_type'] = "company";
							$this->request->data['Users_following']['status'] = 2;
							$date_created = date("Y-m-d H:i:s");
							$this->request->data['Users_following']['start_date'] = $date_created;
							$this->request->data['Users_following']['end_date'] = $date_created;
							
							if ($following_id != '') {
								$this->Users_following->id = $following_id;
							}
							
							if ($this->Users_following->save($this->request->data)) {
								$mesg = "Company Page has been created successfully";
								$this->Session->setFlash($mesg,'success_msg');
							$this->redirect(array('controller'=>'companies','action'=>'page'));
							}
							
						}
						else {
								echo "data not saved";
								//exit;
						}
					}
					else {
						$this->Session->setFlash($mesg,'error_msg');
						$this->redirect(array('controller'=>'companies','action'=>'add',$companyid));
					}
			}
	}
	
	public function add_admin() {
		if ($this->request->is('post')) {
				$this->loadModel('Company_user');
				$admin_user = $this->request->data['Company_user']['user_id'];
				$company_id = $this->request->data['Company_user']['company_id'];
				$this->request->data['Company_user']['status'] = 2;
				$dt_created = date("Y-m-d H:i:s");
				$this->request->data['Company_user']['created'] = $dt_created;
				$check_user = $this->Company_user->find('all', array('conditions'=>array('Company_user.user_id'=>$admin_user,'Company_user.company_id'=>$company_id)));

				if (sizeof($check_user) == 0) {
					if ($this->Company_user->save($this->request->data)) {
					//$company_id = $this->Company_user->getInsertID();
					$this->redirect(array('controller'=>'companies','action'=>'add/'.$company_id));
					}
					else {
						echo "data not saved";
						//exit;
					}
				}
				else {
					
					$error = "This user is already added to this page.";
					$this->redirect(array('controller'=>'companies','action'=>'page','error'=>$error));
				}
		}
	}
	
	public function page() {
		if (@$this->userInfo['users']['id']) {
			$uid = $this->userInfo['users']['id'];
			$this->loadModel('Company_user');
		$companyPagesBYuser = ClassRegistry::init('companies')->find('all',
																	 array('fields'=>array('companies.*,industries.title'),'group'=>'companies.id',
																			'joins'=>array(array(
																			'alias' => 'industries', 'table' => 'industries', 'type' => 'left', 'foreignKey' => false,
																						'conditions' => array('companies.industry_id = industries.id')),
																						   array(
																			'alias' => 'Company_user', 'table' => 'company_users', 'foreignKey' => false,
																						'conditions' => array('companies.id = Company_user.company_id'))),
																	 		'conditions'=>array('OR'=>array('companies.user_id'=> $uid,'Company_user.user_id'=>$uid))));
		
		
		$this->set('companyPagesBYuser',$companyPagesBYuser);
		$this->set('total_pages',sizeof($companyPagesBYuser));
		}
	}
	public function jobs(){
		//Configure::write('debug', 2);
		$paramenter = $this->params['pass'];
		$companyid = $paramenter[0];
		if ($companyid) {
			$this->set('companyid',$companyid);
			
			if (@$this->userInfo['users']['id']) {
				$uid = $this->userInfo['users']['id'];
			}
			$companyDetail = ClassRegistry::init('companies')->find('first',array('fields' =>array('
																								 companies.id,
																								 companies.title,
																								 companies.user_id,
																								 companies.logo,
																								 companies.city,
																								 companies.weburl,
																								 companies.established,
																								 countries.name,
																								 industries.title,
																								 companies_types.title
																								 '),
																				'joins' => array(array('alias' => 'countries', 
																									   'table' => 'countries',
																									   'type' => 'left',
																									   'foreignKey' => false,
																									   'conditions' => array('companies.country_id = countries.id'
																															 )
																									   ),
																								 array('alias' => 'industries',
																									   'table' => 'industries',
																									   'type' => 'left',
																									   'foreignKey' => false,
																									   'conditions' => array('companies.industry_id = industries.id'
																															 )
																									   ),
																								 array('alias' => 'companies_types',
																									   'table' => 'companies_types',
																									   'type' => 'left',
																									   'foreignKey' => false,
																									   'conditions' => array('companies.company_type_id = companies_types.id'
																															 )
																									   )
																								 ),
																				'conditions' => array('companies.id'=>$companyid)
																							)
																	);	
			$this->set('companyDetail',$companyDetail);
			
			$company_admin = $companyDetail['companies']['user_id'];
			$admin_info = ClassRegistry::init('users_profiles')->find('first',array('fields'=>array('users_profiles.user_id,users_profiles.firstname,users_profiles.lastname'),
																					  'conditions'=>array('users_profiles.user_id='.$company_admin)));
			
			$this->set('admin_info',$admin_info);
			
			$this->loadModel('Users_following');
			$users_following_thisCompany = $this->Users_following->find('all',array(
												'conditions'=>array('Users_following.following_id='.$companyid.'
												AND Users_following.following_type="company"')));
			foreach ($users_following_thisCompany as $user_follow_page) {
				if ($user_follow_page['Users_following']['user_id'] == $uid) {
				$user_company_id = $user_follow_page['Users_following']['id'];
				$status = $user_follow_page['Users_following']['status'];
				}
				
			}
			$this->set('user_company_id',$user_company_id);
			$this->set('status',$status);
			$this->set('users_following_thisCompany',sizeof($users_following_thisCompany));
			
			$count_following_thisCompany = $this->Users_following->find('all',array(
												'conditions'=>array('Users_following.following_id='.$companyid.'
												AND Users_following.following_type="company" AND Users_following.status=2')));
			$this->set('count_following_thisCompany',sizeof($count_following_thisCompany));
			
			
			/* TO CHECK EDIT PERMISSION*/
			$this->loadModel('Company_user');
			$edit_Permission_for_User = ClassRegistry::init('companies')->find('all',
																	 array('fields'=>array('companies.*,Company_user.user_id'),
																			'joins'=>array(
																						   array(
																			'alias' => 'Company_user', 'table' => 'company_users', 'foreignKey' => false,
																						'conditions' => array('companies.id = Company_user.company_id'))),
														'conditions'=>array('companies.id='.$companyid.' AND (companies.user_id='.$uid.' OR Company_user.user_id='.$uid.')')));
		$this->set('check_permission',sizeof($edit_Permission_for_User));
			//$this->loadModel('Country');
			$this->loadModel('Job');
			$this->loadModel('jobs_company_page');
					
			
			$this->jobs_company_page->bindModel(array('belongsTo'=>array('Job'=>array('foreignKey'=>false,'conditions'=>array('jobs_company_page.job_id=Job.id')),'Company'=>array('foreignKey'=>false,'conditions'=>array('Job.company_id=Company.id')))));
			$conditions = array('jobs_company_page.company_id'=>$companyid);
			$data1= $this->jobs_company_page->find('all',array('conditions'=>$conditions,'order'=>'Job.modified desc'));
			
			$this->Job->bindModel(array('belongsTo'=>array('Company'=>array('foreignKey'=>false,'conditions'=>array('Job.company_id=Company.id')))));
			$conditions2 = array('AND'=>array('Job.company_id'=>$companyid,'Job.status'=>2));
			$data2= $this->Job->find('all',array('conditions'=>$conditions2,'order'=>'Job.modified desc'));
			
			$data3=array_merge($data1,$data2);
			
			$this->set('data',$data3);
			
			
		}
	}							
	public function view() {
		$paramenter = $this->params['pass'];
		$companyid = $paramenter[0];
		if ($companyid) {
			$this->set('companyid',$companyid);
		
			if (@$this->userInfo['users']['id']) {
			$uid = $this->userInfo['users']['id'];
			}
			$companyDetail = ClassRegistry::init('companies')->find('first',array('fields' =>array('
																								 companies.id,
																								 companies.title,
																								 companies.user_id,
																								 companies.logo,
																								 companies.image,
																								 companies.city,
																								 companies.weburl,
																								 companies.established,
																								 companies.company_size,
																								 countries.name,
																								 industries.title,
																								 companies_types.title
																								 '),
																				'joins' => array(array('alias' => 'countries', 
																									   'table' => 'countries',
																									   'type' => 'left',
																									   'foreignKey' => false,
																									   'conditions' => array('companies.country_id = countries.id'
																															 )
																									   ),
																								 array('alias' => 'industries',
																									   'table' => 'industries',
																									   'type' => 'left',
																									   'foreignKey' => false,
																									   'conditions' => array('companies.industry_id = industries.id'
																															 )
																									   ),
																								 array('alias' => 'companies_types',
																									   'table' => 'companies_types',
																									   'type' => 'left',
																									   'foreignKey' => false,
																									   'conditions' => array('companies.company_type_id = companies_types.id'
																															 )
																									   )
																								 ),
																				'conditions' => array('companies.id'=>$companyid)
																							)
																	);	
			$this->set('companyDetail',$companyDetail);
			$company_admin = $companyDetail['companies']['user_id'];
			$admin_info = ClassRegistry::init('users_profiles')->find('first',array('fields'=>array('users_profiles.user_id,users_profiles.firstname,users_profiles.lastname'),
																					  'conditions'=>array('users_profiles.user_id='.$company_admin)));
			
			$this->set('admin_info',$admin_info);
			$this->loadModel('Users_following');
			$users_following_thisCompany = $this->Users_following->find('all',array(
												'conditions'=>array('Users_following.following_id='.$companyid.'
												AND Users_following.following_type="company"')));
			foreach ($users_following_thisCompany as $user_follow_page) {
				if ($user_follow_page['Users_following']['user_id'] == $uid) {
				$user_company_id = $user_follow_page['Users_following']['id'];
				$status = $user_follow_page['Users_following']['status'];
				}
				
			}
			$this->set('user_company_id',$user_company_id);
			$this->set('status',$status);
			$this->set('users_following_thisCompany',sizeof($users_following_thisCompany));
			
			$count_following_thisCompany = $this->Users_following->find('all',array(
												'conditions'=>array('Users_following.following_id='.$companyid.'
												AND Users_following.following_type="company" AND Users_following.status=2')));
			$this->set('count_following_thisCompany',sizeof($count_following_thisCompany));
			
		
		/* ******************************************* LISTING COMPANY'S UPDATES ******************************************/
		$this->loadModel('Entity_update');
			$company_Updates = $this->Entity_update->find('all',array('fields'=>array('
																					  Entity_update.id,
																					  Entity_update.user_id,
																					  Entity_update.group_title,
																					  Entity_update.image,
																					  Entity_update.entity_type,
																					  Entity_update.update_text,
																					  Entity_update.created,
																					  companies.id,
																					  companies.logo,
																					  companies.title,
																					  likes.like,
																					  likes.content_id,
																					  likes.id,
																					  likes.user_id,
																					  count(likes.like) as total
																					  '),
																	  'joins'=>array(
																					 array('alias' => 'companies',
																						   'table' => 'companies',
																						   'foreignKey' => false,
																						   'conditions'=>array('Entity_update.entity_id=companies.id'
																											   )
																						   ),
																					 array('alias' => 'users_followings',
																						   'table' => 'users_followings',
																						   'foreignKey' => false,
																						   'conditions'=>array('Entity_update.entity_id=users_followings.following_id AND users_followings.following_type="company"'
																											   )
																						   ),
																					 array('alias' => 'likes',
																						   'table' => 'likes',
																						   'foreignKey' => false,
																						   'conditions' => array('Entity_update.id  = likes.content_id'
																												 )
																						   )
																					 ),
																	  'conditions'=>array('Entity_update.entity_id='.$companyid.' AND (Entity_update.user_id = companies.user_id OR Entity_update.user_id=users_followings.user_id) AND (Entity_update.entity_type="company" AND likes.content_type="company")'),
																	  'order'=>'Entity_update.id DESC',
																	  'group'=>'Entity_update.id'									   
																	  )
														  );
			

			$this->set('company_Updates',$company_Updates);
			
			/* ******************************************* LISTING COMPANY'S UPDATES' LIKES ******************************************/
			$likes_on_Update = ClassRegistry::init('likes')->find('all', array('fields'=>array('likes.*'),'order'=>'likes.id DESC',
																					 'conditions'=>array(
																									 'likes.content_type="company"')));

		$this->set('likes_on_Update',$likes_on_Update);
		
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
																					'conditions'=>array('likes.content_type="company" AND likes.like=1')
																											));
			$this->set('likesOnUpdates',$likesOnUpdates);
			
		/*who share an update*/
		$shareOnUpdates = $this->Entity_update->find('all', array('fields'=>array('
																					users_profiles.firstname,
																					users_profiles.lastname,
																					users_profiles.photo,
																					users_profiles.tags,
																					users_profiles.user_id,
																					Entity_update.share
																					'),
																  'order'=>'Entity_update.id DESC',
																  'joins'=> array(
																				 array(
																					   'alias'=> 'users_profiles',
																					   'table'=> 'users_profiles',
																					   'foreignKey'=> false,
																					'conditions'=> array('Entity_update.user_id = users_profiles.user_id'
																									  ))),
																  'conditions'=>array('Entity_update.entity_type="company" AND Entity_update.share !=0')
																											));
			$this->set('shareOnUpdates',$shareOnUpdates);
		
		/* ******************************************* LISTING COMPANY'S UPDATES' COMMENTS ******************************************/
			$user_comments = ClassRegistry::init('entity_comments')->find('all',array('fields'=>array('
																						  entity_comments.content_id,
																						  entity_comments.id,
																						  entity_comments.comments,
																						  entity_comments.user_id,
																						  entity_comments.created,
																						  users_profiles.firstname ,
																						  users_profiles.lastname,
																						  users_profiles.photo,
																						  users_profiles.handler
																						  '),
																					  'joins'=>array(
																									 array('alias' => 'users_profiles',
																										   'table' => 'users_profiles',
																										   'type' => 'left',
																										   'foreignKey' => false,
																										  'conditions' => array('entity_comments.user_id = users_profiles.user_id'
																													  )
																								)
																									 ),
																					  'conditions'=>array('entity_comments.content_type="company"'
																										  )
																					  )
																		  );
				//$this->set('comments_this_groups',$comments_this_groups);
		
		$this->set('user_comments', $user_comments);

		/*Count comments individually*/
		$updates_comments_count= ClassRegistry::init('entity_comments')->find('all', array('fields' => array(
																				'entity_comments.content_id,count(entity_comments.content_id) as commenttotal'),
										'conditions'=>array('entity_comments.content_type="company"'),'order'=>'entity_comments.id DESC','group'=>'entity_comments.content_id'));

	$this->set('updates_comments_count',$updates_comments_count);
			
		}
	}
	
	public function followers() {
		$paramenter = $this->params['pass'];
		$companyid = $paramenter[0];
		if ($companyid) {
			$this->set('companyid',$companyid);
		
			if (@$this->userInfo['users']['id']) {
			$uid = $this->userInfo['users']['id'];
			}
			$this->loadModel('Users_following');
			$companyDetail = ClassRegistry::init('companies')->find('first',array('fields' =>array('
																								 companies.id,
																								 companies.title,
																								 companies.user_id,
																								 companies.logo,
																								 companies.city,
																								 companies.weburl,
																								 companies.established,
																								 countries.name,
																								 industries.title,
																								 companies_types.title
																								 '),
																				'joins' => array(array('alias' => 'countries', 
																									   'table' => 'countries',
																									   'type' => 'left',
																									   'foreignKey' => false,
																									   'conditions' => array('companies.country_id = countries.id'
																															 )
																									   ),
																								 array('alias' => 'industries',
																									   'table' => 'industries',
																									   'type' => 'left',
																									   'foreignKey' => false,
																									   'conditions' => array('companies.industry_id = industries.id'
																															 )
																									   ),
																								 array('alias' => 'companies_types',
																									   'table' => 'companies_types',
																									   'type' => 'left',
																									   'foreignKey' => false,
																									   'conditions' => array('companies.company_type_id = companies_types.id'
																															 )
																									   )
																								 ),
																				'conditions' => array('companies.id'=>$companyid)
																							)
																	);	
			$this->set('companyDetail',$companyDetail);
			
			$company_admin = $companyDetail['companies']['user_id'];
			$admin_info = ClassRegistry::init('users_profiles')->find('first',array('fields'=>array('users_profiles.user_id,users_profiles.firstname,users_profiles.lastname'),
																					  'conditions'=>array('users_profiles.user_id='.$company_admin)));
			
			$this->set('admin_info',$admin_info);
	$company_followers = $this->Users_following->find('all',array('fields'=>array('
																			  Users_following.id,
																			  Users_following.start_date,
																			  users_profiles.firstname,
																			  users_profiles.lastname,
																			  users_profiles.photo,
																			  users_profiles.user_id,
																			  users_profiles.handler,
																			  users_profiles.tags
																					  '),
																			  'joins'=>array(
																							 array('alias' => 'users_profiles',
																								   'table' => 'users_profiles',
																								   'foreignKey' => false,
																								   'conditions'=>array('Users_following.user_id = users_profiles.user_id'
																													   )
																								   )
																							 ),
																			  'conditions'=>array('Users_following.following_id ='.$companyid.' AND (Users_following.following_type="company" AND Users_following.status=2)'),
																			  'order'=>'Users_following.id DESC'
																			  )
																  );	
														  
			$this->set('company_followers',$company_followers);
			
			$count_following_thisCompany = $this->Users_following->find('all',array(
												'conditions'=>array('Users_following.following_id='.$companyid.'
												AND Users_following.following_type="company" AND Users_following.status=2')));
			$this->set('count_following_thisCompany',sizeof($count_following_thisCompany));
			
			$users_following_thisCompany = $this->Users_following->find('all',array(
												'conditions'=>array('Users_following.following_id='.$companyid.'
												AND Users_following.following_type="company"')));
			foreach ($users_following_thisCompany as $user_follow_page) {
				if ($user_follow_page['Users_following']['user_id'] == $uid) {
				$user_company_id = $user_follow_page['Users_following']['id'];
				$status = $user_follow_page['Users_following']['status'];
				}
				
			}
			$this->set('user_company_id',$user_company_id);
			$this->set('status',$status);
			$this->set('users_following_thisCompany',sizeof($users_following_thisCompany));
		}
	}
	
	
		public function follow_page(){
		$this->loadModel('Users_following');
		if ($this->request->is('post')) {
			$status = $_POST["status"];
			$user_id = $_POST["user_id"];
			$company_id = $_POST["company_id"];
			$user_follow_id = $_POST["user_follow_id"];
			$date_to_created = date("Y-m-d H:i:s");
			$find_following_companies = $this->Users_following->find('all',array('conditions' => array(
							  'Users_following.user_id='.$user_id.' AND Users_following.following_type="company" AND Users_following.following_id='.$company_id)));
			$this->request->data['Users_following']['status'] = $status;
			$this->request->data['Users_following']['start_date'] = $date_to_created;
			if ($user_follow_id != '') {
				$this->Users_following->id = $user_follow_id;
				//if($this->Users_following->updateAll(array('Users_following.status' =>$status,'Users_following.start_date' =>$date_to_created), array('Users_following.id' => $user_follow_id))) 
				if ($this->Users_following->save($this->request->data)) 
				
				{
					$this->set('status',$status);
					$this->set('user_follow_id',$user_follow_id);
					$this->set('uid',$user_id);
					$this->set('company_id',$company_id);
				}
				else {
				echo "not updated";
				}
			}
			else {
				$this->request->data = '';
				$date_to_created = date("Y-m-d H:i:s");
				$this->request->data['Users_following']['user_id'] = $user_id;
				$this->request->data['Users_following']['following_id'] = $company_id;
				$this->request->data['Users_following']['following_type'] = "company";
				$this->request->data['Users_following']['status'] = $status;
				$this->request->data['Users_following']['start_date'] = $date_to_created;
				if ($this->Users_following->save($this->request->data)) {
					$user_follow_id = $this->Users_following->getInsertID();
					$this->set('status',$status);
					$this->set('user_follow_id',$user_follow_id);
					$this->set('uid',$user_id);
					$this->set('company_id',$company_id);
				}
				
			}
			$total_following_companies = $this->Users_following->find('all',array('conditions' => array(
							  'Users_following.following_type="company" AND Users_following.following_id='.$company_id.' AND Users_following.status=2')));
			$this->set('total_following_companies',sizeof($total_following_companies));
	  }
		$this->autorender = false;
	    $this->layout = false;
	    $this->render('follow_page');
	}
	
	public function home() {
	
		if (@$this->userInfo['users']['id']) {
			$uid = $this->userInfo['users']['id'];
			
			$this->loadModel('Entity_update');
			$this->loadModel('Users_following');
			
			if ($this->request->is('post')){
				
				$uid = $this->request->data['Entity_update']['user_id'];
				$this->request->data['Entity_update']['share_with'] = $this->request->data['Entity_update']['share_with'];
				$this->request->data['Entity_update']['group_title'] = $this->request->data['Entity_update']['title_group'];
				if(!empty($this->request->data['Entity_update']['link_content'])){
					$txt = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $this->request->data['Entity_update']['update_text']);
				
					$this->request->data['Entity_update']['update_text'] = $txt.'<div class="clear"></div>'.$this->request->data['Entity_update']['link_content'];
				}else{
					$this->request->data['Entity_update']['update_text'] = $this->request->data['Entity_update']['update_text'];
				}
			
			$this->request->data['Entity_update']['user_id'] = $this->request->data['Entity_update']['user_id'];
			$this->request->data['Entity_update']['entity_id'] = $this->request->data['Entity_update']['entity_id'];
			$this->request->data['Entity_update']['entity_type'] = "company";
			$this->request->data['Entity_update']['created'] = date("Y-m-d H:i:s");
			$entity_id = $this->request->data['Entity_update']['entity_id'];
			/*file uploading*/
			$filename = $this->request->data['Entity_update']['image'];
			$this->request->data['Entity_update']['image'] = $filename['name'];
			$photo = $this->request->data['Entity_update']['image'];
			$imagename = $filename['name'];
			$typess = $filename['type'];
			
			$imageTypes = array("image/gif", "image/jpeg", "image/png","image/jpg");
			
			$uploadFolder = "files/update/original/";
			$uploadPath = MEDIA_PATH . $uploadFolder;
			foreach ($imageTypes as $type) {
			
				if ($type == $filename['type']) {
					$imageName = $filename['name'];
					if (file_exists($uploadPath . '/' . $imageName)) {
						$imageName = date('His') . $imageName;
					}
					$full_image_path = $uploadPath . '/' . $imageName;
					$this->loadModel('Entity_update');
					if (move_uploaded_file($filename['tmp_name'], $full_image_path)) {
						$data['image'] = $this->request->data['Entity_update']['image'];
						$this->request->data['Entity_update']['image'] = $data['image'];
					}else{
						$mesg = "There was a problem uploading file. Please try again";
						$error = 1;
					}
				}
				else 
				{
					$mesg = "Unacceptable file type";
					$error = 1;
				}
			} //loop end
			if ($this->Entity_update->save($this->request->data)) {
					$lastid = $this->Entity_update->getInsertID();
					$this->request->data['likes']['content_type'] = 'company';
					$this->request->data['likes']['created'] = date("Y-m-d H:i:s");
					$this->request->data['likes']['like'] = 0;
					$this->request->data['likes']['user_id'] = $uid;
					$this->request->data['likes']['content_id'] = $lastid;
					if (ClassRegistry::init('likes')->save($this->request->data)) {
						$this->Session->setFlash('Record successfully added','success_msg');
						$this->redirect(array('controller' => 'companies', 'action' => 'view/'.$entity_id));
					}
				
				}
				else {
					$this->Session->setFlash($mesg,'error_msg');
					$this->redirect(array('controller' => 'companies', 'action' => 'view/'.$entity_id));
				}
				
			} // post end here
			
			/******************************************** LISTING COMPANY'S UPDATES ******************************************/
			$company_Updates = $this->Entity_update->find('all',array('fields'=>array('
																					  Entity_update.id,
																					  Entity_update.user_id,
																					  Entity_update.image,
																					  Entity_update.entity_type,
																					  Entity_update.entity_id,
																					  Entity_update.update_text,
																					  Entity_update.share_with,
																					  Entity_update.created,
																					  companies.id,
																					  companies.logo,
																					  companies.user_id,
																					  companies.title,
																					  likes.like,
																					  likes.content_id,
																					  likes.id,
																					  likes.user_id,
																					  count(likes.like) as total
																					  '),
																	  'joins'=>array(
																					 array('alias' => 'companies',
																						   'table' => 'companies',
																						   'foreignKey' => false,
																						   'conditions'=>array('Entity_update.entity_id=companies.id'
																											   )
																						   ),
																					 array('alias' => 'users_followings',
																						   'table' => 'users_followings',
																						   'foreignKey' => false,
																						   'conditions'=>array('Entity_update.entity_id=users_followings.following_id AND users_followings.following_type="company"'
																											   )
																						   ),
																					 array('alias' => 'likes',
																						   'table' => 'likes',
																						   'foreignKey' => false,
																						   'conditions' => array('Entity_update.id  = likes.content_id'
																												 )
																						   )
																					 ),
																	  'conditions'=>array('(Entity_update.user_id = companies.user_id OR Entity_update.user_id=users_followings.user_id) AND (Entity_update.entity_type="company" AND likes.content_type="company")'),
																'order'=>'Entity_update.id DESC','group'=>'Entity_update.id'									   
																	  ));
			

			$this->set('company_Updates',$company_Updates);
			
			
			$users_following_companies = $this->Users_following->find('all',array('fields'=>array('
																								 DISTINCT Users_following.following_id
																								  '),
																				  'conditions'=>array('Users_following.user_id='.$uid.' AND Users_following.following_type="company" AND Users_following.status=2'
																									  )
																				  )
																	  );
			foreach ($users_following_companies as $comp_follow_row) {
				$users_following_com_Array[] = $comp_follow_row['Users_following']['following_id'];
			}
			$this->set('users_following_com_Array',$users_following_com_Array);
			
			/* ******************************************* LISTING COMPANY'S UPDATES' LIKES ******************************************/
			$likes_on_Update = ClassRegistry::init('likes')->find('all', array('fields'=>array('likes.*'),'order'=>'likes.id DESC',
																					 'conditions'=>array(
																									 'likes.content_type="company"')));

		$this->set('likes_on_Update',$likes_on_Update);
		
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
																					'conditions'=>array('likes.content_type="company" AND likes.like=1')
																											));
			$this->set('likesOnUpdates',$likesOnUpdates);
			
			/*who share an update*/
		$shareOnUpdates = $this->Entity_update->find('all', array('fields'=>array('
																					users_profiles.firstname,
																					users_profiles.lastname,
																					users_profiles.photo,
																					users_profiles.tags,
																					users_profiles.user_id,
																					Entity_update.share
																					'),
																  'order'=>'Entity_update.id DESC',
																  'joins'=> array(
																				 array(
																					   'alias'=> 'users_profiles',
																					   'table'=> 'users_profiles',
																					   'foreignKey'=> false,
																					'conditions'=> array('Entity_update.user_id = users_profiles.user_id'
																									  ))),
																  'conditions'=>array('Entity_update.entity_type="company" AND Entity_update.share !=0')
																											));
			$this->set('shareOnUpdates',$shareOnUpdates);
		
		 /************************    ****************************Company Comments Start******************************************************************/
		
					$reqUser = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),'conditions'=>array('(connections.user_id='.$uid.' OR connections.friend_id='.$uid.') AND connections.request=1')));
			
		foreach ($reqUser as $rfid) {
			$comResult[] = $rfid['connections']['friend_id'];
			$comResult[] .= $rfid['connections']['user_id'];
		}
		
				$user_comments = ClassRegistry::init('entity_comments')->find('all',array('fields'=>array('
																										  entity_comments.content_id,
																										  entity_comments.comments,
																										  entity_comments.id,
																										  entity_comments.created,
																										  entity_comments.user_id,
																										  users_profiles.firstname ,
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
																											   'conditions' => array('entity_comments.user_id = users_profiles.user_id'
																																	 )
																											   )
																										 ),
																						  'conditions'=>array('entity_comments.content_type="company"'
																											  )
																						  )
																			  );
		$this->set('user_comments', $user_comments);

		/*Count comments individually*/
		$updates_comments_count= ClassRegistry::init('entity_comments')->find('all', array('fields' => array(
																				'entity_comments.content_id,count(entity_comments.content_id) as commenttotal'),
										'conditions'=>array('entity_comments.content_type="company"'),'order'=>'entity_comments.id DESC','group'=>'entity_comments.content_id'));

	$this->set('updates_comments_count',$updates_comments_count);
		/************************    ****************************Company Comments End******************************************************************/
		}
	}
	
	public function delete_update() {
		if ($this->request->is('get')) {
			$update_id = $_GET['update_id'];
			$db = ConnectionManager::getDataSource('default');
			$db->rawQuery("DELETE FROM entity_updates WHERE id=".$update_id);
			$db->rawQuery("DELETE FROM likes WHERE content_id=".$update_id.' AND content_type= "company"');
			$db->rawQuery("DELETE FROM entity_comments WHERE content_id=".$update_id.' AND content_type= "company"');
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('delete_update');
		}
		
	}
	
	public function delete_comment() {
		if ($this->request->is('get')) {
			$comment_id = $_GET['comment_id'];
			$content_id = $_GET['content_id'];
			$db = ConnectionManager::getDataSource('default');
			$db->rawQuery("DELETE FROM entity_comments WHERE id=".$comment_id.' AND content_type= "company"');
			
			$comments_this_company = ClassRegistry::init('entity_comments')->find('all',array('fields'=>array('entity_comments.content_id
																												  '),
																	 'conditions'=>array('entity_comments.content_id='.$content_id.' AND entity_comments.content_type="company"')
																	 )
																				  );
			echo $total_comments = sizeof($comments_this_company);
			
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('delete_comment');
		}
		
	}
	
		   /*add comments to company*/
	public function add_comments() {
		if ($this->request->is('post')) {
			$user_id = $_POST['user_id'];
			$content_id = $_POST['content_id'];
			$comment_text = $_POST['comments'];
			$created_date = date("Y-m-d H:i:s");
			$company_admin_id = $_POST['admin_id'];
			$this->request->data['entity_comments']['user_id'] = $user_id;
			$this->request->data['entity_comments']['content_type'] = "company";
			$this->request->data['entity_comments']['content_id'] = $content_id;
			$this->request->data['entity_comments']['created'] = $created_date;
			$this->request->data['entity_comments']['modified'] = $created_date;
			$this->request->data['entity_comments']['comments'] = $comment_text;
			if (ClassRegistry::init('entity_comments')->save($this->request->data)){
				//$last_comment_id = $this->Comment->getInsertID();
				$comments_this_company = ClassRegistry::init('entity_comments')->find('all',array('fields'=>array('
																												  entity_comments.content_id,
																												  entity_comments.id,
																												  entity_comments.user_id,
																												  entity_comments.comments,
																												  entity_comments.created,
																												  users_profiles.firstname,
																												  users_profiles.lastname,
																												  users_profiles.photo, 
																												  users_profiles.handler
																												  '),
																					 'joins'=>array(array(
																					 'alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('entity_comments.user_id = users_profiles.user_id'))),
																	 'conditions'=>array('entity_comments.content_id='.$content_id.' AND entity_comments.content_type="company"')
																	 )
																					  );
				$this->set('comments_this_company',$comments_this_company);
				$this->set('total_commentsOnUpdate',sizeof($comments_this_company));
				$this->set('company_admin_id',$company_admin_id);
				$this->set('content_id',$content_id);
			}
		}
		$this->autorender = false;
		$this->layout = false;
		$this->render('add_comments');
	}
	
	
	
	public function share() {
		$uid = @$this->userInfo['users']['id'];
	
		if ($uid) {
	
			if ($this->request->is('post')) {
				$share = $this->request->data['user_share'];
				$orignaltext = $this->request->data['update_text'];
				$sharetext = $this->request->data['share_text'];
				$updatedText = $orignaltext;
					if ($sharetext) {
						$updatedText .= "<br />".$sharetext;
					}
				$companyID = $this->request->data['entity_id'];
				$this->request->data['Entity_update']['share_with'] = $this->request->data['share_with'];
				$this->request->data['Entity_update']['update_text'] = $updatedText;
				$this->request->data['Entity_update']['user_id'] = $this->request->data['user_id'];
				$this->request->data['Entity_update']['entity_type'] = $this->request->data['content_type'];
				$this->request->data['Entity_update']['image'] = $this->request->data['photo'];
				$this->request->data['Entity_update']['share'] = $share;
				$this->request->data['Entity_update']['created'] = $this->request->data['comment_date'];
				$this->request->data['Entity_update']['entity_id'] = $this->request->data['entity_id'];
				
				$this->loadModel('Entity_update');
				if (ClassRegistry::init('Entity_update')->save($this->request->data)) {
					$lastid = $this->Entity_update->getInsertID();
						$this->request->data['likes']['content_type'] = 'company';
						$this->request->data['likes']['created'] = date("Y-m-d H:i:s");
						$this->request->data['likes']['like'] = 0;
						$this->request->data['likes']['user_id'] = $uid;
						$this->request->data['likes']['content_id'] = $lastid;
						if (ClassRegistry::init('likes')->save($this->request->data)) {
							$mesg = "Re-shared your Update Successfully";
							$this->Session->setFlash($mesg,'success_msg');
							$this->redirect(array('controller' => 'companies', 'action' => 'view',$companyID));
						}
					
					}
			}
		}

	}
	/*DEELETE COMPANY PAGE UDPATE*/
	
	public function delete() {
			$this->params['pass'];
			$paramenter = $this->params['pass'];
			$company__ID = $paramenter[0];
			if ($company__ID !=0) {
				$db = ConnectionManager::getDataSource('default');
				$db->rawQuery("DELETE FROM companies WHERE id=".$company__ID);
				$db->rawQuery("DELETE FROM users_followings WHERE following_id=".$company__ID." AND following_type='company'");
				$db->rawQuery("DELETE FROM entity_updates WHERE entity_id=".$company__ID." AND share_with='company'");
				$mesg = "Company page has been deleted successfully";
				$this->Session->setFlash($mesg,'success_msg');
				$this->redirect(array('controller'=>'companies','action'=>'search'));
			}
	}
	public function display() {}

	public function about(){}

	public function why(){}

	public function what(){}

	public function team(){}

	public function joinus(){}

	public function contact(){
	
		if(!empty($this->request->data)) {
			$department = $this->data['department'];
			switch ($department){
				case 0: $AdminEmail = 'info@networkwe.com'; break;
				case 1: $AdminEmail = 'support@networkwe.com'; break;
				case 2: $AdminEmail = 'sales@networkwe.com'; break;
				default : $AdminEmail = 'info@networkwe.com'; break;
			}
			$fulname = $this->data['fullname'];
			$this->set('fulname', $fulname);
			$email = $this->data['email'];
			$subject = $this->data['subject'];
			$message = $this->data['message'];
			
			$emailBody = 'The following user was trying to be in touch with us. Please revert back to this email ASAP.';
			$emailBody .= 'Name: '.$fulname.'
				Email: '.$email.'
					Message: '.$message;
			$this->set('emailBody', $emailBody);
			
			$this->Email->template='contactFormUser';
			$this->Email->sendAs = 'both';
			$this->Email->from = 'support@networkwe.com';
			$this->Email->to = $email; 
			$this->Email->subject = 'Contact Form Enquiry';
			$this->Email->_debug = FALSE;
			if ($this->Email->send($message)) {
				$this->Session->setFlash('Email sent.', 'default', array ('class' => 'success_msg'));
			}
			else {
				$this->Session->setFlash('Error sending email.', 'default', array ('class' => 'error_msg'));
			}
			
			$this->Email->template='contactFormAdmin';
			$this->Email->sendAs = 'both';
			$this->Email->from = $email;
			$this->Email->to = $AdminEmail; 
			$this->Email->subject = $subject;
			$this->Email->_debug = FALSE;
			$this->Email->send($emailBody);
		}
            
	}
}
