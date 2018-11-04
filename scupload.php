<!DOCTYPE html>

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

    <form action="php-hmac-put.php" method="get" enctype="multipart/form-data">
      Select image to upload:
      <input type="file" name="fileToUpload" id="fileToUpload" value="fileToUpload"><br>
      Source String:<input type="text" name="sourceString" value="identify yourself"><br>
      <input type="submit" value="submit">
      <!-- <button type="button" onclick="run()">Upload image</button> -->
    </form>


  </body>

</html>
