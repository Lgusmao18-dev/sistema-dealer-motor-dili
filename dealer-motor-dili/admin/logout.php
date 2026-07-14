<?php
require_once '../config/database.php';
session_destroy();
redirect('/dealer-motor-dili/admin/login.php');
