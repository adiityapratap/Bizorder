// add remove clone new row on button click
$(document).ready(function() {
  
  $(document).on('click', '.btn-clone', function() {
    var $inputRow = $(this).closest('.input-row');
    var $clonedRow = $inputRow.clone(true); 
    $clonedRow.find('input').val(''); 
    $inputRow.after($clonedRow); 
  });

  $(document).on('click', '.btn-declone', function() {
    var $inputRow = $(this).closest('.input-row');
    if ($('.input-row').length > 1) {
      $inputRow.remove();
    }
  });
});