<div class="container footer">
      <hr>
      <footer>
        <h5 align="center">
        <?php
                if (!isset($_SESSION['username'])) {
                    echo '<a style="color:yellow" class="nav-link" href="hms-staff.php">Staff Login</a>
                  </li>';
                }
        ?>
        </h5>
        <h5 align="center">
        Aplicatie Web creata de Georgescu Florin-Adrian & Vasiliu Gheoghe-Adelin <?php echo date('Y'); ?>
        </h5>
      </footer>
    </div>
  </body>
</html>
