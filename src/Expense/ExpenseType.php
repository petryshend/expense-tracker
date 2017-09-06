<?php

namespace Expense;

use MyCLabs\Enum\Enum;

class ExpenseType extends Enum
{
    const OTHER = 'other';
    const GROCERY = 'grocery';
    const LUNCH = 'lunch';
    const FOOD = 'food';
    const WATER = 'water';
    const FUEL = 'fuel';
    const BANK_FEE = 'bank_fee';
    const PHONE = 'phone';
    const INTERNET = 'internet';
    const RENT = 'rent';
    const HAIR_CUR = 'hair_cut';
    const PARKING = 'parking';
    const GADGET = 'gadget';
    const EVENT = 'event';
}