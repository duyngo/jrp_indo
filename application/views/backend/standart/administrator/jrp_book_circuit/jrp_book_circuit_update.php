
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
<?php $project_book = db_get_single_data('jrp_project_book','id='.$jrp_book_circuit->project_Id );?>
<section class="content-header">
    <h1>
        Book Circuit        <small>Edit Book Circuit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/jrp_book_circuit'); ?>">Book Circuit</a></li>
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
                            <h3 class="widget-user-username"><?= $project_book->name ?></h3>
                            <h5 class="widget-user-desc">Edit Book Circuit</h5>
                            <hr>
                        </div>
                        <?= form_open(base_url('administrator/jrp_book_circuit/edit_save/'.$this->uri->segment(4)), [
                            'name'    => 'form_jrp_book_circuit', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_jrp_book_circuit', 
                            'method'  => 'POST'
                            ]); ?>
                         
<!--
                                                <div class="form-group ">
                            <label for="project_Id" class="col-sm-2 control-label">Project Id 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="project_Id" id="project_Id" data-placeholder="Select Project Id" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('jrp_project_book') as $row): ?>
                                    <option <?=  $row->id ==  $jrp_book_circuit->project_Id ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->name; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                <b>Input Project Id</b> Max Length : 11.</small>
                            </div>
                        </div>
-->

                                                 
                                                <div class="form-group ">
                            <label for="layout_id" class="col-sm-2 control-label">Layout Id 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
	                            <input type="hidden" name="project_Id" id="project_Id" value="<?= $jrp_book_circuit->project_Id ?>"/>
                                <select  class="form-control chosen chosen-select-deselect" name="layout_id" id="layout_id" data-placeholder="Select Layout Id" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('jrp_book_layout','project_id ='.$jrp_book_circuit->project_Id) as $row): ?>
                                    <option <?=  $row->id ==  $jrp_book_circuit->layout_id ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->document_id; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                <b>Input Layout Id</b> Max Length : 11.</small>
                            </div>
                        </div>

                                                 
                                                <div class="form-group ">
                            <label for="circuit" class="col-sm-2 control-label">Circuit 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="circuit" id="circuit" placeholder="Circuit" value="<?= set_value('circuit', $jrp_book_circuit->circuit); ?>">
                                <small class="info help-block">
                                <b>Input Circuit</b> Max Length : 128.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="quantity" class="col-sm-2 control-label">Quantity 

                            </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="quantity" id="quantity" placeholder="Quantity" value="<?= set_value('quantity', $jrp_book_circuit->quantity); ?>">
                                <small class="info help-block">
                                <b>Input Quantity</b> Max Length : 11.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="circuit_desc" class="col-sm-2 control-label">Circuit Desc 
                            </label>
                            <div class="col-sm-8">
                                <textarea id="circuit_desc" name="circuit_desc" rows="5" class="textarea"><?= set_value('circuit_desc', $jrp_book_circuit->circuit_desc); ?></textarea>
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
              window.location.href = BASE_URL + 'administrator/jrp_book_circuit/index/'+<?= $jrp_book_circuit->project_Id ?>;
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_jrp_book_circuit = $('#form_jrp_book_circuit');
        var data_post = form_jrp_book_circuit.serializeArray();
        var save_type = $(this).attr('data-stype');
        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: form_jrp_book_circuit.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id = $('#jrp_book_circuit_image_galery').find('li').attr('qq-file-id');
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