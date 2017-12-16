var Tesseract = require('tesseract.js');

Tesseract.recognize("./test.png", {
    lang: 'eng'
})
.then(function(result){
    console.log(result)
});