<?php
$alipay = array(
    //应用ID,您的APPID。
    'app_id' => "2016093000628163",

    //商户私钥，您的原始格式RSA私钥
    'merchant_private_key' => "MIIEpQIBAAKCAQEApnBPqVrLumatZf7EFr2hs3JA6qI4cePuQKhz1d4LlcPQ6orbx3XQpAsUlMoLq6wWY52lmDo0WihD5C7rbg0HQpOIgTgKs/gzWkz0K1GTLdzsL4ws/q2n11g8XnRygOGKViUHssPIK/7nEBGR1UWVaeeyCzlltyi5hGaH+I7ehH5yWfXiS+zZu3lKaxaxikpvWs7WQ/du5l9ZRaWG4tTxIn/VSDEvXojpNrV2obXOQzfXvABS6q1lDB6Ca5SDporfjIh5ULYgoo/ynUcqhQYI2N7wZlUqB0ocnw1uT1Um1PnQvChTNIurghTCRHe773Ex5DFYLq/piAQfeNVxWyzdAwIDAQABAoIBAQCVm9MfqkwDDBTF4BInVuIpSYRs5NDUH0yktkcZcXT8dH4wtg0E6DRZoNQpQszmzdN6S9T0Vy2D9TnBvSNHU1K5V6CWdue4Cl0uyIma/sLLsRBlVR2E+FgszFXHmejrTNFqyfJ3kGE4mvLckM6D5P5/qhNy3289CtBn4TpMBTCj6wpblJiecq/Y7Tmalep5xMvsjbprFKtcRVBdCD/sjg267RVajaTVhlXvKqUCJWrha5dfAYTMq5HTFQk1slfcGKmcpq1H+jd14Cmwc8bgKpiIkmW+AZCj61Na0WvIOPEUcSvHddF5V7LBs7AH16F26prWyaSz47zgOdCAbE3Hgx7hAoGBANUEIHqUb6tgIsLq/O1Sc8g2ewWCqlghBsFifuM4lCv3KBHPiPmpKtLG8WUu2sZt7quQ+Y0RM9n5hzEtuhqtP768L9aFLEgylAmjb6iosZO+agg4aXCUbmJMlBrwGCpJkwcuMvhqjsNms1YfC3cTElXMaLywSKqfMLiVy/8asHhLAoGBAMgGHRJ1wqGhUuKnnynYkYY0eipkkdocWdnMz9PEeXqsLZEC+3T+LXH5hyjH+b/mo+EgHXdrSSyoMrTbc/xkdnJORanMH3nb8Hlr4ba0G/Yg0ImDR8L8NLP6GSMlXnEqgrqIiW6BHZgLxyMSidJ5Jrcqof6X1zGufL9K/3Ea/yspAoGBAKLZx9bO2lyDX6/ypLDuwzOCayS4U3CSty5rFaSy4ZyHFKwhJI/xw5pmm7AGVR00eC3T5OTzDNgNC00Or2Orpbs09cGkCEmd2U1RFJE1fqT8AuYL8pgt8gHWl7fMbD0QCIaJzE/cbw512o7xpvs+qlrLrhrrDnLaxw2m/9Ek31rnAoGAbPP3jgCbHdN0BIXtiquuyP14tfLGB5p9zsdjRSS2Tv3ObDjFo7p4Iqca2jnjboZBKfWGV3AXEb4ksKMBEK/gXO8Jvy2yz3vgByOedRiySmUhcmYSBsG+K3LFkoFeaiIPx29r/MdTyWhQ9me4ru7TCd6tErK+ww8aYFCHx6I+79ECgYEAwotD86YKrzfYOCPJ4SKg9xBxcLFiWFUmNGNxCUSjp4mTM0rZS0+yRRIx/aBG+5gU0HF3wvI5dxj35QsFOK4gEfkWvIlKPYA0hIWtXygNVP38AmRjl19hSnIF3+yl+IAELvZj6B8IKnEqR7DhvlDmsv7fsLvguIM6hX0p+7VqXts=",

    //异步通知地址
    'notify_url' => "http://to-group.top/vending/web/index.php?r=buy%2Frefund",

    //同步跳转
    'return_url' => "http://to-group.top/vending/web/index.php?r=buy%2Fsuccess",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type' => "RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAopT9A/Xqj7suZ4RnovQv/dsY6IOiUCMjg+MPsJ72W+W2a1qE/jWvzB0bCGMr4lwExUNgRr2qweKR+L/sNCfhIZjhZJHn1jqN98l61XMz4mRxc1/6uxu+2k6B/wVRVvb7tCh9PEZAdDqF7HbdJj9dzePd3uwRte9IkYzDSjNNeEK3a77mo0o3tlRRQmFVm1rYQHaRye2HuqWtb/HkuDq/m07BbwE8H+qxY12KtW3Swovz+TNGI5kstGLY96z5+0fpTNl96iwQ4DFhRJvIfKe2maeo7iKlfVX0gvG7GlccF3W+ewYQ2PoLjA4wP324Qn3svG5MX+0C8PASNoNXVOZ4fwIDAQAB",


);


return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'alipay' => $alipay,
];
