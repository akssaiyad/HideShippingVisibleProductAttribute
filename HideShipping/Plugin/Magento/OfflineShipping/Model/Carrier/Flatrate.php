<?php
namespace Aks\HideShipping\Plugin\Magento\OfflineShipping\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;

class Flatrate
{

    public function afterCollectRates(
        \Magento\OfflineShipping\Model\Carrier\Flatrate $subject,
        $result,
        RateRequest $request
    ) {

       if($result instanceof  \Magento\Shipping\Model\Rate\Result){
           $check = false;
           foreach ($request->getAllItems() as $item) {
               if ($item->getParentItem()) {
                   continue;
               }
               $attributeValue = $item->getProduct()->getAttributeForHideShipping();
               // here condition match
               if(!empty($attributeValue)){
                   $check = true;
                   break;
               }

               /*
               if ($item->getHasChildren() && $item->isShipSeparately()) {
                   foreach ($item->getChildren() as $child) {
                       if ($child->getProduct()->isVirtual()) {

                       }
                   }
               }*/
           }

           /**
            * If check variable is true return  false.
            * False means hide Free Shipping method at Checkout
            */
           if($check){
               return false;
           }
       }
        return $result;
    }
}