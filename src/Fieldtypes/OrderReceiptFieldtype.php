<?php

namespace DuncanMcClean\SimpleCommerce\Fieldtypes;

use DuncanMcClean\SimpleCommerce\Orders\LineItem;
use DuncanMcClean\SimpleCommerce\Support\Money;
use Facades\Statamic\Fields\FieldtypeRepository;
use Statamic\Fields\Field;
use Statamic\Fields\Fieldtype;
use Statamic\Facades\Site;

class OrderReceiptFieldtype extends Fieldtype
{
    protected $selectable = false;

    public function preload()
    {
        $entriesFieldtype = FieldtypeRepository::find('entries');

        $productField = new Field('product', ['type' => 'entries']);

        return [
            'productsField' => $productField->fieldtype()->preload(),
        ];
    }

    public function preProcess($data)
    {
        $order = $this->field->parent();

        return [
            'line_items' => $order->lineItems()->map(fn (LineItem $lineItem) => [
                'product' => [
                    'id' => $lineItem->product()->id(),
                    'reference' => $lineItem->product()->reference(),
                    'title' => $lineItem->product()->value('title'),
                    'edit_url' => $lineItem->product()->editUrl(),
                ],
                'variant' => $lineItem->variant() ? [
                    'id' => $lineItem->variant()->id(),
                    'title' => $lineItem->variant()->name(),
                ] : null,
                'unit_price' => Money::format($lineItem->unitPrice(), Site::selected()),
                'quantity' => $lineItem->quantity(),
                'total' => Money::format($lineItem->total(), Site::selected()),
            ])->all(),
//            'discount' => $order->coupon() ? [
//                'code' => $order->coupon()->code(),
//                'value' => $order->coupon()->value(),
//            ] : null,
//            'shipping' => $order->shippingMethod() ? [
//                'title' => $order->shippingMethod()->title(),
//                'price' => $order->shippingMethod()->price(),
//            ] : null,
            'totals' => [
                'sub_total' => Money::format($order->subTotal(), Site::selected()),
                'discount_total' => Money::format($order->discountTotal(), Site::selected()),
                'shipping_total' => Money::format($order->shippingTotal(), Site::selected()),
                'tax_total' => Money::format($order->taxTotal(), Site::selected()),
                'grand_total' => Money::format($order->grandTotal(), Site::selected()),
            ],
        ];
    }

    public function process($data): null
    {
        return null;
    }
}