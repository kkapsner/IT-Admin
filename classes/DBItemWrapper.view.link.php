<?php

/* @var $this DBItemWrapper */
echo '<a href="?action=show&amp;class=' . get_class($this) . '&amp;id=' . $this->DBid . '">';
$this->view("singleLine", true, $args);
echo '</a>';

?>