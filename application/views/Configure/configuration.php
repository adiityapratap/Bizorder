<div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                             <div class="col-12">
                                <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 text-black" style="z-index: 9999;">Configure</h4>
                                </div>
                            </div>
                                    </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                 
                                    <div class="card-body">

                 <form action="<?php echo base_url(); ?>config/configureAddUpdate" method="post" class="form-horizontal mt-5">
                 
               
                  <div class="row">       
                                   <div class="col-md-8 col-sm-12">
                  <label for="sort_order" class="form-label fw-semibold">Add Automated Notification Email</label>
               <table class="table table-bordered" id="cronNotificationMailTable">
            <tbody>
                <?php $loopCount = 1;  if(isset($mailConfigData) && !empty($mailConfigData)) {  ?>
                <?php foreach($mailConfigData as $index => $emails) { ?>
                <input type="hidden" name="cronMailNotificationConfigId[]" value="<?php echo $emails['id'] ?>">
                <?php $emailTo = unserialize($emails['data']);  ?>
                <?php $configureFor = $emails['configureFor'];  ?>
                <?php $time_of_notification = unserialize($emails['time_of_notification']);  ?>
                <?php foreach($emailTo as $emailId) { ?>
               <tr>
               <td>
             <select class="form-select notificationMailoptions" name="mailType[]">
             <option value="MSchecklistNotification_mail" <?php echo  ((isset($emails['configureFor']) && $emails['configureFor'] == 'MSchecklistNotification_mail'  ? 'selected'  : '')) ?>>Morning Shift Notification</option>
             <option value="ASchecklistNotification_mail" <?php echo  ((isset($emails['configureFor']) && $emails['configureFor'] == 'ASchecklistNotification_mail'  ? 'selected'  : '')) ?>>Afternoon Shift Checklist Notification</option>
             <option value="ESchecklistNotification_mail"  <?php echo  ((isset($emails['configureFor']) && $emails['configureFor'] == 'ESchecklistNotification_mail'  ? 'selected'  : '')) ?>>Evening Shift Checklist Notification</option>
           </select>
             </td>
                    <td class="gap-2 d-flex">
                    <input required type="text" name="emailTo[]" class="form-control " value="<?php echo (isset($emailId) ? $emailId : ''); ?>" placeholder="Enter mail" autocomplete="off" />
                    </td>
                    
                     <td>
                    <input required type="text" name="time_of_notification[]" class="form-control item  JUItimepicker w-50" value="<?php echo (isset($time_of_notification[$configureFor]) ? $time_of_notification[$configureFor] : ''); ?>" placeholder="Enter time" autocomplete="off" />
                    </td>
                    <td><button class="btn btn-success add-row " type="button">+</button></td>
                    <?php if($loopCount != 1) { ?>
                    <td><button type="button" class="btn btn-danger remove-row">-</button></td>
                    <?php } ?>
                </tr>
                 <?php } ?>
                <?php $loopCount ++;} ?>
               <?php      }  else {   ?>
             <tr>
                 <td>
                          <select class="form-select notificationMailoptions" name="mailType[]">
                          <option value="MSchecklistNotification_mail">Morning Shift Checklist Notification</option>
                           <option value="ASchecklistNotification_mail">Afternoon Shift Checklist Notification</option>
                            <option value="ESchecklistNotification_mail">Evening Shift Checklist Notification</option>
                           </select>
                           </td>
                    <td class="gap-2 d-flex">
                    <input type="text" name="emailTo[]" class="form-control" placeholder="Enter mail" autocomplete="off" required />
                    </td>
                    <td>
                    <input required type="text" name="time_of_notification[]" class="form-control item  JUItimepicker w-50" value="<?php echo (isset($mailConfigData[0]['time_of_notification']) ? $mailConfigData[0]['time_of_notification'] : ''); ?>" placeholder="Enter time" autocomplete="off" />
                    </td>
                    <td><button class="btn btn-success add-row " type="button">+</button></td>
                </tr>  
               
               <?php  } ?>
               
            </tbody>
        </table> 
        
                 
                 </div>  
                  </div> 
                  <div class="col-xxl-3 col-md-6 mt-2">
                                     <input class="btn btn-success"  type="submit" value="Save"> 
                                        </div>
                        </form> 
                       
                                      
                                      
                                      
                                      
                                    </div><!-- end card -->
                               
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end col -->
                        </div>
                       </div>
                    <!-- container-fluid -->
                </div>
              
            </div>
            
            <script>
            
              $(document).ready(function () {
            // Add new row on plus button click
            $('form').on('click', '.add-row', function () {
              let newRow = '<tr>';
                         newRow +='<td>';
                         newRow +='<select class="form-select notificationMailoptions" name="mailType[]">';
                          newRow +='<option value="MSchecklistNotification_mail">Morning Shift Checklist Notification</option>';
                          newRow +='<option value="ASchecklistNotification_mail">Afternoon Shift Checklist Notification</option>';
                          newRow +='<option value="ESchecklistNotification_mail">Evening Shift Checklist Notification</option>';
                         newRow +=  '</select>';
                         newRow +=  '</td>';
             newRow +='<td class="gap-2 d-flex"><input type="text" name="emailTo[]" class="form-control " placeholder="Enter  email" autocomplete="off"  />';
             newRow += '<td><input required type="text" name="time_of_notification[]" class="form-control item  JUItimepicker w-50"  placeholder="Enter time" autocomplete="off" /> </td>';
             newRow +='</td><td><button type="button" class="btn btn-success add-row">+</button></td><td><button type="button" class="btn btn-danger remove-row">-</button></td></tr>';
                $(this).closest('tr').after(newRow);
            });

            // Remove row on minus button click
            $('form').on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
            });
            
            
            $('#cronNotificationMailTable').on('change', '.notificationMailoptions', function () {
      let selectedOption = $(this).val();
      let allPreviousOptions = [];

      // Iterate over all previous rows
      $(this).parents('#cronNotificationMailTable').find('tr').each(function () {
        let prevOption = $(this).find('.notificationMailoptions').val(); 
        allPreviousOptions.push(prevOption);
      });
      
      let count = allPreviousOptions.filter(item => item === selectedOption).length;
      
      if(count > 1) {
        alert('Option already selected in a previous row.');
        $(this).val('');
        return false;
      }
    });
            
           
        });
        
            </script>
          