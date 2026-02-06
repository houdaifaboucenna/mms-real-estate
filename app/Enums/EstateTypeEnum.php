<?php

namespace App\Enums;

enum EstateTypeEnum: string
{
    case APARTMENT = 'apartment';
    case RESIDENCE = 'residence';
    case COMMERCIAL = 'commercial';
    case VILLA = 'villa';
    case OFFICES = 'offices';
    case HOTEL = 'hotel';

    public static function labels(): array
    {
        return [
            self::APARTMENT->value => __('admin.appartement'),
            self::RESIDENCE->value => __('admin.residence'),
            self::COMMERCIAL->value => __('admin.commercial'),
            self::VILLA->value => __('admin.villa'),
            self::OFFICES->value => __('admin.offices'),
            self::HOTEL->value => __('admin.hotel'),
        ];
    }
}
