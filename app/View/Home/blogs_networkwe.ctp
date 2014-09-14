<div class="greybox">
	    <div class="greybox-div-heading">
				<h1>Blogs</h1>
	    </div>
        <?php
			foreach ($get_latest_posts_networkwe as $blog__Row) {
				
				$blog_title = $blog__Row['blogs']['post_title'];
				$title_url = str_replace(" ", "-", strtolower($blog__Row['blogs']['post_title']));
				$blogId = $blog__Row['blogs']['id'];
				$auther_fullname = $blog__Row['users_profiles']['firstname'];
				$created_date = $blog__Row['blogs']['created'];
				$year = date("Y", strtotime($created_date));
				$month = date("M", strtotime($created_date));
				$day = date("d", strtotime($created_date));
			?>
		<div class="rgtwidget-blogs">
            <ul> 
                <li>
                    <h1>
                    	<?php 
							echo $this->Html->link($blog_title,array(
																	 'controller'=>'blogs',
																	 'action'=>'view',
																	 $blogId,
																	 $title_url
																	 ),
												   array(
												   'target'=>'_blank'
												   ));
						?>
                    </h1>
                </li>
                <li>
                Author: <?php echo $auther_fullname;?>
                &nbsp;&nbsp;&nbsp;
                <?php echo $month." ".$day.", ".$year;?>
                </li>
            </ul>
	    </div>
        <?php 
			}
		?>
		<div class="more"><?php echo $this->Html->link('more...',array('controller'=>'blogs','action'=>'index'), array('class'=>''));?></div>
 </div>