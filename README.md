kashflow_api_wrapper
====================

Wrapper for the Kashflow accounting software's SOAP API (www.kashflow.com)
Still a work in progress and very specifically tailored to my needs. Provides classes for creating invoices, receipts, projects and customers.

**Example Usage**

Create an invoice and add invoice lines:

```php
//Instantiate the invoice
$kf_invoice = new Kashflow_Invoice(array(
	"CustomerID"		=> 11902622,
	"InvoiceDate"		=> "2013-09-18",
	"DueDate"		=> "2013-09-18",
	"ProjectID"		=> 123456,
	"CustomerReference"	=> "Invoice for services provided by ....",
));

$kf_invoice->add_line_item(array(
	"Quantity"		=> 29,
	"Description"		=> "Hourly Service Fee",
	"Rate"			=> 10,
));

$kf_invoice->save();

```
