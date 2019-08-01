<?php
/**
 * @author Eric Shi <wwolf5566@outlook.com>
 * @copyright Copyright (c) 2019
 * @license Please see LICENSE
 */

namespace EsTools\modules;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

/**
 * Class EsExcel
 *
 * @package EsTools\modules
 */
class EsExcel extends EsModule
{

    /**
     * 解析EXCEL
     *
     * @param $file
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function getData($file)
    {
        $io_reader = IOFactory::createReaderForFile($file);
        $io_reader->setReadDataOnly(true);
        $sheet_obj = $io_reader->load($file);
        $active_sheet_obj = $sheet_obj->getActiveSheet();

        return $active_sheet_obj->toArray();
    }

    /**
     * 将数组写入EXCEL文件
     *
     * @param $list array 传入的数据
     * @param $sheetTitle string EXCEL工作表名称
     * @param $fieldsMap array 数组字段名与EXCEL表格标题的对应关系
     * @param $saveToFile boolean 是否保存到文件
     * @param $targetFile string 目标文件, $saveToFile为false时，$targetFile为文件名, 否则为完整磁盘路径
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     * @return bool
     */
    protected function setExcel($list, $sheetTitle, $fieldsMap, $saveToFile, $targetFile)
    {
        // 创建EXCEL对象
        $sheet_obj = new Spreadsheet();
        $sheet_active = $sheet_obj->getActiveSheet();
        $sheet_active->setTitle($sheetTitle);

        // 表头
        for ($i = 0; $i < count($fieldsMap); $i++) {
            $sheet_active->setCellValueByColumnAndRow($i + 1,
                1, $fieldsMap[$i]['label']);
        }

        // 内容
        if (isset($list[0]['id'])) {
            foreach ($list as $key => $value) {
                $tmp_row = $key + 2;
                for ($i = 0; $i < count($fieldsMap); $i++) {
                    $sheet_active->getCellByColumnAndRow($i + 1, $tmp_row)
                        ->setDataType(DataType::TYPE_STRING2)
                        ->setValue((string)$value[$fieldsMap[$i]['name']]);
                }
            }
        }

        // 文件处理
        $writer = IOFactory::createWriter($sheet_obj, 'Xlsx');

        if (false === $saveToFile) {
            ob_clean();
            ob_start();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $targetFile . '"');
            header('Cache-Control: max-age=0');

            // 重设管道
            $targetFile = 'php://output';

            // 输出文件
            $writer->save($targetFile);
            exit;
        }

        // 写入文件
        $writer->save($targetFile);

        return (file_exists($targetFile) && is_file($targetFile)) ? true : false;
    }
}