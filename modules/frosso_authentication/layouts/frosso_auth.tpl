<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us" lang="en-us">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>{page_title default="Projects"}</title>

    <meta name="msapplication-TileColor" content="#95000">

    {if !($wireframe->getInitParams($logged_user) instanceof User)}
      <!-- *%NOT LOGGED IN%* -->
    {/if}
  </head>
  
  <body id="login_page">
    <pre></pre>
  </body>
</html>