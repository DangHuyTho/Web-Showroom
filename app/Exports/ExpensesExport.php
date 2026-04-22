<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExpensesExport
{
    protected $expenses;
    protected $totalExpenses;
    protected $period;
    protected $periodLabel;

    public function __construct($expenses, $totalExpenses, $period, $periodLabel)
    {
        $this->expenses = $expenses;
        $this->totalExpenses = $totalExpenses;
        $this->period = $period;
        $this->periodLabel = $periodLabel;
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Chi Phí');

        $row = 1;

        // Title
        $sheet->setCellValue('A' . $row, 'BÁO CÁO CHI PHÍ VẬN HÀNH');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true)->setSize(14);
        $row++;

        $sheet->setCellValue('A' . $row, 'Kỳ: ' . $this->periodLabel);
        $row++;

        $sheet->setCellValue('A' . $row, 'Ngày xuất: ' . now()->format('d/m/Y H:i:s'));
        $row += 2; // blank row

        // Summary
        $sheet->setCellValue('A' . $row, 'TỔNG CHI PHÍ');
        $sheet->setCellValue('B' . $row, number_format($this->totalExpenses, 0, ',', '.') . ' ₫');
        $row += 2; // blank row

        // Headers
        $headers = ['Danh Mục Chi Phí', 'Số Tiền', 'Ghi Chú'];
        $cols = ['A', 'B', 'C'];
        foreach ($headers as $index => $header) {
            $sheet->setCellValue($cols[$index] . $row, $header);
        }
        $headerRow = $row;
        $row++;

        // Data
        foreach ($this->expenses as $expense) {
            $sheet->setCellValue('A' . $row, $expense['category'] ?? 'N/A');
            $sheet->setCellValue('B' . $row, number_format($expense['amount'] ?? 0, 0, ',', '.') . ' ₫');
            $sheet->setCellValue('C' . $row, $expense['description'] ?? '');
            $row++;
        }

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(30);

        return $spreadsheet;
    }
}
