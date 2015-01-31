<?php

return array(
    'magl_legacy_application' => array(
        'doc_root' => 'www/', // the legacy apps DOCUMENT_ROOT for including files
        'index_files' => array( // add the files you wish to be loaded by default if the request is made to /
            'index.php',
            'index.html',
        ),
        'globals' => array(
            'get' => true, // should $_GET be filled with variables from route match?
            'request' => true, // should $_GET be filled with variables from route match?
        ),
    ),
);
