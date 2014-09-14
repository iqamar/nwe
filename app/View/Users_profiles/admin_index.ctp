<?php 
$this->Html->addCrumb(' Dashboard', '/admin');
$this->Html->addCrumb(' Users', array('controller' => 'users_profiles', 'action' => 'index'));
echo $this->element('Siteadmin/breadcrumb'); ?>
<?php //$this->Html->script(MEDIA_URL . "/backend/js/jquery.dataTables.new.js", null, array("inline"=>false)); ?>
<?php //$this->Html->css(MEDIA_URL . "backend/jquery.dataTables", null, array("inline"=>false)); ?>
<div class="row-fluid sortable">
    <div class="box span12">
	<div class="box-header well" data-original-title>
	    <h2><i class="icon-user"></i> Members</h2>

	</div>
	<div class="box-content">
            <table id="datatableDiv" class="display table table-striped table-bordered bootstrap-datatable datatable" cellspacing="0" width="100%">
                    <thead>
                            <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Title</th>
                                    <th>City</th>
                                    <th>Joining date</th>
                                    <th>Action</th>
                            </tr>
                    </thead>

                    <!--<tfoot>
                            <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                    <th>Extn.</th>
                                    <th>Start date</th>
                                    <th>Actions</th>
                            </tr>
                    </tfoot>-->
            </table>
            
            
            
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
            "order": [[ 4, "desc" ]],
            "ajax": $.fn.dataTable.pipeline({
                url: '<?= NETWORKWE_URL ?>/admin/users_profiles/users_list/',
                pages: 5 // number of pages to cache
            }),
            "aoColumnDefs": [ {
                            "aTargets": [5],
                            "mData": null,
                            "mRender": function (data, type, full) {
                                return '\
                                <div class="btn-group">\n\
                                <a href="<?= NETWORKWE_URL ?>/admin/users_profiles/view/'+ full[5] +'" class="btn"><i class="icon-zoom-in"></i></a>\n\
                                <a href="<?= NETWORKWE_URL ?>/admin/users_profiles/edit/'+ full[5] +'" class="btn"><i class="icon-pencil"></i></a>\n\
                                <a onclick="if (confirm(&quot;Are you sure you wish to delete this Record?&quot;)) { return true; } return false;" href="<?= NETWORKWE_URL ?>/admin/users_profiles/delete/'+ full[5] +'" class="btn btn-danger"><i class="icon-trash icon-white"></i></a></div>\n\
                                ';
                            }
                        }
                    ]
        });

    });
</script>