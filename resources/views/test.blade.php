<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
</head>
<body>
    <img src="http://589e7829.ngrok.io/1.jpg">
    <script src='https://cdn.rawgit.com/naptha/tesseract.js/1.0.10/dist/tesseract.js'></script>
    <script type="text/javascript">
        var img = document.querySelectorAll("img");

        img = img[0];

        Tesseract.recognize(img)
        .then(function(result) {
            console.log(result);
        });
    </script>
</body>
</html>