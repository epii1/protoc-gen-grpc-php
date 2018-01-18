<?php
require __DIR__.'/vendor/autoload.php';

use \Lv\Grpc\Context;
use Helloworld\HelloRequest;
use Helloworld\HelloReply;

class GreeterService implements Helloworld\Greeter
{
    use Helloworld\GreeterServiceTrait;

    public function SayHello(Context $context, HelloRequest $request) : HelloReply
    {
        $a = $context->getMetadata('a');
        $context->setMetadata('b', $a + 1);

        $name = $request->getName() ?? 'world';

        $reply = new HelloReply;
        $reply->setMessage('Hello '.$name);
        return $reply;
    }
}

$s = new Lv\Grpc\SwooleServer('127.0.0.1', 8080);
$s->addService(new GreeterService);

$s->run();
