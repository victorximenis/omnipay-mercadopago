<?php

namespace Omnipay\MercadoPago\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getItemData()
    {
        $data = [];
        $items = $this->getItems();
        if ($items) {
            foreach ($items as $n => $item) {
                $item_array = [];
                $item_array['title'] = $item->getName();
                $item_array['category_id'] = $item->getCategoryId();
                $item_array['quantity'] = $item->getQuantity();
                $item_array['currency_id'] = $item->getCurrencyId();
                $item_array['unit_price'] = (double)($this->formatCurrency($item->getPrice()));
                array_push($data, $item_array);
            }
        }
        return $data;
    }

    public function getData()
    {

        $data = array(
        "items" => array(
            array(
                'title' => 'PurchaseTest',
                'quantity' => 1,
                'category_id' => 'tickets',
                'currency_id' => 'BRL',
                'unit_price' => 10.0
            )
        ));

        $items = $this->getItemData();
        $external_reference = parent::getData();

        $purchaseObject = ['items' => $items, 'external_reference' => $external_reference];
        return $purchaseObject;
    }

    protected function createResponse($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

    protected function getEndpoint()
    {
        return $this->getTestMode() ? ($this->testEndpoint . '/checkout/preferences') : ($this->liveEndpoint . '/checkout/preferences');
    }

}

?>
