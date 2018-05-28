<!--display error messages-->

<?php

use Util\Util;

if (isset($errors) && is_array($errors)): ?>
  <div class="errors alert alert-danger">
    <ul>
		<?php foreach ($errors as $errMsg): ?>
          <li><?php echo(Util::escape($errMsg)); ?></li>
		<?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>
<!--/display error messages-->

<script src="assets/jquery-1.11.2.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>