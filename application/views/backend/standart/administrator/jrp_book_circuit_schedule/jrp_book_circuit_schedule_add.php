
<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
    function domo(){
     
       // Binding keys
       $('*').bind('keydown', 'Ctrl+s', function assets() {
          $('#btn_save').trigger('click');
           return false;
       });
    
       $('*').bind('keydown', 'Ctrl+x', function assets() {
          $('#btn_cancel').trigger('click');
           return false;
       });
    
      $('*').bind('keydown', 'Ctrl+d', function assets() {
          $('.btn_save_back').trigger('click');
           return false;
       });
        
    }
    
    jQuery(document).ready(domo);
</script>
<!-- Content Header (Page header) -->
<?php $project_book = db_get_single_data('jrp_project_book','id='.$project_id);?>
<section class="content-header">
    <h1>
        Circuit Schedule        <small><?= cclang('new', ['Circuit Schedule']); ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/jrp_book_circuit_schedule'); ?>">Circuit Schedule</a></li>
        <li class="active"><?= cclang('new'); ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row" >
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-body ">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header ">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?= BASE_ASSET; ?>/img/add2.png" alt="User Avatar">
                            </div>
                            <!-- /.widget-user-image -->
                            <h3 class="widget-user-username"><?= $project_book-> name ?></h3>
                            <h5 class="widget-user-desc"><?= cclang('new', ['Circuit Schedule']); ?></h5>
                            <hr>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_jrp_book_circuit_schedule', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_jrp_book_circuit_schedule', 
                            'enctype' => 'multipart/form-data', 
                            'method'  => 'POST'
                            ]); ?>
                         
                                                <div class="form-group ">
                            <label for="circuit_id" class="col-sm-2 control-label">Circuit Id 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="circuit_id" id="circuit_id" data-placeholder="Select Circuit Id" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('jrp_book_circuit','project_id ='.$project_id) as $row): ?>
                                    <option value="<?= $row->id ?>"><?= $row->circuit; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                <b>Input Circuit Id</b> Max Length : 11.</small>
                            </div>
                        </div>

                                                 
                                                <div class="form-group ">
                            <label for="feed_from" class="col-sm-2 control-label">Feed From 

                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="feed_from" id="feed_from" placeholder="Feed From" value="<?= set_value('feed_from'); ?>">
                                <small class="info help-block">
                                <b>Input Feed From</b> Max Length : 128.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="dim_rack" class="col-sm-2 control-label">Dim Rack 

                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="dim_rack" id="dim_rack" placeholder="Dim Rack" value="<?= set_value('dim_rack'); ?>">
                                <small class="info help-block">
                                <b>Input Dim Rack</b> Max Length : 128.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="quantity" class="col-sm-2 control-label">Quantity 

                            </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="quantity" id="quantity" placeholder="Quantity" value="<?= set_value('quantity'); ?>">
                                <small class="info help-block">
                                <b>Input Quantity</b> Max Length : 11.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="fixtures" class="col-sm-2 control-label">Fixtures 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="fixtures" id="fixtures" data-placeholder="Select Fixtures" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('jrp_fixture') as $row): ?>
                                    <option value="<?= $row->id ?>"><?= $row->code; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                <b>Input Fixtures</b> Max Length : 11.</small>
                            </div>
                        </div>

                                                 
                                                <div class="form-group ">
                            <label for="AD" class="col-sm-2 control-label">AD 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
	                            
	                             <select  class="form-control chosen chosen-select-deselect" name="AD" id="AD" data-placeholder="Select AD" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('jrp_project_app_detail','project_id ='.$project_id) as $row): ?>
                                    <option value="<?= $row->id ?>"><?= $row->document_id; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                
                                <small class="info help-block">
                                <b>Input AD</b> Max Length : 128.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="load_type" class="col-sm-2 control-label">Load Type 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="load_type" id="load_type" data-placeholder="Select Load Type" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('jrp_mstr_load_type') as $row): ?>
                                    <option value="<?= $row->id ?>"><?= $row->name; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                
                                <input type="hidden" name="project_id" id="project_id" value="<?= $project_id ?>" />
                                <small class="info help-block">
                                <b>Input Load Type</b> Max Length : 20.</small>
                            </div>
                        </div>

                                                 
<!--
                                                <div class="form-group ">
                            <label for="project_id" class="col-sm-2 control-label">Project Id 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="project_id" id="project_id" data-placeholder="Select Project Id" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('jrp_project_book') as $row): ?>
                                    <option value="<?= $row->id ?>"><?= $row->name; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
-->

                                                
                        <div class="message"></div>
                        <div class="row-fluid col-md-7">
                           <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="<?= cclang('save_button'); ?> (Ctrl+s)">
                            <i class="fa fa-save" ></i> <?= cclang('save_button'); ?>
                            </button>
                            <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save" data-stype='back' title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)">
                            <i class="ion ion-ios-list-outline" ></i> <?= cclang('save_and_go_the_list_button'); ?>
                            </a>
                            <a class="btn btn-flat btn-default btn_action" id="btn_cancel" title="<?= cclang('cancel_button'); ?> (Ctrl+x)">
                            <i class="fa fa-undo" ></i> <?= cclang('cancel_button'); ?>
                            </a>
                            <span class="loading loading-hide">
                            <img src="<?= BASE_ASSET; ?>/img/loading-spin-primary.svg"> 
                            <i><?= cclang('loading_saving_data'); ?></i>
                            </span>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
                <!--/box body -->
            </div>
            <!--/box -->
        </div>
    </div>
</section>
<!-- /.content -->
<!-- Page script -->
<script>
    $(document).ready(function(){
                   
      $('#btn_cancel').click(function(){
        swal({
            title: "<?= cclang('are_you_sure'); ?>",
            text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            cancelButtonText: "No!",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
              window.location.href = BASE_URL + 'administrator/jrp_book_circuit_schedule/index/'+<?= $project_id ?>;
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_jrp_book_circuit_schedule = $('#form_jrp_book_circuit_schedule');
        var data_post = form_jrp_book_circuit_schedule.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: BASE_URL + '/administrator/jrp_book_circuit_schedule/add_save',
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            
            if (save_type == 'back') {
              window.location.href = res.redirect;
              return;
            }
    
            $('.message').printMessage({message : res.message});
            $('.message').fadeIn();
            resetForm();
            $('.chosen option').prop('selected', false).trigger('chosen:updated');
                
          } else {
            $('.message').printMessage({message : res.message, type : 'warning'});
          }
    
        })
        .fail(function() {
          $('.message').printMessage({message : 'Error save data', type : 'warning'});
        })
        .always(function() {
          $('.loading').hide();
          $('html, body').animate({ scrollTop: $(document).height() }, 2000);
        });
    
        return false;
      }); /*end btn save*/
      
       
 
       
    
    
    }); /*end doc ready*/
</script>