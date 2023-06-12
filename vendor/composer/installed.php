<?php return array(
    'root' => array(
        'name' => 'wpforms/mailchimp',
        'pretty_version' => 'dev-develop',
        'version' => 'dev-develop',
        'reference' => '1b04e6fa4188295437b22d0b7a9f175441af7534',
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'drewm/mailchimp-api' => array(
            'pretty_version' => 'v2.5.4',
            'version' => '2.5.4.0',
            'reference' => 'c6cdfab4ca6ddbc3b260913470bd0a4a5cb84c7a',
            'type' => 'library',
            'install_path' => __DIR__ . '/../drewm/mailchimp-api',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'roave/security-advisories' => array(
            'pretty_version' => 'dev-latest',
            'version' => 'dev-latest',
            'reference' => 'd5961914bf7f90e81af509b81e51450bff419815',
            'type' => 'metapackage',
            'install_path' => NULL,
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => true,
        ),
        'wpforms/mailchimp' => array(
            'pretty_version' => 'dev-develop',
            'version' => 'dev-develop',
            'reference' => '1b04e6fa4188295437b22d0b7a9f175441af7534',
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
    ),
);
