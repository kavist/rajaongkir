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
        $rowColumn = array_column($this->collection, $this->searchColumn);
        $s = preg_replace('/(\s|$)/', '.+?$1', preg_quote($searchQuery, '/'));
        $res = preg_grep('/^'.$s.'/i', $rowColumn);
        $resKey = array_keys($res);
        foreach ($this->collection as $key => $val) {
            if (in_array($key, $resKey)) {
                $result[] = $val;
            }
        }

        return $result;
    }
}
