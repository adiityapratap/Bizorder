<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Recipe_model extends CI_Model{
	

	function __construct() {
		parent::__construct();
		$this->selected_location_id = $this->session->userdata('default_location_id');
	}
	
	function recipeList(){
	    
	  $this->tenantDb->select('r.id, r.recipeName, r.cookingTime, r.difficulty, SUM(ri.cost) as totalCost');
$this->tenantDb->from('recipes as r');
$this->tenantDb->join('recipesToIngredients as ri', 'ri.recipeID = r.id', 'LEFT');
$this->tenantDb->where('r.is_deleted', 0);
$this->tenantDb->group_by('r.id'); // Group by recipe ID to get the total cost per recipe
$this->tenantDb->order_by('r.sort_order', 'ASC');
return $this->tenantDb->get()->result_array();

	}
	
	function fetchIngredients($ingredientId='') {
	    
       $this->tenantDb->select('ing.name ,ing.id,ing.uom, rc1.name as category_name,rc1.id as category_id,rc2.id as uom_id, rc2.name as uom_name,ing.cost,ing.uomqty');
       $this->tenantDb->from('ingredients as ing');
       $this->tenantDb->join('recipebuilder_configs as rc1', 'rc1.id = ing.category_id', 'LEFT');
       $this->tenantDb->join('recipebuilder_configs as rc2', 'rc2.id = ing.uom', 'LEFT');
       
       if($ingredientId !=''){
        $this->tenantDb->where('ing.id', $ingredientId);
        }
       // Add the conditions for the relevant listtypes
       $this->tenantDb->where('rc1.listtype', 'category');
       $this->tenantDb->where('ing.is_deleted', 0);
       $this->tenantDb->where('rc2.listtype', 'uom');

      return $this->tenantDb->get()->result_array();

   }
   
   function fetchRecipeInfo($recipeId){
    $this->tenantDb->select('
        R.*, 
        RBC.name as UOMName, 
        RI.ingredientId as ingredientId, 
        I.name as ingredientName, 
        I.uomqty as ingredientUOMqty, 
        I.cost as ingredientCost, 
        RI.qty, 
        RI.uom, 
        RI.cost, 
        RPS.id as rpsId, 
        RPS.prepSteps
    ');
    $this->tenantDb->from('recipes R');
    $this->tenantDb->join('recipesToIngredients RI', 'R.id = RI.recipeID', 'left');
    $this->tenantDb->join('recipeToPreparationSteps RPS', 'R.id = RPS.recipeID', 'left');
    $this->tenantDb->join('ingredients I', 'RI.ingredientId = I.id', 'left');
    $this->tenantDb->join('recipebuilder_configs RBC', 'RBC.id = RI.uom', 'left');
    $this->tenantDb->where('R.is_deleted', 0);
    $this->tenantDb->where('R.location_id', $this->selected_location_id);
    $this->tenantDb->where('R.id', $recipeId);
    // Only add the RBC filter if it's not a null join
    $this->tenantDb->group_start();
    $this->tenantDb->where('RBC.listtype', 'uom');
    $this->tenantDb->or_where('RBC.listtype IS NULL');
    $this->tenantDb->group_end();

    $query = $this->tenantDb->get();

    // echo $lastQuery = $this->tenantDb->last_query(); exit;
    $result = $query->result_array();

    // Process the results to nest ingredients under the recipe
    $processedResult = [];
    foreach ($result as $row) {
        $recipeId = $row['id'];
        
        if (!isset($processedResult[$recipeId])) {
            // Initialize the recipe data and ingredients array
            $processedResult[$recipeId] = [
                'id' => $row['id'],
                'rpsId' => $row['rpsId'],
                'recipeName' => $row['recipeName'],
                'servingSize' => $row['servingSize'],
                'preparationTime' => $row['preparationTime'],
                'cookingTime' => $row['cookingTime'],
                'totalTime' => $row['totalTime'],
                'difficulty' => $row['difficulty'],
                'date_added' => $row['date_added'],
                'location_id' => $row['location_id'],
                'is_deleted' => $row['is_deleted'],
                'prepSteps' => $row['prepSteps'],
                'ingredients' => [] // Initialize the ingredients array
            ];
        }
        
        // Add the ingredient to the recipe's ingredients array if present
        if ($row['ingredientId'] !== null) {
            $processedResult[$recipeId]['ingredients'][] = [
                'ingredientId' => $row['ingredientId'],
                'ingredientName' => $row['ingredientName'],
                'ingredientUOMqty' => $row['ingredientUOMqty'],
                'qty' => $row['qty'],
                'UOMName' => $row['UOMName'],
                'uom' => $row['uom'],
                'cost' => $row['cost'],
                'ingredientCost' => $row['ingredientCost']
            ];
        }
    }

    // Reset the array keys to a standard indexed array
    $processedResult = array_values($processedResult);

    // Output the final processed result
    return $processedResult;
}

   
}

?>