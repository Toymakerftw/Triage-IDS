<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $service_name = $_POST['service_name'];

    switch ($action) {
        case 'start':
            shell_exec("sudo service $service_name start");
            header("Location: newservices.php");
            exit();
            break;
        case 'stop':
            shell_exec("sudo service $service_name stop");
            header("Location: newservices.php");
            exit();
            break;
        case 'restart':
            shell_exec("sudo service $service_name restart");
            header("Location: newservices.php");
            exit();
            break;
        default:
            // Invalid action
            break;
    }
}
?>
