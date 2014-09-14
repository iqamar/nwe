<?php
class BlogsController extends AppController {

    //var $name = 'Blogs';
    var $helpers = array('Form', 'html', 'DatePicker');
    var $components = array('Auth');
    //'ImageResize'

    function beforeFilter() {
	parent::beforeFilter();


	$this->Auth->allow();
	switch ($this->request->params['action']) {
	    case 'index':
	    case 'admin':
		$this->Security->validatePost = false;
	}
    } 
	
	public function index() {  
             $this->loadModel('Blog');   
		if ($this->userInfo['users']['id']) {
				$uid = $this->userInfo['users']['id'];
			}
		if (empty($this->userInfo['users']['id'])) {	
			$this->loadModel('Country');
			$countryList = $this->Country->find('list');
			$this->set('countryList',$countryList);
		}
		
				/*Total posts*/
				$this->paginate = array('fields'=>array('
														 Blog.*,
														 users_profiles.firstname,
														 users_profiles.lastname,
														 users_profiles.user_id,
														 users_profiles.photo,
														 users_profiles.tags,
														 users_profiles.handler,
														 count(comments.content_id) as total_comments
														 '),
										 'joins'=>array(
														array('alias' => 'users_profiles',
															  'table' => 'users_profiles',
															  'type' => 'left',
															  'foreignKey' => false,
															  'conditions' => array('Blog.user_id  = users_profiles.user_id')
															  ),
														array('alias' => 'comments',
															  'table' => 'comments',
															  'type' => 'left',
															  'foreignKey' => false, 
															  'conditions' => array('Blog.id  = comments.content_id AND (comments.parent=0 AND comments.comment_type="blog")')
															  )
														),
										 'conditions'=>array('Blog.status=2'),
										 'limit' => 10,
										 'order'=>'Blog.id DESC',
										 'group'=>'Blog.id'
										 );
				
				//$blog_posts = ClassRegistry::init('blogs')->find('all');
				$blog_posts = $this->paginate('Blog');
			$this->set('blog_posts',$blog_posts);
		
		
		//print_r($blog_posts);
		
			/*get post's categories*/
			$categories_posts = ClassRegistry::init('category_posts')->find('all',array('fields'=>array('DISTINCT post_categories.title,category_posts.*, post_categories.id, post_categories.user_id, blogs.id'), 
																						 'joins'=>array(array('alias' => 'post_categories', 'table' => 'post_categories', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.category_id  = post_categories.id')),																																																										 array('alias' => 'blogs', 'table' => 'blogs', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.post_id  = blogs.id')))
																						 ,'order'=>'category_posts.id DESC','group'=>'category_posts.id'));
			$this->set('categories_posts',$categories_posts);
				
		/*List the category which have posts in drop down list*/
			$categories_lists = ClassRegistry::init('category_posts')->find('all',array('fields'=>array('DISTINCT post_categories.title,category_posts.*, post_categories.id, post_categories.user_id, blogs.id'), 
																						 'joins'=>array(array('alias' => 'post_categories', 'table' => 'post_categories', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.category_id  = post_categories.id')),																																																										 array('alias' => 'blogs', 'table' => 'blogs', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.post_id  = blogs.id')))
																						 ,'order'=>'category_posts.id DESC','group'=>'category_posts.category_id'));
			$this->set('categories_lists',$categories_lists);
			
			
		
	}
	public function add() {
		if ($this->userInfo['users']['id']) {
			$uid = $this->userInfo['users']['id']; 
		}
			/*for edit post/...*/
			$this->params['pass'];
			$paramenter = $this->params['pass'];
			$post__ID = $paramenter[0];
			//pr($post__ID);
			if ($post__ID !=0) {
				
				$edit_posts_dt = ClassRegistry::init('blogs')->find('first',array('fields'=>array('blogs.*'),'conditions'=>array('blogs.id='.$post__ID)));
				$this->set('post_dt_Row',$edit_posts_dt);
				$this->request->data['Blog']['image'] = $edit_posts_dt['blogs']['image'];
			$db = ConnectionManager::getDataSource('default');
			$db->rawQuery("DELETE FROM category_posts WHERE post_id=".$post__ID);
			$db->rawQuery("DELETE FROM post_tags WHERE post_id=".$post__ID);
			$db->rawQuery("DELETE FROM tags WHERE post_id=".$post__ID);
			
		}
			/*for edit post/..end.*/
		$post_categories = ClassRegistry::init('post_categories')->find('all');
		$this->set('post_categories',$post_categories);
		if ($this->request->is('post')) {
			$this->loadModel('Blog');
			$parent_id = $this->request->data['Blog']['parent'];
			if ($parent_id !=0) {
				$parent = 0;
				$this->loadModel('Statusupdate');
				$postById = $this->Blog->find('first',array('fields'=>array('Blog.id,Blog.post_title,Blog.description,Blog.parent,Blog.image,Blog.user_id'),
																		  'conditions'=>array('Blog.id ='.$parent_id)));
					$title = trim($postById['Blog']['post_title']);
					$description = strip_tags(substr($postById['Blog']['description'],0,200));
					$parent = $postById['Blog']['parent'];
					$blog_img = $postById['Blog']['image'];
					$auther_id = $postById['Blog']['user_id'];
				$blog_owners = ClassRegistry::init('users_profiles')->find('first',array('fields'=>array('
																										 users_profiles.firstname,
																										 users_profiles.lastname
																										 '),
																		  'conditions'=>array('users_profiles.user_id ='.$auther_id)));
				$auther_name = $blog_owners['users_profiles']['firstname']." ".$blog_owners['users_profiles']['lastname'];
				$auther_detail = '<div style="float:right;">By: <strong><a href="'.NETWORKWE_URL.'/users_profiles/userprofile/'.$auther_id.'">'.$auther_name.'</a></strong></div>';
				$this->request->data = '';
				
				$title = '<a href="'.NETWORKWE_URL.'/blogs/view/'.$parent_id.'">'.$title.'</a>';
				$blog_description = $title."<br />".$description."<br />".$auther_detail;
				$this->request->data['Statusupdate']['photo'] = $blog_img;
				$this->request->data['Statusupdate']['user_text'] = $blog_description;
				$this->request->data['Statusupdate']['user_id'] = $uid;
				$this->request->data['Statusupdate']['content_type'] = "blog";
				$created_date = date("Y-m-d H:i:s");
				$this->request->data['Statusupdate']['created'] = $created_date;
				$this->request->data['Statusupdate']['modified'] = $created_date;
				$this->request->data['Statusupdate']['share'] = $parent_id;
				$this->request->data['Statusupdate']['update_type'] = 0;
				$this->request->data['Statusupdate']['update_shared'] = 0;
				$this->request->data['Statusupdate']['share_with'] = 1;
				if ($this->Statusupdate->save($this->request->data)) {
					$this->Blog->id = $parent_id;
					$parent = $parent+1;
					$this->request->data['Blog']['parent'] = $parent;
					if ($this->Blog->save($this->request->data)) {
						$this->redirect(array('controller'=>'home','action'=>'index'));
						exit;
					}
				}
			}
				$filename = $this->request->data['Blog']['post_image']['name'];
				$uploadPath = MEDIA_PATH . "files/blog/original";
				$imageName = $filename;
				if (file_exists($uploadPath . '/' . $imageName)) {
					$imageName = date('His') . $imageName;
				}
				$full_image_path = $uploadPath . '/' . $imageName;
				if (move_uploaded_file($this->request->data['Blog']['post_image']['tmp_name'], $full_image_path)) {
					$this->request->data['Blog']['image'] = $imageName;
				}
						
			$this->request->data['Blog']['user_id'] = $uid;
			$this->request->data['Blog']['status'] = 2;
			$created_date = date("Y-m-d H:i:s");
			$this->request->data['Blog']['created'] = $created_date;
			$this->request->data['Blog']['modified'] = $created_date;
			$post_tags = $this->request->data['Blog']['user_tags'];
			$post_tags = rtrim($post_tags, ",");
			if(!empty($_POST['cat'])) {
   				 foreach($_POST['cat'] as $check) {
           			$catgory_array[] = $check; 
   				 }
			}
			//$catsArray = @implode(',',$catgory_array);
			//Edit id;
			$id = $this->request->data['Blog']['id'];
			if ($id != 0) {
				$this->Blog->id = $id;
				
				
			}
			
			//$this->Blog->create();
			if ($this->Blog->save($this->request->data)) {
				if ($id != 0) {
					$post_id = $id;
				}
				else {
					$post_id = $this->Blog->getInsertID();
				}
				$this->request->data = '';
				$this->loadModel('Category_post');
				for ($k=0;$k<sizeof($catgory_array);$k++) {
					$this->request->data['Category_post']['post_id'] = $post_id;
					$this->request->data['Category_post']['user_id'] = $uid;
					$this->request->data['Category_post']['category_id'] = $catgory_array[$k];
					 $this->Category_post->create();
							if ($this->Category_post->save($this->request->data)) {
								$this->request->data = '';
							}
				}
				$tags_array = @explode(',',$post_tags);
				$this->loadModel('Tag');
				for($j=0;$j<sizeof($tags_array);$j++) {
					
					$this->request->data['Tag']['post_tag'] = $tags_array[$j];
					$this->request->data['Tag']['user_id'] = $uid;
					$this->request->data['Tag']['post_id'] = $post_id;
					
					$checkTagInDB = $this->Tag->find('all',array('fields'=>array('Tag.post_tag,Tag.id'),'conditions'=>array('Tag.post_tag ='.'"'.$tags_array[$j].'"')));
					if (sizeof($checkTagInDB) == 0) {
						 $this->Tag->create();
						if ($this->Tag->save($this->request->data)) {
							$this->loadModel('Post_tag');
							$tag_id = $this->Tag->getInsertID();
							$this->request->data['Post_tag']['tag_id'] = $tag_id;
							$this->request->data['Post_tag']['post_id'] = $post_id;
							$this->request->data['Post_tag']['user_id'] = $uid;
							 $this->Post_tag->create();
							 if ($this->Post_tag->save($this->request->data)) {
								$this->request->data = '';
							 }
						}
					}
					else {
						foreach ($checkTagInDB as $tag_exist_row) {
							$tag_id = $tag_exist_row['Tag']['id'];
							
							$this->loadModel('Post_tag');
							$this->request->data['Post_tag']['tag_id'] = $tag_id;
							$this->request->data['Post_tag']['post_id'] = $post_id;
							$this->request->data['Post_tag']['user_id'] = $uid;
							 $this->Post_tag->create();
							 if ($this->Post_tag->save($this->request->data)) {
								$this->request->data = '';
							}
						}	 
					}
				}
				
			}
				$this->redirect(array('controller'=>'blogs','action'=>'index'));
		}
	}
	/*to search existing tags*/
	public function search_tags() {
		if ($this->request->is('get')) {
			$search_str = $_GET['search_str'];
			if ($search_str) {
					$search_Result_Tags = ClassRegistry::init('tags')->find('all',array('fields'=>array('tags.post_tag, tags.id'),'limit'=>10,'order'=>'tags.id DESC','conditions'=>array('tags.post_tag LIKE '=>'%'.$search_str.'%')));
					
					$this->set('search_Result_Tags',$search_Result_Tags);
			}
		}
					$this->autorender = false;
					$this->layout = false;
					$this->render('search_tags');
		
	}
	
	/*posts by select the category*/
	public function posts_by_category() {
		
		if ($this->request->is('post')) {
			
			$category__ID = $_POST['category__ID'];
			if ($category__ID !=0) {
					$posts_per_category = ClassRegistry::init('category_posts')->find('all',array('fields'=>array('category_posts.*, post_categories.id, post_categories.title, post_categories.user_id, blogs.*,users_profiles.firstname,users_profiles.lastname, users_profiles.handler'), 
																						 'joins'=>array(array('alias' => 'post_categories', 'table' => 'post_categories', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.category_id  = post_categories.id')),																																																										 array('alias' => 'blogs', 'table' => 'blogs', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.post_id  = blogs.id')),																																																										 array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.user_id =users_profiles.user_id'))),
																						 'conditions'=>array('category_posts.category_id='.$category__ID)
																						 ,'order'=>'category_posts.id DESC','group'=>'category_posts.post_id'));
					}
					else {
						
						$posts_per_category = ClassRegistry::init('category_posts')->find('all',array('fields'=>array('category_posts.*, post_categories.id, post_categories.title, post_categories.user_id, blogs.*,users_profiles.firstname,users_profiles.lastname, users_profiles.handler'), 
																						 'joins'=>array(array('alias' => 'post_categories', 'table' => 'post_categories', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.category_id  = post_categories.id')),																																																										 array('alias' => 'blogs', 'table' => 'blogs', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.post_id  = blogs.id')),																																																										 array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.user_id=users_profiles.user_id')))
																						 ,'order'=>'category_posts.id DESC','group'=>'category_posts.post_id'));
					}
			
			$this->set('posts_per_category',$posts_per_category);
			
			/*get post's categories*/
			$categories_posts = ClassRegistry::init('category_posts')->find('all',array('fields'=>array('DISTINCT post_categories.title,category_posts.*, post_categories.id, post_categories.user_id, blogs.id'), 
																						 'joins'=>array(array('alias' => 'post_categories', 'table' => 'post_categories', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.category_id  = post_categories.id')),																																																										 array('alias' => 'blogs', 'table' => 'blogs', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.post_id  = blogs.id')))
																						 ,'order'=>'category_posts.id DESC','group'=>'category_posts.id'));
			$this->set('categories_posts',$categories_posts);
		}
					$this->autorender = false;
					$this->layout = false;
					$this->render('posts_by_category');
					
	}
	/*Detail of the selected post*/
	public function view() {
			if ($this->userInfo['users']['id']) {
				$uid = $this->userInfo['users']['id']; 
			}
			if (empty($this->userInfo['users']['id'])) {	
				$this->loadModel('Country');
				$countryList = $this->Country->find('list');
				$this->set('countryList',$countryList);
			}
			$this->params['pass'];
			$paramenter = $this->params['pass'];
			$post__ID = $paramenter[0];
			if ($post__ID !=0) {
				$posts_Detail = ClassRegistry::init('blogs')->find('all',array('fields'=>array('
																							   category_posts.post_id,
																							   blogs.*,
																							   users_profiles.firstname,
																							   users_profiles.lastname,
																							   users_profiles.photo,
																							   users_profiles.tags
																							   '), 
																						 'joins'=>array(
																										array('alias' => 'category_posts',
																											  'table' => 'category_posts',
																											  'type' => 'left',
																											  'foreignKey' => false,
																											  'conditions' => array('category_posts.post_id  = blogs.id'
																																	)
																											  ),
																										array('alias' => 'users_profiles',
																											  'table' => 'users_profiles',
																											  'type' => 'left',
																											  'foreignKey' => false,
																											  'conditions' => array('blogs.user_id = users_profiles.user_id'
																																	)
																											  )
																										),
																						 'conditions'=>array('blogs.id='.$post__ID),'group'=>'blogs.id'
																						 )
																   );
			$this->set('posts_Detail',$posts_Detail);
			$post_data = $posts_Detail[0]['blogs'];
			$post_id = $post_data['id'];
			}
			if ($post_id) {
					/*post tags*/
			$post_Have_Tags = ClassRegistry::init('post_tags')->find('all',array('fields'=>array('tags.post_tag, tags.id,post_tags.post_id'),
																								 'joins'=>array(																																																									 array('alias' => 'tags', 'table' => 'tags', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('post_tags.tag_id  = tags.id'))),
																							'conditions'=>array('post_tags.post_id='.$post_id)));
			$this->set('post_Have_Tags',$post_Have_Tags);
			
			/*comments on the post*/
			$this->loadModel('Comment');
			$comments_on_post = $this->Comment->find('all',array('fields'=>array('Comment.*,users_profiles.firstname,users_profiles.lastname,users_profiles.photo, users_profiles.handler'),
																				 'joins'=>array(array(
																				 'alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('Comment.user_id = users_profiles.user_id'))),
																 'conditions'=>'Comment.content_id='.$post__ID.' AND Comment.comment_type="blog" AND Comment.parent=0'));
			$this->set('comments_on_post',$comments_on_post);
			
			/*reply to comments*/
			$reply_to_comments = $this->Comment->find('all',array('fields'=>array('Comment.*,users_profiles.firstname,users_profiles.lastname,users_profiles.photo, users_profiles.handler'),
																				 'joins'=>array(array(
																				 'alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('Comment.user_id = users_profiles.user_id'))),
																 'conditions'=>'Comment.content_id='.$post__ID.' AND Comment.comment_type="blog" AND Comment.parent!=0'));
			$this->set('reply_to_comments',$reply_to_comments);
			
			/*likes on Blog*/
			$this->loadModel('Like');
			$likes_on_post = $this->Like->find('all',array('fields'=>array('count(Like.like) as total_like'),'conditions'=>array('Like.content_id='.$post__ID.' AND Like.content_type="blog" AND Like.like=1'),'group'=>'Like.content_id'));
			$likes = $likes_on_post[0][0];
			$total_like_on_post = $likes['total_like'];
			$this->set('total_like_on_post',$total_like_on_post);
			
			/*check user already like*/
			if ($uid) {
			$log_user_like = $this->Like->find('first',array('fields'=>array('Like.user_id,Like.like'),
																		   'conditions'=>array('(Like.content_id='.$post__ID.' AND Like.content_type="blog") AND 
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
																			'conditions'=>array('likes.content_type="blog" AND likes.like=1 AND likes.content_id='.$post__ID)
																									));
			$this->set('likesOnUpdates',$likesOnUpdates);
			
			$whoshareBlogs = ClassRegistry::init('statusupdates')->find('all', array('fields'=>array('
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
																			'conditions'=>array('statusupdates.content_type="blog" AND statusupdates.share='.$post__ID)
																									));
			$this->set('whoshareBlogs',$whoshareBlogs);
		  }
	}
	/*add comments to post*/
	public function add_comments() {
		if ($this->request->is('post')) {
			$user_id = $_POST['user_id'];
			$content_id = $_POST['post_id'];
			$admin_id = $_POST['admin_id'];
			$comment_text = $_POST['user_comment'];
			$created_date = date("Y-m-d H:i:s");
			$this->loadModel('Comment');
			$this->request->data['Comment']['user_id'] = $user_id;
			$this->request->data['Comment']['comment_type'] = "blog";
			$this->request->data['Comment']['content_id'] = $content_id;
			$this->request->data['Comment']['comment_date'] = $created_date;
			$this->request->data['Comment']['comment_text'] = $comment_text;
			if ($this->Comment->save($this->request->data)){
				$last_comment_id = $this->Comment->getInsertID();
				$comments_this_post = $this->Comment->find('all',array('fields'=>array('
																					   Comment.comment_text,
																					   Comment.created,
																					   Comment.id,
																					   Comment.user_id,
																					   users_profiles.firstname,
																					   users_profiles.lastname,
																					   users_profiles.photo,
																					   users_profiles.handler
																					   '),
																					 'joins'=>array(
																									array('alias' => 'users_profiles', 
																										  'table' => 'users_profiles',
																										  'type' => 'left',
																										  'foreignKey' => false,
																										  'conditions' => array('Comment.user_id = users_profiles.user_id'
																																)
																										  )
																									),
																					 'conditions'=>'Comment.id='.$last_comment_id.' AND Comment.comment_type="blog"'
																					 )
														   );
				
				$total_blog_comments = $this->Comment->find('all',array('fields'=>array('Comment.id'),
																						'conditions'=>array('Comment.content_id='.$content_id.' AND Comment.parent =0 AND Comment.comment_type="blog"')));
				
				$this->set('comments_this_post',$comments_this_post);
				$this->set('total_blogs_comments',sizeof($total_blog_comments));
				$this->set('content_id',$content_id);
				$this->set('admin_id',$admin_id);
			}
		}
		$this->autorender = false;
		$this->layout = false;
		$this->render('add_comments');
	}

	/*Reply to comment*/
	public function reply_to_comments() {
			if ($this->request->is('post')) {
			$user_id = $_POST['user_id'];
			$content_id = $_POST['post_id'];
			$parent = $_POST['parent'];
			$comment_text = $_POST['user_comment'];
			$created_date = date("Y-m-d H:i:s");
			$this->loadModel('Comment');
			$this->request->data['Comment']['user_id'] = $user_id;
			$this->request->data['Comment']['comment_type'] = "blog";
			$this->request->data['Comment']['content_id'] = $content_id;
			$this->request->data['Comment']['comment_date'] = $created_date;
			$this->request->data['Comment']['comment_text'] = $comment_text;
			$this->request->data['Comment']['parent'] = $parent;
			if ($this->Comment->save($this->request->data)){
				$last_reply_id = $this->Comment->getInsertID();
				$reply_to_comments = $this->Comment->find('all',array('fields'=>array('Comment.*,users_profiles.firstname,users_profiles.lastname,users_profiles.photo, users_profiles.handler'),
																					 'joins'=>array(array(
																					 'alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('Comment.user_id = users_profiles.user_id'))),
																	 'conditions'=>'Comment.parent='.$parent.' AND Comment.comment_type="blog"'));
				$this->set('reply_to_comments',$reply_to_comments);
				$this->set('content_id',$content_id);
			}
		}
		$this->autorender = false;
		$this->layout = false;
		$this->render('reply_to_comments');
		
	}
	
	public function category_posts() {
			$this->params['pass'];
			$paramenter = $this->params['pass'];
			$category__ID = $paramenter[0];
			if ($category__ID !=0) {
				$posts_in_category = ClassRegistry::init('category_posts')->find('all',array('fields'=>array('category_posts.*, post_categories.id, post_categories.title, post_categories.user_id, blogs.*,users_profiles.firstname,users_profiles.lastname'), 
																						 'joins'=>array(array('alias' => 'post_categories', 'table' => 'post_categories', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.category_id  = post_categories.id')),																																																										 array('alias' => 'blogs', 'table' => 'blogs', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.post_id  = blogs.id')),																																																										 array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.user_id =users_profiles.user_id'))),
																						 'conditions'=>array('category_posts.category_id='.$category__ID)
																						 ,'order'=>'category_posts.id DESC'));
				$this->set('posts_in_category',$posts_in_category);
			}
	}
	
	/*to check user type blog_ posts*/
	
	public function blog_type() {
		if ($this->request->is('get')) {
			$blog_type = $_GET['post_type'];
			$uid = $this->userInfo['users']['id'];
				
				if ($blog_type == 'connection') {
					if ($uid) {
							
							$reqUser = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),
												'conditions'=>array('(connections.user_id='.$uid.' OR connections.friend_id='.$uid.') AND connections.request=1')));
							
							foreach ($reqUser as $req) {
			
								$reqArray[] = $req['connections']['friend_id'];
								$reqArray[] = $req['connections']['user_id'];
			
							}

							//$commonArrays = array_intersect($commArray, $reqArray);
							foreach ($reqArray as $key=>$commValue) {
								if ($commValue != $uid) {
									$commonUserArray[] = $commValue;
								}
							}
							$you_your_connections = @implode(',',$commonUserArray).",".$uid;
							$connection_posts = ClassRegistry::init('blogs')->find('all',array('fields'=>array('blogs.*,users_profiles.firstname,users_profiles.lastname, users_profiles.user_id,users_profiles.handler, count(comments.content_id) as total_comments'),
																						 'joins'=>array(array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('blogs.user_id  = users_profiles.user_id')),																																												array('alias' => 'comments', 'table' => 'comments', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('blogs.id  = comments.content_id AND (comments.parent=0 AND comments.comment_type="blog")'))),'conditions'=>array(array('blogs.user_id IN ('.$you_your_connections.')'),'blogs.status=2'),'order'=>'blogs.id DESC','group'=>'blogs.id'));
			$this->set('connection_posts',$connection_posts);
			
							
					}
				}
			else if($blog_type == 'all') {
				
				$connection_posts = ClassRegistry::init('blogs')->find('all',array('fields'=>array('blogs.*,users_profiles.firstname,users_profiles.lastname,users_profiles.user_id ,users_profiles.handler, count(comments.content_id) as total_comments'),
																						 'joins'=>array(array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('blogs.user_id  = users_profiles.user_id')),																																												array('alias' => 'comments', 'table' => 'comments', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('blogs.id  = comments.content_id AND (comments.parent=0 AND comments.comment_type="blog")'))),'conditions'=>array('blogs.status=2'),'order'=>'blogs.id DESC','group'=>'blogs.id'));
			$this->set('connection_posts',$connection_posts);
			}
			else if($blog_type == 'your') {
				
				$connection_posts = ClassRegistry::init('blogs')->find('all',array('fields'=>array('blogs.*,users_profiles.firstname,users_profiles.lastname,users_profiles.user_id ,users_profiles.handler, count(comments.content_id) as total_comments'),
																						 'joins'=>array(array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('blogs.user_id  = users_profiles.user_id')),																																												array('alias' => 'comments', 'table' => 'comments', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('blogs.id  = comments.content_id AND (comments.parent=0 AND comments.comment_type="blog")'))),'conditions'=>array('blogs.status=2 AND blogs.user_id='.$uid),'order'=>'blogs.id DESC','group'=>'blogs.id'));
			$this->set('connection_posts',$connection_posts);
			}
			else {
				
				echo "<h1>No Record found.</h1>";
			}
			
			/*post's category*/
			$categories_posts = ClassRegistry::init('category_posts')->find('all',array('fields'=>array('category_posts.*, post_categories.id, post_categories.title, post_categories.user_id, blogs.id'), 
																						 'joins'=>array(array('alias' => 'post_categories', 'table' => 'post_categories', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.category_id  = post_categories.id')),																																																										 array('alias' => 'blogs', 'table' => 'blogs', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.post_id  = blogs.id')))
																						 ,'order'=>'category_posts.id DESC','group'=>'category_posts.id'));
			$this->set('categories_posts',$categories_posts);
			$this->set('blog_type',$blog_type);
			
			$this->autorender = false;
			$this->layout = false;
			$this->render('blog_type');
		}
	}
	
	/*Delete the post...*/
	public function delete() {
		$this->params['pass'];
		$paramenter = $this->params['pass'];
		$post__ID = $paramenter[0];
		if ($post__ID !=0) {
			/*Custom delte method without using Model name*/
			$db = ConnectionManager::getDataSource('default');
			$db->rawQuery("DELETE FROM category_posts WHERE post_id=".$post__ID);
			$db->rawQuery("DELETE FROM post_tags WHERE post_id=".$post__ID);
			$db->rawQuery("DELETE FROM tags WHERE post_id=".$post__ID);
			$db->rawQuery("DELETE FROM blogs WHERE id=".$post__ID);
			$db->rawQuery("DELETE FROM comments WHERE content_id=".$post__ID.' AND comment_type= "blog"');
			$db->rawQuery("DELETE FROM likes WHERE content_id=".$post__ID.' AND content_type= "blog"');
			$db->rawQuery("DELETE FROM tags WHERE post_id=".$post__ID);
			
			//$this->redirect(array('controller'=>'blogs','action'=>'index','mesg'=>$mesg));
			
			$this->Session->setFlash('Blog Deleted!','success_msg',array(),'blog_message');
			$this->redirect(array('action' => 'index'));
		}
	}
	
	public function search_blog() {
		/*echo "<pre>";
		
		print_r($_GET);
		exit;*/
		if ($this->request->is('get')) {
			
			
			
			
			
			$where = "blogs.status=2 ";
			
			if(isset($_GET['search_posts'])){
				$search_posts = $_GET['search_posts'];
				if(!empty($search_posts )){
					$where .= " AND blogs.post_title LIKE '%".$search_posts."%' "; 
				}
			}	
			
			if(isset($_GET['category'])){
				$category = $_GET['category'];
				if($category>0){
					$where .= " AND category_posts.category_id='".$category."' ";
				}
			
			}
			
			if(isset($_GET['post_group'])){
				$post_group = $_GET['post_group'];
				$uid = $this->userInfo['users']['id'];
				if($post_group == "your"){
					$where .= " AND blogs.user_id='".$uid."' ";
				}else if($post_group == "connection"){
					$reqUser = ClassRegistry::init('connections')->find('all',array('fields'=>array('connections.friend_id,connections.user_id'),
												'conditions'=>array('(connections.user_id='.$uid.' OR connections.friend_id='.$uid.') AND connections.request=1')));
							
					foreach ($reqUser as $req) {	
						$reqArray[] = $req['connections']['friend_id'];
						$reqArray[] = $req['connections']['user_id'];	
					}

					//$commonArrays = array_intersect($commArray, $reqArray);
					foreach ($reqArray as $key=>$commValue) {
						if ($commValue != $uid) {
							$commonUserArray[] = $commValue;
						}
					}
					$you_your_connections = @implode(',',$commonUserArray).",".$uid;
					$where .= " AND blogs.user_id IN (".$you_your_connections.") ";
				}
			}
			$get_posts_search = ClassRegistry::init('blogs')->find('all',array('fields'=>array('blogs.*,users_profiles.firstname,users_profiles.lastname,users_profiles.user_id, users_profiles.photo,users_profiles.tags,users_profiles.handler, count(comments.content_id) as total_comments'),
'joins'=>array(array('alias' => 'users_profiles', 'table' => 'users_profiles', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('blogs.user_id  = users_profiles.user_id')),																																												
array('alias' => 'comments', 'table' => 'comments', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('blogs.id  = comments.content_id AND (comments.parent=0 AND comments.comment_type="blog")')),
array('alias' => 'category_posts', 'table' => 'category_posts', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('blogs.id  = category_posts.post_id')),
),
														'conditions'=>array("$where"),'order'=>'blogs.id DESC','group'=>'blogs.id'));
			
			$this->set('get_posts_search',$get_posts_search);
			
						/*get post's categories*/
			$categories_posts = ClassRegistry::init('category_posts')->find('all',array('fields'=>array('DISTINCT post_categories.title,category_posts.*, post_categories.id, post_categories.user_id, blogs.id'), 
																						 'joins'=>array(array('alias' => 'post_categories', 'table' => 'post_categories', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.category_id  = post_categories.id')),	
																						  array('alias' => 'blogs', 'table' => 'blogs', 'type' => 'left', 'foreignKey' => false, 'conditions' => array('category_posts.post_id  = blogs.id')))
																						  ,'order'=>'category_posts.id DESC','group'=>'category_posts.id'));
			$this->set('categories_posts',$categories_posts);
			
		}
		/*echo "<pre>";
		print_r($get_posts_search);
		exit;*/
		$this->autorender = false;
		$this->layout = false;
		$this->render('search_blog');
	}
	
		public function delete_comment() {
		if ($this->request->is('get')) {
			$comment_id = $_GET['comment_id'];
			$content_id = $_GET['content_id'];
			$db = ConnectionManager::getDataSource('default');
			$db->rawQuery("DELETE FROM comments WHERE (id=".$comment_id.' OR parent='.$comment_id.') AND comment_type= "blog"');
			
			$comments_this_update = ClassRegistry::init('comments')->find('all',array('fields'=>array('comments.id
																												  '),
																'conditions'=>array('comments.content_id='.$content_id.' AND comments.comment_type="blog" AND comments.parent=0')
																	 )
																				  );
			echo $total_comments = sizeof($comments_this_update);
			
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('delete_comment');
		}
		
	}
	
	public function delete_reply() {
		if ($this->request->is('get')) {
			$comment_id = $_GET['comment_id'];
			$content_id = $_GET['content_id'];
			$db = ConnectionManager::getDataSource('default');
			$db->rawQuery("DELETE FROM comments WHERE id=".$comment_id.' AND parent='.$content_id.' AND comment_type= "blog"');
			
			$this->autorender = false;
	    	$this->layout = false;
	    	$this->render('delete_comment');
		}
		
	}
}
?>
