<?php

namespace Flynt\Features\Acf;

use RecursiveDirectoryIterator;
use ACFComposer\ACFComposer;
use Flynt\Utils\ArrayHelpers;
use Flynt\Utils\FileLoader;
use Flynt\ComponentManager;

class FieldGroupComposer
{
    const FILTER_NAMESPACE = 'Flynt/Components';
    const FIELD_GROUPS_DIR = '/config/fieldGroups';

    protected static $fieldGroupsLoaded = false;

    public static function setup()
    {
        add_action(
            'acf/init',
            ['Flynt\Features\Acf\FieldGroupComposer', 'loadFieldGroups']
        );
    }

    public static function loadFieldGroups()
    {
        // prevent this running more than once
        if (self::$fieldGroupsLoaded) {
            return;
        }

        // Load field groups from files after ACF initializes
        $dir = get_template_directory() . self::FIELD_GROUPS_DIR;

        if (!is_dir($dir)) {
            trigger_error("[ACF] Cannot load field groups: {$dir} is not a valid directory!", E_USER_WARNING);
            return;
        }

        FileLoader::iterateDir($dir, function ($file) {
            if ($file->getExtension() === 'json') {
                $filePath = $file->getPathname();
                $config = json_decode(file_get_contents($filePath), true);
                ACFComposer::registerFieldGroup($config);
            }
        });

        self::$fieldGroupsLoaded = true;
    }
}
