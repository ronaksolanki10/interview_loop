<?php

return [
    'success' => [
        'stored' => 'Order created successfully.',
        'updated' => 'Order updated successfully.',
        'deleted' => 'Order deleted successfully.',
        'product_attached' => 'Product attached successfully.',
        'product_deattached' => 'Product de-attached successfully.',
        'payed' => 'Payment Successful'
    ],
    'error' => [
        'not_found' => 'Order does not exists.',
        'unable_to_attach_product' => 'Order is already payed hence product can not be added.',
        'product_already_attached' => 'Product already attached.',
        'unable_to_deattach_product' => 'Order is already payed hence product can not be removed.',
        'product_not_attached' => 'Product did not attach.',
        'already_payed' => 'Order already payed',
    ],
];