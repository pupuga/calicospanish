<?php

$method = $params->data->getMethod();
echo $params->data->$method();