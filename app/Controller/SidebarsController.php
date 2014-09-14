<?php	
class SidebarsController extends AppController {
    var $helpers = array('Form', 'html');
    var $components = array('Auth');
	var $uses = array('User');
    function beforeFilter() {
		parent::beforeFilter();
	
		$this->Auth->allow();
		switch ($this->request->params['action']) {
			case 'index':
			case 'admin_index':
		}
    }					  
	
	public function user_activities() {
		
		$this->params['pass'];
		
		$paramenter = $this->params['pass'];
		
		$para = $paramenter[0];
		
		$uid = $this->userInfo['users']['id'];
		
		$friends_Lists =$this->getCurrentUserFriends($uid);
		
		$this->loadModel('Sidebar');
		
		if ($para == 'birthday') {
			
			$your_birthday_message = $this->Sidebar->yourBirthDayMessages($uid);
			
			$this->set('your_birthday_message',$your_birthday_message);
			
			$user_birthday = $this->Sidebar->usersHaveBirthdays($friends_Lists);
			
			$this->set('user_birthday',$user_birthday);

			$user_birthday_message = $this->Sidebar->usersBirthdayMessages();
			
			$this->set('user_birthday_message',$user_birthday_message);
			
		}
		$this->autorender = false;
		$this->layout = false;
		$this->render('user_activities');
		
	}
	
	public function related_jobs() {
		
		$this->params['pass'];
		
		$paramenter = $this->params['pass'];
		
		$para = $paramenter[0];
		
		if ($para == 'job') {
			
			$uid =  $this->userInfo['users']['id'];
			
			$user_Profile = $this->getCurrentUser($uid);
			
			$this->loadModel('Sidebar');
			
			$city = $user_Profile['city'];
			
			$user_country_id = $user_Profile['country_id'];
			
			$user_Job_List = $this->Sidebar->userRelatedJobs($user_country_id,$city);
			
			$this->set('user_Job_List',$user_Job_List);
		
			$this->autorender = false;
			$this->layout = false;
			$this->render('related_jobs');
		}
	}
	
	public function known_people() {
		
			$this->params['pass'];
			
			$paramenter = $this->params['pass'];
			
			$para = $paramenter[0];
			
			if ($para == '2ndlevel') {
				
				$uid =  $this->userInfo['users']['id'];
				
				$user_Profile = $this->getCurrentUser($uid);
				
				$city = $user_Profile['city'];
				
				$friends_Lists =$this->getCurrentUserFriends($uid);
				
				$this->loadModel('Sidebar');
				
				$colse_Friends_toUser = $this->Sidebar->getCloseUserFriends($uid,$friends_Lists,$city);
				
				$this->set('colse_Friends_toUser',$colse_Friends_toUser);
				
				$get_user_connection_st = $this->Sidebar->getConnectionsStatus($uid);
				
				$this->set('get_user_connection_st',$get_user_connection_st);
				
				$this->autorender = false;
				$this->layout = false;
				$this->render('known_people');
			}
				
		}
	
	
	public function view_profile() {
		
			$this->params['pass'];
			
			$paramenter = $this->params['pass'];
			
			$para = $paramenter[0];
			
			if ($para == 'viewprofile') {
				
				$uid =  $this->userInfo['users']['id'];
				
				$this->loadModel('Sidebar');
				
				$get_view_profile = $this->Sidebar->get_viewed_profiles($uid);
				
				$this->set('get_view_profile',$get_view_profile);
				
				$this->autorender = false;
				$this->layout = false;
				$this->render('view_profile');
			}
			
		}
	
	public function profile_strength() {
		
			$this->params['pass'];
			
			$paramenter = $this->params['pass'];
			
			$para = $paramenter[0];
			
			if ($para == 'strenght') {
				
				$uid =  $this->userInfo['users']['id'];
				
				$this->loadModel('Sidebar');
				
				$profile_strength = $this->Sidebar->getUserProfileStrength($uid);
				
				$this->set('profile_strength_user',$profile_strength);
				
				$this->autorender = false;
				$this->layout = false;
				$this->render('profile_strength');
				
			}
		
	}
	
	public function profile_performance() {
		
			$this->params['pass'];
			
			$paramenter = $this->params['pass'];
			
			$para = $paramenter[0];
			
			if ($para == 'performance') {
				
				$uid =  $this->userInfo['users']['id'];
				
				$this->loadModel('Sidebar');
				
				$get_total_view_profile = $this->Sidebar->get_total_viewed_profiles($uid);
				
				$this->set('get_total_view_profile',$get_total_view_profile);
				
				$this->autorender = false;
				$this->layout = false;
				$this->render('profile_performance');
			}
	}
	
