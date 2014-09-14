<?php for ($i=1; $i<=5; $i++) {
				if ($i<=$countedRate){
				echo $this->Html->image('golden-star.png',array('style'=>'width:15px; height:15px; margin-right:3px;'));
				}else {
				echo $this->Html->image('star-icon1.png',array('style'=>'width:15px; height:15px; margin-right:3px;'));  }
}?>