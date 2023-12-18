
<div id='loader' style='width: 100vw; height: 100vh; position:absolute;  display:flex; justify-content:center; align-items:center; background: linear-gradient(180deg, #5E0B0B 0%, #000 100%);z-index:4;'>
  <div class="spinner-border" style="position:absolute; width: 10vw; height: 10vw; border-width:20px; color:white;" role="status"></div>
</div>

<script>
  window.addEventListener('load', function () {
    var loader = document.getElementById('loader');
    loader.style.display = 'none';
  });
</script>