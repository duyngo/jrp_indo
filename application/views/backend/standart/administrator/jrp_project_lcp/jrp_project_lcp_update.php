
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
<?php $project_book = db_get_single_data('jrp_project_book','id='.$jrp_project_lcp->project_id ); ?>
<section class="content-header">
    <h1>
        Lighting Control Panel        <small>Edit Lighting Control Panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/jrp_project_lcp'); ?>">Lighting Control Panel</a></li>
        <li class="active">Edit</li>
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
                            <h3 class="widget-user-username"><?= _ent($project_book->name) ?></h3>
                            <h5 class="widget-user-desc">Edit Lighting Control Panel</h5>
                            <hr>
                        </div>
                        <?= form_open(base_url('administrator/jrp_project_lcp/edit_save/'.$this->uri->segment(4)), [
                            'name'    => 'form_jrp_project_lcp', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_jrp_project_lcp', 
                            'method'  => 'POST'
                            ]); ?>
                         
                        <div class="form-group ">
                            <label for="LCP_code" class="col-sm-2 control-label">LCP Code 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="LCP_code" id="LCP_code" placeholder="LCP Code" value="<?= set_value('LCP_code', $jrp_project_lcp->LCP_code); ?>">

                                <small class="info help-block">
                                <b>Input LCP Code</b> Max Length : 64.</small>
                            </div>
                        </div>
                                                 
                        <div class="form-group ">
                            <label for="type" class="col-sm-2 control-label">Type 

                            </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="type" id="type" placeholder="Type" value="<?= set_value('type', $jrp_project_lcp->type); ?>">
                                <small class="info help-block">
                                <b>Input Type</b> Max Length : 11.</small>
                            </div>
                        </div>
                                                 
                        <div class="form-group ">
                            <label for="lcp_layout" class="col-sm-2 control-label">Lcp Layout 

                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="lcp_layout" id="lcp_layout" placeholder="Lcp Layout" value="<?= set_value('lcp_layout', $jrp_project_lcp->lcp_layout); ?>">
                                <small class="info help-block">
                                <b>Input Lcp Layout</b> Max Length : 128.</small>
                            </div>
                        </div>
                                                 
                        <div class="form-group ">
                            <label for="location" class="col-sm-2 control-label">Location 

                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="location" id="location" placeholder="Location" value="<?= set_value('location', $jrp_project_lcp->location); ?>">
                                <small class="info help-block">
                                <b>Input Location</b> Max Length : 128.</small>
                            </div>
                        </div>
                                                 
                        <div class="form-group ">
                            <label for="area" class="col-sm-2 control-label">Area 

                            </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="area" id="area" placeholder="Area" value="<?= set_value('area', $jrp_project_lcp->area); ?>">
                                <small class="info help-block">
                                <b>Input Area</b> Max Length : 11.</small>
                            </div>
                        </div>
                                                 
                        <div class="form-group ">
                            <label for="control_area_name" class="col-sm-2 control-label">Control Area Name 

                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="control_area_name" id="control_area_name" placeholder="Control Area Name" value="<?= set_value('control_area_name', $jrp_project_lcp->control_area_name); ?>">
                                <small class="info help-block">
                                <b>Input Control Area Name</b> Max Length : 128.</small>
                            </div>
                        </div>
                                                 
                        <div class="form-group ">
                            <label for="note" class="col-sm-2 control-label">Note 

                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="note" id="note" placeholder="Note" value="<?= set_value('note', $jrp_project_lcp->note); ?>">
                                <small class="info help-block">
                                <b>Input Note</b> Max Length : 256.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="LCP_code" class="col-sm-2 control-label">LCP Finish

                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="lcp_finish" id="lcp_finish" placeholder="LCP Code" maxlength="64" value="<?= set_value('lcp_finish',$jrp_project_lcp->lcp_finish); ?>">
                                <small class="info help-block">
                                    <b>Input LCP Finish</b> Max Length : 64.</small>
                            </div>
                        </div>

                        <input type="hidden" name="project_id" value="<?= $project_book->id ?>" />
                                                
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
            title: "Are you sure?",
            text: "the data that you have created will be in the exhaust!",
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
              window.location.href = BASE_URL + 'administrator/jrp_project_lcp/index/<?= $project_book->id ?>';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_jrp_project_lcp = $('#form_jrp_project_lcp');
        var data_post = form_jrp_project_lcp.serializeArray();
        var save_type = $(this).attr('data-stype');
        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: form_jrp_project_lcp.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id = $('#jrp_project_lcp_image_galery').find('li').attr('qq-file-id');
            if (save_type == 'back') {
              window.location.href = res.redirect;
              return;
            }
    
            $('.message').printMessage({message : res.message});
            $('.message').fadeIn();
            $('.data_file_uuid').val('');
    
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