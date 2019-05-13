
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
        Component        <small>Edit Component</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/jrp_component'); ?>">Component</a></li>
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
                            <h3 class="widget-user-username">Component</h3>
                            <h5 class="widget-user-desc">Edit Component</h5>
                            <hr>
                        </div>
                        <?= form_open(base_url('administrator/jrp_component/edit_save/'.$this->uri->segment(4)), [
                            'name'    => 'form_jrp_component', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_jrp_component', 
                            'method'  => 'POST'
                            ]); ?>
                         
                                                <div class="form-group ">
                            <label for="name" class="col-sm-2 control-label">Name 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?= set_value('name', $jrp_component->name); ?>">
                                <small class="info help-block">
                                <b>Input Name</b> Max Length : 512.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="catalog_number" class="col-sm-2 control-label">Catalog Number 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="catalog_number" id="catalog_number" placeholder="Catalog Number" value="<?= set_value('catalog_number', $jrp_component->catalog_number); ?>">
                                <small class="info help-block">
                                <b>Input Catalog Number</b> Max Length : 128.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="manufacturer" class="col-sm-2 control-label">Manufacturer 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="manufacturer" id="manufacturer" data-placeholder="Select Manufacturer" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('jrp_manufacturer') as $row): ?>
                                    <option <?=  $row->id ==  $jrp_component->manufacturer ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->name; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>

                                                 
                                                <div class="form-group ">
                            <label for="finishing" class="col-sm-2 control-label">Finishing 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="finishing" id="finishing" placeholder="Finishing" value="<?= set_value('finishing', $jrp_component->finishing); ?>">
                                <small class="info help-block">
                                <b>Input Finishing</b> Max Length : 128.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="watt" class="col-sm-2 control-label">Watt 
                            </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="watt" id="watt" placeholder="Watt" value="<?= set_value('watt', $jrp_component->watt); ?>">
                                <small class="info help-block">
                                <b>Input Watt</b> Max Length : 11.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="width" class="col-sm-2 control-label">Width 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="width" id="width" placeholder="Width" value="<?= set_value('width', $jrp_component->width); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="length" class="col-sm-2 control-label">Length 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="length" id="length" placeholder="Length" value="<?= set_value('length', $jrp_component->length); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="depth" class="col-sm-2 control-label">Depth 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="depth" id="depth" placeholder="Depth" value="<?= set_value('depth', $jrp_component->depth); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="image_ref" class="col-sm-2 control-label">Image Ref 
                            </label>
                            <div class="col-sm-8">
                                <div id="jrp_component_image_ref_galery"></div>
                                <input class="data_file data_file_uuid" name="jrp_component_image_ref_uuid" id="jrp_component_image_ref_uuid" type="hidden" value="<?= set_value('jrp_component_image_ref_uuid'); ?>">
                                <input class="data_file" name="jrp_component_image_ref_name" id="jrp_component_image_ref_name" type="hidden" value="<?= set_value('jrp_component_image_ref_name', $jrp_component->image_ref); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                  
                                                <div class="form-group ">
                            <label for="notes" class="col-sm-2 control-label">Notes 
                            </label>
                            <div class="col-sm-8">
                                <textarea id="notes" name="notes" rows="10" cols="80"> <?= set_value('notes', $jrp_component->notes); ?></textarea>
                                <small class="info help-block">
                                </small>
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
<script src="<?= BASE_ASSET; ?>ckeditor/ckeditor.js"></script>
<!-- Page script -->
<script>
    $(document).ready(function(){
      
      CKEDITOR.replace('notes'); 
      var notes = CKEDITOR.instances.notes;
                   
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
              window.location.href = BASE_URL + 'administrator/jrp_component';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
        $('#notes').val(notes.getData());
                    
        var form_jrp_component = $('#form_jrp_component');
        var data_post = form_jrp_component.serializeArray();
        var save_type = $(this).attr('data-stype');
        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: form_jrp_component.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id = $('#jrp_component_image_galery').find('li').attr('qq-file-id');
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

       $('#jrp_component_image_ref_galery').fineUploader({
          template: 'qq-template-gallery',
          request: {
              endpoint: BASE_URL + '/administrator/jrp_component/upload_image_ref_file',
              params : params
          },
          deleteFile: {
              enabled: true, // defaults to false
              endpoint: BASE_URL + '/administrator/jrp_component/delete_image_ref_file'
          },
          thumbnails: {
              placeholders: {
                  waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                  notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
              }
          },
           session : {
             endpoint: BASE_URL + 'administrator/jrp_component/get_image_ref_file/<?= $jrp_component->id; ?>',
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
                   var uuid = $('#jrp_component_image_ref_galery').fineUploader('getUuid', id);
                   $('#jrp_component_image_ref_uuid').val(uuid);
                   $('#jrp_component_image_ref_name').val(xhr.uploadName);
                } else {
                   toastr['error'](xhr.error);
                }
              },
              onSubmit : function(id, name) {
                  var uuid = $('#jrp_component_image_ref_uuid').val();
                  $.get(BASE_URL + '/administrator/jrp_component/delete_image_ref_file/' + uuid);
              },
              onDeleteComplete : function(id, xhr, isError) {
                if (isError == false) {
                  $('#jrp_component_image_ref_uuid').val('');
                  $('#jrp_component_image_ref_name').val('');
                }
              }
          }
      }); /*end image_ref galey*/
              
       
           
    
    }); /*end doc ready*/
</script>