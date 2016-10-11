<?php

require('../vendor/autoload.php');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$bot = new CU\LineBot();

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => 'php://stderr',
));

$app->before(function (Request $request) use($bot) {
    // Signature validation
    $request_body = $request->getContent();
    $signature = $request->headers->get('X-LINE-CHANNELSIGNATURE');
    if (!$bot->isValid($signature, $request_body)) {
        return new Response('Signature validation failed.', 400);
    }
});

$app->post('/callback', function (Request $request) use ($app, $bot) {
    // Let's hack from here!
    $body = json_decode($request->getContent(), true);

    foreach ($body['result'] as $obj) {
        $app['monolog']->addInfo(sprintf('obj: %s', json_encode($obj)));
        $from = $obj['content']['from'];
        $content = $obj['content'];

        //if ($content['text']) {
        $message;
        while (true)
        {
          $input = array(
            ["ウヒョ", 100],
            ["ウヒョヒョー", 50],
            ["せやねん",  100],
            ["たしかーにバーガー", 50],
            ["たしかーに", 100],
            ["せやのう", 100],
            ["せやね", 100],
            ["そ！", 100],
            ["ういー", 100],
            ["ええやん", 100],
            ["それな", 100],
            ["よいショー", 100],
            ["それな", 100],
            ["おけ", 100],
            ["なるみ", 100],
            ["うすうす", 100],
            ["りょ", 100],
            ["あざす", 100],
            ["( ˘ω˘)ｽﾔｧ…", 50],
            ["すやまる", 100],
            ["すやまる課長", 70],
            ["すやまる大戦争", 30],
            ["おはまる", 100],
            ["おはまる社長", 70],
            ["おはまる幹事長", 30],
            ["もっちり!", 100],
            ["もっちりハンドトス", 50],
            ["たそがーれバーガー", 30],
            ["わっしょい", 100],
            ["わっしょいわっしょいわっしょい", 40],
            ["めっちゃええ", 100],
            ["めっちゃええやん", 100],
            ["おへそがもげるー", 60],
            ["実はアイマスクー", 60],
            ["ときどきさらわれるー", 60],
            ["君の名は、観た？", 50],
            ["どうだった？", 100],
            ["まじのすけ", 100],
            ["まじのすけすか", 100],
            ["三代目まじのすけブラザーズ", 30],
            ["まじすか学園", 60],
            ["CP4000のコイキングいたわ", 40],
            ["I think so too.", 60],
            ["うん、よかったね！本当によかったね！", 100]);
          $rate = $input[1];
          $rnd  = rand (1, 100);
          if ($rate >= $rnd)
          {
            $rand_key = array_rand($input, 1);
            $message  = $input[$rand_key];
            break;
          }
        }
        $bot->sendText($from, $message);
      }
    //}

    return 0;
});

$app->run();
