<style>
  p{
    font-weight: 400!important;
  }
</style>
<div class="main">
  <div class="contact-content">
    <div class="container">
      <div class="row">
        <div class="col-md-5 ml-auto mr-auto pt-5 mt-5">
          <h2 class="title">Send us a message</h2>
          <p class="description">You can contact us with anything related to our products or services. We'll get in touch with you as soon as possible.
            <br>
            <br>
          </p>
          <form role="form" id="contact-form">
            <label>Your name</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="now-ui-icons users_circle-08"></i></span>
              </div>
              <input type="text" class="form-control" name="name" placeholder="Your Name..." aria-label="Your Name..." autocomplete="name" required>
            </div>
            <label>Email address</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="now-ui-icons ui-1_email-85"></i></span>
              </div>
              <input type="email" class="form-control" name="email" placeholder="Email Here..." aria-label="Email Here..." autocomplete="email" required>
            </div>
            <label>Phone</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="now-ui-icons tech_mobile"></i></span>
              </div>
              <input type="text" class="form-control" name="phone" placeholder="Number Here..." autocomplete="number" required>
            </div>
            <div class="form-group">
              <label>Your message</label>
              <textarea name="message" class="form-control" id="message" rows="6" required></textarea>
            </div>
              <div class="alert alert-success" role="alert">
                <div class="container">
                  <div class="alert-icon">
                    <i class="now-ui-icons ui-2_like"></i>
                  </div>
                  Your message has been sent!
                </div>
              </div>
            <div class="submit text-center">
              <input type="submit" class="btn btn-primary btn-raised btn-round" value="Contact Us" />
            </div>
          </form>
        </div>
        <div class="col-md-5 ml-auto mr-auto">
          <div class="info info-horizontal mt-5">
            <div class="icon icon-primary">
              <i class="now-ui-icons location_pin"></i>
            </div>
            <div class="description">
              <h4 class="info-title">Find us at the office</h4>
              <p> <strong>West Moreton Health</strong><br>Chelmsford Avenue,<br>Ipswich QLD 4305, <br>Australia
              </p>
            </div>
          </div>
          <div class="info info-horizontal">
            <div class="icon icon-primary">
              <i class="now-ui-icons tech_mobile"></i>
            </div>
            <div class="description">
              <h4 class="info-title">Give us a ring</h4>
              <p>1800 692 283
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(function(){
    $('.alert').hide();
    $("#contact-form").on('submit',function(e){
      e.preventDefault();
      $.ajax({
        url:'<?php echo base_url();?>index.php/general/contact',
        method:"POST",
        data:$("#contact-form").serialize(),
        success:function(data){
          if(data=="1")
            $(".alert").slideDown().delay(3000).slideUp();
        }
      })
    })
  })
</script>