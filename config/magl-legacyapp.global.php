<?php

return array(
    'magl_legacy_application' => array(
        'doc_root' => array('www/'), // the legacy apps DOCUMENT_ROOT for including files
        'index_files' => array( // add the files you wish to be loaded by default if the request is made to /
            'index.php',
            'index.html',
        ),
        'globals' => array(
            'get' => true, // should $_GET be filled with variables from route match?
            'request' => true, // should $_GET be filled with variables from route match?
        ),
        // when short circuiting a response, it could be needed to prepend the output buffer to the response,
        // enable this to prepend the output buffer
        'prepend_output_buffer_to_response' => false,
    ),
);
