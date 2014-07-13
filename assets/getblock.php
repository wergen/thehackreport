<?php
  $blockSource = $_REQUEST['type'];
  $blockZone   = $_REQUEST['zone'];
  $blockDate   = $_REQUEST['date'];
  
  $dateParts = explode('/',$blockDate);

  /* include our API call functions */
  require_once($blockSource.'.php');

  switch($blockZone){
    case 'article':
      $result = GetBlock_Article($dateParts[1], $dateParts[2]);
      $hLen = strlen($result['headline']);
      $hClass = '';

      switch(true) {
        case $hLen < 12:
          $hClass = ' class="huge"';
          break;
        case $hLen < 25:
          $hClass = ' class="big"';
          break;
        case $hLen > 30:
          $hClass = ' class="small"';
          break;
      }

      echo '<h2'.$hClass.'>',$result['headline'],'</h2><a class="pagelink" href="',$result['url'],'" target="_blank">', $result['content'],'</a>';
    break;
      
    case 'picture':
      $result = GetBlock_Picture($dateParts[2]);
      echo '<div class="picture" style="background-image: url(\'',$result['thumb'],'\');"><!-- --></div><span>',$result['title'],'</span>';
    break;
  }
?>