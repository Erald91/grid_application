<?php

namespace app\models;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $requiredUser = self::findOne($id);
        if($requiredUser) {
            return $requiredUser;
        } else {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Will not use for this implementation
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $requiredUser = self::find()->where(['username' => $username])
                                    ->one();
        if($requiredUser) {
            return $requiredUser;
        } else {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        // Will not use for this implementation
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        // Will not use for this implementation
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {    
        $hashedPassword = $this->hashed_password;
        return hash_equals($hashedPassword, crypt($password, $hashedPassword));
    }

    /**
     * Check if logged user is admin
     *
     * @return bool if user is in administrator role
     */
    public function isAdmin() {
        return $this->is_admin;
    }
}
