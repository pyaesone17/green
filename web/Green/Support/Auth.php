<?php 
namespace Green\Support;
use Green\Models\User;
use Green\Support\PasswordHasher;
use Lcobucci\JWT\Builder;

class Auth
{
    public static function attempt($email, $plainPassword)
    {
        $user = User::whereEmail($email)->first();
        if ($user == null) {
            return false;
        }

        return PasswordHasher::verify($plainPassword,$user->password);
    }

    public static function createToken($email)
    {
        $token = (new Builder())->setIssuer('Hellofresh') // Configures the issuer (iss claim)
                                ->setAudience('Hellofresh') // Configures the audience (aud claim)
                                ->setId('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
                                ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
                                ->setNotBefore(time()) // Configures the time that the token can be used (nbf claim)
                                ->setExpiration(time() + 3600) // Configures the expiration time of the token (exp claim)
                                ->set('user_email', $email) // Configures a new claim, called "uid"
                                ->getToken(); // Retrieves the generated token
        
        return $token;
    }
}
