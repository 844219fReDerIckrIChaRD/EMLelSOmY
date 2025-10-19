<?php
// 代码生成时间: 2025-10-20 02:36:23
// ElectronicMedicalRecordSystem.php
// 电子病历系统

use Phalcon\Mvc\Model;

class ElectronicMedicalRecord extends Model
{
    // 电子病历ID
    protected $id;
    // 患者姓名
    protected $patient_name;
    // 患者ID
    protected $patient_id;
    // 病历内容
    protected $content;
    // 创建时间
    protected $created_at;
    // 更新时间
    protected $updated_at;

    // 源数据类型
    public function getSource() {
        return 'electronic_medical_records';
    }

    // 定义数据映射
    public function columnMap() {
        return array(
            'id' => 'id',
            'patient_name' => 'patient_name',
            'patient_id' => 'patient_id',
            'content' => 'content',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        );
    }

    // 创建电子病历
    public function createRecord($patientName, $patientId, $content) {
        try {
            $this->patient_name = $patientName;
            $this->patient_id = $patientId;
            $this->content = $content;
            $this->created_at = date('Y-m-d H:i:s');
            $this->updated_at = date('Y-m-d H:i:s');

            if (!$this->save()) {
                $messages = $this->getMessages();
                $error_message = '';
                foreach ($messages as $message) {
                    $error_message .= $message->getMessage();
                }
                throw new \Exception($error_message);
            }
        } catch (\Exception $e) {
            // 错误处理
            return array(
                'success' => false,
                'message' => $e->getMessage(),
            );
        }
        return array(
            'success' => true,
            'message' => '电子病历创建成功',
        );
    }

    // 更新电子病历
    public function updateRecord($id, $content) {
        try {
            $this->id = $id;
            $this->content = $content;
            $this->updated_at = date('Y-m-d H:i:s');

            if (!$this->save()) {
                $messages = $this->getMessages();
                $error_message = '';
                foreach ($messages as $message) {
                    $error_message .= $message->getMessage();
                }
                throw new \Exception($error_message);
            }
        } catch (\Exception $e) {
            // 错误处理
            return array(
                'success' => false,
                'message' => $e->getMessage(),
            );
        }
        return array(
            'success' => true,
            'message' => '电子病历更新成功',
        );
    }

    // 获取电子病历
    public function getRecord($id) {
        try {
            $record = self::findFirstById($id);
            if (!$record) {
                throw new \Exception('电子病历不存在');
            }
            return $record;
        } catch (\Exception $e) {
            // 错误处理
            return array(
                'success' => false,
                'message' => $e->getMessage(),
            );
        }
    }

    // 删除电子病历
    public function deleteRecord($id) {
        try {
            $record = self::findFirstById($id);
            if (!$record) {
                throw new \Exception('电子病历不存在');
            }

            if (!$record->delete()) {
                $messages = $record->getMessages();
                $error_message = '';
                foreach ($messages as $message) {
                    $error_message .= $message->getMessage();
                }
                throw new \Exception($error_message);
            }
        } catch (\Exception $e) {
            // 错误处理
            return array(
                'success' => false,
                'message' => $e->getMessage(),
            );
        }
        return array(
            'success' => true,
            'message' => '电子病历删除成功',
        );
    }
}
