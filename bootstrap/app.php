<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
| 我们首先要做的是创建一个新的Laravel应用程序实例

| 它是拉维的所有成分的“粘合剂”

| 用于绑定所有不同部分的系统的IoC容器。
*/

//实例化容器，设置基本目录（app、config等）、设置服务别名
$app = new Illuminate\Foundation\Application(
    realpath(__DIR__.'/../')
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.

  接下来，我们需要将一些重要的接口绑定到容器中，以便

| 我们将能够在需要时解决这些问题。核心是

| 来自web和CLI的对此应用程序的传入请求。
|
*/
//核心Kernel类的单例（执行bind方法，绑定容器）   别名，实际类
//在这里绑定了http的类,绑定到了ioc容器中
$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);
//console
$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);
//异常处理
$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.

  此脚本返回应用程序实例。实例被赋予

| 调用脚本以便我们可以分离实例的构建

| 从应用程序的实际运行和发送响应开始。
|
*/

return $app;
