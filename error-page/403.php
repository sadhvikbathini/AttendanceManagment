<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>403 - Forbidden</title>
<style>
  body, html {
    margin: 0;
    padding: 0;
    height: 100%;
  }

  .bg-image {
    background-image: url('/img/error.jpg');
    height: 100%;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5);
    filter: brightness(80%);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }

  h1 {
    color: white;
    font-size:50px;
    text-shadow: 2px 2px 9px #727f2f;
    filter: brightness(200%);
    margin-bottom: 50px; 
  }
  h1:hover{
    color: #727f2f;
    text-shadow: 2px 2px 9px white;
  }
  a.back-link {
    color: white;
    text-decoration: none;
    filter: brightness(200%);
    font-size: 1.5em;
    text-shadow: 1px 1px 5px #727f2f;
  }
  a.back-link:hover{
    color: #727f2f;
    text-shadow: 2px 2px 9px white;
  }
  .footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    color: white;
    text-align: center;
    padding: 5px 0;
    font-size: 0.8em;
  }
</style>
</head>
<body>
<div class="bg-image"><center>
  <h1>403 - Forbidden</h1>
  <a href="javascript:history.back()" class="back-link">Go Back</a></center>
</div>
<div class="footer">
  Developed & Deployed by Team Kaboom &copy; 2024
</div>
</body>
</html>

