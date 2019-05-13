
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
        Manufacturer        <small>Edit Manufacturer</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/jrp_manufacturer'); ?>">Manufacturer</a></li>
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
                            <h3 class="widget-user-username">Manufacturer</h3>
                            <h5 class="widget-user-desc">Edit Manufacturer</h5>
                            <hr>
                        </div>
                        <?= form_open(base_url('administrator/jrp_manufacturer/edit_save/'.$this->uri->segment(4)), [
                            'name'    => 'form_jrp_manufacturer', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_jrp_manufacturer', 
                            'method'  => 'POST'
                            ]); ?>
                         
                                                <div class="form-group ">
                            <label for="name" class="col-sm-2 control-label">Name 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?= set_value('name', $jrp_manufacturer->name); ?>">
                                <small class="info help-block">
                                <b>Input Name</b> Max Length : 512.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="contact_person" class="col-sm-2 control-label">Contact Person 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="contact_person" id="contact_person" placeholder="Contact Person" value="<?= set_value('contact_person', $jrp_manufacturer->contact_person); ?>">
                                <small class="info help-block">
                                <b>Input Contact Person</b> Max Length : 512.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="contact_email" class="col-sm-2 control-label">Contact Email 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="contact_email" id="contact_email" placeholder="Contact Email" value="<?= set_value('contact_email', $jrp_manufacturer->contact_email); ?>">
                                <small class="info help-block">
                                <b>Input Contact Email</b> Max Length : 64.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="contact_phone" class="col-sm-2 control-label">Contact Phone 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="contact_phone" id="contact_phone" placeholder="Contact Phone" value="<?= set_value('contact_phone', $jrp_manufacturer->contact_phone); ?>">
                                <small class="info help-block">
                                <b>Input Contact Phone</b> Max Length : 16.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="contact_address" class="col-sm-2 control-label">Contact Address 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="contact_address" id="contact_address" placeholder="Contact Address" value="<?= set_value('contact_address', $jrp_manufacturer->contact_address); ?>">
                                <small class="info help-block">
                                <b>Input Contact Address</b> Max Length : 512.</small>
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
              window.location.href = BASE_URL + 'administrator/jrp_manufacturer';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_jrp_manufacturer = $('#form_jrp_manufacturer');
        var data_post = form_jrp_manufacturer.serializeArray();
        var save_type = $(this).attr('data-stype');
        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: form_jrp_manufacturer.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id = $('#jrp_manufacturer_image_galery').find('li').attr('qq-file-id');
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