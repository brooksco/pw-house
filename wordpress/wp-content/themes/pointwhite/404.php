<!DOCTYPE html>
<html>
<head>
  <title>(404) Page not found</title>

  <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Annie+Use+Your+Telescope' rel='stylesheet' type='text/css'>
  
  <style type="text/css">
  body { 
    font-family: 'Lato';
    color: #333;
  }

  h2 { 
    font-size: 2em; 
    margin: 0;
    font-family: 'Annie Use Your Telescope', cursive;
    font-weight: 300;
  }

  p { 
    font-size: 1.25em; 
    font-weight: 300;
  }

  #error {
   max-width: 650px;
   margin-left: auto; 
   margin-right: auto;
   padding-top: 2em;
   padding-left: 5%;
   padding-right: 5%;
   text-align: center;
  }

  #logo {
    width: 300px;
    margin-bottom: 2em;
  }

  #somewhere {
    text-decoration: none;
    color: #006595;
  }

  #somewhere:hover {
    text-decoration: underline;
  }
</style>
</head>

  <body>

    <div id="error">

     <a href="<?php echo site_url(); ?>"><img id="logo" src="/wp-content/themes/pointwhite/img/PWGH-logo-blue-small.png" /></a>

        <h2>Something went wrong (404)</h2>
        <p>

          The page that you've tried to access doesn't seem to be available.
          You might have mistyped something, or our site may be experiencing difficulties.

        </p>

        <p><a id="somewhere" href="<?php echo site_url(); ?>">Head back to the homepage.</a></p>


    </div>

  </body>
</html>
