<?php 
$this->Html->addCrumb(' Dashboard', '/admin');
$this->Html->addCrumb(' News', array('controller' => 'news', 'action' => 'index'));
echo $this->element('Siteadmin/breadcrumb'); ?>
<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> News</h2>
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-plus icon-white')) . " Add", array('action' => 'add'), array('class' => 'btn btn-primary span1 pull-right', 'escape' => false)); ?> 
            <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-tasks icon-white')) . " Manage News Categories", array('action' => 'categories'), array('class' => 'btn btn-info pull-right', 'escape' => false)); ?>
	</div>
	<div class="box-content">
            <table id="datatableDiv" class="display table table-striped table-bordered bootstrap-datatable datatable" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th style="width: 100px;">Posted Date</th>
                        <th style="width: 100px;">Action</th>
                    </tr>
                </thead>
            </table>
	    <?php /*<table class="table table-striped table-bordered bootstrap-datatable datatable">
		<thead>
		    <tr>
			<th>Heading</th>
<!--			<th>Status</th>-->
			<th>Actions</th>
		    </tr>
		</thead>
		<tbody>
		    <?php foreach ($news as $data): ?>
    		    <tr>
    			<td>
                            <strong class="muted"><?php echo $this->Html->link($data['News']['heading'], array('action' => 'view', $data['News']['id'])); ?></strong>
                            <br/><small>Posted on: <?php echo date("M d, Y", strtotime($data['News']['created']));?></small> 
                            <?php  echo ($data['News']['publish'] != 1)? ' - <span class="alert alert-error">In-active</span>':''; ?> 
                        </td>
<!--    			<td class="center">
                            <?php
                            if ($data['News']['publish'] == 1) {
                                echo '<span class="label label-success">Active</span>';
                            } else {
                                echo '<span class="label">In Active</span>';
                            }
                            ?>
    			</td>-->
    			<td class="center" nowrap>
                            <div class="btn-group">
                            <?php
                            echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-zoom-in')), array('action' => 'view', $data['News']['id']), array('class' => 'btn', 'escape' => false));
                            //echo "&nbsp;";
                            echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-pencil')), array('action' => 'edit', $data['News']['id']), array('class' => 'btn', 'escape' => false));
                            //echo "&nbsp;";
                            echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-trash icon-white')), array('action' => 'delete', $data['News']['id']), array('class' => 'btn btn-danger', 'escape' => false), "Are you sure you wish to delete this article?");
                            ?>
                            </div>
    			</td>
    		    </tr>
		    <?php endforeach; ?>
		</tbody>
	    </table> */ ?>
	</div>
    </div><!--/span-->
</div><!--/row-->
<script type="text/javascript" language="javascript" class="init">
    //
    // Pipelining function for DataTables. To be used to the `ajax` option of DataTables
    //
    $.fn.dataTable.pipeline = function ( opts ) {
        // Configuration options
        var conf = $.extend( {
                pages: 5,     // number of pages to cache
                url: '',      // script url
                data: null,   // function or object with parameters to send to the server
                              // matching how `ajax.data` works in DataTables
                method: 'GET' // Ajax HTTP method
        }, opts );

        // Private variables for storing the cache
        var cacheLower = -1;
        var cacheUpper = null;
        var cacheLastRequest = null;
        var cacheLastJson = null;

        return function ( request, drawCallback, settings ) {
                var ajax          = false;
                var requestStart  = request.start;
                var requestLength = request.length;
                var requestEnd    = requestStart + requestLength;
		
                if ( settings.clearCache ) {
                        // API requested that the cache be cleared
                        ajax = true;
                        settings.clearCache = false;
                }
                else if ( cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper ) {
                        // outside cached data - need to make a request
                        ajax = true;
                }
                else if ( JSON.stringify( request.order )   !== JSON.stringify( cacheLastRequest.order ) ||
                          JSON.stringify( request.columns ) !== JSON.stringify( cacheLastRequest.columns ) ||
                          JSON.stringify( request.search )  !== JSON.stringify( cacheLastRequest.search )
                ) {
                        // properties changed (ordering, columns, searching)
                        ajax = true;
                }
		
                // Store the request for checking next time around
                cacheLastRequest = $.extend( true, {}, request );

                if ( ajax ) {
                        // Need data from the server
                        if ( requestStart < cacheLower ) {
                                requestStart = requestStart - (requestLength*(conf.pages-1));

                                if ( requestStart < 0) {
                        requestStart = 0;
                    }
                }

                cacheLower = requestStart;
                cacheUpper = requestStart + (requestLength * conf.pages);

                request.start = requestStart;
                request.length = requestLength * conf.pages;

                // Provide the same `data` options as DataTables.
                if ($.isFunction(conf.data)) {
                    // As a function it is executed with the data object as an arg
                    // for manipulation. If an object is returned, it is used as the
                    // data object to submit
                    var d = conf.data(request);
                    if (d) {
                        $.extend(request, d);
                    }
                }
                else if ($.isPlainObject(conf.data)) {
                    // As an object, the data given extends the default
                    $.extend(request, conf.data);
                }

                settings.jqXHR = $.ajax({
                    "type": conf.method,
                    "url": conf.url,
                    "data": request,
                    "dataType": "json",
                    "cache": false,
                    "success": function(json) {
                        cacheLastJson = $.extend(true, {}, json);

                        if (cacheLower != requestStart) {
                            json.data.splice(0, requestStart - cacheLower);
                        }
                        json.data.splice(requestLength, json.data.length);

                        drawCallback(json);
                    }
                });
            }
            else {
                json = $.extend(true, {}, cacheLastJson);
                json.draw = request.draw; // Update the echo for each response
                json.data.splice(0, requestStart - cacheLower);
                json.data.splice(requestLength, json.data.length);

                drawCallback(json);
            }
        }
    };
    
    // Register an API method that will empty the pipelined data, forcing an Ajax
    // fetch on the next draw (i.e. `table.clearPipeline().draw()`)
    $.fn.dataTable.Api.register( 'clearPipeline()', function () {
            return this.iterator( 'table', function ( settings ) {
                    settings.clearCache = true;
            } );
    } );

    //
    // DataTables initialisation
    //
    $(document).ready(function() {
        $('#datatableDiv').dataTable({
            "processing": true,
            "serverSide": true,
            "order": [[ 1, "desc" ]],
            "ajax": $.fn.dataTable.pipeline({
                url: '<?= NETWORKWE_URL ?>/admin/news/datatable_source/',
                pages: 5 // number of pages to cache
            }),
            "aoColumnDefs": [ {
                            "aTargets": [2],
                            "mData": null,
                            "mRender": function (data, type, full) {
                                return '\
                                <div class="btn-group">\n\
                                <a href="<?= NETWORKWE_URL ?>/admin/news/view/'+ full[2] +'" class="btn"><i class="icon-zoom-in"></i></a>\n\
                                <a href="<?= NETWORKWE_URL ?>/admin/news/edit/'+ full[2] +'" class="btn"><i class="icon-pencil"></i></a>\n\
                                <a onclick="if (confirm(&quot;Are you sure you wish to delete this Record?&quot;)) { return true; } return false;" href="<?= NETWORKWE_URL ?>/admin/news/delete/'+ full[2] +'" class="btn btn-danger"><i class="icon-trash icon-white"></i></a></div>\n\
                                ';
                            }
                        }
                    ]
        });

    });
</script>