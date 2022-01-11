<?php
 namespace App\Services ;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Purchase;

class   HelperService{


   public static function uniqueInvoiceMaker($invoice_type){
        // 1 for order Invoice
        // 2 for sale Invoice
        // 3 for purchase Invoice

        $invoice_no = 22 + rand(111,999).substr(time(),0,2) ;
        //checking in order  table
        if ($invoice_type==1) {
            $isExistInvoice = Self::isExist(new Order(),'invoice_no',$invoice_no) ;
            return !empty($isExistInvoice) ? self::uniqueInvoiceMaker($invoice_type) : $invoice_no ;
        }
        //checking in sale  table
        if ($invoice_type==2) {
            $isExistInvoice = Self::isExist(new Sale(),'invoice_no',$invoice_no) ;
            return !empty($isExistInvoice) ? self::uniqueInvoiceMaker($invoice_type) : $invoice_no ;
        }
         //checking in sale  table
        if ($invoice_type==3) {
            $isExistInvoice = Self::isExist(new Purchase(),'invoice_no',$invoice_no) ;
            return !empty($isExistInvoice) ? self::uniqueInvoiceMaker($invoice_type) : $invoice_no ;
        }

   }



   public static function isExist($model,$column,$invoice_no){

        return  $model->where($column,$invoice_no)->first() ?? null;
   }



 }









?>