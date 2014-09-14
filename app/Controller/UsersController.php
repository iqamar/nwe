<?php

class UsersController extends AppController {

    var $name = 'Users_profile';
    var $helpers = array('Form', 'html', 'DatePicker');
    var $components = array('Email', 'RequestHandler');
    var $uses = array('User', 'Userexp', 'Users_profile', 'users_contacts_invites', 'Users_profile_strength', 'Role','Countries','Companies','Users_experiences','Industries','Institutes','Qualifications','Users_qualifications');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        switch ($this->request->params['action']) {
            case 'index':
            case 'admin_index':
        }
        //pr($this->cake_sessions->getActiveUsers());
    }

    function index() {
        //  pr($this->cake_sessions->getActiveUsers());
        $this->User->recursive = 0;
        $this->set('users', $this->paginate($this->User));
        $this->autoRender = false;
        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
    }

    function admin_login() {
        $this->login();
    }

    function admin_logout() {
        $this->logout();
    }

	
    function login() {

        if ($this->request->is('post')) {
			
            $data['password'] = $this->request->data['User']['password'];
            $data['email'] = $this->request->data['User']['email'];
            $login_Action = $this->User->user_login($data['email'], hash('sha256',$data['password']));
			
            if (isset($login_Action["User"]["id"])) {
				if ($login_Action["User"]["status"] != 1) {
					$this->redirect('/company/pending_confirmation');
					exit;
				}
                
                    $id = $login_Action['User']['id'];
                    $theme = $login_Action['User']['theme_id'];
                    $role_id = $login_Action['User']['role_id'];
                    $email = $login_Action['User']['email'];
                
                $this->Session->write('userid', $id);
                $this->Session->write('checkUser', 'logged');
                $this->Session->write('theme', $theme);
                $this->Session->write('email', $email);
                $this->Session->write('role_id', $role_id);
                //$this->Session->write('language', 'eng');
				//$this->Cookie->write('forum_email', $email);
				//$this->Cookie->write('forum_userid', $id);


		$this->Cookie->write('role_id', $role_id);
		if($this->request->data['User']['remember_me'] == 1){
			$this->Cookie->write('remember_me', 1);
			setcookie("js_remember_me", 1, time()+15552000, "/", ".networkwe.com", false,false);	
		        setcookie("remember_me_email", $email, time()+15552000, "/", ".networkwe.com", false,false);
			setcookie("remember_me_key", $data['password'], time()+15552000, "/", ".networkwe.com", false,false);
			setcookie("remember_me_userid",$id, time()+15552000, "/", ".networkwe.com", false,false);
		}else{
			$this->Cookie->write('remember_me', -1);
			setcookie("js_remember_me", -1, time()+14400, "/", ".networkwe.com", false,false);
			setcookie("remember_me_email", $email, time()+14400, "/", ".networkwe.com", false,false);
                        setcookie("remember_me_key", $data['password'], time()+14400, "/", ".networkwe.com", false,false);
                        setcookie("remember_me_userid",$id, time()+14400, "/", ".networkwe.com", false,false);
			
		}

		
	
		$this->Cookie->write('User', array('email' => $email,'key'=>$data['password'], 'userid' => $id, 'role_id' => $role_id), false);

//		$this->Cookie->write('User', array('email' => $email,'key'=>$data['password'],'remember_me' => $remember_me, 'userid' => $id, 'role_id' => $role_id),false);

				

                $cuser = $this->getCurrentUser($id);
                $firstname = $cuser['firstname'];
                $lastname = $cuser['lastname'];
                $pic = $cuser['photo'];
                $city = $cuser['city'];
                $handler = $cuser['handler'];
                $this->Session->write('fullname', $firstname . " " . $lastname);
                $this->Session->write('picture', $pic);
                $this->Session->write('city', $city);
                $this->Session->write('handler', $handler);
//echo $role_id;
//exit;

                if ("100" == $role_id) {
                    $this->redirect('/admin/');
                    exit;
                }
                if ("2" == $role_id) {
			$this->loadModel('Company');
			$company = $this->Company->find('first',array('conditions'=> array('AND' => array('Company.flag' => 'profile','Company.user_id'=>$id)) ));
					//$company = $this->Company->find('first',array('conditions'=> array('Company.user_id'=>$id) ));
			$this->Session->write('company_id', $company["Company"]["id"]);

                    $this->redirect('/recruiter/');
                    exit;
                }
		$refral = $this->Session->read('HTTP_REFERAL');
		if(!empty($refral)){
			$pos = strpos($refral, 'networkwe.com/sidebars');
                        if ($pos === false) {
				if("." != substr($refral, -4, 1)){
					$this->Session->read('HTTP_REFERAL','');
					$this->redirect($refral);
					exit;
				}
			}
		}

                $this->redirect(array('controller' => 'users_profiles', 'action' => 'myprofile'));

                //$this->redirect('/');

            } else {
                $this->redirect('/company/invalid_account');
                exit;
                //	$this->Session->setFlash(__('Your email or password was incorrect.'));
                //	$this->redirect('/');
                //	exit;
            }
        }
        exit;
    }
	function switchToRecruiter($userid,$companyid,$uid) {
		//Configure::write('debug', 2);
		$remember=$_COOKIE['remember_me'];
		$rowData = stripslashes($_COOKIE["newnet"]["User"]);
		$mycookies =json_decode($rowData);
		//$currentUseremail = $mycookies->email;
		 //$currentUserid=$mycookies->userid;
		//$role_id=$mycookies->role_id;
		//echo $_SERVER['HTTP_REFERER'];
		$server_url=explode('/',$_SERVER['HTTP_REFERER']);
		$reffer_urls=$server_url[0].'//'.$server_url[2];
		
		if($reffer_urls == NETWORKWE_URL){
			
			$this->Session->write('userid', '');
			$this->Session->write('theme', '');
			$this->Session->write('role_id', '');

			$this->Session->write('fullname', '');
			$this->Session->write('email', '');
			$this->Session->write('photo', '');
			$this->Session->write('handler', '');
			$this->Session->destroy();
			setcookie("cc_data", "", time() - 3600);		
			$this->Cookie->destroy();
		
		if($userid && $companyid){
			

			$userLogin = ClassRegistry::init('users')->find('first',array('conditions'=> array('AND' => array('users.role_id' => 2,'users.id'=>$userid)) ));
			
			$currentUseremail = $userLogin['users']['email'];
			$currentPass =$userLogin['users']['password'];
			$login_Action = $this->User->user_login($currentUseremail, $currentPass);
			//$login_Action[0];exit;
			//pr($login_Action);exit;
			if (isset($login_Action["User"]["id"])) {
				
				$id = $login_Action['User']['id'];
				$theme = $login_Action['User']['theme_id'];
				$role_id = $login_Action['User']['role_id'];
				$email = $login_Action['User']['email'];
	
				$this->Session->write('userid', $id);
				$this->Session->write('checkUser', 'logged');
				$this->Session->write('theme', $theme);
				$this->Session->write('email', $email);
				$this->Session->write('role_id', $role_id);
				$this->Cookie->write('role_id', $role_id);
				if($remember){
					 $this->Cookie->write('remember_me', 1);
					setcookie("js_remember_me", 1, time()+259200, "/", "", false,false);	
				}else{
					$this->Cookie->write('remember_me', -1);
					setcookie("js_remember_me", -1, time()+14400, "/", "", false,false);
					
				}	
				$this->Cookie->write('User', array('email' => $currentUseremail,'key'=>$currentPass, 'userid' => $id, 'role_id' => $role_id), false);
                $this->Session->write('company_id', $companyid);  
				$this->Session->write('professional', $uid);  
				$this->redirect('/recruiter/');
				exit;
			
			}else {
				$this->redirect('/company/invalid_account');
				exit;
			}
		}else{
			$this->redirect('/company/invalid_account');
			exit;
		}
		}else{
			$this->redirect('/company/invalid_account');
			exit;
		}
		
    }
	function switchToProfessional($userid) {
		
		//Configure::write('debug', 2);
		$remember=$_COOKIE['remember_me'];
		$rowData = stripslashes($_COOKIE["newnet"]["User"]);
		$mycookies =json_decode($rowData);
		if($userid){
			$this->Session->write('userid', '');
			$this->Session->write('theme', '');
			$this->Session->write('role_id', '');

			$this->Session->write('fullname', '');
			$this->Session->write('email', '');
			$this->Session->write('photo', '');
			$this->Session->write('handler', '');
			$this->Session->destroy();
			setcookie("cc_data", "", time() - 3600);		
			$this->Cookie->destroy();

			$userLogin = ClassRegistry::init('users')->find('first',array('conditions'=> array('AND' => array('users.role_id' => 1,'users.id'=>$userid)) ));
			
			$currentUseremail = $userLogin['users']['email'];
			$currentPass =$userLogin['users']['password'];
			$login_Action = $this->User->user_login($currentUseremail, $currentPass);
			//$login_Action[0];exit;
			//pr($userLogin);exit;
			if ($login_Action) {
				
				$id = $login_Action['User']['id'];
				$theme = $login_Action['User']['theme_id'];
				$role_id = $login_Action['User']['role_id'];
				$email = $login_Action['User']['email'];
	
				$this->Session->write('userid', $id);
				$this->Session->write('checkUser', 'logged');
				$this->Session->write('theme', $theme);
				$this->Session->write('email', $email);
				$this->Session->write('role_id', $role_id);
				$this->Cookie->write('role_id', $role_id);
				if($remember){
					 $this->Cookie->write('remember_me', 1);
					setcookie("js_remember_me", 1, time()+259200, "/", "", false,false);	
				}else{
					$this->Cookie->write('remember_me', -1);
					setcookie("js_remember_me", -1, time()+14400, "/", "", false,false);
					
				}
				$this->Cookie->write('User', array('email' => $currentUseremail,'key'=>$currentPass, 'userid' => $id, 'role_id' => $role_id), false);
                $cuser = $this->getCurrentUser($id);
				$firstname = $cuser['firstname'];
				$lastname = $cuser['lastname'];
				$pic = $cuser['photo'];
				$city = $cuser['city'];
				$handler = $cuser['handler'];
				$this->Session->write('fullname', $firstname . " " . $lastname);
				$this->Session->write('picture', $pic);
				$this->Session->write('city', $city);
				$this->Session->write('handler', $handler);
				$this->redirect(array('controller' => 'users_profiles', 'action' => 'myprofile'));
				exit;
			
			}else {
				$this->redirect('/company/invalid_account');
				// $this->redirect("/users/loginagain/");
				exit;
			}
		}else{
			$this->redirect('/company/invalid_account');
			exit;
		}
		
    }
    function logout() {
        $this->Session->write('userid', '');
        $this->Session->write('theme', '');
        $this->Session->write('role_id', '');

        $this->Session->write('fullname', '');
        $this->Session->write('email', '');
        $this->Session->write('photo', '');
        $this->Session->write('handler', '');
	$this->Session->destroy();
        setcookie("cc_data", "", time() - 3600);		


	 setcookie("js_remember_me", "", time()-14400, "/", ".networkwe.com", false,false);
	 setcookie("remember_me_email", "", time()-14400, "/", ".networkwe.com", false,false);
	 setcookie("remember_me_key", "", time()-14400, "/", ".networkwe.com", false,false);
	 setcookie("remember_me_userid","", time()-14400, "/", ".networkwe.com", false,false);

        $this->Cookie->destroy();
	$this->redirect($this->Auth->logout());
    }
    
    public function resend_verification(){
        if($this->request->is('post')){
            $this->passedArgs['n'] = $this->passedArgs['n']?$this->passedArgs['n']:$this->request->data['n'];
            if (!empty($this->passedArgs['n'])) {
                $email = $this->passedArgs['n'];
                $isInDB = ClassRegistry::init('User')->find('first', array('fields' => array('User.varcode','User.status'),'conditions' => array('email' => $email)));
                if(!empty($isInDB['User']['varcode'])){
                    $isInDB['User']['status'] = $isInDB['User']['status']?$isInDB['User']['status']:0;
                    if($isInDB['User']['status'] == 1){
                        $this->set('status', 'confirmed');
                        $this->render('/Users/resend_verification');
                    }
                    else{
                        $ms = NETWORKWE_URL . '/users/verify/t:' . $isInDB['User']['varcode'] . '/n:' . $email . '';
                        $this->set('confirmlink', $ms);
                        $this->set('email', $email);
                        $this->set('data', $ms);
                    

			$strBody="";


	                $json_fields='{"api_key":"'.MAILER_API_KEY.'","email_details":{"fromname":"'.$this->fullescape(MAILER_REGISTER_FROMNAME).'","subject":"'.$this->fullescape(MAILER_REGISTER_SUBJECT).'","from":"'.MAILER_REGISTER_FROMEMAIL.'","replytoid":"'.MAILER_REGISTER_REPLYTO.'","content":"'.$this->fullescape($strBody).'"},"settings":{"template":"769"},"recipients":["'.$email.'"],"attributes":{"EMAIL":["'.$email.'"],"CONFIRMLINK":["'.$ms.'"],"UNSUB_URL":["'.$this->fullescape(UNSUB_URL."?xEmail=".$email).'"]}}';

        	        $ch = curl_init();
                	curl_setopt($ch,CURLOPT_URL, MAILER_SEND_API);
	                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        	        curl_setopt($ch,CURLOPT_POST, true);
                	curl_setopt($ch,CURLOPT_POSTFIELDS, array('data' => $json_fields));
	                $api_result = curl_exec($ch);
        	        curl_close($ch);
                	if ($api_result == "success") {
                            $this->Session->setFlash('Please Check your email for validation Link');
                            $this->set('status', 'sent');
                            $this->render('/Users/resend_verification');
                        }
                        //return $this->render('/elements/email/html/confirm');
                    }
                }
                else {
                    $this->set('status', 'invalid');
                    $this->render('/Users/resend_verification');
                }
            }
        }
        $this->render('/Users/resend_verification');
    }


	public function testMailAPIs(){
		 $ms = '';
                $ms = NETWORKWE_URL . '/users/verify/t:' . $data['varcode'] . '/n:testemail@testdomain.com';


                $strBody="";


                $json_fields='{"api_key":"'.MAILER_API_KEY.'","email_details":{"fromname":"'.$this->fullescape(MAILER_REGISTER_FROMNAME).'","subject":"'.$this->fullescape(MAILER_REGISTER_SUBJECT).'","from":"'.MAILER_REGISTER_FROMEMAIL.'","replytoid":"'.MAILER_REGISTER_REPLYTO.'","content":"'.$this->fullescape($strBody).'"},"settings":{"template":"769"},"recipients":["it@gulfbankers.com","111@gulfbankers.com","nnetcore@gmail.com","sk.mohdnuman@gmail.com"],"attributes":{"EMAIL":["testemail@testdomain.com"],"CONFIRMLINK":["'.$ms.'"],"UNSUB_URL":["'.$this->fullescape(UNSUB_URL."?xEmail=testemail@testdomain.com").'"]}}';

                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL, MAILER_SEND_API);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch,CURLOPT_POST, true);
                curl_setopt($ch,CURLOPT_POSTFIELDS, array('data' => $json_fields));
                $api_result = curl_exec($ch);
                curl_close($ch);

