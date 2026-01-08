<?php

class Recipe extends MY_Controller
{
    public function __construct() 
    {   
      	parent::__construct();
   	   
   	    $this->load->model('common_model');
   	    $this->load->model('recipe_model');
       !$this->ion_auth->logged_in() ? redirect('auth/login', 'refresh') : '';
        $this->POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $this->selected_location_id = $this->session->userdata('default_location_id');
       
    }
    
  
    
    public function Config(){
   	      //   $table = 'your_table';
    //     $fields = array('field1', 'field2');
        $conditions = array('location_id' => $this->selected_location_id, 'is_deleted' => 0);
        $conditions['listtype'] = 'category';
        $catListData = $this->common_model->fetchRecordsDynamically('recipebuilder_configs','',$conditions);
        $conditions['listtype'] = 'uom';
        $uomListData = $this->common_model->fetchRecordsDynamically('recipebuilder_configs','',$conditions);
        
       
        $ingredientListData = $this->recipe_model->fetchIngredients();
         
        // echo "<pre>"; print_r($ingredientListData); exit;
        
        $modulesListData = array(
            'category' => array(
                'label' => 'Category',
                'tableData' => $catListData,
                ),
                
            'uom' => array(
                'label' => 'UOM',
                'tableData' => $uomListData,
                ),
                
            'ingredient' => array(
                'label' => 'Ingredient',
                'tableData' => $ingredientListData,
                )
            );
        
        $data['uomListData']  = $uomListData;
        $data['catListData']  = $catListData;
        $data['modulesInfo']  = $modulesListData;
		$data['selectedlisttype'] = $this->session->userdata('listtype');	
	
			$this->load->view('general/header');
            $this->load->view('Recipebuilder/recipeConfigs',$data);
            $this->load->view('general/footer');
		}
		
	public function saveConfigsdata(){
			if(isset($this->POST['name'])){
					$configData = array(
						'name' => $this->POST['name'],
						'listtype' => $this->POST['listtype'],
						'location_id' => $this->session->userdata('default_location_id'),
						'created_date' => date('Y-m-d'),
					);
		$this->session->set_userdata('listtype', $this->POST['listtype']);
		$result = $this->common_model->commonRecordCreate('recipebuilder_configs',$configData);
		echo $result;
			}
			
			
		}
		
	public function updateConfig(){
        $result = $this->common_model->commonRecordUpdate('recipebuilder_configs','id',$this->POST['id'],$this->POST);
        $this->session->set_userdata('listtype', $this->POST['listtype']);    
		echo 'succcess';
		}
		
