<?php

namespace codexten\yii\user\models\query;

/**
 * This is the ActiveQuery class for [[\codexten\yii\models\User]].
 *
 * @see \codexten\yii\models\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \codexten\yii\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \codexten\yii\models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function notId($id)
    {
        $this->andWhere(['!=', 'id', $id]);

        return $this;
    }

    /**
     * @return $this
     */
    public function byRole()
    {
        $this->joinWith('authAssignment as authAssignment');

        return $this;
    }
}
