<iframe <?php if (isset($params->data['settings']['full']) && $params->data['settings']['full'] == 1) echo 'style = "width: 100%"' ?> width="<?php echo $params->data['settings']['width'] ?>" height="<?php echo $params->data['settings']['height'] ?>" src="https://www.youtube.com/embed/<?php echo $params->atts['id'] ?>?rel=0" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>