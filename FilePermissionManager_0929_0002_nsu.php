<?php
// 代码生成时间: 2025-09-29 00:02:12
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Exception;
use Phalcon\DI;

// FilePermissionManager 类负责管理文件权限
class FilePermissionManager extends Model
{
    // 常量定义不同的权限级别
    const PERMISSION_READ = 1;
    const PERMISSION_WRITE = 2;
    const PERMISSION_EXECUTE = 4;

    // 检查文件是否存在
    protected function checkFileExists($filePath)
    {
        if (!file_exists($filePath)) {
            throw new Exception("File not found: {$filePath}");
        }
    }

    // 更改文件权限
    public function changePermission($filePath, $permission)
    {
        // 检查文件是否存在
        $this->checkFileExists($filePath);

        // 更改文件权限
        if (!chmod($filePath, $permission)) {
            throw new Exception("Failed to change permissions for file: {$filePath}");
        }

        return true;
    }

    // 设置文件只读权限
    public function setReadOnly($filePath)
    {
        return $this->changePermission($filePath, 0444);
    }

    // 设置文件读写权限
    public function setReadWrite($filePath)
    {
        return $this->changePermission($filePath, 0666);
    }

    // 设置文件读写执行权限
    public function setReadWriteExecute($filePath)
    {
        return $this->changePermission($filePath, 0777);
    }
}
