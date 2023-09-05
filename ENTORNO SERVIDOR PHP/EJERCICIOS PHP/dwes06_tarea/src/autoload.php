<?php


 function autoload_16df4e56819d1ecfb7b8b52b2a1ecfa9($class)
{
    $classes = array(
        'App\ClasesOperacionesServiceCustom' => __DIR__ .'/ClasesOperacionesServiceCustom.php'
    );
    if (!empty($classes[$class])) {
        include $classes[$class];
    };
}

spl_autoload_register('autoload_16df4e56819d1ecfb7b8b52b2a1ecfa9');

// Do nothing. The rest is just leftovers from the code generation.
{
}
