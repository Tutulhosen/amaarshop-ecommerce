<?php 
    $meta=DB::table('meta')->where('status', 1)->first();
?>
<!doctype html>

<html
  lang="en"
  class="light-style layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="admin/assets/"
  data-template="vertical-menu-template-free"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{$meta->title}} Admin</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    @if ($meta->fav_icon)
    <link rel="shortcut icon" href="{{asset('images/fav_icon/' . $meta->fav_icon)}}">
    @else
    <link rel="shortcut icon" href="{{asset('logo-icon.png')}}" />
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('admin/assets/vendor/fonts/boxicons.css')}}" />
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/demo.css')}}" />
    
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/apex-charts/apex-charts.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/font-awesome.min.css')}}" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    {{-- toster link --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    {{-- sweet alert link  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
</head>
    <!-- Page CSS -->
    
    <script src="https://kit.fontawesome.com/5b135da28d.js" crossorigin="anonymous"></script>
    <!-- Helpers -->
    <script src="{{asset('admin/assets/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('admin/assets/js/config.js')}}"></script>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script> --}}
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        @include('admin.layout.sidebar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          @include('admin.layout.header')

          <!-- / Navbar -->

          <!-- Content wrapper -->
          @section('main-content')
              
          @show
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script>
      // alert();
       $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
      
    </script>

    {{-- //file upload  --}}
    <script>
      // Image Preview Function
      const imageUpload = document.getElementById('imageUpload');
      const imagePreview = document.getElementById('imagePreview');
  
      imageUpload.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function (e) {
            imagePreview.setAttribute('src', e.target.result);
          }
          reader.readAsDataURL(file);
        }
      });

      //multiple image
      document.getElementById('multipleImageUpload').addEventListener('change', function(event) {
          $('#previousImageContainer').hide();
          const files = event.target.files;
          const imagePreviewContainer = document.getElementById('multipleImagePreviewContainer');
          
          // Clear previous previews
          imagePreviewContainer.innerHTML = '';

          // Loop through the selected files
          Array.from(files).forEach(file => {
              if (file.type.startsWith('image/')) {
                  const reader = new FileReader();

                  reader.onload = function(e) {
                      // Create a new img element and set its source to the file content
                      const img = document.createElement('img');
                      img.src = e.target.result;
                      img.alt = 'Image Preview';
                      img.style.maxWidth = '150px';  // Set image size for preview
                      img.style.maxHeight = '150px';  // Set image size for preview
                      img.style.marginRight = '10px';
                      img.style.marginBottom = '10px';

                      // Append the img element to the preview container
                      imagePreviewContainer.appendChild(img);
                  };

                  reader.readAsDataURL(file);
              }
          });
      });

      
    </script>
    {{-- chart js  --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
    <!-- jQuery (necessary for Toastr) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    
    <!-- Spectrum JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.1/spectrum.min.js"></script>
    
    <script src="{{asset('admin/assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/js/menu.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/js/jquery-3.3.1.slim.min.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{asset('admin/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

    <!-- Main JS -->
    <script src="{{asset('admin/assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{asset('admin/assets/js/dashboards-analytics.js')}}"></script>
    

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="{{asset('https://buttons.github.io/buttons.js')}}"></script>
    {{-- fontawesome  --}}
    <script>
      // Function to show a Toastr alert
      function showToast(message, type) {
          toastr.options = {
              closeButton: true,
              progressBar: true,
              positionClass: 'toast-top-right',
              showMethod: 'slideDown',
              timeOut: 3000 // 3 seconds
          };
    
          // Type can be 'success', 'info', 'warning', or 'error'
          toastr[type](message);
      }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
      @yield('scripts')
  </body>
</html>
