<?php

class Model_User extends Model {
    function __construct() {
        parent::__construct("users");
    }

    public function readAllWithGroups() {
        $q = "SELECT u.id as id, u.name as name,
                u.passwd as passwd, ug.name as g_name
                from {$this->table} as u
                join user_group as ug
                on u.group_id = ug.id
                order by u.id";
        return $this->raw_query($q);
    }


}