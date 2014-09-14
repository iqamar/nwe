        <?php if(!empty($datauser)): ?>
            <?php foreach ($datauser as $data): ?>
                <li class="result-box">
                    <p>
                    <?php if ($data['users_profiles']['photo'] !='') echo $this->Html->image('/files/users/'.$data['users_profiles']['photo'],array('class'=>'thumbnail'));
                    else echo $this->Html->image('user-icon.png',array('class'=>'thumbnail')); ?>
                    <a href="<?= $this->request->base ?>/users_profiles/userprofile/<?=$data['Users_profile']['id']?>"><?php echo "<b>".$data['Users_profile']['firstname']." ".$data['Users_profile']['lastname']."</b>"; ?></a>
                    </p>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if(!empty($datajobs)): ?>
            <?php foreach ($datajobs as $data): ?>
                <li class="result-box">
                    <p>
                    <?php if ($data['Company']['logo'] !='') echo $this->Html->image('/files/users/'.$data['Company']['logo'],array('class'=>'thumbnail'));
                    else echo $this->Html->image('no-image.png',array('class'=>'thumbnail')); ?>
                    <a href="http://jobs.networkwe.com/search/jobDetails/<?php echo $data['Job']['id'];?>"><?php echo "<b>"; if(strlen($data['Job']['title'])>19) echo substr($data['Job']['title'],0,20); else echo $data['Job']['title']; echo "</b>"; ?></a><br/>
                    <sub><?php echo $data['Country']['name'];?></sub>
                    </p>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if(!empty($datacompany)): ?>
            <?php foreach ($datacompany as $data): ?>
                <li class="result-box">
                    <p>
                    <?php if ($data['Company']['logo'] !='') echo $this->Html->image('/files/users/'.$data['Company']['logo'],array('class'=>'thumbnail'));
                    else echo $this->Html->image('no-image.png',array('class'=>'thumbnail')); ?>
                    <a href="<?= $this->request->base ?>/companies/view/<?php echo $data['Company']['id'];?>"><?php echo "<b>"; if(strlen($data['Company']['title'])>19) echo substr($data['Company']['title'],0,20); else echo $data['Company']['title']; echo "</b>"; ?></a><br/>
                    <sub><?php echo $data['Country']['name']?$data['Country']['name']:'N/A';?></sub>
                    </p>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if(!empty($datagroups)): ?>
            <?php foreach ($datagroups as $data): ?>
                <li class="result-box">
                    <p>
                    <?php if ($data['Group']['logo'] !='') echo $this->Html->image('/files/users/'.$data['Group']['logo'],array('class'=>'thumbnail'));
                    else echo $this->Html->image('no-image.png',array('class'=>'thumbnail')); ?>
                    <a href="<?= $this->request->base ?>/companies/view/<?php echo $data['Group']['id'];?>"><?php echo "<b>"; if(strlen($data['Group']['title'])>19) echo substr($data['Group']['title'],0,20); else echo $data['Group']['title']; echo "</b>"; ?></a><br/>
                    <sub><?php echo $data['groups_types']['title'];?></sub>
                    </p>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>