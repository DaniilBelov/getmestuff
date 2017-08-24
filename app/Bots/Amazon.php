<?php

namespace App\Bots;

use function foo\func;
use Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar;
use Guzzle\Plugin\Cookie\CookiePlugin;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\SessionCookieJar;
use Symfony\Component\Process\Process;

class Amazon
{
    protected $data =  [];
    protected $url = "";
    protected $post = "";
    protected $cart_endpoint;
    protected $login_url = "https://www.amazon.co.uk/sign-in";

    public function __construct($url)
    {
        $this->url = $url;
        $this->post = parse_url($url, PHP_URL_SCHEME).'://'.parse_url($url, PHP_URL_HOST);
    }

    public function buy()
    {
        $this->signIn();

        $this->getContent();
        $this->addToCart();

        return $this;
    }

    public function getContent()
    {
        $html = file_get_contents($this->url);

        $this->getData($html);
    }

    protected function getData($html)
    {
        preg_match_all('%<form method="post" id="addToCart" action="/gp/product/handle-buy-box/ref=dp_start-bbf_1_glance" class="a-content">(.*)<input type="hidden" name="wlPopCommand" value="">%s', $html, $matches);

        $matches = $matches[0][0]."</form>";

        $dom = new \DOMDocument();
        $dom->loadHTML($matches);
        $form = $dom->getElementsByTagName("form");
        $inputs = $dom->getElementsByTagName('input');

        $this->post .= $form->item(0)->getAttribute('action');

        foreach ($inputs as $input) {
            $this->data[$input->getAttribute("name")] = $input->getAttribute("value");
        }
    }

    protected function addToCart()
    {
        $result = $this->connect($this->post, $this->data);

        if (preg_match('/Please Confirm Your Action/', $result))
        {
            $form = $this->getInputs(false, $result);
            $post = $this->getPostUrl(false, $result);

            $result = $this->connect("https://www.amazon.co.uk/{$post}", $form);
        }
    }

    protected function signIn()
    {
        $amazonjs = '/phantomjs/amazon.js';

        $process = new Process("casperjs ./phantom/amazon.js --endpoint={$this->url}");

//        $process = new Process("uname -a");
        $process->run();

        dd($process->getOutput());
//        [$form, $post] = $this->getInputs($this->login_url);
//
//        unset($form['ue_back']);
//        unset($form['']);
//
//        $result = $this->connect("https://www.amazon.co.uk/ap/signin", $form);
//
//        dd($result);
    }

    protected function connect($url, $data)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:11.0) Gecko/20100101 Firefox/11.0");

        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
        $cookie_file = "cookie1.txt";
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);

        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $result;
    }

    protected function getInputs($url, $html = false)
    {
        $inputs = '';
        $form_data = [];

        if (!$html) {
            $html = file_get_contents($url);
        }

        preg_match_all('%<input (.*?)>%', $html, $matches);

        foreach ($matches[0] as $input)
        {
            $inputs .= $input;
        }

        $dom = new \DOMDocument();
        $dom->loadHTML($inputs);

        $inputs = $dom->getElementsByTagName('input');

        foreach ($inputs as $input) {
            $input_name = $input->getAttribute('name');
            if ($input_name == 'email')
                $form_data[$input_name] = "daniilbelov98@yandex.ru";
            elseif ($input_name == 'password')
                $form_data[$input_name] = "Daniil89917032";
            else
                $form_data[$input->getAttribute('name')] = $input->getAttribute('value');
        }

        $post = $this->getPostUrl($url, $html);

        return [$form_data, $post];
    }

    protected function getPostUrl($url, $html = false)
    {
        if (!$html) {
            $html = file_get_contents($url);
        }

        preg_match_all('#<form .* action="(.*)" .*>#', $html, $matches);

        return $matches[1][0];
    }
}