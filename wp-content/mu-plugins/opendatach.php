<?php

function opendatach_remove_update_check($tests) {
    unset($tests['async']['background_updates']);
    return $tests;
}
add_filter('site_status_tests', 'opendatach_remove_update_check');
