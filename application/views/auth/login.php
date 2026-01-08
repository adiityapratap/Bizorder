<div class="login-13">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-8 bg-img">
                <div class="bg-img-inner">
                    <div class="info">
                        <div class="center">
                            <h1>WELCOME TO BIZORDER</h1>
                        <p class="tagline">Your Patient Ordering Solution Partner</p>
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
<?php if (isset($message) && $message !=''){ ?>
<div id="infoMessage" class="alert alert-danger"><?php echo $message;?></div>
 <?php } ?>
 <div class="login-inner-form">
                            <?php if ($this->session->flashdata('error')): ?>
                             <div class="alert alert-danger">
                                <?php echo $this->session->flashdata('error'); ?>
                                 </div>
                               <?php endif; ?>


  <form action="<?php echo base_url();?>index.php/auth/login" method="POST">
                                <div class="form-group form-box clearfix">
                                    <input type="email" name="identity" id="identity" class="form-control" placeholder="Email Address" aria-label="Email Address">
                                    <i class="flaticon-mail-2"></i>
                                </div>
                                <div class="form-group form-box clearfix">
                                    <input name="password" id="password" type="password" class="form-control" autocomplete="off" placeholder="Password" aria-label="Password">
                                    <i class="flaticon-password"></i>
                                </div>
                                <div class="checkbox form-group clearfix">
                                    <!--<div class="form-check float-start">-->
                                    <!--    <input class="form-check-input" type="checkbox" id="remember" name="remember" value="1">-->
                                    <!--    <label class="form-check-label" for="remember">-->
                                    <!--        Remember me-->
                                    <!--    </label>-->
                                    <!--</div>-->
                                   
                                    <a href="/auth/forgot_password" class="link-light float-end forgot-password">Forgot password?</a>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-theme">Login</button>
                                </div>
                            </form>
 
 
 

</div>

</div>
                </div>
            </div>
        </div>
    </div>
</div>