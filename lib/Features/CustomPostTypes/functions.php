<?php

# TODO reorganize and rename
require_once __DIR__ . '/CustomPostTypeRegister.php';

use Flynt\Features\CustomPostTypes\CustomPostTypeRegister;

CustomPostTypeRegister::fromDirectory(get_template_directory() . '/config/customPostTypes/');
