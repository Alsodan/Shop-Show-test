<?php

use yii\db\ActiveRecord;
use yii\db\Exception;

class ActiveRecordSoftDelete extends ActiveRecord
{
    protected $softDeleteAttribute = 'isDeleted';

    public function delete()
    {
        if (!$this->hasAttribute($this->softDeleteAttribute)) {
            throw new Exception(get_class($this) . ' does not have a soft-delete attribute. You should add boolean attribute to your database scheme.');
        }

        // Запрет повторного вызова удаления помеченной на удаление записи
        $isDeleted = $this->getAttribute($this->softDeleteAttribute);
        if ($isDeleted) {
            return 0;
        }

        // Запись помечается на удаление
        $this->setAttribute($this->softDeleteAttribute, true);

        return $this->commit();
    }

    // метод восстановления помеченной на удаление записи
    public function restore()
    {
        if (!$this->hasAttribute($this->softDeleteAttribute)) {
            throw new Exception(get_class($this) . ' does not have a soft-delete attribute. You should add boolean attribute to your database scheme.');
        }

        $this->setAttribute($this->softDeleteAttribute, false);

        return $this->commit();
    }

    // сохранение изменений в БД
    private function commit(): int
    {
        if (!$this->isTransactional(self::OP_UPDATE)) {
            return $this->save() ? 1 : 0;
        }

        $transaction = static::getDb()->beginTransaction();
        try {
            $result = $this->save();
            if ($result === false) {
                $transaction->rollBack();
            } else {
                $transaction->commit();
            }

            return $result ? 1 : 0;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}