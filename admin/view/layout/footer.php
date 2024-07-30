

</div>
</div>
<footer class="admin-footer my-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <p>&copy; 2024 Your Company. All rights reserved.</p>
      </div>
      <div class="col-md-6 text-md-right">
        <ul class="list-inline">
          <li class="list-inline-item"><a href="#" class="nav-link">Home</a></li>
          <li class="list-inline-item"><a href="#" class="nav-link">About Us</a></li>
          <li class="list-inline-item"><a href="#" class="nav-link">Contact</a></li>
          <li class="list-inline-item"><a href="#" class="nav-link">Privacy Policy</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    $('#productsDropdown').click(function() {
      var $dropdownMenu = $(this).next('.dropdown-menu');
      $dropdownMenu.toggleClass('show');
    });
  });

  $(document).ready(function() {
    $('#orderDropdown').click(function() {
      var $dropdownMenu = $(this).next('.dropdown-menu');
      $dropdownMenu.toggleClass('show');
    });
  });

  $(document).ready(function() {
    $('#usersDropdown').click(function() {
      var $dropdownMenu = $(this).next('.dropdown-menu');
      $dropdownMenu.toggleClass('show');
    });
  });
  $(document).ready(function() {
    $('#commentDropdown').click(function() {
      var $dropdownMenu = $(this).next('.dropdown-menu');
      $dropdownMenu.toggleClass('show');
    });
  });
  
</script>
<script src="/SilverBook/public/js/adminAdd.js"></script>
<script src="/SilverBook/public/js/adminComments.js"></script>


</body>

</html>