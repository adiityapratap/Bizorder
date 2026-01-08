
                    <div class="container-fluid mt-3">
                        <h4 class="text-black mb-3">Please enter card details below</h4>
                        <div class="row">
                            <div class="col-lg-6" >
                                <div class="card" style="background-color: rgb(233 245 254);">
                <div class="alert alert-success shadow showSuccessAlert" role="alert" style="display:none">
                 
                 </div>
                    <div class="card-body">
                        <form onsubmit="return false;" class="text-center">
      <div id="securepay-ui-container"></div>
      <button class="btn btn-success" onclick="mySecurePayUI.tokenise();">Submit</button>
      <button class="btn btn-danger" onclick="mySecurePayUI.reset();">Reset</button>
    </form>
                       
                   
                    </div>         
                     </div>
                    </div>
                        </div>
                       </div>
              
              
           
          
         
       <script id="securepay-ui-js" src="https://payments-stest.npe.auspost.zone/v3/ui/client/securepay-ui.min.js"></script>
    <script type="text/javascript">
  var mySecurePayUI = new securePayUI.init({
    containerId: 'securepay-ui-container',
    scriptId: 'securepay-ui-js',
    clientId: 'IOAolN5KM7FKyhoTvUEoS391xx3e74Pr',
    merchantCode: 'ub1ZpuO0y6e5r-y-AowJ8gNnqJfA51bOinIwmjPdkJsNttgibd95ytZEn3vvxFbL',
    card: {
      allowedCardTypes: ['visa', 'mastercard'],
      showCardIcons: false,
      onTokeniseSuccess: function (tokenisedCard) {
        // Tokenization successful
        const token = tokenisedCard.singleUseToken;
        console.log("Token:", token);

        // Send the token to your server
        fetch('/process_payment', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            token: token,
            amount: 100.00, // Example amount
            orderId: 1234, // Example order ID
          }),
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert("Payment successful!");
              console.log("Response:", data);
            } else {
              alert("Payment failed: " + data.message);
            }
          })
          .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while processing the payment.");
          });
      },
      onTokeniseError: function (errors) {
        console.error("Tokenization Error:", errors);
        alert("Failed to tokenize card details.");
      }
    },
    style: {
      backgroundColor: 'rgba(135, 206, 250, 0.1)',
      label: {
        font: {
          family: 'Arial, Helvetica, sans-serif',
          size: '1.1rem',
          color: 'darkblue',
        }
      },
      input: {
        font: {
          family: 'Arial, Helvetica, sans-serif',
          size: '1.1rem',
          color: 'darkblue',
        }
      }
    },
    onLoadComplete: function () {
      console.log("SecurePay UI loaded successfully.");
    }
  });
</script>

   