<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class SearchController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	
	var $components = array('Email');
	var $uses = array('Job');
	var $helpers = array('Form');
	
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	function beforeFilter() 
	{
		parent::beforeFilter(); 
		ini_set('max_execution_time', 300);
		
	  
		
	}
	
	public function changelang($lng)
	{
		/*$this->Session->write('Config.language', $lng);			
		$this->redirect($this->referer(null, true)); 
		die;*/
	}
	public function logout(){
		//$this->request(array('url'=>'demo.localhost.com/users/logout/'));
		$this->Cookie->destroy();
		$this->redirect($this->referer(null, true)); 
		die;
	}
	
	
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}
	public function countries(){
		$this->loadModel('Country');
		$countries = $this->Country->find('list');
		if(isset($this->params['requested'])){
		
			return $countries;
		}
	}
	public function functionalArea(){
		$this->loadModel('functional_area');
		$functionalArea = $this->functional_area->find('list');
		if(isset($this->params['requested'])){
		
			return $functionalArea;
		}
	}
	public function industry(){
		$this->loadModel('industry');
		$industry = $this->industry->find('list');
		if(isset($this->params['requested'])){
		
			return $industry;
		}
	}
	public function jobSearch(){
		
		$this->layout = false;
		$this->autoRender = false;
		
		if(isset($_POST)){
			
			$this->loadModel('Country');
			$this->loadModel('Company');
			$this->loadModel('functional_area');
			$this->loadModel('industry');
			//$this->loadModel('jobs_functional_area');
			
			$keyword = $this->data['keyword'];
			$functionalArea = $this->data['functionalArea'];
			$country = $this->data['country'];
			$experience = $this->data['experience'];
			$freshness = $this->data['freshness'];
			$industry = $this->data['industry'];
			$page = $this->data['page'];
			$this->Job->recursive = 0;	
//pr($this->data);			
			$conditions=array();
			if(!empty($keyword)){
				$conditions = array('Job.title LIKE'   =>'%'. $keyword . '%' );
			}
			$cond=array();
			$cond_function=array();
			$idx=1;
			if(!empty($functionalArea)){
			/*
				$function= $this->jobs_functional_area->find('all',array('conditions'=>array('jobs_functional_area.functional_area_id'=>$functionalArea)));	
				foreach($function as $row){
					$cond_function[] = array('Job.id'=>$row['jobs_functional_area']['job_id']);				
				}
				$cond[$idx++]=array('OR'=>$cond_function);*/
				$cond[$idx++] = array('Job.functional_area '=>$functionalArea);
			}
			if(!empty($industry)){
			
				
				$cond[$idx++] = array('AND'=>array('Job.industries '=>$industry));
			}
			
			if(!empty($country)){
				$cond[$idx++] = array('AND'=>array('Country.id '=>$country));
			}
			if(!empty($experience)){
			
				if($experience == 1){
					$cond[$idx++] =array('AND'=>array('Job.max_experience <='=>'1'));
				}
				if($experience == 2){
					$cond[$idx++] = array('AND'=>array('Job.min_experience >='=>'1', 'Job.max_experience <='=>'5' ));
				}
				if($experience == 3){
					$cond[$idx++] = array('AND'=>array('Job.min_experience >='=>'5', 'Job.max_experience <='=>'10' ));
				}
				if($experience == 4){
					$cond[$idx++] = array('AND'=>array('Job.min_experience >='=>'10' ));
				}
			}
			if(!empty($freshness)){
				if($freshness == 1){
					$startDate = time() - 24*3600;     
					$startDate = date('Y-m-d H:i:s',$startDate);   
					$today = date('Y-m-d H:i:s');
					$cond[$idx++] = array('AND'=>array('Job.modified >='=>$startDate, 'Job.modified <='=>$today ));
				}
				if($freshness == 2){
				
					$startTime = mktime(0, 0, 0, date('n'), date('j'), date('Y')) - ((date('N')-1)*3600*24);
					$startDate = date('Y-m-d H:i:s',$startTime); 
					$today = date('Y-m-d H:i:s');
					$cond[$idx++] = array('AND'=>array('Job.modified >='=>$startDate, 'Job.modified <='=>$today));
				}
				if($freshness == 3){
				
					$startTime = time () - 15 * 3600 * 24;
					$startDate = date('Y-m-d H:i:s',$startTime); 
					$today = date('Y-m-d H:i:s');
					$cond[$idx++] = array('AND'=>array('Job.modified >='=>$startDate, 'Job.modified <='=>$today, ));
				}
				if($freshness == 4){
				
					$startTime = time () - 30 * 3600 * 24;
					$startDate = date('Y-m-d H:i:s',$startTime); 
					$today = date('Y-m-d H:i:s');
					$cond[$idx++] = array('AND'=>array('Job.modified >='=>$startDate, 'Job.modified <='=>$today ));
				}
				if($freshness == 5){
				
					$startTime = time () - 60 * 3600 * 24;
					$startDate = date('Y-m-d H:i:s',$startTime); 
					$today = date('Y-m-d H:i:s');
					$cond[$idx++] = array('AND'=>array('Job.modified >='=>$startDate, 'Job.modified <='=>$today));
				}
				if($freshness == 6){
				
					$startTime = time () - 90 * 3600 * 24;
					$startDate = date('Y-m-d H:i:s',$startTime); 
					$today = date('Y-m-d H:i:s');
					$cond[$idx++] = array('AND'=>array('Job.modified >='=>$startDate, 'Job.modified <='=>$today ));
				}
				
			}
			$condition = array_merge($conditions,array('AND'=>array($cond,'Job.status'=>2)));
			//pr($condition);
			$this->paginate=array('conditions'=>$condition, 'limit'=>10);
			$this->set('data',$this->paginate('Job'));
		}
		$this->render('jobSearch');
		
	}
	public function checkSavedJob(){
		$this->loadModel('jobs_saved');
		$userid= $this->userInfo['users']['id'];
		$jobsSaved= $this->jobs_saved->find('all',array('conditions'=>array('jobs_saved.user_id'=>$userid)));
		$usersSavedJobs = array();
		$idx=0;
		foreach($jobsSaved as $js){
				$usersSavedJobs[$idx]=$js["jobs_saved"]["job_id"];
				$idx++;
			
		}
		//pr($usersSavedJobs);
		//$this->set('jobsSaved',$usersSavedJobs);
		if(isset($this->params['requested'])) { //--- return data if requested from view ---//
			 return $usersSavedJobs;
			 
		}
	}
	public function index($id){
	
		$userid= $this->userInfo['users']['id'];
		
		
		if($id){
			$row = $this->Job->find('first',array('conditions'=>array('Job.id'=>$id)));
			$sdata=$row['Job']['title'];
			$sdata=preg_replace("/[^a-zA-Z0-9]+/", " ", $sdata);
			$this->set('sectionTitle','Similar Jobs');
		}else{
			$sdata= '';
			$this->set('sectionTitle','All Jobs');
		}
		
		$sdata1= explode(" ",$sdata);
			
		$conditions = array();
		$i=0;
		for($i=0; $i<sizeof($sdata1);$i++){
			
			$cond[$i] = array('Job.title LIKE'   =>'%'. $sdata1[$i] . '%',);

		}	
		$conditions=array('OR'=>$cond,'AND'=>array('Job.status'=>2,'Job.id !='=>$id));
		//$conditions=array('Job.status'=>2);
		//pr($conditions);
		$this->paginate = array('conditions'=>$conditions,'order'=>'Job.modified desc', 'limit'=>10);
		
		$this->set('data',$this->paginate('Job'));
		
		
		
		

	}
	public function jobs_by_company($id){
	
		$userid= $this->userInfo['users']['id'];
		
		if($id){
			$conditions=array('AND'=>array('Job.company_id'=>$id,'Job.status'=>2));
			
		}else{
			$conditions=array('Job.status'=>2);
		}
		
			
		$this->paginate = array('conditions'=>$conditions,'order'=>'Job.modified desc', 'limit'=>10);
		
		$this->set('data',$this->paginate('Job'));
		
		

	}
	function userJobwidget($id){
		if($id){
			$row = $this->Job->find('first',array('conditions'=>array('Job.id'=>$id)));
			$sdata=$row['Job']['title'];
		}else{
			$sdata= $this->userInfo['users_profiles']['tags'];
		}
		$sdata1= explode(" ",$sdata);
			
		$conditions = array();
		$i=0;
		for($i=0; $i<sizeof($sdata1);$i++){
			
			$cond[$i] = array('Job.title LIKE'   =>'%'. $sdata1[$i] . '%',);

		}	
		$conditions=array('OR'=>$cond,'AND'=>array('Job.status'=>2));
		$data= $this->Job->find('all', array('conditions'=>$conditions,'order'=>'Job.modified desc','limit'=>10));
		
		if(isset($this->params['requested'])) { //--- return data if requested from view ---//
			 return $data;
			 
		}
	}
	function JobsWidget() {
		
		$data = $this->Job->find('all',array('limit'=>6)); 
			if(isset($this->params['requested'])) { //--- return data if requested from view ---//
				 return $data;
				 
			}
    }
	function companyWidgetHome(){
		$this->loadModel('Company');
		
		$data = $this->Company->find('all',array('conditions'=>array('Company.flag' => 'profile','Company.status'=>2),'order'=>'Company.modified desc','limit'=>15)); 
			if(isset($this->params['requested'])) { //--- return data if requested from view ---//
				 return $data;
				 
			}
		
	}
	function jobDetails($id=0){
		
		$this->loadModel('Country');
		$this->loadModel('Company');
		$this->loadModel('functional_area');
		//$this->loadModel('jobs_functional_area');
		
		$this->loadModel('users_qualification','qualification');
		$this->loadModel('users_experience');
		$this->loadModel('jobs_application');
		$this->loadModel('Connection');
		$this->loadModel('Users_profile');
		$userid= $this->userInfo['users']['id'];
		$user_profile= $this->userInfo['users_profiles']['user_id'];
		
		$this->users_experience->bindModel(array('belongsTo'=>array('Company'=>array('foreignKey'=>'company_id','fields'=>array('Company.title,Company.id')))));
		$userExperience= $this->users_experience->find('all',array('conditions'=>array('users_experience.user_id'=>$userid),'order'=>'users_experience.end_date desc','limit'=>3));
		
		$userQualification = $this->users_qualification->find('first',array('conditions'=>array('users_qualification.user_id'=>$userid),'order'=>'users_qualification.end_date desc'));
		$this->set('userQualification',$userQualification);
		$this->set('userExperience',$userExperience);
			
		$jobDetail = $this->Job->query("SELECT JS.*, CO.id, CO.title, CO.logo, COU.id, COU.name, JS.functional_area, FA.id,FA.title,NA.name,JT.type FROM jobs AS JS LEFT JOIN companies AS CO ON (JS.company_id=CO.id) LEFT JOIN countries AS COU ON (JS.country_id=COU.id) LEFT JOIN functional_areas AS FA ON (JS.functional_area=FA.id) LEFT JOIN countries AS NA ON (JS.nationality=NA.id) LEFT JOIN job_types AS JT ON (JS.job_type=JT.id) WHERE JS.id=$id");
		$this->set('jobDetail',$jobDetail);
		
		
		$jobApplyCount = $this->jobs_application->find('count',array('conditions'=>array('jobs_application.job_id'=>$id)));
		$this->set('jobAppCount',$jobApplyCount);
		
		
		if(isset($user_profile)){
			
			//$conn= $this->Connection->find('all',array('conditions'=>array('Connection.user_id'=>$userid)));
			$conn= $this->Connection->find('all',array('conditions'=>array('AND' => array('Connection.request=1', 'OR'=> array('Connection.user_id'=>$userid,'Connection.friend_id'=>$userid)))));
			if($conn){
				foreach($conn as $row){
					if($userid == $row['Connection']['friend_id']){
						$connection = $row['Connection']['user_id'];
					}else{
						$connection = $row['Connection']['friend_id'];
					}
					$findCon[] = $this->Users_profile->find('all',array('conditions'=>array('Users_profile.user_id'=>$connection)));
				}
			
			$this->set('con',$findCon);
			}
		}
		
		$arr = $this->params['pass'];
        $jobs_url = $arr[0];
		
		if($jobs_url){
			$rec_sjobs = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobs_url)));
			$sdata=$rec_sjobs['Job']['title'];
			//$sdata=preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $sdata);
			$sdata=preg_replace("/[^a-zA-Z0-9]+/", " ", $sdata);
			
			//echo $sdata;
			$sdata1= explode(" ",$sdata);
			
			$sconditions = array();
			$i=0;
			for($i=0; $i<sizeof($sdata1);$i++){
				
				$scond[$i] = array('Job.title LIKE'   =>'%'. $sdata1[$i] . '%',);

			}	
			$sjobs= $this->Job->find('all',array('conditions'=>array('OR'=>$scond,'AND'=>array('Job.status'=>2,'Job.id !='=>$jobs_url)),'order'=>'Job.modified desc', 'limit'=>5));
			$this->set('urlid',$rec_sjobs);
			$this->set('sjobs',$sjobs);
			
			
		}
		
		
	}
	
	function jobsApplication($id=0){
		
		$this->loadModel('Country');
		$this->loadModel('Company');
			
		$this->loadModel('jobs_application');
		$userid= $this->userInfo['users']['id'];
		
		//pr($this->request->data);
		if ($this->request->is('post')) {
			if(($this->request->data['jobsApplication']['resume']['size']>16777216) OR ($this->request->data['jobsApplication']['cover_letter']['size']>16777216)){
				
				$res= $this->request->data['jobsApplication']['resume']['size'];
				$cl= $this->request->data['jobsApplication']['cover_letter']['size'];
				$this->Session->setFlash(__('The file size is more than 2MB. Please, try again.',true),'error_msg');
				$this->redirect(array('action' => 'jobDetails/'.$id));
				
				}
		
			$appliedAlready = $this->jobs_application->find('first',array('conditions'=>array('jobs_application.job_id'=>$id,'jobs_application.user_id'=>$userid)));
			if(empty($appliedAlready)){
							
				$upload_file_path = MEDIA_PATH.'/files/resume/';
				
				
				if(!is_dir($upload_file_path)){
					mkdir($upload_file_path, 0777);
				}
				$randNumbers =  time();
				$renameCV = $randNumbers.$this->request->data['jobsApplication']['resume']['name'];
				$renameCL = $randNumbers.$this->request->data['jobsApplication']['cover_letter']['name'];
				$upload_CV = $upload_file_path.DS.$renameCV;
				$upload_CL = $upload_file_path.DS.$renameCL;
				
				
				
				
				if(move_uploaded_file($this->request->data['jobsApplication']['resume']['tmp_name'], $upload_CV)){
					$this->request->data['jobs_application']['cv']= $renameCV;
					/*
					$source_image = $upload_file_path.$renameCV;
					$destination_thumb_path = $upload_file_path.'thumbs/' . $renameCV;
					$this->__imageresize($source_image, $destination_thumb_path, 92, 112);
					*/
					
				}else{
					$this->request->data['jobs_application']['cv']= '';
				}
				if(move_uploaded_file($this->request->data['jobsApplication']['cover_letter']['tmp_name'], $upload_CL)){
					$this->request->data['jobs_application']['cover_letter']= $renameCL;
					
					
				}else{
					$this->request->data['jobs_application']['cover_letter']= '';
				}
					
					$this->jobs_application->create();
					
					$this->request->data['jobs_application']['job_id']= $id;
					$this->request->data['jobs_application']['user_id']= $userid;					
					$this->request->data['jobs_application']['status']= 2;
					
					if($this->jobs_application->save($this->request->data)){
						$this->Session->setFlash(__('Job application successful!',true),'success_msg');
						$this->redirect(array('action' => 'jobDetails/'.$id));
					}else{
					
					$this->Session->setFlash(__('The data could not be saved. Please, try again.',true),'error_msg');
					$this->redirect(array('action' => 'jobDetails/'.$id));
					}
			}else{
				$this->Session->setFlash(__('You have applied to this job already.',true),'error_msg');
				$this->redirect(array('action' => 'jobDetails/'.$id));
			}
			
		}else{
		
			$sdata= $this->Job->find('first',array('conditions'=>array('Job.id'=>$id)));
			
			$sdata1= explode(" ",$sdata['Job']['title']);
				
			$conditions = array();
			$i=0;
			for($i=0; $i<sizeof($sdata1);$i++){
				
				$cond[$i] = array('Job.title LIKE'   =>'%'. $sdata1[$i] . '%',);

			}	
			$conds=array('OR'=>$cond);
			$condition = array_merge($conds,array('AND'=>array('Job.title !='=>$sdata['Job']['title'])));
			$dataa= $this->Job->find('all', array('conditions'=>$condition,'limit'=>4));
			
			$this->set('similarJobs',$dataa);
		
			$this->set('data',$sdata);
		}
		
	}
	
	function jobForward($id=0){
		
		$this->loadModel('Country');
		$this->loadModel('Company');
		$this->loadModel('User');
		
		$this->loadModel('jobs_referral');
		$this->loadModel('Connection');
		$userid= $this->userInfo['users']['id'];
		$user_profile= $this->userInfo['users_profiles']['user_id'];
		
		if(isset($this->request->data['Send'])){
			$fmail=$this->request->data['friendsEmail'];
			$omail=$this->request->data['ms4'];
			if(empty($fmail) AND empty($omail)) {
					$this->Session->setFlash(__('Both fields were empty, Please try again.',true),'error_msg');
					$this->redirect(array('action' => 'jobDetails/'.$this->request->data['job_id']));
			}else{
			
		
			$job_link=JOBS_URL.'/search/jobDetails/'.$this->request->data['job_id'];
			$femail=$this->request->data['friendsEmail'];
			$sdata1= explode(",",$femail);
			
			if(!empty($this->request->data['ms4'])){
				$conEmail = $this->request->data['ms4'];
				$cm= str_replace(array('[',']','"','"'), '', $conEmail);
				$cemail = explode(",", $cm);
				$sdata= array_merge($sdata1,$cemail);
			}
			else{
				$cemail='';
				$sdata =$sdata1;
			}
				
				if(!empty($sdata)){
					
					foreach($sdata as $email)
					{
						if(!empty($email)){
						
							if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
							{
								$this->Session->setFlash(__('Invalid email address, Please try again.',true),'error_msg');
								$this->redirect(array('action' => 'jobDetails/'.$this->request->data['job_id']));
							}else{
							$frndid = $this->User->find('first',array('conditions'=>array('User.email'=>$email)));
							$this->jobs_referral->create();
							$this->request->data['jobs_referral']['job_id']= $this->request->data['job_id'];
							$this->request->data['jobs_referral']['user_id']= $userid;
							$this->request->data['jobs_referral']['email']= $email;
							if(!empty($frndid)){
								$this->request->data['jobs_referral']['friend_id']= $frndid['User']['id'];
								
							}
							$this->request->data['jobs_referral']['status']= 2;
							if($this->jobs_referral->save($this->request->data)){
							
								$this->Email->template = 'message'; 
								$this->set('yourname', $this->request->data['jobForward']['yourname']); 
								$this->set('data', $job_link); 
								$this->Email->sendAs = 'both';
								$this->Email->from = 'support@networkwe.com';
								$this->Email->subject = 'Invitation to Post Resume';
								$this->Email->_debug = false; 
								$this->Email->to = $email;
								if($this->Email->send()){
									$this->Session->setFlash(__('The job has successfully been forwarded!',true),'success_msg');
									$this->redirect(array('action' => 'jobDetails/'.$this->request->data['job_id']));
								}else{
									$this->Session->setFlash(__('The job could only be saved without email!',true),'alert_msg');
									$this->redirect(array('action' => 'jobDetails/'.$this->request->data['job_id']));
								}
								
							}
							}
							
						}
						
					}
				}
				else
				{
					$this->Session->setFlash(__('The job could not be forwarded. Please, try again.',true),'error_msg');
					$this->redirect(array('action' => 'jobDetails/'.$this->request->data['job_id']));
				}
		
			}
		}
//--Default data required in view--//
		$sdata= $this->Job->find('first',array('conditions'=>array('Job.id'=>$id)));
		$this->set('data',$sdata);
		
	}
	
	function saveJob(){
		
		$this->autoRender = false;
		$this->loadModel('jobs_saved');
		
		if($this->request->is('post')){
			$jobid = $this->request->data['job_id'];
			$userid= $this->userInfo['users']['id'];
			$data = $this->jobs_saved->find('count',array('conditions'=>array('AND'=>array('jobs_saved.user_id'=>$userid,'jobs_saved.job_id'=>$jobid))));
			$jobCount1 = $this->jobs_saved->find('count',array('conditions'=>array('jobs_saved.user_id'=>$userid)));
			if($data < 1){
				$this->jobs_saved->create();
				if($this->jobs_saved->save($this->request->data))
				{
					$jobCount = $this->jobs_saved->find('count',array('conditions'=>array('jobs_saved.user_id'=>$userid)));
					echo $jobCount;
					echo "|<div class='success_msg'>Your job has been saved!</div>";
				}else{
					
					echo $jobCount1;
					echo "|<div class='error_msg'>This jobs could not be saved!</div>";
					
				}
			}else{			
				echo $jobCount1;
				echo "|<div class='alert_msg'>You have already saved this job!</div>";
				
				
			}
			
		}

	}
	function unsaveJob(){
		
		$this->autoRender = false;
		$this->loadModel('jobs_saved');
		
		if($this->request->is('post')){
			$jobid = $this->request->data['job_id'];
			$userid= $this->userInfo['users']['id'];
			$data = $this->jobs_saved->find('first',array('conditions'=>array('jobs_saved.user_id'=>$userid,'jobs_saved.job_id'=>$jobid)));
			$jobCount1 = $this->jobs_saved->find('count',array('conditions'=>array('jobs_saved.user_id'=>$userid)));
			if($data){
			
				
				//pr($jobsavedid);exit;
				if ($this->jobs_saved->delete($data['jobs_saved']['id'])) {
					
					$jobCount = $this->jobs_saved->find('count',array('conditions'=>array('jobs_saved.user_id'=>$userid)));
					echo $jobCount;
					echo "|<div class='success_msg'>Your job has been unsaved!</div>";
				}else{
					echo $jobCount1;
					echo "|<div class='error_msg'>This jobs could not be unsaved!</div>";
				}
				
			}else{			
				echo $jobCount1;
				echo "|<div class='alert_msg'>No saved job!</div>";
				
				
			}
			
		}

	}
	function user_saved_jobs(){
		
		$this->loadModel('Country');
		$this->loadModel('Company');
			
		$this->loadModel('jobs_saved');
		$userid= $this->userInfo['users']['id'];
		$this->jobs_saved->recursive = 2;
		$this->jobs_saved->bindModel(array('belongsTo'=>array('Job'=>array('foreignKey'=>'job_id'))));
		$savedJobs = $this->jobs_saved->find('first',array('conditions'=>array('jobs_saved.user_id'=>$userid),'order'=>'jobs_saved.modified desc')); 
		
		$save=array();
		$countsavedJobs[] = $this->jobs_saved->find('count',array('conditions'=>array('jobs_saved.user_id'=>$userid))); 
		if(!empty($savedJobs)){
			if($countsavedJobs > 0){
				
				$save=array_merge($countsavedJobs,$savedJobs);
			}
		}
		if(isset($this->params['requested'])) { //--- return data if requested from view ---//
			 return $save;
				 
		}
			
	}
	
	function user_jobs_applied(){

		$this->loadModel('jobs_application');
		$userid= $this->userInfo['users']['id'];
		$jobsApplication = $this->jobs_application->find('count',array('conditions'=>array('jobs_application.user_id'=>$userid)));
	
		if(isset($this->params['requested'])) { //--- return data if requested from view ---//
			 return $jobsApplication;
				 
		}
	}
		
	function searchByFunction(){
		
		$this->loadModel('Country');
		$this->loadModel('Company');
		$this->loadModel('functional_area');
		
		$data =$this->functional_area->query("SELECT J.id, J.title, COUNT(FA.id)  FROM jobs AS FA LEFT JOIN functional_areas AS J  ON (FA.functional_area= J.id) GROUP BY FA.functional_area;");
		
		if(isset($this->params['requested'])) { //--- return data if requested from view ---//
			 return $data;
		}
		
		$this->set('data',$data);
		
	}
	function jobsByFunction($id=0){
		
		$this->loadModel('Country');
		$this->loadModel('Company');
		$this->loadModel('functional_area');
		
		if(!$id){
			$this->redirect('/');
		}
		$this->functional_area->recursive=0;
		$this->functional_area->bindModel(array('belongsTo'=>array('Job'=>array('foreignKey'=>'id'))));
		$ftitle= $this->functional_area->find('first',array('conditions'=>array('functional_area.id'=>$id)));
		$this->set('ftitle',$ftitle);

		$conditions=array('Job.functional_area'=>$id);
		$this->paginate=array('conditions'=>$conditions, 'limit'=>10);
		
		$this->set('jobsby',$this->paginate('Job'));
	}
	function searchByIndustry(){
		
		$this->loadModel('Country');
		$this->loadModel('Company');
		$this->loadModel('industry');
		
		$data =$this->industry->query("SELECT IND.id, IND.title, COUNT(J.id)  FROM jobs AS J LEFT JOIN industries AS IND  ON (IND.id= J.industries) GROUP BY J.industries;");
		
		if(isset($this->params['requested'])) { //--- return data if requested from view ---//
			 return $data;
		}
		
		$this->set('data',$data);
		
	}
	function jobsByIndustry($id=0){
		
		$this->loadModel('Country');
		$this->loadModel('Company');
		$this->loadModel('industry');
		
		if(!$id){
			$this->redirect('/');
		}
		$this->industry->recursive=0;
		$this->industry->bindModel(array('belongsTo'=>array('Job'=>array('foreignKey'=>'id'))));
		$title= $this->industry->find('first',array('conditions'=>array('industry.id'=>$id)));
		$this->set('title',$title);

		$conditions=array('Job.industries'=>$id);
		$this->paginate=array('conditions'=>$conditions, 'limit'=>10);
		
		$this->set('jobsby',$this->paginate('Job'));
	}
	
	
	function searchByLocation(){
		
		$this->loadModel('Country');
		$this->loadModel('Company');
		$this->loadModel('functional_area');
		$data = $this->Job->query("SELECT JFA.id,JFA.name,JFA.alpha_3, COUNT(FA.id)  FROM jobs AS FA LEFT JOIN countries AS JFA ON (FA.country_id= JFA.id) GROUP BY FA.country_id;");
		
		//pr($data);exit;
		if(isset($this->params['requested'])) { //--- return data if requested from view ---//
			 return $data;
		}
		$this->set('data',$data);
	}
	function jobsByLocation($id=0){
		
		$this->loadModel('Country');
		$this->loadModel('Company');
		$this->loadModel('functional_area');
	
		if(!$id){
			$this->redirect('/');
		}
		
		$this->Job->recursive=2;
		$conditions=array('Job.country_id'=>$id);
		$this->paginate=array('conditions'=>$conditions, 'limit'=>10);
		$this->set('jobsby',$this->paginate('Job'));
		
		
	}
	function shareJob(){
		
		$this->autoRender = false;
		$this->loadModel('statusupdate');
		
		if($this->request->is('post')){
			$jobid = $this->request->data['job_id'];
			$userid= $this->userInfo['users']['id'];
			$job = $this->Job->find('first',array('conditions'=>array('Job.id'=>$jobid)));
			
			$this->request->data['statusupdate']['user_id'] = $userid;
			$this->request->data['statusupdate']['content_type'] = "jobs";
			$this->request->data['statusupdate']['photo'] ='';
			$this->request->data['statusupdate']['share_with'] = 0;
			$this->request->data['statusupdate']['update_shared'] = 0;
			$this->request->data['statusupdate']['update_type'] = 1;
			if($job['Company']['logo']){
				if(file_exists(MEDIA_PATH.'/files/company/icon/'.$job['Company']['logo'])){
					$company_logo=MEDIA_URL.'/files/company/icon/'.$job['Company']['logo'];
				}else{
					$company_logo=MEDIA_URL.'/img/nologo.jpg';
				}
			}else{
					$company_logo=MEDIA_URL.'/img/nologo.jpg';
			}
			
			$job_link=JOBS_URL.'/search/jobDetails/'.$jobid.'/'.$job['Job']['title'];
			$details = strip_tags($job['Job']['description']);
			$detail=substr(trim($details),0,250).'...';
			$content = '<div class="extracted_url"><div class="extracted_thumb" id="extracted_thumb"><img src="'.$company_logo.'" width="60" height="60"></div><div class="extracted_content"><h4><a href="'.$job_link.'" target="_blank">'.$job['Job']['title'].'</a></h4><p>'.$detail.'</p></div></div>';
			
			$this->request->data['statusupdate']['user_text'] = $content;
			
			$this->statusupdate->create();
			if($this->statusupdate->save($this->request->data))
			{
				echo "<div class='success_msg'>Your job has been shared!</div>";
			}else{
			
				echo "<div class='error_msg'>This jobs could not be shared!</div>";
				
			}

		}

	}
	


}
