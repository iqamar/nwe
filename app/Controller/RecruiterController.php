<?php

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class RecruiterController extends AppController {

    var $helpers = array('Form', 'html');
    var $components = array('Auth');
    //var $uses = array('GoogleAnalytics.GoogleAnalyticsAccount');

    function beforeFilter() {
        $this->Auth->allow();
        switch ($this->request->params['action']) {
            case 'index':
            case 'client':
                $this->Security->validatePost = false;
        }
        $this->primary_email = $this->Session->read('email');
        $this->user_id = $this->Session->read('userid');
        $this->company_id = $this->Session->read('company_id');
        parent::beforeFilter();
    }

    public function index() {
        $this->loadModel('Company');
        $this->Company->recursive = 2;
        $this->Company->bindModel(array(
            'belongsTo' => array(
                'Users_profile' => array(
                    'foreignKey' => false,
                    'class' => 'Users_profile',
                    'conditions' => array('Company.user_id = Users_profile.user_id')
                ),
                'User' => array(
                    'foreignKey' => false,
                    'class' => 'User',
                    'conditions' => array('Company.user_id = User.id')
                )
            )
        ));
        $userData = $this->Company->find('first', array('conditions' => array('Company.user_id' => $this->user_id)));
        if ($userData) {

            /*
             * Find list of assigned users.
             */
            $company_users = array();
            $recruiter_users = ClassRegistry::init('Recruiter_user')->get_assigned_users($this->company_id);
            foreach ($recruiter_users as $users) {
                $company_users[] = $users['Users_profile']['user_id'];
            }
            $company_users[] = $this->user_id;
            $hot_jobs = ClassRegistry::init('Jobs_application')->get_hot_jobs($company_users, 'all', 1);
            foreach ($hot_jobs as $applciation) {
                $total_applications += $applciation[0]['cnt'];
            }
            $total_company_users = sizeof($recruiter_users);

            $jobs_list = ClassRegistry::init('Job')->get_job_list($this->company_id, 2);
            $total_jobs = sizeof($jobs_list);
            $jobs_reffered = ClassRegistry::init('Jobs_referral')->get_refered_jobs($this->user_id, 'count');

            /*
             * Facebook Auth
             */
            App::import('Vendor', 'Facebook/facebook');
            $facebook = new Facebook(array(
                'appId' => FB_APP_ID,
                'secret' => FB_APP_SECRET,
            ));

            $user = $facebook->getUser();

            if ($user) {
                $logoutUrl = $facebook->getLogoutUrl();
            } else {
                //$statusUrl = $facebook->getLoginStatusUrl();
                $loginUrl = $facebook->getLoginUrl(array(
                    'scope' => 'publish_stream,publish_actions',
                    'redirect_uri' => NETWORKWE_URL . '/recruiter/'
                ));
            }
            $this->set(compact('user', 'logoutUrl', 'loginUrl', 'hot_jobs', 'total_company_users', 'total_jobs', 'total_applications', 'jobs_list', 'jobs_reffered'));
            $this->render('dashboard');
        } else {
            $this->redirect(array('action' => 'companyAdd'));
        }
    }

    function photo_upload($file, $location = 'company', $logo = FALSE, $icon = FALSE, $thumbnail = FALSE, $cover = FALSE, $name = '') {
        /*
         * @author  :   Danish Backer
         * @Date    :   22-04-2014
         * @usage   :   photo_upload()
         */
        $upload_path = MEDIA_PATH . "files" . DS . $location . DS;
        switch ($file['type']) {
            case 'image/gif' : $ext = '.gif';
                break;
            case 'image/jpeg' :
            case 'image/jpg' : $ext = '.jpg';
                break;
            case 'image/png' : $ext = '.png';
                break;
            default : $ext = '';
                break;
        }
        if (!empty($ext)) {
            $filename = $name ? $name : uniqid("CMP", FALSE) . $ext;
            $dest = $upload_path . 'original' . DS . $filename;
            if (move_uploaded_file($file['tmp_name'], $dest)) {
                if ($logo)
                    $this->__imageresize($dest, $upload_path . 'logo' . DS . $filename, 100, 100);
                if ($icon)
                    $this->__imageresize($dest, $upload_path . 'icon' . DS . $filename, 60, 60);
                if ($thumbnail)
                    $this->__imageresize($dest, $upload_path . 'thumbnail' . DS . $filename, 100, 100);
                if ($cover)
                    $this->__imageresize($dest, $upload_path . 'cover' . DS . $filename, 237, 653);
            }
        }
        else
            unset($filename);
        return (!empty($filename)) ? $filename : FALSE;
    }

    public function companyAdd() {
        if (!empty($this->company_id)) {
            $this->Session->setFlash('Already have a valid company profile!', 'custom_flash', array('params' => array('noty_class' => 'warning')), 'recruiter_flash');
            $this->redirect(array('action' => 'index'));
            exit;
        }

        $company_type = ClassRegistry::init('Companies_type')->find('list', array('conditions' => array('Companies_type.status' => 2)));
        $this->set(compact('company_type'));
        $this->set('industries', ClassRegistry::init('Industry')->find('list'));
        $this->set('countries', ClassRegistry::init('Country')->find('list'));
        $this->set('primary_email', $this->Cookie->read('User.email'));
        if ($this->request->data) {
            $image = $this->photo_upload($this->request->params['form']['image'], 'company', FALSE, FALSE, FALSE, TRUE);
            $logo = $this->photo_upload($this->request->params['form']['logo'], 'company', TRUE, TRUE, TRUE);
            $this->request->data['Company']['user_id'] = $this->user_id;
            $this->request->data['Company']['status'] = 2;
            $this->request->data['Company']['image'] = $image ? $image : '';
            $this->request->data['Company']['logo'] = $logo ? $logo : '';
            $this->request->data['Company']['title'] = $this->request->data['title'];
            $this->request->data['Company']['primary_email'] = $this->request->data['primary_email'];
            $this->request->data['Company']['alternative_email'] = $this->request->data['alternative_email'];
            $this->request->data['Company']['established'] = $this->request->data['established'];
            $this->request->data['Company']['description'] = $this->request->data['description'];
            $this->request->data['Company']['company_size'] = $this->request->data['company_size'];
            $this->request->data['Company']['contact_name'] = $this->request->data['contact_name'];
            $this->request->data['Company']['designation'] = $this->request->data['designation'];
            $this->request->data['Company']['address'] = $this->request->data['address'];
            $this->request->data['Company']['address2'] = $this->request->data['address2'];
            $this->request->data['Company']['address3'] = $this->request->data['address3'];
            $this->request->data['Company']['fax1'] = $this->request->data['fax1'];
            $this->request->data['Company']['fax2'] = $this->request->data['fax2'];
            $this->request->data['Company']['mobile'] = $this->request->data['mobile'];
            $this->request->data['Company']['state'] = $this->request->data['state'];
            $this->request->data['Company']['city'] = $this->request->data['city'];
            $this->request->data['Company']['weburl'] = $this->request->data['weburl'];
            $this->request->data['Company']['company_type_id'] = $this->request->data['company_type_id'];
            $this->request->data['Company']['industry_id'] = $this->request->data['industry_id'];
            $this->request->data['Company']['company_operating_status'] = $this->request->data['company_operating_status'];
            $this->request->data['Company']['country_id'] = $this->request->data['country_id'];
            $this->request->data['Company']['top_employer_display'] = $this->request->data['top_employer_display'] ? 1 : 0;
            $this->request->data['Company']['featured_display'] = $this->request->data['featured_display'] ? 1 : 0;
            $this->request->data['Company']['modified_by'] = $this->user_id;
			$this->request->data['Company']['flag'] = "profile";
            //print_r($this->request->data['Company']);
            //exit;
            if (ClassRegistry::init('Company')->save($this->request->data['Company'])) {
                $company_id = ClassRegistry::init('Company')->getInsertID();
                $this->Session->write('company_id', $company_id);
                $this->redirect(array('action' => 'index'));
            }
        }
        $this->autoRender = false;
        $this->render('companyAdd');
    }

    public function employer() {
        $list = ClassRegistry::init('Company')->find('all', array('conditions' => array('Company.user_id' => $this->user_id)));
        $this->set('company', $list);
        $this->set('primary_email', $this->primary_email);
    }

    public function employer_edit() {
        /*
         * @author:     Danish Backer
         * @date:       21-05-2014
         * @purpose:    Edit method for employer
         */

        $company_type = ClassRegistry::init('Companies_type')->find('list', array('conditions' => array('Companies_type.status' => 2)));
        $industries = ClassRegistry::init('Industry')->find('list');
        $countries = ClassRegistry::init('Country')->find('list');
        $company = ClassRegistry::init('Company')->find('first', array('conditions' => array('Company.id' => $this->company_id, 'Company.user_id' => $this->user_id), 'recursive' => -1));
        $primary_email = $this->primary_email;
        $this->set(compact('company_type', 'industries', 'countries', 'primary_email', 'company'));

        if ($this->request->is('post')) {
            if (!empty($this->request->params['form']['logo'])) {
                $logo = $this->photo_upload($this->request->params['form']['logo'], 'company', TRUE, TRUE, TRUE, FALSE);
                if ($logo) {
                    $path_logo = MEDIA_PATH . 'files' . DS . 'company' . DS . 'thumbnail' . DS . $company['Company']['logo'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_logo = MEDIA_PATH . 'files' . DS . 'company' . DS . 'original' . DS . $company['Company']['logo'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_logo = MEDIA_PATH . 'files' . DS . 'company' . DS . 'logo' . DS . $company['Company']['logo'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_logo = MEDIA_PATH . 'files' . DS . 'company' . DS . 'icon' . DS . $company['Company']['logo'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_logo = MEDIA_PATH . 'files' . DS . 'company' . DS . 'cover' . DS . $company['Company']['logo'];
                    $f = new File($path_logo, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                }
            }
            if (!empty($this->request->params['form']['image'])) {
                $image = $this->photo_upload($this->request->params['form']['image'], 'company', FALSE, FALSE, FALSE, TRUE);
                if ($image) {
                    $path_image = MEDIA_PATH . 'files' . DS . 'company' . DS . 'thumbnail' . DS . $company['Company']['image'];
                    $f = new File($path_image, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_image = MEDIA_PATH . 'files' . DS . 'company' . DS . 'original' . DS . $company['Company']['image'];
                    $f = new File($path_image, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_image = MEDIA_PATH . 'files' . DS . 'company' . DS . 'logo' . DS . $company['Company']['image'];
                    $f = new File($path_image, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_image = MEDIA_PATH . 'files' . DS . 'company' . DS . 'icon' . DS . $company['Company']['image'];
                    $f = new File($path_image, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                    $path_image = MEDIA_PATH . 'files' . DS . 'company' . DS . 'cover' . DS . $company['Company']['image'];
                    $f = new File($path_image, false, 0777);
                    ($f->exists()) ? $f->delete() : false;
                    $f->close();
                }
            }
            $data = array();
            $data['Company']['id'] = $this->company_id;
            if ($logo)
                $data['Company']['logo'] = $logo;
            if ($image)
                $data['Company']['image'] = $image;
            $data['Company']['title'] = $this->request->data['title'];
            $data['Company']['alternative_email'] = $this->request->data['alternative_email'];
            $data['Company']['established'] = $this->request->data['established'];
            $data['Company']['description'] = $this->request->data['description'];
            $data['Company']['company_size'] = $this->request->data['company_size'];
            $data['Company']['contact_name'] = $this->request->data['contact_name'];
            $data['Company']['designation'] = $this->request->data['designation'];
            $data['Company']['address'] = $this->request->data['address'];
            $data['Company']['address2'] = $this->request->data['address2'];
            $data['Company']['address3'] = $this->request->data['address3'];
            $data['Company']['fax1'] = $this->request->data['fax1'];
            $data['Company']['fax2'] = $this->request->data['fax2'];
            $data['Company']['mobile'] = $this->request->data['mobile'];
            $data['Company']['state'] = $this->request->data['state'];
            $data['Company']['city'] = $this->request->data['city'];
            $data['Company']['weburl'] = $this->request->data['weburl'];
            $data['Company']['company_type_id'] = $this->request->data['company_type_id'];
            $data['Company']['industry_id'] = $this->request->data['industry_id'];
            $data['Company']['company_operating_status'] = $this->request->data['company_operating_status'];
            $data['Company']['country_id'] = $this->request->data['country_id'];
            $data['Company']['top_employer_display'] = $this->request->data['top_employer_display'] ? 1 : 0;
            $data['Company']['featured_display'] = $this->request->data['featured_display'] ? 1 : 0;
            $data['Company']['modified_by'] = $this->user_id;
            if (ClassRegistry::init('Company')->saveAll($data['Company'])) {
                $this->Session->setFlash('Saved changes.', 'custom_flash', array('params' => array('noty_class' => 'success')), 'recruiter_flash');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function chkemail() {
        $this->autoRender = false;
        header('Content-type: application/json');
        //$this->loadModel('Company');
        //if ($this->request->is('get')) {
        //$primary_email = $this->request->data['pemail']?$this->request->data['pemail']:$this->request->params['named']['pemail'];
        $primary_email = $this->request->query['primary_email'];
        if (!empty($primary_email)) {
            $topLevel = @explode('@', $primary_email);
            $topLevel = strtolower($topLevel[1]);
            $pemail = ClassRegistry::init('Company')->find('first', array('conditions' => array('LOWER(Company.primary_email) LIKE' => "%$topLevel")));
            if ($pemail) {
                //$json = json_encode(array('message' => 'This domain already exist!', 'status' => true));
                echo 'false';
                //echo "This domain already exist!";
            } else {
                //$json = json_encode(array('message' => 'Ok!', 'status' => false));
                echo 'true';
            }
        } else {
            echo 'false';
            //$json = json_encode(array('message' => 'Invalid email!', 'status' => false));
            //echo "Please enter primary email!";
        }
        //}
        //echo json_encode($json);
    }

    public function users() {
        $users = ClassRegistry::init('Recruiter_user')->get_assigned_users($this->company_id);
        $this->set('users', $users);
    }

    public function jobs($mode = 2) {
        /*
         * $mode defaults to 2(active), mode 3(expired) and mode -1(deleted)
         */
        switch ($mode) {
            case 'deleted': $status_id = -1;
                break;
            case 'expired': $status_id = 3;
                break;
            default: $status_id = 2;
                break;
        }
        $jobDataList = ClassRegistry::init('Job')->get_job_list($this->company_id, $status_id);
        $this->set('jobs', $jobDataList);
    }

    public function jobApplications($id = 0) {
        $this->loadModel('Company');
        $this->loadModel('Job');
        $this->loadModel('jobs_application');
        $this->loadModel('Users_profile');
        $this->Company->recursive = 2;
        $this->Company->bindModel(array('belongsTo' => array('Users_profile' => array('foreignKey' => false, 'class' => 'Users_profile', 'conditions' => array('Company.user_id = Users_profile.user_id')), 'User' => array('foreignKey' => false, 'class' => 'User', 'conditions' => array('Company.user_id = User.id')))));
        $userData = $this->Company->find('first', array('conditions' => array('Company.user_id' => $this->user_id)));
        $jobData = $this->Job->find('all', array('conditions' => array('Job.company_id' => $userData['Company']['id'])));
        $strJobId = "";
        foreach ($jobData as $row) {
            $strJobId .= $row['Job']['id'] . ",";
        }
        if (!empty($strJobId)) {
            $strJobId = "(" . trim($strJobId, ",") . ")";

            if ($id) {
                $jobApp = $this->jobs_application->query("SELECT JA.*, JSCY.name,JS.title,JS.city,JS.start_date,JS.expiry_date,JS.job_code,EMP.title,EMP.id,UP.firstname,UP.lastname,UP.city,UPCY.name FROM jobs_applications AS JA LEFT JOIN jobs AS JS ON (JA.job_id=JS.id) LEFT JOIN countries AS JSCY ON (JS.country_id=JSCY.id) LEFT JOIN companies AS EMP ON (JS.company_id=EMP.id) LEFT JOIN users_profiles AS UP ON (JA.user_id=UP.user_id) LEFT JOIN countries AS UPCY ON(UP.country_id=UPCY.id) WHERE JA.job_id=$id ORDER BY JA.modified DESC;");
                $this->set('jobApp', $jobApp);
            } else {
                $jobApp = $this->jobs_application->query("SELECT JA.*, JSCY.name,JS.title,JS.city,JS.start_date,JS.expiry_date,JS.job_code,EMP.title,EMP.id,UP.firstname,UP.lastname,UP.city,UPCY.name FROM jobs_applications AS JA LEFT JOIN jobs AS JS ON (JA.job_id=JS.id) LEFT JOIN countries AS JSCY ON (JS.country_id=JSCY.id) LEFT JOIN companies AS EMP ON (JS.company_id=EMP.id) LEFT JOIN users_profiles AS UP ON (JA.user_id=UP.user_id) LEFT JOIN countries AS UPCY ON(UP.country_id=UPCY.id) WHERE JA.job_id IN $strJobId ORDER BY JA.modified DESC;");
                $this->set('jobApp', $jobApp);
            }
            //pr($jobApp);
            if ($this->request->is('post')) {
                //pr($this->request);
                $this->render('job_applications', 'export_xls');
            }
        }
    }

    public function jobApplicationView($id = 0) {
        $this->layout = $this->autoRender = false;
        $this->loadModel('Job');
        $this->loadModel('jobs_application');
        $this->loadModel('Users_profile');
        $appid = $this->request->data['appid'];
        $appstatus = $this->request->data['appstatus'];
        if ($appstatus) {
            $this->jobs_application->updateAll(array('status' => $appstatus), array('jobs_application.id' => $appid));
        }
        if ($appid) {
            $this->jobs_application->recursive = 2;
            $this->jobs_application->bindModel(array('belongsTo' => array('Job' => array('foreignKey' => false, 'class' => 'Job', 'conditions' => array('jobs_application.job_id=Job.id')), 'Users_profile' => array('foreignKey' => false, 'class' => 'Users_profile', 'conditions' => array('jobs_application.user_id=Users_profile.user_id')), 'User' => array('foreignKey' => false, 'class' => 'User', 'fields' => array('User.email'), 'conditions' => array('jobs_application.user_id=User.id')))));
            $jobApp = $this->jobs_application->find('first', array('conditions' => array('jobs_application.id' => $appid)));
            $this->set('jobData', $jobApp);
        }

        $this->render('jobApplicationView');
    }

    public function referredJobs() {
        /* $sql = "SELECT
          R.id RID, R.job_id, R.user_id, R.friend_id, R.email, R.created,
          J.id JID, J.title job_title, J.`status`,
          (SELECT firstname FROM users_profiles WHERE user_id = R.friend_id) refered_to,
          CONCAT(P.firstname,' ',P.lastname) as refered_by
          FROM
          jobs_referrals R
          LEFT JOIN jobs J ON (R.job_id = J.id)
          LEFT JOIN companies CO ON (J.company_id = CO.id)
          LEFT JOIN countries CY ON (J.country_id = CY.id)
          LEFT JOIN users U ON (R.user_id = U.id)
          LEFT JOIN users_profiles P ON (R.user_id = P.user_id)
          WHERE
          CO.user_id = {$this->user_id}
          AND J.`status` = 2
          AND (R.friend_id <> '' OR R.user_id <> '' OR R.email <> '')
          ORDER BY
          DATE(R.created) DESC,
          R.created ASC;"; */
        //$jobsRefer = ClassRegistry::init('Jobs_referral')->query($sql);
        $jobsRefer = ClassRegistry::init('Jobs_referral')->get_refered_jobs($this->user_id);
        //pr($jobsRefer);
        $this->set('jobsReferred', $jobsRefer);
    }

    public function jobs_view($id = 0) {
        $this->loadModel('Job');
        //$jobData=$this->Job->find('first',array('conditions'=>array('Job.id'=>$id)));
        $jobData = $this->Job->query("SELECT * FROM jobs AS Job LEFT JOIN companies AS Company ON (Job.company_id = Company.id) WHERE Job.id = $id AND Job.user_id = $this->user_id");
        $this->set('jobData', $jobData[0]);
    }

    function jobsStatusChange() {
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('Job');

        if ($this->request->is('post')) {

            $jobid = $this->request->data['jobid'];
            $jobstatus = $this->request->data['jobstatus'];

            if ($this->Job->updateAll(array('status' => $jobstatus), array('Job.id' => $jobid))) {
                $jobData = $this->Job->find('first', array('conditions' => array('Job.id' => $jobid)));
                $this->set('jobData', $jobData);
            }
        }
        $this->render('jobs_view');
    }

    public function get_skills() {
        $this->layout = $this->autoRender = false;
        $match = $_GET['search_str'];
        $skills = ClassRegistry::init('Skill')->get_skills($match, 10, '');
        if ($skills) {
            echo '<ul class="nav nav-list">';
            foreach ($skills as $search_skill_row) {
                $title = $search_skill_row['Skill']['title'];
                $skillid = $search_skill_row['Skill']['id'];
                echo '<li><a href="javascript: assignSkill(\'' . $title . '\',\'' . $skillid . '\');"><i class="icon-plus"></i>' . $title . '</a></li>';
            }
            echo '</ul>';
        }
    }

    public function jobs_add() {
        $this->set('company_id', $this->company_id);
        $this->loadModel('Job');

        if ($this->request->is('post')) {
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
                'group_id' => $this->request->data('select_groups'),
                'user_id' => $this->user_id,
                'company_id' => $this->company_id,
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

            if ($this->request->data('confidentiality') == NULL) {
                $jobData['confidentiality'] = 0;
            }

            if ($this->request->data('auto_reply_apply') != 1) {
                $jobData['auto_reply_apply_text'] = NULL;
            }
            
            if ($this->request->data('apply_remote_website') == 'on') {
                $jobData['remote_website_url'] = $this->request->data('remote_website_url');
            }
            
            $jobData["status"] = 2;
            $this->Job->create();
            //if(ClassRegistry::init('jobs')->save($jobData)){
            if ($this->Job->save($jobData)) {
                $job_id = $this->Job->getLastInsertID();
                $this->Job->id = $job_id;
                $this->Job->saveField('job_code', 'JB10' . $job_id);

                $insert_data_0[] = array();
                $selected_company_pages_array = $this->request->data('company_page');
                if (sizeof($selected_company_pages_array) > 0) {
                    $i = 0;
                    foreach ($selected_company_pages_array as $company_page_id) {
                        $insert_data_0[$i]['Jobs_company_page']['job_id'] = $job_id;
                        $insert_data_0[$i]['Jobs_company_page']['company_id'] = $company_page_id;
                        $i++;
                    }
                    ClassRegistry::init('Jobs_company_page')->create();
                    ClassRegistry::init('Jobs_company_page')->saveAll($insert_data_0);
                }

                $insert_data_1[] = array();
                $selected_groups_array = $this->request->data('user_group');
                if (sizeof($selected_groups_array) > 0) {
                    $i = 0;
                    foreach ($selected_groups_array as $group_id) {
                        $insert_data_1[$i]['Jobs_group']['job_id'] = $job_id;
                        $insert_data_1[$i]['Jobs_group']['group_id'] = $group_id;
                        $i++;
                    }
                    ClassRegistry::init('Jobs_group')->create();
                    ClassRegistry::init('Jobs_group')->saveAll($insert_data_1);
                }

                $skills = trim($this->request->data('selectedSkills'), ',');
                if ($skills) {
                    $skills = explode(',', $skills);
                    $insert_data_2[] = array();
                    $i = 0;
                    foreach ($skills as $skill_id) {
                        $insert_data_2[$i]['Jobs_skill']['job_id'] = $job_id;
                        $insert_data_2[$i]['Jobs_skill']['skill_id'] = $skill_id;
                        $i++;
                    }
                    ClassRegistry::init('Jobs_skill')->create();
                    ClassRegistry::init('Jobs_skill')->saveAll($insert_data_2);
                }

                if ($this->request->data('share_social') == 'on') {
                    /*
                     * URL Shortener
                     */
                    $longUrl = JOBS_URL . '/search/jobDetails/' . $job_id;
                    $postData = array('longUrl' => $longUrl, 'key' => GOOGLE_API_KEY);
                    App::uses('Urlshorten', 'Lib');
                    $urlshorten = new Urlshorten();
                    $shortUrl = $urlshorten->httpsPost($postData);
                    $url = ($shortUrl != null) ? $shortUrl->id : $longUrl;

                    /*
                     * Twitter Share
                     */
                    App::import('Vendor', 'Twitter/codebird');
                    \Codebird\Codebird::setConsumerKey(TW_API_KEY, TW_API_SECRET);
                    $cb = \Codebird\Codebird::getInstance();
                    $cb->setToken(TW_ACCESS_TOKEN, TW_ACCESS_TOKEN_SECRET);
                    $Country = ClassRegistry::init('Country')->findById($this->request->data('locations'));
                    $Functional_area = ClassRegistry::init('Functional_area')->findById($this->request->data('functional_area'));
                    $Industry = ClassRegistry::init('Industry')->findById($this->request->data('industries'));
                    $Functional_area_tags = preg_replace('/\&amp;/', ' #', str_replace('/', ' #', str_replace(' ', '', $Functional_area['Functional_area']['title'])));
                    $Industry_tags = preg_replace('/\&amp;/', ' #', str_replace('/', ' #', str_replace(' ', '', $Industry['Industry']['title'])));
                    $Country_tags = str_replace(' ', '', $Country['Country']['name']);
                    $params = array(
                        'status' => 'Find #Jobs for ' . $this->request->data('jobTitle') . ' #' . $Functional_area_tags . ' #' . $Industry_tags . ' in #' . $Country_tags . ' Apply here ' . $url
                    );
                    $cb->statuses_update($params);

                    /*
                     * Facebook Share
                     */
                    App::import('Vendor', 'Facebook/facebook');
                    $facebook = new Facebook(array(
                        'appId' => FB_APP_ID,
                        'secret' => FB_APP_SECRET,
                    ));

                    $user = $facebook->getUser();
                    if ($user) {
                        $facebook->api('/me');
                        try {
                            $facebook->api('/NetworkWe/feed', 'post', array(
                                'name' => SITE_TITLE,
                                'message' => $params['status'],
                                'privacy' => array('value' => 'CUSTOM', 'friends' => 'SELF'),
                                'description' => strip_tags($this->request->data('job_description')),
                                'picture' => MEDIA_URL . '/files/company/logo/003445network_we_160x160.png',
                                'caption' => $longUrl,
                                'link' => $longUrl)
                            );
                        } catch (FacebookApiException $e) {
                            //error_log($e);
                            $user = null;
                        }
                    }
                }

                $this->Session->setFlash('Job saved sucessfully.', 'custom_flash', array('params' => array('noty_class' => 'success')), 'recruiter_flash');
            } else {
                $this->Session->setFlash('Error saving job!', 'custom_flash', array('params' => array('noty_class' => 'error')), 'recruiter_flash');
            }
            $this->redirect(array('controller' => 'recruiter', 'action' => 'jobs'));
        } else {
            $this->set('countries', ClassRegistry::init('countries')->find('all', array('conditions' => array('countries.status' => '1'))));
            $this->set('companies', ClassRegistry::init('companies')->find('all', array('conditions' => array('companies.status' => '1'))));
            //$this->set('qualifications', ClassRegistry::init('qualifications')->find('all', array('conditions' => array('qualifications.status' => '1'), 'order' => array('qualifications.priority', 'qualifications.title'))));
            $this->set('functional_areas', ClassRegistry::init('functional_areas')->find('all', array('conditions' => array('functional_areas.status' => '1'))));
            $this->set('industries', ClassRegistry::init('industries')->find('all', array('order' => array('industries.title'))));
        }
        $this->set('job_types', ClassRegistry::init('job_types')->find('all'));

        /*
         * Changed Table from company_admins to recruiter_users
         */
        $Recruiter_user = ClassRegistry::init('Recruiter_user')->find('all', array(
            'fields' => array('Recruiter_user.user_id'),
            'joins' => array(
                array('alias' => 'Company',
                    'table' => 'companies',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('Company.id = Recruiter_user.company_id')
                )
            ),
            'conditions' => array('Recruiter_user.company_id' => $this->company_id)
                )
        );
        $company_users = array();
        foreach ($Recruiter_user as $users) {
            $company_users[] = $users["Recruiter_user"]["user_id"];
        }
        $company_users[] = $this->user_id;
        $company_users_in = join(',', $company_users);
        $company_pages = ClassRegistry::init('Company')->find('all', array('fields' => array('Company.id, Company.title'), 'conditions' => array("AND" => array('Company.flag' => 'page', "Company.user_id IN (" . $company_users_in . ")"))));
        $this->set('company_pages', $company_pages);
        $user_groups = ClassRegistry::init('Group')->find('all', array('fields' => array('Group.id, Group.title'), 'conditions' => array("Group.user_id IN (" . $company_users_in . ")")));
        $this->set('user_groups', $user_groups);
    }

    function jobs_edit($id) {
        //Configure::write('debug', 2);
        $this->loadModel('Job');
        //$this->loadModel('Country');
        //$this->loadModel('Company');
        //$this->loadModel('Functional_area');
        //$this->loadModel('Industry');
        //$this->loadModel('Jobs_skill');

        $this->Job->id = $id;
        if ($this->request->is('post')) {
            $this->set('company_id', $this->company_id);
            $jobData = array(
                'company_id' => $this->company_id,
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
                'modified_by' => $this->user_id,
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

            if ($this->request->data('confidentiality') == NULL) {
                $jobData['confidentiality'] = 0;
            }
            
            if ($this->request->data('apply_remote_website') == 'on') {
                $jobData['remote_website_url'] = $this->request->data('remote_website_url');
            } else {
                $jobData['remote_website_url'] = '';
            }

            if ($this->request->data('auto_reply_apply') != 1) {
                $jobData['auto_reply_apply_text'] = NULL;
            }

            $this->Job->create();
            $this->Job->id = $id;

            //if(ClassRegistry::init('jobs')->save($jobData)){
            if ($this->Job->save($jobData)) {
                //$job_id = $this->Job->getLastInsertID();//unused var

                $insert_data_0[] = array();
                $selected_company_pages_array = $this->request->data('company_page');
                if (sizeof($selected_company_pages_array) > 0) {
                    $i = 0;
                    ClassRegistry::init('Jobs_company_page')->deleteAll(array('job_id' => $id));
                    foreach ($selected_company_pages_array as $company_page_id) {
                        $insert_data_0[$i]['Jobs_company_page']['job_id'] = $id;
                        $insert_data_0[$i]['Jobs_company_page']['company_id'] = $company_page_id;
                        $i++;
                    }
                    ClassRegistry::init('Jobs_company_page')->create();
                    ClassRegistry::init('Jobs_company_page')->saveAll($insert_data_0);
                }

                $insert_data_1[] = array();
                $selected_groups_array = $this->request->data('user_group');
                if (sizeof($selected_groups_array) > 0) {
                    $i = 0;
                    ClassRegistry::init('Jobs_group')->deleteAll(array('job_id' => $id));
                    foreach ($selected_groups_array as $group_id) {
                        $insert_data_1[$i]['Jobs_group']['job_id'] = $id;
                        $insert_data_1[$i]['Jobs_group']['group_id'] = $group_id;
                        $i++;
                    }
                    ClassRegistry::init('Jobs_group')->create();
                    ClassRegistry::init('Jobs_group')->saveAll($insert_data_1);
                }

                $skills = trim($this->request->data('selectedSkills'), ',');
                if ($skills) {
                    $skills = explode(',', $skills);
                    $insert_data_2[] = array();
                    $i = 0;
                    ClassRegistry::init('Jobs_skill')->deleteAll(array('job_id' => $id));
                    foreach ($skills as $skill_id) {
                        $insert_data_2[$i]['Jobs_skill']['job_id'] = $id;
                        $insert_data_2[$i]['Jobs_skill']['skill_id'] = $skill_id;
                        $i++;
                    }
                    ClassRegistry::init('Jobs_skill')->create();
                    ClassRegistry::init('Jobs_skill')->saveAll($insert_data_2);
                }

                /* $skills = $this->request->data['selectedSkills'];
                  $skills_arr = split(',', $skills);
                  $lenskills = count($skills_arr);
                  $db = ConnectionManager::getDataSource('default');
                  $db->rawQuery("DELETE FROM jobs_skills WHERE job_id=" . $id);
                  //  ClassRegistry::init('jobs_skills')->deleteAll(array('conditions' => array('job_id' => $id)));
                  $skill_data = "";
                  for ($i = 0; $i < $lenskills; $i++) {
                  $skill_data .= "('" . $id . "','" . $skills_arr[$i] . "'),";
                  }
                  $skill_data = trim($skill_data, ",");
                  $sql = "INSERT INTO jobs_skills (job_id, skill_id) VALUES " . $skill_data;
                  $db->rawQuery($sql);
                  ClassRegistry::init('jobs_skills')->deleteAll(array('skill_id' => 0)); */
                $this->Session->setFlash('Sucessfully saved changes.', 'custom_flash', array('params' => array('noty_class' => 'success')), 'recruiter_flash');
                $this->redirect(array('controller' => 'recruiter', 'action' => 'jobs'));
            } else {
                $this->Session->setFlash('Error saving job!', 'custom_flash', array('params' => array('noty_class' => 'error')), 'recruiter_flash');
            }
        } else {
            $jobs = ClassRegistry::init('jobs')->find('first', array('conditions' => array('id' => $id)));
            $countries = ClassRegistry::init('countries')->find('all', array('conditions' => array('countries.status' => '1')));
            $sCountry = ClassRegistry::init('countries')->find('first', array('conditions' => array('id' => $jobs['jobs']['country_id'])));
            $companies = ClassRegistry::init('companies')->find('all', array('conditions' => array('companies.status' => '1')));
            $qualifications = ClassRegistry::init('qualifications')->find('all', array('conditions' => array('qualifications.status' => '1'), 'order' => array('qualifications.priority', 'qualifications.title')));
            $functional_areas = ClassRegistry::init('functional_areas')->find('all', array('conditions' => array('functional_areas.status' => '1')));
            $industries = ClassRegistry::init('industries')->find('all', array('order' => array('industries.title')));
            //ClassRegistry::init('jobs_skills')->deleteAll(array('skill_id' => 0));
            $skills = ClassRegistry::init('jobs_skills')->find('all', array('fields' => array('skills.title,jobs_skills.skill_id'), 'joins' => array(array('alias' => 'skills', 'table' => 'skills', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('skills.id = jobs_skills.skill_id'))), 'conditions' => array('jobs_skills.job_id' => $id), 'order' => array('jobs_skills.id DESC'), 'limit' => 5));
            $job_types = ClassRegistry::init('job_types')->find('all');

            $Recruiter_user = ClassRegistry::init('Recruiter_user')->find('all', array(
                'fields' => array('Recruiter_user.user_id'),
                'joins' => array(
                    array('alias' => 'Company',
                        'table' => 'companies',
                        'type' => 'left',
                        'foreignKey' => false,
                        'conditions' => array('Company.id = Recruiter_user.company_id')
                    )
                ),
                'conditions' => array('Recruiter_user.company_id' => $this->company_id)
                )
            );
            $company_users = array();
            foreach ($Recruiter_user as $users) {
                $company_users[] = $users['Recruiter_user']['user_id'];
            }
            $company_users[] = $this->user_id;
            $company_users_in = join(',', $company_users);
            $company_pages = ClassRegistry::init('Company')->find('all', array('fields' => array('Company.id, Company.title'), 'conditions' => array('AND' => array('Company.flag' => 'page', "Company.user_id IN (" . $company_users_in . ")"))));
            $user_groups = ClassRegistry::init('Group')->find('all', array('fields' => array('Group.id, Group.title'), 'conditions' => array("Group.user_id IN (" . $company_users_in . ")")));
            $jobs_company_pages = ClassRegistry::init('Jobs_company_page')->find('list', array(
                'fields' => array('Jobs_company_page.company_id'),
                'conditions' => array('Jobs_company_page.job_id' => $id)
            ));
            $jobs_groups = ClassRegistry::init('Jobs_group')->find('list', array(
                'fields' => array('Jobs_group.group_id'),
                'conditions' => array('Jobs_group.job_id' => $id)
            ));
            $this->set(compact('jobs', 'countries', 'sCountry', 'companies', 'qualifications', 'functional_areas', 'industries', 'skills', 'job_types', 'company_pages', 'jobs_company_pages', 'user_groups', 'jobs_groups'));
        }
    }

    function jobs_delete($id) {
        if (ClassRegistry::init('Job')->updateAll(array('Job.status' => '-1'), array('Job.id =' => $id)))
            $this->Session->setFlash('Successfully deleted job!', 'custom_flash', array('params' => array('noty_class' => 'success')), 'recruiter_flash');
        else
            $this->Session->setFlash('Error deleting job!', 'custom_flash', array('params' => array('noty_class' => 'error')), 'recruiter_flash');
        $this->redirect(array('action' => 'jobs'));
        /* if (ClassRegistry::init('jobs')->delete($id)) {
          $this->Session->setFlash(___('Job deleted'), 'flash_message', array('plugin' => 'alaxos'));
          $this->redirect("/recruiter/jobs/");
          } else {
          $this->Session->setFlash(___('Job was not deleted'), 'flash_error', array('plugin' => 'alaxos'));
          //$this->redirect($this->referer(array('action' => 'index')));
          $this->redirect("/recruiter/jobs/");
          } */
    }
	function unassign_users($id) {
		$this->loadModel('Recruiter_user');
		if($id){
			$this->Recruiter_user->delete($id);
			$this->Session->setFlash('Successfully deleted job!', 'custom_flash', array('params' => array('noty_class' => 'success')), 'recruiter_flash');
			$this->redirect(array('action' => 'users'));
		}else{
			$this->Session->setFlash('Error deleting job!', 'custom_flash', array('params' => array('noty_class' => 'error')), 'recruiter_flash');
			$this->redirect(array('action' => 'users'));
		}
            
        
        /* if (ClassRegistry::init('jobs')->delete($id)) {
          $this->Session->setFlash(___('Job deleted'), 'flash_message', array('plugin' => 'alaxos'));
          $this->redirect("/recruiter/jobs/");
          } else {
          $this->Session->setFlash(___('Job was not deleted'), 'flash_error', array('plugin' => 'alaxos'));
          //$this->redirect($this->referer(array('action' => 'index')));
          $this->redirect("/recruiter/jobs/");
          } */
    }
    function downloadcv($id) {
        //$url = JOBS_URL.'/files/resume/'.$id;
        //file($url);
        //echo $url;
        //$data= file_get_contents($url);

        var_dump($data);

        set_time_limit(60);

        $url = JOBS_URL . '/files/resume/' . $id;
        $file = basename($url);
        if (file_exists($file)) {

            $fp = fopen($file, 'w');

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_FILE, $fp);

            $data = curl_exec($ch);

            curl_close($ch);
            fclose($fp);

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        } else {

            $this->redirect('jobApplications');
        }
    }

    function plans() {
        //$plans = ClassRegistry::init('plans')->find('all', array('conditions' => array('type' => 'recruiters')));
        //$plans = ClassRegistry::init('plans')->find('all',
        $this->loadModel('Plan');
        $this->loadModel('Plans_feature');
        $this->loadModel('Plans_features_masters');
        //$plans = $this->Plan->query('SELECT PL.*,PF.plan_id,PF.feature_id,PF.value, PFM.id, PFM.title FROM plans, plans_features, plans_features_masters AS PL LEFT JOIN plans_features AS PF ON (PL.id=PF.plan_id) LEFT JOIN plans_features_masters AS PFM ON (PFM.id=PF.plan_id) WHERE PL.type = "recruiters" AND PL.id = PF.plan_id AND PFM.id = PF.feature_id');
        //$plans = $this->Plan->query('SELECT PF.*, PFM.id, PFM.title, PL.id, PL.title, PL.price, PL.yearly_discount_percentage FROM plans AS PL LEFT JOIN plans_features AS PF ON (PL.id=PF.plan_id) LEFT JOIN plans_features_masters AS PFM ON (PFM.id=PF.feature_id) WHERE PL.type = "recruiters"');
        $plans = $this->Plan->query('SELECT PF.*, PFM.id, PFM.title, PL.id, PL.title, PL.price, PL.yearly_discount_percentage FROM plans_features AS PF LEFT JOIN plans_features_masters AS PFM ON (PFM.id = PF.feature_id) LEFT JOIN plans AS PL ON (PL.id = PF.plan_id) WHERE PL.type = "recruiters"');
        // echo "<pre>";  print_r($plans); echo "</pre>";
        //  exit;
        $current_plan_id = 0;
        $idx = -1;
        $fidx = 0;
        // $final_plans = array();
        foreach ($plans as $value) {
            if ($current_plan_id != $value["PF"]["plan_id"]) {
                $idx++;
                $final_plans[$idx]["plan_id"] = $value["PF"]["plan_id"];
                $final_plans[$idx]["plan_title"] = $value["PL"]["title"];
                $final_plans[$idx]["month_price"] = $value["PL"]["price"];
                $final_plans[$idx]["year_price"] = $value["PL"]["price"] * 12 * $value["PL"]["yearly_discount_percentage"] / 100;

                $final_plans[$idx]["features"][$fidx]["id"] = $value["PFM"]["id"];
                $final_plans[$idx]["features"][$fidx]["feature_title"] = $value["PFM"]["title"];
                $final_plans[$idx]["features"][$fidx]["value"] = $value["PF"]["value"];
                $current_plan_id = $value["PF"]["plan_id"];
            } else {

                $final_plans[$idx]["features"][$fidx]["id"] = $value["PFM"]["id"];
                $final_plans[$idx]["features"][$fidx]["feature_title"] = $value["PFM"]["title"];
                $final_plans[$idx]["features"][$fidx]["value"] = $value["PF"]["value"];
            }
            $fidx++;
        }
//        echo "<pre>";  print_r($final_plans); echo "</pre>";
//        exit;

        $this->set('plans', $final_plans);
    }

    function checkout($type = NULL, $id = NULL) {
        if (strtolower($type) == 'm') {

            //$plans = ClassRegistry::init('plans')->find('all', array('conditions' => array('type' => 'recruiters')));
            //$plans = ClassRegistry::init('plans')->find('all',
            $this->loadModel('Plan');
            $this->loadModel('Plans_feature');
            $this->loadModel('Plans_features_masters');
            //$plans = $this->Plan->query('SELECT PL.*,PF.plan_id,PF.feature_id,PF.value, PFM.id, PFM.title FROM plans, plans_features, plans_features_masters AS PL LEFT JOIN plans_features AS PF ON (PL.id=PF.plan_id) LEFT JOIN plans_features_masters AS PFM ON (PFM.id=PF.plan_id) WHERE PL.type = "recruiters" AND PL.id = PF.plan_id AND PFM.id = PF.feature_id');
            //$plans = $this->Plan->query('SELECT PF.*, PFM.id, PFM.title, PL.id, PL.title, PL.price, PL.yearly_discount_percentage FROM plans AS PL LEFT JOIN plans_features AS PF ON (PL.id=PF.plan_id) LEFT JOIN plans_features_masters AS PFM ON (PFM.id=PF.feature_id) WHERE PL.type = "recruiters"');
            $plans = $this->Plan->query('SELECT PF.*, PFM.id, PFM.title, PL.id, PL.title, PL.price, PL.yearly_discount_percentage FROM plans_features AS PF LEFT JOIN plans_features_masters AS PFM ON (PFM.id = PF.feature_id) LEFT JOIN plans AS PL ON (PL.id = PF.plan_id) WHERE PL.type = "recruiters" AND PL.id = ' . $id);
            // echo "<pre>";  print_r($plans); echo "</pre>";
            //  exit;
            $current_plan_id = 0;
            $idx = -1;
            $fidx = 0;
            // $final_plans = array();
            foreach ($plans as $value) {
                if ($current_plan_id != $value["PF"]["plan_id"]) {
                    $idx++;
                    $final_plans[$idx]["plan_id"] = $value["PF"]["plan_id"];
                    $final_plans[$idx]["plan_title"] = $value["PL"]["title"];
                    $final_plans[$idx]["month_price"] = $value["PL"]["price"];
                    $final_plans[$idx]["year_price"] = $value["PL"]["price"] * 12 * $value["PL"]["yearly_discount_percentage"] / 100;

                    $final_plans[$idx]["features"][$fidx]["id"] = $value["PFM"]["id"];
                    $final_plans[$idx]["features"][$fidx]["feature_title"] = $value["PFM"]["title"];
                    $final_plans[$idx]["features"][$fidx]["value"] = $value["PF"]["value"];
                    $current_plan_id = $value["PF"]["plan_id"];
                } else {

                    $final_plans[$idx]["features"][$fidx]["id"] = $value["PFM"]["id"];
                    $final_plans[$idx]["features"][$fidx]["feature_title"] = $value["PFM"]["title"];
                    $final_plans[$idx]["features"][$fidx]["value"] = $value["PF"]["value"];
                }
                $fidx++;
            }
//        echo "<pre>";  print_r($final_plans); echo "</pre>";
//        exit;

            $this->set('plans', $final_plans);
            $this->set('plan_period', $type);
            $this->set('plan_id', $id);
            $this->set('price', $final_plans[0]['month_price']);
        }



        if (strtolower($type) == 'y') {


            //$plans = ClassRegistry::init('plans')->find('all', array('conditions' => array('type' => 'recruiters')));
            //$plans = ClassRegistry::init('plans')->find('all',
            $this->loadModel('Plan');
            $this->loadModel('Plans_feature');
            $this->loadModel('Plans_features_masters');
            //$plans = $this->Plan->query('SELECT PL.*,PF.plan_id,PF.feature_id,PF.value, PFM.id, PFM.title FROM plans, plans_features, plans_features_masters AS PL LEFT JOIN plans_features AS PF ON (PL.id=PF.plan_id) LEFT JOIN plans_features_masters AS PFM ON (PFM.id=PF.plan_id) WHERE PL.type = "recruiters" AND PL.id = PF.plan_id AND PFM.id = PF.feature_id');
            //$plans = $this->Plan->query('SELECT PF.*, PFM.id, PFM.title, PL.id, PL.title, PL.price, PL.yearly_discount_percentage FROM plans AS PL LEFT JOIN plans_features AS PF ON (PL.id=PF.plan_id) LEFT JOIN plans_features_masters AS PFM ON (PFM.id=PF.feature_id) WHERE PL.type = "recruiters"');
            $plans = $this->Plan->query('SELECT PF.*, PFM.id, PFM.title, PL.id, PL.title, PL.price, PL.yearly_discount_percentage FROM plans_features AS PF LEFT JOIN plans_features_masters AS PFM ON (PFM.id = PF.feature_id) LEFT JOIN plans AS PL ON (PL.id = PF.plan_id) WHERE PL.type = "recruiters" AND PL.id = ' . $id);
            // echo "<pre>";  print_r($plans); echo "</pre>";
            //  exit;
            $current_plan_id = 0;
            $idx = -1;
            $fidx = 0;
            // $final_plans = array();
            foreach ($plans as $value) {
                if ($current_plan_id != $value["PF"]["plan_id"]) {
                    $idx++;
                    $final_plans[$idx]["plan_id"] = $value["PF"]["plan_id"];
                    $final_plans[$idx]["plan_title"] = $value["PL"]["title"];
                    $final_plans[$idx]["month_price"] = $value["PL"]["price"];
                    $final_plans[$idx]["year_price"] = $value["PL"]["price"] * 12 * $value["PL"]["yearly_discount_percentage"] / 100;

                    $final_plans[$idx]["features"][$fidx]["id"] = $value["PFM"]["id"];
                    $final_plans[$idx]["features"][$fidx]["feature_title"] = $value["PFM"]["title"];
                    $final_plans[$idx]["features"][$fidx]["value"] = $value["PF"]["value"];
                    $current_plan_id = $value["PF"]["plan_id"];
                } else {

                    $final_plans[$idx]["features"][$fidx]["id"] = $value["PFM"]["id"];
                    $final_plans[$idx]["features"][$fidx]["feature_title"] = $value["PFM"]["title"];
                    $final_plans[$idx]["features"][$fidx]["value"] = $value["PF"]["value"];
                }
                $fidx++;
            }
//        echo "<pre>";  print_r($final_plans); echo "</pre>";
//        exit;

            $this->set('plans', $final_plans);
            $this->set('plan_period', $type);
            $this->set('plan_id', $id);
            $this->set('price', $final_plans[0]['year_price']);
        }
    }

    function candidates($job_id) {
        $profile = ClassRegistry::init('Job')->get_matching_profiles($job_id);
        $this->set('candidate', $profile);
    }

    function user_search_ajax() {
        $this->layout = $this->autoRender = false;
        if ($this->request->is('get')) {
            $name = $this->request->params['named']['name'];
            $sql = "SELECT
                        US.id , UP.user_id , CONCAT(UP.firstname,' ',UP.lastname) fullname, US.role_id, UP.photo
                    FROM
                        users US LEFT JOIN users_profiles UP ON (US.id = UP.user_id)
                    WHERE
                        CONCAT(UP.firstname,' ',UP.lastname) LIKE '{$name}%'
                    ORDER BY
                    CONCAT(UP.firstname,' ',UP.lastname) ASC
                    LIMIT 10;";
            $user = ClassRegistry::init('User')->query($sql);
            $data = '<ul class="nav nav-list"><li class="nav-header"><h4>Users List</h4></li>';
            foreach ($user as $u) {
                if (empty($u['UP']['photo']) || !file_exists(MEDIA_PATH . '/files/user/icon/' . $u['UP']['photo']))
                    $profile_pic = '/img/nophoto.jpg';
                else
                    $profile_pic = '/files/user/icon/' . $u['UP']['photo'];
                //$data .= '<li class="divider"><li><img width="50" hieght="50" class="pull-left" src="'.MEDIA_URL . $profile_pic.'"/><span class="span9">' . $u[0]['fullname'] . '</span><a href="'.NETWORKWE_URL.'/recruiter/assignUser/'.$u['US']['id'].'" class="btn btn-small pull-right">Assign</a><br class="clear" /></li></li>';
                $data .= '<li class="divider"><li id="user-' . $u['US']['id'] . '"><img width="50" hieght="50" class="pull-left" src="' . MEDIA_URL . $profile_pic . '"/><span class="span9">' . $u[0]['fullname'] . '</span><a href="javascript:;" onclick="assign_user(\'' . $u['US']['id'] . '\')" class="btn btn-small pull-right">Assign</a><br class="clear" /></li></li>';
            }
            $data .= '</ul>';
            //header('Content-Type: application/json');
            //echo json_encode($user);
            echo $data;
        }
    }

    function assign_user() {
        /*
         * @author: Danish Backer
         * @date: 28-04-2014
         * @purpose: assign user to recruiter account.
         */
        $this->layout = $this->autoRender = false;
        $userid = $this->request->params['named']['id'];
        $isUnique = ClassRegistry::init('Recruiter_user')->isIdUnique($userid, $this->company_id);
        if ($isUnique) {
            $res = ClassRegistry::init('Recruiter_user')->create_record($userid, $this->company_id, 2);
            $output = ($res) ? 'true' : 'false';
        } else {
            $output = 'false';
        }
        header('Content-Type: application/json');
        echo json_encode($output);
    }

    public function view_user($user_id) {
        /*
         * @author: Danish Backer
         * @date: 30-04-2014
         * @purpose: Display user profile for employer.
         */
        $this->autoRender = false;
        $profile = ClassRegistry::init('Users_profile')->get_profiles($user_id);
        $experience = ClassRegistry::init('Users_experience')->get_user_experience($user_id);
        $education = ClassRegistry::init('Users_qualification')->get_qualification($user_id);
        $skills = ClassRegistry::init('Skill')->get_user_skills($user_id);
        $this->set(compact('profile', 'experience', 'education', 'skills'));
        $this->render('/Recruiter/view_user');
    }

    public function testfn() {
        Configure::write('debug', 2);
        /*
         * @author: Danish Backer
         * @date: 27-04-2014
         * @purpose: testing-to be deleted.
         */


        //App::uses('ShorturlHelper', 'Helper');
        //App::uses('View', 'View');
        //$ShorturlHelper = new ShorturlHelper(new View(null));
        //print_r($ShorturlHelper);
        //print_r($this->Shorturl->testFunction('hello'));
        //print_r($this->helpers->Shorturl);
        //print_r($this->helpers['Shorturl']);
        //print_r($this->Shorturl->testFunction('hello'));
        //exit;

        /*
         * URL Shortener
         */
        /* $apiKey = 'AIzaSyBveS6MYuQtdxyaeDPy6-yKbdCJkPVai8Q';
          $longUrl = 'https://developers.google.com/url-shortener/';
          $postData = array('longUrl' => $longUrl, 'key' => $apiKey);
          App::uses('Urlshorten', 'Lib');
          $urlshorten = new Urlshorten();
          $shortUrl = $urlshorten->httpsPost($postData);
          if($shortUrl != null) {
          echo "Short URL is : ".$shortUrl->id."\n";
          } */

        /*
         * Facebook Share
         */
        //$login_email = '132@gulfbankers.com';
        //$login_pass = 'Db#GF2011';
        App::import('Vendor', 'Facebook/facebook');
        $facebook = new Facebook(array(
            'appId' => FB_APP_ID,
            'secret' => FB_APP_SECRET,
        ));
        /* $facebook = new Facebook(array(
          'appId'  => "703402656383887",
          'secret' => "e8b6d731f81bd6232605cf11bc3388ed",
          )); */
        /* $facebook = new Facebook(array(
          'appId'  => '703718799685606',
          'secret' => 'e5c9d4a5e3ceec028feee84974972611',
          )); */

        $user = $facebook->getUser();
        print_r($user);
        echo 'before try';
        if ($user) {
            try {
                echo '1st try';
                // Proceed knowing you have a logged in user who's authenticated.
                //$user_profile = $facebook->api('/me');
                $user_profile = $facebook->api('/237158053100688');
                /* $facebook->api('/752403294791990/feed/', 'post', array(
                  //'picture'=>'http://media.networkwe.com/files/user/logo/003101DSC03314.JPG',
                  //'description'=>'testing my description',
                  //'link' => 'www.ebankingcareers.com/jobsd-4442-manager-research-and-studies.html',
                  'message' => 'I want to display this message on my wall'
                  )); */
                try {
                    echo '2nd try';
                    $statusUpdate = $facebook->api('/752403294791990/feed', 'post', array('name' => 'Danish Backer', 'message' => 'My Wall post',
                        'privacy' => array('value' => 'CUSTOM', 'friends' => 'SELF'),
                        'description' => 'testing my description',
                        'picture' => 'http://media.networkwe.com/files/user/logo/003101DSC03314.JPG',
                        'caption' => 'networkwe.com/pub/danishbacker', 'link' => 'http://www.networkwe.com/pub/danishbacker'));
                    print_r($statusUpdate);
                } catch (FacebookApiException $e) {
                    echo '<pre>' . htmlspecialchars(print_r($e, true)) . '</pre>';
                    //$user = null;
                }
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = null;
            }
        }

        if ($user) {
            $logoutUrl = $facebook->getLogoutUrl();
        } else {
            //$statusUrl = $facebook->getLoginStatusUrl();
            $loginUrl = $facebook->getLoginUrl(array(
                'scope' => 'publish_stream,publish_actions',
                'redirect_uri' => NETWORKWE_URL . '/recruiter/'
                    //'redirect_uri' => 'http://danish.networkwe.net/recruiter/testfn/'
            ));
        }

        $this->set(compact('user', 'logoutUrl', 'loginUrl', 'user_profile'));
        exit;
        /*
         * Twitter Share
         */
        //App::import('Vendor', 'Twitter/codebird');

        $API_key = TW_API_KEY;
        $API_secret = TW_API_SECRET;
        $Access_token = TW_ACCESS_TOKEN;
        $Access_token_secret = TW_ACCESS_TOKEN_SECRET;

        /* $API_key = "MZgpgcCZnp18Eg7fX2qwilc9G";
          $API_secret = "NakTk6WONiafZrQgpYxFWkkFCreEOH1wVO2JgYtr4x6b85VXaX";
          $Access_token = "22629539-3yyHCgs9ukaw9AyWM6LJo7W5XDCMIUpUxw5yox7JZ";
          $Access_token_secret = "YS6FQ9UO6tTfE2RIn8RRTpfAuwTAW58jCY0IpvbbfRDMM"; */

        /* \Codebird\Codebird::setConsumerKey($API_key, $API_secret);
          $cb = \Codebird\Codebird::getInstance();
          $cb->setToken($Access_token, $Access_token_secret);

          $params = array(
          'status' => 'Auto Post on Twitter with PHP http://goo.gl/OZHaQD #php #twitter'
          );
          $reply = $cb->statuses_update($params); */

        //$this->layout = $this->autoRender = false;
        //pr($reply);exit;

        $this->render('/Recruiter/testfn');
    }

    function getFirstprofileId(&$analytics) {
        $accounts = $analytics->management_accounts->listManagementAccounts();

        if (count($accounts->getItems()) > 0) {
            $items = $accounts->getItems();
            $firstAccountId = $items[0]->getId();

            $webproperties = $analytics->management_webproperties
                    ->listManagementWebproperties($firstAccountId);

            if (count($webproperties->getItems()) > 0) {
                $items = $webproperties->getItems();
                $firstWebpropertyId = $items[0]->getId();

                $profiles = $analytics->management_profiles
                        ->listManagementProfiles($firstAccountId, $firstWebpropertyId);

                if (count($profiles->getItems()) > 0) {
                    $items = $profiles->getItems();
                    return $items[0]->getId();
                } else {
                    throw new Exception('No views (profiles) found for this user.');
                }
            } else {
                throw new Exception('No webproperties found for this user.');
            }
        } else {
            throw new Exception('No accounts found for this user.');
        }
    }

    function __runMainDemo(&$analytics) {
        $this->layout = $this->autoRender = false;
        try {

            // Step 2. Get the user's first view (profile) ID.
            $profileId = getFirstProfileId($analytics);

            if (isset($profileId)) {

                // Step 3. Query the Core Reporting API.
                $results = getResults($analytics, $profileId);

                // Step 4. Output the results.
                printResults($results);
            }
        } catch (apiServiceException $e) {
            // Error from the API.
            print 'There was an API error : ' . $e->getCode() . ' : ' . $e->getMessage();
        } catch (Exception $e) {
            print 'There wan a general error : ' . $e->getMessage();
        }
    }

    public function tempfn($code = '') {
        Configure::write('debug', 2); echo 'HelloAnalyticsApi';
        $this->layout = $this->autoRender = false;
        
        
        
        App::import('Vendor', 'Google/Google_Client');
        App::import('Vendor', 'Google/contrib/Google_AnalyticsService');
        
        //require_once '../../src/Google_Client.php';
        //require_once '../../src/contrib/Google_AnalyticsService.php';
        //session_start();

        $client = new Google_Client();
        $client->setApplicationName("Google Analytics PHP Starter Application");

        $client->setClientId(Configure::read('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(Configure::read('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(Configure::read('GOOGLE_REDIRECT_URI'));
        $client->setDeveloperKey(Configure::read('GOOGLE_API_KEY_NEW'));
        $service = new Google_AnalyticsService($client);
        

        if (isset($_GET['logout'])|| $this->request->query('logout') === 1) {
            unset($_SESSION['token']);
        }
        //pr($service);
        
        $code = $this->request->query('code');
        if (isset($code)) { echo 'here';
            $client->authenticate();
            //pr($client->getAccessToken());
            $_SESSION['token'] = $client->getAccessToken();
            $redirect = NETWORKWE_URL . '/recruiter/tempfn/';
            //$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            //header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
            $access_token = $client->getAccessToken();
            $this->redirect($redirect);
            
        }
pr($client->getAccessToken());
        //if (isset($_SESSION['token'])) {
        if($access_token){
            /*$google_token = json_decode($_SESSION['access_token']);
            $client->refreshToken($google_token->refresh_token);
            $_SESSION['access_token'] = $client->getAccessToken();*/
            $client->setAccessToken($_SESSION['token']);
            
            $accounts = $service->management_accounts->listManagementAccounts();
            pr($accounts);
        }

        if ($client->getAccessToken()) {
            $props = $service->management_webproperties->listManagementWebproperties("~all");
            echo "<h1>Web Properties</h1><pre>" . print_r($props, true) . "</pre>";

            $accounts = $service->management_accounts->listManagementAccounts();
            echo "<h1>Accounts</h1><pre>" . print_r($accounts, true) . "</pre>";

            $segments = $service->management_segments->listManagementSegments();
            echo "<h1>Segments</h1><pre>" . print_r($segments, true) . "</pre>";

            $goals = $service->management_goals->listManagementGoals("~all", "~all", "~all");
            echo "<h1>Segments</h1><pre>" . print_r($goals, true) . "</pre>";

            $_SESSION['token'] = $client->getAccessToken();
        } else {
            $authUrl = $client->createAuthUrl();
            echo "<a class='login' href='$authUrl'>Connect Me!</a>";
        }
        
        $this->render('/Recruiter/testfn');
    }
    
    public function mynewfn(){
        //https://github.com/alecho/GoogleAnalytics
        Configure::write('debug', 2);
        //$this->layout = $this->autoRender = false;
        //$this->loadModel('GoogleAnalytics.GoogleAnalyticsAccount');
        $this->loadModel('GoogleAnalytics.GoogleAnalyticsAccount');
        //$this->loadModel('GoogleAnalyticsAccount');
        $test = $this->GoogleAnalyticsAccount->find('all');
        
        pr($test);
        //$this->render('/Recruiter/testfn');
    }

    public function HelloAnalyticsApi1() {
        Configure::write('debug', 2);
        $this->layout = $this->autoRender = false;
        /*
         * https://developers.google.com/analytics/solutions/articles/hello-analytics-api#authorize_access
         * https://console.developers.google.com/project/751065884371/apiui/credential
         * https://github.com/google/google-api-php-client
         * https://code.google.com/apis/ajax/playground/?type=visualization#column_chart
         * https://developers.google.com/chart/interactive/docs/examples
         * http://stackoverflow.com/questions/21024672/php-google-analytics-api-simple-example
         * http://www.highcharts.com/demo
         */


        /* App::import('Vendor', 'Google/facebook');
          $facebook = new Facebook(array(
          'appId'  => FB_APP_ID,
          'secret' => FB_APP_SECRET,
          )); */
        //require_once 'Google/Client.php';
        //require_once 'Google/Service/Analytics.php';
        App::import('Vendor', 'Google/Google_Client.php');
        App::import('Vendor', 'Google/contrib/Google_AnalyticsService.php');
        //echo Configure::read('GOOGLE_JAVASCRIPT_ORIGINS');


        $client = new Google_Client();
        $client->setApplicationName('Hello Analytics API Sample');

        // Visit https://console.developers.google.com/ to generate your
        // client id, client secret, and to register your redirect uri.

        $client->setClientId(Configure::read('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(Configure::read('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(Configure::read('GOOGLE_REDIRECT_URI'));
        $client->setDeveloperKey(GOOGLE_API_KEY);
        $client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));

        // Magic. Returns objects from the Analytics Service instead of associative arrays.
        $client->setUseObjects(true);

        //$analytics = new apiAnalyticsService($client);
        //$this->__runMainDemo($analytics);


        /* if (isset($_GET['code'])) {
          $client->authenticate();
          $_SESSION['token'] = $client->getAccessToken();
          $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
          header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
          }
          if (isset($_SESSION['token'])) {
          $client->setAccessToken($_SESSION['token']);
          }

          if (!$client->getAccessToken()) {
          $authUrl = $client->createAuthUrl();
          echo "<a class='login' href='$authUrl'>Connect Me!</a>";
          } else {
          // Create analytics service object. See next step below.
          $analytics = new apiAnalyticsService($client);
          $this->__runMainDemo($analytics);
          pr($analytics);
          } */
//echo Configure::read('GOOGLE_JAVASCRIPT_ORIGINS');
        /* $client = new Google_Client();
          $client->setApplicationName("networkwe-dan");
          $client->setDeveloperKey("459602403818-qeu228dm091igc4ha3hvuo1jm18k2ad0.apps.googleusercontent.com"); //security measures
          $service = new Google_Service_Analytics($client);

          $results = $service->data_ga; */

        echo '<pre>';
        pr($client);
        echo '</pre>';


        $this->render('/Recruiter/testfn');
    }

    public function clear_cache() {
        /*
         * @author  :   Danish Backer
         * @date    :   21-05-2014
         * @pupose  :   Clear cache files
         */

        Configure::write('debug', 2);
        header('Content-Type: text/plain');
        $pwd = '/home/nwenet/public_html/subdomains/danish/app/tmp/cache/';
        echo 'PWD:' . $pwd . PHP_EOL . "#models" . PHP_EOL;
        $dir_models = new Folder($pwd . 'models');
        $files_models = $dir_models->find('.*');
        foreach ($files_models as $file) {
            $f = new File($dir_models->pwd() . DS . $file, false, 0777);
            echo 'Deleting file ' . $file . ' => ';
            echo ($f->delete()) ? 'true' : 'false';
            //echo $contents = $file->read();
            // $file->write('I am overwriting the contents of this file');
            // $file->append('I am adding to the bottom of this file.');
            // $file->delete(); // I am deleting this file
            $f->close();
            echo PHP_EOL;
        }
        echo '#persistent' . PHP_EOL;
        $dir = new Folder($pwd . 'persistent');
        $files = $dir->find('.*');
        foreach ($files as $file) {
            $f = new File($dir->pwd() . DS . $file, false, 0777);
            //chown($dir_models->pwd() . DS . $file,465);
            echo 'Deleting file ' . $file . ' => ';
            //unlink($dir->pwd() . DS . $file);
            echo ($f->delete()) ? 'true' : 'false';
            //$file->close();
            echo PHP_EOL;
        }
        $this->layout = $this->autoRender = false;
    }

}

