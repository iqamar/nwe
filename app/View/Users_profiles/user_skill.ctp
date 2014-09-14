<?php foreach ($skill_Ajax_List as $new_skill__Row) {
					$skill_id = $new_skill__Row['users_skills']['id'];
							?>
						<div class="editprofile-skill skill_list" id="<?php echo $skill_id;?>">
							<a href="#" class="blockers-number">0</a>
                        	<div class="blockers-text">
                        		<a href="#"><?php echo $new_skill__Row['skills']['title'];?></a>
                			</div>
                        		<a href="javascript:void(0)" onclick="delete_skill('<?php echo $skill_id;?>')" class="delete-skills"></a>
							<div class="clear"></div>
						</div>
   <?php }?>