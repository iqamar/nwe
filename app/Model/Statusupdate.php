<?php
App::uses('AppModel', 'Model');
/**
 * Post Model
 *
 * @property User $User
 */
class Statusupdate extends AppModel {
	public $displayField = 'title';
	
	function get_activity($activity_id,$activity_type) {
		
		if ($activity_type == 'comments') {
				$content_array = ClassRegistry::init('comments')->find('first',array('fields'=>array(
																								  'users_profiles.firstname,
																								   users_profiles.lastname,
																								   users_profiles.photo,
																								   users_profiles.tags,
																								   users_profiles.user_id,
																								   comments.comment_type,
																								   comments.content_id
																								   '
																								  ),
																				  
																				  'joins'=>array(
																								 array('alias'=> 'users_profiles',
																									   'table'=> 'users_profiles',
																									   'type'=> 'left',
																									   'foreignKey'=> false,
																									   'conditions'=> array('comments.user_id = users_profiles.user_id'
																															)
																									   )
																								 ),
																				  'conditions'=>array(
																									  'comments.id='.$activity_id
																									  )
															  ));
			}
			else if ($activity_type == 'likes') {
				$content_array = ClassRegistry::init('likes')->find('first',array('fields'=>array(
																								  'users_profiles.firstname,
																								   users_profiles.lastname,
																								   users_profiles.photo,
																								   users_profiles.user_id,
																								   users_profiles.tags,
																								   likes.content_type,
																								   likes.content_id
																								   '
																								  ),
																				  
																				  'joins'=>array(
																								 array('alias'=> 'users_profiles',
																									   'table'=> 'users_profiles',
																									   'type'=> 'left',
																									   'foreignKey'=> false,
																									   'conditions'=> array('likes.user_id = users_profiles.user_id'
																															)
																									   )
																								 ),
																				  'conditions'=>array(
																									  'likes.id='.$activity_id
																									  )
															  ));
				
			}
			else if ($activity_type == 'updates') {
				$content_array = ClassRegistry::init('statusupdates')->find('first',array('fields'=>array(
																								  'users_profiles.firstname,
																								   users_profiles.lastname,
																								   users_profiles.photo,
																								   users_profiles.user_id,
																								   users_profiles.tags,
																								   statusupdates.id
																								   '
																								  ),
																				  
																				  'joins'=>array(
																								 array('alias'=> 'users_profiles',
																									   'table'=> 'users_profiles',
																									   'type'=> 'left',
																									   'foreignKey'=> false,
																									   'conditions'=> array('statusupdates.user_id = users_profiles.user_id'
																															)
																									   )
																								 ),
																				  'conditions'=>array(
																									  'statusupdates.id='.$activity_id
																									  )
															  ));
			}
		return $content_array;
	}
	
	function get_updates($uid) {
		$findParameters = array(
								'fields'=> array('
												 statusupdates.user_text,
												 statusupdates.content_type,
												 statusupdates.photo,
												 statusupdates.user_id,
												 statusupdates.share,
												 statusupdates.created,
												 statusupdates.id,
												 statusupdates.update_type,
												 statusupdates.share_with,
												 users_profiles.firstname,
												 users_profiles.lastname,
												 users_profiles.user_id,
												 users_profiles.photo,
												 likes.like,
												 likes.content_id,
												 likes.id,likes.user_id,
												 count(likes.like) as total,
												 statusupdates.created
												 '),
								'order'=>'statusupdates.id DESC',
								'limit'=>50,
								'joins'=>array(
											  array('alias'=> 'likes',
													'table'=> 'likes',
													'type'=> 'left',
													'foreignKey'=> false,
													'conditions'=> array('statusupdates.id  = likes.content_id')),	
											  array('alias'=> 'users_profiles',
													'table'=> 'users_profiles',
													'type'=> 'left',
													'foreignKey'=> false,
													'conditions'=> array('statusupdates.user_id = users_profiles.user_id'
																	  )
													)
											  ),
								'conditions'=>array(
													 array('statusupdates.content_type="updates"'),
													'statusupdates.user_id='.$uid	
													 ),
								'group'=> 'statusupdates.id'
								);
		
		$your_updates = ClassRegistry::init('statusupdates')->find('all',$findParameters);	
		return $your_updates;
		
		
	}
	
	function get_updates_likes() {
		$findParameters = array('fields'=>array('
												users_profiles.firstname,
												users_profiles.lastname,
												users_profiles.photo,
												users_profiles.user_id,
												users_profiles.tags,
												likes.content_id,
												likes.user_id
												'),
								'joins'=>array(
											  array('alias'=> 'users_profiles',
													'table'=> 'users_profiles',
													'type'=> 'left',
													'foreignKey'=> false,
													'conditions'=> array('likes.user_id = users_profiles.user_id'
																	  )
													)
											  ),
								'order'=>'likes.id DESC',
								'conditions'=>array('likes.content_type="updates"'
													)
								);
		$likesOnUpdates = ClassRegistry::init('likes')->find('all', $findParameters);
		return $likesOnUpdates;
	}
	
	function get_count_comment() {
		
		$findParameters = array('fields'=> array('
												 comments.content_id,
												 count(comments.content_id) as commenttotal
												 '),
								'conditions'=>array('comments.comment_type="updates"'),
								'order'=>'comments.id DESC',
								'group'=>'comments.content_id'
								);
		
		$updates_comments_count = ClassRegistry::init('comments')->find('all', $findParameters);
		return $updates_comments_count;
	}
	
	function get_user_comments() {
		$findParameters = array('fields'=> array('
												  comments.comment_text,
												  comments.created,
												  comments.content_id,
												  comments.user_id,
												  comments.id,
												  users_profiles.lastname,
												  users_profiles.firstname,
												  users_profiles.photo,
												  users_profiles.user_id,
												  users_profiles.handler
												  '),
								'order'=>'comments.id DESC',
								'joins'=> array(
												 array('alias'=> 'users_profiles',
													   'table'=> 'users_profiles',
													   'type'=> 'left',
													   'foreignKey'=> false,
													   'conditions'=> array('comments.user_id = users_profiles.user_id'
																			 )
													   )
												 ),
								'conditions'=> array('comments.comment_type ="updates"')
																			
								);
		$user_comments = ClassRegistry::init('comments')->find('all', $findParameters);
		return $user_comments;
	}
}