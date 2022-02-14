<!DOCTYPE html>
<html lang="en">
<head>
  <title>EXAMPLE APP</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="icon" href="data:image/x-icon;base64,">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="/css/bootstrap.min.css">

  <!-- Own overwriting styles -->
  <link rel="stylesheet" href="/css/app-style.css">

  <!-- Bootstrap JS scripts needed: jQuery first, then Popper.js, then Bootstrap JS -->
  <!-- <script src="assets/js/popper.min.js"></script> -->
  <!-- <script src="assets/jsbootstrap.min.js"></script> -->
  <!-- OR use Bootstrap Bundle which includes Popper.js -->
  <script src="/js/jquery-3.5.1.min.js"></script>
  <script src="/js/bootstrap.bundle.min.js"></script>
  <script src="/js/moment-with-locales.min.js"></script>
  <script src="/js/common.js"></script>
</head>

<body>
  <div>
    <div id="fade"></div>
    <div id="loading">
      <img id="loader" src="/images/loading.gif" />
    </div>
  </div>

  <?php include($page); ?>

  <!-- Other JavaScript that uses jQuery, always at the end
       ==================================================== -->
  <script>
    // Functions for loading splash image
    function showLoading() {
        document.getElementById('loading').style.display = 'block';
        document.getElementById('fade').style.display = 'block';
    }
    function hideLoading() {
        document.getElementById('loading').style.display = 'none';
        document.getElementById('fade').style.display = 'none';
    }
  </script>
</body>
</html>