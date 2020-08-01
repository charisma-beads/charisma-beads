<?php

namespace Common\Model;


interface NestedSetInterface
{
    /**
     * @return int
     */
    public function getLft();

    /**
     * @param int $lft
     * @return $this
     */
    public function setLft(int $lft);

    /**
     * @return int
     */
    public function getRgt();

    /**
     * @param int $rgt
     * @return $this
     */
    public function setRgt(int $rgt);

    /**
     * @return int
     */
    public function getDepth(): int;

    /**
     * @param int $depth
     * @return $this
     */
    public function setDepth(int $depth);

    /**
     * @return int
     */
    public function width(): int;

    /**
     * @return bool
     */
    public function hasChildren(): bool;
}