	public function want_to_follow_company() {
		
			$this->params['pass'];
			
			$paramenter = $this->params['pass'];
			
			$para = $paramenter[0];
			
			if ($para == 'companies') {
				
				$uid =  $this->userInfo['users']['id'];
				
				$user_Profile = $this->getCurrentUser($uid);
			
				$this->loadModel('Sidebar');
			
				$city = $user_Profile['city'];
				
				$friends_Lists =$this->getCurrentUserFriends($uid);
				
				$user_related_companies = $this->Sidebar->getRelatedCompanies($uid,$friends_Lists,$user_Profile['city']);
				
				$this->set('user_related_companies',$user_related_companies);
				
				$your_following_company = $this->Sidebar->get_ur_following_company($uid);
				
				$this->set('your_following_company',$your_following_company);
						
				$this->autorender = false;
				$this->layout = false;
				$this->render('want_to_follow_company');
				
			}
		
	}
	
	public function may_like_groups() {
		
			$this->params['pass'];
			
			$paramenter = $this->params['pass'];
			
			$para = $paramenter[0];
			
			if ($para == 'groups') {
				
				$uid =  $this->userInfo['users']['id'];
				
				$this->loadModel('Sidebar');
				
				$user_related_groups = $this->Sidebar->getRelatedGroups($uid);
				
				$this->set('user_related_groups',$user_related_groups);
				
				$user_joined_groups = $this->Sidebar->getUserJoinedGroups($uid);
				
				$this->set('user_joined_groups',$user_joined_groups);
				
				$this->autorender = false;
				$this->layout = false;
				$this->render('may_like_groups');
				
			}
	}
	
	public function tweets_networkwe() {
		
			$this->params['pass'];
			
			$paramenter = $this->params['pass'];
			
			$para = $paramenter[0];
			
			if ($para == 'tweets') {
				
				$this->loadModel('Sidebar');
				
				$uid = $this->userInfo['users']['id'];
				
				$friends_List =$this->getCurrentUserFriends($uid);
				
				$get_tweets = $this->Sidebar->tweets_networkwe($friends_List,$uid);
				
				$this->set('get_tweets',$get_tweets);
				
				$get_retweeted = $this->Sidebar->tweets_retweeted();
				
				$this->set('get_retweeted',$get_retweeted);
				
				$this->autorender = false;
				$this->layout = false;
				$this->render('tweets_networkwe');
			}
		
	}
	
	public function get_latest_posts() {
		
			$this->params['pass'];
			
			$paramenter = $this->params['pass'];
			
			$para = $paramenter[0];
			
			if ($para == 'blogs') {
				
				$this->loadModel('Sidebar');
				
				$get_latest_posts_networkwe = $this->Sidebar->get_latest_posts();
				
				$this->set('get_latest_posts_networkwe',$get_latest_posts_networkwe);
				
				$this->autorender = false;
				$this->layout = false;
				$this->render('blogs_networkwe');
				
			}
		
		
	}
	public function get_users_news() {
		
			$this->params['pass'];
			
			$paramenter = $this->params['pass'];
			
			$para = $paramenter[0];
			$uid = $this->userInfo['users']['id'];
			if ($para == 'news') {
				
				$this->loadModel('News');
				
				$get_news_draft = $this->News->find('all',array('conditions' => array('News.publish=0','News.user_id='.$uid), 'order' => 'News.id DESC', 'limit' => 6));
				$this->set('news_draft', $get_news_draft);
						
				$get_news_list = $this->News->find('all',array('conditions' => array('News.publish=1','News.user_id='.$uid), 'order' => 'News.id DESC', 'limit' => 6));
				$this->set('news_lists', $get_news_list);
				
				$count_published = $this->News->find('count',array('conditions' => array('News.publish=1','News.user_id='.$uid)));
				$count_draft = $this->News->find('count',array('conditions' => array('News.publish=0','News.user_id='.$uid)));
				$this->set(compact('count_published','count_draft'));
				$topviewednews = ClassRegistry::init('users_viewings')->find('all',array(
																		'fields'=>array('users_viewings.id,users_viewings.viewings_id,users_viewings.viewings_type,users_viewings.viewings_counts,topnews.id,topnews.heading'),
																		'joins'=>array(array('alias'=>'topnews','table'=>'news','conditions'=>'topnews.id=users_viewings.viewings_id')),
																		'conditions'=>array('users_viewings.viewings_type="news"'),'order'=>'users_viewings.viewings_counts DESC','limit'=>10));
		
				$this->set('topviewednews', $topviewednews);
				$this->autorender = false;
				$this->layout = false;
				$this->render('news_networkwe');
				
				
			}
		
		
	}
}
 ?>