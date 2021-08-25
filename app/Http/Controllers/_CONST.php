<?php

namespace App\Http\Controllers;

class _CONST {
    public const ADMIN_ROLE_ID = 1;
    public const SUB_ADMIN_ROLE_ID = 2;
    public const CUSTOMER_ROLE_ID = 3;

    public const STRIPE_KEY = 'Stripe key';
    public const STRIPE_SECRET = 'Stripe secret';

    public const MAXIMUM_WORKOUT_FOR_NORMAL_CUSTOMER = 3;

    public const IMGUR_END_POINT_IMAGE =  'https://api.imgur.com/3/image';
    public const IMGUR_END_POINT_VIDEO =  'https://api.imgur.com/3/upload';
    public const SETTING_ADMIN_PAGINATION =  'Admin pagination';
}