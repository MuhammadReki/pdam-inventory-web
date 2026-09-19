<?php

namespace App\Exports;

use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Enumerable;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $jenis;

    public function __construct($startDate, $endDate, $jenis)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
        $this->jenis     = $jenis;
    }

    public function collection(): Enumerable
    {
        $data = collect();

        if ($this->jenis === 'semua' || $this->jenis === 'masuk') {
            $masuk = BarangMasuk::with('barang')
                ->whereBetween('tanggal_masuk', [$this->startDate, $this->endDate])
                ->get();

            foreach ($masuk as $item) {
                $data->push([
                    'tanggal'    => $item->tanggal_masuk,
                    'kode'       => $item->barang->kode_barang ?? '-',
                    'nama'       => $item->barang->nama_barang ?? '-',
                    'jenis'      => 'Masuk',
                    'jumlah'     => $item->jumlah,
                    'keterangan' => $item->keterangan ?? '-',
                ]);
            }
        }

        if ($this->jenis === 'semua' || $this->jenis === 'keluar') {
            $keluar = BarangKeluar::with('barang')
                ->whereBetween('tanggal_keluar', [$this->startDate, $this->endDate])
                ->get();

            foreach ($keluar as $item) {
                $data->push([
                    'tanggal'    => $item->tanggal_keluar,
                    'kode'       => $item->barang->kode_barang ?? '-',
                    'nama'       => $item->barang->nama_barang ?? '-',
                    'jenis'      => 'Keluar',
                    'jumlah'     => $item->jumlah,
                    'keterangan' => $item->keterangan ?? '-',
                ]);
            }
        }

        return $data->sortByDesc('tanggal')->values();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Kode Barang',
            'Nama Barang',
            'Jenis',
            'Jumlah',
            'Keterangan',
        ];
    }

    public function map($row): array
    {
        return [
            $row['tanggal'],
            $row['kode'],
            $row['nama'],
            $row['jenis'],
            $row['jumlah'],
            $row['keterangan'],
        ];
    }

    public function styles(Worksheet $sheet): ?array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '0D47A1']],
            ],
        ];
    }
}