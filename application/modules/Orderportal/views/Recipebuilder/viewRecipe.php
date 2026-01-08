<style>
@media print {
    textarea {
        display: none;
    }
    .textarea-print-content {
        display: block;
        white-space: pre-wrap; /* Preserves newlines */
        word-wrap: break-word;
        font-family: inherit; /* Matches the surrounding text */
        font-size: inherit;
    }
}
.textarea-print-content {
    display: none; /* Hide it in normal view */
}
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0 text-black printhide text-center">Recipe Details</h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div>
                                        <button onclick="history.back()" class="btn btn-danger btn-sm"><i class="ri-arrow-go-back-line me-2"></i> Back</button>
                                        <button class="btn btn-success btn-sm" id="printButton"><i class="ri-printer-line me-2"></i> Print Recipe</button>
                                            
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Recipe Details Section -->
                            <div>
                               
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p><strong>Recipe Name:</strong> <?= htmlspecialchars($recipeInfo['recipeName'] ?? '', ENT_QUOTES); ?></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><strong>Serving Size:</strong> <?= htmlspecialchars($recipeInfo['servingSize'] ?? '', ENT_QUOTES); ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p><strong>Preparation Time:</strong> <?= htmlspecialchars($recipeInfo['preparationTime'] ?? '', ENT_QUOTES); ?></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><strong>Cooking Time:</strong> <?= htmlspecialchars($recipeInfo['cookingTime'] ?? '', ENT_QUOTES); ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p><strong>Total Time:</strong> <?= htmlspecialchars($recipeInfo['totalTime'] ?? '', ENT_QUOTES); ?></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><strong>Difficulty:</strong> <?= htmlspecialchars($recipeInfo['difficulty'] ?? '', ENT_QUOTES); ?></p>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <!-- Ingredient Details Section -->
                            <div>
                                <h5 class="mb-3 text-black">Ingredient Details</h5>
                                <?php if (isset($recipeInfo['ingredients']) && !empty($recipeInfo['ingredients'])) { ?>
                                    <div class="table-responsive ">
                                        <table class="table table-bordered">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Ingredient Name</th>
                                                    <th>Quantity</th>
                                                    <th>UOM</th>
                                                    <th>Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
$totalCost = 0; // Initialize a variable to keep track of the total cost

foreach ($recipeInfo['ingredients'] as $recipeIngredients) { 
    $totalCost += $recipeIngredients['cost']; // Add the cost of each ingredient to the total
?>
    <tr>
        <td>
            <?php 
            if (isset($ingredients) && !empty($ingredients)) {
                $matchingIngredient = array_filter($ingredients, function($ingredient) use ($recipeIngredients) {
                    return $ingredient['id'] == $recipeIngredients['ingredientId'];
                });

                // Get the first matching ingredient's name
                echo !empty($matchingIngredient) ? current($matchingIngredient)['name'] : 'Ingredient not found';
            } else {
                echo 'No ingredients available';
            }
            ?>
        </td>
        <td><?= htmlspecialchars($recipeIngredients['qty'], ENT_QUOTES); ?></td>
        <td><?= htmlspecialchars($recipeIngredients['UOMName'], ENT_QUOTES); ?></td>
        <td>$<?= number_format($recipeIngredients['cost'], 2); ?></td>
    </tr>
<?php } ?>

<!-- Total cost row -->
<tr>
    <td colspan="3" class="text-end"><strong>Total Cost:</strong></td>
    <td><strong>$<?= number_format($totalCost, 2); ?></strong></td>
</tr>

                                             
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <p>No ingredients added.</p>
                                <?php } ?>
                            </div>
                            <hr>

                            <!-- Preparation Steps Section -->
                            <div>
    <textarea class="form-control" placeholder="Enter steps" rows="4" id="prepStepsTextarea"><?php echo isset($recipeInfo['prepSteps']) ? htmlspecialchars($recipeInfo['prepSteps'], ENT_QUOTES) : ''; ?></textarea>
    <div class="textarea-print-content" id="prepStepsPrintContent">
        <?php echo isset($recipeInfo['prepSteps']) ? nl2br(htmlspecialchars($recipeInfo['prepSteps'], ENT_QUOTES)) : ''; ?>
    </div>
</div>
                            <hr>

                            <!-- Print Button -->
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('printButton').addEventListener('click', function () {
    window.print();
});


</script>
