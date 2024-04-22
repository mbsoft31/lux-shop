<?php

namespace Core\Sales\Enums;

enum PaymentMethod: string
{
    /*'Cash', 'Credit Card', 'Debit Card'*/
    case CASH = 'Cash';
    case CREDIT_CARD = 'Credit Card';
    case DEBIT_CARD = 'Debit Card';
}
