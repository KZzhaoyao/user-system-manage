<?php

namespace AppBundle\Common;

class Import
{
    public function import($file)
    {
        $this->check($file);

        $datas = $this->getData($file);

        $datas = $this->sortDataForUser($datas);

        $datas = $this->validateData($datas);

        return $datas;
    }

    public function getData($file)
    {
        $datas = array();

        $PHPExcel = \PHPExcel_IOFactory::load($file);
        $worksheet = $PHPExcel->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
        for ($row = 2; $row <= $highestRow; $row++) {
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $infoData = $worksheet->getCellByColumnAndRow($col, $row)->getFormattedValue();
                $columnsData[$col] = $infoData . "";
            }

            $datas[] = $columnsData;
        }

        return $datas;
    }

    protected function sortDataForUser($datas)
    {
        $keys = $datas[0];
        $sort = array();
        foreach ($datas as $key => $data) {
            if ($key > 0) {
                $sort[$key]['basic'] = array_combine(array_slice($keys, 0, 26), array_slice($data, 0, 26));
                $sort[$key]['family'][1] = array_combine(array_slice($keys, 26, 5), array_slice($data, 26, 5));
                $sort[$key]['education'][1] = array_combine(array_slice($keys, 31, 5), array_slice($data, 31, 5));
                $sort[$key]['work'][1] = array_combine(array_slice($keys, 36, 5), array_slice($data, 36, 5));
                $sort[$key]['other'] = array_combine(array_slice($keys, 41, 2), array_slice($data, 41, 2));

                if ($sort[$key]['basic']['gender'] == '男' || $sort[$key]['basic']['gender'] == '男性') {
                    $sort[$key]['basic']['gender'] = 'male';
                } else {
                    $sort[$key]['basic']['gender'] = 'female';
                }

                if ($sort[$key]['basic']['marriage'] == '否' || $sort[$key]['basic']['marriage'] == '未婚') {
                    $sort[$key]['basic']['marriage'] = 0;
                } else {
                    $sort[$key]['basic']['marriage'] = 1;
                }

                switch ($sort[$key]['basic']['education']) {
                    case '博士':
                        $sort[$key]['basic']['education'] = 'doctor';
                        break;

                    case '硕士':
                        $sort[$key]['basic']['education'] = 'master';
                        break;
                        
                    case '本科':
                        $sort[$key]['basic']['education'] = 'regularCollege';
                        break;
                        
                    case '大专':
                        $sort[$key]['basic']['education'] = 'JuniorCollege';
                        break;
                        
                    case '高中':
                        $sort[$key]['basic']['education'] = 'seniorMiddle';
                        break;
                    
                    default:
                        $sort[$key]['basic']['education'] = 'juniorMiddle';
                        break;
                }

                switch ($sort[$key]['basic']['politics']) {
                    case '其他':
                        $sort[$key]['basic']['politics'] = 'other';
                        break;
                    
                    case '共产党员':
                        $sort[$key]['basic']['politics'] = 'partyMember';
                        break;
                    
                    case '预备党员':
                        $sort[$key]['basic']['politics'] = 'reservePartyMember';
                        break;
                    
                    case '团员':
                        $sort[$key]['basic']['politics'] = 'leagueMember';
                        break;
                    
                    default:
                        $sort[$key]['basic']['politics'] = 'masses';
                        break;
                }
                
            }
        }

        return $sort;
    }

    /**
     * @todo 添加数据的验证
     */
    protected function validateData($datas)
    {
        foreach ($datas as $key => $data) {
            if (empty($data['basic']['number'])) {
                unset($datas[$key]);
            } else {
                $data['basic']['number'] = strval($data['basic']['number']);
                $length = strlen($data['basic']['number']);
                for (; $length<4; $length++) {
                    $datas[$key]['basic']['number'] = '0'.$datas[$key]['basic']['number'];
                }
            }
        }
        return $datas;
    }

    /**
     * @todo  需要校验下仅是改变文件后缀所产生的xls文件
     */
    protected function check($file)
    {
        return true;
    }
}