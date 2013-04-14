<?php
////////////////////////////////////////////////
//    Author : frinux
//    Website : http://www.frinux.fr
////////////////////////////////////////////////
//
//      collection of required functions 
////////////////////////////////////////////////

////////////////////////////////////////////////
//    Return the size of the file
////////////////////////////////////////////////
function Size($file){
  $file_size=filesize($file);
  return human_readable($file_size);
}

////////////////////////////////////////////////
//    Returns the size of the folder
////////////////////////////////////////////////
function DirSize($path , $recursive=TRUE){
  $result = 0;
  if(!is_dir($path) || !is_readable($path))
    return 0;
  $fd = dir($path); 
  while($file = $fd->read()){ 
    if(($file != '.') && ($file != '..')){
      if(@is_dir("$path$file/"))
        $result += $recursive?DirSize("$path$file/"):0;
      else
        $result += filesize("$path$file");
    }
  }
  $fd->close();
  return human_readable($result);
}

////////////////////////////////////////////////
//    Converts a byte size into human readable size
////////////////////////////////////////////////
function human_readable($size){
  if ($size >= 1073741824)
  {$size = round($size / 1073741824 * 100) / 100 . ' Go';}
  elseif ($size >= 1048576)
  {$size = round($size / 1048576 * 100) / 100 . ' Mo';}
  elseif ($size >= 1024)
  {$size = round($size / 1024 * 100) / 100 . ' Ko';}
  else
  {$size = $size . ' octets';}
  if($size==0) {$size='-';}
  return $size;
}

?>