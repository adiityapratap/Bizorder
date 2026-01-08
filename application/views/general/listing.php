<style>
    .table-card td:first-child, .table-card th:first-child {
    padding-left: 12px;
}
.table-card td:last-child, .table-card th:last-child {
    padding-right: 12px;
}
</style>
<?php $idName = $table_name.'_id'; ?>
<div class="main-content">

    <div class="page-content">
                
    <div class="container-fluid">
     <div class="row">
        <div class="col-lg-12">
            <div class="page-content-inner">
                <div class="card" id="userList">
                    <div class="card-header border-bottom-dashed">

                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0"><?php echo $page_title; ?></h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div>
                                    <a class="btn btn-primary add-btn" href="<?php echo base_url(); ?>index.php/<?php echo $controller_add; ?>"><i class="ri-add-line align-bottom me-1"></i> Add New</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                   
                    <div class="card-body">
                       <div>
                             <?php if($this->session->flashdata('sucess_msg') != '') { ?>  
                            <div class='hideMeAlert'>
                                <p class="alert alert-success"><?php echo $this->session->flashdata('sucess_msg'); ?></p>
                            </div>
                            <?php } else if($this->session->flashdata('error_msg') != '') { ?>  
                            <div class='hideMeAlert'>
                                <p class="alert alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
                            </div>
                            <?php }else{} ?>
                        </div>
                           
                                
                                <table class="table table-striped nowrap align-middle" id="customerDataTable">
                                    <thead class="table-light">
                                        <tr>
                                            <?php foreach($table_columns as $cols){ ?>
                                            <th class="fs-13 <?php echo ($cols['sort'] == 1 ? 'sort' : 'no-sort'); ?>" ><?php echo $cols['column_title']; ?></th>
                                            <?php } ?>
                                            <th class="fs-13 no-sort text-center" width="200">Action</th>
                                        </tr>
                                    </thead>
                                    <?php if(!empty($record)){ ?>
                                    <tbody class="list form-check-all">
                                        <?php foreach($record as $row){ ?>
                                        
                                        <tr class="recordRow">
                                            <?php foreach($table_columns as $cols){ 
                                            $colName = $cols['column_name'];
                                            if($cols['column_title'] == 'Status'){
                                                if($row->$colName == 0){
                                                    $statusHtml = '<span class="badge badge-soft-danger">Disabled</span>';
                                                }else if($row->$colName == 1){
                                                    $statusHtml = '<span class="badge badge-soft-success">Enabled</span>';
                                                }else{
                                                    $statusHtml = '';
                                                }
                                            ?>
                                                <td class="fs-14"><?php echo $statusHtml; ?></td>
                                                <?php }else{ ?>
                                                <td class="fs-14"><?php echo $row->$colName; ?></td>
                                           <?php } } ?>
                                            <td>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <div class="view">
                                                        <a class="btn btn-sm btn-primary edit-item-btn" href="<?php echo base_url(); ?>index.php/<?php echo $controller_view."/".$row->$idName ?>">
                                                          View</a>
                                                    </div>
                                                    <div class="edit">
                                                        <a class="btn btn-sm btn-success edit-item-btn" href="<?php echo base_url(); ?>index.php/<?php echo $controller_edit."/".$row->$idName ?>">
                                                      Edit</a>
                                                    </div>
                                                    <div class="remove">
                                                      <button class="btn btn-sm btn-danger remove-item-btn" data-rel="delete" data-rel-id="<?php echo  $row->$idName ?>" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">Remove</button>
                                                    </div>
                                                </div>
                                                    
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                    <?php } ?>
                                </table>
                                
                                <div class="noresult" <?php if(!empty($record)){ ?>style="display: none" <?php } else{ ?>style="display: block" <?php } ?> >
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                        <p class="text-muted mb-0">We did not find any record for you search.</p>
                                    </div>
                                </div>
                               
                          
                           
                      
                       
                    </div>
                </div>
            </div>
        </div>
            <!--end col-->
     </div>
        <!--end row-->
       
        
        
    </div>
           
    </div>
       

        
    </div>
   
</div>
<input type="hidden" id="table_name" value="<?php echo $table_name; ?>">
<script type="text/javascript">
$('.remove-item-btn').click(function(){
    var id = $(this).attr('data-rel-id');
    var thisRow = $(this).closest('.recordRow');
    var table_name = $('#table_name').val();
        Swal.fire({
          title: "Are you sure?",
          icon: "warning",
          showCancelButton: !0,
          confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
          cancelButtonClass: "btn btn-danger w-xs mt-2",
          confirmButtonText: "Yes, delete it!",
          buttonsStyling: !1,
          showCloseButton: !0,
      }).then(function (e) {
          if (e.value) {
              
            
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>index.php/general/record_delete",
                data:'id='+id+'&table_name='+table_name,
                success: function(data){
                //   location.reload();
                  if(data == 'deleted'){
                      $(thisRow).remove();
                  }
                }
            });
            
        
              
          }
      })
   
    
});
    $(document).ready(function () {
            
    <?php if(empty($employees)){ ?>
        $('#customerDataTable').DataTable({
            paging: false,
            info: false,
           "columnDefs": [ {
                  "targets"  : 'no-sort',
                  "orderable": false
                }]
        });
    <?php  }else{ ?>
        $('#customerDataTable').DataTable({
            pageLength: 100,
            lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
           "columnDefs": [ {
                  "targets"  : 'no-sort',
                  "orderable": false
                }]
        });
    <?php  } ?>
});
</script> 
<?php 
$this->session->unset_userdata('sucess_msg');
$this->session->unset_userdata('error_msg');
?>