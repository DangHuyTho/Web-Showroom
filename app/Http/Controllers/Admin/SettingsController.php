<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show shipping settings
     */
    public function shipping()
    {
        // Get current settings from config or database
        $settings = [
            'default_shipping_provider' => config('shipping.provider', 'ghtk'),
            'providers' => [
                'ghtk' => ['name' => 'GHTK', 'enabled' => true],
                'viettel' => ['name' => 'Viettel Post', 'enabled' => true],
                'ninjavan' => ['name' => 'Ninja Van', 'enabled' => false],
            ],
            'shipping_rates' => [
                'standard' => ['name' => 'Giao hàng tiêu chuẩn', 'days' => 3, 'base_fee' => 30000],
                'express' => ['name' => 'Giao hàng nhanh', 'days' => 1, 'base_fee' => 50000],
                'free_threshold' => 1000000, // Free shipping above 1M
            ]
        ];

        return view('admin.settings.shipping', compact('settings'));
    }

    /**
     * Update shipping settings
     */
    public function updateShipping(Request $request)
    {
        $validated = $request->validate([
            'default_shipping_provider' => 'required|in:ghtk,viettel,ninjavan',
            'free_shipping_threshold' => 'required|numeric|min:0',
            'standard_shipping_fee' => 'required|numeric|min:0',
            'express_shipping_fee' => 'required|numeric|min:0',
        ]);

        // Save to config or database
        // For now, we'll just return success
        return redirect()->back()
            ->with('success', 'Cập nhật cài đặt vận chuyển thành công');
    }

    /**
     * Show payment settings
     */
    public function payment()
    {
        $settings = [
            'enabled_methods' => [
                'direct_payment' => ['name' => 'Thanh toán khi nhận hàng (COD)', 'enabled' => true],
                'banking' => ['name' => 'Chuyển khoản ngân hàng', 'enabled' => true],
                'credit_card' => ['name' => 'Thẻ tín dụng', 'enabled' => true],
                'e_wallet' => ['name' => 'Ví điện tử', 'enabled' => false],
            ],
            'gateway_keys' => [
                'stripe' => config('services.stripe.key', ''),
                'paypal' => config('services.paypal.client_id', ''),
                'vnpay' => config('services.vnpay.merchant_id', ''),
            ]
        ];

        return view('admin.settings.payment', compact('settings'));
    }

    /**
     * Update payment settings
     */
    public function updatePayment(Request $request)
    {
        $validated = $request->validate([
            'payment_methods' => 'required|array',
            'stripe_key' => 'nullable|string',
            'paypal_client_id' => 'nullable|string',
            'vnpay_merchant_id' => 'nullable|string',
        ]);

        // Update settings
        return redirect()->back()
            ->with('success', 'Cập nhật cài đặt thanh toán thành công');
    }

    /**
     * Show general settings
     */
    public function general()
    {
        $settings = [
            'site_name' => config('app.name', 'Hộ Nhâm'),
            'site_email' => config('mail.from.address', ''),
            'site_phone' => '+84 xxx xxx xxx',
            'site_address' => '...',
            'theme' => 'light',
            'items_per_page' => 20,
        ];

        return view('admin.settings.general', compact('settings'));
    }

    /**
     * Update general settings
     */
    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email',
            'site_phone' => 'required|string',
            'site_address' => 'required|string',
            'theme' => 'required|in:light,dark',
            'items_per_page' => 'required|integer|min:5|max:100',
        ]);

        // Update settings in database or config
        return redirect()->back()
            ->with('success', 'Cập nhật cài đặt chung thành công');
    }

    /**
     * Show content settings (policies, about us, etc)
     */
    public function content()
    {
        $pages = [
            'about' => ['title' => 'Về chúng tôi', 'slug' => 'about-us'],
            'privacy' => ['title' => 'Chính sách bảo mật', 'slug' => 'privacy-policy'],
            'terms' => ['title' => 'Điều khoản dịch vụ', 'slug' => 'terms-of-service'],
            'return' => ['title' => 'Chính sách đổi trả', 'slug' => 'return-policy'],
            'faq' => ['title' => 'Câu hỏi thường gặp', 'slug' => 'faq'],
        ];

        return view('admin.settings.content', compact('pages'));
    }

    /**
     * Edit content page
     */
    public function editContent($slug)
    {
        // Get content from database
        $content = [
            'slug' => $slug,
            'title' => 'Page Title',
            'body' => '<p>Page content here</p>',
        ];

        return view('admin.settings.edit-content', compact('content'));
    }

    /**
     * Update content page
     */
    public function updateContent(Request $request, $slug)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        // Save to database
        return redirect()->route('admin.settings.content')
            ->with('success', 'Cập nhật trang thành công');
    }
}
