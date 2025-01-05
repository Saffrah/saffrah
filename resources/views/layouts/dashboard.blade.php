<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
        <link rel="icon" type="image/png" href="../assets/img/favicon.png">
        <title>
            Next Trip
        </title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
        <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="../assets/css/corporate-ui-dashboard.css?v=1.0.0" rel="stylesheet" />
        
        @yield('CSS')

    </head>
    <body class="g-sidenav-show  bg-gray-100">
        @include('layouts.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            
            @include('layouts.navbar')
            <div class="container-fluid py-4 px-5">

                @yield('content')

            </div>

        </main>

        @include('layouts.preference')

        <!--   Core JS Files   -->
        <script src="../assets/js/core/popper.min.js"></script>
        <script src="../assets/js/core/bootstrap.min.js"></script>
        <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
        <script src="../assets/js/plugins/chartjs.min.js"></script>
        <script src="../assets/js/plugins/swiper-bundle.min.js" type="text/javascript"></script>
        
        @yield('JavaScript')
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Get all nav-link elements
                const navLinks = document.querySelectorAll(".nav-link");

                // Remove "active" class from all links and set it to the current one based on URL
                navLinks.forEach(link => {
                    // Check if the href of the link matches the current URL
                    if (link.href === window.location.href) {
                        link.classList.add("active");
                    } else {
                        link.classList.remove("active");
                    }

                    // Add click event listener for client-side navigation
                    link.addEventListener("click", function () {
                        navLinks.forEach(l => l.classList.remove("active")); // Remove "active" from others
                        this.classList.add("active"); // Add "active" to the clicked link
                    });
                });

                // Get the current URL path
                const path = window.location.pathname;

                // Split the path into segments based on '/'
                const pathSegments = path.split('/').filter(segment => segment !== '');

                // Initialize breadcrumb
                let breadcrumbHTML = `<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Dashboard</a></li>`;
                let title          = 'Dashboard';  // Default title

                // Generate the breadcrumb based on the path
                pathSegments.forEach((segment, index) => {
                    // Capitalize the segment (for example 'companies' becomes 'Companies')
                    const capitalizedSegment = segment.charAt(0).toUpperCase() + segment.slice(1);

                    // If it's the last segment, set it as active
                    if (index === pathSegments.length - 1) {
                        breadcrumbHTML += `<li class="breadcrumb-item text-sm text-dark active" aria-current="page">${capitalizedSegment}</li>`;
                        title = `${capitalizedSegment} ${title !== 'Dashboard' ? ' ' + title : ''}`;  // Update title for the last segment
                    } else {
                        breadcrumbHTML += `<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">${capitalizedSegment}</a></li>`;
                    }
                });

                // Update the breadcrumb HTML and title
                document.getElementById('breadcrumb').innerHTML = breadcrumbHTML;
                document.getElementById('breadcrumb-title').innerText = title;
            });

            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Corporate UI Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="../assets/js/corporate-ui-dashboard.min.js?v=1.0.0"></script>
    </body>
</html>