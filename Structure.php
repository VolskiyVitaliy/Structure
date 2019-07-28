<?php

class Structure
{
    private $structure;

    public function __construct()
    {
        $this->structure = array();
    }

    public function getValue($variableName, $timestamp)
    {
        if (is_numeric($timestamp)) {
            if (key_exists($variableName, $this->structure)) {
                $keys = array_keys($this->structure[$variableName]);
                return $this->structure[$variableName][$this->BinarySearch($variableName, $timestamp, 0, count($keys) - 1)];
            } else {
                return null;
            }
        } else throw new InvalidArgumentException('Timestamp should be a number. Input was: ' . $timestamp);
    }

    public function setValue($variableName, $value, $timestamp)
    {
        if (is_numeric($timestamp)) {
            if (array_key_exists($variableName, $this->structure)) {
                $keys = array_keys($this->structure[$variableName]);
                if ($timestamp > $keys[count($keys) - 1]) {
                    $this->structure[$variableName] += [(string)$timestamp => $value];
                    return true;
                } else return false;
            } else {
                $this->structure[$variableName] = [(string)$timestamp => $value];
                return true;
            }
        } else throw new InvalidArgumentException('Timestamp should be a number. Input was: ' . $timestamp);
    }

    private function BinarySearch($variableName, $searchElem, $firstPos, $lastPos)
    {
        $keys = array_keys($this->structure[$variableName]);
        if ($searchElem < $keys[0]) {
            return null;
        } elseif ($searchElem > $keys[$lastPos]) {
            return $keys[$lastPos];
        }
        $middle = floor(($firstPos + $lastPos) / 2);
        if ($searchElem == $keys[$middle]) {
            return $keys[$middle];
        } elseif ($keys[$middle] > $searchElem) {
            return $this->BinarySearch($variableName, $searchElem, $firstPos, $middle - 1);
        } else {
            return $this->BinarySearch($variableName, $searchElem, $middle + 1, $lastPos);
        }
    }
}
