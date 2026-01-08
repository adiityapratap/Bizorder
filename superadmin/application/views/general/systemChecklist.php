<div class="container-fluid" style="    margin-top: 100px !important;">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            
            <div class="row row-inner">
        <div class="col-md-3 col-sm-6 mb-5">
            <div class="counter">
                <div class="counter-icon">
                 <i class="fa-solid fa-money-check-dollar"></i>
                </div>
                
                <h6>Cash/Register</h6>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-5">
            <div class="counter green">
                <div class="counter-icon">
                 <i class="fa-solid fa-mug-hot"></i>
                </div>
               
                <h6>Catering Admin</h6>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-5">
                    <div class="counter navyblue">
                        <div class="counter-icon">
                           <i class="fa-solid fa-book"></i>
                        </div>
                       
                        <h6>Compliance</h6>
                    </div>
                </div>
        <div class="col-md-3 col-sm-6 mb-5">
                    <div class="counter purple">
                        <div class="counter-icon">
                          <i class="fa-solid fa-id-badge"></i>
                        </div>
                   
                        <h6>HR Admin</h6>
                    </div>
                </div>
                
        <div class="col-md-3 col-sm-6 mb-5">
            <div class="counter lightpurple">
                <div class="counter-icon">
                   <i class="fa-solid fa-burger"></i>
                </div>
               
                <h6>Recipe Management</h6>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-5">
            <div class="counter blue">
                <div class="counter-icon">
                  <i class="fa-regular fa-file-zipper"></i>
                </div>
              
                <h6>Reports</h6>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-5">
                    <div class="counter pink">
                        <div class="counter-icon">
                          <i class="fa-solid fa-calendar-week"></i>
                        </div>
                  
                        <h6>Rosters & Timesheets</h6>
                    </div>
                </div>
        <div class="col-md-3 col-sm-6 mb-5">
                    <div class="counter purple">
                        <div class="counter-icon">
                         <i class="fa-brands fa-shopify"></i>
                        </div>
                      
                        <h6>Supplier Ordering</h6>
                    </div>
                </div>        
                
                </div>
    </div>
    <div class="col-md-6 col-sm-12">
            
            <div class="row row-inner">
        
	    <div class="card">
                <!-- Default panel contents -->
                <div class="card-header card-text">Today's Checklist</div>
            
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        Create Timehseet in Bendigo
                                <label class="switch ">
          <input type="checkbox" class="success">
          <span class="slider"></span>
        </label>
                    </li>
                    <li class="list-group-item">
                        Create Roster in Latrobe
                                <label class="switch ">
          <input type="checkbox" class="success">
          <span class="slider"></span>
        </label>
                    </li>
                    <li class="list-group-item">
                        Create Roster in Werribee
                                <label class="switch ">
          <input type="checkbox" class="success">
          <span class="slider"></span>
        </label>
                    </li>
                    <li class="list-group-item">
                        Place order for two suppliers
                               <label class="switch ">
          <input type="checkbox" class="success">
          <span class="slider"></span>
        </label>
                    </li>
                    <li class="list-group-item">
                       Place order for some suppliers
                               <label class="switch ">
          <input type="checkbox" class="success">
          <span class="slider"></span>
        </label>
                    </li>
                    <li class="list-group-item">
                        Mark paid the order number 123
                              <label class="switch ">
          <input type="checkbox" class="success">
          <span class="slider"></span>
        </label>
                    </li>
                </ul>
            </div> 
            
                </div>
    </div>
    </div>
</div>
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
body{
        background-color: #ffffff !important;
}
.card-text {
      font-size:18px;
      text-align: center;
      font-weight: 600;
    }
