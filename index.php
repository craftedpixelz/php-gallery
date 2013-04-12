<?php

    /* ----------------------

    Auto PHP Gallery - Abid Din (@craftedpixelz)
    Usage: Drop this file into a folder containing images 
    for an instant gallery to showcase designs across devices.

    ---------------------- */

    /* settings */
    $images_dir = './';

    /* Get files from Dir */
    function get_files($images_dir,$exts = array('jpg', 'png')) {
      $files = array();
      if($handle = opendir($images_dir)) {
        while(false !== ($file = readdir($handle))) {
          $extension = strtolower(get_file_extension($file));
          if($extension && in_array($extension,$exts)) {
            $files[] = $file;
          }
        }
        closedir($handle);
      }

      sort($files);
      return $files;
    }

    /* Get file extensions */
    function get_file_extension($file_name) {
      return substr(strrchr($file_name,'.'),1);
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        
        <title>Creative Concept Gallery</title>

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        
        <!-- STYLES -->
        <style>
          body {
              margin: 0;
              padding: 0;
              font-family: Helvetica, Arial, sans-serif;
              color: #fff;
              background: #030303;
          }

          ::-webkit-scrollbar {
              display: none;
          }

          .swipe {
              overflow: hidden;
              position: relative;
              visibility: hidden;
          }
          
          .swipe-wrap {
              overflow: hidden;
              position: relative;
          }

          .swipe-wrap > div {
              float:left;
              width:100%;
              position: relative;
          }

          .swipe-wrap img {
              display: block;
              max-width: 100%;
          }
        </style>
    </head>

    <body>
        <!-- SLIDESHOW CONTAINER -->
        <div id="slider" class="swipe">
          <div class="swipe-wrap">
            <?php
                /* Output images to page */
                $image_files = get_files($images_dir);
                if(count($image_files)) {
                  $index = 0;
                  foreach($image_files as $index=>$file) {
                    $index++;
                    $image = $images_dir.$file;

                    echo "<div><img src='" . $image . "' /></div>";
                  }
                }
                else {
                  echo "<p>There are no images in this gallery.</p>";
                }
            ?>
          </div>
        </div>
        
        <!-- JS -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/swipe/2.0/swipe.min.js"></script>

        <script>
          var gallery = gallery || {};

          // Set up Slideshow
          gallery.handleSwipe = function () {
              var slider = document.getElementById("slider"),
                  slideshow = Swipe(slider, {
                  continuous: false
              });
              
              // Handle click event
              slider.onclick = function () {
                slideshow.next();
              };
              
              // Handle key events
              window.onkeydown = function (e) {
                  e.preventDefault();

                  var keyCode = e.keyCode || e.which;

                  if (keyCode == 37) { 
                     slideshow.prev();
                  }

                  if (keyCode == 39) {
                     slideshow.next();
                  }
              }
          };

          // Hide URL bar on iPhone/iPad
          gallery.hideUrlBar = function () {
              /mobi/i.test(navigator.userAgent) && !location.hash && setTimeout(function () {
                if (!pageYOffset) window.scrollTo(0, 1);
              }, 1000);
          };

          // Init
          gallery.init = function () {
              gallery.handleSwipe();
              gallery.hideUrlBar();
          };

          gallery.init();
        </script>
    </body>
</html>