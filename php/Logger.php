<?php
class Logger {
    private $log = [];
    private $logFile;
    
    public function __construct($filename  = 'log_') {
        
        $this->logFile = __DIR__ . '/../logs/' . $filename . date('Y-m-d_H-i-s') . '.log';
    }
    
    public function add($message) {
        $timestamp = date('Y-m-d H:i:s');
        $this->log[] = "[$timestamp] $message";
    }
    
    public function addError($message) {
        $this->add("ERROR: $message");
    }
    
    public function addSuccess($message) {
        $this->add("SUCCESS: $message");
    }
    
    public function save() {
        $logDir = dirname($this->logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        $content = implode("\n", $this->log);
        file_put_contents($this->logFile, $content);
        return $this->logFile;
    }
    
    public function getLog() {
        return $this->log;
    }
    
    public function getLogFile() {
        return $this->logFile;
    }
}
?> 