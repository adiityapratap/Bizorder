<style>

.feedback{
    width: 100%;
    max-width: 780px;
    background: #fff;
    margin: 0 auto;
    padding: 15px;
    box-shadow: 1px 1px 16px rgba(0, 0, 0, 0.3);
}
.survey-hr{
  margin:10px 0;
  border: .5px solid #ddd;
}

.star-rating {
margin: 5px 0 0px;
    font-size: 0;
    white-space: nowrap;
    display: inline-block;
    width: 106px;
    height: 21px;
    overflow: hidden;
    position: relative;
    background: url(data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDIwIDIwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cG9seWdvbiBmaWxsPSIjREREREREIiBwb2ludHM9IjEwLDAgMTMuMDksNi41ODMgMjAsNy42MzkgMTUsMTIuNzY0IDE2LjE4LDIwIDEwLDE2LjU4MyAzLjgyLDIwIDUsMTIuNzY0IDAsNy42MzkgNi45MSw2LjU4MyAiLz48L3N2Zz4=);
    background-size: contain;
}
.star-rating i {
  opacity: 0;
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  width: 20%;
  z-index: 1;
  background: url('data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDIwIDIwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cG9seWdvbiBmaWxsPSIjRkZERjg4IiBwb2ludHM9IjEwLDAgMTMuMDksNi41ODMgMjAsNy42MzkgMTUsMTIuNzY0IDE2LjE4LDIwIDEwLDE2LjU4MyAzLjgyLDIwIDUsMTIuNzY0IDAsNy42MzkgNi45MSw2LjU4MyAiLz48L3N2Zz4=');
  background-size: contain;
}
.star-rating input {
  -moz-appearance: none;
  -webkit-appearance: none;
  opacity: 0;
  display: inline-block;
  width: 20%;
  height: 100%;
  margin: 0;
  padding: 0;
  z-index: 2;
  position: relative;
}
.star-rating input:hover + i,
.star-rating input:checked + i {
  opacity: 1;
}
.star-rating i ~ i {
  width: 40%;
}
.star-rating i ~ i ~ i {
  width: 60%;
}
.star-rating i ~ i ~ i ~ i {
  width: 80%;
}
.star-rating i ~ i ~ i ~ i ~ i {
  width: 100%;
}
.choice {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  text-align: center;
  padding: 20px;
  display: block;
}
span.scale-rating{
margin: 5px 0 15px;
    display: inline-block;
   
    width: 100%;
   
}
span.scale-rating>label {
  position:relative;
    -webkit-appearance: none;
  outline:0 !important;
    border: 1px solid grey;
    height:33px;
    margin: 0 5px 0 0;
  width: calc(10% - 7px);
    float: left;
  cursor:pointer;
}
span.scale-rating label {
  position:relative;
    -webkit-appearance: none;
  outline:0 !important;
    height:33px;
      
    margin: 0 5px 0 0;
  width: calc(10% - 7px);
    float: left;
  cursor:pointer;
}
span.scale-rating input[type=radio] {
  position:absolute;
    -webkit-appearance: none;
  opacity:0;
  outline:0 !important;
    /*border-right: 1px solid grey;*/
    height:33px;
 
    margin: 0 5px 0 0;
  
  width: 100%;
    float: left;
  cursor:pointer;
  z-index:3;
}
span.scale-rating label:hover{
background:#fddf8d;
}
span.scale-rating input[type=radio]:last-child{
border-right:0;
}
span.scale-rating label input[type=radio]:checked ~ label{
    -webkit-appearance: none;
    margin: 0;
  background:#fddf8d;
}
span.scale-rating label:before
{
  content:attr(value);
    top: 7px;
    width: 100%;
    position: absolute;
    left: 0;
    right: 0;
    text-align: center;
    vertical-align: middle;
  z-index:2;
}
</style>

<div class="feedback">
<p>Dear <?php echo $cname; ?>,<br>
We’d love to know about your website experience placing an order with us.</p>
<h4>Please rate it and write a review to let us know.</h4>
<form method="post" action="https://healthychoicescatering.com.au/manager/index.php/orders/feedback_form_submit">
    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
    <input type="hidden" name="delivery_date" value="<?php echo $delivery_date;?>">
   <input type="hidden" name="company_name" value="<?php echo $company_name; ?>">
   <input type="hidden" name="cname" value="<?php echo $cname; ?>">
    <input type="hidden" name="location_id" value="<?php echo $location_id; ?>">
    <input type="hidden" name="ofrom" value="<?php echo $ofrom; ?>">
<!--  <label>1. FOOD</label><br>-->
<!--  <span class="star-rating">-->
<!--  <input type="radio" name="FOOD" value="1"><i></i>-->
<!--  <input type="radio" name="FOOD" value="2"><i></i>-->
<!--  <input type="radio" name="FOOD" value="3"><i></i>-->
<!--  <input type="radio" name="FOOD" value="4"><i></i>-->
<!--  <input type="radio" name="FOOD" value="5"><i></i>-->
<!--</span>-->

