<?php


namespace app\extensions\dektrium_user\models;


use dektrium\user\models\User as UserParent;

class User extends UserParent
{
    /**
     * Creates new user account. If Module::enableGeneratingPassword is set true, this method
     * will generate password.
     *
     * @return bool
     */
    public function create()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $transaction = $this->getDb()->beginTransaction();

        try {
            $this->password = ($this->password == null && $this->module->enableGeneratingPassword) ? Password::generate(8) : $this->password;

            $this->trigger(self::BEFORE_CREATE);

            if (!$this->save()) {
                $transaction->rollBack();
                return false;
            }

            $this->confirm();

//            $this->mailer->sendWelcomeMessage($this, null, true);
            $this->trigger(self::AFTER_CREATE);

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            \Yii::warning($e->getMessage());
            throw $e;
        }
    }
}