# rss2pdf
Simple php page where after submitting an rss feed from news.google.com it will grab the contents of the RSS and gernerate a PDF output with one article from the XML per page.

Functionality is specifically made to parse news.google.com rss, but other rss feeds may be input as well. Other inputs will only display the description and no other data without further edits.

### Demo
Input rss/xml feed you would like to have parsed submit it. You will see a notice to view your pdf submission. Click to view. An example url that you can use is `http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&output=rss`.

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