<!--<div class="clear"></div> -->
<!--  <hr class="survey-hr">-->
<!--  <label>2. PRICING</label><br>-->
<!--  <span class="star-rating">-->
<!--  <input type="radio" name="PRICING" value="1"><i></i>-->
<!--  <input type="radio" name="PRICING" value="2"><i></i>-->
<!--  <input type="radio" name="PRICING" value="3"><i></i>-->
<!--  <input type="radio" name="PRICING" value="4"><i></i>-->
<!--  <input type="radio" name="PRICING" value="5"><i></i>-->
<!--</span>-->

<!--<div class="clear"></div> -->
<!--  <hr class="survey-hr">-->
<!--  <label>3. MENU</label><br>-->
<!--  <span class="star-rating">-->
<!--  <input type="radio" name="MENU" value="1"><i></i>-->
<!--  <input type="radio" name="MENU" value="2"><i></i>-->
<!--  <input type="radio" name="MENU" value="3"><i></i>-->
<!--  <input type="radio" name="MENU" value="4"><i></i>-->
<!--  <input type="radio" name="MENU" value="5"><i></i>-->
<!--</span>-->
<!--  <div class="clear"></div> -->
<!--  <hr class="survey-hr">  -->
<!--<label>4. WEBSITE EXPERIENCE </label><br>-->
  
<!--<span class="star-rating">-->
<!--  <input type="radio" name="EXPERIENCE" value="1"><i></i>-->
<!--  <input type="radio" name="EXPERIENCE" value="2"><i></i>-->
<!--  <input type="radio" name="EXPERIENCE" value="3"><i></i>-->
<!--  <input type="radio" name="EXPERIENCE" value="4"><i></i>-->
<!--  <input type="radio" name="EXPERIENCE" value="5"><i></i>-->
<!--</span>-->
<!--  <div class="clear"></div> -->
<!--  <hr class="survey-hr">-->
<!--<label>5. DELIVERY</label><br>-->
<!--<span class="star-rating">-->
<!--  <input type="radio" name="DELIVERY" value="1"><i></i>-->
<!--  <input type="radio" name="DELIVERY" value="2"><i></i>-->
<!--  <input type="radio" name="DELIVERY" value="3"><i></i>-->
<!--  <input type="radio" name="DELIVERY" value="4"><i></i>-->
<!--  <input type="radio" name="DELIVERY" value="5"><i></i>-->
<!--</span>-->
<!--  <div class="clear"></div> -->
<!--  <hr class="survey-hr">-->
<!--<label>6. PACKAGING</label><br>-->
<!--<span class="star-rating">-->
<!--  <input type="radio" name="PACKAGING" value="1"><i></i>-->
<!--  <input type="radio" name="PACKAGING" value="2"><i></i>-->
<!--  <input type="radio" name="PACKAGING" value="3"><i></i>-->
<!--  <input type="radio" name="PACKAGING" value="4"><i></i>-->
<!--  <input type="radio" name="PACKAGING" value="5"><i></i>-->
<!--</span>-->
<!--  <div class="clear"></div> -->
<!--  <hr class="survey-hr">-->
<!--  <label>7. CUSTOMER SERVICE</label><br>-->
<!--  <span class="star-rating">-->
<!--  <input type="radio" name="SERVICE" value="1"><i></i>-->
<!--  <input type="radio" name="SERVICE" value="2"><i></i>-->
<!--  <input type="radio" name="SERVICE" value="3"><i></i>-->
<!--  <input type="radio" name="SERVICE" value="4"><i></i>-->
<!--  <input type="radio" name="SERVICE" value="5"><i></i>-->
<!--</span>-->


<div class="clear"></div> 
  <hr class="survey-hr"> 
<label for="m_3189847521540640526commentText">1. Was the order delivered on time? </label><br/><br/>
<textarea cols="65" name="deliveredOnTime" rows="2" style="100%"></textarea><br>
<br>




  <div class="clear"></div> 
  <hr class="survey-hr"> 
<label for="m_3189847521540640526commentText">2. One thing we can improve on with your overall experience:</label><br/><br/>
<select id="overall" name="commentText" class="form-control">
<option value="food">Food</option>
<option value="menu">Menu</option>
<option value="packaging">Packaging</option>
<option value="service">Customer Service</option>
</select>
<br>
<div class="clear"></div> 
  <hr class="survey-hr"> 
<label for="suggestions">Suggestions </label><br/><br/>
<textarea cols="65" name="suggestions" rows="2" style="100%"></textarea><br>
<br>

  <div class="clear"></div> 
<input style="background:#8BC34A;color:#fff;padding:12px;border:0" type="submit" value="Submit your review"> 
<br>
<br>
<label>Kind Regards,</label><br>
<label>Healthy Choices Catering.</label>
</form>
</div>