    public function saveIngredients() {
        
    
        $ingredient_name = $this->input->post('ingredient_name');
        $category_id = $this->input->post('category_id');
        $uom_id = $this->input->post('uom_id');
        $cost = $this->input->post('cost');
        $uomqty = $this->input->post('uomqty');

        // Validate data
        if (empty($ingredient_name) || empty($category_id) || empty($cost)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            return;
        }

        // Insert data into database
        $ingredientData = [
            'name' => $ingredient_name,
            'category_id' => $category_id,
            'uom' => $uom_id,
            'uomqty' => $uomqty,
            'cost' => $cost,
            'location_id' => $this->session->userdata('default_location_id'),
        ];

        $result = $this->common_model->commonRecordCreate('ingredients',$ingredientData);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Ingredient saved successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save ingredient.']);
        }
    }
    
    public function editIngredient($id){
        
        $conditions = array('location_id' => $this->selected_location_id, 'is_deleted' => 0);
        $conditions['listtype'] = 'category';
        $data['catListData'] = $this->common_model->fetchRecordsDynamically('recipebuilder_configs','',$conditions);
        $conditions['listtype'] = 'uom';
        $data['uomListData'] = $this->common_model->fetchRecordsDynamically('recipebuilder_configs','',$conditions);
        
        
        $conditionsI['id'] = $id;
        $data['ingredientData'] = $this->common_model->fetchRecordsDynamically('ingredients', '',$conditionsI);  
        // echo "<pre>"; print_r($data['ingredientData']); exit;
        $this->load->view('general/header');
        $this->load->view('Recipebuilder/editIngredient',$data);
        $this->load->view('general/footer'); 
    }
    
    function updateIngredient(){
        // echo "<pre>"; print_r($this->POST); exit;
        unset($this->POST['listtype']);
      $result = $this->common_model->commonRecordUpdate('ingredients','id',$this->POST['id'],$this->POST); 
      redirect(base_url('Orderportal/Recipe/Config'), 'refresh');
    }
    // Code related to recipe builder form ================================================================================================
    
     public function buildRecipe() {
         
         $this->session->set_userdata('listtype', 'ingredient');
        $data['recipes'] = $this->recipe_model->recipeList();
        //   echo "<pre>"; print_r($data['recipes']); exit;
        $this->load->view('general/header');
        $this->load->view('Recipebuilder/recipeList', $data);
        $this->load->view('general/footer');
    }
    
    function newRecipeForm(){
        $data['ingredients'] = $this->recipe_model->fetchIngredients(); 
        // echo "<pre>"; print_r($data['ingredients']); exit;
        $this->load->view('general/header');
        $this->load->view('Recipebuilder/recipeForm',$data);
        $this->load->view('general/footer'); 
    }
    
    function saveRecipeDetails(){
      
      
        $recipeData = [
            'recipeName' => $this->input->post('recipeName'),
            'servingSize' => $this->input->post('servingSize'),
            'preparationTime' => $this->input->post('preparationTime'),
            'cookingTime' => $this->input->post('cookingTime'),
            'totalTime' => $this->input->post('totalTime'),
            'difficulty' => $this->input->post('difficulty'),
            'location_id' => $this->session->userdata('default_location_id'),
        ];
        if($this->input->post('recipeId') !=''){
        $recipeId = $this->input->post('recipeId');
         $this->common_model->commonRecordUpdate('recipes','id',$recipeId,$recipeData);
         }else{
          $recipeId = $this->common_model->commonRecordCreate('recipes',$recipeData);
         }

        
        echo $recipeId;
    }
    
    public function saveIngredientDetails() {
        $data = $this->input->post();

        $recipeId = $data['recipeId'];
        $ingredientNames = $data['ingredientName'];
        $ingredientUoms = $data['ingredientUom'];
        $ingredientQtys = $data['ingredientQty'];
        $ingredientCosts = $data['ingredientCost'];

        $bulkInsertData = [];

        foreach ($ingredientNames as $index => $ingredientId) {
            $bulkInsertData[] = [
                'recipeID' => $recipeId,
                'ingredientId' => $ingredientId,
                'qty' => $ingredientQtys[$index],
                'uom' => $ingredientUoms[$index],
                'cost' => $ingredientCosts[$index],
            ];
        }
        
        // delete old ingredients and update with new one if its update form
        $this->common_model->commonRecordDelete('recipesToIngredients',$recipeId,'recipeID');  
      
        $this->common_model->commonBulkRecordCreate('recipesToIngredients', $bulkInsertData);

        echo json_encode(['status' => 'success', 'message' => 'Ingredients saved successfully']);
    }
    
    function savePrepSteps(){
       
       $prepStepsData = [
            'recipeId' => $this->input->post('recipeId'),
            'prepSteps' => $this->input->post('preparationSteps'),
        ];
        
        $conditions['recipeID'] = $this->input->post('recipeId');
        $recipeToPreparationSteps = $this->common_model->fetchRecordsDynamically('recipeToPreparationSteps', ['id'],$conditions);
       
        // update if recipe steps already exist else insert
        if(isset($recipeToPreparationSteps) && !empty($recipeToPreparationSteps)){
         $this->common_model->commonRecordUpdate('recipeToPreparationSteps','recipeId',$this->input->post('recipeId'),$prepStepsData); 
        }else{
        $this->common_model->commonRecordCreate('recipeToPreparationSteps',$prepStepsData);    
        }
        
        
         echo json_encode(['status' => 'success', 'message' => 'Prep steps saved successfully']);
        
    }
    
    function editRecipe($recipeId){
      
     $data['ingredients'] = $this->recipe_model->fetchIngredients(); 
     $recipeInfo = $this->recipe_model->fetchRecipeInfo($recipeId); 
     $data['recipeInfo'] = (isset($recipeInfo) && !empty($recipeInfo) ? reset($recipeInfo) : array());
    //   echo "<pre>"; print_r($recipeInfo); exit;
        $this->load->view('general/header');
        $this->load->view('Recipebuilder/recipeForm',$data);
        $this->load->view('general/footer'); 
        
    }
    function viewRecipe($recipeId){
      
     $data['ingredients'] = $this->recipe_model->fetchIngredients(); 
     $recipeInfo = $this->recipe_model->fetchRecipeInfo($recipeId); 
     $data['recipeInfo'] = (isset($recipeInfo) && !empty($recipeInfo) ? reset($recipeInfo) : array());
    //   echo "<pre>"; print_r($data['recipeInfo']); exit;
        $this->load->view('general/header');
        $this->load->view('Recipebuilder/viewRecipe',$data);
        $this->load->view('general/footer'); 
        
    }
    function deleteRecipe(){
      $this->common_model->commonRecordDelete('recipes',$this->POST['id'],'id');
      $this->common_model->commonRecordDelete('recipesToIngredients',$this->POST['id'],'recipeID'); 
      $this->common_model->commonRecordDelete('recipeToPreparationSteps',$this->POST['id'],'recipeID'); 
		echo 'success';
    }
    
    public function updateRecipeSortOrder(){
	 $newOrder = $this->input->post('order');
    // Update the database with the new sort order

    foreach ($newOrder as $index => $recipeid) {
        $recipeID = substr($recipeid, 4);
        $this->tenantDb->set('sort_order', $index + 1);
        $this->tenantDb->where('id', $recipeID);
        $this->tenantDb->update('recipes');
    }
    echo "success";
	}  
    function deleteRecipeConfigs(){
        $tabelName = $this->POST['tablename'];
        unset($this->POST['tablename']);
         $result = $this->common_model->commonRecordUpdate($tabelName,'id',$this->POST['id'],$this->POST);
           
		echo 'succcess';
    }
    
    public function fetchIngredientDetails()
    {
    $ingredientId = $this->input->post('id');

    if ($ingredientId) {
        $ingredientDetails = $this->recipe_model->fetchIngredients($ingredientId);

        if (!empty($ingredientDetails)) {
            echo json_encode([
                'success' => true,
                'data' => [
                    'uom_id' => explode(',', $ingredientDetails[0]['uom_id']), 
                    'uom_name' => explode(',', $ingredientDetails[0]['uom_name']), 
                    'cost' => $ingredientDetails[0]['cost'],
                    'uomqty' => $ingredientDetails[0]['uomqty']
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Ingredient details not found.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    }
   }

    
    
   
    
    }
    
    ?>