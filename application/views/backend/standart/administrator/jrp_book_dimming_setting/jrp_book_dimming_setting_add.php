
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
        Dimming Setting        <small><?= cclang('new', ['Dimming Setting']); ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/jrp_book_dimming_setting'); ?>">Dimming Setting</a></li>
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
                            <h3 class="widget-user-username"><?= $project_book->name ?></h3>
                            <h5 class="widget-user-desc"><?= cclang('new', ['Dimming Setting']); ?></h5>
                            <hr>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_jrp_book_dimming_setting', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_jrp_book_dimming_setting', 
                            'enctype' => 'multipart/form-data', 
                            'method'  => 'POST'
                            ]); ?>

                        <div class="form-group ">
                            <label for="layout_id" class="col-sm-2 control-label">Layout Id
                                <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">

                                <select  class="form-control chosen chosen-select-deselect" name="layout_id" id="layout_id" data-placeholder="Select Layout Id" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('jrp_book_layout','project_id = '.$project_id) as $row): ?>
                                        <option value="<?= $row->id ?>"><?= $row->document_id; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="info help-block">
                                    <b>Input Layout Id</b> Max Length : 11.</small>
                            </div>
                        </div>
                         
                        <div class="form-group ">
                            <label for="circuit_id" class="col-sm-2 control-label">Circuit Id 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
	                            <input type="hidden" class="form-control" name="project_id" id="project_id" placeholder="Project Id" value="<?= $project_id ?>">
                                <select  class="form-control chosen chosen-select-deselect" name="circuit_id" id="circuit_id" data-placeholder="Select Circuit Id" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('jrp_book_circuit','project_id = '.$project_id) as $row): ?>
                                    <option value="<?= $row->id ?>"><?= $row->circuit; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                <b>Input Circuit Id</b> Max Length : 11.</small>
                            </div>
                        </div>

                                                 
                                                <div class="form-group ">
                            <label for="scene_1" class="col-sm-2 control-label">Scene 1 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="scene_1" id="scene_1" placeholder="Scene 1" value="<?= set_value('scene_1'); ?>">
                                <small class="info help-block">
                                <b>Input Scene 1</b> Max Length : 64.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="scene_2" class="col-sm-2 control-label">Scene 2 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="scene_2" id="scene_2" placeholder="Scene 2" value="<?= set_value('scene_2'); ?>">
                                <small class="info help-block">
                                <b>Input Scene 2</b> Max Length : 64.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="scene_3" class="col-sm-2 control-label">Scene 3 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="scene_3" id="scene_3" placeholder="Scene 3" value="<?= set_value('scene_3'); ?>">
                                <small class="info help-block">
                                <b>Input Scene 3</b> Max Length : 64.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="scene_4" class="col-sm-2 control-label">Scene 4 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="scene_4" id="scene_4" placeholder="Scene 4" value="<?= set_value('scene_4'); ?>">
                                <small class="info help-block">
                                <b>Input Scene 4</b> Max Length : 64.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="scene_5" class="col-sm-2 control-label">Scene 5 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="scene_5" id="scene_5" placeholder="Scene 5" value="<?= set_value('scene_5'); ?>">
                                <small class="info help-block">
                                <b>Input Scene 5</b> Max Length : 64.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="scene_6" class="col-sm-2 control-label">Scene 6 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="scene_6" id="scene_6" placeholder="Scene 6" value="<?= set_value('scene_6'); ?>">
                                <small class="info help-block">
                                <b>Input Scene 6</b> Max Length : 64.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="note" class="col-sm-2 control-label">Note 
                            </label>
                            <div class="col-sm-8">
                                <textarea id="note" name="note" rows="5" cols="80"><?= set_value('Note'); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
<!--
                                                <div class="form-group ">
                            <label for="project_id" class="col-sm-2 control-label">Project Id 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="project_id" id="project_id" placeholder="Project Id" value="<?= set_value('project_id'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
-->
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
            CKEDITOR.replace('note'); 
      var note = CKEDITOR.instances.note;
                   
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
              window.location.href = BASE_URL + 'administrator/jrp_book_dimming_setting/index/<?=$project_id?>';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
        $('#note').val(note.getData());
                    
        var form_jrp_book_dimming_setting = $('#form_jrp_book_dimming_setting');
        var data_post = form_jrp_book_dimming_setting.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: BASE_URL + '/administrator/jrp_book_dimming_setting/add_save',
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
            note.setData('');
                
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