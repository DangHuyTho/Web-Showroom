<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReconciliationExport
{
    protected $orders;
    protected $totalCOD;
    protected $pendingCOD;

    public function __construct($orders, $totalCOD, $pendingCOD)
    {
        $this->orders = $orders;
        $this->totalCOD = $totalCOD;
        $this->pendingCOD = $pendingCOD;
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Đối Soát');

        $row = 1;

        // Title
        $sheet->setCellValue('A' . $row, 'BÁO CÁO ĐỐI SOÁT THANH TOÁN');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true)->setSize(14);
        $row++;

        $sheet->setCellValue('A' . $row, 'Ngày xuất: ' . now()->format('d/m/Y H:i:s'));
        $row++;

        $row++; // blank row

        // Summary
        $sheet->setCellValue('A' . $row, 'TỔNG HẠNG TÓ ĐỐI SOÁT');
        $sheet->setCellValue('B' . $row, number_format($this->totalCOD, 0, ',', '.') . ' ₫');
        $sheet->setCellValue('D' . $row, 'CHỜ ĐỐI SOÁT');
        $sheet->setCellValue('E' . $row, number_format($this->pendingCOD, 0, ',', '.') . ' ₫');
        $row++;

        $sheet->setCellValue('D' . $row, 'TỔNG CỘNG');
        $sheet->setCellValue('G' . $row, number_format($this->totalCOD + $this->pendingCOD, 0, ',', '.') . ' ₫');
        $row += 2; // blank row

        // Headers
        $headers = ['Mã Đơn Hàng', 'Khách Hàng', 'Email', 'Tổng Tiền', 'Phương Thức TT', 'Trạng Thái', 'Ngày Giao'];
        $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        foreach ($headers as $index => $header) {
            $sheet->setCellValue($cols[$index] . $row, $header);
        }
        $headerRow = $row;
        $row++;

        // Data
        foreach ($this->orders as $order) {
            $paymentMethod = $order->payment->payment_method ?? 'N/A';
            $paymentStatus = $order->payment->status ?? 'pending';

            $methodLabel = [
                'credit_card' => 'Thẻ Tín Dụng',
                'direct_payment' => 'Thanh Toán Trực Tiếp (COD)',
                'bank_transfer' => 'Chuyển Khoản',
                'wallet' => 'Ví Điện Tử',
            ][$paymentMethod] ?? $paymentMethod;

            $statusLabel = $paymentStatus === 'completed' ? 'Đã Thanh Toán' : 'Chờ Thanh Toán';

            $sheet->setCellValue('A' . $row, 'ĐH' . str_pad($order->id, 6, '0', STR_PAD_LEFT));
            $sheet->setCellValue('B' . $row, $order->user->name);
            $sheet->setCellValue('C' . $row, $order->user->email);
            $sheet->setCellValue('D' . $row, number_format($order->total_amount, 0, ',', '.') . ' ₫');
            $sheet->setCellValue('E' . $row, $methodLabel);
            $sheet->setCellValue('F' . $row, $statusLabel);
            $sheet->setCellValue('G' . $row, $order->delivered_at ? $order->delivered_at->format('d/m/Y H:i') : '—');

            $row++;
        }

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(18);

        return $spreadsheet;
    }
}
