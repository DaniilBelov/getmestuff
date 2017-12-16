<?php

namespace App\Bots;

use GuzzleHttp\Client;

class Amazon
{
    protected $base_url = "https://www.amazon.co.uk/s/ref=nb_sb_noss_2?url=search-alias%3Daps&field-keywords=";
    protected $items = [];

    public function search($item)
    {
        $item = str_replace(' ', '+', $item);
        $client = new Client();
        $result = $client->get("{$this->base_url}{$item}")->getBody()->getContents();

        preg_match_all("#<li id=\"result_\d\" .*</li>#sU", $result, $matches);

        $this->processData(collect($matches[0])->slice(0, 3));
    }

    protected function processData($items)
    {
        $items->each(function ($item) {
            $this->items[] = $this->getData($item);
        });

        dd($this->items);
    }

    protected function getData($item)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($item);

        $title = $dom->getElementsByTagName('h2')->item(0)->textContent;
        $link = $link = $this->xsearch($dom, "//*[contains(@class, 's-access-detail-page')]", 'link');
        $price = $this->xsearch($dom, "//*[contains(@class, 'a-color-price')]");
        $delivery = $this->xsearch($dom, "//div[contains(@class, 'a-row a-spacing-none')][a[span[contains(@class, 's-price')]]]/span[contains(@class, 'a-size-small a-color-secondary')][not(contains(@class, 'a-text-strike'))]");

        return new Product($title, $link, $price, $delivery);
    }

    protected function xsearch($item, $path, $type = 'number')
    {
        $xpath = new \DOMXPath($item);
        $data = $xpath->query($path);

        if ($data->length > 0) {
            if ($type == 'number') {
                $data = $data->item(0)->textContent;
                return (float) filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            } elseif ($type == 'link') {
                return $data->item(0)->getAttribute("href");
            } else {
                return $data->item(0)->textContent;
            }
        }

        return 0;
    }
}