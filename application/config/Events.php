<?php

// app/Config/Events.php
$hook = new \App\Hooks\DatabasePreSystemHook();
Events::on('pre_system', [$hook, 'run']);

?>