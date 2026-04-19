
  <!-- ===============================================-->
  <!--    JavaScripts-->
  <!-- ===============================================-->
  <script src="{{asset('vendors/popper/popper.min.js')}}"></script>
  <script src="{{asset('vendors/bootstrap/bootstrap.min.js')}}"></script>
  <script src="{{asset('vendors/anchorjs/anchor.min.js')}}"></script>
  <script src="{{asset('vendors/is/is.min.js')}}"></script>
  <script src="{{asset('vendors/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('vendors/fontawesome/all.min.js')}}"></script>
  <script src="{{asset('vendors/lodash/lodash.min.js')}}"></script>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
  <script src="{{asset('vendors/list.js/list.min.js')}}"></script>
  <script src="{{asset('assets/js/theme.js')}}"></script>
  
  <!-- Ensure theme switching works on all pages -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Handle theme switching
      var themeRadios = document.querySelectorAll('input[name="theme-color"]');
      themeRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
          var theme = this.value;
          localStorage.setItem('theme', theme);
          if (theme === 'dark') {
            document.documentElement.classList.add('dark');
          } else {
            document.documentElement.classList.remove('dark');
          }
        });
      });
      
      // Handle reset button
      var resetBtn = document.querySelector('[data-theme-control="reset"]');
      if (resetBtn) {
        resetBtn.addEventListener('click', function() {
          localStorage.setItem('theme', 'light');
          document.documentElement.classList.remove('dark');
          var lightRadio = document.getElementById('themeSwitcherLight');
          if (lightRadio) {
            lightRadio.checked = true;
          }
        });
      }
    });
  </script>
  
@stack('scripts')
</body>

</html>