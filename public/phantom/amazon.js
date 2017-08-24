var casper = require('casper').create();

casper.userAgent('Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:46.0) Gecko/20100101 Firefox/46.0');
phantom.cookiesEnabled = true;

var product = casper.cli.get('endpoint');
var amazon_user = 'daniilbelov98@yandex.ru';
var amazon_pass = 'Daniil89917032';

var emailInput = 'input#ap_email';
var passInput  = 'input#ap_password';

casper.start(product);

casper.then(function () {
    this.waitForSelector('#add-to-cart-button', function () {
        this.click('#add-to-cart-button');
    });

    this.waitForSelector('#hlb-ptc-btn-native', function () {
        this.click('#hlb-ptc-btn-native');
    });

    this.waitForSelector(emailInput, function () {
        this.mouseEvent('click', emailInput, '15%', '48%');
        this.sendKeys('input#ap_email', amazon_user);

        this.wait(3000, function() {
            this.mouseEvent('click', passInput, '12%', '67%');
            this.sendKeys('input#ap_password', amazon_pass);

            this.mouseEvent('click', 'input#signInSubmit', '50%', '50%');
        });
    });

    this.wait(5000, function() {
        this.echo('Capping');
        this.capture('amazon.png');
    });
});

casper.run(function () {
    casper.exit();
});