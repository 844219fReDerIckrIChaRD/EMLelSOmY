<?php
// 代码生成时间: 2025-10-02 20:42:57
use Phalcon\DI\FactoryDefault;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\DiInterface;
use Phalcon\Mvc\Model;

class BluetoothCommunicationService extends Model
{
    protected $di;
    protected $logger;
    protected $bluetoothSocket;

    public function __construct(DiInterface $di)
    {
        // Injecting Phalcon's Dependency Injector
        $this->di = $di;

        // Setting up the logger
        $this->logger = new Logger\Adapter\Stream("/var/log/bluetooth.log");
    }

    /**
     * Establishes a connection with a Bluetooth device.
     *
     * @param string $deviceAddress
     * @return bool
     */
    public function connect($deviceAddress)
    {
        // Attempt to create a Bluetooth socket
        $this->bluetoothSocket = socket_create(AF_BLUETOOTH, SOCK_STREAM, BTPROTO_RFCOMM);
        if (!$this->bluetoothSocket) {
            $this->logger->error("Failed to create Bluetooth socket.");
            return false;
        }

        // Connect to the Bluetooth device
        if (!socket_connect($this->bluetoothSocket, $deviceAddress)) {
            $this->logger->error("Failed to connect to Bluetooth device: " . $deviceAddress);
            return false;
        }

        $this->logger->info("Connected to Bluetooth device: " . $deviceAddress);
        return true;
    }

    /**
     * Sends a message to the Bluetooth device.
     *
     * @param string $message
     * @return bool
     */
    public function sendMessage($message)
    {
        if (!socket_write($this->bluetoothSocket, $message)) {
            $this->logger->error("Failed to write message to Bluetooth device.");
            return false;
        }

        $this->logger->info("Message sent to Bluetooth device: " . $message);
        return true;
    }

    /**
     * Receives a message from the Bluetooth device.
     *
     * @return string|null
     */
    public function receiveMessage()
    {
        $response = socket_read($this->bluetoothSocket, 1024);
        if ($response === false) {
            $this->logger->error("Failed to read message from Bluetooth device.");
            return null;
        }

        $this->logger->info("Message received from Bluetooth device: " . $response);
        return $response;
    }

    /**
     * Closes the Bluetooth connection.
     */
    public function disconnect()
    {
        if ($this->bluetoothSocket) {
            socket_close($this->bluetoothSocket);
            $this->logger->info("Bluetooth connection closed.");
        }
    }
}
