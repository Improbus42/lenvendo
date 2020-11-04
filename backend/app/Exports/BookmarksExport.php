<?php

namespace App\Exports;


use App\Models\Bookmark;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class BookmarksExport implements FromCollection, ShouldAutoSize,WithHeadings, WithColumnFormatting,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Bookmark::all();
    }

    public function headings(): array
    {
        return [
            'Номер закладки',
            'URL страницы ',
            'Ссылка на favicon',
            'Заголовок',
            'META Description',
            'META Keywords',
            'Дата создания',
        ];
    }
    public function map($invoice): array
    {
        return [
            $invoice->id,
            $invoice->url,
            $invoice->favicon,
            $invoice->title,
            $invoice->metadesc,
            $invoice->meta_key,
            Date::dateTimeToExcel($invoice->created_at)
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => 'yyyy/m/dd h:mm:ss',
        ];
    }
}
