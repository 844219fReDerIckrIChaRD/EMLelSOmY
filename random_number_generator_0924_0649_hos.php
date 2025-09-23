<?php
// 代码生成时间: 2025-09-24 06:49:04
use Phalcon\Mvc\Controller;

class RandomNumberController extends Controller
{
    public function indexAction()
    {
        // Check if the parameters are set
        $min = $this->request->getQuery('min', 'int', 0);
        $max = $this->request->getQuery('max', 'int', 100);

        // Validate parameters
        if ($min > $max) {
            $this->response->setJsonContent(['error' => 'Minimum value cannot be greater than maximum value.']);
            return $this->response;
        }

        // Generate random number
        $randomNumber = rand($min, $max);

        // Return the result as JSON
        $this->response->setJsonContent(['number' => $randomNumber]);
        return $this->response;
    }
}
