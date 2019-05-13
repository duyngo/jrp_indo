
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
        Fixture Component        <small><?= cclang('new', ['Fixture Component']); ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/jrp_fixture_component'); ?>">Fixture Component</a></li>
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
                            <h3 class="widget-user-username">Fixture Component</h3>
                            <h5 class="widget-user-desc"><?= cclang('new', ['Fixture Component']); ?></h5>
                            <hr>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_jrp_fixture_component', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_jrp_fixture_component', 
                            'enctype' => 'multipart/form-data', 
                            'method'  => 'POST'
                            ]); ?>
                         
                                                <div class="form-group ">
                            <label for="fixture_id" class="col-sm-2 control-label">Fixture Id 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
	                            <input type="hidden" name="fixture_id" id="fixture_id" value="<?= $fixture_id; ?>" />
	                            <?php $fixture = db_get_single_data('jrp_fixture','id = '.$fixture_id); ?>
	                            <input class="form-control" type="text" readonly="readonly" value="<?= $fixture->code ?>">
<!--
	                            
                                <select  class="form-control chosen chosen-select-deselect" name="fixture_id" id="fixture_id" data-placeholder="Select Fixture Id" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('jrp_fixture') as $row): ?>
                                    <option <?= (($fixture_id == $row->id) ? 'selected' : ''); ?> value="<?= $row->id ?>"><?= $row->code; ?></option>
                                    <?php endforeach; ?>  
                                </select>
-->
                                <small class="info help-block">
                                <b>Input Fixture Id</b> Max Length : 11.</small>
                            </div>
                        </div>

                                                 
                                                <div class="form-group ">
                            <label for="component_id" class="col-sm-2 control-label">Component Id 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="component_id" id="component_id" data-placeholder="Select Component Id" >
                                    <option value=""></option>
                                    <?php foreach (db_get_component_data('jrp_component') as $row): ?>
                                    <option value="<?= $row->id ?>"><?= $row->name.' ('.$row->manufacturer_name.' | '. $row->finishing . ' | ' .$row->width .' x '. $row->length . ' x '. $row->depth . ')'; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                <b>Input Component Id</b> Max Length : 11.</small>
                            </div>
                            
                        </div>


						<div class="form-group ">
                            <label for="component_qty" class="col-sm-2 control-label">Component Quantity 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                               <input type="text" class="form-control" name="component_qty" id="component_qty" placeholder="Quantity" value="<?= set_value('component_qty'); ?>">
                                <small class="info help-block">
                                <b>Input Component Quantity</b> Max Length : 11.</small>
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
                   
      $('.chosen').chosen();
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
              window.location.href = BASE_URL + 'administrator/jrp_fixture_component/index/'+<?= $fixture_id ?>;
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_jrp_fixture_component = $('#form_jrp_fixture_component');
        var data_post = form_jrp_fixture_component.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: BASE_URL + '/administrator/jrp_fixture_component/add_save',
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