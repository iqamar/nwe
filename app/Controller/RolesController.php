<?php
/**
 * Roles Controller
 *
 * @property Role $Role
 */
class RolesController extends AppController {

	var $name = 'Roles';
	var $helpers = array('Form', 'Alaxos.AlaxosForm', 'Alaxos.AlaxosHtml');
	var $components = array('Alaxos.AlaxosFilter');

  function beforeFilter()
  {
    parent :: beforeFilter();

    switch($this->request->params['action'])
    {
        case 'index':
        case 'admin_index':
            $this->Security->validatePost = false;
    }
  }

	function index()
	{
		$this->Role->recursive = 0;
		$this->set('roles', $this->paginate($this->Role, $this->AlaxosFilter->get_filter()));
		
	}

	function view($id = null)
	{
		$this->_set_role($id);
	}

	function add()
	{
		if($this->request->is('post'))
		{
			$this->Role->create();
			if($this->Role->save($this->request->data))
			{
				$this->Session->setFlash(___('the role has been saved'), 'flash_message', array('plugin' => 'alaxos'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(___('the role could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
			}
		}
		
	}

	function edit($id = null)
	{
		$this->Role->id = $id;
		if(!$this->Role->exists())
		{
			throw new NotFoundException(___('invalid id for role'));
		}
		
		if($this->request->is('post') || $this->request->is('put'))
		{
			if($this->Role->save($this->request->data))
			{
				$this->Session->setFlash(___('the role has been saved'), 'flash_message', array('plugin' => 'alaxos'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(___('the role could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
			}
		}
		
		$this->_set_role($id);
		
	}

	function copy($id = null)
	{
		$this->Role->id = $id;
		if(!$this->Role->exists())
		{
			throw new NotFoundException(___('invalid id for role'));
		}
		
		if($this->request->is('post') || $this->request->is('put'))
		{
			$this->Role->create();
			
			if($this->Role->save($this->request->data))
			{
				$this->Session->setFlash(___('the role has been saved'), 'flash_message', array('plugin' => 'alaxos'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				//reset id to copy
				$this->request->data['Role'][$this->Role->primaryKey] = $id;
				$this->Session->setFlash(___('the role could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
			}
		}
		
		$this->_set_role($id);
				
	}
	
	function delete($id = null)
	{
		if(!$this->request->is('post'))
		{
			throw new MethodNotAllowedException();
		}
		
		$this->Role->id = $id;
		if(!$this->Role->exists())
		{
			throw new NotFoundException(___('invalid id for role'));
		}
		
		if($this->Role->delete($id))
		{
			$this->Session->setFlash(___('role deleted'), 'flash_message', array('plugin' => 'alaxos'));
			$this->redirect(array('action'=>'index'));
		}
		elseif(count($this->Role->validationErrors) > 0)
		{
			$errors_str = '<ul>';
		    
		    foreach($this->Role->validationErrors as $field => $errors)
		    {
		        foreach($errors as $error)
		        {
		            $errors_str .= '<li>';
		            $errors_str .= $error;
		            $errors_str .= '</li>';
		        }
		    }
		    $errors_str .= '</ul>';
		    
			$this->Session->setFlash(sprintf(___('the role was not deleted: %s'), $errors_str), 'flash_error', array('plugin' => 'alaxos'));
		    $this->redirect($this->referer(array('action' => 'index')));
		}
		else
		{
			$this->Session->setFlash(___('role was not deleted'), 'flash_error', array('plugin' => 'alaxos'));
			$this->redirect($this->referer(array('action' => 'index')));
		}
	}
	
	function actionAll()
	{
	    if(!empty($this->request->data['_Tech']['action']))
	    {
        	if(isset($this->Auth))
	        {
	        	$request           = $this->request;
	            $request['action'] = $this->request->data['_Tech']['action'];
	            
	            if($this->Auth->isAuthorized($this->Auth->user(), $request))
	            {
	                $this->setAction($this->request->data['_Tech']['action']);
	            }
	            else
	            {
	                $this->Session->setFlash(___d('alaxos', 'not authorized'), 'flash_error', array('plugin' => 'alaxos'));
	                $this->redirect($this->referer());
	            }
	        }
	        else
	        {
	        	/*
	             * Auth is not used -> grant access
	             */
	        	$this->setAction($this->request->data['_Tech']['action']);
	        }
	    }
	    else
	    {
	        $this->Session->setFlash(___d('alaxos', 'the action to perform is not defined'), 'flash_error', array('plugin' => 'alaxos'));
	        $this->redirect($this->referer());
	    }
	}
	
	function deleteAll()
	{
	    $ids = Set :: extract('/Role/id[id > 0]', $this->request->data);
	    if(count($ids) > 0)
	    {
    	    if($this->Role->deleteAll(array('Role.id' => $ids), false, true))
    	    {
    	        $this->Session->setFlash(___('roles deleted'), 'flash_message', array('plugin' => 'alaxos'));
    			$this->redirect(array('action'=>'index'));
    	    }
    	    else
    	    {
    	        $this->Session->setFlash(___('roles were not deleted'), 'flash_error', array('plugin' => 'alaxos'));
    	        $this->redirect($this->referer(array('action' => 'index')));
    	    }
	    }
	    else
	    {
	        $this->Session->setFlash(___('no role to delete was found'), 'flash_error', array('plugin' => 'alaxos'));
    	    $this->redirect($this->referer(array('action' => 'index')));
	    }
	}
	
	
	
	function _set_role($id)
	{
		$this->Role->id = $id;
		if(!$this->Role->exists())
		{
			throw new NotFoundException(___('invalid id for role'));
		}
	    
	    /*
	    * Test allowing to not override submitted data
	    */
	    if(empty($this->request->data))
	    {
	    	$this->request->data = $this->Role->findById($id);
	    }
	    
	    $this->set('role', $this->request->data);
	    
	    return $this->request->data;
	}
	
	
	function admin_index()
	{
		$this->Role->recursive = 0;
		$this->set('roles', $this->paginate($this->Role, $this->AlaxosFilter->get_filter()));
		
	}

	function admin_view($id = null)
	{
		$this->_set_role($id);
	}

	function admin_add()
	{
		if($this->request->is('post'))
		{
			$this->Role->create();
			if($this->Role->save($this->request->data))
			{
				$this->Session->setFlash(___('the role has been saved'), 'flash_message', array('plugin' => 'alaxos'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(___('the role could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
			}
		}
		
	}

	function admin_edit($id = null)
	{
		$this->Role->id = $id;
		if(!$this->Role->exists())
		{
			throw new NotFoundException(___('invalid id for role'));
		}
		
		if($this->request->is('post') || $this->request->is('put'))
		{
			if($this->Role->save($this->request->data))
			{
				$this->Session->setFlash(___('the role has been saved'), 'flash_message', array('plugin' => 'alaxos'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(___('the role could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
			}
		}
		
		$this->_set_role($id);
		
	}

	function admin_copy($id = null)
	{
		$this->Role->id = $id;
		if(!$this->Role->exists())
		{
			throw new NotFoundException(___('invalid id for role'));
		}
		
		if($this->request->is('post') || $this->request->is('put'))
		{
			$this->Role->create();
			
			if($this->Role->save($this->request->data))
			{
				$this->Session->setFlash(___('the role has been saved'), 'flash_message', array('plugin' => 'alaxos'));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				//reset id to copy
				$this->request->data['Role'][$this->Role->primaryKey] = $id;
				$this->Session->setFlash(___('the role could not be saved. Please, try again.'), 'flash_error', array('plugin' => 'alaxos'));
			}
		}
		
		$this->_set_role($id);
				
	}
	
	function admin_delete($id = null)
	{
		if(!$this->request->is('post'))
		{
			throw new MethodNotAllowedException();
		}
		
		$this->Role->id = $id;
		if(!$this->Role->exists())
		{
			throw new NotFoundException(___('invalid id for role'));
		}
		
		if($this->Role->delete($id))
		{
			$this->Session->setFlash(___('role deleted'), 'flash_message', array('plugin' => 'alaxos'));
			$this->redirect(array('action'=>'index'));
		}
		elseif(count($this->Role->validationErrors) > 0)
		{
			$errors_str = '<ul>';
		    
		    foreach($this->Role->validationErrors as $field => $errors)
		    {
		        foreach($errors as $error)
		        {
		            $errors_str .= '<li>';
		            $errors_str .= $error;
		            $errors_str .= '</li>';
		        }
		    }
		    $errors_str .= '</ul>';
		    
			$this->Session->setFlash(sprintf(___('the role was not deleted: %s'), $errors_str), 'flash_error', array('plugin' => 'alaxos'));
		    $this->redirect($this->referer(array('action' => 'index')));
		}
		else
		{
			$this->Session->setFlash(___('role was not deleted'), 'flash_error', array('plugin' => 'alaxos'));
			$this->redirect($this->referer(array('action' => 'index')));
		}
	}
	
	function admin_actionAll()
	{
	    if(!empty($this->request->data['_Tech']['action']))
	    {
        	if(isset($this->Auth))
	        {
	        	$request           = $this->request;
	            $request['action'] = $this->request->data['_Tech']['action'];
	            
	            if($this->Auth->isAuthorized($this->Auth->user(), $request))
	            {
	                $this->setAction($this->request->data['_Tech']['action']);
	            }
	            else
	            {
	                $this->Session->setFlash(___d('alaxos', 'not authorized'), 'flash_error', array('plugin' => 'alaxos'));
	                $this->redirect($this->referer());
	            }
	        }
	        else
	        {
	        	/*
	             * Auth is not used -> grant access
	             */
	        	$this->setAction($this->request->data['_Tech']['action']);
	        }
	    }
	    else
	    {
	        $this->Session->setFlash(___d('alaxos', 'the action to perform is not defined'), 'flash_error', array('plugin' => 'alaxos'));
	        $this->redirect($this->referer());
	    }
	}
	
	function admin_deleteAll()
	{
	    $ids = Set :: extract('/Role/id[id > 0]', $this->request->data);
	    if(count($ids) > 0)
	    {
    	    if($this->Role->deleteAll(array('Role.id' => $ids), false, true))
    	    {
    	        $this->Session->setFlash(___('roles deleted'), 'flash_message', array('plugin' => 'alaxos'));
    			$this->redirect(array('action'=>'index'));
    	    }
    	    else
    	    {
    	        $this->Session->setFlash(___('roles were not deleted'), 'flash_error', array('plugin' => 'alaxos'));
    	        $this->redirect($this->referer(array('action' => 'index')));
    	    }
	    }
	    else
	    {
	        $this->Session->setFlash(___('no role to delete was found'), 'flash_error', array('plugin' => 'alaxos'));
    	    $this->redirect($this->referer(array('action' => 'index')));
	    }
	}
	
	
	
	
}
?>
