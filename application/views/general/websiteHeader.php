<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Links of CSS files -->
    <link rel="stylesheet" href="mainWebsiteAssets/css/bootstrap.min.css">
    <link rel="stylesheet" href="mainWebsiteAssets/css/animate.min.css">
    <link rel="stylesheet" href="mainWebsiteAssets/css/meanmenu.min.css">
    <link rel="stylesheet" href="mainWebsiteAssets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="mainWebsiteAssets/css/odometer.min.css">
    <link rel="stylesheet" href="mainWebsiteAssets/css/showMoreItems-theme.min.css">
    <link rel="stylesheet" href="mainWebsiteAssets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="mainWebsiteAssets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="mainWebsiteAssets/css/remixicon.css">
    <link rel="stylesheet" href="mainWebsiteAssets/css/style.css">
    <link rel="stylesheet" href="mainWebsiteAssets/css/serviceSection.css">
    <link rel="stylesheet" href="mainWebsiteAssets/css/responsive.css">
    
     <script src="mainWebsiteAssets/js/jquery.min.js"></script>
    <script src="mainWebsiteAssets/js/bootstrap.bundle.min.js"></script>
    <script src="mainWebsiteAssets/js/language-switcher.js"></script>

    <title>Bizorder</title>

    <link rel="icon" type="image/ico" href="mainWebsiteAssets/img/logoBiz.png">
    
    <style>
    #servicesAccordion {
     display: none;
     }
    @media (max-width: 768px) {
     .accordion-button {
            background-color: #262f5e !important;
            color: #fff !important;
            font-weight: bold;
            font-size: 12px;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .accordion-button span {
            color: #F4A261;
            font-weight: bold;
            font-size: 18px;
            margin-right: 10px;
        }

        .accordion-button::after {
            content: "▼";
            font-size: 16px;
            color: #F4A261;
            transform: rotate(0deg);
            transition: transform 0.3s ease;
        }

        .accordion-button:not(.collapsed)::after {
            transform: rotate(180deg);
        }

        .accordion-body {
            background-color: #111;
            color: #fff;
            font-size: 16px;
        }

        .accordion-item {
            border: none;
            border-bottom: 1px solid #444;
        }
        .monitor-services{
            display:none !important;
        }
        #servicesAccordion {
        display: block;
        }
        
        
        .featuresTitle{
            font-size: 16px;
            line-height: 24px;
        }
        .about-image img{
            height: 350px !important;
        }
        .owl-stage-outer{
                height: 350px !important;
                background-image: url(https://bizorder.com.au/mainWebsiteAssets/img/banner/banner-dummy.png);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
        }
}


    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const element = document.querySelector('.monitor-services');
        const serviceItems = element.querySelectorAll('.service-item');
        const serviceImages = document.querySelectorAll('.service-image');
        serviceItems.forEach((serviceItem, index) => {
            serviceItem.addEventListener('click', () => {
                serviceItems.forEach((item) => {
                    item.classList.remove('active');
                });
                serviceImages.forEach((image) => {
                    image.classList.remove('active');
                });
                serviceItem.classList.add('active');
                serviceImages[index].classList.add('active');
                const mainImage = document.querySelector('.main-image');
                mainImage.scrollTo({
                    left: serviceImages[index].offsetLeft - mainImage.offsetLeft,
                    behavior: 'smooth',
                });
            });
        });
    });
    
    
    
    </script>
    
    <script>
        document.querySelectorAll(".accordion-header").forEach(button => {
            button.addEventListener("click", function() {
                const accordionItem = this.parentElement;
                const isActive = accordionItem.classList.contains("active");

                // Close all accordions
                document.querySelectorAll(".accordion-item").forEach(item => {
                    item.classList.remove("active");
                });

                // Toggle current accordion
                if (!isActive) {
                    accordionItem.classList.add("active");
                }
            });
        });
    </script>
</head>
<body>
   <!-- Start Navbar Area -->
        <div class="navbar-area">
            <div class="enry-responsive-nav">
                <div class="container">
                    <div class="enry-responsive-menu">
                        <div class="logo">
                            <a href="index.php"><img src="mainWebsiteAssets/img/logoBiz.png" alt="logo" style="height: 35px; width:100px"></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="enry-nav">
                <div class="container">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand" href="index.php"><img src="mainWebsiteAssets/img/logoBiz.png" alt="logo" style="height: 40px;"></a>

                        <div class="collapse navbar-collapse mean-menu">
                            <ul class="navbar-nav">
                               
    <li class="nav-item"><a href="about.php" class="nav-link" data-lang="navbar.about">ABOUT</a></li>
    <li class="nav-item"><a href="services.php" class="nav-link" data-lang="navbar.services">FEATURES</a></li>
    <li class="nav-item"><a href="services.php" class="nav-link" data-lang="navbar.services">WHY CHOOSE US</a></li>
    <li class="nav-item"><a href="contact.php" class="nav-link" data-lang="navbar.contact">CONTACT</a></li>
    <li class="mt-3"><a href="https://bizorder.com.au/zenn" class=" btn btn-dark login-btn">LOGIN</a></li>

                            </ul>

                            <div class="others-option">
                                <div class="dropdown language-switcher">
                                    <button class="btn btn-secondary d-flex align-items-center dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="mainWebsiteAssets/img/flag/aus.png" alt="image">
                                        <span>Eng <i class="ri-arrow-down-s-line"></i></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        
                                        
                                         <li> <a href="#" class="dropdown-item d-flex align-items-center" data-lang="language.en">English</a></li>
                
                                        
                                        
                                    </ul>
                                </div>

                                
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- End Navbar Area -->
    <!-- End Navbar Area -->

    <!-- Your content here -->

    <!-- Scripts -->
   


        
        