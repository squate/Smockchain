
<html lang="en">
  <!-- we can add more stuff to the head as we see necessary -->
  <head>
    <title>SMOCKchain</title>
    <meta charset="utf-8" />
    <script src="chain.js"></script>
  </head>

  <body>
    <h1>Welcome to SMOCKchain</h1>
    <h2>The blockchain for verifying art ownership and winning internet arguments</h2>
    <br><br>

    <!-- image submission form from w3schools -->

    <form action="php-hmac-get.php" method="get" enctype="multipart/form-data">
      Select image to check:
      <input type="file" name="fileToUpload" id="fileToUpload" value="fileToUpload"><br>
      key:<input type="text" name="token" value="token"><br>
      <input type="submit" value="submit">
      <!-- <button type="button" onclick="run()">Upload image</button> -->
    </form>


  </body>

</html>
