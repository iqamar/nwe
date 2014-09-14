<script type="text/javascript">
function showSearch() {
if (document.getElementById('advcance-search').style.display == 'none') {
document.getElementById('advcance-search').style.display == 'block';
$('#advcance-search').slideToggle('slow');
$('#adv_search').removeClass('search-footer').addClass('search-ft-up');
}
else if (document.getElementById('advcance-search').style.display == 'block' || document.getElementById('advcance-search').style.display == '') {
$('#advcance-search').slideToggle('slow');
document.getElementById('advcance-search').style.display == '';
$('#adv_search').removeClass('search-ft-up').addClass('search-footer');

}
}
</script>

<div class="jobs">
<div class="search search-div">
<h2>Search for job</h2>
<div class="content">
<?php echo $this->Form->create("Search",array('controller' => 'jobs', 'action' => 'listing'));?>
<div class="icon"><img src="<?php echo $this->base;?>/img/search-icon.png" width="20" height="20" alt="seach icon" /></div>
<?php echo $this->Form->text('degree',array('required'=>true,'id'=>'search', 'class'=>'job-search-field')) ?>
<?php echo $this->Form->submit('Search', array('div' => false,'class' => 'submit', 'title' => 'Title')); ?>
<div class="advanced-search-fields" id="advcance-search" style="display:none;">
<?php echo $this->Form->create("Search",array('controller' => 'jobs', 'action' => 'listing'));?>
<div class="country field">
<label class="field-label">Country</label><br />
<?php $cate = array(1=>'United Arab Emirates', 2=>'Behrain', 3=>'Egypt', 4=>'Saudi Arabia', 5=>'Libnan', 6=>'Qatar', 8=>'Yamin') ?>
<?php echo $this->Form->select('country', array('options'=>$cate),array('empty'=>false, 'selected' =>'1', 'class'=>'job-country')) ?>
</div>

<div class="country field">
<label class="field-label">Company</label><br />
<?php $cate = array(1=>'Dubai Islamic Bank', 2=>'NBD', 3=>'ADIB', 4=>'National Bank', 5=>'Sharjah Bank', 6=>'Qatar Bank') ?>
<?php echo $this->Form->select('company', array('options'=>$cate),array('empty'=>false, 'selected' =>'1', 'class'=>'job-country')) ?>
</div>
<div class="country field">
<label class="field-label">Industry</label><br />
<ul class="industries">
<?php foreach ($indsut as $inds) {?>
<li><?php echo $this->Form->checkbox('industry',array('class'=>'check','style'=>'margin-bottom:5px; height:24px;','value'=>$inds['industries']['id']))?>
<label class="label"><?php echo $inds['industries']['industry']?></label>
</li>
<?php }?>
</ul>
</div>

<div class="country field">
<label class="field-label">Functions</label><br />
<ul class="industries">
<?php foreach ($functions as $func) {?>
<li><?php echo $this->Form->checkbox('functions',array('class'=>'check','style'=>'margin-bottom:5px; height:24px;','value'=>$func['functions']['id']))?>
<label class="label"><?php echo $func['functions']['function']?></label>
</li>
<?php }?>
</ul>
</div>
<?php echo $this->Form->submit('Search', array('div' => false,'class' => 'submit', 'title' => 'Title')); ?>
</div>
</div>
<div class="search-footer" id="adv_search" onclick="Javascript:showSearch();"><button class="toggle-advanced">Advance Search</button></div>
</div>
<div class="job-listing">
<div class="job_div">
<div class="job_image"><img src="<?php echo $this->base;?>/img/j3.png" width="100" height="110" alt="job1" /></div>
<div class="content_search_jobs"><div class="title_blue"><a href="#">IT Project Manager UAE</a></div>
<div class="grey_text">Our client is looking for an IT Project Manager-Arabic speaker ... More</div>
</div>
</div>
<hr class="job-hr" />

<div class="job_div">
<div class="job_image"><img src="<?php echo $this->base;?>/img/j2.png" width="100" height="110" alt="job1" /></div>
<div class="content_search_jobs"><div class="title_blue"><a href="#">Dynamic Archtic</a></div>
<div class="grey_text">Our client is looking for an Dynamic Archtic speaker ... More</div>
</div>
</div>
<hr class="job-hr" />
</div>

<div class="job-search">

</div>

</div>
