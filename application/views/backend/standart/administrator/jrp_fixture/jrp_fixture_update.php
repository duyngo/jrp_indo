
<!-- Fine Uploader Gallery CSS file
    ====================================================================== -->
<link href="<?= BASE_ASSET; ?>/fine-upload/fine-uploader-gallery.min.css" rel="stylesheet">
<!-- Fine Uploader jQuery JS file
    ====================================================================== -->
<script src="<?= BASE_ASSET; ?>/fine-upload/jquery.fine-uploader.js"></script>
<?php $this->load->view('core_template/fine_upload'); ?>
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
<section class="content-header">
    <h1>
        Fixture        <small>Edit Fixture</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/jrp_fixture'); ?>">Fixture</a></li>
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
                            <h3 class="widget-user-username">Fixture</h3>
                            <h5 class="widget-user-desc">Edit Fixture</h5>
                            <hr>
                        </div>
                        <?= form_open(base_url('administrator/jrp_fixture/edit_save/'.$this->uri->segment(4)), [
                            'name'    => 'form_jrp_fixture', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_jrp_fixture', 
                            'method'  => 'POST'
                            ]); ?>
                         
                                                <div class="form-group ">
                            <label for="code" class="col-sm-2 control-label">Code 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="code" id="code" placeholder="Code" value="<?= set_value('code', $jrp_fixture->code); ?>">
                                <small class="info help-block">
                                <b>Input Code</b> Max Length : 5.</small>
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label class="col-sm-2 control-label">Component <i class="required">*</i></label>
                            <div class="col-sm-8">
                                <div class="box box-primary">
                                    <div id="product-details" class="box-body">
                                        <button id="add" type="button" id="show-modal" class="btn btn-primary" data-toggle="modal" data-target="#modal-detail">Add Component </button>
                                        <br/>
                                        <table class="table table-striped" data-number="" id="dynamic-field-product">
                                            <thead>
                                                <tr>
                                                    <th>Component</th>
                                                    <th>Component Qty</th>
                                                    <th>Watt</th>
                                                    <th>Catalogue</th>
                                                    <th>Finish</th>
                                                    <th>Dimension</th>
                                                    <th>Notes</th>
                                                    <th class="dl-no">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <small class="info help-block"></small>
                            </div>
                        </div>                         
                        
                        <div class="form-group ">
                            <label for="image_ref" class="col-sm-2 control-label">Image Ref 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <div id="jrp_fixture_image_ref_galery"></div>
                                <input class="data_file data_file_uuid" name="jrp_fixture_image_ref_uuid" id="jrp_fixture_image_ref_uuid" type="hidden" value="<?= set_value('jrp_fixture_image_ref_uuid'); ?>">
                                <input class="data_file" name="jrp_fixture_image_ref_name" id="jrp_fixture_image_ref_name" type="hidden" value="<?= set_value('jrp_fixture_image_ref_name', $jrp_fixture->image_ref); ?>">
                                <small class="info help-block">
                                <b>Input Image Ref</b> Max Length : 512.</small>
                            </div>
                        </div>
                                                 
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
              window.location.href = BASE_URL + 'administrator/jrp_fixture';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_jrp_fixture = $('#form_jrp_fixture');
        var data_post = form_jrp_fixture.serializeArray();
        var save_type = $(this).attr('data-stype');
        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: form_jrp_fixture.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id = $('#jrp_fixture_image_galery').find('li').attr('qq-file-id');
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
      
                     var params = {};
       params[csrf] = token;

       $('#jrp_fixture_image_ref_galery').fineUploader({
          template: 'qq-template-gallery',
          request: {
              endpoint: BASE_URL + '/administrator/jrp_fixture/upload_image_ref_file',
              params : params
          },
          deleteFile: {
              enabled: true, // defaults to false
              endpoint: BASE_URL + '/administrator/jrp_fixture/delete_image_ref_file'
          },
          thumbnails: {
              placeholders: {
                  waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                  notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
              }
          },
           session : {
             endpoint: BASE_URL + 'administrator/jrp_fixture/get_image_ref_file/<?= $jrp_fixture->id; ?>',
             refreshOnRequest:true
           },
          multiple : false,
          validation: {
              allowedExtensions: ["*"],
              sizeLimit : 0,
                        },
          showMessage: function(msg) {
              toastr['error'](msg);
          },
          callbacks: {
              onComplete : function(id, name, xhr) {
                if (xhr.success) {
                   var uuid = $('#jrp_fixture_image_ref_galery').fineUploader('getUuid', id);
                   $('#jrp_fixture_image_ref_uuid').val(uuid);
                   $('#jrp_fixture_image_ref_name').val(xhr.uploadName);
                } else {
                   toastr['error'](xhr.error);
                }
              },
              onSubmit : function(id, name) {
                  var uuid = $('#jrp_fixture_image_ref_uuid').val();
                  $.get(BASE_URL + '/administrator/jrp_fixture/delete_image_ref_file/' + uuid);
              },
              onDeleteComplete : function(id, xhr, isError) {
                if (isError == false) {
                  $('#jrp_fixture_image_ref_uuid').val('');
                  $('#jrp_fixture_image_ref_name').val('');
                }
              }
          }
      }); /*end image_ref galey*/
              
       
           
    
    }); /*end doc ready*/
</script>