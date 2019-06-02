<?php
$alipay = array(
    //应用ID,您的APPID。
    'app_id' => "2016093000628163",

    //商户私钥，您的原始格式RSA私钥
    'merchant_private_key' => "-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAq+pDnmYPhde30YA4rq6zXq5YQGgEcJjnyAasS89Cd6DdXvDJ
fp1WIIczNVXqE8oQaoNJuTrgnbN/tzPk0BiL4dsqB2efb3fBCRdSsLYFYdpbtIg9
eXAk4e8SIYQMhEGaNeH8gNuRgYDAhP5g8bi1l5+c1NhE/yJFWoTzX3bmdUlYqE+I
Bq3vdMHhlCjT2BNfILY4N9IbrMR9+9gsX49rLsca8cdiFOitlz6T07bf8HO4TPsL
Tegph2C4Q5IAfyICK/3r1nnskgK+1Li7+n9ip/BcjU+dXGyEdo3sgHJ55xOgA8WF
yjybcRyxexNcPPceuOyAa8ngWzpdulu8zFlMBwIDAQABAoIBAQCLgCE2m6Lk/NMQ
kXdtaB3tKpQ6Ty2rIKiUS7XsHlbVNBfuPn2C3LFS2+LV2M2FGWaQx9A/GmPCFDIC
u31kz0ZTE8DbGV7q2MYvVlmnQ0zCxqm7qQIZVMLZA2I3CCwP9hvotWRsO7+q0otm
X/TSsQvJ6Z8dqBD05x5YAaJrSNRhPrpzBUEgcX10N4F6sESkqGcCoq5FWBas5+tI
iYCGa+gtopb8UZY+UQT9LniSQL8I2Sv//SJOYd3WdeUVU37dJx+F7VC9hS2uGE8v
av9GEnWOrw7BxCyo+08kyMbxiIEwBebIqhXYLDcHEsT3AIJpjdj1S6fW9qanD5kK
BdpL65ghAoGBANwR8KoenOKZi8HDSXVoAsdkk8ex7E6wyTg3IFOE23WxWE0kgDbT
PQa6Gl/eu8kzFsYSSVmkisYfaOclIGHmSllUjl0DqGsQ2BMPNCQ+CvnEL7mMym2D
YpTGf+ybSAj2o7ZXUJCI4O4hnXXFQIqxjV+0KY9PiXQ0BjXQUh4PhwpzAoGBAMf7
osyMnDzyrdiPff9tZw0GH+6WdxUSUxN4ou4/VFMGa9/FuiZO8OW9wf3//RDg3nQj
vHw2BjzMLJkW7nN7LfpiCCTPIaGbUzxhb/UPzYZ6yd9TOigGSf+NvfTU2/F3WDcW
TKT89AKOtCWTys0u1QF0Jpoj+vXqwBWJa2Wx1i8dAoGBAIJRmVuUX0EMvicS1vhQ
jHy5AY4avZ3nsHC6rEjo/vCWAX1FJSvSMWw/XojxI/DEcTL/9zG/b3JdfUiLwr5W
miaGHPvVw7ELO3kl4rGnj+ZSGBTf26u4RvNlDLH3TlQIge/jitDcTZ6Wh2ELWuoG
tHo8/PNhnTsT562MXGRyu3wjAoGAFESKgVSW2Q53VAVm7aY21XkTb2jMdNRAmy6U
xLSiZS+3axxs+0jw3TfYG1gAW9+ObBLbHXOUOkEvG+zZCdcoF8IrtR9Q90H4s5vk
bt/FIqX7I6kZscjBYycIY3HXQKepxxt5dRc127R+yXgrC5R9fgI5j1GqM5YxFX2x
5sKZRHkCgYBZNA8HPtSvI0qeB8/4RryIZ07zPcidOSXQvepgFclAT8nQijORR4y9
lkDYAlncYyyoltGwtfFhv0ees5f+MD+FgZmUJx9KUuLGlrXKuINwXSNjOkYo6AS/
qeALCckShxZUiRYDf89kCCWGp2H3oGApbrWdMIcw0W1CIvOmdfY7ww==
-----END RSA PRIVATE KEY-----",

    //异步通知地址
    'notify_url' => "http://to-group.top/vending/web/index.php?r=buy%2Fsuccess",

    //同步跳转
    'return_url' => "http://to-group.top/vending/web/index.php?r=buy%2Fsuccess",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type' => "RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgk9bxpWBz8airYXYJsjosRpMo6lTU8jcEwGQQ79SLh5tonOXco31ov1eV3iJ5GMObD/jSInIOAl5qMgdGXOfqMKEj4S8/vlvwg+UCqJcLwT6ko7a9fAWpu163Y2KNpayxzADL70WwCrXKS/eWa/b27wmeZFCWfMm2IrRuYyNM8WnaB5Uw2pv+u8fVfT9vRN9McRdi/ilebI7ni6V8F6Teu+qM7QxNCvZPK0AJOuyPbyQqagroW3FntjEwUDUOaSt8PGYMVBrBNV1Oczl+LQ6wwy2iHuWmVuZKPfJMEfg7wy0NJtomvf3jNXM1qwRRZzC8e73mGiHBQcfbXNzss8wGwIDAQAB",


);

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'alipay' => $alipay,
];
