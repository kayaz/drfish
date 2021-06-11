<?php
class Model_InlineModel  extends Zend_Db_Table_Abstract
{
    protected $_name = 'inline';
    protected $_primary = 'id';

    /**
     * Get
     * @param int $id
     * @return Object
     */
    public function get(int $id)
    {
        return $this->fetchRow($this->select()
            ->from('inline')
            ->where('id_item = ?', $id));
    }

    /**
     * List
     * @param int $id
     * @return Object
     */
    public function getInlineList(int $id)
    {
        return $this->fetchAll($this->select()
            ->from('inline')
            ->where('id_place =?', $id));
    }

    /**
     * Store
     * @param array $data
     */
    public function save(array $data)
    {
        $this->insert($data);
    }

    /**
     * Update
     * @param int $id
     * @param array $data
     */
    public function updateInline(int $id, array $data)
    {
        $where = array(
            'id_item = ?' => $id
        );
        $this->update($data, $where);
    }
}