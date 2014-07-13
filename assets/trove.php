<?php
  function GetBlock_Article($month, $year) {
    $key = 'a5f0tm0e021esii5';

    $json = file_get_contents('http://api.trove.nla.gov.au/result?key='.$key.'&zone=newspaper&q=tasmania&l-category=Article&l-decade='.substr($year, 0, 3).'&l-year='.$year.'&l-month='.$month.'&s=0&n=20&sortby=datedesc&encoding=json');
    $obj = json_decode($json);
    $articles = $obj->response->zone[0]->records->article;

    $cnt = count($articles);
    
    if($cnt == 0) return false;

    $rnd = mt_rand(0, $cnt-1);

    $json = file_get_contents('http://api.trove.nla.gov.au/newspaper/'.($articles[$rnd]->id).'?key='.$key.'&include=articletext&encoding=json');
    $obj = json_decode($json);
    
    $content = strip_tags($obj->article->articleText);
    if(strlen($content) < 800) $content .= ' Phasellus at urna venenatis, condimentum mi ut, ultricies mauris. Sed imperdiet sodales eros, ac ultricies mi ullamcorper eu. Aenean eu ante in justo vehicula luctus eget quis tellus. Donec tempus et lorem sit amet elementum. Etiam condimentum magna quis vulputate aliquam. Sed nibh nulla, semper in sem a, cursus iaculis lacus. Suspendisse vitae posuere elit. Aenean pharetra elit eget hendrerit convallis. Proin dolor magna, congue ut ultrices nec, interdum nec ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel molestie arcu. Donec at nibh at nisl consectetur dapibus. Ut lacinia gravida varius. Vivamus fringilla est a sapien scelerisque, at fringilla eros porta. Nunc ultrices vestibulum tempor. Morbi magna purus, luctus vel gravida tincidunt, ultrices eu purus. Curabitur ut dui a est molestie vulputate. Nulla mollis metus eget ornare accumsan.';
    $headline = $obj->article->heading;
    $pageurl = $obj->article->troveUrl;
    return array('headline'=>$headline, 'content'=>$content, 'url'=>$pageurl);
  }
  
  
  function GetBlock_Picture($year) {
    $key = 'a5f0tm0e021esii5';
    $sirius = array('thumb'=>'assets/images/sirius.gif', 'title'=>'No image? You can\'t be Sirius.');
    
    $rnd = mt_rand(1, 5);
    if($rnd == 5) return $sirius;

    $json = file_get_contents('http://api.trove.nla.gov.au/result?key='.$key.'&zone=picture&q=tasmania&l-decade='.substr($year, 0, 3).'&l-year='.$year.'&l-format=Photograph&l-availability=y&s=0&n=20&sortby=datedesc&encoding=json');
    $obj = json_decode($json);
    $pictures = $obj->response->zone[0]->records->work;

    $cnt = count($pictures);
    if($cnt == 0) return $sirius;
    
    foreach($pictures as $pic) {
      foreach($pic->identifier as $ident) {
        if($ident->linktype == 'thumbnail' && !strpos($ident->value, 'prov.vic.gov.au')){
          $images[] = array('thumb'=>$ident->value, 'title'=>substr($pic->title, 0, 32).'...');
        }
      }
    }

    $cnt = count($images);
    if($cnt == 0) return $sirius;
    $rnd = mt_rand(0, $cnt-1);
    return $images[$rnd];
  }
?>