<?php

namespace Kavist\RajaOngkir\SearchDrivers;

class BasicDriver extends AbstractDriver
{
    /**
     * @param string $searchQuery
     * @return array
     */
    public function search(string $searchQuery): array
    {
        $result = [];
        $q = trim(strtolower($searchQuery));
        $rowColumn = array_column($this->collection, $this->searchColumn);
        $data = array_map('strtolower', $rowColumn);
        $cari = preg_quote($q, '/');
        $res = preg_grep('/'.$cari.'/', $data);
        $resKey = array_keys($res);
        foreach ($this->collection as $key => $val) {
            if (in_array($key, $resKey)) {
                $result[] = $val;
            }
        }

        return $result;
    }
}
