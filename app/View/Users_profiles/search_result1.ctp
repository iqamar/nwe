<style type="text/css">
    /* style the auto-complete response */
    li.ui-menu-item { font-size:12px !important; }
    .wrapper { width: 100%; margin: 0 auto; background: #fff; }
    .sinlge-column { width: 100%; border-left: 1px solid #eee; padding: 15px 10px; }
    .sinlge-column h2 { text-align: left; }
    .multi-column-1 { width: 30%; float: left; background: #EEEEEE; padding: 15px 10px; }
    .multi-column-1 h2 { font-weight: bold; font-size: 16px; padding: 5px 0; }
    .multi-column-1 ul { padding: 0; margin: 10px 0; }
    .multi-column-1 ul li { padding: 0; margin: 5px 0; }
    .multi-column-1 label { font-weight: bold; }
    .multi-column-1 input,.multi-column-1 select { width: 100%; padding: 5px 10px; }
    .multi-column-2 { width: 70%; float: left; }
    .columns { width: 24%; float: left; border-right: 1px solid #ccc;  }
    .columns ul { margin: 0; padding: 0; }
    .columns ul h2 { font-weight: bold; font-size: 16px; color: #333; text-align: center; padding: 2px 5px; }
    .clear { clear: both; height: 0; margin: 0; padding: 0; }
    .multi-column-2 .columns { width: 100%; }
    .thumbnail { width: 30px; height: 30px;}
    .result-box { height: 50px; padding: 5px; margin: 2px 0; border-bottom: 1px solid #E1E1E1; overflow: hidden; }
    .result-box:hover { background-color: #EEEEEE; }
    .result-box a { color: #000; text-decoration: none; }
    .result-box mark { bac kground-color: #FAD1C9; }
    .result-box p { margin: 0; padding: 0; line-height: 1.2em; }
    .result-box p img { float: left; vertical-align: text-top; margin-right: 5px; }
    .result-box p sub { font-size: 12px; color: #666; line-height: 1.2em; }
    .submit-button, .load-more-button { background: #DE1A25; border: 1px solid #DE1A25; color: #fff; font-weight: bold; width: 100%; padding: 2px;
    cursor: pointer; text-align: center; }
    .submit-button:hover, .load-more-button:hover { background-color: #D0121A; }
</style>
<div class="wrapper">
    <?php
    //echo($SearchScope);
    ?>
    <?php if($SearchFilter==1) : ?>
        <div class="column-1 multi-column-1">
        <h2>Advanced Search</h2>
        <?php echo $this->Form->create(null, array('url' => '/users_profiles/search_result/', 'name' => 'searchform', 'id' => 'searchform')); ?>
        <ul>
<!--            <li><?php /*echo $this->Form->input('search string', array(
                    'label' => 'Search Keyword',
                    'div'=>false,
                    'class' => '',
                    'placeholder' => 'Search...',
                    'name' => 'search_str',
                    'id' => 'search_str2',
                    'value' => $SearchString
                    )); ?></li>
            <li><?php 
                echo $this->Form->input(null, array('options' => array(
                    '0' => 'All',
                    '1' => 'People',
                    '2' => 'Jobs',
                    '3' => 'Company',
                    '4' => 'Groups'
                    ), 'default' => '0', 'id' => 'SearchScope', 'name' => 'SearchScope' ,'label' => false, 'div'=>false, 'selected' => $SearchScope));*/ ?></li>-->
            <li><?php echo $this->Form->input('Location',array('options'=>array(''=>'All',$countryList),'name'=>'location','id'=>'location','label'=>'Location','div'=>false,'class'=>'','selected' => $country)); ?></li>
            <?php if ($SearchScope ==1 ){ ?>
            <li><?php echo $this->Form->input('Nationality',array('options'=>array(''=>'All',$countryList),'name'=>'nationality','id'=>'nationality','label'=>'Nationality','div'=>false,'class'=>'','selected' => $nationality)); ?></li>
            <?php } ?>
            <?php if ($SearchScope ==2 ){ ?>
            <li><?php echo $this->Form->input('Functional Area',array('options'=>array(''=>'All',$FunctionalAreaList),'name'=>'functionalArea','id'=>'functionalArea','label'=>'Functional Area','div'=>false,'class'=>'','selected' => $functionalArea)); ?></li>
            <?php } ?>
            <?php if ($SearchScope ==3 ){ ?>
            <li><?php echo $this->Form->input('Companies Type',array('options'=>array(''=>'All',$CompaniesTypeList),'name'=>'companies','id'=>'companies','label'=>'Type','div'=>false,'class'=>'','selected' => $companies)); ?></li>
            <li><?php echo $this->Form->input('Company Operating Status',array('options'=>array(''=>'All',$CompanyOperatingStatusList),'name'=>'company_operating_status','id'=>'company_operating_status','label'=>'Operating Status','div'=>false,'class'=>'','selected' => $company_operating_status)); ?></li>
            <li><?php echo $this->Form->input('Industry',array('options'=>array(''=>'All',$IndustryList),'name'=>'industry','id'=>'industry','label'=>'Industry','div'=>false,'class'=>'','selected' => $industry)); ?></li>
            <?php } ?>
            <?php if ($SearchScope ==4 ){ ?>
            <li><?php echo $this->Form->input('Groups',array('options'=>array(''=>'All Groups',$GroupsTypeList),'name'=>'groups','id'=>'groups','label'=>"Groups",'div'=>false,'class'=>'','selected' => $group)); ?></li>
            <?php } ?>
            <li><br/><?php echo $this->Form->submit('Submit', array('type' => 'submit', 'label' => false, 'class'=>'submit-button')); ?></li>
        </ul>
        <?php echo $this->Form->hidden('search_str',array('value' => $SearchString?$SearchString:'','name'=>'search_str','id'=>'search_str1'));?>
        <?php echo $this->Form->hidden('SearchScope',array('value' => $SearchScope?$SearchScope:'','name'=>'SearchScope','id'=>'SearchScope1'));?>
        <?php echo $this->Form->end(); ?>
    </div>
    <div class="column-2 <?=($SearchFilter==1)?'multi-column-2':'sinlge-column'?>">
        <?php if(!empty($datauser)): ?>
        <div class="columns sinlge-column">
            <ul>
                <h2>People</h2>
            <?php foreach ($datauser as $data): ?>
                <?php
                $FullName = $data['Users_profile']['firstname'].' '.$data['Users_profile']['lastname'];
                ?>
                <li class="result-box">
                    <p>
                    <?php if ($data['users_profiles']['photo'] !='') echo $this->Html->image('/files/users/'.$data['users_profiles']['photo'],array('class'=>'thumbnail'));
                    else echo $this->Html->image('user-icon.png',array('class'=>'thumbnail')); ?>
                    <a href="<?= $this->request->base ?>/users_profiles/userprofile/<?=$data['Users_profile']['id']?>"><?php echo "<b>".str_ireplace ($SearchString, '<mark>'.$SearchString.'</mark>', $FullName)." ".$data['Users_profile']['lastname']."</b>"; ?></a>
                    <br/><sub><?php echo $data['Country']['name'];?></sub>
                    </p>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <?php if(!empty($datajobs)): ?>
        <div class="columns sinlge-column">
            <ul>
                <h2>Jobs</h2>
            <?php foreach ($datajobs as $data): ?>
                <li class="result-box">
                    <p>
                    <?php if ($data['Company']['logo'] !='') echo $this->Html->image('/files/users/'.$data['Company']['logo'],array('class'=>'thumbnail'));
                    else echo $this->Html->image('no-image.png',array('class'=>'thumbnail')); ?>
                    <a href="http://jobs.networkwe.com/search/jobDetails/<?php echo $data['Job']['id'];?>"><?php echo "<b>"; if(strlen($data['Job']['title'])>19) echo substr($data['Job']['title'],0,20); else echo $data['Job']['title']; echo "</b>"; ?></a><br/>
                    <sub><?php //echo $data['Job']['city'];?><?php echo $data['Country']['name'];?></sub>
                    </p>
<!--                    <a href="http://jobs.networkwe.com/search/jobDetails/<?php echo $data['Job']['id'];?>"><?php echo "<b>".$data['Job']['title']."</b>"; ?></a>
                    <p>
                        <img src="<?php (empty($data['Company']['logo'])) ?'/networkwe/img/no-image.png': '/files/users/'.$data['Company']['logo']; ?>"/>
                        <?php echo $data['Company']['name'];?> - <?php echo $data['Job']['city'];?> - <?php echo $data['Country']['name'];?>
                    </p>-->
                    <?php //echo "<li class='".$class."'>".$this->Html->image($jobsite.'/img/company_logos/'.$row['Company']['logo'],array('class'=>'compLogo'))."<div class='leftrow'>".$this->Html->link($row['Job']['title'],'http://jobs.localhost.com/search/jobDetails/'.$row['Job']['id'],array('escape'=>false,'class'=>'resultTitle'))."</a><div id='jobsDesc'>".$this->Html->Image('company-icon.png',array('width'=>16))."&nbsp;&nbsp;".$row['Company']['title']."</div></div><div style='clear:both'></div></li>";?>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <?php if(!empty($datacompany)): ?>
        <div class="columns sinlge-column">
            <ul>
                <h2>Companies</h2>
            <?php foreach ($datacompany as $data): ?>
                <li class="result-box">
                    <p>
                    <?php if ($data['Company']['logo'] !='') echo $this->Html->image('/files/users/'.$data['Company']['logo'],array('class'=>'thumbnail'));
                    else echo $this->Html->image('no-image.png',array('class'=>'thumbnail')); ?>
                    <a href="<?= $this->request->base ?>/companies/view/<?php echo $data['Company']['id'];?>"><?php echo "<b>"; if(strlen($data['Company']['title'])>19) echo substr($data['Company']['title'],0,20); else echo $data['Company']['title']; echo "</b>"; ?></a><br/>
                    <sub><?php echo $data['Country']['name']?$data['Country']['name']:'N/A';?></sub>
                    </p>
<!--                    <a href="/companies/view/<?php echo $data['Company']['id'];?>"><?php echo "<b>".$data['Company']['title']."</b>"; ?></a>-->
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <?php if(!empty($datagroups)): ?>
        <div class="columns sinlge-column">
            <ul>
                <h2>Groups</h2>
            <?php foreach ($datagroups as $data): ?>
                <li class="result-box">
                    <p>
                    <?php if ($data['Group']['logo'] !='') echo $this->Html->image('/files/users/'.$data['Group']['logo'],array('class'=>'thumbnail'));
                    else echo $this->Html->image('no-image.png',array('class'=>'thumbnail')); ?>
                    <a href="<?= $this->request->base ?>/companies/view/<?php echo $data['Group']['id'];?>"><?php echo "<b>"; if(strlen($data['Group']['title'])>19) echo substr($data['Group']['title'],0,20); else echo $data['Group']['title']; echo "</b>"; ?></a><br/>
                    <sub><?php echo $data['groups_types']['title'];?></sub>
                    </p>
<!--                    <a href="/groups/view/<?php echo $data['Group']['id'];?>"><?php echo "<b>".$data['Group']['title']."</b>"; ?></a>-->
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <br class="clear" />
        <div class="submit-button" id="load-more" onclick="MoreItems(5,5)">Load More</div>
    </div>
    <?php else: ?>
    <div class="column-2 <?=($SearchFilter==1)?'multi-column-2':'sinlge-column'?>">
        <div class="columns">
            <ul>
                <h2>People</h2>
            <?php foreach ($datauser as $data): ?>
                
                <li class="result-box">
                    <p>
                    <?php if ($data['users_profiles']['photo'] !='') echo $this->Html->image('/files/users/'.$data['users_profiles']['photo'],array('class'=>'thumbnail'));
                    else echo $this->Html->image('user-icon.png',array('class'=>'thumbnail')); ?>
                    <a href="<?= $this->request->base ?>/users_profiles/userprofile/<?=$data['Users_profile']['id']?>"><?php echo "<b>".$data['Users_profile']['firstname']." ".$data['Users_profile']['lastname']."</b>"; ?></a>
                    </p>
                </li>
            <?php endforeach; ?>
            </ul>
            
            <?php 
            if($SearchScope==0){
            echo $this->Form->create(null, array('url' => '/users_profiles/search_result/', 'name' => 'searchformpeople', 'id' => 'searchformpeople'));
            echo $this->Form->hidden('SearchScope',array('value' => '1','name'=>'SearchScope','id'=>'SearchScope11'));
            echo $this->Form->submit('More People', array('type' => 'submit', 'label' => false, 'div' => false, 'class' => 'load-more-button'));
            echo $this->Form->end();
            }
            ?>
        </div>
        <div class="columns">
            <ul>
                <h2>Jobs</h2>
            <?php foreach ($datajobs as $data): ?>
                <li class="result-box">
                    <p>
                    <?php if ($data['Company']['logo'] !='') echo $this->Html->image('/files/users/'.$data['Company']['logo'],array('class'=>'thumbnail'));
                    else echo $this->Html->image('no-image.png',array('class'=>'thumbnail')); ?>
                    <a href="http://jobs.networkwe.com/search/jobDetails/<?php echo $data['Job']['id'];?>"><?php echo "<b>"; if(strlen($data['Job']['title'])>19) echo substr($data['Job']['title'],0,20); else echo $data['Job']['title']; echo "</b>"; ?></a><br/>
                    <sub><?php //echo $data['Job']['city'];?><?php echo $data['Country']['name'];?></sub>
                    </p>
<!--                    <a href="http://jobs.networkwe.com/search/jobDetails/<?php echo $data['Job']['id'];?>"><?php echo "<b>".$data['Job']['title']."</b>"; ?></a>
                    <p>
                        <img src="<?php (empty($data['Company']['logo'])) ?'/networkwe/img/no-image.png': '/files/users/'.$data['Company']['logo']; ?>"/>
                        <?php echo $data['Company']['name'];?> - <?php echo $data['Job']['city'];?> - <?php echo $data['Country']['name'];?>
                    </p>-->
                    <?php //echo "<li class='".$class."'>".$this->Html->image($jobsite.'/img/company_logos/'.$row['Company']['logo'],array('class'=>'compLogo'))."<div class='leftrow'>".$this->Html->link($row['Job']['title'],'http://jobs.localhost.com/search/jobDetails/'.$row['Job']['id'],array('escape'=>false,'class'=>'resultTitle'))."</a><div id='jobsDesc'>".$this->Html->Image('company-icon.png',array('width'=>16))."&nbsp;&nbsp;".$row['Company']['title']."</div></div><div style='clear:both'></div></li>";?>
                </li>
            <?php endforeach; ?>
            </ul>
            <?php 
            if($SearchScope==0){
            echo $this->Form->create(null, array('url' => '/users_profiles/search_result/', 'name' => 'searchformjobs', 'id' => 'searchformjobs'));
            echo $this->Form->hidden('SearchScope',array('value' => '2','name'=>'SearchScope','id'=>'SearchScope2'));
            echo $this->Form->submit('More Jobs', array('type' => 'submit', 'label' => false, 'div' => false, 'class' => 'load-more-button'));
            echo $this->Form->end();
            }
            ?>
        </div>
        <div class="columns">
            <ul>
                <h2>Companies</h2>
            <?php foreach ($datacompany as $data): ?>
                <li class="result-box">
                    <p>
                    <?php if ($data['Company']['logo'] !='') echo $this->Html->image('/files/users/'.$data['Company']['logo'],array('class'=>'thumbnail'));
                    else echo $this->Html->image('no-image.png',array('class'=>'thumbnail')); ?>
                    <a href="<?= $this->request->base ?>/companies/view/<?php echo $data['Company']['id'];?>"><?php echo "<b>"; if(strlen($data['Company']['title'])>19) echo substr($data['Company']['title'],0,20); else echo $data['Company']['title']; echo "</b>"; ?></a><br/>
                    <sub><?php echo $data['Country']['name']?$data['Country']['name']:'N/A';?></sub>
                    </p>
<!--                    <a href="/companies/view/<?php echo $data['Company']['id'];?>"><?php echo "<b>".$data['Company']['title']."</b>"; ?></a>-->
                </li>
            <?php endforeach; ?>
            </ul>
            <?php 
            if($SearchScope==0){
            echo $this->Form->create(null, array('url' => '/users_profiles/search_result/', 'name' => 'searchformcompanies', 'id' => 'searchformcompanies'));
            echo $this->Form->hidden('SearchScope',array('value' => '3','name'=>'SearchScope','id'=>'SearchScope3'));
            echo $this->Form->submit('More Companies', array('type' => 'submit', 'label' => false, 'div' => false, 'class' => 'load-more-button'));
            echo $this->Form->end();
            }
            ?>
        </div>
        <div class="columns">
            <ul>
                <h2>Groups</h2>
            <?php foreach ($datagroups as $data): ?>
                <li class="result-box">
                    <p>
                    <?php if ($data['Group']['logo'] !='') echo $this->Html->image('/files/users/'.$data['Group']['logo'],array('class'=>'thumbnail'));
                    else echo $this->Html->image('no-image.png',array('class'=>'thumbnail')); ?>
                    <a href="<?= $this->request->base ?>/companies/view/<?php echo $data['Group']['id'];?>"><?php echo "<b>"; if(strlen($data['Group']['title'])>19) echo substr($data['Group']['title'],0,20); else echo $data['Group']['title']; echo "</b>"; ?></a><br/>
                    <sub><?php echo $data['groups_types']['title'];?></sub>
                    </p>
<!--                    <a href="/groups/view/<?php echo $data['Group']['id'];?>"><?php echo "<b>".$data['Group']['title']."</b>"; ?></a>-->
                </li>
            <?php endforeach; ?>
            </ul>
            <?php 
            if($SearchScope==0){
            echo $this->Form->create(null, array('url' => '/users_profiles/search_result/', 'name' => 'searchformgroups', 'id' => 'searchformgroups'));
            echo $this->Form->hidden('SearchScope',array('value' => '4','name'=>'SearchScope','id'=>'SearchScope4'));
            echo $this->Form->submit('More Groups', array('type' => 'submit', 'label' => false, 'div' => false, 'class' => 'load-more-button'));
            echo $this->Form->end();
            }
            ?>
        </div>
        
    </div>
    <?php endif; ?>

    <br class="clear">
</div>
<script type="text/javascript">
    function MoreItems(limit,offset){
        var data;
        $.ajaxSetup({
            beforeSend:function(){$("#load-more").html('Please wait...');},
            complete:function(){$("#load-more").html('Load More');}
        });
        $.ajax({
            dataType: "html",type: "POST",evalScripts: true,
            url:"<?php echo $this->webroot; ?>users_profiles/search_result/"+limit+"/"+offset+"/"+$('#SearchScope').val(),
            data: ({
                SearchScope:$('#SearchScope').val(),
                search_str: $( "#search_str" ).val(),
                location: $( "#location" ).val(),
                nationality: $( "#nationality" ).val(),
                functionalArea: $( "#functionalArea" ).val(),
                companies: $( "#companies" ).val(),
                company_operating_status: $( "#company_operating_status" ).val(),
                industry: $( "#industry" ).val(),
                groups: $( "#groups" ).val()
            }),
            success: function (data, textStatus){
                var item = $(data).hide().fadeIn(2000);
                $( ".result-box" ).parent().append(item);
                offset = limit + offset;
                var newvalues = "MoreItems("+limit+","+offset+")";  
                if(data)
                    $("#load-more").attr("onclick",newvalues);
                else
                    $("#load-more").css('display','none');
            }
        });
    }
jQuery(document).ready(function(){
    $('#zipsearch').autocomplete({source:'users/search', minLength:1});
});
</script>

