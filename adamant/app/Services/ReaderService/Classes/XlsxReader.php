<?php

namespace App\Services\ReaderService\Classes;

use App\Manufacturer;
use App\Services\ReaderService\Interfaces\ReaderInterface;
use App\Tire;
use App\TireModel;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\CellIterator;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Worksheet\RowIterator;

/**
 * Class XlsxReader
 * @package App\Services\ReaderService\Classes
 */
class XlsxReader implements ReaderInterface
{
    /**
     * Имя временного файла в который записывается число для progressbar
     *
     * @var string
     */
    private $progressFileName;

    /**
     * Кол-во обрабатываемых строк, необходимое для рассчета процента progressbar
     *
     * @var integer
     */
    private $countRows;

    /**
     * @var \PhpOffice\PhpSpreadsheet\Spreadsheet
     */
    private $spreadsheet;

    public function __construct(string $progressFileName, string $filePath)
    {
        $this->progressFileName = $progressFileName;
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $this->spreadsheet = $reader->load($filePath);
    }

    /**
     * Чтение и парсинг xlsx файла
     *
     * @param string $filePath
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function readFile(string $filePath): void
    {
        $this->countRows = $this->spreadsheet->getActiveSheet()->getHighestRow();
        $this->parseSheet($this->spreadsheet->getActiveSheet()->getRowIterator());
    }

    /**
     * Парсинг страницы
     *
     * @param RowIterator $rowIterator
     */
    protected function parseSheet(RowIterator $rowIterator): void
    {
        foreach ($rowIterator as $row) {
            Storage::disk('public')->put($this->progressFileName, (int)(($row->getRowIndex() / $this->countRows) * 100));

            if ($row->getRowIndex() < 5) {
                continue;
            }
            $this->parseRow($row->getCellIterator(), $row);
        }
    }

    /**
     * Парсинг строки
     *
     * @param CellIterator $cellIterator
     * @param Row $row
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function parseRow(CellIterator $cellIterator, Row $row): void
    {
        /**
         * передавать также row OK или можно сделать элегантнее??
         */
        foreach ($cellIterator as $cell) {

            if ($cell->getColumn() == "A") {
                continue;
            }

            if ($cell->getColumn() == "B") {

                if ($tire = Tire::where(['name' => $cell->getValue()])->first()) {
                    $tire->update(
                        [
                            'count' => $tire->count + (int) $this->spreadsheet->getActiveSheet()->getCell("C{$row->getRowIndex()}")->getValue(),
                            'price' => (int) $this->spreadsheet->getActiveSheet()->getCell("D{$row->getRowIndex()}")->getValue()
                        ]
                    );
                    break;
                }
                try {
                    $newTire = $this->parseName($cell->getValue());
                    preg_match("/\d+/", $this->spreadsheet->getActiveSheet()->getCell("C{$row->getRowIndex()}")->getValue(), $count);
                    $newTire->count = (int) $count[0];
                    $newTire->price = (int) $this->spreadsheet->getActiveSheet()->getCell("D{$row->getRowIndex()}")->getValue();
                    $newTire->save();
                    break;
                } catch (\Exception $exception) {
                    break;
                }
            }
        }
    }

    /**
     * Парсинг строки с наименованием
     *
     * @param string $cell
     * @return Tire
     */
    private function parseName(string $cell): Tire
    {
        $parseCell = explode(' ', $cell);
        $tire = new Tire();
        $widthAndProfile = explode('/', $parseCell[1]);

        //Парсинг ширины и профиля
        if (count($widthAndProfile) < 2) {
            $tire->manual_distribution = 1;
            $tire->width = $widthAndProfile[0];
        } else {
            $tire->width = $widthAndProfile[0];
            $tire->profile = $widthAndProfile[1];
        }

        //Парсинг диаметра
        if (preg_match("/^R[0-9]{2}/", $parseCell[2])) {
            $tire->diameter = str_replace("R", '', $parseCell[2]);
        } else {
            $tire->manual_distribution = 1;
        }

        //Парсинг индекса нагрузки и индекса скорости
        if (preg_match("/^[0-9]{2}[K,L,M,N,P,Q,R,S,T,U,H,V,VR,W,Y,ZR]/", $parseCell[3])) {
            preg_match("/\d+/", $parseCell[3], $load_index);
            preg_match("/\D+/", $parseCell[3], $speed_index);
            $tire->load_index = $load_index[0];
            $tire->speed_index = $speed_index[0];
        } else {
            $tire->manual_distribution = 1;
        }

        //Парсинг производителя
        if($manufacturer = Manufacturer::where(['name' => $parseCell[count($parseCell) - 1]])->first()) {
            $tire->manufacturer_id = $manufacturer->id;
        } else {
            $tire->manual_distribution = 1;
        }

        //Получение модели
        if($modelId = $this->getTireModel(array_slice($parseCell, 4, (count($parseCell) - 1) - (3 + 1)))) {
            $tire->tire_model_id = $modelId;
        } else {
            $tire->manual_distribution = 1;
        }

        return $tire;
    }

    /**
     * Получение модели из ячейки
     *
     * @param array $nameArr
     * @return int
     */
    protected function getTireModel(array $nameArr):int
    {
        $modelName = '';
        foreach ($nameArr as $word) {
            $modelName .= "$word ";
        }

        if($tireModel = TireModel::where(['name' => trim($modelName)])->first()) {
            return $tireModel->id;
        }

        return false;
    }
}
