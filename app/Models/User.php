<?php


namespace App\Models;


use Firebase\JWT\JWT;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = ['email', 'role'];

    protected $hidden = ['password'];

    public static function findByEmail($email)
    {
        return self::where('email', $email)->first();
    }

    public function jwt()
    {
        $payload = [
            'iss' => 'lumen-jwt',
            'sub' => $this->id,
            'iat' => time(),
            'exp' => time() + 60 * 60
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }
}
