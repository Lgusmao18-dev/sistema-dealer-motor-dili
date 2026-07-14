<?php
require_once '../config/database.php';
if (!isLoggedIn()) redirect('/dealer-motor-dili/admin/login.php');
redirect('/dealer-motor-dili/admin/dashboard.php');
