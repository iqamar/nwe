<?php

/**
 * Jobs Controller
 *
 * @property Job $Job
 */
class JobsController extends AppController {

    var $name = 'Jobs';
    var $helpers = array('Form', 'html', 'DatePicker');
    var $components = array('Auth');
    var $jobs = array('Job', 'jobs_description', 'jobs_functional_area', 'jobs_keyword', 'jobs_location', 'jobs_qualifications');

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


	$jobData = ClassRegistry::init('jobs')->find('all', array('fields' => array('DISTINCT countries.name, companies.title, jobs.id, jobs.title, jobs.city, jobs.min_experience, jobs.max_experience, jobs.created, jobs.start_date, jobs.expiry_date, jobs.job_code, jobs.status, jobs.user_id'),	'joins' => array(array('alias' => 'companies', 'table' => 'companies', 'type' => 'left', 'foreignKey' => false,'conditions' => array('companies.id = jobs.company_id')),array('alias' => 'countries', 'table' => 'countries','type' => 'left', 'foreignKey' => false, 'conditions' => array('countries.id = jobs.country_id'))), 'order' => array('jobs.title')));


/*
	$jobData = ClassRegistry::init('jobs')->find('all', array('fields' => array('DISTINCT countries.name, companies.title, jobs.id, jobs.title, jobs.city, jobs.min_experience, jobs.max_experience, jobs.created, jobs.start_date, jobs.expiry_date, jobs.job_code, jobs.status, jobs.user_id'), 'joins' => array(array('alias' => 'companies', 'table' => 'companies', 'type' => 'left', 'foreignKey' => false,'conditions' => array('companies.id = jobs.company_id')),array('alias' => 'countries', 'table' => 'countries', 'foreignKey' => false, 'conditions' => array('countries.id = jobs.country_id')),
		//array('alias' => 'jobs_descriptions', 'table' => 'jobs_descriptions', 'foreignKey' => false, 'conditions' => array('jobs_descriptions.job_id = jobs.job_id')),
		//array('alias' => 'jobs_functional_areas', 'table' => 'jobs_functional_areas', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('jobs_functional_areas.job_id = jobs.job_id')),
		//array('alias' => 'functional_areas', 'table' => 'functional_areas', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('jobs_functional_areas.functional_area_id = functional_areas.functional_area_id')),
		array('alias' => 'jobs_locations', 'table' => 'jobs_locations', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('jobs_locations.job_id = jobs.job_id')),
		array('alias' => 'countries', 'table' => 'countries', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('jobs_locations.location_id = countries.id'))
	    ), 'order' => array('jobs.job_id')));*/
	//echo "<pre>";
	//print_r($jobData);
	$this->set('jobs', $jobData);
	//print_r($subskill);
//$roles = $this->User->Role->find('list');
//$this->set(compact('roles'));
    }

    function admin_view($id = null) {
	$jobView = ClassRegistry::init('jobs')->find('first', array('conditions' => array('jobs.id' => $id)));
        $this->set('job', $jobView);
    }

    function admin_add() {
	//echo "<pre>";
	//print_r($_REQUEST);
        //print_r($this->Session->read(@$userid));
	if ($this->request->is('post')) {
        $userID = $this->Session->read(@$userid);
        //$currentDate = date("Y-m-d");
        //$currentTime = date("H:i:s");
        
            $jobData = array(
                'title' => $this->request->data('jobTitle'),
                'functional_area' => $this->request->data('functional_area'),
                'industries' => $this->request->data('industries'),                
                'country_id' => $this->request->data('locations'),
                'city' => $this->request->data('city'),
                'relocation_assistance' => $this->request->data('relocation'),
                'work_anywhere' => $this->request->data('remote_work'),
                'start_date' => date("Y-m-d", strtotime($this->request->data('startDate'))),
                'expiry_date' => date("Y-m-d", strtotime($this->request->data('expiryDate'))),
                'min_experience' => $this->request->data('min_exp'),
                'max_experience' => $this->request->data('max_exp'),
                'description' => $this->request->data('job_description'),
                'vacancies' => $this->request->data('vacancies'),
                'job_type' => $this->request->data('job_type'),
                'career_level' => $this->request->data('career_level'),
                'qualifications' => $this->request->data('qualifications'),
                'salary_mode' => $this->request->data('salary_mode'),
                'min_salary' => $this->request->data('min_salary'),
                'max_salary' => $this->request->data('max_salary'),
                'hourly_salary' => $this->request->data('hourly_salary'),
                'manages_team' => $this->request->data('manage_others'),
                'residence' => $this->request->data('residence_locations'),
                'min_age' => $this->request->data('min_age'),
                'max_age' => $this->request->data('max_age'),
                'nationality' => $this->request->data('nationality'),
                'gender' => $this->request->data('gender'),
                'confidentiality' => $this->request->data('confidentiality'),
                'apply_notification' => $this->request->data('email_setting'),
                'auto_reply_apply' => $this->request->data('auto_reply_apply'),
                'auto_reply_apply_text' => $this->request->data('auto_reply_apply_text'),
                'contact_person' => $this->request->data('contactPerson'),
                'contact_email' => $this->request->data('contactEmail'),
                'contact_number' => $this->request->data('contactNumber'),
                'user_id' => $userID['userid'],
                'created' => date("Y-m-d H:i:s")
            );
            
            switch ($jobData['salary_mode']) {
                case "0":
                       $jobData['min_salary'] = 0;
                       $jobData['max_salary'] = 0;
                       $jobData['hourly_salary'] = 0;
                    break;
                
                case "1":
                    $jobData['hourly_salary'] = 0;
                    break;
                
                case "2" :
                    $jobData['min_salary'] = 0;
                    $jobData['max_salary'] = 0;
                    break;

            }
            
            if($this->request->data('auto_reply_apply') != 1){
                $jobData['auto_reply_apply_text'] = NULL;
            }
            $this->Job->create();
            //if(ClassRegistry::init('jobs')->save($jobData)){
			if ($this->Job->save($jobData)) {
				$job_id = $this->Job->getLastInsertID();
				$skills = $this->request->data['selectedSkills'];	
				$skills_arr =  split(',', $skills);
				$lenskills = count($skills_arr);
				$db = ConnectionManager::getDataSource('default');
			   // $db->rawQuery("DELETE FROM jobs_skills WHERE job_id=".$job_id);			
				$skill_data ="";
				for($i=0;$i < $lenskills; $i++){				
						$skill_data .= "('".$job_id."','".$skills_arr[$i]."'),";
				}
				$skill_data = trim($skill_data,",");
				$sql = "INSERT INTO jobs_skills (job_id, skill_id) VALUES ".$skill_data;
			    $db->rawQuery($sql);
	

                $this->Session->setFlash("Job saved sucessfully, Do you want to add more jobs?");
                $this->redirect('/admin/jobs/flash_message');
            } 
            else{
                $this->Session->setFlash('Error saving job');
            }
        }else {
	    $this->set('countries', ClassRegistry::init('countries')->find('all', array('conditions' => array('countries.status' => '1'))));
	    $this->set('companies', ClassRegistry::init('companies')->find('all', array('conditions' => array('companies.status' => '1'))));
	    //$this->set('qualifications', ClassRegistry::init('qualifications')->find('all', array('conditions' => array('qualifications.status' => '1'), 'order' => array('qualifications.priority', 'qualifications.title'))));		
	    $this->set('functional_areas', ClassRegistry::init('functional_areas')->find('all', array('conditions' => array('functional_areas.status' => '1'))));
		$this->set('industries', ClassRegistry::init('industries')->find('all', array('order' => array('industries.title'))));
		}
   }
     

