<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Link Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Link Font Awesome CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    /* Additional Custom CSS */
    .custom-card {
      height: 250px;
      width: 250px;
      border-radius: 20px;
      background-color: #f4f4f4;
      color: #323b4b;
      
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 10px;
      position: relative;
      transition: background-color 0.3s, transform 0.3s;
    }

    .custom-card:hover {
      background-color: #1e2046;
      transform: scale(1.05);
    }

    .card-icon {
      font-size: 40px;
      margin-top: 20px; /* Adjusted top margin for better alignment */
    }

    .card-text {
      margin-top: 14px;
      text-align: center;
      font-weight: 600;
    }

    .custom-card:hover .card-icon {
      /*color: #323b4b;*/
      color: white;
    }

    /* Text color on hover */
    .custom-card:hover .card-text {
      color: white;
    }

    /* Welcome message */
    .welcome-message {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 10px;
      text-align: left;
    }

    /* Please select location text */
    .location-text {
      font-size: 18px;
      text-align: left;
      padding: 10px;
      font-weight:600;
    }

   

    /* Media queries for responsiveness */
    @media (max-width: 767px) {
      .custom-card {
        margin-bottom: 20px; /* Add some space between cards on mobile */
      }
      .next-button {
        bottom: 70px; /* Adjust the position of the Next button on mobile */
      }
    }
  </style>
</head>
<body>
  <div class="container" style="margin-top: 100px;">
    <!-- Welcome Message -->
    <div class="col-12">
      <div class="welcome-message mb-3">Welcome to BizAdmin, Justin</div>
      <div class="location-text mb-3">Please select location</div>
    </div>
    <!-- Cards Section -->
    <div class="row justify-content-center">
      <div class="col-12 col-md-3 mb-4">
        <div class="card-container">
            <a style="text-decoration: none;" href="https://bizadmin.com.au/superadmin_login/index.php/auth/checklist">
          <div class="custom-card">
            <i class="fas fa-store card-icon"></i>
            <div class="card-text">Bendigo</div>
          </div>
          </a>
        </div>
      </div>
      <div class="col-12 col-md-3 mb-4">
        <div class="card-container">
            <a style="text-decoration: none;" href="https://bizadmin.com.au/superadmin_login/index.php/auth/checklist">
          <div class="custom-card">
            <i class="fas fa-store card-icon"></i>
            <div class="card-text">Latrobe</div>
          </div>
          </a>
        </div>
      </div>
      <div class="col-12 col-md-3 mb-4">
        <div class="card-container">
            <a style="text-decoration: none;" href="https://bizadmin.com.au/superadmin_login/index.php/auth/checklist">
          <div class="custom-card">
            <i class="fas fa-store card-icon"></i>
            <div class="card-text">Werribee</div>
          </div>
          </a>
        </div>
      </div>
      <div class="col-12 col-md-3 mb-4">
        <div class="card-container">
            <a style="text-decoration: none;" href="https://bizadmin.com.au/superadmin_login/index.php/auth/checklist">
          <div class="custom-card">
            <i class="fas fa-store card-icon"></i>
            <div class="card-text">Test</div>
          </div>
          </a>
        </div>
      </div>
    </div>
  </div>
 

  <!-- Link Bootstrap JS and Popper.js (if needed) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
