<?php

namespace App\Http\Livewire;

use DateTimeImmutable;
use GusApi\BulkReportTypes;
use GusApi\Exception\InvalidUserKeyException;
use GusApi\Exception\NotFoundException;
use GusApi\GusApi;
use GusApi\ReportTypes;
use Livewire\Component;

class InvoiceAdd extends Component
{
    public $seller_name;
    public $seller_nip;
    public $seller_street;
    public $seller_house_number;
    public $seller_city;
    public $seller_postcode;
    public $seller_email;
    public $seller_phone;

    public $buyer_name;
    public $buyer_nip;
    public $buyer_street;
    public $buyer_house_number;
    public $buyer_city;
    public $buyer_postcode;
    public $buyer_email;
    public $buyer_phone;

    public $productsCount = 1;

    public function getSellerDataFromApi()
    {
        $this->seller_nip = json_decode(json_encode($this->seller_nip),true);
        $seller_nip_copy = preg_replace("/[^0-9]/", "", $this->seller_nip);
        $gus = new GusApi('b666914c9b084287ac4b');

        try {
            $nipToCheck = $seller_nip_copy; //change to valid nip value
            $gus->login();

            $gusReports = $gus->getByNip($nipToCheck);
            if($gusReports)
            {
                $gusReport = $gusReports[0];
                // dd($gusReport);
                $this->seller_name = $gusReport->getName();
                if($gusReport->getCity() == $gusReport->getPostCity()) $this->seller_street = $gusReport->getStreet();
                else $this->seller_street = $gusReport->getCity().' '.$gusReport->getStreet();
                if($gusReport->getApartmentNumber() != "") $this->seller_house_number = $gusReport->getPropertyNumber().'/'.$gusReport->getApartmentNumber();
                else $this->seller_house_number = $gusReport->getPropertyNumber();
                $this->seller_city = $gusReport->getPostCity();
                $this->seller_postcode = $gusReport->getZipCode();
                // $this->seller_email = $gusReport->get;
                // $this->seller_phone = $gusReport->get;
            }

            // var_dump($gus->dataStatus());
            // var_dump($gus->getBulkReport(
            //     new DateTimeImmutable('2019-05-31'),
            //     BulkReportTypes::REPORT_DELETED_LOCAL_UNITS
            // ));

            // // dd($gusReports);
            // foreach ($gusReports as $gusReport) {
            //     //you can change report type to other one
            //     $reportType = ReportTypes::REPORT_PERSON;
            //     echo $gusReport->getName();
            //     echo 'Address: ' . $gusReport->getStreet() . ' ' . $gusReport->getPropertyNumber() . '/' . $gusReport->getApartmentNumber();

            //     $fullReport = $gus->getFullReport($gusReport, $reportType);
            //     var_dump($fullReport);
            // }
        } catch (InvalidUserKeyException $e) {
            echo 'Bad user key';
        } catch (NotFoundException $e) {
            echo 'No data found <br>';
            echo 'For more information read server message below: <br>';
            echo sprintf(
                "StatusSesji:%s\nKomunikatKod:%s\nKomunikatTresc:%s\n",
                $gus->getSessionStatus(),
                $gus->getMessageCode(),
                $gus->getMessage()
            );
        }
    }

    public function getBuyerDataFromApi()
    {
        $this->buyer_nip = json_decode(json_encode($this->buyer_nip),true);
        $buyer_nip_copy = preg_replace("/[^0-9]/", "", $this->buyer_nip);
        $gus = new GusApi('b666914c9b084287ac4b');

        try {
            $nipToCheck = $buyer_nip_copy; //change to valid nip value
            $gus->login();

            $gusReports = $gus->getByNip($nipToCheck);
            if($gusReports)
            {
                $gusReport = $gusReports[0];
                // dd($gusReport);
                $this->buyer_name = $gusReport->getName();
                if($gusReport->getCity() == $gusReport->getPostCity()) $this->buyer_street = $gusReport->getStreet();
                else $this->buyer_street = $gusReport->getCity().' '.$gusReport->getStreet();
                if($gusReport->getApartmentNumber() != "") $this->buyer_house_number = $gusReport->getPropertyNumber().'/'.$gusReport->getApartmentNumber();
                else $this->buyer_house_number = $gusReport->getPropertyNumber();
                $this->buyer_city = $gusReport->getPostCity();
                $this->buyer_postcode = $gusReport->getZipCode();
                // $this->seller_email = $gusReport->get;
                // $this->seller_phone = $gusReport->get;
            }

            // var_dump($gus->dataStatus());
            // var_dump($gus->getBulkReport(
            //     new DateTimeImmutable('2019-05-31'),
            //     BulkReportTypes::REPORT_DELETED_LOCAL_UNITS
            // ));

            // // dd($gusReports);
            // foreach ($gusReports as $gusReport) {
            //     //you can change report type to other one
            //     $reportType = ReportTypes::REPORT_PERSON;
            //     echo $gusReport->getName();
            //     echo 'Address: ' . $gusReport->getStreet() . ' ' . $gusReport->getPropertyNumber() . '/' . $gusReport->getApartmentNumber();

            //     $fullReport = $gus->getFullReport($gusReport, $reportType);
            //     var_dump($fullReport);
            // }
        } catch (InvalidUserKeyException $e) {
            echo 'Bad user key';
        } catch (NotFoundException $e) {
            echo 'No data found <br>';
            echo 'For more information read server message below: <br>';
            echo sprintf(
                "StatusSesji:%s\nKomunikatKod:%s\nKomunikatTresc:%s\n",
                $gus->getSessionStatus(),
                $gus->getMessageCode(),
                $gus->getMessage()
            );
        }
    }

    public function addProduct()
    {
        $this->productsCount++;
    }

    public function render()
    {
        return view('livewire.invoice-add');
    }
}
