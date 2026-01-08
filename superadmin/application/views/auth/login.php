<div class="login-13">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-8 bg-img">
                <div class="bg-img-inner">
                    <div class="info">
                        <div class="center">
                            <h1>Welcome To BIZORDER</h1>
                        <p class="tagline"><b>BIZORDER</b> is a one stop management tool to simplify your business processes.</p>
                        </div>
                        
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 form-info">
                <div class="form-section">
                    <div class="form-section-innner">
                        <div class="logo clearfix">
                            <a href="">
                                <!--<img src="<?php echo base_url();?>theme-assets/img/logos/logo.png" alt="logo">-->
                            </a>
                        </div>
                        <h3>Sign Into Your Account</h3>
                       
                        <div class="login-inner-form">
                            <form action="<?php echo base_url();?>index.php/login" method="POST">
                                <div class="form-group form-box clearfix">
                                    <input type="email" name="email" class="form-control" placeholder="Email Address" aria-label="Email Address">
                                    <i class="flaticon-mail-2"></i>
                                </div>
                                <div class="form-group form-box clearfix">
                                    <input name="password" type="password" class="form-control" autocomplete="off" placeholder="Password" aria-label="Password">
                                    <i class="flaticon-password"></i>
                                </div>
                                <div class="checkbox form-group clearfix">
                                    
                                    <a href="#" class="link-light float-end forgot-password">Forgot password?</a>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-theme">Login</button>
                                </div>
                            </form>
                        </div>
                       
                        <p class="none-2">Don't have an account? <a href="register-13.html" class="thembo"> Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.header {
  background-color: #007bff;
  color: #fff;
  text-align: center;
  padding: 10px;
  font-size: 24px;
}
.tagline{
       
    font-family: ui-monospace;
        font-size: 18px;
}
.quote-container{
    position: absolute;
    bottom: 130px;
    width: 62%;
    text-align: center;
    color: #fff;
    padding: 5px 0;
}
    .quote-text {
            font-size: 22px;
            font-style: italic;
            color: #333;
            margin-bottom: 20px;
                text-align: center;
            position: relative; /* Needed for the quote marks */
        }
        .quote-text:before, /* Quote mark before the quote text */
        .quote-text:after { /* Quote mark after the quote text */
            font-family: "FontAwesome";
            font-weight: 900;
            font-size: 40px;
            color: #007bff;
            position: absolute;
            top: -20px;
        }
        .quote-text:before {
            content: "\f10d"; /* Font Awesome icon for left double quote */
            left: -20px;
        }
        .quote-text:after {
            content: "\f10e"; /* Font Awesome icon for right double quote */
            right: -20px;
        }
        .quote-author {
            font-size: 18px;
            color: #666;
                text-align: center;
        }
        
</style>