.row-inner{
    display:flex;
    padding:40px;
}
.counter{
    color: #f27f21;
    font-family: 'Open Sans', sans-serif;
    text-align: center;
    height: 160px;
    width: 160px;
    padding: 30px 25px 25px;
    margin: 0 auto;
    border: 3px solid #f27f21;
    border-radius: 20px 20px;
    position: relative;
    z-index: 1;
}
.counter:before,
.counter:after{
    content: "";
    background: #f3f3f3;
    border-radius: 20px;
    box-shadow: 4px 4px 2px rgba(0,0,0,0.2);
    position: absolute;
    left: 15px;
    top: 15px;
    bottom: 15px;
    right: 15px;
    z-index: -1;
}
.counter:after{
    background: transparent;
    width: 100px;
    height: 100px;
    border: 15px solid #f27f21;
    border-top: none;
    border-right: none;
    border-radius: 0 0 0 20px;
    box-shadow: none;
    top: auto;
    left: -10px;
    bottom: -10px;
    right: auto;
}
.counter .counter-icon{
    font-size: 35px;
    line-height: 35px;
    margin: 0 0 15px;
    transition: all 0.3s ease 0s;
}
.counter:hover .counter-icon{ transform: rotateY(360deg); }
.counter .counter-value{
    color: #555;
    font-size: 30px;
    font-weight: 600;
    line-height: 20px;
    margin: 0 0 20px;
    display: block;
    transition: all 0.3s ease 0s;
}
.counter:hover .counter-value{ text-shadow: 2px 2px 0 #d1d8e0; }
.counter h3{
    font-size: 17px;
    font-weight: 700;
    text-transform: uppercase;
    margin: 0 0 15px;
}
.counter.blue{
    color: #4accdb;
    border-color: #4accdb;
}
.counter.pink {
    color: #EE436D;
    border-color: #EE436D;
}
.counter.pink:after {
    color: #EE436D;
    border-color: #EE436D;
}
.counter.purple {
    color: #9C52A1;
    border-color: #9C52A1;
}
.counter.purple:after {
    border-bottom-color: #9C52A1;
    border-left-color: #9C52A1;
}
.counter.blue:after{
    border-bottom-color: #4accdb;
    border-left-color: #4accdb;
}

.counter.green {
    color: #45cb85;
    border-color: #45cb85;
}
.counter.green:after{
    border-bottom-color: #45cb85;
    border-left-color: #45cb85;
}

.counter.lightpurple {
    color: #464496;
    border-color: #464496;
}
.counter.lightpurple:after {
    color: #464496;
    border-color: #464496;
}

.counter.navyblue {
    color: #0d3350;
    border-color: #0d3350;
}
.counter.navyblue:after {
    color: #0d3350;
    border-color: #0d3350;
}

@media screen and (max-width:990px){
    .counter{ margin-bottom: 40px; }
}
 /* Laptop  */
@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
 .counter{
      height: 140px;
    width: 140px;
 }
 .counter .counter-icon{
    font-size: 28px;
 }
 .counter .counter-icon h6{
   font-size:12px !important;  
 }
 .row {
    --vz-gutter-x: 7.5rem;
 }
 .row-inner{
    padding:20px !important;  ;
}
.counter h6{
    font-size: 10px !important; 
}
}
@media only screen  and (min-width: 1025px)   and (max-width: 1366px) {
    .counter{
      height: 140px;
    width: 140px;
 }
 .counter .counter-icon{
    font-size: 28px;
 }
 .counter .counter-icon h6{
   font-size:12px !important;  
 }
 .row {
    --vz-gutter-x: 7.5rem;
 }
 .row-inner{
    padding:20px !important;  ;
}
.counter h6{
    font-size: 10px !important; 
}
}
 
/*     ============================================          checklist CSS  ============================================   */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
  float:right;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input.default:checked + .slider {
  background-color: #444;
}
input.primary:checked + .slider {
  background-color: #2196F3;
}
input.success:checked + .slider {
  background-color: #272a54;
}
input.info:checked + .slider {
  background-color: #3de0f5;
}
input.warning:checked + .slider {
  background-color: #FFC107;
}
input.danger:checked + .slider {
  background-color: #f44336;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
.card,.card-header{
  background-color: #f9f9fa !important;
      border-radius: 20px;
}
.list-group-item {
        padding: 4px !important;;
    background-color: #f9f9fa !important;
    border-bottom: var(--vz-list-group-border-width) solid #dadada !important;
   
}

</style>