echo 'done';
exit;

	}


    public function ajax_signup_step1() {
		
        if ($this->request->is('post')) {
            $data['role_id'] = $this->request->data['User']['role_id'];
            $data['email'] = $this->request->data['userRegEmail'];
            $data['auth'] = $this->request->data['User']['oauth'];
            if ($data['auth'] == 1) {
                $this->Email->template = 'confirmauth';
                $this->set('password', $this->request->data['userRegPassword']);
            } else {

                $this->Email->template = 'confirm';
            }


            $isEmailInDB = $this->User->find('all', array('fields' => array('User.id'), 'conditions' => array('email' => $data['email']), 'limit' => 1));

            if (isset($isEmailInDB[0]['User']['id'])) {
                $this->redirect('/company/email_exist');
                exit;
            }


	   $this->request->data['User']['email'] = $this->request->data['userRegEmail'];
         	

            $this->request->data['User']['password'] = hash('sha256', $this->request->data['userRegPassword']);
            //$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
            $this->request->data['User']['varcode'] = md5($this->request->data['userRegEmail'] . microtime());
            $data['varcode'] = $this->request->data['User']['varcode'];
            if ($data['role_id'] == 1) {
                $this->request->data['User']['theme_id'] = 1;
                $theme = $this->request->data['User']['theme_id'];
            }else if ($data['role_id'] == 2) {
                $this->request->data['User']['theme_id'] = 2;
                $theme = $this->request->data['User']['theme_id'];
            }


            if ($this->User->save($this->request->data)) {

                $ms = '';
                $ms = NETWORKWE_URL . '/users/verify/t:' . $data['varcode'] . '/n:' . $data['email'] . '';


		$strBody="";             
                
                
                $json_fields='{"api_key":"'.MAILER_API_KEY.'","email_details":{"fromname":"'.$this->fullescape(MAILER_REGISTER_FROMNAME).'","subject":"'.$this->fullescape(MAILER_REGISTER_SUBJECT).'","from":"'.MAILER_REGISTER_FROMEMAIL.'","replytoid":"'.MAILER_REGISTER_REPLYTO.'","content":"'.$this->fullescape($strBody).'"},"settings":{"template":"769"},"recipients":["'.$data["email"].'"],"attributes":{"EMAIL":["'.$data["email"].'"],"CONFIRMLINK":["'.$ms.'"],"UNSUB_URL":["'.$this->fullescape(UNSUB_URL."?xEmail=".$data["email"]).'"]}}';
                
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, MAILER_SEND_API);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS, array('data' => $json_fields));
		$api_result = curl_exec($ch);
		curl_close($ch);
		if ($api_result == "success") {
                    $this->Session->setFlash('Please Check your email for validation Link');
                    $this->redirect('/company/thanks');
               	} 
                return $this->render('/elements/email/html/confirm');
            }
        }
        //exit;
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

     public function register_social() {


//print_r($this->request->data);


        if ($this->request->is('post')) {
            $data['User']['role_id'] = 1;
            $data['User']['email'] = $this->request->data['email_address'];
            $data['User']['register_mode'] = $this->request->data['social'];
            $data['User']['auth'] = 1;
            if ($data['User']['auth'] == 1) {
                $this->Email->template = 'confirmauth';
                $this->set('password', $this->request->data['password']);
            } else {
                $this->Email->template = 'confirm';
            }

			if($this->request->data['email_address'] != "patilstar@gmail.com"){
            $isEmailInDB = $this->User->find('all', array('fields' => array('User.id'), 'conditions' => array('email' => $this->request->data['email_address']), 'limit' => 1));

            if (isset($isEmailInDB[0]['User']['id'])) {
                echo "-1";
                exit;
            }
			}

            $data['User']['password'] = hash('sha256', $this->request->data['password']);
            //$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
            $data['User']['varcode'] = md5($this->request->data['email_address'] . microtime());


            $data['User']['theme_id'] = 1;
            $theme = $this->request->data['theme_id'];




            if ($this->User->save($data)) {
                $user_id = $this->User->getInsertID();

                $ms = '';
                $ms = NETWORKWE_URL.'/users/verify_social/t:' . $data['User']['varcode'] . '/n:' . $data['User']['email'] . '';




		$strBody="";
               
                
                $json_fields='{"api_key":"'.MAILER_API_KEY.'","email_details":{"fromname":"'.$this->fullescape(MAILER_REGISTER_FROMNAME).'","subject":"'.$this->fullescape(MAILER_REGISTER_SUBJECT).'","from":"'.MAILER_REGISTER_FROMEMAIL.'","replytoid":"'.MAILER_REGISTER_REPLYTO.'","content":"'.$this->fullescape($strBody).'"},"settings":{"template":"769"},"recipients":["'.$data['User']["email"].'"],"attributes":{"EMAIL":["'.$data['User']["email"].'"],"CONFIRMLINK":["'.$ms.'"],"UNSUB_URL":["'.$this->fullescape(UNSUB_URL."?xEmail=".$data['User']["email"]).'"]}}';
                
				
			
				
                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL, MAILER_SEND_API);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch,CURLOPT_POST, true);
                curl_setopt($ch,CURLOPT_POSTFIELDS, array('data' => $json_fields));
                $api_result = curl_exec($ch);
                curl_close($ch);

                if ($api_result == "success") {
                    $data_details['Users_profile']['user_id'] = $user_id;
                    $data_details['Users_profile']['firstname'] = $this->request->data['first_name'];
                    $data_details['Users_profile']['lastname'] = $this->request->data['last_name'];


                    if(($data['User']['register_mode'] == "gulfbankers") || ($data['User']['register_mode'] == "gulfmanagers") || ($data['User']['register_mode'] == "ebankingcareers")){
						//$data_details['Users_profile']['city'] = $this->request->data['city'];

						$data_details['Users_profile']['birth_date'] = $this->request->data['birthday'];
						$data_details['Users_profile']['gender'] = ucfirst($this->request->data['gender']);

						$data_details['Users_profile']['phone'] = $this->request->data['phone'];
						$data_details['Users_profile']['mobile'] = $this->request->data['mobile'];
						$data_details['Users_profile']['city'] = $this->request->data['city'];
						$data_details['Users_profile']['tags'] = $this->request->data['tags'];
						//$data_details['Users_profile']['gender'] = $this->request->data['key_skill'];


						$isCountryInDB = $this->Countries->find('all', array('fields' => array('Countries.id'), 'conditions' => array('name' => $this->request->data['country']), 'limit' => 1));
						if (isset($isCountryInDB[0]['Countries']['id'])) {
								 $data_details['Users_profile']['country_id'] = $isCountryInDB[0]['Countries']['id'];
						}

						$isCountry1InDB = $this->Countries->find('all', array('fields' => array('Countries.id'), 'conditions' => array('name' => $this->request->data['nationality']), 'limit' => 1));
						if (isset($isCountry1InDB[0]['Countries']['id'])) {
								 $data_details['Users_profile']['nationality'] = $isCountry1InDB[0]['Countries']['id'];
						}

						$isIndustryInDB = $this->Industries->find('all', array('fields' => array('Industries.id'), 'conditions' => array("title like '".$this->request->data['industry']."'"), 'limit' => 1));
						if (isset($isIndustryInDB[0]['Industries']['id'])) {
								 $data_details['Users_profile']['industry_id'] = $isIndustryInDB[0]['Industries']['id'];
						}


						$isCompanyInDB = $this->Companies->find('all', array('fields' => array('Companies.id'), 'conditions' => array("title like '".$this->request->data['company']."'"), 'limit' => 1));

						if (isset($isCompanyInDB[0]['Companies']['id'])) {
							$company_id = $isCompanyInDB[0]['Companies']['id'];
						}else{
							$cdata["Companies"]["title"]=$this->request->data['company'];
							$this->Companies->create();
							$this->Companies->save($cdata);
							$company_id = $this->Companies->getInsertID();
							unset($cdata["Companies"]["title"]);
						}

						$c1data["Users_experiences"]["company_id"]=$company_id;
						$c1data["Users_experiences"]["designation"]=$this->request->data['title'];
						$c1data["Users_experiences"]["user_id"]=$user_id;
						$c1data["Users_experiences"]["created"]= date("Y-m-d H:i:s",strtotime('+1 seconds'));
						$this->Users_experiences->create();
						$this->Users_experiences->save($c1data);




						$isInstituteInDB = $this->Institutes->find('all', array('fields' => array('Institutes.id'), 'conditions' => array("title like '".$this->request->data['college']."'"), 'limit' => 1));

						if (isset($isInstituteInDB[0]['Institutes']['id'])) {
							$institute_id = $isInstituteInDB[0]['Institutes']['id'];
						}else{
							$cdata["Institutes"]["title"]=$this->request->data['college'];
							$this->Institutes->create();
							$this->Institutes->save($cdata);
							$institute_id = $this->Institutes->getInsertID();
							unset($cdata["Institutes"]["title"]);
						}

						$isQualificationInDB = $this->Qualifications->find('all', array('fields' => array('Qualifications.id'), 'conditions' => array("title like '".$this->request->data['degree']."'"), 'limit' => 1));

						if (isset($isQualificationInDB[0]['Qualifications']['id'])) {
							$qualification_id = $isQualificationInDB[0]['Qualifications']['id'];
						}else{
							$cdata["Qualifications"]["title"]=$this->request->data['degree'];
							$this->Qualifications->create();
							$this->Qualifications->save($cdata);
							$qualification_id = $this->Qualifications->getInsertID();
							unset($cdata["Qualifications"]["title"]);
						}

						$c1data["Users_qualifications"]["institute_id"]=$institute_id;
						$c1data["Users_qualifications"]["qualification_id"]=$qualification_id;
						$c1data["Users_qualifications"]["user_id"]=$user_id;
						$c1data["Users_qualifications"]["start_end"]= "00-0000";
						$c1data["Users_qualifications"]["end_date"]= $this->request->data['year'];
						$c1data["Users_qualifications"]["field_study"]= $this->request->data['speciliz'];

						$c1data["Users_qualifications"]["created"]= date("m-Y-m-d H:i:s",strtotime('+1 seconds'));
						$this->Users_qualifications->create();
						$this->Users_qualifications->save($c1data);
						unset($c1data["Users_qualifications"]);



					}else if(($data['User']['register_mode'] == "onemanagers") || ($data['User']['register_mode'] == "socializein")){
						//$data_details['Users_profile']['city'] = $this->request->data['city'];

						$data_details['Users_profile']['birth_date'] = date("d-M-Y", strtotime($this->request->data['birthday']));
						$data_details['Users_profile']['gender'] = ucfirst($this->request->data['gender']);

						$data_details['Users_profile']['summary'] = urldecode($this->request->data['summary']);

						$isIndustryInDB = $this->Industries->find('all', array('fields' => array('Industries.id'), 'conditions' => array("title like '".$this->request->data['industry']."'"), 'limit' => 1));
						if (isset($isIndustryInDB[0]['Industries']['id'])) {
								 $data_details['Users_profile']['industry_id'] = $isIndustryInDB[0]['Industries']['id'];
						}
						$isCountryInDB = $this->Countries->find('all', array('fields' => array('Countries.id'), 'conditions' => array('name' => $this->request->data['residence']), 'limit' => 1));
						if (isset($isCountryInDB[0]['Countries']['id'])) {
								 $data_details['Users_profile']['country_id'] = $isCountryInDB[0]['Countries']['id'];
						}

						$isCountryInDB = $this->Countries->find('all', array('fields' => array('Countries.id'), 'conditions' => array('name' => $this->request->data['country']), 'limit' => 1));
						if (isset($isCountryInDB[0]['Countries']['id'])) {
								 $data_details['Users_profile']['nationality'] = $isCountryInDB[0]['Countries']['id'];
						}


						$past_exp = json_decode($this->request->data['work']);


						$incr_dur=0;
						foreach($past_exp as $past){


							$isCompanyInDB = $this->Companies->find('all', array('fields' => array('Companies.id'), 'conditions' => array("title like '".$past->name."'"), 'limit' => 1));

							if (isset($isCompanyInDB[0]['Companies']['id'])) {
								$company_id = $isCompanyInDB[0]['Companies']['id'];
							}else{
								$cdata["Companies"]["title"]=$past->name;
								$this->Companies->create();
								$this->Companies->save($cdata);
								$company_id = $this->Companies->getInsertID();
								unset($cdata["Companies"]["title"]);
							}

							$c1data["Users_experiences"]["company_id"]=$company_id;
							$c1data["Users_experiences"]["designation"]=$past->title;
							$c1data["Users_experiences"]["location"]=$past->location;
							$c1data["Users_experiences"]["user_id"]=$user_id;
							$c1data["Users_experiences"]["start_end"]= date("m-Y",strtotime($past->start_date));
							if($past->isCurrent == 1){
								$c1data["Users_experiences"]["end_date"]= "Present";
							}else{
								$c1data["Users_experiences"]["end_date"]= date("m-Y",strtotime($past->end_date));
							}

							$c1data["Users_experiences"]["created"]= date("Y-m-d H:i:s",strtotime('+'.$incr_dur.' seconds'));
							$this->Users_experiences->create();
							$this->Users_experiences->save($c1data);
							unset($c1data["Users_experiences"]);
							$incr_dur +=30;
						}






					}else if($data['User']['register_mode'] == "linkedin"){
						//$data_details['Users_profile']['city'] = $this->request->data['city'];
						$data_details['Users_profile']['tags'] = urldecode($this->request->data['headline']);

						$isIndustryInDB = $this->Industries->find('all', array('fields' => array('Industries.id'), 'conditions' => array("title like '%".$this->request->data['industry']."%'"), 'limit' => 1));
						if (isset($isIndustryInDB[0]['Industries']['id'])) {
								 $data_details['Users_profile']['industry_id'] = $isIndustryInDB[0]['Industries']['id'];
						}
						$isCountryInDB = $this->Countries->find('all', array('fields' => array('Countries.id'), 'conditions' => array('alpha_2' => $this->request->data['location']), 'limit' => 1));
						if (isset($isCountryInDB[0]['Countries']['id'])) {
								 $data_details['Users_profile']['country_id'] = $isCountryInDB[0]['Countries']['id'];
						}

						$data_details['Users_profile']['summary'] = urldecode($this->request->data['summary']);
						$past_exp = json_decode($this->request->data['exp_past']);
						$current_exp = json_decode($this->request->data['exp_current']);

						$past_exp_rev = array_reverse($past_exp);
						$incr_dur=0;
						foreach($past_exp_rev as $past){


							$isCompanyInDB = $this->Companies->find('all', array('fields' => array('Companies.id'), 'conditions' => array("title like '%".$past->name."%'"), 'limit' => 1));

							if (isset($isCompanyInDB[0]['Companies']['id'])) {
								$company_id = $isCompanyInDB[0]['Companies']['id'];
							}else{
								$cdata["Companies"]["title"]=$past->name;
								$this->Companies->create();
								$this->Companies->save($cdata);
								$company_id = $this->Companies->getInsertID();
								unset($cdata["Companies"]["title"]);
							}

							$c1data["Users_experiences"]["company_id"]=$company_id;
							$c1data["Users_experiences"]["designation"]=$past->title;
							$c1data["Users_experiences"]["user_id"]=$user_id;
							$c1data["Users_experiences"]["created"]= date("Y-m-d H:i:s",strtotime('+'.$incr_dur.' seconds'));
							$this->Users_experiences->create();
							$this->Users_experiences->save($c1data);
							unset($c1data["Users_experiences"]);
							$incr_dur +=30;
						}

						$current_exp_rev = array_reverse($current_exp);

						foreach($current_exp_rev as $current){


							$isCompanyInDB = $this->Companies->find('all', array('fields' => array('Companies.id'), 'conditions' => array("title like '%".$current->name."%'"), 'limit' => 1));

							if (isset($isCompanyInDB[0]['Companies']['id'])) {
								$company_id = $isCompanyInDB[0]['Companies']['id'];
							}else{
								$cdata["Companies"]["title"]=$current->name;
								$this->Companies->create();
								$this->Companies->save($cdata);
								$company_id = $this->Companies->getInsertID();
								unset($cdata["Companies"]["title"]);
							}

							$c1data["Users_experiences"]["company_id"]=$company_id;
							$c1data["Users_experiences"]["designation"]=$current->title;
							$c1data["Users_experiences"]["user_id"]=$user_id;
							$c1data["Users_experiences"]["created"]= date("Y-m-d H:i:s",strtotime('+'.$incr_dur.' seconds'));
							$this->Users_experiences->create();
							$this->Users_experiences->save($c1data);
							unset($c1data["Users_experiences"]);
							$incr_dur +=30;
						}




					}elseif($data['User']['register_mode'] == "facebook"){

						$data_details['Users_profile']['birth_date'] = date("d-M-Y", strtotime($this->request->data['birthday']));
						$data_details['Users_profile']['gender'] = ucfirst($this->request->data['gender']);
						// $data_details['Users_profile']['city'] = $this->request->data['city'];
						$location = urldecode($this->request->data['city']);
						$locationArray = split(",",$location);

						$isCountryInDB = $this->Countries->find('all', array('fields' => array('Countries.id'), 'conditions' => array("name like '".trim($locationArray[1])."'"), 'limit' => 1));
						if (isset($isCountryInDB[0]['Countries']['id'])) {
								 $data_details['Users_profile']['country_id'] = $isCountryInDB[0]['Countries']['id'];
						}
						$data_details['Users_profile']['city'] = $locationArray[0];



						$education = json_decode($this->request->data['education']);
						$experience = json_decode($this->request->data['experience']);
						$incr_dur=0;


						foreach($education as $edu){

							$isInstituteInDB = $this->Institutes->find('all', array('fields' => array('Institutes.id'), 'conditions' => array("title like '".$edu->name."'"), 'limit' => 1));

							if (isset($isInstituteInDB[0]['Institutes']['id'])) {
								$institute_id = $isInstituteInDB[0]['Institutes']['id'];
							}else{
								$cdata["Institutes"]["title"]=$edu->name;
								$this->Institutes->create();
								$this->Institutes->save($cdata);
								$institute_id = $this->Institutes->getInsertID();
								unset($cdata["Institutes"]["title"]);
							}

							$isQualificationInDB = $this->Qualifications->find('all', array('fields' => array('Qualifications.id'), 'conditions' => array("title like '".$edu->type."'"), 'limit' => 1));

							if (isset($isQualificationInDB[0]['Qualifications']['id'])) {
								$qualification_id = $isQualificationInDB[0]['Qualifications']['id'];
							}else{
								$cdata["Qualifications"]["title"]=$edu->type;
								$this->Qualifications->create();
								$this->Qualifications->save($cdata);
								$qualification_id = $this->Qualifications->getInsertID();
								unset($cdata["Qualifications"]["title"]);
							}

							$c1data["Users_qualifications"]["institute_id"]=$institute_id;
							$c1data["Users_qualifications"]["qualification_id"]=$qualification_id;
							$c1data["Users_qualifications"]["user_id"]=$user_id;
							$c1data["Users_qualifications"]["start_end"]= "00-0000";
							$c1data["Users_qualifications"]["end_date"]= "12-".$edu->year;
							$c1data["Users_qualifications"]["created"]= date("m-Y-m-d H:i:s",strtotime('+'.$incr_dur.' seconds'));
							$this->Users_qualifications->create();
							$this->Users_qualifications->save($c1data);
							unset($c1data["Users_qualifications"]);
							$incr_dur +=30;
						}

						$incr_dur=0;

						foreach($experience as $experience){

							$isCompanyInDB = $this->Companies->find('all', array('fields' => array('Companies.id'), 'conditions' => array("title like '".$experience->name."'"), 'limit' => 1));

							if (isset($isCompanyInDB[0]['Companies']['id'])) {
								$company_id = $isCompanyInDB[0]['Companies']['id'];
							}else{
								$cdata["Companies"]["title"]=$experience->name;
								$this->Companies->create();
								$this->Companies->save($cdata);
								$company_id = $this->Companies->getInsertID();
								unset($cdata["Companies"]["title"]);
							}

							$c1data["Users_experiences"]["company_id"]=$company_id;
							$c1data["Users_experiences"]["designation"]=$experience->job_title;
							$c1data["Users_experiences"]["location"]=$experience->location;
							$c1data["Users_experiences"]["start_date"]=date("m-Y", strtotime($experience->start_date));
							$c1data["Users_experiences"]["end_date"]=date("m-Y", strtotime($experience->end_date));
							$c1data["Users_experiences"]["user_id"]=$user_id;
							$c1data["Users_experiences"]["created"]= date("Y-m-d H:i:s",strtotime('+'.$incr_dur.' seconds'));
							$this->Users_experiences->create();
							$this->Users_experiences->save($c1data);
							unset($c1data["Users_experiences"]);
							$incr_dur +=30;
						}




					}


					$source = $this->request->data['profile_photo'];
					$name = basename($source);
					$imageName = date('His') . $name;

					if($data['User']['register_mode'] == "facebook"){
						$imageName .= ".jpg";
					}


					$uploadOriginal = MEDIA_PATH. "files/user/original";
					$uploadLogo = MEDIA_PATH. "files/user/logo";
					$uploadThumb = MEDIA_PATH. "files/user/thumbnail";
					$uploadIcon = MEDIA_PATH. "files/user/icon";

					$full_image_path = $uploadOriginal . '/' . $imageName;;

					$upload = file_put_contents($full_image_path, file_get_contents($source));

					if ($upload) {
						$data_details['Users_profile']['photo'] = $imageName;
							//$this->request->data['Users_profile']['photo'] = $data['photo'];

							$source_image = $uploadOriginal.'/'.$data_details['Users_profile']['photo'];
							$destination_logo_path = $uploadLogo.'/'.$data_details['Users_profile']['photo'];
							$this->__imageresize($source_image, $destination_logo_path, 165, 165);

							$destination_thumb_path = $uploadThumb.'/'.$data_details['Users_profile']['photo'];
							$this->__imageresize($source_image, $destination_thumb_path, 100, 100);

							$destination_icon_path = $uploadIcon.'/'.$data_details['Users_profile']['photo'];
							$this->__imageresize($source_image, $destination_icon_path, 50, 50);
						 	$image_type = true;
					}


					$pub = time();
					$timestamp = "networkwe-" . $pub;
					$data_details['Users_profile']['handler'] = $timestamp;
					$this->Users_profile->save($data_details);
					echo 1;
					exit;

				}
			}
		}
        echo "-3";
        exit;
    }

    public function forgot_password() {
        if ($this->request->is('ajax')) {
            $email = $this->request->data['forgot_password_email'];
            $emailInDB = $this->User->find('all', array('conditions' => array('email' => "$email")));
            if ($emailInDB) {
                $random_code = md5($this->request->data['forgot_password_email'] . microtime());
                $forgot_link = '';
                $forgot_link = NETWORKWE_URL . '/the-company/recover_password/t:' . $random_code . '/n:' . $email . '';
                

		  $strBody="";

                $json_fields='{"api_key":"'.MAILER_API_KEY.'","email_details":{"fromname":"'.$this->fullescape(MAILER_FORGOT_PASSWORD_FROMNAME).'","subject":"'.$this->fullescape(MAILER_FORGOT_PASSWORD_SUBJECT).'","from":"'.MAILER_FORGOT_PASSWORD_FROMEMAIL.'","replytoid":"'.MAILER_FORGOT_PASSWORD_REPLYTO.'","content":"'.$this->fullescape($strBody).'"},"settings":{"template":"771"},"recipients":["'.$email.'"],"attributes":{"EMAIL":["'.$email.'"],"CONFIRMLINK":["'.$forgot_link.'"],"UNSUB_URL":["'.$this->fullescape(UNSUB_URL."?xEmail=".$email).'"]}}';

                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL, MAILER_SEND_API);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch,CURLOPT_POST, true);
                curl_setopt($ch,CURLOPT_POSTFIELDS, array('data' => $json_fields));
                $api_result = curl_exec($ch);
                curl_close($ch);
                if ($api_result == "success") {
                    $message = "Please Check your email for password recovery";
                    $this->set('data', '1');
                } else {
                    $this->set('data', '-1');
                }
            }
            else
                $this->set('data', '0');
            $this->layout = false;
            $this->autoRender = false;
            $this->render('/Users/forgot_password', 'ajax');
        }
    }

    public function recover_password() {

        if ($this->request->is('post')) {
            $email = $this->request->data['User']['email'];
            $password = $this->request->data['User']['password'];
            $confirm_password = $this->request->data['User']['confirm_password'];

            $currentpassword = hash('sha256', $password);
            $conpassword = hash('sha256', $confirm_password);
            $results = $this->User->find('all', array('conditions' => array('email' => "$email")));
            $UserLogged = $results[0]['User'];
            $id = $UserLogged['id'];
            //print_r($UserLogged);
            if ($id) {
                $this->request->data = '';
//echo 	$password = Security::hash('123456', 'sha1', 'ASDUIAHSDUZ89//(9ASD=Ç%*HHFzgjhbJJGG%%//((())tfbv""ç/');
//echo "<hr>";
//				echo 	$this->request->data['User']['password'] = $currentpassword;
//exit;
                $this->User->id = $id;
                $this->request->data['User']['password'] = $currentpassword;

                if ($this->User->save($this->request->data)) {
                    $this->redirect('/the-company/password_changed/');
                } else {

                    echo "Password not changed";
                    exit;
                }
            }
        }
    }

    public function verify() {
        if (!empty($this->passedArgs['n']) && !empty($this->passedArgs['t'])) {
            $email = $this->passedArgs['n'];
            $code = $this->passedArgs['t'];
            $results = ClassRegistry::init('User')->find('first', array(
                'fields' => array('User.id,COALESCE(User.status,0) AS status,User.role_id,User.varcode'),
                'conditions' => array('AND' => array('varcode' => "$code",'email' => "$email")),
                'recursive' => -1
                ));
            if ($results[0]['status'] == 0) {                    
                $this->request->data['User']['id'] = $results['User']['id'];
                $this->request->data['User']['role_id'] = $results['User']['role_id'];
                $this->request->data['User']['varcode'] = $results['User']['varcode'];
                $this->request->data['User']['status'] = 1;

                $this->request->data['Users_profile']['user_id'] = $results['User']['id'];
                $this->request->data['Users_profile']['role_id'] = $results['User']['role_id'];
                $this->request->data['User_profile_strength']['registration'] = 10;
                $this->request->data['User_profile_strength']['handler'] = 5;
                $this->request->data['User_profile_strength']['user_id'] = $results['User']['id'];
                $handler = "networkwe-" . time();
                $this->request->data['Users_profile']['handler'] = $handler;

                if (ClassRegistry::init('User')->saveAll($this->request->data) && 
                    ClassRegistry::init('Users_profile')->saveAll($this->request->data) &&
                    ClassRegistry::init('User_profile_strength')->saveAll($this->request->data)) {
                    $this->Session->write('userid', $results['User']['id']);
                    $this->Session->write('checkUser', 'logged');
                    $this->Session->write('theme', $results['User']['role_id']);
                    $this->Session->write('email', $email);
                    $this->Session->write('role_id', $results['User']['role_id']);
                    $this->Session->write('language', 'eng');
                    $this->Session->write('fullname', '');
                    $this->Session->write('picture', '');
                    $this->Session->write('city', '');
                    $this->Session->write('handler', $handler);
					
					
					if($results['User']['role_id']==1){
                    $this->redirect(array('controller' => 'company', 'action' => 'complete_profile'));
					}elseif($results['User']['role_id']==2){
						$this->redirect(array('controller' => 'company', 'action' => 'verify'));
					}
                    //$this->redirect(array('controller' => 'company', 'action' => 'verify'));
                }
            } else {
                $this->redirect(array('controller' => 'company', 'action' => 'already_verify'));
            }
        }
        $this->layout = false;
        $this->autoRender = false;
    }

    public function verify_social() {

        if (!empty($this->passedArgs['n']) && !empty($this->passedArgs['t'])) {
            $email = $this->passedArgs['n'];
            $code = $this->passedArgs['t'];
            $results = $this->User->find('all', array('conditions' => array('varcode' => "$code")));

            $UserLogged = $results[0]['User'];

            //check if the user is already activated
            if ($UserLogged['status'] == 0) {
                //check the token
                if ($UserLogged['varcode'] == $code) {
                    //Set activate to 1
                    $UserLogged['status'] = 1;
                    $results['User']['status'] = $UserLogged['status'];
                    $this->User->id = $UserLogged['id'];
                    $data['role_id'] = $UserLogged['role_id'];


                    $this->request->data['Users_profile']['user_id'] = $UserLogged['id'];
                    $loginid = $this->request->data['Users_profile']['user_id'];
                    $this->request->data['Users_profile']['user_id'] = $loginid;
                    $this->request->data['Users_profile']['role_id'] = $data['role_id'];
                    $this->data['Users_profile']['user_id'] = $loginid;
                    $this->request->data['User_profile_strength']['registration'] = 10;
                    $this->request->data['User_profile_strength']['handler'] = 5;
                    $this->request->data['User_profile_strength']['user_id'] = $loginid;
                    $pub = time();
                    $timestamp = "networkwe-" . $pub;
                    $this->request->data['Users_profile']['handler'] = $timestamp;

                    //Save the data
                    if ($this->User->save($results)) {
						//$this->Users_profile->user_id=$UserLogged['id'];
                        //if ($this->Users_profile->save($this->request->data))         {
                            $this->loadModel('User_profile_strength');
                            if ($this->User_profile_strength->save($this->data)) {
                                $this->Session->setFlash('Your registration is complete');
                                $this->redirect(array('controller' => 'company', 'action' => 'verify_social'));
                            } else {
                                echo "not saved the profile strength";
                            }
                        //} else {
                          //  $this->redirect($this->referer());
                            //$this->redirect(array('controller'=>'Company','action'=>'thanks'));
                        //}
                    }
                }
            } else {
                $this->redirect(array('controller' => 'company', 'action' => 'already_verify'));
            }
        }
    }



    	public function loginagain() {
		$currentUseremail =  $_COOKIE["remember_me_email"];
		$currentUserid= $_COOKIE["remember_me_userid"];
		$remember_me = $_COOKIE["js_remember_me"];

		if((!empty($currentUseremail)) && (!empty($currentUserid)) && (!empty($remember_me ))){
			$pass = ClassRegistry::init('users')->find('first',array('conditions'=>array('users.id'=>$currentUserid)));
			$login_Action = $this->User->user_login($currentUseremail, $pass['users']['password']);
			if (isset($login_Action["User"]["id"])) {
				if ($login_Action["User"]["status"] != 1) {
					$this->redirect('/company/pending_confirmation');
					exit;
				}

				$id = $login_Action['User']['id'];
				$theme = $login_Action['User']['theme_id'];
				$role_id = $login_Action['User']['role_id'];
				$email = $login_Action['User']['email'];

				$this->Session->write('userid', $id);
				$this->Session->write('checkUser', 'logged');
				$this->Session->write('theme', $theme);
				$this->Session->write('email', $email);
				$this->Session->write('role_id', $role_id);
				$this->Cookie->write('role_id', $role_id);
				$this->Cookie->write('User', array('email' => $currentUseremail, 'userid' => $id, 'role_id' => $role_id), false);

				$cuser = $this->getCurrentUser($id);
				$firstname = $cuser['firstname'];
				$lastname = $cuser['lastname'];
				$pic = $cuser['photo'];
				$city = $cuser['city'];
				$handler = $cuser['handler'];
				$this->Session->write('fullname', $firstname . " " . $lastname);
				$this->Session->write('picture', $pic);
				$this->Session->write('city', $city);
				$this->Session->write('handler', $handler);

				if ("100" == $role_id) {
					$this->redirect('/admin/');
					exit;
				}
				
				if ("2" == $role_id) {
					$this->loadModel('Company');
					$company = $this->Company->find('first',array('conditions'=> array('AND' => array('Company.flag' => 'profile','Company.user_id'=>$id)) ));
					$this->Session->write('company_id', $company["Company"]["id"]);
					$this->redirect('/recruiter/');
					exit;
				}

				$refral = $this->Session->read('HTTP_REFERAL');
				if(!empty($refral)){
						if("." != substr($refral, -4, 1)){
								$this->Session->read('HTTP_REFERAL','');
								$this->redirect($refral);
								exit;
						}
				}
				$this->redirect(array('controller' => 'users_profiles', 'action' => 'myprofile'));
				exit;
			} else {
				$this->redirect('/company/invalid_account');
				exit;
			}
		}
		$this->render("/loginagain");
	}
	
    public function loginagain_old() {
                $currentUseremail =  $_COOKIE["remember_me_email"];
		$currentPass = $_COOKIE["remember_me_key"];
                $currentUserid= $_COOKIE["remember_me_userid"];
		$remember_me = $_COOKIE['js_remember_me'];
		
	
		//if((!empty($remember_me)) && (!empty($currentUseremail)) && (!empty($currentPass))){ 	
		if((!empty($currentUseremail)) && (!empty($currentPass))){
					//$pass= $this->User->find('first',array('conditions'=>array('User.id'=>$currentUserid)));
					$pass = ClassRegistry::init('users')->find('first',array('conditions'=>array('users.id'=>$currentUserid)));
						
            		$login_Action = $this->User->user_login($currentUseremail, $pass['users']['password']);
			if (isset($login_Action["User"]["id"])) {
				if ($login_Action["User"]["status"] != 1) {
					$this->redirect('/company/pending_confirmation');
						exit;
                                }
				
        	        	    $id = $login_Action['User']['id'];
	        	            $theme = $login_Action['User']['theme_id'];
		                    $role_id = $login_Action['User']['role_id'];
				    $email = $login_Action['User']['email'];
				
				$this->Session->write('userid', $id);
				$this->Session->write('checkUser', 'logged');
				$this->Session->write('theme', $theme);
				$this->Session->write('email', $email);
				$this->Session->write('role_id', $role_id);
				$this->Cookie->write('role_id', $role_id);
				/*if( $this->request->data['User']['remember_me'] == 1){
					$this->Cookie->write('remember_me', 1);
					setcookie("js_remember_me", 1, time()+259200, "/", "", false,false);
				}else{
					$this->Cookie->write('remember_me', -1);
					setcookie("js_remember_me", -1, time()+14400, "/", "", false,false);
				}*/
				$this->Cookie->write('User', array('email' => $currentUseremail,'key'=>$currentPass, 'userid' => $id, 'role_id' => $role_id), false);

				$cuser = $this->getCurrentUser($id);
				$firstname = $cuser['firstname'];
				$lastname = $cuser['lastname'];
				$pic = $cuser['photo'];
				$city = $cuser['city'];
				$handler = $cuser['handler'];
				$this->Session->write('fullname', $firstname . " " . $lastname);
				$this->Session->write('picture', $pic);
				$this->Session->write('city', $city);
				$this->Session->write('handler', $handler);
//echo $role_id;
//exit;

				if ("100" == $role_id) {
					$this->redirect('/admin/');
					exit;
				}
				if ("2" == $role_id) {
					$this->loadModel('Company');
					$company = $this->Company->find('first',array('conditions'=> array('AND' => array('Company.flag' => 'profile','Company.user_id'=>$id)) ));
					//$company = $this->Company->find('first',array('conditions'=> array('Company.user_id'=>$id) ));
					$this->Session->write('company_id', $company["Company"]["id"]);

					$this->redirect('/recruiter/');
					exit;
				}

				$refral = $this->Session->read('HTTP_REFERAL');
                                if(!empty($refral)){
                                        if("." != substr($refral, -4, 1)){
                                                $this->Session->read('HTTP_REFERAL','');
                                                $this->redirect($refral);
                                                exit;
                                        }
                                }


				$this->redirect(array('controller' => 'users_profiles', 'action' => 'myprofile'));
				 exit;
                

			} else {
				$this->redirect('/company/invalid_account');
				exit;
               
			}
		}

	/*	$this->Session->write('userid', '');
        	$this->Session->write('theme', '');
	        $this->Session->write('role_id', '');

        	$this->Session->write('fullname', '');
	        $this->Session->write('email', '');
        	$this->Session->write('photo', '');
	        $this->Session->write('handler', '');
        	$this->Session->destroy();
	        setcookie("cc_data", "", time() - 3600);
        	$this->Cookie->destroy();*/

        	$this->render("/loginagain");
    }

    public function pricing_plans($type) {
        $planDetails = ClassRegistry::init('plans')->find('all', array('fields' => array('plans.*, plans_features.*'), 'conditions' => array('plans.type' => "$type"),
            'joins' => array(array('alias' => 'plans_features', 'table' => 'plans_features', 'foreignKey' => false, 'conditions' => array('plans_features.plan_id = plans.id')))));

        $features = ClassRegistry::init('plans_features_masters')->find('all', array('conditions' => array('plans_features_masters.type' => "$type")));

        $this->set('plans', $planDetails);
        $this->set('features', $features);
        $this->set('type', $type);
    }

    public function pricing_registered($params) {
        $params = split("_", $params);
        $plan_id = $params[0];
        $user_id = $params[1];
        $mode = $params[2];


        /* $planDetails = ClassRegistry::init('plans')->find('all' ,array('fields' => array('plans.*, plans_features.*'),'conditions' => array('plans.id' => "$plan_id"),
          'joins' => array(array('alias' => 'plans_features', 'table' => 'plans_features', 'foreignKey' => false, 'conditions' => array('plans_features.plan_id = plans.id')))));
         */

        $plans = ClassRegistry::init('plans')->find('all', array('conditions' => array('plans.id' => "$plan_id")));

        $type = $plans[0]['plans']['type'];

        $features = ClassRegistry::init('plans_features_masters')->find('all', array('conditions' => array('plans_features_masters.type' => "$type")));

        $features_ids = "'";
        foreach ($features as $feature) {
            foreach ($feature as $value) {
                $features_ids .= $value["id"] . "','";
            }
        }

        $features_ids = trim($features_ids, ",'");
        $plans_features = ClassRegistry::init('plans_features')->find('all', array('conditions' => array("plans_features.plan_id='$plan_id' AND plans_features.feature_id IN ('$features_ids')")));


//echo "<pre>";
//print_r($plans[0]['plans']);
//print_r($features);
//print_r($plans_features);

        if ($mode == "y") {
            $plans[0]['plans']['price'] = $plans[0]['plans']['price'] * 12 - ($plans[0]['plans']['price'] * 12 * $plans[0]['plans']['yearly_discount_percentage'] / 100);
            $plans[0]['plans']['mode'] = "Yearly";
        } else {
            $plans[0]['plans']['mode'] = "Monthly";
        }



        $this->set('plans', $plans[0]['plans']);
        $this->set('features', $features);
        $this->set('plans_features', $plans_features);
        $this->set('type', $type);
        $this->set('user_id', $user_id);
        $this->set('plan_id', $plan_id);
        $this->set('mode', $mode);
    }

    public function pricing_registered1($params) {
        $params = split("_", $params);
        $plan_id = $params[0];
        $user_id = $params[1];
        $mode = $params[2];


        $response = $this->curlCall();
        echo "<pre>";
        print_r($response);
        echo "ff";
        $responseArray = split("&", $response);
        foreach ($responseArray as $value) {
            $result = split("=", $value);
            if ($result[0] == "TOKEN") { //TIMESTAMP //CORRELATIONID //ACK //VERSION //BUILD
                //	echo "<script>document.location = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=".$result[1]."';;
            }
            print_r($responseArray);
        };
    }

    public function pricing_plans_jobseekers() {

    }

    public function pricing_plans_recruiters() {

    }

    public function pricing_jobseekers_registered() {

    }

    public function pricing_recruiters_registered() {

    }

    public function checkout() {

    }

    function ajax_login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $cuser = $this->Session->read('Auth.User');
                $id = $this->Session->read('Auth.User.id');
                $theme = $this->Session->read('Auth.User.theme_id');
                $email = $this->Session->read('Auth.User.email');


                $this->Session->write('userid', $id);
                $this->Session->write('checkUser', 'logged');
                $this->Session->write('theme', $theme);
                $this->Session->write('email', $email);
                $this->Session->write('language', 'eng');

                $cuser = $this->getCurrentUser($id);

                $firstname = $cuser['firstname'];
                $lastname = $cuser['lastname'];
                $pic = $cuser['photo'];
                $city = $cuser['city'];
                $handler = $cuser['handler'];

                $this->Session->write('fullname', $firstname . " " . $lastname);
                $this->Session->write('picture', $pic);
                $this->Session->write('city', $city);
                $this->Session->write('handler', $handler);

                echo 1;
                exit;
            }
        }
        echo -1;
        exit;
    }

    public function ajax_register() {
        if ($this->request->is('post')) {
            $data['role_id'] = $this->request->data['User']['role_id'];
            $data['email'] = $this->request->data['User']['email'];
            $this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);
            $this->request->data['User']['varcode'] = md5($this->request->data['User']['email'] . microtime());
            $data['varcode'] = $this->request->data['User']['varcode'];
            if ($data['role_id'] == 1) {
                $this->request->data['User']['theme_id'] = 1;
                $theme = $this->request->data['User']['theme_id'];
            }
            if ($this->User->save($this->request->data)) {
                $userid = $this->User->getInsertID();
                $ms = '';
                $ms = NETWORKWE_URL .'/users/verify/t:' . $data['varcode'] . '/n:' . $data['email'] . '';


                $strBody="";


                $json_fields='{"api_key":"'.MAILER_API_KEY.'","email_details":{"fromname":"'.$this->fullescape(MAILER_REGISTER_FROMNAME).'","subject":"'.$this->fullescape(MAILER_REGISTER_SUBJECT).'","from":"'.MAILER_REGISTER_FROMEMAIL.'","replytoid":"'.MAILER_REGISTER_REPLYTO.'","content":"'.$this->fullescape($strBody).'"},"settings":{"template":"769"},"recipients":["'.$data["email"].'"],"attributes":{"EMAIL":["'.$data["email"].'"],"CONFIRMLINK":["'.$ms.'"],"UNSUB_URL":["'.$this->fullescape(UNSUB_URL."?xEmail=".$data["email"]).'"]}}';

                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL, MAILER_SEND_API);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch,CURLOPT_POST, true);
                curl_setopt($ch,CURLOPT_POSTFIELDS, array('data' => $json_fields));
                $api_result = curl_exec($ch);
                curl_close($ch);
                if ($api_result == "success") {
 		    echo $userid;
                    exit;

                }

            }
        }
        echo -1;
        exit;
    }

    function curlCall() {

        $ch = curl_init();
        $apiData = array(
            "USER" => "support_api1.gulfbankers.com",
            "PWD" => "Y5CNCM7LDWNEW64Z",
            "SIGNATURE" => "AFcWxV21C7fd0v3bYYYRCpSSRl31AqGCU9VQwYCLMztuUWgVnD4CbtY6",
            "VERSION" => "52.0",
            "PAYMENTREQUEST_0_PAYMENTACTION" => "Sale",
            "PAYMENTREQUEST_0_AMT" => "1000",
            "AMT" => "19.95",
            "RETURNURL" => "https://stage.networkwe.com/users/paypal_return/",
            "CANCELURL" => "http://stage.networkwe.com/users/pricing_plans_jobseekers/",
            "METHOD" => "SetExpressCheckout");


        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, "https://api-3t.sandbox.paypal.com/nvp/");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
        // grab URL and pass it to the browser
        $response = curl_exec($ch);
        // close cURL resource, and free up system resources
        curl_close($ch);

        return $response;
    }

}

?>
