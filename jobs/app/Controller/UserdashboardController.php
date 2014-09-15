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
class UserdashboardController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $helpers = array('Html', 'Form');
	public $components = array('RequestHandler');
	var $uses = array('Job', 'Country', 'Company', 'functional_area');
	
	
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
		/*if(empty($this->userInfo['Users_profile']['user_id'])){
			$this->redirect('/');
		}*/
		
	}
		
	public function logout(){
		//$this->request(array('url'=>'demo.localhost.com/users/logout/'));
		$this->Cookie->destroy();
		$this->redirect($this->referer(null, true)); 
		die;
	}
		
	public function index(){
		
		$this->loadModel('users_qualification','qualification');
		$this->loadModel('users_experience');
		$this->loadModel('jobs_saved');
		$this->loadModel('jobs_application');
		$this->loadModel('jobs_referral');
		$userid= $this->userInfo['users']['id'];
		$this->RequestHandler->setContent('json', 'application/json');
		if(!empty($userid)){
			$this->users_experience->bindModel(array('belongsTo'=>array('Company'=>array('foreignKey'=>'company_id'))));
			$userExperience= $this->users_experience->find('all',array('conditions'=>array('users_experience.user_id'=>$userid),'order'=>'users_experience.end_date desc','limit'=>3));
			$userQualification = $this->users_qualification->find('first',array('conditions'=>array('users_qualification.user_id'=>$userid),'order'=>'users_qualification.end_date desc'));
			$this->set('userQualification',$userQualification);
			$this->set('userExperience',$userExperience);
			
			$cosavedJobs = $this->jobs_saved->find('count',array('conditions'=>array('jobs_saved.user_id'=>$userid)));
			$this->set('countsavedJobs',$cosavedJobs);
			$this->jobs_saved->recursive = 2;
			$this->jobs_saved->bindModel(array('belongsTo'=>array('Job'=>array('foreignKey'=>'job_id'))));
			$conditions=array('jobs_saved.user_id'=>$userid); 
			$this->paginate = array('order'=>'jobs_saved.modified desc ', 'limit'=>5);
			$this->set('savedJobs',$this->paginate('jobs_saved',$conditions));
			
			
			$corefferJob = $this->jobs_referral->find('count',array('conditions'=>array('jobs_referral.friend_id'=>$userid)));
			$this->set('countrefferjob',$corefferJob);
			
			$this->jobs_referral->recursive = 2;
			$this->jobs_referral->bindModel(array('belongsTo'=>array('Job'=>array('foreignKey'=>false,'type'=>'right','conditions'=>array('jobs_referral.job_id = Job.id')),'Users_profile'=>array('foreignKey'=>false,'type'=>'right','conditions'=>array('jobs_referral.user_id = Users_profile.user_id')))));
			$conditions=array('jobs_referral.friend_id'=>$userid); 
			$refferjob = $this->jobs_referral->find('all',array('conditions'=>$conditions,array('order'=>'jobs_referral.modified desc', 'limit'=>5)));
			$this->set('refferedJob',$refferjob);

			$coJobsapplication = $this->jobs_application->find('count',array('conditions'=>array('jobs_application.user_id'=>$userid)));
			$this->set('countJobsapplied',$coJobsapplication);
			$this->jobs_application->recursive = 2;
			$this->jobs_application->bindModel(array('belongsTo'=>array('Job'=>array('foreignKey'=>'job_id'))));
			$conditions=array('jobs_application.user_id'=>$userid); 
			$this->paginate = array('order'=>'jobs_application.modified desc ', 'limit'=>5);
			$this->set('appliedJobs',$this->paginate('jobs_application',$conditions));
			
			$this->set('_serialize', array('appliedJobs','savedJobs','refferedJob'));
			
		}
		else{
			$this->redirect('/');
		}
		
	}
	
	function allJobApplication(){
		$this->loadModel('jobs_application');
		$userid= $this->userInfo['users']['id'];
		if(!empty($userid)){
			$coJobsapplication = $this->jobs_application->find('count',array('conditions'=>array('jobs_application.user_id'=>$userid)));
			$this->set('countJobsapplied',$coJobsapplication);
			$this->jobs_application->recursive = 2;
			$this->jobs_application->bindModel(array('belongsTo'=>array('Job'=>array('foreignKey'=>'job_id'))));
			$conditions=array('jobs_application.user_id'=>$userid); 
			$this->paginate = array('order'=>'jobs_application.modified desc','limit'=>10);
			$this->set('appliedJobs',$this->paginate('jobs_application',$conditions));
		}
		else{
			$this->redirect('/');
		}
		
	}
	function allJobSaved(){
		$this->loadModel('jobs_saved');
		$userid= $this->userInfo['users']['id'];
		if(!empty($userid)){
			$cosavedJobs = $this->jobs_saved->find('count',array('conditions'=>array('jobs_saved.user_id'=>$userid)));
			$this->set('countsavedJobs',$cosavedJobs);
			$this->jobs_saved->recursive = 2;
			$this->jobs_saved->bindModel(array('belongsTo'=>array('Job'=>array('foreignKey'=>'job_id'))));
			$conditions=array('jobs_saved.user_id'=>$userid); 
			$this->paginate = array('order'=>'jobs_saved.modified desc','limit'=>10);
			$this->set('savedJobs',$this->paginate('jobs_saved',$conditions));
		}
		else{
			$this->redirect('/');
		}
		
	}
	function allJobReferred(){
		$this->loadModel('jobs_referral');
		$userid= $this->userInfo['users']['id'];
		if(!empty($userid)){
			$corefferJob = $this->jobs_referral->find('count',array('conditions'=>array('jobs_referral.friend_id'=>$userid)));
			$this->set('countrefferjob',$corefferJob);
			$this->jobs_referral->recursive = 2;
			$this->jobs_referral->bindModel(array('belongsTo'=>array('Job'=>array('foreignKey'=>false,'type'=>'right','conditions'=>array('jobs_referral.job_id = Job.id')),'Users_profile'=>array('foreignKey'=>false,'type'=>'right','conditions'=>array('jobs_referral.user_id = Users_profile.user_id')))));
			$conditions=array('jobs_referral.friend_id'=>$userid); 
			$this->paginate = array('order'=>'jobs_referral.modified desc','limit'=>10);
			$this->set('refferedJob',$this->paginate('jobs_referral',$conditions));
			
		}
		else{
			$this->redirect('/');
		}
		if(isset($this->params['requested'])) { //--- return data if requested from view ---//
			 return $corefferJob;
				 
		}
		
	}
	
	function userunsavejobAction($id=0){
		//$this->autoRender = false;
		$this->loadModel('jobs_saved');
		$userid= $this->userInfo['users']['id'];
		if(!empty($userid)){
			$jobsavedid = $this->jobs_saved->find('first',array('conditions'=>array('jobs_saved.job_id'=>$id,'jobs_saved.user_id'=>$userid)));
			//pr($jobsavedid);exit;
			if ($this->jobs_saved->delete($jobsavedid['jobs_saved']['id'])) {
				
				$this->Session->setFlash(__('The saved job has been removed!',true),'success_msg');
				$this->redirect(array('action' => 'index#savejob'));
			}
		}
	}
	function userunapplyjobAction($id=0){
		$this->loadModel('jobs_application');
		$userid= $this->userInfo['users']['id'];
		if(!empty($userid)){
			$jobappid = $this->jobs_application->find('first',array('conditions'=>array('jobs_application.job_id'=>$id,'jobs_application.user_id'=>$userid)));
			//pr($jobsavedid);exit;
			if ($this->jobs_application->delete($jobappid['jobs_application']['id'])) {
				
				$this->Session->setFlash(__('You have un-applied for this job!',true),'success_msg');
				$this->redirect(array('action' => 'index#jobapp'));
			}
		}
	}
	function referredJobDelete($id=0){
		$this->loadModel('jobs_referral');
		$userid= $this->userInfo['users']['id'];
		if(!empty($userid)){
			$jobappid = $this->jobs_referral->find('first',array('conditions'=>array('jobs_referral.job_id'=>$id,'jobs_referral.friend_id'=>$userid)));
			//pr($jobsavedid);exit;
			if ($this->jobs_referral->delete($jobappid['jobs_referral']['id'])) {
				$this->Session->setFlash(__('The referred job has been removed!',true),'success_msg');
				$this->redirect(array('action' => 'index#reffer'));
			}
		}
	}
	

}
