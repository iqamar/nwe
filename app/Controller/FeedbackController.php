<?php
Class FeedbackController extends AppController{
    
    function beforeFilter() {
	parent::beforeFilter();


	$this->Auth->allow();
	switch ($this->request->params['action']) {
	    case 'index':
	    case 'admin':
		$this->Security->validatePost = false;
	}
    }
    
    function index(){
        App::uses('CakeEmail', 'Network/Email');
        if($this->request->is('post')){
            $userID = $this->Session->read(@$userid);
            
            $formData = array(
                'firstname' => ucfirst($this->request->data('firstname')),
                'lastname' => ucfirst($this->request->data('lastname')),
                'email' => $this->request->data('email'),
                'user_id' => $userID['userid'],
                'description' => $this->request->data('description'),
                'subject' => $this->request->data('subject')
            );
            if($formData['firstname'] == NULL || $formData['lastname'] == NULL || $formData['email'] == NULL || $formData['description'] == NULL){
              $this->redirect('/feedback');  
            }
        else{
            if(ClassRegistry::init('feedback')->validates(array('fieldlist' => array('firstname', 'lastname', 'email', 'description')))){
                ClassRegistry::init('feedback')->save($formData);
                $email = new CakeEmail();
                $email->emailFormat('html');
                $email->from('118@gulfbankers.com');
                //$email->to($formData['email']);
                $email->to('info@networkwe.com');
                $email->subject('NetworkWE Feedback');
                $message = "Name: {$formData['firstname']} {$formData['lastname']}<br>"
                . "Email: {$formData['email']} <br>"
                . "Description: <br>"
                        . "{$formData['description']}";
                        
                $email->send($message);
                $this->Session->setFlash('Thank You, your feedback has been submitted and we will respond to you shortly.');
                
            }
            else{
                $this->Session->setFlash('Error submbitting your feedback, please check again.');
            }
        }
        }
        
        
  
}

function admin_index(){
    $this->set('feedbacks', ClassRegistry::init('feedbacks')->find('all'));
}

function admin_view($id){
    $feedback = ClassRegistry::init('feedbacks')->find('first', array('conditions' => array('id' => $id)));
    $this->set('feedback', $feedback);
    
}

function admin_delete($id){
    ClassRegistry::init('feedbacks')->delete($id);
    $this->redirect('/admin/feedback');
}

}
