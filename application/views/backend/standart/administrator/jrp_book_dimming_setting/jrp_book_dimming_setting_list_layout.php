
<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>

<!-- Content Header (Page header) -->

<section class="content-header">
   <h1>
      Dimming Setting<small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dimming Setting</li>
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
                     <div class="row pull-right">
                        <?php is_allowed('jrp_book_dimming_setting_add', function($project_book) use($project_book){?>
                        <a class="btn btn-flat btn-success btn_add_new" id="btn_add_new" title="<?= cclang('add_new_button', ['Jrp Book Dimming Setting']); ?>  (Ctrl+a)" href="<?=  site_url('administrator/jrp_book_dimming_setting/add/'.$project_book->id); ?>"><i class="fa fa-plus-square-o" ></i> <?= cclang('add_new_button', ['Jrp Book Dimming Setting']); ?></a>
                        <?php }) ?>
                     </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar">
                     </div>
                     <!-- /.widget-user-image -->
                     <h3 class="widget-user-username"><a href="/administrator/jrp_project_book/view/<?= _ent($project_book->id);?>"><?= _ent($project_book->name);?></a></h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', ['Dimming Setting']); ?>  <i class="label bg-yellow"><?= ''; ?>  <?= cclang('items'); ?></i></h5>
                  </div>

                  <form name="form_jrp_book_dimming_setting" id="form_jrp_book_dimming_setting" action="<?= base_url("administrator/jrp_book_dimming_setting/index/$project_id"); ?>">
                  

                  <div class="table-responsive"> 
                  <table class="table table-bordered table-striped dataTable">
                     <thead>
                        <tr class="">
                           <th>
                            <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                           </th>
                           <th>Layout Id</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody id="tbody_jrp_book_dimming_setting">
                     <?php foreach($list_layout as $layout): ?>
                        <tr>
                           <td width="5">
                              <input type="checkbox" class="flat-red check" name="id[]" value="<?= $layout->layout_id; ?>">
                           </td>
                           
                           <td> <a href="<?= site_url("administrator/jrp_book_dimming_setting/index/$project_id?q=$layout->layout_id&f=layout_id"); ?>"><?= _ent($layout->document_id); ?></a></td>
                           <td width="200">

                              <a href="<?= site_url("administrator/jrp_book_dimming_setting/index/$project_id?q=$layout->layout_id&f=layout_id"); ?>" class="label-default"><i class="fa fa-newspaper-o"></i> <?= cclang('view_button'); ?>


                           </td>
                        </tr>
                      <?php endforeach; ?>
                      <?php if (count($list_layout) == 0) :?>
                         <tr>
                           <td colspan="100">
                           Dimming Setting data is not available
                           </td>
                         </tr>
                      <?php endif; ?>
                     </tbody>
                  </table>
                  </div>
               </div>
               <hr>
               <!-- /.widget-user -->

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


  });
</script>