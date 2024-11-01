<?php

use Database\DataAccess\Implementations\EmailDAOImpl;
use Database\DataAccess\Implementations\PostDAOImpl;
use Helpers\DatabaseHelper;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;
use Response\Render\MediaRenderer;
use Database\DataAccess\DAOFactory;
use Types\ValueType;
use Models\ComputerPart;
use Models\Post;
use Helpers\Authenticate;
use Response\FlashData;
use Response\Render\RedirectRenderer;
use Models\User;
use Routing\Route;

return [

    '' => Route::create('component/register-form', function (): HTTPRenderer {

        return new HTMLRenderer('component/register-form');
    }),
    'random/part' => Route::create('random/part', function (): HTTPRenderer {
        $partDao = DAOFactory::getComputerPartDAO();
        $part = $partDao->getRandom();

        if ($part === null) throw new Exception('No parts are available!');

        return new HTMLRenderer('component/computer-part-card', ['part' => $part]);
    }),
    // メール登録
    'register/email' => Route::create('register/emali', function (): HTTPRenderer {

        if (!isset($_POST['email'])) return new JSONRenderer(['status' => 'error', 'message' => 'email not found.']);

        // signatureはurlから正しいか確認する
        $email = ValidationHelper::string($_POST['email'] ?? null);
        $emailDAO = new EmailDAOImpl;
        // 存在するか確認
        if ($emailDAO->emailExists($email)) return new JSONRenderer(['status' => 'error', 'message' => 'This Email already exists.']);
        // データベースにid, user(email), email_verifiedを追加

        $result = $emailDAO->create($email);
        // 失敗の場合はerrorを返す。
        if (!$result) return new JSONRenderer(['status' => 'error', 'message' => 'Failed to register email']);

        // id, email, expirationをカプセル化する
        // idは検索する
        $data = [];
        $data['id'] = $emailDAO->getIdByEmail($email);
        $data['email'] = $emailDAO->getHasehdEmail($email);
        $data['expiration'] = time() + 3600;

        $route = new Route('', function() {});
        $signedUrl = $route->getSignedURL($data);
        // 署名付き検証URLを作成し、ユーザのメールアドレスに送信する
        $to      = $email;
        $subject = 'Hello World';
        $message = <<<MAIL
            Click the link below to verify your email
            $signedUrl
        MAIL;

        $headers = 'From: TestApp <yoshiya1m@gmail.com>' . "\r\n" .
            "Reply-To: $email" . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        return new JSONRenderer(['status' => 'success', 'message' => 'Email sent to your account.']);
        // return new JSONRenderer(['url' => Route::create('test/share/files/jpg', function () {})->getSignedURL($validatedData)]);
    }),
    // メール検証
    'verify/email' => Route::create('verify/email', function (): HTTPRenderer {

        // return new JSONRenderer(['status' => 'success', 'message' => 'verified your email']);
        // ユーザーの詳細が URL パラメータと一致していることを確認
        // データベースの email_verified 列を更新
        $email = $_GET['email'];
        $emailDAO = new EmailDAOImpl;
        $result = $emailDAO->verifyEmail($email);
        if (!$result) return new JSONRenderer(['status' => 'error', 'message' => 'Failed to verify your email']);
        return new JSONRenderer(['status' => 'success', 'message' => 'Successfully verified your account']);
    })->setMiddleware(['signature']),
];