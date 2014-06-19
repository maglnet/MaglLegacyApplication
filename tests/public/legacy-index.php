<?php

/* 
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

echo json_encode(array(
    'GET' => $_GET,
    'REQUEST' => $_REQUEST,
));
