<?php

namespace App\Traits;

/**
 * Trait untuk memulihkan data yang di-soft delete (set kolom deleted_at = NULL).
 * Tambahkan `use SoftRestoreTrait;` di model yang memakai soft delete.
 */
trait SoftRestoreTrait
{
    /**
     * Pulihkan satu ID atau daftar ID.
     *
     * @param int|array $id Primary key value(s)
     * @return bool True jika berhasil.
     */
    public function restore($id): bool
    {
        if (empty($id)) {
            return false;
        }

        $builder = $this->builder()->set('deleted_at', null);

        if (is_array($id)) {
            $builder->whereIn($this->primaryKey, $id);
        } else {
            $builder->where($this->primaryKey, $id);
        }

        return $builder->update();
    }
}
