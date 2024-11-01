<?php
namespace Helpers;

use Database\DataAccess\DAOFactory;
use Exceptions\AuthenticationFailureException;
use Models\User;

class Authenticate
{
    // 認証されたユーザーの状態をこのクラス変数に保持します
    private static ?User $authenticatedUser = null;
    private const USER_ID_SESSION_KEY = 'user_id';

    public static function loginAsUser(User $user): bool{
        if($user->getId() === null) throw new \Exception('Cannot login a user with no ID.');
        if(isset($_SESSION[self::USER_ID_SESSION_KEY])) throw new \Exception('User is already logged in. Logout before continuing.');

        $_SESSION[self::USER_ID_SESSION_KEY] = $user->getId();
        return true;
    }

    public static function logoutUser(): bool {
        if (isset($_SESSION[self::USER_ID_SESSION_KEY])) {
            unset($_SESSION[self::USER_ID_SESSION_KEY]);
            self::$authenticatedUser = null;
            return true;
        }
        else throw new \Exception('No user to logout.');
    }

    private static function retrieveAuthenticatedUser(): void{
        if(!isset($_SESSION[self::USER_ID_SESSION_KEY])) return;
        $userDao = DAOFactory::getUserDAO();
        self::$authenticatedUser = $userDao->getById($_SESSION[self::USER_ID_SESSION_KEY]);
    }

    public static function isLoggedIn(): bool{
        self::retrieveAuthenticatedUser();
        return self::$authenticatedUser !== null;
    }

    public static function getAuthenticatedUser(): ?User{
        self::retrieveAuthenticatedUser();
        return self::$authenticatedUser;
    }

    /**
     * @throws AuthenticationFailureException
     */
    public static function authenticate(string $email, string $password): User{
        $userDAO = DAOFactory::getUserDAO();
        self::$authenticatedUser = $userDAO->getByEmail($email);

        // ユーザーが見つからない場合はnullを返します
        if (self::$authenticatedUser === null) throw new AuthenticationFailureException("Could not retrieve user by specified email %s " . $email);

        // データベースからハッシュ化されたパスワードを取得します
        $hashedPassword = $userDAO->getHashedPasswordById(self::$authenticatedUser->getId());

        if (password_verify($password, $hashedPassword)){
            self::loginAsUser(self::$authenticatedUser);
            return self::$authenticatedUser;
        }
        else throw new AuthenticationFailureException("Invalid password.");
    }
}