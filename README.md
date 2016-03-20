# rss2pdf
Input a google news rss feed and get a PDF export with each article per page. Class is specifically made to parse news.google.com rss, but other rss feeds may be input as well. Other inputs will only display the description and no other data without further edits.

[![Build Status](https://travis-ci.org/SapioBeasley/geocode.svg?branch=master)](https://travis-ci.org/SapioBeasley/geocode)

### Demo
Input rss/xml feed you would like to have parsed submit it. You will see a notice to view your pdf submission. Click to view.

Run a live demo: [http://sapioweb.com/rss2pdf](http://sapioweb.com/rss2pdf)

### Installation
Clone repo into the root of your project

`git clone https://github.com/SapioBeasley/rss2pdf.git`

Install dependencies
`cd rss2pdf/`

`composer install`

## Usage
```php
$pdf = new urlToPDF();
$pdf->displayPdf($url);
```

### License

This software is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT). For questions please email andreas@sapioweb.com or info@sapioweb.com or visit [Sapioweb.com](https://sapioweb.com/) to learn more and get in contact
