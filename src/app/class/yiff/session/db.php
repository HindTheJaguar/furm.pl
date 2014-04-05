<?php
/**
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 27.01.2013
 */
class yiff_session_db {
    protected $savePath;
    protected $sessionName;
    protected $db;
    protected $_ex = false;
    /**
     * czas zycia
     * @var int
     */
    protected $lt;
    public function __construct($db) {
    $this->db = $db;
        session_set_save_handler(
            array($this, "open"),
            array($this, "close"),
            array($this, "read"),
            array($this, "write"),
            array($this, "destroy"),
            array($this, "gc")
        );
    }

    public function open($savePath, $sessionName) {
        $this->savePath = $savePath;
        $this->sessionName = $sessionName;
        return true;
    }

    public function close() {
        // your code if any
        return true;
    }

    public function read($id) {
        $d = $this->db->row("SELECT * FROM sessions WHERE session_id = ".$this->db->escapeString($id)." LIMIT 1");
        if($d) {
            $this->_ex = true;
            $this->lt = $d['ttl'];
            return $d['storage'];
        } else {
            $this->lt = 3600;
        }
        
    }

    public function write($id, $data) {
        if (isset($_SESSION['_UserId'])) {
            $userid = $_SESSION['_UserId'];
        } else {
            $userid = 0;
        }
        
        if($this->_ex) {
                $this->db->update('sessions',array('user_id'=>$userid,'ttl'=>$this->lt,'storage'=>$data,'modified'=>time()),"session_id = ".$this->db->escapeString($id)."");
        }else{
                $this->db->insert('sessions',array('user_id'=>$userid,'ttl'=>$this->lt,'session_id'=>$id,'storage'=>$data,'modified'=>time()));
        }

        return true;
    }

    public function destroy($id) {
        $this->db->query("DELETE FROM sessions WHERE session_id = ".$this->db->escapeString($id)."");
        return true;
    }

    public function gc($maxlifetime) {
        $this->db->query("DELETE FROM sessions WHERE (modified - ttl) < ".time());
        return true;
    }

    public function setLifetime($time) {
        $this->lt = $time;
    }

    public function getLifetime(){
        return $this->lt;
    }
}
