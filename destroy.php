<?php
session_start();


session_unset();
session_destroy();

// header("Location: index.php");
echo "<script>document.location.href = 'index.php'</script>";
