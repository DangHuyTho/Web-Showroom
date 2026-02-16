<?php

namespace App\Helpers;

class ProductFilterHelper
{
    /**
     * Định nghĩa các filter có sẵn cho mỗi brand
     */
    public static function getBrandFilterConfig()
    {
        return [
            'royal' => [
                'name' => 'Royal',
                'filters' => ['size', 'surface_type'],
                'size_label' => 'Kích thước',
                'surface_type_label' => 'Bề mặt'
            ],
            'viglacera' => [
                'name' => 'Viglacera',
                'filters' => ['size', 'surface_type'],
                'size_label' => 'Kích thước',
                'surface_type_label' => 'Bề mặt'
            ],
            'fuji' => [
                'name' => 'Fuji',
                'filters' => ['product_type'],
                'product_type_label' => 'Loại ngói',
                'product_type_options' => [
                    'flat' => 'Ngói phẳng',
                    'wave' => 'Ngói sóng',
                    'accessories' => 'Phụ kiện'
                ]
            ],
            'toto' => [
                'name' => 'Toto',
                'filters' => ['product_category'],
                'product_category_label' => 'Loại sản phẩm',
                'product_category_options' => [
                    'Bồn Cầu' => 'Bồn Cầu',
                    'Chậu Lavabo' => 'Chậu Rửa',
                    'Nắp Bồn Cầu' => 'Nắp Bồn Cầu',
                    'Vòi' => 'Vòi',
                    'Vòi Xịt' => 'Vòi Xịt',
                    'Phễu Thoát & Ống Xả' => 'Ống Xả & Phễu'
                ]
            ]
        ];
    }

    /**
     * Lấy config cho một brand cụ thể
     */
    public static function getBrandConfig($brandSlug)
    {
        $config = self::getBrandFilterConfig();
        return $config[$brandSlug] ?? null;
    }

    /**
     * Kiểm tra brand có filter gì
     */
    public static function getFilterTypesForBrand($brandSlug)
    {
        $config = self::getBrandConfig($brandSlug);
        return $config['filters'] ?? [];
    }

    /**
     * Lấy options cho một filter type
     */
    public static function getFilterOptions($filterType, $data = [])
    {
        switch ($filterType) {
            case 'size':
                return $data['sizes'] ?? [];
            case 'surface_type':
                return $data['surface_types'] ?? [];
            case 'product_type':
                return [
                    'flat' => 'Ngói phẳng',
                    'wave' => 'Ngói sóng',
                    'accessories' => 'Phụ kiện'
                ];
            default:
                return [];
        }
    }
}
?>
