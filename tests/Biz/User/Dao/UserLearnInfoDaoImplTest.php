<?php

use Codeages\Biz\Framework\UnitTests\BaseTestCase;

class UserLearnInfoDaoImplTest extends BaseTestCase
{   
    public function testAddUser()
    {
    }
    
    /**
     * @dataProvider additionProvider
     */
    public function testFindEduExperiences($data)
    {   
        $this->getUserServiece()->createUser($data);
        $education = $this->getLearnInfoDao()->findEduExperiences(1);
        foreach ($data['education'] as $key => $value) {
            $data['education'][$key]['startTime'] = strtotime($value['startTime']);
            $data['education'][$key]['endTime'] = strtotime($value['endTime']);
        }
        $this->assertEquals($data['education'],$education);
    }

    protected function getUserServiece()
    {
        return self::$kernel['user_service'];
    }

    protected function getLearnInfoDao()
    {
        return self::$kernel['edu_experience_dao'];
    }

    public function additionProvider()
    {
        return [
            [array(
                "basic" => array(
                    "id" => 1,
                    "userId" => 1,
                    "departmentId" => 1,
                    "rank" => "p20",
                    "number" => "0010",
                    "trueName" => "陆昉宇",
                    "phone" => 13411231234,
                    "email" => "594@qq.com",
                    "gender" => "male",
                    "bornTime" => 1994,
                    "native" => "中国海宁",
                    "nation" => "汉族",
                    "height" => "177cm",
                    "weight" => "55kg",
                    "blood" => "AB",
                    "education" => "博士",
                    "prefession" => "计科",
                    "joinTime" => '2016-06-08',
                    "marriage" => 0,
                    "residence" => "海宁",
                    "address" => "没考虑",
                    "postcode" => 310000,
                    "Idcard" => 330481199412170055,
                    "professionTitle" => "PHP程序员",
                    "householdType" => "城市",
                    "recordPlace" => "杭州",
                    "formerLaborShip" => "已解除",
                    "politics" => "群众",
                ),
                "family" => array(
                    array(
                        "id" => 1,
                        "userId" => 1,
                        "member" => "爸爸",
                        "trueName" => "陆昉宇",
                        "age" => 30,
                        "job" => "那几款",
                        "phone" => 13511292312,
                    ),
                    array(
                        "id" => 2,
                        "userId" => 1,
                        "member" => "爸爸",
                        "trueName" => "陆昉宇",
                        "age" => 30,
                        "job" => "那几款",
                        "phone" => 13511292312,
                    )
                ),
                "work" => array(
                    array(
                        "id" => 1,
                        "userId" => 1,
                        "startTime" => '2016-06-08',
                        "endTime" => '2016-06-08',
                        "company" => "方法",
                        "position" => "发的",
                        "leaveReason" => "等等",
                    )
                ),
                "education" => array(
                    array(
                        "id" => 1,
                        "userId" => 1,
                        "startTime" => '2016-06-08',
                        "endTime" => '2016-06-08',
                        "schoolName" => "你",
                        "profession" => "方法",
                        "position" => "方法",
                    ),
                    array(
                        "id" => 2,
                        "userId" => 1,
                        "startTime" => '2016-06-08',
                        "endTime" => '2016-06-08',
                        "schoolName" => "你",
                        "profession" => "方法",
                        "position" => "方法",
                    )
                ),
                "other" => array(
                    "id" => 1,
                    "userId" => 1,
                    "reward" => "覅UN会不会就不喝酒",
                    "selfAssessment" => "和基本和金额为备份和文件",
                )
            )]
        ];
    }
}
