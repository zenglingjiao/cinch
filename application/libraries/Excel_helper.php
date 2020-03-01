<?php

require_once dirname(__FILE__) . '/PHPExcel.php';

class Excel_helper extends PHPExcel {

    public function import_excel($filename, $field)
    {
        $objPHPExcel = new PHPExcel();

        // $objReader = PHPExcel_IOFactory::createReader('Excel5');
        // $PHPReader = new PHPExcel_Reader_Excel2007();
        // if (!$PHPReader->canRead($filename)) {
        //     $PHPReader = new PHPExcel_Reader_Excel5();
        //     if (!$PHPReader->canRead($filename)) {
        //         //return '沒有發現Excel格式數據';
        //         return 100;
        //     }
        // }

        $extension = strtolower( pathinfo($filename, PATHINFO_EXTENSION) );

        if ($extension =='xlsx') {
            $objReader = new PHPExcel_Reader_Excel2007();
            $objPHPExcel = $objReader ->load($filename);
        } else if ($extension =='xls') {
            $objReader = new PHPExcel_Reader_Excel5();
            $objPHPExcel = $objReader ->load($filename);
        } else if ($extension=='csv') {
            $PHPReader = new PHPExcel_Reader_CSV();

            //默认输入字符集
            $PHPReader->setInputEncoding('utf-8');

            //默认的分隔符
            $PHPReader->setDelimiter(',');

            //载入文件
            $objPHPExcel = $PHPReader->load($filename);
        }


        //$objPHPExcel = $objReader->load($filename, $encode = 'utf-8');


        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        $data = array();
        for ($i = 2; $i < $highestRow + 1; $i++) {
            // $data[$i]['goods_name'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
            // $data[$i]['brand'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
            // $data[$i]['specification'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
            // $data[$i]['store_count'] = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
            // $data[$i]['shop_price'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();
            foreach ($field as $k => $v) {
                $data[$i][$v] = $objPHPExcel->getActiveSheet()->getCell($k.$i)->getValue();
            }
        }
        return $data;

    }

}