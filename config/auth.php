<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
      此选项控制默认的身份验证“guard”和密码
    | 重置应用程序的选项。您可以更改这些默认值
    | 但对于大多数应用程序来说，这是一个完美的开始。
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
      接下来，可以为应用程序定义每个身份验证保护。
    |当然，已经为您定义了一个很好的默认配置
    |这里使用会话存储和雄辩的用户提供程序。
    |
    |所有身份验证驱动程序都有一个用户提供程序。这定义了
    |用户实际上是从数据库或其他存储中检索出来的
    |此应用程序用于保存用户数据的机制。
    |
    |支持：“会话”，“令牌”
    |
    */
    //身份验证的方式，web默认是使用session   api默认是使用token
    //指定看守器，默认是使用web 即通过session的方式来进行看守，就是判断的标准吧应该是
    //providers 应该就是提供者
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
     所有身份验证驱动程序都有一个用户提供程序。这定义了
    |用户实际上是从数据库或其他存储中检索出来的
    |此应用程序用于保存用户数据的机制。
    |如果有多个用户表或模型，则可以配置多个
    |表示每个模型/表的源。这些消息来源可能
    |分配给您定义的任何额外的身份验证保护。
    |支持：“数据库”，“雄辩”
    |
    */

    'providers' => [
        'users' => [
            //'driver' => 'eloquent',      //ORM的一个东西，操作数据库，校验登录
            //'model' => App\AdminAccount::class,
            'driver' => 'database',
            'table' => 'admin_accounts',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
        如果您有更多的密码重置配置，可以指定多个密码重置配置
    |在应用程序中有多个用户表或模型
    |根据特定的用户类型单独设置密码重置。
    |expire time是重置令牌应为的分钟数
    |被认为是有效的。此安全功能使令牌保持短生命，因此
    |他们没那么多时间被猜测。你可以根据需要改变这个。
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,    //令牌有效时间
        ],
    ],

];