function admin_update(){

	if ($this->request->is('post')) {

		if(empty($this->request->data['job_id'])){
			echo "-1";
			exit;
		}
	    
		$current_tab = $this->request->data['current_tab'];
		$this->Job->id  = $this->request->data['job_id'];

		if($current_tab == 1){
		    $formData['title'] = $this->request->data['jobTitle'];
			$formData['description'] = $this->request->data['jobDescription'];
			$formData['company_id'] = 123;
		    $formData['country_id'] = $this->request->data['locations'];
		    $formData['city'] = $this->request->data['city'];
			$formData['job_type'] = $this->request->data['employmentType'];
			$formData['vacancies'] = $this->request->data['vacancies'];			
		    $formData['start_date'] = date('Y-m-d H:i:s', (strtotime($this->request->data['startDate'])));
		    $formData['expiry_date'] = date('Y-m-d H:i:s', (strtotime($this->request->data['expiryDate'])));


		}elseif($current_tab == 2){
		    $formData['min_age'] = $this->request->data['ageMin'];
			$formData['max_age'] = $this->request->data['ageMax'];
			$formData['min_experience'] = $this->request->data['experienceMin'];
			$formData['max_experience'] = $this->request->data['experienceMax'];



		    $formData['gender'] = $this->request->data['gender'];
		    $formData['manages_team'] = $this->request->data['manages'];
			$formData['nationality'] = $this->request->data['nationality'];
			$formData['residence'] = $this->request->data['residence'];	
			$formData['qualifications'] = $this->request->data['qualifications'];
			$skills = $this->request->data['skills'];	

			$skills_arr =  split(',', $skills);
			$lenskills = count($skills_arr);


			$db = ConnectionManager::getDataSource('default');
		    $db->rawQuery("DELETE FROM jobs_skills WHERE job_id=".$this->Job->id);			
			$skill_data ="";
			for($i=0;$i < $lenskills; $i++){				
				
				$skill_data .= "('".$this->Job->id."','".$skills_arr[$i]."'),";
			}
			$skill_data = trim($skill_data,",");
			$sql = "INSERT INTO jobs_skills (job_id, skill_id) VALUES ".$skill_data;
		    $db->rawQuery($sql);
			

		}elseif($current_tab == 3){
		    $formData['confidentiality'] = $this->request->data['confidentiality'];
			$formData['apply_notification'] = $this->request->data['apply_notification'];			
		}elseif($current_tab == 4){
		    $formData['auto_reply_apply'] = $this->request->data['auto_reply_apply'];
			$formData['auto_reply_apply_text'] = $this->request->data['auto_reply_apply_text'];			
		}elseif($current_tab == 5){
		    $formData['conatct_person'] = $this->request->data['conatctPerson'];
			$formData['contact_email'] = $this->request->data['contactEmail'];			
			$formData['contact_number'] = $this->request->data['contactNumber'];			
		}
//	offered_salary

    
	    $userData = $this->Session->read(@$userid);
	    $formData['modified_by'] = $userData['Auth']['User']['id'];
	    $currentDate = date("Y-m-d");
		$currentTime = date("H:i:s");
	    $formData['modified'] = date("Y-m-d H:i:s", strtotime($currentDate . $currentTime));

	    


	    if ($this->Job->save($formData)) {
			echo 1;
		}else{
			echo -3;
		}
		exit;	    
	}
	echo 0;
	exit;	 
}

    function admin_edit($id = null) {
      
        if ($this->request->is('post')) {
        $userID = $this->Session->read(@$userid);
        
       //pr($this->request->data['jobTitle']);
       // $this->Job->create();
            $jobData = array(
                'title' => $this->request->data['jobTitle'],
                'functional_area' => $this->request->data['functional_area'],
                'industries' => $this->request->data('industries'),                
                'country_id' => $this->request->data('locations'),
                'city' => $this->request->data('city'),
                'relocation_assistance' => $this->request->data('relocation'),
                'work_anywhere' => $this->request->data('remote_work'),
                'start_date' => date("Y-m-d", strtotime($this->request->data('startDate'))),
                'expiry_date' => date("Y-m-d", strtotime($this->request->data('expiryDate'))),
                'min_experience' => $this->request->data('min_exp'),
                'max_experience' => $this->request->data('max_exp'),
                'description' => $this->request->data('job_description'),
                'vacancies' => $this->request->data['vacancies'],
                'job_type' => $this->request->data('job_type'),
                'career_level' => $this->request->data('career_level'),
                'qualifications' => $this->request->data('qualifications'),
                'salary_mode' => $this->request->data('salary_mode'),
                'min_salary' => $this->request->data('min_salary'),
                'max_salary' => $this->request->data('max_salary'),
                'hourly_salary' => $this->request->data('hourly_salary'),
                'manages_team' => $this->request->data('manage_others'),
                'residence' => $this->request->data('residence_locations'),
                'min_age' => $this->request->data('min_age'),
                'max_age' => $this->request->data('max_age'),
                'nationality' => $this->request->data('nationality'),
                'gender' => $this->request->data('gender'),
                'confidentiality' => $this->request->data('confidentiality'),
                'apply_notification' => $this->request->data('email_setting'),
                'auto_reply_apply' => $this->request->data('auto_reply_apply'),
                'auto_reply_apply_text' => $this->request->data('auto_reply_apply_text'),
                'contact_person' => $this->request->data('contactPerson'),
                'contact_email' => $this->request->data('contactEmail'),
                'contact_number' => $this->request->data('contactNumber'),
                'modified_by' => $userID['userid'],
                'modified' => date("Y-m-d H:i:s")
            );
            
            switch ($jobData['salary_mode']) {
                case "0":
                       $jobData['min_salary'] = 0;
                       $jobData['max_salary'] = 0;
                       $jobData['hourly_salary'] = 0;
                    break;
                
                case "1":
                    $jobData['hourly_salary'] = 0;
                    $jobData['min_salary'] = $this->request->data('min_salary');
                    $jobData['max_salary'] = $this->request->data('max_salary');
                    break;
                
                case "2" :
                    $jobData['min_salary'] = 0;
                    $jobData['max_salary'] = 0;
                    $jobData['hourly_salary'] = $this->request->data('hourly_salary');
                    break;

            }
            
            
            if($this->request->data('auto_reply_apply') != 1){
                $jobData['auto_reply_apply_text'] = NULL;
            }
            $this->Job->create();
            $this->Job->id = $id;
            //if(ClassRegistry::init('jobs')->save($jobData)){
			if ($this->Job->save($jobData)) {
				$job_id = $this->Job->getLastInsertID();
				$skills = $this->request->data['selectedSkills'];	
				$skills_arr =  split(',', $skills);
				$lenskills = count($skills_arr);
				$db = ConnectionManager::getDataSource('default');
			    $db->rawQuery("DELETE FROM jobs_skills WHERE job_id=".$id);
                          //  ClassRegistry::init('jobs_skills')->deleteAll(array('conditions' => array('job_id' => $id)));
				$skill_data ="";
				for($i=0;$i < $lenskills; $i++){				
						$skill_data .= "('".$id."','".$skills_arr[$i]."'),";
				}
				$skill_data = trim($skill_data,",");
				$sql = "INSERT INTO jobs_skills (job_id, skill_id) VALUES ".$skill_data;
//exit;
			    $db->rawQuery($sql);
                           //ClassRegistry::init('jobs_skills')->save(array('job_id' ))
	

               // $this->Session->setFlash("Job saved sucessfully, Do you want to add more jobs?");
                $this->redirect('/admin/jobs/');
            } 
            else{
                $this->Session->setFlash('Error saving job');
            }
        }else {
	    $jobs = ClassRegistry::init('jobs')->find('first', array('conditions' => array('id' => $id)));
            $this->set('jobs', $jobs);
	    $this->set('countries', ClassRegistry::init('countries')->find('all', array('conditions' => array('countries.status' => '1'))));
	    $this->set('sCountry', ClassRegistry::init('countries')->find('first', array('conditions' => array('id' => $jobs['jobs']['country_id']))));
            $this->set('companies', ClassRegistry::init('companies')->find('all', array('conditions' => array('companies.status' => '1'))));
	    $this->set('qualifications', ClassRegistry::init('qualifications')->find('all', array('conditions' => array('qualifications.status' => '1'), 'order' => array('qualifications.priority', 'qualifications.title'))));
	    $this->set('functional_areas', ClassRegistry::init('functional_areas')->find('all', array('conditions' => array('functional_areas.status' => '1'))));
            $this->set('industries', ClassRegistry::init('industries')->find('all', array('order' => array('industries.title'))));
            ClassRegistry::init('jobs_skills')->deleteAll(array('skill_id' => 0));               
            $skills = ClassRegistry::init('jobs_skills')->find('all', array('fields' => array('skills.title,jobs_skills.skill_id'),'joins'=>array(array('alias' => 'skills' , 'table' => 'skills', 'type' => 'left', 'foreignKey' => false,'conditions' => array('skills.id = jobs_skills.skill_id'))),'conditions' => array('jobs_skills.job_id' => $id), 'order' => array('jobs_skills.id DESC'), 'limit' => 5));
            $this->set('skills', $skills);

            
            
            
        }
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

	if (ClassRegistry::init('jobs')->delete($id)){  
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
	    $this->redirect(array('controller' => 'users', 'action' => 'search











'));
	}
    }

    
    function admin_flash_message(){
        
    }
}
?>