  <!-- ===============================================-->
  <!--    Main Content-->
  <!-- ===============================================-->
  <main class="main" id="top">
    <div class="container" data-layout="container">
      <script>
        var isFluid = JSON.parse(localStorage.getItem('isFluid'));
        if (isFluid) {
          var container = document.querySelector('[data-layout]');
          container.classList.remove('container');
          container.classList.add('container-fluid');
        }
        
        // Ensure theme is applied on every page
        var theme = localStorage.getItem('theme');
        if (theme === 'dark') {
          document.documentElement.classList.add('dark');
        } else {
          document.documentElement.classList.remove('dark');
        }
      </script>

      @include("layouts.header")
      @include("layouts.sidebar")
      <div class="content">
              @include("layouts.pageheader")
              @yield("page")
              @include("layouts.pagefooter")
      </div>
      @include("layouts.modal")
    </div>
  </main>
  <!-- ===============================================-->
  <!--    End of Main Content-->
  <!-- ===============================================-->
 @include("layouts.rightsidebar")
 @include("layouts.footer")
