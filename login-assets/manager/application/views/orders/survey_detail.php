<html>
    <head>
        <link rel="stylesheet" href="https://www.cafeadmin.com.au/HR/assets/menu_design/css/bootstrap.min.css">
        <title>Survey Details</title>
        <style>
            table.table td, table.table th {
                border-top: 0;
            }
            .table thead th {
                width: 20%;
            }
        </style>
        </head>
        <body>

	
<div class="container main-container" style="margin-top: 110px;">
    <span class="validation_text">

	<span>
	  		<div class="row">
  			<div class="col">
	        	<div class="panel panel-default">
	        		<div class="panel-body">
	                <h3>Survey Details</h3><br>
				<div class="form-row">
						<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    					    <!--<input type="text"  class="form-control" name="choose_food_feedback" <?php echo  $choose_food_feedback; ?> placeholder="">-->
			    						<select name="branch_id" class="form-control input-sm" disabled>
			    					      <option value="2">Bendigo Hospital, VIC</option> 
			    						    <option value="1">Footscray Hospital, VIC</option>
			    						     <option value="5">Ipswich Hospital, QLD</option>
			    						     <option value="4">Northshore Hospital, NSW</option>
                                            <option value="6">  RPA Hospital, NSW</option>
			    						   <option value="6">Redcliffee Hospital, QLD</option>
			    						   <option value="3">Westmead Hospital, NSW</option>  
			    						</select>
			    					</div>
			    				</div>
						</div>
						<br>
					<div class="questions">
					<h6 ><b>1) PATRONAGE DURING THE WEEK</b></h6>
	          		<div class="form-row">
	          		<div class="col-md-4 col-sm-12">
					<label class="radio-inline">
					 <input type="radio" value="none" name="patronage" <?php echo  ($patronage =="none" ? 'checked' : '')?>> None
					 </label>
                      </div>
                      	<div class="col-md-4 col-sm-12">
                      <label class="radio-inline">
                      <input type="radio" value="once" name="patronage" <?php echo  ($patronage =="once" ? 'checked' : '')?>> Once
                      </label>
                      </div>
                      	<div class="col-md-4 col-sm-12">
                      <label class="radio-inline">
                      <input type="radio" value="more" name="patronage" <?php echo  ($patronage =="more" ? 'checked' : '')?>> More than once
                      </label>
                      </div>
                      	</div>
                      
						</div>
					<br>
					<div class="questions">
					<h6 ><b>2) Dietary requirement</b></h6>
	          		<div class="form-row">
	          		<div class="col-md-2 col-sm-12">
    					<label class="radio-inline">
    					 <input type="checkbox" value="none" name="dietry" <?php echo  ($dietry =="none" ? 'checked' : '')?>> None
    					 </label>
                      </div>
                      	</div>
                      <br>
						
                      	<div class="form-row">
                      	<div class=" col-sm-12">
                      <label> Please specify </label>
                      <textarea rows="3" class="form-control" name="dietry_feedback"><?php echo  $dietry_feedback; ?></textarea>
                      </div>
                      </div>
						</div> </br>	
					
				<div class="questions">
				    <h6 ><b>3) If the following were introduced in the café, how likely would you to try them?</b></h6>
				    <div class="form-row">
					 	<div class="form-group col-sm-12">
					<table class="table">
                  <tbody>
                      <tr>
                      <th scope="row"></th>
                      <td></td>
                      <td>
                            <table class="table">
                              <thead>
                                <tr>
                                  <th scope="col">Excellence</th>
                                  <th scope="col">Unlikely</th>
                                  <th scope="col">Keen</th>
                                  <th scope="col">Likely</th>
                                  <th scope="col">Needs Improvement</th>
                                </tr>
                              </thead>
                              
                            </table>
                            </td>
                     
                            </tr>
                    <tr>
                      <th scope="row">1</th>
                      <td>Quality of food :</td>
                      <td>
                            <table class="table">
                              
                              <tbody>
                                <tr>
                                    <td><input type="radio" name="quality_of_food" value="5" <?php echo  ($quality_of_food =="5" ? 'checked' : '')?> ></td>
                                    <td><input type="radio" name="quality_of_food" value="4" <?php echo  ($quality_of_food =="4" ? 'checked' : '')?> ></td>
                                    <td><input type="radio" name="quality_of_food" value="3" <?php echo  ($quality_of_food =="3" ? 'checked' : '')?>></td>
                                    <td><input type="radio" name="quality_of_food" value="2" <?php echo  ($quality_of_food =="2" ? 'checked' : '')?>></td>
                                    <td><input type="radio" name="quality_of_food" value="1" <?php echo  ($quality_of_food =="1" ? 'checked' : '')?>></td>
                                </tr>
                              </tbody>
                            </table>
                            </td>
                     
                            </tr>
                            <tr>
                            <th scope="row">2</th>
                              <td>Variety of Food :</td>
                              <td><table class="table">
                          <tbody>
                            <tr>
                                    <td><input type="radio" name="variety_of_food" value="5" <?php echo  ($variety_of_food =="5" ? 'checked' : '')?> ></td>
                                    <td><input type="radio" name="variety_of_food" value="4" <?php echo  ($variety_of_food =="4" ? 'checked' : '')?> ></td>
                                    <td><input type="radio" name="variety_of_food" value="3" <?php echo  ($variety_of_food =="3" ? 'checked' : '')?>></td>
                                    <td><input type="radio" name="variety_of_food" value="2" <?php echo  ($variety_of_food =="2" ? 'checked' : '')?>></td>
                                    <td><input type="radio" name="variety_of_food" value="1" <?php echo  ($variety_of_food =="1" ? 'checked' : '')?>></td>
                                </tr>
                              </tbody>
                            </table> </td>
                           
                              
                            </tr>
                             <tr>
                            <th scope="row">3</th>
                              <td>Food portion size : <br></td>
                              <td><table class="table">
                          <tbody>
                            <tr>
                                    <td><input type="radio" name="food_portion_size" value="5" <?php echo  ($food_portion_size =="5" ? 'checked' : '')?> ></td>
                                    <td><input type="radio" name="food_portion_size" value="4" <?php echo  ($food_portion_size =="4" ? 'checked' : '')?> ></td>
                                    <td><input type="radio" name="food_portion_size" value="3" <?php echo  ($food_portion_size =="3" ? 'checked' : '')?>></td>
                                    <td><input type="radio" name="food_portion_size" value="2" <?php echo  ($food_portion_size =="2" ? 'checked' : '')?>></td>
                                    <td><input type="radio" name="food_portion_size" value="1" <?php echo  ($food_portion_size =="1" ? 'checked' : '')?>></td>
                                </tr>
                          </tbody>
                        </table> </td>
                             
                            </tr>
                            <tr>
                            <th scope="row">4</th>
                              <td>Food labels well informative :<br> </td>
                            <td><table class="table">
                                    <tbody>
                                        <tr>
                                            <td><input type="radio" name="food_label" value="5" <?php echo  ($food_label =="5" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="food_label" value="4" <?php echo  ($food_label =="4" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="food_label" value="3" <?php echo  ($food_label =="3" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="food_label" value="2" <?php echo  ($food_label =="2" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="food_label" value="1" <?php echo  ($food_label =="1" ? 'checked' : '')?>></td>
                                        </tr>
                                    </tbody>
                                </table> </td>
                            </tr>
                            <tr>
                            <th scope="row">5</th>
                              <td>Value for money :<br> </td>
                            <td><table class="table">
                                    <tbody>
                                        <tr>
                                            <td><input type="radio" name="value_for_Money" value="5" <?php echo  ($value_for_Money =="5" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="value_for_Money" value="4" <?php echo  ($value_for_Money =="4" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="value_for_Money" value="3" <?php echo  ($value_for_Money =="3" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="value_for_Money" value="2" <?php echo  ($value_for_Money =="2" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="value_for_Money" value="1" <?php echo  ($value_for_Money =="1" ? 'checked' : '')?>></td>
                                        </tr>
                                    </tbody>
                                </table> </td>
                            </tr>
                            <tr>
                            <th scope="row">6</th>
                              <td>Staff helpfulness :<br> </td>
                            <td><table class="table">
                                    <tbody>
                                        <tr>
                                            <td><input type="radio" name="staff_helpfulness" value="5" <?php echo  ($staff_helpfulness =="5" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="staff_helpfulness" value="4" <?php echo  ($staff_helpfulness =="4" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="staff_helpfulness" value="3" <?php echo  ($staff_helpfulness =="3" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="staff_helpfulness" value="2" <?php echo  ($staff_helpfulness =="2" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="staff_helpfulness" value="1" <?php echo  ($staff_helpfulness =="1" ? 'checked' : '')?>></td>
                                        </tr>
                                    </tbody>
                                </table> </td>
                            </tr>
                            <tr>
                            <th scope="row">7</th>
                              <td>Staff courtesy :<br> </td>
                            <td><table class="table">
                                    <tbody>
                                        <tr>
                                            <td><input type="radio" name="staff_courtesy" value="5" <?php echo  ($staff_courtesy =="5" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="staff_courtesy" value="4" <?php echo  ($staff_courtesy =="4" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="staff_courtesy" value="3" <?php echo  ($staff_courtesy =="3" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="staff_courtesy" value="2" <?php echo  ($staff_courtesy =="2" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="staff_courtesy" value="1" <?php echo  ($staff_courtesy =="1" ? 'checked' : '')?>></td>
                                        </tr>
                                    </tbody>
                                </table> </td>
                            </tr>
                            <tr>
                            <th scope="row">8</th>
                              <td>Staff presentation :<br> </td>
                            <td><table class="table">
                                    <tbody>
                                        <tr>
                                            <td><input type="radio" name="staff_presentation" value="5" <?php echo  ($staff_presentation =="5" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="staff_presentation" value="4" <?php echo  ($staff_presentation =="4" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="staff_presentation" value="3" <?php echo  ($staff_presentation =="3" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="staff_presentation" value="2" <?php echo  ($staff_presentation =="2" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="staff_presentation" value="1" <?php echo  ($staff_presentation =="1" ? 'checked' : '')?>></td>
                                        </tr>
                                    </tbody>
                                </table> </td>
                            </tr>
                            <tr>
                            <th scope="row">9</th>
                              <td>Staff knowledge :<br> </td>
                            <td><table class="table">
                                    <tbody>
                                        <tr>
                                            <td><input type="radio" name="staff_knowledge" value="5" <?php echo  ($staff_knowledge =="5" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="staff_knowledge" value="4" <?php echo  ($staff_knowledge =="4" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="staff_knowledge" value="3" <?php echo  ($staff_knowledge =="3" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="staff_knowledge" value="2" <?php echo  ($staff_knowledge =="2" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="staff_knowledge" value="1" <?php echo  ($staff_knowledge =="1" ? 'checked' : '')?>></td>
                                        </tr>
                                    </tbody>
                                </table> </td>
                            </tr>
                            <tr>
                            <th scope="row">10</th>
                              <td>Biodegradable and compostable packaging used :<br> </td>
                            <td><table class="table">
                                    <tbody>
                                        <tr>
                                            <td><input type="radio" name="biodegradable_package" value="5" <?php echo  ($biodegradable_package =="5" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="biodegradable_package" value="4" <?php echo  ($biodegradable_package =="4" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="biodegradable_package" value="3" <?php echo  ($biodegradable_package =="3" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="biodegradable_package" value="2" <?php echo  ($biodegradable_package =="2" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="biodegradable_package" value="1" <?php echo  ($biodegradable_package =="1" ? 'checked' : '')?>></td>
                                        </tr>
                                    </tbody>
                                </table> </td>
                            </tr>
                            <tr>
                            <th scope="row">11</th>
                              <td>Coffee quality :<br> </td>
                            <td><table class="table">
                                    <tbody>
                                        <tr>
                                            <td><input type="radio" name="coffee_quality" value="5" <?php echo  ($coffee_quality =="5" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="coffee_quality" value="4" <?php echo  ($coffee_quality =="4" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="coffee_quality" value="3" <?php echo  ($coffee_quality =="3" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="coffee_quality" value="2" <?php echo  ($coffee_quality =="2" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="coffee_quality" value="1" <?php echo  ($coffee_quality =="1" ? 'checked' : '')?>></td>
                                        </tr>
                                    </tbody>
                                </table> </td>
                            </tr>
                            <tr>
                            <th scope="row">12</th>
                              <td>Outlet ambience :<br> </td>
                            <td><table class="table">
                                    <tbody>
                                        <tr>
                                            <td><input type="radio" name="outlet_ambience" value="5" <?php echo  ($outlet_ambience =="5" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="outlet_ambience" value="4" <?php echo  ($outlet_ambience =="4" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="outlet_ambience" value="3" <?php echo  ($outlet_ambience =="3" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="outlet_ambience" value="2" <?php echo  ($outlet_ambience =="2" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="outlet_ambience" value="1" <?php echo  ($outlet_ambience =="1" ? 'checked' : '')?>></td>
                                        </tr>
                                    </tbody>
                                </table> </td>
                            </tr>
                            <tr>
                            <th scope="row">13</th>
                              <td>Outlet cleanliness :<br> </td>
                            <td><table class="table">
                                    <tbody>
                                        <tr>
                                            <td><input type="radio" name="outlet_cleanliness" value="5" <?php echo  ($outlet_cleanliness =="5" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="outlet_cleanliness" value="4" <?php echo  ($outlet_cleanliness =="4" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="outlet_cleanliness" value="3" <?php echo  ($outlet_cleanliness =="3" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="outlet_cleanliness" value="2" <?php echo  ($outlet_cleanliness =="2" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="outlet_cleanliness" value="1" <?php echo  ($outlet_cleanliness =="1" ? 'checked' : '')?>></td>
                                        </tr>
                                    </tbody>
                                </table> </td>
                            </tr>
                            <tr>
                            <th scope="row">14</th>
                              <td>Dietary requirement availability :<br> </td>
                            <td><table class="table">
                                    <tbody>
                                        <tr>
                                            <td><input type="radio" name="dietry_requirement" value="5" <?php echo  ($dietry_requirement =="5" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="dietry_requirement" value="4" <?php echo  ($dietry_requirement =="4" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="dietry_requirement" value="3" <?php echo  ($dietry_requirement =="3" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="dietry_requirement" value="2" <?php echo  ($dietry_requirement =="2" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="dietry_requirement" value="1" <?php echo  ($dietry_requirement =="1" ? 'checked' : '')?>></td>
                                        </tr>
                                    </tbody>
                                </table> </td>
                            </tr>
                            <tr>
                            <th scope="row">15</th>
                              <td>Ordering online (cafeonline) if used :<br> </td>
                            <td><table class="table">
                                    <tbody>
                                        <tr>
                                            <td><input type="radio" name="ordering_online" value="5" <?php echo  ($ordering_online =="5" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="ordering_online" value="4" <?php echo  ($ordering_online =="4" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="ordering_online" value="3" <?php echo  ($ordering_online =="3" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="ordering_online" value="2" <?php echo  ($ordering_online =="2" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="ordering_online" value="1" <?php echo  ($ordering_online =="1" ? 'checked' : '')?>></td>
                                        </tr>
                                    </tbody>
                                </table> </td>
                            </tr>
                            <tr>
                            <th scope="row">16</th>
                              <td>Catering if used :<br> </td>
                            <td><table class="table">
                                    <tbody>
                                        <tr>
                                            <td><input type="radio" name="catering" value="5" <?php echo  ($catering =="5" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="catering" value="4" <?php echo  ($catering =="4" ? 'checked' : '')?> ></td>
                                            <td><input type="radio" name="catering" value="3" <?php echo  ($catering =="3" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="catering" value="2" <?php echo  ($catering =="2" ? 'checked' : '')?>></td>
                                            <td><input type="radio" name="catering" value="1" <?php echo  ($catering =="1" ? 'checked' : '')?>></td>
                                        </tr>
                                    </tbody>
                                </table> </td>
                            </tr>
                    
                      </tbody>
                    </table>
                    </div>
                    </div>
				</div>
		
		</br>
		 <div class="questions">
					<h6 ><b>4) Please provide the following details about yourself: </b></h6>
	          
	          <div class="form-row age-group">
              
					<div class=" col-md-6 col-sm-12 ms-5">
                      <label>Name</label>
                      <input type="text"  class="form-control" name="person_name" value="<?php echo  $person_name; ?>" placeholder="Name">
                      </div>
                      <div class="col-md-6  col-sm-12">
                      <label>Email</label>
                      <input type="email"  class="form-control" name="person_email" value="<?php echo  $person_email; ?>" placeholder="Email">
                      </div>

                      </div><br>
                      	<h6 ><b>Age</b></h6>
						<div class="form-row age-group">
              
						    	<div class="col-md-2 col-sm-12 ms-5">
                      <label class="radio-inline">
                      <input  type="radio" value="16" name="age" <?php echo  ($age =="16" ? 'checked' : '')?> /> Under 16
                      </label>
                      </div>
                      <div class="col-md-2 col-sm-12">
                      <label class="radio-inline">
                      <input type="radio" value="above_16" name="age" <?php echo  ($age =="above_16" ? 'checked' : '')?> /> 16-34 y.o
                      </label>
                      </div>

                      <div class="col-md-2 col-sm-12">
                      <label class="radio-inline">
                      <input  type="radio" value="above_34" name="age" <?php echo  ($age =="above_34" ? 'checked' : '')?> /> 35-54 y.o.
                      </label>
                      </div>

                      <div class=" col-md-2 col-sm-12">
                      <label class="radio-inline">
                      <input  type="radio" value="above_55" name="age" <?php echo  ($age =="above_55" ? 'checked' : '')?> /> Over 55
                      </label>
                      </div>
                      </div>
                        <br>
                    <h6 ><b>Sex:</b></h6>
                      <div class="form-row age-group">
              
						    	<div class="col-md-2 col-sm-12 ms-5">
                      <label class="radio-inline">
                      <input  type="radio" value="male" name="sex" <?php echo  ($sex =="male" ? 'checked' : '')?> /> Male
                      </label>
                      </div>
                      <div class="col-md-2 col-sm-12">
                      <label class="radio-inline">
                      <input  type="radio" value="female" name="sex"  <?php echo  ($sex =="female" ? 'checked' : '')?> /> Female
                      </label>
                      </div>

                      <div class="col-md-2 col-sm-12">
                      <label class="radio-inline">
                      <input  type="radio" value="no" name="sex" <?php echo  ($sex =="Staff" ? 'no' : '')?> /> No Preference

                      </label>
                      </div>

                      </div><br>
                      <h6><b>Are you:</b></h6>
                      <div class="form-row age-group">
              
						    	<div class="col-md-2 col-sm-12 ms-5">
                      <label class="radio-inline">
                      <input  type="radio" value="Patient" name="are_you" <?php echo  ($are_you =="Patient" ? 'checked' : '')?> /> A Patient 
                      </label>
                      </div>
                      <div class="col-md-2 col-sm-12">
                      <label class="radio-inline">
                      <input  type="radio" value="Visitor" name="are_you" <?php echo  ($are_you =="Visitor" ? 'checked' : '')?> /> A Visitor / Carer
                      </label>
                      </div>

                      <div class="col-md-3 col-sm-12">
                      <label class="radio-inline">
                      <input  type="radio" value="Student" name="are_you" <?php echo  ($are_you =="Student" ? 'checked' : '')?> /> Hospital Staff / Student

                      </label>
                      </div>

                      <div class="col-md-5 col-sm-12">
                      <label class="radio-inline">
                      <input  type="radio" value="Staff" name="choose_food" <?php echo  ($are_you =="Staff" ? 'checked' : '')?> /> Staff working from nearby buildings
                      </label>
                      </div>
                      </div>

                     
						</div> 
			</div>
			</div>
	        </div>
	    </div>

  
   
  
  <br>
  <script>
$(function() {
        $('.datepicker').datepicker({
	    dateFormat: 'dd-mm-yy',
		startDate: '-3d'
        });
        
        
    });
    
     $(document).ready(function(){
             $('.datetimepicker3').datetimepicker({
                    format: 'HH:mm A'
                });
             
              
            });
    
</script>

</body>
</html>
