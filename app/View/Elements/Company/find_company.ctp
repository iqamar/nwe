<div class="ttle-bar effectX">Search Company</div>
<div class="right-col-no-title" style="padding:10px;">
	<ul class="factes">
    	<li class="searchby">
        	<fieldset>
            	<legend>Location >></legend>
                <div class="factes-value-container">
                	<ul class="facet-values">
                    	<li class="facet-value">
                        	<input type="radio" value="0" id="all" name="all" checked="checked" onclick="return searchCompanies('0');" />
                        	<div class="label-container">
                            	<span class="facet-count" style="font-weight:bold;">(<?php echo $get_total_compay_countries;?>)</span>
                                <label class="facet-label" style="font-weight:bold;">All</label>
                            </div>
                        </li>
                        <?php foreach ($compay_countries_result as $country_name_row) {?>
                        <li class="facet-value">
                        	<input type="radio" value="<?php echo $country_name_row['countries']['id']?>" name="all" id="all"
                             onclick="return searchCompanies('<?php echo $country_name_row['countries']['id']?>');" />
                        	<div class="label-container">
                            	<span class="facet-count">(<?php echo $country_name_row[0]['ctotal']?>)</span>
                                <label class="facet-label"><?php echo $country_name_row['countries']['name']?></label>
                            </div>
                        </li>
                        <?php }?>
                        
                    </ul>
                </div>
            </fieldset>
        </li>
    </ul>
    					    
</div>
<script type="text/javascript">
	function searchCompanies(country_id) {

$.ajax({
              url     : baseUrl+"/companies/resultant_companies/",
              type    : "GET",
              cache   : false,
              data    : {country_id: country_id},
              success : function(data){
			  $("#search_result").html(data);
              },
			  error : function(data) {
           $("#search_result").html("there is error");
        }
          });
		  
}
</script>