<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromCollection, WithColumnWidths, WithStyles, WithEvents
{
    public mixed $categorySlug;
    public array $result = [];

    public function __construct($categorySlug = null)
    {
        $this->categorySlug = $categorySlug;
    }

    public function collection(): Collection
    {
        $headers[] = [
            'name' => 'Наименование',
            'price' => 'Цена',
            'brand' => 'Марка',
            'description' => 'Описание',
            'image_link' => 'Ссылки на фото',
        ];


        Product
            ::isActive()
            ->orderBy('name')
            ->chunk(1000, function($products) {
                foreach ($products as $product) {

                    $imageUrl = $product->getMedia('image')->first()?->getUrl();

                    $this->result[] = [
                        'name' => $product->name,
                        'price' => $product->price,
                        'brand' => $product->brand,
                        'description' => $product->description,
                        'image_link' => config('app.client_url').$imageUrl,
                    ];
                }
            });

        return collect($headers)->merge(collect($this->result));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setAutoFilter('B1:D1');
            },
        ];
    }

    public function columnWidths(): array
    {
        return ['A' => 6, 'B' => 65, 'C' => 12, 'D' => 10, 'E' => 6, 'F' => 10];
    }
    public function styles(Worksheet $sheet): array
    {
        return [
            'A1' => ['font' => ['bold' => true, 'size' => 12]],
            'A2:A5000' => ['font' => ['bold' => true, 'size' => 8]],
            'B1' => ['font' => ['bold' => true, 'size' => 12]],
            'C1' => ['font' => ['bold' => true, 'size' => 12]],
            'D1' => ['font' => ['bold' => true, 'size' => 12]],
            'E1' => ['font' => ['bold' => true, 'size' => 12]],
            'F1' => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
